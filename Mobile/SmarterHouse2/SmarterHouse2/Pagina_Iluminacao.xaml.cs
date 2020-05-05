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
    public partial class Pagina_Iluminacao : ContentPage
    {
        Cliente cliente = new Cliente();

        bool[] acao = new bool[10];

        List<Pacote> lista_modulos = new List<Pacote>();
        List<Pacote> _lista_tarefas = new List<Pacote>();
        List<Pacote> lista1 = new List<Pacote>();
        List<Pacote> lista2 = new List<Pacote>();
  
        public Pagina_Iluminacao(List<Pacote> lista, List<Pacote> lista_tarefas)
        {
            InitializeComponent();
            NavigationPage.SetHasNavigationBar(this, true);

            lista_modulos = lista;
            _lista_tarefas = lista_tarefas;

            string[] texto = new string[10];

            texto = cliente.mudartexto(lista);

            lampada1.Text = texto[0];
            lampada2.Text = texto[1];

            acao = cliente.MudarAcao(lista);

        }

        private async void Button_Clicked(object sender, EventArgs e)
        {
           await Navigation.PushModalAsync(new NavigationPage(new Pagina_RotinaIluminacao(lista_modulos, _lista_tarefas)));
        }

        private void Lampada1_Clicked(object sender, EventArgs e)
        {
            if (acao[0])
            {
                acao[0] = false;
            }
            else
            {
                acao[0] = true;
            }

            cliente.ConectarServidor();
            cliente.Enviar(1, null, acao[0], false);
            lampada1.Text=cliente.Receber();
            cliente.FecharServidor();
    
        }

        private void Lampada2_Clicked(object sender, EventArgs e)
        {
            cliente.ConectarServidor();
            cliente.Enviar(2, null, acao[1], false);
            lampada2.Text=cliente.Receber();
            cliente.FecharServidor();

            if (acao[1])
            {
                acao[1] = false;
            }
            else
            {
                acao[1] = true;
            }
        }
    }
}