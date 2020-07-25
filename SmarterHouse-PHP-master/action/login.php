<?php  session_start();

require_once('criptografia.php');


$ch = curl_init();
$link = "http://localhost/smarterapi/v1/login";

$array = array(
    "email"=>$_POST['login_usuario'],
    "senha"=>$_POST['senha_usuario']
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
        $_SESSION['email'] = $_POST['login_usuario'];
        $_SESSION['senha'] = $_POST['senha_usuario'];
        $_SESSION['refresh_token'] = $json->refresh_token;
        $_SESSION['token'] = $json->token;
        $_SESSION['id_user'] = $json->id_user;
        $_SESSION['tag_casa'] = $json->tag_casa;
        $_SESSION['id_casa'] = $json->id_casa;
        $_SESSION['nome_usuario'] = $json->nome_usuario;
        $_SESSION['nivel_usuario'] = $json->nivel_usuario;
        $_SESSION['success'] = $json->user_message;
  
    //    echo $_POST['manter_conectado'];
        if(isset($_POST['manter_conectado'])){
          $cript = new cript();
          // date_default_timezone_set('America/Sao_Paulo');
          setcookie("_u_s_1_E",$cript->Criptografia($array['email'],"e"),strtotime( '+2 years' ),'/');
          setcookie("_u_s_1_S", $cript->Criptografia($array['senha'], "e"), strtotime( '+2 years' ),'/');
        }
        else{
          setcookie("_u_s_1_E","", time()-3600,'/');
          setcookie("_u_s_1_S", "", time()-3600,'/');
        }
       // echo $_COOKIE['email'];2
      header('location: ../paginas/pagina_usuario');
}
else{
    $_SESSION['erro'] = $json->user_message;
      header('location: ../paginas/login_cadastro');
}