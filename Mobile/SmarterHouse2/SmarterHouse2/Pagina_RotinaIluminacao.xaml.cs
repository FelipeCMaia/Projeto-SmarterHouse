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
    public partial class Pagina_RotinaIluminacao : ContentPage
    {
        Cliente cliente = new Cliente();
        bool acao = true;
        List<Pacote> lista1 = new List<Pacote>();
        List<Pacote> lista2 = new List<Pacote>();

        public Pagina_RotinaIluminacao(List<Pacote> lista, List<Pacote> lista_tarefas)
        {
            InitializeComponent();

            foreach (var item in lista_tarefas)
            {
                if(item.Id_Modulo == 1)
                {
                    item.Temperatura = "Lâmpada 1";
                }
                else if(item.Id_Modulo == 2)
                {
                    item.Temperatura = "Lâmpada 2";
                }
            }

            lista1 = cliente.ListarTarefas(lista_tarefas, 1);

            lista2 = cliente.ListarTarefas(lista_tarefas, 2);
 

            listview.ItemsSource = lista2;
        }


        private void DefinirRotina_Clicked(object sender, EventArgs e)
        {
            string data = DateTime.Now.Date.ToShortDateString();

            string tempo = _timepicker.Time.ToString();

            string horario = data + " " + tempo;

            DateTime _horario1 = Convert.ToDateTime(horario);


            string data2 = DateTime.Now.Date.ToShortDateString();

            string tempo2 = _timepicker.Time.ToString();

            string horario2 = data2 + " " + tempo2;

            DateTime _horario2 = Convert.ToDateTime(horario2);

            

            switch (Lampada_Picker.SelectedIndex)
            {
                case 0:
                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 1, "Abrir", true, true);
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 1, "Fechar", false, true);
                    cliente.FecharServidor();
                    break;

                case 1:
                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 2, "Abrir", true, true);
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 2, "Fechar", false, true);
                    cliente.FecharServidor();
                    break;

                case 2:
                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 1, "Abrir", true, true);
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 1, "Fechar", false, true);
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 2, "Abrir", true, true);
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 2, "Fechar", false, true);
                    cliente.FecharServidor();
                    break;

            }
        }

        private void MenuItem_Clicked(object sender, EventArgs e)
        {
            var mi = (MenuItem)sender;
            var pacote = (Pacote)mi.CommandParameter;

            cliente.Enviar2(pacote.Horario, pacote.Id_Modulo, "Remover", false, false);
        }
    }
}