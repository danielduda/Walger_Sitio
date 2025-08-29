<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_cliente', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_clienteinfo.php" ?>
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
$dbo_cliente->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_cliente->Export; // Get export parameter, used in header
$sExportFile = $dbo_cliente->TableVar; // Get export file, used in header
?>
<?php

// Get action
$dbo_cliente->CurrentAction = @$_POST["a_search"];
switch ($dbo_cliente->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("dbo_clientelist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$dbo_cliente->RowType = EW_ROWTYPE_SEARCH;
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
<p><span class="phpmaker">Buscar : Clientes (ISIS)<br><br><a href="dbo_clientelist.php">Lista</a></span></p>
<form name="fdbo_clientesearch" id="fdbo_clientesearch" action="dbo_clientesrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Código</td>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodigoCli" id="z_CodigoCli"><option value="="<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CodigoCli" id="x_CodigoCli" title="" size="30" maxlength="10" value="<?php echo $dbo_cliente->CodigoCli->EditValue ?>"<?php echo $dbo_cliente->CodigoCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Razón Social</td>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_RazonSocialCli" id="z_RazonSocialCli"><option value="="<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_RazonSocialCli" id="x_RazonSocialCli" title="" size="30" maxlength="60" value="<?php echo $dbo_cliente->RazonSocialCli->EditValue ?>"<?php echo $dbo_cliente->RazonSocialCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">CUIT</td>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CuitCli" id="z_CuitCli"><option value="="<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->CuitCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CuitCli" id="x_CuitCli" title="" size="30" maxlength="13" value="<?php echo $dbo_cliente->CuitCli->EditValue ?>"<?php echo $dbo_cliente->CuitCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Ingresos Brutos</td>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_IngBrutosCli" id="z_IngBrutosCli"><option value="="<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_IngBrutosCli" id="x_IngBrutosCli" title="" size="30" maxlength="18" value="<?php echo $dbo_cliente->IngBrutosCli->EditValue ?>"<?php echo $dbo_cliente->IngBrutosCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Condición IVA</td>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Regis_IvaC" id="z_Regis_IvaC"><option value="="<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>><span class="phpmaker">
<select id="x_Regis_IvaC" name="x_Regis_IvaC" onChange="ew_UpdateOpt(this.form.x_Regis_IvaC, ar_x_Regis_IvaC, this);"<?php echo $dbo_cliente->Regis_IvaC->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($dbo_cliente->Regis_IvaC->EditValue)) {
	$arwrk = $dbo_cliente->Regis_IvaC->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($dbo_cliente->Regis_IvaC->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Lista de Precios</td>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Regis_ListaPrec" id="z_Regis_ListaPrec"><option value="="<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>><span class="phpmaker">
<select id="x_Regis_ListaPrec" name="x_Regis_ListaPrec" onChange="ew_UpdateOpt(this.form.x_Regis_ListaPrec, ar_x_Regis_ListaPrec, this);"<?php echo $dbo_cliente->Regis_ListaPrec->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($dbo_cliente->Regis_ListaPrec->EditValue)) {
	$arwrk = $dbo_cliente->Regis_ListaPrec->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">EMail</td>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_emailCli" id="z_emailCli"><option value="="<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->emailCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_emailCli" id="x_emailCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->emailCli->EditValue ?>"<?php echo $dbo_cliente->emailCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Razón Social Flete</td>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_RazonSocialFlete" id="z_RazonSocialFlete"><option value="="<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_RazonSocialFlete" id="x_RazonSocialFlete" title="" size="30" maxlength="50" value="<?php echo $dbo_cliente->RazonSocialFlete->EditValue ?>"<?php echo $dbo_cliente->RazonSocialFlete->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Dirección</td>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Direccion" id="z_Direccion"><option value="="<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->Direccion->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Direccion" id="x_Direccion" title="" size="30" maxlength="90" value="<?php echo $dbo_cliente->Direccion->EditValue ?>"<?php echo $dbo_cliente->Direccion->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Barrio</td>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_BarrioCli" id="z_BarrioCli"><option value="="<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_BarrioCli" id="x_BarrioCli" title="" size="30" maxlength="30" value="<?php echo $dbo_cliente->BarrioCli->EditValue ?>"<?php echo $dbo_cliente->BarrioCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Localidad</td>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_LocalidadCli" id="z_LocalidadCli"><option value="="<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_LocalidadCli" id="x_LocalidadCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->LocalidadCli->EditValue ?>"<?php echo $dbo_cliente->LocalidadCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Provincia</td>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrProvincia" id="z_DescrProvincia"><option value="="<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrProvincia" id="x_DescrProvincia" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->DescrProvincia->EditValue ?>"<?php echo $dbo_cliente->DescrProvincia->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">CP</td>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodigoPostalCli" id="z_CodigoPostalCli"><option value="="<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CodigoPostalCli" id="x_CodigoPostalCli" title="" size="30" maxlength="10" value="<?php echo $dbo_cliente->CodigoPostalCli->EditValue ?>"<?php echo $dbo_cliente->CodigoPostalCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">País</td>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrPais" id="z_DescrPais"><option value="="<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->DescrPais->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrPais" id="x_DescrPais" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->DescrPais->EditValue ?>"<?php echo $dbo_cliente->DescrPais->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Teléfono</td>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Telefono" id="z_Telefono"><option value="="<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->Telefono->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Telefono" id="x_Telefono" title="" size="30" maxlength="90" value="<?php echo $dbo_cliente->Telefono->EditValue ?>"<?php echo $dbo_cliente->Telefono->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Fax</td>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_FaxCli" id="z_FaxCli"><option value="="<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->FaxCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_FaxCli" id="x_FaxCli" title="" size="30" maxlength="30" value="<?php echo $dbo_cliente->FaxCli->EditValue ?>"<?php echo $dbo_cliente->FaxCli->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Pagina Web</td>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_PaginaWebCli" id="z_PaginaWebCli"><option value="="<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_PaginaWebCli" id="x_PaginaWebCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->PaginaWebCli->EditValue ?>"<?php echo $dbo_cliente->PaginaWebCli->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="Action" id="Action" value="  Buscar  ">
<input type="button" name="Reset" id="Reset" value="  Vaciar  " onclick="ew_ClearForm(this.form);">
</form>
<script language="JavaScript">
<!--
var f = document.fdbo_clientesearch;
ew_UpdateOpt(f.x_Regis_IvaC, ar_x_Regis_IvaC, f.x_Regis_IvaC);
ew_UpdateOpt(f.x_Regis_ListaPrec, ar_x_Regis_ListaPrec, f.x_Regis_ListaPrec);

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
	global $dbo_cliente;
	$sSrchUrl = "";

	// Field CodigoCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->CodigoCli, @$_POST["x_CodigoCli"], @$_POST["z_CodigoCli"], @$_POST["v_CodigoCli"], @$_POST["y_CodigoCli"], @$_POST["w_CodigoCli"]);

	// Field RazonSocialCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->RazonSocialCli, @$_POST["x_RazonSocialCli"], @$_POST["z_RazonSocialCli"], @$_POST["v_RazonSocialCli"], @$_POST["y_RazonSocialCli"], @$_POST["w_RazonSocialCli"]);

	// Field CuitCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->CuitCli, @$_POST["x_CuitCli"], @$_POST["z_CuitCli"], @$_POST["v_CuitCli"], @$_POST["y_CuitCli"], @$_POST["w_CuitCli"]);

	// Field IngBrutosCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->IngBrutosCli, @$_POST["x_IngBrutosCli"], @$_POST["z_IngBrutosCli"], @$_POST["v_IngBrutosCli"], @$_POST["y_IngBrutosCli"], @$_POST["w_IngBrutosCli"]);

	// Field Regis_IvaC
	BuildSearchUrl($sSrchUrl, $dbo_cliente->Regis_IvaC, @$_POST["x_Regis_IvaC"], @$_POST["z_Regis_IvaC"], @$_POST["v_Regis_IvaC"], @$_POST["y_Regis_IvaC"], @$_POST["w_Regis_IvaC"]);

	// Field Regis_ListaPrec
	BuildSearchUrl($sSrchUrl, $dbo_cliente->Regis_ListaPrec, @$_POST["x_Regis_ListaPrec"], @$_POST["z_Regis_ListaPrec"], @$_POST["v_Regis_ListaPrec"], @$_POST["y_Regis_ListaPrec"], @$_POST["w_Regis_ListaPrec"]);

	// Field emailCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->emailCli, @$_POST["x_emailCli"], @$_POST["z_emailCli"], @$_POST["v_emailCli"], @$_POST["y_emailCli"], @$_POST["w_emailCli"]);

	// Field RazonSocialFlete
	BuildSearchUrl($sSrchUrl, $dbo_cliente->RazonSocialFlete, @$_POST["x_RazonSocialFlete"], @$_POST["z_RazonSocialFlete"], @$_POST["v_RazonSocialFlete"], @$_POST["y_RazonSocialFlete"], @$_POST["w_RazonSocialFlete"]);

	// Field Direccion
	BuildSearchUrl($sSrchUrl, $dbo_cliente->Direccion, @$_POST["x_Direccion"], @$_POST["z_Direccion"], @$_POST["v_Direccion"], @$_POST["y_Direccion"], @$_POST["w_Direccion"]);

	// Field BarrioCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->BarrioCli, @$_POST["x_BarrioCli"], @$_POST["z_BarrioCli"], @$_POST["v_BarrioCli"], @$_POST["y_BarrioCli"], @$_POST["w_BarrioCli"]);

	// Field LocalidadCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->LocalidadCli, @$_POST["x_LocalidadCli"], @$_POST["z_LocalidadCli"], @$_POST["v_LocalidadCli"], @$_POST["y_LocalidadCli"], @$_POST["w_LocalidadCli"]);

	// Field DescrProvincia
	BuildSearchUrl($sSrchUrl, $dbo_cliente->DescrProvincia, @$_POST["x_DescrProvincia"], @$_POST["z_DescrProvincia"], @$_POST["v_DescrProvincia"], @$_POST["y_DescrProvincia"], @$_POST["w_DescrProvincia"]);

	// Field CodigoPostalCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->CodigoPostalCli, @$_POST["x_CodigoPostalCli"], @$_POST["z_CodigoPostalCli"], @$_POST["v_CodigoPostalCli"], @$_POST["y_CodigoPostalCli"], @$_POST["w_CodigoPostalCli"]);

	// Field DescrPais
	BuildSearchUrl($sSrchUrl, $dbo_cliente->DescrPais, @$_POST["x_DescrPais"], @$_POST["z_DescrPais"], @$_POST["v_DescrPais"], @$_POST["y_DescrPais"], @$_POST["w_DescrPais"]);

	// Field Telefono
	BuildSearchUrl($sSrchUrl, $dbo_cliente->Telefono, @$_POST["x_Telefono"], @$_POST["z_Telefono"], @$_POST["v_Telefono"], @$_POST["y_Telefono"], @$_POST["w_Telefono"]);

	// Field FaxCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->FaxCli, @$_POST["x_FaxCli"], @$_POST["z_FaxCli"], @$_POST["v_FaxCli"], @$_POST["y_FaxCli"], @$_POST["w_FaxCli"]);

	// Field PaginaWebCli
	BuildSearchUrl($sSrchUrl, $dbo_cliente->PaginaWebCli, @$_POST["x_PaginaWebCli"], @$_POST["z_PaginaWebCli"], @$_POST["v_PaginaWebCli"], @$_POST["y_PaginaWebCli"], @$_POST["w_PaginaWebCli"]);
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
	global $conn, $Security, $dbo_cliente;

	// Call Row Rendering event
	$dbo_cliente->Row_Rendering();

	// Common render codes for all row types
	if ($dbo_cliente->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// CodigoCli
		$dbo_cliente->CodigoCli->EditCustomAttributes = "";
		$dbo_cliente->CodigoCli->EditValue = ew_HtmlEncode($dbo_cliente->CodigoCli->AdvancedSearch->SearchValue);

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->EditCustomAttributes = "";
		$dbo_cliente->RazonSocialCli->EditValue = ew_HtmlEncode($dbo_cliente->RazonSocialCli->AdvancedSearch->SearchValue);

		// CuitCli
		$dbo_cliente->CuitCli->EditCustomAttributes = "";
		$dbo_cliente->CuitCli->EditValue = ew_HtmlEncode($dbo_cliente->CuitCli->AdvancedSearch->SearchValue);

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->EditCustomAttributes = "";
		$dbo_cliente->IngBrutosCli->EditValue = ew_HtmlEncode($dbo_cliente->IngBrutosCli->AdvancedSearch->SearchValue);

		// Regis_IvaC
		$dbo_cliente->Regis_IvaC->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_IvaC`, `DescrIvaC` FROM `dbo_ivacondicion`";
		$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione"));
		$dbo_cliente->Regis_IvaC->EditValue = $arwrk;

		// Regis_ListaPrec
		$dbo_cliente->Regis_ListaPrec->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_ListaPrec`, `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios`";
		$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$dbo_cliente->Regis_ListaPrec->EditValue = $arwrk;

		// emailCli
		$dbo_cliente->emailCli->EditCustomAttributes = "";
		$dbo_cliente->emailCli->EditValue = ew_HtmlEncode($dbo_cliente->emailCli->AdvancedSearch->SearchValue);

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->EditCustomAttributes = "";
		$dbo_cliente->RazonSocialFlete->EditValue = ew_HtmlEncode($dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchValue);

		// Direccion
		$dbo_cliente->Direccion->EditCustomAttributes = "";
		$dbo_cliente->Direccion->EditValue = ew_HtmlEncode($dbo_cliente->Direccion->AdvancedSearch->SearchValue);

		// BarrioCli
		$dbo_cliente->BarrioCli->EditCustomAttributes = "";
		$dbo_cliente->BarrioCli->EditValue = ew_HtmlEncode($dbo_cliente->BarrioCli->AdvancedSearch->SearchValue);

		// LocalidadCli
		$dbo_cliente->LocalidadCli->EditCustomAttributes = "";
		$dbo_cliente->LocalidadCli->EditValue = ew_HtmlEncode($dbo_cliente->LocalidadCli->AdvancedSearch->SearchValue);

		// DescrProvincia
		$dbo_cliente->DescrProvincia->EditCustomAttributes = "";
		$dbo_cliente->DescrProvincia->EditValue = ew_HtmlEncode($dbo_cliente->DescrProvincia->AdvancedSearch->SearchValue);

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->EditCustomAttributes = "";
		$dbo_cliente->CodigoPostalCli->EditValue = ew_HtmlEncode($dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchValue);

		// DescrPais
		$dbo_cliente->DescrPais->EditCustomAttributes = "";
		$dbo_cliente->DescrPais->EditValue = ew_HtmlEncode($dbo_cliente->DescrPais->AdvancedSearch->SearchValue);

		// Telefono
		$dbo_cliente->Telefono->EditCustomAttributes = "";
		$dbo_cliente->Telefono->EditValue = ew_HtmlEncode($dbo_cliente->Telefono->AdvancedSearch->SearchValue);

		// FaxCli
		$dbo_cliente->FaxCli->EditCustomAttributes = "";
		$dbo_cliente->FaxCli->EditValue = ew_HtmlEncode($dbo_cliente->FaxCli->AdvancedSearch->SearchValue);

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->EditCustomAttributes = "";
		$dbo_cliente->PaginaWebCli->EditValue = ew_HtmlEncode($dbo_cliente->PaginaWebCli->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$dbo_cliente->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_cliente;
	$dbo_cliente->CodigoCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_CodigoCli");
	$dbo_cliente->CodigoCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_CodigoCli");
	$dbo_cliente->RazonSocialCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_RazonSocialCli");
	$dbo_cliente->RazonSocialCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_RazonSocialCli");
	$dbo_cliente->CuitCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_CuitCli");
	$dbo_cliente->CuitCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_CuitCli");
	$dbo_cliente->IngBrutosCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_IngBrutosCli");
	$dbo_cliente->IngBrutosCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_IngBrutosCli");
	$dbo_cliente->Regis_IvaC->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_Regis_IvaC");
	$dbo_cliente->Regis_IvaC->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_Regis_IvaC");
	$dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_Regis_ListaPrec");
	$dbo_cliente->Regis_ListaPrec->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_Regis_ListaPrec");
	$dbo_cliente->emailCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_emailCli");
	$dbo_cliente->emailCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_emailCli");
	$dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_RazonSocialFlete");
	$dbo_cliente->RazonSocialFlete->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_RazonSocialFlete");
	$dbo_cliente->Direccion->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_Direccion");
	$dbo_cliente->Direccion->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_Direccion");
	$dbo_cliente->BarrioCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_BarrioCli");
	$dbo_cliente->BarrioCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_BarrioCli");
	$dbo_cliente->LocalidadCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_LocalidadCli");
	$dbo_cliente->LocalidadCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_LocalidadCli");
	$dbo_cliente->DescrProvincia->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_DescrProvincia");
	$dbo_cliente->DescrProvincia->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_DescrProvincia");
	$dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_CodigoPostalCli");
	$dbo_cliente->CodigoPostalCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_CodigoPostalCli");
	$dbo_cliente->DescrPais->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_DescrPais");
	$dbo_cliente->DescrPais->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_DescrPais");
	$dbo_cliente->Telefono->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_Telefono");
	$dbo_cliente->Telefono->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_Telefono");
	$dbo_cliente->FaxCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_FaxCli");
	$dbo_cliente->FaxCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_FaxCli");
	$dbo_cliente->PaginaWebCli->AdvancedSearch->SearchValue = $dbo_cliente->getAdvancedSearch("x_PaginaWebCli");
	$dbo_cliente->PaginaWebCli->AdvancedSearch->SearchOperator = $dbo_cliente->getAdvancedSearch("z_PaginaWebCli");
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
