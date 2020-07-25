<?php  session_start();
session_destroy();
    header('location: ../paginas/login_cadastro');
    // setcookie("email","", time()-3600,'/');
    // setcookie("senha", "", time()-3600,'/');
