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
  <link rel="stylesheet" type="text/css" href="../css/styles_contato.css" />
  <link rel="stylesheet" type="text/css" href="../css/placeholder_contato.css" />
  <script type="text/javascript" src="../js/vendor/jquery.js"></script>
  <link type="text/css" href="../css/aos.css" rel="stylesheet">
  <script type="text/javascript" src="../js/aos.js"></script>

</head>

<body>


  <!-- HEADER -->
  <?php $comp->Header();?>
  <!-- END OF HEADER -->

  <!-- BUTTON TOP-UP -->
  <div data-magellan class="div_voltar_topo" data-aos="fade-up"
      data-aos-duration="600" data-aos-anchor-placement="top-center">
    <!-- <a href="#about_us" class="button rosa fi-arrow-up hollow large" style="border-radius: 50px">TOPO</a> -->
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
      <div class="medium-12 cell parallax-rosa "  >

        <div class="medium-12 large-12 cell titulo_parallax_contato" data-aos="fade-left"
          data-aos-duration="1000" data-aos-anchor-placement="bottom-bottom">FALE CONOSCO</div>
      </div>

      <!-- LINE OUT OF PARALAX--ABOUT PARTNERS -->
      <div class="medium-12 cell div_out_parallax_contato">
       
          <div class="grid-x grid-padding-x div_aux_grid_parallax">
              
            <!-- div auxiliar da centralização  -->
            <div class="cell medium-2 large-1 small-12 "></div>

            <!-- div do formulário de contato -->

            <div class="medium-12 large-12 small-12 cell"> 

              <form action="../action/email" class="espaco_top_contato" method="post" data-abide novalidate>
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                      
                        <div class="small-12 medium-1 cell" data-aos="fade-up"
                        data-aos-duration="600" data-aos-anchor-placement="bottom-bottom" data-aos-once="true">
                            <label for="middle-label" class="text-right middle texto_claro alinhamento_esquerda">E-mail</label>
                          </div>
                        <div class="medium-11  cell medium-cell-block-y " data-aos="fade-right"
                        data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                            <label class="">
                                <input type="email" class="cor_campos_contato" name="email_contato" maxlength="50"
                                    placeholder="Insira seu email aqui..." required maxlength="35">
                                <span class="form-error texto_claro" id="example1Error3">
                                    Seu email deve ter um formato válido! <br>EX: exemplo@exemplo.com
                                </span>
                            </label>
                        </div>

                        <div class="small-12 medium-1 cell" data-aos="fade-left"
                        data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                            <label for="middle-label" class="text-right middle texto_claro alinhamento_esquerda">Nome</label>
                          </div>
                        <div class="medium-11    large-centered small-centered  cell" data-aos="fade-up"
                        data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                            <label class="texto_claro">       
                                <input type="text" class="cor_campos_contato" placeholder="Insira seu nome aqui..."
                                    name="nome_contato" required maxlength="40">
                                <span class="form-error texto_claro" id="example1Error3">
                                    Insira seu nome para podermos responder a sua mensagem!
                                </span>
                            </label>

                          
                        </div>
                          <div class="small-12 medium-1 cell" data-aos="fade-down"
                          data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                            <label for="middle-label" class="text-right middle texto_claro alinhamento_esquerda">Assunto</label>
                          </div>
                        <div class="medium-11   large-centered small-centered  cell" data-aos="fade-left"
                        data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                          <label class="texto_claro">
                              <input type="text" class="cor_campos_contato" placeholder="Qual o assunto?"
                                  name="assunto_contato" required maxlength="60">
                              <span class="form-error texto_claro " id="example1Error3">
                                  Informar o assunto é importante para pordemos saber qual o assunto da mensagem.
                              </span>
                          </label>

                        
                      </div>  

                      <div class="small-12 medium-1 cell " data-aos="fade-up"
                      data-aos-duration="600" data-aos-anchor-placement="top-center"  data-aos-once="true">
                          <label for="middle-label" class="text-right middle texto_claro alinhamento_esquerda">Mensagem</label>
                        </div>
                      <div class="medium-11    large-centered small-centered  cell" data-aos="fade-up"
                      data-aos-duration="600" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true" >
                        <label class="texto_claro">
                            
                                <textarea class="campo_mensagem cor_campos_contato"  name="mensagem_contato" required maxlength="400" placeholder="Insira a mensagem que deseja nos enviar aqui..."></textarea>
                                <span class="form-error texto_claro" id="example1Error3">
                                Escreva sua mensagem aqui!
                            </span>
                        </label>

                      
                        <div class="cell medium-12 large-12 small-12 alinhamento_esquerda" data-aos="fade-up"
                        data-aos-duration="900" data-aos-anchor-placement="bottom-bottom"  data-aos-once="true">
                          <button type="submit" class="button rosa" value="Enviar_Mensagem">Enviar Mensagem</button>
                      </div>
                    </div>  

                    </div>
                </div>
            </form>

            </div>

              <!-- div auxiliar da centralização -->
            <div class="cell medium-2 large-1 small-12 "></div>

              
            
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
    <script  type="text/javascript" src="../js/vendor/foundation.min.js"></script>
  <script> $(document).foundation();</script>
</body>

</html>