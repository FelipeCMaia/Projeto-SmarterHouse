<?php
session_start();
$ch = curl_init();
$link = "http://localhost/smarterapi/v1/manutencao-usuario/atualiza";

$array = array(
    "nome_user"=>strval($_POST['nome_user']),
    "login_user"=>strval($_POST['email_user']),
    "senha_user"=>strval($_POST['senha_user']),
    "id_user"=>$_POST['id_user']
);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $link);


$result = curl_exec($ch);
$json = json_decode($result);
curl_close($ch);
var_dump($json);

if($json->status == 200){
    $_SESSION['ok'] = 200;
    $_SESSION['messagem_usuario'] = $json->user_message;
    $_SESSION['nome_usuario'] =$_POST['nome_user'];
}
else{
    $_SESSION['erro'] = $json->user_message;
    $_SESSION['code_error'] = $json->code;
}
echo $json->status ;
echo $_SESSION['ok'];
echo $_SESSION['messagem_usuario'];
header('location: ../paginas/manager_user.php');
