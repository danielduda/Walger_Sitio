<?PHP 

session_start ();

if ($_SESSION ["cliente"]["Cotiz_Mda"] == "") exit ();

error_reporting (E_ALL ^ E_NOTICE);
include ("inc/funciones.php");

  conectar ();  

    $q = mysql_query ("SELECT *
                       FROM dbo_articulo
                       ORDER BY CodInternoArti");

$hoy = getdate();
$hoy = $hoy [mday] . "-" . $hoy [mon] . "-" . $hoy [year];

header('Content-type: application/xls');
header('Content-Disposition: attachment; filename="walger-lista-'.$hoy.'.xls"');

?>

<table>
  <tr>
    <td colspan="3"><img src="http://servidor.walger.com.ar/imgs/logo.jpg"></td>
    <td colspan="5"><h1>Lista de Precios <?PHP echo ($hot); ?></h1></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;
    </td>
  </tr> 
  <tr>
    <td colspan="3"></td>
    <td colspan="5">
    
    	Pedidos al : 4854-0360 (tel/fax) 0800-888-64772 (fax)<br />
    	correo@walger.com.ar - www.walger.com.ar 
    
    </td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;
    </td>
  </tr> 
  
  <tr>
    <td width="80"><strong>Código WG</strong></td>
    <td width="95"><strong>Precio de Lista</strong></td>
    <td width="10"></td>
    <td width="80"><strong>Código WG</strong></td>
    <td width="95"><strong>Precio de Lista</strong></td>
    <td width="10"></td>
    <td width="80"><strong>Código WG</strong></td>
    <td width="95"><strong>Precio de Lista</strong></td>
  </tr>

	<?PHP 
	
		while ($f = mysql_fetch_array ($q)) {
	
	?>
  
  <tr>

		<?PHP 
		
    if ($_SESSION ["cliente"]["Cotiz_Mda"] != "") {
    
      $f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
      $f ['PrecioVta1_PreArti'] = $f ['PrecioVta1_PreArti'] / $_SESSION ["cliente"]["Cotiz_Mda"];
      $f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);

    }

		?>
  
    <td><?PHP echo ($f ["CodInternoArti"]); ?></td>
    <td align="right"><?PHP echo ($_SESSION ["cliente"]["Signo_Mda"]); ?><?PHP echo ($f ["PrecioVta1_PreArti"]); ?></td>
    <td></td>

		<?PHP 
		
		$f = mysql_fetch_array ($q);
		
    if ($_SESSION ["cliente"]["Cotiz_Mda"] != "") {
    
      $f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
      $f ['PrecioVta1_PreArti'] = $f ['PrecioVta1_PreArti'] / $_SESSION ["cliente"]["Cotiz_Mda"];
      $f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);

    }

		?>

    <td><?PHP echo ($f ["CodInternoArti"]); ?></td>
    <td align="right"><?PHP echo ($_SESSION ["cliente"]["Signo_Mda"]); ?><?PHP echo ($f ["PrecioVta1_PreArti"]); ?></td>
    <td></td>

		<?PHP 
		
		$f = mysql_fetch_array ($q);
		
    if ($_SESSION ["cliente"]["Cotiz_Mda"] != "") {
    
      $f ['PrecioVta1_PreArti'] += $f ['PrecioVta1_PreArti'] * $_SESSION ['cliente'] ['VariacionListaPrec'] / 100;
      $f ['PrecioVta1_PreArti'] = $f ['PrecioVta1_PreArti'] / $_SESSION ["cliente"]["Cotiz_Mda"];
      $f ['PrecioVta1_PreArti'] = sprintf("%.2f", $f ['PrecioVta1_PreArti']);

    }

		?>

    <td><?PHP echo ($f ["CodInternoArti"]); ?></td>
    <td align="right"><?PHP echo ($_SESSION ["cliente"]["Signo_Mda"]); ?><?PHP echo ($f ["PrecioVta1_PreArti"]); ?></td>
    
  </tr>
  
  <?PHP 
  
    }
  
  ?>
  
</table>  
    
