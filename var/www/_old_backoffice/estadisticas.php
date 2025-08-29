<?PHP 

  include ("../inc/funciones.php");
  conectar ();
  
  if ($_POST ["enviar"] == "Enviar") {

    $query = mysql_query ("select * from walger_logins where fecha between '$_POST[desdeAnio]-$_POST[desdeMes]-$_POST[desdeDia]' AND '$_POST[hastaAnio]-$_POST[hastaMes]-$_POST[hastaDia]' ORDER BY fecha");

  } else {
  
	  $_POST[desdeAnio] = "2010";
	  $_POST[desdeMes] = "01";
	  $_POST[desdeDia] = "01";
	  $_POST[hastaAnio] = "2010";
	  $_POST[hastaMes] = "01";
	  $_POST[hastaDia] = "31";
  
  }
  
?>

<html>
<head>
<title>Estadisticas</title>
</head>
<body>

<form method="post" action="estadisticas.php">

<table>
  <tr>
    <td><strong>Fecha Desde (DD-MM-AAAA)</strong></td>
    <td>
      <input type="text" value="<?PHP echo ($_POST ["desdeDia"]); ?>" name="desdeDia" size="2" maxlength="2" />
      <input type="text" value="<?PHP echo ($_POST ["desdeMes"]); ?>" name="desdeMes" size="2" maxlength="2" />
      <input type="text" value="<?PHP echo ($_POST ["desdeAnio"]); ?>" name="desdeAnio" size="4" maxlength="4" />
    </td>
  </tr>
  <tr>
    <td><strong>Fecha Hasta (DD-MM-AAAA)</strong></td>
    <td>
      <input type="text" value="<?PHP echo ($_POST ["hastaDia"]); ?>" name="hastaDia" size="2" maxlength="2" />
      <input type="text" value="<?PHP echo ($_POST ["hastaMes"]); ?>" name="hastaMes" size="2" maxlength="2" />
      <input type="text" value="<?PHP echo ($_POST ["hastaAnio"]); ?>" name="hastaAnio" size="4" maxlength="4" />
    </td>
  </tr>
  <tr><td colspan="2"><input type="submit" value="Enviar" name="enviar" /></td></tr>
</table>

</form>

<?PHP 

  if ($_POST ["enviar"] == "Enviar") {

?>

<table border="1">
  <tr>
    <td><strong>Fecha</strong></td>
    <td><strong>Cliente</strong></td>
    <td><strong>Usuario</strong></td>
  </tr>
  
  <?PHP while ($f = mysql_fetch_array ($query)) { ?>

  <tr>
    <td><?PHP echo ($f ["fecha"]); ?></td>
    <td><?PHP echo ($f ["RazonSocialCli"]); ?></td>
    <td><?PHP echo ($f ["emailCli"]); ?></td>
  </tr>

  
  <?PHP } ?>
  
</table>

<table>
  <tr>
    <td><strong>Total</strong></td>
    <td><?PHP echo (mysql_num_rows ($query)); ?></td>
  </tr>
</table>

<?PHP 

  }

?>

</body>
</html>
