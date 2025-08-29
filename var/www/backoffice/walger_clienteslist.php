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

$walger_clientes_list = NULL; // Initialize page object first

class cwalger_clientes_list extends cwalger_clientes {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'walger_clientes';

	// Page object name
	var $PageObjName = 'walger_clientes_list';

	// Grid form hidden field names
	var $FormName = 'fwalger_clienteslist';
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

		// Table object (walger_clientes)
		if (!isset($GLOBALS["walger_clientes"]) || get_class($GLOBALS["walger_clientes"]) == "cwalger_clientes") {
			$GLOBALS["walger_clientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["walger_clientes"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "walger_clientesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "walger_clientesdelete.php";
		$this->MultiUpdateUrl = "walger_clientesupdate.php";

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fwalger_clienteslistsrch";

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
			$this->CodigoCli->setFormValue($arrKeyFlds[0]);
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fwalger_clienteslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->CodigoCli->AdvancedSearch->ToJSON(), ","); // Field CodigoCli
		$sFilterList = ew_Concat($sFilterList, $this->Contrasenia->AdvancedSearch->ToJSON(), ","); // Field Contrasenia
		$sFilterList = ew_Concat($sFilterList, $this->Habilitado->AdvancedSearch->ToJSON(), ","); // Field Habilitado
		$sFilterList = ew_Concat($sFilterList, $this->IP->AdvancedSearch->ToJSON(), ","); // Field IP
		$sFilterList = ew_Concat($sFilterList, $this->UltimoLogin->AdvancedSearch->ToJSON(), ","); // Field UltimoLogin
		$sFilterList = ew_Concat($sFilterList, $this->TipoCliente->AdvancedSearch->ToJSON(), ","); // Field TipoCliente
		$sFilterList = ew_Concat($sFilterList, $this->Regis_Mda->AdvancedSearch->ToJSON(), ","); // Field Regis_Mda
		$sFilterList = ew_Concat($sFilterList, $this->ApellidoNombre->AdvancedSearch->ToJSON(), ","); // Field ApellidoNombre
		$sFilterList = ew_Concat($sFilterList, $this->Cargo->AdvancedSearch->ToJSON(), ","); // Field Cargo
		$sFilterList = ew_Concat($sFilterList, $this->Comentarios->AdvancedSearch->ToJSON(), ","); // Field Comentarios
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fwalger_clienteslistsrch", $filters);
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

		// Field CodigoCli
		$this->CodigoCli->AdvancedSearch->SearchValue = @$filter["x_CodigoCli"];
		$this->CodigoCli->AdvancedSearch->SearchOperator = @$filter["z_CodigoCli"];
		$this->CodigoCli->AdvancedSearch->SearchCondition = @$filter["v_CodigoCli"];
		$this->CodigoCli->AdvancedSearch->SearchValue2 = @$filter["y_CodigoCli"];
		$this->CodigoCli->AdvancedSearch->SearchOperator2 = @$filter["w_CodigoCli"];
		$this->CodigoCli->AdvancedSearch->Save();

		// Field Contrasenia
		$this->Contrasenia->AdvancedSearch->SearchValue = @$filter["x_Contrasenia"];
		$this->Contrasenia->AdvancedSearch->SearchOperator = @$filter["z_Contrasenia"];
		$this->Contrasenia->AdvancedSearch->SearchCondition = @$filter["v_Contrasenia"];
		$this->Contrasenia->AdvancedSearch->SearchValue2 = @$filter["y_Contrasenia"];
		$this->Contrasenia->AdvancedSearch->SearchOperator2 = @$filter["w_Contrasenia"];
		$this->Contrasenia->AdvancedSearch->Save();

		// Field Habilitado
		$this->Habilitado->AdvancedSearch->SearchValue = @$filter["x_Habilitado"];
		$this->Habilitado->AdvancedSearch->SearchOperator = @$filter["z_Habilitado"];
		$this->Habilitado->AdvancedSearch->SearchCondition = @$filter["v_Habilitado"];
		$this->Habilitado->AdvancedSearch->SearchValue2 = @$filter["y_Habilitado"];
		$this->Habilitado->AdvancedSearch->SearchOperator2 = @$filter["w_Habilitado"];
		$this->Habilitado->AdvancedSearch->Save();

		// Field IP
		$this->IP->AdvancedSearch->SearchValue = @$filter["x_IP"];
		$this->IP->AdvancedSearch->SearchOperator = @$filter["z_IP"];
		$this->IP->AdvancedSearch->SearchCondition = @$filter["v_IP"];
		$this->IP->AdvancedSearch->SearchValue2 = @$filter["y_IP"];
		$this->IP->AdvancedSearch->SearchOperator2 = @$filter["w_IP"];
		$this->IP->AdvancedSearch->Save();

		// Field UltimoLogin
		$this->UltimoLogin->AdvancedSearch->SearchValue = @$filter["x_UltimoLogin"];
		$this->UltimoLogin->AdvancedSearch->SearchOperator = @$filter["z_UltimoLogin"];
		$this->UltimoLogin->AdvancedSearch->SearchCondition = @$filter["v_UltimoLogin"];
		$this->UltimoLogin->AdvancedSearch->SearchValue2 = @$filter["y_UltimoLogin"];
		$this->UltimoLogin->AdvancedSearch->SearchOperator2 = @$filter["w_UltimoLogin"];
		$this->UltimoLogin->AdvancedSearch->Save();

		// Field TipoCliente
		$this->TipoCliente->AdvancedSearch->SearchValue = @$filter["x_TipoCliente"];
		$this->TipoCliente->AdvancedSearch->SearchOperator = @$filter["z_TipoCliente"];
		$this->TipoCliente->AdvancedSearch->SearchCondition = @$filter["v_TipoCliente"];
		$this->TipoCliente->AdvancedSearch->SearchValue2 = @$filter["y_TipoCliente"];
		$this->TipoCliente->AdvancedSearch->SearchOperator2 = @$filter["w_TipoCliente"];
		$this->TipoCliente->AdvancedSearch->Save();

		// Field Regis_Mda
		$this->Regis_Mda->AdvancedSearch->SearchValue = @$filter["x_Regis_Mda"];
		$this->Regis_Mda->AdvancedSearch->SearchOperator = @$filter["z_Regis_Mda"];
		$this->Regis_Mda->AdvancedSearch->SearchCondition = @$filter["v_Regis_Mda"];
		$this->Regis_Mda->AdvancedSearch->SearchValue2 = @$filter["y_Regis_Mda"];
		$this->Regis_Mda->AdvancedSearch->SearchOperator2 = @$filter["w_Regis_Mda"];
		$this->Regis_Mda->AdvancedSearch->Save();

		// Field ApellidoNombre
		$this->ApellidoNombre->AdvancedSearch->SearchValue = @$filter["x_ApellidoNombre"];
		$this->ApellidoNombre->AdvancedSearch->SearchOperator = @$filter["z_ApellidoNombre"];
		$this->ApellidoNombre->AdvancedSearch->SearchCondition = @$filter["v_ApellidoNombre"];
		$this->ApellidoNombre->AdvancedSearch->SearchValue2 = @$filter["y_ApellidoNombre"];
		$this->ApellidoNombre->AdvancedSearch->SearchOperator2 = @$filter["w_ApellidoNombre"];
		$this->ApellidoNombre->AdvancedSearch->Save();

		// Field Cargo
		$this->Cargo->AdvancedSearch->SearchValue = @$filter["x_Cargo"];
		$this->Cargo->AdvancedSearch->SearchOperator = @$filter["z_Cargo"];
		$this->Cargo->AdvancedSearch->SearchCondition = @$filter["v_Cargo"];
		$this->Cargo->AdvancedSearch->SearchValue2 = @$filter["y_Cargo"];
		$this->Cargo->AdvancedSearch->SearchOperator2 = @$filter["w_Cargo"];
		$this->Cargo->AdvancedSearch->Save();

		// Field Comentarios
		$this->Comentarios->AdvancedSearch->SearchValue = @$filter["x_Comentarios"];
		$this->Comentarios->AdvancedSearch->SearchOperator = @$filter["z_Comentarios"];
		$this->Comentarios->AdvancedSearch->SearchCondition = @$filter["v_Comentarios"];
		$this->Comentarios->AdvancedSearch->SearchValue2 = @$filter["y_Comentarios"];
		$this->Comentarios->AdvancedSearch->SearchOperator2 = @$filter["w_Comentarios"];
		$this->Comentarios->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->CodigoCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Contrasenia, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Habilitado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->IP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->TipoCliente, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ApellidoNombre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cargo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Comentarios, $arKeywords, $type);
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
			$this->UpdateSort($this->CodigoCli, $bCtrl); // CodigoCli
			$this->UpdateSort($this->pedidosPendientes, $bCtrl); // pedidosPendientes
			$this->UpdateSort($this->vencimientosPendientes, $bCtrl); // vencimientosPendientes
			$this->UpdateSort($this->emailCli, $bCtrl); // emailCli
			$this->UpdateSort($this->Contrasenia, $bCtrl); // Contrasenia
			$this->UpdateSort($this->Habilitado, $bCtrl); // Habilitado
			$this->UpdateSort($this->IP, $bCtrl); // IP
			$this->UpdateSort($this->UltimoLogin, $bCtrl); // UltimoLogin
			$this->UpdateSort($this->TipoCliente, $bCtrl); // TipoCliente
			$this->UpdateSort($this->Regis_Mda, $bCtrl); // Regis_Mda
			$this->UpdateSort($this->ApellidoNombre, $bCtrl); // ApellidoNombre
			$this->UpdateSort($this->Cargo, $bCtrl); // Cargo
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
				$this->UltimoLogin->setSort("DESC");
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
				$this->setSessionOrderByList($sOrderBy);
				$this->CodigoCli->setSort("");
				$this->pedidosPendientes->setSort("");
				$this->vencimientosPendientes->setSort("");
				$this->emailCli->setSort("");
				$this->Contrasenia->setSort("");
				$this->Habilitado->setSort("");
				$this->IP->setSort("");
				$this->UltimoLogin->setSort("");
				$this->TipoCliente->setSort("");
				$this->Regis_Mda->setSort("");
				$this->ApellidoNombre->setSort("");
				$this->Cargo->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->CodigoCli->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fwalger_clienteslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fwalger_clienteslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fwalger_clienteslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fwalger_clienteslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Body = "<button id=\"emf_walger_clientes\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_walger_clientes',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fwalger_clienteslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($walger_clientes_list)) $walger_clientes_list = new cwalger_clientes_list();

// Page init
$walger_clientes_list->Page_Init();

// Page main
$walger_clientes_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$walger_clientes_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($walger_clientes->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fwalger_clienteslist = new ew_Form("fwalger_clienteslist", "list");
fwalger_clienteslist.FormKeyCountName = '<?php echo $walger_clientes_list->FormKeyCountName ?>';

// Form_CustomValidate event
fwalger_clienteslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwalger_clienteslist.ValidateRequired = true;
<?php } else { ?>
fwalger_clienteslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwalger_clienteslist.Lists["x_CodigoCli"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","x_emailCli",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};
fwalger_clienteslist.Lists["x_Habilitado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clienteslist.Lists["x_Habilitado"].Options = <?php echo json_encode($walger_clientes->Habilitado->Options()) ?>;
fwalger_clienteslist.Lists["x_TipoCliente"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_clienteslist.Lists["x_TipoCliente"].Options = <?php echo json_encode($walger_clientes->TipoCliente->Options()) ?>;
fwalger_clienteslist.Lists["x_Regis_Mda"] = {"LinkField":"x_Regis_Mda","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descr_Mda","x_Signo_Mda","x_Cotiz_Mda",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_moneda"};

// Form object for search
var CurrentSearchForm = fwalger_clienteslistsrch = new ew_Form("fwalger_clienteslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($walger_clientes->Export == "") { ?>
<div class="ewToolbar">
<?php if ($walger_clientes->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($walger_clientes_list->TotalRecs > 0 && $walger_clientes_list->ExportOptions->Visible()) { ?>
<?php $walger_clientes_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($walger_clientes_list->SearchOptions->Visible()) { ?>
<?php $walger_clientes_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($walger_clientes_list->FilterOptions->Visible()) { ?>
<?php $walger_clientes_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($walger_clientes->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $walger_clientes_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($walger_clientes_list->TotalRecs <= 0)
			$walger_clientes_list->TotalRecs = $walger_clientes->SelectRecordCount();
	} else {
		if (!$walger_clientes_list->Recordset && ($walger_clientes_list->Recordset = $walger_clientes_list->LoadRecordset()))
			$walger_clientes_list->TotalRecs = $walger_clientes_list->Recordset->RecordCount();
	}
	$walger_clientes_list->StartRec = 1;
	if ($walger_clientes_list->DisplayRecs <= 0 || ($walger_clientes->Export <> "" && $walger_clientes->ExportAll)) // Display all records
		$walger_clientes_list->DisplayRecs = $walger_clientes_list->TotalRecs;
	if (!($walger_clientes->Export <> "" && $walger_clientes->ExportAll))
		$walger_clientes_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$walger_clientes_list->Recordset = $walger_clientes_list->LoadRecordset($walger_clientes_list->StartRec-1, $walger_clientes_list->DisplayRecs);

	// Set no record found message
	if ($walger_clientes->CurrentAction == "" && $walger_clientes_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$walger_clientes_list->setWarningMessage(ew_DeniedMsg());
		if ($walger_clientes_list->SearchWhere == "0=101")
			$walger_clientes_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$walger_clientes_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$walger_clientes_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($walger_clientes->Export == "" && $walger_clientes->CurrentAction == "") { ?>
<form name="fwalger_clienteslistsrch" id="fwalger_clienteslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($walger_clientes_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fwalger_clienteslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="walger_clientes">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($walger_clientes_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($walger_clientes_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $walger_clientes_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($walger_clientes_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($walger_clientes_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($walger_clientes_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($walger_clientes_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $walger_clientes_list->ShowPageHeader(); ?>
<?php
$walger_clientes_list->ShowMessage();
?>
<?php if ($walger_clientes_list->TotalRecs > 0 || $walger_clientes->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid walger_clientes">
<?php if ($walger_clientes->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($walger_clientes->CurrentAction <> "gridadd" && $walger_clientes->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($walger_clientes_list->Pager)) $walger_clientes_list->Pager = new cPrevNextPager($walger_clientes_list->StartRec, $walger_clientes_list->DisplayRecs, $walger_clientes_list->TotalRecs) ?>
<?php if ($walger_clientes_list->Pager->RecordCount > 0 && $walger_clientes_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($walger_clientes_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $walger_clientes_list->PageUrl() ?>start=<?php echo $walger_clientes_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($walger_clientes_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $walger_clientes_list->PageUrl() ?>start=<?php echo $walger_clientes_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $walger_clientes_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($walger_clientes_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $walger_clientes_list->PageUrl() ?>start=<?php echo $walger_clientes_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($walger_clientes_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $walger_clientes_list->PageUrl() ?>start=<?php echo $walger_clientes_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $walger_clientes_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $walger_clientes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $walger_clientes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $walger_clientes_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($walger_clientes_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="walger_clientes">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($walger_clientes_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($walger_clientes_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="40"<?php if ($walger_clientes_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="80"<?php if ($walger_clientes_list->DisplayRecs == 80) { ?> selected<?php } ?>>80</option>
<option value="160"<?php if ($walger_clientes_list->DisplayRecs == 160) { ?> selected<?php } ?>>160</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($walger_clientes_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fwalger_clienteslist" id="fwalger_clienteslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($walger_clientes_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $walger_clientes_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="walger_clientes">
<div id="gmp_walger_clientes" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($walger_clientes_list->TotalRecs > 0) { ?>
<table id="tbl_walger_clienteslist" class="table ewTable">
<?php echo $walger_clientes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$walger_clientes_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$walger_clientes_list->RenderListOptions();

// Render list options (header, left)
$walger_clientes_list->ListOptions->Render("header", "left");
?>
<?php if ($walger_clientes->CodigoCli->Visible) { // CodigoCli ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->CodigoCli) == "") { ?>
		<th data-name="CodigoCli"><div id="elh_walger_clientes_CodigoCli" class="walger_clientes_CodigoCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->CodigoCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CodigoCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->CodigoCli) ?>',2);"><div id="elh_walger_clientes_CodigoCli" class="walger_clientes_CodigoCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->CodigoCli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->CodigoCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->CodigoCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->pedidosPendientes->Visible) { // pedidosPendientes ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->pedidosPendientes) == "") { ?>
		<th data-name="pedidosPendientes"><div id="elh_walger_clientes_pedidosPendientes" class="walger_clientes_pedidosPendientes"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->pedidosPendientes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pedidosPendientes"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->pedidosPendientes) ?>',2);"><div id="elh_walger_clientes_pedidosPendientes" class="walger_clientes_pedidosPendientes">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->pedidosPendientes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->pedidosPendientes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->pedidosPendientes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->vencimientosPendientes) == "") { ?>
		<th data-name="vencimientosPendientes"><div id="elh_walger_clientes_vencimientosPendientes" class="walger_clientes_vencimientosPendientes"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->vencimientosPendientes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="vencimientosPendientes"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->vencimientosPendientes) ?>',2);"><div id="elh_walger_clientes_vencimientosPendientes" class="walger_clientes_vencimientosPendientes">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->vencimientosPendientes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->vencimientosPendientes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->vencimientosPendientes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->emailCli->Visible) { // emailCli ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->emailCli) == "") { ?>
		<th data-name="emailCli"><div id="elh_walger_clientes_emailCli" class="walger_clientes_emailCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->emailCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="emailCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->emailCli) ?>',2);"><div id="elh_walger_clientes_emailCli" class="walger_clientes_emailCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->emailCli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->emailCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->emailCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->Contrasenia->Visible) { // Contrasenia ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->Contrasenia) == "") { ?>
		<th data-name="Contrasenia"><div id="elh_walger_clientes_Contrasenia" class="walger_clientes_Contrasenia"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->Contrasenia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Contrasenia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->Contrasenia) ?>',2);"><div id="elh_walger_clientes_Contrasenia" class="walger_clientes_Contrasenia">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->Contrasenia->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->Contrasenia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->Contrasenia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->Habilitado->Visible) { // Habilitado ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->Habilitado) == "") { ?>
		<th data-name="Habilitado"><div id="elh_walger_clientes_Habilitado" class="walger_clientes_Habilitado"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->Habilitado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Habilitado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->Habilitado) ?>',2);"><div id="elh_walger_clientes_Habilitado" class="walger_clientes_Habilitado">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->Habilitado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->Habilitado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->Habilitado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->IP->Visible) { // IP ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->IP) == "") { ?>
		<th data-name="IP"><div id="elh_walger_clientes_IP" class="walger_clientes_IP"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->IP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="IP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->IP) ?>',2);"><div id="elh_walger_clientes_IP" class="walger_clientes_IP">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->IP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->IP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->IP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->UltimoLogin->Visible) { // UltimoLogin ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->UltimoLogin) == "") { ?>
		<th data-name="UltimoLogin"><div id="elh_walger_clientes_UltimoLogin" class="walger_clientes_UltimoLogin"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->UltimoLogin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UltimoLogin"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->UltimoLogin) ?>',2);"><div id="elh_walger_clientes_UltimoLogin" class="walger_clientes_UltimoLogin">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->UltimoLogin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->UltimoLogin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->UltimoLogin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->TipoCliente->Visible) { // TipoCliente ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->TipoCliente) == "") { ?>
		<th data-name="TipoCliente"><div id="elh_walger_clientes_TipoCliente" class="walger_clientes_TipoCliente"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->TipoCliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TipoCliente"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->TipoCliente) ?>',2);"><div id="elh_walger_clientes_TipoCliente" class="walger_clientes_TipoCliente">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->TipoCliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->TipoCliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->TipoCliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->Regis_Mda->Visible) { // Regis_Mda ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->Regis_Mda) == "") { ?>
		<th data-name="Regis_Mda"><div id="elh_walger_clientes_Regis_Mda" class="walger_clientes_Regis_Mda"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->Regis_Mda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Regis_Mda"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->Regis_Mda) ?>',2);"><div id="elh_walger_clientes_Regis_Mda" class="walger_clientes_Regis_Mda">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->Regis_Mda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->Regis_Mda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->Regis_Mda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->ApellidoNombre->Visible) { // ApellidoNombre ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->ApellidoNombre) == "") { ?>
		<th data-name="ApellidoNombre"><div id="elh_walger_clientes_ApellidoNombre" class="walger_clientes_ApellidoNombre"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->ApellidoNombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ApellidoNombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->ApellidoNombre) ?>',2);"><div id="elh_walger_clientes_ApellidoNombre" class="walger_clientes_ApellidoNombre">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->ApellidoNombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->ApellidoNombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->ApellidoNombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($walger_clientes->Cargo->Visible) { // Cargo ?>
	<?php if ($walger_clientes->SortUrl($walger_clientes->Cargo) == "") { ?>
		<th data-name="Cargo"><div id="elh_walger_clientes_Cargo" class="walger_clientes_Cargo"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $walger_clientes->Cargo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cargo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $walger_clientes->SortUrl($walger_clientes->Cargo) ?>',2);"><div id="elh_walger_clientes_Cargo" class="walger_clientes_Cargo">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $walger_clientes->Cargo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($walger_clientes->Cargo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($walger_clientes->Cargo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$walger_clientes_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($walger_clientes->ExportAll && $walger_clientes->Export <> "") {
	$walger_clientes_list->StopRec = $walger_clientes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($walger_clientes_list->TotalRecs > $walger_clientes_list->StartRec + $walger_clientes_list->DisplayRecs - 1)
		$walger_clientes_list->StopRec = $walger_clientes_list->StartRec + $walger_clientes_list->DisplayRecs - 1;
	else
		$walger_clientes_list->StopRec = $walger_clientes_list->TotalRecs;
}
$walger_clientes_list->RecCnt = $walger_clientes_list->StartRec - 1;
if ($walger_clientes_list->Recordset && !$walger_clientes_list->Recordset->EOF) {
	$walger_clientes_list->Recordset->MoveFirst();
	$bSelectLimit = $walger_clientes_list->UseSelectLimit;
	if (!$bSelectLimit && $walger_clientes_list->StartRec > 1)
		$walger_clientes_list->Recordset->Move($walger_clientes_list->StartRec - 1);
} elseif (!$walger_clientes->AllowAddDeleteRow && $walger_clientes_list->StopRec == 0) {
	$walger_clientes_list->StopRec = $walger_clientes->GridAddRowCount;
}

// Initialize aggregate
$walger_clientes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$walger_clientes->ResetAttrs();
$walger_clientes_list->RenderRow();
while ($walger_clientes_list->RecCnt < $walger_clientes_list->StopRec) {
	$walger_clientes_list->RecCnt++;
	if (intval($walger_clientes_list->RecCnt) >= intval($walger_clientes_list->StartRec)) {
		$walger_clientes_list->RowCnt++;

		// Set up key count
		$walger_clientes_list->KeyCount = $walger_clientes_list->RowIndex;

		// Init row class and style
		$walger_clientes->ResetAttrs();
		$walger_clientes->CssClass = "";
		if ($walger_clientes->CurrentAction == "gridadd") {
		} else {
			$walger_clientes_list->LoadRowValues($walger_clientes_list->Recordset); // Load row values
		}
		$walger_clientes->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$walger_clientes->RowAttrs = array_merge($walger_clientes->RowAttrs, array('data-rowindex'=>$walger_clientes_list->RowCnt, 'id'=>'r' . $walger_clientes_list->RowCnt . '_walger_clientes', 'data-rowtype'=>$walger_clientes->RowType));

		// Render row
		$walger_clientes_list->RenderRow();

		// Render list options
		$walger_clientes_list->RenderListOptions();
?>
	<tr<?php echo $walger_clientes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$walger_clientes_list->ListOptions->Render("body", "left", $walger_clientes_list->RowCnt);
?>
	<?php if ($walger_clientes->CodigoCli->Visible) { // CodigoCli ?>
		<td data-name="CodigoCli"<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_CodigoCli" class="walger_clientes_CodigoCli">
<span<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>>
<?php echo $walger_clientes->CodigoCli->ListViewValue() ?></span>
</span>
<a id="<?php echo $walger_clientes_list->PageObjName . "_row_" . $walger_clientes_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($walger_clientes->pedidosPendientes->Visible) { // pedidosPendientes ?>
		<td data-name="pedidosPendientes"<?php echo $walger_clientes->pedidosPendientes->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_pedidosPendientes" class="walger_clientes_pedidosPendientes">
<span<?php echo $walger_clientes->pedidosPendientes->ViewAttributes() ?>>
<?php echo $walger_clientes->pedidosPendientes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
		<td data-name="vencimientosPendientes"<?php echo $walger_clientes->vencimientosPendientes->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_vencimientosPendientes" class="walger_clientes_vencimientosPendientes">
<span<?php echo $walger_clientes->vencimientosPendientes->ViewAttributes() ?>>
<?php echo $walger_clientes->vencimientosPendientes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->emailCli->Visible) { // emailCli ?>
		<td data-name="emailCli"<?php echo $walger_clientes->emailCli->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_emailCli" class="walger_clientes_emailCli">
<span<?php echo $walger_clientes->emailCli->ViewAttributes() ?>>
<?php echo $walger_clientes->emailCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->Contrasenia->Visible) { // Contrasenia ?>
		<td data-name="Contrasenia"<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_Contrasenia" class="walger_clientes_Contrasenia">
<span<?php echo $walger_clientes->Contrasenia->ViewAttributes() ?>>
<?php echo $walger_clientes->Contrasenia->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->Habilitado->Visible) { // Habilitado ?>
		<td data-name="Habilitado"<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_Habilitado" class="walger_clientes_Habilitado">
<span<?php echo $walger_clientes->Habilitado->ViewAttributes() ?>>
<?php echo $walger_clientes->Habilitado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->IP->Visible) { // IP ?>
		<td data-name="IP"<?php echo $walger_clientes->IP->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_IP" class="walger_clientes_IP">
<span<?php echo $walger_clientes->IP->ViewAttributes() ?>>
<?php echo $walger_clientes->IP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->UltimoLogin->Visible) { // UltimoLogin ?>
		<td data-name="UltimoLogin"<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_UltimoLogin" class="walger_clientes_UltimoLogin">
<span<?php echo $walger_clientes->UltimoLogin->ViewAttributes() ?>>
<?php echo $walger_clientes->UltimoLogin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->TipoCliente->Visible) { // TipoCliente ?>
		<td data-name="TipoCliente"<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_TipoCliente" class="walger_clientes_TipoCliente">
<span<?php echo $walger_clientes->TipoCliente->ViewAttributes() ?>>
<?php echo $walger_clientes->TipoCliente->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->Regis_Mda->Visible) { // Regis_Mda ?>
		<td data-name="Regis_Mda"<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_Regis_Mda" class="walger_clientes_Regis_Mda">
<span<?php echo $walger_clientes->Regis_Mda->ViewAttributes() ?>>
<?php echo $walger_clientes->Regis_Mda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->ApellidoNombre->Visible) { // ApellidoNombre ?>
		<td data-name="ApellidoNombre"<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_ApellidoNombre" class="walger_clientes_ApellidoNombre">
<span<?php echo $walger_clientes->ApellidoNombre->ViewAttributes() ?>>
<?php echo $walger_clientes->ApellidoNombre->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($walger_clientes->Cargo->Visible) { // Cargo ?>
		<td data-name="Cargo"<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<span id="el<?php echo $walger_clientes_list->RowCnt ?>_walger_clientes_Cargo" class="walger_clientes_Cargo">
<span<?php echo $walger_clientes->Cargo->ViewAttributes() ?>>
<?php echo $walger_clientes->Cargo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$walger_clientes_list->ListOptions->Render("body", "right", $walger_clientes_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($walger_clientes->CurrentAction <> "gridadd")
		$walger_clientes_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($walger_clientes->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($walger_clientes_list->Recordset)
	$walger_clientes_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($walger_clientes_list->TotalRecs == 0 && $walger_clientes->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($walger_clientes_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($walger_clientes->Export == "") { ?>
<script type="text/javascript">
fwalger_clienteslistsrch.FilterList = <?php echo $walger_clientes_list->GetFilterList() ?>;
fwalger_clienteslistsrch.Init();
fwalger_clienteslist.Init();
</script>
<?php } ?>
<?php
$walger_clientes_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($walger_clientes->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$walger_clientes_list->Page_Terminate();
?>
