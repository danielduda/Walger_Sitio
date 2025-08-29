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

$dbo_cliente_view = NULL; // Initialize page object first

class cdbo_cliente_view extends cdbo_cliente {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'dbo_cliente';

	// Page object name
	var $PageObjName = 'dbo_cliente_view';

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
		$KeyUrl = "";
		if (@$_GET["CodigoCli"] <> "") {
			$this->RecKey["CodigoCli"] = $_GET["CodigoCli"];
			$KeyUrl .= "&CodigoCli=" . urlencode($this->RecKey["CodigoCli"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbo_cliente', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("dbo_clientelist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["CodigoCli"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["CodigoCli"]);
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Update url if printer friendly for Pdf
		if ($this->PrinterFriendlyForPdf)
			$this->ExportOptions->Items["pdf"]->Body = str_replace($this->ExportPdfUrl, $this->ExportPrintUrl . "&pdf=1", $this->ExportOptions->Items["pdf"]->Body);
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();
		if ($this->Export == "print" && @$_GET["pdf"] == "1") { // Printer friendly version and with pdf=1 in URL parameters
			$pdf = new cExportPdf($GLOBALS["Table"]);
			$pdf->Text = ob_get_contents(); // Set the content as the HTML of current page (printer friendly version)
			ob_end_clean();
			$pdf->Export();
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
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["CodigoCli"] <> "") {
				$this->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
				$this->RecKey["CodigoCli"] = $this->CodigoCli->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("dbo_clientelist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->CodigoCli->CurrentValue) == strval($this->Recordset->fields('CodigoCli'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "dbo_clientelist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "dbo_clientelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));\" class=\"ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_dbo_cliente\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dbo_cliente',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fdbo_clienteview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "v");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($ExportDoc->Text);
		} else {
			$ExportDoc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_GET["sender"];
		$sRecipient = @$_GET["recipient"];
		$sCc = @$_GET["cc"];
		$sBcc = @$_GET["bcc"];
		$sContentType = @$_GET["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_GET["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_GET["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-error\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-error\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EW_EMAIL_CHARSET;
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= $EmailContent; // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-error\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "dbo_clientelist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("view");
		$Breadcrumb->Add("view", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($dbo_cliente_view)) $dbo_cliente_view = new cdbo_cliente_view();

// Page init
$dbo_cliente_view->Page_Init();

// Page main
$dbo_cliente_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_cliente_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($dbo_cliente->Export == "") { ?>
<script type="text/javascript">

// Page object
var dbo_cliente_view = new ew_Page("dbo_cliente_view");
dbo_cliente_view.PageID = "view"; // Page ID
var EW_PAGE_ID = dbo_cliente_view.PageID; // For backward compatibility

// Form object
var fdbo_clienteview = new ew_Form("fdbo_clienteview");

// Form_CustomValidate event
fdbo_clienteview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_clienteview.ValidateRequired = true;
<?php } else { ?>
fdbo_clienteview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $dbo_cliente_view->ExportOptions->Render("body") ?>
<?php if (!$dbo_cliente_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($dbo_cliente_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $dbo_cliente_view->ShowPageHeader(); ?>
<?php
$dbo_cliente_view->ShowMessage();
?>
<?php if ($dbo_cliente->Export == "") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($dbo_cliente_view->Pager)) $dbo_cliente_view->Pager = new cPrevNextPager($dbo_cliente_view->StartRec, $dbo_cliente_view->DisplayRecs, $dbo_cliente_view->TotalRecs) ?>
<?php if ($dbo_cliente_view->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($dbo_cliente_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $dbo_cliente_view->PageUrl() ?>start=<?php echo $dbo_cliente_view->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($dbo_cliente_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $dbo_cliente_view->PageUrl() ?>start=<?php echo $dbo_cliente_view->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dbo_cliente_view->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($dbo_cliente_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $dbo_cliente_view->PageUrl() ?>start=<?php echo $dbo_cliente_view->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($dbo_cliente_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $dbo_cliente_view->PageUrl() ?>start=<?php echo $dbo_cliente_view->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $dbo_cliente_view->Pager->PageCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
</form>
<?php } ?>
<form name="fdbo_clienteview" id="fdbo_clienteview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="dbo_cliente">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_dbo_clienteview" class="table table-bordered table-striped">
<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
	<tr id="r_CodigoCli">
		<td><span id="elh_dbo_cliente_CodigoCli"><?php echo $dbo_cliente->CodigoCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CodigoCli" class="control-group">
<span<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
	<tr id="r_RazonSocialCli">
		<td><span id="elh_dbo_cliente_RazonSocialCli"><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<span id="el_dbo_cliente_RazonSocialCli" class="control-group">
<span<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
	<tr id="r_CuitCli">
		<td><span id="elh_dbo_cliente_CuitCli"><?php echo $dbo_cliente->CuitCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CuitCli" class="control-group">
<span<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CuitCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
	<tr id="r_IngBrutosCli">
		<td><span id="elh_dbo_cliente_IngBrutosCli"><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<span id="el_dbo_cliente_IngBrutosCli" class="control-group">
<span<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->IngBrutosCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
	<tr id="r_Regis_IvaC">
		<td><span id="elh_dbo_cliente_Regis_IvaC"><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<span id="el_dbo_cliente_Regis_IvaC" class="control-group">
<span<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_IvaC->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
	<tr id="r_Regis_ListaPrec">
		<td><span id="elh_dbo_cliente_Regis_ListaPrec"><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<span id="el_dbo_cliente_Regis_ListaPrec" class="control-group">
<span<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_ListaPrec->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
	<tr id="r_emailCli">
		<td><span id="elh_dbo_cliente_emailCli"><?php echo $dbo_cliente->emailCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<span id="el_dbo_cliente_emailCli" class="control-group">
<span<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->emailCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
	<tr id="r_RazonSocialFlete">
		<td><span id="elh_dbo_cliente_RazonSocialFlete"><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<span id="el_dbo_cliente_RazonSocialFlete" class="control-group">
<span<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialFlete->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
	<tr id="r_Direccion">
		<td><span id="elh_dbo_cliente_Direccion"><?php echo $dbo_cliente->Direccion->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<span id="el_dbo_cliente_Direccion" class="control-group">
<span<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>>
<?php echo $dbo_cliente->Direccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
	<tr id="r_BarrioCli">
		<td><span id="elh_dbo_cliente_BarrioCli"><?php echo $dbo_cliente->BarrioCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<span id="el_dbo_cliente_BarrioCli" class="control-group">
<span<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->BarrioCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
	<tr id="r_LocalidadCli">
		<td><span id="elh_dbo_cliente_LocalidadCli"><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<span id="el_dbo_cliente_LocalidadCli" class="control-group">
<span<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->LocalidadCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
	<tr id="r_DescrProvincia">
		<td><span id="elh_dbo_cliente_DescrProvincia"><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<span id="el_dbo_cliente_DescrProvincia" class="control-group">
<span<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrProvincia->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
	<tr id="r_CodigoPostalCli">
		<td><span id="elh_dbo_cliente_CodigoPostalCli"><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CodigoPostalCli" class="control-group">
<span<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoPostalCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
	<tr id="r_DescrPais">
		<td><span id="elh_dbo_cliente_DescrPais"><?php echo $dbo_cliente->DescrPais->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<span id="el_dbo_cliente_DescrPais" class="control-group">
<span<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrPais->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
	<tr id="r_Telefono">
		<td><span id="elh_dbo_cliente_Telefono"><?php echo $dbo_cliente->Telefono->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<span id="el_dbo_cliente_Telefono" class="control-group">
<span<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>>
<?php echo $dbo_cliente->Telefono->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
	<tr id="r_FaxCli">
		<td><span id="elh_dbo_cliente_FaxCli"><?php echo $dbo_cliente->FaxCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<span id="el_dbo_cliente_FaxCli" class="control-group">
<span<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->FaxCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
	<tr id="r_PaginaWebCli">
		<td><span id="elh_dbo_cliente_PaginaWebCli"><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?></span></td>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<span id="el_dbo_cliente_PaginaWebCli" class="control-group">
<span<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->PaginaWebCli->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
fdbo_clienteview.Init();
</script>
<?php
$dbo_cliente_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($dbo_cliente->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$dbo_cliente_view->Page_Terminate();
?>
