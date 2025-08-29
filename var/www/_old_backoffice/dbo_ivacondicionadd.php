<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_ivacondicion', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_ivacondicioninfo.php" ?>
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
$dbo_ivacondicion->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_ivacondicion->Export; // Get export parameter, used in header
$sExportFile = $dbo_ivacondicion->TableVar; // Get export file, used in header
?>
<?php

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["Regis_IvaC"] != "") {
  $dbo_ivacondicion->Regis_IvaC->setQueryStringValue($_GET["Regis_IvaC"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $dbo_ivacondicion->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $dbo_ivacondicion->CurrentAction = "C"; // Copy Record
  } else {
    $dbo_ivacondicion->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($dbo_ivacondicion->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($dbo_ivacondicion->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$dbo_ivacondicion->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($dbo_ivacondicion->KeyUrl($dbo_ivacondicion->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$dbo_ivacondicion->RowType = EW_ROWTYPE_ADD;  // Render add type
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
		elm = fobj.elements["x" + infix + "_Regis_IvaC"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - ID"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Regis_IvaC"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - ID"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_CalculaIvaC"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Calcula Iva ?"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_DiscriminaIvaC"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Discrimina Iva ?"))
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
<p><span class="phpmaker">Agregar a : Condiciones IVA (ISIS)<br><br><a href="<?php echo $dbo_ivacondicion->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fdbo_ivacondicionadd" id="fdbo_ivacondicionadd" action="dbo_ivacondicionadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">ID<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>><span id="cb_x_Regis_IvaC">
<input type="text" name="x_Regis_IvaC" id="x_Regis_IvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->Regis_IvaC->EditValue ?>"<?php echo $dbo_ivacondicion->Regis_IvaC->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Descripción</td>
    <td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>><span id="cb_x_DescrIvaC">
<input type="text" name="x_DescrIvaC" id="x_DescrIvaC" title="" size="30" maxlength="20" value="<?php echo $dbo_ivacondicion->DescrIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->DescrIvaC->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Calcula Iva ?</td>
    <td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>><span id="cb_x_CalculaIvaC">
<input type="text" name="x_CalculaIvaC" id="x_CalculaIvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->CalculaIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->CalculaIvaC->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Discrimina Iva ?</td>
    <td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>><span id="cb_x_DiscriminaIvaC">
<input type="text" name="x_DiscriminaIvaC" id="x_DiscriminaIvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->DiscriminaIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->DiscriminaIvaC->EditAttributes() ?>>
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
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->CurrentValue = 0;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->setFormValue($objForm->GetValue("x_Regis_IvaC"));
	$dbo_ivacondicion->DescrIvaC->setFormValue($objForm->GetValue("x_DescrIvaC"));
	$dbo_ivacondicion->CalculaIvaC->setFormValue($objForm->GetValue("x_CalculaIvaC"));
	$dbo_ivacondicion->DiscriminaIvaC->setFormValue($objForm->GetValue("x_DiscriminaIvaC"));
}

// Restore form values
function RestoreFormValues() {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->CurrentValue = $dbo_ivacondicion->Regis_IvaC->FormValue;
	$dbo_ivacondicion->DescrIvaC->CurrentValue = $dbo_ivacondicion->DescrIvaC->FormValue;
	$dbo_ivacondicion->CalculaIvaC->CurrentValue = $dbo_ivacondicion->CalculaIvaC->FormValue;
	$dbo_ivacondicion->DiscriminaIvaC->CurrentValue = $dbo_ivacondicion->DiscriminaIvaC->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_ivacondicion;
	$sFilter = $dbo_ivacondicion->SqlKeyFilter();
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_IvaC@", ew_AdjustSql($dbo_ivacondicion->Regis_IvaC->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_ivacondicion->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_ivacondicion->CurrentFilter = $sFilter;
	$sSql = $dbo_ivacondicion->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_ivacondicion->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_ivacondicion->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
	$dbo_ivacondicion->CalculaIvaC->setDbValue($rs->fields('CalculaIvaC'));
	$dbo_ivacondicion->DiscriminaIvaC->setDbValue($rs->fields('DiscriminaIvaC'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_ivacondicion;

	// Call Row Rendering event
	$dbo_ivacondicion->Row_Rendering();

	// Common render codes for all row types
	// Regis_IvaC

	$dbo_ivacondicion->Regis_IvaC->CellCssStyle = "";
	$dbo_ivacondicion->Regis_IvaC->CellCssClass = "";

	// DescrIvaC
	$dbo_ivacondicion->DescrIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DescrIvaC->CellCssClass = "";

	// CalculaIvaC
	$dbo_ivacondicion->CalculaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->CalculaIvaC->CellCssClass = "";

	// DiscriminaIvaC
	$dbo_ivacondicion->DiscriminaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DiscriminaIvaC->CellCssClass = "";
	if ($dbo_ivacondicion->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_ADD) { // Add row

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->Regis_IvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->Regis_IvaC->CurrentValue);

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->DescrIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->DescrIvaC->CurrentValue);

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->CalculaIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->CalculaIvaC->CurrentValue);

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->DiscriminaIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->DiscriminaIvaC->CurrentValue);
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_ivacondicion->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $dbo_ivacondicion;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $dbo_ivacondicion->SqlKeyFilter();
	if (trim(strval($dbo_ivacondicion->Regis_IvaC->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@Regis_IvaC@", ew_AdjustSql($dbo_ivacondicion->Regis_IvaC->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $dbo_ivacondicion->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field Regis_IvaC
	$dbo_ivacondicion->Regis_IvaC->SetDbValueDef($dbo_ivacondicion->Regis_IvaC->CurrentValue, 0);
	$rsnew['Regis_IvaC'] =& $dbo_ivacondicion->Regis_IvaC->DbValue;

	// Field DescrIvaC
	$dbo_ivacondicion->DescrIvaC->SetDbValueDef($dbo_ivacondicion->DescrIvaC->CurrentValue, NULL);
	$rsnew['DescrIvaC'] =& $dbo_ivacondicion->DescrIvaC->DbValue;

	// Field CalculaIvaC
	$dbo_ivacondicion->CalculaIvaC->SetDbValueDef($dbo_ivacondicion->CalculaIvaC->CurrentValue, NULL);
	$rsnew['CalculaIvaC'] =& $dbo_ivacondicion->CalculaIvaC->DbValue;

	// Field DiscriminaIvaC
	$dbo_ivacondicion->DiscriminaIvaC->SetDbValueDef($dbo_ivacondicion->DiscriminaIvaC->CurrentValue, NULL);
	$rsnew['DiscriminaIvaC'] =& $dbo_ivacondicion->DiscriminaIvaC->DbValue;

	// Call Row Inserting event
	$bInsertRow = $dbo_ivacondicion->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($dbo_ivacondicion->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($dbo_ivacondicion->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_ivacondicion->CancelMessage;
			$dbo_ivacondicion->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {

		// Call Row Inserted event
		$dbo_ivacondicion->Row_Inserted($rsnew);
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
