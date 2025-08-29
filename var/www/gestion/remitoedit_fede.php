<?PHP
include 'phpmailer527/PHPMailerAutoload.php';

						$titulo="Envio WALGER SRL referencia Remito 0001-".str_pad($numeroderemito, 8, "0", STR_PAD_LEFT);
						$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$razonSocial = "Prueba Gerardo";
							$mensaje='
							<p style="text-align:right">Ciudad Aut&oacute;noma de Buenos Aires, '. strftime("%d").' de '. $meses[date("n")-1].' del ' .strftime("%Y").'</p>
							<h3>Sr./es '.$razonSocial.'</h3>
							<p>Le informamos que en las ultimas 24 horas hemos enviado por el transporte '.$transporte.' la mercaderia solicitada, embalada en '.$cantidadBultos.' bulto/s, referente a la factura '.$numerosFacturaok.'.
							La misma fue enviada en perfectas condiciones de embalaje y control.
							Como siempre agradecemos vuestra compra, y en el caso de no recibir en tiempo y forma, no dude con solicitar copia de nuestra Guia de Envio.</p>
							<p>Sin otro particular lo saludamos muy atentamente,</p>                 
							<h5 style="margin:0">WALGER SRL</h5>
							<h5 style="margin:0">Hidalgo 1736 Capital Federal</h5>
							<h5 style="margin:0">Te: (54-11) 4854-0360 (L&iacute;neas Rotativas)</h5>
							<a style="margin:0" href="mailto:ventas@walger.com.ar">ventas@walger.com.ar</a><br>
							<a style="margin:0" href="http://www.walger.com.ar">http://www.walger.com.ar</a>
<br><br>
							';            

							$mensaje.='
							<p style="text-align:right">Ciudad Aut&oacute;noma de Buenos Aires, '. strftime("%d").' de '. $meses[date("n")-1].' del ' .strftime("%Y").'</p>
							<h3>Sr./es '.$razonSocial.'</h3>
							<p>Le informamos que en las ultimas 24 horas hemos enviado por el transporte '.$transporte.' cuya GUIA Nº '.$observacionesInternas.' de la mercaderia solicitada, embalada en '.$cantidadBultos.' bulto/s, referente a la factura '.$numerosFacturaok.'.
							La misma fue enviada en perfectas condiciones de embalaje y control.
							Como siempre agradecemos vuestra compra, y en el caso de no recibir en tiempo y forma, no dude con solicitar copia de nuestra Guia de Envio.</p>
							<p>Sin otro particular lo saludamos muy atentamente,</p>                 
							<h5 style="margin:0">WALGER SRL</h5>
							<h5 style="margin:0">Hidalgo 1736 Capital Federal</h5>
							<h5 style="margin:0">Te: (54-11) 4854-0360 (L&iacute;neas Rotativas)</h5>
							<a style="margin:0" href="mailto:ventas@walger.com.ar">ventas@walger.com.ar</a><br>
							<a style="margin:0" href="http://www.walger.com.ar">http://www.walger.com.ar</a>
							';
						
						$mail = new PHPMailer();
						$mail->SetLanguage = "es";
						$mail->IsSMTP();
						$mail->SMTPAuth = true;
						$mail->Username = "administracionventas@walger.com.ar";
						$mail->Password = "1736";
						$mail->Host = "smtp.walger.com.ar";
						$mail->Port = 255;
						$mail->From = "administracionventas@walger.com.ar";
						$mail->FromName = "Walger - Tienda Virtual";
						$mail->Subject = $titulo;
						$mail->AddAddress ("gerardo@walger.com.ar", "");
						$mail->WordWrap = 50;
						$mail->Body = $mensaje;
						$mail->IsHTML(true);
						$mail->Send();

echo("FIN3");


?>
