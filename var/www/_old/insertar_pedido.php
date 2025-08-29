<?PHP

  include ("inc/encabezado.php");

  if (($_GET ["codigo"] != "") && ($_GET ["cantidad"] != "") && ($_GET ["cantidad"] != "0")) {

    $q = mysql_query ("SELECT PrecioVta1_PreArti AS p FROM dbo_articulo WHERE CodInternoArti = '".$_GET ["codigo"]."'");

    $f = mysql_fetch_array ($q);
    $f ['p'] += $f ['p'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
    $f ['p'] = $f ['p'] / $_SESSION ["cliente"]["Cotiz_Mda"];

    $q_ = mysql_query ("SELECT idPedido FROM walger_pedidos
                        WHERE estado = 'N'
						AND CodigoCli = '".$_SESSION ["cliente"]["CodigoCli"]."'");

    $f_ = mysql_fetch_array ($q_);
    if (mysql_num_rows ($q_) > 0) $idPedido = $f_ ["idPedido"];
    else {

      mysql_query ("INSERT INTO walger_pedidos (CodigoCli, estado, fechaEstado) VALUES ('".$_SESSION ["cliente"]["CodigoCli"]."', 'N', NOW())");
      $idPedido = mysql_insert_id ();

    }

    mysql_query ("INSERT INTO walger_items_pedidos (idPedido, CodInternoArti, precio, cantidad, estado)
                  VALUES ($idPedido, '$_GET[codigo]', '$f[p]', '$_GET[cantidad]', 'P')");

    header ("location: insertar_pedido.php");

  }

?>

      <div class="contenido">

        <strong>Su pedido fue incorporado con éxito al carrito de compras. <a href="javascript:history.go (-1);">Regresar al listado</a></strong>.<br />
        Recuerde confirmar su compra una vez finalizada desde la opción de <a href="realizar_pedido.php">Realizar Pedido</a><br />
        <br />
        Muchas gracias !<br />

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
