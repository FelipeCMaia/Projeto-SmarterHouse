try {


    $(document).ready(function () {

        $(document).on({

            ajaxStart: function () { setTimeout(function () { AtivaClick(); }, 3000); },
            ajaxStop: function () { setTimeout(function () { DesativaClick(); }, 3000); }
        });

        var id_user = $('.graph_casa').data('num-casa');
        var token = $('.graph_casa').data('token');
        var refresh_token = $('.graph_casa').data('refresh-token');

        $('.graph_casa').removeAttr('data-refresh-token')
        $('.graph_casa').removeAttr('data-token');
        ////console.log(token);
        ////console.log(refresh_token);


        /*variavel que recebe a quantidade de gráficos (canvas)
         com ao tipo de dado do gráfico sendo tempo*/
        var num_graficos_tempo = [];

        /*variavel que recebe a quantidade de gráficos (canvas)
        com ao tipo de dado do gráfico sendo as vezes ligadas */
        var num_graficos_vezesligados = [];

        //verifica qual o número do módulo que o container irá pegar os dados
        if ($('.chart-container').data('model-graph') > 0 && $('.chart-container').data('model-graph') < 7) {
            var tipo_grafico = $('.chart-container').data('model-graph');
            ////console.log(tipo_grafico);
        }
        else {
            ////console.log("VALOR PARA MÒDULO INVÀLIDO");

        }

        /*O código abaixo pega a quantidade de gráficos dentro
         do container dividindo-so entre gráficos do com dados
        de tempo e gráficos com dados de vezesligadas 
        */
        $('.chart-container .mycanvas').each(function () {
            /*verifica se um gráfico dentro do container 
            tem seus dados setados como tempo ou vezesligadas*/
            if ($(this).data('type-graph') == "tempo") {
                num_graficos_tempo.push($(this).attr('id'));
            }
            else if ($(this).data('type-graph') == "vezesligado") {
                num_graficos_vezesligados.push($(this).attr('id'));
            }

        })

        /*variável global usada para auxiliar a passagem
         de valor dos ids de cada módulo entre as funções*/
        var global = [];

        //variáveis para os gráficos do tipo tempo e do tipo vezesligadas
        var barGraph_tempo = [], barGraph_vezesligados = [];

        //passando os valrores dos ids para a variável global
        global = pega_id_modulos();

        //declarando array rgb que vai receber as cores
        var rgb = [];
        // rgb =['104, 148, 155',
        // '161, 94, 107',
        // '152, 179, 154',
        // '138, 206, 90',
        // '131, 109, 112',]; 
        /*gerando as cores para os gráficos com base na
         quantidade de gráfico que tem no banco de dados*/
        gera_cores(rgb, global, tipo_grafico);

        //Criando o gráfico de tempo e o de vezes ligadas
        cria_grafico_tempo();
        cria_grafico_vezesligadas();




        //método que verifica se existe algum dado novo no banco de dados a cada 5 segundos
        setInterval(function () {

            //Chama o método que Atualiza os Dados baseando nos valores do banco de dados
            attData();

        }, 180000 //3 minutos de intervalo de execução
        )

        async function AtivaClick() {
            $('#loading').show();
            // var a =  document.getElementById("loading").style;
            // a.display = "block";
        }
        async function DesativaClick() {
            $('#loading').hide();
            // var a =  document.getElementById("loading").style;
            // a.display = "none";
        }

        function cria_grafico_tempo() {

            $.ajax({

                //Seleciona todos os dados referentes ao tipo do gráfico 

                url: "http://localhost/smarterapi/v1/grafico/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: true,
                /*caso ocorra tudo certo so códigos a seguir irão passar os valores recebidos
                 para o gráfico */

                success: function (data) {

                    //método para pegar a quantidade de elementos que tem em um objeto
                    Object.size = function (data) {
                        var size = 0, key;
                        for (key in data) {
                            if (data.hasOwnProperty(key)) size++;
                        }
                        return size;
                    }
                        ;

                    //declarando variáveis para pegar os valores selecionados do banco de dados
                    var dia = {};
                    var tempo = {};
                    var id = {};

                    dia.dias = new Array();
                    tempo.tempos = new Array();

                    id.ids = [];
                    aux_labels = [];
                    recebe_label = [];

                    //passando os valores das labels para a variável recebe_label
                    recebe_label.push(pega_labels_banco());

                    //pegando a quantidade de datas que tem em labels 
                    var tamanho = Object.size(recebe_label[0]);

                    //pegando o tamanho minimo que cada módulo repete   
                    var tamanho_data = min_quant_dados_graf();

                    /*recebe as ultimas 10 labels da base de dados se a
                     quantidade de datas no banco de dados for maior que 10*/
                    if (tamanho > 10) {
                        for (var o = tamanho - 10; o < tamanho; o++) {
                            aux_labels.push(recebe_label[0][o]);
                        }
                        aux = [];
                        ////console.log(data[0].id_mod.nome_mod);
                        //função que pega o id dos módulos e passa para a variável Global
                        pega_id_modulos();

                        /*pega os valores de tempo onde os id do banco de 
                        dados forem iguais aos ids da variável global*/
                        for (var a in global) {
                            for (var i = Object.size(data) - (10 * (Object.size(global))); i < Object.size(data); i++) {
                                ////console.log(data[i].id_mod.id_mod_numb + " == " + global[a]);
                                if ((data[i].id_mod.id_mod_numb == global[a])) {
                                    aux.push(data[i].id_mod[0].tempo);
                                }
                            }

                            //passa os valores recebidos de aux para um array tempos
                            tempo.tempos[a] = aux;

                            aux = new Array();
                        }
                    }
                    /*Se o tamanho não for maior que 10, 
                    não haveerá necessidade de limitar os índices de labels*/
                    else {
                        ////console.log(data[0].id_mod.nome_mod);
                        //recebe os valroes de labels
                        for (var o = tamanho - tamanho_data; o < tamanho; o++) {
                            aux_labels.push(Date_US_BR(recebe_label[0][o]));
                        }

                        aux = [];

                        //pega os valores dos id e passa para a variável global
                        pega_id_modulos();
                        ////console.log(global);

                        /*pega os valores de tempo onde os id do banco de 
                       dados forem iguais aos ids da variável global*/
                        for (var a in global) {

                            for (var i = 0; i < Object.size(data); i++) {
                                ////console.log(data[i].id_mod.id_mod_numb + " == " + global[a]);
                                if ((data[i].id_mod.id_mod_numb == global[a])) {
                                    aux.push(data[i].id_mod[0].tempo);
                                }
                            }
                            //passa o valor recebido de aux para o array tempos
                            tempo.tempos[a] = aux;
                            aux = new Array();
                        }
                        ////console.log(tempo);
                    }
                    //passa o valor do array auxiliar de labels para o array dias
                    dia.dias = aux_labels;

                    //passando o valor do tamanho inicial do objeto data para uma variável auxiliar
                    tamanho_before = Object.size(data);
                    //decalraa um vetor para comportar as criação de masi de 1 elemento
                    var Elementos = [];
                    var k = 0;

                    //cria os elementos dos gráficos e passa os valores para o array Elementos
                    for (k = 0; k < Object.size(global); k++) {

                        var r = Math.floor((Math.random() * 255) + 1);
                        var g = Math.floor((Math.random() * 255) + 1);
                        var b = Math.floor((Math.random() * 255) + 1);

                        //console.log(rgb[k]);
                        Elementos[k] = {
                            label: "Atividade Diária - Módulo " + data[0].id_mod.nome_mod + " " + global[k],
                            color: 'rgb(' + rgb[k] + ')',
                            backgroundColor: 'rgb(' + rgb[k] + ')',
                            borderColor: 'rgb(' + rgb[k] + ')',
                            fill: false,
                            //passando os valores da quantidade de horas para os dados de cada label(linha33)
                            data: tempo.tempos[k]
                        };
                    }

                    //criando o gráfico com os dados do banco de dados
                    var chartdata = {

                        //passando o valor dos dias para as labels abaixo do gráfico
                        labels: dia.dias,

                        //passando os valores de tempos para o gráfico
                        datasets: Elementos
                    };

                    //vetor ctx conterá mais de um contexto para diferentes gráficos
                    var ctx = [];

                    //passando os valores de cada id para o vetor ctx
                    for (var i = 0; i < Object.size(num_graficos_tempo); i++) {
                        ////console.log(num_graficos_tempo[i]);
                        ctx[i] = num_graficos_tempo[i];

                    }
                    ////console.log(ctx);


                    //criando o gráfico
                    for (var i = 0; i < Object.size(num_graficos_tempo); i++) {
                        barGraph_tempo[i] = new Chart(ctx[i], {
                            //definindo o tipo do gráfico
                            type: 'bar',

                            //passando o valor dos dádos do gráfico
                            data: chartdata,

                            //definindo propriedades para o gráfico em geral
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                title: {
                                    display: true,
                                    text: 'Tempo de atividade dos módulos ' + data[0].id_mod.nome_mod,
                                    fontSize: 20
                                },
                                //configurações para os títulos dos módulos
                                legend: {
                                    labels: {
                                        fontColor: '#5B5151',
                                        fontSize: 15,
                                        fontFamily: 'Verdana'
                                    }
                                },
                                scales: {
                                    //configurações para o Eixo X do gráfico (eixo horizontal)
                                    yAxes: [{
                                        gridLines: { color: "#5B5151" },
                                        ticks: {
                                            fontColor: '#5B5151',
                                            beginAtZero: true,
                                            userCallback: function (v) { return convert_to_data(v) },
                                            stepSize: 30 * 120,
                                            fontSize: 16,

                                        },

                                    }],

                                    //configurações para o Eixo X do gráfico (eixo vertical)
                                    xAxes: [{
                                        gridLines: { color: "#5B5151" },

                                        ticks: {
                                            autoSkip: true,
                                            maxTicksLimit: 8,
                                            fontColor: '#5B5151',
                                            fontSize: 14,
                                            minRotation: 0,
                                            maxRotation: 90,
                                        }
                                    }]

                                },

                                /*definindo as configurações da barra de informação que 
                                aparecerá quando o mouse estiver sobre o gráfico*/
                                tooltips: {
                                    titleFontSize: 14,
                                    bodyFontSize: 14,
                                    intersect: false,
                                    mode: 'index',
                                    backgroundColor: 'rgba(91, 81, 80,.7)',
                                    caretPadding: 20,
                                    borderWidth: 2,
                                    borderColor: 'rgba(81, 71, 70,.7)',
                                    multiKeyBackground: 'rgba(86, 123, 131,1)',
                                    footerFontColor: 'rgba(91, 81, 80,.7)',
                                    titleFontColor: '#E7F0C3',
                                    bodyFontColor: '#E7F0C3',
                                    callbacks: {
                                        label: function (tooltipItem, data) {
                                            return data.datasets[tooltipItem.datasetIndex].label + ': ' + convert_to_data(tooltipItem.yLabel)
                                        }
                                    }
                                }

                            }
                        });
                    }


                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                },


            });
        }

        //método semelhante ao Cria_grafico_tempo, fireindo apenas da requisição do dado no banco de dados
        function cria_grafico_vezesligadas() {
            $.ajax({
                //chamando o link com do select em php
                url: "http://localhost/smarterapi/v1/grafico/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: false,
                /*caso ocorra tudo certo o código a seguir irá passar os valores recebidos
                 para o gráfico */
                success: function (data) {

                    //método para pegar a quantidade de elementos que tem no objeto 'data'
                    Object.size = function (data) {
                        var size = 0, key;
                        for (key in data) {
                            if (data.hasOwnProperty(key)) size++;
                        }
                        return size;
                    };

                    //declarando variáveis para pegar os valores selecionados do banco de dados
                    var dia = {};
                    var vezes = {};
                    var id = {};

                    dia.dias = new Array();
                    vezes.ligadas = new Array();

                    id.ids = [];
                    aux_labels = [];
                    recebe_label = [];

                    recebe_label.push(pega_labels_banco());
                    var tamanho = Object.size(recebe_label[0]);
                    var tamanho_data = min_quant_dados_graf();


                    if (tamanho > 10) {
                        for (var o = tamanho - 10; o < tamanho; o++) {
                            aux_labels.push(recebe_label[0][o]);
                        }
                        aux = [];
                        pega_id_modulos();

                        //GERA OS VALORES DE CADA MÒDULO Randomicamente
                        for (var a in global) {
                            //aqui o Object Size deverá SER o tamanho do menor elemento repetido do id_mod
                            for (var i = Object.size(data) - (10 * (Object.size(global))); i < Object.size(data); i++) {
                                if ((data[i].id_mod.id_mod_numb == global[a])) {
                                    aux.push(data[i].id_mod[0].vezes_ligadas);
                                }
                            }
                            vezes.ligadas[a] = aux;
                            aux = new Array();
                        }
                    }
                    else {
                        for (var o = tamanho - tamanho_data; o < tamanho; o++) {
                            aux_labels.push(Date_US_BR(recebe_label[0][o]));
                        }
                   
                        ////console.log(aux_labels);
                        aux = [];

                        pega_id_modulos();
                        ////console.log(data);
                        //GERA OS VALORES DE CADA MÒDULO Randomicamente
                        for (var a in global) {
                            //aqui o Object Size deverá SER o tamanho do menor elemento repetido do id_mod
                            for (var i = 0; i < Object.size(data); i++) {
                                if ((data[i].id_mod.id_mod_numb == global[a])) {
                                    aux.push(data[i].id_mod[0].vezes_ligadas);
                                }
                            }
                            vezes.ligadas[a] = aux;
                            aux = new Array();
                        }

                    }
                    dia.dias = aux_labels;
                    //passando o valor do tamanho inicial do objeto data para uma variável auxiliar
                    tamanho_before = Object.size(data);
                    var Elementos = [];
                    var k = 0;

                   
                    for (k = 0; k < Object.size(global); k++) {

                        var r = Math.floor((Math.random() * 255) + 1);
                        var g = Math.floor((Math.random() * 255) + 1);
                        var b = Math.floor((Math.random() * 255) + 1);
                        Elementos[k] = {
                            label: "Vezes Ligadas- Módulo " + data[0].id_mod.nome_mod + " " + global[k],
                            color: 'rgb(' + rgb[k] + ')',
                            backgroundColor: 'rgb(' + rgb[k] + ')',
                            borderColor: 'rgb(' + rgb[k] + ')',
                            fill: false,
                            //passando os valores da quantidade de horas para os dados de cada label(linha33)
                            data: vezes.ligadas[k]
                        };
                    }
                   
                    //criando o gráfico com os dados do banco de dados
                    var chartdata = {
                        //passando o valor dos dias para as labels abaixo do gráfico
                        labels: dia.dias,

                        //defindo propriedades para o gráfico 
                        datasets: Elementos
                    };

                    var ctx = [];
                    //declarando uma variável com o id do canvas que irá receber o gráfico

                    // ctx[0]= $("#mycanvas");
                    // ctx[1]= $("#mycanvas2");

                    for (var i = 0; i < Object.size(num_graficos_vezesligados); i++) {
                        ////console.log(num_graficos_vezesligados[i]);
                        ctx[i] = num_graficos_vezesligados[i];

                    }
                    ////console.log(ctx);
                    //criando o gráfico
                    for (var i = 0; i < Object.size(num_graficos_vezesligados); i++) {
                        barGraph_vezesligados[i] = new Chart(ctx[i], {
                            //definindo o tipo do gráfico
                            type: 'bar',

                            //passando o valor dos dádos do gráfico
                            data: chartdata,

                            //definindo propriedades para o gráfico em geral
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                title: {
                                    display: true,
                                    text: 'Quantidade de vezes Ligado módulos ' + data[0].id_mod.nome_mod,
                                    fontSize: 20
                                },
                                //configurações para os títulos dos módulos
                                legend: {
                                    labels: {
                                        fontColor: '#5B5151',
                                        fontSize: 15,
                                        fontFamily: 'Verdana'
                                    }
                                },
                                scales: {
                                    //configurações para o Eixo X do gráfico (eixo horizontal)
                                    yAxes: [{
                                        gridLines: { color: "#5B5151" },
                                        ticks: {
                                            fontColor: '#5B5151',
                                            beginAtZero: true,

                                            stepSize: 5,
                                            fontSize: 16,

                                        },

                                    }],

                                    //configurações para o Eixo X do gráfico (eixo vertical)
                                    xAxes: [{
                                        gridLines: { color: "#5B5151" },

                                        ticks: {
                                            fontColor: '#5B5151',
                                            fontSize: 14,
                                            minRotation: 0,
                                            maxRotation: 90,
                                        },
                                    }]
                                },

                                /*definindo as configurações da barra de informação que 
                                aparecerá quando o mouse estiver sobre o gráfico*/
                                tooltips: {
                                    titleFontSize: 14,
                                    bodyFontSize: 14,
                                    intersect: false,
                                    mode: 'index',
                                    backgroundColor: 'rgba(91, 81, 80,.7)',
                                    caretPadding: 20,
                                    borderWidth: 2,
                                    borderColor: 'rgba(81, 71, 70,.7)',
                                    multiKeyBackground: 'rgba(86, 123, 131,1)',
                                    footerFontColor: 'rgba(91, 81, 80,.7)',
                                    titleFontColor: '#E7F0C3',
                                    bodyFontColor: '#E7F0C3',
                                    
                                    
                                    
                                }
                            }
                        });
                    }

                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                }

            });
        }

        //método que atualiza os dados do grafico
        function attData() {

            $.ajax({
                //pega os valores atuais no banco de dados


                url: "http://localhost/smarterapi/v1/grafico/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: true,
                success: function (data) {
                    //declara variáveis para o controle de dados distintos do banco de dados
                    var dia = {};
                    var tempo = {};
                    var id = {};

                    dia.dias = new Array();
                    tempo.tempos = new Array();
                    id.ids = [];

                    Object.size = function (data) {
                        var size = 0, key;
                        for (key in data) {
                            if (data.hasOwnProperty(key)) size++;
                        }
                        return size;
                    };

                    //define o valor de outra variável de controle
                    //com o tamanho mais atual do banco de dados
                    tamanho_after = Object.size(data);


                    aux_labels = [];
                    recebe_label = [];
                    //pega os valores atuais das labels no banco de dados
                    recebe_label.push(pega_labels_banco());
                    var tamanho = Object.size(recebe_label[0]);

                    ////console.log(tamanho);
                    //verifica se o tamanho do objeto que recebeu as labels é maior que 10
                    if (tamanho > 10) {

                        //se for maior que 10, pega os ultimos 10 elementos
                        for (var o = tamanho - 10; o < tamanho; o++) {
                            aux_labels.push(recebe_label[0][o]);
                        }
                    }
                    else {
                        /*se o tamnaho for menor que 10 não haverá necessidade
                         de controlar a quantidade de itens no gráfico*/
                        for (var o = 0; o < tamanho; o++) {
                            aux_labels.push(recebe_label[0][o]);
                        }
                    }

                    /*Verifica se o tamanho dos dados depois dos 5 segundos e 
                    maior que o tamanho dos dados antes dos 5 segundos*/
                    // removeData(barGraph_tempo);removeData(barGraph_vezesligados);
                    if ((tamanho_after != tamanho_before)) {
                        /*se o tamanho for maior que 10, remove o primeiro item
                         do gráfico na hora da atualização*/
                        if (tamanho > 10) {
                            removeData(barGraph_tempo);
                            removeData(barGraph_vezesligados);
                        }
                        //pega os valores mais recente do banco de dados
                        global = pega_id_modulos();
                        var data = {};
                        data.dados = [];

                        ////console.log(global);

                        //adiciona os dados para o gráfico de tempo 
                        for (var i in num_graficos_tempo) {
                            addData(barGraph_tempo[i], $(aux_labels).get(-1), data.dados);
                        }

                        //adiciona os dados para o gráfico de vezesligados
                        for (var i in num_graficos_vezesligados) {

                            addData(barGraph_vezesligados[i], $(aux_labels).get(-1), data.dados);
                        }

                        // addData(barGraph2, $(aux_labels).get(-1), data.dados);
                        //igualando as variáveis auxiliares para verificações futuras
                        tamanho_before = tamanho_after;
                    }

                    updateData(aux_labels);
                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    }
                }
            });
        }

        //função para adicionar os dados recebidos no gráfico
        function addData(chart, label, data) {
            //método que retorna o tamanho de um objeto
            Object.size = function (data) {
                var size = 0, key;
                for (key in data) {
                    if (data.hasOwnProperty(key)) size++;
                }
                return size;
            };

            //Inserindo o dia na ultima posição do gráfico
            chart.data.labels.push(label);
            ////console.log(data);
            var i = 0;
            //Inserindo os dados na ultima posição do gráfico baseado no Dia
            chart.data.datasets.forEach((dataset) => {
                dataset.data.push(data[i]);
                i++;
            });

            //atualiza o gráfico com os valores novos 
            chart.update();
        }

        //função que atualiza os dados do gráfico
        function updateData(aux_labels) {

            global = pega_id_modulos();
            ////console.log(global);


            $.ajax({
                //pega os valores no banco de dados dos ids dos módulo
                url: "http://localhost/smarterapi/v1/grafico/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: false,
                success: function (data) {

                    //declara variáveis para recber esse valores 
                    aux_data_tempo = [];
                    aux_data_vezesligados = [];
                    aux_data_dia = [];

                    /*percorre a variável global que contém todos os
                     ids do módulos permitidos para o id passado*/
                    for (var k in global) {

                        //pega os valores de tempo e de vezes ligadas
                        for (var i in data) {
                            if (global[k] == data[i].id_mod.id_mod_numb && $(aux_labels).get(-1) == data[i].id_mod[0].dia) {
                                aux_data_tempo.push(data[i].id_mod[0].tempo);
                                aux_data_vezesligados.push(data[i].id_mod[0].vezes_ligadas);
                            }
                        }
                    }
                    ////console.log(aux_data_vezesligados);

                    var i = 0;

                    for (var i in global) {

                        //insere os valores de aux de tempo no gráfico no gráfico de tempo
                        barGraph_tempo.forEach((barGraph_tempo) => {
                            barGraph_tempo.data.datasets[i].data[barGraph_tempo.data.datasets[i].data.length - 1] = aux_data_tempo[i];

                        });

                        //insere os valores de aux de vezesligadas no gráfico de vezesligadas
                        barGraph_vezesligados.forEach((barGraph_vezesligados) => {
                            barGraph_vezesligados.data.datasets[i].data[barGraph_vezesligados.data.datasets[i].data.length - 1] = aux_data_vezesligados[i];

                        });
                        //barGraph[k].data.datasets[i].data[barGraph.data.datasets[i].data.length - 1] = aux_data_tempo[i];

                        // barGraph2.data.datasets[i].data[barGraph.data.datasets[i].data.length - 1] = aux_data_tempo[i];
                    }
                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                }
            });
            //atualiza os gráficos de tempo
            for (i in num_graficos_tempo) {
                barGraph_tempo[i].update();
            }
            //atualiza os gráficos de vezes ligadas
            for (i in num_graficos_vezesligados) {
                barGraph_vezesligados[i].update();
            }

            // barGraph2.update();

        }

        //função para remover a ultima data do gráfico
        function removeData(chart) {
            //remove Os valores de data e label do PRIMEIRO indice do gráfico (no caso o primeiro da esquerda apra a direita)
            chart[0].data.labels.shift();
            chart[0].data.datasets.forEach((dataset) => {
                dataset.data.shift();
            });
            //atualiza o gráfico
            chart[0].update();
        }

        /*função que pega o id dos modulos baseado num 
        tipo de gráfico expecífico e retorna para uma variável*/
        function pega_id_modulos() {
            var global;
            $.ajax({

                //pega os valores no banco de dados
                url: "http://localhost/smarterapi/v1/grafico/seleciona-modulos/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: false,
                success: function (id_mod) {
                    id_modulo = [];
                    for (var i in id_mod) {
                        id_modulo.push(id_mod[i].id_mod);
                    }
                    global = id_modulo;
                    ////console.log(global);
                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                }
            });
            return global;
        }

        /*método que retorna a quantidade minima que todos os
         gráficos podem aparecer de cada vez no gráfico*/
        function min_quant_dados_graf() {

            var min_quant_dados;
            $.ajax({
                //pega os valores no banco de dados
                //http://localhost/smarterapi/v1/grafico/conta-dados/7/1
                url: "http://localhost/smarterapi/v1/grafico/conta-dados/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: false,
                success: function (contagem_min_dados) {
                    ////console.log(contagem_min_dados);
                    min_quant_dados = contagem_min_dados.quant_elem_grafic;
                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                }
            });
            return min_quant_dados;
        }

        //método que pega todas as labels no banco de dados baseando-se no tipo do gráfico 
        function pega_labels_banco() {
            var labels = [];
            $.ajax({
                //pega os valores no banco de dados
                url: "http://localhost/smarterapi/v1/grafico/seleciona-labels-date/" + id_user + "/" + tipo_grafico,
                method: "GET",
                headers: { "Authorization": 'Bearer ' + token },
                async: false,
                success: function (label) {
                    aux_label = [];
                    for (var i in label) {
                        aux_label.push(label[i].dia_atividade);
                    }
                    labels = aux_label;
                },
                error: function (erro) {
                    if (erro.status == 401) {
                        // ////console.log(v);
                        $.ajax({
                            url: "../action/sair.php",
                            success: function (data) {
                                location.reload();
                            },
                            error: function (erro) { ////console.log("erro");
                                location.reload(true);
                            },

                            async: false,


                        })

                    } else {
                        location.reload(true);
                    }

                }
            });
            return labels;
        }

        //método usado para converter segundos em horas nas labels dos gráficos
        function convert_to_data(epoch) {
            return new Date(epoch * 1000).toISOString().substr(11, 8)
        }

        /*método que gera cores e passa para um array 
        baseando-se na quantidade de módulos contidos na base de dados*/
        function gera_cores(array_cores, quant_modulos, tipo_mod) {
            //gerando as cores dos gráficos
            switch (tipo_mod) {
                case 1: r = 2; g = 105; b = 164;
                    break;
                case 2: r = 0; g = 180; b = 171;
                    break;
                case 3: r = 255; g = 216; b = 50;
                    break;
                case 4: r = 254; g = 124; b = 0;
                    break;
                case 5: r = 248; g = 128; b = 106;
                    break;
                default:
                    break;
            }

            for (var i = 0; i < quant_modulos.length; i++) {

                array_cores[i] = "" + (r + (i * 20)) + "," + (g + (i * 20)) + "," + (b + (i * 20)) + "";

            }
            ////console.log(array_cores);
        }

        function Date_US_BR(data){
            
                            // console.log(recebe_label[0][o].substring(8,10));
                            var ano_p = data.substring(0,4);
                            var mes_p = data.substring(5,7);
                            var dia_p = data.substring(8,10);
                            return datanova = dia_p+"-"+mes_p+"-"+ano_p;
                         
        }
    });

} catch (error) {
    location.reload(true);
}