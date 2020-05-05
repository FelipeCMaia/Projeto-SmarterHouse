using System;
using System.Collections.Generic;
using System.Text;

namespace Servidor.Model
{
    [Serializable()]
    public class Pacote
    {
        public Pacote() { }
        
        public Pacote(DateTime horario, int _id, bool _acao = true, bool continuo = false, string _temperatura = "")
        {
            Id_Modulo = _id;
            Acao = _acao;
            Continuo = continuo;
            Temperatura = _temperatura;
            Horario = horario;
        }

        
        public string Temperatura { get; set; }
        public int Id_Modulo { get; set; }
        public bool Acao { get; set; }
        public bool Continuo { get; set; }
        public DateTime Horario { get; set; }
    }
}
