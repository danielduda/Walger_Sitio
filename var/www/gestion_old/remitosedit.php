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

$remitos_edit = NULL; // Initialize page object first

class cremitos_edit extends cremitos {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'remitos';

	// Page object name
	var $PageObjName = 'remitos_edit';

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

		// Table object (remitos)
		if (!isset($GLOBALS["remitos"])) {
			$GLOBALS["remitos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["remitos"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'remitos', TRUE);

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
			$this->Page_Terminate("remitoslist.php");
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
		if (@$_GET["Id_Remito"] <> "") {
			$this->Id_Remito->setQueryStringValue($_GET["Id_Remito"]);
			$this->RecKey["Id_Remito"] = $this->Id_Remito->QueryStringValue;
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
			$this->Page_Terminate("remitoslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->Id_Remito->CurrentValue) == strval($this->Recordset->fields('Id_Remito'))) {
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
					$this->Page_Terminate("remitoslist.php"); // Return to list page
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
					if (ew_GetPageName($sReturnUrl) == "remitosview.php")
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
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->observacionesInternas->FldIsDetailKey) {
			$this->observacionesInternas->setFormValue($objForm->GetValue("x_observacionesInternas"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->Id_Remito->FldIsDetailKey)
			$this->Id_Remito->setFormValue($objForm->GetValue("x_Id_Remito"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Remito->CurrentValue = $this->Id_Remito->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->observacionesInternas->CurrentValue = $this->observacionesInternas->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Remito
		// numeroRemito
		// Fecha
		// tipoDestinatario
		// Cliente
		// Proveedor
		// Transporte
		// NumeroDeBultos
		// OperadorTraslado
		// OperadorEntrego
		// OperadorVerifico
		// Observaciones
		// Importe
		// facturas
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

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// observacionesInternas
			$this->observacionesInternas->LinkCustomAttributes = "";
			$this->observacionesInternas->HrefValue = "";
			$this->observacionesInternas->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Observaciones
			$this->Observaciones->EditCustomAttributes = "";
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);
			$this->Observaciones->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Observaciones->FldCaption()));

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

			// Edit refer script
			// Observaciones

			$this->Observaciones->HrefValue = "";

			// observacionesInternas
			$this->observacionesInternas->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";
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

			// Observaciones
			$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, $this->Observaciones->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "remitoslist.php", $this->TableVar);
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
if (!isset($remitos_edit)) $remitos_edit = new cremitos_edit();

// Page init
$remitos_edit->Page_Init();

// Page main
$remitos_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var remitos_edit = new ew_Page("remitos_edit");
remitos_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = remitos_edit.PageID; // For backward compatibility

// Form object
var fremitosedit = new ew_Form("fremitosedit");

// Validate form
fremitosedit.Validate = function() {
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
fremitosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitosedit.ValidateRequired = true;
<?php } else { ?>
fremitosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $remitos_edit->ShowPageHeader(); ?>
<?php
$remitos_edit->ShowMessage();
?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($remitos_edit->Pager)) $remitos_edit->Pager = new cPrevNextPager($remitos_edit->StartRec, $remitos_edit->DisplayRecs, $remitos_edit->TotalRecs) ?>
<?php if ($remitos_edit->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($remitos_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_edit->PageUrl() ?>start=<?php echo $remitos_edit->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($remitos_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_edit->PageUrl() ?>start=<?php echo $remitos_edit->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $remitos_edit->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($remitos_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_edit->PageUrl() ?>start=<?php echo $remitos_edit->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($remitos_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $remitos_edit->PageUrl() ?>start=<?php echo $remitos_edit->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small" disabled="disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $remitos_edit->Pager->PageCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
<?php } ?>
</td>
</tr></table>
</form>
<form name="fremitosedit" id="fremitosedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="remitos">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_remitosedit" class="table table-bordered table-striped">
<?php if ($remitos->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones">
		<td><span id="elh_remitos_Observaciones"><?php echo $remitos->Observaciones->FldCaption() ?></span></td>
		<td<?php echo $remitos->Observaciones->CellAttributes() ?>>
<span id="el_remitos_Observaciones" class="control-group">
<input type="text" data-field="x_Observaciones" name="x_Observaciones" id="x_Observaciones" size="30" maxlength="100" placeholder="<?php echo $remitos->Observaciones->PlaceHolder ?>" value="<?php echo $remitos->Observaciones->EditValue ?>"<?php echo $remitos->Observaciones->EditAttributes() ?>>
</span>
<?php echo $remitos->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
	<tr id="r_observacionesInternas">
		<td><span id="elh_remitos_observacionesInternas"><?php echo $remitos->observacionesInternas->FldCaption() ?></span></td>
		<td<?php echo $remitos->observacionesInternas->CellAttributes() ?>>
<span id="el_remitos_observacionesInternas" class="control-group">
<input type="text" data-field="x_observacionesInternas" name="x_observacionesInternas" id="x_observacionesInternas" size="30" maxlength="255" placeholder="<?php echo $remitos->observacionesInternas->PlaceHolder ?>" value="<?php echo $remitos->observacionesInternas->EditValue ?>"<?php echo $remitos->observacionesInternas->EditAttributes() ?>>
</span>
<?php echo $remitos->observacionesInternas->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_remitos_estado"><?php echo $remitos->estado->FldCaption() ?></span></td>
		<td<?php echo $remitos->estado->CellAttributes() ?>>
<span id="el_remitos_estado" class="control-group">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $remitos->estado->EditAttributes() ?>>
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
<?php echo $remitos->estado->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<input type="hidden" data-field="x_Id_Remito" name="x_Id_Remito" id="x_Id_Remito" value="<?php echo ew_HtmlEncode($remitos->Id_Remito->CurrentValue) ?>">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
fremitosedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$remitos_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$remitos_edit->Page_Terminate();
?>
