<?PHP

    include ("inc/encabezado.php");

    $q = mysql_query ("SELECT *
                       FROM dbo_articulo
                       WHERE CodInternoArti = '$_GET[id]'
                       LIMIT 1");

    $f = mysql_fetch_array ($q);
    
    if ($_SESSION ["cliente"]["Cotiz_Mda"] != "") {
    
      $f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
      $f ['PrecioVta1_PreArti'] = $f ['PrecioVta1_PreArti'] / $_SESSION ["cliente"]["Cotiz_Mda"];

	if ($_SESSION['cliente']["TipoCliente"] == "Consumidor Final")
	{
		$f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $f["TasaIva"] / 100;
	}

	$f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);

    }

    if ($f ["CodInternoArti"] == "") header ("location: index.php");

    $imagen_aux = explode ("/", $f ["NombreFotoArti"]);
    $imagen_aux = $imagen_aux [count ($imagen_aux) - 1];
    if (($imagen_aux != "") && (file_exists ("articulos/$imagen_aux"))) $imagen = '<img src="articulos/'.$imagen_aux.'" alt="" width="228" />';

?>

<script type="text/javascript">

  var _cantidad = 0;

$(document).ready(function(){
if($('div.imagen_grande').size()<1){
$(".articulo").append('<div class="imagen_grande"><img src="articulos/imagen no disponible.jpg" alt="" width="228"></div>');}
});

</script>

      <div class="contenido">

        <div class="articulo">

        <?PHP if ($imagen != "") { ?>

          <div class="imagen_grande">

            <?PHP echo ($imagen); ?>

          </div>

        <?PHP } ?>

          <div class="datos_grande" style=" width: 450px;" <?PHP if ($imagen == "") { ?>style="float: left; margin-left: 70px;"<?PHP } ?>>

            <strong>Código:</strong> <?PHP echo ($f ["CodInternoArti"]); ?><br />
            <strong>Código de Barras:</strong> <?PHP echo ($f ["CodBarraArti"]); ?><br />
            <strong>Catálogo:</strong> <?PHP echo ($f ["DescrNivelInt4"]); ?><br />
            <strong>Línea:</strong> <?PHP echo ($f ["DescrNivelInt3"]); ?><br />
            <strong>Marca:</strong> <?PHP echo ($f ["DescrNivelInt2"]); ?><br />
            <strong>Descripción</strong>: <?PHP echo ($f ["DescripcionArti"]); ?><br />
            <?PHP if ($_SESSION ["cliente"]["Habilitado"] == 'S') { ?>
            <strong>Stock:</strong> 
            <?PHP 
              if ($f ["Stock1_StkArti"] > 0) echo ('<strong style="color: green;">Disponible</strong>');
              else echo ('<strong style="color: orange">Consultar</strong>');
            ?><br />
            <strong>Precio:</strong> <?PHP echo ($_SESSION ["cliente"]["Signo_Mda"]); ?><?PHP echo ($f ["PrecioVta1_PreArti"]); ?><br />
            <br />
            <strong>Cantidad:</strong> <input type="text" id="cantidad" onkeypress="return (__numero (this, event));" onkeyup="_cantidad = this.value;" maxlength="5" />
            <input type="button" id="comprar" value="Comprar" class="boton" onclick="comprar (_cantidad, '<?PHP echo ($f ["CodInternoArti"]); ?>');">
            <br />
            <?PHP } ?>


            <br />
            
            <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>
            <a href="registro.php">Para ver los precios y comprar online debe registrarse haciendo click aquí &raquo;</a>
            <br /><br />
            <?PHP } ?>
            <a href="javascript:history.go(-1);">Volver &raquo;</a>

          </div>

        </div>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
