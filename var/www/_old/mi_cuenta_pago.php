<?PHP

  include ("inc/encabezado.php");

  if ($_SESSION ["cliente"]["Habilitado"] != 'S') header ("location: index.php");

?>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

        <strong>Mi Cuenta - Pago</strong>
        <br /><br />

&iexcl; Muchas gracias por informar su pago !<br />
Se le envi&oacute; un email a su casilla con una copia de los datos informados.<br />

<?PHP 

//print_r($_SESSION);

$cuerpo = '<img src="http://servidor.walger.com.ar/imgs/mail.gif" height="162" width="841" />';
$cuerpo .= "<table border='1' width=100%>";
$cuerpo .= '<tr><td><strong>Cliente</strong></td><td>'.$_SESSION ["cliente"]["CodigoCli"]." - ".$_SESSION ["cliente"]["RazonSocialCli"].'</td></tr>';
$cuerpo .= '<tr><td colspan="2"><strong>Comprobantes</strong></td></tr>';
foreach ($_POST as $k => $v)
{
	if (strpos($k, "_") !== false) 
		$cuerpo .= "<tr><td> &nbsp; &nbsp;".str_replace("_", " ", $k)."</td><td>".$v."</td></tr>";
}
$cuerpo .= "<tr><td width=300><strong>Monto total</strong></td><td>".$_POST["montoAbonar"]."</td></tr>";
$cuerpo .= "<tr><td><strong>Monto total abonado</strong></td><td>".$_POST["montoAbonarReal"]."</td></tr>";

if ($_POST ["medio"] == "1")
{

$cuerpo .= "<tr><td><strong>Fecha y Hora de dep&oacute;sito </strong></td><td>".$_POST["fechaTF"]."</td></tr>";
$cuerpo .= "<tr><td><strong>Banco</strong></td><td>".$_POST["banco"]."</td></tr>";
$cuerpo .= "<tr><td><strong>N&uacute;mero de comprobante</strong></td><td>".$_POST["numeroComprobante"]."</td></tr>";


} else
if ($_POST ["medio"] == "2")
{

$cuerpo .= "<tr><td><strong>Fecha del env&iacute;o </strong></td><td>".$_POST["fechaCC"]."</td></tr>";
$cuerpo .= "<tr><td><strong>Empresa de correo</strong></td><td>".$_POST["empresaCorreo"]."</td></tr>";
$cuerpo .= "<tr><td><strong>N&uacute;mero de oblea</strong></td><td>".$_POST["numeroOblea"]."</td></tr>";

} else
if ($_POST ["medio"] == "3")
{

$cuerpo .= "<tr><td><strong>Fecha del env&iacute;o </strong></td><td>".$_POST["fechaT"]."</td></tr>";
$cuerpo .= "<tr><td><strong>Empresa de transporte</strong></td><td>".$_POST["nombreTransporte"]."</td></tr>";
$cuerpo .= "<tr><td><strong>N&uacute;mero de guia</strong></td><td>".$_POST["numeroGuia"]."</td></tr>";

}
$cuerpo .= "<tr><td><strong>Comentarios</strong></td><td>".$_POST["comentarios"]."</td></tr>";
$cuerpo .= "</table><br />";

$cuerpo .= "<strong>Sr Cliente</strong>: Dependiendo del medio de seleccion que Ud. ha indicado, su operacion se vera reflejada, en aproximadamente 72 hs. habiles, en el caso de no mostrar modificacion, por favor contactarse con nuestra area administrativa.<br />";
$cuerpo .= "Esta informacion es de caracter virtual, y solo se incorporara al sistema una vez recibida en la empresa.<br />";
$cuerpo .= "Desde ya agradecemos vuestra compra y continuamos trabajando para brindarle cada dia un mejor servicio<br />";
$cuerpo .= "<strong>WALGER SRL</strong>";

include_once("inc/funciones.php");
enviarEmail ($_SESSION ["cliente"]["emailCli"], "Walger | Mi Cuenta - Pago", $cuerpo);

//enviarEmail ("yo@federicopfaffendorf.com.ar", "Walger | Mi Cuenta - Pago", $cuerpo);

enviarEmail ("administracionventas@walger.com.ar", "Walger | Mi Cuenta - Pago", $cuerpo);


?>














        <br /><br /><br />

        <?PHP include ("inc/novedades.php"); ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>

