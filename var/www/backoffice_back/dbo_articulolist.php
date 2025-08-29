<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dbo_articuloinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dbo_articulo_list = NULL; // Initialize page object first

class cdbo_articulo_list extends cdbo_articulo {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'dbo_articulo';

	// Page object name
	var $PageObjName = 'dbo_articulo_list';

	// Grid form hidden field names
	var $FormName = 'fdbo_articulolist';
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

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

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

		// Table object (dbo_articulo)
		if (!isset($GLOBALS["dbo_articulo"]) || get_class($GLOBALS["dbo_articulo"]) == "cdbo_articulo") {
			$GLOBALS["dbo_articulo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dbo_articulo"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "dbo_articuloadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "dbo_articulodelete.php";
		$this->MultiUpdateUrl = "dbo_articuloupdate.php";

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbo_articulo', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (walger_usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cwalger_usuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fdbo_articulolistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->CodInternoArti->SetVisibility();
		$this->CodBarraArti->SetVisibility();
		$this->idTipoArticulo->SetVisibility();
		$this->DescripcionArti->SetVisibility();
		$this->PrecioVta1_PreArti->SetVisibility();
		$this->Stock1_StkArti->SetVisibility();
		$this->NombreFotoArti->SetVisibility();
		$this->DescrNivelInt4->SetVisibility();
		$this->DescrNivelInt3->SetVisibility();
		$this->DescrNivelInt2->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $dbo_articulo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dbo_articulo);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
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
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
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

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

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

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
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
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
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
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->CodInternoArti->setFormValue($arrKeyFlds[0]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdbo_articulolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->CodInternoArti->AdvancedSearch->ToJSON(), ","); // Field CodInternoArti
		$sFilterList = ew_Concat($sFilterList, $this->CodBarraArti->AdvancedSearch->ToJSON(), ","); // Field CodBarraArti
		$sFilterList = ew_Concat($sFilterList, $this->idTipoArticulo->AdvancedSearch->ToJSON(), ","); // Field idTipoArticulo
		$sFilterList = ew_Concat($sFilterList, $this->DescripcionArti->AdvancedSearch->ToJSON(), ","); // Field DescripcionArti
		$sFilterList = ew_Concat($sFilterList, $this->detalle->AdvancedSearch->ToJSON(), ","); // Field detalle
		$sFilterList = ew_Concat($sFilterList, $this->PrecioVta1_PreArti->AdvancedSearch->ToJSON(), ","); // Field PrecioVta1_PreArti
		$sFilterList = ew_Concat($sFilterList, $this->Stock1_StkArti->AdvancedSearch->ToJSON(), ","); // Field Stock1_StkArti
		$sFilterList = ew_Concat($sFilterList, $this->NombreFotoArti->AdvancedSearch->ToJSON(), ","); // Field NombreFotoArti
		$sFilterList = ew_Concat($sFilterList, $this->DescrNivelInt4->AdvancedSearch->ToJSON(), ","); // Field DescrNivelInt4
		$sFilterList = ew_Concat($sFilterList, $this->DescrNivelInt3->AdvancedSearch->ToJSON(), ","); // Field DescrNivelInt3
		$sFilterList = ew_Concat($sFilterList, $this->DescrNivelInt2->AdvancedSearch->ToJSON(), ","); // Field DescrNivelInt2
		$sFilterList = ew_Concat($sFilterList, $this->TasaIva->AdvancedSearch->ToJSON(), ","); // Field TasaIva
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["cmd"] == "savefilters") {
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdbo_articulolistsrch", $filters);
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field CodInternoArti
		$this->CodInternoArti->AdvancedSearch->SearchValue = @$filter["x_CodInternoArti"];
		$this->CodInternoArti->AdvancedSearch->SearchOperator = @$filter["z_CodInternoArti"];
		$this->CodInternoArti->AdvancedSearch->SearchCondition = @$filter["v_CodInternoArti"];
		$this->CodInternoArti->AdvancedSearch->SearchValue2 = @$filter["y_CodInternoArti"];
		$this->CodInternoArti->AdvancedSearch->SearchOperator2 = @$filter["w_CodInternoArti"];
		$this->CodInternoArti->AdvancedSearch->Save();

		// Field CodBarraArti
		$this->CodBarraArti->AdvancedSearch->SearchValue = @$filter["x_CodBarraArti"];
		$this->CodBarraArti->AdvancedSearch->SearchOperator = @$filter["z_CodBarraArti"];
		$this->CodBarraArti->AdvancedSearch->SearchCondition = @$filter["v_CodBarraArti"];
		$this->CodBarraArti->AdvancedSearch->SearchValue2 = @$filter["y_CodBarraArti"];
		$this->CodBarraArti->AdvancedSearch->SearchOperator2 = @$filter["w_CodBarraArti"];
		$this->CodBarraArti->AdvancedSearch->Save();

		// Field idTipoArticulo
		$this->idTipoArticulo->AdvancedSearch->SearchValue = @$filter["x_idTipoArticulo"];
		$this->idTipoArticulo->AdvancedSearch->SearchOperator = @$filter["z_idTipoArticulo"];
		$this->idTipoArticulo->AdvancedSearch->SearchCondition = @$filter["v_idTipoArticulo"];
		$this->idTipoArticulo->AdvancedSearch->SearchValue2 = @$filter["y_idTipoArticulo"];
		$this->idTipoArticulo->AdvancedSearch->SearchOperator2 = @$filter["w_idTipoArticulo"];
		$this->idTipoArticulo->AdvancedSearch->Save();

		// Field DescripcionArti
		$this->DescripcionArti->AdvancedSearch->SearchValue = @$filter["x_DescripcionArti"];
		$this->DescripcionArti->AdvancedSearch->SearchOperator = @$filter["z_DescripcionArti"];
		$this->DescripcionArti->AdvancedSearch->SearchCondition = @$filter["v_DescripcionArti"];
		$this->DescripcionArti->AdvancedSearch->SearchValue2 = @$filter["y_DescripcionArti"];
		$this->DescripcionArti->AdvancedSearch->SearchOperator2 = @$filter["w_DescripcionArti"];
		$this->DescripcionArti->AdvancedSearch->Save();

		// Field detalle
		$this->detalle->AdvancedSearch->SearchValue = @$filter["x_detalle"];
		$this->detalle->AdvancedSearch->SearchOperator = @$filter["z_detalle"];
		$this->detalle->AdvancedSearch->SearchCondition = @$filter["v_detalle"];
		$this->detalle->AdvancedSearch->SearchValue2 = @$filter["y_detalle"];
		$this->detalle->AdvancedSearch->SearchOperator2 = @$filter["w_detalle"];
		$this->detalle->AdvancedSearch->Save();

		// Field PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->AdvancedSearch->SearchValue = @$filter["x_PrecioVta1_PreArti"];
		$this->PrecioVta1_PreArti->AdvancedSearch->SearchOperator = @$filter["z_PrecioVta1_PreArti"];
		$this->PrecioVta1_PreArti->AdvancedSearch->SearchCondition = @$filter["v_PrecioVta1_PreArti"];
		$this->PrecioVta1_PreArti->AdvancedSearch->SearchValue2 = @$filter["y_PrecioVta1_PreArti"];
		$this->PrecioVta1_PreArti->AdvancedSearch->SearchOperator2 = @$filter["w_PrecioVta1_PreArti"];
		$this->PrecioVta1_PreArti->AdvancedSearch->Save();

		// Field Stock1_StkArti
		$this->Stock1_StkArti->AdvancedSearch->SearchValue = @$filter["x_Stock1_StkArti"];
		$this->Stock1_StkArti->AdvancedSearch->SearchOperator = @$filter["z_Stock1_StkArti"];
		$this->Stock1_StkArti->AdvancedSearch->SearchCondition = @$filter["v_Stock1_StkArti"];
		$this->Stock1_StkArti->AdvancedSearch->SearchValue2 = @$filter["y_Stock1_StkArti"];
		$this->Stock1_StkArti->AdvancedSearch->SearchOperator2 = @$filter["w_Stock1_StkArti"];
		$this->Stock1_StkArti->AdvancedSearch->Save();

		// Field NombreFotoArti
		$this->NombreFotoArti->AdvancedSearch->SearchValue = @$filter["x_NombreFotoArti"];
		$this->NombreFotoArti->AdvancedSearch->SearchOperator = @$filter["z_NombreFotoArti"];
		$this->NombreFotoArti->AdvancedSearch->SearchCondition = @$filter["v_NombreFotoArti"];
		$this->NombreFotoArti->AdvancedSearch->SearchValue2 = @$filter["y_NombreFotoArti"];
		$this->NombreFotoArti->AdvancedSearch->SearchOperator2 = @$filter["w_NombreFotoArti"];
		$this->NombreFotoArti->AdvancedSearch->Save();

		// Field DescrNivelInt4
		$this->DescrNivelInt4->AdvancedSearch->SearchValue = @$filter["x_DescrNivelInt4"];
		$this->DescrNivelInt4->AdvancedSearch->SearchOperator = @$filter["z_DescrNivelInt4"];
		$this->DescrNivelInt4->AdvancedSearch->SearchCondition = @$filter["v_DescrNivelInt4"];
		$this->DescrNivelInt4->AdvancedSearch->SearchValue2 = @$filter["y_DescrNivelInt4"];
		$this->DescrNivelInt4->AdvancedSearch->SearchOperator2 = @$filter["w_DescrNivelInt4"];
		$this->DescrNivelInt4->AdvancedSearch->Save();

		// Field DescrNivelInt3
		$this->DescrNivelInt3->AdvancedSearch->SearchValue = @$filter["x_DescrNivelInt3"];
		$this->DescrNivelInt3->AdvancedSearch->SearchOperator = @$filter["z_DescrNivelInt3"];
		$this->DescrNivelInt3->AdvancedSearch->SearchCondition = @$filter["v_DescrNivelInt3"];
		$this->DescrNivelInt3->AdvancedSearch->SearchValue2 = @$filter["y_DescrNivelInt3"];
		$this->DescrNivelInt3->AdvancedSearch->SearchOperator2 = @$filter["w_DescrNivelInt3"];
		$this->DescrNivelInt3->AdvancedSearch->Save();

		// Field DescrNivelInt2
		$this->DescrNivelInt2->AdvancedSearch->SearchValue = @$filter["x_DescrNivelInt2"];
		$this->DescrNivelInt2->AdvancedSearch->SearchOperator = @$filter["z_DescrNivelInt2"];
		$this->DescrNivelInt2->AdvancedSearch->SearchCondition = @$filter["v_DescrNivelInt2"];
		$this->DescrNivelInt2->AdvancedSearch->SearchValue2 = @$filter["y_DescrNivelInt2"];
		$this->DescrNivelInt2->AdvancedSearch->SearchOperator2 = @$filter["w_DescrNivelInt2"];
		$this->DescrNivelInt2->AdvancedSearch->Save();

		// Field TasaIva
		$this->TasaIva->AdvancedSearch->SearchValue = @$filter["x_TasaIva"];
		$this->TasaIva->AdvancedSearch->SearchOperator = @$filter["z_TasaIva"];
		$this->TasaIva->AdvancedSearch->SearchCondition = @$filter["v_TasaIva"];
		$this->TasaIva->AdvancedSearch->SearchValue2 = @$filter["y_TasaIva"];
		$this->TasaIva->AdvancedSearch->SearchOperator2 = @$filter["w_TasaIva"];
		$this->TasaIva->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->CodInternoArti, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CodBarraArti, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescripcionArti, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->detalle, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NombreFotoArti, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescrNivelInt4, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescrNivelInt3, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescrNivelInt2, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
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
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->CodInternoArti, $bCtrl); // CodInternoArti
			$this->UpdateSort($this->CodBarraArti, $bCtrl); // CodBarraArti
			$this->UpdateSort($this->idTipoArticulo, $bCtrl); // idTipoArticulo
			$this->UpdateSort($this->DescripcionArti, $bCtrl); // DescripcionArti
			$this->UpdateSort($this->PrecioVta1_PreArti, $bCtrl); // PrecioVta1_PreArti
			$this->UpdateSort($this->Stock1_StkArti, $bCtrl); // Stock1_StkArti
			$this->UpdateSort($this->NombreFotoArti, $bCtrl); // NombreFotoArti
			$this->UpdateSort($this->DescrNivelInt4, $bCtrl); // DescrNivelInt4
			$this->UpdateSort($this->DescrNivelInt3, $bCtrl); // DescrNivelInt3
			$this->UpdateSort($this->DescrNivelInt2, $bCtrl); // DescrNivelInt2
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->CodInternoArti->setSort("ASC");
				$this->CodBarraArti->setSort("ASC");
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
				$this->CodInternoArti->setSort("");
				$this->CodBarraArti->setSort("");
				$this->idTipoArticulo->setSort("");
				$this->DescripcionArti->setSort("");
				$this->PrecioVta1_PreArti->setSort("");
				$this->Stock1_StkArti->setSort("");
				$this->NombreFotoArti->setSort("");
				$this->DescrNivelInt4->setSort("");
				$this->DescrNivelInt3->setSort("");
				$this->DescrNivelInt2->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->CodInternoArti->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdbo_articulolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdbo_articulolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdbo_articulolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdbo_articulolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
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
		$this->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
		$this->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
		$this->idTipoArticulo->setDbValue($rs->fields('idTipoArticulo'));
		$this->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
		$this->detalle->setDbValue($rs->fields('detalle'));
		$this->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
		$this->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
		$this->NombreFotoArti->Upload->DbValue = $rs->fields('NombreFotoArti');
		$this->NombreFotoArti->CurrentValue = $this->NombreFotoArti->Upload->DbValue;
		$this->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
		$this->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
		$this->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
		$this->TasaIva->setDbValue($rs->fields('TasaIva'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CodInternoArti->DbValue = $row['CodInternoArti'];
		$this->CodBarraArti->DbValue = $row['CodBarraArti'];
		$this->idTipoArticulo->DbValue = $row['idTipoArticulo'];
		$this->DescripcionArti->DbValue = $row['DescripcionArti'];
		$this->detalle->DbValue = $row['detalle'];
		$this->PrecioVta1_PreArti->DbValue = $row['PrecioVta1_PreArti'];
		$this->Stock1_StkArti->DbValue = $row['Stock1_StkArti'];
		$this->NombreFotoArti->Upload->DbValue = $row['NombreFotoArti'];
		$this->DescrNivelInt4->DbValue = $row['DescrNivelInt4'];
		$this->DescrNivelInt3->DbValue = $row['DescrNivelInt3'];
		$this->DescrNivelInt2->DbValue = $row['DescrNivelInt2'];
		$this->TasaIva->DbValue = $row['TasaIva'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CodInternoArti")) <> "")
			$this->CodInternoArti->CurrentValue = $this->getKey("CodInternoArti"); // CodInternoArti
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->PrecioVta1_PreArti->FormValue == $this->PrecioVta1_PreArti->CurrentValue && is_numeric(ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue)))
			$this->PrecioVta1_PreArti->CurrentValue = ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Stock1_StkArti->FormValue == $this->Stock1_StkArti->CurrentValue && is_numeric(ew_StrToFloat($this->Stock1_StkArti->CurrentValue)))
			$this->Stock1_StkArti->CurrentValue = ew_StrToFloat($this->Stock1_StkArti->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// CodInternoArti

		$this->CodInternoArti->CellCssStyle = "white-space: nowrap;";

		// CodBarraArti
		$this->CodBarraArti->CellCssStyle = "white-space: nowrap;";

		// idTipoArticulo
		// DescripcionArti

		$this->DescripcionArti->CellCssStyle = "white-space: nowrap;";

		// detalle
		// PrecioVta1_PreArti

		$this->PrecioVta1_PreArti->CellCssStyle = "white-space: nowrap;";

		// Stock1_StkArti
		$this->Stock1_StkArti->CellCssStyle = "white-space: nowrap;";

		// NombreFotoArti
		$this->NombreFotoArti->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt4
		$this->DescrNivelInt4->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt3
		$this->DescrNivelInt3->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt2
		$this->DescrNivelInt2->CellCssStyle = "white-space: nowrap;";

		// TasaIva
		$this->TasaIva->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		$this->CodInternoArti->ViewValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$this->CodBarraArti->ViewValue = $this->CodBarraArti->CurrentValue;
		$this->CodBarraArti->ViewCustomAttributes = "";

		// idTipoArticulo
		if (strval($this->idTipoArticulo->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->idTipoArticulo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_tipos-articulos`";
		$sWhereWrk = "";
		$this->idTipoArticulo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idTipoArticulo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->CurrentValue;
			}
		} else {
			$this->idTipoArticulo->ViewValue = NULL;
		}
		$this->idTipoArticulo->ViewCustomAttributes = "";

		// DescripcionArti
		$this->DescripcionArti->ViewValue = $this->DescripcionArti->CurrentValue;
		$this->DescripcionArti->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->ViewValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->PrecioVta1_PreArti->ViewValue = ew_FormatNumber($this->PrecioVta1_PreArti->ViewValue, 2, -1, 0, 0);
		$this->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->ViewValue = $this->Stock1_StkArti->CurrentValue;
		$this->Stock1_StkArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$this->NombreFotoArti->UploadPath = "../articulos/";
		if (!ew_Empty($this->NombreFotoArti->Upload->DbValue)) {
			$this->NombreFotoArti->ViewValue = $this->NombreFotoArti->Upload->DbValue;
		} else {
			$this->NombreFotoArti->ViewValue = "";
		}
		$this->NombreFotoArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->ViewValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->ViewValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->ViewValue = $this->DescrNivelInt2->CurrentValue;
		$this->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$this->TasaIva->ViewValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->ViewValue = ew_FormatNumber($this->TasaIva->ViewValue, 2, -1, 0, 0);
		$this->TasaIva->ViewCustomAttributes = "";

			// CodInternoArti
			$this->CodInternoArti->LinkCustomAttributes = "";
			$this->CodInternoArti->HrefValue = "";
			$this->CodInternoArti->TooltipValue = "";

			// CodBarraArti
			$this->CodBarraArti->LinkCustomAttributes = "";
			$this->CodBarraArti->HrefValue = "";
			$this->CodBarraArti->TooltipValue = "";

			// idTipoArticulo
			$this->idTipoArticulo->LinkCustomAttributes = "";
			$this->idTipoArticulo->HrefValue = "";
			$this->idTipoArticulo->TooltipValue = "";

			// DescripcionArti
			$this->DescripcionArti->LinkCustomAttributes = "";
			$this->DescripcionArti->HrefValue = "";
			$this->DescripcionArti->TooltipValue = "";

			// PrecioVta1_PreArti
			$this->PrecioVta1_PreArti->LinkCustomAttributes = "";
			$this->PrecioVta1_PreArti->HrefValue = "";
			$this->PrecioVta1_PreArti->TooltipValue = "";

			// Stock1_StkArti
			$this->Stock1_StkArti->LinkCustomAttributes = "";
			$this->Stock1_StkArti->HrefValue = "";
			$this->Stock1_StkArti->TooltipValue = "";

			// NombreFotoArti
			$this->NombreFotoArti->LinkCustomAttributes = "";
			$this->NombreFotoArti->HrefValue = "";
			$this->NombreFotoArti->HrefValue2 = $this->NombreFotoArti->UploadPath . $this->NombreFotoArti->Upload->DbValue;
			$this->NombreFotoArti->TooltipValue = "";

			// DescrNivelInt4
			$this->DescrNivelInt4->LinkCustomAttributes = "";
			$this->DescrNivelInt4->HrefValue = "";
			$this->DescrNivelInt4->TooltipValue = "";

			// DescrNivelInt3
			$this->DescrNivelInt3->LinkCustomAttributes = "";
			$this->DescrNivelInt3->HrefValue = "";
			$this->DescrNivelInt3->TooltipValue = "";

			// DescrNivelInt2
			$this->DescrNivelInt2->LinkCustomAttributes = "";
			$this->DescrNivelInt2->HrefValue = "";
			$this->DescrNivelInt2->TooltipValue = "";
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
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_dbo_articulo\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dbo_articulo',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdbo_articulolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
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
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
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
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
		global $dbo_articulo_read_only;
		$this->OtherOptions["addedit"]->Items["add"]->Visible = !$dbo_articulo_read_only;
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {
		global $dbo_articulo_tipo_articulo_visible;
		$this->idTipoArticulo->Visible = $dbo_articulo_tipo_articulo_visible;
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
		global $dbo_articulo_read_only;
		$this->ListOptions->Items["edit"]->Visible = !$dbo_articulo_read_only;
		$this->ListOptions->Items["delete"]->Visible = !$dbo_articulo_read_only;
	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($dbo_articulo_list)) $dbo_articulo_list = new cdbo_articulo_list();

// Page init
$dbo_articulo_list->Page_Init();

// Page main
$dbo_articulo_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_articulo_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($dbo_articulo->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdbo_articulolist = new ew_Form("fdbo_articulolist", "list");
fdbo_articulolist.FormKeyCountName = '<?php echo $dbo_articulo_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdbo_articulolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_articulolist.ValidateRequired = true;
<?php } else { ?>
fdbo_articulolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdbo_articulolist.Lists["x_idTipoArticulo"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_tipos2Darticulos"};

// Form object for search
var CurrentSearchForm = fdbo_articulolistsrch = new ew_Form("fdbo_articulolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<div class="ewToolbar">
<?php if ($dbo_articulo->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($dbo_articulo_list->TotalRecs > 0 && $dbo_articulo_list->ExportOptions->Visible()) { ?>
<?php $dbo_articulo_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_articulo_list->SearchOptions->Visible()) { ?>
<?php $dbo_articulo_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_articulo_list->FilterOptions->Visible()) { ?>
<?php $dbo_articulo_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $dbo_articulo_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($dbo_articulo_list->TotalRecs <= 0)
			$dbo_articulo_list->TotalRecs = $dbo_articulo->SelectRecordCount();
	} else {
		if (!$dbo_articulo_list->Recordset && ($dbo_articulo_list->Recordset = $dbo_articulo_list->LoadRecordset()))
			$dbo_articulo_list->TotalRecs = $dbo_articulo_list->Recordset->RecordCount();
	}
	$dbo_articulo_list->StartRec = 1;
	if ($dbo_articulo_list->DisplayRecs <= 0 || ($dbo_articulo->Export <> "" && $dbo_articulo->ExportAll)) // Display all records
		$dbo_articulo_list->DisplayRecs = $dbo_articulo_list->TotalRecs;
	if (!($dbo_articulo->Export <> "" && $dbo_articulo->ExportAll))
		$dbo_articulo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$dbo_articulo_list->Recordset = $dbo_articulo_list->LoadRecordset($dbo_articulo_list->StartRec-1, $dbo_articulo_list->DisplayRecs);

	// Set no record found message
	if ($dbo_articulo->CurrentAction == "" && $dbo_articulo_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$dbo_articulo_list->setWarningMessage(ew_DeniedMsg());
		if ($dbo_articulo_list->SearchWhere == "0=101")
			$dbo_articulo_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$dbo_articulo_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$dbo_articulo_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($dbo_articulo->Export == "" && $dbo_articulo->CurrentAction == "") { ?>
<form name="fdbo_articulolistsrch" id="fdbo_articulolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($dbo_articulo_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdbo_articulolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="dbo_articulo">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($dbo_articulo_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($dbo_articulo_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $dbo_articulo_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($dbo_articulo_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($dbo_articulo_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($dbo_articulo_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($dbo_articulo_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $dbo_articulo_list->ShowPageHeader(); ?>
<?php
$dbo_articulo_list->ShowMessage();
?>
<?php if ($dbo_articulo_list->TotalRecs > 0 || $dbo_articulo->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid dbo_articulo">
<?php if ($dbo_articulo->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($dbo_articulo->CurrentAction <> "gridadd" && $dbo_articulo->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($dbo_articulo_list->Pager)) $dbo_articulo_list->Pager = new cPrevNextPager($dbo_articulo_list->StartRec, $dbo_articulo_list->DisplayRecs, $dbo_articulo_list->TotalRecs) ?>
<?php if ($dbo_articulo_list->Pager->RecordCount > 0 && $dbo_articulo_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($dbo_articulo_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $dbo_articulo_list->PageUrl() ?>start=<?php echo $dbo_articulo_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($dbo_articulo_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $dbo_articulo_list->PageUrl() ?>start=<?php echo $dbo_articulo_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dbo_articulo_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($dbo_articulo_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $dbo_articulo_list->PageUrl() ?>start=<?php echo $dbo_articulo_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($dbo_articulo_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $dbo_articulo_list->PageUrl() ?>start=<?php echo $dbo_articulo_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $dbo_articulo_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $dbo_articulo_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $dbo_articulo_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $dbo_articulo_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($dbo_articulo_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="dbo_articulo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($dbo_articulo_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($dbo_articulo_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="40"<?php if ($dbo_articulo_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="80"<?php if ($dbo_articulo_list->DisplayRecs == 80) { ?> selected<?php } ?>>80</option>
<option value="160"<?php if ($dbo_articulo_list->DisplayRecs == 160) { ?> selected<?php } ?>>160</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dbo_articulo_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdbo_articulolist" id="fdbo_articulolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dbo_articulo_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dbo_articulo_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dbo_articulo">
<div id="gmp_dbo_articulo" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($dbo_articulo_list->TotalRecs > 0) { ?>
<table id="tbl_dbo_articulolist" class="table ewTable">
<?php echo $dbo_articulo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$dbo_articulo_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$dbo_articulo_list->RenderListOptions();

// Render list options (header, left)
$dbo_articulo_list->ListOptions->Render("header", "left");
?>
<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->CodInternoArti) == "") { ?>
		<th data-name="CodInternoArti"><div id="elh_dbo_articulo_CodInternoArti" class="dbo_articulo_CodInternoArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->CodInternoArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CodInternoArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->CodInternoArti) ?>',2);"><div id="elh_dbo_articulo_CodInternoArti" class="dbo_articulo_CodInternoArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->CodInternoArti->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->CodInternoArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->CodInternoArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->CodBarraArti) == "") { ?>
		<th data-name="CodBarraArti"><div id="elh_dbo_articulo_CodBarraArti" class="dbo_articulo_CodBarraArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->CodBarraArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CodBarraArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->CodBarraArti) ?>',2);"><div id="elh_dbo_articulo_CodBarraArti" class="dbo_articulo_CodBarraArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->CodBarraArti->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->CodBarraArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->CodBarraArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->idTipoArticulo) == "") { ?>
		<th data-name="idTipoArticulo"><div id="elh_dbo_articulo_idTipoArticulo" class="dbo_articulo_idTipoArticulo"><div class="ewTableHeaderCaption"><?php echo $dbo_articulo->idTipoArticulo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idTipoArticulo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->idTipoArticulo) ?>',2);"><div id="elh_dbo_articulo_idTipoArticulo" class="dbo_articulo_idTipoArticulo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->idTipoArticulo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->idTipoArticulo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->idTipoArticulo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->DescripcionArti) == "") { ?>
		<th data-name="DescripcionArti"><div id="elh_dbo_articulo_DescripcionArti" class="dbo_articulo_DescripcionArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->DescripcionArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescripcionArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->DescripcionArti) ?>',2);"><div id="elh_dbo_articulo_DescripcionArti" class="dbo_articulo_DescripcionArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->DescripcionArti->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->DescripcionArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->DescripcionArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->PrecioVta1_PreArti) == "") { ?>
		<th data-name="PrecioVta1_PreArti"><div id="elh_dbo_articulo_PrecioVta1_PreArti" class="dbo_articulo_PrecioVta1_PreArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->PrecioVta1_PreArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PrecioVta1_PreArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->PrecioVta1_PreArti) ?>',2);"><div id="elh_dbo_articulo_PrecioVta1_PreArti" class="dbo_articulo_PrecioVta1_PreArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->PrecioVta1_PreArti->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->PrecioVta1_PreArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->PrecioVta1_PreArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->Stock1_StkArti) == "") { ?>
		<th data-name="Stock1_StkArti"><div id="elh_dbo_articulo_Stock1_StkArti" class="dbo_articulo_Stock1_StkArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->Stock1_StkArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Stock1_StkArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->Stock1_StkArti) ?>',2);"><div id="elh_dbo_articulo_Stock1_StkArti" class="dbo_articulo_Stock1_StkArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->Stock1_StkArti->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->Stock1_StkArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->Stock1_StkArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->NombreFotoArti) == "") { ?>
		<th data-name="NombreFotoArti"><div id="elh_dbo_articulo_NombreFotoArti" class="dbo_articulo_NombreFotoArti"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->NombreFotoArti->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NombreFotoArti"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->NombreFotoArti) ?>',2);"><div id="elh_dbo_articulo_NombreFotoArti" class="dbo_articulo_NombreFotoArti">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->NombreFotoArti->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->NombreFotoArti->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->NombreFotoArti->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt4) == "") { ?>
		<th data-name="DescrNivelInt4"><div id="elh_dbo_articulo_DescrNivelInt4" class="dbo_articulo_DescrNivelInt4"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->DescrNivelInt4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescrNivelInt4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt4) ?>',2);"><div id="elh_dbo_articulo_DescrNivelInt4" class="dbo_articulo_DescrNivelInt4">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->DescrNivelInt4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->DescrNivelInt4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->DescrNivelInt4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt3) == "") { ?>
		<th data-name="DescrNivelInt3"><div id="elh_dbo_articulo_DescrNivelInt3" class="dbo_articulo_DescrNivelInt3"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->DescrNivelInt3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescrNivelInt3"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt3) ?>',2);"><div id="elh_dbo_articulo_DescrNivelInt3" class="dbo_articulo_DescrNivelInt3">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->DescrNivelInt3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->DescrNivelInt3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->DescrNivelInt3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
	<?php if ($dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt2) == "") { ?>
		<th data-name="DescrNivelInt2"><div id="elh_dbo_articulo_DescrNivelInt2" class="dbo_articulo_DescrNivelInt2"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_articulo->DescrNivelInt2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescrNivelInt2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_articulo->SortUrl($dbo_articulo->DescrNivelInt2) ?>',2);"><div id="elh_dbo_articulo_DescrNivelInt2" class="dbo_articulo_DescrNivelInt2">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_articulo->DescrNivelInt2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_articulo->DescrNivelInt2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_articulo->DescrNivelInt2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$dbo_articulo_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($dbo_articulo->ExportAll && $dbo_articulo->Export <> "") {
	$dbo_articulo_list->StopRec = $dbo_articulo_list->TotalRecs;
} else {

	// Set the last record to display
	if ($dbo_articulo_list->TotalRecs > $dbo_articulo_list->StartRec + $dbo_articulo_list->DisplayRecs - 1)
		$dbo_articulo_list->StopRec = $dbo_articulo_list->StartRec + $dbo_articulo_list->DisplayRecs - 1;
	else
		$dbo_articulo_list->StopRec = $dbo_articulo_list->TotalRecs;
}
$dbo_articulo_list->RecCnt = $dbo_articulo_list->StartRec - 1;
if ($dbo_articulo_list->Recordset && !$dbo_articulo_list->Recordset->EOF) {
	$dbo_articulo_list->Recordset->MoveFirst();
	$bSelectLimit = $dbo_articulo_list->UseSelectLimit;
	if (!$bSelectLimit && $dbo_articulo_list->StartRec > 1)
		$dbo_articulo_list->Recordset->Move($dbo_articulo_list->StartRec - 1);
} elseif (!$dbo_articulo->AllowAddDeleteRow && $dbo_articulo_list->StopRec == 0) {
	$dbo_articulo_list->StopRec = $dbo_articulo->GridAddRowCount;
}

// Initialize aggregate
$dbo_articulo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$dbo_articulo->ResetAttrs();
$dbo_articulo_list->RenderRow();
while ($dbo_articulo_list->RecCnt < $dbo_articulo_list->StopRec) {
	$dbo_articulo_list->RecCnt++;
	if (intval($dbo_articulo_list->RecCnt) >= intval($dbo_articulo_list->StartRec)) {
		$dbo_articulo_list->RowCnt++;

		// Set up key count
		$dbo_articulo_list->KeyCount = $dbo_articulo_list->RowIndex;

		// Init row class and style
		$dbo_articulo->ResetAttrs();
		$dbo_articulo->CssClass = "";
		if ($dbo_articulo->CurrentAction == "gridadd") {
		} else {
			$dbo_articulo_list->LoadRowValues($dbo_articulo_list->Recordset); // Load row values
		}
		$dbo_articulo->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$dbo_articulo->RowAttrs = array_merge($dbo_articulo->RowAttrs, array('data-rowindex'=>$dbo_articulo_list->RowCnt, 'id'=>'r' . $dbo_articulo_list->RowCnt . '_dbo_articulo', 'data-rowtype'=>$dbo_articulo->RowType));

		// Render row
		$dbo_articulo_list->RenderRow();

		// Render list options
		$dbo_articulo_list->RenderListOptions();
?>
	<tr<?php echo $dbo_articulo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$dbo_articulo_list->ListOptions->Render("body", "left", $dbo_articulo_list->RowCnt);
?>
	<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
		<td data-name="CodInternoArti"<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_CodInternoArti" class="dbo_articulo_CodInternoArti">
<span<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodInternoArti->ListViewValue() ?></span>
</span>
<a id="<?php echo $dbo_articulo_list->PageObjName . "_row_" . $dbo_articulo_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
		<td data-name="CodBarraArti"<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_CodBarraArti" class="dbo_articulo_CodBarraArti">
<span<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodBarraArti->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
		<td data-name="idTipoArticulo"<?php echo $dbo_articulo->idTipoArticulo->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_idTipoArticulo" class="dbo_articulo_idTipoArticulo">
<span<?php echo $dbo_articulo->idTipoArticulo->ViewAttributes() ?>>
<?php echo $dbo_articulo->idTipoArticulo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
		<td data-name="DescripcionArti"<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_DescripcionArti" class="dbo_articulo_DescripcionArti">
<span<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescripcionArti->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
		<td data-name="PrecioVta1_PreArti"<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_PrecioVta1_PreArti" class="dbo_articulo_PrecioVta1_PreArti">
<span<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->PrecioVta1_PreArti->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
		<td data-name="Stock1_StkArti"<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_Stock1_StkArti" class="dbo_articulo_Stock1_StkArti">
<span<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->Stock1_StkArti->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
		<td data-name="NombreFotoArti"<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_NombreFotoArti" class="dbo_articulo_NombreFotoArti">
<span<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($dbo_articulo->NombreFotoArti, $dbo_articulo->NombreFotoArti->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
		<td data-name="DescrNivelInt4"<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_DescrNivelInt4" class="dbo_articulo_DescrNivelInt4">
<span<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
		<td data-name="DescrNivelInt3"<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_DescrNivelInt3" class="dbo_articulo_DescrNivelInt3">
<span<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
		<td data-name="DescrNivelInt2"<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_list->RowCnt ?>_dbo_articulo_DescrNivelInt2" class="dbo_articulo_DescrNivelInt2">
<span<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$dbo_articulo_list->ListOptions->Render("body", "right", $dbo_articulo_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($dbo_articulo->CurrentAction <> "gridadd")
		$dbo_articulo_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($dbo_articulo->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($dbo_articulo_list->Recordset)
	$dbo_articulo_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($dbo_articulo_list->TotalRecs == 0 && $dbo_articulo->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dbo_articulo_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<script type="text/javascript">
fdbo_articulolistsrch.FilterList = <?php echo $dbo_articulo_list->GetFilterList() ?>;
fdbo_articulolistsrch.Init();
fdbo_articulolist.Init();
</script>
<?php } ?>
<?php
$dbo_articulo_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($dbo_articulo->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
var dbo_articulo_read_only = <?PHP echo($dbo_articulo_read_only); ?>;
if (dbo_articulo_read_only)
{
	$(".ewListOptionHeader").hide();
	$(".ewListOptionBody").hide();
}
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$dbo_articulo_list->Page_Terminate();
?>
