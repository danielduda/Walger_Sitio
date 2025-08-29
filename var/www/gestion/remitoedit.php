<?PHP
require 'phpmailer527/PHPMailerAutoload.php';
$idremito=$_GET["Id_Remito"];
$MAXIMO_DETALLE = 10;
$MAXIMO_FACTURA = 5;
error_reporting (E_STRICT);
$link_aux = mysqli_connect("localhost", "root", "walger0000");
mysqli_select_db($link_aux, "gestion_walger");
$link = mysqli_connect("localhost", "root", "walger0000");
mysqli_select_db($link, "gestion_walger");
$tildes = $link->query("SET NAMES 'utf8'");
$q ="select * from remitos where Id_Remito='".$idremito."'";
$q = mysqli_query($link_aux, $q);
$f = mysqli_fetch_array($q,MYSQLI_ASSOC);

//datos para email
$estadoanterior=$f["estado"];
$numeroderemito=$f["numeroRemito"];


if (isset($_POST ["modificar"])){
	$newDate = date("Y-m-d", strtotime($_POST["x_Fecha"])); 
	$qu ="UPDATE `remitos` SET Fecha='".$newDate."', Cliente='".$_POST["x_Cliente"]."', Proveedor='".$_POST["x_Proveedor"]."', Transporte='".$_POST["transporte"]."', NumeroDeBultos='".$_POST["bultos"]."', OperadorTraslado='".$_POST["opTraslado"]."', OperadorEntrego='".$_POST["opEntrego"]."', OperadorVerifico='".$_POST["opVerifico"]."', Observaciones='".$_POST["observaciones"]."', observacionesInternas='".$_POST["observacionesint"]."', Importe='".$_POST["importe"]."', tipoDestinatario='".$_POST["tipodestinatario"]."', estado='".$_POST["estado"]."' where Id_Remito='".$idremito."'";
	$qu = mysqli_query($link_aux, $qu);
	$q="DELETE FROM remitos_detalle where remitoCabecera='".$idremito."'";
	$q=mysqli_query($link_aux, $q);
	for($i = 1; $i <= $MAXIMO_DETALLE; $i++){
		if ($_POST["x_Producto".$i] != ""){
			$q = "INSERT INTO `remitos_detalle` (remitoCabecera, cantidad, descripcion) " .
			"VALUES ('".$idremito."', '".$_POST["cantidadDetalle".$i]."','".$_POST["x_Producto".$i]."')";
			$q = mysqli_query($link_aux, $q);
		}
	}
	$q="DELETE FROM facturas where RemitoCabecera='".$idremito."'";
	$q=mysqli_query($link_aux, $q);
	for($i = 1; $i <= $MAXIMO_FACTURA; $i++){
		if ($_POST["factura".$i] != ""){
			$q = "INSERT INTO `facturas` (RemitoCabecera, numFactura) " .
			"VALUES ('".$idremito."', '".$_POST["factura".$i]."')";
			$q = mysqli_query($link_aux, $q);
		}
	}

	//Envío email

	if ($_POST["tipodestinatario"]==0) {    
		if ($estadoanterior!=1 && $_POST["estado"]==1) {//cambia estado a finalizado
			$titulo="Envio WALGER SRL referencia Remito 0001-".str_pad($numeroderemito, 8, "0", STR_PAD_LEFT);
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$link_aux_2 = mysqli_connect("localhost", "root", "walger0000");
			mysqli_select_db($link_aux_2, "walger");
			$qcli="select `dbo_cliente`.* from `dbo_cliente` where CodigoCli= '".$_POST["x_Cliente"]."'";
			$qcli=mysqli_query($link_aux_2, $qcli);
			$fcli=mysqli_fetch_assoc($qcli);
			$razonSocial=htmlspecialchars($fcli['RazonSocialCli']);		
			$destinatario=$fcli['emailCli'];
			$transporte=htmlspecialchars($_POST["transporte"]);		
			$cantidadBultos=$_POST["bultos"];
			$numerosFactura=array();
			$qfactura="SELECT 
			`remitos` . * ,
			`facturas` . *
			FROM  `remitos` 
			LEFT JOIN  `facturas` ON  `remitos`.Id_Remito =  `facturas`.RemitoCabecera
			where Id_Remito='".$idremito."'";
			$qfactura=mysqli_query($link_aux, $qfactura);
			for ($i=0; $i < mysqli_num_rows($qfactura); $i++) {
				$ffactura=mysqli_fetch_assoc($qfactura);
				array_push($numerosFactura, $ffactura["numFactura"]);
			}
			$numerosFacturaok=implode(",", $numerosFactura);                

			//$destinatario="walgersrl@gmail.com";
			if (!isset($_POST["observacionesint"]) ) {
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
			}else{
				$observacionesInternas=htmlspecialchars($_POST["observacionesint"]);
				$mensaje='
				<p style="text-align:right">Ciudad Aut&oacute;noma de Buenos Aires, '. strftime("%d").' de '. $meses[date("n")-1].' del ' .strftime("%Y").'</p>
				<h3>Sr./es '.$razonSocial.'</h3>
				<p>Le informamos que en las &uacute;ltimas 24 horas hemos enviado por el transporte '.$transporte.' cuya GUIA Nro. '.$observacionesInternas.' de la mercader&iacute;a solicitada, embalada en '.$cantidadBultos.' bulto/s, referente a la factura '.$numerosFacturaok.'.
				La misma fue enviada en perfectas condiciones de embalaje y control.
				Como siempre agradecemos vuestra compra, y en el caso de no recibir en tiempo y forma, no dude con solicitar copia de nuestra Gu&iacute;a de Env&iacute;o.</p>
				<p>Sin otro particular lo saludamos muy atentamente,</p>                 
				<h5 style="margin:0">WALGER SRL</h5>
				<h5 style="margin:0">Hidalgo 1736 - Capital Federal</h5>
				<h5 style="margin:0">Te: (54-11) 4854-0360 (L&iacute;neas Rotativas)</h5>
				<a style="margin:0" href="mailto:ventas@walger.com.ar">ventas@walger.com.ar</a><br>
				<a style="margin:0" href="http://www.walger.com.ar">http://www.walger.com.ar</a>
				';
			}

			$mail = new PHPMailer();
			$mail->SetLanguage = "es";
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->Host = "smtp.gmail.com";
			$mail->Username = "walgersrl";
			$mail->Password = "Cc8697400!";
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
				$qresultado="UPDATE `remitos` SET `resultado` = '".$resultado."' WHERE `Id_Remito` = '".$idremito."'";

				//file_put_contents("test.txt", $qresultado);
				$qresultado=mysqli_query($link_aux, $qresultado);
			    header("Location: remitoslist.php");						
				return false;
			} else {

				//file_put_contents("test.txt", "ok");
				$resultado="Enviado ok a ".$destinatario;
				$qresultado="UPDATE `remitos` SET `resultado` = '".$resultado."' WHERE `Id_Remito` = '".$idremito."'";

				//file_put_contents("test.txt", $qresultado);
				$qresultado=mysqli_query($link_aux, $qresultado);
				header("Location: remitoslist.php");
				return true;
			}
		}
	}

    header("Location: remitoslist.php");
    exit();
	//echo "<script>window.location = 'remitoslist.php'</script>";

}
?>
<meta charset="UTF-8">
<html lang="es">
<head>
	<link rel="stylesheet" href="phpcss/customremito.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="phpcss/customremito.css">
	<link rel="stylesheet" href="phpcss/custom.css">
	<link rel="stylesheet" href="phpcss/ewmobile.css">
	<link rel="stylesheet" href="phpcss/ewpdf.css">
	<link rel="stylesheet" href="phpcss/GestiF3n_Walger.css">
	<link rel="stylesheet" href="phpcss/jquery.fileupload-ui.css">
	<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/jquery-1.10.2.min.js"></script><style type="text/css"></style>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="calendar/calendar.min.js"></script>
	<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="calendar/calendar-setup.js"></script>
	<script type="text/javascript" src="phpjs/ewcalendar.js"></script>
	<link href="juno/juno.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="http://walger.dyndns.org/gestion/fav.ico">
	<link rel="icon" type="image/vnd.microsoft.icon" href="http://walger.dyndns.org/gestion/fav.ico">
	<script type="text/javascript" src="juno/juno.js"></script>
	<script type="text/javascript">
	var EW_LANGUAGE_ID = "es";
	var EW_DATE_SEPARATOR = "/" || "/"; // Default date separator
	var EW_DECIMAL_POINT = ".";
	var EW_THOUSANDS_SEP = "";
	var EW_MAX_FILE_SIZE = 2000000; // Upload max file size
	var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension
	var EW_LOOKUP_FILE_NAME = "ewlookup10.php"; // Lookup file name
	var EW_AUTO_SUGGEST_MAX_ENTRIES = 10; // Auto-Suggest max entries
	var EW_MAX_EMAIL_RECIPIENT = 3;
	var EW_DISABLE_BUTTON_ON_SUBMIT = true;
	var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
	var EW_UPLOAD_URL = "ewupload10.php"; // Upload url
	var EW_UPLOAD_THUMBNAIL_WIDTH = 200; // Upload thumbnail width
	var EW_UPLOAD_THUMBNAIL_HEIGHT = 200; // Upload thumbnail height
	var EW_USE_JAVASCRIPT_MESSAGE = false;
	var EW_IS_MOBILE = false;
	</script>
	<script type="text/javascript" src="phpjs/jsrender.min.js"></script>
	<script type="text/javascript" src="phpjs/ewp10.js"></script>
	<script type="text/javascript" src="phpjs/userfn10.js"></script>
	<script type="text/javascript">
	var ewLanguage = new ew_Language({"deleteconfirmmsg":"Borra el registro?","deletemulticonfirmmsg":"Borra seleccionado?","enternewpassword":"Ingrese nueva clave","enteroldpassword":"Ingrese clave anterior","enterpassword":"Ingresar clave","enterpwd":"Ingresar clave","enterrequiredfield":"Ingresar campo requerido","enterusername":"Ingresar Usuario","entervalidatecode":"Validar el codigo mostrado","entersenderemail":"Ingrese email remit.","enterpropersenderemail":"La dirección de correo electrónico es incorrecta","enterrecipientemail":"Ingrese email destinatario","enterproperrecipientemail":"Cta. de Email del destin. excedida o dirección erronea","enterproperccemail":"Maximo CC exced. o dirección erronea","enterproperbccemail":"Maximo CCO exced. o dirección erronea","entersubject":"Ingrese objeto","enteruid":"Ingrese ID usuario","entervalidemail":"Ingrese email válido!","exporttoemail":"Email","exporttoemailtext":"Email","hidehighlight":"Ocultar destacado","incorrectemail":"Email erroneo","incorrectfield":"ICampo erroneo","incorrectfloat":"Punto flotante erroneo","incorrectguid":"Error GUID","incorrectinteger":"Entero erroneo","incorrectphone":"Telef.erroneo","incorrectregexp":"No concuerda expres.","incorrectrange":"Debe estar entre %1 y %2","incorrectssn":"# seg.social erroneo","incorrecttime":"Hora erronea (hh:mm:ss)","incorrectzip":"Cod.postal erroneo","insertfailed":"Falló inserción","invalidrecord":"Registro Invalido! Clave nula","loading":"Cargando...","maxfilesize":"Max.Excedido (%s bytes)","messageok":"OK","mismatchpassword":"No coincide","noaddrecord":"Registros no agregados","nofieldselected":"Campos no seleccionados para actualizar","norecordselected":"No seleccionado","pleasewait":"Espere...","sendemailsuccess":"Email enviado!","showhighlight":"Ver destacado","uploading":"Actualizando...","uploadstart":"Comenzar","uploadcancel":"Cancelar","uploaddelete":"Borrar","uploadoverwrite":"Sobreescribir archivo?","userleveladministratorname":"El nombre de usuario -1 debe ser 'Administrador'","userlevelidinteger":"ID de nivel de usuario debe ser entero","userleveldefaultname":"Nombre de nivel de usuario para el nivel de usuario debe ser 0 'Defecto'","userlevelidincorrect":"El ID usuario de usuario El nivel debe ser mayor que 0","userlevelnameincorrect":"El nombre de nivel de usuario no puede ser 'Administrador' or 'Default'","wrongfiletype":"Tipo de archivo no permitido."});</script>
	<script type="text/javascript">
	</script>

</head>
<body>
	<form name="remitoadd" id="remitoadd" method="post" action="">
		<table class="ltable">
			<tr>
			<td>
				<div style="text-align:center;position: relative;left: 250px;">
					<h1>X</h1>
					<h5>DOCUMENTO NO VALIDO</h5>
					<h5>COMO FACTURA</h5>
				</div>
			</td>				
			</tr>
			<tr>
				<td class="encabezado" style="text-align:center">
					<img src="images/Logo_Walger.png" alt="">
					<h4>Hidalgo 1736 - (1414) - Capital Federal - Argentina</h4>
					<h4>Tel.: 4854-8599 / 0360</h4>
					<h5>IVA RESPONSABLE INSCRIPTO</h5>
				</td>
				<td class="encabezado2">
					<div>
						<span><h3>GUIA DE TRASLADO</h3></span>
					</div>
					<div style="display: flex;">
						<span><h3>Nº</h3></span>
						<span class="input-append" style="margin-left: 58px;"><input id="numrem" style="height: 35px;font-size: 20px" type="text" value=<?php 
						$numremcompleto="select prefijo as f from numerador where nombre='remitos'";
						$numremcompleto=mysqli_query($link_aux, $numremcompleto);
						$numremcompletof=mysqli_fetch_assoc($numremcompleto);
						$numremcompletofinal=$numremcompletof["f"]."-".str_pad($f[numeroRemito],8,"0",STR_PAD_LEFT);
						echo $numremcompletofinal;
						?>></span>
					</div>
					<div style="display: flex;">
						<span>
							<h3>FECHA</h3>
						</span>
						<span id="el_remitos_Fecha" class="control-group" style="margin-left: 10px;margin-bottom:0px">
							<span class="input-append" style="margin-bottom:0px">
								<span class="input-append" style="height: 25px;">
									<input required type="date" data-field="x_Fecha" name="x_Fecha" id="x_Fecha" placeholder="Fecha" value= <?php $newDat = date("Y-m-d", strtotime($f[Fecha]));
									echo $newDat ; ?>  style="height: 35px;font-size: 20px;" >
								</button>
							</span>
						</span>
					</span>
				</div>
				<h4>C.U.I.T.30-66109877-1</h4>
				<h4>Ingresos Brutos: 901-153562-9</h4>
				<h4>Inicio de actividades: 20/10/1994</h4>
			</td>
		</tr>
	</table>
	<table class="ltable">
		<div class="noseimprime noseimprimenada" id="elegirdestinatario" style="display: flex;">
			<span>
				<h3>Tipo de Destinatario</h3>
			</span>
			<span>
				<?php 
				if ($f["tipoDestinatario"]==0) {
					?>
					<select class="cli" name="tipodestinatario" id="tipodestinatario">
						<option value="0" selected>Cliente</option>
						<option value="1">Proveedor</option>
					</select>
					<?php 
				}else{
					?>
					<select class="cli" name="tipodestinatario" id="tipodestinatario">
						<option value="0">Cliente</option>
						<option value="1" selected>Proveedor</option>
					</select>
					<?php
				}
				?>
			</span>
		</div>
		<div class="noseimprime noseimprimenada" id="estado" style="display: flex;">
			<span>
				<h3>Estado</h3>
			</span>
			<span>
				<select class="cli" name="estado" id="selectestado">
					<?php
					$estados=array(
						0=>"En trámite",
						1=>"Finalizado",
						2=>"Anulado",
						3=>"Editable"
						);

						for ($esti=0; $esti < count($estados); $esti++) { 
								if ($esti==$f["estado"]) {
									?>
									<option selected value="<?php echo $esti ?>"><?php echo $estados["$esti"] ?></option>
									<?php
								}else{
									?>
									<option value="<?php echo $esti ?>"><?php echo $estados["$esti"] ?></option>
									<?php 
								}
						}
					 ?>
				</select>
			</span>
		</div>
		<tr class="cliente" id="r_Cliente">
			<td>
				<span class="clie" id="elh_remitos_Cliente">Cliente</span>
				<span  id="el_remitos_Cliente" class="control-group">
					<select class="cli" data-field="x_Cliente" id="x_Cliente" name="x_Cliente">
						<option value="" >Seleccione</option>
						<?php
						$clienteelegido=($f[Cliente]);
						$link2 = mysqli_connect("localhost", "root", "walger0000");
						mysqli_select_db($link2, "walger");
						$tildes = $link2->query("SET NAMES 'utf8'");
						$result = mysqli_query($link2, "SELECT * FROM dbo_cliente");
						while ($fila = mysqli_fetch_array($result)){
							mostrarDatos($fila);
						}
						mysqli_free_result($result);
						function mostrarDatos ($resultados) {
							if ($resultados !=NULL) {
								global $clienteelegido; 
								if($resultados[CodigoCli]== $clienteelegido){
									?>	<option selected="selected" value=<?php echo $resultados['CodigoCli']; ?>><?php echo $resultados['CodigoCli']."-".$resultados['RazonSocialCli']; ?></option>
									<?php
								}else{
									?>	<option value=<?php echo $resultados['CodigoCli']; ?>><?php echo $resultados['CodigoCli']."-".$resultados['RazonSocialCli']; ?></option>
									<?php
								}
							}
						}
						?>
					</select>
					<td>
						<span class="clie">Proveedor</span>
						<span>
							<select class="cli" data-field="x_Proveedor" id="x_Proveedor" name="x_Proveedor">
								<option value="" >Seleccione</option>
								<?php
								$result = mysqli_query($link, "SELECT * FROM proveedores");
								while ($fila = mysqli_fetch_array($result)){
									mostrarDatosc($fila);
								}
								mysqli_free_result($result);
								?>	
							</select>
						</span>
					</td>
				</tr>
				<tr class="cliente">
					<td>	
						<span class="clie">Domicilio</span>
						<span><input id="domicilio" class="cli" type="text" value="" name="domicilio" /><br /></span>
					</td>
					<td>	
						<span class="clie">Loc.-Pcia.</span>
						<span><input id="localidad" class="cli" type="text" value="" name="localidad" /><br /></span>
					</td>
				</tr>
				<tr class="cliente">	
					<td>	
						<span class="clie">IVA</span>
						<span><input id="iva" class="cli" type="text" value="" name="iva" /><br /></span>
					</td>
					<td>	
						<span class="clie">CUIT</span>
						<span><input  id="cuit" class="cli" type="text" value="" name="cuit" /><br /></span>
					</td>
				</tr>
			</table>
			<table class="ltable">
				<tr>
					<td>
						<h5>Enviamos a Ud. lo siguiente</h5>
					</td>
				</tr>
			</table>
			<table class="ltable">
				<tr>
					<td>Cant</td>
					<td>Descripción</td>
				</tr>
				<?PHP
				$q2="select * from remitos_detalle where remitoCabecera='".$idremito."'";
				$q2=mysqli_query($link_aux, $q2);
				for ($i = 1; $i <= $MAXIMO_DETALLE; $i ++){
					$f2=mysqli_fetch_assoc($q2);
					?>
					<tr>
						<td>
							<input class="cantidad" type="number" min="1" value="<?php echo $f2["cantidad"]; ?>" name="cantidadDetalle<?PHP echo($i); ?>">
						</td>
						<td>
							<select class="descripcion" data-field="x_Producto" id="x_Producto" name="x_Producto<?PHP echo($i); ?>">
								<option value="">Seleccione</option>
								<?php
								$result = mysqli_query($link, "SELECT * FROM productos");
								while ($fila = mysqli_fetch_array($result)){
									mostrarDatosb($fila);
								}
								mysqli_free_result($result);
								?>	
							</select>
						</td>
					</tr>
					<?PHP 
				}
				function mostrarDatosb ($resultados) {
					if ($resultados !=NULL) {
						global $f2;
						echo $f2["descripcion"];
						if($f2["descripcion"]==$resultados['Id_Productos']){
							?>	<option selected="selected" value=<?php echo $resultados['Id_Productos']; ?>><?php echo $resultados['denominacion']; ?></option>
							<?php
						}else{
							?>	<option value=<?php echo $resultados['Id_Productos']; ?>><?php echo $resultados['denominacion']; ?></option>
							<?php
						}
					}
				}
				?>
			</table>
			<table class="ltable">
				<?PHP 
				function mostrarDatosc ($resultados) {
					if ($resultados !=NULL) {
						global $f;
						if($resultados['Id_Proveedores']==$f["Proveedor"]){
							?><option selected="selected" value=<?php echo $resultados['Id_Proveedores']; ?>><?php echo $resultados['razonSocial']; ?></option>
							<?php
						}else{
							?>	<option value=<?php echo $resultados['Id_Proveedores']; ?>><?php echo $resultados['razonSocial']; ?></option>
							<?php	
						}
					}
				}
				?></span>
			</td>
			<td>
				<span class="clie">Transporte</span>
				<span>
					<select id="transporte" class="cli" data-field="x_Proveedor" name="transporte" required>
						<option value="" >Seleccione</option>
						<?php
						$result = mysqli_query($link2, "SELECT  * FROM  `dbo_cliente` WHERE RazonSocialFlete !=  '' GROUP BY RazonSocialFlete ORDER BY  `dbo_cliente`.`RazonSocialFlete` ASC ");
						while ($fila = mysqli_fetch_array($result)){
							mostrarDatosasd($fila);
						}
						mysqli_free_result($result);
						function mostrarDatosasd ($resultados) {
							if ($resultados !=NULL) {
								global $f;
								if($resultados['RazonSocialFlete']==$f[Transporte]){
									?>	<option selected="selected" value="<?php echo $resultados['RazonSocialFlete']; ?>"><?php echo $resultados['RazonSocialFlete']; ?></option>
									<?php
								}else{
									?>	<option value="<?php echo $resultados['RazonSocialFlete']; ?>"><?php echo $resultados['RazonSocialFlete']; ?></option>
									<?php	
								}
							}
						}
						?>	
					</select>
				</td>
				<td>
					<span class="clie">Op Verificó</span>
					<span>
						<select required class="cli" data-field="x_Proveedor"  name="opVerifico">
							<option value="" >Seleccione</option>
							<?php
							$result = mysqli_query($link, "SELECT * FROM operadores");
							while ($fila = mysqli_fetch_array($result)){
								mostrarDatoseb($fila);
							}
							mysqli_free_result($result);
							?>	
						</select>
					</span>
				</td>
			</tr>
		</span>
	</td>
</tr>
<tr>
	<td>
		<span class="clie">Bultos</span>
		<span><input required id="bultos" class="cli" type="number" name="bultos" /><br /></span>
	</td>
	<td>
		<span class="clie">Transp int</span>
		<span>
			<select required class="cli" data-field="x_Proveedor"  name="opTraslado">
				<option value="" >Seleccione</option>
				<?php
				$result = mysqli_query($link, "SELECT * FROM transporte_interno");
				while ($fila = mysqli_fetch_array($result)){
					mostrarDatosec($fila);
				}
				mysqli_free_result($result);
				function mostrarDatosec ($resultados) {
					if ($resultados !=NULL) {
						global $f;
						if($resultados['idTransporteInterno']==$f["OperadorTraslado"]){
							?>	<option selected="selected"value=<?php echo $resultados['idTransporteInterno']; ?>><?php echo $resultados['denominacionTransporte']; ?></option>
							<?php
						}else{
							?>	<option value=<?php echo $resultados['idTransporteInterno']; ?>><?php echo $resultados['denominacionTransporte']; ?></option>
							<?php	
						}
					}
				}
				?>	
			</select>
		</td>
	</tr>
	<?PHP 
	function mostrarDatosea ($resultados) {
		if ($resultados !=NULL) {
			global $f;
			if($resultados['Id_Operadores']==$f[OperadorEntrego]){
				?>	<option selected="selected"value=<?php echo $resultados['Id_Operadores']; ?>><?php echo $resultados['nombreOperadores']; ?></option>
				<?php
			}else{
				?>	<option value=<?php echo $resultados['Id_Operadores']; ?>><?php echo $resultados['nombreOperadores']; ?></option>
				<?php	
			}
		}
	}
	function mostrarDatoseb ($resultados) {
		if ($resultados !=NULL) {
			global $f;
			if($resultados['Id_Operadores']==$f[OperadorVerifico]){
				?>	<option selected="selected"value=<?php echo $resultados['Id_Operadores']; ?>><?php echo $resultados['nombreOperadores']; ?></option>
				<?php
			}else{
				?>	<option value=<?php echo $resultados['Id_Operadores']; ?>><?php echo $resultados['nombreOperadores']; ?></option>
				<?php	
			}
		}
	}
	?>
</span>
</td>
</tr>
<tr>
</tr>
<tr>
	<td>
		<span class="clie">Valor</span>
		<span><input required class="cli" type="text" value="<?php echo $f[Importe]; ?>" name="importe" required /><br /></span>
	</td>
	<td>
		<span class="clie">Op Entregó</span>
		<span>
			<select class="cli" data-field="x_Proveedor"  name="opEntrego">
				<option value="" >Seleccione</option>
				<?php
				$result = mysqli_query($link, "SELECT * FROM operadores");
				while ($fila = mysqli_fetch_array($result)){
					mostrarDatosea($fila);
				}
				mysqli_free_result($result);
				?>	
			</select>
		</span>
	</td>
</tr>
</table>
<table class="ltable">
	<tr>
		<td>
			<textarea class="cli" type="text" value="" name="observaciones" placeholder="obsevaciones"><?php echo $f[Observaciones]; ?></textarea>
		</td>
		<td>
			<textarea class="cli" id="obsint" type="text" value="" name="observacionesint" placeholder="obsevaciones internas"><?php echo $f[observacionesInternas] ; ?></textarea>	
		</td>
	</tr>
</table>
<table class="ltable">
	<tr>
		<td>Facturas</td>
	</tr>
	<?PHP
	$q3="select * from facturas where RemitoCabecera='".$idremito."'";
	$q3=mysqli_query($link_aux, $q3);
	for ($i = 1; $i <= $MAXIMO_FACTURA; $i ++){
		$f3=mysqli_fetch_assoc($q3);
		?>
		<tr>
			<td>
				<input type="text" value="<?php echo $f3[numFactura]; ?>" name="factura<?PHP echo($i); ?>" placeholder="XXXX-XXXXXXXX" pattern="[0-9]{3}.-.[0-9]{7}" title="Debe ingresar la factura en formato XXXX-XXXXXXXX" />
			</td>
		</tr>
		<?PHP 
	}
	?>
	<div id="panelcontrol">	
		<input class="btn btnpanel" id="btnguardar" type="submit" value="Modificar" name="modificar" />
		<input class="btn btnpanel" id="btncancelar" type="button" value="volver" onclick="window.location='remitoslist.php';"/>
	</div>
</table>
</form>
<script>
	$(document).ready(function(){
				var size = $(".cantidad").size();
				var bultos=0;
			for (var i = 0; i <size; i++) {
				var bultos = bultos + ($(".cantidad").eq(i).val()*1);
				if (($(".cantidad").eq(i).val()*1)>0) {
					$(".descripcion").eq(i).prop("required",true);
					$(".descripcion").eq(i).addClass("seimprime");
					$(".descripcion").eq(i).removeClass("noseimprime");
				}else{
					$(".descripcion").eq(i).prop("required",false);
					$(".descripcion").eq(i).addClass("noseimprime");
					$(".descripcion").eq(i).removeClass("seimprime");
				};
			};
		if ($( "#tipodestinatario option:selected" ).val()==0) {
			$("select#x_Cliente").css("visibility","visible");
			$("#elh_remitos_Cliente").css("visibility","visible");
			$("select#x_Proveedor").css("visibility","hidden");
			$("#elh_remitos_Proveedor").css("visibility","hidden");
			$("select#x_Proveedor").val("0");
		}else{
			$("select#x_Cliente").css("visibility","hidden");
			$("#elh_remitos_Cliente").css("visibility","hidden");
			$("select#x_Proveedor").css("visibility","visible");
			$("#elh_remitos_Proveedor").css("visibility","visible");
			$("select#x_Cliente").val("0");
			$("#cuit").val("");
			$("#localidad").val("");
			$("#iva").val("");
			$("#domicilio").val("");
		};
		$("#tipodestinatario").change(function(){
			if ($( "#tipodestinatario option:selected" ).val()==0) {
				$("select#x_Cliente").css("visibility","visible");
				$("#elh_remitos_Cliente").css("visibility","visible");
				$("select#x_Proveedor").css("visibility","hidden");
				$("#elh_remitos_Proveedor").css("visibility","hidden");
				$("select#x_Proveedor").val("0");	
			}else{
				$("select#x_Cliente").css("visibility","hidden");
				$("#elh_remitos_Cliente").css("visibility","hidden");
				$("select#x_Proveedor").css("visibility","visible");
				$("#elh_remitos_Proveedor").css("visibility","visible");
				$("select#x_Cliente").val("0");
				$("#cuit").val("");
				$("#localidad").val("");
				$("#iva").val("");
				$("#domicilio").val("");
			};
		});
		$("#numrem").prop("readonly",true);
		var idname = $("select#x_Cliente").val();
		if ($.trim(idname) !="") {
			$.post("ajax/name.php",{nombrepost:idname},function(data){
				console.log(data);
				var res=data.split(",");
				$("#cuit").val(res[0]);
				$("#localidad").val(res[1]);
				$("#iva").val(res[2]);
				$("#domicilio").val(res[3]);
				console.log(res[2]);
			});
		}else{
			$("#cuit").val("");
			$("#localidad").val("");
			$("#iva").val("");
			$("#domicilio").val("");
		}
		$("select#x_Cliente").change( function(){
			var idname = $("select#x_Cliente").val();
			if ($.trim(idname) !="") {
				$.post("ajax/name.php",{nombrepost:idname},function(data){
					var res=data.split(",");
					$("#cuit").val(res[0]);
					$("#localidad").val(res[1]);
					$("#iva").val(res[2]);
					$("#domicilio").val(res[3]);
					var tran=res[4];
					$("#factura1").val(res[5]);
					$("#transporte option[value='"+tran+"']").attr("selected","selected");
				});
			}else{
				$("#cuit").val("");
				$("#localidad").val("");
				$("#iva").val("");
				$("#domicilio").val("");
				$("#factura1").val("");
			}
		});
		var elementos = $(".cantidad");
		var size = $(".cantidad").size();
		var bultos=0;
		for (var i = 0; i <size; i++) {
			var bultos = bultos + ($(".cantidad").eq(i).val()*1);
		};
		$("#bultos").val(bultos);			
		$(".cantidad").change(function(){
			var elementos = $(".cantidad");
			var size = $(".cantidad").size();
			var bultos=0;
			for (var i = 0; i <size; i++) {
				var bultos = bultos + ($(".cantidad").eq(i).val()*1);
				if (($(".cantidad").eq(i).val()*1)>0) {
					$(".descripcion").eq(i).prop("required",true);
					$(".descripcion").eq(i).addClass("seimprime");
					$(".descripcion").eq(i).removeClass("noseimprime");
				}else{
					$(".descripcion").eq(i).prop("required",false);
					$(".descripcion").eq(i).addClass("noseimprime");
					$(".descripcion").eq(i).removeClass("seimprime");
				};
			};
			$("#bultos").val(bultos);			
			
		});
	});
</script>
</body>
</html>
