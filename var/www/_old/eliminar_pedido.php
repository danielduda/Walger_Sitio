<?PHP

  include ("inc/encabezado.php");

  mysql_query ("DELETE walger_items_pedidos FROM walger_items_pedidos
                INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
                WHERE idItemPedido = '$_GET[id]'
                AND CodigoCli = '".$_SESSION ["cliente"]["CodigoCli"]."'
                AND walger_pedidos.estado = 'N' ");

  header ("location: mi_carrito.php");

?>