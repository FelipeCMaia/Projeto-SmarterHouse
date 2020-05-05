using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;

namespace SmarterHouse2
{

    public class Usuario
    {

        public string nome_usuario { get; set; }
        public string id_usuario { get; set; }
        public string method { get; set; }
        public string senha { get; set; }
        public string email { get; set; }
        public string senha_usuario { get; set; }
        public string cep_usuario { get; set; }
        public string cidade_usuario { get; set; }
        public string bairro_usuario { get; set; }
        public string endereco_usuario { get; set; }
        public string telefone_usuario { get; set; }

    }
    public class Insert
    {
        public string nome_usuario { get; set; }
        public string login_usuario { get; set; }
        public string senha_usuario { get; set; }
        public string id_usuario { get; set; }
        public string cep_usuario { get; set; }
        public string cidade_usuario { get; set; }
        public string bairro_usuario { get; set; }
        public string endereco_usuario { get; set; }
        public string telefone_usuario { get; set; }
    }

    public class Info_smart
    {
        public int codigo_erro { get; set; }
        public string mensagem_erro { get; set; }
    }

    public class Select_smart
    {
        public List<Usuario> select { get; set; }
        public List<Info> info { get; set; }

        public List<Insert> insert { get; set; }
    }



}
