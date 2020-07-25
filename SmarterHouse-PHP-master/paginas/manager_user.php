<?php session_start();
require_once('../classes/components.php');
require_once('../classes/manager_user/ManagerUser.php');


if (!isset($_GET['model-graph'])) {
    $_GET['model-graph'] = 1;
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
        <link rel="stylesheet" type="text/css" href="../css/styles_manager_user.css" />
        <script type="text/javascript" src="../js/vendor/jquery.js"></script>
    </head>

    <body>
        <!-- BODY OF SITE -->
        <div class="cell medium-12 large-12 auto body_site auto">
            <div class="grid-x grid-padding-x altura_body">

                <!-- parte do menu topo mobile -->
                <div class="show-for-small-only small-12 ">
                    <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
                        <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
                        <div class="title-bar-left cor_menu_opc">Menu </div>

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
                                        <li><a href="pagina_usuario?model-graph=2">Iluminação</a></li>
                                        <li><a href="pagina_usuario?model-graph=3">ventilação</a></li>
                                        <li><a href="pagina_usuario?model-graph=4">cortina</a></li>
                                    </ul>
                                </li>

                                <div class="direita">
                                    <li><a href="../action/sair">Sair</a></li>
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

                <div class="medium-4 large-3  cell body_site hide-for-small-only lateral_menu menu_lateral">

                    <div class="grid-x grid-padding-x modo_flex">

                        <div class="medium-12 large-12 cell info_user">
                            <p class="nome_user">Bem Vindo <?php echo $_SESSION['nome_usuario']; ?></p>
                            <p class="taghome">TagHome <?php echo  $_SESSION['tag_casa'] ?></p>
                        </div>

                        <ul class="vertical menu drilldown">
                            <li><a href="pagina_usuario?model-graph=2">Módulos de Iluminação</a></li>
                            <li><a href="pagina_usuario?model-graph=3">Módulos de Ventilação</a></li>
                            <li><a href="pagina_usuario?model-graph=4">Módulos de Cortina</a></li>
                            <li><a href="../index">Home</a></li>
                            <li><a href="../action/sair">Logout</a></li>


                        </ul>
                    </div>
                </div>
                <!-- ############# -->
                <!-- parte dos módulos do site  -->
                <div class="medium-8 large-9  cell body_site body_modulos">

                    <div class="cell small-12 medium-12 large-12 body_pagina">
                        <!--Alertas -->
                        <?php

                            if (isset($_SESSION['erro'])) { ?>

                            <div class="callout alert-callout-border espaco-alerta warning" data-alert data-closable>
                                <strong>Erro</strong> <?php echo $_SESSION['erro']; ?><br>
                                <strong>Codigo de Erro</strong> <?php echo $_SESSION['code_error']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                            } ?>

                        <!--Alertas -->
                        <?php
                            if (isset($_SESSION['ok'])) { ?>
                            <div class="callout alert-callout-border espaco-alerta success" data-alert data-closable>
                                <strong>Atualizado</strong> <?php echo  $_SESSION['messagem_usuario']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                            } ?>

                        <!--Alertas -->
                        <?php
                            if (isset($_SESSION['delete_ok'])) { ?>
                            <div class="callout alert-callout-border espaco-alerta primary" data-alert data-closable>
                                <strong>Deletado</strong> <?php echo  $_SESSION['delete_messagem_usuario']; ?>
                                <button class="close-button " aria-label="Dismiss alert" type="button" data-close onclick="$('#callout').trigger('close');">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                            } ?>

                        <table>
                            <thead>
                                <tr class="titulo_tbl">
                                    <th width="150" class="titulo_tbl">USUÁRIOS CADASTRADOS NA CASA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $b = [];
                                    $var = new ManagerUser();
                                    $b = $var->SelecionaUsuario($_SESSION['id_user']);

                                    for ($i = 0; $i < count($b); $i++) {

                                        ?>

                                    <tr>
                                        <td>
                                            <form action="" method="POST" data-abide novalidate>
                                                <div class="grid-x grid-margin-x">
                                                    <!-- <div class="cell small-0 medium-0 large-1"></div> -->
                                                    <div class="cell small-12 medium-12 large-2">
                                                        <label class="lbl_tbl esquerda">Senha</label>
                                                        <div class="input-group" hidden>
                                                            <span class="input-group-label icon_tbl">
                                                                <i class="fi fi-info"></i>
                                                            </span>
                                                            <input class="input-group-field" type="password" maxlength="100" value="<?php echo $b[$i]->senha_user ?>" name="senha_user" required <?php if (isset($_SESSION['nivel_usuario'])) {
                                                                                                                                                                                                                if ($_SESSION['nivel_usuario'] == 0) { ?>readonly disabled<?php }
                                                                                                                                                                                                                                                                                    } ?>>
                                                            <input class="input-group-field" type="hidden" value="<?php echo $b[$i]->id_user ?>" name="id_user" readonly>

                                                        </div>
                                                    </div>
                                                    <div class="cell small-12 medium-12 large-3">
                                                        <label class="lbl_tbl esquerda">Nome de Usuario</label>
                                                        <div class="input-group">
                                                            <span class="input-group-label icon_tbl">
                                                                <i class="fi fi-torso"></i>
                                                            </span>
                                                            <input class="input-group-field" type="text" maxlength="100" value="<?php echo $b[$i]->nome_user ?>" name="nome_user" required <?php if (isset($_SESSION['nivel_usuario'])) {
                                                                                                                                                                                                        if ($_SESSION['nivel_usuario'] == 0) { ?>readonly disabled<?php }
                                                                                                                                                                                                                                                                            } ?>>

                                                        </div>
                                                    </div>
                                                    <div class="cell small-12 medium-12 large-7">

                                                        <label class="texto_escuro cell small-12 medium-12 large-6 "> <label class="lbl_tbl esquerda">E-mail</label>
                                                            <div class="input-group ">
                                                                <span class="input-group-label icon_tbl">
                                                                    <i class="fi fi-mail"></i>
                                                                </span>
                                                                <input class="input-group-field altura" type="email" maxlength="100" value="<?php echo $b[$i]->login_user ?>" name="email_user" required <?php if (isset($_SESSION['nivel_usuario'])) {
                                                                                                                                                                                                                        if ($_SESSION['nivel_usuario'] == 0) { ?> disabled<?php } else { ?>onclick="this.form.action='../action/atualiza_usuario'" <?php }
                                                                                                                                                                                                                                                                                                                                                            } ?>>
                                                            </div>
                                                            <span class="form-error texto_escuro" id="example1Error3">
                                                                Seu email deve ter um formato válido! <br>EX: exemplo@exemplo.com
                                                            </span>
                                                        </label>

                                                        <div class="grid-x grid-margin-x">


                                                            <a class="cell small-12 medium-12 large-6 botao_largura">
                                                                <button type="submit" class="button custom largura" <?php if (isset($_SESSION['nivel_usuario'])) {
                                                                                                                                if ($_SESSION['nivel_usuario'] == 0) { ?> disabled<?php } else { ?>onclick="this.form.action='../action/atualiza_usuario'" <?php }
                                                                                                                                                                                                                                                                    } ?>>Atualizar</button>
                                                            </a>
                                                            <a class="cell small-12 medium-12 large-6 botao_largura">
                                                                <button type="submit" class="button rosado largura" <?php if (isset($_SESSION['nivel_usuario'])) {
                                                                                                                                if ($_SESSION['nivel_usuario'] == 0 || $b[$i]->id_user == $_SESSION['id_user']) { ?> disabled<?php } else { ?>onclick="this.form.action='../action/deleta_usuario'" <?php }
                                                                                                                                                                                                                                                                                                            } ?>>Remover</button>
                                                            </a>



                                                        </div>

                                                        <!-- <div class="cell small-0 medium-0 large-1">
                                                    </div> -->


                                                    </div>
                                            </form>
                                        </td>
                                    </tr>


                                <?php
                                    }
                                    if (count($b) == 0) {
                                        echo "  <div class='callout alert-callout-border espaco-alerta alert'  data-alert data-closable>
                                    <strong>Erro</strong> Falha ao selecionar dados do banco de dados
                                    <button class='close-button' aria-label='Dismiss alert' type='button' data-close onclick='$('#callout').trigger('close');'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                                    }

                                    ?>



                            </tbody>
                        </table>



                    </div>


                </div>

                <!-- ############# -->
            </div>

        </div>
        <!-- END OF BODY -->

        <!-- Compressed JavaScript -->
        <script type="text/javascript" src="../js/vendor/foundation.min.js"></script>
        <script type="text/javascript" src="../js/vendor/jquery.js"></script>
        <script type="text/javascript" src="../js/vendor/what-input.js"></script>
        <script type="text/javascript" src="../js/vendor/foundation.js"></script>
        <script>
            $(document).foundation();
        </script>

    </body>

    </html>
<?php }
unset($_SESSION['erro']);
unset($_SESSION['code_error']);
unset($_SESSION['ok']);
unset($_SESSION['delete_ok'])
?>