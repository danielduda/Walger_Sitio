<?php
	require '../db/connect.php'; 
	$query =mysql_query("select apellido from personas where name= '".$_POST['name']."'
		");

	echo $query;

 ?>