<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

// ------------------------- //
// Configuración por Cliente //
// ------------------------- //
// Dejar estas variables aquí. Las tuve que sacar de Page_Head porque en determinados
// eventos no eran visibles salvo poniendolas aquí. (FP)
// El menú llamado Remoto puede ser renombrado desde aquí.

$nombre_menu_remoto = "ISIS";

// El menú llamado Trama puede ser renombrado desde aquí.
$nombre_menu_trama = "Web";

// El menú llamado Remoto Auxiliares puede ser renombrado desde aquí.
$nombre_menu_remoto_auxiliares = "ISIS Auxiliares";

// El menú llamado Trama Auxiliares puede ser renombrado desde aquí.
$nombre_menu_trama_auxiliares = "Web Auxiliares";

// Ruta absoluta a factura_pdf.php
$ruta_absoluta_factura_pdf = "http://servidor.walger.com.ar/backoffice/factura_pdf.php";

// Directorio de facturas en formato PDF
$directorio_facturas_pdf = "/home/fcisis/";

// Permite habilitar y deshabilitar la columna Tipo Articulo en la grilla dbo_articulo
$dbo_articulo_tipo_articulo_visible = false;

// Perfmite habilitar y deshabilitar la autogeneración del código de artículo
$dbo_articulo_codigo_autogenerado = false;

// URL a las imagenes de artículos (finalizar con /)
$ruta_imagenes_articulos = "http://servidor.walger.com.ar/articulos/";

// Ruta relativa a las imagenes de categoría (finalizar con /)
$ruta_relativa_imagenes_categorias = "../img/";

// Ruta relativa a las descargas (finalizar con /)
$ruta_relativa_descargas = "../descargas/";

// Ruta relativa a las imagenes de noticias (finalizar con /)
$ruta_relativa_imagenes_noticias = "../img/";

// Ruta relativa a las imagenes de portfolio (finalizar con /)
$ruta_relativa_imagenes_portfolio = "../img/";

// Ruta relativa a las imagenes de atributos (finalizar con /)
$ruta_relativa_imagenes_atributos = "../img/";

// Ruta relativa a las imagenes de slider (finalizar con /)
$ruta_relativa_imagenes_slider = "../img/";

// Código de artículo linkeado a Valores, Stock y Precios
$codigo_articulo_linkeado_valores_stock_precios = false;

// Permite habilitar y deshabilitar los controles de ABM en la tabla dbo_articulo
$dbo_articulo_read_only = true;

// Logo para encabezado de reportes (ruta absoluta)
$logo_encabezado_reportes = "http://servidor.walger.com.ar/img/Logo_Walger.png";

// Texto de contacto
$texto_contacto = "
<b>TELÉFONO</b>: 5411-4854-0360<br />
<b>WHATSAPP</b>: +54 9 11-6094-3285<br />
<b>EMAIL</b>: <a href=\"mailto:ventas@walger.com.ar\">ventas@walger.com.ar</a><br />
<b>DOMICILIO</b>: Hidalgo 1736 (C1414CAP) - CABA Argentina<br />
";

// Texto de medios de pago
$medios_de_pago = "
Para evitar demoras y riesgos de envió en los pagos, solicitamos tengan la amabilidad de hacer efectivo el pago de las facturas en nuestras cuentas corrientes de los siguientes bancos.<br />
<br />
<b>BANCO CREDICOOP COOPERATIVO LTDO</b><br />
Sucursal Nº 031 Cuenta Corriente 27873/5 a la orden de WALGER SRL <br />
CBU 19100315-55003102787350<br />
ALIAS WALGERCREDICOOP<br />
<br />
<b>BANCO NACIÓN ARGENTINA</b><br />
Sucursal Villa Crespo Cuenta Corriente 2300053/95 a la orden de WALGER SRL <br />
CBU 01100235-20002300053951<br />
ALIAS WALGERSRLBNA<br />
<br />
<b>NUESTRO NÚMERO DE CUIT</b><br />
CUIT 30-66109877-1<br />
Desde ya agradecemos su valiosa colaboración y el envío por fax del cupón de depósito.<br />
";

// Forzar siempre este destinatario (evitar enviarle correos al cliente)
// $email_forzar_destinatario = "yo@federicopfaffendorf.com.ar";

// EMail característica IsSMTP 
$email_is_smtp = true;

// EMail SMTP Authorization
$email_smtp_auth = true;

// EMail SMTPSecure
$email_smtp_secure = "tls";

// EMail Host
$email_host = "smtp.gmail.com";

// EMail Username
$email_username = "walgersrl";

// EMail Password
$email_password = "c8697400";

// EMail Port
$email_port = 587;

// EMail Remitente
$email_remitente = "administracionventas@walger.com.ar";

// EMail Remitente Nombre
$email_remitente_nombre = "Walger - Tienda Virtual";

// EMail Dirección de Copia
$email_direccion_copia = "";

// Asunto EMail Usuario Habilitado
$email_asunto_usuario_habilitado = "Walger Tienda Virtual: Usuario habilitado.";

// Asunto EMail de Items Pedidos
$email_asunto_items_pedidos = "Nuevo Pedido Web - Nro [[idPedido]]";

// Asunto EMail de Vencimientos
$email_asunto_vencimientos = "Walger Tienda Virtual -Estado de Cuenta- [[RazonSocial]]";

// Mensaje HTML para usuario habilitado
$email_mensaje_html_usuario_habilitado = '
<table width="100%" style="border-top: 1px solid #F0F0F0;">
  <tr>
	 <td style="padding: 20px;">
		<img src="'.$logo_encabezado_reportes.'" width="210" alt="Walger" /><br />
	 </td>
	 <td style="text-align: right; vertical-align: bottom; padding: 20px;">
		'.$texto_contacto.'
	 </td>
  </tr>
</table>
<table width="100%" style="border-top: 2px solid #F0F0F0;">
	<tr>
		<td style="padding: 3px; vertical-align: top;" width="50%">
			<strong>Sr/es. [[ApellidoNombre]]</strong><br />
			<br />
			Le damos la Bienvenida a Walger SRL.<br />
			<br />
			Le informamos que su usuario ya esta habilitado para operar en nuestra Tienda Virtual.<br />
			<br />
			<strong>Su usuario: </strong>[[emailCli]]<br />
			<strong>Su contraseña: </strong>[[Contrasenia]]<br />
			<br />
			A partir de ahora usted podrá acceder a nuestro carrito de pedidos,
			cualquier producto cargado a su pedido permanecerá en él hasta que sea confirmado
			por usted así podrá antes de ese proceso, realizar modificaciones sobre los ítems
			pedidos.<br />
			<br />
			Todos los pedidos permanecerán en un historial para que usted pueda repetirlos cuantas
			veces lo desee.<br />
			<br />
			Un Carrito de Pedidos no es una compra confirmada. Los pedidos se procesarán por orden
			de llegada, y su ejecutivo de cuenta se comunicará con usted para confirmar la orden o
			bien, podrá verificar el estado de su pedido on line.<br />
			<br />
			También usted podrá acceder al área de descarga donde podrá descargar la lista de precios
			actualizada cuando lo desee y realizar cualquier tipo de consulta a través del
			botón CONTACTO las 24hs del día.<br />
			<br />
			Disfrute a partir de ahora su acceso a nuestra Tienda Virtual en
			<a href="http://walger.com.ar">http://walger.com.ar</a> y desde ya agradecemos su registración.<br />
			<br />
			Cualquier consulta no dude en comunicarse con nosotros.<br />
			<br />
			<strong>WALGER SRL</strong><br />
		</td>
	</tr>
</table>';

// ------------------ //
// Variables Globales //
// ------------------ //

$acumulador = 0;

// --------- //
// Funciones //
// --------- //
function estadoActualizacion()
{
	$rs = ew_Execute("
		SELECT `walger_actualizaciones`.`fecha` AS `fecha`,
			   `walger_actualizaciones`.`pendiente` AS `estado`
		FROM `walger_actualizaciones`
		ORDER BY `walger_actualizaciones`.`fecha` DESC LIMIT 1
	");
	$s = "No disponible";
	if ($rs && $rs->RecordCount() > 0) {
		$sFields = "";
		$rs->MoveFirst();
		$fecha = date_format(date_create($rs->fields("fecha")), 'd/m/Y H:i:s');
		$estado = $rs->fields("estado") == "N" ? "Terminado" : "Pendiente";
		$rs->Close();
		$array[0] = $fecha;
		$array[1] = $estado;
		return $array;
	}
	$array[0] = "";
	$array[1] = "";
	return $array;
}

function estadoPedidos()
{
	$rs = ew_Execute("SELECT estado, COUNT(estado) AS c FROM walger_pedidos GROUP BY estado");
	$s = "No disponible";
	if ($rs && $rs->RecordCount() > 0) {
		$s = "";
		while($rs->MoveNext())
		{
			$estado = "";
			if ($rs->fields("estado") == "N") $estado = '<a href=\\"walger_pedidoslist.php?cmd=search&x_estado=N\\" title=\\"No Confirmado\\">nC</a>: ';
			else if ($rs->fields("estado") == "X") $estado = '<a href=\\"walger_pedidoslist.php?cmd=search&x_estado=X\\" title=\\"Confirmado no Entregado\\">CnE</a>: ';
			else if ($rs->fields("estado") == "E") $estado = '<a href=\\"walger_pedidoslist.php?cmd=search&x_estado=E\\" title=\\"En Preparación\\">eP</a>: ';
			else if ($rs->fields("estado") == "P") $estado = '<a href=\\"walger_pedidoslist.php?cmd=search&x_estado=P\\" title=\\"Pendiente de Pago\\">PdP</a>: ';
			if($estado != "") $s .= $estado . $rs->fields("c") . " &middot; ";
		}
		$rs->Close();
	}

	// Eliminar el último &middot;
	return substr($s, 0, strlen($s) - 10);
}

function diasFechas($f1)
{
	$f1_ = substr($f1, 6, 4) . "-" . substr($f1, 3, 2) . "-" . substr ($f1, 0, 2);
	return floor((strtotime($f1_)-strtotime("now"))/-86400);
}

function enviar_email($destinatario, $asunto, $mensaje_html)
{
	if ($destinatario == "") return;
	if ($asunto == "") return;
 	if ($mensaje_html == "") return;
	global $email_forzar_destinatario;
	global $email_is_smtp;
	global $email_smtp_auth;
	global $email_smtp_secure;
	global $email_host;
	global $email_username;
	global $email_password;
	global $email_port;
	global $email_remitente;
	global $email_remitente_nombre;
	global $email_direccion_copia;
	if ($email_username == "") return;
	if ($email_password == "") return;
	if (isset($email_forzar_destinatario)) $destinatario = $email_forzar_destinatario;
	include_once("phpmailer5216\class.phpmailer.php");
	$cuerpo = '<!DOCTYPE html>'; 
	$cuerpo .= '<html lang="es">';
	$cuerpo .= '<head>';
	$cuerpo .= '<meta charset="UTF-8">';
	$cuerpo .= '<meta name="generator" content="PHPMaker v2017">
</head>';
	$cuerpo .= '<body>';
	$cuerpo .= $mensaje_html;
	$cuerpo .= '</body>';
	$cuerpo .= '</html>';
	$php_mailer = new PHPMailer();
	$php_mailer->SetLanguage = "es";
	if($email_is_smtp) $php_mailer->IsSMTP();
	$php_mailer->SMTPAuth = $email_smtp_auth;
	$php_mailer->SMTPSecure = $email_smtp_secure;
	$php_mailer->Host = $email_host;
	$php_mailer->Username = $email_username;
	$php_mailer->Password = $email_password;
	$php_mailer->Port = $email_port;
	$php_mailer->From = $email_remitente;
	$php_mailer->FromName = $email_remitente_nombre;
	$php_mailer->Subject = $asunto;
	$php_mailer->AddAddress ($destinatario, "");
	if (!isset($email_forzar_destinatario))
		if ($email_direccion_copia != "")
			$php_mailer->AddAddress ($email_direccion_copia, "");
	$php_mailer->AddReplyTo ($email_remitente);
	$php_mailer->Body = $cuerpo;
	$php_mailer->IsHTML(true);
	$php_mailer->CharSet = 'UTF-8';
	$resultado = $php_mailer->Send();
	if ($resultado) $resultado = '1';
	else $resultado = '0';
	ew_Execute(
		"INSERT INTO trama_emails (enviado, para, asunto, fecha, contenido) " .
		"VALUES ('".$resultado."', '".$destinatario."', '".$asunto."', NOW(), '".$cuerpo."')"
	);								
}
?>
