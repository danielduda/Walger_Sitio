<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// User table object (walger_usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cwalger_usuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;

		// If session expired, show session expired message
		if (@$_GET["expired"] == "1")
			$this->setFailureMessage($Language->Phrase("SessionExpired"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->AllowList(CurrentProjectID() . 'dbo_cliente'))
		$this->Page_Terminate("dbo_clientelist.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . 'trama_cuotas-recargos'))
			$this->Page_Terminate("trama_cuotas2Drecargoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_pagos-entregas'))
			$this->Page_Terminate("trama_pagos2Dentregaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_medios-entrega'))
			$this->Page_Terminate("trama_medios2Dentregalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_medios-pagos'))
			$this->Page_Terminate("trama_medios2Dpagoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_atributos'))
			$this->Page_Terminate("trama_atributoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_atributos-valores'))
			$this->Page_Terminate("trama_atributos2Dvaloreslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'dbo_articulo'))
			$this->Page_Terminate("dbo_articulolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'dbo_ivacondicion'))
			$this->Page_Terminate("dbo_ivacondicionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'dbo_listaprecios'))
			$this->Page_Terminate("dbo_listaprecioslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'dbo_moneda'))
			$this->Page_Terminate("dbo_monedalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_categorias-productos'))
			$this->Page_Terminate("trama_categorias2Dproductoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'items_pedido.php'))
			$this->Page_Terminate("items_pedido.php");
		if ($Security->AllowList(CurrentProjectID() . 'vencimientos.php'))
			$this->Page_Terminate("vencimientos.php");
		if ($Security->AllowList(CurrentProjectID() . 'factura_pdf.php'))
			$this->Page_Terminate("factura_pdf.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_noticias'))
			$this->Page_Terminate("trama_noticiaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'walger_articulos'))
			$this->Page_Terminate("walger_articuloslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'walger_clientes'))
			$this->Page_Terminate("walger_clienteslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'walger_ofertas'))
			$this->Page_Terminate("walger_ofertaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'walger_pedidos'))
			$this->Page_Terminate("walger_pedidoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'walger_usuarios'))
			$this->Page_Terminate("walger_usuarioslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_descargas'))
			$this->Page_Terminate("trama_descargaslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_emails'))
			$this->Page_Terminate("trama_emailslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_favoritos'))
			$this->Page_Terminate("trama_favoritoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_newsletter'))
			$this->Page_Terminate("trama_newsletterlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_categorias-portfolio'))
			$this->Page_Terminate("trama_categorias2Dportfoliolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_portfolio'))
			$this->Page_Terminate("trama_portfoliolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_tipos-articulos'))
			$this->Page_Terminate("trama_tipos2Darticuloslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_lineas-productos'))
			$this->Page_Terminate("trama_lineas2Dproductoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_marcas-productos'))
			$this->Page_Terminate("trama_marcas2Dproductoslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'matriz_valores_stock_precio.php'))
			$this->Page_Terminate("matriz_valores_stock_precio.php");
		if ($Security->AllowList(CurrentProjectID() . 'toggle_menu.php'))
			$this->Page_Terminate("toggle_menu.php");
		if ($Security->AllowList(CurrentProjectID() . 'enviar_email_habilitado.php'))
			$this->Page_Terminate("enviar_email_habilitado.php");
		if ($Security->AllowList(CurrentProjectID() . 'trama_slider'))
			$this->Page_Terminate("trama_sliderlist.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage(ew_DeniedMsg() . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "footer.php" ?>
<?php
$default->Page_Terminate();
?>
