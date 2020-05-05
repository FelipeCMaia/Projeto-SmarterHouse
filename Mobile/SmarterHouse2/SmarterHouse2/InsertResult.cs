using System;
using System.Collections.Generic;
using System.Text;

namespace SmarterHouse2
{
    public class Produto
    {
        public string id { get; set; }
        public string nome_produto { get; set; }
        public string valor { get; set; }
    }

    public class Info
    {
        public int codigo_erro { get; set; }
        public string mensagem_erro { get; set; }
    }

    public class InsertResult
    {
        public List<Produto> produtos { get; set; }
        public List<Info> info { get; set; }
    }
}
