<?php session_start();
require_once('../classes/components.php');
$comp = new component;
if (!isset($_GET['model-graph'])) {
  $_GET['model-graph'] = 2;
};

if (!isset($_SESSION['id_user'])) {
  header('location: login_cadastro');
} else {
  ?>

  <!doctype html>
  <html class="no-js" lang="pt-br" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <title>Smarterhouse</title>
    <link rel="stylesheet" type="text/css" href="../css/foundation.css">
    <link rel="stylesheet" type="text/css" href="../css/styles_login_cad.css" />
    <link rel="stylesheet" type="text/css" href="../css/components_for_all_pages.css" />
    <link rel="stylesheet" type="text/css" href="../css/foundation-icons/foundation-icons.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_components.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_index.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_download.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_pagina_usuario.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_loading.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/chart.js"></script>
    <script type="text/javascript" src="../js/Chart.min.js"></script>

    <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> -->
    <link href="../css/aos.css" rel="stylesheet">
    <script src="../js/aos.js"></script>

  </head>

  <body>

    <style>
    
    </style>

    <div class="grid-x grid-margin-x" id="loading">
      <div class="div_escuro" id="div_escuro">
        <div class="div_loading">
          <div class="parede">
            <div class="porta"></div>
            <div class="janela"></div>
          </div>
          <div class="teto">
            <div class="inside"></div>
          </div>
          <div class="chamine"></div>
          <div class="fumaca_1" id="fumaca_1"></div>
          <div class="fumaca_2"></div>
          <div class="fumaca_3"></div>
          <div class="div_base_casa"></div>
          <div class="folha"></div>
          <div class="folha2"></div>
        </div>

      </div>
    </div>



    <!-- BODY OF SITE -->
    <div class="cell medium-12 large-12 auto body_site auto">
      <div class="grid-x grid-padding-x altura_body">

        <!-- parte do menu topo mobile -->
        <div class="show-for-small-only small-12 ">
          <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
            <div class="title-bar-title cor_menu_opc">Menu </div>

            <div class="title-bar-right ">
              <p class="titulo_taghome">TagHome <?php echo  $_SESSION['tag_casa'] ?></p></a>
            </div>
          </div>

          <div class="top-bar bg_dark" id="responsive-menu">
            <div class="top-bar-left bg_dark">
              <ul class="dropdown menu bg_dark " data-dropdown-menu>
                <li><a href="../index">Home</a></li>
                <li class="has-submenu cor_branca bg_btn_mod">
                  <a class=" bg_btn_mod" href="#0">Módulos</a>
                  <ul class="submenu menu vertical bg_dark" data-submenu>
                    <!-- <li><a href="pagina_usuario?model-graph=1" onclick="">Portão</a></li> -->
                    <li><a href="pagina_usuario?model-graph=2">Iluminação</a></li>
                    <li><a href="pagina_usuario?model-graph=3">ventilação</a></li>
                    <li><a href="pagina_usuario?model-graph=4">cortina</a></li>
                    <!-- <li><a href="pagina_usuario?model-graph=5">porta</a></li> -->
                  </ul>
                </li>
                <li><a href="manager_user">Gerenciar Contas</a></li>
                <div class="direita">
                  <li><a href="../action/sair">Logout</a></li>
                </div>
              </ul>
            </div>
          </div>
        </div>
        <!-- ############# -->

        <!-- Parte que vai ficar embaixo do menu lateral para colidir com o resto a direita -->
        <div class="medium-4 large-3  cell body_site hide-for-small-only fake_menu_lateral">

        </div>


        <!-- parte do menu lateral -->

        <div class="medium-4 large-3  cell body_site hide-for-small-only lateral_menu custom-scroll menu_lateral">

          <div class="grid-x grid-padding-x modo_flex">

            <div class="medium-12 large-12 cell info_user">
              <p class="nome_user">Bem Vindo <?php echo $_SESSION['nome_usuario']; ?></p>
              <p class="taghome">TagHome <?php echo  $_SESSION['tag_casa'] ?></p>
            </div>

            <ul class="vertical menu drilldown">


              <!-- <li><a href="pagina_usuario?model-graph=1" onclick="">Módulos de Portão</a></li> -->
              <li><a href="pagina_usuario?model-graph=2">Módulos de Iluminação</a></li>
              <li><a href="pagina_usuario?model-graph=3">Módulos de Ventilação</a></li>
              <li><a href="pagina_usuario?model-graph=4">Módulos de Cortina</a></li>
              <!-- <li><a href="pagina_usuario?model-graph=5">Módulos de Porta</a></li> -->
              <li><a href="manager_user">Gerenciar Contas</a></li>
              <li><a href="../index">Home</a></li>
              <li><a href="../action/sair">Logout</a></li>
            </ul>
          </div>
        </div>
        <!-- ############# -->
        
        <!-- parte dos módulos do site  -->
        <div class="medium-8 large-9  cell body_site body_modulos">
          <div class="grid-x grid-padding-x largura_corpo">

            <div class="medium-12  large-12 cell graph_casa container_grafico" 
            data-num-casa="<?php echo  $_SESSION['id_user'] ?>" data-token="<?php echo $_SESSION['token'] ?>"
             data-refresh-token="<?php echo $_SESSION['refresh_token'] ?>">

              <div class="grid-y ">
                <div class="medium-6  large-6 cell div_grafico chart-container" id="chart-container" data-model-graph="<?php echo $_GET['model-graph'] ?>" >
                  <canvas class="line-chart-rounded  mycanvas dimensao_grafico" id="mycanvas" data-type-graph="tempo" >

                  </canvas>
                </div>
                <div class="medium-6  large-6 cell div_grafico chart-container" id="chart-container" data-model-graph="<?php echo $_GET['model-graph'] ?>" >
                  <canvas class="line-chart-rounded  mycanvas dimensao_grafico" id="mycanvas2" data-type-graph="vezesligado" >

                  </canvas>

                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- ############# -->
      </div>


    </div>
    <!-- END OF BODY -->

    <script>
      AOS.init();
    </script>
    <!-- Compressed JavaScript -->
    <script type="text/javascript" src="../js/vendor/foundation.min.js"></script>
    <script type="text/javascript" src="../js/vendor/jquery.js"></script>
    <script type="text/javascript" src="../js/vendor/what-input.js"></script>
    <script type="text/javascript" src="../js/vendor/foundation.js"></script>
    <script>
      $(document).foundation();
    </script>
    <script type="text/javascript" src="../js/moment.min.js"></script>

  </body>

  </html>
<?php } ?>