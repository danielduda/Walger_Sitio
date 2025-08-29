<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "walger_pedidosinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$walger_pedidos_search = NULL; // Initialize page object first

class cwalger_pedidos_search extends cwalger_pedidos {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'walger_pedidos';

	// Page object name
	var $PageObjName = 'walger_pedidos_search';

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

		// Table object (walger_pedidos)
		if (!isset($GLOBALS["walger_pedidos"]) || get_class($GLOBALS["walger_pedidos"]) == "cwalger_pedidos") {
			$GLOBALS["walger_pedidos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["walger_pedidos"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'walger_pedidos', TRUE);

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("walger_pedidoslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idPedido->SetVisibility();
		$this->idPedido->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->CodigoCli->SetVisibility();
		$this->estado->SetVisibility();
		$this->fechaEstado->SetVisibility();
		$this->fechaFacturacion->SetVisibility();
		$this->factura->SetVisibility();
		$this->comentario->SetVisibility();
		$this->medioEnvio->SetVisibility();

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
		global $EW_EXPORT, $walger_pedidos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($walger_pedidos);
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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
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
						$sSrchStr = "walger_pedidoslist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
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
		$this->BuildSearchUrl($sSrchUrl, $this->idPedido); // idPedido
		$this->BuildSearchUrl($sSrchUrl, $this->CodigoCli); // CodigoCli
		$this->BuildSearchUrl($sSrchUrl, $this->estado); // estado
		$this->BuildSearchUrl($sSrchUrl, $this->fechaEstado); // fechaEstado
		$this->BuildSearchUrl($sSrchUrl, $this->fechaFacturacion); // fechaFacturacion
		$this->BuildSearchUrl($sSrchUrl, $this->factura); // factura
		$this->BuildSearchUrl($sSrchUrl, $this->comentario); // comentario
		$this->BuildSearchUrl($sSrchUrl, $this->medioEnvio); // medioEnvio
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// idPedido

		$this->idPedido->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idPedido"));
		$this->idPedido->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idPedido");

		// CodigoCli
		$this->CodigoCli->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_CodigoCli"));
		$this->CodigoCli->AdvancedSearch->SearchOperator = $objForm->GetValue("z_CodigoCli");

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado"));
		$this->estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado");
		$this->estado->AdvancedSearch->SearchCondition = $objForm->GetValue("v_estado");
		$this->estado->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_estado"));
		$this->estado->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_estado");

		// fechaEstado
		$this->fechaEstado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fechaEstado"));
		$this->fechaEstado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fechaEstado");

		// fechaFacturacion
		$this->fechaFacturacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fechaFacturacion"));
		$this->fechaFacturacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fechaFacturacion");

		// factura
		$this->factura->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_factura"));
		$this->factura->AdvancedSearch->SearchOperator = $objForm->GetValue("z_factura");

		// comentario
		$this->comentario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_comentario"));
		$this->comentario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_comentario");

		// medioEnvio
		$this->medioEnvio->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_medioEnvio"));
		$this->medioEnvio->AdvancedSearch->SearchOperator = $objForm->GetValue("z_medioEnvio");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idPedido
		// CodigoCli
		// estado
		// fechaEstado
		// fechaFacturacion
		// factura
		// comentario
		// idMedioEnvio
		// idMedioPago
		// recargoEnvioIva
		// recargoPagoIva
		// idCuotaRecargo
		// recargoEnvio
		// recargoPago
		// StatusCode
		// StatusMessage
		// URL_Request
		// RequestKey
		// PublicRequestKey
		// AnswerKey
		// medioEnvio

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idPedido
		$this->idPedido->ViewValue = $this->idPedido->CurrentValue;
		$this->idPedido->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->CodigoCli->ViewValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->ViewValue = NULL;
		}
		$this->CodigoCli->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fechaEstado
		$this->fechaEstado->ViewValue = $this->fechaEstado->CurrentValue;
		$this->fechaEstado->ViewValue = ew_FormatDateTime($this->fechaEstado->ViewValue, 1);
		$this->fechaEstado->ViewCustomAttributes = "";

		// fechaFacturacion
		$this->fechaFacturacion->ViewValue = $this->fechaFacturacion->CurrentValue;
		$this->fechaFacturacion->ViewValue = ew_FormatDateTime($this->fechaFacturacion->ViewValue, 0);
		$this->fechaFacturacion->ViewCustomAttributes = "";

		// factura
		$this->factura->ViewValue = $this->factura->CurrentValue;
		$this->factura->ViewCustomAttributes = "";

		// comentario
		$this->comentario->ViewValue = $this->comentario->CurrentValue;
		$this->comentario->ViewCustomAttributes = "";

		// medioEnvio
		$this->medioEnvio->ViewValue = $this->medioEnvio->CurrentValue;
		$this->medioEnvio->ViewCustomAttributes = "";

			// idPedido
			$this->idPedido->LinkCustomAttributes = "";
			$this->idPedido->HrefValue = "";
			$this->idPedido->TooltipValue = "";

			// CodigoCli
			$this->CodigoCli->LinkCustomAttributes = "";
			$this->CodigoCli->HrefValue = "";
			$this->CodigoCli->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fechaEstado
			$this->fechaEstado->LinkCustomAttributes = "";
			$this->fechaEstado->HrefValue = "";
			$this->fechaEstado->TooltipValue = "";

			// fechaFacturacion
			$this->fechaFacturacion->LinkCustomAttributes = "";
			$this->fechaFacturacion->HrefValue = "";
			$this->fechaFacturacion->TooltipValue = "";

			// factura
			$this->factura->LinkCustomAttributes = "";
			$this->factura->HrefValue = "";
			$this->factura->TooltipValue = "";

			// comentario
			$this->comentario->LinkCustomAttributes = "";
			$this->comentario->HrefValue = "";
			$this->comentario->TooltipValue = "";

			// medioEnvio
			$this->medioEnvio->LinkCustomAttributes = "";
			$this->medioEnvio->HrefValue = "";
			$this->medioEnvio->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idPedido
			$this->idPedido->EditAttrs["class"] = "form-control";
			$this->idPedido->EditCustomAttributes = "";
			$this->idPedido->EditValue = ew_HtmlEncode($this->idPedido->AdvancedSearch->SearchValue);
			$this->idPedido->PlaceHolder = ew_RemoveHtml($this->idPedido->FldCaption());

			// CodigoCli
			$this->CodigoCli->EditAttrs["class"] = "form-control";
			$this->CodigoCli->EditCustomAttributes = "";
			$this->CodigoCli->EditValue = ew_HtmlEncode($this->CodigoCli->AdvancedSearch->SearchValue);
			if (strval($this->CodigoCli->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "";
			$this->CodigoCli->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->CodigoCli->EditValue = $this->CodigoCli->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->CodigoCli->EditValue = ew_HtmlEncode($this->CodigoCli->AdvancedSearch->SearchValue);
				}
			} else {
				$this->CodigoCli->EditValue = NULL;
			}
			$this->CodigoCli->PlaceHolder = ew_RemoveHtml($this->CodigoCli->FldCaption());

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(TRUE);
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue2 = $this->estado->Options(TRUE);

			// fechaEstado
			$this->fechaEstado->EditAttrs["class"] = "form-control";
			$this->fechaEstado->EditCustomAttributes = "";
			$this->fechaEstado->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fechaEstado->AdvancedSearch->SearchValue, 1), 8));
			$this->fechaEstado->PlaceHolder = ew_RemoveHtml($this->fechaEstado->FldCaption());

			// fechaFacturacion
			$this->fechaFacturacion->EditAttrs["class"] = "form-control";
			$this->fechaFacturacion->EditCustomAttributes = "";
			$this->fechaFacturacion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fechaFacturacion->AdvancedSearch->SearchValue, 0), 8));
			$this->fechaFacturacion->PlaceHolder = ew_RemoveHtml($this->fechaFacturacion->FldCaption());

			// factura
			$this->factura->EditAttrs["class"] = "form-control";
			$this->factura->EditCustomAttributes = "";
			$this->factura->EditValue = ew_HtmlEncode($this->factura->AdvancedSearch->SearchValue);
			$this->factura->PlaceHolder = ew_RemoveHtml($this->factura->FldCaption());

			// comentario
			$this->comentario->EditAttrs["class"] = "form-control";
			$this->comentario->EditCustomAttributes = "";
			$this->comentario->EditValue = ew_HtmlEncode($this->comentario->AdvancedSearch->SearchValue);
			$this->comentario->PlaceHolder = ew_RemoveHtml($this->comentario->FldCaption());

			// medioEnvio
			$this->medioEnvio->EditAttrs["class"] = "form-control";
			$this->medioEnvio->EditCustomAttributes = "";
			$this->medioEnvio->EditValue = ew_HtmlEncode($this->medioEnvio->AdvancedSearch->SearchValue);
			$this->medioEnvio->PlaceHolder = ew_RemoveHtml($this->medioEnvio->FldCaption());
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
		if (!ew_CheckInteger($this->idPedido->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idPedido->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fechaEstado->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fechaEstado->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->fechaFacturacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fechaFacturacion->FldErrMsg());
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
		$this->idPedido->AdvancedSearch->Load();
		$this->CodigoCli->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->fechaEstado->AdvancedSearch->Load();
		$this->fechaFacturacion->AdvancedSearch->Load();
		$this->factura->AdvancedSearch->Load();
		$this->comentario->AdvancedSearch->Load();
		$this->medioEnvio->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("walger_pedidoslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_CodigoCli":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CodigoCli` AS `LinkFld`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
			$sWhereWrk = "{filter}";
			$this->CodigoCli->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`CodigoCli` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
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
		case "x_CodigoCli":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld` FROM `dbo_cliente`";
			$sWhereWrk = "`CodigoCli` LIKE '{query_value}%' OR CONCAT(`CodigoCli`,'" . ew_ValueSeparator(1, $this->CodigoCli) . "',`RazonSocialCli`) LIKE '{query_value}%'";
			$this->CodigoCli->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($walger_pedidos_search)) $walger_pedidos_search = new cwalger_pedidos_search();

// Page init
$walger_pedidos_search->Page_Init();

// Page main
$walger_pedidos_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$walger_pedidos_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($walger_pedidos_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fwalger_pedidossearch = new ew_Form("fwalger_pedidossearch", "search");
<?php } else { ?>
var CurrentForm = fwalger_pedidossearch = new ew_Form("fwalger_pedidossearch", "search");
<?php } ?>

// Form_CustomValidate event
fwalger_pedidossearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwalger_pedidossearch.ValidateRequired = true;
<?php } else { ?>
fwalger_pedidossearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwalger_pedidossearch.Lists["x_CodigoCli"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};
fwalger_pedidossearch.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fwalger_pedidossearch.Lists["x_estado"].Options = <?php echo json_encode($walger_pedidos->estado->Options()) ?>;

// Form object for search
// Validate function for search

fwalger_pedidossearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_idPedido");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($walger_pedidos->idPedido->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fechaEstado");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($walger_pedidos->fechaEstado->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fechaFacturacion");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($walger_pedidos->fechaFacturacion->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$walger_pedidos_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $walger_pedidos_search->ShowPageHeader(); ?>
<?php
$walger_pedidos_search->ShowMessage();
?>
<form name="fwalger_pedidossearch" id="fwalger_pedidossearch" class="<?php echo $walger_pedidos_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($walger_pedidos_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $walger_pedidos_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="walger_pedidos">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($walger_pedidos_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($walger_pedidos->idPedido->Visible) { // idPedido ?>
	<div id="r_idPedido" class="form-group">
		<label for="x_idPedido" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_idPedido"><?php echo $walger_pedidos->idPedido->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idPedido" id="z_idPedido" value="="></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->idPedido->CellAttributes() ?>>
			<span id="el_walger_pedidos_idPedido">
<input type="text" data-table="walger_pedidos" data-field="x_idPedido" name="x_idPedido" id="x_idPedido" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->idPedido->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->idPedido->EditValue ?>"<?php echo $walger_pedidos->idPedido->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->CodigoCli->Visible) { // CodigoCli ?>
	<div id="r_CodigoCli" class="form-group">
		<label class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_CodigoCli"><?php echo $walger_pedidos->CodigoCli->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_CodigoCli" id="z_CodigoCli" value="="></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->CodigoCli->CellAttributes() ?>>
			<span id="el_walger_pedidos_CodigoCli">
<?php
$wrkonchange = trim(" " . @$walger_pedidos->CodigoCli->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$walger_pedidos->CodigoCli->EditAttrs["onchange"] = "";
?>
<span id="as_x_CodigoCli" style="white-space: nowrap; z-index: NaN">
	<input type="text" name="sv_x_CodigoCli" id="sv_x_CodigoCli" value="<?php echo $walger_pedidos->CodigoCli->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->CodigoCli->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($walger_pedidos->CodigoCli->getPlaceHolder()) ?>"<?php echo $walger_pedidos->CodigoCli->EditAttributes() ?>>
</span>
<input type="hidden" data-table="walger_pedidos" data-field="x_CodigoCli" data-value-separator="<?php echo $walger_pedidos->CodigoCli->DisplayValueSeparatorAttribute() ?>" name="x_CodigoCli" id="x_CodigoCli" value="<?php echo ew_HtmlEncode($walger_pedidos->CodigoCli->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_CodigoCli" id="q_x_CodigoCli" value="<?php echo $walger_pedidos->CodigoCli->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fwalger_pedidossearch.CreateAutoSuggest({"id":"x_CodigoCli","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label for="x_estado" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_estado"><?php echo $walger_pedidos->estado->FldCaption() ?></span>	
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->estado->CellAttributes() ?>>
		<span class="ewSearchOperator"><select name="z_estado" id="z_estado" class="form-control" onchange="ewForms(this).SrchOprChanged(this);"><option value="="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "=") ? " selected" : "" ?> ><?php echo $Language->Phrase("EQUAL") ?></option><option value="<>"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "<>") ? " selected" : "" ?> ><?php echo $Language->Phrase("<>") ?></option><option value="<"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "<") ? " selected" : "" ?> ><?php echo $Language->Phrase("<") ?></option><option value="<="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "<=") ? " selected" : "" ?> ><?php echo $Language->Phrase("<=") ?></option><option value=">"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == ">") ? " selected" : "" ?> ><?php echo $Language->Phrase(">") ?></option><option value=">="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == ">=") ? " selected" : "" ?> ><?php echo $Language->Phrase(">=") ?></option><option value="LIKE"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("LIKE") ?></option><option value="NOT LIKE"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "NOT LIKE") ? " selected" : "" ?> ><?php echo $Language->Phrase("NOT LIKE") ?></option><option value="STARTS WITH"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "STARTS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("STARTS WITH") ?></option><option value="ENDS WITH"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "ENDS WITH") ? " selected" : "" ?> ><?php echo $Language->Phrase("ENDS WITH") ?></option><option value="BETWEEN"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator == "BETWEEN") ? " selected" : "" ?> ><?php echo $Language->Phrase("BETWEEN") ?></option></select></span>
			<span id="el_walger_pedidos_estado">
<select data-table="walger_pedidos" data-field="x_estado" data-value-separator="<?php echo $walger_pedidos->estado->DisplayValueSeparatorAttribute() ?>" id="x_estado" name="x_estado"<?php echo $walger_pedidos->estado->EditAttributes() ?>>
<?php echo $walger_pedidos->estado->SelectOptionListHtml("x_estado") ?>
</select>
</span>
			<span class="ewSearchCond btw0_estado"><label class="radio-inline ewRadio" style="white-space: nowrap;"><input type="radio" name="v_estado" value="AND"<?php if ($walger_pedidos->estado->AdvancedSearch->SearchCondition <> "OR") echo " checked" ?>><?php echo $Language->Phrase("AND") ?></label><label class="radio-inline ewRadio" style="white-space: nowrap;"><input type="radio" name="v_estado" value="OR"<?php if ($walger_pedidos->estado->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><?php echo $Language->Phrase("OR") ?></label>&nbsp;</span>
			<span class="ewSearchCond btw1_estado">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<p class="form-control-static ewSearchOperator btw0_estado"><?php echo $Language->Phrase("=") ?><input type="hidden" name="w_estado" id="w_estado" value="="></p>
			<span id="e2_walger_pedidos_estado">
<select data-table="walger_pedidos" data-field="x_estado" data-value-separator="<?php echo $walger_pedidos->estado->DisplayValueSeparatorAttribute() ?>" id="y_estado" name="y_estado"<?php echo $walger_pedidos->estado->EditAttributes() ?>>
<?php echo $walger_pedidos->estado->SelectOptionListHtml("y_estado") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->fechaEstado->Visible) { // fechaEstado ?>
	<div id="r_fechaEstado" class="form-group">
		<label for="x_fechaEstado" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_fechaEstado"><?php echo $walger_pedidos->fechaEstado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fechaEstado" id="z_fechaEstado" value="="></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->fechaEstado->CellAttributes() ?>>
			<span id="el_walger_pedidos_fechaEstado">
<input type="text" data-table="walger_pedidos" data-field="x_fechaEstado" data-format="1" name="x_fechaEstado" id="x_fechaEstado" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->fechaEstado->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->fechaEstado->EditValue ?>"<?php echo $walger_pedidos->fechaEstado->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->fechaFacturacion->Visible) { // fechaFacturacion ?>
	<div id="r_fechaFacturacion" class="form-group">
		<label for="x_fechaFacturacion" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_fechaFacturacion"><?php echo $walger_pedidos->fechaFacturacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fechaFacturacion" id="z_fechaFacturacion" value="="></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->fechaFacturacion->CellAttributes() ?>>
			<span id="el_walger_pedidos_fechaFacturacion">
<input type="text" data-table="walger_pedidos" data-field="x_fechaFacturacion" name="x_fechaFacturacion" id="x_fechaFacturacion" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->fechaFacturacion->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->fechaFacturacion->EditValue ?>"<?php echo $walger_pedidos->fechaFacturacion->EditAttributes() ?>>
<?php if (!$walger_pedidos->fechaFacturacion->ReadOnly && !$walger_pedidos->fechaFacturacion->Disabled && !isset($walger_pedidos->fechaFacturacion->EditAttrs["readonly"]) && !isset($walger_pedidos->fechaFacturacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fwalger_pedidossearch", "x_fechaFacturacion", 0);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->factura->Visible) { // factura ?>
	<div id="r_factura" class="form-group">
		<label for="x_factura" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_factura"><?php echo $walger_pedidos->factura->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_factura" id="z_factura" value="LIKE"></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->factura->CellAttributes() ?>>
			<span id="el_walger_pedidos_factura">
<input type="text" data-table="walger_pedidos" data-field="x_factura" name="x_factura" id="x_factura" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->factura->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->factura->EditValue ?>"<?php echo $walger_pedidos->factura->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->comentario->Visible) { // comentario ?>
	<div id="r_comentario" class="form-group">
		<label for="x_comentario" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_comentario"><?php echo $walger_pedidos->comentario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_comentario" id="z_comentario" value="LIKE"></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->comentario->CellAttributes() ?>>
			<span id="el_walger_pedidos_comentario">
<input type="text" data-table="walger_pedidos" data-field="x_comentario" name="x_comentario" id="x_comentario" size="35" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->comentario->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->comentario->EditValue ?>"<?php echo $walger_pedidos->comentario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($walger_pedidos->medioEnvio->Visible) { // medioEnvio ?>
	<div id="r_medioEnvio" class="form-group">
		<label for="x_medioEnvio" class="<?php echo $walger_pedidos_search->SearchLabelClass ?>"><span id="elh_walger_pedidos_medioEnvio"><?php echo $walger_pedidos->medioEnvio->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_medioEnvio" id="z_medioEnvio" value="LIKE"></p>
		</label>
		<div class="<?php echo $walger_pedidos_search->SearchRightColumnClass ?>"><div<?php echo $walger_pedidos->medioEnvio->CellAttributes() ?>>
			<span id="el_walger_pedidos_medioEnvio">
<input type="text" data-table="walger_pedidos" data-field="x_medioEnvio" name="x_medioEnvio" id="x_medioEnvio" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($walger_pedidos->medioEnvio->getPlaceHolder()) ?>" value="<?php echo $walger_pedidos->medioEnvio->EditValue ?>"<?php echo $walger_pedidos->medioEnvio->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$walger_pedidos_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fwalger_pedidossearch.Init();
</script>
<?php
$walger_pedidos_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$walger_pedidos_search->Page_Terminate();
?>
