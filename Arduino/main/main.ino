
//Bibliotecas para conexão ethernet
#include <SPI.h>
#include <Ethernet.h>


//Variáveis de conexão ethernet
IPAddress ip(192, 168, 0, 108); //IP address for your arduino.
EthernetClient client;
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "10.104.205.27"; //IP address of your computer.
char output[256];

//Biblioteca para conversão de Arduino para JSON
#include <ArduinoJson.h>

//Bibliotecas do sensor de temperatura
#include <OneWire.h>
#include <DallasTemperature.h>

//Váriaveis do sensor de temperatura
OneWire ourWire(7);
DallasTemperature sensors(&ourWire);
int temperatura_ativacao = 30;
float temperatura_total = 0;
float temperatura_media = 0;
int quantidade_temperatura = 0;

//Bibliotecas do sensor de digital
#include <Adafruit_Fingerprint.h>
SoftwareSerial mySerial(12, 13);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
int id;

String json_string="";


void setup() {
  // put your setup code here, to run once:
  
  Ethernet.begin(mac, ip);

  pinMode(2, OUTPUT); //Lampada 1
  pinMode(3, OUTPUT); //Lampada 2
  pinMode(4, OUTPUT); //Sistema ventilação

  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);

}

void loop() {
  // put your main code here, to run repeatedly:

  delay(1000);
  
  httpRequest();
  checarTemperatura();
}



void httpRequest()
{
  String resp;
  const int capacity = JSON_OBJECT_SIZE(3);
  StaticJsonDocument<256> doc;

  doc["Temperatura"].set("Arduino");
  doc["Id_Modulo"].set(0);
  doc["Acao"].set(true);
  doc["Continuo"].set(true);
  

  serializeJson(doc, output);

  if (client.connect(server, 9000))
  {


    client.println(output);
    
    
    json_string = client.readString();
    delay(2500);
    client.stop();    
        

    DeserializaJson();    
  }
  else
  {
    Serial.println("Falha na conexão");
  }
}
/*
1 - Ligar/Desligar Lampada 1 ok 
2 - Ligar/Desligar Lampada 2 ok
5 - Definir temperatura de ativação do ventilador ok
6 - Ligar/Desligar ventilação ok
7 - Abrir/Fechar Cotina 1
9 - Abrir/Fecha portão
10 - Abrir porta com digital ok 
11 - Cadastrar nova digital ok 
12 - Excluir digital ok 
*/
void DeserializaJson()
{
  StaticJsonDocument<256> doc;
  
  deserializeJson(doc, json_string);
  
  String temperatura = doc["Temperatura"];
  int id_modulo = doc["Id_Modulo"];
  bool acao = doc["Acao"];

  /*
  Serial.print("ID do módulo: ");
  Serial.println(id_modulo);
  Serial.print("Ação: ");
  Serial.println(acao);
  Serial.print("Temperatura informada: ");
  Serial.println(temperatura);
  */
  
  if (id_modulo != 0)
  {
    switch (id_modulo)
    {
      case 1:

        if(acao == true)
        {
          digitalWrite(2, HIGH);
          
        }
        else
        {
          digitalWrite(2, LOW);
        }
        break;
      
      case 2:
      {
        if(acao == true)
        {
          digitalWrite(3, HIGH);
          
        }
        else
        {
          digitalWrite(3, LOW);
        }
        break;
      }


      //Definir temperatura pra ativação do led
      case 5:
      {
        {
            temperatura_ativacao = temperatura.toInt();
        }
        break;
      }

      case 6:
      {
        if(digitalRead(8) == LOW)
        {
          digitalWrite(8, HIGH);
        }
        else
        {
          digitalWrite(8, LOW);
        }
        break;
      }
      
      case 10:
      {
        abrirPorta();
        break;
      }

      case 11:
      {
        id = temperatura.toInt();
        SalvarDigital(id);
        break;
      }

      case 12:
      {
        id = temperatura.toInt();
        deletarDigital(id);
        break; 
      }

      
    }
  }
  else
  {
    Serial.println("Não há tarefa para ser executada");    
  }
  json_string = "";
  doc.clear();
}

//Função pra checar temperatura ambiente e mudar o estado da lâmpada (ventilador ou sistema de irrigação) caso esteja acima da armazenada
void checarTemperatura()
{
  quantidade_temperatura++;
  sensors.requestTemperatures();
  temperatura_total += sensors.getTempCByIndex(0);
  temperatura_media = temperatura_total / quantidade_temperatura;

  if (sensors.getTempCByIndex(0) > temperatura_ativacao)
  {
    digitalWrite(8, HIGH);
  }
  else
  {
    digitalWrite(8, LOW);
  }
  Serial.print("Temperatura ativação: ");
  Serial.println(temperatura_ativacao);
  Serial.print("Temperatura média: ");
  Serial.println(temperatura_media);
  Serial.print("Temperatura atual: ");
  Serial.println(sensors.getTempCByIndex(0));
}

// Código para abrir a porta #
int abrirPorta() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK)  return -1;
  
  // found a match!
  Serial.print("ID ENCONTRADA #"); Serial.print(finger.fingerID); 
  Serial.print(" COM CONFIANÇA"); Serial.println(finger.confidence);

  if(finger.confidence > 80)
  {
    digitalWrite(4, HIGH);
    delay(1500);
    digitalWrite(4, LOW);
  }
  return finger.fingerID; 
}


/* Função pra salvar digital no sistema */
uint8_t SalvarDigital(uint8_t id) {

  int p = -1;
  Serial.print("Esperando digital válida para salvar como: #"); Serial.println(id);
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Imagem coletada");
      break;
    case FINGERPRINT_NOFINGER:
      
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      
      break;
    case FINGERPRINT_IMAGEFAIL:
      
      break;
    default:
      
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      
      break;
    case FINGERPRINT_IMAGEMESS:
      
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      
      return p;
    case FINGERPRINT_FEATUREFAIL:
      
      return p;
    case FINGERPRINT_INVALIDIMAGE:
     
      return p;
    default:
      
      return p;
  }
  
  Serial.println("Remova o dedo");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(id);
  p = -1;
  Serial.println("Coloque o mesmo dedo novamente");
  while (p != FINGERPRINT_OK) {
    
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Imagem coletada.");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.print(".");
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Erro de comunicação.");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Erro de imagem.");
      break;
    default:
      Serial.println("Erro desconhecido.");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      
      break;
    case FINGERPRINT_IMAGEMESS:
      
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      
      return p;
    case FINGERPRINT_FEATUREFAIL:
      
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      
      return p;
    default:
      
      return p;
  }
  
  // OK converted!
  Serial.print("Criando o modelo para a digital #");  Serial.println(id);
  
  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Digitais compativeis!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Erro de comunicação.");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Digitais não compativeis.");
    return p;
  } else {
    Serial.println("Erro desconhecido.");
    return p;
  }   
  
  Serial.print("ID "); Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    
    return p;
  } else {
    
    return p;
  }  
  }   
  
uint8_t deletarDigital(uint8_t id) {
  uint8_t p = -1;
  
  p = finger.deleteModel(id);

  if (p == FINGERPRINT_OK) {
    
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    
    return p;
  } else {
    
    return p;
  }   
}
