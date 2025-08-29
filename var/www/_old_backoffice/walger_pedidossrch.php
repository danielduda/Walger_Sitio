<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_pedidos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_pedidosinfo.php" ?>
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
$walger_pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_pedidos->Export; // Get export parameter, used in header
$sExportFile = $walger_pedidos->TableVar; // Get export file, used in header
?>
<?php

// Get action
$walger_pedidos->CurrentAction = @$_POST["a_search"];
switch ($walger_pedidos->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("walger_pedidoslist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$walger_pedidos->RowType = EW_ROWTYPE_SEARCH;
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
		elm = fobj.elements["x" + infix + "_idPedido"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - ID"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_fechaEstado"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Cambio de Estado"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_fechaFacturacion"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha de Facturación"))
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
<p><span class="phpmaker">Buscar : Pedidos<br><br><a href="walger_pedidoslist.php">Lista</a></span></p>
<form name="fwalger_pedidossearch" id="fwalger_pedidossearch" action="walger_pedidossrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID</td>
		<td<?php echo $walger_pedidos->idPedido->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_idPedido" id="z_idPedido"><option value="="<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_pedidos->idPedido->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $walger_pedidos->idPedido->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_idPedido" id="x_idPedido" title="" value="<?php echo $walger_pedidos->idPedido->EditValue ?>"<?php echo $walger_pedidos->idPedido->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Cliente</td>
		<td<?php echo $walger_pedidos->CodigoCli->CellAttributes() ?>><span class="ewSearchOpr">contiene<input type="hidden" name="z_CodigoCli" id="z_CodigoCli" value="LIKE"></span></td>
		<td<?php echo $walger_pedidos->CodigoCli->CellAttributes() ?>><span class="phpmaker">
<select id="x_CodigoCli" name="x_CodigoCli" onChange="ew_UpdateOpt(this.form.x_CodigoCli, ar_x_CodigoCli, this);"<?php echo $walger_pedidos->CodigoCli->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_pedidos->CodigoCli->EditValue)) {
	$arwrk = $walger_pedidos->CodigoCli->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_pedidos->CodigoCli->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
	<tr class="ewTableRow">
		<td class="ewTableHeader">Estado</td>
		<td<?php echo $walger_pedidos->estado->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_estado" id="z_estado"><option value="="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_pedidos->estado->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_pedidos->estado->CellAttributes() ?>><span class="phpmaker">
<select id="x_estado" name="x_estado"<?php echo $walger_pedidos->estado->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_pedidos->estado->EditValue)) {
	$arwrk = $walger_pedidos->estado->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_pedidos->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Fecha Cambio de Estado</td>
		<td<?php echo $walger_pedidos->fechaEstado->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_fechaEstado" id="z_fechaEstado" value="="></span></td>
		<td<?php echo $walger_pedidos->fechaEstado->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_fechaEstado" id="x_fechaEstado" title="" value="<?php echo $walger_pedidos->fechaEstado->EditValue ?>"<?php echo $walger_pedidos->fechaEstado->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Fecha de Facturación</td>
		<td<?php echo $walger_pedidos->fechaFacturacion->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_fechaFacturacion" id="z_fechaFacturacion" value="="></span></td>
		<td<?php echo $walger_pedidos->fechaFacturacion->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_fechaFacturacion" id="x_fechaFacturacion" title="" value="<?php echo $walger_pedidos->fechaFacturacion->EditValue ?>"<?php echo $walger_pedidos->fechaFacturacion->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Factura</td>
		<td<?php echo $walger_pedidos->factura->CellAttributes() ?>><span class="ewSearchOpr">contiene<input type="hidden" name="z_factura" id="z_factura" value="LIKE"></span></td>
		<td<?php echo $walger_pedidos->factura->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_factura" id="x_factura" title="" size="30" maxlength="20" value="<?php echo $walger_pedidos->factura->EditValue ?>"<?php echo $walger_pedidos->factura->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Comentario</td>
		<td<?php echo $walger_pedidos->comentario->CellAttributes() ?>><span class="ewSearchOpr">contiene<input type="hidden" name="z_comentario" id="z_comentario" value="LIKE"></span></td>
		<td<?php echo $walger_pedidos->comentario->CellAttributes() ?>><span class="phpmaker">
<textarea name="x_comentario" id="x_comentario" cols="35" rows="4"<?php echo $walger_pedidos->comentario->EditAttributes() ?>><?php echo $walger_pedidos->comentario->EditValue ?></textarea>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="Action" id="Action" value="  Buscar  ">
<input type="button" name="Reset" id="Reset" value="  Vaciar  " onclick="ew_ClearForm(this.form);">
</form>
<script language="JavaScript">
<!--
var f = document.fwalger_pedidossearch;
ew_UpdateOpt(f.x_CodigoCli, ar_x_CodigoCli, f.x_CodigoCli);

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
	global $walger_pedidos;
	$sSrchUrl = "";

	// Field idPedido
	BuildSearchUrl($sSrchUrl, $walger_pedidos->idPedido, @$_POST["x_idPedido"], @$_POST["z_idPedido"], @$_POST["v_idPedido"], @$_POST["y_idPedido"], @$_POST["w_idPedido"]);

	// Field CodigoCli
	BuildSearchUrl($sSrchUrl, $walger_pedidos->CodigoCli, @$_POST["x_CodigoCli"], @$_POST["z_CodigoCli"], @$_POST["v_CodigoCli"], @$_POST["y_CodigoCli"], @$_POST["w_CodigoCli"]);

	// Field estado
	BuildSearchUrl($sSrchUrl, $walger_pedidos->estado, @$_POST["x_estado"], @$_POST["z_estado"], @$_POST["v_estado"], @$_POST["y_estado"], @$_POST["w_estado"]);

	// Field fechaEstado
	BuildSearchUrl($sSrchUrl, $walger_pedidos->fechaEstado, ew_UnFormatDateTime(@$_POST["x_fechaEstado"],7), @$_POST["z_fechaEstado"], @$_POST["v_fechaEstado"], ew_UnFormatDateTime(@$_POST["y_fechaEstado"],7), @$_POST["w_fechaEstado"]);

	// Field fechaFacturacion
	BuildSearchUrl($sSrchUrl, $walger_pedidos->fechaFacturacion, ew_UnFormatDateTime(@$_POST["x_fechaFacturacion"],7), @$_POST["z_fechaFacturacion"], @$_POST["v_fechaFacturacion"], ew_UnFormatDateTime(@$_POST["y_fechaFacturacion"],7), @$_POST["w_fechaFacturacion"]);

	// Field factura
	BuildSearchUrl($sSrchUrl, $walger_pedidos->factura, @$_POST["x_factura"], @$_POST["z_factura"], @$_POST["v_factura"], @$_POST["y_factura"], @$_POST["w_factura"]);

	// Field comentario
	BuildSearchUrl($sSrchUrl, $walger_pedidos->comentario, @$_POST["x_comentario"], @$_POST["z_comentario"], @$_POST["v_comentario"], @$_POST["y_comentario"], @$_POST["w_comentario"]);
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
	global $conn, $Security, $walger_pedidos;

	// Call Row Rendering event
	$walger_pedidos->Row_Rendering();

	// Common render codes for all row types
	if ($walger_pedidos->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// idPedido
		$walger_pedidos->idPedido->EditCustomAttributes = "";
		$walger_pedidos->idPedido->EditValue = ew_HtmlEncode($walger_pedidos->idPedido->AdvancedSearch->SearchValue);

		// CodigoCli
		$walger_pedidos->CodigoCli->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente`";
		$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$walger_pedidos->CodigoCli->EditValue = $arwrk;

		// estado
		$walger_pedidos->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("N", "No confirmado");
		$arwrk[] = array("X", "Confirmado no entregado");
		$arwrk[] = array("E", "En preparación");
		$arwrk[] = array("P", "Pendiente de pago");
		$arwrk[] = array("F", "Facturado");
		$arwrk[] = array("C", "Cancelado");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_pedidos->estado->EditValue = $arwrk;

		// fechaEstado
		$walger_pedidos->fechaEstado->EditCustomAttributes = "";
		$walger_pedidos->fechaEstado->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_pedidos->fechaEstado->AdvancedSearch->SearchValue, 7));

		// fechaFacturacion
		$walger_pedidos->fechaFacturacion->EditCustomAttributes = "";
		$walger_pedidos->fechaFacturacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_pedidos->fechaFacturacion->AdvancedSearch->SearchValue, 7));

		// factura
		$walger_pedidos->factura->EditCustomAttributes = "";
		$walger_pedidos->factura->EditValue = ew_HtmlEncode($walger_pedidos->factura->AdvancedSearch->SearchValue);

		// comentario
		$walger_pedidos->comentario->EditCustomAttributes = "";
		$walger_pedidos->comentario->EditValue = ew_HtmlEncode($walger_pedidos->comentario->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$walger_pedidos->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_pedidos;
	$walger_pedidos->idPedido->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_idPedido");
	$walger_pedidos->idPedido->AdvancedSearch->SearchOperator = $walger_pedidos->getAdvancedSearch("z_idPedido");
	$walger_pedidos->CodigoCli->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_CodigoCli");
	$walger_pedidos->estado->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_estado");
	$walger_pedidos->estado->AdvancedSearch->SearchOperator = $walger_pedidos->getAdvancedSearch("z_estado");
	$walger_pedidos->fechaEstado->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_fechaEstado");
	$walger_pedidos->fechaFacturacion->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_fechaFacturacion");
	$walger_pedidos->factura->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_factura");
	$walger_pedidos->comentario->AdvancedSearch->SearchValue = $walger_pedidos->getAdvancedSearch("x_comentario");
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
