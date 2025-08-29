<?PHP include ("inc/encabezado.php"); ?>

<?PHP

  if ($_POST ["email"] != "") {

    $q = mysql_query ("SELECT RazonSocialCli, eMailCli, Contrasenia FROM dbo_cliente
                       INNER JOIN walger_clientes on dbo_cliente.CodigoCli = walger_clientes.CodigoCli
                       WHERE eMailCli = '$_POST[email]'
                       AND Habilitado = 'S'
                       LIMIT 1");

    $f = mysql_fetch_array ($q);
 
    if ($f ["eMailCli"] != "") {

      $mensaje = "Le recordamos sus datos de acceso a nuestra tienda virtual:\r\n<br />
                  <strong>Usuario:</strong> $f[eMailCli]\r\n<br />
                  <strong>Contraseña:</strong> $f[Contrasenia]\r\n<br />
                  \r\n<br />
                  Tenga a bien recordarlos o guardarlos en un sitio seguro para futura referencia
                  ya que le serán solicitados, siempre, al ingresar a nuestro sitio.\r\n<br />
                  \r\n<br />
                  ¡ Muchas gracias !\r\n";

      if (enviarEmail ($f ["eMailCli"], "Walger - Tienda Virtual - Recordatorio Datos de Ingreso", $mensaje)) {

        $mensaje = "Le enviamos un correo a su cuenta ($_POST[email]) con sus datos de ingreso, por favor, verifique ahora si le ha llegado correctamente.<br />
                    Si en el termino de 10 minutos aún no recibe el mensaje por favor <a href=\"consultar.php\">contactenos</a>. <br />
                    Recuerde revisar también su carpeta de correo SPAM o NO DESEADO.<br />
                    <br />
                    ¡ Muchas gracias !";

      } else {

        $mensaje = "Se produjo un error en nuestro servidor al enviar el correo, intente nuevamente en unos minutos.<br />
                    Disculpe las molestias.";

      }

    } else {

      $mensaje = "Su cuenta no existe o no se encuentra habilitada para operar. <br />
                  Por favor, si aún no se ha registrado <a href=\"registro.php\">hagalo ahora</a>, caso contrario
                  <a href=\"consultar.php\">contactenos</a> y nos comunicaremos a la brevedad.<br />
                  <br />
                  ¡ Muchas gracias !";

    }

  }

?>

      <div class="contenido">

        <?PHP if ($mensaje == "") { ?>

        Si no recuerda como ingresar a nuestra tienda virtual, ingrese su dirección
        de correo electrónico (EMail) y le enviaremos su usuario y contraseña
        a dicha casilla.<br />
        <br />
        <br />

        <form method="post" action="olvide.php">

          <strong>EMail</strong><br />
          <input type="text" value="" id="email" name="email" style="width: 200px;" />
          <input type="button" value="Solicitar datos" onclick="if (validarEMail (document.getElementById ('email').value)) document.forms [0].submit (); else alert ('Por favor, ingrese una cuenta de correo válida.');" />

        </form>

        <?PHP } else { ?>

          <?PHP echo ($mensaje); ?>

        <?PHP } ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
