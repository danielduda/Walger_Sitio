<?php

@include_once("../inc/configuracion.php");

$mysqli = mysqli_connect($GLOBALS["configuracion"]["mysql"]["servidor"], $GLOBALS["configuracion"]["mysql"]["usuario"], $GLOBALS["configuracion"]["mysql"]["contrasena"], $GLOBALS["configuracion"]["mysql"]["base"]);

if (!$mysqli) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if (!mysqli_set_charset($mysqli, "latin1")) {
    printf("Error cargando el conjunto de caracteres latin1: %s\n", mysqli_error($mysqli));
    exit;
}

if (isset($GLOBALS["configuracion"]["conexionesexternas"])) {
	for ($i=0; $i < count($GLOBALS["configuracion"]["conexionesexternas"]); $i++) { 
		${"mysqliext" . $i} = mysqli_connect($GLOBALS["configuracion"]["conexionesexternas"][$i]["servidor"], $GLOBALS["configuracion"]["conexionesexternas"][$i]["usuario"], $GLOBALS["configuracion"]["conexionesexternas"][$i]["contrasena"], $GLOBALS["configuracion"]["conexionesexternas"][$i]["base"]);		
		if (!${"mysqliext" . $i}) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}	
	}
}


?>
