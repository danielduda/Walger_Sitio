<?php

@include_once("../inc/configuracion.php"); 
@include_once("connect.php");


function cargaError($tipo,$codigo){

	global $respuesta;
	global $errores;


	array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
	array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
}

/*****************************************************************************/

function map($var){

	return array_map('utf8_encode', $var);

}

/*****************************************************************************/

function enviarMail($demail, $denombre, $paramail, $paranombre, $responderamail, $responderanombre, $concopia, $concopiaoculta, $asunto, $mensajehtml, $mensajeplano, $encabezado ){

	global $mysqli;
	require_once('PHPMailer-master/PHPMailerAutoload.php') ;

	$logo='<img src="'.$GLOBALS["configuracion"]["carpetauploadremoto"].$GLOBALS["configuracion"]["brand"]["logo"].'" aria-hidden="true" width="200" height="50" alt="alt_text" border="0" style="height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">';

	$datospie="";
	foreach ($GLOBALS["configuracion"]["contactos"] as $key => $value) {
		$datospie.= $value["denominacion"].': '.$value["valor"].'<br>';
	}

	$body  = file_get_contents("../inc/render_emails.php");
	$reemplazar = array("[[logo]]", "[[mensajeplano]]", "[[mensajehtml]]", "[[encabezado]]", "[[datospie]]");
	$por = array($logo, $mensajeplano, $mensajehtml,$encabezado,$datospie);

	$body = utf8_decode(str_replace($reemplazar, $por, $body));

	$asunto = utf8_decode($asunto);
            				
	$resultado=array();

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
  $mail->SetLanguage = "es";

	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';                                      // Set mailer to use SMTP
	$mail->Host = $GLOBALS["configuracion"]["email"]["host"]; 																	// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $GLOBALS["configuracion"]["email"]["usuario"];                  // SMTP username
	$mail->Password = $GLOBALS["configuracion"]["email"]["password"];                          // SMTP password
	$mail->SMTPSecure = $GLOBALS["configuracion"]["email"]["seguridad"];                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $GLOBALS["configuracion"]["email"]["puerto"];                                    // TCP port to connect to

	$mail->setFrom($demail, $denombre);
	$mail->addAddress($paramail, $paranombre);     // Add a recipient
	$mail->addReplyTo($responderamail, $responderanombre);
	$mail->addCC($concopia);
	$mail->addBCC($concopiaoculta);

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $asunto;
	$mail->Body    = $body;
	$mail->AltBody = $mensajeplano;

	if(!$mail->send()) {
		$resultado["enviado"]=FALSE;
		$enviado=0;
		$resultado["detalle"]=$mail;
	} else {
		$resultado["enviado"]=TRUE;
		$enviado=1;
		$resultado["detalle"]=$mail;
	}

	$sql="SELECT id FROM trama_emails";
	$result=	mysqli_query($mysqli, $sql);

	if ($result->num_rows>$GLOBALS["configuracion"]["limitelogmails"]) {
		$sql="DELETE FROM trama_emails 
		ORDER BY id
		LIMIT 1";
		mysqli_query($mysqli, $sql);		
	}

	$body=mysqli_real_escape_string($mysqli, $body);
	
	$sql="INSERT INTO `trama_emails`
	 (
	 	`enviado`,
	 	`para`,
	 	`asunto`,
	 	`fecha`,
	 	`contenido`
	 	) VALUES (
	 	".$enviado.",
	 	'".$paramail."',
	 	'".$asunto."',
	 	'".date("Y-m-d H:i:s")."',
	 	'".$body."'
	 	)";

	mysqli_query($mysqli, $sql);

return $resultado;

}


/*****************************************************************************/

function randomPassword() {
    $caracteres = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($caracteres) - 1;
    $largopass=rand(8, 10);
    for ($i = 0; $i < $largopass; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $caracteres[$n];
    }
    return implode($pass);
}

/*****************************************************************************/

function comprobarPassword($pwd){

	global $respuesta;
	global $errores;
	$respuesta["error"]=FALSE;

	if( strlen($pwd) < $GLOBALS["configuracion"]["passwords"]["largominimo"] ) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=0;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}

	if( strlen($pwd) > $GLOBALS["configuracion"]["passwords"]["largomaximo"] ) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=1;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);		
	}

	if( !preg_match("#[0-9]+#", $pwd) && $GLOBALS["configuracion"]["passwords"]["requierenumeros"]===TRUE) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=2;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
	}

	if( !preg_match("#[a-z]+#", $pwd) && $GLOBALS["configuracion"]["passwords"]["requierenumeros"]===TRUE) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=3;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
	}

	if( !preg_match("#[A-Z]+#", $pwd) && $GLOBALS["configuracion"]["passwords"]["requierenumeros"]===TRUE) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=4;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
	}

	if( !preg_match("#\W+#", $pwd) && $GLOBALS["configuracion"]["passwords"]["requierenumeros"]===TRUE) {
		$respuesta["error"]=TRUE;
		$tipo="seguridad-password";
		$codigo=5;
		array_push($respuesta["errores"]["coderror"], $tipo.$codigo);
		array_push($respuesta["errores"]["mensajeerror"], $errores[$tipo][$codigo]);
	}
	if($respuesta["error"]==FALSE){
		$respuesta["exito"]="Contraseña Válida";
	}	

	return $respuesta;

}

/*****************************************************************************/

function formatearPrecio($valor){
	if (!isset($_SESSION["idUsuario"])) {
		global $mysqli;

		$sql="SELECT *
		FROM `dbo_moneda`
		WHERE Regis_Mda ='".$GLOBALS["configuracion"]["productos"]["monedadefault"]."'";

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$registro = mysqli_fetch_assoc($resultado);
			$Signo_Mda=$registro["Signo_Mda"];		
		}

		return $Signo_Mda." ".number_format((float)$valor, $GLOBALS["configuracion"]["precios"]["cantidaddecimales"], $GLOBALS["configuracion"]["precios"]["separadordecimales"], $GLOBALS["configuracion"]["precios"]["separadormiles"]);
	
	}else{
		return $_SESSION["Signo_Mda"]." ".number_format((float)$valor, $GLOBALS["configuracion"]["precios"]["cantidaddecimales"], $GLOBALS["configuracion"]["precios"]["separadordecimales"], $GLOBALS["configuracion"]["precios"]["separadormiles"]);
	}	
}

/*****************************************************************************/

function precioCliente($valor, $iva){
	if (isset($_SESSION["idUsuario"])) {
    $valor += $valor * $_SESSION['VariacionListaPrec'] / 100;
    $valor = $valor / $_SESSION["Cotiz_Mda"];
		
		if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==0) {
			$valor += $valor * $iva / 100;
		}
	}else{
		global $mysqli;

		$sql="SELECT *
		FROM `dbo_listaprecios`
		WHERE CodigListaPrec ='".$GLOBALS["configuracion"]["productos"]["listadepreciosdefault"]."'";

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$registro = mysqli_fetch_assoc($resultado);
			$VariacionListaPrec=$registro["VariacionListaPrec"];		
		}

		$sql="SELECT *
		FROM `dbo_moneda`
		WHERE Regis_Mda ='".$GLOBALS["configuracion"]["productos"]["monedadefault"]."'";

		$resultado = mysqli_query($mysqli, $sql);

		if ($resultado->num_rows>0) {
			$registro = mysqli_fetch_assoc($resultado);
			$Cotiz_Mda=$registro["Cotiz_Mda"];
			if ($Cotiz_Mda==0) {
				$Cotiz_Mda=1;
			}					
		}

    $valor += $valor * $VariacionListaPrec / 100;
    $valor = $valor / $Cotiz_Mda;
		$valor += $valor * $iva / 100;

	}	
	return $valor;
}

/*****************************************************************************/

function obtieneVencimiento(){

	global $mysqli;
	global $errores;	
	
	$sql="SELECT Fecha_CliTra FROM dbo_clientevtotransa 
	WHERE CodigoCli = '".$_SESSION["idUsuario"]."'
	ORDER BY Regis_CliTra ASC";

	$resultado = mysqli_query($mysqli, $sql);

	$vencido=FALSE;

	if ($resultado->num_rows>0) {
		for ($i = 0; $i < $resultado->num_rows; $i++) { 
			$registro = mysqli_fetch_assoc($resultado);
			$hoy=date_create(date("d-m-Y"));
			
			$fechaTra=date_create_from_format('d/m/Y', substr($registro["Fecha_CliTra"],0,-14));			
			$fechaTra=date_format($fechaTra, 'Y-m-d');
			$fechaTra=date_create($fechaTra);

			$intervalo = (date_diff($fechaTra, $hoy)->days);

			if ($intervalo>$GLOBALS["configuracion"]["diasvencimientotransaccion"]) {
				$vencido=TRUE;
			}
		}
	}	

	return $vencido;
}

/*****************************************************************************/

function usuarioInvitado(){
	if (!isset($_COOKIE["trama_ecommerce_usuario"])) {
		$usuariogenerado=md5(uniqid(rand(), true));
		setcookie("trama_ecommerce_usuario",$usuariogenerado,time()+60*60*24*30);
	}else{
		$usuariogenerado=$_COOKIE["trama_ecommerce_usuario"];
	}
	return $usuariogenerado;
}

/*****************************************************************************/


function borraUsuarioInvitado(){
	unset($_COOKIE["trama_ecommerce_usuario"]);
	setcookie("trama_ecommerce_usuario","",time()-1);
}

/*****************************************************************************/


function compruebaUsuarioInvitado(){
	if (isset($_COOKIE["trama_ecommerce_usuario"])) {
		return TRUE;
	}else{
		return FALSE;
	}
}


/*****************************************************************************/

function obtieneDatosTodopago(){
	$datosTodopago = array();
	$datosTodopago["modo"]=$GLOBALS["configuracion"]["todopago"]["modo"];
	$datosTodopago["Merchant"] =	$GLOBALS["configuracion"]["todopago"][$datosTodopago["modo"]]["Merchant"];
	$datosTodopago["Security"] =	$GLOBALS["configuracion"]["todopago"][$datosTodopago["modo"]]["Security"];

	return $datosTodopago;
}

/*****************************************************************************/


function formatoMonedaTodoPago($importe){
	return number_format($importe, 2, '.', ''); 
}

/*****************************************************************************/

function formatoDetallesTodoPago($array){
	foreach ($array as &$str) {
	    $str = str_replace("#", "", $str);
	}	
	return substr(implode("#", $array), 0,254); 
}


/*****************************************************************************/

function confirmarPago($idPedido, $AnswerKey){
		global $mysqli;

		$sql="UPDATE walger_pedidos
    SET estado = 'E',
		AnswerKey='".$AnswerKey."'
    WHERE idPedido = '".$idPedido."'
    AND CodigoCli = '".$_SESSION["idUsuario"]."'";

		$resultado = mysqli_query($mysqli, $sql);

}

function mezclararray($items, $mezcla = array()) {
	global $arraymezclado;

  if (empty($items)) {
  		$mezcla="%".implode("%", $mezcla)."%";
  		array_push($arraymezclado, $mezcla);
      
  } else {
      for ($i = count($items) - 1; $i >= 0; --$i) {
           $nuevositems = $items;
           $nuevamezcla = $mezcla;
           list($a) = array_splice($nuevositems, $i, 1);
           array_unshift($nuevamezcla, $a);
           mezclararray($nuevositems, $nuevamezcla);
       }
  }

}

function sqlinjection(){
	
	global $mysqli;

  foreach ($_POST as $key => $value) {
  	if (is_array($value)) {
  		foreach ($value as $key2 => $value2) {
		  	if (is_array($value2)) {
		  		
		  	}else{
		    	$_POST[$key2] = mysqli_real_escape_string($mysqli, $value2);
		  	} 			
  		}
  	}else{
    	$_POST[$key] = mysqli_real_escape_string($mysqli, $value);
  	}
  }

  foreach ($_GET as $key => $value) {
  	if (is_array($value)) {
  		foreach ($value as $key2 => $value2) {
		  	if (is_array($value2)) {
		  		
		  	}else{
		    	$_GET[$key2] = mysqli_real_escape_string($mysqli, $value2);
		  	} 			
  		}
  	}else{
    	$_GET[$key] = mysqli_real_escape_string($mysqli, $value);
  	}
  }

  foreach ($_REQUEST as $key => $value) {
  	if (is_array($value)) {
  		foreach ($value as $key2 => $value2) {
		  	if (is_array($value2)) {
		  		
		  	}else{
		    	$_REQUEST[$key2] = mysqli_real_escape_string($mysqli, $value2);
		  	} 			
  		}
  	}else{
    	$_REQUEST[$key] = mysqli_real_escape_string($mysqli, $value);
  	}
  }

  foreach ($_SESSION as $key => $value) {
  	if (is_array($value)) {
  		foreach ($value as $key2 => $value2) {
		  	if (is_array($value2)) {
		  		
		  	}else{
		    	$_SESSION[$key2] = mysqli_real_escape_string($mysqli, $value2);
		  	} 			
  		}
  	}else{
    	$_SESSION[$key] = mysqli_real_escape_string($mysqli, $value);
  	}
  }

  foreach ($_COOKIE as $key => $value) {
  	if (is_array($value)) {
  		foreach ($value as $key2 => $value2) {
		  	if (is_array($value2)) {
		  		
		  	}else{
		    	$_COOKIE[$key2] = mysqli_real_escape_string($mysqli, $value2);
		  	} 			
  		}
  	}else{
    	$_COOKIE[$key] = mysqli_real_escape_string($mysqli, $value);
  	}
  }

}


 ?> 