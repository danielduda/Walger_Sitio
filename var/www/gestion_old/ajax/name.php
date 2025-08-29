<?php

//Creo la conexión

	error_reporting(E_ALL ^ E_DEPRECATED);
	mysql_connect('localhost','root','walger0000');
	mysql_select_db('walger');

//post no está vacío	

if(isset($_POST["nombrepost"])===true && empty($_POST["nombrepost"])===false){
	
	//genero la consulta where post
	$query=mysql_query("
		select `CuitCli`, `LocalidadCli`,`Regis_IvaC`,`Direccion`, `RazonSocialFlete`, `DescrProvincia`
		from `dbo_cliente`
		where `CodigoCli`='".mysql_real_escape_string(trim($_POST['nombrepost']))."'
		");

	$f=mysql_fetch_assoc($query);
	$cuit=$f["CuitCli"];
	$localidad=$f["LocalidadCli"]." - ".$f["DescrProvincia"];
	$iva=$f["Regis_IvaC"];
	$direccion=$f["Direccion"];
	$transporte=$f["RazonSocialFlete"];


	$q="select * from `dbo_ivacondicion` where Regis_IvaC='".$iva."'";
	$q=mysql_query($q);
	$f2=mysql_fetch_assoc($q);
	$iva2=$f2["DescrIvaC"];

	$qfac="SELECT * FROM `walger_pedidos`where CodigoCli='".mysql_real_escape_string(trim($_POST['nombrepost']))."' order by fechaFacturacion desc";
	$qfac=mysql_query($qfac);
	$ffac=mysql_fetch_assoc($qfac); 

	//imprimo resultado
	echo htmlspecialchars(utf8_encode(strtoupper ($cuit.",".$localidad.",".$iva2.",".$direccion.",".$transporte.",".$ffac["factura"])));
	//echo mysql_result($query, 0,'CuitCli').",".mysql_result($query, 0,'LocalidadCli').",".mysql_result($query, 0,'Regis_IvaC').",".mysql_result($query, 0,'Direccion');
	
}

 ?>