<?PHP

	session_start();
	$_SESSION["MenuClassNameDisplay"] = strtolower($_POST["display"]) == "yes";

?>


