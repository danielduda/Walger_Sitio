<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "trama_portfolioinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$trama_portfolio_edit = NULL; // Initialize page object first

class ctrama_portfolio_edit extends ctrama_portfolio {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'trama_portfolio';

	// Page object name
	var $PageObjName = 'trama_portfolio_edit';

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

		// Table object (trama_portfolio)
		if (!isset($GLOBALS["trama_portfolio"]) || get_class($GLOBALS["trama_portfolio"]) == "ctrama_portfolio") {
			$GLOBALS["trama_portfolio"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trama_portfolio"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trama_portfolio', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("trama_portfoliolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->fkCategoriaPortfolio->SetVisibility();
		$this->denominacion->SetVisibility();
		$this->contenido->SetVisibility();
		$this->imagen->SetVisibility();

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
		global $EW_EXPORT, $trama_portfolio;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($trama_portfolio);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("trama_portfoliolist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("trama_portfoliolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "trama_portfoliolist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->imagen->Upload->Index = $objForm->Index;
		$this->imagen->Upload->UploadFile();
		$this->imagen->CurrentValue = $this->imagen->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->fkCategoriaPortfolio->FldIsDetailKey) {
			$this->fkCategoriaPortfolio->setFormValue($objForm->GetValue("x_fkCategoriaPortfolio"));
		}
		if (!$this->denominacion->FldIsDetailKey) {
			$this->denominacion->setFormValue($objForm->GetValue("x_denominacion"));
		}
		if (!$this->contenido->FldIsDetailKey) {
			$this->contenido->setFormValue($objForm->GetValue("x_contenido"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->fkCategoriaPortfolio->CurrentValue = $this->fkCategoriaPortfolio->FormValue;
		$this->denominacion->CurrentValue = $this->denominacion->FormValue;
		$this->contenido->CurrentValue = $this->contenido->FormValue;
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
		$this->fkCategoriaPortfolio->setDbValue($rs->fields('fkCategoriaPortfolio'));
		$this->denominacion->setDbValue($rs->fields('denominacion'));
		$this->contenido->setDbValue($rs->fields('contenido'));
		$this->imagen->Upload->DbValue = $rs->fields('imagen');
		$this->imagen->CurrentValue = $this->imagen->Upload->DbValue;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->fkCategoriaPortfolio->DbValue = $row['fkCategoriaPortfolio'];
		$this->denominacion->DbValue = $row['denominacion'];
		$this->contenido->DbValue = $row['contenido'];
		$this->imagen->Upload->DbValue = $row['imagen'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// fkCategoriaPortfolio
		// denominacion
		// contenido
		// imagen

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// fkCategoriaPortfolio
		if (strval($this->fkCategoriaPortfolio->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->fkCategoriaPortfolio->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_categorias-portfolio`";
		$sWhereWrk = "";
		$this->fkCategoriaPortfolio->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->fkCategoriaPortfolio, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->fkCategoriaPortfolio->ViewValue = $this->fkCategoriaPortfolio->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->fkCategoriaPortfolio->ViewValue = $this->fkCategoriaPortfolio->CurrentValue;
			}
		} else {
			$this->fkCategoriaPortfolio->ViewValue = NULL;
		}
		$this->fkCategoriaPortfolio->ViewCustomAttributes = "";

		// denominacion
		$this->denominacion->ViewValue = $this->denominacion->CurrentValue;
		$this->denominacion->ViewCustomAttributes = "";

		// contenido
		$this->contenido->ViewValue = $this->contenido->CurrentValue;
		$this->contenido->ViewCustomAttributes = "";

		// imagen
		if (!ew_Empty($this->imagen->Upload->DbValue)) {
			$this->imagen->ViewValue = $this->imagen->Upload->DbValue;
		} else {
			$this->imagen->ViewValue = "";
		}
		$this->imagen->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// fkCategoriaPortfolio
			$this->fkCategoriaPortfolio->LinkCustomAttributes = "";
			$this->fkCategoriaPortfolio->HrefValue = "";
			$this->fkCategoriaPortfolio->TooltipValue = "";

			// denominacion
			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";
			$this->denominacion->TooltipValue = "";

			// contenido
			$this->contenido->LinkCustomAttributes = "";
			$this->contenido->HrefValue = "";
			$this->contenido->TooltipValue = "";

			// imagen
			$this->imagen->LinkCustomAttributes = "";
			$this->imagen->HrefValue = "";
			$this->imagen->HrefValue2 = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
			$this->imagen->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// fkCategoriaPortfolio
			$this->fkCategoriaPortfolio->EditAttrs["class"] = "form-control";
			$this->fkCategoriaPortfolio->EditCustomAttributes = "";
			if (trim(strval($this->fkCategoriaPortfolio->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->fkCategoriaPortfolio->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_categorias-portfolio`";
			$sWhereWrk = "";
			$this->fkCategoriaPortfolio->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->fkCategoriaPortfolio, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->fkCategoriaPortfolio->EditValue = $arwrk;

			// denominacion
			$this->denominacion->EditAttrs["class"] = "form-control";
			$this->denominacion->EditCustomAttributes = "";
			$this->denominacion->EditValue = ew_HtmlEncode($this->denominacion->CurrentValue);
			$this->denominacion->PlaceHolder = ew_RemoveHtml($this->denominacion->FldCaption());

			// contenido
			$this->contenido->EditAttrs["class"] = "form-control";
			$this->contenido->EditCustomAttributes = "";
			$this->contenido->EditValue = ew_HtmlEncode($this->contenido->CurrentValue);
			$this->contenido->PlaceHolder = ew_RemoveHtml($this->contenido->FldCaption());

			// imagen
			$this->imagen->EditAttrs["class"] = "form-control";
			$this->imagen->EditCustomAttributes = "";
			if (!ew_Empty($this->imagen->Upload->DbValue)) {
				$this->imagen->EditValue = $this->imagen->Upload->DbValue;
			} else {
				$this->imagen->EditValue = "";
			}
			if (!ew_Empty($this->imagen->CurrentValue))
				$this->imagen->Upload->FileName = $this->imagen->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->imagen);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// fkCategoriaPortfolio
			$this->fkCategoriaPortfolio->LinkCustomAttributes = "";
			$this->fkCategoriaPortfolio->HrefValue = "";

			// denominacion
			$this->denominacion->LinkCustomAttributes = "";
			$this->denominacion->HrefValue = "";

			// contenido
			$this->contenido->LinkCustomAttributes = "";
			$this->contenido->HrefValue = "";

			// imagen
			$this->imagen->LinkCustomAttributes = "";
			$this->imagen->HrefValue = "";
			$this->imagen->HrefValue2 = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
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
		if (!$this->fkCategoriaPortfolio->FldIsDetailKey && !is_null($this->fkCategoriaPortfolio->FormValue) && $this->fkCategoriaPortfolio->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->fkCategoriaPortfolio->FldCaption(), $this->fkCategoriaPortfolio->ReqErrMsg));
		}
		if (!$this->denominacion->FldIsDetailKey && !is_null($this->denominacion->FormValue) && $this->denominacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->denominacion->FldCaption(), $this->denominacion->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// fkCategoriaPortfolio
			$this->fkCategoriaPortfolio->SetDbValueDef($rsnew, $this->fkCategoriaPortfolio->CurrentValue, NULL, $this->fkCategoriaPortfolio->ReadOnly);

			// denominacion
			$this->denominacion->SetDbValueDef($rsnew, $this->denominacion->CurrentValue, NULL, $this->denominacion->ReadOnly);

			// contenido
			$this->contenido->SetDbValueDef($rsnew, $this->contenido->CurrentValue, NULL, $this->contenido->ReadOnly);

			// imagen
			if ($this->imagen->Visible && !$this->imagen->ReadOnly && !$this->imagen->Upload->KeepFile) {
				$this->imagen->Upload->DbValue = $rsold['imagen']; // Get original value
				if ($this->imagen->Upload->FileName == "") {
					$rsnew['imagen'] = NULL;
				} else {
					$rsnew['imagen'] = $this->imagen->Upload->FileName;
				}
			}
			if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
				if (!ew_Empty($this->imagen->Upload->Value)) {
					$rsnew['imagen'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->imagen->UploadPath), $rsnew['imagen']); // Get new file name
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
						if (!ew_Empty($this->imagen->Upload->Value)) {
							$this->imagen->Upload->SaveToFile($this->imagen->UploadPath, $rsnew['imagen'], TRUE);
						}
					}
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

		// imagen
		ew_CleanUploadTempPath($this->imagen, $this->imagen->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("trama_portfoliolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_fkCategoriaPortfolio":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_categorias-portfolio`";
			$sWhereWrk = "";
			$this->fkCategoriaPortfolio->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->fkCategoriaPortfolio, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
if (!isset($trama_portfolio_edit)) $trama_portfolio_edit = new ctrama_portfolio_edit();

// Page init
$trama_portfolio_edit->Page_Init();

// Page main
$trama_portfolio_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_portfolio_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftrama_portfolioedit = new ew_Form("ftrama_portfolioedit", "edit");

// Validate form
ftrama_portfolioedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fkCategoriaPortfolio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_portfolio->fkCategoriaPortfolio->FldCaption(), $trama_portfolio->fkCategoriaPortfolio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_denominacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_portfolio->denominacion->FldCaption(), $trama_portfolio->denominacion->ReqErrMsg)) ?>");

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
ftrama_portfolioedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_portfolioedit.ValidateRequired = true;
<?php } else { ?>
ftrama_portfolioedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_portfolioedit.Lists["x_fkCategoriaPortfolio"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_categorias2Dportfolio"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$trama_portfolio_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $trama_portfolio_edit->ShowPageHeader(); ?>
<?php
$trama_portfolio_edit->ShowMessage();
?>
<form name="ftrama_portfolioedit" id="ftrama_portfolioedit" class="<?php echo $trama_portfolio_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($trama_portfolio_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $trama_portfolio_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="trama_portfolio">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($trama_portfolio_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($trama_portfolio->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_trama_portfolio_id" class="col-sm-2 control-label ewLabel"><?php echo $trama_portfolio->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_portfolio->id->CellAttributes() ?>>
<span id="el_trama_portfolio_id">
<span<?php echo $trama_portfolio->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_portfolio->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="trama_portfolio" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($trama_portfolio->id->CurrentValue) ?>">
<?php echo $trama_portfolio->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_portfolio->fkCategoriaPortfolio->Visible) { // fkCategoriaPortfolio ?>
	<div id="r_fkCategoriaPortfolio" class="form-group">
		<label id="elh_trama_portfolio_fkCategoriaPortfolio" for="x_fkCategoriaPortfolio" class="col-sm-2 control-label ewLabel"><?php echo $trama_portfolio->fkCategoriaPortfolio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_portfolio->fkCategoriaPortfolio->CellAttributes() ?>>
<span id="el_trama_portfolio_fkCategoriaPortfolio">
<select data-table="trama_portfolio" data-field="x_fkCategoriaPortfolio" data-value-separator="<?php echo $trama_portfolio->fkCategoriaPortfolio->DisplayValueSeparatorAttribute() ?>" id="x_fkCategoriaPortfolio" name="x_fkCategoriaPortfolio"<?php echo $trama_portfolio->fkCategoriaPortfolio->EditAttributes() ?>>
<?php echo $trama_portfolio->fkCategoriaPortfolio->SelectOptionListHtml("x_fkCategoriaPortfolio") ?>
</select>
<input type="hidden" name="s_x_fkCategoriaPortfolio" id="s_x_fkCategoriaPortfolio" value="<?php echo $trama_portfolio->fkCategoriaPortfolio->LookupFilterQuery() ?>">
</span>
<?php echo $trama_portfolio->fkCategoriaPortfolio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_portfolio->denominacion->Visible) { // denominacion ?>
	<div id="r_denominacion" class="form-group">
		<label id="elh_trama_portfolio_denominacion" for="x_denominacion" class="col-sm-2 control-label ewLabel"><?php echo $trama_portfolio->denominacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $trama_portfolio->denominacion->CellAttributes() ?>>
<span id="el_trama_portfolio_denominacion">
<input type="text" data-table="trama_portfolio" data-field="x_denominacion" name="x_denominacion" id="x_denominacion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($trama_portfolio->denominacion->getPlaceHolder()) ?>" value="<?php echo $trama_portfolio->denominacion->EditValue ?>"<?php echo $trama_portfolio->denominacion->EditAttributes() ?>>
</span>
<?php echo $trama_portfolio->denominacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_portfolio->contenido->Visible) { // contenido ?>
	<div id="r_contenido" class="form-group">
		<label id="elh_trama_portfolio_contenido" for="x_contenido" class="col-sm-2 control-label ewLabel"><?php echo $trama_portfolio->contenido->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_portfolio->contenido->CellAttributes() ?>>
<span id="el_trama_portfolio_contenido">
<textarea data-table="trama_portfolio" data-field="x_contenido" name="x_contenido" id="x_contenido" cols="60" rows="7" placeholder="<?php echo ew_HtmlEncode($trama_portfolio->contenido->getPlaceHolder()) ?>"<?php echo $trama_portfolio->contenido->EditAttributes() ?>><?php echo $trama_portfolio->contenido->EditValue ?></textarea>
</span>
<?php echo $trama_portfolio->contenido->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_portfolio->imagen->Visible) { // imagen ?>
	<div id="r_imagen" class="form-group">
		<label id="elh_trama_portfolio_imagen" class="col-sm-2 control-label ewLabel"><?php echo $trama_portfolio->imagen->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_portfolio->imagen->CellAttributes() ?>>
<span id="el_trama_portfolio_imagen">
<div id="fd_x_imagen">
<span title="<?php echo $trama_portfolio->imagen->FldTitle() ? $trama_portfolio->imagen->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($trama_portfolio->imagen->ReadOnly || $trama_portfolio->imagen->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="trama_portfolio" data-field="x_imagen" name="x_imagen" id="x_imagen"<?php echo $trama_portfolio->imagen->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_imagen" id= "fn_x_imagen" value="<?php echo $trama_portfolio->imagen->Upload->FileName ?>">
<?php if (@$_POST["fa_x_imagen"] == "0") { ?>
<input type="hidden" name="fa_x_imagen" id= "fa_x_imagen" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_imagen" id= "fa_x_imagen" value="1">
<?php } ?>
<input type="hidden" name="fs_x_imagen" id= "fs_x_imagen" value="255">
<input type="hidden" name="fx_x_imagen" id= "fx_x_imagen" value="<?php echo $trama_portfolio->imagen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_imagen" id= "fm_x_imagen" value="<?php echo $trama_portfolio->imagen->UploadMaxFileSize ?>">
</div>
<table id="ft_x_imagen" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $trama_portfolio->imagen->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$trama_portfolio_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $trama_portfolio_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftrama_portfolioedit.Init();
</script>
<?php
$trama_portfolio_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$trama_portfolio_edit->Page_Terminate();
?>
