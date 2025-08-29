<?php 
$destinatario="leandromusso@gmail.com";
$titulo="test";
$mensaje="test á é í";
//enviarEmail($destinatario, $titulo, $mensaje);

@include_once ("../mailer/class.phpmailer.php");
//@include_once ("./mailer/class.phpmailer.php");

$mail = new PHPMailer();


$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Username = "walgersrl";
$mail->Password = "c8697400";
$mail->SMTPAuth = true;                            
$mail->SMTPSecure = 'tls';                         


$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->From = "administracionventas@walger.com.ar";
$mail->FromName = "Walger - Tienda Virtual";
$mail->Subject = $titulo;
$mail->AddAddress ($destinatario, "");

$mail->WordWrap = 50;

$mail->Body = $mensaje;
$mail->IsHTML(true);

if(!$mail->Send()){
   return false; 
} else {
   return true;
}
 ?>