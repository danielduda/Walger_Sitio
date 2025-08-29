<?PHP

	$STYLE_BODY = "height: 1200px;";

  include ("inc/encabezado.php");

  if ($_SESSION ["cliente"]["Habilitado"] != 'S') header ("location: index.php");

?>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

        <strong>Mi Cuenta</strong> <input type="button" value="Versi&oacute;n de impresora" class="boton" onclick="var w = window.open ('vto_imprimir.php'); w.focus ();" style="float: right">
				<br />
        <br />

<form method="post" action="mi_cuenta_pago.php" id="formPago">

        <table class="listado">

  <?PHP 

          $_GET ["c"] = $_SESSION ["cliente"]["CodigoCli"];
    $_GET ["mi_cuenta"] = "true";

          include ("vto.php");

  ?>

        </table>

  <br />

<script type="text/javascript">

function medioChange(id)
{

document.getElementById("transferenciaBancaria").style.display = (id == '1' ? "table-row" : "none");
document.getElementById("cartaCorreo").style.display = (id == '2' ? "table-row" : "none");
document.getElementById("transporte").style.display = (id == '3' ? "table-row" : "none");
document.getElementById("trComentarios").style.display = (id != '4' ? "table-row" : "none");
document.getElementById("trEnviar").style.display = (id != '4' ? "table-row" : "none");
document.getElementById("imageEnviar").style.display = (id == '4' ? "table-row" : "none");


}

function validar()
{

var error = "";
if (document.getElementById("montoAbonar").value == "0.00") error += "Debe seleccionar al menos un comprobante a abonar.\r\n";
if (isNaN(document.getElementById("montoAbonarReal").value) || (document.getElementById("montoAbonarReal").value == "")) error += "El monto a abonar es incorrecto.\r\n";

if (document.getElementById("medio").value == "0") error += "Debe seleccionar un medio de pago.\r\n";
if (document.getElementById("medio").value == "1")
{

	if (
	(document.getElementById("fechaTF").value == "") ||
	(document.getElementById("banco").value == "") ||
	(document.getElementById("numeroComprobante").value == "")
	) error += "Debe completar fecha y hora de deposito, banco y numero de comprobante.\r\n";

}
else
if (document.getElementById("medio").value == "2")
{

	if (
        (document.getElementById("fechaCC").value == "") ||
	(document.getElementById("numeroOblea").value == "") ||
        (document.getElementById("empresaCorreo").value == "")
        ) error += "Debe completar fecha, empresa de correo y numero de oblea.\r\n";

}
else
if (document.getElementById("medio").value == "3")
{

        if (
        (document.getElementById("fechaT").value == "") ||
        (document.getElementById("nombreTransporte").value == "")
        ) error += "Debe completar fecha y transporte.\r\n";

}


if (error != "") alert (error);
else document.getElementById("formPago").submit();

}

</script>

<?PHP if ($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final") { ?>

  <table cellpadding="2" cellspacing="0">
          <tr>
      <td width="200">Monto total seleccionado:</td>
      <td><input type="text" value="0.00" maxlength="10" size="10" id="montoAbonar" name="montoAbonar" style="text-align: right;" onkeypress="return (__numeroDecimal (this, event));" readonly /></td>
          </tr>

    <tr>
            <td>Monto total a abonar:</td>
            <td><input type="text" value="0.00" maxlength="10" size="10" id="montoAbonarReal" name="montoAbonarReal" style="text-align: right;" onkeypress="return (__numeroDecimal (this, event));"  /><small><small> (Ingrese el monto deseado)</small></small></td>
          </tr>
       
<tr>
  <td>Medio de pago</td>
  <td>
    <select id="medio" name="medio" style="width: 300px;" onchange="medioChange(this.value)">
      <option value="0">Seleccione ...</option>
      <option value="1">Transferencia Bancaria</option>
      <option value="2">Carta por Correo</option>
      <option value="3">Transporte</option>
      <option value="4">Dinero Mail</option>
    </select>
  </td>
</tr>

<tr id="transferenciaBancaria" style="display: none;">
<td colspan="2">
<table cellpadding="2" cellspacing="0" style="font-size: 11px; margin-left: 20px;">
  <tr>
    <td>Fecha y hora de dep&oacute;sito</td>
    <td><input type="text" value="" name="fechaTF" id="fechaTF" /></td>
  </tr>
  <tr>
    <td>Banco</td>
    <td><input type="text" value="" name="banco" id="banco" /></td>
  </tr>
  <tr>
    <td width="200">N&uacute;mero de comprobante</td>
    <td><input type="text" value="" name="numeroComprobante" id="numeroComprobante" /></td>
  </tr>
</table>
</td>
</tr>

<tr id="cartaCorreo" style="display: none;">
<td colspan="2">
<table cellpadding="2" cellspacing="0" style="font-size: 11px; margin-left: 20px;">
 <tr>
    <td>Fecha</td>
    <td><input type="text" value="" name="fechaCC" id="fechaCC" /></td>
 </tr>
 <tr>
    <td width="200">Empresa de correo</td>
    <td><input type="text" value="" name="empresaCorreo" id="empresaCorreo" /></td>
  </tr>
  <tr>
    <td width="200">N&uacute;mero de oblea</td>
    <td><input type="text" value="" name="numeroOblea" id="numeroOblea" /></td>
  </tr>
</table>
</td>
</tr>

<tr id="transporte" style="display: none;">
<td colspan="2">
<table cellpadding="2" cellspacing="0" style="font-size: 11px; margin-left: 20px;">
  <tr>
    <td>Fecha</td>
    <td><input type="text" value="" name="fechaT" id="fechaT" /></td>
  </tr>
  <tr>
    <td width="200">Nombre del transporte</td>
    <td><input type="text" value="" name="nombreTransporte" id="nombreTransporte" /></td>
  </tr>
  <tr>
    <td width="200">N&uacute;mero de gu&iacute;a</td>
    <td><input type="text" value="" name="numeroGuia" id="numeroGuia" /></td>
  </tr>
</table>
</td>
</tr>


<tr id="trComentarios">
  <td>Comentarios del pago:</td>
  <td><textarea id="comentarios" name="comentarios" style="width: 300px; height: 80px;"></textarea></td>
</tr>
<tr id="trEnviar">
  <td></td>
  <td><input type="button" value="Enviar" class="boton" onclick="validar();" /></td>
</tr>
 
        </table>

<?PHP } ?>

</form>

<br /><br />
<?PHP include("formas_pago_texto.php"); ?>

<script type="text/javascript">

function dm_obtener()
{

document.getElementById("NombreItem").value = "Comprobante/s: ";

var cbs = document.getElementsByTagName("input");
for (var i = 0; i < cbs.length; i++)
{
	if (cbs[i].type == "checkbox")
	{
		if (cbs[i].checked)
		{
			document.getElementById("NombreItem").value += cbs[i].id + " ";
		}
	}
}

document.getElementById("PrecioItem").value = document.getElementById("montoAbonarReal").value;

if (document.getElementById("PrecioItem").value != "0.00")
	document.getElementById("formDM").submit();

}

</script>

<form action='https://argentina.dineromail.com/Shop/Shop_Ingreso.asp' method='post' id="formDM">
<input type='hidden' name='NombreItem' id="NombreItem" value=''>
<input type='hidden' name='TipoMoneda' id="TipoMoneda" value='<?PHP echo ($VTOPHPMONEDA); ?>'>
<input type='hidden' name='PrecioItem' id="PrecioItem" value=''>
<input type='hidden' name='E_Comercio' value='3244300'>
<input type='hidden' name='NroItem' value='<?PHP echo ($_SESSION["cliente"]["CodigoCli"]); ?>'>
<input type='hidden' name='image_url' value='http://servidor.walger.com.ar/imgs/logo.jpg'>
<input type='hidden' name='DireccionExito' value='http://servidor.walger.com.ar/dm_exito.php'>
<input type='hidden' name='DireccionFracaso' value='http://servidor.walger.com.ar/dm_fracaso.php'>
<input type='hidden' name='DireccionEnvio' value='0'>
<input type='hidden' name='Mensaje' value='1'>
<input type='hidden' name='submit_'>
</form>

<img src="https://argentina.dineromail.com/import/img/payment-button-ar.png?dmbypayu" onclick="dm_obtener();" border="0" style="cursor: pointer; display: none; margin-left: 170px; margin-top: 30px;" alt='Pagar con DineroMail' id="imageEnviar" />


        <br /><br /><br />

        <?PHP include ("inc/novedades.php"); ?>
        
      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
