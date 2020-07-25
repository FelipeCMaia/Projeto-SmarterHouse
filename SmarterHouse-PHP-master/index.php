<?php require_once ('classes/components.php');
  $comp = new component;
?>

<!doctype html>
<html class="no-js" lang="pt-br" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

  <title>Smarterhouse</title>
  <link rel="stylesheet" type="text/css" href="css/foundation.css">
  <link rel="stylesheet" type="text/css" href="css/styles_login_cad.css" />
  <link rel="stylesheet" type="text/css" href="css/styles_pagina_usuario.css" />
  <link rel="stylesheet" type="text/css" href="css/components_for_all_pages.css" />
  <link rel="stylesheet" type="text/css" href="css/foundation-icons/foundation-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/styles_index.css" />
  <link rel="stylesheet" type="text/css" href="css/styles_components.css" />
  <link rel="stylesheet" type="text/css" href="css/aos.css">
  <script type="text/javascript" src="js/vendor/jquery.js"></script>
  <script type="text/javascript" src="js/aos.js"></script>

</head>

<body>

  <!-- tela completa -->

  <!-- HEADER -->
  <?php $comp->HeaderIndex();?>
  <!-- END OF HEADER -->

  <!-- BUTTON TOP-UP -->
  <div data-magellan class="div_voltar_topo" data-aos="fade-up" data-aos-duration="500"
    data-aos-anchor-placement="top-center">
    <a href="#about_us" class="button secondary hollow large topo">Topo</a>

  </div>
  <!-- END OF BUTTON TOP-UP -->


  <!-- BODY OF SITE -->
  <div class="cell medium-7 large-7 auto body_site">

    <!-- BEGIN OF SECTIONS -->
    <div class="sections">

      <!-- SECTION ABOUT US -->
      <section id="about_us" data-magellan-target="about_us"></section>

      <!-- PARALAX -->
      <div class="parallax-amarelo ">

        <div class="cell large-12 div_subtitulo_logo">
          <img src="img/logo_lsolo_dark.png" class="estilo_img_logo">


          <div class="grid-x div_aux_subtitulo_logo">
            <div class="cell large-1 - medium-1 small-1"></div>


            <div class="cell large-10 - medium-10 small-10 subtitulo_logo">O melhor da automação para você</div>

            <div class="cell large-1 - medium-1 small-1"></div>
          </div>
        </div>
      </div>
      <!-- END OF PARALAX -->

      <!--LINE OUT OF PARALAX--ABOUT US -->
      <div class="medium-12 cell div_out_parallax">


        <div class="grid-x grid-padding-x div_aux_grid_parallax">

          <div class="cell medium-1 large-1 small-12 "></div>

          <div class="cell auto medium-10 small-12 large-7 div_imagem_info" data-aos="fade-right"
            data-aos-duration="500" data-aos-anchor-placement="top-center">

            <img src="img/note_smart.png" class="imagem_info">

          </div>

          <div class="cell  medium-12 large-4 small-12 " data-aos="fade-left" data-aos-anchor-placement="top-center"
            data-aos-duration="600">
            <div>
              <div class="cell small-0 medium-12 large-12 div_info_texto"></div>

              <h4 class="info_texto">
                <p>Faça o Cadastro ou Login em nosso sistema pelo Site ou
                  Celular e compre nosso plano de automação</p>
              </h4>

              <div class="cell medium-12">
               <a href="paginas/login_cadastro.php"> <button type="submit" class="button custom">Cadastre-se aqui</button></a>
              </div>
              <h4 class="info_texto">
                <p>É cadastrado mas não tem um plano de automação?</p>
              </h4>
              <div class="cell medium-12" data-magellan>
                <a href="#plans" class="button rosa">Veja nosso plano de automação </a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- END  LINE OUT OF PARALAX-- ABOUT US -->

    <!-- SECTION ABOUT PARTNERS -->
    <section id="parterns" data-magellan-target="parterns"></section>
    <div class="medium-12 cell parallax-verde">

      <div class="medium-12 large-12 cell div_titulo_parallax" data-aos="fade-right"
        data-aos-anchor-placement="top-center">SOBRE NÓS</div>
    </div>

    <!-- LINE OUT OF PARALAX--ABOUT PARTNERS -->
    <div class="medium-12 cell div_out_parallax padding_quem_sms_nos">


      <div class="grid-x grid-padding-x div_aux_grid_parallax">

        <div class="cell small-12 medium-3 large-3 div_img_quem_sms_nos"  data-aos="fade-right"
        data-aos-anchor-placement="bottom-bottom">
          <img class="img_quem_sms_nos" src="img/felipe.jpg" alt="" width="300" height="300">
          <div class="nome_quem_sms_nos">Felipe Domingues Bonfim</div>
          <hr class=" linha_quem_sms_nos">
          <div class="desc_parceiro_quem_sms_nos">Chefe de Desenvolvimento</div>
          <hr class=" linha_quem_sms_nos_hist">
          <div class="historia_parceiro_quem_sms_nos">
            <p>"Uma mente concentrada pode perfurar rochas"</p>
          </div>
        </div>
        <div class="cell small-6 medium-2 large-2 div_img_quem_sms_nos" data-aos="fade-down"
        data-aos-anchor-placement="bottom-bottom">
          <img class="img_quem_sms_nos" src="img/henrique.jpg" alt="" width="300" height="300">
          <div class="nome_quem_sms_nos">Henrique Arnaud</div>
          <hr class=" linha_quem_sms_nos">
          <div class="desc_parceiro_quem_sms_nos">Back-End Mobile</div>
          <hr class=" linha_quem_sms_nos_hist">
          <div class="historia_parceiro_quem_sms_nos">
          <p>"Se a terra fosse plana, ela seria chata"</p>
          </div>
        </div>
        <div class="cell small-6 medium-2 large-2 div_img_quem_sms_nos" data-aos="fade-up"
        data-aos-anchor-placement="bottom-bottom">
          <img class="img_quem_sms_nos" src="img/bigode.jpg" alt="" width="300" height="300">
          <div class="nome_quem_sms_nos">Felipe Cardoso Maia</div>
          <hr class=" linha_quem_sms_nos">
          <div class="desc_parceiro_quem_sms_nos">Back-End Arduino / Chefe de Montagem de Circuitos / Banco de Dados
          </div>
          <hr class=" linha_quem_sms_nos_hist">
          <div class="historia_parceiro_quem_sms_nos">
            <p>"Faça em vida aquilo que a morte não poderá levar"</p>
          </div>
        </div>
        <div class="cell small-6 medium-2 large-2 div_img_quem_sms_nos" data-aos="fade-down"
        data-aos-anchor-placement="bottom-bottom">
          <img class="img_quem_sms_nos" src="img/arthur.jpg" alt="" width="300" height="300">
          <div class="nome_quem_sms_nos">Arthur Lira Bueno</div>
          <hr class=" linha_quem_sms_nos">
          <div class="desc_parceiro_quem_sms_nos">Front-End Mobile</div>
          <hr class=" linha_quem_sms_nos_hist">
          <div class="historia_parceiro_quem_sms_nos">
            <p>"Uma frase vale mais que 1000 palavras. Pena que esse não é o caso."</p>
          </div>
        </div>
        <div class="cell small-6 medium-3 large-3 div_img_quem_sms_nos" data-aos="fade-left"
        data-aos-anchor-placement="bottom-bottom">
          <img class="img_quem_sms_nos" src="img/daniel.jpg" alt="" width="300" height="300">
          <div class="nome_quem_sms_nos">Daniel Izidio de Lima</div>
          <hr class=" linha_quem_sms_nos">
          <div class="desc_parceiro_quem_sms_nos">Front-End Web / Back-End Web / API / Banco de Dados </div>
          <hr class=" linha_quem_sms_nos_hist">
          <div class="historia_parceiro_quem_sms_nos">
            <p>"Deu muito trabalho fazer esse site, pelo amor de DEUS."</p>
          </div>
        </div>



      </div>

    </div>
    <!-- END OF LINE OUT PARALAX--ABOUT PARTNERS -->

    <!-- SECTION CONTRACT PLANS -->
    <section id="plans" data-magellan-target="plans"></section>

    <!-- PARALLAX -->
    <div class="medium-12 cell parallax-rosa">
      <div class="medium-12 large-12 cell div_titulo_parallax" data-aos="fade-left"
        data-aos-anchor-placement="bottom-bottom">PLANOS DE AUTOMAÇÃO</div>

    </div>
    <!-- END OF PARALLAX -->

    <!-- LINE OUT OF PARALAX--CONTRACT PLANS -->
    <div class="medium-12 cell div_out_parallax">


      <div class="grid-x grid-padding-x div_aux_grid_parallax">

        <div class="cell medium-4 large-4 small-12 " data-aos="fade-left"
        data-aos-anchor-placement="bottom-bottom">
          <div class="div_plano">
            <div class="titulo_plano basico">PLANO BASICO</div>
            <div class="texto_plano">Nosso plano basico consinste em menor quantidade de modulos.</div>
            <div class="preco_plano">R$344,56</div>
            <div class="cell medium-12 large-12 " data-magellan>
                <a href="paginas/contato.php"><button type="submit" class="button verde">Pedir Plano</button></a>
            </div>
            
          </div>
        </div>
        <div class="cell medium-4 large-4 small-12 " data-aos="fade-up"
        data-aos-anchor-placement="bottom-bottom">
            <div class="div_plano ">
              <div class="titulo_plano medio">PLANO MÉDIO</div>
              <div class="texto_plano">Nosso plano basico consinste em menor quantidade de modulos.</div>
              <div class="preco_plano">R$450,56</div>
              <div class="cell medium-12" data-magellan>
                  <a href="paginas/contato.php"><button type="submit" class="button azul">Pedir Plano</button></a>
              </div>
            </div>
          </div>
          <div class="cell medium-4 large-4 small-12 " data-aos="fade-down"
          data-aos-anchor-placement="bottom-bottom">
              <div class="div_plano ">
                <div class="titulo_plano avancado">PLANO AVANÇADO</div>
                <div class="texto_plano">Nosso plano basico consinste em menor quantidade de modulos.</div>
                <div class="preco_plano">R$567,56</div>
                <div class="cell medium-12" data-magellan>
                    <a href="paginas/contato.php"><button type="submit" class="button rosado">Pedir Plano</button></a>
                </div>
              </div>
            </div>

      </div>

    </div>
    <!-- END OFLINE OUT OF PARALAX--CONTRACT PLANS-->

  </div>
  <!-- END OF SECTIONS -->
  <!-- Add a Sticky Menu -->

  </div>
  <!-- END OF BODY -->

  <!-- FOOTER -->
  <?php $comp->Footer();?>
  <!-- END OF FOOTER -->


  <script>
    AOS.init();
  </script>
 
    <script type="text/javascript" src="js/vendor/jquery.js"></script>
    <script type="text/javascript" src="js/vendor/what-input.js"></script>
    <script type="text/javascript" src="js/vendor/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
</body>

</html>