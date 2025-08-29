<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "trama_cuotas2Drecargosinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$trama_cuotas2Drecargos_add = NULL; // Initialize page object first

class ctrama_cuotas2Drecargos_add extends ctrama_cuotas2Drecargos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'trama_cuotas-recargos';

	// Page object name
	var $PageObjName = 'trama_cuotas2Drecargos_add';

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

		// Table object (trama_cuotas2Drecargos)
		if (!isset($GLOBALS["trama_cuotas2Drecargos"]) || get_class($GLOBALS["trama_cuotas2Drecargos"]) == "ctrama_cuotas2Drecargos") {
			$GLOBALS["trama_cuotas2Drecargos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trama_cuotas2Drecargos"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trama_cuotas-recargos', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("trama_cuotas2Drecargoslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idMedioPago->SetVisibility();
		$this->cuotas->SetVisibility();
		$this->recargo->SetVisibility();
		$this->activo->SetVisibility();

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
		global $EW_EXPORT, $trama_cuotas2Drecargos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($trama_cuotas2Drecargos);
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
					$this->Page_Terminate("trama_cuotas2Drecargoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "trama_cuotas2Drecargoslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "trama_cuotas2Drecargosview.php")
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
		$this->idMedioPago->CurrentValue = NULL;
		$this->idMedioPago->OldValue = $this->idMedioPago->CurrentValue;
		$this->cuotas->CurrentValue = NULL;
		$this->cuotas->OldValue = $this->cuotas->CurrentValue;
		$this->recargo->CurrentValue = NULL;
		$this->recargo->OldValue = $this->recargo->CurrentValue;
		$this->activo->CurrentValue = NULL;
		$this->activo->OldValue = $this->activo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idMedioPago->FldIsDetailKey) {
			$this->idMedioPago->setFormValue($objForm->GetValue("x_idMedioPago"));
		}
		if (!$this->cuotas->FldIsDetailKey) {
			$this->cuotas->setFormValue($objForm->GetValue("x_cuotas"));
		}
		if (!$this->recargo->FldIsDetailKey) {
			$this->recargo->setFormValue($objForm->GetValue("x_recargo"));
		}
		if (!$this->activo->FldIsDetailKey) {
			$this->activo->setFormValue($objForm->GetValue("x_activo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idMedioPago->CurrentValue = $this->idMedioPago->FormValue;
		$this->cuotas->CurrentValue = $this->cuotas->FormValue;
		$this->recargo->CurrentValue = $this->recargo->FormValue;
		$this->activo->CurrentValue = $this->activo->FormValue;
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
		$this->idMedioPago->setDbValue($rs->fields('idMedioPago'));
		$this->cuotas->setDbValue($rs->fields('cuotas'));
		$this->recargo->setDbValue($rs->fields('recargo'));
		$this->activo->setDbValue($rs->fields('activo'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->idMedioPago->DbValue = $row['idMedioPago'];
		$this->cuotas->DbValue = $row['cuotas'];
		$this->recargo->DbValue = $row['recargo'];
		$this->activo->DbValue = $row['activo'];
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
		// Convert decimal values if posted back

		if ($this->recargo->FormValue == $this->recargo->CurrentValue && is_numeric(ew_StrToFloat($this->recargo->CurrentValue)))
			$this->recargo->CurrentValue = ew_StrToFloat($this->recargo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// idMedioPago
		// cuotas
		// recargo
		// activo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// idMedioPago
		if (strval($this->idMedioPago->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->idMedioPago->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_medios-pagos`";
		$sWhereWrk = "";
		$this->idMedioPago->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idMedioPago, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idMedioPago->ViewValue = $this->idMedioPago->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idMedioPago->ViewValue = $this->idMedioPago->CurrentValue;
			}
		} else {
			$this->idMedioPago->ViewValue = NULL;
		}
		$this->idMedioPago->ViewCustomAttributes = "";

		// cuotas
		$this->cuotas->ViewValue = $this->cuotas->CurrentValue;
		$this->cuotas->ViewCustomAttributes = "";

		// recargo
		$this->recargo->ViewValue = $this->recargo->CurrentValue;
		$this->recargo->ViewCustomAttributes = "";

		// activo
		if (strval($this->activo->CurrentValue) <> "") {
			$this->activo->ViewValue = $this->activo->OptionCaption($this->activo->CurrentValue);
		} else {
			$this->activo->ViewValue = NULL;
		}
		$this->activo->ViewCustomAttributes = "";

			// idMedioPago
			$this->idMedioPago->LinkCustomAttributes = "";
			$this->idMedioPago->HrefValue = "";
			$this->idMedioPago->TooltipValue = "";

			// cuotas
			$this->cuotas->LinkCustomAttributes = "";
			$this->cuotas->HrefValue = "";
			$this->cuotas->TooltipValue = "";

			// recargo
			$this->recargo->LinkCustomAttributes = "";
			$this->recargo->HrefValue = "";
			$this->recargo->TooltipValue = "";

			// activo
			$this->activo->LinkCustomAttributes = "";
			$this->activo->HrefValue = "";
			$this->activo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idMedioPago
			$this->idMedioPago->EditAttrs["class"] = "form-control";
			$this->idMedioPago->EditCustomAttributes = "";
			if (trim(strval($this->idMedioPago->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->idMedioPago->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_medios-pagos`";
			$sWhereWrk = "";
			$this->idMedioPago->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idMedioPago, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->idMedioPago->EditValue = $arwrk;

			// cuotas
			$this->cuotas->EditAttrs["class"] = "form-control";
			$this->cuotas->EditCustomAttributes = "";
			$this->cuotas->EditValue = ew_HtmlEncode($this->cuotas->CurrentValue);
			$this->cuotas->PlaceHolder = ew_RemoveHtml($this->cuotas->FldCaption());

			// recargo
			$this->recargo->EditAttrs["class"] = "form-control";
			$this->recargo->EditCustomAttributes = "";
			$this->recargo->EditValue = ew_HtmlEncode($this->recargo->CurrentValue);
			$this->recargo->PlaceHolder = ew_RemoveHtml($this->recargo->FldCaption());
			if (strval($this->recargo->EditValue) <> "" && is_numeric($this->recargo->EditValue)) $this->recargo->EditValue = ew_FormatNumber($this->recargo->EditValue, -2, -1, -2, 0);

			// activo
			$this->activo->EditCustomAttributes = "";
			$this->activo->EditValue = $this->activo->Options(FALSE);

			// Add refer script
			// idMedioPago

			$this->idMedioPago->LinkCustomAttributes = "";
			$this->idMedioPago->HrefValue = "";

			// cuotas
			$this->cuotas->LinkCustomAttributes = "";
			$this->cuotas->HrefValue = "";

			// recargo
			$this->recargo->LinkCustomAttributes = "";
			$this->recargo->HrefValue = "";

			// activo
			$this->activo->LinkCustomAttributes = "";
			$this->activo->HrefValue = "";
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
		if (!$this->cuotas->FldIsDetailKey && !is_null($this->cuotas->FormValue) && $this->cuotas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cuotas->FldCaption(), $this->cuotas->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->cuotas->FormValue)) {
			ew_AddMessage($gsFormError, $this->cuotas->FldErrMsg());
		}
		if (!$this->recargo->FldIsDetailKey && !is_null($this->recargo->FormValue) && $this->recargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->recargo->FldCaption(), $this->recargo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->recargo->FormValue)) {
			ew_AddMessage($gsFormError, $this->recargo->FldErrMsg());
		}
		if ($this->activo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->activo->FldCaption(), $this->activo->ReqErrMsg));
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

		// idMedioPago
		$this->idMedioPago->SetDbValueDef($rsnew, $this->idMedioPago->CurrentValue, NULL, FALSE);

		// cuotas
		$this->cuotas->SetDbValueDef($rsnew, $this->cuotas->CurrentValue, NULL, FALSE);

		// recargo
		$this->recargo->SetDbValueDef($rsnew, $this->recargo->CurrentValue, NULL, FALSE);

		// activo
		$this->activo->SetDbValueDef($rsnew, $this->activo->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("trama_cuotas2Drecargoslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_idMedioPago":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_medios-pagos`";
			$sWhereWrk = "";
			$this->idMedioPago->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->idMedioPago, $sWhereWrk); // Call Lookup selecting
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
if (!isset($trama_cuotas2Drecargos_add)) $trama_cuotas2Drecargos_add = new ctrama_cuotas2Drecargos_add();

// Page init
$trama_cuotas2Drecargos_add->Page_Init();

// Page main
$trama_cuotas2Drecargos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_cuotas2Drecargos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftrama_cuotas2Drecargosadd = new ew_Form("ftrama_cuotas2Drecargosadd", "add");

// Validate form
ftrama_cuotas2Drecargosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_cuotas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_cuotas2Drecargos->cuotas->FldCaption(), $trama_cuotas2Drecargos->cuotas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cuotas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_cuotas2Drecargos->cuotas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_recargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_cuotas2Drecargos->recargo->FldCaption(), $trama_cuotas2Drecargos->recargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_recargo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_cuotas2Drecargos->recargo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_cuotas2Drecargos->activo->FldCaption(), $trama_cuotas2Drecargos->activo->ReqErrMsg)) ?>");

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
ftrama_cuotas2Drecargosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_cuotas2Drecargosadd.ValidateRequired = true;
<?php } else { ?>
ftrama_cuotas2Drecargosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_cuotas2Drecargosadd.Lists["x_idMedioPago"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_medios2Dpagos"};
ftrama_cuotas2Drecargosadd.Lists["x_activo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftrama_cuotas2Drecargosadd.Lists["x_activo"].Options = <?php echo json_encode($trama_cuotas2Drecargos->activo->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$trama_cuotas2Drecargos_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $trama_cuotas2Drecargos_add->ShowPageHeader(); ?>
<?php
$trama_cuotas2Drecargos_add->ShowMessage();
?>
<form name="ftrama_cuotas2Drecargosadd" id="ftrama_cuotas2Drecargosadd" class="<?php echo $trama_cuotas2Drecargos_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($trama_cuotas2Drecargos_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $trama_cuotas2Drecargos_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="trama_cuotas2Drecargos">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($trama_cuotas2Drecargos_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($trama_cuotas2Drecargos->idMedioPago->Visible) { // idMedioPago ?>
	<div id="r_idMedioPago" class="form-group">
		<label id="elh_trama_cuotas2Drecargos_idMedioPago" for="x_idMedioPago" class="col-sm-2 control-label ewLabel"><?php echo $trama_cuotas2Drecargos->idMedioPago->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_cuotas2Drecargos->idMedioPago->CellAttributes() ?>>
<span id="el_trama_cuotas2Drecargos_idMedioPago">
<select data-table="trama_cuotas2Drecargos" data-field="x_idMedioPago" data-value-separator="<?php echo $trama_cuotas2Drecargos->idMedioPago->DisplayValueSeparatorAttribute() ?>" id="x_idMedioPago" name="x_idMedioPago"<?php echo $trama_cuotas2Drecargos->idMedioPago->EditAttributes() ?>>
<?php echo $trama_cuotas2Drecargos->idMedioPago->SelectOptionListHtml("x_idMedioPago") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_cuotas2Drecargos->idMedioPago->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_idMedioPago',url:'trama_medios2Dpagosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_idMedioPago"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_cuotas2Drecargos->idMedioPago->FldCaption() ?></span></button>
<input type="hidden" name="s_x_idMedioPago" id="s_x_idMedioPago" value="<?php echo $trama_cuotas2Drecargos->idMedioPago->LookupFilterQuery() ?>">
</span>
<?php echo $trama_cuotas2Drecargos->idMedioPago->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_cuotas2Drecargos->cuotas->Visible) { // cuotas ?>
	<div id="r_cuotas" class="form-group">
		<label id="elh_trama_cuotas2Drecargos_cuotas" for="x_cuotas" class="col-sm-2 control-label ewLabel"><?php echo $trama_cuotas2Drecargos->cuotas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_cuotas2Drecargos->cuotas->CellAttributes() ?>>
<span id="el_trama_cuotas2Drecargos_cuotas">
<input type="text" data-table="trama_cuotas2Drecargos" data-field="x_cuotas" name="x_cuotas" id="x_cuotas" size="30" placeholder="<?php echo ew_HtmlEncode($trama_cuotas2Drecargos->cuotas->getPlaceHolder()) ?>" value="<?php echo $trama_cuotas2Drecargos->cuotas->EditValue ?>"<?php echo $trama_cuotas2Drecargos->cuotas->EditAttributes() ?>>
</span>
<?php echo $trama_cuotas2Drecargos->cuotas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_cuotas2Drecargos->recargo->Visible) { // recargo ?>
	<div id="r_recargo" class="form-group">
		<label id="elh_trama_cuotas2Drecargos_recargo" for="x_recargo" class="col-sm-2 control-label ewLabel"><?php echo $trama_cuotas2Drecargos->recargo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_cuotas2Drecargos->recargo->CellAttributes() ?>>
<span id="el_trama_cuotas2Drecargos_recargo">
<input type="text" data-table="trama_cuotas2Drecargos" data-field="x_recargo" name="x_recargo" id="x_recargo" size="30" placeholder="<?php echo ew_HtmlEncode($trama_cuotas2Drecargos->recargo->getPlaceHolder()) ?>" value="<?php echo $trama_cuotas2Drecargos->recargo->EditValue ?>"<?php echo $trama_cuotas2Drecargos->recargo->EditAttributes() ?>>
</span>
<?php echo $trama_cuotas2Drecargos->recargo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_cuotas2Drecargos->activo->Visible) { // activo ?>
	<div id="r_activo" class="form-group">
		<label id="elh_trama_cuotas2Drecargos_activo" class="col-sm-2 control-label ewLabel"><?php echo $trama_cuotas2Drecargos->activo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_cuotas2Drecargos->activo->CellAttributes() ?>>
<span id="el_trama_cuotas2Drecargos_activo">
<div id="tp_x_activo" class="ewTemplate"><input type="radio" data-table="trama_cuotas2Drecargos" data-field="x_activo" data-value-separator="<?php echo $trama_cuotas2Drecargos->activo->DisplayValueSeparatorAttribute() ?>" name="x_activo" id="x_activo" value="{value}"<?php echo $trama_cuotas2Drecargos->activo->EditAttributes() ?>></div>
<div id="dsl_x_activo" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $trama_cuotas2Drecargos->activo->RadioButtonListHtml(FALSE, "x_activo") ?>
</div></div>
</span>
<?php echo $trama_cuotas2Drecargos->activo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$trama_cuotas2Drecargos_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $trama_cuotas2Drecargos_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftrama_cuotas2Drecargosadd.Init();
</script>
<?php
$trama_cuotas2Drecargos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$trama_cuotas2Drecargos_add->Page_Terminate();
?>
