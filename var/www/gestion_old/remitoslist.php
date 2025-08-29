<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "remitosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$remitos_list = NULL; // Initialize page object first

class cremitos_list extends cremitos {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'remitos';

	// Page object name
	var $PageObjName = 'remitos_list';

	// Grid form hidden field names
	var $FormName = 'fremitoslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (remitos)
		if (!isset($GLOBALS["remitos"])) {
			$GLOBALS["remitos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["remitos"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "remitosadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "remitosdelete.php";
		$this->MultiUpdateUrl = "remitosupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'remitos', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "span";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("Id_Remito", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["Id_Remito"] <> "") {
			$this->Id_Remito->setQueryStringValue($_GET["Id_Remito"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Remito", $this->Id_Remito->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue("k_key"));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("Id_Remito")) <> strval($this->Id_Remito->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->Id_Remito->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Remito->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Remito, FALSE); // Id_Remito
		$this->BuildSearchSql($sWhere, $this->numeroRemito, FALSE); // numeroRemito
		$this->BuildSearchSql($sWhere, $this->Fecha, FALSE); // Fecha
		$this->BuildSearchSql($sWhere, $this->tipoDestinatario, FALSE); // tipoDestinatario
		$this->BuildSearchSql($sWhere, $this->Cliente, FALSE); // Cliente
		$this->BuildSearchSql($sWhere, $this->Proveedor, FALSE); // Proveedor
		$this->BuildSearchSql($sWhere, $this->Transporte, FALSE); // Transporte
		$this->BuildSearchSql($sWhere, $this->NumeroDeBultos, FALSE); // NumeroDeBultos
		$this->BuildSearchSql($sWhere, $this->OperadorTraslado, FALSE); // OperadorTraslado
		$this->BuildSearchSql($sWhere, $this->OperadorEntrego, FALSE); // OperadorEntrego
		$this->BuildSearchSql($sWhere, $this->OperadorVerifico, FALSE); // OperadorVerifico
		$this->BuildSearchSql($sWhere, $this->Observaciones, FALSE); // Observaciones
		$this->BuildSearchSql($sWhere, $this->Importe, FALSE); // Importe
		$this->BuildSearchSql($sWhere, $this->facturas, FALSE); // facturas
		$this->BuildSearchSql($sWhere, $this->observacionesInternas, FALSE); // observacionesInternas
		$this->BuildSearchSql($sWhere, $this->estado, FALSE); // estado
		$this->BuildSearchSql($sWhere, $this->resultado, FALSE); // resultado

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->Id_Remito->AdvancedSearch->Save(); // Id_Remito
			$this->numeroRemito->AdvancedSearch->Save(); // numeroRemito
			$this->Fecha->AdvancedSearch->Save(); // Fecha
			$this->tipoDestinatario->AdvancedSearch->Save(); // tipoDestinatario
			$this->Cliente->AdvancedSearch->Save(); // Cliente
			$this->Proveedor->AdvancedSearch->Save(); // Proveedor
			$this->Transporte->AdvancedSearch->Save(); // Transporte
			$this->NumeroDeBultos->AdvancedSearch->Save(); // NumeroDeBultos
			$this->OperadorTraslado->AdvancedSearch->Save(); // OperadorTraslado
			$this->OperadorEntrego->AdvancedSearch->Save(); // OperadorEntrego
			$this->OperadorVerifico->AdvancedSearch->Save(); // OperadorVerifico
			$this->Observaciones->AdvancedSearch->Save(); // Observaciones
			$this->Importe->AdvancedSearch->Save(); // Importe
			$this->facturas->AdvancedSearch->Save(); // facturas
			$this->observacionesInternas->AdvancedSearch->Save(); // observacionesInternas
			$this->estado->AdvancedSearch->Save(); // estado
			$this->resultado->AdvancedSearch->Save(); // resultado
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->Id_Remito, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->numeroRemito, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Fecha, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Cliente, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->Proveedor, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Transporte, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->NumeroDeBultos, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->OperadorTraslado, $Keyword);
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->OperadorVerifico, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Observaciones, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->Importe, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->observacionesInternas, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->resultado, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->Id_Remito->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->numeroRemito->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->tipoDestinatario->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Proveedor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Transporte->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NumeroDeBultos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->OperadorTraslado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->OperadorEntrego->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->OperadorVerifico->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Observaciones->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Importe->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->facturas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->observacionesInternas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->resultado->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Id_Remito->AdvancedSearch->UnsetSession();
		$this->numeroRemito->AdvancedSearch->UnsetSession();
		$this->Fecha->AdvancedSearch->UnsetSession();
		$this->tipoDestinatario->AdvancedSearch->UnsetSession();
		$this->Cliente->AdvancedSearch->UnsetSession();
		$this->Proveedor->AdvancedSearch->UnsetSession();
		$this->Transporte->AdvancedSearch->UnsetSession();
		$this->NumeroDeBultos->AdvancedSearch->UnsetSession();
		$this->OperadorTraslado->AdvancedSearch->UnsetSession();
		$this->OperadorEntrego->AdvancedSearch->UnsetSession();
		$this->OperadorVerifico->AdvancedSearch->UnsetSession();
		$this->Observaciones->AdvancedSearch->UnsetSession();
		$this->Importe->AdvancedSearch->UnsetSession();
		$this->facturas->AdvancedSearch->UnsetSession();
		$this->observacionesInternas->AdvancedSearch->UnsetSession();
		$this->estado->AdvancedSearch->UnsetSession();
		$this->resultado->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Remito->AdvancedSearch->Load();
		$this->numeroRemito->AdvancedSearch->Load();
		$this->Fecha->AdvancedSearch->Load();
		$this->tipoDestinatario->AdvancedSearch->Load();
		$this->Cliente->AdvancedSearch->Load();
		$this->Proveedor->AdvancedSearch->Load();
		$this->Transporte->AdvancedSearch->Load();
		$this->NumeroDeBultos->AdvancedSearch->Load();
		$this->OperadorTraslado->AdvancedSearch->Load();
		$this->OperadorEntrego->AdvancedSearch->Load();
		$this->OperadorVerifico->AdvancedSearch->Load();
		$this->Observaciones->AdvancedSearch->Load();
		$this->Importe->AdvancedSearch->Load();
		$this->facturas->AdvancedSearch->Load();
		$this->observacionesInternas->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->resultado->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Remito); // Id_Remito
			$this->UpdateSort($this->numeroRemito); // numeroRemito
			$this->UpdateSort($this->Fecha); // Fecha
			$this->UpdateSort($this->Cliente); // Cliente
			$this->UpdateSort($this->Proveedor); // Proveedor
			$this->UpdateSort($this->Transporte); // Transporte
			$this->UpdateSort($this->NumeroDeBultos); // NumeroDeBultos
			$this->UpdateSort($this->OperadorTraslado); // OperadorTraslado
			$this->UpdateSort($this->OperadorVerifico); // OperadorVerifico
			$this->UpdateSort($this->Importe); // Importe
			$this->UpdateSort($this->observacionesInternas); // observacionesInternas
			$this->UpdateSort($this->estado); // estado
			$this->UpdateSort($this->resultado); // resultado
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Id_Remito->setSort("");
				$this->numeroRemito->setSort("");
				$this->Fecha->setSort("");
				$this->Cliente->setSort("");
				$this->Proveedor->setSort("");
				$this->Transporte->setSort("");
				$this->NumeroDeBultos->setSort("");
				$this->OperadorTraslado->setSort("");
				$this->OperadorVerifico->setSort("");
				$this->Importe->setSort("");
				$this->observacionesInternas->setSort("");
				$this->estado->setSort("");
				$this->resultado->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Remito->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Remito->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fremitoslist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Remito->CurrentValue = NULL;
		$this->Id_Remito->OldValue = $this->Id_Remito->CurrentValue;
		$this->numeroRemito->CurrentValue = NULL;
		$this->numeroRemito->OldValue = $this->numeroRemito->CurrentValue;
		$this->Fecha->CurrentValue = ew_CurrentDate();
		$this->Cliente->CurrentValue = NULL;
		$this->Cliente->OldValue = $this->Cliente->CurrentValue;
		$this->Proveedor->CurrentValue = NULL;
		$this->Proveedor->OldValue = $this->Proveedor->CurrentValue;
		$this->Transporte->CurrentValue = NULL;
		$this->Transporte->OldValue = $this->Transporte->CurrentValue;
		$this->NumeroDeBultos->CurrentValue = NULL;
		$this->NumeroDeBultos->OldValue = $this->NumeroDeBultos->CurrentValue;
		$this->OperadorTraslado->CurrentValue = NULL;
		$this->OperadorTraslado->OldValue = $this->OperadorTraslado->CurrentValue;
		$this->OperadorVerifico->CurrentValue = NULL;
		$this->OperadorVerifico->OldValue = $this->OperadorVerifico->CurrentValue;
		$this->Importe->CurrentValue = NULL;
		$this->Importe->OldValue = $this->Importe->CurrentValue;
		$this->observacionesInternas->CurrentValue = NULL;
		$this->observacionesInternas->OldValue = $this->observacionesInternas->CurrentValue;
		$this->estado->CurrentValue = 0;
		$this->resultado->CurrentValue = NULL;
		$this->resultado->OldValue = $this->resultado->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Id_Remito

		$this->Id_Remito->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Remito"]);
		if ($this->Id_Remito->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Remito->AdvancedSearch->SearchOperator = @$_GET["z_Id_Remito"];

		// numeroRemito
		$this->numeroRemito->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_numeroRemito"]);
		if ($this->numeroRemito->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->numeroRemito->AdvancedSearch->SearchOperator = @$_GET["z_numeroRemito"];

		// Fecha
		$this->Fecha->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha"]);
		if ($this->Fecha->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha->AdvancedSearch->SearchOperator = @$_GET["z_Fecha"];

		// tipoDestinatario
		$this->tipoDestinatario->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_tipoDestinatario"]);
		if ($this->tipoDestinatario->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->tipoDestinatario->AdvancedSearch->SearchOperator = @$_GET["z_tipoDestinatario"];

		// Cliente
		$this->Cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cliente"]);
		if ($this->Cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cliente->AdvancedSearch->SearchOperator = @$_GET["z_Cliente"];

		// Proveedor
		$this->Proveedor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Proveedor"]);
		if ($this->Proveedor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Proveedor->AdvancedSearch->SearchOperator = @$_GET["z_Proveedor"];

		// Transporte
		$this->Transporte->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Transporte"]);
		if ($this->Transporte->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Transporte->AdvancedSearch->SearchOperator = @$_GET["z_Transporte"];

		// NumeroDeBultos
		$this->NumeroDeBultos->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NumeroDeBultos"]);
		if ($this->NumeroDeBultos->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NumeroDeBultos->AdvancedSearch->SearchOperator = @$_GET["z_NumeroDeBultos"];

		// OperadorTraslado
		$this->OperadorTraslado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_OperadorTraslado"]);
		if ($this->OperadorTraslado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->OperadorTraslado->AdvancedSearch->SearchOperator = @$_GET["z_OperadorTraslado"];

		// OperadorEntrego
		$this->OperadorEntrego->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_OperadorEntrego"]);
		if ($this->OperadorEntrego->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->OperadorEntrego->AdvancedSearch->SearchOperator = @$_GET["z_OperadorEntrego"];

		// OperadorVerifico
		$this->OperadorVerifico->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_OperadorVerifico"]);
		if ($this->OperadorVerifico->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->OperadorVerifico->AdvancedSearch->SearchOperator = @$_GET["z_OperadorVerifico"];

		// Observaciones
		$this->Observaciones->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Observaciones"]);
		if ($this->Observaciones->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Observaciones->AdvancedSearch->SearchOperator = @$_GET["z_Observaciones"];

		// Importe
		$this->Importe->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Importe"]);
		if ($this->Importe->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Importe->AdvancedSearch->SearchOperator = @$_GET["z_Importe"];

		// facturas
		$this->facturas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_facturas"]);
		if ($this->facturas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->facturas->AdvancedSearch->SearchOperator = @$_GET["z_facturas"];

		// observacionesInternas
		$this->observacionesInternas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_observacionesInternas"]);
		if ($this->observacionesInternas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->observacionesInternas->AdvancedSearch->SearchOperator = @$_GET["z_observacionesInternas"];

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado"]);
		if ($this->estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado->AdvancedSearch->SearchOperator = @$_GET["z_estado"];

		// resultado
		$this->resultado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_resultado"]);
		if ($this->resultado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->resultado->AdvancedSearch->SearchOperator = @$_GET["z_resultado"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Remito->FldIsDetailKey) {
			$this->Id_Remito->setFormValue($objForm->GetValue("x_Id_Remito"));
		}
		if (!$this->numeroRemito->FldIsDetailKey) {
			$this->numeroRemito->setFormValue($objForm->GetValue("x_numeroRemito"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->Cliente->FldIsDetailKey) {
			$this->Cliente->setFormValue($objForm->GetValue("x_Cliente"));
		}
		if (!$this->Proveedor->FldIsDetailKey) {
			$this->Proveedor->setFormValue($objForm->GetValue("x_Proveedor"));
		}
		if (!$this->Transporte->FldIsDetailKey) {
			$this->Transporte->setFormValue($objForm->GetValue("x_Transporte"));
		}
		if (!$this->NumeroDeBultos->FldIsDetailKey) {
			$this->NumeroDeBultos->setFormValue($objForm->GetValue("x_NumeroDeBultos"));
		}
		if (!$this->OperadorTraslado->FldIsDetailKey) {
			$this->OperadorTraslado->setFormValue($objForm->GetValue("x_OperadorTraslado"));
		}
		if (!$this->OperadorVerifico->FldIsDetailKey) {
			$this->OperadorVerifico->setFormValue($objForm->GetValue("x_OperadorVerifico"));
		}
		if (!$this->Importe->FldIsDetailKey) {
			$this->Importe->setFormValue($objForm->GetValue("x_Importe"));
		}
		if (!$this->observacionesInternas->FldIsDetailKey) {
			$this->observacionesInternas->setFormValue($objForm->GetValue("x_observacionesInternas"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->resultado->FldIsDetailKey) {
			$this->resultado->setFormValue($objForm->GetValue("x_resultado"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Remito->CurrentValue = $this->Id_Remito->FormValue;
		$this->numeroRemito->CurrentValue = $this->numeroRemito->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->Cliente->CurrentValue = $this->Cliente->FormValue;
		$this->Proveedor->CurrentValue = $this->Proveedor->FormValue;
		$this->Transporte->CurrentValue = $this->Transporte->FormValue;
		$this->NumeroDeBultos->CurrentValue = $this->NumeroDeBultos->FormValue;
		$this->OperadorTraslado->CurrentValue = $this->OperadorTraslado->FormValue;
		$this->OperadorVerifico->CurrentValue = $this->OperadorVerifico->FormValue;
		$this->Importe->CurrentValue = $this->Importe->FormValue;
		$this->observacionesInternas->CurrentValue = $this->observacionesInternas->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->resultado->CurrentValue = $this->resultado->FormValue;
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
		$this->Id_Remito->setDbValue($rs->fields('Id_Remito'));
		$this->numeroRemito->setDbValue($rs->fields('numeroRemito'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->tipoDestinatario->setDbValue($rs->fields('tipoDestinatario'));
		$this->Cliente->setDbValue($rs->fields('Cliente'));
		$this->Proveedor->setDbValue($rs->fields('Proveedor'));
		$this->Transporte->setDbValue($rs->fields('Transporte'));
		$this->NumeroDeBultos->setDbValue($rs->fields('NumeroDeBultos'));
		$this->OperadorTraslado->setDbValue($rs->fields('OperadorTraslado'));
		$this->OperadorEntrego->setDbValue($rs->fields('OperadorEntrego'));
		$this->OperadorVerifico->setDbValue($rs->fields('OperadorVerifico'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Importe->setDbValue($rs->fields('Importe'));
		$this->facturas->setDbValue($rs->fields('facturas'));
		$this->observacionesInternas->setDbValue($rs->fields('observacionesInternas'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->resultado->setDbValue($rs->fields('resultado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Remito->DbValue = $row['Id_Remito'];
		$this->numeroRemito->DbValue = $row['numeroRemito'];
		$this->Fecha->DbValue = $row['Fecha'];
		$this->tipoDestinatario->DbValue = $row['tipoDestinatario'];
		$this->Cliente->DbValue = $row['Cliente'];
		$this->Proveedor->DbValue = $row['Proveedor'];
		$this->Transporte->DbValue = $row['Transporte'];
		$this->NumeroDeBultos->DbValue = $row['NumeroDeBultos'];
		$this->OperadorTraslado->DbValue = $row['OperadorTraslado'];
		$this->OperadorEntrego->DbValue = $row['OperadorEntrego'];
		$this->OperadorVerifico->DbValue = $row['OperadorVerifico'];
		$this->Observaciones->DbValue = $row['Observaciones'];
		$this->Importe->DbValue = $row['Importe'];
		$this->facturas->DbValue = $row['facturas'];
		$this->observacionesInternas->DbValue = $row['observacionesInternas'];
		$this->estado->DbValue = $row['estado'];
		$this->resultado->DbValue = $row['resultado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Remito")) <> "")
			$this->Id_Remito->CurrentValue = $this->getKey("Id_Remito"); // Id_Remito
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Remito
		// numeroRemito
		// Fecha
		// tipoDestinatario

		$this->tipoDestinatario->CellCssStyle = "white-space: nowrap;";

		// Cliente
		// Proveedor
		// Transporte
		// NumeroDeBultos
		// OperadorTraslado
		// OperadorEntrego

		$this->OperadorEntrego->CellCssStyle = "white-space: nowrap;";

		// OperadorVerifico
		// Observaciones
		// Importe
		// facturas

		$this->facturas->CellCssStyle = "white-space: nowrap;";

		// observacionesInternas
		// estado
		// resultado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Remito
			$this->Id_Remito->ViewValue = $this->Id_Remito->CurrentValue;
			$this->Id_Remito->ViewCustomAttributes = "";

			// numeroRemito
			$this->numeroRemito->ViewValue = $this->numeroRemito->CurrentValue;
			$this->numeroRemito->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Cliente
			$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
			$this->Cliente->ViewCustomAttributes = "";

			// Proveedor
			if (strval($this->Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedores`" . ew_SearchString("=", $this->Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedores`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Proveedor, $sWhereWrk);
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
			$this->Transporte->ViewValue = $this->Transporte->CurrentValue;
			$this->Transporte->ViewCustomAttributes = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->ViewValue = $this->NumeroDeBultos->CurrentValue;
			$this->NumeroDeBultos->ViewCustomAttributes = "";

			// OperadorTraslado
			$this->OperadorTraslado->ViewValue = $this->OperadorTraslado->CurrentValue;
			if (strval($this->OperadorTraslado->CurrentValue) <> "") {
				$sFilterWrk = "`idTransporteInterno`" . ew_SearchString("=", $this->OperadorTraslado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idTransporteInterno`, `denominacionTransporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte_interno`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorTraslado, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacionTransporte` ASC";
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

			// OperadorVerifico
			$this->OperadorVerifico->ViewValue = $this->OperadorVerifico->CurrentValue;
			if (strval($this->OperadorVerifico->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorVerifico->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorVerifico, $sWhereWrk);
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

			// observacionesInternas
			$this->observacionesInternas->ViewValue = $this->observacionesInternas->CurrentValue;
			$this->observacionesInternas->ViewCustomAttributes = "";

			// estado
			if (strval($this->estado->CurrentValue) <> "") {
				switch ($this->estado->CurrentValue) {
					case $this->estado->FldTagValue(1):
						$this->estado->ViewValue = $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->CurrentValue;
						break;
					case $this->estado->FldTagValue(2):
						$this->estado->ViewValue = $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->CurrentValue;
						break;
					case $this->estado->FldTagValue(3):
						$this->estado->ViewValue = $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->CurrentValue;
						break;
					case $this->estado->FldTagValue(4):
						$this->estado->ViewValue = $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->CurrentValue;
						break;
					default:
						$this->estado->ViewValue = $this->estado->CurrentValue;
				}
			} else {
				$this->estado->ViewValue = NULL;
			}
			$this->estado->ViewCustomAttributes = "";

			// resultado
			$this->resultado->ViewValue = $this->resultado->CurrentValue;
			$this->resultado->ViewCustomAttributes = "";

			// Id_Remito
			$this->Id_Remito->LinkCustomAttributes = "";
			$this->Id_Remito->HrefValue = "";
			$this->Id_Remito->TooltipValue = "";

			// numeroRemito
			$this->numeroRemito->LinkCustomAttributes = "";
			$this->numeroRemito->HrefValue = "";
			$this->numeroRemito->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Cliente
			$this->Cliente->LinkCustomAttributes = "";
			$this->Cliente->HrefValue = "";
			$this->Cliente->TooltipValue = "";

			// Proveedor
			$this->Proveedor->LinkCustomAttributes = "";
			$this->Proveedor->HrefValue = "";
			$this->Proveedor->TooltipValue = "";

			// Transporte
			$this->Transporte->LinkCustomAttributes = "";
			$this->Transporte->HrefValue = "";
			$this->Transporte->TooltipValue = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->LinkCustomAttributes = "";
			$this->NumeroDeBultos->HrefValue = "";
			$this->NumeroDeBultos->TooltipValue = "";

			// OperadorTraslado
			$this->OperadorTraslado->LinkCustomAttributes = "";
			$this->OperadorTraslado->HrefValue = "";
			$this->OperadorTraslado->TooltipValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->LinkCustomAttributes = "";
			$this->OperadorVerifico->HrefValue = "";
			$this->OperadorVerifico->TooltipValue = "";

			// Importe
			$this->Importe->LinkCustomAttributes = "";
			$this->Importe->HrefValue = "";
			$this->Importe->TooltipValue = "";

			// observacionesInternas
			$this->observacionesInternas->LinkCustomAttributes = "";
			$this->observacionesInternas->HrefValue = "";
			$this->observacionesInternas->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// resultado
			$this->resultado->LinkCustomAttributes = "";
			$this->resultado->HrefValue = "";
			$this->resultado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Remito
			$this->Id_Remito->EditCustomAttributes = "";
			$this->Id_Remito->EditValue = ew_HtmlEncode($this->Id_Remito->CurrentValue);
			$this->Id_Remito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Id_Remito->FldCaption()));

			// numeroRemito
			$this->numeroRemito->EditCustomAttributes = "";
			$this->numeroRemito->EditValue = ew_HtmlEncode($this->numeroRemito->CurrentValue);
			$this->numeroRemito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->numeroRemito->FldCaption()));

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha->CurrentValue, 7));
			$this->Fecha->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Fecha->FldCaption()));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$this->Cliente->EditValue = ew_HtmlEncode($this->Cliente->CurrentValue);
			$this->Cliente->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Cliente->FldCaption()));

			// Proveedor
			$this->Proveedor->EditCustomAttributes = "";

			// Transporte
			$this->Transporte->EditCustomAttributes = "";
			$this->Transporte->EditValue = ew_HtmlEncode($this->Transporte->CurrentValue);
			$this->Transporte->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Transporte->FldCaption()));

			// NumeroDeBultos
			$this->NumeroDeBultos->EditCustomAttributes = "";
			$this->NumeroDeBultos->EditValue = ew_HtmlEncode($this->NumeroDeBultos->CurrentValue);
			$this->NumeroDeBultos->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NumeroDeBultos->FldCaption()));

			// OperadorTraslado
			$this->OperadorTraslado->EditCustomAttributes = "";
			$this->OperadorTraslado->EditValue = ew_HtmlEncode($this->OperadorTraslado->CurrentValue);
			$this->OperadorTraslado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorTraslado->FldCaption()));

			// OperadorVerifico
			$this->OperadorVerifico->EditCustomAttributes = "";
			$this->OperadorVerifico->EditValue = ew_HtmlEncode($this->OperadorVerifico->CurrentValue);
			$this->OperadorVerifico->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorVerifico->FldCaption()));

			// Importe
			$this->Importe->EditCustomAttributes = "";
			$this->Importe->EditValue = ew_HtmlEncode($this->Importe->CurrentValue);
			$this->Importe->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Importe->FldCaption()));

			// observacionesInternas
			$this->observacionesInternas->EditCustomAttributes = "";
			$this->observacionesInternas->EditValue = ew_HtmlEncode($this->observacionesInternas->CurrentValue);
			$this->observacionesInternas->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->observacionesInternas->FldCaption()));

			// estado
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			$arwrk[] = array($this->estado->FldTagValue(3), $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->FldTagValue(3));
			$arwrk[] = array($this->estado->FldTagValue(4), $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// resultado
			$this->resultado->EditCustomAttributes = "";
			$this->resultado->EditValue = $this->resultado->CurrentValue;
			$this->resultado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->resultado->FldCaption()));

			// Edit refer script
			// Id_Remito

			$this->Id_Remito->HrefValue = "";

			// numeroRemito
			$this->numeroRemito->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Cliente
			$this->Cliente->HrefValue = "";

			// Proveedor
			$this->Proveedor->HrefValue = "";

			// Transporte
			$this->Transporte->HrefValue = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->HrefValue = "";

			// OperadorTraslado
			$this->OperadorTraslado->HrefValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->HrefValue = "";

			// Importe
			$this->Importe->HrefValue = "";

			// observacionesInternas
			$this->observacionesInternas->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// resultado
			$this->resultado->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Remito
			$this->Id_Remito->EditCustomAttributes = "";
			$this->Id_Remito->EditValue = $this->Id_Remito->CurrentValue;
			$this->Id_Remito->ViewCustomAttributes = "";

			// numeroRemito
			$this->numeroRemito->EditCustomAttributes = "";
			$this->numeroRemito->EditValue = $this->numeroRemito->CurrentValue;
			$this->numeroRemito->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = $this->Fecha->CurrentValue;
			$this->Fecha->EditValue = ew_FormatDateTime($this->Fecha->EditValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$this->Cliente->EditValue = $this->Cliente->CurrentValue;
			$this->Cliente->ViewCustomAttributes = "";

			// Proveedor
			$this->Proveedor->EditCustomAttributes = "";
			if (strval($this->Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedores`" . ew_SearchString("=", $this->Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedores`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Proveedor, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `razonSocial` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Proveedor->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Proveedor->EditValue = $this->Proveedor->CurrentValue;
				}
			} else {
				$this->Proveedor->EditValue = NULL;
			}
			$this->Proveedor->ViewCustomAttributes = "";

			// Transporte
			$this->Transporte->EditCustomAttributes = "";
			$this->Transporte->EditValue = $this->Transporte->CurrentValue;
			$this->Transporte->ViewCustomAttributes = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->EditCustomAttributes = "";
			$this->NumeroDeBultos->EditValue = $this->NumeroDeBultos->CurrentValue;
			$this->NumeroDeBultos->ViewCustomAttributes = "";

			// OperadorTraslado
			$this->OperadorTraslado->EditCustomAttributes = "";
			$this->OperadorTraslado->EditValue = $this->OperadorTraslado->CurrentValue;
			if (strval($this->OperadorTraslado->CurrentValue) <> "") {
				$sFilterWrk = "`idTransporteInterno`" . ew_SearchString("=", $this->OperadorTraslado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idTransporteInterno`, `denominacionTransporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte_interno`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorTraslado, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacionTransporte` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorTraslado->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorTraslado->EditValue = $this->OperadorTraslado->CurrentValue;
				}
			} else {
				$this->OperadorTraslado->EditValue = NULL;
			}
			$this->OperadorTraslado->ViewCustomAttributes = "";

			// OperadorVerifico
			$this->OperadorVerifico->EditCustomAttributes = "";
			$this->OperadorVerifico->EditValue = $this->OperadorVerifico->CurrentValue;
			if (strval($this->OperadorVerifico->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorVerifico->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorVerifico, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorVerifico->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorVerifico->EditValue = $this->OperadorVerifico->CurrentValue;
				}
			} else {
				$this->OperadorVerifico->EditValue = NULL;
			}
			$this->OperadorVerifico->ViewCustomAttributes = "";

			// Importe
			$this->Importe->EditCustomAttributes = "";
			$this->Importe->EditValue = $this->Importe->CurrentValue;
			$this->Importe->ViewCustomAttributes = "";

			// observacionesInternas
			$this->observacionesInternas->EditCustomAttributes = "";
			$this->observacionesInternas->EditValue = ew_HtmlEncode($this->observacionesInternas->CurrentValue);
			$this->observacionesInternas->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->observacionesInternas->FldCaption()));

			// estado
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			$arwrk[] = array($this->estado->FldTagValue(3), $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->FldTagValue(3));
			$arwrk[] = array($this->estado->FldTagValue(4), $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// resultado
			$this->resultado->EditCustomAttributes = "";
			$this->resultado->EditValue = $this->resultado->CurrentValue;
			$this->resultado->ViewCustomAttributes = "";

			// Edit refer script
			// Id_Remito

			$this->Id_Remito->HrefValue = "";

			// numeroRemito
			$this->numeroRemito->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// Cliente
			$this->Cliente->HrefValue = "";

			// Proveedor
			$this->Proveedor->HrefValue = "";

			// Transporte
			$this->Transporte->HrefValue = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->HrefValue = "";

			// OperadorTraslado
			$this->OperadorTraslado->HrefValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->HrefValue = "";

			// Importe
			$this->Importe->HrefValue = "";

			// observacionesInternas
			$this->observacionesInternas->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// resultado
			$this->resultado->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Id_Remito
			$this->Id_Remito->EditCustomAttributes = "";
			$this->Id_Remito->EditValue = ew_HtmlEncode($this->Id_Remito->AdvancedSearch->SearchValue);
			$this->Id_Remito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Id_Remito->FldCaption()));

			// numeroRemito
			$this->numeroRemito->EditCustomAttributes = "";
			$this->numeroRemito->EditValue = ew_HtmlEncode($this->numeroRemito->AdvancedSearch->SearchValue);
			$this->numeroRemito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->numeroRemito->FldCaption()));

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Fecha->FldCaption()));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$this->Cliente->EditValue = ew_HtmlEncode($this->Cliente->AdvancedSearch->SearchValue);
			$this->Cliente->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Cliente->FldCaption()));

			// Proveedor
			$this->Proveedor->EditCustomAttributes = "";

			// Transporte
			$this->Transporte->EditCustomAttributes = "";
			$this->Transporte->EditValue = ew_HtmlEncode($this->Transporte->AdvancedSearch->SearchValue);
			$this->Transporte->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Transporte->FldCaption()));

			// NumeroDeBultos
			$this->NumeroDeBultos->EditCustomAttributes = "";
			$this->NumeroDeBultos->EditValue = ew_HtmlEncode($this->NumeroDeBultos->AdvancedSearch->SearchValue);
			$this->NumeroDeBultos->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NumeroDeBultos->FldCaption()));

			// OperadorTraslado
			$this->OperadorTraslado->EditCustomAttributes = "";
			$this->OperadorTraslado->EditValue = ew_HtmlEncode($this->OperadorTraslado->AdvancedSearch->SearchValue);
			$this->OperadorTraslado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorTraslado->FldCaption()));

			// OperadorVerifico
			$this->OperadorVerifico->EditCustomAttributes = "";
			$this->OperadorVerifico->EditValue = ew_HtmlEncode($this->OperadorVerifico->AdvancedSearch->SearchValue);
			$this->OperadorVerifico->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorVerifico->FldCaption()));

			// Importe
			$this->Importe->EditCustomAttributes = "";
			$this->Importe->EditValue = ew_HtmlEncode($this->Importe->AdvancedSearch->SearchValue);
			$this->Importe->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Importe->FldCaption()));

			// observacionesInternas
			$this->observacionesInternas->EditCustomAttributes = "";
			$this->observacionesInternas->EditValue = ew_HtmlEncode($this->observacionesInternas->AdvancedSearch->SearchValue);
			$this->observacionesInternas->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->observacionesInternas->FldCaption()));

			// estado
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			$arwrk[] = array($this->estado->FldTagValue(3), $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->FldTagValue(3));
			$arwrk[] = array($this->estado->FldTagValue(4), $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// resultado
			$this->resultado->EditCustomAttributes = "";
			$this->resultado->EditValue = $this->resultado->AdvancedSearch->SearchValue;
			$this->resultado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->resultado->FldCaption()));
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// observacionesInternas
			$this->observacionesInternas->SetDbValueDef($rsnew, $this->observacionesInternas->CurrentValue, NULL, $this->observacionesInternas->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, NULL, $this->estado->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Id_Remito
		$this->Id_Remito->SetDbValueDef($rsnew, $this->Id_Remito->CurrentValue, 0, FALSE);

		// numeroRemito
		$this->numeroRemito->SetDbValueDef($rsnew, $this->numeroRemito->CurrentValue, NULL, FALSE);

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha->CurrentValue, 7), NULL, FALSE);

		// Cliente
		$this->Cliente->SetDbValueDef($rsnew, $this->Cliente->CurrentValue, NULL, FALSE);

		// Proveedor
		$this->Proveedor->SetDbValueDef($rsnew, $this->Proveedor->CurrentValue, NULL, FALSE);

		// Transporte
		$this->Transporte->SetDbValueDef($rsnew, $this->Transporte->CurrentValue, NULL, FALSE);

		// NumeroDeBultos
		$this->NumeroDeBultos->SetDbValueDef($rsnew, $this->NumeroDeBultos->CurrentValue, NULL, FALSE);

		// OperadorTraslado
		$this->OperadorTraslado->SetDbValueDef($rsnew, $this->OperadorTraslado->CurrentValue, NULL, FALSE);

		// OperadorVerifico
		$this->OperadorVerifico->SetDbValueDef($rsnew, $this->OperadorVerifico->CurrentValue, NULL, FALSE);

		// Importe
		$this->Importe->SetDbValueDef($rsnew, $this->Importe->CurrentValue, NULL, FALSE);

		// observacionesInternas
		$this->observacionesInternas->SetDbValueDef($rsnew, $this->observacionesInternas->CurrentValue, NULL, FALSE);

		// estado
		$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, NULL, FALSE);

		// resultado
		$this->resultado->SetDbValueDef($rsnew, $this->resultado->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && $this->Id_Remito->CurrentValue == "" && $this->Id_Remito->getSessionValue() == "") {
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Remito->AdvancedSearch->Load();
		$this->numeroRemito->AdvancedSearch->Load();
		$this->Fecha->AdvancedSearch->Load();
		$this->tipoDestinatario->AdvancedSearch->Load();
		$this->Cliente->AdvancedSearch->Load();
		$this->Proveedor->AdvancedSearch->Load();
		$this->Transporte->AdvancedSearch->Load();
		$this->NumeroDeBultos->AdvancedSearch->Load();
		$this->OperadorTraslado->AdvancedSearch->Load();
		$this->OperadorEntrego->AdvancedSearch->Load();
		$this->OperadorVerifico->AdvancedSearch->Load();
		$this->Observaciones->AdvancedSearch->Load();
		$this->Importe->AdvancedSearch->Load();
		$this->facturas->AdvancedSearch->Load();
		$this->observacionesInternas->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->resultado->AdvancedSearch->Load();
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
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_remitos\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_remitos',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.fremitoslist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}
		$this->AddSearchQueryString($sQry, $this->Id_Remito); // Id_Remito
		$this->AddSearchQueryString($sQry, $this->numeroRemito); // numeroRemito
		$this->AddSearchQueryString($sQry, $this->Fecha); // Fecha
		$this->AddSearchQueryString($sQry, $this->tipoDestinatario); // tipoDestinatario
		$this->AddSearchQueryString($sQry, $this->Cliente); // Cliente
		$this->AddSearchQueryString($sQry, $this->Proveedor); // Proveedor
		$this->AddSearchQueryString($sQry, $this->Transporte); // Transporte
		$this->AddSearchQueryString($sQry, $this->NumeroDeBultos); // NumeroDeBultos
		$this->AddSearchQueryString($sQry, $this->OperadorTraslado); // OperadorTraslado
		$this->AddSearchQueryString($sQry, $this->OperadorEntrego); // OperadorEntrego
		$this->AddSearchQueryString($sQry, $this->OperadorVerifico); // OperadorVerifico
		$this->AddSearchQueryString($sQry, $this->Observaciones); // Observaciones
		$this->AddSearchQueryString($sQry, $this->Importe); // Importe
		$this->AddSearchQueryString($sQry, $this->facturas); // facturas
		$this->AddSearchQueryString($sQry, $this->observacionesInternas); // observacionesInternas
		$this->AddSearchQueryString($sQry, $this->estado); // estado
		$this->AddSearchQueryString($sQry, $this->resultado); // resultado

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($remitos_list)) $remitos_list = new cremitos_list();

// Page init
$remitos_list->Page_Init();

// Page main
$remitos_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($remitos->Export == "") { ?>
<script type="text/javascript">

// Page object
var remitos_list = new ew_Page("remitos_list");
remitos_list.PageID = "list"; // Page ID
var EW_PAGE_ID = remitos_list.PageID; // For backward compatibility

// Form object
var fremitoslist = new ew_Form("fremitoslist");
fremitoslist.FormKeyCountName = '<?php echo $remitos_list->FormKeyCountName ?>';

// Validate form
fremitoslist.Validate = function() {
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

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fremitoslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitoslist.ValidateRequired = true;
<?php } else { ?>
fremitoslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitoslist.Lists["x_Proveedor"] = {"LinkField":"x_Id_Proveedores","Ajax":null,"AutoFill":false,"DisplayFields":["x_razonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitoslist.Lists["x_OperadorTraslado"] = {"LinkField":"x_idTransporteInterno","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacionTransporte","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitoslist.Lists["x_OperadorVerifico"] = {"LinkField":"x_Id_Operadores","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fremitoslistsrch = new ew_Form("fremitoslistsrch");

// Validate function for search
fremitoslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fremitoslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitoslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fremitoslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($remitos->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($remitos_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $remitos_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$remitos_list->TotalRecs = $remitos->SelectRecordCount();
	} else {
		if ($remitos_list->Recordset = $remitos_list->LoadRecordset())
			$remitos_list->TotalRecs = $remitos_list->Recordset->RecordCount();
	}
	$remitos_list->StartRec = 1;
	if ($remitos_list->DisplayRecs <= 0 || ($remitos->Export <> "" && $remitos->ExportAll)) // Display all records
		$remitos_list->DisplayRecs = $remitos_list->TotalRecs;
	if (!($remitos->Export <> "" && $remitos->ExportAll))
		$remitos_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$remitos_list->Recordset = $remitos_list->LoadRecordset($remitos_list->StartRec-1, $remitos_list->DisplayRecs);
$remitos_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($remitos->Export == "" && $remitos->CurrentAction == "") { ?>
<form name="fremitoslistsrch" id="fremitoslistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="fremitoslistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#fremitoslistsrch_SearchGroup" href="#fremitoslistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="fremitoslistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="fremitoslistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="remitos">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$remitos_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$remitos->RowType = EW_ROWTYPE_SEARCH;

// Render row
$remitos->ResetAttrs();
$remitos_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
	<span id="xsc_Cliente" class="ewCell">
		<span class="ewSearchCaption"><?php echo $remitos->Cliente->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cliente" id="z_Cliente" value="LIKE"></span>
		<span class="control-group ewSearchField">
<input type="text" data-field="x_Cliente" name="x_Cliente" id="x_Cliente" size="30" maxlength="10" placeholder="<?php echo $remitos->Cliente->PlaceHolder ?>" value="<?php echo $remitos->Cliente->EditValue ?>"<?php echo $remitos->Cliente->EditAttributes() ?>>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($remitos->estado->Visible) { // estado ?>
	<span id="xsc_estado" class="ewCell">
		<span class="ewSearchCaption"><?php echo $remitos->estado->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></span>
		<span class="control-group ewSearchField">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $remitos->estado->EditAttributes() ?>>
<?php
if (is_array($remitos->estado->EditValue)) {
	$arwrk = $remitos->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($remitos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $remitos_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_4" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($remitos_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($remitos_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($remitos_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
			</div>
		</div>
	</div>
</div>
</td></tr></table>
</form>
<?php } ?>
<?php } ?>
<?php $remitos_list->ShowPageHeader(); ?>
<?php
$remitos_list->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($remitos->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($remitos->CurrentAction <> "gridadd" && $remitos->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($remitos_list->Pager)) $remitos_list->Pager = new cPrevNextPager($remitos_list->StartRec, $remitos_list->DisplayRecs, $remitos_list->TotalRecs) ?>
<?php if ($remitos_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($remitos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_list->PageUrl() ?>start=<?php echo $remitos_list->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($remitos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_list->PageUrl() ?>start=<?php echo $remitos_list->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $remitos_list->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($remitos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_list->PageUrl() ?>start=<?php echo $remitos_list->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($remitos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_list->PageUrl() ?>start=<?php echo $remitos_list->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $remitos_list->Pager->PageCount ?>
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $remitos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $remitos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $remitos_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($remitos_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoPermission") ?></p>
	<?php } ?>
<?php } ?>
</td>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($remitos_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
</div>
<?php } ?>
<form name="fremitoslist" id="fremitoslist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="remitos">
<div id="gmp_remitos" class="ewGridMiddlePanel">
<?php if ($remitos_list->TotalRecs > 0) { ?>
<table id="tbl_remitoslist" class="ewTable ewTableSeparate">
<?php echo $remitos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$remitos_list->RenderListOptions();

// Render list options (header, left)
$remitos_list->ListOptions->Render("header", "left");
?>
<?php if ($remitos->Id_Remito->Visible) { // Id_Remito ?>
	<?php if ($remitos->SortUrl($remitos->Id_Remito) == "") { ?>
		<td><div id="elh_remitos_Id_Remito" class="remitos_Id_Remito"><div class="ewTableHeaderCaption"><?php echo $remitos->Id_Remito->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Id_Remito) ?>',1);"><div id="elh_remitos_Id_Remito" class="remitos_Id_Remito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Id_Remito->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Id_Remito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Id_Remito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->numeroRemito->Visible) { // numeroRemito ?>
	<?php if ($remitos->SortUrl($remitos->numeroRemito) == "") { ?>
		<td><div id="elh_remitos_numeroRemito" class="remitos_numeroRemito"><div class="ewTableHeaderCaption"><?php echo $remitos->numeroRemito->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->numeroRemito) ?>',1);"><div id="elh_remitos_numeroRemito" class="remitos_numeroRemito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->numeroRemito->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->numeroRemito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->numeroRemito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
	<?php if ($remitos->SortUrl($remitos->Fecha) == "") { ?>
		<td><div id="elh_remitos_Fecha" class="remitos_Fecha"><div class="ewTableHeaderCaption"><?php echo $remitos->Fecha->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Fecha) ?>',1);"><div id="elh_remitos_Fecha" class="remitos_Fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Fecha->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
	<?php if ($remitos->SortUrl($remitos->Cliente) == "") { ?>
		<td><div id="elh_remitos_Cliente" class="remitos_Cliente"><div class="ewTableHeaderCaption"><?php echo $remitos->Cliente->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Cliente) ?>',1);"><div id="elh_remitos_Cliente" class="remitos_Cliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Cliente->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Cliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Cliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
	<?php if ($remitos->SortUrl($remitos->Proveedor) == "") { ?>
		<td><div id="elh_remitos_Proveedor" class="remitos_Proveedor"><div class="ewTableHeaderCaption"><?php echo $remitos->Proveedor->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Proveedor) ?>',1);"><div id="elh_remitos_Proveedor" class="remitos_Proveedor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Proveedor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Proveedor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Proveedor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
	<?php if ($remitos->SortUrl($remitos->Transporte) == "") { ?>
		<td><div id="elh_remitos_Transporte" class="remitos_Transporte"><div class="ewTableHeaderCaption"><?php echo $remitos->Transporte->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Transporte) ?>',1);"><div id="elh_remitos_Transporte" class="remitos_Transporte">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Transporte->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Transporte->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Transporte->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
	<?php if ($remitos->SortUrl($remitos->NumeroDeBultos) == "") { ?>
		<td><div id="elh_remitos_NumeroDeBultos" class="remitos_NumeroDeBultos"><div class="ewTableHeaderCaption"><?php echo $remitos->NumeroDeBultos->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->NumeroDeBultos) ?>',1);"><div id="elh_remitos_NumeroDeBultos" class="remitos_NumeroDeBultos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->NumeroDeBultos->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->NumeroDeBultos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->NumeroDeBultos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
	<?php if ($remitos->SortUrl($remitos->OperadorTraslado) == "") { ?>
		<td><div id="elh_remitos_OperadorTraslado" class="remitos_OperadorTraslado"><div class="ewTableHeaderCaption"><?php echo $remitos->OperadorTraslado->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->OperadorTraslado) ?>',1);"><div id="elh_remitos_OperadorTraslado" class="remitos_OperadorTraslado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->OperadorTraslado->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->OperadorTraslado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->OperadorTraslado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
	<?php if ($remitos->SortUrl($remitos->OperadorVerifico) == "") { ?>
		<td><div id="elh_remitos_OperadorVerifico" class="remitos_OperadorVerifico"><div class="ewTableHeaderCaption"><?php echo $remitos->OperadorVerifico->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->OperadorVerifico) ?>',1);"><div id="elh_remitos_OperadorVerifico" class="remitos_OperadorVerifico">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->OperadorVerifico->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->OperadorVerifico->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->OperadorVerifico->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->Importe->Visible) { // Importe ?>
	<?php if ($remitos->SortUrl($remitos->Importe) == "") { ?>
		<td><div id="elh_remitos_Importe" class="remitos_Importe"><div class="ewTableHeaderCaption"><?php echo $remitos->Importe->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->Importe) ?>',1);"><div id="elh_remitos_Importe" class="remitos_Importe">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->Importe->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->Importe->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->Importe->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
	<?php if ($remitos->SortUrl($remitos->observacionesInternas) == "") { ?>
		<td><div id="elh_remitos_observacionesInternas" class="remitos_observacionesInternas"><div class="ewTableHeaderCaption"><?php echo $remitos->observacionesInternas->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->observacionesInternas) ?>',1);"><div id="elh_remitos_observacionesInternas" class="remitos_observacionesInternas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->observacionesInternas->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->observacionesInternas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->observacionesInternas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->estado->Visible) { // estado ?>
	<?php if ($remitos->SortUrl($remitos->estado) == "") { ?>
		<td><div id="elh_remitos_estado" class="remitos_estado"><div class="ewTableHeaderCaption"><?php echo $remitos->estado->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->estado) ?>',1);"><div id="elh_remitos_estado" class="remitos_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitos->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos->resultado->Visible) { // resultado ?>
	<?php if ($remitos->SortUrl($remitos->resultado) == "") { ?>
		<td><div id="elh_remitos_resultado" class="remitos_resultado"><div class="ewTableHeaderCaption"><?php echo $remitos->resultado->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $remitos->SortUrl($remitos->resultado) ?>',1);"><div id="elh_remitos_resultado" class="remitos_resultado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos->resultado->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($remitos->resultado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos->resultado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$remitos_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($remitos->ExportAll && $remitos->Export <> "") {
	$remitos_list->StopRec = $remitos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($remitos_list->TotalRecs > $remitos_list->StartRec + $remitos_list->DisplayRecs - 1)
		$remitos_list->StopRec = $remitos_list->StartRec + $remitos_list->DisplayRecs - 1;
	else
		$remitos_list->StopRec = $remitos_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($remitos_list->FormKeyCountName) && ($remitos->CurrentAction == "gridadd" || $remitos->CurrentAction == "gridedit" || $remitos->CurrentAction == "F")) {
		$remitos_list->KeyCount = $objForm->GetValue($remitos_list->FormKeyCountName);
		$remitos_list->StopRec = $remitos_list->StartRec + $remitos_list->KeyCount - 1;
	}
}
$remitos_list->RecCnt = $remitos_list->StartRec - 1;
if ($remitos_list->Recordset && !$remitos_list->Recordset->EOF) {
	$remitos_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $remitos_list->StartRec > 1)
		$remitos_list->Recordset->Move($remitos_list->StartRec - 1);
} elseif (!$remitos->AllowAddDeleteRow && $remitos_list->StopRec == 0) {
	$remitos_list->StopRec = $remitos->GridAddRowCount;
}

// Initialize aggregate
$remitos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$remitos->ResetAttrs();
$remitos_list->RenderRow();
$remitos_list->EditRowCnt = 0;
if ($remitos->CurrentAction == "edit")
	$remitos_list->RowIndex = 1;
while ($remitos_list->RecCnt < $remitos_list->StopRec) {
	$remitos_list->RecCnt++;
	if (intval($remitos_list->RecCnt) >= intval($remitos_list->StartRec)) {
		$remitos_list->RowCnt++;

		// Set up key count
		$remitos_list->KeyCount = $remitos_list->RowIndex;

		// Init row class and style
		$remitos->ResetAttrs();
		$remitos->CssClass = "";
		if ($remitos->CurrentAction == "gridadd") {
			$remitos_list->LoadDefaultValues(); // Load default values
		} else {
			$remitos_list->LoadRowValues($remitos_list->Recordset); // Load row values
		}
		$remitos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($remitos->CurrentAction == "edit") {
			if ($remitos_list->CheckInlineEditKey() && $remitos_list->EditRowCnt == 0) { // Inline edit
				$remitos->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($remitos->CurrentAction == "edit" && $remitos->RowType == EW_ROWTYPE_EDIT && $remitos->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$remitos_list->RestoreFormValues(); // Restore form values
		}
		if ($remitos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$remitos_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$remitos->RowAttrs = array_merge($remitos->RowAttrs, array('data-rowindex'=>$remitos_list->RowCnt, 'id'=>'r' . $remitos_list->RowCnt . '_remitos', 'data-rowtype'=>$remitos->RowType));

		// Render row
		$remitos_list->RenderRow();

		// Render list options
		$remitos_list->RenderListOptions();
?>
	<tr<?php echo $remitos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$remitos_list->ListOptions->Render("body", "left", $remitos_list->RowCnt);
?>
	<?php if ($remitos->Id_Remito->Visible) { // Id_Remito ?>
		<td<?php echo $remitos->Id_Remito->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Id_Remito" class="control-group remitos_Id_Remito">
<span<?php echo $remitos->Id_Remito->ViewAttributes() ?>>
<?php echo $remitos->Id_Remito->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Id_Remito" name="x<?php echo $remitos_list->RowIndex ?>_Id_Remito" id="x<?php echo $remitos_list->RowIndex ?>_Id_Remito" value="<?php echo ew_HtmlEncode($remitos->Id_Remito->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Id_Remito->ViewAttributes() ?>>
<?php echo $remitos->Id_Remito->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->numeroRemito->Visible) { // numeroRemito ?>
		<td<?php echo $remitos->numeroRemito->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_numeroRemito" class="control-group remitos_numeroRemito">
<span<?php echo $remitos->numeroRemito->ViewAttributes() ?>>
<?php echo $remitos->numeroRemito->EditValue ?></span>
</span>
<input type="hidden" data-field="x_numeroRemito" name="x<?php echo $remitos_list->RowIndex ?>_numeroRemito" id="x<?php echo $remitos_list->RowIndex ?>_numeroRemito" value="<?php echo ew_HtmlEncode($remitos->numeroRemito->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->numeroRemito->ViewAttributes() ?>>
<?php echo $remitos->numeroRemito->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->Fecha->Visible) { // Fecha ?>
		<td<?php echo $remitos->Fecha->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Fecha" class="control-group remitos_Fecha">
<span<?php echo $remitos->Fecha->ViewAttributes() ?>>
<?php echo $remitos->Fecha->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Fecha" name="x<?php echo $remitos_list->RowIndex ?>_Fecha" id="x<?php echo $remitos_list->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($remitos->Fecha->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Fecha->ViewAttributes() ?>>
<?php echo $remitos->Fecha->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->Cliente->Visible) { // Cliente ?>
		<td<?php echo $remitos->Cliente->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Cliente" class="control-group remitos_Cliente">
<span<?php echo $remitos->Cliente->ViewAttributes() ?>>
<?php echo $remitos->Cliente->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Cliente" name="x<?php echo $remitos_list->RowIndex ?>_Cliente" id="x<?php echo $remitos_list->RowIndex ?>_Cliente" value="<?php echo ew_HtmlEncode($remitos->Cliente->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Cliente->ViewAttributes() ?>>
<?php echo $remitos->Cliente->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
		<td<?php echo $remitos->Proveedor->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Proveedor" class="control-group remitos_Proveedor">
<span<?php echo $remitos->Proveedor->ViewAttributes() ?>>
<?php echo $remitos->Proveedor->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Proveedor" name="x<?php echo $remitos_list->RowIndex ?>_Proveedor" id="x<?php echo $remitos_list->RowIndex ?>_Proveedor" value="<?php echo ew_HtmlEncode($remitos->Proveedor->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Proveedor->ViewAttributes() ?>>
<?php echo $remitos->Proveedor->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->Transporte->Visible) { // Transporte ?>
		<td<?php echo $remitos->Transporte->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Transporte" class="control-group remitos_Transporte">
<span<?php echo $remitos->Transporte->ViewAttributes() ?>>
<?php echo $remitos->Transporte->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Transporte" name="x<?php echo $remitos_list->RowIndex ?>_Transporte" id="x<?php echo $remitos_list->RowIndex ?>_Transporte" value="<?php echo ew_HtmlEncode($remitos->Transporte->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Transporte->ViewAttributes() ?>>
<?php echo $remitos->Transporte->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
		<td<?php echo $remitos->NumeroDeBultos->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_NumeroDeBultos" class="control-group remitos_NumeroDeBultos">
<span<?php echo $remitos->NumeroDeBultos->ViewAttributes() ?>>
<?php echo $remitos->NumeroDeBultos->EditValue ?></span>
</span>
<input type="hidden" data-field="x_NumeroDeBultos" name="x<?php echo $remitos_list->RowIndex ?>_NumeroDeBultos" id="x<?php echo $remitos_list->RowIndex ?>_NumeroDeBultos" value="<?php echo ew_HtmlEncode($remitos->NumeroDeBultos->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->NumeroDeBultos->ViewAttributes() ?>>
<?php echo $remitos->NumeroDeBultos->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
		<td<?php echo $remitos->OperadorTraslado->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_OperadorTraslado" class="control-group remitos_OperadorTraslado">
<span<?php echo $remitos->OperadorTraslado->ViewAttributes() ?>>
<?php echo $remitos->OperadorTraslado->EditValue ?></span>
</span>
<input type="hidden" data-field="x_OperadorTraslado" name="x<?php echo $remitos_list->RowIndex ?>_OperadorTraslado" id="x<?php echo $remitos_list->RowIndex ?>_OperadorTraslado" value="<?php echo ew_HtmlEncode($remitos->OperadorTraslado->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->OperadorTraslado->ViewAttributes() ?>>
<?php echo $remitos->OperadorTraslado->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
		<td<?php echo $remitos->OperadorVerifico->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_OperadorVerifico" class="control-group remitos_OperadorVerifico">
<span<?php echo $remitos->OperadorVerifico->ViewAttributes() ?>>
<?php echo $remitos->OperadorVerifico->EditValue ?></span>
</span>
<input type="hidden" data-field="x_OperadorVerifico" name="x<?php echo $remitos_list->RowIndex ?>_OperadorVerifico" id="x<?php echo $remitos_list->RowIndex ?>_OperadorVerifico" value="<?php echo ew_HtmlEncode($remitos->OperadorVerifico->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->OperadorVerifico->ViewAttributes() ?>>
<?php echo $remitos->OperadorVerifico->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->Importe->Visible) { // Importe ?>
		<td<?php echo $remitos->Importe->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_Importe" class="control-group remitos_Importe">
<span<?php echo $remitos->Importe->ViewAttributes() ?>>
<?php echo $remitos->Importe->EditValue ?></span>
</span>
<input type="hidden" data-field="x_Importe" name="x<?php echo $remitos_list->RowIndex ?>_Importe" id="x<?php echo $remitos_list->RowIndex ?>_Importe" value="<?php echo ew_HtmlEncode($remitos->Importe->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->Importe->ViewAttributes() ?>>
<?php echo $remitos->Importe->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
		<td<?php echo $remitos->observacionesInternas->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_observacionesInternas" class="control-group remitos_observacionesInternas">
<input type="text" data-field="x_observacionesInternas" name="x<?php echo $remitos_list->RowIndex ?>_observacionesInternas" id="x<?php echo $remitos_list->RowIndex ?>_observacionesInternas" size="30" maxlength="255" placeholder="<?php echo $remitos->observacionesInternas->PlaceHolder ?>" value="<?php echo $remitos->observacionesInternas->EditValue ?>"<?php echo $remitos->observacionesInternas->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->observacionesInternas->ViewAttributes() ?>>
<?php echo $remitos->observacionesInternas->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->estado->Visible) { // estado ?>
		<td<?php echo $remitos->estado->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_estado" class="control-group remitos_estado">
<select data-field="x_estado" id="x<?php echo $remitos_list->RowIndex ?>_estado" name="x<?php echo $remitos_list->RowIndex ?>_estado"<?php echo $remitos->estado->EditAttributes() ?>>
<?php
if (is_array($remitos->estado->EditValue)) {
	$arwrk = $remitos->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->estado->ViewAttributes() ?>>
<?php echo $remitos->estado->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitos->resultado->Visible) { // resultado ?>
		<td<?php echo $remitos->resultado->CellAttributes() ?>>
<?php if ($remitos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_list->RowCnt ?>_remitos_resultado" class="control-group remitos_resultado">
<span<?php echo $remitos->resultado->ViewAttributes() ?>>
<?php echo $remitos->resultado->EditValue ?></span>
</span>
<input type="hidden" data-field="x_resultado" name="x<?php echo $remitos_list->RowIndex ?>_resultado" id="x<?php echo $remitos_list->RowIndex ?>_resultado" value="<?php echo ew_HtmlEncode($remitos->resultado->CurrentValue) ?>">
<?php } ?>
<?php if ($remitos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos->resultado->ViewAttributes() ?>>
<?php echo $remitos->resultado->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $remitos_list->PageObjName . "_row_" . $remitos_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$remitos_list->ListOptions->Render("body", "right", $remitos_list->RowCnt);
?>
	</tr>
<?php if ($remitos->RowType == EW_ROWTYPE_ADD || $remitos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fremitoslist.UpdateOpts(<?php echo $remitos_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($remitos->CurrentAction <> "gridadd")
		$remitos_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($remitos->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $remitos_list->FormKeyCountName ?>" id="<?php echo $remitos_list->FormKeyCountName ?>" value="<?php echo $remitos_list->KeyCount ?>">
<?php } ?>
<?php if ($remitos->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($remitos_list->Recordset)
	$remitos_list->Recordset->Close();
?>
</td></tr></table>
<?php if ($remitos->Export == "") { ?>
<script type="text/javascript">
fremitoslistsrch.Init();
fremitoslist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$remitos_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($remitos->Export == "") { ?>
<script type="text/javascript">
$(document).ready(function(){
var renglones = $("#tbl_remitoslist tbody tr").length;
var idclientes= new Array;
$("thead tr td:eq(1)").css("display","none");
for (var i = 1; i < renglones+1; i++) {

	//console.log(i);     
	var idregistro=($("#r"+i+"_remitos td:eq(1) span:eq(4)").text());

	//console.log(i);
	var orden=i-1;
	if($("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(4) span").attr("class")==undefined){
		var idcli=($("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(4) span").text());
	}else{
		var idcli=($("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(4) span span").text());
	}
	var idcli=idcli.replace("\n","");

	//console.log(idcli);
	idclientes.push(idcli);
	$(".ewView:eq("+orden+")").attr("href", "remitoimpreso.php?Id_Remito="+idregistro);
	$(".ewEdit:eq("+orden+")").attr("href", "remitoedit.php?Id_Remito="+idregistro);

	//$("thead tr td:eq(3)").css("display","none");
	//$("thead tr td:eq(6)").text("Destinatario");
	//$("thead tr td:eq(7)").css("display","none");
	//$("thead tr td:eq(2)").css("display","none");

	$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(1)").css("display","none");
	if($("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(5)").text()==0){
		$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(5)").text("");
	} 

	//$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(6)").text($("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(6)").text()+$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(7)").text());
	//$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(7)").css("display","none");
	//$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(1)").css("display","none");
	//$("#tbl_remitoslist tbody tr:eq("+orden+") td:eq(2)").css("display","none");

};
console.log(idclientes);
$.ajax({
  url: 'ajax/cliente.php',
  type: 'POST',
  dataType: 'json',
  data: {idclientes:idclientes},
  success: function(data) {

	//called when successful
	console.log(data);
	for (var i2 = 0; i2 < data.length; i2++) {
		if (data[i2]!=null) {
			$("#tbl_remitoslist tbody tr:eq("+i2+") td:eq(4) span").text($("#tbl_remitoslist tbody tr:eq("+i2+") td:eq(4) span").text()+"-"+data[i2]);    
		};    
	};

	//console.log(orden);
  },
  error: function(e) {

	//called when there is an error
	//console.log(e.message);

  }
});
$(".ewAdd").css("display","none");
$(".ewListOtherOptions .ewButtonGroup:eq(0)").append('<span data-name="button"><div class="btn-group ewButtonGroup"><a class="btn ewAddEdit btn-primary" href="remito.php">Agregar Remito</a></div></span>');
$(".ewListOtherOptions .ewButtonGroup:eq(0)").append($("#autoincrement").html());
$(".ewListOtherOptions .ewButtonGroup:eq(0)").css("display","flex");
$(".ewListOtherOptions").css("margin top","0px");
$(".ewListOtherOptions").css("margin bottom","0px");
$(".ewListOtherOptions").css("height","60px");
$("#autoincrement").css("display","none");

//Formato para selección de producto
	function formatResult(item) {
	  if(!item.id) {

		// return `text` for optgroup
		return item.text;
	  }

	  // Item Template cuando seleccionás
	  return '<span>'+item.id +'</span><span> '+item.detalle+'</span>';
	}

	function formatSelection(item) {

	  // Selection template cuando ya seleccionaste
	  return '<span>'+item.id +'</span><span> '+item.detalle+'</span>';
	}      
	$('#x_Cliente').select2({
		minimumInputLength: 2,//caracteres mínimos para empezar la búsqueda 
		ajax: {
			quietMillis: 500,//espera medio segundo de no escritura para buscar
			url: "ajax/optionlist.php",
			dataType: 'json',
			data: function (term, page) {
				return {  
					q: term,
					page:page,  
				};
			},
			results: function (data, page) {

				  //console.log(data);//ver los datos devueltos por el ajax
				  return {
					  results: data
				  };
			},
		},

	// Formatos
	formatResult: formatResult,
	formatSelection: formatSelection
});
$("#s2id_x_Cliente").css("width","400px");
});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$remitos_list->Page_Terminate();
?>
