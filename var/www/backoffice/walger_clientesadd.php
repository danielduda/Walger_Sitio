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

$walger_clientes_add = NULL; // Initialize page object first

class cwalger_clientes_add extends cwalger_clientes {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'walger_clientes';

	// Page object name
	var $PageObjName = 'walger_clientes_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("walger_clienteslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->CodigoCli->SetVisibility();
		$this->Contrasenia->SetVisibility();
		$this->Habilitado->SetVisibility();
		$this->TipoCliente->SetVisibility();
		$this->Regis_Mda->SetVisibility();
		$this->ApellidoNombre->SetVisibility();
		$this->Cargo->SetVisibility();
		$this->Comentarios->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["CodigoCli"] != "") {
				$this->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
				$this->setKey("CodigoCli", $this->CodigoCli->CurrentValue); // Set up key
			} else {
				$this->setKey("CodigoCli", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("walger_clienteslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "walger_clienteslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "walger_clientesview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->CodigoCli->CurrentValue = NULL;
		$this->CodigoCli->OldValue = $this->CodigoCli->CurrentValue;
		$this->Contrasenia->CurrentValue = NULL;
		$this->Contrasenia->OldValue = $this->Contrasenia->CurrentValue;
		$this->Habilitado->CurrentValue = NULL;
		$this->Habilitado->OldValue = $this->Habilitado->CurrentValue;
		$this->TipoCliente->CurrentValue = NULL;
		$this->TipoCliente->OldValue = $this->TipoCliente->CurrentValue;
		$this->Regis_Mda->CurrentValue = NULL;
		$this->Regis_Mda->OldValue = $this->Regis_Mda->CurrentValue;
		$this->ApellidoNombre->CurrentValue = NULL;
		$this->ApellidoNombre->OldValue = $this->ApellidoNombre->CurrentValue;
		$this->Cargo->CurrentValue = NULL;
		$this->Cargo->OldValue = $this->Cargo->CurrentValue;
		$this->Comentarios->CurrentValue = NULL;
		$this->Comentarios->OldValue = $this->Comentarios->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->CodigoCli->FldIsDetailKey) {
			$this->CodigoCli->setFormValue($objForm->GetValue("x_CodigoCli"));
		}
		if (!$this->Contrasenia->FldIsDetailKey) {
			$this->Contrasenia->setFormValue($objForm->GetValue("x_Contrasenia"));
		}
		if (!$this->Habilitado->FldIsDetailKey) {
			$this->Habilitado->setFormValue($objForm->GetValue("x_Habilitado"));
		}
		if (!$this->TipoCliente->FldIsDetailKey) {
			$this->TipoCliente->setFormValue($objForm->GetValue("x_TipoCliente"));
		}
		if (!$this->Regis_Mda->FldIsDetailKey) {
			$this->Regis_Mda->setFormValue($objForm->GetValue("x_Regis_Mda"));
		}
		if (!$this->ApellidoNombre->FldIsDetailKey) {
			$this->ApellidoNombre->setFormValue($objForm->GetValue("x_ApellidoNombre"));
		}
		if (!$this->Cargo->FldIsDetailKey) {
			$this->Cargo->setFormValue($objForm->GetValue("x_Cargo"));
		}
		if (!$this->Comentarios->FldIsDetailKey) {
			$this->Comentarios->setFormValue($objForm->GetValue("x_Comentarios"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->CodigoCli->CurrentValue = $this->CodigoCli->FormValue;
		$this->Contrasenia->CurrentValue = $this->Contrasenia->FormValue;
		$this->Habilitado->CurrentValue = $this->Habilitado->FormValue;
		$this->TipoCliente->CurrentValue = $this->TipoCliente->FormValue;
		$this->Regis_Mda->CurrentValue = $this->Regis_Mda->FormValue;
		$this->ApellidoNombre->CurrentValue = $this->ApellidoNombre->FormValue;
		$this->Cargo->CurrentValue = $this->Cargo->FormValue;
		$this->Comentarios->CurrentValue = $this->Comentarios->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CodigoCli")) <> "")
			$this->CodigoCli->CurrentValue = $this->getKey("CodigoCli"); // CodigoCli
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// CodigoCli
		// pedidosPendientes
		// vencimientosPendientes
		// emailCli
		// Contrasenia
		// Habilitado
		// IP
		// UltimoLogin
		// TipoCliente
		// Regis_Mda
		// ApellidoNombre
		// Cargo
		// Comentarios

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

		// Comentarios
		$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
		$this->Comentarios->ViewCustomAttributes = "";

			// CodigoCli
			$this->CodigoCli->LinkCustomAttributes = "";
			$this->CodigoCli->HrefValue = "";
			$this->CodigoCli->TooltipValue = "";

			// Contrasenia
			$this->Contrasenia->LinkCustomAttributes = "";
			$this->Contrasenia->HrefValue = "";
			$this->Contrasenia->TooltipValue = "";

			// Habilitado
			$this->Habilitado->LinkCustomAttributes = "";
			$this->Habilitado->HrefValue = "";
			$this->Habilitado->TooltipValue = "";

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

			// Comentarios
			$this->Comentarios->LinkCustomAttributes = "";
			$this->Comentarios->HrefValue = "";
			$this->Comentarios->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// CodigoCli
			$this->CodigoCli->EditCustomAttributes = "";
			if (trim(strval($this->CodigoCli->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, `emailCli` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `dbo_cliente`";
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
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->CodigoCli->ViewValue = $this->CodigoCli->DisplayValue($arwrk);
			} else {
				$this->CodigoCli->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->CodigoCli->EditValue = $arwrk;

			// Contrasenia
			$this->Contrasenia->EditAttrs["class"] = "form-control";
			$this->Contrasenia->EditCustomAttributes = "";
			$this->Contrasenia->EditValue = ew_HtmlEncode($this->Contrasenia->CurrentValue);
			$this->Contrasenia->PlaceHolder = ew_RemoveHtml($this->Contrasenia->FldCaption());

			// Habilitado
			$this->Habilitado->EditCustomAttributes = "";
			$this->Habilitado->EditValue = $this->Habilitado->Options(FALSE);

			// TipoCliente
			$this->TipoCliente->EditAttrs["class"] = "form-control";
			$this->TipoCliente->EditCustomAttributes = "";
			$this->TipoCliente->EditValue = $this->TipoCliente->Options(TRUE);

			// Regis_Mda
			$this->Regis_Mda->EditAttrs["class"] = "form-control";
			$this->Regis_Mda->EditCustomAttributes = "";
			if (trim(strval($this->Regis_Mda->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Regis_Mda`" . ew_SearchString("=", $this->Regis_Mda->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Regis_Mda`, `Descr_Mda` AS `DispFld`, `Signo_Mda` AS `Disp2Fld`, `Cotiz_Mda` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `dbo_moneda`";
			$sWhereWrk = "";
			$this->Regis_Mda->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Regis_Mda, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descr_Mda`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][3] = ew_FormatNumber($arwrk[$rowcntwrk][3], 2, -1, 0, 0);
			}
			$this->Regis_Mda->EditValue = $arwrk;

			// ApellidoNombre
			$this->ApellidoNombre->EditAttrs["class"] = "form-control";
			$this->ApellidoNombre->EditCustomAttributes = "";
			$this->ApellidoNombre->EditValue = ew_HtmlEncode($this->ApellidoNombre->CurrentValue);
			$this->ApellidoNombre->PlaceHolder = ew_RemoveHtml($this->ApellidoNombre->FldCaption());

			// Cargo
			$this->Cargo->EditAttrs["class"] = "form-control";
			$this->Cargo->EditCustomAttributes = "";
			$this->Cargo->EditValue = ew_HtmlEncode($this->Cargo->CurrentValue);
			$this->Cargo->PlaceHolder = ew_RemoveHtml($this->Cargo->FldCaption());

			// Comentarios
			$this->Comentarios->EditAttrs["class"] = "form-control";
			$this->Comentarios->EditCustomAttributes = "";
			$this->Comentarios->EditValue = ew_HtmlEncode($this->Comentarios->CurrentValue);
			$this->Comentarios->PlaceHolder = ew_RemoveHtml($this->Comentarios->FldCaption());

			// Add refer script
			// CodigoCli

			$this->CodigoCli->LinkCustomAttributes = "";
			$this->CodigoCli->HrefValue = "";

			// Contrasenia
			$this->Contrasenia->LinkCustomAttributes = "";
			$this->Contrasenia->HrefValue = "";

			// Habilitado
			$this->Habilitado->LinkCustomAttributes = "";
			$this->Habilitado->HrefValue = "";

			// TipoCliente
			$this->TipoCliente->LinkCustomAttributes = "";
			$this->TipoCliente->HrefValue = "";

			// Regis_Mda
			$this->Regis_Mda->LinkCustomAttributes = "";
			$this->Regis_Mda->HrefValue = "";

			// ApellidoNombre
			$this->ApellidoNombre->LinkCustomAttributes = "";
			$this->ApellidoNombre->HrefValue = "";

			// Cargo
			$this->Cargo->LinkCustomAttributes = "";
			$this->Cargo->HrefValue = "";

			// Comentarios
			$this->Comentarios->LinkCustomAttributes = "";
			$this->Comentarios->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->CodigoCli->FldIsDetailKey && !is_null($this->CodigoCli->FormValue) && $this->CodigoCli->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->CodigoCli->FldCaption(), $this->CodigoCli->ReqErrMsg));
		}
		if (!$this->Contrasenia->FldIsDetailKey && !is_null($this->Contrasenia->FormValue) && $this->Contrasenia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Contrasenia->FldCaption(), $this->Contrasenia->ReqErrMsg));
		}
		if ($this->Habilitado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Habilitado->FldCaption(), $this->Habilitado->ReqErrMsg));
		}
		if (!$this->TipoCliente->FldIsDetailKey && !is_null($this->TipoCliente->FormValue) && $this->TipoCliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TipoCliente->FldCaption(), $this->TipoCliente->ReqErrMsg));
		}
		if (!$this->Regis_Mda->FldIsDetailKey && !is_null($this->Regis_Mda->FormValue) && $this->Regis_Mda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Regis_Mda->FldCaption(), $this->Regis_Mda->ReqErrMsg));
		}
		if (!$this->ApellidoNombre->FldIsDetailKey && !is_null($this->ApellidoNombre->FormValue) && $this->ApellidoNombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ApellidoNombre->FldCaption(), $this->ApellidoNombre->ReqErrMsg));
		}
		if (!$this->Cargo->FldIsDetailKey && !is_null($this->Cargo->FormValue) && $this->Cargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cargo->FldCaption(), $this->Cargo->ReqErrMsg));
		}
		if (!$this->Comentarios->FldIsDetailKey && !is_null($this->Comentarios->FormValue) && $this->Comentarios->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Comentarios->FldCaption(), $this->Comentarios->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// CodigoCli
		$this->CodigoCli->SetDbValueDef($rsnew, $this->CodigoCli->CurrentValue, "", FALSE);

		// Contrasenia
		$this->Contrasenia->SetDbValueDef($rsnew, $this->Contrasenia->CurrentValue, "", FALSE);

		// Habilitado
		$this->Habilitado->SetDbValueDef($rsnew, $this->Habilitado->CurrentValue, "", FALSE);

		// TipoCliente
		$this->TipoCliente->SetDbValueDef($rsnew, $this->TipoCliente->CurrentValue, "", FALSE);

		// Regis_Mda
		$this->Regis_Mda->SetDbValueDef($rsnew, $this->Regis_Mda->CurrentValue, NULL, FALSE);

		// ApellidoNombre
		$this->ApellidoNombre->SetDbValueDef($rsnew, $this->ApellidoNombre->CurrentValue, "", FALSE);

		// Cargo
		$this->Cargo->SetDbValueDef($rsnew, $this->Cargo->CurrentValue, "", FALSE);

		// Comentarios
		$this->Comentarios->SetDbValueDef($rsnew, $this->Comentarios->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['CodigoCli']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("walger_clienteslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_CodigoCli":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CodigoCli` AS `LinkFld`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, `emailCli` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "{filter}";
			$this->CodigoCli->LookupFilters = array("dx1" => "`CodigoCli`", "dx2" => "`RazonSocialCli`", "dx3" => "`emailCli`");
			$lookuptblfilter = " `CodigoCli` NOT IN ( SELECT `CodigoCli` FROM walger_clientes ) ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`CodigoCli` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `CodigoCli`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Regis_Mda":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Regis_Mda` AS `LinkFld`, `Descr_Mda` AS `DispFld`, `Signo_Mda` AS `Disp2Fld`, `Cotiz_Mda` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_moneda`";
			$sWhereWrk = "";
			$this->Regis_Mda->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Regis_Mda` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Regis_Mda, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descr_Mda`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($walger_clientes_add)) $walger_clientes_add = new cwalger_clientes_add();

// Page init
$walger_clientes_add->Page_Init();

// Page main
$walger_clientes_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$walger_clientes_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fwalger_clientesadd = new ew_Form("fwalger_clientesadd", "add");

// Validate form
fwalger_clientesadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_CodigoCli");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->CodigoCli->FldCaption(), $walger_clientes->CodigoCli->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Contrasenia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->Contrasenia->FldCaption(), $walger_clientes->Contrasenia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Habilitado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->Habilitado->FldCaption(), $walger_clientes->Habilitado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TipoCliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->TipoCliente->FldCaption(), $walger_clientes->TipoCliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Regis_Mda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->Regis_Mda->FldCaption(), $walger_clientes->Regis_Mda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ApellidoNombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->ApellidoNombre->FldCaption(), $walger_clientes->ApellidoNombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->Cargo->FldCaption(), $walger_clientes->Cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Comentarios");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $walger_clientes->Comentarios->FldCaption(), $walger_clientes->Comentarios->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fwalger_clientesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwalger_clientesadd.ValidateRequired = true;
<?php } else { ?>
fwalger_clientesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwalger_clientesadd.Lists["x_CodigoCli"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","x_emailCli",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};
fwalger_clientesadd.Lists["x_Habilitado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clientesadd.Lists["x_Habilitado"].Options = <?php echo json_encode($walger_clientes->Habilitado->Options()) ?>;
fwalger_clientesadd.Lists["x_TipoCliente"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clientesadd.Lists["x_TipoCliente"].Options = <?php echo json_encode($walger_clientes->TipoCliente->Options()) ?>;
fwalger_clientesadd.Lists["x_Regis_Mda"] = {"LinkField":"x_Regis_Mda","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descr_Mda","x_Signo_Mda","x_Cotiz_Mda",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_moneda"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$walger_clientes_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $walger_clientes_add->ShowPageHeader(); ?>
<?php
$walger_clientes_add->ShowMessage();
?>
<form name="fwalger_clientesadd" id="fwalger_clientesadd" class="<?php echo $walger_clientes_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($walger_clientes_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $walger_clientes_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="walger_clientes">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($walger_clientes_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($walger_clientes->CodigoCli->Visible) { // CodigoCli ?>
	<div id="r_CodigoCli" class="form-group">
		<label id="elh_walger_clientes_CodigoCli" for="x_CodigoCli" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->CodigoCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<span id="el_walger_clientes_CodigoCli">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_CodigoCli"><?php echo (strval($walger_clientes->CodigoCli->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $walger_clientes->CodigoCli->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($walger_clientes->CodigoCli->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_CodigoCli',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="walger_clientes" data-field="x_CodigoCli" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $walger_clientes->CodigoCli->DisplayValueSeparatorAttribute() ?>" name="x_CodigoCli" id="x_CodigoCli" value="<?php echo $walger_clientes->CodigoCli->CurrentValue ?>"<?php echo $walger_clientes->CodigoCli->EditAttributes() ?>>
<input type="hidden" name="s_x_CodigoCli" id="s_x_CodigoCli" value="<?php echo $walger_clientes->CodigoCli->LookupFilterQuery() ?>">
</span>
<?php echo $walger_clientes->CodigoCli->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->Contrasenia->Visible) { // Contrasenia ?>
	<div id="r_Contrasenia" class="form-group">
		<label id="elh_walger_clientes_Contrasenia" for="x_Contrasenia" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->Contrasenia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<span id="el_walger_clientes_Contrasenia">
<input type="text" data-table="walger_clientes" data-field="x_Contrasenia" name="x_Contrasenia" id="x_Contrasenia" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($walger_clientes->Contrasenia->getPlaceHolder()) ?>" value="<?php echo $walger_clientes->Contrasenia->EditValue ?>"<?php echo $walger_clientes->Contrasenia->EditAttributes() ?>>
</span>
<?php echo $walger_clientes->Contrasenia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->Habilitado->Visible) { // Habilitado ?>
	<div id="r_Habilitado" class="form-group">
		<label id="elh_walger_clientes_Habilitado" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->Habilitado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<span id="el_walger_clientes_Habilitado">
<div id="tp_x_Habilitado" class="ewTemplate"><input type="radio" data-table="walger_clientes" data-field="x_Habilitado" data-value-separator="<?php echo $walger_clientes->Habilitado->DisplayValueSeparatorAttribute() ?>" name="x_Habilitado" id="x_Habilitado" value="{value}"<?php echo $walger_clientes->Habilitado->EditAttributes() ?>></div>
<div id="dsl_x_Habilitado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $walger_clientes->Habilitado->RadioButtonListHtml(FALSE, "x_Habilitado") ?>
</div></div>
</span>
<?php echo $walger_clientes->Habilitado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->TipoCliente->Visible) { // TipoCliente ?>
	<div id="r_TipoCliente" class="form-group">
		<label id="elh_walger_clientes_TipoCliente" for="x_TipoCliente" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->TipoCliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<span id="el_walger_clientes_TipoCliente">
<select data-table="walger_clientes" data-field="x_TipoCliente" data-value-separator="<?php echo $walger_clientes->TipoCliente->DisplayValueSeparatorAttribute() ?>" id="x_TipoCliente" name="x_TipoCliente"<?php echo $walger_clientes->TipoCliente->EditAttributes() ?>>
<?php echo $walger_clientes->TipoCliente->SelectOptionListHtml("x_TipoCliente") ?>
</select>
</span>
<?php echo $walger_clientes->TipoCliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->Regis_Mda->Visible) { // Regis_Mda ?>
	<div id="r_Regis_Mda" class="form-group">
		<label id="elh_walger_clientes_Regis_Mda" for="x_Regis_Mda" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->Regis_Mda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<span id="el_walger_clientes_Regis_Mda">
<select data-table="walger_clientes" data-field="x_Regis_Mda" data-value-separator="<?php echo $walger_clientes->Regis_Mda->DisplayValueSeparatorAttribute() ?>" id="x_Regis_Mda" name="x_Regis_Mda"<?php echo $walger_clientes->Regis_Mda->EditAttributes() ?>>
<?php echo $walger_clientes->Regis_Mda->SelectOptionListHtml("x_Regis_Mda") ?>
</select>
<input type="hidden" name="s_x_Regis_Mda" id="s_x_Regis_Mda" value="<?php echo $walger_clientes->Regis_Mda->LookupFilterQuery() ?>">
</span>
<?php echo $walger_clientes->Regis_Mda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->ApellidoNombre->Visible) { // ApellidoNombre ?>
	<div id="r_ApellidoNombre" class="form-group">
		<label id="elh_walger_clientes_ApellidoNombre" for="x_ApellidoNombre" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->ApellidoNombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<span id="el_walger_clientes_ApellidoNombre">
<input type="text" data-table="walger_clientes" data-field="x_ApellidoNombre" name="x_ApellidoNombre" id="x_ApellidoNombre" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($walger_clientes->ApellidoNombre->getPlaceHolder()) ?>" value="<?php echo $walger_clientes->ApellidoNombre->EditValue ?>"<?php echo $walger_clientes->ApellidoNombre->EditAttributes() ?>>
</span>
<?php echo $walger_clientes->ApellidoNombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->Cargo->Visible) { // Cargo ?>
	<div id="r_Cargo" class="form-group">
		<label id="elh_walger_clientes_Cargo" for="x_Cargo" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->Cargo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<span id="el_walger_clientes_Cargo">
<input type="text" data-table="walger_clientes" data-field="x_Cargo" name="x_Cargo" id="x_Cargo" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($walger_clientes->Cargo->getPlaceHolder()) ?>" value="<?php echo $walger_clientes->Cargo->EditValue ?>"<?php echo $walger_clientes->Cargo->EditAttributes() ?>>
</span>
<?php echo $walger_clientes->Cargo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($walger_clientes->Comentarios->Visible) { // Comentarios ?>
	<div id="r_Comentarios" class="form-group">
		<label id="elh_walger_clientes_Comentarios" for="x_Comentarios" class="col-sm-2 control-label ewLabel"><?php echo $walger_clientes->Comentarios->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $walger_clientes->Comentarios->CellAttributes() ?>>
<span id="el_walger_clientes_Comentarios">
<textarea data-table="walger_clientes" data-field="x_Comentarios" name="x_Comentarios" id="x_Comentarios" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($walger_clientes->Comentarios->getPlaceHolder()) ?>"<?php echo $walger_clientes->Comentarios->EditAttributes() ?>><?php echo $walger_clientes->Comentarios->EditValue ?></textarea>
</span>
<?php echo $walger_clientes->Comentarios->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$walger_clientes_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $walger_clientes_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fwalger_clientesadd.Init();
</script>
<?php
$walger_clientes_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$walger_clientes_add->Page_Terminate();
?>
