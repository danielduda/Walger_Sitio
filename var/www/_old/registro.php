<?PHP $STYLE_BODY = "height: 800px;"; include ("inc/encabezado.php"); ?>

<?PHP

  $CODIGO = rand(1000, 9999);

  $_GET ["editar"] = ($_GET ["editar"] == "true");

  if ($_POST ["postback"] == "S") {

    if ($_POST ["editar"] == "S") {

      // Envia email con edicion de datos ...
      $titulo = "Edición de Cliente - " . $_SESSION ["cliente"] ["RazonSocialCli"];

    } else {

      // Envia email con alta de datos ...
      $titulo = "Alta de Cliente - " . $_POST ["RazonSocialCli"];

    }

    if ($_POST["Password"] != $_POST ["rPassword"]) exit("1");
    if (strrpos ($_POST["emailCli"], "@") === false) exit("2");
    if ($_POST["codigo"] != $_POST["codigoUsuario"]) exit("3");
    if (strlen($_POST["Password"]) < 5) exit("4");
    if (strlen($_POST["rPassword"]) < 5) exit("5");

	$q_usuario_unico = mysql_query("SELECT COUNT(*) AS cantidad FROM dbo_cliente WHERE emailCli = '".$_POST ["emailCli"]."'");
	$q_usuario_unico = mysql_fetch_array($q_usuario_unico);
	if ($q_usuario_unico["cantidad"] > 0) {
		header("location: usuario_uso.php");
		exit();
	}

 
    $mensaje = "$titulo\r\n<br />";
    $mensaje .= "<br />\r\nNúmero de Cliente: " . $_POST ["CodigoCli"] . ($_POST ["CodigoCli"] != $_SESSION ["cliente"]["CodigoCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nRazón Social: " . $_POST ["RazonSocialCli"] . ($_POST ["RazonSocialCli"] != $_SESSION ["cliente"]["RazonSocialCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nTipo de Cliente: " . $_POST ["TipoCliente"] . ($_POST ["TipoCliente"] != $_SESSION ["cliente"]["TipoCliente"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nIngresos Brutos: " . $_POST ["IngBrutosCli"] . ($_POST ["IngBrutosCli"] != $_SESSION ["cliente"]["IngBrutosCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nCUIT: " . $_POST ["CuitCli"] . ($_POST ["CuitCli"] != $_SESSION ["cliente"]["CuitCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nCondición de IVA: " . $_POST ["Regis_IvaC"] . ($_POST ["Regis_IvaC"] != $_SESSION ["cliente"]["Regis_IvaC"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nDirección: " . $_POST ["Direccion"] . ($_POST ["Direccion"] != $_SESSION ["cliente"]["Direccion"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nBarrio: " . $_POST ["BarrioCli"] . ($_POST ["BarrioCli"] != $_SESSION ["cliente"]["BarrioCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nCódigo Postal: " . $_POST ["CodigoPostalCli"] . ($_POST ["CodigoPostalCli"] != $_SESSION ["cliente"]["CodigoPostalCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nLocalidad: " . $_POST ["LocalidadCli"] . ($_POST ["LocalidadCli"] != $_SESSION ["cliente"]["LocalidadCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nProvincia: " . $_POST ["DescrProvincia"] . ($_POST ["DescrProvincia"] != $_SESSION ["cliente"]["DescrProvincia"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nPaís: " . $_POST ["DescrPais"] . ($_POST ["DescrPais"] != $_SESSION ["cliente"]["DescrPais"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nTeléfono: " . $_POST ["Telefono"] . ($_POST ["Telefono"] != $_SESSION ["cliente"]["Telefono"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nFax: " . $_POST ["FaxCli"] . ($_POST ["FaxCli"] != $_SESSION ["cliente"]["FaxCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nPágina Web: " . $_POST ["PaginaWebCli"] . ($_POST ["PaginaWebCli"] != $_SESSION ["cliente"]["PaginaWebCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nEMail: " . $_POST ["emailCli"] . ($_POST ["emailCli"] != $_SESSION ["cliente"]["emailCli"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nContraseña: " . $_POST ["Password"] . ($_POST ["Password"] != $_SESSION ["cliente"]["Contrasenia"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nFlete (Razón Social): " . $_POST ["RazonSocialFlete"] . ($_POST ["RazonSocialFlete"] != $_SESSION ["cliente"]["RazonSocialFlete"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nApellido y Nombre: " . $_POST ["ApellidoNombre"] . ($_POST ["ApellidoNombre"] != $_SESSION ["cliente"]["ApellidoNombre"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nCargo: " . $_POST ["Cargo"] . ($_POST ["Cargo"] != $_SESSION ["cliente"]["Cargo"] ? " (modificado)" : "");
    $mensaje .= "<br />\r\nComentarios: " . $_POST ["Comentarios"] . ($_POST ["Comentarios"] != $_SESSION ["cliente"]["Comentarios"] ? " (modificado)" : "");

    $destinatario = "administracionventas@walger.com.ar";
//    $destinatario = "yo@federicopfaffendorf.com.ar";

    if (enviarEmail ($destinatario, $titulo, $mensaje)) {

       // Ok Envio ...
       $MENSAJE = "Los datos fueron enviados correctamente a administración.
                   Estarán actualizados dentro de las 24 Horas.";

	if ($_POST ["TipoCliente"] == "Consumidor Final")
	{

        $q_insertCliente = mysql_query("INSERT INTO secuencia_cf VALUES (null)");
        $q_insertCliente = mysql_query("SELECT MAX(id) AS id FROM secuencia_cf");
        $q_insertCliente = mysql_fetch_array($q_insertCliente);
        $q_codigoCli = "CF" . $q_insertCliente["id"];

        $q_insertCliente = mysql_query(
        "INSERT INTO walger_clientes
        (CodigoCli,
        TipoCliente,
        ApellidoNombre,
        Cargo,
        Comentarios,
        Contrasenia,
        IP,
        UltimoLogin,
        Habilitado,
        Regis_Mda)
        VALUES
        ('".$q_codigoCli."',
        '".$_POST ["TipoCliente"]."',
        '".$_POST ["ApellidoNombre"]."',
        '',
        '".$_POST ["Comentarios"]."',
        '".$_POST ["Password"]."',
        '127.0.0.1',
        NOW(),
        'N',
        '1')");

        $q_insertClienteDBO = mysql_query(
        "INSERT INTO dbo_cliente
        (CodigoCli,
        RazonSocialCli,
        CuitCli,
        IngBrutosCli,
        Regis_IvaC,
        Regis_ListaPrec,
        emailCli,
        RazonSocialFlete,
        Direccion,
        BarrioCli,
        LocalidadCli,
        DescrProvincia,
        CodigoPostalCli,
        DescrPais,
        Telefono,
        FaxCli,
        PaginaWebCli)
        VALUES
        ('".$q_codigoCli."',
        '".$_POST ["ApellidoNombre"]."',
        '',
        '',
        '3',
        '21',
        '".$_POST ["emailCli"]."',
        '',
        '".$_POST ["Direccion"]."',
        '".$_POST ["BarrioCli"]."',
        '".$_POST ["LocalidadCli"]."',
        '".$_POST ["DescrProvincia"]."',
        '".$_POST ["CodigoPostalCli"]."',
        '".$_POST ["DescrPais"]."',
        '".$_POST ["Telefono"]."',
        '".$_POST ["FaxCli"]."',
        '".$_POST ["PaginaWebCli"]."')
        ");

	}



    } else {

       // Falló Envio ...
       $MENSAJE = "Se produjo un error en nuestro servidor al enviar el correo
                   a administración.<br />
                   Por favor, intente nuevamente en unos minutos.<br />
                   Disculpe las molestias.";

    }


  }

?>

<script>

function cambioTipoCliente(v)
{

document.getElementById ('tr1').style.display = (v != "Consumidor Final") ? 'table-row' : 'none';
document.getElementById ('tr2').style.display = (v != "Consumidor Final") ? 'table-row' : 'none';
document.getElementById ('tr3').style.display = (v != "Consumidor Final") ? 'table-row' : 'none';

document.getElementById ('td1').style.display = (v != "Consumidor Final") ? 'table-cell' : 'none';
document.getElementById ('td2').style.display = (v != "Consumidor Final") ? 'table-cell' : 'none';


}

</script>


      <div class="contenido">

        <?PHP if ($_GET ["editar"] != "true") { ?><strong>Registrarme</strong><?PHP } ?>
        <?PHP if ($_GET ["editar"] == "true") { ?><strong>Editar mi Cuenta</strong><?PHP } ?>
        <br />
        <br />

        <?PHP if ($MENSAJE == "") { ?>

        <form action="registro.php" method="post">

        <input type="hidden" name="editar" value="<?PHP if ($_GET ["editar"]) echo ("S"); ?>" />
        <input type="hidden" name="postback" value="S" />

        <strong><small>Datos de la empresa</small></strong><br />
        <br />

        <table class="registro">
          <tr>
	    <td>Tipo de Cliente</td>
            <td>
              <select name="TipoCliente" id="TipoCliente" onchange="cambioTipoCliente(this.value);">
<?PHP if ($_SESSION ["cliente"]["TipoCliente"] == "") { ?>
              <option value="Casa de Repuestos" <?PHP if ($_SESSION ["cliente"]["TipoCliente"] == "Casa de Repuestos") echo ("SELECTED"); ?>>Casa de Repuestos</option>
              <option value="Distribuidor" <?PHP if ($_SESSION ["cliente"]["TipoCliente"] == "Distribuidor") echo ("SELECTED"); ?>>Distribuidor</option>
	      <option value="Consumidor Final" <?PHP if ($_SESSION ["cliente"]["TipoCliente"] == "Consumidor Final") echo ("SELECTED"); ?>>Consumidor Final</option>
<?PHP } else { ?>
		<option value="<?PHP echo($_SESSION ["cliente"]["TipoCliente"]); ?>"><?PHP echo($_SESSION ["cliente"]["TipoCliente"]); ?></option>
<?PHP } ?>
              </select>
            </td>
            <td></td>
            <td></td>            
          </tr>
          <tr>
<?PHP if ($_GET ["editar"] == "true") { ?>
            <td>Número de Cliente</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["CodigoCli"]); ?>" name="CodigoCli" id="CodigoCli" maxlength="10" readonly /></td>
            <td></td>
            <td></td>
<?PHP } ?>
          </tr>
          <tr id="tr1">
	    <td>Razón Social (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["RazonSocialCli"]); ?>" name="RazonSocialCli" id="RazonSocialCli" maxlength="60" /></td>
            <td> &nbsp; Ingresos Brutos</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["IngBrutosCli"]); ?>" name="IngBrutosCli" id="IngBrutosCli" maxlength="18" /></td>
          </tr>
          <tr id="tr2">
            <td>CUIT</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["CuitCli"]); ?>" name="CuitCli" id="CuitCli" maxlength="13" /></td>
            <td> &nbsp; Condición de IVA</td>
            <td>
              <select name="Regis_IvaC" id="Regis_IvaC">
              <?PHP

                $q_aux = mysql_query ("SELECT * FROM dbo_ivacondicion ORDER BY DescrIvaC");
                while ($f_aux = mysql_fetch_array ($q_aux)) {

                if ($_SESSION ["cliente"]["Regis_IvaC"] == $f_aux ["Regis_IvaC"]) $SELECTED = "selected";
                else $SELECTED = "";

              ?>
                <option value="<?PHP echo ($f_aux ["DescrIvaC"]); ?>" <?PHP echo ($SELECTED); ?>><?PHP echo ($f_aux ["DescrIvaC"]); ?></option>
              <?PHP

                }

              ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Dirección Postal (*) &nbsp; </td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["Direccion"]); ?>" name="Direccion" id="Direccion" maxlength="90" /></td>
            <td> &nbsp; Barrio</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["BarrioCli"]); ?>" name="BarrioCli" id="BarrioCli" maxlength="30" /></td>
          </tr>
          <tr>
            <td>Código Postal (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["CodigoPostalCli"]); ?>" name="CodigoPostalCli" id="CodigoPostalCli" maxlength="10" /></td>
            <td> &nbsp; Localidad (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["LocalidadCli"]); ?>" name="LocalidadCli" id="LocalidadCli" maxlength="40" /></td>
          </tr>
          <tr>
            <td>Provincia (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["DescrProvincia"]); ?>" name="DescrProvincia" id="DescrProvincia" maxlength="40" /></td>
            <td> &nbsp; País (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["DescrPais"]); ?>" name="DescrPais" id="DescrPais" maxlength="40" /></td>
          </tr>
          <tr>
            <td>Teléfono (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["Telefono"]); ?>" name="Telefono" id="Telefono" maxlength="90" /></td>
            <td> &nbsp; Fax</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["FaxCli"]); ?>" name="FaxCli" id="FaxCli" maxlength="30" /></td>
          </tr>
          <tr>
            <td>Página web</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["PaginaWebCli"]); ?>" name="PaginaWebCli" id="PaginaWebCli" maxlength="40" /></td>
            <td> &nbsp; EMail (*)</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["emailCli"]); ?>" name="emailCli" id="emailCli" maxlength="40" /></td>
          </tr>
          <tr>
            <td>Contraseña (*)</td>
            <td><input type="password" value="<?PHP echo ($_SESSION ["cliente"] ["Contrasenia"]); ?>" name="Password" id="Password" maxlength="40" /></td>
            <td> &nbsp; Repetir contraseña (*) &nbsp;</td>
            <td><input type="password" value="<?PHP echo ($_SESSION ["cliente"] ["Contrasenia"]); ?>" name="rPassword" id="rPassword" maxlength="40" /></td>
          </tr>
          <tr id="tr3">
            <td>Flete (Razón Social) &nbsp;</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["RazonSocialFlete"]); ?>" name="RazonSocialFlete" id="RazonSocialFlete" maxlength="50" /></td>
            <td></td>
            <td></td>
          </tr>
        </table>

        <br />
        <strong><small>Datos del contacto</small></strong><br />
        <br />

        <table class="registro">
          <tr>
            <td>Apellido y Nombre &nbsp;</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["ApellidoNombre"]); ?>" name="ApellidoNombre" id="ApellidoNombre" maxlength="30" /></td>
            <td width="138" id="td1"> &nbsp; Cargo</td>
            <td id="td2"><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["Cargo"]); ?>" name="Cargo" id="Cargo" maxlength="30" /></td>      
          </tr>
          <tr>
            <td>Comentarios</td>
            <td><textarea name="Comentarios" id="Comentarios" style="width: 198px; height: 80px;"><?PHP echo ($_SESSION ["cliente"] ["Comentarios"]); ?></textarea></td>
            <td></td>
            <td></td>
          </tr>
        </table>

	<br />
	<strong><small>Codigo de verificación</small></strong><br />
        <br />

	<table class="registro">
	  <tr> 
            <td width="360">

		Escriba el siguiente código a continuación: 
		
	    </td>
	    <td>
		<span class="captcha"><?PHP echo($CODIGO); ?></span>
	    </td>
	    <td width="210">
	
	 	<input type="hidden" value="<?PHP echo($CODIGO); ?>" name="codigo" id="codigo" />
		<input type="text" value="" name="codigoUsuario" id="codigoUsuario" maxlength="4" style="width: 50px;" />

	    </td>
            <td>        

		<input type="button" onclick="validarRegistro ();" value="Enviar" name="enviar" style="width: 80px;" />

	    </td>
          </tr>
        </table>

	<br />
        <br />

        
<script type="text/javascript">

	cambioTipoCliente("<?PHP echo ($_SESSION ["cliente"]["TipoCliente"]); ?>");

</script>

        </form>

        <?PHP } else echo ($MENSAJE); ?>

      </div>
