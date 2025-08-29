<?php 

	require_once('PHPMailer-master/PHPMailerAutoload.php') ;

	$mail = new PHPMailer;
/*
		"emailadministracion"=>"administracionventas@walger.com.ar",
		"nombreadministracion"=>"Administración",
		"emailenvia"=>"administracionventas@walger.com.ar",
		"nombreenvia"=>"Walger - Tienda Virtual",
		"norespondermail"=>"noresponder@walger.com.ar",
		"norespondernombre"=>"noresponder",
		"host"=>"smtp.walger.com.ar",
		"usuario"=>"administracionventas@walger.com.ar",
		"password"=>"Aa8697400",
		"seguridad"=>"ssl",
		"puerto"=>465
*/

	$mail->SMTPDebug = 3;                               // Enable verbose debug output
  	$mail->SetLanguage = "es";
	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';                                      // Set mailer to use SMTP
	$mail->Host = "smtp.walger.com.ar"; 																	// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = "administracionventas@walger.com.ar";                  // SMTP username
	$mail->Password = "Aa8697400";                          // SMTP password
	$mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->setFrom("administracionventas@walger.com.ar", "administracionventas@walger.com.ar");
	$mail->addAddress("leandromusso@gmail.com", "leandro");     // Add a recipient

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);

$mail->SMTPOptions = array(
       'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );  	                                  // Set email format to HTML

	$mail->Subject = "test";
	$mail->Body    = "test";
	$mail->AltBody = "test";

	var_dump($mail->send());

 ?>