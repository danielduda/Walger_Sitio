<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "dbo_articuloinfo.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "trama_articulos2Dimagenes2Dadicionalesgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$dbo_articulo_add = NULL; // Initialize page object first

class cdbo_articulo_add extends cdbo_articulo {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'dbo_articulo';

	// Page object name
	var $PageObjName = 'dbo_articulo_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("dbo_articulolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->CodInternoArti->SetVisibility();
		$this->CodBarraArti->SetVisibility();
		$this->idTipoArticulo->SetVisibility();
		$this->DescripcionArti->SetVisibility();
		$this->detalle->SetVisibility();
		$this->PrecioVta1_PreArti->SetVisibility();
		$this->Stock1_StkArti->SetVisibility();
		$this->NombreFotoArti->SetVisibility();
		$this->DescrNivelInt4->SetVisibility();
		$this->DescrNivelInt3->SetVisibility();
		$this->DescrNivelInt2->SetVisibility();
		$this->TasaIva->SetVisibility();

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

			// Process auto fill for detail table 'trama_articulos-imagenes-adicionales'
			if (@$_POST["grid"] == "ftrama_articulos2Dimagenes2Dadicionalesgrid") {
				if (!isset($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"])) $GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"] = new ctrama_articulos2Dimagenes2Dadicionales_grid;
				$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->Page_Init();
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["CodInternoArti"] != "") {
				$this->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
				$this->setKey("CodInternoArti", $this->CodInternoArti->CurrentValue); // Set up key
			} else {
				$this->setKey("CodInternoArti", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("dbo_articulolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "dbo_articulolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "dbo_articuloview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->NombreFotoArti->Upload->Index = $objForm->Index;
		$this->NombreFotoArti->Upload->UploadFile();
		$this->NombreFotoArti->CurrentValue = $this->NombreFotoArti->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->CodInternoArti->CurrentValue = NULL;
		$this->CodInternoArti->OldValue = $this->CodInternoArti->CurrentValue;
		$this->CodBarraArti->CurrentValue = NULL;
		$this->CodBarraArti->OldValue = $this->CodBarraArti->CurrentValue;
		$this->idTipoArticulo->CurrentValue = NULL;
		$this->idTipoArticulo->OldValue = $this->idTipoArticulo->CurrentValue;
		$this->DescripcionArti->CurrentValue = NULL;
		$this->DescripcionArti->OldValue = $this->DescripcionArti->CurrentValue;
		$this->detalle->CurrentValue = NULL;
		$this->detalle->OldValue = $this->detalle->CurrentValue;
		$this->PrecioVta1_PreArti->CurrentValue = NULL;
		$this->PrecioVta1_PreArti->OldValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->Stock1_StkArti->CurrentValue = NULL;
		$this->Stock1_StkArti->OldValue = $this->Stock1_StkArti->CurrentValue;
		$this->NombreFotoArti->Upload->DbValue = NULL;
		$this->NombreFotoArti->OldValue = $this->NombreFotoArti->Upload->DbValue;
		$this->NombreFotoArti->CurrentValue = NULL; // Clear file related field
		$this->DescrNivelInt4->CurrentValue = NULL;
		$this->DescrNivelInt4->OldValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt3->CurrentValue = NULL;
		$this->DescrNivelInt3->OldValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt2->CurrentValue = NULL;
		$this->DescrNivelInt2->OldValue = $this->DescrNivelInt2->CurrentValue;
		$this->TasaIva->CurrentValue = NULL;
		$this->TasaIva->OldValue = $this->TasaIva->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->CodInternoArti->FldIsDetailKey) {
			$this->CodInternoArti->setFormValue($objForm->GetValue("x_CodInternoArti"));
		}
		if (!$this->CodBarraArti->FldIsDetailKey) {
			$this->CodBarraArti->setFormValue($objForm->GetValue("x_CodBarraArti"));
		}
		if (!$this->idTipoArticulo->FldIsDetailKey) {
			$this->idTipoArticulo->setFormValue($objForm->GetValue("x_idTipoArticulo"));
		}
		if (!$this->DescripcionArti->FldIsDetailKey) {
			$this->DescripcionArti->setFormValue($objForm->GetValue("x_DescripcionArti"));
		}
		if (!$this->detalle->FldIsDetailKey) {
			$this->detalle->setFormValue($objForm->GetValue("x_detalle"));
		}
		if (!$this->PrecioVta1_PreArti->FldIsDetailKey) {
			$this->PrecioVta1_PreArti->setFormValue($objForm->GetValue("x_PrecioVta1_PreArti"));
		}
		if (!$this->Stock1_StkArti->FldIsDetailKey) {
			$this->Stock1_StkArti->setFormValue($objForm->GetValue("x_Stock1_StkArti"));
		}
		if (!$this->DescrNivelInt4->FldIsDetailKey) {
			$this->DescrNivelInt4->setFormValue($objForm->GetValue("x_DescrNivelInt4"));
		}
		if (!$this->DescrNivelInt3->FldIsDetailKey) {
			$this->DescrNivelInt3->setFormValue($objForm->GetValue("x_DescrNivelInt3"));
		}
		if (!$this->DescrNivelInt2->FldIsDetailKey) {
			$this->DescrNivelInt2->setFormValue($objForm->GetValue("x_DescrNivelInt2"));
		}
		if (!$this->TasaIva->FldIsDetailKey) {
			$this->TasaIva->setFormValue($objForm->GetValue("x_TasaIva"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->CodInternoArti->CurrentValue = $this->CodInternoArti->FormValue;
		$this->CodBarraArti->CurrentValue = $this->CodBarraArti->FormValue;
		$this->idTipoArticulo->CurrentValue = $this->idTipoArticulo->FormValue;
		$this->DescripcionArti->CurrentValue = $this->DescripcionArti->FormValue;
		$this->detalle->CurrentValue = $this->detalle->FormValue;
		$this->PrecioVta1_PreArti->CurrentValue = $this->PrecioVta1_PreArti->FormValue;
		$this->Stock1_StkArti->CurrentValue = $this->Stock1_StkArti->FormValue;
		$this->DescrNivelInt4->CurrentValue = $this->DescrNivelInt4->FormValue;
		$this->DescrNivelInt3->CurrentValue = $this->DescrNivelInt3->FormValue;
		$this->DescrNivelInt2->CurrentValue = $this->DescrNivelInt2->FormValue;
		$this->TasaIva->CurrentValue = $this->TasaIva->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CodInternoArti")) <> "")
			$this->CodInternoArti->CurrentValue = $this->getKey("CodInternoArti"); // CodInternoArti
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
		// Convert decimal values if posted back

		if ($this->PrecioVta1_PreArti->FormValue == $this->PrecioVta1_PreArti->CurrentValue && is_numeric(ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue)))
			$this->PrecioVta1_PreArti->CurrentValue = ew_StrToFloat($this->PrecioVta1_PreArti->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Stock1_StkArti->FormValue == $this->Stock1_StkArti->CurrentValue && is_numeric(ew_StrToFloat($this->Stock1_StkArti->CurrentValue)))
			$this->Stock1_StkArti->CurrentValue = ew_StrToFloat($this->Stock1_StkArti->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TasaIva->FormValue == $this->TasaIva->CurrentValue && is_numeric(ew_StrToFloat($this->TasaIva->CurrentValue)))
			$this->TasaIva->CurrentValue = ew_StrToFloat($this->TasaIva->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// CodInternoArti
		// CodBarraArti
		// idTipoArticulo
		// DescripcionArti
		// detalle
		// PrecioVta1_PreArti
		// Stock1_StkArti
		// NombreFotoArti
		// DescrNivelInt4
		// DescrNivelInt3
		// DescrNivelInt2
		// TasaIva

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

		// detalle
		$this->detalle->ViewValue = $this->detalle->CurrentValue;
		$this->detalle->ViewCustomAttributes = "";

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

			// detalle
			$this->detalle->LinkCustomAttributes = "";
			$this->detalle->HrefValue = "";
			$this->detalle->TooltipValue = "";

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

			// TasaIva
			$this->TasaIva->LinkCustomAttributes = "";
			$this->TasaIva->HrefValue = "";
			$this->TasaIva->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// CodInternoArti
			$this->CodInternoArti->EditAttrs["class"] = "form-control";
			$this->CodInternoArti->EditCustomAttributes = "";
			$this->CodInternoArti->EditValue = ew_HtmlEncode($this->CodInternoArti->CurrentValue);
			$this->CodInternoArti->PlaceHolder = ew_RemoveHtml($this->CodInternoArti->FldCaption());

			// CodBarraArti
			$this->CodBarraArti->EditAttrs["class"] = "form-control";
			$this->CodBarraArti->EditCustomAttributes = "";
			$this->CodBarraArti->EditValue = ew_HtmlEncode($this->CodBarraArti->CurrentValue);
			$this->CodBarraArti->PlaceHolder = ew_RemoveHtml($this->CodBarraArti->FldCaption());

			// idTipoArticulo
			$this->idTipoArticulo->EditCustomAttributes = "";
			if (trim(strval($this->idTipoArticulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->idTipoArticulo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `trama_tipos-articulos`";
			$sWhereWrk = "";
			$this->idTipoArticulo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idTipoArticulo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->DisplayValue($arwrk);
			} else {
				$this->idTipoArticulo->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->idTipoArticulo->EditValue = $arwrk;

			// DescripcionArti
			$this->DescripcionArti->EditAttrs["class"] = "form-control";
			$this->DescripcionArti->EditCustomAttributes = "";
			$this->DescripcionArti->EditValue = ew_HtmlEncode($this->DescripcionArti->CurrentValue);
			$this->DescripcionArti->PlaceHolder = ew_RemoveHtml($this->DescripcionArti->FldCaption());

			// detalle
			$this->detalle->EditAttrs["class"] = "form-control";
			$this->detalle->EditCustomAttributes = "";
			$this->detalle->EditValue = ew_HtmlEncode($this->detalle->CurrentValue);
			$this->detalle->PlaceHolder = ew_RemoveHtml($this->detalle->FldCaption());

			// PrecioVta1_PreArti
			$this->PrecioVta1_PreArti->EditAttrs["class"] = "form-control";
			$this->PrecioVta1_PreArti->EditCustomAttributes = "";
			$this->PrecioVta1_PreArti->EditValue = ew_HtmlEncode($this->PrecioVta1_PreArti->CurrentValue);
			$this->PrecioVta1_PreArti->PlaceHolder = ew_RemoveHtml($this->PrecioVta1_PreArti->FldCaption());
			if (strval($this->PrecioVta1_PreArti->EditValue) <> "" && is_numeric($this->PrecioVta1_PreArti->EditValue)) $this->PrecioVta1_PreArti->EditValue = ew_FormatNumber($this->PrecioVta1_PreArti->EditValue, -2, -1, 0, 0);

			// Stock1_StkArti
			$this->Stock1_StkArti->EditAttrs["class"] = "form-control";
			$this->Stock1_StkArti->EditCustomAttributes = "";
			$this->Stock1_StkArti->EditValue = ew_HtmlEncode($this->Stock1_StkArti->CurrentValue);
			$this->Stock1_StkArti->PlaceHolder = ew_RemoveHtml($this->Stock1_StkArti->FldCaption());
			if (strval($this->Stock1_StkArti->EditValue) <> "" && is_numeric($this->Stock1_StkArti->EditValue)) $this->Stock1_StkArti->EditValue = ew_FormatNumber($this->Stock1_StkArti->EditValue, -2, -1, -2, 0);

			// NombreFotoArti
			$this->NombreFotoArti->EditAttrs["class"] = "form-control";
			$this->NombreFotoArti->EditCustomAttributes = "";
			$this->NombreFotoArti->UploadPath = "../articulos/";
			if (!ew_Empty($this->NombreFotoArti->Upload->DbValue)) {
				$this->NombreFotoArti->EditValue = $this->NombreFotoArti->Upload->DbValue;
			} else {
				$this->NombreFotoArti->EditValue = "";
			}
			if (!ew_Empty($this->NombreFotoArti->CurrentValue))
				$this->NombreFotoArti->Upload->FileName = $this->NombreFotoArti->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->NombreFotoArti);

			// DescrNivelInt4
			$this->DescrNivelInt4->EditAttrs["class"] = "form-control";
			$this->DescrNivelInt4->EditCustomAttributes = "";
			$this->DescrNivelInt4->EditValue = ew_HtmlEncode($this->DescrNivelInt4->CurrentValue);
			$this->DescrNivelInt4->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt4->FldCaption());

			// DescrNivelInt3
			$this->DescrNivelInt3->EditAttrs["class"] = "form-control";
			$this->DescrNivelInt3->EditCustomAttributes = "";
			$this->DescrNivelInt3->EditValue = ew_HtmlEncode($this->DescrNivelInt3->CurrentValue);
			$this->DescrNivelInt3->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt3->FldCaption());

			// DescrNivelInt2
			$this->DescrNivelInt2->EditAttrs["class"] = "form-control";
			$this->DescrNivelInt2->EditCustomAttributes = "";
			$this->DescrNivelInt2->EditValue = ew_HtmlEncode($this->DescrNivelInt2->CurrentValue);
			$this->DescrNivelInt2->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt2->FldCaption());

			// TasaIva
			$this->TasaIva->EditAttrs["class"] = "form-control";
			$this->TasaIva->EditCustomAttributes = "";
			$this->TasaIva->EditValue = ew_HtmlEncode($this->TasaIva->CurrentValue);
			$this->TasaIva->PlaceHolder = ew_RemoveHtml($this->TasaIva->FldCaption());
			if (strval($this->TasaIva->EditValue) <> "" && is_numeric($this->TasaIva->EditValue)) $this->TasaIva->EditValue = ew_FormatNumber($this->TasaIva->EditValue, -2, -1, 0, 0);

			// Add refer script
			// CodInternoArti

			$this->CodInternoArti->LinkCustomAttributes = "";
			$this->CodInternoArti->HrefValue = "";

			// CodBarraArti
			$this->CodBarraArti->LinkCustomAttributes = "";
			$this->CodBarraArti->HrefValue = "";

			// idTipoArticulo
			$this->idTipoArticulo->LinkCustomAttributes = "";
			$this->idTipoArticulo->HrefValue = "";

			// DescripcionArti
			$this->DescripcionArti->LinkCustomAttributes = "";
			$this->DescripcionArti->HrefValue = "";

			// detalle
			$this->detalle->LinkCustomAttributes = "";
			$this->detalle->HrefValue = "";

			// PrecioVta1_PreArti
			$this->PrecioVta1_PreArti->LinkCustomAttributes = "";
			$this->PrecioVta1_PreArti->HrefValue = "";

			// Stock1_StkArti
			$this->Stock1_StkArti->LinkCustomAttributes = "";
			$this->Stock1_StkArti->HrefValue = "";

			// NombreFotoArti
			$this->NombreFotoArti->LinkCustomAttributes = "";
			$this->NombreFotoArti->HrefValue = "";
			$this->NombreFotoArti->HrefValue2 = $this->NombreFotoArti->UploadPath . $this->NombreFotoArti->Upload->DbValue;

			// DescrNivelInt4
			$this->DescrNivelInt4->LinkCustomAttributes = "";
			$this->DescrNivelInt4->HrefValue = "";

			// DescrNivelInt3
			$this->DescrNivelInt3->LinkCustomAttributes = "";
			$this->DescrNivelInt3->HrefValue = "";

			// DescrNivelInt2
			$this->DescrNivelInt2->LinkCustomAttributes = "";
			$this->DescrNivelInt2->HrefValue = "";

			// TasaIva
			$this->TasaIva->LinkCustomAttributes = "";
			$this->TasaIva->HrefValue = "";
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
		if (!$this->CodInternoArti->FldIsDetailKey && !is_null($this->CodInternoArti->FormValue) && $this->CodInternoArti->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->CodInternoArti->FldCaption(), $this->CodInternoArti->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->PrecioVta1_PreArti->FormValue)) {
			ew_AddMessage($gsFormError, $this->PrecioVta1_PreArti->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Stock1_StkArti->FormValue)) {
			ew_AddMessage($gsFormError, $this->Stock1_StkArti->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TasaIva->FormValue)) {
			ew_AddMessage($gsFormError, $this->TasaIva->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("trama_articulos2Dimagenes2Dadicionales", $DetailTblVar) && $GLOBALS["trama_articulos2Dimagenes2Dadicionales"]->DetailAdd) {
			if (!isset($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"])) $GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"] = new ctrama_articulos2Dimagenes2Dadicionales_grid(); // get detail page object
			$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->ValidateGridForm();
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
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->NombreFotoArti->OldUploadPath = "../articulos/";
			$this->NombreFotoArti->UploadPath = $this->NombreFotoArti->OldUploadPath;
		}
		$rsnew = array();

		// CodInternoArti
		$this->CodInternoArti->SetDbValueDef($rsnew, $this->CodInternoArti->CurrentValue, "", FALSE);

		// CodBarraArti
		$this->CodBarraArti->SetDbValueDef($rsnew, $this->CodBarraArti->CurrentValue, NULL, FALSE);

		// idTipoArticulo
		$this->idTipoArticulo->SetDbValueDef($rsnew, $this->idTipoArticulo->CurrentValue, NULL, FALSE);

		// DescripcionArti
		$this->DescripcionArti->SetDbValueDef($rsnew, $this->DescripcionArti->CurrentValue, NULL, FALSE);

		// detalle
		$this->detalle->SetDbValueDef($rsnew, $this->detalle->CurrentValue, NULL, FALSE);

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->SetDbValueDef($rsnew, $this->PrecioVta1_PreArti->CurrentValue, NULL, FALSE);

		// Stock1_StkArti
		$this->Stock1_StkArti->SetDbValueDef($rsnew, $this->Stock1_StkArti->CurrentValue, NULL, FALSE);

		// NombreFotoArti
		if ($this->NombreFotoArti->Visible && !$this->NombreFotoArti->Upload->KeepFile) {
			$this->NombreFotoArti->Upload->DbValue = ""; // No need to delete old file
			if ($this->NombreFotoArti->Upload->FileName == "") {
				$rsnew['NombreFotoArti'] = NULL;
			} else {
				$rsnew['NombreFotoArti'] = $this->NombreFotoArti->Upload->FileName;
			}
		}

		// DescrNivelInt4
		$this->DescrNivelInt4->SetDbValueDef($rsnew, $this->DescrNivelInt4->CurrentValue, NULL, FALSE);

		// DescrNivelInt3
		$this->DescrNivelInt3->SetDbValueDef($rsnew, $this->DescrNivelInt3->CurrentValue, NULL, FALSE);

		// DescrNivelInt2
		$this->DescrNivelInt2->SetDbValueDef($rsnew, $this->DescrNivelInt2->CurrentValue, NULL, FALSE);

		// TasaIva
		$this->TasaIva->SetDbValueDef($rsnew, $this->TasaIva->CurrentValue, NULL, FALSE);
		if ($this->NombreFotoArti->Visible && !$this->NombreFotoArti->Upload->KeepFile) {
			$this->NombreFotoArti->UploadPath = "../articulos/";
			if (!ew_Empty($this->NombreFotoArti->Upload->Value)) {
				$rsnew['NombreFotoArti'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->NombreFotoArti->UploadPath), $rsnew['NombreFotoArti']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['CodInternoArti']) == "") {
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
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->NombreFotoArti->Visible && !$this->NombreFotoArti->Upload->KeepFile) {
					if (!ew_Empty($this->NombreFotoArti->Upload->Value)) {
						$this->NombreFotoArti->Upload->SaveToFile($this->NombreFotoArti->UploadPath, $rsnew['NombreFotoArti'], TRUE);
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
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("trama_articulos2Dimagenes2Dadicionales", $DetailTblVar) && $GLOBALS["trama_articulos2Dimagenes2Dadicionales"]->DetailAdd) {
				$GLOBALS["trama_articulos2Dimagenes2Dadicionales"]->idArticulo->setSessionValue($this->CodInternoArti->CurrentValue); // Set master key
				if (!isset($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"])) $GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"] = new ctrama_articulos2Dimagenes2Dadicionales_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "trama_articulos-imagenes-adicionales"); // Load user level of detail table
				$AddRow = $GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales"]->idArticulo->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// NombreFotoArti
		ew_CleanUploadTempPath($this->NombreFotoArti, $this->NombreFotoArti->Upload->Index);
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("trama_articulos2Dimagenes2Dadicionales", $DetailTblVar)) {
				if (!isset($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]))
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"] = new ctrama_articulos2Dimagenes2Dadicionales_grid;
				if ($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->CurrentMode = "add";
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->setStartRecordNumber(1);
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->idArticulo->FldIsDetailKey = TRUE;
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->idArticulo->CurrentValue = $this->CodInternoArti->CurrentValue;
					$GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->idArticulo->setSessionValue($GLOBALS["trama_articulos2Dimagenes2Dadicionales_grid"]->idArticulo->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("dbo_articulolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_idTipoArticulo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_tipos-articulos`";
			$sWhereWrk = "";
			$this->idTipoArticulo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`id` = {filter_value}", "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->idTipoArticulo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `denominacion` ASC";
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
		global $dbo_articulo_codigo_autogenerado;
		if ($dbo_articulo_codigo_autogenerado)
		{
			$this->CodInternoArti->EditValue = uniqid();
			$this->CodInternoArti->ReadOnly = true;
		}
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
if (!isset($dbo_articulo_add)) $dbo_articulo_add = new cdbo_articulo_add();

// Page init
$dbo_articulo_add->Page_Init();

// Page main
$dbo_articulo_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dbo_articulo_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdbo_articuloadd = new ew_Form("fdbo_articuloadd", "add");

// Validate form
fdbo_articuloadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_CodInternoArti");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $dbo_articulo->CodInternoArti->FldCaption(), $dbo_articulo->CodInternoArti->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PrecioVta1_PreArti");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dbo_articulo->PrecioVta1_PreArti->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Stock1_StkArti");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dbo_articulo->Stock1_StkArti->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TasaIva");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dbo_articulo->TasaIva->FldErrMsg()) ?>");

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
fdbo_articuloadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdbo_articuloadd.ValidateRequired = true;
<?php } else { ?>
fdbo_articuloadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdbo_articuloadd.Lists["x_idTipoArticulo"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_tipos2Darticulos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$dbo_articulo_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $dbo_articulo_add->ShowPageHeader(); ?>
<?php
$dbo_articulo_add->ShowMessage();
?>
<form name="fdbo_articuloadd" id="fdbo_articuloadd" class="<?php echo $dbo_articulo_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dbo_articulo_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dbo_articulo_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dbo_articulo">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($dbo_articulo_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
	<div id="r_CodInternoArti" class="form-group">
		<label id="elh_dbo_articulo_CodInternoArti" for="x_CodInternoArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->CodInternoArti->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<span id="el_dbo_articulo_CodInternoArti">
<input type="text" data-table="dbo_articulo" data-field="x_CodInternoArti" name="x_CodInternoArti" id="x_CodInternoArti" size="30" maxlength="24" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->CodInternoArti->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->CodInternoArti->EditValue ?>"<?php echo $dbo_articulo->CodInternoArti->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->CodInternoArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
	<div id="r_CodBarraArti" class="form-group">
		<label id="elh_dbo_articulo_CodBarraArti" for="x_CodBarraArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->CodBarraArti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<span id="el_dbo_articulo_CodBarraArti">
<input type="text" data-table="dbo_articulo" data-field="x_CodBarraArti" name="x_CodBarraArti" id="x_CodBarraArti" size="30" maxlength="24" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->CodBarraArti->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->CodBarraArti->EditValue ?>"<?php echo $dbo_articulo->CodBarraArti->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->CodBarraArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
	<div id="r_idTipoArticulo" class="form-group">
		<label id="elh_dbo_articulo_idTipoArticulo" for="x_idTipoArticulo" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->idTipoArticulo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->idTipoArticulo->CellAttributes() ?>>
<span id="el_dbo_articulo_idTipoArticulo">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $dbo_articulo->idTipoArticulo->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_idTipoArticulo" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $dbo_articulo->idTipoArticulo->RadioButtonListHtml(TRUE, "x_idTipoArticulo") ?>
		</div>
	</div>
	<div id="tp_x_idTipoArticulo" class="ewTemplate"><input type="radio" data-table="dbo_articulo" data-field="x_idTipoArticulo" data-value-separator="<?php echo $dbo_articulo->idTipoArticulo->DisplayValueSeparatorAttribute() ?>" name="x_idTipoArticulo" id="x_idTipoArticulo" value="{value}"<?php echo $dbo_articulo->idTipoArticulo->EditAttributes() ?>></div>
</div>
<input type="hidden" name="s_x_idTipoArticulo" id="s_x_idTipoArticulo" value="<?php echo $dbo_articulo->idTipoArticulo->LookupFilterQuery() ?>">
</span>
<?php echo $dbo_articulo->idTipoArticulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
	<div id="r_DescripcionArti" class="form-group">
		<label id="elh_dbo_articulo_DescripcionArti" for="x_DescripcionArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->DescripcionArti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<span id="el_dbo_articulo_DescripcionArti">
<input type="text" data-table="dbo_articulo" data-field="x_DescripcionArti" name="x_DescripcionArti" id="x_DescripcionArti" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->DescripcionArti->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->DescripcionArti->EditValue ?>"<?php echo $dbo_articulo->DescripcionArti->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->DescripcionArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->detalle->Visible) { // detalle ?>
	<div id="r_detalle" class="form-group">
		<label id="elh_dbo_articulo_detalle" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->detalle->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->detalle->CellAttributes() ?>>
<span id="el_dbo_articulo_detalle">
<?php ew_AppendClass($dbo_articulo->detalle->EditAttrs["class"], "editor"); ?>
<textarea data-table="dbo_articulo" data-field="x_detalle" name="x_detalle" id="x_detalle" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->detalle->getPlaceHolder()) ?>"<?php echo $dbo_articulo->detalle->EditAttributes() ?>><?php echo $dbo_articulo->detalle->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fdbo_articuloadd", "x_detalle", 35, 4, <?php echo ($dbo_articulo->detalle->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $dbo_articulo->detalle->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
	<div id="r_PrecioVta1_PreArti" class="form-group">
		<label id="elh_dbo_articulo_PrecioVta1_PreArti" for="x_PrecioVta1_PreArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->PrecioVta1_PreArti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<span id="el_dbo_articulo_PrecioVta1_PreArti">
<input type="text" data-table="dbo_articulo" data-field="x_PrecioVta1_PreArti" name="x_PrecioVta1_PreArti" id="x_PrecioVta1_PreArti" size="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->PrecioVta1_PreArti->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->PrecioVta1_PreArti->EditValue ?>"<?php echo $dbo_articulo->PrecioVta1_PreArti->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->PrecioVta1_PreArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
	<div id="r_Stock1_StkArti" class="form-group">
		<label id="elh_dbo_articulo_Stock1_StkArti" for="x_Stock1_StkArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->Stock1_StkArti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<span id="el_dbo_articulo_Stock1_StkArti">
<input type="text" data-table="dbo_articulo" data-field="x_Stock1_StkArti" name="x_Stock1_StkArti" id="x_Stock1_StkArti" size="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->Stock1_StkArti->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->Stock1_StkArti->EditValue ?>"<?php echo $dbo_articulo->Stock1_StkArti->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->Stock1_StkArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
	<div id="r_NombreFotoArti" class="form-group">
		<label id="elh_dbo_articulo_NombreFotoArti" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->NombreFotoArti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<span id="el_dbo_articulo_NombreFotoArti">
<div id="fd_x_NombreFotoArti">
<span title="<?php echo $dbo_articulo->NombreFotoArti->FldTitle() ? $dbo_articulo->NombreFotoArti->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($dbo_articulo->NombreFotoArti->ReadOnly || $dbo_articulo->NombreFotoArti->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="dbo_articulo" data-field="x_NombreFotoArti" name="x_NombreFotoArti" id="x_NombreFotoArti"<?php echo $dbo_articulo->NombreFotoArti->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_NombreFotoArti" id= "fn_x_NombreFotoArti" value="<?php echo $dbo_articulo->NombreFotoArti->Upload->FileName ?>">
<input type="hidden" name="fa_x_NombreFotoArti" id= "fa_x_NombreFotoArti" value="0">
<input type="hidden" name="fs_x_NombreFotoArti" id= "fs_x_NombreFotoArti" value="100">
<input type="hidden" name="fx_x_NombreFotoArti" id= "fx_x_NombreFotoArti" value="<?php echo $dbo_articulo->NombreFotoArti->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_NombreFotoArti" id= "fm_x_NombreFotoArti" value="<?php echo $dbo_articulo->NombreFotoArti->UploadMaxFileSize ?>">
</div>
<table id="ft_x_NombreFotoArti" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $dbo_articulo->NombreFotoArti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
	<div id="r_DescrNivelInt4" class="form-group">
		<label id="elh_dbo_articulo_DescrNivelInt4" for="x_DescrNivelInt4" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->DescrNivelInt4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt4">
<input type="text" data-table="dbo_articulo" data-field="x_DescrNivelInt4" name="x_DescrNivelInt4" id="x_DescrNivelInt4" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->DescrNivelInt4->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->DescrNivelInt4->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt4->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->DescrNivelInt4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
	<div id="r_DescrNivelInt3" class="form-group">
		<label id="elh_dbo_articulo_DescrNivelInt3" for="x_DescrNivelInt3" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->DescrNivelInt3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt3">
<input type="text" data-table="dbo_articulo" data-field="x_DescrNivelInt3" name="x_DescrNivelInt3" id="x_DescrNivelInt3" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->DescrNivelInt3->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->DescrNivelInt3->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt3->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->DescrNivelInt3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
	<div id="r_DescrNivelInt2" class="form-group">
		<label id="elh_dbo_articulo_DescrNivelInt2" for="x_DescrNivelInt2" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->DescrNivelInt2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt2">
<input type="text" data-table="dbo_articulo" data-field="x_DescrNivelInt2" name="x_DescrNivelInt2" id="x_DescrNivelInt2" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->DescrNivelInt2->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->DescrNivelInt2->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt2->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->DescrNivelInt2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dbo_articulo->TasaIva->Visible) { // TasaIva ?>
	<div id="r_TasaIva" class="form-group">
		<label id="elh_dbo_articulo_TasaIva" for="x_TasaIva" class="col-sm-2 control-label ewLabel"><?php echo $dbo_articulo->TasaIva->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>>
<span id="el_dbo_articulo_TasaIva">
<input type="text" data-table="dbo_articulo" data-field="x_TasaIva" name="x_TasaIva" id="x_TasaIva" size="30" placeholder="<?php echo ew_HtmlEncode($dbo_articulo->TasaIva->getPlaceHolder()) ?>" value="<?php echo $dbo_articulo->TasaIva->EditValue ?>"<?php echo $dbo_articulo->TasaIva->EditAttributes() ?>>
</span>
<?php echo $dbo_articulo->TasaIva->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("trama_articulos2Dimagenes2Dadicionales", explode(",", $dbo_articulo->getCurrentDetailTable())) && $trama_articulos2Dimagenes2Dadicionales->DetailAdd) {
?>
<?php if ($dbo_articulo->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("trama_articulos2Dimagenes2Dadicionales", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "trama_articulos2Dimagenes2Dadicionalesgrid.php" ?>
<?php } ?>
<?php if (!$dbo_articulo_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dbo_articulo_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdbo_articuloadd.Init();
</script>
<?php
$dbo_articulo_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dbo_articulo_add->Page_Terminate();
?>
