<?php

require_once('../classes/components.php');
require_once('../action/criptografia.php');
session_start();
$comp = new component;

$cript = new cript();

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
    <link rel="stylesheet" href="../css/foundation-icons/foundation-icons.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_index.css" />
    <link rel="stylesheet" type="text/css" href="../css/styles_components.css" />
    <script type="text/javascript" src="../js/vendor/jquery.js"></script>
    <script type="text/javascript" src="../js/vendor/foundation.js"></script>

</head>

<body class="">




    <!--Modal Termos de contrato -->

    <div class="reveal grid-x" id="exampleModal11" aria-labelledby="exampleModalHeader11" data-reveal>

        <h2>Política de privacidade para SmarterHouse</h2>
        <p>Todas as suas informações pessoais recolhidas, serão usadas para o ajudar a tornar a sua visita no nosso site o mais produtiva e agradável possível.</p>
        <p>A garantia da confidencialidade dos dados pessoais dos utilizadores do nosso site é importante para o SmarterHouse.</p>
        <p>Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes que usem o SmarterHouse serão tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98).</p>
        <p>A informação pessoal recolhida pode incluir o seu nome, e-mail, número de telefone e/ou telemóvel, morada, data de nascimento e/ou outros.</p>
        <p>O uso do SmarterHouse pressupõe a aceitação deste Acordo de privacidade. A equipa do SmarterHouse reserva-se ao direito de alterar este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política de privacidade com regularidade de forma a estar sempre atualizado.</p>
        <h2>Os anúncios</h2>
        <p>Tal como outros websites, coletamos e utilizamos informação contida nos anúncios. A informação contida nos anúncios, inclui o seu endereço IP (Internet Protocol), o seu ISP (Internet Service Provider, como o Sapo, Clix, ou outro), o browser que utilizou ao visitar o nosso website (como o Internet Explorer ou o Firefox), o tempo da sua visita e que páginas visitou dentro do nosso website.</p>
        <h2>Os Cookies e Web Beacons</h2>
        <p>Utilizamos cookies para armazenar informação, tais como as suas preferências pessoas quando visita o nosso website. Isto poderá incluir um simples popup, ou uma ligação em vários serviços que providenciamos, tais como fóruns.</p>
        <p>Em adição também utilizamos publicidade de terceiros no nosso website para suportar os custos de manutenção. Alguns destes publicitários, poderão utilizar tecnologias como os cookies e/ou web beacons quando publicitam no nosso website, o que fará com que esses publicitários (como o Google através do Google AdSense) também recebam a sua informação pessoal, como o endereço IP, o seu ISP, o seu browser, etc. Esta função é geralmente utilizada para geotargeting (mostrar publicidade de Lisboa apenas aos leitores oriundos de Lisboa por ex.) ou apresentar publicidade direcionada a um tipo de utilizador (como mostrar publicidade de restaurante a um utilizador que visita sites de culinária regularmente, por ex.).</p>
        <p>Você detém o poder de desligar os seus cookies, nas opções do seu browser, ou efetuando alterações nas ferramentas de programas Anti-Virus, como o Norton Internet Security. No entanto, isso poderá alterar a forma como interage com o nosso website, ou outros websites. Isso poderá afetar ou não permitir que faça logins em programas, sites ou fóruns da nossa e de outras redes.</p>
        <h2>Ligações a Sites de terceiros</h2>
        <p>O SmarterHouse possui ligações para outros sites, os quais, a nosso ver, podem conter informações / ferramentas úteis para os nossos visitantes. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a partir do nosso deverá ler a politica de privacidade do mesmo.</p>
        <p>Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.</p>

        <div class="cell medium-6 medium-6 small-6" data-close>
            <button type="button" class="button ">Entendi</button>
        </div>

        <button class="close-button" data-close aria-label="Close Accessible Modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!--#######-->

    <!-- Cabeçalho do SITE-->
    <div class="grid-y medium-grid-frame cabecalho-log-cad">

        <!--Corpo do SITE-->
        <div class="cell medium-auto medium-cell-block-container corpo-light-log-cad">
            <!-- BUTTON TOP-UP -->
            <div data-magellan class="div_voltar_inicio" data-aos="fade-up" data-aos-duration="500" data-aos-anchor-placement="top-center">
                <a href="../index" class="button secondary voltar_inicio hollow large "> <span class="fi-arrow-left hollow font_size"></span></a>

            </div>
            <!-- grid responsavel pela parte do background esquerdo do site -->
            <div class="grid-x grid-padding-x">
                <div class="cell large-7 medium-7 small-12 medium-cell-block-y corpo-dark-log-cad"></div>
                <div class="cell large-5 medium-5 small-12 medium-cell-block-y tamanho-dark-log-cad corpo-light-log-cad"></div>
            </div>
            <!--#######-->

            <div class="grid-y grid-padding-y small-12 div-central-forms-log-cad">

                <div class="grid-x grid-padding-x">

                    <!--formulário de login -->
                    <div class="cell large-6 medium-6 small-12 medium-cell-block-y  div-form-login-log-cad custom-scroll">

                        <!--Alertas -->
                        <?php if (isset($_SESSION['erro'])) { ?>

                            <div class="callout alert-callout-border espaco-alerta warning" data-alert data-closable="slide-out-left">
                                <strong>Erro</strong> <?php echo $_SESSION['erro']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        } ?>
                        <!--#######-->

                        <!-- título -->
                        <div class="text-center titulo-form-login-log-cad">
                            <h2 class="texto_escuro">LOGIN</h2>
                        </div>
                        <!--#######-->

                        <!-- formulário -->
                        <form action="../action/login" method="post" data-abide novalidate>
                            <div class="grid-container">

                                <div class="grid-x grid-padding-x">
                                    <div class="medium-10  medium-offset-1 cell medium-cell-block-y ">
                                        <label class="texto_escuro">E-mail
                                            <input type="email" name="login_usuario" maxlength="35" placeholder="Insira seu email aqui..." value="<?php if (isset($_COOKIE['_u_s_1_E'])) {
                                                                                                                                                        echo $cript->Criptografia($_COOKIE['_u_s_1_E'], "d");
                                                                                                                                                    } ?>" required>
                                            <span class="form-error texto_escuro" id="example1Error3">
                                                Seu email deve ter um formato válido! <br>EX: exemplo@exemplo.com
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid-x grid-padding-x">

                                    <div class="medium-10  medium-offset-1  large-centered small-centered  cell">
                                        <label class="texto_escuro">Senha
                                            <input type="password" placeholder="Insira sua senha aqui..." name="senha_usuario" value="<?php if (isset($_COOKIE['_u_s_1_S'])) {
                                                                                                                                            echo  $cript->Criptografia($_COOKIE['_u_s_1_S'], "d");
                                                                                                                                        } ?>" required>
                                            <span class="form-error texto_escuro" id="example1Error3">
                                                Insira sua senha para poder logar!
                                            </span>
                                        </label>

                                        <p class="texto_escuro ">Manter-me Conectado</p>
                                        <div class="switch small escuro">
                                            <input class="switch-input" id="yes-no" type="checkbox" name="manter_conectado" <?php if (isset($_COOKIE['_u_s_1_S'])) : ?>checked<?php endif ?>>
                                            <label class="switch-paddle" for="yes-no">
                                                <span class="show-for-sr"></span>
                                                <span class="switch-active switch-text-active-cor-light" aria-hidden="true">Sim</span>
                                                <span class="switch-inactive switch-text-inactive-cor-dark" aria-hidden="true">Não</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="cell medium-7 medium-offset-5 small-7 small-offset-5">
                                        <input type="submit" class="button secondary " value="Fazer Login">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--#######-->

                    </div>
                    <!--#######-->
                    <!--FORMULÁRIO DE CADASTRO -->
                    <div class="cell large-6 medium-6 small-12  medium-cell-block-y div-form-cadastro-log-cad custom-scroll over_hide">

                        <?php if (isset($_SESSION['erro_cad'])) { ?>

                            <div class="callout alert-callout-border espaco-alerta warning" data-alert data-closable="slide-out-left">
                                <strong>Erro</strong> <?php echo $_SESSION['erro_cad']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        } else if (isset($_SESSION['success_cad'])) { ?>
                            <div class="callout alert-callout-border espaco-alerta success" data-alert data-closable="slide-out-left">
                                <strong>Sucesso</strong> <?php echo $_SESSION['success_cad']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>



                        <!-- <p><button  data-toggle="cadastro_home_user" class="button hollow success">Não tem uma HomeTag? Faça o cadastro de sua casa aqui</button></p> -->

                        <div class="medium-0  medium-1 large-1  cell"></div>

                        <div class="cell medium-10 large-10 small-12 titulo_info">
                            <label class="texto_claro">Ainda não cadastrou sua casa? </label>
                            <button type="submit" data-toggle="cadastro_home_user" class="button custom">Cadastrar Casa e Usuario</button>
                        </div>
                        <div class="medium-0 medium-1 large-1  cell"></div>

                        <div class="callout back_cadastro" id="cadastro_home_user" data-toggler data-animate="fade-in fade-out" hidden>
                            <div class="text-center">
                                <h2 class="texto_claro">Cadastre Sua Casa e seu Usuário</h2>
                            </div>
                            <form action="../action/cadastro" method="POST" data-abide novalidate>

                                <div class="grid-container">
                                    <div class="grid-x grid-padding-x">

                                        <div class="medium-12 large-6 small-12  cell">

                                            <label class="texto_claro">Nome Completo
                                                <input type="text" name="nome_usuario" maxlength="60" placeholder="Insira seu nome aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira seu Nome!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-6  small-12 cell">
                                            <label class="texto_claro">CEP
                                                <input type="text" name="cep_usuario" maxlength="9" minlength="9" placeholder="Insira seu CPF aqui..." required pattern="^\d{5}-\d{3}$">
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira um CEP Válido!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-8  small-12 cell">
                                            <label class="texto_claro">Cidade
                                                <input type="text" name="cidade_usuario" maxlength="35" placeholder="Insira sua Cidade..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira uma Cidade!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-4  small-12 cell">
                                            <label class="texto_claro">Bairro
                                                <input type="text" name="bairro_usuario" class="sample1" maxlength="50" placeholder="Insira o nome do seu Bairro aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira um Bairro!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-4  small-12 cell">
                                            <label class="texto_claro">Endereço
                                                <input type="text" name="endereco_usuario" maxlength="60" placeholder="Insira seu Enredeço aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Campo de Endereço nulo!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-8 small-12 cell">
                                            <label class="texto_claro">telefone
                                                <input type="tel" name="telefone_usuario" maxlength="9" minlength="9" placeholder="Insira seu telefone aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira um número de telefone!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="medium-12 large-12  small-12 cell">
                                            <label class="texto_claro">E-mail
                                                <input type="email" name="login_usuario" maxlength="35" placeholder="Insira seu email aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Seu email deve ter um formato válido! <br>EX: exemplo@exemplo.com
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-6 medium-12 small-12  cell">
                                            <label class="texto_claro ">Senha
                                                <input type="password" id="password1" name="senha_usuario" maxlength="35" placeholder="Insira sua senha aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error2">
                                                    Preencha este campo com a senha que deseja!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-6 medium-12 small-12  cell">

                                            <label class="texto_claro ">Confirmar Senha
                                                <input type="password" name="senha_usuario" maxlength="35" placeholder="Insira sua senha aqui..." required data-equalto="password1">
                                                <span class="form-error texto_claro" id="example1Error2">
                                                    As Senhas não coincidem!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-12 medium-12 small-12  cell">

                                            <!-- Teste para evitar burlação no input REGEX -->
                                            <script>
                                                function TesteTag() {
                                                    var tag = document.getElementById("tag_casa");
                                                    var regex = new RegExp("^[@]+([A-Z]+([0-9]{1})){4,4}$");
                                                    if (regex.test(tag.value) || tag.value === "") {

                                                        tag.style.border = "none";

                                                    } else {
                                                        tag.setAttribute('pattern', "^[@]+([A-Z]+([0-9]{1})){4,4}$");

                                                    }
                                                }
                                            </script>

                                        </div>

                                        <div class="medium-12 large-12 cell padding_switch">

                                            <p class="texto_claro">Li e aceito os <input data-open="exampleModal11" class="cor-termos-contrato" value="termos de contrato" type="button" style="background: transparent;border: none;">
                                                <div class="switch small claro">
                                                    <input class="switch-input" id="tinySwitch" type="checkbox" name="exampleSwitch" required>
                                                    <label class="switch-paddle" for="tinySwitch">
                                                        <span class="show-for-sr"></span>
                                                        <span class="switch-active switch-text-inactive-cor-dark" aria-hidden="true">Sim</span>
                                                        <span class="switch-inactive switch-text-inactive-cor-dark" aria-hidden="true">Não</span>
                                                    </label>

                                                    <span class="form-error texto_claro" id="example1Error2">
                                                        Você deve aceitar os termos e contrato para poder prosseguir.
                                                    </span>
                                                </div>
                                        </div>




                                        <div class="medium-0  medium-1 large-1  cell"></div>

                                        <div class="cell medium-10 large-10 small-12 centro">
                                            <button type="submit" class="button custom">Cadastrar</button>
                                        </div>
                                        <div class="medium-0 medium-1 large-1  cell"></div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="cell medium-10 large-10 small-12 centro">
                            <label class="texto_claro">Já tem uma TagHome? Cadastre um novo usuario a sua Casa </label>
                            <button type="submit" data-toggle="cadastro_user_taghome" class="button custom">Cadastrar Usuario Via TagHome</button>
                        </div>
                        <div class="medium-0 medium-1 large-1  cell"></div>

                        <div class="callout back_cadastro" id="cadastro_user_taghome" data-toggler data-animate="fade-in fade-out" hidden>

                            <div class="text-center">
                                <h2 class="texto_claro">Cadastro De Usuário via TagHome</h2>
                            </div>

                            <form action="../action/cadastro_taghome" method="POST" data-abide novalidate onsubmit="TesteTag()">
                                <div class="grid-container">
                                    <div class="grid-x grid-padding-x">

                                        <div class="medium-12 large-12 small-12  cell">

                                            <label class="texto_claro">Nome Completo
                                                <input type="text" name="nome_usuario" maxlength="60" placeholder="Insira seu nome aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Insira seu Nome!
                                                </span>
                                            </label>
                                        </div>

                                        <div class="medium-12 large-12  small-12 cell">
                                            <label class="texto_claro">E-mail
                                                <input type="email" name="login_usuario" maxlength="35" placeholder="Insira seu email aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error3">
                                                    Seu email deve ter um formato válido! <br>EX: exemplo@exemplo.com
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-6 medium-12 small-12  cell">
                                            <label class="texto_claro ">Senha
                                                <input type="password" id="password" name="senha_usuario" maxlength="35" placeholder="Insira sua senha aqui..." required>
                                                <span class="form-error texto_claro" id="example1Error2">
                                                    Preencha este campo com a senha que deseja!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-6 medium-12 small-12  cell">

                                            <label class="texto_claro ">Confirmar Senha
                                                <input type="password" name="senha_usuario" maxlength="35" placeholder="Insira sua senha aqui..." required data-equalto="password">
                                                <span class="form-error texto_claro" id="example1Error2">
                                                    As Senhas não coincidem!
                                                </span>
                                            </label>
                                        </div>
                                        <div class="large-12 medium-12 small-12  cell">
                                            <label class="texto_claro ">TagHome
                                                <input type="text" name="tag_casa" maxlength="35" id="tag_casa" placeholder="Caso já tenha uma TagHome, insira-a aqui" pattern="^[@]+([A-Z]+([0-9]{1})){4,4}$" onkeypress="TesteTag()">
                                                <span class="form-error texto_claro" id="example1Error2">
                                                    Insira uma Tag válida
                                                </span>
                                            </label>



                                        </div>

                                        <div class="medium-12 large-12 cell padding_switch">

                                            <p class="texto_claro">Li e aceito os <input data-open="exampleModal11" class="cor-termos-contrato termos_contrato" value="termos de contrato" type="button">
                                                <div class="switch small claro">
                                                    <input class="switch-input" id="termos" type="checkbox" name="exampleSwitch" required>
                                                    <label class="switch-paddle" for="termos">
                                                        <span class="show-for-sr"></span>
                                                        <span class="switch-active switch-text-inactive-cor-dark" aria-hidden="true">Sim</span>
                                                        <span class="switch-inactive switch-text-inactive-cor-dark" aria-hidden="true">Não</span>
                                                    </label>

                                                    <span class="form-error texto_claro" id="example1Error2">
                                                        Você deve aceitar os termos e contrato para poder prosseguir.
                                                    </span>
                                                </div>
                                        </div>


                                        <div class="medium-0  medium-1 large-1  cell"></div>

                                        <div class="cell medium-10 large-10 small-12 centro">
                                            <button type="submit" class="button custom">Cadastrar</button>
                                        </div>
                                        <div class="medium-0 medium-1 large-1  cell"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--#######-->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).foundation();
    </script>
    <!-- Compressed JavaScript -->
    <script type="text/javascript" src="../js/vendor/foundation.min.js"></script>
    <script type="text/javascript" src="../js/vendor/jquery.js"></script>
    <script type="text/javascript" src="../js/vendor/what-input.js"></script>

</body>

</html>
<?php
unset($_SESSION["erro"], $_SESSION['success_cad'], $_SESSION['erro_cad']); ?>