<?PHP $OCULTAR_USUARIO = true; include ("inc/encabezado.php");

  if (($_POST ["usuario"] == "") || ($_POST ["usuario"] == "Usuario") ||
     ($_POST ["contrasenia"] == "") || ($_POST ["contrasenia"] == "Password")) {

     header ("location: index.php");

  } else {

    $q = mysql_query ("SELECT * FROM dbo_cliente
                       INNER JOIN dbo_listaprecios on dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec
                       INNER JOIN dbo_ivacondicion on dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC
                       INNER JOIN walger_clientes on dbo_cliente.CodigoCli = walger_clientes.CodigoCli
                       LEFT JOIN dbo_moneda on dbo_moneda.Regis_Mda = walger_clientes.Regis_Mda
                       WHERE eMailCli = '$_POST[usuario]'
                       AND Contrasenia = '$_POST[contrasenia]'
                       AND Habilitado = 'S'
                       LIMIT 1");

    if (mysql_num_rows ($q) == 1) {

      $f = mysql_fetch_array ($q);
      $_SESSION ["cliente"] = $f;
      
      mysql_query ("INSERT INTO walger_logins VALUES ('".$_POST[usuario]."', NOW(), '".$f[RazonSocialCli]."')");

      if ($_SESSION ["cliente"]["Cotiz_Mda"] == "0") $_SESSION ["cliente"]["Cotiz_Mda"] = "1"; 

      if ($f ["Signo_Mda"] == "") {

        $_SESSION ["cliente"]["Signo_Mda"] = "$";
        $_SESSION ["cliente"]["Cotiz_Mda"] = "1";
        $_SESSION ["cliente"]["CodigoAFIP_Mda"] = "PES";
        $_SESSION ["cliente"]["Descr_Mda"] = "Pesos";

        $f ["Signo_Mda"] = "$"; 
        $f ["Cotiz_Mda"] = "1"; 
        $f ["CodigoAFIP_Mda"] = "PES"; 
        $f ["Descr_Mda"] = "Pesos"; 

      }

      mysql_query ("UPDATE walger_clientes
                    SET IP = '".$_SERVER['REMOTE_ADDR']."', UltimoLogin = NOW()
                    WHERE CodigoCli = '$f[CodigoCli]'");

      $UltimoLogin = $f ["UltimoLogin"];
      $IP = $f ["IP"];
      if ($f ["Signo_Mda"] == "$") $MONEDA = $f ["Signo_Mda"] . "(".$f["Descr_Mda"].")"; 
      else $MONEDA = $f ["Signo_Mda"] . "(".$f["Descr_Mda"].") con una cotización de $" . $f ["Cotiz_Mda"]; 

      if ($IP == "") $UltimoLogin = "(Este es su primer ingreso)";
      if ($IP == "") $IP = "(Este es su primer ingreso)";

      $_SESSION ["MENSAJE_LOGIN"] = "¡ Bienvenido <b>$f[RazonSocialCli]</b> !<br /><br />".$VTOS;

      $_SESSION ["MENSAJE_LOGIN"] .= "Su último login fue: $UltimoLogin<br />
                  Desde la IP: $IP<br />
                  Usted opera con la siguiente moneda: $MONEDA<br />
                  <br />
                  No dude en <a href=\"consultar.php\">contactarnos</a> ante cualquier consulta o sugerencia.

                  ";

    } else {

      $_SESSION ["MENSAJE_LOGIN"] = "Login incorrecto.<br />
                  <a href=\"index.php\">Vuelva a intentarlo</a>
      ";

    }

    header ("location: mensaje.php");

  }

?>


