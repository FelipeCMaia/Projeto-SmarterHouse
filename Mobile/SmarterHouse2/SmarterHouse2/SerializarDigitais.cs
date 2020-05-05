using System;
using System.Collections.Generic;
using System.Text;
using System.IO;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using Xamarin.Essentials;
using System.Xml.Serialization;

namespace SmarterHouse2
{
    public class SerializarDigitais
    {
        List<ListaDigitais> listaDigitais = new List<ListaDigitais>();
        XmlSerializer serializacao = new XmlSerializer(typeof(List<ListaDigitais>));


        public SerializarDigitais()
        {
            var documentsPath = Environment.GetFolderPath(Environment.SpecialFolder.Personal);

            var filePath = Path.Combine(documentsPath, "listaDigitais.xml");
            if (File.Exists(filePath))
            {
                using (FileStream fileStream = File.OpenRead(filePath))
                {
                    listaDigitais = (List<ListaDigitais>)serializacao.Deserialize(fileStream);
                }
            }
        }

        public void SalvarDigitais()
        {
            var documentsPath = Environment.GetFolderPath(Environment.SpecialFolder.Personal);

            var filePath = Path.Combine(documentsPath, "listaDigitais.xml");
            using (FileStream fileStream = new FileStream(filePath, FileMode.Create, FileAccess.Write, FileShare.None))
            {

                serializacao.Serialize(fileStream, listaDigitais);
            }
        }

        public bool AdicionarUsuario(int id, string nome, DateTime data)
        {
            
            listaDigitais.Add(new ListaDigitais(id, data, nome));
            SalvarDigitais();
            return true;

        }

        public void ExcluirUsuario(int id)
        {

            if (listaDigitais.Count > 0)
            {
                if (VerificarUsuario(id))
                {
                    foreach (ListaDigitais digitais in listaDigitais)
                    {
                        if (id == digitais.id)
                        {
                            listaDigitais.Remove(digitais);
                            

                            break;

                        }
                    }
                    SalvarDigitais();
                    
                }
                else
                {
                      
                }
            }
            else
            {
                
            }
            SalvarDigitais();
        }

        public bool VerificarUsuario(int id)
        {
            if (listaDigitais.Count > 0)
            {
                foreach (ListaDigitais digitais in listaDigitais)
                {
                    if (id == digitais.id)
                    {
                        return true;
                    }
                }
            }
            return false;
        }

        public int pegarID(string nome, DateTime data)
        {
            int id = 999;
            foreach(ListaDigitais DIGITAIS in listaDigitais)
            {
                if(DIGITAIS.nome == nome && data.ToShortDateString() == DIGITAIS.datCriacao.ToShortDateString())
                {
                    id = DIGITAIS.id;

                }
            }
            return id;
        }
        public List<ListaDigitais> retornar()
        {
            return listaDigitais;
        }
    }
}
