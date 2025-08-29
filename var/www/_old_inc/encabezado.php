<?PHP

  ob_start ();

  session_start ();
  error_reporting (E_ALL ^ E_NOTICE);

  $_GET ["c"] = $_SESSION ["cliente"]["CodigoCli"];
  $_GET ["vtos"] = "true";

  include ("vto.php");

  include_once ("inc/funciones.php");

  escaparComillas ();

  conectar ();  

  actualizacionEnCurso ();
  
  $TITULO = "Tienda Virtual";
  if ($_GET ["catalogo"] != "") $TITULO = $_GET ["catalogo"];
  if ($_GET ["linea"] != "") $TITULO .= " - " . $_GET ["linea"];
  if ($_GET ["marca"] != "") $TITULO .= " - " . $_GET ["marca"];

  if ($_GET ["termino"] != "") $TITULO = $_GET ["termino"];

  $KEYWORDS = str_replace (" ", ",", $TITULO);
  $KEYWORDS = str_replace ("-", "", $KEYWORDS);
  $KEYWORDS = str_replace (",,", ",", $KEYWORDS);

  if ($_SESSION ["cliente"]["Habilitado"] == 'S') {


    $COUNT_MI_CARRITO = mysql_query (
		"SELECT COUNT(*) FROM walger_pedidos AS wp ".
		"INNER JOIN walger_items_pedidos AS wip ON (wp.idPedido = wip.idPedido AND wip.estado = 'P')  ".
		"WHERE CodigoCli = '".$_SESSION ["cliente"]["CodigoCli"]."' AND wp.estado = 'N' ");

    $COUNT_MI_CARRITO = mysql_fetch_array ($COUNT_MI_CARRITO);
    $COUNT_MI_CARRITO = $COUNT_MI_CARRITO[0];

  } 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title><?PHP echo ($TITULO); ?> - WALGER</title>
  <link rel="stylesheet" href="css/common.css" type="text/css" media="screen" />
  <script type="text/javascript" src="js/common.js"></script>
  <script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <meta name="description" content="<?PHP echo ($TITULO); ?>" />
  <meta name="keywords" content="<?PHP echo ($KEYWORDS); ?>" />
  <meta name="robots" content="index, follow" />  
</head>
<body>

  <div class="principal">

    <div class="encabezado">
                        
      <h1><?PHP echo ($TITULO); ?></h1>
      <h2>Walger</h2>
      <h3>Importación y Exportación de Autopartes</h3>

      <?PHP if (! $OCULTAR_USUARIO) { ?>

        <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>
        <span class="bienvenido">Bienvenido, Invitado</span>
        <?PHP } else { ?>
        <span class="bienvenido">Bienvenido, <?PHP if ($_SESSION ["cliente"]["ApellidoNombre"] != "") echo ($_SESSION ["cliente"]["ApellidoNombre"]); else echo ($_SESSION ["cliente"]["RazonSocialCli"]); ?></span>
        <?PHP } ?>

        <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>
        <span class="login"><a href="index.php?login=true#login">Login</a></span>
        <?PHP } else { ?>
        <span class="login"><a href="logout.php">Salir</a></span>
        <?PHP } ?>

      <?PHP } else { ?>

        <span class="bienvenido">&nbsp;</span>
        <span class="login">&nbsp;</span>

      <?PHP } ?>
      <ul class="menu_izquierda" style="font-size: 13px;">
        <li><a href="index.php">Home</a></li>
        <?PHP if ($_SESSION ["cliente"]["Habilitado"] == 'S') { ?>
          <li class="separador"> | </li>

<?PHP 

	$_GET ["c"] = $_SESSION ["cliente"]["CodigoCli"];
	$_GET ["vtos"] = "true";
	
//	include ("vto.php");

?>

	  <li><a href="mi_cuenta.php" style="<?PHP  if ($VTOS == "false") echo('color: #99FF66;'); else echo('color: red;'); ?>">Mi Cuenta</a></li><li class="separador"> | </li>

          <li><a href="registro.php?editar=true">Editar mi cuenta</a></li><li class="separador"> | </li>
          <li><a href="mi_carrito.php">Ver mi carrito</a> (<?PHP echo($COUNT_MI_CARRITO); ?>)</li><li class="separador"> | </li>
          <li><a href="realizar_pedido.php">Realizar pedido</a></li><li class="separador"> | </li>
          <li><a href="mis_pedidos.php">Mis pedidos</a></li><li class="separador"> | </li>
          <li><a href="formas_pago.php">Formas de Pago</a></li><li class="separador"> | </li>
          <li><a href="descargas.php">Descargas</a></li><li class="separador"> | </li>
          <li><a href="http://www.walger.com.ar/CatalogosWalger/CatalogoIndexGeneral.html">Catalogos</a></li>
        <?PHP } ?>
      </ul>

      <ul class="menu_derecha" style="font-size: 13px;">
        <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>
          <?PHP if (! $OCULTAR_USUARIO) { ?>
            <li><a href="registro.php">Registrarme</a></li><li class="separador"> | </li>
          <?PHP } ?>
        <?PHP } ?>
        <li><a href="http://www.walger.com.ar/" target="_blank">Sitio Institucional</a></li>
      </ul>

    </div>

    <div class="cuerpo" style="<?PHP echo ($STYLE_BODY); ?>">

      <div class="menu_cuerpo">

        <div class="combos">

          Catálogo<br />
          <div id="div_catalogo"><?PHP obtenerCombo ('catalogo', 'DescrNivelInt4'); ?></div><br />
          Línea<br />
          <div id="div_linea"><?PHP obtenerCombo ('linea', 'DescrNivelInt3'); ?></div><br />
          Marca<br />
          <div id="div_marca"><?PHP obtenerCombo ('marca', 'DescrNivelInt2'); ?></div><br />
          <br />
          <br />

        </div>
        
        <strong>Buscar</strong>
        <input type="text" id="termino" value="<?PHP echo ($_GET ["termino"]); ?>" onkeydown="if (window.event.keyCode == 13) document.getElementById ('buscar').onclick ();" /> <input type="button" id="buscar" value="Buscar" class="boton" onclick="buscar (document.getElementById ('termino').value);"><br />
        <br />
        <br />
        <strong>Consultas</strong>
        <input type="button" id="consultar" value="Consultar" class="boton" onclick="location.href = 'consultar.php';"><br />
        <br />
        <br />
        <strong>¡ Ofertas !</strong>
        <div class="ofertas">

          <?PHP obtenerOfertas (); ?>

        </div>

      </div> 
