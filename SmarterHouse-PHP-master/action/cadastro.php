<?php 
session_start();

$nome_usuario = strtolower($_POST['nome_usuario']);
$cep_usuario= $_POST['cep_usuario'];
$cidade_usuario = strtolower($_POST['cidade_usuario']);
$bairro_usuario = strtolower($_POST['bairro_usuario']);
$endereco_usuario = strtolower($_POST['endereco_usuario']);
$telefone_usuario = $_POST['telefone_usuario'];
$login_usuario = strtolower( $_POST['login_usuario']);
$senha_usuario = strtolower($_POST['senha_usuario']);


$ch = curl_init();
$link = "http://localhost:8088/smarterapi/v1/cadastro";

$array = array(
    "nome_usuario"=>strval($_POST['nome_usuario']),
    "email"=>strval($_POST['login_usuario']),
    "senha"=>strval($_POST['senha_usuario']),
    "cep_usuario"=>strval($_POST['cep_usuario']),
    "cidade_usuario"=>strval($_POST['cidade_usuario']),
    "bairro_usuario"=>strval($_POST['bairro_usuario']),
    "endereco_usuario"=>strval($_POST['endereco_usuario']),
    "telefone_usuario"=>strval($_POST['telefone_usuario']),
);


curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $link);


$result = curl_exec($ch);
$json = json_decode($result);
curl_close($ch);

if($json->status == 200){
    $_SESSION['success_cad'] = $json->user_message;

   echo"dasd";
}
else{
    $_SESSION['erro_cad'] = $json->user_message;
    echo "erro";
}

header('location: ../paginas/login_cadastro');