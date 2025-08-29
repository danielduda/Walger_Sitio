<?PHP include ("inc/encabezado.php"); ?>

      <div class="contenido">

        <?PHP if ($VTOS == "true") { ?>
	<a href="mi_cuenta.php" style="color: red; text-decoration: underline;">Verifique el estado de su cuenta haciendo click aqu&iacute;</a><br /><br />
	<?PHP } ?>

        <?PHP echo ($_SESSION ["MENSAJE_LOGIN"]); ?>

        <br /><br /><br /><br />

        <?PHP include ("inc/novedades.php"); ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
