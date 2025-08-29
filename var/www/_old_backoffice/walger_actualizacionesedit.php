<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_actualizaciones', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_actualizacionesinfo.php" ?>
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
$walger_actualizaciones->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_actualizaciones->Export; // Get export parameter, used in header
$sExportFile = $walger_actualizaciones->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["fecha"] <> "") {
	$walger_actualizaciones->fecha->setQueryStringValue($_GET["fecha"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_actualizaciones->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_actualizaciones->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_actualizaciones->fecha->CurrentValue == "") Page_Terminate($walger_actualizaciones->getReturnUrl()); // Invalid key, exit
switch ($walger_actualizaciones->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_actualizaciones->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_actualizaciones->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_actualizaciones->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_actualizaciones->RowType = EW_ROWTYPE_EDIT; // Render as edit
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "edit"; // Page id

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
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Fecha"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_pendiente"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Pendiente ?"))
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
<p><span class="phpmaker">Editar : Actualizaciones<br><br><a href="<?php echo $walger_actualizaciones->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_actualizacionesedit" id="fwalger_actualizacionesedit" action="walger_actualizacionesedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Fecha<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_actualizaciones->fecha->CellAttributes() ?>><span id="cb_x_fecha">
<div<?php echo $walger_actualizaciones->fecha->ViewAttributes() ?>><?php echo $walger_actualizaciones->fecha->EditValue ?></div>
<input type="hidden" name="x_fecha" id="x_fecha" value="<?php echo ew_HtmlEncode($walger_actualizaciones->fecha->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Pendiente ?<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_actualizaciones->pendiente->CellAttributes() ?>><span id="cb_x_pendiente">
<input type="text" name="x_pendiente" id="x_pendiente" title="" size="30" maxlength="1" value="<?php echo $walger_actualizaciones->pendiente->EditValue ?>"<?php echo $walger_actualizaciones->pendiente->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  Editar  ">
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

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $walger_actualizaciones;
	$walger_actualizaciones->fecha->setFormValue($objForm->GetValue("x_fecha"));
	$walger_actualizaciones->fecha->CurrentValue = ew_UnFormatDateTime($walger_actualizaciones->fecha->CurrentValue, 7);
	$walger_actualizaciones->pendiente->setFormValue($objForm->GetValue("x_pendiente"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_actualizaciones;
	$walger_actualizaciones->fecha->CurrentValue = $walger_actualizaciones->fecha->FormValue;
	$walger_actualizaciones->pendiente->CurrentValue = $walger_actualizaciones->pendiente->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_actualizaciones;
	$sFilter = $walger_actualizaciones->SqlKeyFilter();
	$sFilter = str_replace("@fecha@", ew_AdjustSql($walger_actualizaciones->fecha->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_actualizaciones->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_actualizaciones->CurrentFilter = $sFilter;
	$sSql = $walger_actualizaciones->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_actualizaciones->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_actualizaciones;
	$walger_actualizaciones->fecha->setDbValue($rs->fields('fecha'));
	$walger_actualizaciones->pendiente->setDbValue($rs->fields('pendiente'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_actualizaciones;

	// Call Row Rendering event
	$walger_actualizaciones->Row_Rendering();

	// Common render codes for all row types
	// fecha

	$walger_actualizaciones->fecha->CellCssStyle = "";
	$walger_actualizaciones->fecha->CellCssClass = "";

	// pendiente
	$walger_actualizaciones->pendiente->CellCssStyle = "";
	$walger_actualizaciones->pendiente->CellCssClass = "";
	if ($walger_actualizaciones->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// fecha
		$walger_actualizaciones->fecha->EditCustomAttributes = "";
		$walger_actualizaciones->fecha->EditValue = $walger_actualizaciones->fecha->CurrentValue;
		$walger_actualizaciones->fecha->EditValue = ew_FormatDateTime($walger_actualizaciones->fecha->EditValue, 7);
		$walger_actualizaciones->fecha->CssStyle = "";
		$walger_actualizaciones->fecha->CssClass = "";
		$walger_actualizaciones->fecha->ViewCustomAttributes = "";

		// pendiente
		$walger_actualizaciones->pendiente->EditCustomAttributes = "";
		$walger_actualizaciones->pendiente->EditValue = ew_HtmlEncode($walger_actualizaciones->pendiente->CurrentValue);
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_actualizaciones->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_actualizaciones;
	$sFilter = $walger_actualizaciones->SqlKeyFilter();
	$sFilter = str_replace("@fecha@", ew_AdjustSql(ew_UnFormatDateTime($walger_actualizaciones->fecha->CurrentValue,7)), $sFilter); // Replace key value
	$walger_actualizaciones->CurrentFilter = $sFilter;
	$sSql = $walger_actualizaciones->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE)
		return FALSE;
	if ($rs->EOF) {
		$EditRow = FALSE; // Update Failed
	} else {

		// Save old values
		$rsold =& $rs->fields;
		$rsnew = array();

		// Field fecha
		// Field pendiente

		$walger_actualizaciones->pendiente->SetDbValueDef($walger_actualizaciones->pendiente->CurrentValue, "");
		$rsnew['pendiente'] =& $walger_actualizaciones->pendiente->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_actualizaciones->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_actualizaciones->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_actualizaciones->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_actualizaciones->CancelMessage;
				$walger_actualizaciones->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_actualizaciones->Row_Updated($rsold, $rsnew);
	}
	$rs->Close();
	return $EditRow;
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
