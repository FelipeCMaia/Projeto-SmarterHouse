using System;
using System.Collections.Generic;
using System.Text;
using Servidor.Model;
using Newtonsoft.Json;
using System.IO;
using System.Net;
using System.Xml.Serialization;

namespace Servidor
{
    class EnviarHorarios
    {                
        //Email e senha para ter acesso ao token para conexão com api
        public static string email_server = "a@a.com";
        public static string senha_server = "123";
        public static string token = "";

        //URL para login e conexão com api
        public static string uri_login = "http://smarterapi.dx.am/v1/login";
        public static string uri = "http://smarterapi.dx.am/v1/grafico/insere-dados-horario";
        

        public void EnviarHorariosDB(InfoMod info)
        {
            Console.WriteLine("Enviando modulo " + info.num_mod + " ao banco.");
            //Converte informações do modulo em JSON
            var data = JsonConvert.SerializeObject(info);

            //Chamada de metodo que conecta a api
            string response = RequestHttp(uri, token, data);

            //Caso o token esteja expirado retornará erro 401
            if (response == "401")
            {
                Console.WriteLine("Token Expirado");

                User user = new User
                {
                    email = email_server,
                    senha = senha_server,
                };

                data = JsonConvert.SerializeObject(user);

                //Realiza nova consulta para obter novo token de acesso
                var resp = JsonConvert.DeserializeObject<User>(RequestHttp(uri_login, data));

                token = resp.token;

                Console.WriteLine("Novo Token Gerado");

                //Tenta novamente a conexão com o novo token
                EnviarHorariosDB(info);
            }
            else
            {
                Console.WriteLine("Modulo Enviado");
            }
        }               

        //Verifica a data a ser enviada ao banco
        public List<InfoMod> VerificaData(List<InfoMod> infoMods)
        {
            String data = DateTime.Now.Year.ToString() + "-" + DateTime.Now.Month.ToString() + "-" + DateTime.Now.Day.ToString();

            foreach (InfoMod item in infoMods)
            {
                if(item.dia_atividade != data)
                {
                    item.dia_atividade = data;
                }
            }

            return infoMods;
        }

        //Envia dados dos modulos para o banco
        public static string RequestHttp(string uri, string token, string json_info)
        {
            string responseText = "";

            var requisicaoWeb = (HttpWebRequest)WebRequest.Create(uri);
            requisicaoWeb.Method = "POST";
            requisicaoWeb.PreAuthenticate = true;
            requisicaoWeb.Headers.Add("Authorization", "Bearer " + token);
            requisicaoWeb.Accept = "application/json";
            requisicaoWeb.ContentType = "application/json; charset=utf-8";

            //Estabelece conexão com api
            using (var resposta = new StreamWriter(requisicaoWeb.GetRequestStream()))
            {
                //Envia modulo
                resposta.Write(json_info);
                resposta.Flush();
            }
            try
            {

                var httpResponse = (HttpWebResponse)requisicaoWeb.GetResponse();
                using (var streamReader = new StreamReader(httpResponse.GetResponseStream()))
                {
                    responseText = streamReader.ReadToEnd();
                    Console.WriteLine(responseText);
                }

                return responseText;
            }
            catch (Exception ex)
            {
                if (ex.Message.Contains("401"))
                {
                    responseText = "401";
                }

                return responseText;
            }
        }

        //Requisita token para conexão com api atraves do login com email e senha
        public static string RequestHttp(string uri, string json_info)
        {
            string responseText = "";
            //Acessa url
            var requisicaoWeb = (HttpWebRequest)WebRequest.Create(uri);
            requisicaoWeb.Method = "POST";
            requisicaoWeb.PreAuthenticate = true;
            requisicaoWeb.Accept = "application/json";
            requisicaoWeb.ContentType = "application/json; charset=utf-8";

           
            using (var resposta = new StreamWriter(requisicaoWeb.GetRequestStream()))
            {
                resposta.Write(json_info);
                resposta.Flush();
            }
            try
            {
                var httpResponse = (HttpWebResponse)requisicaoWeb.GetResponse();
                using (var streamReader = new StreamReader(httpResponse.GetResponseStream()))
                {
                    responseText = streamReader.ReadToEnd();
                }

                return responseText;
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message);

                if (ex.Message.Contains("401"))
                {
                    responseText = "401";
                }

                return responseText;
            }
        }
    }
}
