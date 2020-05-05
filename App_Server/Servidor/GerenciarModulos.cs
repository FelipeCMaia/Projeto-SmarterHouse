using System;
using System.Collections.Generic;
using System.Text;
using System.Net.Sockets;
using Servidor.Model;
using Newtonsoft.Json;
using System.IO;
using System.Xml.Serialization;

namespace Servidor
{
    class GerenciarModulos
    {
        EnviarHorarios Enviar = new EnviarHorarios();

        public static XmlSerializer serializer = new XmlSerializer(typeof(List<InfoMod>));

        //Envia tempo de atividade dos modulos ao banco de dados
        public void AcrescentarTempoModulos(List<InfoMod> infos)
        {
            foreach (InfoMod item in infos)
            {
                if (item.estado_modulo)
                {
                    item.tempo_atividade += 5;
                    //Enviar.EnviarHorariosDB(item);
                }
            }
            SalvarModulos(infos);
        }

        public void RetornaEstadoModulos(NetworkStream stream, List<InfoMod> infos)
        {
            List<Pacote> pacotes = new List<Pacote>();

            foreach (InfoMod item in infos)
            {
                pacotes.Add(new Pacote { Id_Modulo = item.num_mod, Acao = item.estado_modulo, Continuo = false, Horario = DateTime.Now, Temperatura = "" });
            }

            var data = Encoding.UTF8.GetBytes(JsonConvert.SerializeObject(pacotes));

            stream.Write(data, 0, data.Length);

            stream.Flush();
        }

        //Define estaticamente os modulos do arduino
        public List<InfoMod> DefineModulos(List<InfoMod> infos)
        {
            String data = DateTime.Now.Year.ToString() + "-" + DateTime.Now.Month.ToString() + "-" + DateTime.Now.Day.ToString();

            bool r = true;

            List<InfoMod> list = new List<InfoMod>();

            if (File.Exists("modulos.xml"))
            {
                using (FileStream fileStream = File.OpenRead("modulos.xml"))
                {
                    list = (List<InfoMod>)serializer.Deserialize(fileStream);
                }
            }

            foreach (InfoMod item in list)
            {
                if (item.dia_atividade == data)
                {
                    infos.Add(new InfoMod { num_mod = item.num_mod, dia_atividade = item.dia_atividade, tempo_atividade = item.tempo_atividade, vezes_ligadas = item.vezes_ligadas, estado_modulo = item.estado_modulo });
                    r = false;
                }
            }

            if (r)
            {
                infos.Add(new InfoMod { num_mod = 1, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });
                infos.Add(new InfoMod { num_mod = 2, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });
                infos.Add(new InfoMod { num_mod = 3, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });                
                infos.Add(new InfoMod { num_mod = 6, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });
                infos.Add(new InfoMod { num_mod = 7, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });                
                infos.Add(new InfoMod { num_mod = 9, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });
                infos.Add(new InfoMod { num_mod = 10, dia_atividade = data, tempo_atividade = 0, vezes_ligadas = 0, estado_modulo = false });
                
            }            
            return infos;
        }

        //Altera o estado do modulo de acordo com cada ação
        public List<InfoMod> AlteraEstadoModulo(int id_mod, List<InfoMod> infoMods)
        {
            foreach (InfoMod info in infoMods)
            {
                if (info.num_mod == id_mod)
                {
                    if (info.estado_modulo)
                    {
                        info.estado_modulo = false;
                    }
                    else
                    {
                        info.vezes_ligadas++;
                        info.estado_modulo = true;
                    }
                }
            }

            //infoMods = VerificaData(infoMods);

            SalvarModulos(infoMods);
            return infoMods;
        }

        //Salva estado dos metodos no arquivo xml
        public static void SalvarModulos(List<InfoMod> infos)
        {
            using (FileStream fileStream = new FileStream("modulos.xml", FileMode.Create, FileAccess.Write, FileShare.None))
            {
                serializer.Serialize(fileStream, infos);
            }
        }

        public InfoMod RetornaModulo(int id_modulo, List<InfoMod> infos)
        {
            var retorno = new InfoMod { num_mod = 0 };
            foreach (var item in infos)
            {
                if (item.num_mod == id_modulo)
                {
                    retorno = item;
                    return retorno;
                }
            }
            return retorno;
        }
    }
}
