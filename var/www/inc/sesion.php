<?php 

session_start();

function sesion(){
	if (isset($_SESSION["idUsuario"])) {
		return true;
	}else{
		return false;
	}
}

 ?>