<?php 
require 'phpmailer527/PHPMailerAutoload.php';

$titulo="TEST Envio WALGER SRL referencia Remito 0001-0000001";
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


$razonSocial="Razón Social";

$transporte="Transporte";
$cantidadBultos=1;

$numerosFacturaok=1;                

$destinatario="walgersrl@gmail.com";

$mensaje='
<p style="text-align:right">Ciudad Aut&oacute;noma de Buenos Aires, '. strftime("%d").' de '. $meses[date("n")-1].' del ' .strftime("%Y").'</p>
<h3>Sr./es '.$razonSocial.'</h3>
<p>Le informamos que en las &uacute;ltimas 24 horas hemos enviado por el transporte '.$transporte.' la mercader&iacute;a solicitada, embalada en '.$cantidadBultos.' bulto/s, referente a la factura '.$numerosFacturaok.'.
La misma fue enviada en perfectas condiciones de embalaje y control.
Como siempre agradecemos vuestra compra, y en el caso de no recibir en tiempo y forma, no dude con solicitar copia de nuestra Gu&iacute;a de Env&iacute;o.</p>
<p>Sin otro particular lo saludamos muy atentamente,</p>                 
<h5 style="margin:0">WALGER SRL</h5>
<h5 style="margin:0">Hidalgo 1736 - Capital Federal</h5>
<h5 style="margin:0">Te: (54-11) 4854-0360 (L&iacute;neas Rotativas)</h5>
<a style="margin:0" href="mailto:ventas@walger.com.ar">ventas@walger.com.ar</a><br>
<a style="margin:0" href="http://www.walger.com.ar">http://www.walger.com.ar</a>
';  



$mail = new PHPMailer();
$mail->SetLanguage = "es";
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";
$mail->Username = "walgersrl";
$mail->Password = "c8697400";
$mail->Port = 587;
$mail->From = "walgersrl@gmail.com";
$mail->FromName = "Walger - Tienda Virtual";
$mail->Subject = $titulo;
$mail->AddAddress ($destinatario, "");
$mail->WordWrap = 50;
$mail->Body = $mensaje;
$mail->IsHTML(true);


if(!$mail->Send()){

	//file_put_contents("test.txt", $mail->ErrorInfo);
	$resultado=$mail->ErrorInfo;
	echo $resultado;
	return false;
} else {

	//file_put_contents("test.txt", "ok");
	$resultado="Enviado ok a ".$destinatario;
	echo $resultado;
	return true;
}

 ?>