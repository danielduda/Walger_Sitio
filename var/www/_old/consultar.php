<?PHP $STYLE_BODY = "height: 700px;"; include ("inc/encabezado.php"); ?>

<?PHP

  $_GET ["editar"] = ($_GET ["editar"] == "true");

  if ($_POST ["postback"] == "S") {

    // Envia email con alta de datos ...
    $titulo = "Consulta Web - " . $_POST ["CodigoCli"];

    $mensaje = "$titulo\r\n<br />";
    $mensaje .= "<br />\r\nApellido y Nombre: " . $_POST ["ApellidoNombre"];
    $mensaje .= "<br />\r\nTeléfono: " . $_POST ["Telefono"];
    $mensaje .= "<br />\r\nEMail: " . $_POST ["emailCli"];
    $mensaje .= "<br />\r\nConsulta: " . $_POST ["Comentarios"];

    $destinatario = "administracionventas@walger.com.ar";
    if (enviarEmail ($destinatario, $titulo, $mensaje)) {

       // Ok Envio ...
       $MENSAJE = "Los datos fueron enviados correctamente a administración.
                   Lo contactaremos dentro de las 24 Horas.";

    } else {

       // Falló Envio ...
       $MENSAJE = "Se produjo un error en nuestro servidor al enviar el correo
                   a administración.<br />
                   Por favor, intente nuevamente en unos minutos.<br />
                   Disculpe las molestias.";

    }


  }

?>

      <div class="contenido">

        <strong>Consultar</strong>
        <br />
        <br />

        <?PHP if ($MENSAJE == "") { ?>

        <form action="consultar.php" method="post">

        <input type="hidden" value="<?PHP echo ($_SESSION ["cliente"] ["CodigoCli"]); ?>" name="CodigoCli" id="CodigoCli" />
        <input type="hidden" name="postback" value="S" />

        <strong><small>Datos de la consulta</small></strong><br />
        <br />


        <table class="registro">
          <tr>
            <td>Teléfono</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["Telefono"]); ?>" name="Telefono" id="Telefono" maxlength="90" /></td>
          </tr>
          <tr>
            <td>EMail</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["emailCli"]); ?>" name="emailCli" id="emailCli" maxlength="40" /></td>
          </tr>
          <tr>
            <td>Apellido y Nombre &nbsp;</td>
            <td><input type="text" value="<?PHP echo ($_SESSION ["cliente"] ["ApellidoNombre"]); ?>" name="ApellidoNombre" id="ApellidoNombre" maxlength="30" /></td>
          </tr>
          <tr>
            <td>Consulta</td>
            <td><textarea name="Comentarios" id="Comentarios" style="width: 198px; height: 80px;"></textarea></td>
          </tr>
          <tr>
            <td></td>
            <td valign="bottom" align="right"><input type="submit" value="Enviar" name="enviar" style="width: 80px;" /></td>
          </tr>
        </table>




        </form>

        <?PHP } else echo ($MENSAJE); ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
