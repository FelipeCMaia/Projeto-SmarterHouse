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
    public partial class Pagina_RotinaGeralCortinas : ContentPage
    {
        Cliente cliente = new Cliente();
        bool[] acao = new bool[15];

       // List<Pacote> lista_de_retorno = new List<Pacote>();

        public Pagina_RotinaGeralCortinas(List<Pacote> lista, List<Pacote> lista_tarefas)
        {
            InitializeComponent();

            acao = cliente.MudarAcao(lista);

            foreach (var item in lista_tarefas)
            {
                if (item.Id_Modulo == 7)
                {
                    item.Temperatura = "Cortina";
                }
            }

            listview.ItemsSource=cliente.ListarTarefas(lista_tarefas, 7);

        }

        private void definir_clicked(object sender, EventArgs e)
        {
            if (acao[3])
            {
                acao[3] = false;
            }
            else
            {
                acao[3] = true;
            }

            string data = DateTime.Now.Date.ToShortDateString();

            string tempo = _timepicker.Time.ToString();

            string horario = data + " " + tempo;

            DateTime _horario1 = Convert.ToDateTime(horario);


            string data2 = DateTime.Now.Date.ToShortDateString();

            string tempo2 = _timepicker.Time.ToString();

            string horario2 = data2 + " " + tempo2;

            DateTime _horario2 = Convert.ToDateTime(horario2);



            switch (Cortina_Picker.SelectedIndex)
            {
                case 0:
                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 7, "Abrir", acao[3], true);
                    
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 7, "Fechar", acao[3], true);
                    
                    cliente.FecharServidor();
                    break;

                case 1:
                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario1, 7, "Abrir", acao[3], true);
                    
                    cliente.FecharServidor();

                    cliente.ConectarServidor();
                    cliente.Enviar2(_horario2, 7, "Fechar", acao[3], true);
                    
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