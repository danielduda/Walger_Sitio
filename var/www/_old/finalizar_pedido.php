<?PHP

  ob_start ();
  session_start ();

  include_once ("inc/funciones.php");

  conectar ();

//  mysql_connect ("localhost", "root", "walger0000");
//  mysql_select_db ("walger");

  $q_ = mysql_query ("SELECT MAX(idPedido) AS m
                      FROM walger_pedidos
                      WHERE estado = 'N'
                      AND CodigoCli = '".$_SESSION ["cliente"]["CodigoCli"]."'");

  if (mysql_num_rows ($q_) > 0) {
    $f_ = mysql_fetch_array ($q_);
    $idPedido = $f_ ["m"];
  } else exit;
  
  mysql_query ("UPDATE walger_pedidos
                SET estado = 'X',
                comentario = '$_POST[comentario]',
                fechaEstado = NOW()
                WHERE CodigoCli = '".$_SESSION ["cliente"]["CodigoCli"]."'
                AND idPedido = $idPedido");

  include ("pedido_admin.php");
  $mensaje = ob_get_contents ();
  ob_end_clean ();

  include ("inc/encabezado.php");
 
  mysql_query ("UPDATE walger_items_pedidos
                SET estado = 'P'
                WHERE idPedido = $idPedido
                ");


  // Envia email con alta de datos ...
  $titulo = "Nuevo Pedido Web - Nro. " . $idPedido;
  $mensaje = convertLatin1ToHtml ($mensaje);

  $destinatario = "administracionventas@walger.com.ar";
  enviarEmail ($destinatario, $titulo, $mensaje);

  $destinatario = $_SESSION ["cliente"]["emailCli"];
  enviarEmail ($destinatario, $titulo, $mensaje);


?>

      <div class="contenido">

        <strong>Su pedido fue enviado con éxito. </strong><br />
        Un representante lo contactará dentro de las próximas 24Hs para perfeccionar la venta.<br />
        <br />
        No dude en <a href="consultar.php">contactarnos</a> ante cualquier consulta o sugerencia.<br />
        Muchas gracias !<br />

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
