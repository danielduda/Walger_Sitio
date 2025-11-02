<?PHP 

  ob_start();

  include_once ("../_old_inc/funciones.php");

  $mysqli = mysqli_connect('localhost', 'technext_walger_user', '*Walger000#25', 'technext_walger');

  if (!$mysqli) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
  }

  $q = "SELECT * FROM dbo_moneda";
  $q = mysqli_query($mysqli, $q);

  while ($f = mysqli_fetch_assoc ($q))
    $mdas [$f ["Regis_Mda"]] = $f ["Signo_Mda"];

  $q = "SELECT * FROM dbo_cliente " . 
       "WHERE CodigoCli = '" . $_GET ["c"] . "'";

  $q = mysqli_query ($mysqli, $q);
  $cliente = mysqli_fetch_assoc ($q);

  $q = "SELECT * FROM dbo_clientevtotransa " . 
       "WHERE CodigoCli = '" . $_GET ["c"] . "' " .
       "ORDER BY Regis_CliTra ASC ";

  $q = mysqli_query ($mysqli, $q);

  //echo mysql_error();

  $vtos = null;
  while ($f = mysqli_fetch_assoc ($q))
    $vtos [] = $f;


  $VTOS = "sc";

  if (($_GET["vtos"] == "true") && ($_GET["mi_cuenta"] == "") && ($_GET["mailing"] == "")) 
  {

	for ($i = 0; $i < count($vtos); $i++)
	{

		if (diasFechas ($vtos [$i]["Fecha_CliTra"]) > 30)
		{

			ob_clean();
			$VTOS = "true";
			
		

		}

	}

	ob_clean();
	if ($VTOS == "sc") $VTOS = "false";
	
	
  } else {

  $acumulado = 0;

?>

<?PHP

  if ($_GET ["mi_cuenta"] != "true") {

?>

<html>
<head>
<title>Ficha de Vencimientos</title>
</head>
<body style="font-family: verdana;">

<table width="100%">
<tr>
    <td align="left"><img src="http://servidor2.walger.ar/imgs/logo.jpg"></td>
    <td align="right">Ficha de Vencimientos</td>
  </tr>
  <tr>
    <td colspan="2">
      <br />
      <table width="100%" bgcolor="#EEEEEE">
        <tr>
          <td valign="top"><i><?PHP echo ($cliente ["CodigoCli"]); ?></i></td>
          <td valign="top"><i><?PHP echo ($cliente ["RazonSocialCli"]); ?></i></td>
          <td align="right">
            <small>
<i>
<?PHP echo ($cliente ["BarrioCli"]); ?>&nbsp;
<?PHP echo ($cliente ["LocalidadCli"]); ?>&nbsp;
<?PHP echo ($cliente ["CodigoPostalCli"]); ?><br />
<?PHP echo ($cliente ["Direccion"]); ?>&nbsp;
<?PHP echo ($cliente ["DescrProvincia"]); ?>&nbsp;
<?PHP echo ($cliente ["DescrPais"]); ?><br />
<?PHP echo ($cliente ["Telefono"]); ?>&nbsp;
<?PHP echo ($cliente ["FaxCli"]); ?>
</i>
            </small>
          </td>
        </tr>
      </table>
      <br />

      <table width="100%">

<?PHP } ?>


	<script type="text/javascript">

		function toFixed(value, precision) {
		    var precision = precision || 0,
		    neg = value < 0,
		    power = Math.pow(10, precision),
		    value = Math.round(value * power),
		    integral = String((neg ? Math.ceil : Math.floor)(value / power)),
		    fraction = String((neg ? -value : value) % power),
		    padding = new Array(Math.max(precision - fraction.length, 0) + 1).join('0');
		    return precision ? integral + '.' +  padding + fraction : integral;
		}


		function sumarImporte(suma, i, id)
		{

		  try
		  {

		    var valor = parseFloat(document.getElementById ("montoAbonar").value);
                    i = parseFloat(i);

		    if (suma) document.getElementById ("montoAbonar").value = toFixed(valor + i, 2);
		    else document.getElementById ("montoAbonar").value = toFixed(valor - i, 2);

		    if (isNaN (valor)) document.getElementById ("montoAbonar").value = "0.00";

		    document.getElementById ("montoAbonarReal").value = document.getElementById ("montoAbonar").value;  

		  } catch (err) { }

		}

	</script>

        <tr class="titulos">
	  <?PHP if ($_GET ["mi_cuenta"] == "true") { ?><td></td><?PHP  } ?>
          <td><b>Vto.</b></td>
          <td><b>Emisi&oacute;n</b></td>
          <td><b>D&iacute;as</b></td>
          <td><b>Div.</b></td>
          <td><b>Comprobante</b></td>
          <td><b>Mda.</b></td>
          <td align="right"><b>Pendiente</b></td>
          <td align="right"><b>Acumulado</b></td>
        </tr>
        <?PHP 

		for ($i = 0; $i < count($vtos); $i ++) { 

		if ($i % 2 == 0) $PAR = "par"; else $PAR = "";

	?>

<?PHP

  if ($vtos [$i]["MdaOper_CliTra"] == 0) $moneda = 1;
  else
  {
    $moneda = $vtos [$i]["Regis_Mda" . $vtos [$i]["MdaOper_CliTra"]];
  }

  $VTOPHPMONEDA = $moneda;

  if ($vtos [$i]["MdaOper_CliTra"] == 0) $cotizacion = 1;
  else
  {
    $cotizacion = $vtos [$i]["CotizMda" . $vtos [$i]["MdaOper_CliTra"] . "_CliVto"];
  }

  if ($vtos [$i]["MdaOper_CliTra"] == 0) $pendiente = $vtos [$i]["ImportePes_CliVto"];
  else
  {
    $pendiente = $vtos [$i]["ImporteMda" . $vtos [$i]["MdaOper_CliTra"] . "_CliVto"];
  }

  $pendiente = $pendiente; // * $cotizacion;

  if ($vtos ["$i"]["SignoComp"] == "-") $pendiente *= -1;

  $acumulado += $pendiente;

?>


        <tr class="<?PHP echo ($PAR); ?>">
	  <?PHP if ($_GET ["mi_cuenta"] == "true") { ?><td><input type="checkbox" value="<?PHP echo (number_format ($pendiente, 2, '.', '')); ?>" id="<?PHP echo ($vtos [$i]["Abreviatura"]); ?>_<?PHP echo ($vtos [$i]["NroComprob_CliTra"]); ?>" name="<?PHP echo ($vtos [$i]["Abreviatura"]); ?>_<?PHP echo ($vtos [$i]["NroComprob_CliTra"]); ?>" onclick="sumarImporte(this.checked, this.value, this.id);"></td><?PHP  } ?>
          <td><?PHP echo (substr ($vtos [$i]["FechaVto_CliVto"], 0, 10)); ?></td>
          <td><?PHP echo (substr ($vtos [$i]["Fecha_CliTra"], 0, 10)); ?></td>
          <td><?PHP echo (diasFechas ($vtos [$i]["Fecha_CliTra"])); ?></td>
          <td><?PHP echo ($vtos [$i]["Regis_Emp"]); ?></td>


<?PHP

$fcisis_doc = "";
$dh_vto = opendir("/home/technext/servidor2.walger.ar/fcisis/");
while ($f_vto = readdir($dh_vto)) {
	if ((strpos($f_vto, $cliente ["CodigoCli"]) === 0) && (strpos($f_vto, $cliente ["CuitCli"]) > 0)){

		$dh1_vto = opendir("/home/technext/servidor2.walger.ar/fcisis/".$f_vto."/");
		while ($f1_vto = readdir($dh1_vto)) {
			if ((strpos($f1_vto, $vtos [$i]["NroComprob_CliTra"]) > 0)&&(strpos($f1_vto, ".pdf") > 0)) {
				$fcisis_doc = "/fc.php?r=".$f_vto."/".$f1_vto;
				break;
			}
		}
		break;
	}
}

?>

          <td><a <?PHP if ($fcisis_doc != "") { ?> target="_blank" href="<?PHP echo($fcisis_doc); ?>" <?PHP } ?> ><?PHP echo ($vtos [$i]["Abreviatura"]); ?> <?PHP echo ($vtos [$i]["NroComprob_CliTra"]); ?></a></td>
          <td><?PHP echo ($mdas [$moneda]); ?></td>
          <td align="right"><?PHP echo (number_format ($pendiente, 2, '.', ',')); ?></td>
          <td align="right"><?PHP echo (number_format ($acumulado, 2, '.', ',')); ?></td>
        </tr>
        <?PHP } ?>

        <tr>
          <?PHP if ($_GET ["mi_cuenta"] == "true") { ?><td></td><?PHP } ?>
          <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
          <td align="right"><b><?PHP echo (number_format ($acumulado, 2, '.', ',')); ?></b></td>
        </tr>

<?PHP 

  if ($_GET ["mi_cuenta"] != "true") { 

?>

      </table>

    </td>
  </tr>
</table>

</body>
</html>

<?PHP 

  }

  if (($acumulado == 0) && ($_GET["mailing"] == "true")) ob_clean();
  else ob_flush();

}

?>
