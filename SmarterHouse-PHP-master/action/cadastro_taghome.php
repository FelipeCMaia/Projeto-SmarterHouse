<?php 

session_start();
$nome_usuario = strtolower($_POST['nome_usuario']);
$login_usuario = strtolower($_POST['login_usuario']);
$senha_usuario = strtolower($_POST['senha_usuario']);
$tag_casa = strtolower($_POST['tag_casa']);

$ch = curl_init();
$link = "http://localhost/smarterapi/v1/cadastro-taghome";

$array = array(
    "nome_usuario"=>strval($_POST['nome_usuario']),
    "email"=>strval($_POST['login_usuario']),
    "senha"=>strval($_POST['senha_usuario']),
    "tag_casa" =>strval($_POST['tag_casa'])
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
}
else{
    $_SESSION['erro_cad'] = $json->user_message;
    
}

header('location: ../paginas/login_cadastro');