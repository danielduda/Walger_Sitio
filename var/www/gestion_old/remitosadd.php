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

$remitos_add = NULL; // Initialize page object first

class cremitos_add extends cremitos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'remitos';

	// Page object name
	var $PageObjName = 'remitos_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id_Remito"] != "") {
				$this->Id_Remito->setQueryStringValue($_GET["Id_Remito"]);
				$this->setKey("Id_Remito", $this->Id_Remito->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Remito", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("remitoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "remitosview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->numeroRemito->CurrentValue = NULL;
		$this->numeroRemito->OldValue = $this->numeroRemito->CurrentValue;
		$this->Fecha->CurrentValue = ew_CurrentDate();
		$this->tipoDestinatario->CurrentValue = NULL;
		$this->tipoDestinatario->OldValue = $this->tipoDestinatario->CurrentValue;
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
		$this->OperadorEntrego->CurrentValue = NULL;
		$this->OperadorEntrego->OldValue = $this->OperadorEntrego->CurrentValue;
		$this->OperadorVerifico->CurrentValue = NULL;
		$this->OperadorVerifico->OldValue = $this->OperadorVerifico->CurrentValue;
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
		$this->Importe->CurrentValue = NULL;
		$this->Importe->OldValue = $this->Importe->CurrentValue;
		$this->facturas->CurrentValue = NULL;
		$this->facturas->OldValue = $this->facturas->CurrentValue;
		$this->observacionesInternas->CurrentValue = NULL;
		$this->observacionesInternas->OldValue = $this->observacionesInternas->CurrentValue;
		$this->estado->CurrentValue = 0;
		$this->resultado->CurrentValue = NULL;
		$this->resultado->OldValue = $this->resultado->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->numeroRemito->FldIsDetailKey) {
			$this->numeroRemito->setFormValue($objForm->GetValue("x_numeroRemito"));
		}
		if (!$this->Fecha->FldIsDetailKey) {
			$this->Fecha->setFormValue($objForm->GetValue("x_Fecha"));
			$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		}
		if (!$this->tipoDestinatario->FldIsDetailKey) {
			$this->tipoDestinatario->setFormValue($objForm->GetValue("x_tipoDestinatario"));
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
		if (!$this->OperadorEntrego->FldIsDetailKey) {
			$this->OperadorEntrego->setFormValue($objForm->GetValue("x_OperadorEntrego"));
		}
		if (!$this->OperadorVerifico->FldIsDetailKey) {
			$this->OperadorVerifico->setFormValue($objForm->GetValue("x_OperadorVerifico"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->Importe->FldIsDetailKey) {
			$this->Importe->setFormValue($objForm->GetValue("x_Importe"));
		}
		if (!$this->facturas->FldIsDetailKey) {
			$this->facturas->setFormValue($objForm->GetValue("x_facturas"));
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
		if (!$this->Id_Remito->FldIsDetailKey)
			$this->Id_Remito->setFormValue($objForm->GetValue("x_Id_Remito"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Remito->CurrentValue = $this->Id_Remito->FormValue;
		$this->numeroRemito->CurrentValue = $this->numeroRemito->FormValue;
		$this->Fecha->CurrentValue = $this->Fecha->FormValue;
		$this->Fecha->CurrentValue = ew_UnFormatDateTime($this->Fecha->CurrentValue, 7);
		$this->tipoDestinatario->CurrentValue = $this->tipoDestinatario->FormValue;
		$this->Cliente->CurrentValue = $this->Cliente->FormValue;
		$this->Proveedor->CurrentValue = $this->Proveedor->FormValue;
		$this->Transporte->CurrentValue = $this->Transporte->FormValue;
		$this->NumeroDeBultos->CurrentValue = $this->NumeroDeBultos->FormValue;
		$this->OperadorTraslado->CurrentValue = $this->OperadorTraslado->FormValue;
		$this->OperadorEntrego->CurrentValue = $this->OperadorEntrego->FormValue;
		$this->OperadorVerifico->CurrentValue = $this->OperadorVerifico->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->Importe->CurrentValue = $this->Importe->FormValue;
		$this->facturas->CurrentValue = $this->facturas->FormValue;
		$this->observacionesInternas->CurrentValue = $this->observacionesInternas->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->resultado->CurrentValue = $this->resultado->FormValue;
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

			// tipoDestinatario
			$this->tipoDestinatario->ViewValue = $this->tipoDestinatario->CurrentValue;
			$this->tipoDestinatario->ViewCustomAttributes = "";

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

			// OperadorEntrego
			$this->OperadorEntrego->ViewValue = $this->OperadorEntrego->CurrentValue;
			if (strval($this->OperadorEntrego->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorEntrego->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorEntrego, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorEntrego->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorEntrego->ViewValue = $this->OperadorEntrego->CurrentValue;
				}
			} else {
				$this->OperadorEntrego->ViewValue = NULL;
			}
			$this->OperadorEntrego->ViewCustomAttributes = "";

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

			// facturas
			$this->facturas->ViewValue = $this->facturas->CurrentValue;
			$this->facturas->ViewCustomAttributes = "";

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

			// numeroRemito
			$this->numeroRemito->LinkCustomAttributes = "";
			$this->numeroRemito->HrefValue = "";
			$this->numeroRemito->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// tipoDestinatario
			$this->tipoDestinatario->LinkCustomAttributes = "";
			$this->tipoDestinatario->HrefValue = "";
			$this->tipoDestinatario->TooltipValue = "";

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

			// OperadorEntrego
			$this->OperadorEntrego->LinkCustomAttributes = "";
			$this->OperadorEntrego->HrefValue = "";
			$this->OperadorEntrego->TooltipValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->LinkCustomAttributes = "";
			$this->OperadorVerifico->HrefValue = "";
			$this->OperadorVerifico->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Importe
			$this->Importe->LinkCustomAttributes = "";
			$this->Importe->HrefValue = "";
			$this->Importe->TooltipValue = "";

			// facturas
			$this->facturas->LinkCustomAttributes = "";
			$this->facturas->HrefValue = "";
			$this->facturas->TooltipValue = "";

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

			// numeroRemito
			$this->numeroRemito->EditCustomAttributes = "";
			$this->numeroRemito->EditValue = ew_HtmlEncode($this->numeroRemito->CurrentValue);
			$this->numeroRemito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->numeroRemito->FldCaption()));

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha->CurrentValue, 7));
			$this->Fecha->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Fecha->FldCaption()));

			// tipoDestinatario
			$this->tipoDestinatario->EditCustomAttributes = "";
			$this->tipoDestinatario->EditValue = ew_HtmlEncode($this->tipoDestinatario->CurrentValue);
			$this->tipoDestinatario->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->tipoDestinatario->FldCaption()));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$this->Cliente->EditValue = ew_HtmlEncode($this->Cliente->CurrentValue);
			$this->Cliente->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Cliente->FldCaption()));

			// Proveedor
			$this->Proveedor->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Proveedores`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Proveedor, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `razonSocial` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Proveedor->EditValue = $arwrk;

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
			$this->OperadorTraslado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorTraslado->FldCaption()));

			// OperadorEntrego
			$this->OperadorEntrego->EditCustomAttributes = "";
			$this->OperadorEntrego->EditValue = ew_HtmlEncode($this->OperadorEntrego->CurrentValue);
			if (strval($this->OperadorEntrego->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorEntrego->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorEntrego, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->OperadorEntrego->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->OperadorEntrego->EditValue = $this->OperadorEntrego->CurrentValue;
				}
			} else {
				$this->OperadorEntrego->EditValue = NULL;
			}
			$this->OperadorEntrego->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorEntrego->FldCaption()));

			// OperadorVerifico
			$this->OperadorVerifico->EditCustomAttributes = "";
			$this->OperadorVerifico->EditValue = ew_HtmlEncode($this->OperadorVerifico->CurrentValue);
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
			$this->OperadorVerifico->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorVerifico->FldCaption()));

			// Observaciones
			$this->Observaciones->EditCustomAttributes = "";
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);
			$this->Observaciones->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Observaciones->FldCaption()));

			// Importe
			$this->Importe->EditCustomAttributes = "";
			$this->Importe->EditValue = ew_HtmlEncode($this->Importe->CurrentValue);
			$this->Importe->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Importe->FldCaption()));

			// facturas
			$this->facturas->EditCustomAttributes = "";
			$this->facturas->EditValue = ew_HtmlEncode($this->facturas->CurrentValue);
			$this->facturas->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->facturas->FldCaption()));

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
			// numeroRemito

			$this->numeroRemito->HrefValue = "";

			// Fecha
			$this->Fecha->HrefValue = "";

			// tipoDestinatario
			$this->tipoDestinatario->HrefValue = "";

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

			// OperadorEntrego
			$this->OperadorEntrego->HrefValue = "";

			// OperadorVerifico
			$this->OperadorVerifico->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Importe
			$this->Importe->HrefValue = "";

			// facturas
			$this->facturas->HrefValue = "";

			// observacionesInternas
			$this->observacionesInternas->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// resultado
			$this->resultado->HrefValue = "";
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
		if (!ew_CheckInteger($this->numeroRemito->FormValue)) {
			ew_AddMessage($gsFormError, $this->numeroRemito->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipoDestinatario->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipoDestinatario->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Transporte->FormValue)) {
			ew_AddMessage($gsFormError, $this->Transporte->FldErrMsg());
		}
		if (!ew_CheckInteger($this->NumeroDeBultos->FormValue)) {
			ew_AddMessage($gsFormError, $this->NumeroDeBultos->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorTraslado->FormValue)) {
			ew_AddMessage($gsFormError, $this->OperadorTraslado->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorEntrego->FormValue)) {
			ew_AddMessage($gsFormError, $this->OperadorEntrego->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorVerifico->FormValue)) {
			ew_AddMessage($gsFormError, $this->OperadorVerifico->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// numeroRemito
		$this->numeroRemito->SetDbValueDef($rsnew, $this->numeroRemito->CurrentValue, NULL, FALSE);

		// Fecha
		$this->Fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha->CurrentValue, 7), NULL, FALSE);

		// tipoDestinatario
		$this->tipoDestinatario->SetDbValueDef($rsnew, $this->tipoDestinatario->CurrentValue, NULL, FALSE);

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

		// OperadorEntrego
		$this->OperadorEntrego->SetDbValueDef($rsnew, $this->OperadorEntrego->CurrentValue, NULL, FALSE);

		// OperadorVerifico
		$this->OperadorVerifico->SetDbValueDef($rsnew, $this->OperadorVerifico->CurrentValue, NULL, FALSE);

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Importe
		$this->Importe->SetDbValueDef($rsnew, $this->Importe->CurrentValue, NULL, FALSE);

		// facturas
		$this->facturas->SetDbValueDef($rsnew, $this->facturas->CurrentValue, NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "remitoslist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($remitos_add)) $remitos_add = new cremitos_add();

// Page init
$remitos_add->Page_Init();

// Page main
$remitos_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var remitos_add = new ew_Page("remitos_add");
remitos_add.PageID = "add"; // Page ID
var EW_PAGE_ID = remitos_add.PageID; // For backward compatibility

// Form object
var fremitosadd = new ew_Form("fremitosadd");

// Validate form
fremitosadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_numeroRemito");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->numeroRemito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->Fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipoDestinatario");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->tipoDestinatario->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Transporte");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->Transporte->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NumeroDeBultos");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->NumeroDeBultos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_OperadorTraslado");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->OperadorTraslado->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_OperadorEntrego");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->OperadorEntrego->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_OperadorVerifico");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitos->OperadorVerifico->FldErrMsg()) ?>");

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
fremitosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitosadd.ValidateRequired = true;
<?php } else { ?>
fremitosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitosadd.Lists["x_Proveedor"] = {"LinkField":"x_Id_Proveedores","Ajax":null,"AutoFill":false,"DisplayFields":["x_razonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosadd.Lists["x_OperadorTraslado"] = {"LinkField":"x_idTransporteInterno","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacionTransporte","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosadd.Lists["x_OperadorEntrego"] = {"LinkField":"x_Id_Operadores","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosadd.Lists["x_OperadorVerifico"] = {"LinkField":"x_Id_Operadores","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $remitos_add->ShowPageHeader(); ?>
<?php
$remitos_add->ShowMessage();
?>
<form name="fremitosadd" id="fremitosadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="remitos">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_remitosadd" class="table table-bordered table-striped">
<?php if ($remitos->numeroRemito->Visible) { // numeroRemito ?>
	<tr id="r_numeroRemito">
		<td><span id="elh_remitos_numeroRemito"><?php echo $remitos->numeroRemito->FldCaption() ?></span></td>
		<td<?php echo $remitos->numeroRemito->CellAttributes() ?>>
<span id="el_remitos_numeroRemito" class="control-group">
<input type="text" data-field="x_numeroRemito" name="x_numeroRemito" id="x_numeroRemito" size="30" maxlength="13" placeholder="<?php echo $remitos->numeroRemito->PlaceHolder ?>" value="<?php echo $remitos->numeroRemito->EditValue ?>"<?php echo $remitos->numeroRemito->EditAttributes() ?>>
</span>
<?php echo $remitos->numeroRemito->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
	<tr id="r_Fecha">
		<td><span id="elh_remitos_Fecha"><?php echo $remitos->Fecha->FldCaption() ?></span></td>
		<td<?php echo $remitos->Fecha->CellAttributes() ?>>
<span id="el_remitos_Fecha" class="control-group">
<input type="text" data-field="x_Fecha" name="x_Fecha" id="x_Fecha" placeholder="<?php echo $remitos->Fecha->PlaceHolder ?>" value="<?php echo $remitos->Fecha->EditValue ?>"<?php echo $remitos->Fecha->EditAttributes() ?>>
<?php if (!$remitos->Fecha->ReadOnly && !$remitos->Fecha->Disabled && @$remitos->Fecha->EditAttrs["readonly"] == "" && @$remitos->Fecha->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_Fecha" name="cal_x_Fecha" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_Fecha" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fremitosadd", "x_Fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $remitos->Fecha->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->tipoDestinatario->Visible) { // tipoDestinatario ?>
	<tr id="r_tipoDestinatario">
		<td><span id="elh_remitos_tipoDestinatario"><?php echo $remitos->tipoDestinatario->FldCaption() ?></span></td>
		<td<?php echo $remitos->tipoDestinatario->CellAttributes() ?>>
<span id="el_remitos_tipoDestinatario" class="control-group">
<input type="text" data-field="x_tipoDestinatario" name="x_tipoDestinatario" id="x_tipoDestinatario" size="30" placeholder="<?php echo $remitos->tipoDestinatario->PlaceHolder ?>" value="<?php echo $remitos->tipoDestinatario->EditValue ?>"<?php echo $remitos->tipoDestinatario->EditAttributes() ?>>
</span>
<?php echo $remitos->tipoDestinatario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
	<tr id="r_Cliente">
		<td><span id="elh_remitos_Cliente"><?php echo $remitos->Cliente->FldCaption() ?></span></td>
		<td<?php echo $remitos->Cliente->CellAttributes() ?>>
<span id="el_remitos_Cliente" class="control-group">
<input type="text" data-field="x_Cliente" name="x_Cliente" id="x_Cliente" size="30" maxlength="10" placeholder="<?php echo $remitos->Cliente->PlaceHolder ?>" value="<?php echo $remitos->Cliente->EditValue ?>"<?php echo $remitos->Cliente->EditAttributes() ?>>
</span>
<?php echo $remitos->Cliente->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
	<tr id="r_Proveedor">
		<td><span id="elh_remitos_Proveedor"><?php echo $remitos->Proveedor->FldCaption() ?></span></td>
		<td<?php echo $remitos->Proveedor->CellAttributes() ?>>
<span id="el_remitos_Proveedor" class="control-group">
<select data-field="x_Proveedor" id="x_Proveedor" name="x_Proveedor"<?php echo $remitos->Proveedor->EditAttributes() ?>>
<?php
if (is_array($remitos->Proveedor->EditValue)) {
	$arwrk = $remitos->Proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos->Proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php if (AllowAdd(CurrentProjectID() . "proveedores")) { ?>
&nbsp;<a id="aol_x_Proveedor" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_Proveedor',url:'proveedoresaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $remitos->Proveedor->FldCaption() ?></a>
<?php } ?>
<script type="text/javascript">
fremitosadd.Lists["x_Proveedor"].Options = <?php echo (is_array($remitos->Proveedor->EditValue)) ? ew_ArrayToJson($remitos->Proveedor->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $remitos->Proveedor->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
	<tr id="r_Transporte">
		<td><span id="elh_remitos_Transporte"><?php echo $remitos->Transporte->FldCaption() ?></span></td>
		<td<?php echo $remitos->Transporte->CellAttributes() ?>>
<span id="el_remitos_Transporte" class="control-group">
<input type="text" data-field="x_Transporte" name="x_Transporte" id="x_Transporte" size="30" maxlength="30" placeholder="<?php echo $remitos->Transporte->PlaceHolder ?>" value="<?php echo $remitos->Transporte->EditValue ?>"<?php echo $remitos->Transporte->EditAttributes() ?>>
</span>
<?php echo $remitos->Transporte->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
	<tr id="r_NumeroDeBultos">
		<td><span id="elh_remitos_NumeroDeBultos"><?php echo $remitos->NumeroDeBultos->FldCaption() ?></span></td>
		<td<?php echo $remitos->NumeroDeBultos->CellAttributes() ?>>
<span id="el_remitos_NumeroDeBultos" class="control-group">
<input type="text" data-field="x_NumeroDeBultos" name="x_NumeroDeBultos" id="x_NumeroDeBultos" size="30" placeholder="<?php echo $remitos->NumeroDeBultos->PlaceHolder ?>" value="<?php echo $remitos->NumeroDeBultos->EditValue ?>"<?php echo $remitos->NumeroDeBultos->EditAttributes() ?>>
</span>
<?php echo $remitos->NumeroDeBultos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
	<tr id="r_OperadorTraslado">
		<td><span id="elh_remitos_OperadorTraslado"><?php echo $remitos->OperadorTraslado->FldCaption() ?></span></td>
		<td<?php echo $remitos->OperadorTraslado->CellAttributes() ?>>
<span id="el_remitos_OperadorTraslado" class="control-group">
<?php
	$wrkonchange = trim(" " . @$remitos->OperadorTraslado->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$remitos->OperadorTraslado->EditAttrs["onchange"] = "";
?>
<span id="as_x_OperadorTraslado" style="white-space: nowrap; z-index: 8910">
	<input type="text" name="sv_x_OperadorTraslado" id="sv_x_OperadorTraslado" value="<?php echo $remitos->OperadorTraslado->EditValue ?>" size="30" placeholder="<?php echo $remitos->OperadorTraslado->PlaceHolder ?>"<?php echo $remitos->OperadorTraslado->EditAttributes() ?>>&nbsp;<span id="em_x_OperadorTraslado" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_OperadorTraslado" style="display: inline; z-index: 8910"></div>
</span>
<input type="hidden" data-field="x_OperadorTraslado" name="x_OperadorTraslado" id="x_OperadorTraslado" value="<?php echo $remitos->OperadorTraslado->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `idTransporteInterno`, `denominacionTransporte` AS `DispFld` FROM `transporte_interno`";
$sWhereWrk = "`denominacionTransporte` LIKE '{query_value}%'";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorTraslado, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `denominacionTransporte` ASC";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_OperadorTraslado" id="q_x_OperadorTraslado" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_OperadorTraslado", fremitosadd, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorTraslado") + ar[i] : "";
	return dv;
}
fremitosadd.AutoSuggests["x_OperadorTraslado"] = oas;
</script>
<?php if (AllowAdd(CurrentProjectID() . "transporte_interno")) { ?>
&nbsp;<a id="aol_x_OperadorTraslado" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_OperadorTraslado',url:'transporte_internoaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $remitos->OperadorTraslado->FldCaption() ?></a>
<?php } ?>
<?php
$sSqlWrk = "SELECT `idTransporteInterno`, `denominacionTransporte` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte_interno`";
$sWhereWrk = "{filter}";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorTraslado, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `denominacionTransporte` ASC";
?>
<input type="hidden" name="s_x_OperadorTraslado" id="s_x_OperadorTraslado" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`idTransporteInterno` = {filter_value}"); ?>&t0=19">
</span>
<?php echo $remitos->OperadorTraslado->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorEntrego->Visible) { // OperadorEntrego ?>
	<tr id="r_OperadorEntrego">
		<td><span id="elh_remitos_OperadorEntrego"><?php echo $remitos->OperadorEntrego->FldCaption() ?></span></td>
		<td<?php echo $remitos->OperadorEntrego->CellAttributes() ?>>
<span id="el_remitos_OperadorEntrego" class="control-group">
<?php
	$wrkonchange = trim(" " . @$remitos->OperadorEntrego->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$remitos->OperadorEntrego->EditAttrs["onchange"] = "";
?>
<span id="as_x_OperadorEntrego" style="white-space: nowrap; z-index: 8900">
	<input type="text" name="sv_x_OperadorEntrego" id="sv_x_OperadorEntrego" value="<?php echo $remitos->OperadorEntrego->EditValue ?>" size="30" placeholder="<?php echo $remitos->OperadorEntrego->PlaceHolder ?>"<?php echo $remitos->OperadorEntrego->EditAttributes() ?>>&nbsp;<span id="em_x_OperadorEntrego" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_OperadorEntrego" style="display: inline; z-index: 8900"></div>
</span>
<input type="hidden" data-field="x_OperadorEntrego" name="x_OperadorEntrego" id="x_OperadorEntrego" value="<?php echo $remitos->OperadorEntrego->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld` FROM `operadores`";
$sWhereWrk = "`nombreOperadores` LIKE '{query_value}%'";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorEntrego, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_OperadorEntrego" id="q_x_OperadorEntrego" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_OperadorEntrego", fremitosadd, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorEntrego") + ar[i] : "";
	return dv;
}
fremitosadd.AutoSuggests["x_OperadorEntrego"] = oas;
</script>
<?php if (AllowAdd(CurrentProjectID() . "operadores")) { ?>
&nbsp;<a id="aol_x_OperadorEntrego" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_OperadorEntrego',url:'operadoresaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $remitos->OperadorEntrego->FldCaption() ?></a>
<?php } ?>
<?php
$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
$sWhereWrk = "{filter}";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorEntrego, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
?>
<input type="hidden" name="s_x_OperadorEntrego" id="s_x_OperadorEntrego" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`Id_Operadores` = {filter_value}"); ?>&t0=19">
</span>
<?php echo $remitos->OperadorEntrego->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
	<tr id="r_OperadorVerifico">
		<td><span id="elh_remitos_OperadorVerifico"><?php echo $remitos->OperadorVerifico->FldCaption() ?></span></td>
		<td<?php echo $remitos->OperadorVerifico->CellAttributes() ?>>
<span id="el_remitos_OperadorVerifico" class="control-group">
<?php
	$wrkonchange = trim(" " . @$remitos->OperadorVerifico->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$remitos->OperadorVerifico->EditAttrs["onchange"] = "";
?>
<span id="as_x_OperadorVerifico" style="white-space: nowrap; z-index: 8890">
	<input type="text" name="sv_x_OperadorVerifico" id="sv_x_OperadorVerifico" value="<?php echo $remitos->OperadorVerifico->EditValue ?>" size="30" placeholder="<?php echo $remitos->OperadorVerifico->PlaceHolder ?>"<?php echo $remitos->OperadorVerifico->EditAttributes() ?>>&nbsp;<span id="em_x_OperadorVerifico" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_OperadorVerifico" style="display: inline; z-index: 8890"></div>
</span>
<input type="hidden" data-field="x_OperadorVerifico" name="x_OperadorVerifico" id="x_OperadorVerifico" value="<?php echo $remitos->OperadorVerifico->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld` FROM `operadores`";
$sWhereWrk = "`nombreOperadores` LIKE '{query_value}%'";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorVerifico, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_OperadorVerifico" id="q_x_OperadorVerifico" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_OperadorVerifico", fremitosadd, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorVerifico") + ar[i] : "";
	return dv;
}
fremitosadd.AutoSuggests["x_OperadorVerifico"] = oas;
</script>
<?php if (AllowAdd(CurrentProjectID() . "operadores")) { ?>
&nbsp;<a id="aol_x_OperadorVerifico" class="ewAddOptLink" href="javascript:void(0);" onclick="ew_AddOptDialogShow({lnk:this,el:'x_OperadorVerifico',url:'operadoresaddopt.php'});"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $remitos->OperadorVerifico->FldCaption() ?></a>
<?php } ?>
<?php
$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
$sWhereWrk = "{filter}";

// Call Lookup selecting
$remitos->Lookup_Selecting($remitos->OperadorVerifico, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
?>
<input type="hidden" name="s_x_OperadorVerifico" id="s_x_OperadorVerifico" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&f0=<?php echo ew_Encrypt("`Id_Operadores` = {filter_value}"); ?>&t0=19">
</span>
<?php echo $remitos->OperadorVerifico->CustomMsg ?></td>
	</tr>
<?php } ?>
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
<?php if ($remitos->Importe->Visible) { // Importe ?>
	<tr id="r_Importe">
		<td><span id="elh_remitos_Importe"><?php echo $remitos->Importe->FldCaption() ?></span></td>
		<td<?php echo $remitos->Importe->CellAttributes() ?>>
<span id="el_remitos_Importe" class="control-group">
<input type="text" data-field="x_Importe" name="x_Importe" id="x_Importe" size="30" maxlength="10" placeholder="<?php echo $remitos->Importe->PlaceHolder ?>" value="<?php echo $remitos->Importe->EditValue ?>"<?php echo $remitos->Importe->EditAttributes() ?>>
</span>
<?php echo $remitos->Importe->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($remitos->facturas->Visible) { // facturas ?>
	<tr id="r_facturas">
		<td><span id="elh_remitos_facturas"><?php echo $remitos->facturas->FldCaption() ?></span></td>
		<td<?php echo $remitos->facturas->CellAttributes() ?>>
<span id="el_remitos_facturas" class="control-group">
<input type="text" data-field="x_facturas" name="x_facturas" id="x_facturas" size="30" maxlength="50" placeholder="<?php echo $remitos->facturas->PlaceHolder ?>" value="<?php echo $remitos->facturas->EditValue ?>"<?php echo $remitos->facturas->EditAttributes() ?>>
</span>
<?php echo $remitos->facturas->CustomMsg ?></td>
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
<?php if ($remitos->resultado->Visible) { // resultado ?>
	<tr id="r_resultado">
		<td><span id="elh_remitos_resultado"><?php echo $remitos->resultado->FldCaption() ?></span></td>
		<td<?php echo $remitos->resultado->CellAttributes() ?>>
<span id="el_remitos_resultado" class="control-group">
<textarea data-field="x_resultado" name="x_resultado" id="x_resultado" cols="35" rows="4" placeholder="<?php echo $remitos->resultado->PlaceHolder ?>"<?php echo $remitos->resultado->EditAttributes() ?>><?php echo $remitos->resultado->EditValue ?></textarea>
</span>
<?php echo $remitos->resultado->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fremitosadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$remitos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$remitos_add->Page_Terminate();
?>
