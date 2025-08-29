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

$remitos_search = NULL; // Initialize page object first

class cremitos_search extends cremitos {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{B81C6C2E-1100-4548-836E-685E96F6B551}";

	// Table name
	var $TableName = 'remitos';

	// Page object name
	var $PageObjName = 'remitos_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$this->Page_Terminate("remitoslist.php" . "?" . $sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->numeroRemito); // numeroRemito
		$this->BuildSearchUrl($sSrchUrl, $this->Fecha); // Fecha
		$this->BuildSearchUrl($sSrchUrl, $this->tipoDestinatario); // tipoDestinatario
		$this->BuildSearchUrl($sSrchUrl, $this->Cliente); // Cliente
		$this->BuildSearchUrl($sSrchUrl, $this->Proveedor); // Proveedor
		$this->BuildSearchUrl($sSrchUrl, $this->Transporte); // Transporte
		$this->BuildSearchUrl($sSrchUrl, $this->NumeroDeBultos); // NumeroDeBultos
		$this->BuildSearchUrl($sSrchUrl, $this->OperadorTraslado); // OperadorTraslado
		$this->BuildSearchUrl($sSrchUrl, $this->OperadorEntrego); // OperadorEntrego
		$this->BuildSearchUrl($sSrchUrl, $this->OperadorVerifico); // OperadorVerifico
		$this->BuildSearchUrl($sSrchUrl, $this->Observaciones); // Observaciones
		$this->BuildSearchUrl($sSrchUrl, $this->Importe); // Importe
		$this->BuildSearchUrl($sSrchUrl, $this->facturas); // facturas
		$this->BuildSearchUrl($sSrchUrl, $this->observacionesInternas); // observacionesInternas
		$this->BuildSearchUrl($sSrchUrl, $this->estado); // estado
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// numeroRemito

		$this->numeroRemito->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_numeroRemito"));
		$this->numeroRemito->AdvancedSearch->SearchOperator = $objForm->GetValue("z_numeroRemito");

		// Fecha
		$this->Fecha->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Fecha"));
		$this->Fecha->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Fecha");

		// tipoDestinatario
		$this->tipoDestinatario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_tipoDestinatario"));
		$this->tipoDestinatario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tipoDestinatario");

		// Cliente
		$this->Cliente->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Cliente"));
		$this->Cliente->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Cliente");

		// Proveedor
		$this->Proveedor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Proveedor"));
		$this->Proveedor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Proveedor");

		// Transporte
		$this->Transporte->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Transporte"));
		$this->Transporte->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Transporte");

		// NumeroDeBultos
		$this->NumeroDeBultos->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NumeroDeBultos"));
		$this->NumeroDeBultos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NumeroDeBultos");

		// OperadorTraslado
		$this->OperadorTraslado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_OperadorTraslado"));
		$this->OperadorTraslado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_OperadorTraslado");

		// OperadorEntrego
		$this->OperadorEntrego->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_OperadorEntrego"));
		$this->OperadorEntrego->AdvancedSearch->SearchOperator = $objForm->GetValue("z_OperadorEntrego");

		// OperadorVerifico
		$this->OperadorVerifico->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_OperadorVerifico"));
		$this->OperadorVerifico->AdvancedSearch->SearchOperator = $objForm->GetValue("z_OperadorVerifico");

		// Observaciones
		$this->Observaciones->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Observaciones"));
		$this->Observaciones->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Observaciones");

		// Importe
		$this->Importe->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_Importe"));
		$this->Importe->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Importe");

		// facturas
		$this->facturas->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_facturas"));
		$this->facturas->AdvancedSearch->SearchOperator = $objForm->GetValue("z_facturas");

		// observacionesInternas
		$this->observacionesInternas->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_observacionesInternas"));
		$this->observacionesInternas->AdvancedSearch->SearchOperator = $objForm->GetValue("z_observacionesInternas");

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado"));
		$this->estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado");
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// numeroRemito
			$this->numeroRemito->EditCustomAttributes = "";
			$this->numeroRemito->EditValue = ew_HtmlEncode($this->numeroRemito->AdvancedSearch->SearchValue);
			$this->numeroRemito->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->numeroRemito->FldCaption()));

			// Fecha
			$this->Fecha->EditCustomAttributes = "";
			$this->Fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Fecha->AdvancedSearch->SearchValue, 7), 7));
			$this->Fecha->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Fecha->FldCaption()));

			// tipoDestinatario
			$this->tipoDestinatario->EditCustomAttributes = "";
			$this->tipoDestinatario->EditValue = ew_HtmlEncode($this->tipoDestinatario->AdvancedSearch->SearchValue);
			$this->tipoDestinatario->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->tipoDestinatario->FldCaption()));

			// Cliente
			$this->Cliente->EditCustomAttributes = "";
			$this->Cliente->EditValue = ew_HtmlEncode($this->Cliente->AdvancedSearch->SearchValue);
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
			$this->Transporte->EditValue = ew_HtmlEncode($this->Transporte->AdvancedSearch->SearchValue);
			$this->Transporte->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Transporte->FldCaption()));

			// NumeroDeBultos
			$this->NumeroDeBultos->EditCustomAttributes = "";
			$this->NumeroDeBultos->EditValue = ew_HtmlEncode($this->NumeroDeBultos->AdvancedSearch->SearchValue);
			$this->NumeroDeBultos->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->NumeroDeBultos->FldCaption()));

			// OperadorTraslado
			$this->OperadorTraslado->EditCustomAttributes = "";
			$this->OperadorTraslado->EditValue = ew_HtmlEncode($this->OperadorTraslado->AdvancedSearch->SearchValue);
			if (strval($this->OperadorTraslado->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`idTransporteInterno`" . ew_SearchString("=", $this->OperadorTraslado->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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
					$this->OperadorTraslado->EditValue = $this->OperadorTraslado->AdvancedSearch->SearchValue;
				}
			} else {
				$this->OperadorTraslado->EditValue = NULL;
			}
			$this->OperadorTraslado->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorTraslado->FldCaption()));

			// OperadorEntrego
			$this->OperadorEntrego->EditCustomAttributes = "";
			$this->OperadorEntrego->EditValue = ew_HtmlEncode($this->OperadorEntrego->AdvancedSearch->SearchValue);
			if (strval($this->OperadorEntrego->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorEntrego->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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
					$this->OperadorEntrego->EditValue = $this->OperadorEntrego->AdvancedSearch->SearchValue;
				}
			} else {
				$this->OperadorEntrego->EditValue = NULL;
			}
			$this->OperadorEntrego->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorEntrego->FldCaption()));

			// OperadorVerifico
			$this->OperadorVerifico->EditCustomAttributes = "";
			$this->OperadorVerifico->EditValue = ew_HtmlEncode($this->OperadorVerifico->AdvancedSearch->SearchValue);
			if (strval($this->OperadorVerifico->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorVerifico->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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
					$this->OperadorVerifico->EditValue = $this->OperadorVerifico->AdvancedSearch->SearchValue;
				}
			} else {
				$this->OperadorVerifico->EditValue = NULL;
			}
			$this->OperadorVerifico->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->OperadorVerifico->FldCaption()));

			// Observaciones
			$this->Observaciones->EditCustomAttributes = "";
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->AdvancedSearch->SearchValue);
			$this->Observaciones->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Observaciones->FldCaption()));

			// Importe
			$this->Importe->EditCustomAttributes = "";
			$this->Importe->EditValue = ew_HtmlEncode($this->Importe->AdvancedSearch->SearchValue);
			$this->Importe->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->Importe->FldCaption()));

			// facturas
			$this->facturas->EditCustomAttributes = "";
			$this->facturas->EditValue = ew_HtmlEncode($this->facturas->AdvancedSearch->SearchValue);
			$this->facturas->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->facturas->FldCaption()));

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
		if (!ew_CheckInteger($this->numeroRemito->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->numeroRemito->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Fecha->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipoDestinatario->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->tipoDestinatario->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Transporte->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Transporte->FldErrMsg());
		}
		if (!ew_CheckInteger($this->NumeroDeBultos->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->NumeroDeBultos->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorTraslado->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->OperadorTraslado->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorEntrego->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->OperadorEntrego->FldErrMsg());
		}
		if (!ew_CheckInteger($this->OperadorVerifico->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->OperadorVerifico->FldErrMsg());
		}

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

	// Load advanced search
	function LoadAdvancedSearch() {
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
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "remitoslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("search");
		$Breadcrumb->Add("search", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($remitos_search)) $remitos_search = new cremitos_search();

// Page init
$remitos_search->Page_Init();

// Page main
$remitos_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var remitos_search = new ew_Page("remitos_search");
remitos_search.PageID = "search"; // Page ID
var EW_PAGE_ID = remitos_search.PageID; // For backward compatibility

// Form object
var fremitossearch = new ew_Form("fremitossearch");

// Form_CustomValidate event
fremitossearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitossearch.ValidateRequired = true;
<?php } else { ?>
fremitossearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitossearch.Lists["x_Proveedor"] = {"LinkField":"x_Id_Proveedores","Ajax":null,"AutoFill":false,"DisplayFields":["x_razonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitossearch.Lists["x_OperadorTraslado"] = {"LinkField":"x_idTransporteInterno","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacionTransporte","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitossearch.Lists["x_OperadorEntrego"] = {"LinkField":"x_Id_Operadores","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fremitossearch.Lists["x_OperadorVerifico"] = {"LinkField":"x_Id_Operadores","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombreOperadores","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
// Validate function for search

fremitossearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
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
	return true;
}

// Form_CustomValidate event
fremitossearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitossearch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fremitossearch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $remitos_search->ShowPageHeader(); ?>
<?php
$remitos_search->ShowMessage();
?>
<form name="fremitossearch" id="fremitossearch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="remitos">
<input type="hidden" name="a_search" id="a_search" value="S">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_remitossearch" class="table table-bordered table-striped">
<?php if ($remitos->numeroRemito->Visible) { // numeroRemito ?>
	<tr id="r_numeroRemito">
		<td><span id="elh_remitos_numeroRemito"><?php echo $remitos->numeroRemito->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_numeroRemito" id="z_numeroRemito" value="="></span></td>
		<td<?php echo $remitos->numeroRemito->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_numeroRemito" class="control-group">
<input type="text" data-field="x_numeroRemito" name="x_numeroRemito" id="x_numeroRemito" size="30" maxlength="13" placeholder="<?php echo $remitos->numeroRemito->PlaceHolder ?>" value="<?php echo $remitos->numeroRemito->EditValue ?>"<?php echo $remitos->numeroRemito->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
	<tr id="r_Fecha">
		<td><span id="elh_remitos_Fecha"><?php echo $remitos->Fecha->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Fecha" id="z_Fecha" value="="></span></td>
		<td<?php echo $remitos->Fecha->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Fecha" class="control-group">
<input type="text" data-field="x_Fecha" name="x_Fecha" id="x_Fecha" placeholder="<?php echo $remitos->Fecha->PlaceHolder ?>" value="<?php echo $remitos->Fecha->EditValue ?>"<?php echo $remitos->Fecha->EditAttributes() ?>>
<?php if (!$remitos->Fecha->ReadOnly && !$remitos->Fecha->Disabled && @$remitos->Fecha->EditAttrs["readonly"] == "" && @$remitos->Fecha->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_Fecha" name="cal_x_Fecha" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_Fecha" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fremitossearch", "x_Fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->tipoDestinatario->Visible) { // tipoDestinatario ?>
	<tr id="r_tipoDestinatario">
		<td><span id="elh_remitos_tipoDestinatario"><?php echo $remitos->tipoDestinatario->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_tipoDestinatario" id="z_tipoDestinatario" value="="></span></td>
		<td<?php echo $remitos->tipoDestinatario->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_tipoDestinatario" class="control-group">
<input type="text" data-field="x_tipoDestinatario" name="x_tipoDestinatario" id="x_tipoDestinatario" size="30" placeholder="<?php echo $remitos->tipoDestinatario->PlaceHolder ?>" value="<?php echo $remitos->tipoDestinatario->EditValue ?>"<?php echo $remitos->tipoDestinatario->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
	<tr id="r_Cliente">
		<td><span id="elh_remitos_Cliente"><?php echo $remitos->Cliente->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Cliente" id="z_Cliente" value="LIKE"></span></td>
		<td<?php echo $remitos->Cliente->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Cliente" class="control-group">
<input type="text" data-field="x_Cliente" name="x_Cliente" id="x_Cliente" size="30" maxlength="10" placeholder="<?php echo $remitos->Cliente->PlaceHolder ?>" value="<?php echo $remitos->Cliente->EditValue ?>"<?php echo $remitos->Cliente->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
	<tr id="r_Proveedor">
		<td><span id="elh_remitos_Proveedor"><?php echo $remitos->Proveedor->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Proveedor" id="z_Proveedor" value="="></span></td>
		<td<?php echo $remitos->Proveedor->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Proveedor" class="control-group">
<select data-field="x_Proveedor" id="x_Proveedor" name="x_Proveedor"<?php echo $remitos->Proveedor->EditAttributes() ?>>
<?php
if (is_array($remitos->Proveedor->EditValue)) {
	$arwrk = $remitos->Proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos->Proveedor->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fremitossearch.Lists["x_Proveedor"].Options = <?php echo (is_array($remitos->Proveedor->EditValue)) ? ew_ArrayToJson($remitos->Proveedor->EditValue, 1) : "[]" ?>;
</script>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
	<tr id="r_Transporte">
		<td><span id="elh_remitos_Transporte"><?php echo $remitos->Transporte->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Transporte" id="z_Transporte" value="LIKE"></span></td>
		<td<?php echo $remitos->Transporte->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Transporte" class="control-group">
<input type="text" data-field="x_Transporte" name="x_Transporte" id="x_Transporte" size="30" maxlength="30" placeholder="<?php echo $remitos->Transporte->PlaceHolder ?>" value="<?php echo $remitos->Transporte->EditValue ?>"<?php echo $remitos->Transporte->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
	<tr id="r_NumeroDeBultos">
		<td><span id="elh_remitos_NumeroDeBultos"><?php echo $remitos->NumeroDeBultos->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_NumeroDeBultos" id="z_NumeroDeBultos" value="="></span></td>
		<td<?php echo $remitos->NumeroDeBultos->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_NumeroDeBultos" class="control-group">
<input type="text" data-field="x_NumeroDeBultos" name="x_NumeroDeBultos" id="x_NumeroDeBultos" size="30" placeholder="<?php echo $remitos->NumeroDeBultos->PlaceHolder ?>" value="<?php echo $remitos->NumeroDeBultos->EditValue ?>"<?php echo $remitos->NumeroDeBultos->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
	<tr id="r_OperadorTraslado">
		<td><span id="elh_remitos_OperadorTraslado"><?php echo $remitos->OperadorTraslado->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_OperadorTraslado" id="z_OperadorTraslado" value="="></span></td>
		<td<?php echo $remitos->OperadorTraslado->CellAttributes() ?>>
			<div style="white-space: nowrap;">
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
<input type="hidden" data-field="x_OperadorTraslado" name="x_OperadorTraslado" id="x_OperadorTraslado" value="<?php echo $remitos->OperadorTraslado->AdvancedSearch->SearchValue ?>"<?php echo $wrkonchange ?>>
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
var oas = new ew_AutoSuggest("x_OperadorTraslado", fremitossearch, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorTraslado") + ar[i] : "";
	return dv;
}
fremitossearch.AutoSuggests["x_OperadorTraslado"] = oas;
</script>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorEntrego->Visible) { // OperadorEntrego ?>
	<tr id="r_OperadorEntrego">
		<td><span id="elh_remitos_OperadorEntrego"><?php echo $remitos->OperadorEntrego->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_OperadorEntrego" id="z_OperadorEntrego" value="="></span></td>
		<td<?php echo $remitos->OperadorEntrego->CellAttributes() ?>>
			<div style="white-space: nowrap;">
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
<input type="hidden" data-field="x_OperadorEntrego" name="x_OperadorEntrego" id="x_OperadorEntrego" value="<?php echo $remitos->OperadorEntrego->AdvancedSearch->SearchValue ?>"<?php echo $wrkonchange ?>>
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
var oas = new ew_AutoSuggest("x_OperadorEntrego", fremitossearch, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorEntrego") + ar[i] : "";
	return dv;
}
fremitossearch.AutoSuggests["x_OperadorEntrego"] = oas;
</script>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
	<tr id="r_OperadorVerifico">
		<td><span id="elh_remitos_OperadorVerifico"><?php echo $remitos->OperadorVerifico->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_OperadorVerifico" id="z_OperadorVerifico" value="="></span></td>
		<td<?php echo $remitos->OperadorVerifico->CellAttributes() ?>>
			<div style="white-space: nowrap;">
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
<input type="hidden" data-field="x_OperadorVerifico" name="x_OperadorVerifico" id="x_OperadorVerifico" value="<?php echo $remitos->OperadorVerifico->AdvancedSearch->SearchValue ?>"<?php echo $wrkonchange ?>>
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
var oas = new ew_AutoSuggest("x_OperadorVerifico", fremitossearch, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_OperadorVerifico") + ar[i] : "";
	return dv;
}
fremitossearch.AutoSuggests["x_OperadorVerifico"] = oas;
</script>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones">
		<td><span id="elh_remitos_Observaciones"><?php echo $remitos->Observaciones->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Observaciones" id="z_Observaciones" value="LIKE"></span></td>
		<td<?php echo $remitos->Observaciones->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Observaciones" class="control-group">
<input type="text" data-field="x_Observaciones" name="x_Observaciones" id="x_Observaciones" size="30" maxlength="100" placeholder="<?php echo $remitos->Observaciones->PlaceHolder ?>" value="<?php echo $remitos->Observaciones->EditValue ?>"<?php echo $remitos->Observaciones->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->Importe->Visible) { // Importe ?>
	<tr id="r_Importe">
		<td><span id="elh_remitos_Importe"><?php echo $remitos->Importe->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Importe" id="z_Importe" value="LIKE"></span></td>
		<td<?php echo $remitos->Importe->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_Importe" class="control-group">
<input type="text" data-field="x_Importe" name="x_Importe" id="x_Importe" size="30" maxlength="10" placeholder="<?php echo $remitos->Importe->PlaceHolder ?>" value="<?php echo $remitos->Importe->EditValue ?>"<?php echo $remitos->Importe->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->facturas->Visible) { // facturas ?>
	<tr id="r_facturas">
		<td><span id="elh_remitos_facturas"><?php echo $remitos->facturas->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_facturas" id="z_facturas" value="LIKE"></span></td>
		<td<?php echo $remitos->facturas->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_facturas" class="control-group">
<input type="text" data-field="x_facturas" name="x_facturas" id="x_facturas" size="30" maxlength="50" placeholder="<?php echo $remitos->facturas->PlaceHolder ?>" value="<?php echo $remitos->facturas->EditValue ?>"<?php echo $remitos->facturas->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
	<tr id="r_observacionesInternas">
		<td><span id="elh_remitos_observacionesInternas"><?php echo $remitos->observacionesInternas->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_observacionesInternas" id="z_observacionesInternas" value="LIKE"></span></td>
		<td<?php echo $remitos->observacionesInternas->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_observacionesInternas" class="control-group">
<input type="text" data-field="x_observacionesInternas" name="x_observacionesInternas" id="x_observacionesInternas" size="30" maxlength="255" placeholder="<?php echo $remitos->observacionesInternas->PlaceHolder ?>" value="<?php echo $remitos->observacionesInternas->EditValue ?>"<?php echo $remitos->observacionesInternas->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php if ($remitos->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_remitos_estado"><?php echo $remitos->estado->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></span></td>
		<td<?php echo $remitos->estado->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_remitos_estado" class="control-group">
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
			</div>
		</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
</form>
<script type="text/javascript">
fremitossearch.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$remitos_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$remitos_search->Page_Terminate();
?>
