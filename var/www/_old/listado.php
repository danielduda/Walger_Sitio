<?PHP include ("inc/encabezado.php"); ?>

<?PHP

  if ($_GET ["pagina"] == "") $_GET ["pagina"] = 0;
  if (! is_numeric ($_GET ["pagina"])) $_GET ["pagina"] = 0;

?>

<script type="text/javascript">

  var _cantidad = 0;

</script>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

      <?PHP if ($_SESSION ["cliente"]["Habilitado"] != 'S') { ?>

        <small>Solo los usuarios registrados pueden ver los precios y realizar pedidos online. <br /></small><br /><br />

      <?PHP } else { ?>

        <small>(<?PHP if($_SESSION ["cliente"]["TipoCliente"] != "Consumidor Final") { ?>Los precios no incluyen IVA. <?PHP } ?>Consultar disponibilidad para aquellos productos en <strong style="color: orange;">naranja</strong>.)</small><br /><br />

      <?PHP } ?>

        <table class="listado">
          <tr class="titulos">
            <td>Código</td>
            <td>Descripción</td>
            <td align="right">Precio &nbsp; (<?PHP echo ($_SESSION ['cliente'] ['Signo_Mda']); ?>) &nbsp;</td>
            <td colspan="2">Cantidad</td>
          </tr>

          <?PHP

            if ($_GET ["catalogo"] == "Seleccione ...") $_GET ["catalogo"] = "";
            if ($_GET ["linea"] == "Seleccione ...") $_GET ["linea"] = "";
            if ($_GET ["marca"] == "Seleccione ...") $_GET ["marca"] = "";

            if ($_GET ["termino"] != "") {

              $termino = "%" . str_replace (" ", "%", $_GET ["termino"]) . "%";

              $WHERE = "WHERE CodInternoArti LIKE '$termino' OR DescripcionArti LIKE '$termino'
                        OR DescrNivelInt4 LIKE '$termino' OR DescrNivelInt3 LIKE '$termino'
                        OR DescrNivelInt2 LIKE '$termino' OR CodBarraArti LIKE '$termino' ";

            }

            if ($_GET ["catalogo"] != "") {

              $WHERE = "WHERE DescrNivelInt4 = '$_GET[catalogo]'";

            }

            if ($_GET ["linea"] != "") {

              $WHERE .= " AND DescrNivelInt3 = '$_GET[linea]'";

            }

            if ($_GET ["marca"] != "") {

              $WHERE .= " AND DescrNivelInt2 = '$_GET[marca]'";

            }

            $CONSULTA = "SELECT * 
                         FROM dbo_articulo $WHERE ";

            $q = mysql_query ($CONSULTA);

            $PAGINAS = mysql_num_rows ($q) / 10;

            $q = mysql_query ("$CONSULTA
                               ORDER BY CodInternoArti, DescripcionArti
                               LIMIT ".($_GET ["pagina"] * 10).", 10
                               ");



            while ($f = mysql_fetch_array ($q)) {

              if ($PAR != '') $PAR = ''; else $PAR = 'class="par"';

              if ($_SESSION ["cliente"]["Habilitado"] == 'S') {
                $f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
                $f ['PrecioVta1_PreArti'] = $f ['PrecioVta1_PreArti'] / $_SESSION ['cliente'] ['Cotiz_Mda']; 

		if ($_SESSION['cliente']["TipoCliente"] == "Consumidor Final")
        	{
                	$f ['PrecioVta1_PreArti'] += ($f ['PrecioVta1_PreArti'] * $f["TasaIva"] / 100);
        	}

        	$f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);


              } else {
                $f ['PrecioVta1_PreArti'] = " ";
              }

          ?>

          <tr <?PHP echo ($PAR); ?>>
            <td><?PHP echo ($f ['CodInternoArti']); ?></td>
            <td><a href="articulo.php?id=<?PHP echo ($f ['CodInternoArti']); ?>&d=<?PHP echo ($f ['DescripcionArti']); ?>"><?PHP echo ($f ['DescripcionArti']); ?></a></td>
            <td align="right"><?PHP echo ($f ['PrecioVta1_PreArti']); ?> &nbsp;</td>

            <?PHP if ($_SESSION ["cliente"]["Habilitado"] == 'S') { ?>

            <td><input type="text" class="cantidad" onkeypress="return (__numero (this, event));" onkeyup="_cantidad = this.value;" maxlength="5" /></td>
            <td><input <?PHP if ($f["Stock1_StkArti"] < 1) { ?>style="background-color: orange; border: 2px solid black;"<?PHP } else { ?>style="background-color: green; border: 2px solid black;"<?PHP } ?> type="button" id="comprar" value="Comprar" class="boton" onclick="comprar (_cantidad, '<?PHP echo ($f ["CodInternoArti"]); ?>');"></td>

            <?PHP } else { ?>

            <td></td><td></td>

            <?PHP } ?>

          </tr>

          <?PHP } ?>

          <tr>
            <td colspan="5" align="right">

              <?PHP

                $PAGINA_ACTUAL = curPageURL();
                if ($_GET ["pagina"] != "") $PAGINA_ACTUAL = substr($PAGINA_ACTUAL, 0, strpos($PAGINA_ACTUAL, "&pagina="));

              ?>

              <br />
              <?PHP if ($_GET ["pagina"] != 0) { ?>
              <a href="<?PHP echo ($PAGINA_ACTUAL . "&pagina=" . ($_GET ["pagina"] - 1) . "#pagina"); ?>">&laquo; Anterior</a> |
              <?PHP } ?>
              Página <?PHP echo ($_GET ["pagina"] + 1) ?> de <?PHP echo ((int) ($PAGINAS) + 1); ?>
              <?PHP if ($_GET ["pagina"] + 1 != (int)$PAGINAS + 1) { ?>
               | <a href="<?PHP echo ($PAGINA_ACTUAL . "&pagina=" . ($_GET ["pagina"] + 1) . "#pagina"); ?>">Siguiente &raquo;</a>
              <?PHP } ?>

            </td>
          </tr>
        </table>

        <br />

        <?PHP include ("inc/novedades.php"); ?>
        
      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
