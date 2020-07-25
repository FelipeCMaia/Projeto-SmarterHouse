<?php require_once ('../classes/components.php');
  $comp = new component;
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
  <link rel="stylesheet" type="text/css" href="../css/aos.css" >

  <script type="text/javascript" type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/aos.js"></script>

</head>

<body >


  <!-- HEADER -->
  <?php $comp->Header();?>
  <!-- END OF HEADER -->

  <!-- BUTTON TOP-UP -->
  <div data-magellan class="div_voltar_topo" data-aos="fade-up"
      data-aos-duration="600" data-aos-anchor-placement="top-center">
    <a href="#download" class="button secondary hollow large topo">Topo</a>

  </div>
  <!-- END OF BUTTO TOP-UP -->


  <!-- BODY OF SITE -->
  <div class="cell medium-7 large-7 auto body_site">

    <!-- BEGIN OF SECTIONS -->
    <div class="sections">

     
      <!-- SECTION ABOUT PARTNERS -->
      <section id="download" data-magellan-target="download"></section>
      
      <!-- PARALLAX -->
      <div class="medium-12 cell parallax-verde ">

        <div class="medium-12 large-12 cell titulo_parallax_verde" data-aos="fade-left"
          data-aos-duration="1000" data-aos-anchor-placement="bottom-bottom">DOWNLOAD</div>
      </div>

      <!-- LINE OUT OF PARALAX--ABOUT PARTNERS -->
      <div class="medium-12 cell div_out_parallax">
       
          <div class="grid-x grid-padding-x div_aux_grid_parallax">

            <div class="cell medium-1 large-1 small-12 "></div>

            <div class="cell auto medium-8 medium-offset-1 small-12 large-4 div_imagem_info"
             data-aos="fade-right" data-aos-duration="900"
              data-aos-anchor-placement="center-bottom">

              <img src="../img/smartphone.png" class="imagem_download_info" >

            </div>
             
               <!-- linha vertical e horizontal -->
              <div class="vl" data-aos="fade-down"
              data-aos-anchor-placement="bottom-bottom" data-aos-duration="900"></div>

              
            <div class="cell medium-12 large-4 small-12 ">
              <div >
                <div class="cell small-12 medium-12 large-12 div_info_texto">
                </div>
                <div data-aos="fade-up"
                data-aos-anchor-placement="bottom-bottom" data-aos-duration="900" >
                <h4 class="info_texto"  >
                  <p>Faça o Cadastro ou Login em nosso sistema pelo Site ou
                    Celular e compre nosso plano de automação</p>
                </h4>
                  
                <div class="cell medium-12"  data-aos="fade-right"
                data-aos-anchor-placement="center-bottom" data-aos-duration="900">
                <a href="../paginas/login_cadastro"> <button type="submit" class="button custom">Cadastre-se aqui</button></a>
                </div>
              </div>
                <div data-aos="fade-right"
                data-aos-anchor-placement="center-bottom" data-aos-duration="900">
                <h4 class="info_texto" >
                  <p>Para Utilizar os serviços disponíveis em nossa aplicação, é necessário ter adquirido nosso plano de automação.</p>
                </h4>
                
                <div class="cell medium-12" data-magellan>
                <a href="../index#plans"> <button type="submit" class="button rosa" >Plano de automação</button></a>
                </div>
              </div>
              <div data-aos="fade-right"
              data-aos-anchor-placement="center-bottom" data-aos-duration="900">
                <h4 class="info_texto" data-aos="fade-left"
                data-aos-anchor-placement="center-bottom" data-aos-duration="900">
                  <p>Já Adquiriu nosso plano de automação?</p>
                </h4>
                
                <div class="cell medium-12" data-magellan>
                <a href="../file/samples1.exe" download="">  <button type="submit" class="button custom">Download Smarterhouse</button></a>
                </div>
                  </div>
              </div>
            </div>
         
        </div>

      </div>
      <!-- END OF LINE OUT PARALAX--ABOUT PARTNERS -->

     

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
  <!-- Compressed JavaScript -->
  <script type="text/javascript" src="../js/vendor/jquery.js"></script>
    <script type="text/javascript" src="../js/vendor/what-input.js"></script>
    <script type="text/javascript" src="../js/vendor/foundation.min.js"></script>
  <script> $(document).foundation();</script>
</body>

</html>