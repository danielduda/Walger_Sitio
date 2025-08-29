<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_moneda', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_monedainfo.php" ?>
<?php include "userfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Open connection to the database
$conn = ew_Connect();
?>
<?php
$Security = new cAdvancedSecurity();
?>
<?php
if (!$Security->IsLoggedIn()) $Security->AutoLogin();
if (!$Security->IsLoggedIn()) {
	$Security->SaveLastUrl();
	Page_Terminate("login.php");
}
?>
<?php

// Common page loading event (in userfn*.php)
Page_Loading();
?>
<?php

// Page load event, used in current page
Page_Load();
?>
<?php
$dbo_moneda->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_moneda->Export; // Get export parameter, used in header
$sExportFile = $dbo_moneda->TableVar; // Get export file, used in header
?>
<?php

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["Regis_Mda"] != "") {
  $dbo_moneda->Regis_Mda->setQueryStringValue($_GET["Regis_Mda"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $dbo_moneda->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $dbo_moneda->CurrentAction = "C"; // Copy Record
  } else {
    $dbo_moneda->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($dbo_moneda->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($dbo_moneda->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$dbo_moneda->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($dbo_moneda->KeyUrl($dbo_moneda->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$dbo_moneda->RowType = EW_ROWTYPE_ADD;  // Render add type
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "add"; // Page id

//-->
</script>
<script type="text/javascript">
<!--

function ew_ValidateForm(fobj) {
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_Regis_Mda"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - ID"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Regis_Mda"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - ID"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_Cotiz_Mda"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Cotización"))
				return false; 
		}
	}
	return true;
}

//-->
</script>
<script type="text/javascript">
<!--

// js for DHtml Editor
//-->

</script>
<script type="text/javascript">
<!--

// js for Popup Calendar
//-->

</script>
<script type="text/javascript">
<!--
var ew_MultiPagePage = "Página"; // multi-page Page Text
var ew_MultiPageOf = "de"; // multi-page Of Text
var ew_MultiPagePrev = "Anterior"; // multi-page Prev Text
var ew_MultiPageNext = "Siguiente"; // multi-page Next Text

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Agregar a : Monedas (ISIS)<br><br><a href="<?php echo $dbo_moneda->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fdbo_monedaadd" id="fdbo_monedaadd" action="dbo_monedaadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">ID<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $dbo_moneda->Regis_Mda->CellAttributes() ?>><span id="cb_x_Regis_Mda">
<input type="text" name="x_Regis_Mda" id="x_Regis_Mda" title="" size="30" value="<?php echo $dbo_moneda->Regis_Mda->EditValue ?>"<?php echo $dbo_moneda->Regis_Mda->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Descripción</td>
    <td<?php echo $dbo_moneda->Descr_Mda->CellAttributes() ?>><span id="cb_x_Descr_Mda">
<input type="text" name="x_Descr_Mda" id="x_Descr_Mda" title="" size="30" maxlength="16" value="<?php echo $dbo_moneda->Descr_Mda->EditValue ?>"<?php echo $dbo_moneda->Descr_Mda->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Signo</td>
    <td<?php echo $dbo_moneda->Signo_Mda->CellAttributes() ?>><span id="cb_x_Signo_Mda">
<input type="text" name="x_Signo_Mda" id="x_Signo_Mda" title="" size="30" maxlength="5" value="<?php echo $dbo_moneda->Signo_Mda->EditValue ?>"<?php echo $dbo_moneda->Signo_Mda->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Cotización</td>
    <td<?php echo $dbo_moneda->Cotiz_Mda->CellAttributes() ?>><span id="cb_x_Cotiz_Mda">
<input type="text" name="x_Cotiz_Mda" id="x_Cotiz_Mda" title="" size="30" value="<?php echo $dbo_moneda->Cotiz_Mda->EditValue ?>"<?php echo $dbo_moneda->Cotiz_Mda->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Código AFIP</td>
    <td<?php echo $dbo_moneda->CodigoAFIP_Mda->CellAttributes() ?>><span id="cb_x_CodigoAFIP_Mda">
<input type="text" name="x_CodigoAFIP_Mda" id="x_CodigoAFIP_Mda" title="" size="30" maxlength="3" value="<?php echo $dbo_moneda->CodigoAFIP_Mda->EditValue ?>"<?php echo $dbo_moneda->CodigoAFIP_Mda->EditAttributes() ?>>
</span></td>
  </tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="Guardar y continuar">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

// If control is passed here, simply terminate the page without redirect
Page_Terminate();

// -----------------------------------------------------------------
//  Subroutine Page_Terminate
//  - called when exit page
//  - clean up connection and objects
//  - if url specified, redirect to url, otherwise end response
function Page_Terminate($url = "") {
	global $conn;

	// Page unload event, used in current page
	Page_Unload();

	// Global page unloaded event (in userfn*.php)
	Page_Unloaded();

	 // Close Connection
	$conn->Close();

	// Go to url if specified
	if ($url <> "") {
		ob_end_clean();
		header("Location: $url");
	}
	exit();
}
?>
<?php

// Load default values
function LoadDefaultValues() {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->CurrentValue = 0;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $dbo_moneda;
	$dbo_moneda->Regis_Mda->setFormValue($objForm->GetValue("x_Regis_Mda"));
	$dbo_moneda->Descr_Mda->setFormValue($objForm->GetValue("x_Descr_Mda"));
	$dbo_moneda->Signo_Mda->setFormValue($objForm->GetValue("x_Signo_Mda"));
	$dbo_moneda->Cotiz_Mda->setFormValue($objForm->GetValue("x_Cotiz_Mda"));
	$dbo_moneda->CodigoAFIP_Mda->setFormValue($objForm->GetValue("x_CodigoAFIP_Mda"));
}

// Restore form values
function RestoreFormValues() {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->CurrentValue = $dbo_moneda->Regis_Mda->FormValue;
	$dbo_moneda->Descr_Mda->CurrentValue = $dbo_moneda->Descr_Mda->FormValue;
	$dbo_moneda->Signo_Mda->CurrentValue = $dbo_moneda->Signo_Mda->FormValue;
	$dbo_moneda->Cotiz_Mda->CurrentValue = $dbo_moneda->Cotiz_Mda->FormValue;
	$dbo_moneda->CodigoAFIP_Mda->CurrentValue = $dbo_moneda->CodigoAFIP_Mda->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_moneda;
	$sFilter = $dbo_moneda->SqlKeyFilter();
	if (!is_numeric($dbo_moneda->Regis_Mda->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_Mda@", ew_AdjustSql($dbo_moneda->Regis_Mda->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_moneda->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_moneda->CurrentFilter = $sFilter;
	$sSql = $dbo_moneda->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_moneda->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$dbo_moneda->Descr_Mda->setDbValue($rs->fields('Descr_Mda'));
	$dbo_moneda->Signo_Mda->setDbValue($rs->fields('Signo_Mda'));
	$dbo_moneda->Cotiz_Mda->setDbValue($rs->fields('Cotiz_Mda'));
	$dbo_moneda->CodigoAFIP_Mda->setDbValue($rs->fields('CodigoAFIP_Mda'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_moneda;

	// Call Row Rendering event
	$dbo_moneda->Row_Rendering();

	// Common render codes for all row types
	// Regis_Mda

	$dbo_moneda->Regis_Mda->CellCssStyle = "";
	$dbo_moneda->Regis_Mda->CellCssClass = "";

	// Descr_Mda
	$dbo_moneda->Descr_Mda->CellCssStyle = "";
	$dbo_moneda->Descr_Mda->CellCssClass = "";

	// Signo_Mda
	$dbo_moneda->Signo_Mda->CellCssStyle = "";
	$dbo_moneda->Signo_Mda->CellCssClass = "";

	// Cotiz_Mda
	$dbo_moneda->Cotiz_Mda->CellCssStyle = "";
	$dbo_moneda->Cotiz_Mda->CellCssClass = "";

	// CodigoAFIP_Mda
	$dbo_moneda->CodigoAFIP_Mda->CellCssStyle = "";
	$dbo_moneda->CodigoAFIP_Mda->CellCssClass = "";
	if ($dbo_moneda->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_ADD) { // Add row

		// Regis_Mda
		$dbo_moneda->Regis_Mda->EditCustomAttributes = "";
		$dbo_moneda->Regis_Mda->EditValue = ew_HtmlEncode($dbo_moneda->Regis_Mda->CurrentValue);

		// Descr_Mda
		$dbo_moneda->Descr_Mda->EditCustomAttributes = "";
		$dbo_moneda->Descr_Mda->EditValue = ew_HtmlEncode($dbo_moneda->Descr_Mda->CurrentValue);

		// Signo_Mda
		$dbo_moneda->Signo_Mda->EditCustomAttributes = "";
		$dbo_moneda->Signo_Mda->EditValue = ew_HtmlEncode($dbo_moneda->Signo_Mda->CurrentValue);

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->EditCustomAttributes = "";
		$dbo_moneda->Cotiz_Mda->EditValue = ew_HtmlEncode($dbo_moneda->Cotiz_Mda->CurrentValue);

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->EditCustomAttributes = "";
		$dbo_moneda->CodigoAFIP_Mda->EditValue = ew_HtmlEncode($dbo_moneda->CodigoAFIP_Mda->CurrentValue);
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_moneda->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $dbo_moneda;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $dbo_moneda->SqlKeyFilter();
	if (trim(strval($dbo_moneda->Regis_Mda->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@Regis_Mda@", ew_AdjustSql($dbo_moneda->Regis_Mda->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($dbo_moneda->Regis_Mda->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $dbo_moneda->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field Regis_Mda
	$dbo_moneda->Regis_Mda->SetDbValueDef($dbo_moneda->Regis_Mda->CurrentValue, 0);
	$rsnew['Regis_Mda'] =& $dbo_moneda->Regis_Mda->DbValue;

	// Field Descr_Mda
	$dbo_moneda->Descr_Mda->SetDbValueDef($dbo_moneda->Descr_Mda->CurrentValue, NULL);
	$rsnew['Descr_Mda'] =& $dbo_moneda->Descr_Mda->DbValue;

	// Field Signo_Mda
	$dbo_moneda->Signo_Mda->SetDbValueDef($dbo_moneda->Signo_Mda->CurrentValue, NULL);
	$rsnew['Signo_Mda'] =& $dbo_moneda->Signo_Mda->DbValue;

	// Field Cotiz_Mda
	$dbo_moneda->Cotiz_Mda->SetDbValueDef($dbo_moneda->Cotiz_Mda->CurrentValue, NULL);
	$rsnew['Cotiz_Mda'] =& $dbo_moneda->Cotiz_Mda->DbValue;

	// Field CodigoAFIP_Mda
	$dbo_moneda->CodigoAFIP_Mda->SetDbValueDef($dbo_moneda->CodigoAFIP_Mda->CurrentValue, NULL);
	$rsnew['CodigoAFIP_Mda'] =& $dbo_moneda->CodigoAFIP_Mda->DbValue;

	// Call Row Inserting event
	$bInsertRow = $dbo_moneda->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($dbo_moneda->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($dbo_moneda->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_moneda->CancelMessage;
			$dbo_moneda->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {

		// Call Row Inserted event
		$dbo_moneda->Row_Inserted($rsnew);
	}
	return $AddRow;
}
?>
<?php

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
