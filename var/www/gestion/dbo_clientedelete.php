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

$dbo_cliente_delete = NULL; // Initialize page object first

class cdbo_cliente_delete extends cdbo_cliente {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'dbo_cliente';

	// Page object name
	var $PageObjName = 'dbo_cliente_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("dbo_clientelist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
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
			$this->Page_Terminate("dbo_clientelist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in dbo_cliente class, dbo_clienteinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
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
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
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
				$conn->raiseErrorFn = 'ew_ErrorFn';
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
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "dbo_clientelist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($dbo_cliente_delete)) $dbo_cliente_delete = new cdbo_cliente_delete();

// Page init
$dbo_cliente_delete->Page_Init();

// Page main
$dbo_cliente_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_cliente_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var dbo_cliente_delete = new ew_Page("dbo_cliente_delete");
dbo_cliente_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = dbo_cliente_delete.PageID; // For backward compatibility

// Form object
var fdbo_clientedelete = new ew_Form("fdbo_clientedelete");

// Form_CustomValidate event
fdbo_clientedelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_clientedelete.ValidateRequired = true;
<?php } else { ?>
fdbo_clientedelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($dbo_cliente_delete->Recordset = $dbo_cliente_delete->LoadRecordset())
	$dbo_cliente_deleteTotalRecs = $dbo_cliente_delete->Recordset->RecordCount(); // Get record count
if ($dbo_cliente_deleteTotalRecs <= 0) { // No record found, exit
	if ($dbo_cliente_delete->Recordset)
		$dbo_cliente_delete->Recordset->Close();
	$dbo_cliente_delete->Page_Terminate("dbo_clientelist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $dbo_cliente_delete->ShowPageHeader(); ?>
<?php
$dbo_cliente_delete->ShowMessage();
?>
<form name="fdbo_clientedelete" id="fdbo_clientedelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="dbo_cliente">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($dbo_cliente_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_dbo_clientedelete" class="ewTable ewTableSeparate">
<?php echo $dbo_cliente->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
		<td><span id="elh_dbo_cliente_CodigoCli" class="dbo_cliente_CodigoCli"><?php echo $dbo_cliente->CodigoCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<td><span id="elh_dbo_cliente_RazonSocialCli" class="dbo_cliente_RazonSocialCli"><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
		<td><span id="elh_dbo_cliente_CuitCli" class="dbo_cliente_CuitCli"><?php echo $dbo_cliente->CuitCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
		<td><span id="elh_dbo_cliente_IngBrutosCli" class="dbo_cliente_IngBrutosCli"><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
		<td><span id="elh_dbo_cliente_Regis_IvaC" class="dbo_cliente_Regis_IvaC"><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
		<td><span id="elh_dbo_cliente_Regis_ListaPrec" class="dbo_cliente_Regis_ListaPrec"><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
		<td><span id="elh_dbo_cliente_emailCli" class="dbo_cliente_emailCli"><?php echo $dbo_cliente->emailCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
		<td><span id="elh_dbo_cliente_RazonSocialFlete" class="dbo_cliente_RazonSocialFlete"><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
		<td><span id="elh_dbo_cliente_Direccion" class="dbo_cliente_Direccion"><?php echo $dbo_cliente->Direccion->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
		<td><span id="elh_dbo_cliente_BarrioCli" class="dbo_cliente_BarrioCli"><?php echo $dbo_cliente->BarrioCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
		<td><span id="elh_dbo_cliente_LocalidadCli" class="dbo_cliente_LocalidadCli"><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
		<td><span id="elh_dbo_cliente_DescrProvincia" class="dbo_cliente_DescrProvincia"><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
		<td><span id="elh_dbo_cliente_CodigoPostalCli" class="dbo_cliente_CodigoPostalCli"><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
		<td><span id="elh_dbo_cliente_DescrPais" class="dbo_cliente_DescrPais"><?php echo $dbo_cliente->DescrPais->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
		<td><span id="elh_dbo_cliente_Telefono" class="dbo_cliente_Telefono"><?php echo $dbo_cliente->Telefono->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
		<td><span id="elh_dbo_cliente_FaxCli" class="dbo_cliente_FaxCli"><?php echo $dbo_cliente->FaxCli->FldCaption() ?></span></td>
<?php } ?>
<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
		<td><span id="elh_dbo_cliente_PaginaWebCli" class="dbo_cliente_PaginaWebCli"><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$dbo_cliente_delete->RecCnt = 0;
$i = 0;
while (!$dbo_cliente_delete->Recordset->EOF) {
	$dbo_cliente_delete->RecCnt++;
	$dbo_cliente_delete->RowCnt++;

	// Set row properties
	$dbo_cliente->ResetAttrs();
	$dbo_cliente->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$dbo_cliente_delete->LoadRowValues($dbo_cliente_delete->Recordset);

	// Render row
	$dbo_cliente_delete->RenderRow();
?>
	<tr<?php echo $dbo_cliente->RowAttributes() ?>>
<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_CodigoCli" class="control-group dbo_cliente_CodigoCli">
<span<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_RazonSocialCli" class="control-group dbo_cliente_RazonSocialCli">
<span<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_CuitCli" class="control-group dbo_cliente_CuitCli">
<span<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CuitCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_IngBrutosCli" class="control-group dbo_cliente_IngBrutosCli">
<span<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->IngBrutosCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_Regis_IvaC" class="control-group dbo_cliente_Regis_IvaC">
<span<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_IvaC->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_Regis_ListaPrec" class="control-group dbo_cliente_Regis_ListaPrec">
<span<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_ListaPrec->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_emailCli" class="control-group dbo_cliente_emailCli">
<span<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->emailCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_RazonSocialFlete" class="control-group dbo_cliente_RazonSocialFlete">
<span<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialFlete->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_Direccion" class="control-group dbo_cliente_Direccion">
<span<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>>
<?php echo $dbo_cliente->Direccion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_BarrioCli" class="control-group dbo_cliente_BarrioCli">
<span<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->BarrioCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_LocalidadCli" class="control-group dbo_cliente_LocalidadCli">
<span<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->LocalidadCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_DescrProvincia" class="control-group dbo_cliente_DescrProvincia">
<span<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrProvincia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_CodigoPostalCli" class="control-group dbo_cliente_CodigoPostalCli">
<span<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoPostalCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_DescrPais" class="control-group dbo_cliente_DescrPais">
<span<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrPais->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_Telefono" class="control-group dbo_cliente_Telefono">
<span<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>>
<?php echo $dbo_cliente->Telefono->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_FaxCli" class="control-group dbo_cliente_FaxCli">
<span<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->FaxCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_delete->RowCnt ?>_dbo_cliente_PaginaWebCli" class="control-group dbo_cliente_PaginaWebCli">
<span<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->PaginaWebCli->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$dbo_cliente_delete->Recordset->MoveNext();
}
$dbo_cliente_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdbo_clientedelete.Init();
</script>
<?php
$dbo_cliente_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dbo_cliente_delete->Page_Terminate();
?>
