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
    public partial class Pagina_ListarDIgitais : ContentPage
    {
        Cliente cliente = new Cliente();
        SerializarDigitais serializarDigitais = new SerializarDigitais();
        public Pagina_ListarDIgitais()
        {
            InitializeComponent();

            //tem uma lista que vai ter os nomes e digitais cadastradas, e vão aparecer todos que estão cadsatrados, porém o numero vai depender de quantos cadastros tem.
            List<ListaDigitais> list_digitais = new List<ListaDigitais>();
            list_digitais = serializarDigitais.retornar();


            StackLayout layoutPrincipal = new StackLayout() { BackgroundColor = Color.FromHex("#E5EEC7"), Padding = 20 };
            StackLayout layoutAux = new StackLayout() { Orientation = StackOrientation.Horizontal, BackgroundColor = Color.FromHex("#E5EEC7") };

            foreach (ListaDigitais digital in list_digitais)
            {


                StackLayout stackUsuarios = new StackLayout() { };
                StackLayout stackBotoes = new StackLayout() { Orientation = StackOrientation.Horizontal, BackgroundColor = Color.FromHex("#E5EEC7") };
                

                

                stackUsuarios.Children.Add(new Label { Text = "Nome: " + digital.nome, TextColor = Color.Black, FontSize = 16 });
                stackUsuarios.Children.Add(new Label { Text = "ID: " + digital.id, TextColor = Color.Black, FontSize = 16 });
                stackUsuarios.Children.Add(new Label { Text = "Data de criação: " + digital.datCriacao, TextColor = Color.Black, FontSize = 16 });
                
                
               var btnDeletar = new BotaoDigital()
               {
                        Text = "Deletar", 
                        ID = digital.id,
                        Nome = digital.nome,
                        datCriacao = digital.datCriacao,
                        CornerRadius = 5,
                        BackgroundColor = Color.FromHex("#5A5050"),
                        TextColor = Color.FromHex("#E5EEC7")
               };

                btnDeletar.Clicked += BtnDeletar_Clicked;

                stackBotoes.Children.Add(btnDeletar);


               

                layoutPrincipal.Children.Add(stackUsuarios);
                layoutPrincipal.Children.Add(stackBotoes);
                layoutPrincipal.Children.Add(new BoxView { Color = Color.Black, HeightRequest = 1, HorizontalOptions = LayoutOptions.FillAndExpand });
            }
            Content = new ScrollView { Content = layoutPrincipal, BackgroundColor = Color.FromHex("#E5EEC7") , Padding = 20};
            
        }


        private void BtnDeletar_Clicked(object sender, EventArgs e)
        {
            BotaoDigital btn = sender as BotaoDigital;

            serializarDigitais.ExcluirUsuario(btn.ID);

            cliente.ConectarServidor();
            cliente.Enviar2(DateTime.Now, 12, btn.ID.ToString(), true, false);

            cliente.FecharServidor();

            DisplayAlert("Sucesso", "Digital excluida com sucesso", "OK");
        }

        public class BotaoDigital : Button
        {
            public string Nome;
            public int ID;
            public DateTime datCriacao;

        }

        private void MenuItemApagar_OnClicked(object sender, EventArgs e)
        {
            

            
        }
    }
}