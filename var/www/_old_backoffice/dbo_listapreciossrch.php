<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_listaprecios', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_listapreciosinfo.php" ?>
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
$dbo_listaprecios->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_listaprecios->Export; // Get export parameter, used in header
$sExportFile = $dbo_listaprecios->TableVar; // Get export file, used in header
?>
<?php

// Get action
$dbo_listaprecios->CurrentAction = @$_POST["a_search"];
switch ($dbo_listaprecios->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("dbo_listaprecioslist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$dbo_listaprecios->RowType = EW_ROWTYPE_SEARCH;
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
		elm = fobj.elements["x" + infix + "_Regis_ListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - ID"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_CodigListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Código"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_RegrabaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Regraba ?"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_RegisListaMadre"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Lista Madre"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_VariacionListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Variación Lista Madre"))
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
<p><span class="phpmaker">Buscar : Listas de precios (ISIS)<br><br><a href="dbo_listaprecioslist.php">Lista</a></span></p>
<form name="fdbo_listapreciossearch" id="fdbo_listapreciossearch" action="dbo_listapreciossrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID</td>
		<td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Regis_ListaPrec" id="z_Regis_ListaPrec"><option value="="<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Regis_ListaPrec" id="x_Regis_ListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->Regis_ListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->Regis_ListaPrec->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Código</td>
		<td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodigListaPrec" id="z_CodigListaPrec"><option value="="<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CodigListaPrec" id="x_CodigListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->CodigListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->CodigListaPrec->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Descripción</td>
		<td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrListaPrec" id="z_DescrListaPrec"><option value="="<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrListaPrec" id="x_DescrListaPrec" title="" size="30" maxlength="30" value="<?php echo $dbo_listaprecios->DescrListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->DescrListaPrec->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Regraba ?</td>
		<td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_RegrabaPrec" id="z_RegrabaPrec"><option value="="<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_RegrabaPrec" id="x_RegrabaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->RegrabaPrec->EditValue ?>"<?php echo $dbo_listaprecios->RegrabaPrec->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Lista Madre</td>
		<td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_RegisListaMadre" id="z_RegisListaMadre"><option value="="<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_RegisListaMadre" id="x_RegisListaMadre" title="" size="30" value="<?php echo $dbo_listaprecios->RegisListaMadre->EditValue ?>"<?php echo $dbo_listaprecios->RegisListaMadre->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Variación Lista Madre</td>
		<td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_VariacionListaPrec" id="z_VariacionListaPrec"><option value="="<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_VariacionListaPrec" id="x_VariacionListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->VariacionListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->VariacionListaPrec->EditAttributes() ?>>
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
	global $dbo_listaprecios;
	$sSrchUrl = "";

	// Field Regis_ListaPrec
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->Regis_ListaPrec, @$_POST["x_Regis_ListaPrec"], @$_POST["z_Regis_ListaPrec"], @$_POST["v_Regis_ListaPrec"], @$_POST["y_Regis_ListaPrec"], @$_POST["w_Regis_ListaPrec"]);

	// Field CodigListaPrec
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->CodigListaPrec, @$_POST["x_CodigListaPrec"], @$_POST["z_CodigListaPrec"], @$_POST["v_CodigListaPrec"], @$_POST["y_CodigListaPrec"], @$_POST["w_CodigListaPrec"]);

	// Field DescrListaPrec
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->DescrListaPrec, @$_POST["x_DescrListaPrec"], @$_POST["z_DescrListaPrec"], @$_POST["v_DescrListaPrec"], @$_POST["y_DescrListaPrec"], @$_POST["w_DescrListaPrec"]);

	// Field RegrabaPrec
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->RegrabaPrec, @$_POST["x_RegrabaPrec"], @$_POST["z_RegrabaPrec"], @$_POST["v_RegrabaPrec"], @$_POST["y_RegrabaPrec"], @$_POST["w_RegrabaPrec"]);

	// Field RegisListaMadre
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->RegisListaMadre, @$_POST["x_RegisListaMadre"], @$_POST["z_RegisListaMadre"], @$_POST["v_RegisListaMadre"], @$_POST["y_RegisListaMadre"], @$_POST["w_RegisListaMadre"]);

	// Field VariacionListaPrec
	BuildSearchUrl($sSrchUrl, $dbo_listaprecios->VariacionListaPrec, @$_POST["x_VariacionListaPrec"], @$_POST["z_VariacionListaPrec"], @$_POST["v_VariacionListaPrec"], @$_POST["y_VariacionListaPrec"], @$_POST["w_VariacionListaPrec"]);
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
	global $conn, $Security, $dbo_listaprecios;

	// Call Row Rendering event
	$dbo_listaprecios->Row_Rendering();

	// Common render codes for all row types
	if ($dbo_listaprecios->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->Regis_ListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchValue);

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->CodigListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchValue);

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->DescrListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchValue);

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->RegrabaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchValue);

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->EditCustomAttributes = "";
		$dbo_listaprecios->RegisListaMadre->EditValue = ew_HtmlEncode($dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchValue);

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->VariacionListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$dbo_listaprecios->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_Regis_ListaPrec");
	$dbo_listaprecios->Regis_ListaPrec->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_Regis_ListaPrec");
	$dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_CodigListaPrec");
	$dbo_listaprecios->CodigListaPrec->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_CodigListaPrec");
	$dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_DescrListaPrec");
	$dbo_listaprecios->DescrListaPrec->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_DescrListaPrec");
	$dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_RegrabaPrec");
	$dbo_listaprecios->RegrabaPrec->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_RegrabaPrec");
	$dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_RegisListaMadre");
	$dbo_listaprecios->RegisListaMadre->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_RegisListaMadre");
	$dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchValue = $dbo_listaprecios->getAdvancedSearch("x_VariacionListaPrec");
	$dbo_listaprecios->VariacionListaPrec->AdvancedSearch->SearchOperator = $dbo_listaprecios->getAdvancedSearch("z_VariacionListaPrec");
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
