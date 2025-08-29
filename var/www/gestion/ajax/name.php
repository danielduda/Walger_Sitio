<?php

//Creo la conexión

	error_reporting(E_ALL ^ E_DEPRECATED);
	$link_aux = mysqli_connect('localhost','root','walger0000');
	mysqli_select_db($link_aux, 'walger');

//post no está vacío	

if(isset($_REQUEST["nombrepost"])===true && empty($_REQUEST["nombrepost"])===false){
	
	//genero la consulta where post
	$query=mysqli_query($link_aux, "
		select `CuitCli`, `LocalidadCli`,`Regis_IvaC`,`Direccion`, `RazonSocialFlete`, `DescrProvincia`
		from `dbo_cliente`
		where `CodigoCli`='".mysqli_real_escape_string($link_aux, trim($_REQUEST['nombrepost']))."'
		");

	$f=mysqli_fetch_assoc($query);
	$cuit=$f["CuitCli"];
	$localidad=$f["LocalidadCli"]." - ".$f["DescrProvincia"];
	$iva=$f["Regis_IvaC"];
	$direccion=$f["Direccion"];
	$transporte=$f["RazonSocialFlete"];


	$q="select * from `dbo_ivacondicion` where Regis_IvaC='".$iva."'";
	$q=mysqli_query($link_aux, $q);
	$f2=mysqli_fetch_assoc($q);
	$iva2=$f2["DescrIvaC"];

	$qfac="SELECT * FROM `walger_pedidos`where CodigoCli='".mysqli_real_escape_string($link_aux, trim($_REQUEST['nombrepost']))."' order by fechaFacturacion desc";
	$qfac=mysqli_query($link_aux, $qfac);
	$ffac=mysqli_fetch_assoc($qfac);

	//imprimo resultado
	echo htmlspecialchars(utf8_encode(strtoupper ($cuit.",".$localidad.",".$iva2.",".$direccion.",".$transporte.",".$ffac["factura"])));
	//echo mysqli_result($query, 0,'CuitCli').",".mysqli_result($query, 0,'LocalidadCli').",".mysqli_result($query, 0,'Regis_IvaC').",".mysqli_result($query, 0,'Direccion');
	
}

 ?>