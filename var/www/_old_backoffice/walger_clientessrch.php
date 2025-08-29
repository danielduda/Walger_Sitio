<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_clientes', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_clientesinfo.php" ?>
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
$walger_clientes->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_clientes->Export; // Get export parameter, used in header
$sExportFile = $walger_clientes->TableVar; // Get export file, used in header
?>
<?php

// Get action
$walger_clientes->CurrentAction = @$_POST["a_search"];
switch ($walger_clientes->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("walger_clienteslist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$walger_clientes->RowType = EW_ROWTYPE_SEARCH;
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
		elm = fobj.elements["x" + infix + "_UltimoLogin"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Ultimo Login"))
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
<p><span class="phpmaker">Buscar : Clientes<br><br><a href="walger_clienteslist.php">Lista</a></span></p>
<form name="fwalger_clientessearch" id="fwalger_clientessearch" action="walger_clientessrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cliente</td>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodigoCli" id="z_CodigoCli"><option value="="<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->CodigoCli->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>><span class="phpmaker">
<select id="x_CodigoCli" name="x_CodigoCli" onChange="ew_UpdateOpt(this.form.x_CodigoCli, ar_x_CodigoCli, this);"<?php echo $walger_clientes->CodigoCli->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->CodigoCli->EditValue)) {
	$arwrk = $walger_clientes->CodigoCli->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->CodigoCli->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Contraseña</td>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Contrasenia" id="z_Contrasenia"><option value="="<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->Contrasenia->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Contrasenia" id="x_Contrasenia" title="" size="30" maxlength="20" value="<?php echo $walger_clientes->Contrasenia->EditValue ?>"<?php echo $walger_clientes->Contrasenia->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">IP</td>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_IP" id="z_IP"><option value="="<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->IP->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_IP" id="x_IP" title="" size="30" maxlength="15" value="<?php echo $walger_clientes->IP->EditValue ?>"<?php echo $walger_clientes->IP->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Ultimo Login</td>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_UltimoLogin" id="z_UltimoLogin"><option value="="<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_UltimoLogin" id="x_UltimoLogin" title="" value="<?php echo $walger_clientes->UltimoLogin->EditValue ?>"<?php echo $walger_clientes->UltimoLogin->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Habilitado</td>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Habilitado" id="z_Habilitado"><option value="="<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->Habilitado->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>><span class="phpmaker">
<select id="x_Habilitado" name="x_Habilitado"<?php echo $walger_clientes->Habilitado->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->Habilitado->EditValue)) {
	$arwrk = $walger_clientes->Habilitado->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->Habilitado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Tipo de Cliente</td>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_TipoCliente" id="z_TipoCliente"><option value="="<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->TipoCliente->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>><span class="phpmaker">
<select id="x_TipoCliente" name="x_TipoCliente"<?php echo $walger_clientes->TipoCliente->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->TipoCliente->EditValue)) {
	$arwrk = $walger_clientes->TipoCliente->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->TipoCliente->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Moneda</td>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>><span class="ewSearchOpr">=<input type="hidden" name="z_Regis_Mda" id="z_Regis_Mda" value="="></span></td>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>><span class="phpmaker">
<select id="x_Regis_Mda" name="x_Regis_Mda"<?php echo $walger_clientes->Regis_Mda->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->Regis_Mda->EditValue)) {
	$arwrk = $walger_clientes->Regis_Mda->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->Regis_Mda->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Apellido y Nombre</td>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_ApellidoNombre" id="z_ApellidoNombre"><option value="="<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_ApellidoNombre" id="x_ApellidoNombre" title="" size="30" maxlength="30" value="<?php echo $walger_clientes->ApellidoNombre->EditValue ?>"<?php echo $walger_clientes->ApellidoNombre->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cargo</td>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Cargo" id="z_Cargo"><option value="="<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->Cargo->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Cargo" id="x_Cargo" title="" size="30" maxlength="30" value="<?php echo $walger_clientes->Cargo->EditValue ?>"<?php echo $walger_clientes->Cargo->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Comentarios</td>
		<td<?php echo $walger_clientes->Comentarios->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Comentarios" id="z_Comentarios"><option value="="<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($walger_clientes->Comentarios->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $walger_clientes->Comentarios->CellAttributes() ?>><span class="phpmaker">
<textarea name="x_Comentarios" id="x_Comentarios" cols="35" rows="4"<?php echo $walger_clientes->Comentarios->EditAttributes() ?>><?php echo $walger_clientes->Comentarios->EditValue ?></textarea>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="Action" id="Action" value="  Buscar  ">
<input type="button" name="Reset" id="Reset" value="  Vaciar  " onclick="ew_ClearForm(this.form);">
</form>
<script language="JavaScript">
<!--
var f = document.fwalger_clientessearch;
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
	global $walger_clientes;
	$sSrchUrl = "";

	// Field CodigoCli
	BuildSearchUrl($sSrchUrl, $walger_clientes->CodigoCli, @$_POST["x_CodigoCli"], @$_POST["z_CodigoCli"], @$_POST["v_CodigoCli"], @$_POST["y_CodigoCli"], @$_POST["w_CodigoCli"]);

	// Field Contrasenia
	BuildSearchUrl($sSrchUrl, $walger_clientes->Contrasenia, @$_POST["x_Contrasenia"], @$_POST["z_Contrasenia"], @$_POST["v_Contrasenia"], @$_POST["y_Contrasenia"], @$_POST["w_Contrasenia"]);

	// Field IP
	BuildSearchUrl($sSrchUrl, $walger_clientes->IP, @$_POST["x_IP"], @$_POST["z_IP"], @$_POST["v_IP"], @$_POST["y_IP"], @$_POST["w_IP"]);

	// Field UltimoLogin
	BuildSearchUrl($sSrchUrl, $walger_clientes->UltimoLogin, ew_UnFormatDateTime(@$_POST["x_UltimoLogin"],7), @$_POST["z_UltimoLogin"], @$_POST["v_UltimoLogin"], ew_UnFormatDateTime(@$_POST["y_UltimoLogin"],7), @$_POST["w_UltimoLogin"]);

	// Field Habilitado
	BuildSearchUrl($sSrchUrl, $walger_clientes->Habilitado, @$_POST["x_Habilitado"], @$_POST["z_Habilitado"], @$_POST["v_Habilitado"], @$_POST["y_Habilitado"], @$_POST["w_Habilitado"]);

	// Field TipoCliente
	BuildSearchUrl($sSrchUrl, $walger_clientes->TipoCliente, @$_POST["x_TipoCliente"], @$_POST["z_TipoCliente"], @$_POST["v_TipoCliente"], @$_POST["y_TipoCliente"], @$_POST["w_TipoCliente"]);

	// Field Regis_Mda
	BuildSearchUrl($sSrchUrl, $walger_clientes->Regis_Mda, @$_POST["x_Regis_Mda"], @$_POST["z_Regis_Mda"], @$_POST["v_Regis_Mda"], @$_POST["y_Regis_Mda"], @$_POST["w_Regis_Mda"]);

	// Field ApellidoNombre
	BuildSearchUrl($sSrchUrl, $walger_clientes->ApellidoNombre, @$_POST["x_ApellidoNombre"], @$_POST["z_ApellidoNombre"], @$_POST["v_ApellidoNombre"], @$_POST["y_ApellidoNombre"], @$_POST["w_ApellidoNombre"]);

	// Field Cargo
	BuildSearchUrl($sSrchUrl, $walger_clientes->Cargo, @$_POST["x_Cargo"], @$_POST["z_Cargo"], @$_POST["v_Cargo"], @$_POST["y_Cargo"], @$_POST["w_Cargo"]);

	// Field Comentarios
	BuildSearchUrl($sSrchUrl, $walger_clientes->Comentarios, @$_POST["x_Comentarios"], @$_POST["z_Comentarios"], @$_POST["v_Comentarios"], @$_POST["y_Comentarios"], @$_POST["w_Comentarios"]);
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
	global $conn, $Security, $walger_clientes;

	// Call Row Rendering event
	$walger_clientes->Row_Rendering();

	// Common render codes for all row types
	if ($walger_clientes->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// CodigoCli
		$walger_clientes->CodigoCli->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente`";
		$sSqlWrk .= " ORDER BY `RazonSocialCli` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$walger_clientes->CodigoCli->EditValue = $arwrk;

		// Contrasenia
		$walger_clientes->Contrasenia->EditCustomAttributes = "";
		$walger_clientes->Contrasenia->EditValue = ew_HtmlEncode($walger_clientes->Contrasenia->AdvancedSearch->SearchValue);

		// IP
		$walger_clientes->IP->EditCustomAttributes = "";
		$walger_clientes->IP->EditValue = ew_HtmlEncode($walger_clientes->IP->AdvancedSearch->SearchValue);

		// UltimoLogin
		$walger_clientes->UltimoLogin->EditCustomAttributes = "";
		$walger_clientes->UltimoLogin->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_clientes->UltimoLogin->AdvancedSearch->SearchValue, 7));

		// Habilitado
		$walger_clientes->Habilitado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("S", "Si");
		$arwrk[] = array("N", "No");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_clientes->Habilitado->EditValue = $arwrk;

		// TipoCliente
		$walger_clientes->TipoCliente->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("Consumidor Final", "Consumidor Final");
		$arwrk[] = array("Casa de Repuestos", "Casa de Repuestos");
		$arwrk[] = array("Distribuidor", "Distribuidor");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_clientes->TipoCliente->EditValue = $arwrk;

		// Regis_Mda
		$walger_clientes->Regis_Mda->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_Mda`, `CodigoAFIP_Mda`, `Signo_Mda` FROM `dbo_moneda`";
		$sSqlWrk .= " ORDER BY `CodigoAFIP_Mda` ";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$walger_clientes->Regis_Mda->EditValue = $arwrk;

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->EditCustomAttributes = "";
		$walger_clientes->ApellidoNombre->EditValue = ew_HtmlEncode($walger_clientes->ApellidoNombre->AdvancedSearch->SearchValue);

		// Cargo
		$walger_clientes->Cargo->EditCustomAttributes = "";
		$walger_clientes->Cargo->EditValue = ew_HtmlEncode($walger_clientes->Cargo->AdvancedSearch->SearchValue);

		// Comentarios
		$walger_clientes->Comentarios->EditCustomAttributes = "";
		$walger_clientes->Comentarios->EditValue = ew_HtmlEncode($walger_clientes->Comentarios->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$walger_clientes->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_clientes;
	$walger_clientes->CodigoCli->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_CodigoCli");
	$walger_clientes->CodigoCli->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_CodigoCli");
	$walger_clientes->Contrasenia->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_Contrasenia");
	$walger_clientes->Contrasenia->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_Contrasenia");
	$walger_clientes->IP->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_IP");
	$walger_clientes->IP->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_IP");
	$walger_clientes->UltimoLogin->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_UltimoLogin");
	$walger_clientes->UltimoLogin->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_UltimoLogin");
	$walger_clientes->Habilitado->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_Habilitado");
	$walger_clientes->Habilitado->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_Habilitado");
	$walger_clientes->TipoCliente->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_TipoCliente");
	$walger_clientes->TipoCliente->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_TipoCliente");
	$walger_clientes->Regis_Mda->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_Regis_Mda");
	$walger_clientes->ApellidoNombre->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_ApellidoNombre");
	$walger_clientes->ApellidoNombre->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_ApellidoNombre");
	$walger_clientes->Cargo->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_Cargo");
	$walger_clientes->Cargo->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_Cargo");
	$walger_clientes->Comentarios->AdvancedSearch->SearchValue = $walger_clientes->getAdvancedSearch("x_Comentarios");
	$walger_clientes->Comentarios->AdvancedSearch->SearchOperator = $walger_clientes->getAdvancedSearch("z_Comentarios");
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
