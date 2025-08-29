<?php
define("EW_PAGE_ID", "index", TRUE); // Page ID
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php include "userfn50.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Open connection to the database
$conn = ew_Connect();
?>
<?php
$Security = new cAdvancedSecurity();
?>
<?php

// Common page loading event (in userfn*.php)
Page_Loading();
?>
<?php
if (!$Security->IsLoggedIn()) $Security->AutoLogin();
if ($Security->IsLoggedIn()) {
	Page_Terminate("dbo_articulolist.php"); // Exit and go to default page
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("dbo_clientelist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("dbo_ivacondicionlist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("dbo_listaprecioslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_actualizacioneslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_articuloslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_clienteslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_ofertaslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_pedidoslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_usuarioslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("walger_items_pedidoslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("Pedidoslist.php");
}
if ($Security->IsLoggedIn()) {
	Page_Terminate("Reporte_de_Pedidosreport.php");
}
if ($Security->IsLoggedIn()) {
?>
No tiene permisos para ver esta página
<br>
<a href="logout.php"></a>
<?php
} else {
	Page_Terminate("login.php"); // Exit and go to login page
}
?>
<?php

// If control is passed here, simply terminate the page without redirect
Page_Terminate();

// -----------------------------------------------------------------
//  Subroutine Page_Terminate
//  - called when exit page
//  - clean up connection and objects
//  - if url specified, redirect to url, otherwise end response
function Page_Terminate($url = "") {
	global $conn;

	// Global page unloaded event (in userfn*.php)
	Page_Unloaded();

	 // Close Connection
	$conn->Close();

	// Go to url if specified
	if ($url <> "") {
		ob_end_clean();
		header("Location: $url");
	}
	exit();
}
?>
<?php
?>
