<?PHP

  $STYLE_BODY = "height: 900px;";

  include ("inc/encabezado.php");

  if ($_SESSION ["cliente"]["Habilitado"] != 'S') header ("location: index.php");

?>

      <a name="pagina">&nbsp;</a>

      <div class="contenido">

        <strong>Realizar Pedido</strong><br /><br />

				<div style="border: 1px solid grey; width: 770px; height: 450px; overflow: auto;">

        <table class="listado">
          <tr class="titulos">
            <td>Código</td>
            <td>Descripción</td>
            <td>Precio &nbsp;(<?PHP echo ($_SESSION ['cliente'] ['Signo_Mda']); ?>)&nbsp;</td>
            <td>Cantidad</td>
<?PHP if($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final") { ?>
            <td>Sub Total</td>
            <td>IVA</td>
<?PHP } ?>
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
                         AND walger_pedidos.Estado = 'N'
                         ORDER BY walger_items_pedidos.CodInternoArti, DescripcionArti ";

            $q = mysql_query ($CONSULTA);

            while ($f = mysql_fetch_array ($q)) {

              if ($PAR != '') $PAR = ''; else $PAR = 'class="par"';

//              if ($f ['Estado'] == 'N') $ELIMINAR = '<a href="eliminar_pedido.php?id='.$f ["idPedido"].'">(Cancelar)</a>';
//              else $ELIMINAR = "";


		if($_SESSION["cliente"]["TipoCliente"] == "Consumidor Final") 
		{

			$f ['Precio'] = $f ['Precio'] + $f ['Precio'] * $f ['TasaIva'] / 100;

		}

          ?>

          <tr <?PHP echo ($PAR); ?>>
            <td><?PHP echo ($f ['CodInternoArti']); ?></td>
            <td><a href="articulo.php?id=<?PHP echo ($f ['CodInternoArti']); ?>"><?PHP echo ($f ['DescripcionArti']); ?></a></td>
            <td><?PHP printf("%.2f", $f ['Precio']); ?> &nbsp;</td>
            <td><?PHP echo ($f ['Cantidad']); ?> &nbsp;</td>

<?PHP if($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final") { ?>

            <td><?PHP printf("%.2f", $f ['Cantidad'] * $f ['Precio']); ?> &nbsp;</td>
            <td><?PHP printf("%.2f", $f ['Cantidad'] * $f ['Precio'] * $f ['TasaIva'] / 100); ?> (<?PHP echo ($f ["TasaIva"]); ?>%) &nbsp; <?PHP echo ($ELIMINAR); ?> </td>

<?PHP } ?>

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
<?PHP if($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final") { ?>
            <td width="30">&nbsp;</td>
            <td align="right">Total&nbsp;con&nbsp;IVA</td>
<?PHP } ?>
          </tr>
          <tr>
            <td></td>
            <td align="right"><?PHP printf("%.2f", $TOTAL); ?></td>
<?PHP if($_SESSION["cliente"]["TipoCliente"] != "Consumidor Final") { ?>
            <td width="30">&nbsp;</td>
            <td align="right"><?PHP printf("%.2f", $TOTAL + $IVA); ?></td>
<?PHP } ?>
          </tr>
        </table>

        <?PHP if ($TOTAL != 0) { ?>

        <form action="finalizar_pedido.php" method="post">

          Si desea hacernos algun comentario o aclaración, hagalo a continuación :<br />
          <textarea name="comentario" style="width: 500px; height: 120px;"></textarea><br />

          <input type="submit" value="Finalizar Pedido" />

        </form>

        <?PHP } ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
