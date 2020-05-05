using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Xml.Serialization;
using System.Threading.Tasks;
using System.Linq;
using System.Threading;
using Servidor.Model;

namespace Servidor
{
    class Program
    {
        //
        static string nome = Dns.GetHostName();

        static IPAddress[] ip = Dns.GetHostAddresses(nome);

        static GerenciarModulos gerenciar = new GerenciarModulos();        

        //Estancia da classe para envio dos horarios ao banco
        static EnviarHorarios EnviarHorarios = new EnviarHorarios();

        //Lista do estados dos modulos
        static List<InfoMod> infos = new List<InfoMod>();

        static NetworkStream stream;

        //Lista de ordens armazenadas
        static List<Pacote> ordens_armazenadas = new List<Pacote>();

        //Instanciando a classe de serialização
        static XmlSerializer serializador = new XmlSerializer(typeof(List<Pacote>));        

        public static void Main(string[] args)
        {
            

            //DEfine estado dos modulos para envio ao banco de dados
            infos = gerenciar.DefineModulos(infos);            

            //Thread que envia dados dos modulos ao banco
            Thread thread = new Thread(AcrescentaTempo);
            thread.Start();

            Thread thread1 = new Thread(EnviaModulosBanco);
            thread1.Start();

            //Metodo para verificar se a lista de ordens armazenadas previamente existe, se existir, manda para a lista anteriormente criada
            if (File.Exists("ordens.xml"))
            {
                using (FileStream fileStream = File.OpenRead("ordens.xml"))
                {
                    ordens_armazenadas = (List<Pacote>)serializador.Deserialize(fileStream);
                }
            }

            //Define o IP do servidor e a porta de acesso
            TcpListener server = new TcpListener(IPAddress.Parse(ip[3].ToString()), 9000);
                       
            //AdicionarTarefa(DateTime.Now, 3, true, true, "66");            

            server.Start();

            Console.WriteLine("Servidor ligado");
            Console.WriteLine("Ip do Servidor: " + ip[3].ToString());

            //Repetição para receber infinitas conexões
            while (true)
            {
                //Aceita conexão com cliente
                TcpClient client = server.AcceptTcpClient();

                stream = client.GetStream();

                Console.WriteLine("Recebe conexao");

                while (!stream.DataAvailable);

                Byte[] bytes = new Byte[1024];

                //Lê dados enviados pelo cliente
                stream.Read(bytes, 0, bytes.Length);

                String data = Encoding.UTF8.GetString(bytes);

                Pacote leitor = JsonConvert.DeserializeObject<Pacote>(data);

                Console.WriteLine(data);

                //Trata dados enviados
                AnalisaResposta(leitor, stream);                                               
            }
        }

        public static Pacote CriarOrdem()
        {            
            Pacote ordem = new Pacote(DateTime.Now, 5, true, true, "25");
            if (ordens_armazenadas.Count > 0)
            {
                foreach (Pacote pacote in ordens_armazenadas)
                {
                    Console.WriteLine(pacote.Horario);
                    if (pacote.Horario.CompareTo(DateTime.Now) < 0)
                    {
                        if (pacote.Continuo == true)
                        {                            
                            AdicionarTarefa(pacote.Horario.AddDays(1), pacote.Id_Modulo, pacote.Acao, pacote.Continuo, pacote.Temperatura);
                            ordens_armazenadas.Remove(pacote);
                            break;
                        }
                    }
                    if (pacote.Continuo == false)
                    {
                        ordem = pacote;
                        Console.Write("Enviando: ");
                        Console.WriteLine(pacote.Temperatura);
                        Console.WriteLine(pacote.Id_Modulo);
                        Console.WriteLine(pacote.Acao);
                        Console.WriteLine("Continuo: " + pacote.Continuo.ToString());
                        ordens_armazenadas.Remove(pacote);
                        SalvarTarefas();
                    }
                    else
                    {
                        DateTime dateTime = new DateTime();
                        dateTime = DateTime.Now;
                        
                        Console.WriteLine(dateTime);
                        
                        if (DateTime.Now.ToShortTimeString() == pacote.Horario.ToShortTimeString() && DateTime.Now.Date.CompareTo(pacote.Horario.Date) == 0)
                        {
                            Console.WriteLine("Tarefa Enviada");
                            ordem = pacote;
                            if (pacote.Continuo) AdicionarTarefa(pacote.Horario.AddDays(1), pacote.Id_Modulo, pacote.Acao, pacote.Continuo, pacote.Temperatura);
                            ordens_armazenadas.Remove(pacote);
                            SalvarTarefas();
                            break;
                        }
                    }
                    
                }
            }

            return ordem;
        }


        public static void AnalisaResposta(Pacote pacote, NetworkStream stream)
        {
            var pack = new Pacote();

            //Enviar temperatura normalmente
            //Temperatura servira para enviar o id da digital
            //
            switch (pacote.Id_Modulo)
            {
                
                case 0:
                    EnviaResposta(stream);
                    break;

                //Lampada
                case 1:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };                    
                    RespostaCelular(stream, pack);
                    break;

                //Lampada
                case 2:
                    //AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };
                    RespostaCelular(stream, pack);
                    break;                                
                
                //Definir temperatura
                case 5:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo, pacote.Temperatura);
                    //Console.WriteLine("Recebeu celular");
                    //EnviaResposta(stream);
                    break;

                //Ventilação
                case 6:
                    //AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };
                    RespostaCelular(stream, pack);
                    break;

                //Cortina 1
                case 7:
                    //Console.WriteLine("Recebido");
                    //infos = gerenciar.AlteraEstadoModulo(2, infos);
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };
                    RespostaCelular(stream, pack);
                    break;                

                //Portão
                case 9:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };
                    RespostaCelular(stream, pack);
                    break;

                //Abrir porta com digital
                case 10:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
                    pack = new Pacote { Horario = DateTime.Now, Id_Modulo = pacote.Id_Modulo, Acao = gerenciar.RetornaModulo(pacote.Id_Modulo, infos).estado_modulo, Continuo = false };
                    RespostaCelular(stream, pack);
                    break;

                //Cadastrar Digital
                case 11:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    break;

                //Excluir Digital
                case 12:
                    AdicionarTarefa(DateTime.Now, pacote.Id_Modulo, pacote.Acao, pacote.Continuo);
                    break;

                //Retornar estados dos modulos para smartphone
                case 24:
                    Console.WriteLine("Requisição dos modulos");
                    gerenciar.RetornaEstadoModulos(stream, infos);
                    break;


                case 34:
                    EnviarTarefas(stream);
                    break;

                default:
                    break;
            }    
        }

        //Envia resposta ao arduino
        public static void EnviaResposta(NetworkStream stream)
        {
            try
            {
                Pacote pacote = CriarOrdem();

                var enviado = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(pacote));

                stream.Write(enviado, 0, enviado.Length);
                
                stream.Flush();
                Console.WriteLine("Mensagem Enviada");
            }
            catch (Exception)
            {
                throw;
            }
        }

        public static void SalvarTarefas()
        {
            using (FileStream fileStream = new FileStream("ordens.xml", FileMode.Create, FileAccess.Write, FileShare.None))
            {
                serializador.Serialize(fileStream, ordens_armazenadas);
            }
        }

        //Metodo para adicionar tarefas, é necessário pois salvará diretamente no arquivo xml após a inserção de cada nova tarefa na lista
        public static void AdicionarTarefa(DateTime horario, int _id, bool _acao = true, bool continuo = false, string _temperatura = "")
        {
            ordens_armazenadas.Add(new Pacote(horario, _id, _acao, continuo, _temperatura));
            SalvarTarefas();
        }
       
        public static void AcrescentaTempo()
        {
            while (true)
            {
                Thread.Sleep(5000);

                gerenciar.AcrescentarTempoModulos(infos);
            }
        }
        
        public static void EnviaModulosBanco()
        {
            while(true)
            {
                //3 Minutos de delay
                Thread.Sleep(180000);
                foreach (var item in infos)
                {
                    //EnviarHorarios.EnviarHorariosDB(item);
                }                
            }
        }

        public static void Altera(Pacote pacote)
        {
            if (pacote.Id_Modulo != 0)
            {
                //Altera estado do modulo ao ser enviado
                infos = gerenciar.AlteraEstadoModulo(pacote.Id_Modulo, infos);
            }
        }

        public static void EnviarTarefas(NetworkStream stream)
        {
            List<Pacote> tarefas = new List<Pacote>();

            foreach (var item in ordens_armazenadas)
            {
                if(item.Continuo )
                {
                    tarefas.Add(item);
                }
            }

            var enviado = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(tarefas));

            stream.Write(enviado, 0, enviado.Length);

            stream.Flush();
            Console.WriteLine("Tarefas Retornadas");
        }

        public static void RespostaCelular(NetworkStream stream, Pacote pacote)
        {
            var enviado = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(pacote));

            stream.Write(enviado, 0, enviado.Length);

            stream.Flush();
            Console.WriteLine("Tarefas Retornadas");
        }

        public class handleClinet
        {
            TcpClient clientSocket;
            string clNo;
            public void startClient(TcpClient inClientSocket, string clineNo)
            {
                this.clientSocket = inClientSocket;
                this.clNo = clineNo;
                Thread ctThread = new Thread(doChat);
                ctThread.Start();
            }
            private void doChat()
            {
                int requestCount = 0;
                byte[] bytesFrom = new byte[10025];
                string dataFromClient = null;
                Byte[] sendBytes = null;
                string serverResponse = null;
                string rCount = null;
                requestCount = 0;

                while ((true))
                {
                    try
                    {
                        requestCount = requestCount + 1;
                        NetworkStream networkStream = clientSocket.GetStream();
                        networkStream.Read(bytesFrom, 0, (int)clientSocket.ReceiveBufferSize);
                        dataFromClient = System.Text.Encoding.ASCII.GetString(bytesFrom);
                        dataFromClient = dataFromClient.Substring(0, dataFromClient.IndexOf("$"));
                        Console.WriteLine(" >> " + "From client-" + clNo + dataFromClient);

                        rCount = Convert.ToString(requestCount);
                        serverResponse = "Server to clinet(" + clNo + ") " + rCount;
                        sendBytes = Encoding.ASCII.GetBytes(serverResponse);
                        networkStream.Write(sendBytes, 0, sendBytes.Length);
                        networkStream.Flush();
                        Console.WriteLine(" >> " + serverResponse);
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine(" >> " + ex.ToString());
                    }
                }
            }
        }

    }
}   
