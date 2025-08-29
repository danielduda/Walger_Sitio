<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "trama_medios2Dentregainfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$trama_medios2Dentrega_addopt = NULL; // Initialize page object first

class ctrama_medios2Dentrega_addopt extends ctrama_medios2Dentrega {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'trama_medios-entrega';

	// Page object name
	var $PageObjName = 'trama_medios2Dentrega_addopt';

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

		// Table object (trama_medios2Dentrega)
		if (!isset($GLOBALS["trama_medios2Dentrega"]) || get_class($GLOBALS["trama_medios2Dentrega"]) == "ctrama_medios2Dentrega") {
			$GLOBALS["trama_medios2Dentrega"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trama_medios2Dentrega"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trama_medios-entrega', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("trama_medios2Dentregalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->denominacion->SetVisibility();
		$this->importe->SetVisibility();
		$this->iva->SetVisibility();
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
		global $EW_EXPORT, $trama_medios2Dentrega;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($trama_medios2Dentrega);
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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Set up Breadcrumb
		//$this->SetupBreadcrumb(); // Not used
		// Process form if post back

		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_id"] = $this->id->DbValue;
					$row["x_denominacion"] = $this->denominacion->DbValue;
					$row["x_importe"] = $this->importe->DbValue;
					$row["x_iva"] = $this->iva->DbValue;
					$row["x_activo"] = $this->activo->DbValue;
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
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
		$this->importe->CurrentValue = NULL;
		$this->importe->OldValue = $this->importe->CurrentValue;
		$this->iva->CurrentValue = NULL;
		$this->iva->OldValue = $this->iva->CurrentValue;
		$this->activo->CurrentValue = NULL;
		$this->activo->OldValue = $this->activo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->denominacion->FldIsDetailKey) {
			$this->denominacion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_denominacion")));
		}
		if (!$this->importe->FldIsDetailKey) {
			$this->importe->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_importe")));
		}
		if (!$this->iva->FldIsDetailKey) {
			$this->iva->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_iva")));
		}
		if (!$this->activo->FldIsDetailKey) {
			$this->activo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_activo")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->denominacion->CurrentValue = ew_ConvertToUtf8($this->denominacion->FormValue);
		$this->importe->CurrentValue = ew_ConvertToUtf8($this->importe->FormValue);
		$this->iva->CurrentValue = ew_ConvertToUtf8($this->iva->FormValue);
		$this->activo->CurrentValue = ew_ConvertToUtf8($this->activo->FormValue);
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
		$this->importe->setDbValue($rs->fields('importe'));
		$this->iva->setDbValue($rs->fields('iva'));
		$this->activo->setDbValue($rs->fields('activo'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->denominacion->DbValue = $row['denominacion'];
		$this->importe->DbValue = $row['importe'];
		$this->iva->DbValue = $row['iva'];
		$this->activo->DbValue = $row['activo'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->importe->FormValue == $this->importe->CurrentValue && is_numeric(ew_StrToFloat($this->importe->CurrentValue)))
			$this->importe->CurrentValue = ew_StrToFloat($this->importe->CurrentValue);

		// Convert decimal values if posted back
		if ($this->iva->FormValue == $this->iva->CurrentValue && is_numeric(ew_StrToFloat($this->iva->CurrentValue)))
			$this->iva->CurrentValue = ew_StrToFloat($this->iva->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// denominacion
		// importe
		// iva
		// activo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// denominacion
		$this->denominacion->ViewValue = $this->denominacion->CurrentValue;
		$this->denominacion->ViewCustomAttributes = "";

		// importe
		$this->importe->ViewValue = $this->importe->CurrentValue;
		$this->importe->ViewCustomAttributes = "";

		// iva
		$this->iva->ViewValue = $this->iva->CurrentValue;
		$this->iva->ViewCustomAttributes = "";

		// activo
		if (strval($this->activo->CurrentValue) <> "") {
			$this->activo->ViewValue = $this->activo->OptionCaption($this->activo->CurrentValue);
		} else {
			$this->activo->ViewValue = NULL;
		}
		$this->activo->ViewCustomAttributes = "";

			// denominacion
			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";
			$this->denominacion->TooltipValue = "";

			// importe
			$this->importe->LinkCustomAttributes = "";
			$this->importe->HrefValue = "";
			$this->importe->TooltipValue = "";

			// iva
			$this->iva->LinkCustomAttributes = "";
			$this->iva->HrefValue = "";
			$this->iva->TooltipValue = "";

			// activo
			$this->activo->LinkCustomAttributes = "";
			$this->activo->HrefValue = "";
			$this->activo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// denominacion
			$this->denominacion->EditAttrs["class"] = "form-control";
			$this->denominacion->EditCustomAttributes = "";
			$this->denominacion->EditValue = ew_HtmlEncode($this->denominacion->CurrentValue);
			$this->denominacion->PlaceHolder = ew_RemoveHtml($this->denominacion->FldCaption());

			// importe
			$this->importe->EditAttrs["class"] = "form-control";
			$this->importe->EditCustomAttributes = "";
			$this->importe->EditValue = ew_HtmlEncode($this->importe->CurrentValue);
			$this->importe->PlaceHolder = ew_RemoveHtml($this->importe->FldCaption());
			if (strval($this->importe->EditValue) <> "" && is_numeric($this->importe->EditValue)) $this->importe->EditValue = ew_FormatNumber($this->importe->EditValue, -2, -1, -2, 0);

			// iva
			$this->iva->EditAttrs["class"] = "form-control";
			$this->iva->EditCustomAttributes = "";
			$this->iva->EditValue = ew_HtmlEncode($this->iva->CurrentValue);
			$this->iva->PlaceHolder = ew_RemoveHtml($this->iva->FldCaption());
			if (strval($this->iva->EditValue) <> "" && is_numeric($this->iva->EditValue)) $this->iva->EditValue = ew_FormatNumber($this->iva->EditValue, -2, -1, -2, 0);

			// activo
			$this->activo->EditCustomAttributes = "";
			$this->activo->EditValue = $this->activo->Options(FALSE);

			// Add refer script
			// denominacion

			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";

			// importe
			$this->importe->LinkCustomAttributes = "";
			$this->importe->HrefValue = "";

			// iva
			$this->iva->LinkCustomAttributes = "";
			$this->iva->HrefValue = "";

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
		if (!$this->denominacion->FldIsDetailKey && !is_null($this->denominacion->FormValue) && $this->denominacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->denominacion->FldCaption(), $this->denominacion->ReqErrMsg));
		}
		if (!$this->importe->FldIsDetailKey && !is_null($this->importe->FormValue) && $this->importe->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->importe->FldCaption(), $this->importe->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->importe->FormValue)) {
			ew_AddMessage($gsFormError, $this->importe->FldErrMsg());
		}
		if (!$this->iva->FldIsDetailKey && !is_null($this->iva->FormValue) && $this->iva->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->iva->FldCaption(), $this->iva->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->iva->FormValue)) {
			ew_AddMessage($gsFormError, $this->iva->FldErrMsg());
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

		// denominacion
		$this->denominacion->SetDbValueDef($rsnew, $this->denominacion->CurrentValue, NULL, FALSE);

		// importe
		$this->importe->SetDbValueDef($rsnew, $this->importe->CurrentValue, NULL, FALSE);

		// iva
		$this->iva->SetDbValueDef($rsnew, $this->iva->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("trama_medios2Dentregalist.php"), "", $this->TableVar, TRUE);
		$PageId = "addopt";
		$Breadcrumb->Add("addopt", $PageId, $url);
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

	// Custom validate event
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
if (!isset($trama_medios2Dentrega_addopt)) $trama_medios2Dentrega_addopt = new ctrama_medios2Dentrega_addopt();

// Page init
$trama_medios2Dentrega_addopt->Page_Init();

// Page main
$trama_medios2Dentrega_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_medios2Dentrega_addopt->Page_Render();
?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "addopt";
var CurrentForm = ftrama_medios2Dentregaaddopt = new ew_Form("ftrama_medios2Dentregaaddopt", "addopt");

// Validate form
ftrama_medios2Dentregaaddopt.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_medios2Dentrega->denominacion->FldCaption(), $trama_medios2Dentrega->denominacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_importe");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_medios2Dentrega->importe->FldCaption(), $trama_medios2Dentrega->importe->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_importe");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_medios2Dentrega->importe->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_iva");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_medios2Dentrega->iva->FldCaption(), $trama_medios2Dentrega->iva->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_iva");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_medios2Dentrega->iva->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_medios2Dentrega->activo->FldCaption(), $trama_medios2Dentrega->activo->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftrama_medios2Dentregaaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_medios2Dentregaaddopt.ValidateRequired = true;
<?php } else { ?>
ftrama_medios2Dentregaaddopt.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_medios2Dentregaaddopt.Lists["x_activo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftrama_medios2Dentregaaddopt.Lists["x_activo"].Options = <?php echo json_encode($trama_medios2Dentrega->activo->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$trama_medios2Dentrega_addopt->ShowMessage();
?>
<form name="ftrama_medios2Dentregaaddopt" id="ftrama_medios2Dentregaaddopt" class="ewForm form-horizontal" action="trama_medios2Dentregaaddopt.php" method="post">
<?php if ($trama_medios2Dentrega_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $trama_medios2Dentrega_addopt->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="trama_medios2Dentrega">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<?php if ($trama_medios2Dentrega->denominacion->Visible) { // denominacion ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_denominacion"><?php echo $trama_medios2Dentrega->denominacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-9">
<input type="text" data-table="trama_medios2Dentrega" data-field="x_denominacion" name="x_denominacion" id="x_denominacion" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_medios2Dentrega->denominacion->getPlaceHolder()) ?>" value="<?php echo $trama_medios2Dentrega->denominacion->EditValue ?>"<?php echo $trama_medios2Dentrega->denominacion->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($trama_medios2Dentrega->importe->Visible) { // importe ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_importe"><?php echo $trama_medios2Dentrega->importe->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-9">
<input type="text" data-table="trama_medios2Dentrega" data-field="x_importe" name="x_importe" id="x_importe" size="30" placeholder="<?php echo ew_HtmlEncode($trama_medios2Dentrega->importe->getPlaceHolder()) ?>" value="<?php echo $trama_medios2Dentrega->importe->EditValue ?>"<?php echo $trama_medios2Dentrega->importe->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($trama_medios2Dentrega->iva->Visible) { // iva ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_iva"><?php echo $trama_medios2Dentrega->iva->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-9">
<input type="text" data-table="trama_medios2Dentrega" data-field="x_iva" name="x_iva" id="x_iva" size="30" placeholder="<?php echo ew_HtmlEncode($trama_medios2Dentrega->iva->getPlaceHolder()) ?>" value="<?php echo $trama_medios2Dentrega->iva->EditValue ?>"<?php echo $trama_medios2Dentrega->iva->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($trama_medios2Dentrega->activo->Visible) { // activo ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel"><?php echo $trama_medios2Dentrega->activo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-9">
<div id="tp_x_activo" class="ewTemplate"><input type="radio" data-table="trama_medios2Dentrega" data-field="x_activo" data-value-separator="<?php echo $trama_medios2Dentrega->activo->DisplayValueSeparatorAttribute() ?>" name="x_activo" id="x_activo" value="{value}"<?php echo $trama_medios2Dentrega->activo->EditAttributes() ?>></div>
<div id="dsl_x_activo" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $trama_medios2Dentrega->activo->RadioButtonListHtml(FALSE, "x_activo") ?>
</div></div>
</div>
	</div>
<?php } ?>	
</form>
<script type="text/javascript">
ftrama_medios2Dentregaaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$trama_medios2Dentrega_addopt->Page_Terminate();
?>
