<?PHP include ("inc/encabezado.php"); ?>

      <div class="contenido">

        <strong>Operaci&oacute;n realizada con &eacute;xito.</strong><br />
	<br />
        Gracias por operar con DineroMail, lo estaremos contactando a la brevedad para confirmar su pago.<br />

      </div>

    </div>

<?PHP

$cuerpo = "<strong>Sr Cliente</strong>: Dependiendo del medio de seleccion que Ud. ha indicado, su operacion se vera reflejada, en aproximadamente 72 hs. habiles, en el caso de no mostrar modificacion, por favor contactarse con nuestra area administrativa.<br />";
$cuerpo .= "Esta informacion es de caracter virtual, y solo se incorporara al sistema una vez recibida en la empresa.<br />";
$cuerpo .= "Desde ya agradecemos vuestra compra y continuamos trabajando para brindarle cada dia un mejor servicio<br />";
$cuerpo .= "<strong>WALGER SRL</strong>";

include_once("inc/funciones.php");
enviarEmail ($_SESSION ["cliente"]["emailCli"], "Walger | Pago DineroMail " . $_SESSION ["cliente"]["CodigoCli"], $cuerpo);
enviarEmail ("administracionventas@walger.com.ar", "Walger | Pago DineroMail " . $_SESSION ["cliente"]["CodigoCli"], $cuerpo);
//enviarEmail ("yo@federicopfaffendorf.com.ar", "Walger | Pago DineroMail " . $_SESSION ["cliente"]["CodigoCli"], $cuerpo);

?>

<?PHP include ("inc/pie.php"); ?>
