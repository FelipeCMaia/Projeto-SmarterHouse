using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SmarterHouse2
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class Pagina_Portao : ContentPage
    {
        Cliente cliente = new Cliente();

        bool[] acao = new bool[10];

        public Pagina_Portao(List<Pacote> lista)
        {
            InitializeComponent();

            string[] text = new string[10];

            text = cliente.mudartexto(lista);

            btn_portao.Text = text[4];

            acao = cliente.MudarAcao(lista);
        }

        private void Abrir_Clicked(object sender, EventArgs e)
        {
            cliente.ConectarServidor();
            cliente.Enviar(9, null, acao[4], false);
            btn_portao.Text = cliente.Receber();
            cliente.FecharServidor();

            if (acao[4])
            {
                acao[4] = false;
            }
            else
            {
                acao[4] = true;
            }
        }
    }
}