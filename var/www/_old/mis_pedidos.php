<?PHP

  $STYLE_BODY = "height: 900px;";

  include ("inc/encabezado.php");

  if ($_SESSION ["cliente"]["Habilitado"] != 'S') header ("location: index.php");

?>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

        <strong>Mis Pedidos</strong><br /><br />

        <select onchange="location.href = 'mis_pedidos.php?pedido=' + this.value;">

          <?PHP

            $q_ = mysql_query ("SELECT idPedido, fechaEstado, fechaFacturacion, factura, estado
                                FROM walger_pedidos
                                WHERE estado NOT IN ('N')
                                AND CodigoCli = '" . $_SESSION[cliente][CodigoCli] . "'
                                ORDER BY idPedido DESC");



            $i = 0;

            while ($f_ = mysql_fetch_array ($q_)) {

              if (($i == 0) && ($_GET ["pedido"] == "")) $_GET ["pedido"] = $f_ ["idPedido"];
              $i ++;

              if ($_GET ["pedido"] == $f_ ["idPedido"]) {
                $SELECTED = " SELECTED ";
                $FACTURA = $f_ ["factura"];
                $FECHA_ENTREGADO = $f_ ["fechaFacturacion"];
              }
              else $SELECTED = "";

              if ($f_ ['estado'] == 'N') $f_ ['estado'] = "No Confirmado";
              else if ($f_ ['estado'] == 'P') $f_ ['estado'] = "Pendiente";
                else if ($f_ ['estado'] == 'F') $f_ ['estado'] = "Facturado";
                  else if ($f_ ['estado'] == 'C') $f_ ['estado'] = "Cancelado";
                    else if ($f_ ['estado'] == 'X') $f_ ['estado'] = "Confirmado sin entregar";
                      else if ($f_ ['estado'] == 'E') $f_ ['estado'] = "En preparación";

          ?>

          <option value="<?PHP echo ($f_ ["idPedido"]); ?>" <?PHP echo ($SELECTED); ?>>Pedido Nro: <?PHP echo ($f_ ["idPedido"]); ?> (<?PHP echo ($f_ ["estado"]); ?>)</option>

          <?PHP

            }

          ?>

        </select>

        <br /><br />
        <?PHP if ($FACTURA != "") echo ("<b>Factura:</b> $FACTURA - <b>Fecha: </b> $FECHA_ENTREGADO<br />");  ?>
        <br />

				<div style="border: 1px solid grey; width: 770px; height: 300px; overflow: auto;">

        <table class="listado">
          <tr class="titulos">
            <td>C&oacute;digo</td>
            <td>Descripci&oacute;n</td>
            <td>Precio &nbsp;(<?PHP echo ($_SESSION ['cliente'] ['Signo_Mda']); ?>)&nbsp;</td>
            <td>Cantidad</td>
            <td>Sub Total</td>
            <td>IVA</td>
          </tr>

          <?PHP

            $CONSULTA = "SELECT walger_items_pedidos.CodInternoArti, DescripcionArti, Precio, Cantidad,
                                walger_items_pedidos.Estado, walger_pedidos.idPedido,
                                walger_items_pedidos.idItemPedido,
                                TasaIva
                         FROM dbo_articulo
                         INNER JOIN walger_items_pedidos ON dbo_articulo.CodInternoArti = walger_items_pedidos.CodInternoArti
                         INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
                         WHERE walger_pedidos.CodigoCli = '" . $_SESSION[cliente][CodigoCli] . "'
                         AND walger_pedidos.idPedido = '". $_GET ["pedido"] ."'
                         ORDER BY walger_items_pedidos.CodInternoArti, DescripcionArti ";

            $q = mysql_query ($CONSULTA);

            while ($f = mysql_fetch_array ($q)) {

              if ($PAR != '') $PAR = ''; else $PAR = 'class="par"';

//              if ($f ['Estado'] == 'N') $ELIMINAR = '<a href="eliminar_pedido.php?id='.$f ["idPedido"].'">(Cancelar)</a>';
//              else $ELIMINAR = "";

          ?>

          <tr <?PHP echo ($PAR); ?>>
            <td><?PHP echo ($f ['CodInternoArti']); ?></td>
            <td><a href="articulo.php?id=<?PHP echo ($f ['CodInternoArti']); ?>"><?PHP echo ($f ['DescripcionArti']); ?></a></td>
            <td><?PHP printf("%.2f", $f ['Precio']); ?> &nbsp;</td>
            <td><?PHP echo ($f ['Cantidad']); ?> &nbsp;</td>
            <td><?PHP printf("%.2f", $f ['Cantidad'] * $f ['Precio']); ?> &nbsp;</td>
            <td><?PHP printf("%.2f", $f ['Cantidad'] * $f ['Precio'] * $f ['TasaIva'] / 100); ?> (<?PHP echo ($f ["TasaIva"]); ?>%) &nbsp; <?PHP echo ($ELIMINAR); ?> </td>
          </tr>

          <?PHP

            $TOTAL += $f ['Cantidad'] * $f ['Precio'];
            $IVA += $f ['Cantidad'] * $f ['Precio'] * $f ['TasaIva'] / 100;

          ?>

          <?PHP } ?>

        </table>

				</div>

        <br />

        <table class="listado" width="100%">
          <tr class="titulos">
            <td width="600"></td>
            <td align="right">Total</td>
            <td width="30">&nbsp;</td>
            <td align="right">Total&nbsp;con&nbsp;IVA</td>
          </tr>
          <tr>
            <td></td>
            <td align="right"><?PHP printf("%.2f", $TOTAL); ?></td>
            <td width="30">&nbsp;</td>
            <td align="right"><?PHP printf("%.2f", $TOTAL + $IVA); ?></td>
          </tr>
        </table>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
