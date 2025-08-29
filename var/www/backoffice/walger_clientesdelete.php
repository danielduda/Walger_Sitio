<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "walger_clientesinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$walger_clientes_delete = NULL; // Initialize page object first

class cwalger_clientes_delete extends cwalger_clientes {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'walger_clientes';

	// Page object name
	var $PageObjName = 'walger_clientes_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
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
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
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

		// Parent constuctor
		parent::__construct();

		// Table object (walger_clientes)
		if (!isset($GLOBALS["walger_clientes"]) || get_class($GLOBALS["walger_clientes"]) == "cwalger_clientes") {
			$GLOBALS["walger_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["walger_clientes"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'walger_clientes', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

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
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("walger_clienteslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->CodigoCli->SetVisibility();
		$this->pedidosPendientes->SetVisibility();
		$this->vencimientosPendientes->SetVisibility();
		$this->emailCli->SetVisibility();
		$this->Contrasenia->SetVisibility();
		$this->Habilitado->SetVisibility();
		$this->IP->SetVisibility();
		$this->UltimoLogin->SetVisibility();
		$this->TipoCliente->SetVisibility();
		$this->Regis_Mda->SetVisibility();
		$this->ApellidoNombre->SetVisibility();
		$this->Cargo->SetVisibility();

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
		global $EW_EXPORT, $walger_clientes;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($walger_clientes);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("walger_clienteslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in walger_clientes class, walger_clientesinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("walger_clienteslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		if (array_key_exists('EV__CodigoCli', $rs->fields)) {
			$this->CodigoCli->VirtualValue = $rs->fields('EV__CodigoCli'); // Set up virtual field value
		} else {
			$this->CodigoCli->VirtualValue = ""; // Clear value
		}
		$this->pedidosPendientes->setDbValue($rs->fields('pedidosPendientes'));
		$this->vencimientosPendientes->setDbValue($rs->fields('vencimientosPendientes'));
		$this->emailCli->setDbValue($rs->fields('emailCli'));
		$this->Contrasenia->setDbValue($rs->fields('Contrasenia'));
		$this->Habilitado->setDbValue($rs->fields('Habilitado'));
		$this->IP->setDbValue($rs->fields('IP'));
		$this->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
		$this->TipoCliente->setDbValue($rs->fields('TipoCliente'));
		$this->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
		$this->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
		$this->Cargo->setDbValue($rs->fields('Cargo'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CodigoCli->DbValue = $row['CodigoCli'];
		$this->pedidosPendientes->DbValue = $row['pedidosPendientes'];
		$this->vencimientosPendientes->DbValue = $row['vencimientosPendientes'];
		$this->emailCli->DbValue = $row['emailCli'];
		$this->Contrasenia->DbValue = $row['Contrasenia'];
		$this->Habilitado->DbValue = $row['Habilitado'];
		$this->IP->DbValue = $row['IP'];
		$this->UltimoLogin->DbValue = $row['UltimoLogin'];
		$this->TipoCliente->DbValue = $row['TipoCliente'];
		$this->Regis_Mda->DbValue = $row['Regis_Mda'];
		$this->ApellidoNombre->DbValue = $row['ApellidoNombre'];
		$this->Cargo->DbValue = $row['Cargo'];
		$this->Comentarios->DbValue = $row['Comentarios'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// CodigoCli

		$this->CodigoCli->CellCssStyle = "white-space: nowrap;";

		// pedidosPendientes
		$this->pedidosPendientes->CellCssStyle = "white-space: nowrap;";

		// vencimientosPendientes
		$this->vencimientosPendientes->CellCssStyle = "white-space: nowrap;";

		// emailCli
		$this->emailCli->CellCssStyle = "white-space: nowrap;";

		// Contrasenia
		$this->Contrasenia->CellCssStyle = "white-space: nowrap;";

		// Habilitado
		$this->Habilitado->CellCssStyle = "white-space: nowrap;";

		// IP
		$this->IP->CellCssStyle = "white-space: nowrap;";

		// UltimoLogin
		$this->UltimoLogin->CellCssStyle = "white-space: nowrap;";

		// TipoCliente
		$this->TipoCliente->CellCssStyle = "white-space: nowrap;";

		// Regis_Mda
		$this->Regis_Mda->CellCssStyle = "white-space: nowrap;";

		// ApellidoNombre
		$this->ApellidoNombre->CellCssStyle = "white-space: nowrap;";

		// Cargo
		$this->Cargo->CellCssStyle = "white-space: nowrap;";

		// Comentarios
		$this->Comentarios->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		if ($this->CodigoCli->VirtualValue <> "") {
			$this->CodigoCli->ViewValue = $this->CodigoCli->VirtualValue;
		} else {
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, `emailCli` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array("dx1" => "`CodigoCli`", "dx2" => "`RazonSocialCli`", "dx3" => "`emailCli`");
		$lookuptblfilter = " `CodigoCli` NOT IN ( SELECT `CodigoCli` FROM walger_clientes ) ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `CodigoCli`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->CodigoCli->ViewValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->ViewValue = NULL;
		}
		}
		$this->CodigoCli->ViewCustomAttributes = "";

		// pedidosPendientes
		$this->pedidosPendientes->ViewValue = $this->pedidosPendientes->CurrentValue;
		$this->pedidosPendientes->ViewCustomAttributes = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->ViewValue = $this->vencimientosPendientes->CurrentValue;
		$this->vencimientosPendientes->ViewCustomAttributes = "";

		// emailCli
		$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
		$this->emailCli->ViewCustomAttributes = "";

		// Contrasenia
		$this->Contrasenia->ViewValue = $this->Contrasenia->CurrentValue;
		$this->Contrasenia->ViewCustomAttributes = "";

		// Habilitado
		if (strval($this->Habilitado->CurrentValue) <> "") {
			$this->Habilitado->ViewValue = $this->Habilitado->OptionCaption($this->Habilitado->CurrentValue);
		} else {
			$this->Habilitado->ViewValue = NULL;
		}
		$this->Habilitado->ViewCustomAttributes = "";

		// IP
		$this->IP->ViewValue = $this->IP->CurrentValue;
		$this->IP->ViewCustomAttributes = "";

		// UltimoLogin
		$this->UltimoLogin->ViewValue = $this->UltimoLogin->CurrentValue;
		$this->UltimoLogin->ViewValue = ew_FormatDateTime($this->UltimoLogin->ViewValue, 1);
		$this->UltimoLogin->ViewCustomAttributes = "";

		// TipoCliente
		if (strval($this->TipoCliente->CurrentValue) <> "") {
			$this->TipoCliente->ViewValue = $this->TipoCliente->OptionCaption($this->TipoCliente->CurrentValue);
		} else {
			$this->TipoCliente->ViewValue = NULL;
		}
		$this->TipoCliente->ViewCustomAttributes = "";

		// Regis_Mda
		if (strval($this->Regis_Mda->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_Mda`" . ew_SearchString("=", $this->Regis_Mda->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_Mda`, `Descr_Mda` AS `DispFld`, `Signo_Mda` AS `Disp2Fld`, `Cotiz_Mda` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_moneda`";
		$sWhereWrk = "";
		$this->Regis_Mda->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_Mda, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descr_Mda`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = ew_FormatNumber($rswrk->fields('Disp3Fld'), 2, -1, 0, 0);
				$this->Regis_Mda->ViewValue = $this->Regis_Mda->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_Mda->ViewValue = $this->Regis_Mda->CurrentValue;
			}
		} else {
			$this->Regis_Mda->ViewValue = NULL;
		}
		$this->Regis_Mda->ViewCustomAttributes = "";

		// ApellidoNombre
		$this->ApellidoNombre->ViewValue = $this->ApellidoNombre->CurrentValue;
		$this->ApellidoNombre->ViewCustomAttributes = "";

		// Cargo
		$this->Cargo->ViewValue = $this->Cargo->CurrentValue;
		$this->Cargo->ViewCustomAttributes = "";

			// CodigoCli
			$this->CodigoCli->LinkCustomAttributes = "";
			$this->CodigoCli->HrefValue = "";
			$this->CodigoCli->TooltipValue = "";

			// pedidosPendientes
			$this->pedidosPendientes->LinkCustomAttributes = "";
			$this->pedidosPendientes->HrefValue = "";
			$this->pedidosPendientes->TooltipValue = "";

			// vencimientosPendientes
			$this->vencimientosPendientes->LinkCustomAttributes = "";
			$this->vencimientosPendientes->HrefValue = "";
			$this->vencimientosPendientes->TooltipValue = "";

			// emailCli
			$this->emailCli->LinkCustomAttributes = "";
			$this->emailCli->HrefValue = "";
			$this->emailCli->TooltipValue = "";

			// Contrasenia
			$this->Contrasenia->LinkCustomAttributes = "";
			$this->Contrasenia->HrefValue = "";
			$this->Contrasenia->TooltipValue = "";

			// Habilitado
			$this->Habilitado->LinkCustomAttributes = "";
			$this->Habilitado->HrefValue = "";
			$this->Habilitado->TooltipValue = "";

			// IP
			$this->IP->LinkCustomAttributes = "";
			$this->IP->HrefValue = "";
			$this->IP->TooltipValue = "";

			// UltimoLogin
			$this->UltimoLogin->LinkCustomAttributes = "";
			$this->UltimoLogin->HrefValue = "";
			$this->UltimoLogin->TooltipValue = "";

			// TipoCliente
			$this->TipoCliente->LinkCustomAttributes = "";
			$this->TipoCliente->HrefValue = "";
			$this->TipoCliente->TooltipValue = "";

			// Regis_Mda
			$this->Regis_Mda->LinkCustomAttributes = "";
			$this->Regis_Mda->HrefValue = "";
			$this->Regis_Mda->TooltipValue = "";

			// ApellidoNombre
			$this->ApellidoNombre->LinkCustomAttributes = "";
			$this->ApellidoNombre->HrefValue = "";
			$this->ApellidoNombre->TooltipValue = "";

			// Cargo
			$this->Cargo->LinkCustomAttributes = "";
			$this->Cargo->HrefValue = "";
			$this->Cargo->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['CodigoCli'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("walger_clienteslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($walger_clientes_delete)) $walger_clientes_delete = new cwalger_clientes_delete();

// Page init
$walger_clientes_delete->Page_Init();

// Page main
$walger_clientes_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$walger_clientes_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fwalger_clientesdelete = new ew_Form("fwalger_clientesdelete", "delete");

// Form_CustomValidate event
fwalger_clientesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwalger_clientesdelete.ValidateRequired = true;
<?php } else { ?>
fwalger_clientesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwalger_clientesdelete.Lists["x_CodigoCli"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","x_emailCli",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};
fwalger_clientesdelete.Lists["x_Habilitado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clientesdelete.Lists["x_Habilitado"].Options = <?php echo json_encode($walger_clientes->Habilitado->Options()) ?>;
fwalger_clientesdelete.Lists["x_TipoCliente"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clientesdelete.Lists["x_TipoCliente"].Options = <?php echo json_encode($walger_clientes->TipoCliente->Options()) ?>;
fwalger_clientesdelete.Lists["x_Regis_Mda"] = {"LinkField":"x_Regis_Mda","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descr_Mda","x_Signo_Mda","x_Cotiz_Mda",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_moneda"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $walger_clientes_delete->ShowPageHeader(); ?>
<?php
$walger_clientes_delete->ShowMessage();
?>
<form name="fwalger_clientesdelete" id="fwalger_clientesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($walger_clientes_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $walger_clientes_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="walger_clientes">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($walger_clientes_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $walger_clientes->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($walger_clientes->CodigoCli->Visible) { // CodigoCli ?>
		<th><span id="elh_walger_clientes_CodigoCli" class="walger_clientes_CodigoCli"><?php echo $walger_clientes->CodigoCli->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->pedidosPendientes->Visible) { // pedidosPendientes ?>
		<th><span id="elh_walger_clientes_pedidosPendientes" class="walger_clientes_pedidosPendientes"><?php echo $walger_clientes->pedidosPendientes->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
		<th><span id="elh_walger_clientes_vencimientosPendientes" class="walger_clientes_vencimientosPendientes"><?php echo $walger_clientes->vencimientosPendientes->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->emailCli->Visible) { // emailCli ?>
		<th><span id="elh_walger_clientes_emailCli" class="walger_clientes_emailCli"><?php echo $walger_clientes->emailCli->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->Contrasenia->Visible) { // Contrasenia ?>
		<th><span id="elh_walger_clientes_Contrasenia" class="walger_clientes_Contrasenia"><?php echo $walger_clientes->Contrasenia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->Habilitado->Visible) { // Habilitado ?>
		<th><span id="elh_walger_clientes_Habilitado" class="walger_clientes_Habilitado"><?php echo $walger_clientes->Habilitado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->IP->Visible) { // IP ?>
		<th><span id="elh_walger_clientes_IP" class="walger_clientes_IP"><?php echo $walger_clientes->IP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->UltimoLogin->Visible) { // UltimoLogin ?>
		<th><span id="elh_walger_clientes_UltimoLogin" class="walger_clientes_UltimoLogin"><?php echo $walger_clientes->UltimoLogin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->TipoCliente->Visible) { // TipoCliente ?>
		<th><span id="elh_walger_clientes_TipoCliente" class="walger_clientes_TipoCliente"><?php echo $walger_clientes->TipoCliente->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->Regis_Mda->Visible) { // Regis_Mda ?>
		<th><span id="elh_walger_clientes_Regis_Mda" class="walger_clientes_Regis_Mda"><?php echo $walger_clientes->Regis_Mda->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->ApellidoNombre->Visible) { // ApellidoNombre ?>
		<th><span id="elh_walger_clientes_ApellidoNombre" class="walger_clientes_ApellidoNombre"><?php echo $walger_clientes->ApellidoNombre->FldCaption() ?></span></th>
<?php } ?>
<?php if ($walger_clientes->Cargo->Visible) { // Cargo ?>
		<th><span id="elh_walger_clientes_Cargo" class="walger_clientes_Cargo"><?php echo $walger_clientes->Cargo->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$walger_clientes_delete->RecCnt = 0;
$i = 0;
while (!$walger_clientes_delete->Recordset->EOF) {
	$walger_clientes_delete->RecCnt++;
	$walger_clientes_delete->RowCnt++;

	// Set row properties
	$walger_clientes->ResetAttrs();
	$walger_clientes->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$walger_clientes_delete->LoadRowValues($walger_clientes_delete->Recordset);

	// Render row
	$walger_clientes_delete->RenderRow();
?>
	<tr<?php echo $walger_clientes->RowAttributes() ?>>
<?php if ($walger_clientes->CodigoCli->Visible) { // CodigoCli ?>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_CodigoCli" class="walger_clientes_CodigoCli">
<span<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>>
<?php echo $walger_clientes->CodigoCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->pedidosPendientes->Visible) { // pedidosPendientes ?>
		<td<?php echo $walger_clientes->pedidosPendientes->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_pedidosPendientes" class="walger_clientes_pedidosPendientes">
<span<?php echo $walger_clientes->pedidosPendientes->ViewAttributes() ?>>
<?php echo $walger_clientes->pedidosPendientes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
		<td<?php echo $walger_clientes->vencimientosPendientes->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_vencimientosPendientes" class="walger_clientes_vencimientosPendientes">
<span<?php echo $walger_clientes->vencimientosPendientes->ViewAttributes() ?>>
<?php echo $walger_clientes->vencimientosPendientes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->emailCli->Visible) { // emailCli ?>
		<td<?php echo $walger_clientes->emailCli->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_emailCli" class="walger_clientes_emailCli">
<span<?php echo $walger_clientes->emailCli->ViewAttributes() ?>>
<?php echo $walger_clientes->emailCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->Contrasenia->Visible) { // Contrasenia ?>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_Contrasenia" class="walger_clientes_Contrasenia">
<span<?php echo $walger_clientes->Contrasenia->ViewAttributes() ?>>
<?php echo $walger_clientes->Contrasenia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->Habilitado->Visible) { // Habilitado ?>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_Habilitado" class="walger_clientes_Habilitado">
<span<?php echo $walger_clientes->Habilitado->ViewAttributes() ?>>
<?php echo $walger_clientes->Habilitado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->IP->Visible) { // IP ?>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_IP" class="walger_clientes_IP">
<span<?php echo $walger_clientes->IP->ViewAttributes() ?>>
<?php echo $walger_clientes->IP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->UltimoLogin->Visible) { // UltimoLogin ?>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_UltimoLogin" class="walger_clientes_UltimoLogin">
<span<?php echo $walger_clientes->UltimoLogin->ViewAttributes() ?>>
<?php echo $walger_clientes->UltimoLogin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->TipoCliente->Visible) { // TipoCliente ?>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_TipoCliente" class="walger_clientes_TipoCliente">
<span<?php echo $walger_clientes->TipoCliente->ViewAttributes() ?>>
<?php echo $walger_clientes->TipoCliente->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->Regis_Mda->Visible) { // Regis_Mda ?>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_Regis_Mda" class="walger_clientes_Regis_Mda">
<span<?php echo $walger_clientes->Regis_Mda->ViewAttributes() ?>>
<?php echo $walger_clientes->Regis_Mda->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->ApellidoNombre->Visible) { // ApellidoNombre ?>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_ApellidoNombre" class="walger_clientes_ApellidoNombre">
<span<?php echo $walger_clientes->ApellidoNombre->ViewAttributes() ?>>
<?php echo $walger_clientes->ApellidoNombre->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($walger_clientes->Cargo->Visible) { // Cargo ?>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_delete->RowCnt ?>_walger_clientes_Cargo" class="walger_clientes_Cargo">
<span<?php echo $walger_clientes->Cargo->ViewAttributes() ?>>
<?php echo $walger_clientes->Cargo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$walger_clientes_delete->Recordset->MoveNext();
}
$walger_clientes_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $walger_clientes_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fwalger_clientesdelete.Init();
</script>
<?php
$walger_clientes_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$walger_clientes_delete->Page_Terminate();
?>
