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
    public partial class Pagina_Modulos : ContentPage
    {
        List<Pacote> lista_modulos;
        List<Pacote> lista_tarefas;
        public Pagina_Modulos()
        {
            InitializeComponent();

            Cliente cliente = new Cliente();

            lista_modulos = new List<Pacote>();

            cliente.ConectarServidor();
            cliente.Lixo(24);
            lista_modulos = cliente.Receber2();
            cliente.FecharServidor();

            cliente.ConectarServidor();
            cliente.Lixo(34);
            lista_tarefas = cliente.Receber2();
            cliente.FecharServidor();

        }

        private async void Btn_Porta(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_PortaDigital(lista_modulos)));
        }

        private async void Btn_Portao(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_Portao(lista_modulos)));
        }

        private async void Btn_Cortina(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_Cortina(lista_modulos, lista_tarefas)));
        }

        private async void Btn_Iluminacao(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_Iluminacao(lista_modulos, lista_tarefas)));
        }

        private async void Btn_Ventilacao(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_Ventilacao(lista_modulos, lista_tarefas)));
        }

        private async void Btn_Sair(object sender, EventArgs e)
        {
            await Navigation.PopModalAsync();
        }
    }
}