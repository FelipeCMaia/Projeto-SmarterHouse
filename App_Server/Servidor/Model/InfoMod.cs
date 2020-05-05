using System;
using System.Collections.Generic;
using System.Text;

namespace Servidor.Model
{
    [Serializable()]
    public class InfoMod
    {
        public int num_mod { get; set; }
        public int tempo_atividade { get; set; }
        public int vezes_ligadas { get; set; }
        public string dia_atividade { get; set; }
        public bool estado_modulo { get; set; }
    }    
}
