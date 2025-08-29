<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
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

// Get action
$walger_actualizaciones->CurrentAction = @$_POST["a_search"];
switch ($walger_actualizaciones->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("walger_actualizacioneslist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$walger_actualizaciones->RowType = EW_ROWTYPE_SEARCH;
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "search"; // Page id

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
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Buscar : Actualizaciones<br><br><a href="walger_actualizacioneslist.php">Lista</a></span></p>
<form name="fwalger_actualizacionessearch" id="fwalger_actualizacionessearch" action="walger_actualizacionessrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Fecha</td>
		<td<?php echo $walger_actualizaciones->fecha->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_fecha" id="z_fecha" value="="></span></td>
		<td<?php echo $walger_actualizaciones->fecha->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_fecha" id="x_fecha" title="" value="<?php echo $walger_actualizaciones->fecha->EditValue ?>"<?php echo $walger_actualizaciones->fecha->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Pendiente ?</td>
		<td<?php echo $walger_actualizaciones->pendiente->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_pendiente" id="z_pendiente"><option value="="<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_actualizaciones->pendiente->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_pendiente" id="x_pendiente" title="" size="30" maxlength="1" value="<?php echo $walger_actualizaciones->pendiente->EditValue ?>"<?php echo $walger_actualizaciones->pendiente->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="Action" id="Action" value="  Buscar  ">
<input type="button" name="Reset" id="Reset" value="  Vaciar  " onclick="ew_ClearForm(this.form);">
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

// Build advanced search
function BuildAdvancedSearch() {
	global $walger_actualizaciones;
	$sSrchUrl = "";

	// Field fecha
	BuildSearchUrl($sSrchUrl, $walger_actualizaciones->fecha, ew_UnFormatDateTime(@$_POST["x_fecha"],7), @$_POST["z_fecha"], @$_POST["v_fecha"], ew_UnFormatDateTime(@$_POST["y_fecha"],7), @$_POST["w_fecha"]);

	// Field pendiente
	BuildSearchUrl($sSrchUrl, $walger_actualizaciones->pendiente, @$_POST["x_pendiente"], @$_POST["z_pendiente"], @$_POST["v_pendiente"], @$_POST["y_pendiente"], @$_POST["w_pendiente"]);
	return $sSrchUrl;
}

// Function to build search URL
function BuildSearchUrl(&$Url, &$Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2) {
	$sWrk = "";
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$FldOpr = strtoupper(trim($FldOpr));
	if ($FldOpr == "BETWEEN") {
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType == EW_DATATYPE_NUMBER && is_numeric($FldVal) && is_numeric($FldVal2));
		if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
			$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
				"&y_" . $FldParm . "=" . urlencode($FldVal2) .
				"&z_" . $FldParm . "=" . urlencode($FldOpr);
		}
	} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL") {
		$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
			"&z_" . $FldParm . "=" . urlencode($FldOpr);
	} else {
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType = EW_DATATYPE_NUMBER && is_numeric($FldVal));
		if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $Fld->FldDataType)) {
			$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
				"&z_" . $FldParm . "=" . urlencode($FldOpr);
		}
		$IsValidValue = ($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType = EW_DATATYPE_NUMBER && is_numeric($FldVal2));
		if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $Fld->FldDataType)) {
			if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
			$sWrk .= "&y_" . $FldParm . "=" . urlencode($FldVal2) .
				"&w_" . $FldParm . "=" . urlencode($FldOpr2);
		}
	}
	if ($sWrk <> "") {
		if ($Url <> "") $Url .= "&";
		$Url .= $sWrk;
	}
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_actualizaciones;

	// Call Row Rendering event
	$walger_actualizaciones->Row_Rendering();

	// Common render codes for all row types
	if ($walger_actualizaciones->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// fecha
		$walger_actualizaciones->fecha->EditCustomAttributes = "";
		$walger_actualizaciones->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_actualizaciones->fecha->AdvancedSearch->SearchValue, 7));

		// pendiente
		$walger_actualizaciones->pendiente->EditCustomAttributes = "";
		$walger_actualizaciones->pendiente->EditValue = ew_HtmlEncode($walger_actualizaciones->pendiente->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$walger_actualizaciones->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_actualizaciones;
	$walger_actualizaciones->fecha->AdvancedSearch->SearchValue = $walger_actualizaciones->getAdvancedSearch("x_fecha");
	$walger_actualizaciones->pendiente->AdvancedSearch->SearchValue = $walger_actualizaciones->getAdvancedSearch("x_pendiente");
	$walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator = $walger_actualizaciones->getAdvancedSearch("z_pendiente");
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
