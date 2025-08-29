<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$usuarios_edit = NULL; // Initialize page object first

class cusuarios_edit extends cusuarios {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'usuarios';

	// Page object name
	var $PageObjName = 'usuarios_edit';

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

		// Table object (usuarios)
		if (!isset($GLOBALS["usuarios"])) {
			$GLOBALS["usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuarios"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuarios', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("usuarioslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("usuarioslist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->idUsuario->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $DbMasterFilter;
	var $DbDetailFilter;
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
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["idUsuario"] <> "") {
			$this->idUsuario->setQueryStringValue($_GET["idUsuario"]);
			$this->RecKey["idUsuario"] = $this->idUsuario->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("usuarioslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->idUsuario->CurrentValue) == strval($this->Recordset->fields('idUsuario'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
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
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("usuarioslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "usuariosview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
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
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idUsuario->FldIsDetailKey)
			$this->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
		if (!$this->usuario->FldIsDetailKey) {
			$this->usuario->setFormValue($objForm->GetValue("x_usuario"));
		}
		if (!$this->contrasenia->FldIsDetailKey) {
			$this->contrasenia->setFormValue($objForm->GetValue("x_contrasenia"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->apellido->FldIsDetailKey) {
			$this->apellido->setFormValue($objForm->GetValue("x_apellido"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->idNivel->FldIsDetailKey) {
			$this->idNivel->setFormValue($objForm->GetValue("x_idNivel"));
		}
		if (!$this->activo->FldIsDetailKey) {
			$this->activo->setFormValue($objForm->GetValue("x_activo"));
		}
		if (!$this->observaciones->FldIsDetailKey) {
			$this->observaciones->setFormValue($objForm->GetValue("x_observaciones"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idUsuario->CurrentValue = $this->idUsuario->FormValue;
		$this->usuario->CurrentValue = $this->usuario->FormValue;
		$this->contrasenia->CurrentValue = $this->contrasenia->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->apellido->CurrentValue = $this->apellido->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->idNivel->CurrentValue = $this->idNivel->FormValue;
		$this->activo->CurrentValue = $this->activo->FormValue;
		$this->observaciones->CurrentValue = $this->observaciones->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('edit');
			if (!$res) {
				$sUserIdMsg = $Language->Phrase("NoPermission");
				$this->setFailureMessage($sUserIdMsg);
			}
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
		$this->idUsuario->setDbValue($rs->fields('idUsuario'));
		$this->usuario->setDbValue($rs->fields('usuario'));
		$this->contrasenia->setDbValue($rs->fields('contrasenia'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->apellido->setDbValue($rs->fields('apellido'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->idNivel->setDbValue($rs->fields('idNivel'));
		$this->activo->setDbValue($rs->fields('activo'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idUsuario->DbValue = $row['idUsuario'];
		$this->usuario->DbValue = $row['usuario'];
		$this->contrasenia->DbValue = $row['contrasenia'];
		$this->nombre->DbValue = $row['nombre'];
		$this->apellido->DbValue = $row['apellido'];
		$this->_email->DbValue = $row['email'];
		$this->idNivel->DbValue = $row['idNivel'];
		$this->activo->DbValue = $row['activo'];
		$this->observaciones->DbValue = $row['observaciones'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idUsuario
		// usuario
		// contrasenia
		// nombre
		// apellido
		// email
		// idNivel
		// activo
		// observaciones

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idUsuario
			$this->idUsuario->ViewValue = $this->idUsuario->CurrentValue;
			$this->idUsuario->ViewCustomAttributes = "";

			// usuario
			$this->usuario->ViewValue = $this->usuario->CurrentValue;
			$this->usuario->ViewCustomAttributes = "";

			// contrasenia
			$this->contrasenia->ViewValue = $this->contrasenia->CurrentValue;
			$this->contrasenia->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// apellido
			$this->apellido->ViewValue = $this->apellido->CurrentValue;
			$this->apellido->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// idNivel
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->idNivel->CurrentValue) <> "") {
				$sFilterWrk = "`idNivel`" . ew_SearchString("=", $this->idNivel->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idNivel`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `niveles`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idNivel, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idNivel->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idNivel->ViewValue = $this->idNivel->CurrentValue;
				}
			} else {
				$this->idNivel->ViewValue = NULL;
			}
			} else {
				$this->idNivel->ViewValue = "********";
			}
			$this->idNivel->ViewCustomAttributes = "";

			// activo
			$this->activo->ViewValue = $this->activo->CurrentValue;
			$this->activo->ViewCustomAttributes = "";

			// observaciones
			$this->observaciones->ViewValue = $this->observaciones->CurrentValue;
			$this->observaciones->ViewCustomAttributes = "";

			// idUsuario
			$this->idUsuario->LinkCustomAttributes = "";
			$this->idUsuario->HrefValue = "";
			$this->idUsuario->TooltipValue = "";

			// usuario
			$this->usuario->LinkCustomAttributes = "";
			$this->usuario->HrefValue = "";
			$this->usuario->TooltipValue = "";

			// contrasenia
			$this->contrasenia->LinkCustomAttributes = "";
			$this->contrasenia->HrefValue = "";
			$this->contrasenia->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";
			$this->apellido->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// idNivel
			$this->idNivel->LinkCustomAttributes = "";
			$this->idNivel->HrefValue = "";
			$this->idNivel->TooltipValue = "";

			// activo
			$this->activo->LinkCustomAttributes = "";
			$this->activo->HrefValue = "";
			$this->activo->TooltipValue = "";

			// observaciones
			$this->observaciones->LinkCustomAttributes = "";
			$this->observaciones->HrefValue = "";
			$this->observaciones->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idUsuario
			$this->idUsuario->EditCustomAttributes = "";
			$this->idUsuario->EditValue = $this->idUsuario->CurrentValue;
			$this->idUsuario->ViewCustomAttributes = "";

			// usuario
			$this->usuario->EditCustomAttributes = "";
			$this->usuario->EditValue = ew_HtmlEncode($this->usuario->CurrentValue);
			$this->usuario->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->usuario->FldCaption()));

			// contrasenia
			$this->contrasenia->EditCustomAttributes = "";
			$this->contrasenia->EditValue = ew_HtmlEncode($this->contrasenia->CurrentValue);
			$this->contrasenia->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contrasenia->FldCaption()));

			// nombre
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->nombre->FldCaption()));

			// apellido
			$this->apellido->EditCustomAttributes = "";
			$this->apellido->EditValue = ew_HtmlEncode($this->apellido->CurrentValue);
			$this->apellido->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->apellido->FldCaption()));

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// idNivel
			$this->idNivel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->idNivel->EditValue = "********";
			} else {
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `idNivel`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `niveles`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idNivel, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idNivel->EditValue = $arwrk;
			}

			// activo
			$this->activo->EditCustomAttributes = "";
			$this->activo->EditValue = ew_HtmlEncode($this->activo->CurrentValue);
			$this->activo->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->activo->FldCaption()));

			// observaciones
			$this->observaciones->EditCustomAttributes = "";
			$this->observaciones->EditValue = $this->observaciones->CurrentValue;
			$this->observaciones->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->observaciones->FldCaption()));

			// Edit refer script
			// idUsuario

			$this->idUsuario->HrefValue = "";

			// usuario
			$this->usuario->HrefValue = "";

			// contrasenia
			$this->contrasenia->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// apellido
			$this->apellido->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// idNivel
			$this->idNivel->HrefValue = "";

			// activo
			$this->activo->HrefValue = "";

			// observaciones
			$this->observaciones->HrefValue = "";
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
		if (!$this->usuario->FldIsDetailKey && !is_null($this->usuario->FormValue) && $this->usuario->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->usuario->FldCaption());
		}
		if (!$this->contrasenia->FldIsDetailKey && !is_null($this->contrasenia->FormValue) && $this->contrasenia->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->contrasenia->FldCaption());
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->nombre->FldCaption());
		}
		if (!$this->apellido->FldIsDetailKey && !is_null($this->apellido->FormValue) && $this->apellido->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->apellido->FldCaption());
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->_email->FldCaption());
		}
		if (!$this->idNivel->FldIsDetailKey && !is_null($this->idNivel->FormValue) && $this->idNivel->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->idNivel->FldCaption());
		}
		if (!$this->activo->FldIsDetailKey && !is_null($this->activo->FormValue) && $this->activo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->activo->FldCaption());
		}
		if (!ew_CheckInteger($this->activo->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo->FldErrMsg());
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

			// usuario
			$this->usuario->SetDbValueDef($rsnew, $this->usuario->CurrentValue, "", $this->usuario->ReadOnly);

			// contrasenia
			$this->contrasenia->SetDbValueDef($rsnew, $this->contrasenia->CurrentValue, "", $this->contrasenia->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('contrasenia') == $this->contrasenia->CurrentValue));

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", $this->nombre->ReadOnly);

			// apellido
			$this->apellido->SetDbValueDef($rsnew, $this->apellido->CurrentValue, "", $this->apellido->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// idNivel
			if ($Security->CanAdmin()) { // System admin
			$this->idNivel->SetDbValueDef($rsnew, $this->idNivel->CurrentValue, 0, $this->idNivel->ReadOnly);
			}

			// activo
			$this->activo->SetDbValueDef($rsnew, $this->activo->CurrentValue, 0, $this->activo->ReadOnly);

			// observaciones
			$this->observaciones->SetDbValueDef($rsnew, $this->observaciones->CurrentValue, NULL, $this->observaciones->ReadOnly);

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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->idUsuario->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "usuarioslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($usuarios_edit)) $usuarios_edit = new cusuarios_edit();

// Page init
$usuarios_edit->Page_Init();

// Page main
$usuarios_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var usuarios_edit = new ew_Page("usuarios_edit");
usuarios_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = usuarios_edit.PageID; // For backward compatibility

// Form object
var fusuariosedit = new ew_Form("fusuariosedit");

// Validate form
fusuariosedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_usuario");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->usuario->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_contrasenia");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->contrasenia->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->nombre->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_apellido");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->apellido->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->_email->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_idNivel");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->idNivel->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_activo");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($usuarios->activo->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_activo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($usuarios->activo->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

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
fusuariosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusuariosedit.ValidateRequired = true;
<?php } else { ?>
fusuariosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fusuariosedit.Lists["x_idNivel"] = {"LinkField":"x_idNivel","Ajax":null,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $usuarios_edit->ShowPageHeader(); ?>
<?php
$usuarios_edit->ShowMessage();
?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($usuarios_edit->Pager)) $usuarios_edit->Pager = new cPrevNextPager($usuarios_edit->StartRec, $usuarios_edit->DisplayRecs, $usuarios_edit->TotalRecs) ?>
<?php if ($usuarios_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($usuarios_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $usuarios_edit->PageUrl() ?>start=<?php echo $usuarios_edit->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($usuarios_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $usuarios_edit->PageUrl() ?>start=<?php echo $usuarios_edit->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $usuarios_edit->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($usuarios_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $usuarios_edit->PageUrl() ?>start=<?php echo $usuarios_edit->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($usuarios_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $usuarios_edit->PageUrl() ?>start=<?php echo $usuarios_edit->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $usuarios_edit->Pager->PageCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
</form>
<form name="fusuariosedit" id="fusuariosedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_usuariosedit" class="table table-bordered table-striped">
<?php if ($usuarios->idUsuario->Visible) { // idUsuario ?>
	<tr id="r_idUsuario">
		<td><span id="elh_usuarios_idUsuario"><?php echo $usuarios->idUsuario->FldCaption() ?></span></td>
		<td<?php echo $usuarios->idUsuario->CellAttributes() ?>>
<span id="el_usuarios_idUsuario" class="control-group">
<span<?php echo $usuarios->idUsuario->ViewAttributes() ?>>
<?php echo $usuarios->idUsuario->EditValue ?></span>
</span>
<input type="hidden" data-field="x_idUsuario" name="x_idUsuario" id="x_idUsuario" value="<?php echo ew_HtmlEncode($usuarios->idUsuario->CurrentValue) ?>">
<?php echo $usuarios->idUsuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
	<tr id="r_usuario">
		<td><span id="elh_usuarios_usuario"><?php echo $usuarios->usuario->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->usuario->CellAttributes() ?>>
<span id="el_usuarios_usuario" class="control-group">
<input type="text" data-field="x_usuario" name="x_usuario" id="x_usuario" size="30" maxlength="255" placeholder="<?php echo $usuarios->usuario->PlaceHolder ?>" value="<?php echo $usuarios->usuario->EditValue ?>"<?php echo $usuarios->usuario->EditAttributes() ?>>
</span>
<?php echo $usuarios->usuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->contrasenia->Visible) { // contrasenia ?>
	<tr id="r_contrasenia">
		<td><span id="elh_usuarios_contrasenia"><?php echo $usuarios->contrasenia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->contrasenia->CellAttributes() ?>>
<span id="el_usuarios_contrasenia" class="control-group">
<input type="text" data-field="x_contrasenia" name="x_contrasenia" id="x_contrasenia" size="30" maxlength="255" placeholder="<?php echo $usuarios->contrasenia->PlaceHolder ?>" value="<?php echo $usuarios->contrasenia->EditValue ?>"<?php echo $usuarios->contrasenia->EditAttributes() ?>>
</span>
<?php echo $usuarios->contrasenia->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->nombre->Visible) { // nombre ?>
	<tr id="r_nombre">
		<td><span id="elh_usuarios_nombre"><?php echo $usuarios->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->nombre->CellAttributes() ?>>
<span id="el_usuarios_nombre" class="control-group">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="255" placeholder="<?php echo $usuarios->nombre->PlaceHolder ?>" value="<?php echo $usuarios->nombre->EditValue ?>"<?php echo $usuarios->nombre->EditAttributes() ?>>
</span>
<?php echo $usuarios->nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->apellido->Visible) { // apellido ?>
	<tr id="r_apellido">
		<td><span id="elh_usuarios_apellido"><?php echo $usuarios->apellido->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->apellido->CellAttributes() ?>>
<span id="el_usuarios_apellido" class="control-group">
<input type="text" data-field="x_apellido" name="x_apellido" id="x_apellido" size="30" maxlength="255" placeholder="<?php echo $usuarios->apellido->PlaceHolder ?>" value="<?php echo $usuarios->apellido->EditValue ?>"<?php echo $usuarios->apellido->EditAttributes() ?>>
</span>
<?php echo $usuarios->apellido->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_usuarios__email"><?php echo $usuarios->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->_email->CellAttributes() ?>>
<span id="el_usuarios__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo $usuarios->_email->PlaceHolder ?>" value="<?php echo $usuarios->_email->EditValue ?>"<?php echo $usuarios->_email->EditAttributes() ?>>
</span>
<?php echo $usuarios->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->idNivel->Visible) { // idNivel ?>
	<tr id="r_idNivel">
		<td><span id="elh_usuarios_idNivel"><?php echo $usuarios->idNivel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->idNivel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_usuarios_idNivel" class="control-group">
<?php echo $usuarios->idNivel->EditValue ?>
</span>
<?php } else { ?>
<span id="el_usuarios_idNivel" class="control-group">
<select data-field="x_idNivel" id="x_idNivel" name="x_idNivel"<?php echo $usuarios->idNivel->EditAttributes() ?>>
<?php
if (is_array($usuarios->idNivel->EditValue)) {
	$arwrk = $usuarios->idNivel->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuarios->idNivel->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<script type="text/javascript">
fusuariosedit.Lists["x_idNivel"].Options = <?php echo (is_array($usuarios->idNivel->EditValue)) ? ew_ArrayToJson($usuarios->idNivel->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php echo $usuarios->idNivel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->activo->Visible) { // activo ?>
	<tr id="r_activo">
		<td><span id="elh_usuarios_activo"><?php echo $usuarios->activo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $usuarios->activo->CellAttributes() ?>>
<span id="el_usuarios_activo" class="control-group">
<input type="text" data-field="x_activo" name="x_activo" id="x_activo" size="30" placeholder="<?php echo $usuarios->activo->PlaceHolder ?>" value="<?php echo $usuarios->activo->EditValue ?>"<?php echo $usuarios->activo->EditAttributes() ?>>
</span>
<?php echo $usuarios->activo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuarios->observaciones->Visible) { // observaciones ?>
	<tr id="r_observaciones">
		<td><span id="elh_usuarios_observaciones"><?php echo $usuarios->observaciones->FldCaption() ?></span></td>
		<td<?php echo $usuarios->observaciones->CellAttributes() ?>>
<span id="el_usuarios_observaciones" class="control-group">
<textarea data-field="x_observaciones" name="x_observaciones" id="x_observaciones" cols="35" rows="4" placeholder="<?php echo $usuarios->observaciones->PlaceHolder ?>"<?php echo $usuarios->observaciones->EditAttributes() ?>><?php echo $usuarios->observaciones->EditValue ?></textarea>
</span>
<?php echo $usuarios->observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fusuariosedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$usuarios_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$usuarios_edit->Page_Terminate();
?>
