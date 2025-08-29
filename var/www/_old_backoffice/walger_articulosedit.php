<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_articulos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_articulosinfo.php" ?>
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
$walger_articulos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_articulos->Export; // Get export parameter, used in header
$sExportFile = $walger_articulos->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["CodInternoArti"] <> "") {
	$walger_articulos->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_articulos->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_articulos->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_articulos->CodInternoArti->CurrentValue == "") Page_Terminate($walger_articulos->getReturnUrl()); // Invalid key, exit
switch ($walger_articulos->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_articulos->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_articulos->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_articulos->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_articulos->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_CodInternoArti"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Artículo"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Oferta"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Oferta ?"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Novedad"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Novedad ?"))
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
<p><span class="phpmaker">Editar : Artículos<br><br><a href="<?php echo $walger_articulos->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_articulosedit" id="fwalger_articulosedit" action="walger_articulosedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Artículo<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>><span id="cb_x_CodInternoArti">
<div<?php echo $walger_articulos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_articulos->CodInternoArti->EditValue ?></div>
<input type="hidden" name="x_CodInternoArti" id="x_CodInternoArti" value="<?php echo ew_HtmlEncode($walger_articulos->CodInternoArti->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Oferta ?<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>><span id="cb_x_Oferta">
<select id="x_Oferta" name="x_Oferta"<?php echo $walger_articulos->Oferta->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_articulos->Oferta->EditValue)) {
	$arwrk = $walger_articulos->Oferta->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_articulos->Oferta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
	<tr class="ewTableRow">
		<td class="ewTableHeader">Novedad ?<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>><span id="cb_x_Novedad">
<select id="x_Novedad" name="x_Novedad"<?php echo $walger_articulos->Novedad->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_articulos->Novedad->EditValue)) {
	$arwrk = $walger_articulos->Novedad->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_articulos->Novedad->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
<script language="JavaScript">
<!--
var f = document.fwalger_articulosedit;
ew_UpdateOpt(f.x_CodInternoArti, ar_x_CodInternoArti, f.x_CodInternoArti);

//-->
</script>
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
	global $objForm, $walger_articulos;
	$walger_articulos->CodInternoArti->setFormValue($objForm->GetValue("x_CodInternoArti"));
	$walger_articulos->Oferta->setFormValue($objForm->GetValue("x_Oferta"));
	$walger_articulos->Novedad->setFormValue($objForm->GetValue("x_Novedad"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_articulos;
	$walger_articulos->CodInternoArti->CurrentValue = $walger_articulos->CodInternoArti->FormValue;
	$walger_articulos->Oferta->CurrentValue = $walger_articulos->Oferta->FormValue;
	$walger_articulos->Novedad->CurrentValue = $walger_articulos->Novedad->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_articulos;
	$sFilter = $walger_articulos->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_articulos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_articulos->CurrentFilter = $sFilter;
	$sSql = $walger_articulos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_articulos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_articulos;
	$walger_articulos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$walger_articulos->Oferta->setDbValue($rs->fields('Oferta'));
	$walger_articulos->Novedad->setDbValue($rs->fields('Novedad'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_articulos;

	// Call Row Rendering event
	$walger_articulos->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$walger_articulos->CodInternoArti->CellCssStyle = "";
	$walger_articulos->CodInternoArti->CellCssClass = "";

	// Oferta
	$walger_articulos->Oferta->CellCssStyle = "";
	$walger_articulos->Oferta->CellCssClass = "";

	// Novedad
	$walger_articulos->Novedad->CellCssStyle = "";
	$walger_articulos->Novedad->CellCssClass = "";
	if ($walger_articulos->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// CodInternoArti
		$walger_articulos->CodInternoArti->EditCustomAttributes = "";
		if (!is_null($walger_articulos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_articulos->CodInternoArti->EditValue = $rswrk->fields('CodInternoArti');
					$walger_articulos->CodInternoArti->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_articulos->CodInternoArti->EditValue = $walger_articulos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_articulos->CodInternoArti->EditValue = NULL;
		}
		$walger_articulos->CodInternoArti->CssStyle = "";
		$walger_articulos->CodInternoArti->CssClass = "";
		$walger_articulos->CodInternoArti->ViewCustomAttributes = "";

		// Oferta
		$walger_articulos->Oferta->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("S", "Si");
		$arwrk[] = array("N", "No");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_articulos->Oferta->EditValue = $arwrk;

		// Novedad
		$walger_articulos->Novedad->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("S", "Si");
		$arwrk[] = array("N", "No");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_articulos->Novedad->EditValue = $arwrk;
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_articulos->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_articulos;
	$sFilter = $walger_articulos->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue), $sFilter); // Replace key value
	$walger_articulos->CurrentFilter = $sFilter;
	$sSql = $walger_articulos->SQL();
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

		// Field CodInternoArti
		// Field Oferta

		$walger_articulos->Oferta->SetDbValueDef($walger_articulos->Oferta->CurrentValue, "");
		$rsnew['Oferta'] =& $walger_articulos->Oferta->DbValue;

		// Field Novedad
		$walger_articulos->Novedad->SetDbValueDef($walger_articulos->Novedad->CurrentValue, "");
		$rsnew['Novedad'] =& $walger_articulos->Novedad->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_articulos->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_articulos->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_articulos->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_articulos->CancelMessage;
				$walger_articulos->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_articulos->Row_Updated($rsold, $rsnew);
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
