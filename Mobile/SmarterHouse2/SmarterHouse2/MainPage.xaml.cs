using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net.Http;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using System.ComponentModel;
using Newtonsoft.Json;
using System.Threading;

//42605870804

namespace SmarterHouse2
{
    // Learn more about making custom code visible in the Xamarin.Forms previewer
    // by visiting https://aka.ms/xamarinforms-previewer
    [DesignTimeVisible(false)]
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();

            txt_email.Text = "";
            txt_senha.Text = "";

        }

        private async void Btn_logar_Clicked(object sender, EventArgs e)
        {
           
           try
            {
                var uri = "http://smarterapi.dx.am/v1/login";

                HttpClient cliente = new HttpClient();
                var novoselect = new Usuario()
                {
                    email = txt_email.Text,
                    senha = txt_senha.Text,

                };

                var jsonObj = JsonConvert.SerializeObject(novoselect);
                var content = new StringContent(jsonObj, Encoding.UTF8, "application/json");

                var response = await cliente.PostAsync(uri, content);

                if (response.IsSuccessStatusCode)
                {
                    var jsonstring = await response.Content.ReadAsStringAsync();

                   var jstring = JsonConvert.DeserializeObject<Usuario>(jsonstring);

                    await DisplayAlert("Login", "Logado com Sucesso", "Ok");

                    await Navigation.PushModalAsync(new Pagina_Modulos());

                    btn_logar.IsEnabled = false;


                }
                else
                {
                    var jsonstring = await response.Content.ReadAsStringAsync();

                    var jstring = JsonConvert.DeserializeObject<Select_smart>(jsonstring);

                    if (jsonstring.Contains("400"))
                    {
                        await DisplayAlert("Erro ao logar","Email ou senha Iinválidos", "Ok");
                    }
                 
           
                }
            }
            catch (Exception _e)
            {
                await DisplayAlert("Erro", _e.ToString(), "OK");
                throw;
            }
        }

        private void Btn_cad_Clicked(object sender, EventArgs e)
        {

        }
    }
}
