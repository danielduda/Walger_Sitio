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

$remitos_delete = NULL; // Initialize page object first

class cremitos_delete extends cremitos {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'remitos';

	// Page object name
	var $PageObjName = 'remitos_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("remitoslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->Id_Remito->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("remitoslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in remitos class, remitosinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		$this->Fecha->setDbValue($rs->fields('Fecha'));
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
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Remito->DbValue = $row['Id_Remito'];
		$this->Fecha->DbValue = $row['Fecha'];
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
		// Fecha
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Remito
			$this->Id_Remito->ViewValue = $this->Id_Remito->CurrentValue;
			$this->Id_Remito->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Cliente
			if (strval($this->Cliente->CurrentValue) <> "") {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Cliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Cliente->ViewValue = $rswrk->fields('DispFld');
					$this->Cliente->ViewValue .= ew_ValueSeparator(1,$this->Cliente) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
				}
			} else {
				$this->Cliente->ViewValue = NULL;
			}
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
			if (strval($this->Transporte->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Transporte`" . ew_SearchString("=", $this->Transporte->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Transporte`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->Transporte, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `razonSocial` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Transporte->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Transporte->ViewValue = $this->Transporte->CurrentValue;
				}
			} else {
				$this->Transporte->ViewValue = NULL;
			}
			$this->Transporte->ViewCustomAttributes = "";

			// NumeroDeBultos
			$this->NumeroDeBultos->ViewValue = $this->NumeroDeBultos->CurrentValue;
			$this->NumeroDeBultos->ViewCustomAttributes = "";

			// OperadorTraslado
			if (strval($this->OperadorTraslado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorTraslado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->OperadorTraslado, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
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

			// Id_Remito
			$this->Id_Remito->LinkCustomAttributes = "";
			$this->Id_Remito->HrefValue = "";
			$this->Id_Remito->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Remito'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "remitoslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($remitos_delete)) $remitos_delete = new cremitos_delete();

// Page init
$remitos_delete->Page_Init();

// Page main
$remitos_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var remitos_delete = new ew_Page("remitos_delete");
remitos_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = remitos_delete.PageID; // For backward compatibility

// Form object
var fremitosdelete = new ew_Form("fremitosdelete");

// Form_CustomValidate event
fremitosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitosdelete.ValidateRequired = true;
<?php } else { ?>
fremitosdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitosdelete.Lists["x_Cliente"] = {"LinkField":"x_CodigoCli","Ajax":null,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosdelete.Lists["x_Proveedor"] = {"LinkField":"x_Id_Proveedores","Ajax":null,"AutoFill":false,"DisplayFields":["x_razonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosdelete.Lists["x_Transporte"] = {"LinkField":"x_Id_Transporte","Ajax":null,"AutoFill":false,"DisplayFields":["x_razonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosdelete.Lists["x_OperadorTraslado"] = {"LinkField":"x_Id_Operadores","Ajax":null,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosdelete.Lists["x_OperadorEntrego"] = {"LinkField":"x_Id_Operadores","Ajax":null,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitosdelete.Lists["x_OperadorVerifico"] = {"LinkField":"x_Id_Operadores","Ajax":null,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($remitos_delete->Recordset = $remitos_delete->LoadRecordset())
	$remitos_deleteTotalRecs = $remitos_delete->Recordset->RecordCount(); // Get record count
if ($remitos_deleteTotalRecs <= 0) { // No record found, exit
	if ($remitos_delete->Recordset)
		$remitos_delete->Recordset->Close();
	$remitos_delete->Page_Terminate("remitoslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $remitos_delete->ShowPageHeader(); ?>
<?php
$remitos_delete->ShowMessage();
?>
<form name="fremitosdelete" id="fremitosdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="remitos">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($remitos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_remitosdelete" class="ewTable ewTableSeparate">
<?php echo $remitos->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($remitos->Id_Remito->Visible) { // Id_Remito ?>
		<td><span id="elh_remitos_Id_Remito" class="remitos_Id_Remito"><?php echo $remitos->Id_Remito->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
		<td><span id="elh_remitos_Fecha" class="remitos_Fecha"><?php echo $remitos->Fecha->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
		<td><span id="elh_remitos_Cliente" class="remitos_Cliente"><?php echo $remitos->Cliente->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
		<td><span id="elh_remitos_Proveedor" class="remitos_Proveedor"><?php echo $remitos->Proveedor->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
		<td><span id="elh_remitos_Transporte" class="remitos_Transporte"><?php echo $remitos->Transporte->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
		<td><span id="elh_remitos_NumeroDeBultos" class="remitos_NumeroDeBultos"><?php echo $remitos->NumeroDeBultos->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
		<td><span id="elh_remitos_OperadorTraslado" class="remitos_OperadorTraslado"><?php echo $remitos->OperadorTraslado->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->OperadorEntrego->Visible) { // OperadorEntrego ?>
		<td><span id="elh_remitos_OperadorEntrego" class="remitos_OperadorEntrego"><?php echo $remitos->OperadorEntrego->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
		<td><span id="elh_remitos_OperadorVerifico" class="remitos_OperadorVerifico"><?php echo $remitos->OperadorVerifico->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Observaciones->Visible) { // Observaciones ?>
		<td><span id="elh_remitos_Observaciones" class="remitos_Observaciones"><?php echo $remitos->Observaciones->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->Importe->Visible) { // Importe ?>
		<td><span id="elh_remitos_Importe" class="remitos_Importe"><?php echo $remitos->Importe->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->facturas->Visible) { // facturas ?>
		<td><span id="elh_remitos_facturas" class="remitos_facturas"><?php echo $remitos->facturas->FldCaption() ?></span></td>
<?php } ?>
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
		<td><span id="elh_remitos_observacionesInternas" class="remitos_observacionesInternas"><?php echo $remitos->observacionesInternas->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$remitos_delete->RecCnt = 0;
$i = 0;
while (!$remitos_delete->Recordset->EOF) {
	$remitos_delete->RecCnt++;
	$remitos_delete->RowCnt++;

	// Set row properties
	$remitos->ResetAttrs();
	$remitos->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$remitos_delete->LoadRowValues($remitos_delete->Recordset);

	// Render row
	$remitos_delete->RenderRow();
?>
	<tr<?php echo $remitos->RowAttributes() ?>>
<?php if ($remitos->Id_Remito->Visible) { // Id_Remito ?>
		<td<?php echo $remitos->Id_Remito->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Id_Remito" class="control-group remitos_Id_Remito">
<span<?php echo $remitos->Id_Remito->ViewAttributes() ?>>
<?php echo $remitos->Id_Remito->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
		<td<?php echo $remitos->Fecha->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Fecha" class="control-group remitos_Fecha">
<span<?php echo $remitos->Fecha->ViewAttributes() ?>>
<?php echo $remitos->Fecha->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
		<td<?php echo $remitos->Cliente->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Cliente" class="control-group remitos_Cliente">
<span<?php echo $remitos->Cliente->ViewAttributes() ?>>
<?php echo $remitos->Cliente->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
		<td<?php echo $remitos->Proveedor->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Proveedor" class="control-group remitos_Proveedor">
<span<?php echo $remitos->Proveedor->ViewAttributes() ?>>
<?php echo $remitos->Proveedor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
		<td<?php echo $remitos->Transporte->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Transporte" class="control-group remitos_Transporte">
<span<?php echo $remitos->Transporte->ViewAttributes() ?>>
<?php echo $remitos->Transporte->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
		<td<?php echo $remitos->NumeroDeBultos->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_NumeroDeBultos" class="control-group remitos_NumeroDeBultos">
<span<?php echo $remitos->NumeroDeBultos->ViewAttributes() ?>>
<?php echo $remitos->NumeroDeBultos->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
		<td<?php echo $remitos->OperadorTraslado->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_OperadorTraslado" class="control-group remitos_OperadorTraslado">
<span<?php echo $remitos->OperadorTraslado->ViewAttributes() ?>>
<?php echo $remitos->OperadorTraslado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->OperadorEntrego->Visible) { // OperadorEntrego ?>
		<td<?php echo $remitos->OperadorEntrego->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_OperadorEntrego" class="control-group remitos_OperadorEntrego">
<span<?php echo $remitos->OperadorEntrego->ViewAttributes() ?>>
<?php echo $remitos->OperadorEntrego->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
		<td<?php echo $remitos->OperadorVerifico->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_OperadorVerifico" class="control-group remitos_OperadorVerifico">
<span<?php echo $remitos->OperadorVerifico->ViewAttributes() ?>>
<?php echo $remitos->OperadorVerifico->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Observaciones->Visible) { // Observaciones ?>
		<td<?php echo $remitos->Observaciones->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Observaciones" class="control-group remitos_Observaciones">
<span<?php echo $remitos->Observaciones->ViewAttributes() ?>>
<?php echo $remitos->Observaciones->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->Importe->Visible) { // Importe ?>
		<td<?php echo $remitos->Importe->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_Importe" class="control-group remitos_Importe">
<span<?php echo $remitos->Importe->ViewAttributes() ?>>
<?php echo $remitos->Importe->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->facturas->Visible) { // facturas ?>
		<td<?php echo $remitos->facturas->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_facturas" class="control-group remitos_facturas">
<span<?php echo $remitos->facturas->ViewAttributes() ?>>
<?php echo $remitos->facturas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
		<td<?php echo $remitos->observacionesInternas->CellAttributes() ?>>
<span id="el<?php echo $remitos_delete->RowCnt ?>_remitos_observacionesInternas" class="control-group remitos_observacionesInternas">
<span<?php echo $remitos->observacionesInternas->ViewAttributes() ?>>
<?php echo $remitos->observacionesInternas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$remitos_delete->Recordset->MoveNext();
}
$remitos_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fremitosdelete.Init();
</script>
<?php
$remitos_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$remitos_delete->Page_Terminate();
?>
