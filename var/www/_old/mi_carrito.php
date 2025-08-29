<?PHP

  include ("inc/encabezado.php");

  if ($_GET ["pagina"] == "") $_GET ["pagina"] = 0;
  if (! is_numeric ($_GET ["pagina"])) $_GET ["pagina"] = 0;

  if ($_SESSION ["cliente"]["Habilitado"] != 'S') header ("location: index.php");

  $IN = "('N')";

?>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

        <strong>Ver mi Carrito</strong>

        <small></small><br /><br />

        <table class="listado">
          <tr class="titulos">
            <td>Código</td>
            <td>Descripción</td>
            <td>Precio&nbsp;(<?PHP echo ($_SESSION ['cliente'] ['Signo_Mda']); ?>)&nbsp;</td>
            <td>Cantidad</td>
            <td></td>
          </tr>

          <?PHP

            $CONSULTA = "SELECT walger_items_pedidos.CodInternoArti, DescripcionArti, Precio, Cantidad,
                                walger_items_pedidos.Estado, walger_items_pedidos.idPedido, walger_items_pedidos.idItemPedido, TasaIva
                         FROM dbo_articulo
                         INNER JOIN walger_items_pedidos ON dbo_articulo.CodInternoArti = walger_items_pedidos.CodInternoArti
                         INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
                         WHERE walger_pedidos.CodigoCli = '" . $_SESSION[cliente][CodigoCli] . "'
                         AND walger_pedidos.Estado IN $IN";

            $q = mysql_query ($CONSULTA);

            $PAGINAS = mysql_num_rows ($q) / 10;

            $q = mysql_query ("$CONSULTA
                               ORDER BY fechaEstado
                               LIMIT ".($_GET ["pagina"] * 10).", 10
                               ");

            while ($f = mysql_fetch_array ($q)) {

              if ($PAR != '') $PAR = ''; else $PAR = 'class="par"';

              $ELIMINAR = '<a href="eliminar_pedido.php?id='.$f ["idItemPedido"].'">Eliminar&nbsp;Item</a>';

              if ($f ['Estado'] == 'P') $f ['Estado'] = "Pendiente";
                else if ($f ['Estado'] == 'F') $f ['Estado'] = "Facturado";
                  else if ($f ['Estado'] == 'C') $f ['Estado'] = "Cancelado";


          ?>

          <tr <?PHP echo ($PAR); ?>>
            <td><?PHP echo ($f ['CodInternoArti']); ?></td>
            <td><a href="articulo.php?id=<?PHP echo ($f ['CodInternoArti']); ?>"><?PHP echo ($f ['DescripcionArti']); ?></a></td>
            <td>
<?PHP 

if($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final")
printf("%.2f", $f ['Precio']); 
else
printf("%.2f", $f ['Precio'] + $f ['Precio'] * $f ['TasaIva'] / 100);

//echo($f['TasaIva']);

?> &nbsp;</td>
            <td><?PHP echo ($f ['Cantidad']); ?> &nbsp;</td>
            <td><?PHP echo ($ELIMINAR); ?></td>
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

        <br /><br /><br />

        <?PHP include ("inc/novedades.php"); ?>
        
      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
