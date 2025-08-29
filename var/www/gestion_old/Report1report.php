<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php

// Global variable for table object
$Report1 = NULL;

//
// Table class for Report1
//
class cReport1 extends cTableBase {
	var $Id_Remito;
	var $Cliente;
	var $Fecha;
	var $Proveedor;
	var $Transporte;
	var $OperadorTraslado;
	var $NumeroDeBultos;
	var $OperadorEntrego;
	var $OperadorVerifico;
	var $Observaciones;
	var $Importe;
	var $facturas;
	var $Id_RemitoDetalle;
	var $remitoCabecera;
	var $cantidad;
	var $descripcion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'Report1';
		$this->TableName = 'Report1';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->PrinterFriendlyForPdf = TRUE;
		$this->UserIDAllowSecurity = 0; // User ID Allow

		// Id_Remito
		$this->Id_Remito = new cField('Report1', 'Report1', 'x_Id_Remito', 'Id_Remito', '`Id_Remito`', '`Id_Remito`', 19, -1, FALSE, '`Id_Remito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Remito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Remito'] = &$this->Id_Remito;

		// Cliente
		$this->Cliente = new cField('Report1', 'Report1', 'x_Cliente', 'Cliente', '`Cliente`', '`Cliente`', 200, -1, FALSE, '`Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cliente'] = &$this->Cliente;

		// Fecha
		$this->Fecha = new cField('Report1', 'Report1', 'x_Fecha', 'Fecha', '`Fecha`', 'DATE_FORMAT(`Fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`Fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha'] = &$this->Fecha;

		// Proveedor
		$this->Proveedor = new cField('Report1', 'Report1', 'x_Proveedor', 'Proveedor', '`Proveedor`', '`Proveedor`', 3, -1, FALSE, '`Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Proveedor'] = &$this->Proveedor;

		// Transporte
		$this->Transporte = new cField('Report1', 'Report1', 'x_Transporte', 'Transporte', '`Transporte`', '`Transporte`', 3, -1, FALSE, '`Transporte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Transporte->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Transporte'] = &$this->Transporte;

		// OperadorTraslado
		$this->OperadorTraslado = new cField('Report1', 'Report1', 'x_OperadorTraslado', 'OperadorTraslado', '`OperadorTraslado`', '`OperadorTraslado`', 3, -1, FALSE, '`OperadorTraslado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorTraslado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorTraslado'] = &$this->OperadorTraslado;

		// NumeroDeBultos
		$this->NumeroDeBultos = new cField('Report1', 'Report1', 'x_NumeroDeBultos', 'NumeroDeBultos', '`NumeroDeBultos`', '`NumeroDeBultos`', 3, -1, FALSE, '`NumeroDeBultos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->NumeroDeBultos->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['NumeroDeBultos'] = &$this->NumeroDeBultos;

		// OperadorEntrego
		$this->OperadorEntrego = new cField('Report1', 'Report1', 'x_OperadorEntrego', 'OperadorEntrego', '`OperadorEntrego`', '`OperadorEntrego`', 3, -1, FALSE, '`OperadorEntrego`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorEntrego->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorEntrego'] = &$this->OperadorEntrego;

		// OperadorVerifico
		$this->OperadorVerifico = new cField('Report1', 'Report1', 'x_OperadorVerifico', 'OperadorVerifico', '`OperadorVerifico`', '`OperadorVerifico`', 3, -1, FALSE, '`OperadorVerifico`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorVerifico->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorVerifico'] = &$this->OperadorVerifico;

		// Observaciones
		$this->Observaciones = new cField('Report1', 'Report1', 'x_Observaciones', 'Observaciones', '`Observaciones`', '`Observaciones`', 200, -1, FALSE, '`Observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Observaciones'] = &$this->Observaciones;

		// Importe
		$this->Importe = new cField('Report1', 'Report1', 'x_Importe', 'Importe', '`Importe`', '`Importe`', 200, -1, FALSE, '`Importe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Importe'] = &$this->Importe;

		// facturas
		$this->facturas = new cField('Report1', 'Report1', 'x_facturas', 'facturas', '`facturas`', '`facturas`', 200, -1, FALSE, '`facturas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['facturas'] = &$this->facturas;

		// Id_RemitoDetalle
		$this->Id_RemitoDetalle = new cField('Report1', 'Report1', 'x_Id_RemitoDetalle', 'Id_RemitoDetalle', '`Id_RemitoDetalle`', '`Id_RemitoDetalle`', 19, -1, FALSE, '`Id_RemitoDetalle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_RemitoDetalle->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_RemitoDetalle'] = &$this->Id_RemitoDetalle;

		// remitoCabecera
		$this->remitoCabecera = new cField('Report1', 'Report1', 'x_remitoCabecera', 'remitoCabecera', '`remitoCabecera`', '`remitoCabecera`', 3, -1, FALSE, '`remitoCabecera`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->remitoCabecera->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['remitoCabecera'] = &$this->remitoCabecera;

		// cantidad
		$this->cantidad = new cField('Report1', 'Report1', 'x_cantidad', 'cantidad', '`cantidad`', '`cantidad`', 200, -1, FALSE, '`cantidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cantidad'] = &$this->cantidad;

		// descripcion
		$this->descripcion = new cField('Report1', 'Report1', 'x_descripcion', 'descripcion', '`descripcion`', '`descripcion`', 3, -1, FALSE, '`descripcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->descripcion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['descripcion'] = &$this->descripcion;
	}

	// Report group level SQL
	function SqlGroupSelect() { // Select
		return "SELECT DISTINCT `Id_Remito` FROM `remitosview`";
	}

	function SqlGroupWhere() { // Where
		return "";
	}

	function SqlGroupGroupBy() { // Group By
		return "";
	}

	function SqlGroupHaving() { // Having
		return "";
	}

	function SqlGroupOrderBy() { // Order By
		return "`Id_Remito` ASC";
	}

	// Report detail level SQL
	function SqlDetailSelect() { // Select
		return "SELECT * FROM `remitosview`";
	}

	function SqlDetailWhere() { // Where
		return "";
	}

	function SqlDetailGroupBy() { // Group By
		return "";
	}

	function SqlDetailHaving() { // Having
		return "";
	}

	function SqlDetailOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Report group SQL
	function GroupSQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = "";
		return ew_BuildSelectSql($this->SqlGroupSelect(), $this->SqlGroupWhere(),
			 $this->SqlGroupGroupBy(), $this->SqlGroupHaving(),
			 $this->SqlGroupOrderBy(), $sFilter, $sSort);
	}

	// Report detail SQL
	function DetailSQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = "";
		return ew_BuildSelectSql($this->SqlDetailSelect(), $this->SqlDetailWhere(),
			$this->SqlDetailGroupBy(), $this->SqlDetailHaving(),
			$this->SqlDetailOrderBy(), $sFilter, $sSort);
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "Report1report.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "Report1report.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("", $this->UrlParm($parm));
		else
			return $this->KeyUrl("", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Remito->CurrentValue)) {
			$sUrl .= "Id_Remito=" . urlencode($this->Id_Remito->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Id_RemitoDetalle->CurrentValue)) {
			$sUrl .= "&Id_RemitoDetalle=" . urlencode($this->Id_RemitoDetalle->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET)) {
			$arKey[] = @$_GET["Id_Remito"]; // Id_Remito
			$arKey[] = @$_GET["Id_RemitoDetalle"]; // Id_RemitoDetalle
			$arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_array($key) || count($key) <> 2)
				continue; // Just skip so other keys will still work
			if (!is_numeric($key[0])) // Id_Remito
				continue;
			if (!is_numeric($key[1])) // Id_RemitoDetalle
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Id_Remito->CurrentValue = $key[0];
			$this->Id_RemitoDetalle->CurrentValue = $key[1];
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {
	 $q = mysql_query(      
			"SELECT group_concat(numFactura SEPARATOR ' , ' )as p 
			FROM `facturas` where facturas.RemitoCabecera =    '".$this->Id_Remito->ViewValue."'  "
		);      
		$f = mysql_fetch_array($q);                      
		$this->facturas->ViewValue =  $f["p"];
	}                                   

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$Report1_report = NULL; // Initialize page object first

class cReport1_report extends cReport1 {

	// Page ID
	var $PageID = 'report';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'Report1';

	// Page object name
	var $PageObjName = 'Report1_report';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		return TRUE;
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (Report1)
		if (!isset($GLOBALS["Report1"])) {
			$GLOBALS["Report1"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Report1"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'report', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'Report1', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;
		global $EW_EXPORT_REPORT;

		// Page Unload event
		$this->Page_Unload();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EW_EXPORT_REPORT)) {
			$sContent = ob_get_contents();
			$fn = $EW_EXPORT_REPORT[$this->Export];
			$this->$fn($sContent);
			if ($this->Export == "email") { // Email
				ob_end_clean();
				$conn->Close(); // Close connection
				header("Location: " . ew_CurrentPage());
				exit();
			}
		}

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $RecCnt = 0;
	var $ReportSql = "";
	var $ReportFilter = "";
	var $DefaultFilter = "";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $MasterRecordExists;
	var $Command;
	var $DtlRecordCount;
	var $ReportGroups;
	var $ReportCounts;
	var $LevelBreak;
	var $ReportTotals;
	var $ReportMaxs;
	var $ReportMins;
	var $Recordset;
	var $DetailRecordset;
	var $RecordExists;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$this->ReportGroups = &ew_InitArray(2, NULL);
		$this->ReportCounts = &ew_InitArray(2, 0);
		$this->LevelBreak = &ew_InitArray(2, FALSE);
		$this->ReportTotals = &ew_Init2DArray(2, 16, 0);
		$this->ReportMaxs = &ew_Init2DArray(2, 16, 0);
		$this->ReportMins = &ew_Init2DArray(2, 16, 0);

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Check level break
	function ChkLvlBreak() {
		$this->LevelBreak[1] = FALSE;
		if ($this->RecCnt == 0) { // Start Or End of Recordset
			$this->LevelBreak[1] = TRUE;
		} else {
			if (!ew_CompareValue($this->Id_Remito->CurrentValue, $this->ReportGroups[0])) {
				$this->LevelBreak[1] = TRUE;
			}
		}
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Remito
		// Cliente
		// Fecha
		// Proveedor
		// Transporte
		// OperadorTraslado
		// NumeroDeBultos
		// OperadorEntrego
		// OperadorVerifico
		// Observaciones
		// Importe
		// facturas
		// Id_RemitoDetalle
		// remitoCabecera
		// cantidad
		// descripcion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Remito
			$this->Id_Remito->ViewValue = $this->Id_Remito->CurrentValue;
			$this->Id_Remito->ViewCustomAttributes = "";

			// Cliente
			if (strval($this->Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Cliente->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
				}
			} else {
				$this->Cliente->ViewValue = NULL;
			}
			$this->Cliente->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Proveedor
			if (strval($this->Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedores`" . ew_SearchString("=", $this->Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedores`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `razonSocial` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Proveedor->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Proveedor->ViewValue = $this->Proveedor->CurrentValue;
				}
			} else {
				$this->Proveedor->ViewValue = NULL;
			}
			$this->Proveedor->ViewCustomAttributes = "";

			// Transporte
			if (strval($this->Transporte->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Transporte`" . ew_SearchString("=", $this->Transporte->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Transporte`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `razonSocial` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Transporte->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Transporte->ViewValue = $this->Transporte->CurrentValue;
				}
			} else {
				$this->Transporte->ViewValue = NULL;
			}
			$this->Transporte->ViewCustomAttributes = "";

			// OperadorTraslado
			if (strval($this->OperadorTraslado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorTraslado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorTraslado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorTraslado->ViewValue = $this->OperadorTraslado->CurrentValue;
				}
			} else {
				$this->OperadorTraslado->ViewValue = NULL;
			}
			$this->OperadorTraslado->ViewCustomAttributes = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->ViewValue = $this->NumeroDeBultos->CurrentValue;
			$this->NumeroDeBultos->ViewCustomAttributes = "";

			// OperadorEntrego
			if (strval($this->OperadorEntrego->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorEntrego->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorEntrego->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorEntrego->ViewValue = $this->OperadorEntrego->CurrentValue;
				}
			} else {
				$this->OperadorEntrego->ViewValue = NULL;
			}
			$this->OperadorEntrego->ViewCustomAttributes = "";

			// OperadorVerifico
			if (strval($this->OperadorVerifico->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorVerifico->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorVerifico->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorVerifico->ViewValue = $this->OperadorVerifico->CurrentValue;
				}
			} else {
				$this->OperadorVerifico->ViewValue = NULL;
			}
			$this->OperadorVerifico->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// Importe
			$this->Importe->ViewValue = $this->Importe->CurrentValue;
			$this->Importe->ViewCustomAttributes = "";

			// facturas
			$this->facturas->ViewValue = $this->facturas->CurrentValue;
			$this->facturas->ViewCustomAttributes = "";

			// Id_RemitoDetalle
			$this->Id_RemitoDetalle->ViewValue = $this->Id_RemitoDetalle->CurrentValue;
			$this->Id_RemitoDetalle->ViewCustomAttributes = "";

			// remitoCabecera
			$this->remitoCabecera->ViewValue = $this->remitoCabecera->CurrentValue;
			$this->remitoCabecera->ViewCustomAttributes = "";

			// cantidad
			$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
			$this->cantidad->ViewCustomAttributes = "";

			// descripcion
			if (strval($this->descripcion->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Productos`" . ew_SearchString("=", $this->descripcion->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Productos`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `productos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->descripcion->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
				}
			} else {
				$this->descripcion->ViewValue = NULL;
			}
			$this->descripcion->ViewCustomAttributes = "";

			// Id_Remito
			$this->Id_Remito->LinkCustomAttributes = "";
			$this->Id_Remito->HrefValue = "";
			$this->Id_Remito->TooltipValue = "";

			// Cliente
			$this->Cliente->LinkCustomAttributes = "";
			$this->Cliente->HrefValue = "";
			$this->Cliente->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Proveedor
			$this->Proveedor->LinkCustomAttributes = "";
			$this->Proveedor->HrefValue = "";
			$this->Proveedor->TooltipValue = "";

			// Transporte
			$this->Transporte->LinkCustomAttributes = "";
			$this->Transporte->HrefValue = "";
			$this->Transporte->TooltipValue = "";

			// OperadorTraslado
			$this->OperadorTraslado->LinkCustomAttributes = "";
			$this->OperadorTraslado->HrefValue = "";
			$this->OperadorTraslado->TooltipValue = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->LinkCustomAttributes = "";
			$this->NumeroDeBultos->HrefValue = "";
			$this->NumeroDeBultos->TooltipValue = "";

			// OperadorEntrego
			$this->OperadorEntrego->LinkCustomAttributes = "";
			$this->OperadorEntrego->HrefValue = "";
			$this->OperadorEntrego->TooltipValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->LinkCustomAttributes = "";
			$this->OperadorVerifico->HrefValue = "";
			$this->OperadorVerifico->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Importe
			$this->Importe->LinkCustomAttributes = "";
			$this->Importe->HrefValue = "";
			$this->Importe->TooltipValue = "";

			// facturas
			$this->facturas->LinkCustomAttributes = "";
			$this->facturas->HrefValue = "";
			$this->facturas->TooltipValue = "";

			// Id_RemitoDetalle
			$this->Id_RemitoDetalle->LinkCustomAttributes = "";
			$this->Id_RemitoDetalle->HrefValue = "";
			$this->Id_RemitoDetalle->TooltipValue = "";

			// remitoCabecera
			$this->remitoCabecera->LinkCustomAttributes = "";
			$this->remitoCabecera->HrefValue = "";
			$this->remitoCabecera->TooltipValue = "";

			// cantidad
			$this->cantidad->LinkCustomAttributes = "";
			$this->cantidad->HrefValue = "";
			$this->cantidad->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("report", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
	}

	// Export report to HTML
	function ExportReportHtml($html) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');
		//echo $html;

	}

	// Export report to WORD
	function ExportReportWord($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-word' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
		echo $html;
	}

	// Export report to EXCEL
	function ExportReportExcel($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-excel' . (EW_CHARSET <> '' ? ';charset=' . EW_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
		echo $html;
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($Report1_report)) $Report1_report = new cReport1_report();

// Page init
$Report1_report->Page_Init();

// Page main
$Report1_report->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$Report1_report->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($Report1->Export == "") { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Report1->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php
$Report1_report->DefaultFilter = "";
$Report1_report->ReportFilter = $Report1_report->DefaultFilter;
if (!$Security->CanReport()) {
	if ($Report1_report->ReportFilter <> "") $Report1_report->ReportFilter .= " AND ";
	$Report1_report->ReportFilter .= "(0=1)";
}
if ($Report1_report->DbDetailFilter <> "") {
	if ($Report1_report->ReportFilter <> "") $Report1_report->ReportFilter .= " AND ";
	$Report1_report->ReportFilter .= "(" . $Report1_report->DbDetailFilter . ")";
}

// Set up filter and load Group level sql
$Report1->CurrentFilter = $Report1_report->ReportFilter;
$Report1_report->ReportSql = $Report1->GroupSQL();

// Load recordset
$Report1_report->Recordset = $conn->Execute($Report1_report->ReportSql);
$Report1_report->RecordExists = !$Report1_report->Recordset->EOF;
?>
<?php if ($Report1->Export == "") { ?>
<?php if ($Report1_report->RecordExists) { ?>
<div class="ewViewExportOptions"><?php $Report1_report->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php } ?>
<?php $Report1_report->ShowPageHeader(); ?>
<form method="post">
<table class="ewReportTable">
<?php

// Get First Row
if ($Report1_report->RecordExists) {
	$Report1->Id_Remito->setDbValue($Report1_report->Recordset->fields('Id_Remito'));
	$Report1_report->ReportGroups[0] = $Report1->Id_Remito->DbValue;
}
$Report1_report->RecCnt = 0;
$Report1_report->ReportCounts[0] = 0;
$Report1_report->ChkLvlBreak();
while (!$Report1_report->Recordset->EOF) {

	// Render for view
	$Report1->RowType = EW_ROWTYPE_VIEW;
	$Report1->ResetAttrs();
	$Report1_report->RenderRow();

	// Show group headers
	if ($Report1_report->LevelBreak[1]) { // Reset counter and aggregation
?>
	<tr><td class="ewGroupField"><?php echo $Report1->Id_Remito->FldCaption() ?></td>
	<td colspan=15 class="ewGroupName">
<span<?php echo $Report1->Id_Remito->ViewAttributes() ?>>
<?php echo $Report1->Id_Remito->ViewValue ?></span>
</td></tr>
<?php
	}

	// Get detail records
	$Report1_report->ReportFilter = $Report1_report->DefaultFilter;
	if ($Report1_report->ReportFilter <> "") $Report1_report->ReportFilter .= " AND ";
	if (is_null($Report1->Id_Remito->CurrentValue)) {
		$Report1_report->ReportFilter .= "(`Id_Remito` IS NULL)";
	} else {
		$Report1_report->ReportFilter .= "(`Id_Remito` = " . ew_AdjustSql($Report1->Id_Remito->CurrentValue) . ")";
	}
	if ($Report1_report->DbDetailFilter <> "") {
		if ($Report1_report->ReportFilter <> "")
			$Report1_report->ReportFilter .= " AND ";
		$Report1_report->ReportFilter .= "(" . $Report1_report->DbDetailFilter . ")";
	}
	if (!$Security->CanReport()) {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(0=1)";
	}

	// Set up detail SQL
	$Report1->CurrentFilter = $Report1_report->ReportFilter;
	$Report1_report->ReportSql = $Report1->DetailSQL();

	// Load detail records
	$Report1_report->DetailRecordset = $conn->Execute($Report1_report->ReportSql);
	$Report1_report->DtlRecordCount = $Report1_report->DetailRecordset->RecordCount();

	// Initialize aggregates
	if (!$Report1_report->DetailRecordset->EOF) {
		$Report1_report->RecCnt++;
	}
	if ($Report1_report->RecCnt == 1) {
		$Report1_report->ReportCounts[0] = 0;
	}
	for ($i = 1; $i <= 1; $i++) {
		if ($Report1_report->LevelBreak[$i]) { // Reset counter and aggregation
			$Report1_report->ReportCounts[$i] = 0;
		}
	}
	$Report1_report->ReportCounts[0] += $Report1_report->DtlRecordCount;
	$Report1_report->ReportCounts[1] += $Report1_report->DtlRecordCount;
	if ($Report1_report->RecordExists) {
?>
	<tr>
		<td><div class="ewGroupIndent"></div></td>
		<td class="ewGroupHeader"><?php echo $Report1->Cliente->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Fecha->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Proveedor->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Transporte->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->OperadorTraslado->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->NumeroDeBultos->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->OperadorEntrego->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->OperadorVerifico->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Observaciones->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Importe->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->facturas->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->Id_RemitoDetalle->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->remitoCabecera->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->cantidad->FldCaption() ?></td>
		<td class="ewGroupHeader"><?php echo $Report1->descripcion->FldCaption() ?></td>
	</tr>
<?php
	}
	while (!$Report1_report->DetailRecordset->EOF) {
		$Report1->Cliente->setDbValue($Report1_report->DetailRecordset->fields('Cliente'));
		$Report1->Fecha->setDbValue($Report1_report->DetailRecordset->fields('Fecha'));
		$Report1->Proveedor->setDbValue($Report1_report->DetailRecordset->fields('Proveedor'));
		$Report1->Transporte->setDbValue($Report1_report->DetailRecordset->fields('Transporte'));
		$Report1->OperadorTraslado->setDbValue($Report1_report->DetailRecordset->fields('OperadorTraslado'));
		$Report1->NumeroDeBultos->setDbValue($Report1_report->DetailRecordset->fields('NumeroDeBultos'));
		$Report1->OperadorEntrego->setDbValue($Report1_report->DetailRecordset->fields('OperadorEntrego'));
		$Report1->OperadorVerifico->setDbValue($Report1_report->DetailRecordset->fields('OperadorVerifico'));
		$Report1->Observaciones->setDbValue($Report1_report->DetailRecordset->fields('Observaciones'));
		$Report1->Importe->setDbValue($Report1_report->DetailRecordset->fields('Importe'));
		$Report1->facturas->setDbValue($Report1_report->DetailRecordset->fields('facturas'));
		$Report1->Id_RemitoDetalle->setDbValue($Report1_report->DetailRecordset->fields('Id_RemitoDetalle'));
		$Report1->remitoCabecera->setDbValue($Report1_report->DetailRecordset->fields('remitoCabecera'));
		$Report1->cantidad->setDbValue($Report1_report->DetailRecordset->fields('cantidad'));
		$Report1->descripcion->setDbValue($Report1_report->DetailRecordset->fields('descripcion'));

		// Render for view
		$Report1->RowType = EW_ROWTYPE_VIEW;
		$Report1->ResetAttrs();
		$Report1_report->RenderRow();
?>
	<tr>
		<td><div class="ewGroupIndent"></div></td>
		<td<?php echo $Report1->Cliente->CellAttributes() ?>>
<span<?php echo $Report1->Cliente->ViewAttributes() ?>>
<?php echo $Report1->Cliente->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Fecha->CellAttributes() ?>>
<span<?php echo $Report1->Fecha->ViewAttributes() ?>>
<?php echo $Report1->Fecha->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Proveedor->CellAttributes() ?>>
<span<?php echo $Report1->Proveedor->ViewAttributes() ?>>
<?php echo $Report1->Proveedor->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Transporte->CellAttributes() ?>>
<span<?php echo $Report1->Transporte->ViewAttributes() ?>>
<?php echo $Report1->Transporte->ViewValue ?></span>
</td>
		<td<?php echo $Report1->OperadorTraslado->CellAttributes() ?>>
<span<?php echo $Report1->OperadorTraslado->ViewAttributes() ?>>
<?php echo $Report1->OperadorTraslado->ViewValue ?></span>
</td>
		<td<?php echo $Report1->NumeroDeBultos->CellAttributes() ?>>
<span<?php echo $Report1->NumeroDeBultos->ViewAttributes() ?>>
<?php echo $Report1->NumeroDeBultos->ViewValue ?></span>
</td>
		<td<?php echo $Report1->OperadorEntrego->CellAttributes() ?>>
<span<?php echo $Report1->OperadorEntrego->ViewAttributes() ?>>
<?php echo $Report1->OperadorEntrego->ViewValue ?></span>
</td>
		<td<?php echo $Report1->OperadorVerifico->CellAttributes() ?>>
<span<?php echo $Report1->OperadorVerifico->ViewAttributes() ?>>
<?php echo $Report1->OperadorVerifico->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Observaciones->CellAttributes() ?>>
<span<?php echo $Report1->Observaciones->ViewAttributes() ?>>
<?php echo $Report1->Observaciones->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Importe->CellAttributes() ?>>
<span<?php echo $Report1->Importe->ViewAttributes() ?>>
<?php echo $Report1->Importe->ViewValue ?></span>
</td>
		<td<?php echo $Report1->facturas->CellAttributes() ?>>
<span<?php echo $Report1->facturas->ViewAttributes() ?>>
<?php echo $Report1->facturas->ViewValue ?></span>
</td>
		<td<?php echo $Report1->Id_RemitoDetalle->CellAttributes() ?>>
<span<?php echo $Report1->Id_RemitoDetalle->ViewAttributes() ?>>
<?php echo $Report1->Id_RemitoDetalle->ViewValue ?></span>
</td>
		<td<?php echo $Report1->remitoCabecera->CellAttributes() ?>>
<span<?php echo $Report1->remitoCabecera->ViewAttributes() ?>>
<?php echo $Report1->remitoCabecera->ViewValue ?></span>
</td>
		<td<?php echo $Report1->cantidad->CellAttributes() ?>>
<span<?php echo $Report1->cantidad->ViewAttributes() ?>>
<?php echo $Report1->cantidad->ViewValue ?></span>
</td>
		<td<?php echo $Report1->descripcion->CellAttributes() ?>>
<span<?php echo $Report1->descripcion->ViewAttributes() ?>>
<?php echo $Report1->descripcion->ViewValue ?></span>
</td>
	</tr>
<?php
		$Report1_report->DetailRecordset->MoveNext();
	}
	$Report1_report->DetailRecordset->Close();

	// Save old group data
	$Report1_report->ReportGroups[0] = $Report1->Id_Remito->CurrentValue;

	// Get next record
	$Report1_report->Recordset->MoveNext();
	if ($Report1_report->Recordset->EOF) {
		$Report1_report->RecCnt = 0; // EOF, force all level breaks
	} else {
		$Report1->Id_Remito->setDbValue($Report1_report->Recordset->fields('Id_Remito'));
	}
	$Report1_report->ChkLvlBreak();

	// Show footers
	if ($Report1_report->LevelBreak[1]) {
		$Report1->Id_Remito->CurrentValue = $Report1_report->ReportGroups[0];

		// Render row for view
		$Report1->RowType = EW_ROWTYPE_VIEW;
		$Report1->ResetAttrs();
		$Report1_report->RenderRow();
		$Report1->Id_Remito->CurrentValue = $Report1->Id_Remito->DbValue;
?>
	<tr><td colspan=16 class="ewGroupSummary"><?php echo $Language->Phrase("RptSumHead") ?>&nbsp;<?php echo $Report1->Id_Remito->FldCaption() ?>:&nbsp;<?php echo $Report1->Id_Remito->ViewValue ?> (<?php echo ew_FormatNumber($Report1_report->ReportCounts[1],0) ?> <?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
	<tr><td colspan=16>&nbsp;<br></td></tr>
<?php
}
}

// Close recordset
$Report1_report->Recordset->Close();
?>
<?php if ($Report1_report->RecordExists) { ?>
	<tr><td colspan=16>&nbsp;<br></td></tr>
	<tr><td colspan=16 class="ewGrandSummary"><?php echo $Language->Phrase("RptGrandTotal") ?>&nbsp;(<?php echo ew_FormatNumber($Report1_report->ReportCounts[0], 0) ?>&nbsp;<?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
<?php if ($Report1_report->RecordExists) { ?>
	<tr><td colspan=16>&nbsp;<br></td></tr>
<?php } else { ?>
	<tr><td><?php echo $Language->Phrase("NoRecord") ?></td></tr>
<?php } ?>
</table>
</form>
<?php
$Report1_report->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($Report1->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$Report1_report->Page_Terminate();
?>
