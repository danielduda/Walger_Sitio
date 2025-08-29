<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
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

// Get action
$walger_articulos->CurrentAction = @$_POST["a_search"];
switch ($walger_articulos->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("walger_articuloslist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$walger_articulos->RowType = EW_ROWTYPE_SEARCH;
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
<p><span class="phpmaker">Buscar : Artículos<br><br><a href="walger_articuloslist.php">Lista</a></span></p>
<form name="fwalger_articulossearch" id="fwalger_articulossearch" action="walger_articulossrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Artículo</td>
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodInternoArti" id="z_CodInternoArti"><option value="="<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>><span class="phpmaker">
<select id="x_CodInternoArti" name="x_CodInternoArti" onChange="ew_UpdateOpt(this.form.x_CodInternoArti, ar_x_CodInternoArti, this);"<?php echo $walger_articulos->CodInternoArti->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_articulos->CodInternoArti->EditValue)) {
	$arwrk = $walger_articulos->CodInternoArti->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_articulos->CodInternoArti->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
			}
}
?>
</select>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Oferta ?</td>
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Oferta" id="z_Oferta"><option value="="<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_articulos->Oferta->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>><span class="phpmaker">
<select id="x_Oferta" name="x_Oferta"<?php echo $walger_articulos->Oferta->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_articulos->Oferta->EditValue)) {
	$arwrk = $walger_articulos->Oferta->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_articulos->Oferta->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Novedad ?</td>
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Novedad" id="z_Novedad"><option value="="<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_articulos->Novedad->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>><span class="phpmaker">
<select id="x_Novedad" name="x_Novedad"<?php echo $walger_articulos->Novedad->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_articulos->Novedad->EditValue)) {
	$arwrk = $walger_articulos->Novedad->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_articulos->Novedad->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
<input type="submit" name="Action" id="Action" value="  Buscar  ">
<input type="button" name="Reset" id="Reset" value="  Vaciar  " onclick="ew_ClearForm(this.form);">
</form>
<script language="JavaScript">
<!--
var f = document.fwalger_articulossearch;
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

// Build advanced search
function BuildAdvancedSearch() {
	global $walger_articulos;
	$sSrchUrl = "";

	// Field CodInternoArti
	BuildSearchUrl($sSrchUrl, $walger_articulos->CodInternoArti, @$_POST["x_CodInternoArti"], @$_POST["z_CodInternoArti"], @$_POST["v_CodInternoArti"], @$_POST["y_CodInternoArti"], @$_POST["w_CodInternoArti"]);

	// Field Oferta
	BuildSearchUrl($sSrchUrl, $walger_articulos->Oferta, @$_POST["x_Oferta"], @$_POST["z_Oferta"], @$_POST["v_Oferta"], @$_POST["y_Oferta"], @$_POST["w_Oferta"]);

	// Field Novedad
	BuildSearchUrl($sSrchUrl, $walger_articulos->Novedad, @$_POST["x_Novedad"], @$_POST["z_Novedad"], @$_POST["v_Novedad"], @$_POST["y_Novedad"], @$_POST["w_Novedad"]);
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
	global $conn, $Security, $walger_articulos;

	// Call Row Rendering event
	$walger_articulos->Row_Rendering();

	// Common render codes for all row types
	if ($walger_articulos->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// CodInternoArti
		$walger_articulos->CodInternoArti->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `CodInternoArti`, `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo`";
		$sSqlWrk .= " ORDER BY `CodInternoArti` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$walger_articulos->CodInternoArti->EditValue = $arwrk;

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
	}

	// Call Row Rendered event
	$walger_articulos->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_articulos;
	$walger_articulos->CodInternoArti->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_CodInternoArti");
	$walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_CodInternoArti");
	$walger_articulos->Oferta->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_Oferta");
	$walger_articulos->Oferta->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_Oferta");
	$walger_articulos->Novedad->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_Novedad");
	$walger_articulos->Novedad->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_Novedad");
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
