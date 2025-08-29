<?PHP

  if (! isSet ($_GET ["idPedido"])) $_GET ["idPedido"]  = $idPedido;
  else {

    include ("inc/funciones.php");
    conectar ();

  }

  $CONSULTA = "SELECT walger_items_pedidos.CodInternoArti, DescripcionArti, Precio, Cantidad,
               walger_items_pedidos.Estado, walger_pedidos.idPedido, walger_pedidos.fechaEstado AS FECHAPED,
               walger_items_pedidos.idItemPedido, walger_clientes.CodigoCli AS CCLI, dbo_cliente.Telefono AS TELE, dbo_cliente.IngbrutosCLI AS INGBRUT,dbo_cliente.CuitCli AS CUIT, dbo_ivacondicion.DescrIvaC AS DESCRIVA,
               TasaIva, RazonSocialCli, Direccion, BarrioCli, LocalidadCli, DescrProvincia, CodigoPostalCli, DescrPais, RazonSocialFlete, walger_pedidos.Comentario, dbo_moneda.Signo_Mda
               FROM dbo_articulo
               INNER JOIN walger_items_pedidos ON dbo_articulo.CodInternoArti = walger_items_pedidos.CodInternoArti
               INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
               INNER JOIN dbo_cliente ON dbo_cliente.CodigoCli = walger_pedidos.CodigoCli
               INNER JOIN dbo_ivacondicion ON dbo_cliente.Regis_ivaC = dbo_ivacondicion.Regis_ivaC
               INNER JOIN walger_clientes ON dbo_cliente.CodigoCli = walger_clientes.CodigoCli
                       LEFT JOIN dbo_moneda on dbo_moneda.Regis_Mda = walger_clientes.Regis_Mda
               WHERE walger_pedidos.idPedido = '". $_GET ["idPedido"] ."'
               ORDER BY walger_items_pedidos.CodInternoArti, DescripcionArti ";

  $q = mysql_query ($CONSULTA);
  $f = mysql_fetch_array ($q);

  if ($f ["Signo_Mda"] == "") $f ["Signo_Mda"] = "$";

?>

<html>
<body>
<!--
  <img src="http://servidor.walger.com.ar/imgs/mail.gif" height="162" width="841" />

  <br />
-->
  <table cellpadding="20" width="100%">
  <img src="http://servidor.walger.com.ar/imgs/mail.gif" height="162" width="841" />
   <table width="100%" border="1">
    <tr><td><b>Pedido Número:</b> <?PHP echo ($f ["idPedido"]); ?> </td>
       <td> <b>Fecha y Hora Pedido:</b> <?PHP echo ($f ["FECHAPED"]); ?>
       <td> <b>Codigo Cliente:</b> <?PHP echo ($f ["CCLI"]); ?>

        <b>Cliente:</b> <?PHP echo ($f ["RazonSocialCli"]); ?><br /> </td>
        <table width="100%" border="1">
        <tr>
        <td><b>Dirección:</b>
        <?PHP echo ($f ["Direccion"]); ?>
        <?PHP echo ($f ["BarrioCli"]); ?>
         <?PHP echo ($f ["LocalidadCli"]); ?>
        (<?PHP echo ($f ["CodigoPostalCli"]); ?>)
        <?PHP echo ($f ["DescrProvincia"]); ?>
        <?PHP echo ($f ["DescrPais"]); ?>
        <br />        </td>
     <td><b>Telefono:</b> <?PHP echo ($f ["TELE"]); ?><br />  </td>   </tr>
      <table width="100%" border="1">
      <tr>
     <td><b>Ing. Brutos:</b> <?PHP echo ($f ["INGBRUT"]); ?><br />  </td>
     <td><b>Nro. Cuit:</b> <?PHP echo ($f ["CUIT"]); ?><br />  </td>
     <td><b>Tipo IVA:</b> <?PHP echo ($f ["DESCRIVA"]); ?><br />  </td>
     <td> <b>Transporte:</b> <?PHP echo ($f ["RazonSocialFlete"]); ?><br />
				<br />  </td>   </tr>

        <table width="100%" border="1">
          <tr>
            <td>Código</td>
            <td>Descripción</td>
            <td>Cantidad</td>
            <td>Precio &nbsp;(<?PHP echo ($f ['Signo_Mda']); ?>)&nbsp;</td>
            <td>Total Línea</td>
          </tr>

          <?PHP

						mysql_data_seek($q, 0);

            while ($f2 = mysql_fetch_array ($q)) {


          ?>

          <tr>
            <td><?PHP echo ($f2 ['CodInternoArti']); ?></td>
            <td><?PHP echo ($f2 ['DescripcionArti']); ?></td>
            <td align ="right"><?PHP echo ($f2 ['Cantidad']); ?> &nbsp;</td>
            <td align ="right"><?PHP printf("%.2f", $f2 ['Precio']); ?> &nbsp;</td>
           <td align ="right"><?PHP echo($f2 ['Cantidad']* $f2['Precio']); ?></td>

          </tr>

          <?PHP

            $SUBTOTAL += $f2 ['Cantidad'] * $f2 ['Precio'];
            $IVA += $f2 ['Cantidad'] * $f2 ['Precio'] * $f2 ['TasaIva'] / 100;

          ?>

          <?PHP } ?>

        </table>

        <br />

        <table width="100%" border="2">
          <tr>
            <td align="right">Subtotal&nbsp;&nbsp;<?PHP printf("%.2f", $SUBTOTAL); ?></td>
          </tr>
          <tr>
            <td align="right">IVA&nbsp;&nbsp;<?PHP printf("%.2f", $IVA); ?></td>
          </tr>
          <tr>
            <td align="right">TOTAL&nbsp;&nbsp;<?PHP printf("%.2f", $IVA + $SUBTOTAL); ?></td>
          </tr>
        </table>

			  <br /><br />
				<b>Comentario:</b> <i><?PHP echo ($f ['Comentario']); ?></i> -<br />
				<br />
				<br />				

				Gracias por comprar en nuestra tienda virtual.<br />
				Le recordamos que los pedidos se procesarán en orden de llegada y que podrá verificar el estado de su pedido on line.

      </td>
    </tr>
  </table>

</body>
</html>
