<?php  
//file_put_contents("post.txt", print_r($_POST, true));
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
mysql_connect("localhost", "root", "walger0000");
mysql_select_db("walger");

file_put_contents("get.txt", print_r($_GET, true));  
$resultado=array();
$sql = "SELECT CodigoCli, RazonSocialCli, concat(CodigoCli, RazonSocialCli) as det FROM `dbo_cliente` having det like '%".$_GET["q"]."%'";
file_put_contents("sql.txt", print_r($sql, true));
$sql=mysql_query($sql);
for ($i=0; $i < mysql_num_rows($sql); $i++) { 
	$f=mysql_fetch_assoc($sql);
	$f = array_map('utf8_encode', $f);
	$answer[] = array("id"=>$f['CodigoCli'],"detalle"=>$f['RazonSocialCli']);    
}
echo json_encode($answer);  
?>