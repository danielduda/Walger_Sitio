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

        <small>Solo los usuarios registrados pueden ver los precios y realizar pedidos online.</small><br /><br />

      <?PHP } else { ?>

        <small>(Los precios no incluyen IVA)</small><br /><br />

      <?PHP } ?>

        <table class="listado">
          <tr class="titulos">
            <td>Código</td>
            <td>Código de Barras</td>
            <td>Descripción</td>
            <td align="right">Precio &nbsp;(<?PHP echo ($_SESSION ['cliente'] ['Signo_Mda']); ?>)&nbsp;</td>
            <td colspan="2">Cantidad</td>
          </tr>

          <?PHP


            $CONSULTA = "SELECT DescripcionArti, walger_articulos.CodInternoArti, NombreFotoArti, PrecioVta1_PreArti, CodBarraArti
                         FROM dbo_articulo
                         INNER JOIN walger_articulos ON walger_articulos.CodInternoArti = dbo_articulo.CodInternoArti
                         WHERE oferta = 'S'";

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
                $f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);
              } else {
                $f ['PrecioVta1_PreArti'] = " ";
              }

          ?>

          <tr <?PHP echo ($PAR); ?>>
            <td><?PHP echo ($f ['CodInternoArti']); ?></td>
            <td><?PHP echo ($f ['CodBarraArti']); ?></td>
            <td><a href="articulo.php?id=<?PHP echo ($f ['CodInternoArti']); ?>"><?PHP echo ($f ['DescripcionArti']); ?></a></td>
            <td align="right"><?PHP echo ($f ['PrecioVta1_PreArti']); ?> &nbsp;</td>

            <?PHP if ($_SESSION ["cliente"]["Habilitado"] == 'S') { ?>

            <td><input type="text" class="cantidad" onkeypress="return (__numero (this, event));" onkeyup="_cantidad = this.value;" maxlength="5" /></td>
            <td><input type="button" id="comprar" value="Comprar" class="boton" onclick="comprar (_cantidad, '<?PHP echo ($f ["CodInternoArti"]); ?>');"></td>

            <?PHP } else { ?>

            <td></td><td></td>

            <?PHP } ?>

          </tr>

          <?PHP } ?>

          <tr>
            <td colspan="5" align="right">

              <?PHP

                $PAGINA_ACTUAL = curPageURL();
                if ($_GET ["pagina"] != "") $PAGINA_ACTUAL = substr($PAGINA_ACTUAL, 0, strpos($PAGINA_ACTUAL, "?pagina="));

              ?>

              <br />
              <?PHP if ($_GET ["pagina"] != 0) { ?>
              <a href="<?PHP echo ($PAGINA_ACTUAL . "?pagina=" . ($_GET ["pagina"] - 1) . "#pagina"); ?>">&laquo; Anterior</a> |
              <?PHP } ?>
              Página <?PHP echo ($_GET ["pagina"] + 1) ?> de <?PHP echo ((int) ($PAGINAS) + 1); ?>
              <?PHP if ($_GET ["pagina"] + 1 != (int)$PAGINAS + 1) { ?>
               | <a href="<?PHP echo ($PAGINA_ACTUAL . "?pagina=" . ($_GET ["pagina"] + 1) . "#pagina"); ?>">Siguiente &raquo;</a>
              <?PHP } ?>

            </td>
          </tr>
        </table>

        <br />

        <?PHP include ("inc/novedades.php"); ?>
        
      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
