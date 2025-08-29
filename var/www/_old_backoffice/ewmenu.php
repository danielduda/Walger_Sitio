		<img src="http://servidor.walger.com.ar/imgs/logo.jpg" />
<br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php if (IsLoggedIn()) { ?>
  <tr><td><strong style="font-size: 10px;">ISIS</strong></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="dbo_articulolist.php?cmd=resetall&order=CodInternoArti">Artículos</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="dbo_clientelist.php?cmd=resetall&order=RazonSocialCli">Clientes</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="dbo_ivacondicionlist.php?cmd=resetall">Condiciones IVA</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="dbo_listaprecioslist.php?cmd=resetall">Listas de precios</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="dbo_monedalist.php?cmd=resetall">Monedas</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
  <tr><td><br /><strong style="font-size: 10px;">WEB</strong></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_actualizacioneslist.php?cmd=resetall">Actualizaciones</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_articuloslist.php?cmd=resetall&order=CodInternoArti">Artículos</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_clienteslist.php?cmd=resetall&order=UltimoLogin&ordertype=DESC">Clientes</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_ofertaslist.php?cmd=resetall&order=fecha&ordertype=DESC">Ofertas</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>

<?PHP 
$qPedidos = "SELECT COUNT(*) AS c FROM walger_pedidos WHERE estado = 'X';";  
$qPedidos = mysql_query($qPedidos);
$qPedidos = mysql_fetch_array($qPedidos);
?>


	<tr><td><span class="phpmaker"><a href="walger_pedidoslist.php?x_estado=X&z_estado=%3D">Pedidos (<?PHP echo($qPedidos["c"]); ?>)</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_usuarioslist.php?cmd=resetall">Usuarios</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="walger_items_pedidoslist.php?cmd=resetall&order=idPedido&ordertype=DESC">Items Pedidos</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
  <tr><td><span class="phpmaker"><a href="estadisticas.php" target="_blank">Estadisticas</a></span></td></tr>
<?php } ?>
<?php if (IsLoggedIn()) { ?>
	<tr><td><span class="phpmaker"><a href="logout.php">Salir</a></span></td></tr>
<?php } elseif (substr(ew_ScriptName(), -1*strlen("login.php")) <> "login.php") { ?>
	<tr><td><span class="phpmaker"><a href="login.php">Ingresar</a></span></td></tr>
<?php } ?>
</table>
