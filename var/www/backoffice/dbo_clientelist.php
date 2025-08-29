<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dbo_clienteinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "trama_mensajes2Dclientesgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dbo_cliente_list = NULL; // Initialize page object first

class cdbo_cliente_list extends cdbo_cliente {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'dbo_cliente';

	// Page object name
	var $PageObjName = 'dbo_cliente_list';

	// Grid form hidden field names
	var $FormName = 'fdbo_clientelist';
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

		// Table object (dbo_cliente)
		if (!isset($GLOBALS["dbo_cliente"]) || get_class($GLOBALS["dbo_cliente"]) == "cdbo_cliente") {
			$GLOBALS["dbo_cliente"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dbo_cliente"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "dbo_clienteadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "dbo_clientedelete.php";
		$this->MultiUpdateUrl = "dbo_clienteupdate.php";

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbo_cliente', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdbo_clientelistsrch";

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
		$this->RazonSocialCli->SetVisibility();
		$this->pedidosPendientes->SetVisibility();
		$this->vencimientosPendientes->SetVisibility();
		$this->CuitCli->SetVisibility();
		$this->IngBrutosCli->SetVisibility();
		$this->Regis_IvaC->SetVisibility();
		$this->Regis_ListaPrec->SetVisibility();
		$this->emailCli->SetVisibility();
		$this->RazonSocialFlete->SetVisibility();
		$this->Direccion->SetVisibility();
		$this->BarrioCli->SetVisibility();
		$this->LocalidadCli->SetVisibility();
		$this->DescrProvincia->SetVisibility();
		$this->CodigoPostalCli->SetVisibility();
		$this->DescrPais->SetVisibility();
		$this->Telefono->SetVisibility();
		$this->FaxCli->SetVisibility();
		$this->PaginaWebCli->SetVisibility();

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

			// Process auto fill for detail table 'trama_mensajes-clientes'
			if (@$_POST["grid"] == "ftrama_mensajes2Dclientesgrid") {
				if (!isset($GLOBALS["trama_mensajes2Dclientes_grid"])) $GLOBALS["trama_mensajes2Dclientes_grid"] = new ctrama_mensajes2Dclientes_grid;
				$GLOBALS["trama_mensajes2Dclientes_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $dbo_cliente;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dbo_cliente);
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdbo_clientelistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->CodigoCli->AdvancedSearch->ToJSON(), ","); // Field CodigoCli
		$sFilterList = ew_Concat($sFilterList, $this->RazonSocialCli->AdvancedSearch->ToJSON(), ","); // Field RazonSocialCli
		$sFilterList = ew_Concat($sFilterList, $this->CuitCli->AdvancedSearch->ToJSON(), ","); // Field CuitCli
		$sFilterList = ew_Concat($sFilterList, $this->IngBrutosCli->AdvancedSearch->ToJSON(), ","); // Field IngBrutosCli
		$sFilterList = ew_Concat($sFilterList, $this->Regis_IvaC->AdvancedSearch->ToJSON(), ","); // Field Regis_IvaC
		$sFilterList = ew_Concat($sFilterList, $this->Regis_ListaPrec->AdvancedSearch->ToJSON(), ","); // Field Regis_ListaPrec
		$sFilterList = ew_Concat($sFilterList, $this->emailCli->AdvancedSearch->ToJSON(), ","); // Field emailCli
		$sFilterList = ew_Concat($sFilterList, $this->RazonSocialFlete->AdvancedSearch->ToJSON(), ","); // Field RazonSocialFlete
		$sFilterList = ew_Concat($sFilterList, $this->Direccion->AdvancedSearch->ToJSON(), ","); // Field Direccion
		$sFilterList = ew_Concat($sFilterList, $this->BarrioCli->AdvancedSearch->ToJSON(), ","); // Field BarrioCli
		$sFilterList = ew_Concat($sFilterList, $this->LocalidadCli->AdvancedSearch->ToJSON(), ","); // Field LocalidadCli
		$sFilterList = ew_Concat($sFilterList, $this->DescrProvincia->AdvancedSearch->ToJSON(), ","); // Field DescrProvincia
		$sFilterList = ew_Concat($sFilterList, $this->CodigoPostalCli->AdvancedSearch->ToJSON(), ","); // Field CodigoPostalCli
		$sFilterList = ew_Concat($sFilterList, $this->DescrPais->AdvancedSearch->ToJSON(), ","); // Field DescrPais
		$sFilterList = ew_Concat($sFilterList, $this->Telefono->AdvancedSearch->ToJSON(), ","); // Field Telefono
		$sFilterList = ew_Concat($sFilterList, $this->FaxCli->AdvancedSearch->ToJSON(), ","); // Field FaxCli
		$sFilterList = ew_Concat($sFilterList, $this->PaginaWebCli->AdvancedSearch->ToJSON(), ","); // Field PaginaWebCli
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdbo_clientelistsrch", $filters);
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

		// Field RazonSocialCli
		$this->RazonSocialCli->AdvancedSearch->SearchValue = @$filter["x_RazonSocialCli"];
		$this->RazonSocialCli->AdvancedSearch->SearchOperator = @$filter["z_RazonSocialCli"];
		$this->RazonSocialCli->AdvancedSearch->SearchCondition = @$filter["v_RazonSocialCli"];
		$this->RazonSocialCli->AdvancedSearch->SearchValue2 = @$filter["y_RazonSocialCli"];
		$this->RazonSocialCli->AdvancedSearch->SearchOperator2 = @$filter["w_RazonSocialCli"];
		$this->RazonSocialCli->AdvancedSearch->Save();

		// Field CuitCli
		$this->CuitCli->AdvancedSearch->SearchValue = @$filter["x_CuitCli"];
		$this->CuitCli->AdvancedSearch->SearchOperator = @$filter["z_CuitCli"];
		$this->CuitCli->AdvancedSearch->SearchCondition = @$filter["v_CuitCli"];
		$this->CuitCli->AdvancedSearch->SearchValue2 = @$filter["y_CuitCli"];
		$this->CuitCli->AdvancedSearch->SearchOperator2 = @$filter["w_CuitCli"];
		$this->CuitCli->AdvancedSearch->Save();

		// Field IngBrutosCli
		$this->IngBrutosCli->AdvancedSearch->SearchValue = @$filter["x_IngBrutosCli"];
		$this->IngBrutosCli->AdvancedSearch->SearchOperator = @$filter["z_IngBrutosCli"];
		$this->IngBrutosCli->AdvancedSearch->SearchCondition = @$filter["v_IngBrutosCli"];
		$this->IngBrutosCli->AdvancedSearch->SearchValue2 = @$filter["y_IngBrutosCli"];
		$this->IngBrutosCli->AdvancedSearch->SearchOperator2 = @$filter["w_IngBrutosCli"];
		$this->IngBrutosCli->AdvancedSearch->Save();

		// Field Regis_IvaC
		$this->Regis_IvaC->AdvancedSearch->SearchValue = @$filter["x_Regis_IvaC"];
		$this->Regis_IvaC->AdvancedSearch->SearchOperator = @$filter["z_Regis_IvaC"];
		$this->Regis_IvaC->AdvancedSearch->SearchCondition = @$filter["v_Regis_IvaC"];
		$this->Regis_IvaC->AdvancedSearch->SearchValue2 = @$filter["y_Regis_IvaC"];
		$this->Regis_IvaC->AdvancedSearch->SearchOperator2 = @$filter["w_Regis_IvaC"];
		$this->Regis_IvaC->AdvancedSearch->Save();

		// Field Regis_ListaPrec
		$this->Regis_ListaPrec->AdvancedSearch->SearchValue = @$filter["x_Regis_ListaPrec"];
		$this->Regis_ListaPrec->AdvancedSearch->SearchOperator = @$filter["z_Regis_ListaPrec"];
		$this->Regis_ListaPrec->AdvancedSearch->SearchCondition = @$filter["v_Regis_ListaPrec"];
		$this->Regis_ListaPrec->AdvancedSearch->SearchValue2 = @$filter["y_Regis_ListaPrec"];
		$this->Regis_ListaPrec->AdvancedSearch->SearchOperator2 = @$filter["w_Regis_ListaPrec"];
		$this->Regis_ListaPrec->AdvancedSearch->Save();

		// Field emailCli
		$this->emailCli->AdvancedSearch->SearchValue = @$filter["x_emailCli"];
		$this->emailCli->AdvancedSearch->SearchOperator = @$filter["z_emailCli"];
		$this->emailCli->AdvancedSearch->SearchCondition = @$filter["v_emailCli"];
		$this->emailCli->AdvancedSearch->SearchValue2 = @$filter["y_emailCli"];
		$this->emailCli->AdvancedSearch->SearchOperator2 = @$filter["w_emailCli"];
		$this->emailCli->AdvancedSearch->Save();

		// Field RazonSocialFlete
		$this->RazonSocialFlete->AdvancedSearch->SearchValue = @$filter["x_RazonSocialFlete"];
		$this->RazonSocialFlete->AdvancedSearch->SearchOperator = @$filter["z_RazonSocialFlete"];
		$this->RazonSocialFlete->AdvancedSearch->SearchCondition = @$filter["v_RazonSocialFlete"];
		$this->RazonSocialFlete->AdvancedSearch->SearchValue2 = @$filter["y_RazonSocialFlete"];
		$this->RazonSocialFlete->AdvancedSearch->SearchOperator2 = @$filter["w_RazonSocialFlete"];
		$this->RazonSocialFlete->AdvancedSearch->Save();

		// Field Direccion
		$this->Direccion->AdvancedSearch->SearchValue = @$filter["x_Direccion"];
		$this->Direccion->AdvancedSearch->SearchOperator = @$filter["z_Direccion"];
		$this->Direccion->AdvancedSearch->SearchCondition = @$filter["v_Direccion"];
		$this->Direccion->AdvancedSearch->SearchValue2 = @$filter["y_Direccion"];
		$this->Direccion->AdvancedSearch->SearchOperator2 = @$filter["w_Direccion"];
		$this->Direccion->AdvancedSearch->Save();

		// Field BarrioCli
		$this->BarrioCli->AdvancedSearch->SearchValue = @$filter["x_BarrioCli"];
		$this->BarrioCli->AdvancedSearch->SearchOperator = @$filter["z_BarrioCli"];
		$this->BarrioCli->AdvancedSearch->SearchCondition = @$filter["v_BarrioCli"];
		$this->BarrioCli->AdvancedSearch->SearchValue2 = @$filter["y_BarrioCli"];
		$this->BarrioCli->AdvancedSearch->SearchOperator2 = @$filter["w_BarrioCli"];
		$this->BarrioCli->AdvancedSearch->Save();

		// Field LocalidadCli
		$this->LocalidadCli->AdvancedSearch->SearchValue = @$filter["x_LocalidadCli"];
		$this->LocalidadCli->AdvancedSearch->SearchOperator = @$filter["z_LocalidadCli"];
		$this->LocalidadCli->AdvancedSearch->SearchCondition = @$filter["v_LocalidadCli"];
		$this->LocalidadCli->AdvancedSearch->SearchValue2 = @$filter["y_LocalidadCli"];
		$this->LocalidadCli->AdvancedSearch->SearchOperator2 = @$filter["w_LocalidadCli"];
		$this->LocalidadCli->AdvancedSearch->Save();

		// Field DescrProvincia
		$this->DescrProvincia->AdvancedSearch->SearchValue = @$filter["x_DescrProvincia"];
		$this->DescrProvincia->AdvancedSearch->SearchOperator = @$filter["z_DescrProvincia"];
		$this->DescrProvincia->AdvancedSearch->SearchCondition = @$filter["v_DescrProvincia"];
		$this->DescrProvincia->AdvancedSearch->SearchValue2 = @$filter["y_DescrProvincia"];
		$this->DescrProvincia->AdvancedSearch->SearchOperator2 = @$filter["w_DescrProvincia"];
		$this->DescrProvincia->AdvancedSearch->Save();

		// Field CodigoPostalCli
		$this->CodigoPostalCli->AdvancedSearch->SearchValue = @$filter["x_CodigoPostalCli"];
		$this->CodigoPostalCli->AdvancedSearch->SearchOperator = @$filter["z_CodigoPostalCli"];
		$this->CodigoPostalCli->AdvancedSearch->SearchCondition = @$filter["v_CodigoPostalCli"];
		$this->CodigoPostalCli->AdvancedSearch->SearchValue2 = @$filter["y_CodigoPostalCli"];
		$this->CodigoPostalCli->AdvancedSearch->SearchOperator2 = @$filter["w_CodigoPostalCli"];
		$this->CodigoPostalCli->AdvancedSearch->Save();

		// Field DescrPais
		$this->DescrPais->AdvancedSearch->SearchValue = @$filter["x_DescrPais"];
		$this->DescrPais->AdvancedSearch->SearchOperator = @$filter["z_DescrPais"];
		$this->DescrPais->AdvancedSearch->SearchCondition = @$filter["v_DescrPais"];
		$this->DescrPais->AdvancedSearch->SearchValue2 = @$filter["y_DescrPais"];
		$this->DescrPais->AdvancedSearch->SearchOperator2 = @$filter["w_DescrPais"];
		$this->DescrPais->AdvancedSearch->Save();

		// Field Telefono
		$this->Telefono->AdvancedSearch->SearchValue = @$filter["x_Telefono"];
		$this->Telefono->AdvancedSearch->SearchOperator = @$filter["z_Telefono"];
		$this->Telefono->AdvancedSearch->SearchCondition = @$filter["v_Telefono"];
		$this->Telefono->AdvancedSearch->SearchValue2 = @$filter["y_Telefono"];
		$this->Telefono->AdvancedSearch->SearchOperator2 = @$filter["w_Telefono"];
		$this->Telefono->AdvancedSearch->Save();

		// Field FaxCli
		$this->FaxCli->AdvancedSearch->SearchValue = @$filter["x_FaxCli"];
		$this->FaxCli->AdvancedSearch->SearchOperator = @$filter["z_FaxCli"];
		$this->FaxCli->AdvancedSearch->SearchCondition = @$filter["v_FaxCli"];
		$this->FaxCli->AdvancedSearch->SearchValue2 = @$filter["y_FaxCli"];
		$this->FaxCli->AdvancedSearch->SearchOperator2 = @$filter["w_FaxCli"];
		$this->FaxCli->AdvancedSearch->Save();

		// Field PaginaWebCli
		$this->PaginaWebCli->AdvancedSearch->SearchValue = @$filter["x_PaginaWebCli"];
		$this->PaginaWebCli->AdvancedSearch->SearchOperator = @$filter["z_PaginaWebCli"];
		$this->PaginaWebCli->AdvancedSearch->SearchCondition = @$filter["v_PaginaWebCli"];
		$this->PaginaWebCli->AdvancedSearch->SearchValue2 = @$filter["y_PaginaWebCli"];
		$this->PaginaWebCli->AdvancedSearch->SearchOperator2 = @$filter["w_PaginaWebCli"];
		$this->PaginaWebCli->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->CodigoCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->RazonSocialCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CuitCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->IngBrutosCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->emailCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->RazonSocialFlete, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Direccion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->BarrioCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->LocalidadCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescrProvincia, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CodigoPostalCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DescrPais, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Telefono, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->FaxCli, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PaginaWebCli, $arKeywords, $type);
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
			$this->UpdateSort($this->RazonSocialCli, $bCtrl); // RazonSocialCli
			$this->UpdateSort($this->pedidosPendientes, $bCtrl); // pedidosPendientes
			$this->UpdateSort($this->vencimientosPendientes, $bCtrl); // vencimientosPendientes
			$this->UpdateSort($this->CuitCli, $bCtrl); // CuitCli
			$this->UpdateSort($this->IngBrutosCli, $bCtrl); // IngBrutosCli
			$this->UpdateSort($this->Regis_IvaC, $bCtrl); // Regis_IvaC
			$this->UpdateSort($this->Regis_ListaPrec, $bCtrl); // Regis_ListaPrec
			$this->UpdateSort($this->emailCli, $bCtrl); // emailCli
			$this->UpdateSort($this->RazonSocialFlete, $bCtrl); // RazonSocialFlete
			$this->UpdateSort($this->Direccion, $bCtrl); // Direccion
			$this->UpdateSort($this->BarrioCli, $bCtrl); // BarrioCli
			$this->UpdateSort($this->LocalidadCli, $bCtrl); // LocalidadCli
			$this->UpdateSort($this->DescrProvincia, $bCtrl); // DescrProvincia
			$this->UpdateSort($this->CodigoPostalCli, $bCtrl); // CodigoPostalCli
			$this->UpdateSort($this->DescrPais, $bCtrl); // DescrPais
			$this->UpdateSort($this->Telefono, $bCtrl); // Telefono
			$this->UpdateSort($this->FaxCli, $bCtrl); // FaxCli
			$this->UpdateSort($this->PaginaWebCli, $bCtrl); // PaginaWebCli
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
				$this->CodigoCli->setSort("");
				$this->RazonSocialCli->setSort("");
				$this->pedidosPendientes->setSort("");
				$this->vencimientosPendientes->setSort("");
				$this->CuitCli->setSort("");
				$this->IngBrutosCli->setSort("");
				$this->Regis_IvaC->setSort("");
				$this->Regis_ListaPrec->setSort("");
				$this->emailCli->setSort("");
				$this->RazonSocialFlete->setSort("");
				$this->Direccion->setSort("");
				$this->BarrioCli->setSort("");
				$this->LocalidadCli->setSort("");
				$this->DescrProvincia->setSort("");
				$this->CodigoPostalCli->setSort("");
				$this->DescrPais->setSort("");
				$this->Telefono->setSort("");
				$this->FaxCli->setSort("");
				$this->PaginaWebCli->setSort("");
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

		// "detail_trama_mensajes2Dclientes"
		$item = &$this->ListOptions->Add("detail_trama_mensajes2Dclientes");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'trama_mensajes-clientes') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["trama_mensajes2Dclientes_grid"])) $GLOBALS["trama_mensajes2Dclientes_grid"] = new ctrama_mensajes2Dclientes_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("trama_mensajes2Dclientes");
		$this->DetailPages = $pages;

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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_trama_mensajes2Dclientes"
		$oListOpt = &$this->ListOptions->Items["detail_trama_mensajes2Dclientes"];
		if ($Security->AllowList(CurrentProjectID() . 'trama_mensajes-clientes')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("trama_mensajes2Dclientes", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("trama_mensajes2Dclienteslist.php?" . EW_TABLE_SHOW_MASTER . "=dbo_cliente&fk_CodigoCli=" . urlencode(strval($this->CodigoCli->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdbo_clientelistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdbo_clientelistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdbo_clientelist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdbo_clientelistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
		$this->pedidosPendientes->setDbValue($rs->fields('pedidosPendientes'));
		$this->vencimientosPendientes->setDbValue($rs->fields('vencimientosPendientes'));
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
		$this->pedidosPendientes->DbValue = $row['pedidosPendientes'];
		$this->vencimientosPendientes->DbValue = $row['vencimientosPendientes'];
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

		// RazonSocialCli
		$this->RazonSocialCli->CellCssStyle = "white-space: nowrap;";

		// pedidosPendientes
		$this->pedidosPendientes->CellCssStyle = "white-space: nowrap;";

		// vencimientosPendientes
		$this->vencimientosPendientes->CellCssStyle = "white-space: nowrap;";

		// CuitCli
		$this->CuitCli->CellCssStyle = "white-space: nowrap;";

		// IngBrutosCli
		$this->IngBrutosCli->CellCssStyle = "white-space: nowrap;";

		// Regis_IvaC
		$this->Regis_IvaC->CellCssStyle = "white-space: nowrap;";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->CellCssStyle = "white-space: nowrap;";

		// emailCli
		$this->emailCli->CellCssStyle = "white-space: nowrap;";

		// RazonSocialFlete
		$this->RazonSocialFlete->CellCssStyle = "white-space: nowrap;";

		// Direccion
		$this->Direccion->CellCssStyle = "white-space: nowrap;";

		// BarrioCli
		$this->BarrioCli->CellCssStyle = "white-space: nowrap;";

		// LocalidadCli
		$this->LocalidadCli->CellCssStyle = "white-space: nowrap;";

		// DescrProvincia
		$this->DescrProvincia->CellCssStyle = "white-space: nowrap;";

		// CodigoPostalCli
		$this->CodigoPostalCli->CellCssStyle = "white-space: nowrap;";

		// DescrPais
		$this->DescrPais->CellCssStyle = "white-space: nowrap;";

		// Telefono
		$this->Telefono->CellCssStyle = "white-space: nowrap;";

		// FaxCli
		$this->FaxCli->CellCssStyle = "white-space: nowrap;";

		// PaginaWebCli
		$this->PaginaWebCli->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
		$this->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$this->RazonSocialCli->ViewValue = $this->RazonSocialCli->CurrentValue;
		$this->RazonSocialCli->ViewCustomAttributes = "";

		// pedidosPendientes
		$this->pedidosPendientes->ViewValue = $this->pedidosPendientes->CurrentValue;
		$this->pedidosPendientes->ViewCustomAttributes = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->ViewValue = $this->vencimientosPendientes->CurrentValue;
		$this->vencimientosPendientes->ViewCustomAttributes = "";

		// CuitCli
		$this->CuitCli->ViewValue = $this->CuitCli->CurrentValue;
		$this->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$this->IngBrutosCli->ViewValue = $this->IngBrutosCli->CurrentValue;
		$this->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
		if (strval($this->Regis_IvaC->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_IvaC`" . ew_SearchString("=", $this->Regis_IvaC->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_IvaC`, `DescrIvaC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_ivacondicion`";
		$sWhereWrk = "";
		$this->Regis_IvaC->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_IvaC, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
			}
		} else {
			$this->Regis_IvaC->ViewValue = NULL;
		}
		$this->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
		if (strval($this->Regis_ListaPrec->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_ListaPrec`" . ew_SearchString("=", $this->Regis_ListaPrec->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_ListaPrec`, `DescrListaPrec` AS `DispFld`, `Regis_ListaPrec` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_listaprecios`";
		$sWhereWrk = "";
		$this->Regis_ListaPrec->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_ListaPrec, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$this->Regis_ListaPrec->ViewValue = NULL;
		}
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

			// pedidosPendientes
			$this->pedidosPendientes->LinkCustomAttributes = "";
			$this->pedidosPendientes->HrefValue = "";
			$this->pedidosPendientes->TooltipValue = "";

			// vencimientosPendientes
			$this->vencimientosPendientes->LinkCustomAttributes = "";
			$this->vencimientosPendientes->HrefValue = "";
			$this->vencimientosPendientes->TooltipValue = "";

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
		$item->Body = "<button id=\"emf_dbo_cliente\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_dbo_cliente',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdbo_clientelist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		$this->ListOptions->Items["detail_trama_mensajes2Dclientes"]->Body = '<a class="btn btn-default btn-sm ewRowLink " data-action="list" data-toggle="tooltip" data-placement="bottom" title="Mensajes" href="trama_mensajes2Dclienteslist.php?showmaster=dbo_cliente&fk_CodigoCli='.$this->CodigoCli->DbValue.'"><span  class="glyphicon glyphicon-envelope ewIcon" aria-hidden="true"></span></a>';
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
if (!isset($dbo_cliente_list)) $dbo_cliente_list = new cdbo_cliente_list();

// Page init
$dbo_cliente_list->Page_Init();

// Page main
$dbo_cliente_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_cliente_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($dbo_cliente->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdbo_clientelist = new ew_Form("fdbo_clientelist", "list");
fdbo_clientelist.FormKeyCountName = '<?php echo $dbo_cliente_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdbo_clientelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_clientelist.ValidateRequired = true;
<?php } else { ?>
fdbo_clientelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdbo_clientelist.Lists["x_Regis_IvaC"] = {"LinkField":"x_Regis_IvaC","Ajax":true,"AutoFill":false,"DisplayFields":["x_DescrIvaC","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_ivacondicion"};
fdbo_clientelist.Lists["x_Regis_ListaPrec"] = {"LinkField":"x_Regis_ListaPrec","Ajax":true,"AutoFill":false,"DisplayFields":["x_DescrListaPrec","x_Regis_ListaPrec","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_listaprecios"};

// Form object for search
var CurrentSearchForm = fdbo_clientelistsrch = new ew_Form("fdbo_clientelistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
<div class="ewToolbar">
<?php if ($dbo_cliente->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($dbo_cliente_list->TotalRecs > 0 && $dbo_cliente_list->ExportOptions->Visible()) { ?>
<?php $dbo_cliente_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_cliente_list->SearchOptions->Visible()) { ?>
<?php $dbo_cliente_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_cliente_list->FilterOptions->Visible()) { ?>
<?php $dbo_cliente_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $dbo_cliente_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($dbo_cliente_list->TotalRecs <= 0)
			$dbo_cliente_list->TotalRecs = $dbo_cliente->SelectRecordCount();
	} else {
		if (!$dbo_cliente_list->Recordset && ($dbo_cliente_list->Recordset = $dbo_cliente_list->LoadRecordset()))
			$dbo_cliente_list->TotalRecs = $dbo_cliente_list->Recordset->RecordCount();
	}
	$dbo_cliente_list->StartRec = 1;
	if ($dbo_cliente_list->DisplayRecs <= 0 || ($dbo_cliente->Export <> "" && $dbo_cliente->ExportAll)) // Display all records
		$dbo_cliente_list->DisplayRecs = $dbo_cliente_list->TotalRecs;
	if (!($dbo_cliente->Export <> "" && $dbo_cliente->ExportAll))
		$dbo_cliente_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$dbo_cliente_list->Recordset = $dbo_cliente_list->LoadRecordset($dbo_cliente_list->StartRec-1, $dbo_cliente_list->DisplayRecs);

	// Set no record found message
	if ($dbo_cliente->CurrentAction == "" && $dbo_cliente_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$dbo_cliente_list->setWarningMessage(ew_DeniedMsg());
		if ($dbo_cliente_list->SearchWhere == "0=101")
			$dbo_cliente_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$dbo_cliente_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$dbo_cliente_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($dbo_cliente->Export == "" && $dbo_cliente->CurrentAction == "") { ?>
<form name="fdbo_clientelistsrch" id="fdbo_clientelistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($dbo_cliente_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdbo_clientelistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="dbo_cliente">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($dbo_cliente_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($dbo_cliente_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $dbo_cliente_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($dbo_cliente_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($dbo_cliente_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($dbo_cliente_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($dbo_cliente_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $dbo_cliente_list->ShowPageHeader(); ?>
<?php
$dbo_cliente_list->ShowMessage();
?>
<?php if ($dbo_cliente_list->TotalRecs > 0 || $dbo_cliente->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid dbo_cliente">
<?php if ($dbo_cliente->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($dbo_cliente->CurrentAction <> "gridadd" && $dbo_cliente->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($dbo_cliente_list->Pager)) $dbo_cliente_list->Pager = new cPrevNextPager($dbo_cliente_list->StartRec, $dbo_cliente_list->DisplayRecs, $dbo_cliente_list->TotalRecs) ?>
<?php if ($dbo_cliente_list->Pager->RecordCount > 0 && $dbo_cliente_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($dbo_cliente_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $dbo_cliente_list->PageUrl() ?>start=<?php echo $dbo_cliente_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($dbo_cliente_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $dbo_cliente_list->PageUrl() ?>start=<?php echo $dbo_cliente_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dbo_cliente_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($dbo_cliente_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $dbo_cliente_list->PageUrl() ?>start=<?php echo $dbo_cliente_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($dbo_cliente_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $dbo_cliente_list->PageUrl() ?>start=<?php echo $dbo_cliente_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $dbo_cliente_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $dbo_cliente_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $dbo_cliente_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $dbo_cliente_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($dbo_cliente_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="dbo_cliente">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($dbo_cliente_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($dbo_cliente_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="40"<?php if ($dbo_cliente_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="80"<?php if ($dbo_cliente_list->DisplayRecs == 80) { ?> selected<?php } ?>>80</option>
<option value="160"<?php if ($dbo_cliente_list->DisplayRecs == 160) { ?> selected<?php } ?>>160</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dbo_cliente_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdbo_clientelist" id="fdbo_clientelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dbo_cliente_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dbo_cliente_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dbo_cliente">
<div id="gmp_dbo_cliente" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($dbo_cliente_list->TotalRecs > 0) { ?>
<table id="tbl_dbo_clientelist" class="table ewTable">
<?php echo $dbo_cliente->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$dbo_cliente_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$dbo_cliente_list->RenderListOptions();

// Render list options (header, left)
$dbo_cliente_list->ListOptions->Render("header", "left");
?>
<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->CodigoCli) == "") { ?>
		<th data-name="CodigoCli"><div id="elh_dbo_cliente_CodigoCli" class="dbo_cliente_CodigoCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->CodigoCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CodigoCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->CodigoCli) ?>',2);"><div id="elh_dbo_cliente_CodigoCli" class="dbo_cliente_CodigoCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->CodigoCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->CodigoCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->CodigoCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->RazonSocialCli) == "") { ?>
		<th data-name="RazonSocialCli"><div id="elh_dbo_cliente_RazonSocialCli" class="dbo_cliente_RazonSocialCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="RazonSocialCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->RazonSocialCli) ?>',2);"><div id="elh_dbo_cliente_RazonSocialCli" class="dbo_cliente_RazonSocialCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->RazonSocialCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->RazonSocialCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->pedidosPendientes->Visible) { // pedidosPendientes ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->pedidosPendientes) == "") { ?>
		<th data-name="pedidosPendientes"><div id="elh_dbo_cliente_pedidosPendientes" class="dbo_cliente_pedidosPendientes"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->pedidosPendientes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pedidosPendientes"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->pedidosPendientes) ?>',2);"><div id="elh_dbo_cliente_pedidosPendientes" class="dbo_cliente_pedidosPendientes">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->pedidosPendientes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->pedidosPendientes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->pedidosPendientes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->vencimientosPendientes) == "") { ?>
		<th data-name="vencimientosPendientes"><div id="elh_dbo_cliente_vencimientosPendientes" class="dbo_cliente_vencimientosPendientes"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->vencimientosPendientes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="vencimientosPendientes"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->vencimientosPendientes) ?>',2);"><div id="elh_dbo_cliente_vencimientosPendientes" class="dbo_cliente_vencimientosPendientes">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->vencimientosPendientes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->vencimientosPendientes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->vencimientosPendientes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->CuitCli) == "") { ?>
		<th data-name="CuitCli"><div id="elh_dbo_cliente_CuitCli" class="dbo_cliente_CuitCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->CuitCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CuitCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->CuitCli) ?>',2);"><div id="elh_dbo_cliente_CuitCli" class="dbo_cliente_CuitCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->CuitCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->CuitCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->CuitCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->IngBrutosCli) == "") { ?>
		<th data-name="IngBrutosCli"><div id="elh_dbo_cliente_IngBrutosCli" class="dbo_cliente_IngBrutosCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="IngBrutosCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->IngBrutosCli) ?>',2);"><div id="elh_dbo_cliente_IngBrutosCli" class="dbo_cliente_IngBrutosCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->IngBrutosCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->IngBrutosCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->Regis_IvaC) == "") { ?>
		<th data-name="Regis_IvaC"><div id="elh_dbo_cliente_Regis_IvaC" class="dbo_cliente_Regis_IvaC"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Regis_IvaC"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->Regis_IvaC) ?>',2);"><div id="elh_dbo_cliente_Regis_IvaC" class="dbo_cliente_Regis_IvaC">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->Regis_IvaC->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->Regis_IvaC->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->Regis_ListaPrec) == "") { ?>
		<th data-name="Regis_ListaPrec"><div id="elh_dbo_cliente_Regis_ListaPrec" class="dbo_cliente_Regis_ListaPrec"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Regis_ListaPrec"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->Regis_ListaPrec) ?>',2);"><div id="elh_dbo_cliente_Regis_ListaPrec" class="dbo_cliente_Regis_ListaPrec">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->Regis_ListaPrec->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->Regis_ListaPrec->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->emailCli) == "") { ?>
		<th data-name="emailCli"><div id="elh_dbo_cliente_emailCli" class="dbo_cliente_emailCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->emailCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="emailCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->emailCli) ?>',2);"><div id="elh_dbo_cliente_emailCli" class="dbo_cliente_emailCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->emailCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->emailCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->emailCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->RazonSocialFlete) == "") { ?>
		<th data-name="RazonSocialFlete"><div id="elh_dbo_cliente_RazonSocialFlete" class="dbo_cliente_RazonSocialFlete"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="RazonSocialFlete"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->RazonSocialFlete) ?>',2);"><div id="elh_dbo_cliente_RazonSocialFlete" class="dbo_cliente_RazonSocialFlete">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->RazonSocialFlete->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->RazonSocialFlete->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->Direccion) == "") { ?>
		<th data-name="Direccion"><div id="elh_dbo_cliente_Direccion" class="dbo_cliente_Direccion"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->Direccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Direccion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->Direccion) ?>',2);"><div id="elh_dbo_cliente_Direccion" class="dbo_cliente_Direccion">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->Direccion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->Direccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->Direccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->BarrioCli) == "") { ?>
		<th data-name="BarrioCli"><div id="elh_dbo_cliente_BarrioCli" class="dbo_cliente_BarrioCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->BarrioCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="BarrioCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->BarrioCli) ?>',2);"><div id="elh_dbo_cliente_BarrioCli" class="dbo_cliente_BarrioCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->BarrioCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->BarrioCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->BarrioCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->LocalidadCli) == "") { ?>
		<th data-name="LocalidadCli"><div id="elh_dbo_cliente_LocalidadCli" class="dbo_cliente_LocalidadCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LocalidadCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->LocalidadCli) ?>',2);"><div id="elh_dbo_cliente_LocalidadCli" class="dbo_cliente_LocalidadCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->LocalidadCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->LocalidadCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->DescrProvincia) == "") { ?>
		<th data-name="DescrProvincia"><div id="elh_dbo_cliente_DescrProvincia" class="dbo_cliente_DescrProvincia"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescrProvincia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->DescrProvincia) ?>',2);"><div id="elh_dbo_cliente_DescrProvincia" class="dbo_cliente_DescrProvincia">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->DescrProvincia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->DescrProvincia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->CodigoPostalCli) == "") { ?>
		<th data-name="CodigoPostalCli"><div id="elh_dbo_cliente_CodigoPostalCli" class="dbo_cliente_CodigoPostalCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CodigoPostalCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->CodigoPostalCli) ?>',2);"><div id="elh_dbo_cliente_CodigoPostalCli" class="dbo_cliente_CodigoPostalCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->CodigoPostalCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->CodigoPostalCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->DescrPais) == "") { ?>
		<th data-name="DescrPais"><div id="elh_dbo_cliente_DescrPais" class="dbo_cliente_DescrPais"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->DescrPais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DescrPais"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->DescrPais) ?>',2);"><div id="elh_dbo_cliente_DescrPais" class="dbo_cliente_DescrPais">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->DescrPais->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->DescrPais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->DescrPais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->Telefono) == "") { ?>
		<th data-name="Telefono"><div id="elh_dbo_cliente_Telefono" class="dbo_cliente_Telefono"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->Telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Telefono"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->Telefono) ?>',2);"><div id="elh_dbo_cliente_Telefono" class="dbo_cliente_Telefono">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->Telefono->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->Telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->Telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->FaxCli) == "") { ?>
		<th data-name="FaxCli"><div id="elh_dbo_cliente_FaxCli" class="dbo_cliente_FaxCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->FaxCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="FaxCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->FaxCli) ?>',2);"><div id="elh_dbo_cliente_FaxCli" class="dbo_cliente_FaxCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->FaxCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->FaxCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->FaxCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
	<?php if ($dbo_cliente->SortUrl($dbo_cliente->PaginaWebCli) == "") { ?>
		<th data-name="PaginaWebCli"><div id="elh_dbo_cliente_PaginaWebCli" class="dbo_cliente_PaginaWebCli"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PaginaWebCli"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dbo_cliente->SortUrl($dbo_cliente->PaginaWebCli) ?>',2);"><div id="elh_dbo_cliente_PaginaWebCli" class="dbo_cliente_PaginaWebCli">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($dbo_cliente->PaginaWebCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dbo_cliente->PaginaWebCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$dbo_cliente_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($dbo_cliente->ExportAll && $dbo_cliente->Export <> "") {
	$dbo_cliente_list->StopRec = $dbo_cliente_list->TotalRecs;
} else {

	// Set the last record to display
	if ($dbo_cliente_list->TotalRecs > $dbo_cliente_list->StartRec + $dbo_cliente_list->DisplayRecs - 1)
		$dbo_cliente_list->StopRec = $dbo_cliente_list->StartRec + $dbo_cliente_list->DisplayRecs - 1;
	else
		$dbo_cliente_list->StopRec = $dbo_cliente_list->TotalRecs;
}
$dbo_cliente_list->RecCnt = $dbo_cliente_list->StartRec - 1;
if ($dbo_cliente_list->Recordset && !$dbo_cliente_list->Recordset->EOF) {
	$dbo_cliente_list->Recordset->MoveFirst();
	$bSelectLimit = $dbo_cliente_list->UseSelectLimit;
	if (!$bSelectLimit && $dbo_cliente_list->StartRec > 1)
		$dbo_cliente_list->Recordset->Move($dbo_cliente_list->StartRec - 1);
} elseif (!$dbo_cliente->AllowAddDeleteRow && $dbo_cliente_list->StopRec == 0) {
	$dbo_cliente_list->StopRec = $dbo_cliente->GridAddRowCount;
}

// Initialize aggregate
$dbo_cliente->RowType = EW_ROWTYPE_AGGREGATEINIT;
$dbo_cliente->ResetAttrs();
$dbo_cliente_list->RenderRow();
while ($dbo_cliente_list->RecCnt < $dbo_cliente_list->StopRec) {
	$dbo_cliente_list->RecCnt++;
	if (intval($dbo_cliente_list->RecCnt) >= intval($dbo_cliente_list->StartRec)) {
		$dbo_cliente_list->RowCnt++;

		// Set up key count
		$dbo_cliente_list->KeyCount = $dbo_cliente_list->RowIndex;

		// Init row class and style
		$dbo_cliente->ResetAttrs();
		$dbo_cliente->CssClass = "";
		if ($dbo_cliente->CurrentAction == "gridadd") {
		} else {
			$dbo_cliente_list->LoadRowValues($dbo_cliente_list->Recordset); // Load row values
		}
		$dbo_cliente->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$dbo_cliente->RowAttrs = array_merge($dbo_cliente->RowAttrs, array('data-rowindex'=>$dbo_cliente_list->RowCnt, 'id'=>'r' . $dbo_cliente_list->RowCnt . '_dbo_cliente', 'data-rowtype'=>$dbo_cliente->RowType));

		// Render row
		$dbo_cliente_list->RenderRow();

		// Render list options
		$dbo_cliente_list->RenderListOptions();
?>
	<tr<?php echo $dbo_cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$dbo_cliente_list->ListOptions->Render("body", "left", $dbo_cliente_list->RowCnt);
?>
	<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
		<td data-name="CodigoCli"<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_CodigoCli" class="dbo_cliente_CodigoCli">
<span<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoCli->ListViewValue() ?></span>
</span>
<a id="<?php echo $dbo_cliente_list->PageObjName . "_row_" . $dbo_cliente_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<td data-name="RazonSocialCli"<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_RazonSocialCli" class="dbo_cliente_RazonSocialCli">
<span<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->pedidosPendientes->Visible) { // pedidosPendientes ?>
		<td data-name="pedidosPendientes"<?php echo $dbo_cliente->pedidosPendientes->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_pedidosPendientes" class="dbo_cliente_pedidosPendientes">
<span<?php echo $dbo_cliente->pedidosPendientes->ViewAttributes() ?>>
<?php echo $dbo_cliente->pedidosPendientes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
		<td data-name="vencimientosPendientes"<?php echo $dbo_cliente->vencimientosPendientes->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_vencimientosPendientes" class="dbo_cliente_vencimientosPendientes">
<span<?php echo $dbo_cliente->vencimientosPendientes->ViewAttributes() ?>>
<?php echo $dbo_cliente->vencimientosPendientes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
		<td data-name="CuitCli"<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_CuitCli" class="dbo_cliente_CuitCli">
<span<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CuitCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
		<td data-name="IngBrutosCli"<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_IngBrutosCli" class="dbo_cliente_IngBrutosCli">
<span<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->IngBrutosCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
		<td data-name="Regis_IvaC"<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_Regis_IvaC" class="dbo_cliente_Regis_IvaC">
<span<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_IvaC->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
		<td data-name="Regis_ListaPrec"<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_Regis_ListaPrec" class="dbo_cliente_Regis_ListaPrec">
<span<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_ListaPrec->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
		<td data-name="emailCli"<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_emailCli" class="dbo_cliente_emailCli">
<span<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->emailCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
		<td data-name="RazonSocialFlete"<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_RazonSocialFlete" class="dbo_cliente_RazonSocialFlete">
<span<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialFlete->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
		<td data-name="Direccion"<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_Direccion" class="dbo_cliente_Direccion">
<span<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>>
<?php echo $dbo_cliente->Direccion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
		<td data-name="BarrioCli"<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_BarrioCli" class="dbo_cliente_BarrioCli">
<span<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->BarrioCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
		<td data-name="LocalidadCli"<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_LocalidadCli" class="dbo_cliente_LocalidadCli">
<span<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->LocalidadCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
		<td data-name="DescrProvincia"<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_DescrProvincia" class="dbo_cliente_DescrProvincia">
<span<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrProvincia->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
		<td data-name="CodigoPostalCli"<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_CodigoPostalCli" class="dbo_cliente_CodigoPostalCli">
<span<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoPostalCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
		<td data-name="DescrPais"<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_DescrPais" class="dbo_cliente_DescrPais">
<span<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrPais->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
		<td data-name="Telefono"<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_Telefono" class="dbo_cliente_Telefono">
<span<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>>
<?php echo $dbo_cliente->Telefono->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
		<td data-name="FaxCli"<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_FaxCli" class="dbo_cliente_FaxCli">
<span<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->FaxCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
		<td data-name="PaginaWebCli"<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<span id="el<?php echo $dbo_cliente_list->RowCnt ?>_dbo_cliente_PaginaWebCli" class="dbo_cliente_PaginaWebCli">
<span<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->PaginaWebCli->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$dbo_cliente_list->ListOptions->Render("body", "right", $dbo_cliente_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($dbo_cliente->CurrentAction <> "gridadd")
		$dbo_cliente_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($dbo_cliente->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($dbo_cliente_list->Recordset)
	$dbo_cliente_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($dbo_cliente_list->TotalRecs == 0 && $dbo_cliente->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dbo_cliente_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
<script type="text/javascript">
fdbo_clientelistsrch.FilterList = <?php echo $dbo_cliente_list->GetFilterList() ?>;
fdbo_clientelistsrch.Init();
fdbo_clientelist.Init();
</script>
<?php } ?>
<?php
$dbo_cliente_list->ShowPageFooter();
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
$dbo_cliente_list->Page_Terminate();
?>
