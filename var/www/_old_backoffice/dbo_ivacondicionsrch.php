<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
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

// Get action
$dbo_ivacondicion->CurrentAction = @$_POST["a_search"];
switch ($dbo_ivacondicion->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("dbo_ivacondicionlist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$dbo_ivacondicion->RowType = EW_ROWTYPE_SEARCH;
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
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Buscar : Condiciones IVA (ISIS)<br><br><a href="dbo_ivacondicionlist.php">Lista</a></span></p>
<form name="fdbo_ivacondicionsearch" id="fdbo_ivacondicionsearch" action="dbo_ivacondicionsrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID</td>
		<td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Regis_IvaC" id="z_Regis_IvaC"><option value="="<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Regis_IvaC" id="x_Regis_IvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->Regis_IvaC->EditValue ?>"<?php echo $dbo_ivacondicion->Regis_IvaC->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Descripción</td>
		<td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrIvaC" id="z_DescrIvaC"><option value="="<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrIvaC" id="x_DescrIvaC" title="" size="30" maxlength="20" value="<?php echo $dbo_ivacondicion->DescrIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->DescrIvaC->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Calcula Iva ?</td>
		<td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CalculaIvaC" id="z_CalculaIvaC"><option value="="<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CalculaIvaC" id="x_CalculaIvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->CalculaIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->CalculaIvaC->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Discrimina Iva ?</td>
		<td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DiscriminaIvaC" id="z_DiscriminaIvaC"><option value="="<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DiscriminaIvaC" id="x_DiscriminaIvaC" title="" size="30" value="<?php echo $dbo_ivacondicion->DiscriminaIvaC->EditValue ?>"<?php echo $dbo_ivacondicion->DiscriminaIvaC->EditAttributes() ?>>
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
	global $dbo_ivacondicion;
	$sSrchUrl = "";

	// Field Regis_IvaC
	BuildSearchUrl($sSrchUrl, $dbo_ivacondicion->Regis_IvaC, @$_POST["x_Regis_IvaC"], @$_POST["z_Regis_IvaC"], @$_POST["v_Regis_IvaC"], @$_POST["y_Regis_IvaC"], @$_POST["w_Regis_IvaC"]);

	// Field DescrIvaC
	BuildSearchUrl($sSrchUrl, $dbo_ivacondicion->DescrIvaC, @$_POST["x_DescrIvaC"], @$_POST["z_DescrIvaC"], @$_POST["v_DescrIvaC"], @$_POST["y_DescrIvaC"], @$_POST["w_DescrIvaC"]);

	// Field CalculaIvaC
	BuildSearchUrl($sSrchUrl, $dbo_ivacondicion->CalculaIvaC, @$_POST["x_CalculaIvaC"], @$_POST["z_CalculaIvaC"], @$_POST["v_CalculaIvaC"], @$_POST["y_CalculaIvaC"], @$_POST["w_CalculaIvaC"]);

	// Field DiscriminaIvaC
	BuildSearchUrl($sSrchUrl, $dbo_ivacondicion->DiscriminaIvaC, @$_POST["x_DiscriminaIvaC"], @$_POST["z_DiscriminaIvaC"], @$_POST["v_DiscriminaIvaC"], @$_POST["y_DiscriminaIvaC"], @$_POST["w_DiscriminaIvaC"]);
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
	global $conn, $Security, $dbo_ivacondicion;

	// Call Row Rendering event
	$dbo_ivacondicion->Row_Rendering();

	// Common render codes for all row types
	if ($dbo_ivacondicion->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->Regis_IvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchValue);

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->DescrIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchValue);

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->CalculaIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchValue);

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->EditCustomAttributes = "";
		$dbo_ivacondicion->DiscriminaIvaC->EditValue = ew_HtmlEncode($dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$dbo_ivacondicion->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchValue = $dbo_ivacondicion->getAdvancedSearch("x_Regis_IvaC");
	$dbo_ivacondicion->Regis_IvaC->AdvancedSearch->SearchOperator = $dbo_ivacondicion->getAdvancedSearch("z_Regis_IvaC");
	$dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchValue = $dbo_ivacondicion->getAdvancedSearch("x_DescrIvaC");
	$dbo_ivacondicion->DescrIvaC->AdvancedSearch->SearchOperator = $dbo_ivacondicion->getAdvancedSearch("z_DescrIvaC");
	$dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchValue = $dbo_ivacondicion->getAdvancedSearch("x_CalculaIvaC");
	$dbo_ivacondicion->CalculaIvaC->AdvancedSearch->SearchOperator = $dbo_ivacondicion->getAdvancedSearch("z_CalculaIvaC");
	$dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchValue = $dbo_ivacondicion->getAdvancedSearch("x_DiscriminaIvaC");
	$dbo_ivacondicion->DiscriminaIvaC->AdvancedSearch->SearchOperator = $dbo_ivacondicion->getAdvancedSearch("z_DiscriminaIvaC");
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
