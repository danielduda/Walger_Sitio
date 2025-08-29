<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dbo_articuloinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dbo_articulo_delete = NULL; // Initialize page object first

class cdbo_articulo_delete extends cdbo_articulo {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'dbo_articulo';

	// Page object name
	var $PageObjName = 'dbo_articulo_delete';

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

		// Table object (dbo_articulo)
		if (!isset($GLOBALS["dbo_articulo"]) || get_class($GLOBALS["dbo_articulo"]) == "cdbo_articulo") {
			$GLOBALS["dbo_articulo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dbo_articulo"];
		}

		// Table object (walger_usuarios)
		if (!isset($GLOBALS['walger_usuarios'])) $GLOBALS['walger_usuarios'] = new cwalger_usuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dbo_articulo', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("dbo_articulolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->CodInternoArti->SetVisibility();
		$this->CodBarraArti->SetVisibility();
		$this->idTipoArticulo->SetVisibility();
		$this->DescripcionArti->SetVisibility();
		$this->PrecioVta1_PreArti->SetVisibility();
		$this->Stock1_StkArti->SetVisibility();
		$this->NombreFotoArti->SetVisibility();
		$this->DescrNivelInt4->SetVisibility();
		$this->DescrNivelInt3->SetVisibility();
		$this->DescrNivelInt2->SetVisibility();

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
		global $EW_EXPORT, $dbo_articulo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dbo_articulo);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
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
			$this->Page_Terminate("dbo_articulolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in dbo_articulo class, dbo_articuloinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("dbo_articulolist.php"); // Return to list
			}
		}
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
		$this->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
		$this->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
		$this->idTipoArticulo->setDbValue($rs->fields('idTipoArticulo'));
		$this->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
		$this->detalle->setDbValue($rs->fields('detalle'));
		$this->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
		$this->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
		$this->NombreFotoArti->Upload->DbValue = $rs->fields('NombreFotoArti');
		$this->NombreFotoArti->CurrentValue = $this->NombreFotoArti->Upload->DbValue;
		$this->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
		$this->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
		$this->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
		$this->TasaIva->setDbValue($rs->fields('TasaIva'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CodInternoArti->DbValue = $row['CodInternoArti'];
		$this->CodBarraArti->DbValue = $row['CodBarraArti'];
		$this->idTipoArticulo->DbValue = $row['idTipoArticulo'];
		$this->DescripcionArti->DbValue = $row['DescripcionArti'];
		$this->detalle->DbValue = $row['detalle'];
		$this->PrecioVta1_PreArti->DbValue = $row['PrecioVta1_PreArti'];
		$this->Stock1_StkArti->DbValue = $row['Stock1_StkArti'];
		$this->NombreFotoArti->Upload->DbValue = $row['NombreFotoArti'];
		$this->DescrNivelInt4->DbValue = $row['DescrNivelInt4'];
		$this->DescrNivelInt3->DbValue = $row['DescrNivelInt3'];
		$this->DescrNivelInt2->DbValue = $row['DescrNivelInt2'];
		$this->TasaIva->DbValue = $row['TasaIva'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->PrecioVta1_PreArti->FormValue == $this->PrecioVta1_PreArti->CurrentValue && is_numeric(ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue)))
			$this->PrecioVta1_PreArti->CurrentValue = ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Stock1_StkArti->FormValue == $this->Stock1_StkArti->CurrentValue && is_numeric(ew_StrToFloat($this->Stock1_StkArti->CurrentValue)))
			$this->Stock1_StkArti->CurrentValue = ew_StrToFloat($this->Stock1_StkArti->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// CodInternoArti

		$this->CodInternoArti->CellCssStyle = "white-space: nowrap;";

		// CodBarraArti
		$this->CodBarraArti->CellCssStyle = "white-space: nowrap;";

		// idTipoArticulo
		// DescripcionArti

		$this->DescripcionArti->CellCssStyle = "white-space: nowrap;";

		// detalle
		// PrecioVta1_PreArti

		$this->PrecioVta1_PreArti->CellCssStyle = "white-space: nowrap;";

		// Stock1_StkArti
		$this->Stock1_StkArti->CellCssStyle = "white-space: nowrap;";

		// NombreFotoArti
		$this->NombreFotoArti->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt4
		$this->DescrNivelInt4->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt3
		$this->DescrNivelInt3->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt2
		$this->DescrNivelInt2->CellCssStyle = "white-space: nowrap;";

		// TasaIva
		$this->TasaIva->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		$this->CodInternoArti->ViewValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$this->CodBarraArti->ViewValue = $this->CodBarraArti->CurrentValue;
		$this->CodBarraArti->ViewCustomAttributes = "";

		// idTipoArticulo
		if (strval($this->idTipoArticulo->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->idTipoArticulo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_tipos-articulos`";
		$sWhereWrk = "";
		$this->idTipoArticulo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idTipoArticulo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->CurrentValue;
			}
		} else {
			$this->idTipoArticulo->ViewValue = NULL;
		}
		$this->idTipoArticulo->ViewCustomAttributes = "";

		// DescripcionArti
		$this->DescripcionArti->ViewValue = $this->DescripcionArti->CurrentValue;
		$this->DescripcionArti->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->ViewValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->PrecioVta1_PreArti->ViewValue = ew_FormatNumber($this->PrecioVta1_PreArti->ViewValue, 2, -1, 0, 0);
		$this->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->ViewValue = $this->Stock1_StkArti->CurrentValue;
		$this->Stock1_StkArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$this->NombreFotoArti->UploadPath = "../articulos/";
		if (!ew_Empty($this->NombreFotoArti->Upload->DbValue)) {
			$this->NombreFotoArti->ViewValue = $this->NombreFotoArti->Upload->DbValue;
		} else {
			$this->NombreFotoArti->ViewValue = "";
		}
		$this->NombreFotoArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->ViewValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->ViewValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->ViewValue = $this->DescrNivelInt2->CurrentValue;
		$this->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$this->TasaIva->ViewValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->ViewValue = ew_FormatNumber($this->TasaIva->ViewValue, 2, -1, 0, 0);
		$this->TasaIva->ViewCustomAttributes = "";

			// CodInternoArti
			$this->CodInternoArti->LinkCustomAttributes = "";
			$this->CodInternoArti->HrefValue = "";
			$this->CodInternoArti->TooltipValue = "";

			// CodBarraArti
			$this->CodBarraArti->LinkCustomAttributes = "";
			$this->CodBarraArti->HrefValue = "";
			$this->CodBarraArti->TooltipValue = "";

			// idTipoArticulo
			$this->idTipoArticulo->LinkCustomAttributes = "";
			$this->idTipoArticulo->HrefValue = "";
			$this->idTipoArticulo->TooltipValue = "";

			// DescripcionArti
			$this->DescripcionArti->LinkCustomAttributes = "";
			$this->DescripcionArti->HrefValue = "";
			$this->DescripcionArti->TooltipValue = "";

			// PrecioVta1_PreArti
			$this->PrecioVta1_PreArti->LinkCustomAttributes = "";
			$this->PrecioVta1_PreArti->HrefValue = "";
			$this->PrecioVta1_PreArti->TooltipValue = "";

			// Stock1_StkArti
			$this->Stock1_StkArti->LinkCustomAttributes = "";
			$this->Stock1_StkArti->HrefValue = "";
			$this->Stock1_StkArti->TooltipValue = "";

			// NombreFotoArti
			$this->NombreFotoArti->LinkCustomAttributes = "";
			$this->NombreFotoArti->HrefValue = "";
			$this->NombreFotoArti->HrefValue2 = $this->NombreFotoArti->UploadPath . $this->NombreFotoArti->Upload->DbValue;
			$this->NombreFotoArti->TooltipValue = "";

			// DescrNivelInt4
			$this->DescrNivelInt4->LinkCustomAttributes = "";
			$this->DescrNivelInt4->HrefValue = "";
			$this->DescrNivelInt4->TooltipValue = "";

			// DescrNivelInt3
			$this->DescrNivelInt3->LinkCustomAttributes = "";
			$this->DescrNivelInt3->HrefValue = "";
			$this->DescrNivelInt3->TooltipValue = "";

			// DescrNivelInt2
			$this->DescrNivelInt2->LinkCustomAttributes = "";
			$this->DescrNivelInt2->HrefValue = "";
			$this->DescrNivelInt2->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
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
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
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
				$sThisKey .= $row['CodInternoArti'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
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
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dbo_articulolist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($dbo_articulo_delete)) $dbo_articulo_delete = new cdbo_articulo_delete();

// Page init
$dbo_articulo_delete->Page_Init();

// Page main
$dbo_articulo_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_articulo_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdbo_articulodelete = new ew_Form("fdbo_articulodelete", "delete");

// Form_CustomValidate event
fdbo_articulodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_articulodelete.ValidateRequired = true;
<?php } else { ?>
fdbo_articulodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdbo_articulodelete.Lists["x_idTipoArticulo"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_tipos2Darticulos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $dbo_articulo_delete->ShowPageHeader(); ?>
<?php
$dbo_articulo_delete->ShowMessage();
?>
<form name="fdbo_articulodelete" id="fdbo_articulodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dbo_articulo_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dbo_articulo_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dbo_articulo">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($dbo_articulo_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $dbo_articulo->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
		<th><span id="elh_dbo_articulo_CodInternoArti" class="dbo_articulo_CodInternoArti"><?php echo $dbo_articulo->CodInternoArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
		<th><span id="elh_dbo_articulo_CodBarraArti" class="dbo_articulo_CodBarraArti"><?php echo $dbo_articulo->CodBarraArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
		<th><span id="elh_dbo_articulo_idTipoArticulo" class="dbo_articulo_idTipoArticulo"><?php echo $dbo_articulo->idTipoArticulo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
		<th><span id="elh_dbo_articulo_DescripcionArti" class="dbo_articulo_DescripcionArti"><?php echo $dbo_articulo->DescripcionArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
		<th><span id="elh_dbo_articulo_PrecioVta1_PreArti" class="dbo_articulo_PrecioVta1_PreArti"><?php echo $dbo_articulo->PrecioVta1_PreArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
		<th><span id="elh_dbo_articulo_Stock1_StkArti" class="dbo_articulo_Stock1_StkArti"><?php echo $dbo_articulo->Stock1_StkArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
		<th><span id="elh_dbo_articulo_NombreFotoArti" class="dbo_articulo_NombreFotoArti"><?php echo $dbo_articulo->NombreFotoArti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
		<th><span id="elh_dbo_articulo_DescrNivelInt4" class="dbo_articulo_DescrNivelInt4"><?php echo $dbo_articulo->DescrNivelInt4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
		<th><span id="elh_dbo_articulo_DescrNivelInt3" class="dbo_articulo_DescrNivelInt3"><?php echo $dbo_articulo->DescrNivelInt3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
		<th><span id="elh_dbo_articulo_DescrNivelInt2" class="dbo_articulo_DescrNivelInt2"><?php echo $dbo_articulo->DescrNivelInt2->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$dbo_articulo_delete->RecCnt = 0;
$i = 0;
while (!$dbo_articulo_delete->Recordset->EOF) {
	$dbo_articulo_delete->RecCnt++;
	$dbo_articulo_delete->RowCnt++;

	// Set row properties
	$dbo_articulo->ResetAttrs();
	$dbo_articulo->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$dbo_articulo_delete->LoadRowValues($dbo_articulo_delete->Recordset);

	// Render row
	$dbo_articulo_delete->RenderRow();
?>
	<tr<?php echo $dbo_articulo->RowAttributes() ?>>
<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_CodInternoArti" class="dbo_articulo_CodInternoArti">
<span<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodInternoArti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_CodBarraArti" class="dbo_articulo_CodBarraArti">
<span<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodBarraArti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
		<td<?php echo $dbo_articulo->idTipoArticulo->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_idTipoArticulo" class="dbo_articulo_idTipoArticulo">
<span<?php echo $dbo_articulo->idTipoArticulo->ViewAttributes() ?>>
<?php echo $dbo_articulo->idTipoArticulo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_DescripcionArti" class="dbo_articulo_DescripcionArti">
<span<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescripcionArti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_PrecioVta1_PreArti" class="dbo_articulo_PrecioVta1_PreArti">
<span<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->PrecioVta1_PreArti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_Stock1_StkArti" class="dbo_articulo_Stock1_StkArti">
<span<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->Stock1_StkArti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_NombreFotoArti" class="dbo_articulo_NombreFotoArti">
<span<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($dbo_articulo->NombreFotoArti, $dbo_articulo->NombreFotoArti->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_DescrNivelInt4" class="dbo_articulo_DescrNivelInt4">
<span<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_DescrNivelInt3" class="dbo_articulo_DescrNivelInt3">
<span<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<span id="el<?php echo $dbo_articulo_delete->RowCnt ?>_dbo_articulo_DescrNivelInt2" class="dbo_articulo_DescrNivelInt2">
<span<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$dbo_articulo_delete->Recordset->MoveNext();
}
$dbo_articulo_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dbo_articulo_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdbo_articulodelete.Init();
</script>
<?php
$dbo_articulo_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dbo_articulo_delete->Page_Terminate();
?>
