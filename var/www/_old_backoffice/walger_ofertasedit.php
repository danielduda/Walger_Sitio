<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_ofertas', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_ofertasinfo.php" ?>
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
$walger_ofertas->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_ofertas->Export; // Get export parameter, used in header
$sExportFile = $walger_ofertas->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["idOferta"] <> "") {
	$walger_ofertas->idOferta->setQueryStringValue($_GET["idOferta"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_ofertas->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_ofertas->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_ofertas->idOferta->CurrentValue == "") Page_Terminate($walger_ofertas->getReturnUrl()); // Invalid key, exit
switch ($walger_ofertas->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_ofertas->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_ofertas->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_ofertas->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_ofertas->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_oferta"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Oferta"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_activo"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Activo ?"))
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
<p><span class="phpmaker">Editar : Ofertas<br><br><a href="<?php echo $walger_ofertas->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_ofertasedit" id="fwalger_ofertasedit" action="walger_ofertasedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">id Oferta</td>
		<td<?php echo $walger_ofertas->idOferta->CellAttributes() ?>><span id="cb_x_idOferta">
<div<?php echo $walger_ofertas->idOferta->ViewAttributes() ?>><?php echo $walger_ofertas->idOferta->EditValue ?></div>
<input type="hidden" name="x_idOferta" id="x_idOferta" value="<?php echo ew_HtmlEncode($walger_ofertas->idOferta->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Oferta<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_ofertas->oferta->CellAttributes() ?>><span id="cb_x_oferta">
<input type="text" name="x_oferta" id="x_oferta" title="" size="30" maxlength="100" value="<?php echo $walger_ofertas->oferta->EditValue ?>"<?php echo $walger_ofertas->oferta->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Activo ?<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_ofertas->activo->CellAttributes() ?>><span id="cb_x_activo">
<select id="x_activo" name="x_activo"<?php echo $walger_ofertas->activo->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_ofertas->activo->EditValue)) {
	$arwrk = $walger_ofertas->activo->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_ofertas->activo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
			}
}
?>
</select>
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
	global $objForm, $walger_ofertas;
	$walger_ofertas->idOferta->setFormValue($objForm->GetValue("x_idOferta"));
	$walger_ofertas->oferta->setFormValue($objForm->GetValue("x_oferta"));
	$walger_ofertas->activo->setFormValue($objForm->GetValue("x_activo"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_ofertas;
	$walger_ofertas->idOferta->CurrentValue = $walger_ofertas->idOferta->FormValue;
	$walger_ofertas->oferta->CurrentValue = $walger_ofertas->oferta->FormValue;
	$walger_ofertas->activo->CurrentValue = $walger_ofertas->activo->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_ofertas;
	$sFilter = $walger_ofertas->SqlKeyFilter();
	if (!is_numeric($walger_ofertas->idOferta->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idOferta@", ew_AdjustSql($walger_ofertas->idOferta->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_ofertas->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_ofertas->CurrentFilter = $sFilter;
	$sSql = $walger_ofertas->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_ofertas->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_ofertas;
	$walger_ofertas->idOferta->setDbValue($rs->fields('idOferta'));
	$walger_ofertas->oferta->setDbValue($rs->fields('oferta'));
	$walger_ofertas->activo->setDbValue($rs->fields('activo'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_ofertas;

	// Call Row Rendering event
	$walger_ofertas->Row_Rendering();

	// Common render codes for all row types
	// idOferta

	$walger_ofertas->idOferta->CellCssStyle = "";
	$walger_ofertas->idOferta->CellCssClass = "";

	// oferta
	$walger_ofertas->oferta->CellCssStyle = "";
	$walger_ofertas->oferta->CellCssClass = "";

	// activo
	$walger_ofertas->activo->CellCssStyle = "";
	$walger_ofertas->activo->CellCssClass = "";
	if ($walger_ofertas->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// idOferta
		$walger_ofertas->idOferta->EditCustomAttributes = "";
		$walger_ofertas->idOferta->EditValue = $walger_ofertas->idOferta->CurrentValue;
		$walger_ofertas->idOferta->CssStyle = "";
		$walger_ofertas->idOferta->CssClass = "";
		$walger_ofertas->idOferta->ViewCustomAttributes = "";

		// oferta
		$walger_ofertas->oferta->EditCustomAttributes = "";
		$walger_ofertas->oferta->EditValue = ew_HtmlEncode($walger_ofertas->oferta->CurrentValue);

		// activo
		$walger_ofertas->activo->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("S", "Si");
		$arwrk[] = array("N", "No");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_ofertas->activo->EditValue = $arwrk;
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_ofertas->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_ofertas;
	$sFilter = $walger_ofertas->SqlKeyFilter();
	if (!is_numeric($walger_ofertas->idOferta->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@idOferta@", ew_AdjustSql($walger_ofertas->idOferta->CurrentValue), $sFilter); // Replace key value
	$walger_ofertas->CurrentFilter = $sFilter;
	$sSql = $walger_ofertas->SQL();
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

		// Field idOferta
		// Field oferta

		$walger_ofertas->oferta->SetDbValueDef($walger_ofertas->oferta->CurrentValue, "");
		$rsnew['oferta'] =& $walger_ofertas->oferta->DbValue;

		// Field activo
		$walger_ofertas->activo->SetDbValueDef($walger_ofertas->activo->CurrentValue, "");
		$rsnew['activo'] =& $walger_ofertas->activo->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_ofertas->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_ofertas->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_ofertas->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_ofertas->CancelMessage;
				$walger_ofertas->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_ofertas->Row_Updated($rsold, $rsnew);
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
