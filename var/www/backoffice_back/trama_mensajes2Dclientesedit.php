<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "trama_mensajes2Dclientesinfo.php" ?>
<?php include_once "dbo_clienteinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$trama_mensajes2Dclientes_edit = NULL; // Initialize page object first

class ctrama_mensajes2Dclientes_edit extends ctrama_mensajes2Dclientes {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'trama_mensajes-clientes';

	// Page object name
	var $PageObjName = 'trama_mensajes2Dclientes_edit';

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

		// Table object (trama_mensajes2Dclientes)
		if (!isset($GLOBALS["trama_mensajes2Dclientes"]) || get_class($GLOBALS["trama_mensajes2Dclientes"]) == "ctrama_mensajes2Dclientes") {
			$GLOBALS["trama_mensajes2Dclientes"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["trama_mensajes2Dclientes"];
		}

		// Table object (dbo_cliente)
		if (!isset($GLOBALS['dbo_cliente'])) $GLOBALS['dbo_cliente'] = new cdbo_cliente();

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'trama_mensajes-clientes', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("trama_mensajes2Dclienteslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idCliente->SetVisibility();
		$this->fecha->SetVisibility();
		$this->mensaje->SetVisibility();

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
		global $EW_EXPORT, $trama_mensajes2Dclientes;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($trama_mensajes2Dclientes);
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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
			$this->Page_Terminate("trama_mensajes2Dclienteslist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("trama_mensajes2Dclienteslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "trama_mensajes2Dclienteslist.php")
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
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idCliente->FldIsDetailKey) {
			$this->idCliente->setFormValue($objForm->GetValue("x_idCliente"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 2);
		}
		if (!$this->mensaje->FldIsDetailKey) {
			$this->mensaje->setFormValue($objForm->GetValue("x_mensaje"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->idCliente->CurrentValue = $this->idCliente->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 2);
		$this->mensaje->CurrentValue = $this->mensaje->FormValue;
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
		$this->idCliente->setDbValue($rs->fields('idCliente'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->mensaje->setDbValue($rs->fields('mensaje'));
		$this->leido->setDbValue($rs->fields('leido'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->idCliente->DbValue = $row['idCliente'];
		$this->fecha->DbValue = $row['fecha'];
		$this->mensaje->DbValue = $row['mensaje'];
		$this->leido->DbValue = $row['leido'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// idCliente
		// fecha
		// mensaje
		// leido

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idCliente
		if (strval($this->idCliente->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->idCliente->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->idCliente->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idCliente, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idCliente->ViewValue = $this->idCliente->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idCliente->ViewValue = $this->idCliente->CurrentValue;
			}
		} else {
			$this->idCliente->ViewValue = NULL;
		}
		$this->idCliente->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 2);
		$this->fecha->ViewCustomAttributes = "";

		// mensaje
		$this->mensaje->ViewValue = $this->mensaje->CurrentValue;
		$this->mensaje->ViewCustomAttributes = "";

		// leido
		$this->leido->ViewCustomAttributes = "";

			// idCliente
			$this->idCliente->LinkCustomAttributes = "";
			$this->idCliente->HrefValue = "";
			$this->idCliente->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// mensaje
			$this->mensaje->LinkCustomAttributes = "";
			$this->mensaje->HrefValue = "";
			$this->mensaje->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idCliente
			$this->idCliente->EditAttrs["class"] = "form-control";
			$this->idCliente->EditCustomAttributes = "";
			if ($this->idCliente->getSessionValue() <> "") {
				$this->idCliente->CurrentValue = $this->idCliente->getSessionValue();
			if (strval($this->idCliente->CurrentValue) <> "") {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->idCliente->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "";
			$this->idCliente->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idCliente, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idCliente->ViewValue = $this->idCliente->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idCliente->ViewValue = $this->idCliente->CurrentValue;
				}
			} else {
				$this->idCliente->ViewValue = NULL;
			}
			$this->idCliente->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idCliente->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->idCliente->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `dbo_cliente`";
			$sWhereWrk = "";
			$this->idCliente->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idCliente, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->idCliente->EditValue = $arwrk;
			}

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 2));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// mensaje
			$this->mensaje->EditAttrs["class"] = "form-control";
			$this->mensaje->EditCustomAttributes = "";
			$this->mensaje->EditValue = ew_HtmlEncode($this->mensaje->CurrentValue);
			$this->mensaje->PlaceHolder = ew_RemoveHtml($this->mensaje->FldCaption());

			// Edit refer script
			// idCliente

			$this->idCliente->LinkCustomAttributes = "";
			$this->idCliente->HrefValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";

			// mensaje
			$this->mensaje->LinkCustomAttributes = "";
			$this->mensaje->HrefValue = "";
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
		if (!ew_CheckDateDef($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
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

			// idCliente
			$this->idCliente->SetDbValueDef($rsnew, $this->idCliente->CurrentValue, NULL, $this->idCliente->ReadOnly);

			// fecha
			$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 2), NULL, $this->fecha->ReadOnly);

			// mensaje
			$this->mensaje->SetDbValueDef($rsnew, $this->mensaje->CurrentValue, NULL, $this->mensaje->ReadOnly);

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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "dbo_cliente") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_CodigoCli"] <> "") {
					$GLOBALS["dbo_cliente"]->CodigoCli->setQueryStringValue($_GET["fk_CodigoCli"]);
					$this->idCliente->setQueryStringValue($GLOBALS["dbo_cliente"]->CodigoCli->QueryStringValue);
					$this->idCliente->setSessionValue($this->idCliente->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "dbo_cliente") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_CodigoCli"] <> "") {
					$GLOBALS["dbo_cliente"]->CodigoCli->setFormValue($_POST["fk_CodigoCli"]);
					$this->idCliente->setFormValue($GLOBALS["dbo_cliente"]->CodigoCli->FormValue);
					$this->idCliente->setSessionValue($this->idCliente->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "dbo_cliente") {
				if ($this->idCliente->CurrentValue == "") $this->idCliente->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("trama_mensajes2Dclienteslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_idCliente":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CodigoCli` AS `LinkFld`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "";
			$this->idCliente->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`CodigoCli` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->idCliente, $sWhereWrk); // Call Lookup selecting
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
if (!isset($trama_mensajes2Dclientes_edit)) $trama_mensajes2Dclientes_edit = new ctrama_mensajes2Dclientes_edit();

// Page init
$trama_mensajes2Dclientes_edit->Page_Init();

// Page main
$trama_mensajes2Dclientes_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_mensajes2Dclientes_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftrama_mensajes2Dclientesedit = new ew_Form("ftrama_mensajes2Dclientesedit", "edit");

// Validate form
ftrama_mensajes2Dclientesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_mensajes2Dclientes->fecha->FldErrMsg()) ?>");

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
ftrama_mensajes2Dclientesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_mensajes2Dclientesedit.ValidateRequired = true;
<?php } else { ?>
ftrama_mensajes2Dclientesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_mensajes2Dclientesedit.Lists["x_idCliente"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocialCli","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$trama_mensajes2Dclientes_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $trama_mensajes2Dclientes_edit->ShowPageHeader(); ?>
<?php
$trama_mensajes2Dclientes_edit->ShowMessage();
?>
<form name="ftrama_mensajes2Dclientesedit" id="ftrama_mensajes2Dclientesedit" class="<?php echo $trama_mensajes2Dclientes_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($trama_mensajes2Dclientes_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $trama_mensajes2Dclientes_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="trama_mensajes2Dclientes">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($trama_mensajes2Dclientes_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($trama_mensajes2Dclientes->getCurrentMasterTable() == "dbo_cliente") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dbo_cliente">
<input type="hidden" name="fk_CodigoCli" value="<?php echo $trama_mensajes2Dclientes->idCliente->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($trama_mensajes2Dclientes->idCliente->Visible) { // idCliente ?>
	<div id="r_idCliente" class="form-group">
		<label id="elh_trama_mensajes2Dclientes_idCliente" for="x_idCliente" class="col-sm-2 control-label ewLabel"><?php echo $trama_mensajes2Dclientes->idCliente->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_mensajes2Dclientes->idCliente->CellAttributes() ?>>
<?php if ($trama_mensajes2Dclientes->idCliente->getSessionValue() <> "") { ?>
<span id="el_trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idCliente" name="x_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el_trama_mensajes2Dclientes_idCliente">
<select data-table="trama_mensajes2Dclientes" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dclientes->idCliente->DisplayValueSeparatorAttribute() ?>" id="x_idCliente" name="x_idCliente"<?php echo $trama_mensajes2Dclientes->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->idCliente->SelectOptionListHtml("x_idCliente") ?>
</select>
<input type="hidden" name="s_x_idCliente" id="s_x_idCliente" value="<?php echo $trama_mensajes2Dclientes->idCliente->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $trama_mensajes2Dclientes->idCliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_trama_mensajes2Dclientes_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $trama_mensajes2Dclientes->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_mensajes2Dclientes->fecha->CellAttributes() ?>>
<span id="el_trama_mensajes2Dclientes_fecha">
<input type="text" data-table="trama_mensajes2Dclientes" data-field="x_fecha" data-format="2" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->getPlaceHolder()) ?>" value="<?php echo $trama_mensajes2Dclientes->fecha->EditValue ?>"<?php echo $trama_mensajes2Dclientes->fecha->EditAttributes() ?>>
<?php if (!$trama_mensajes2Dclientes->fecha->ReadOnly && !$trama_mensajes2Dclientes->fecha->Disabled && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["readonly"]) && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftrama_mensajes2Dclientesedit", "x_fecha", 2);
</script>
<?php } ?>
</span>
<?php echo $trama_mensajes2Dclientes->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->mensaje->Visible) { // mensaje ?>
	<div id="r_mensaje" class="form-group">
		<label id="elh_trama_mensajes2Dclientes_mensaje" for="x_mensaje" class="col-sm-2 control-label ewLabel"><?php echo $trama_mensajes2Dclientes->mensaje->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $trama_mensajes2Dclientes->mensaje->CellAttributes() ?>>
<span id="el_trama_mensajes2Dclientes_mensaje">
<textarea data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->getPlaceHolder()) ?>"<?php echo $trama_mensajes2Dclientes->mensaje->EditAttributes() ?>><?php echo $trama_mensajes2Dclientes->mensaje->EditValue ?></textarea>
</span>
<?php echo $trama_mensajes2Dclientes->mensaje->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->id->CurrentValue) ?>">
<?php if (!$trama_mensajes2Dclientes_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $trama_mensajes2Dclientes_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ftrama_mensajes2Dclientesedit.Init();
</script>
<?php
$trama_mensajes2Dclientes_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$trama_mensajes2Dclientes_edit->Page_Terminate();
?>
