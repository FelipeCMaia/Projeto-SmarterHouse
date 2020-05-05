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
    public partial class Pagina_RegistrarDigital : ContentPage
    {
        Cliente cliente = new Cliente();
        SerializarDigitais serializarDigitais = new SerializarDigitais();
        public Pagina_RegistrarDigital()
        {
            InitializeComponent();
        }

        private void Button_Clicked(object sender, EventArgs e)
        {
            if(Nome.Text == null || Nome.Text == String.Empty || Nome.Text == "")
            {
                DisplayAlert("Erro", "Informe o nome do dono da digital", "Ok");
            }
            else
            {
                int id = 0;

                while (serializarDigitais.VerificarUsuario(id))
                {
                    id++;
                }

                string temp = id.ToString();
                serializarDigitais.AdicionarUsuario(id, Nome.Text, DateTime.Now);

                cliente.ConectarServidor();
                cliente.Enviar2(DateTime.Now, 11, temp, true, false);
                
                cliente.FecharServidor();

                
            }
        }
    }
}