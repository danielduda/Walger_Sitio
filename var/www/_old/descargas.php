<?PHP

  include ("inc/encabezado.php");

  if ($_SESSION ["cliente"]["TipoCliente"] == "Casa de Repuestos") $DIRECTORIO = "descargas_casa_repuestos";
  if ($_SESSION ["cliente"]["TipoCliente"] == "Consumidor Final") $DIRECTORIO = "descargas_consumidor_final";
  if ($_SESSION ["cliente"]["TipoCliente"] == "Distribuidor") $DIRECTORIO = "descargas_distribuidor";

  if ($DIRECTORIO == "") { header ("location: index.php"); exit (); }

  function dirList ($directory) {

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // keep going until all files in directory have been read
    while ($file = readdir($handler)) {

        // if $file isn't this directory or its parent, 
        // add it to the results array
        if (($file != '.') && ($file != '..') && ($file != 'index.php'))
            $results[] = $file;
    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;

  }
  
  $archivos = dirList ($DIRECTORIO);

?>

      <div class="contenido">

        <strong>Descargas</strong><br />
        <br />

				<?PHP 
				
				  $hoy = getdate();
					$hoy = $hoy [mday] . "/" . $hoy [mon] . "/" . $hoy [year];
				
				?> 

				- <a href="lista.php?r=<?PHP echo ($hoy); ?>">Lista de Precios - <?PHP echo ($hoy); ?> <img src="../imgs/descarga.png" width="20" title="XLS" /></a><br />

        <?PHP for ($i=0; $i < count ($archivos); $i ++) { ?>

				<?PHP
				
					$path_info = pathinfo($archivos [$i]);

					$archivo = str_replace (".".$path_info['extension'], '', $archivos [$i]);
				
				?>

        - <a target="_blank" href="<?PHP echo ($DIRECTORIO); ?>/<?PHP echo ($archivos [$i]); ?>"><?PHP echo ($archivo); ?> <img src="../imgs/archivo.jpg" width="20" title="<?PHP echo strtoupper ($path_info['extension']); ?>" /></a><br />

        <?PHP } ?>

      </div>

    </div>

<?PHP include ("inc/pie.php"); ?>
