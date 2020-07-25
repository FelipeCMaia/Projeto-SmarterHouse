<?php 
require_once('../classes/components.php');
$comp = new component;

$message = "Email de ".$_POST['email_contato']."(".$_POST['nome_contato'].")\r\n"."Mensagem: \r\n".$_POST['mensagem_contato']."";


$to      = 'crud.group@gmail.com';
$subject = "".$_POST['assunto_contato']."";


var_dump($message);

$headers = 'From: crud.group@gmail.com' . "\r\n".
'Reply-To: '.$_POST['email_contato'].'' . "\r\n" .
'MIME-Version: 1.0 '."\r\n". 
'Content-Type: text/html; charset=UTF-8'  . "\r\n" .  
'X-Mailer: PHP/' . phpversion() ;

mail($to, $subject, $message, $headers);
//header('location: ../paginas/contato');