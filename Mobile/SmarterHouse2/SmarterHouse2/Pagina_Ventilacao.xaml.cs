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
    public partial class Pagina_Ventilacao : ContentPage
    {
        Cliente cliente = new Cliente();
        bool[] acao = new bool[10];

        public Pagina_Ventilacao(List<Pacote> lista, List<Pacote> lista_tarefas)
        {
            InitializeComponent();

            slider_value.Text = slide_temp.Value.ToString();

            string[] text = new string[10];

            text = cliente.mudartexto(lista);

            LigarVent.Text = text[2];

            acao = cliente.MudarAcao(lista);
        }

        private void LigarVent_Clicked(object sender, EventArgs e)
        {
            if (acao[2])
            {
                acao[2] = false;

            }
            else
            {
                acao[2] = true;
            }

            cliente.ConectarServidor();
            cliente.Enviar(6, null, acao[2], false);
            var texto = cliente.Receber();
            cliente.FecharServidor();                     
            LigarVent.Text = texto;

            

        }

        private void DefinirTemperatura_Clicked(object sender, EventArgs e)
        {
            string temp = slide_temp.Value.ToString();

            cliente.ConectarServidor();
            cliente.Enviar(5, temp, true, true);
            LigarVent.Text = cliente.Receber();
            cliente.FecharServidor();
        }

        private void Slide_temp_ValueChanged(object sender, ValueChangedEventArgs e)
        {
            slider_value.Text = slide_temp.Value.ToString();
        }

        private void CancelarTemperatura_Clicked(object sender, EventArgs e)
        {
            cliente.ConectarServidor();
            cliente.Enviar(5, "70", true, true);
            LigarVent.Text = cliente.Receber();
            cliente.FecharServidor();
        }
    }
}