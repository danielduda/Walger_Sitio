<?php

//Creo la conexión

	error_reporting(E_ALL ^ E_DEPRECATED);
    $link_aux = mysqli_connect('localhost','root','');
	mysqli_select_db($link_aux, 'gestion_walger');

//post no está vacío	

if(isset($_POST["nombrepost"])===true && empty($_POST["nombrepost"])===false){
	
	//genero la consulta where post
	$query=mysqli_query($link_aux, "
		select `CuitCli`, `LocalidadCli`,`Regis_IvaC`,`Direccion`
		from `dbo_cliente`
		where `CodigoCli`='".mysqli_real_escape_string(trim($_POST['nombrepost']))."'
		");

	//imprimo resultado
	echo mysqli_result($query, 0,'CuitCli').",".mysqli_result($query, 0,'LocalidadCli').",".mysqli_result($query, 0,'Regis_IvaC').",".mysqli_result($query, 0,'Direccion');
	
	
}

 ?>