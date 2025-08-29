<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "dbo_clienteinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$dbo_cliente_addopt = NULL; // Initialize page object first

class cdbo_cliente_addopt extends cdbo_cliente {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'dbo_cliente';

	// Page object name
	var $PageObjName = 'dbo_cliente_addopt';

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

		// Table object (dbo_cliente)
		if (!isset($GLOBALS["dbo_cliente"])) {
			$GLOBALS["dbo_cliente"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dbo_cliente"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbo_cliente', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("dbo_clientelist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

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

		// Page Unload event
		$this->Page_Unload();

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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

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
					$row["x_CodigoCli"] = $this->CodigoCli->DbValue;
					$row["x_RazonSocialCli"] = $this->RazonSocialCli->DbValue;
					$row["x_CuitCli"] = $this->CuitCli->DbValue;
					$row["x_IngBrutosCli"] = $this->IngBrutosCli->DbValue;
					$row["x_Regis_IvaC"] = $this->Regis_IvaC->DbValue;
					$row["x_Regis_ListaPrec"] = $this->Regis_ListaPrec->DbValue;
					$row["x_emailCli"] = $this->emailCli->DbValue;
					$row["x_RazonSocialFlete"] = $this->RazonSocialFlete->DbValue;
					$row["x_Direccion"] = $this->Direccion->DbValue;
					$row["x_BarrioCli"] = $this->BarrioCli->DbValue;
					$row["x_LocalidadCli"] = $this->LocalidadCli->DbValue;
					$row["x_DescrProvincia"] = $this->DescrProvincia->DbValue;
					$row["x_CodigoPostalCli"] = $this->CodigoPostalCli->DbValue;
					$row["x_DescrPais"] = $this->DescrPais->DbValue;
					$row["x_Telefono"] = $this->Telefono->DbValue;
					$row["x_FaxCli"] = $this->FaxCli->DbValue;
					$row["x_PaginaWebCli"] = $this->PaginaWebCli->DbValue;
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
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->CodigoCli->CurrentValue = NULL;
		$this->CodigoCli->OldValue = $this->CodigoCli->CurrentValue;
		$this->RazonSocialCli->CurrentValue = NULL;
		$this->RazonSocialCli->OldValue = $this->RazonSocialCli->CurrentValue;
		$this->CuitCli->CurrentValue = NULL;
		$this->CuitCli->OldValue = $this->CuitCli->CurrentValue;
		$this->IngBrutosCli->CurrentValue = NULL;
		$this->IngBrutosCli->OldValue = $this->IngBrutosCli->CurrentValue;
		$this->Regis_IvaC->CurrentValue = NULL;
		$this->Regis_IvaC->OldValue = $this->Regis_IvaC->CurrentValue;
		$this->Regis_ListaPrec->CurrentValue = NULL;
		$this->Regis_ListaPrec->OldValue = $this->Regis_ListaPrec->CurrentValue;
		$this->emailCli->CurrentValue = NULL;
		$this->emailCli->OldValue = $this->emailCli->CurrentValue;
		$this->RazonSocialFlete->CurrentValue = NULL;
		$this->RazonSocialFlete->OldValue = $this->RazonSocialFlete->CurrentValue;
		$this->Direccion->CurrentValue = NULL;
		$this->Direccion->OldValue = $this->Direccion->CurrentValue;
		$this->BarrioCli->CurrentValue = NULL;
		$this->BarrioCli->OldValue = $this->BarrioCli->CurrentValue;
		$this->LocalidadCli->CurrentValue = NULL;
		$this->LocalidadCli->OldValue = $this->LocalidadCli->CurrentValue;
		$this->DescrProvincia->CurrentValue = NULL;
		$this->DescrProvincia->OldValue = $this->DescrProvincia->CurrentValue;
		$this->CodigoPostalCli->CurrentValue = NULL;
		$this->CodigoPostalCli->OldValue = $this->CodigoPostalCli->CurrentValue;
		$this->DescrPais->CurrentValue = NULL;
		$this->DescrPais->OldValue = $this->DescrPais->CurrentValue;
		$this->Telefono->CurrentValue = NULL;
		$this->Telefono->OldValue = $this->Telefono->CurrentValue;
		$this->FaxCli->CurrentValue = NULL;
		$this->FaxCli->OldValue = $this->FaxCli->CurrentValue;
		$this->PaginaWebCli->CurrentValue = NULL;
		$this->PaginaWebCli->OldValue = $this->PaginaWebCli->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->CodigoCli->FldIsDetailKey) {
			$this->CodigoCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_CodigoCli")));
		}
		if (!$this->RazonSocialCli->FldIsDetailKey) {
			$this->RazonSocialCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_RazonSocialCli")));
		}
		if (!$this->CuitCli->FldIsDetailKey) {
			$this->CuitCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_CuitCli")));
		}
		if (!$this->IngBrutosCli->FldIsDetailKey) {
			$this->IngBrutosCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_IngBrutosCli")));
		}
		if (!$this->Regis_IvaC->FldIsDetailKey) {
			$this->Regis_IvaC->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Regis_IvaC")));
		}
		if (!$this->Regis_ListaPrec->FldIsDetailKey) {
			$this->Regis_ListaPrec->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Regis_ListaPrec")));
		}
		if (!$this->emailCli->FldIsDetailKey) {
			$this->emailCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_emailCli")));
		}
		if (!$this->RazonSocialFlete->FldIsDetailKey) {
			$this->RazonSocialFlete->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_RazonSocialFlete")));
		}
		if (!$this->Direccion->FldIsDetailKey) {
			$this->Direccion->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Direccion")));
		}
		if (!$this->BarrioCli->FldIsDetailKey) {
			$this->BarrioCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_BarrioCli")));
		}
		if (!$this->LocalidadCli->FldIsDetailKey) {
			$this->LocalidadCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_LocalidadCli")));
		}
		if (!$this->DescrProvincia->FldIsDetailKey) {
			$this->DescrProvincia->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_DescrProvincia")));
		}
		if (!$this->CodigoPostalCli->FldIsDetailKey) {
			$this->CodigoPostalCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_CodigoPostalCli")));
		}
		if (!$this->DescrPais->FldIsDetailKey) {
			$this->DescrPais->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_DescrPais")));
		}
		if (!$this->Telefono->FldIsDetailKey) {
			$this->Telefono->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Telefono")));
		}
		if (!$this->FaxCli->FldIsDetailKey) {
			$this->FaxCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_FaxCli")));
		}
		if (!$this->PaginaWebCli->FldIsDetailKey) {
			$this->PaginaWebCli->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_PaginaWebCli")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->CodigoCli->CurrentValue = ew_ConvertToUtf8($this->CodigoCli->FormValue);
		$this->RazonSocialCli->CurrentValue = ew_ConvertToUtf8($this->RazonSocialCli->FormValue);
		$this->CuitCli->CurrentValue = ew_ConvertToUtf8($this->CuitCli->FormValue);
		$this->IngBrutosCli->CurrentValue = ew_ConvertToUtf8($this->IngBrutosCli->FormValue);
		$this->Regis_IvaC->CurrentValue = ew_ConvertToUtf8($this->Regis_IvaC->FormValue);
		$this->Regis_ListaPrec->CurrentValue = ew_ConvertToUtf8($this->Regis_ListaPrec->FormValue);
		$this->emailCli->CurrentValue = ew_ConvertToUtf8($this->emailCli->FormValue);
		$this->RazonSocialFlete->CurrentValue = ew_ConvertToUtf8($this->RazonSocialFlete->FormValue);
		$this->Direccion->CurrentValue = ew_ConvertToUtf8($this->Direccion->FormValue);
		$this->BarrioCli->CurrentValue = ew_ConvertToUtf8($this->BarrioCli->FormValue);
		$this->LocalidadCli->CurrentValue = ew_ConvertToUtf8($this->LocalidadCli->FormValue);
		$this->DescrProvincia->CurrentValue = ew_ConvertToUtf8($this->DescrProvincia->FormValue);
		$this->CodigoPostalCli->CurrentValue = ew_ConvertToUtf8($this->CodigoPostalCli->FormValue);
		$this->DescrPais->CurrentValue = ew_ConvertToUtf8($this->DescrPais->FormValue);
		$this->Telefono->CurrentValue = ew_ConvertToUtf8($this->Telefono->FormValue);
		$this->FaxCli->CurrentValue = ew_ConvertToUtf8($this->FaxCli->FormValue);
		$this->PaginaWebCli->CurrentValue = ew_ConvertToUtf8($this->PaginaWebCli->FormValue);
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
		$this->CuitCli->setDbValue($rs->fields('CuitCli'));
		$this->IngBrutosCli->setDbValue($rs->fields('IngBrutosCli'));
		$this->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
		$this->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
		$this->emailCli->setDbValue($rs->fields('emailCli'));
		$this->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
		$this->Direccion->setDbValue($rs->fields('Direccion'));
		$this->BarrioCli->setDbValue($rs->fields('BarrioCli'));
		$this->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
		$this->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
		$this->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
		$this->DescrPais->setDbValue($rs->fields('DescrPais'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->FaxCli->setDbValue($rs->fields('FaxCli'));
		$this->PaginaWebCli->setDbValue($rs->fields('PaginaWebCli'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CodigoCli->DbValue = $row['CodigoCli'];
		$this->RazonSocialCli->DbValue = $row['RazonSocialCli'];
		$this->CuitCli->DbValue = $row['CuitCli'];
		$this->IngBrutosCli->DbValue = $row['IngBrutosCli'];
		$this->Regis_IvaC->DbValue = $row['Regis_IvaC'];
		$this->Regis_ListaPrec->DbValue = $row['Regis_ListaPrec'];
		$this->emailCli->DbValue = $row['emailCli'];
		$this->RazonSocialFlete->DbValue = $row['RazonSocialFlete'];
		$this->Direccion->DbValue = $row['Direccion'];
		$this->BarrioCli->DbValue = $row['BarrioCli'];
		$this->LocalidadCli->DbValue = $row['LocalidadCli'];
		$this->DescrProvincia->DbValue = $row['DescrProvincia'];
		$this->CodigoPostalCli->DbValue = $row['CodigoPostalCli'];
		$this->DescrPais->DbValue = $row['DescrPais'];
		$this->Telefono->DbValue = $row['Telefono'];
		$this->FaxCli->DbValue = $row['FaxCli'];
		$this->PaginaWebCli->DbValue = $row['PaginaWebCli'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// CodigoCli
		// RazonSocialCli
		// CuitCli
		// IngBrutosCli
		// Regis_IvaC
		// Regis_ListaPrec
		// emailCli
		// RazonSocialFlete
		// Direccion
		// BarrioCli
		// LocalidadCli
		// DescrProvincia
		// CodigoPostalCli
		// DescrPais
		// Telefono
		// FaxCli
		// PaginaWebCli

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// CodigoCli
			$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			$this->CodigoCli->ViewCustomAttributes = "";

			// RazonSocialCli
			$this->RazonSocialCli->ViewValue = $this->RazonSocialCli->CurrentValue;
			$this->RazonSocialCli->ViewCustomAttributes = "";

			// CuitCli
			$this->CuitCli->ViewValue = $this->CuitCli->CurrentValue;
			$this->CuitCli->ViewCustomAttributes = "";

			// IngBrutosCli
			$this->IngBrutosCli->ViewValue = $this->IngBrutosCli->CurrentValue;
			$this->IngBrutosCli->ViewCustomAttributes = "";

			// Regis_IvaC
			$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
			$this->Regis_IvaC->ViewCustomAttributes = "";

			// Regis_ListaPrec
			$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
			$this->Regis_ListaPrec->ViewCustomAttributes = "";

			// emailCli
			$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
			$this->emailCli->ViewCustomAttributes = "";

			// RazonSocialFlete
			$this->RazonSocialFlete->ViewValue = $this->RazonSocialFlete->CurrentValue;
			$this->RazonSocialFlete->ViewCustomAttributes = "";

			// Direccion
			$this->Direccion->ViewValue = $this->Direccion->CurrentValue;
			$this->Direccion->ViewCustomAttributes = "";

			// BarrioCli
			$this->BarrioCli->ViewValue = $this->BarrioCli->CurrentValue;
			$this->BarrioCli->ViewCustomAttributes = "";

			// LocalidadCli
			$this->LocalidadCli->ViewValue = $this->LocalidadCli->CurrentValue;
			$this->LocalidadCli->ViewCustomAttributes = "";

			// DescrProvincia
			$this->DescrProvincia->ViewValue = $this->DescrProvincia->CurrentValue;
			$this->DescrProvincia->ViewCustomAttributes = "";

			// CodigoPostalCli
			$this->CodigoPostalCli->ViewValue = $this->CodigoPostalCli->CurrentValue;
			$this->CodigoPostalCli->ViewCustomAttributes = "";

			// DescrPais
			$this->DescrPais->ViewValue = $this->DescrPais->CurrentValue;
			$this->DescrPais->ViewCustomAttributes = "";

			// Telefono
			$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
			$this->Telefono->ViewCustomAttributes = "";

			// FaxCli
			$this->FaxCli->ViewValue = $this->FaxCli->CurrentValue;
			$this->FaxCli->ViewCustomAttributes = "";

			// PaginaWebCli
			$this->PaginaWebCli->ViewValue = $this->PaginaWebCli->CurrentValue;
			$this->PaginaWebCli->ViewCustomAttributes = "";

			// CodigoCli
			$this->CodigoCli->LinkCustomAttributes = "";
			$this->CodigoCli->HrefValue = "";
			$this->CodigoCli->TooltipValue = "";

			// RazonSocialCli
			$this->RazonSocialCli->LinkCustomAttributes = "";
			$this->RazonSocialCli->HrefValue = "";
			$this->RazonSocialCli->TooltipValue = "";

			// CuitCli
			$this->CuitCli->LinkCustomAttributes = "";
			$this->CuitCli->HrefValue = "";
			$this->CuitCli->TooltipValue = "";

			// IngBrutosCli
			$this->IngBrutosCli->LinkCustomAttributes = "";
			$this->IngBrutosCli->HrefValue = "";
			$this->IngBrutosCli->TooltipValue = "";

			// Regis_IvaC
			$this->Regis_IvaC->LinkCustomAttributes = "";
			$this->Regis_IvaC->HrefValue = "";
			$this->Regis_IvaC->TooltipValue = "";

			// Regis_ListaPrec
			$this->Regis_ListaPrec->LinkCustomAttributes = "";
			$this->Regis_ListaPrec->HrefValue = "";
			$this->Regis_ListaPrec->TooltipValue = "";

			// emailCli
			$this->emailCli->LinkCustomAttributes = "";
			$this->emailCli->HrefValue = "";
			$this->emailCli->TooltipValue = "";

			// RazonSocialFlete
			$this->RazonSocialFlete->LinkCustomAttributes = "";
			$this->RazonSocialFlete->HrefValue = "";
			$this->RazonSocialFlete->TooltipValue = "";

			// Direccion
			$this->Direccion->LinkCustomAttributes = "";
			$this->Direccion->HrefValue = "";
			$this->Direccion->TooltipValue = "";

			// BarrioCli
			$this->BarrioCli->LinkCustomAttributes = "";
			$this->BarrioCli->HrefValue = "";
			$this->BarrioCli->TooltipValue = "";

			// LocalidadCli
			$this->LocalidadCli->LinkCustomAttributes = "";
			$this->LocalidadCli->HrefValue = "";
			$this->LocalidadCli->TooltipValue = "";

			// DescrProvincia
			$this->DescrProvincia->LinkCustomAttributes = "";
			$this->DescrProvincia->HrefValue = "";
			$this->DescrProvincia->TooltipValue = "";

			// CodigoPostalCli
			$this->CodigoPostalCli->LinkCustomAttributes = "";
			$this->CodigoPostalCli->HrefValue = "";
			$this->CodigoPostalCli->TooltipValue = "";

			// DescrPais
			$this->DescrPais->LinkCustomAttributes = "";
			$this->DescrPais->HrefValue = "";
			$this->DescrPais->TooltipValue = "";

			// Telefono
			$this->Telefono->LinkCustomAttributes = "";
			$this->Telefono->HrefValue = "";
			$this->Telefono->TooltipValue = "";

			// FaxCli
			$this->FaxCli->LinkCustomAttributes = "";
			$this->FaxCli->HrefValue = "";
			$this->FaxCli->TooltipValue = "";

			// PaginaWebCli
			$this->PaginaWebCli->LinkCustomAttributes = "";
			$this->PaginaWebCli->HrefValue = "";
			$this->PaginaWebCli->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// CodigoCli
			$this->CodigoCli->EditCustomAttributes = "";
			$this->CodigoCli->EditValue = ew_HtmlEncode($this->CodigoCli->CurrentValue);
			$this->CodigoCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->CodigoCli->FldCaption()));

			// RazonSocialCli
			$this->RazonSocialCli->EditCustomAttributes = "";
			$this->RazonSocialCli->EditValue = ew_HtmlEncode($this->RazonSocialCli->CurrentValue);
			$this->RazonSocialCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->RazonSocialCli->FldCaption()));

			// CuitCli
			$this->CuitCli->EditCustomAttributes = "";
			$this->CuitCli->EditValue = ew_HtmlEncode($this->CuitCli->CurrentValue);
			$this->CuitCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->CuitCli->FldCaption()));

			// IngBrutosCli
			$this->IngBrutosCli->EditCustomAttributes = "";
			$this->IngBrutosCli->EditValue = ew_HtmlEncode($this->IngBrutosCli->CurrentValue);
			$this->IngBrutosCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->IngBrutosCli->FldCaption()));

			// Regis_IvaC
			$this->Regis_IvaC->EditCustomAttributes = "";
			$this->Regis_IvaC->EditValue = ew_HtmlEncode($this->Regis_IvaC->CurrentValue);
			$this->Regis_IvaC->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Regis_IvaC->FldCaption()));

			// Regis_ListaPrec
			$this->Regis_ListaPrec->EditCustomAttributes = "";
			$this->Regis_ListaPrec->EditValue = ew_HtmlEncode($this->Regis_ListaPrec->CurrentValue);
			$this->Regis_ListaPrec->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Regis_ListaPrec->FldCaption()));

			// emailCli
			$this->emailCli->EditCustomAttributes = "";
			$this->emailCli->EditValue = ew_HtmlEncode($this->emailCli->CurrentValue);
			$this->emailCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emailCli->FldCaption()));

			// RazonSocialFlete
			$this->RazonSocialFlete->EditCustomAttributes = "";
			$this->RazonSocialFlete->EditValue = ew_HtmlEncode($this->RazonSocialFlete->CurrentValue);
			$this->RazonSocialFlete->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->RazonSocialFlete->FldCaption()));

			// Direccion
			$this->Direccion->EditCustomAttributes = "";
			$this->Direccion->EditValue = ew_HtmlEncode($this->Direccion->CurrentValue);
			$this->Direccion->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Direccion->FldCaption()));

			// BarrioCli
			$this->BarrioCli->EditCustomAttributes = "";
			$this->BarrioCli->EditValue = ew_HtmlEncode($this->BarrioCli->CurrentValue);
			$this->BarrioCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->BarrioCli->FldCaption()));

			// LocalidadCli
			$this->LocalidadCli->EditCustomAttributes = "";
			$this->LocalidadCli->EditValue = ew_HtmlEncode($this->LocalidadCli->CurrentValue);
			$this->LocalidadCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->LocalidadCli->FldCaption()));

			// DescrProvincia
			$this->DescrProvincia->EditCustomAttributes = "";
			$this->DescrProvincia->EditValue = ew_HtmlEncode($this->DescrProvincia->CurrentValue);
			$this->DescrProvincia->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->DescrProvincia->FldCaption()));

			// CodigoPostalCli
			$this->CodigoPostalCli->EditCustomAttributes = "";
			$this->CodigoPostalCli->EditValue = ew_HtmlEncode($this->CodigoPostalCli->CurrentValue);
			$this->CodigoPostalCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->CodigoPostalCli->FldCaption()));

			// DescrPais
			$this->DescrPais->EditCustomAttributes = "";
			$this->DescrPais->EditValue = ew_HtmlEncode($this->DescrPais->CurrentValue);
			$this->DescrPais->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->DescrPais->FldCaption()));

			// Telefono
			$this->Telefono->EditCustomAttributes = "";
			$this->Telefono->EditValue = ew_HtmlEncode($this->Telefono->CurrentValue);
			$this->Telefono->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Telefono->FldCaption()));

			// FaxCli
			$this->FaxCli->EditCustomAttributes = "";
			$this->FaxCli->EditValue = ew_HtmlEncode($this->FaxCli->CurrentValue);
			$this->FaxCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->FaxCli->FldCaption()));

			// PaginaWebCli
			$this->PaginaWebCli->EditCustomAttributes = "";
			$this->PaginaWebCli->EditValue = ew_HtmlEncode($this->PaginaWebCli->CurrentValue);
			$this->PaginaWebCli->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->PaginaWebCli->FldCaption()));

			// Edit refer script
			// CodigoCli

			$this->CodigoCli->HrefValue = "";

			// RazonSocialCli
			$this->RazonSocialCli->HrefValue = "";

			// CuitCli
			$this->CuitCli->HrefValue = "";

			// IngBrutosCli
			$this->IngBrutosCli->HrefValue = "";

			// Regis_IvaC
			$this->Regis_IvaC->HrefValue = "";

			// Regis_ListaPrec
			$this->Regis_ListaPrec->HrefValue = "";

			// emailCli
			$this->emailCli->HrefValue = "";

			// RazonSocialFlete
			$this->RazonSocialFlete->HrefValue = "";

			// Direccion
			$this->Direccion->HrefValue = "";

			// BarrioCli
			$this->BarrioCli->HrefValue = "";

			// LocalidadCli
			$this->LocalidadCli->HrefValue = "";

			// DescrProvincia
			$this->DescrProvincia->HrefValue = "";

			// CodigoPostalCli
			$this->CodigoPostalCli->HrefValue = "";

			// DescrPais
			$this->DescrPais->HrefValue = "";

			// Telefono
			$this->Telefono->HrefValue = "";

			// FaxCli
			$this->FaxCli->HrefValue = "";

			// PaginaWebCli
			$this->PaginaWebCli->HrefValue = "";
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
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->CodigoCli->FldCaption());
		}
		if (!$this->RazonSocialCli->FldIsDetailKey && !is_null($this->RazonSocialCli->FormValue) && $this->RazonSocialCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->RazonSocialCli->FldCaption());
		}
		if (!$this->CuitCli->FldIsDetailKey && !is_null($this->CuitCli->FormValue) && $this->CuitCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->CuitCli->FldCaption());
		}
		if (!$this->IngBrutosCli->FldIsDetailKey && !is_null($this->IngBrutosCli->FormValue) && $this->IngBrutosCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->IngBrutosCli->FldCaption());
		}
		if (!$this->Regis_IvaC->FldIsDetailKey && !is_null($this->Regis_IvaC->FormValue) && $this->Regis_IvaC->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Regis_IvaC->FldCaption());
		}
		if (!ew_CheckInteger($this->Regis_IvaC->FormValue)) {
			ew_AddMessage($gsFormError, $this->Regis_IvaC->FldErrMsg());
		}
		if (!$this->Regis_ListaPrec->FldIsDetailKey && !is_null($this->Regis_ListaPrec->FormValue) && $this->Regis_ListaPrec->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Regis_ListaPrec->FldCaption());
		}
		if (!ew_CheckInteger($this->Regis_ListaPrec->FormValue)) {
			ew_AddMessage($gsFormError, $this->Regis_ListaPrec->FldErrMsg());
		}
		if (!$this->emailCli->FldIsDetailKey && !is_null($this->emailCli->FormValue) && $this->emailCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emailCli->FldCaption());
		}
		if (!$this->RazonSocialFlete->FldIsDetailKey && !is_null($this->RazonSocialFlete->FormValue) && $this->RazonSocialFlete->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->RazonSocialFlete->FldCaption());
		}
		if (!$this->Direccion->FldIsDetailKey && !is_null($this->Direccion->FormValue) && $this->Direccion->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Direccion->FldCaption());
		}
		if (!$this->BarrioCli->FldIsDetailKey && !is_null($this->BarrioCli->FormValue) && $this->BarrioCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->BarrioCli->FldCaption());
		}
		if (!$this->LocalidadCli->FldIsDetailKey && !is_null($this->LocalidadCli->FormValue) && $this->LocalidadCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->LocalidadCli->FldCaption());
		}
		if (!$this->DescrProvincia->FldIsDetailKey && !is_null($this->DescrProvincia->FormValue) && $this->DescrProvincia->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->DescrProvincia->FldCaption());
		}
		if (!$this->CodigoPostalCli->FldIsDetailKey && !is_null($this->CodigoPostalCli->FormValue) && $this->CodigoPostalCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->CodigoPostalCli->FldCaption());
		}
		if (!$this->DescrPais->FldIsDetailKey && !is_null($this->DescrPais->FormValue) && $this->DescrPais->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->DescrPais->FldCaption());
		}
		if (!$this->Telefono->FldIsDetailKey && !is_null($this->Telefono->FormValue) && $this->Telefono->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Telefono->FldCaption());
		}
		if (!$this->FaxCli->FldIsDetailKey && !is_null($this->FaxCli->FormValue) && $this->FaxCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->FaxCli->FldCaption());
		}
		if (!$this->PaginaWebCli->FldIsDetailKey && !is_null($this->PaginaWebCli->FormValue) && $this->PaginaWebCli->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->PaginaWebCli->FldCaption());
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
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// CodigoCli
		$this->CodigoCli->SetDbValueDef($rsnew, $this->CodigoCli->CurrentValue, "", FALSE);

		// RazonSocialCli
		$this->RazonSocialCli->SetDbValueDef($rsnew, $this->RazonSocialCli->CurrentValue, "", FALSE);

		// CuitCli
		$this->CuitCli->SetDbValueDef($rsnew, $this->CuitCli->CurrentValue, "", FALSE);

		// IngBrutosCli
		$this->IngBrutosCli->SetDbValueDef($rsnew, $this->IngBrutosCli->CurrentValue, "", FALSE);

		// Regis_IvaC
		$this->Regis_IvaC->SetDbValueDef($rsnew, $this->Regis_IvaC->CurrentValue, 0, FALSE);

		// Regis_ListaPrec
		$this->Regis_ListaPrec->SetDbValueDef($rsnew, $this->Regis_ListaPrec->CurrentValue, 0, FALSE);

		// emailCli
		$this->emailCli->SetDbValueDef($rsnew, $this->emailCli->CurrentValue, "", FALSE);

		// RazonSocialFlete
		$this->RazonSocialFlete->SetDbValueDef($rsnew, $this->RazonSocialFlete->CurrentValue, "", FALSE);

		// Direccion
		$this->Direccion->SetDbValueDef($rsnew, $this->Direccion->CurrentValue, "", FALSE);

		// BarrioCli
		$this->BarrioCli->SetDbValueDef($rsnew, $this->BarrioCli->CurrentValue, "", FALSE);

		// LocalidadCli
		$this->LocalidadCli->SetDbValueDef($rsnew, $this->LocalidadCli->CurrentValue, "", FALSE);

		// DescrProvincia
		$this->DescrProvincia->SetDbValueDef($rsnew, $this->DescrProvincia->CurrentValue, "", FALSE);

		// CodigoPostalCli
		$this->CodigoPostalCli->SetDbValueDef($rsnew, $this->CodigoPostalCli->CurrentValue, "", FALSE);

		// DescrPais
		$this->DescrPais->SetDbValueDef($rsnew, $this->DescrPais->CurrentValue, "", FALSE);

		// Telefono
		$this->Telefono->SetDbValueDef($rsnew, $this->Telefono->CurrentValue, "", FALSE);

		// FaxCli
		$this->FaxCli->SetDbValueDef($rsnew, $this->FaxCli->CurrentValue, "", FALSE);

		// PaginaWebCli
		$this->PaginaWebCli->SetDbValueDef($rsnew, $this->PaginaWebCli->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->CodigoCli->CurrentValue == "" && $this->CodigoCli->getSessionValue() == "") {
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
			$conn->raiseErrorFn = 'ew_ErrorFn';
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

		// Get insert id if necessary
		if ($AddRow) {
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
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "dbo_clientelist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("addopt");
		$Breadcrumb->Add("addopt", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($dbo_cliente_addopt)) $dbo_cliente_addopt = new cdbo_cliente_addopt();

// Page init
$dbo_cliente_addopt->Page_Init();

// Page main
$dbo_cliente_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_cliente_addopt->Page_Render();
?>
<script type="text/javascript">

// Page object
var dbo_cliente_addopt = new ew_Page("dbo_cliente_addopt");
dbo_cliente_addopt.PageID = "addopt"; // Page ID
var EW_PAGE_ID = dbo_cliente_addopt.PageID; // For backward compatibility

// Form object
var fdbo_clienteaddopt = new ew_Form("fdbo_clienteaddopt");

// Validate form
fdbo_clienteaddopt.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
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
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->CodigoCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_RazonSocialCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->RazonSocialCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_CuitCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->CuitCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_IngBrutosCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->IngBrutosCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Regis_IvaC");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->Regis_IvaC->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Regis_IvaC");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dbo_cliente->Regis_IvaC->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Regis_ListaPrec");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->Regis_ListaPrec->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Regis_ListaPrec");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dbo_cliente->Regis_ListaPrec->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emailCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->emailCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_RazonSocialFlete");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->RazonSocialFlete->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Direccion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->Direccion->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_BarrioCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->BarrioCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_LocalidadCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->LocalidadCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_DescrProvincia");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->DescrProvincia->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_CodigoPostalCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->CodigoPostalCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_DescrPais");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->DescrPais->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Telefono");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->Telefono->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_FaxCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->FaxCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_PaginaWebCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($dbo_cliente->PaginaWebCli->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdbo_clienteaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_clienteaddopt.ValidateRequired = true;
<?php } else { ?>
fdbo_clienteaddopt.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$dbo_cliente_addopt->ShowMessage();
?>
<form name="fdbo_clienteaddopt" id="fdbo_clienteaddopt" class="ewForm form-horizontal" action="dbo_clienteaddopt.php" method="post">
<input type="hidden" name="t" value="dbo_cliente">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<div id="tbl_dbo_clienteaddopt">
	<div class="control-group">
		<label class="control-label" for="x_CodigoCli"><?php echo $dbo_cliente->CodigoCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_CodigoCli" name="x_CodigoCli" id="x_CodigoCli" size="30" maxlength="10" placeholder="<?php echo $dbo_cliente->CodigoCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->CodigoCli->EditValue ?>"<?php echo $dbo_cliente->CodigoCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_RazonSocialCli"><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_RazonSocialCli" name="x_RazonSocialCli" id="x_RazonSocialCli" size="30" maxlength="60" placeholder="<?php echo $dbo_cliente->RazonSocialCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->RazonSocialCli->EditValue ?>"<?php echo $dbo_cliente->RazonSocialCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_CuitCli"><?php echo $dbo_cliente->CuitCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_CuitCli" name="x_CuitCli" id="x_CuitCli" size="30" maxlength="13" placeholder="<?php echo $dbo_cliente->CuitCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->CuitCli->EditValue ?>"<?php echo $dbo_cliente->CuitCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_IngBrutosCli"><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_IngBrutosCli" name="x_IngBrutosCli" id="x_IngBrutosCli" size="30" maxlength="18" placeholder="<?php echo $dbo_cliente->IngBrutosCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->IngBrutosCli->EditValue ?>"<?php echo $dbo_cliente->IngBrutosCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_Regis_IvaC"><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_Regis_IvaC" name="x_Regis_IvaC" id="x_Regis_IvaC" size="30" placeholder="<?php echo $dbo_cliente->Regis_IvaC->PlaceHolder ?>" value="<?php echo $dbo_cliente->Regis_IvaC->EditValue ?>"<?php echo $dbo_cliente->Regis_IvaC->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_Regis_ListaPrec"><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_Regis_ListaPrec" name="x_Regis_ListaPrec" id="x_Regis_ListaPrec" size="30" placeholder="<?php echo $dbo_cliente->Regis_ListaPrec->PlaceHolder ?>" value="<?php echo $dbo_cliente->Regis_ListaPrec->EditValue ?>"<?php echo $dbo_cliente->Regis_ListaPrec->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_emailCli"><?php echo $dbo_cliente->emailCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_emailCli" name="x_emailCli" id="x_emailCli" size="30" maxlength="50" placeholder="<?php echo $dbo_cliente->emailCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->emailCli->EditValue ?>"<?php echo $dbo_cliente->emailCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_RazonSocialFlete"><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_RazonSocialFlete" name="x_RazonSocialFlete" id="x_RazonSocialFlete" size="30" maxlength="50" placeholder="<?php echo $dbo_cliente->RazonSocialFlete->PlaceHolder ?>" value="<?php echo $dbo_cliente->RazonSocialFlete->EditValue ?>"<?php echo $dbo_cliente->RazonSocialFlete->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_Direccion"><?php echo $dbo_cliente->Direccion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_Direccion" name="x_Direccion" id="x_Direccion" size="30" maxlength="90" placeholder="<?php echo $dbo_cliente->Direccion->PlaceHolder ?>" value="<?php echo $dbo_cliente->Direccion->EditValue ?>"<?php echo $dbo_cliente->Direccion->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_BarrioCli"><?php echo $dbo_cliente->BarrioCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_BarrioCli" name="x_BarrioCli" id="x_BarrioCli" size="30" maxlength="30" placeholder="<?php echo $dbo_cliente->BarrioCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->BarrioCli->EditValue ?>"<?php echo $dbo_cliente->BarrioCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_LocalidadCli"><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_LocalidadCli" name="x_LocalidadCli" id="x_LocalidadCli" size="30" maxlength="40" placeholder="<?php echo $dbo_cliente->LocalidadCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->LocalidadCli->EditValue ?>"<?php echo $dbo_cliente->LocalidadCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_DescrProvincia"><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_DescrProvincia" name="x_DescrProvincia" id="x_DescrProvincia" size="30" maxlength="40" placeholder="<?php echo $dbo_cliente->DescrProvincia->PlaceHolder ?>" value="<?php echo $dbo_cliente->DescrProvincia->EditValue ?>"<?php echo $dbo_cliente->DescrProvincia->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_CodigoPostalCli"><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_CodigoPostalCli" name="x_CodigoPostalCli" id="x_CodigoPostalCli" size="30" maxlength="10" placeholder="<?php echo $dbo_cliente->CodigoPostalCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->CodigoPostalCli->EditValue ?>"<?php echo $dbo_cliente->CodigoPostalCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_DescrPais"><?php echo $dbo_cliente->DescrPais->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_DescrPais" name="x_DescrPais" id="x_DescrPais" size="30" maxlength="40" placeholder="<?php echo $dbo_cliente->DescrPais->PlaceHolder ?>" value="<?php echo $dbo_cliente->DescrPais->EditValue ?>"<?php echo $dbo_cliente->DescrPais->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_Telefono"><?php echo $dbo_cliente->Telefono->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_Telefono" name="x_Telefono" id="x_Telefono" size="30" maxlength="90" placeholder="<?php echo $dbo_cliente->Telefono->PlaceHolder ?>" value="<?php echo $dbo_cliente->Telefono->EditValue ?>"<?php echo $dbo_cliente->Telefono->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_FaxCli"><?php echo $dbo_cliente->FaxCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_FaxCli" name="x_FaxCli" id="x_FaxCli" size="30" maxlength="30" placeholder="<?php echo $dbo_cliente->FaxCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->FaxCli->EditValue ?>"<?php echo $dbo_cliente->FaxCli->EditAttributes() ?>>
</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="x_PaginaWebCli"><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="controls">
<input type="text" data-field="x_PaginaWebCli" name="x_PaginaWebCli" id="x_PaginaWebCli" size="30" maxlength="40" placeholder="<?php echo $dbo_cliente->PaginaWebCli->PlaceHolder ?>" value="<?php echo $dbo_cliente->PaginaWebCli->EditValue ?>"<?php echo $dbo_cliente->PaginaWebCli->EditAttributes() ?>>
</div>
	</div>
</div>
</form>
<script type="text/javascript">
fdbo_clienteaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$dbo_cliente_addopt->Page_Terminate();
?>
