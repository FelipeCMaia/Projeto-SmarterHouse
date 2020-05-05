using System;
using System.Collections.Generic;
using System.Text;

namespace SmarterHouse2
{
    [Serializable()]
    public class ListaDigitais
    {
        public ListaDigitais() { }

        public ListaDigitais(int _id, DateTime _data, string _nome)
        {
            nome = _nome;
            datCriacao = _data;
            id = _id;
        }

        public string nome { get; set; }
        public DateTime datCriacao { get; set; }
        public int id { get; set; }
    }
}
