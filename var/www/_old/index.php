<?PHP include ("inc/encabezado.php"); ?>

      <div class="contenido">

        <span class="ultima">Última actualización: <?PHP obtenerUltimaActualizacion (); ?>.</span><br />
        <br />

        <div class="registro">

          <div class="login_box">

            <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>

            <form method="post" action="login.php" id="formLoginEnter">

              <a name="login">&nbsp;</a>
              <strong>Login de Clientes</strong><br />
              <br />

<table>
<tr>
<td>Usuario</td>
<td>Contrase&ntilde;a</td>
</tr>
<tr>
<td>

              <input type="text" id="usuario" name="usuario" value="" onkeydown="if (event.keyCode == 13) { document.getElementById('formLoginEnter').submit(); return false; }" onfocus="this.value='';" onblur="if (this.value == '') this.value = '';">

</td>
<td>

              <input type="password" id="contrasenia" name="contrasenia" value="" onkeydown="if (event.keyCode == 13) { document.getElementById('formLoginEnter').submit(); return false; }" onfocus="this.value='';" onblur="if (this.value == '') this.value = '';">

</td>
</tr>
</table>

              <input type="submit" id="entrar" value="Entrar" class="boton"><br />
              <br />
              ¿ Olvidó su contraseña ? <a href="olvide.php">¡ Click Aquí !</a>

            </form>

            <?PHP } ?>

          </div>

        <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>
          <div class="registrarse" onclick="location.href='registro.php';">&nbsp;</div>
        <?PHP } ?>

        </div>

        <div class="oferta"><?PHP obtenerOfertaHome (); ?></div>

        <br />

        <?PHP include ("inc/novedades.php"); ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>

<?PHP if ($_GET ["login"] == "true") { ?>

<script type="text/javascript">

  document.getElementById ('usuario').focus ();

</script>

<?PHP } ?>
