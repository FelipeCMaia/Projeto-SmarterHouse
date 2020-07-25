<?php 
session_start();
echo $_POST['id_user'];

  $ch = curl_init();
  $link = "http://localhost/smarterapi/v1/manutencao-usuario/deleta/".$_POST['id_user']."";

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $link);

  $result = curl_exec($ch);
  $json = json_decode($result);
  curl_close($ch);

  if($json->status == 200){
    $_SESSION['delete_ok']=200;
    $_SESSION['delete_messagem_usuario']=$json->user_message;
}
else{
    $_SESSION['erro'] = $json->user_message;
    $_SESSION['code_error'] = $json->code;
}
header('location: ../paginas/manager_user');