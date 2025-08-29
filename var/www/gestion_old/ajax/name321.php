<?php

//Creo la conexión

	error_reporting(E_ALL ^ E_DEPRECATED);
	mysql_connect('localhost','root','');
	mysql_select_db('gestion_walger');

//post no está vacío	

if(isset($_POST["nombrepost"])===true && empty($_POST["nombrepost"])===false){
	
	//genero la consulta where post
	$query=mysql_query("
		select `CuitCli`, `LocalidadCli`,`Regis_IvaC`,`Direccion`
		from `dbo_cliente`
		where `CodigoCli`='".mysql_real_escape_string(trim($_POST['nombrepost']))."'
		");

	//imprimo resultado
	echo mysql_result($query, 0,'CuitCli').",".mysql_result($query, 0,'LocalidadCli').",".mysql_result($query, 0,'Regis_IvaC').",".mysql_result($query, 0,'Direccion');
	
	
}

 ?>