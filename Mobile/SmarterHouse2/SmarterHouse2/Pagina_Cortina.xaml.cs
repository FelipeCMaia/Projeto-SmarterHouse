using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using SmarterHouse2;

namespace SmarterHouse2
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class Pagina_Cortina : ContentPage
    {
        Cliente cliente = new Cliente();

        bool[] acao = new bool[10];

        List<Pacote> list = new List<Pacote>();
        List<Pacote> lista_tarefas2 = new List<Pacote>();

        public Pagina_Cortina(List<Pacote> lista, List<Pacote> lista_tarefas)
        {
            InitializeComponent();

            list = lista;

            lista_tarefas2 = lista_tarefas;

            string[] text = new string[10];

            text = cliente.mudartexto(lista);

            btn_cortina.Text = text[3];

            acao = cliente.MudarAcao(lista);

        }

        private async void Btn_def_rotina(object sender, EventArgs e)
        {
           await Navigation.PushModalAsync(new NavigationPage(new Pagina_RotinaGeralCortinas(list, lista_tarefas2)));
        }

        private void Abrir_Clicked(object sender, EventArgs e)
        {
            if (acao[3])
            {
                acao[3] = false;
            }
            else
            {
                acao[3] = true;
            }

            cliente.ConectarServidor();
            cliente.Enviar(7, null, acao[3], false);
            btn_cortina.Text=cliente.Receber();
            cliente.FecharServidor();

        }
    }
}