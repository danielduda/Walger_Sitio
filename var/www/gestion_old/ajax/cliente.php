<?php 
//file_put_contents("post.txt", print_r($_POST, true));
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
mysql_connect("localhost", "root", "walger0000");
mysql_select_db("walger");

$consulta=array();

for ($i=0; $i < count($_POST["idclientes"]); $i++) { 

	$q="SELECT RazonSocialCli FROM `dbo_cliente` WHERE CodigoCli='".$_POST["idclientes"][$i]."'";
	$q=mysql_query($q);
	$f=mysql_fetch_assoc($q);
	array_push($consulta, htmlspecialchars(utf8_encode($f["RazonSocialCli"])));
}
	//file_put_contents("query.txt", print_r($consulta, true));

echo json_encode($consulta);	
 ?>