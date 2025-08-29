<?php 

$nrocomprobante="400010021";
$idcliente="R0043";
$cuitcliente="33-66508841-9";

$rutapdf = "";
$rutaprincipal = opendir("/home/fcisis/");
$carpeta = readdir($rutaprincipal);

while ($carpeta = readdir($rutaprincipal)) {
	if ((strpos($carpeta, $idcliente) === 0) && (strpos($carpeta, $cuitcliente) > 0)){
		$rutacompleta = opendir("/home/fcisis/".$carpeta."/");
		while ($subcarpeta = readdir($rutacompleta)) {
			if ((strpos($subcarpeta, $nrocomprobante) > 0)&&(strpos($subcarpeta, ".pdf") > 0)) {
				$rutapdf = "/fc.php?r=".$carpeta."/".$subcarpeta;
				break;
			}
		}
		break;
	}
}

echo $rutapdf;

 ?>