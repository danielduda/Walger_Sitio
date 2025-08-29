<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "trama_tipos2Darticulosinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$trama_tipos2Darticulos_add = NULL; // Initialize page object first

class ctrama_tipos2Darticulos_add extends ctrama_tipos2Darticulos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'trama_tipos-articulos';

	// Page object name
	var $PageObjName = 'trama_tipos2Darticulos_add';

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

		// Table object (trama_tipos2Darticulos)
		if (!isset($GLOBALS["trama_tipos2Darticulos"]) || get_class($GLOBALS["trama_tipos2Darticulos"]) == "ctrama_tipos2Darticulos") {
			$GLOBALS["trama_tipos2Darticulos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trama_tipos2Darticulos"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trama_tipos-articulos', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("trama_tipos2Darticuloslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->denominacion->SetVisibility();
		$this->atributo1->SetVisibility();
		$this->atributo2->SetVisibility();
		$this->atributo3->SetVisibility();
		$this->atributo4->SetVisibility();

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
		global $EW_EXPORT, $trama_tipos2Darticulos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($trama_tipos2Darticulos);
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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("trama_tipos2Darticuloslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "trama_tipos2Darticuloslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "trama_tipos2Darticulosview.php")
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
		$this->denominacion->CurrentValue = NULL;
		$this->denominacion->OldValue = $this->denominacion->CurrentValue;
		$this->atributo1->CurrentValue = NULL;
		$this->atributo1->OldValue = $this->atributo1->CurrentValue;
		$this->atributo2->CurrentValue = NULL;
		$this->atributo2->OldValue = $this->atributo2->CurrentValue;
		$this->atributo3->CurrentValue = NULL;
		$this->atributo3->OldValue = $this->atributo3->CurrentValue;
		$this->atributo4->CurrentValue = NULL;
		$this->atributo4->OldValue = $this->atributo4->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->denominacion->FldIsDetailKey) {
			$this->denominacion->setFormValue($objForm->GetValue("x_denominacion"));
		}
		if (!$this->atributo1->FldIsDetailKey) {
			$this->atributo1->setFormValue($objForm->GetValue("x_atributo1"));
		}
		if (!$this->atributo2->FldIsDetailKey) {
			$this->atributo2->setFormValue($objForm->GetValue("x_atributo2"));
		}
		if (!$this->atributo3->FldIsDetailKey) {
			$this->atributo3->setFormValue($objForm->GetValue("x_atributo3"));
		}
		if (!$this->atributo4->FldIsDetailKey) {
			$this->atributo4->setFormValue($objForm->GetValue("x_atributo4"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->denominacion->CurrentValue = $this->denominacion->FormValue;
		$this->atributo1->CurrentValue = $this->atributo1->FormValue;
		$this->atributo2->CurrentValue = $this->atributo2->FormValue;
		$this->atributo3->CurrentValue = $this->atributo3->FormValue;
		$this->atributo4->CurrentValue = $this->atributo4->FormValue;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->denominacion->setDbValue($rs->fields('denominacion'));
		$this->atributo1->setDbValue($rs->fields('atributo1'));
		$this->atributo2->setDbValue($rs->fields('atributo2'));
		$this->atributo3->setDbValue($rs->fields('atributo3'));
		$this->atributo4->setDbValue($rs->fields('atributo4'));
		$this->atributo5->setDbValue($rs->fields('atributo5'));
		$this->atributo6->setDbValue($rs->fields('atributo6'));
		$this->atributo7->setDbValue($rs->fields('atributo7'));
		$this->atributo8->setDbValue($rs->fields('atributo8'));
		$this->atributo9->setDbValue($rs->fields('atributo9'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->denominacion->DbValue = $row['denominacion'];
		$this->atributo1->DbValue = $row['atributo1'];
		$this->atributo2->DbValue = $row['atributo2'];
		$this->atributo3->DbValue = $row['atributo3'];
		$this->atributo4->DbValue = $row['atributo4'];
		$this->atributo5->DbValue = $row['atributo5'];
		$this->atributo6->DbValue = $row['atributo6'];
		$this->atributo7->DbValue = $row['atributo7'];
		$this->atributo8->DbValue = $row['atributo8'];
		$this->atributo9->DbValue = $row['atributo9'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// denominacion
		// atributo1
		// atributo2
		// atributo3
		// atributo4
		// atributo5
		// atributo6
		// atributo7
		// atributo8
		// atributo9

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// denominacion
		$this->denominacion->ViewValue = $this->denominacion->CurrentValue;
		$this->denominacion->ViewCustomAttributes = "";

		// atributo1
		if (strval($this->atributo1->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
		$sWhereWrk = "";
		$this->atributo1->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->atributo1, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->atributo1->ViewValue = $this->atributo1->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->atributo1->ViewValue = $this->atributo1->CurrentValue;
			}
		} else {
			$this->atributo1->ViewValue = NULL;
		}
		$this->atributo1->ViewCustomAttributes = "";

		// atributo2
		if (strval($this->atributo2->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo2->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
		$sWhereWrk = "";
		$this->atributo2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->atributo2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->atributo2->ViewValue = $this->atributo2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->atributo2->ViewValue = $this->atributo2->CurrentValue;
			}
		} else {
			$this->atributo2->ViewValue = NULL;
		}
		$this->atributo2->ViewCustomAttributes = "";

		// atributo3
		if (strval($this->atributo3->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo3->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
		$sWhereWrk = "";
		$this->atributo3->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->atributo3, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->atributo3->ViewValue = $this->atributo3->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->atributo3->ViewValue = $this->atributo3->CurrentValue;
			}
		} else {
			$this->atributo3->ViewValue = NULL;
		}
		$this->atributo3->ViewCustomAttributes = "";

		// atributo4
		if (strval($this->atributo4->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo4->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
		$sWhereWrk = "";
		$this->atributo4->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->atributo4, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->atributo4->ViewValue = $this->atributo4->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->atributo4->ViewValue = $this->atributo4->CurrentValue;
			}
		} else {
			$this->atributo4->ViewValue = NULL;
		}
		$this->atributo4->ViewCustomAttributes = "";

			// denominacion
			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";
			$this->denominacion->TooltipValue = "";

			// atributo1
			$this->atributo1->LinkCustomAttributes = "";
			$this->atributo1->HrefValue = "";
			$this->atributo1->TooltipValue = "";

			// atributo2
			$this->atributo2->LinkCustomAttributes = "";
			$this->atributo2->HrefValue = "";
			$this->atributo2->TooltipValue = "";

			// atributo3
			$this->atributo3->LinkCustomAttributes = "";
			$this->atributo3->HrefValue = "";
			$this->atributo3->TooltipValue = "";

			// atributo4
			$this->atributo4->LinkCustomAttributes = "";
			$this->atributo4->HrefValue = "";
			$this->atributo4->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// denominacion
			$this->denominacion->EditAttrs["class"] = "form-control";
			$this->denominacion->EditCustomAttributes = "";
			$this->denominacion->EditValue = ew_HtmlEncode($this->denominacion->CurrentValue);
			$this->denominacion->PlaceHolder = ew_RemoveHtml($this->denominacion->FldCaption());

			// atributo1
			$this->atributo1->EditAttrs["class"] = "form-control";
			$this->atributo1->EditCustomAttributes = "";
			if (trim(strval($this->atributo1->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo1->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo1->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->atributo1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->atributo1->EditValue = $arwrk;

			// atributo2
			$this->atributo2->EditAttrs["class"] = "form-control";
			$this->atributo2->EditCustomAttributes = "";
			if (trim(strval($this->atributo2->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo2->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo2->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->atributo2, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->atributo2->EditValue = $arwrk;

			// atributo3
			$this->atributo3->EditAttrs["class"] = "form-control";
			$this->atributo3->EditCustomAttributes = "";
			if (trim(strval($this->atributo3->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo3->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo3->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->atributo3, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->atributo3->EditValue = $arwrk;

			// atributo4
			$this->atributo4->EditAttrs["class"] = "form-control";
			$this->atributo4->EditCustomAttributes = "";
			if (trim(strval($this->atributo4->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->atributo4->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo4->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->atributo4, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->atributo4->EditValue = $arwrk;

			// Add refer script
			// denominacion

			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";

			// atributo1
			$this->atributo1->LinkCustomAttributes = "";
			$this->atributo1->HrefValue = "";

			// atributo2
			$this->atributo2->LinkCustomAttributes = "";
			$this->atributo2->HrefValue = "";

			// atributo3
			$this->atributo3->LinkCustomAttributes = "";
			$this->atributo3->HrefValue = "";

			// atributo4
			$this->atributo4->LinkCustomAttributes = "";
			$this->atributo4->HrefValue = "";
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
		if (!$this->denominacion->FldIsDetailKey && !is_null($this->denominacion->FormValue) && $this->denominacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->denominacion->FldCaption(), $this->denominacion->ReqErrMsg));
		}
		if (!$this->atributo1->FldIsDetailKey && !is_null($this->atributo1->FormValue) && $this->atributo1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->atributo1->FldCaption(), $this->atributo1->ReqErrMsg));
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

		// denominacion
		$this->denominacion->SetDbValueDef($rsnew, $this->denominacion->CurrentValue, NULL, FALSE);

		// atributo1
		$this->atributo1->SetDbValueDef($rsnew, $this->atributo1->CurrentValue, NULL, FALSE);

		// atributo2
		$this->atributo2->SetDbValueDef($rsnew, $this->atributo2->CurrentValue, NULL, FALSE);

		// atributo3
		$this->atributo3->SetDbValueDef($rsnew, $this->atributo3->CurrentValue, NULL, FALSE);

		// atributo4
		$this->atributo4->SetDbValueDef($rsnew, $this->atributo4->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id->setDbValue($conn->Insert_ID());
				$rsnew['id'] = $this->id->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("trama_tipos2Darticuloslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_atributo1":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo1->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->atributo1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_atributo2":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo2->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->atributo2, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_atributo3":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo3->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->atributo3, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_atributo4":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_atributos`";
			$sWhereWrk = "";
			$this->atributo4->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->atributo4, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
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
if (!isset($trama_tipos2Darticulos_add)) $trama_tipos2Darticulos_add = new ctrama_tipos2Darticulos_add();

// Page init
$trama_tipos2Darticulos_add->Page_Init();

// Page main
$trama_tipos2Darticulos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_tipos2Darticulos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftrama_tipos2Darticulosadd = new ew_Form("ftrama_tipos2Darticulosadd", "add");

// Validate form
ftrama_tipos2Darticulosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_denominacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_tipos2Darticulos->denominacion->FldCaption(), $trama_tipos2Darticulos->denominacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_atributo1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_tipos2Darticulos->atributo1->FldCaption(), $trama_tipos2Darticulos->atributo1->ReqErrMsg)) ?>");

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
ftrama_tipos2Darticulosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_tipos2Darticulosadd.ValidateRequired = true;
<?php } else { ?>
ftrama_tipos2Darticulosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_tipos2Darticulosadd.Lists["x_atributo1"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_atributos"};
ftrama_tipos2Darticulosadd.Lists["x_atributo2"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_atributos"};
ftrama_tipos2Darticulosadd.Lists["x_atributo3"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_atributos"};
ftrama_tipos2Darticulosadd.Lists["x_atributo4"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_atributos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$trama_tipos2Darticulos_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $trama_tipos2Darticulos_add->ShowPageHeader(); ?>
<?php
$trama_tipos2Darticulos_add->ShowMessage();
?>
<form name="ftrama_tipos2Darticulosadd" id="ftrama_tipos2Darticulosadd" class="<?php echo $trama_tipos2Darticulos_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($trama_tipos2Darticulos_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $trama_tipos2Darticulos_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="trama_tipos2Darticulos">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($trama_tipos2Darticulos_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($trama_tipos2Darticulos->denominacion->Visible) { // denominacion ?>
	<div id="r_denominacion" class="form-group">
		<label id="elh_trama_tipos2Darticulos_denominacion" for="x_denominacion" class="col-sm-2 control-label ewLabel"><?php echo $trama_tipos2Darticulos->denominacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_tipos2Darticulos->denominacion->CellAttributes() ?>>
<span id="el_trama_tipos2Darticulos_denominacion">
<input type="text" data-table="trama_tipos2Darticulos" data-field="x_denominacion" name="x_denominacion" id="x_denominacion" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_tipos2Darticulos->denominacion->getPlaceHolder()) ?>" value="<?php echo $trama_tipos2Darticulos->denominacion->EditValue ?>"<?php echo $trama_tipos2Darticulos->denominacion->EditAttributes() ?>>
</span>
<?php echo $trama_tipos2Darticulos->denominacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_tipos2Darticulos->atributo1->Visible) { // atributo1 ?>
	<div id="r_atributo1" class="form-group">
		<label id="elh_trama_tipos2Darticulos_atributo1" for="x_atributo1" class="col-sm-2 control-label ewLabel"><?php echo $trama_tipos2Darticulos->atributo1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_tipos2Darticulos->atributo1->CellAttributes() ?>>
<span id="el_trama_tipos2Darticulos_atributo1">
<select data-table="trama_tipos2Darticulos" data-field="x_atributo1" data-value-separator="<?php echo $trama_tipos2Darticulos->atributo1->DisplayValueSeparatorAttribute() ?>" id="x_atributo1" name="x_atributo1"<?php echo $trama_tipos2Darticulos->atributo1->EditAttributes() ?>>
<?php echo $trama_tipos2Darticulos->atributo1->SelectOptionListHtml("x_atributo1") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_tipos2Darticulos->atributo1->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_atributo1',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_atributo1"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_tipos2Darticulos->atributo1->FldCaption() ?></span></button>
<input type="hidden" name="s_x_atributo1" id="s_x_atributo1" value="<?php echo $trama_tipos2Darticulos->atributo1->LookupFilterQuery() ?>">
</span>
<?php echo $trama_tipos2Darticulos->atributo1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_tipos2Darticulos->atributo2->Visible) { // atributo2 ?>
	<div id="r_atributo2" class="form-group">
		<label id="elh_trama_tipos2Darticulos_atributo2" for="x_atributo2" class="col-sm-2 control-label ewLabel"><?php echo $trama_tipos2Darticulos->atributo2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_tipos2Darticulos->atributo2->CellAttributes() ?>>
<span id="el_trama_tipos2Darticulos_atributo2">
<select data-table="trama_tipos2Darticulos" data-field="x_atributo2" data-value-separator="<?php echo $trama_tipos2Darticulos->atributo2->DisplayValueSeparatorAttribute() ?>" id="x_atributo2" name="x_atributo2"<?php echo $trama_tipos2Darticulos->atributo2->EditAttributes() ?>>
<?php echo $trama_tipos2Darticulos->atributo2->SelectOptionListHtml("x_atributo2") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_tipos2Darticulos->atributo2->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_atributo2',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_atributo2"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_tipos2Darticulos->atributo2->FldCaption() ?></span></button>
<input type="hidden" name="s_x_atributo2" id="s_x_atributo2" value="<?php echo $trama_tipos2Darticulos->atributo2->LookupFilterQuery() ?>">
</span>
<?php echo $trama_tipos2Darticulos->atributo2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_tipos2Darticulos->atributo3->Visible) { // atributo3 ?>
	<div id="r_atributo3" class="form-group">
		<label id="elh_trama_tipos2Darticulos_atributo3" for="x_atributo3" class="col-sm-2 control-label ewLabel"><?php echo $trama_tipos2Darticulos->atributo3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_tipos2Darticulos->atributo3->CellAttributes() ?>>
<span id="el_trama_tipos2Darticulos_atributo3">
<select data-table="trama_tipos2Darticulos" data-field="x_atributo3" data-value-separator="<?php echo $trama_tipos2Darticulos->atributo3->DisplayValueSeparatorAttribute() ?>" id="x_atributo3" name="x_atributo3"<?php echo $trama_tipos2Darticulos->atributo3->EditAttributes() ?>>
<?php echo $trama_tipos2Darticulos->atributo3->SelectOptionListHtml("x_atributo3") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_tipos2Darticulos->atributo3->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_atributo3',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_atributo3"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_tipos2Darticulos->atributo3->FldCaption() ?></span></button>
<input type="hidden" name="s_x_atributo3" id="s_x_atributo3" value="<?php echo $trama_tipos2Darticulos->atributo3->LookupFilterQuery() ?>">
</span>
<?php echo $trama_tipos2Darticulos->atributo3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_tipos2Darticulos->atributo4->Visible) { // atributo4 ?>
	<div id="r_atributo4" class="form-group">
		<label id="elh_trama_tipos2Darticulos_atributo4" for="x_atributo4" class="col-sm-2 control-label ewLabel"><?php echo $trama_tipos2Darticulos->atributo4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_tipos2Darticulos->atributo4->CellAttributes() ?>>
<span id="el_trama_tipos2Darticulos_atributo4">
<select data-table="trama_tipos2Darticulos" data-field="x_atributo4" data-value-separator="<?php echo $trama_tipos2Darticulos->atributo4->DisplayValueSeparatorAttribute() ?>" id="x_atributo4" name="x_atributo4"<?php echo $trama_tipos2Darticulos->atributo4->EditAttributes() ?>>
<?php echo $trama_tipos2Darticulos->atributo4->SelectOptionListHtml("x_atributo4") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_tipos2Darticulos->atributo4->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_atributo4',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_atributo4"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_tipos2Darticulos->atributo4->FldCaption() ?></span></button>
<input type="hidden" name="s_x_atributo4" id="s_x_atributo4" value="<?php echo $trama_tipos2Darticulos->atributo4->LookupFilterQuery() ?>">
</span>
<?php echo $trama_tipos2Darticulos->atributo4->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$trama_tipos2Darticulos_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $trama_tipos2Darticulos_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftrama_tipos2Darticulosadd.Init();
</script>
<?php
$trama_tipos2Darticulos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$trama_tipos2Darticulos_add->Page_Terminate();
?>
