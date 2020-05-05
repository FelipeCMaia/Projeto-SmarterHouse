using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using Xamarin.Forms;
using System.IO;
using System.Net.Sockets;
using System.Net;
using Newtonsoft.Json;

namespace SmarterHouse2
{
    public class Cliente
    {
        static string mensagem;
        static Pacote p;
        NetworkStream sockStream;
        TcpClient cliente;

        static List<Pacote> lista = new List<Pacote>();
        static List<Pacote> lista2 = new List<Pacote>();

        public void ConectarServidor()
        {

            cliente = new TcpClient();
            cliente.Connect("10.104.205.48", 9000);
            sockStream = cliente.GetStream();

        }
        public void Lixo(int i)
        {
            p = new Pacote { Id_Modulo = i , Temperatura = "", Acao = true, Continuo = false };

            Byte[] lixo = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(p));

            sockStream.Write(lixo, 0, lixo.Length);
        }

        
        public void Enviar(int id_modulo, string temperatura, bool acao, bool continuo)
        {        
            
            p = new Pacote (DateTime.Now, id_modulo, acao, continuo, temperatura);

            Byte[] enviado = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(p));

            Application.Current.MainPage.DisplayAlert("", JsonConvert.SerializeObject(p), "Ok");

            sockStream.Write(enviado, 0, enviado.Length);

        }
        public void Enviar2(DateTime hora, int id_modulo, string temperatura, bool acao, bool continuo)
        {

            p = new Pacote(hora, id_modulo, acao, continuo, temperatura);

            Byte[] enviado = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(p));

            Application.Current.MainPage.DisplayAlert("", JsonConvert.SerializeObject(p), "Ok");

            sockStream.Write(enviado, 0, enviado.Length);
            sockStream.Flush();

        }
         public string Receber()
         {
            try
            {
                string texto = String.Empty;

                byte[] data = new byte[512];
                sockStream.Read(data, 0, data.Length);

                var leitor = JsonConvert.DeserializeObject<Pacote>(Encoding.UTF8.GetString(data));

                Pacote pacote = new Pacote { Horario = leitor.Horario ,Id_Modulo = leitor.Id_Modulo, Temperatura = leitor.Temperatura, Acao = leitor.Acao, Continuo = leitor.Continuo };

                switch (pacote.Id_Modulo)
                {
                    case 0:
                        texto = "mãe do arthur a bolonhesa";
                        return texto;

                    case 1:
                        if (pacote.Acao == true) { texto = "Desligar Lampada 1"; return texto; }
                        else { texto = "Ligar Lampada 1"; return texto; }


                    case 2:
                        if (pacote.Acao == true) { texto = "Desligar Lampada 2"; return texto; }
                        else { texto = "Ligar Lampada 2"; return texto; }

                    case 5:
                        if (pacote.Acao == true) { texto = "Fechar Portão"; return texto; }
                        else { texto = "Abrir Portao"; return texto; }

                    case 6:
                        if (pacote.Acao == true) { texto = "Fechar Portão"; return texto; }
                        else { texto = "Abrir Portao"; return texto; }

                    case 7:
                        if (pacote.Acao == true) { texto = "Fechar Cortina"; return texto; }
                        else { texto = "Abrir Cortina"; return texto; }

                    case 9:
                        if (leitor.Acao) { texto = "Desligar Ventilação"; return texto; }
                        else { texto = "Ligar Ventilação"; return texto; }

                    /*default:
                        System.Diagnostics.Process.GetCurrentProcess().Kill();
                        return texto;*/

                    default:
                        texto = "deu ruim";
                        return texto;


                }
            }
            catch (Exception ex)
            {
                Application.Current.MainPage.DisplayAlert("Erro ao receber informações sobre o módulo", ex.Message, "OK");
                return "a";
            }
         }

        public List<Pacote> Receber2()
        {
            try
            {
                string texto = String.Empty;

                byte[] data = new byte[1500];
                sockStream.Read(data, 0, data.Length);

                var leitor = JsonConvert.DeserializeObject<List<Pacote>>(Encoding.UTF8.GetString(data));

                foreach (var listinha in leitor)
                {
                    lista.Add(new Pacote { Horario = listinha.Horario, Id_Modulo = listinha.Id_Modulo, Temperatura = listinha.Temperatura, Acao = listinha.Acao, Continuo = listinha.Continuo });
                }

                return lista;
            }
            catch (Exception ex)
            {
                Application.Current.MainPage.DisplayAlert("Erro", ex.Message, "OK");
                return null;
             }
                            
        }

        public string[] mudartexto(List<Pacote> pacotes)
        {
            string[] texto = new string[15];

            foreach(var pacote in pacotes)
            {
                if(pacote.Id_Modulo == 1)
                {
                    if(pacote.Acao){
                        texto[0] = "Desligar Lâmpada 1";
                        
                    }
                    else
                    {
                        texto[0] = "Ligar Lâmpada 1";
                        
                    }
                }

                if (pacote.Id_Modulo == 2)
                {
                    if (pacote.Acao)
                    {
                        texto[1] = "Desligar Lâmpada 2";
                        
                    }
                    else
                    {
                        texto[1]="Ligar Lâmpada 2";
                        
                    }
                }


                if (pacote.Id_Modulo == 6)
                {
                    if (pacote.Acao)
                    {
                        texto[2]= "Desligar Ventilação";
                        
                    }
                    else
                    {
                        texto[2]="Ligar Ventilação";
                        
                    }
                }

                if (pacote.Id_Modulo == 7)
                {
                    if (pacote.Acao)
                    {
                        texto[3]= "Fechar Cortina";
                        
                    }
                    else
                    {
                        texto[3]= "Abrir Cortina";
                        
                    }
                }

                if (pacote.Id_Modulo == 9)
                {
                    if (pacote.Acao)
                    {
                        texto[4] = "Fechar Portão";
                        
                    }
                    else
                    {
                        texto[4]="Abrir Portão";
                        
                    }
                }
            }
            return texto;
            
        }

        public bool[] MudarAcao(List<Pacote> pacotes)
        {
            bool[] action = new bool[15];

            foreach (var pacote in pacotes)
            {
                switch (pacote.Id_Modulo)
                {
                    case 1:
                        action[0] = pacote.Acao;
                        break;
                    case 2:
                        action[1] = pacote.Acao;
                        break;
                    case 6:
                        action[2] = pacote.Acao;
                        break;
                    case 7:
                        action[3] = pacote.Acao;
                        break;
                    case 9:
                        action[4] = pacote.Acao;
                        break;
                }
            }

            return action;
        }

        public List<Pacote> ListarTarefas(List<Pacote> pacotes, int id)
        {

            foreach (var pacote in pacotes)
            {
                if (pacote.Id_Modulo == id)
                {                    
                    lista2.Add(pacote);                            
                }
            }
            return lista2;

        }


        public void FecharServidor()
        {
            cliente.Close();
        }
    }
}
