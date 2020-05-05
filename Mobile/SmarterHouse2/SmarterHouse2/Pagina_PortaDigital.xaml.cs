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
    public partial class Pagina_PortaDigital : ContentPage
    {
        public Pagina_PortaDigital(List<Pacote> lista)
        {
            InitializeComponent();
        }

        private async void Btn_Registrar(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_RegistrarDigital()));
        }

        private async void Btn_Listar(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new Pagina_ListarDIgitais()));
        }

        private void Button_Clicked(object sender, EventArgs e)
        {
            Cliente cliente = new Cliente();
            SerializarDigitais serializar = new SerializarDigitais();
            List<ListaDigitais> listinha = new List<ListaDigitais>();
            listinha = serializar.retornar();

            foreach(ListaDigitais lista in listinha)
            {

                serializar.ExcluirUsuario(lista.id);

                cliente.ConectarServidor();
                cliente.Enviar2(DateTime.Now, 12, lista.id.ToString(), true, false);

                cliente.FecharServidor();
            }
        }
    }
}