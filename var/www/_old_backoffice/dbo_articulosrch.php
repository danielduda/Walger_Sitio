<?php
define("EW_PAGE_ID", "search", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_articulo', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_articuloinfo.php" ?>
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
$dbo_articulo->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_articulo->Export; // Get export parameter, used in header
$sExportFile = $dbo_articulo->TableVar; // Get export file, used in header
?>
<?php

// Get action
$dbo_articulo->CurrentAction = @$_POST["a_search"];
switch ($dbo_articulo->CurrentAction) {
	case "S": // Get Search Criteria

		// Build search string for advanced search, remove blank field
		$sSrchStr = BuildAdvancedSearch();
		if ($sSrchStr <> "") {
			Page_Terminate("dbo_articulolist.php?" . $sSrchStr); // Go to list page
		}
		break;
	default: // Restore search settings
		LoadAdvancedSearch();
}

// Render row for search
$dbo_articulo->RowType = EW_ROWTYPE_SEARCH;
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
		elm = fobj.elements["x" + infix + "_TasaIva"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Tasa IVA"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_PrecioVta1_PreArti"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Precio de Venta"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_Stock1_StkArti"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Stock"))
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
<p><span class="phpmaker">Buscar : Artículos (ISIS)<br><br><a href="dbo_articulolist.php">Lista</a></span></p>
<form name="fdbo_articulosearch" id="fdbo_articulosearch" action="dbo_articulosrch.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_search" id="a_search" value="S">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Codigo Interno</td>
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodInternoArti" id="z_CodInternoArti"><option value="="<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CodInternoArti" id="x_CodInternoArti" title="" size="30" maxlength="24" value="<?php echo $dbo_articulo->CodInternoArti->EditValue ?>"<?php echo $dbo_articulo->CodInternoArti->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Codigo de Barras</td>
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_CodBarraArti" id="z_CodBarraArti"><option value="="<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_CodBarraArti" id="x_CodBarraArti" title="" size="30" maxlength="24" value="<?php echo $dbo_articulo->CodBarraArti->EditValue ?>"<?php echo $dbo_articulo->CodBarraArti->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Catálogo</td>
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrNivelInt4" id="z_DescrNivelInt4"><option value="="<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrNivelInt4" id="x_DescrNivelInt4" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt4->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt4->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Línea</td>
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrNivelInt3" id="z_DescrNivelInt3"><option value="="<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrNivelInt3" id="x_DescrNivelInt3" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt3->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt3->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Marca</td>
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescrNivelInt2" id="z_DescrNivelInt2"><option value="="<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescrNivelInt2" id="x_DescrNivelInt2" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt2->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt2->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Tasa IVA</td>
		<td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_TasaIva" id="z_TasaIva"><option value="="<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->TasaIva->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_TasaIva" id="x_TasaIva" title="" size="30" value="<?php echo $dbo_articulo->TasaIva->EditValue ?>"<?php echo $dbo_articulo->TasaIva->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Precio de Venta</td>
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_PrecioVta1_PreArti" id="z_PrecioVta1_PreArti"><option value="="<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_PrecioVta1_PreArti" id="x_PrecioVta1_PreArti" title="" size="30" value="<?php echo $dbo_articulo->PrecioVta1_PreArti->EditValue ?>"<?php echo $dbo_articulo->PrecioVta1_PreArti->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Descripcion</td>
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_DescripcionArti" id="z_DescripcionArti"><option value="="<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_DescripcionArti" id="x_DescripcionArti" title="" size="30" maxlength="60" value="<?php echo $dbo_articulo->DescripcionArti->EditValue ?>"<?php echo $dbo_articulo->DescripcionArti->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Ruta a la Foto</td>
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_NombreFotoArti" id="z_NombreFotoArti"><option value="="<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option><option value="LIKE"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="LIKE")?" selected":"" ?>>contiene</option><option value="NOT LIKE"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="NOT LIKE")?" selected":"" ?>>no contiene</option><option value="STARTS WITH"<?php echo ($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator=="STARTS WITH")?" selected":"" ?>>inicia con</option></select></span></td>
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_NombreFotoArti" id="x_NombreFotoArti" title="" size="30" maxlength="100" value="<?php echo $dbo_articulo->NombreFotoArti->EditValue ?>"<?php echo $dbo_articulo->NombreFotoArti->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Stock</td>
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>><span class="ewSearchOpr"><select name="z_Stock1_StkArti" id="z_Stock1_StkArti"><option value="="<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator=="=")?" selected":"" ?>>=</option><option value="<>"<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator=="<>")?" selected":"" ?>><></option><option value="<"<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator=="<")?" selected":"" ?>><</option><option value="<="<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator=="<=")?" selected":"" ?>><=</option><option value=">"<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator==">")?" selected":"" ?>>></option><option value=">="<?php echo ($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator==">=")?" selected":"" ?>>>=</option></select></span></td>
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>><span class="phpmaker">
<input type="text" name="x_Stock1_StkArti" id="x_Stock1_StkArti" title="" size="30" value="<?php echo $dbo_articulo->Stock1_StkArti->EditValue ?>"<?php echo $dbo_articulo->Stock1_StkArti->EditAttributes() ?>>
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
	global $dbo_articulo;
	$sSrchUrl = "";

	// Field CodInternoArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->CodInternoArti, @$_POST["x_CodInternoArti"], @$_POST["z_CodInternoArti"], @$_POST["v_CodInternoArti"], @$_POST["y_CodInternoArti"], @$_POST["w_CodInternoArti"]);

	// Field CodBarraArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->CodBarraArti, @$_POST["x_CodBarraArti"], @$_POST["z_CodBarraArti"], @$_POST["v_CodBarraArti"], @$_POST["y_CodBarraArti"], @$_POST["w_CodBarraArti"]);

	// Field DescrNivelInt4
	BuildSearchUrl($sSrchUrl, $dbo_articulo->DescrNivelInt4, @$_POST["x_DescrNivelInt4"], @$_POST["z_DescrNivelInt4"], @$_POST["v_DescrNivelInt4"], @$_POST["y_DescrNivelInt4"], @$_POST["w_DescrNivelInt4"]);

	// Field DescrNivelInt3
	BuildSearchUrl($sSrchUrl, $dbo_articulo->DescrNivelInt3, @$_POST["x_DescrNivelInt3"], @$_POST["z_DescrNivelInt3"], @$_POST["v_DescrNivelInt3"], @$_POST["y_DescrNivelInt3"], @$_POST["w_DescrNivelInt3"]);

	// Field DescrNivelInt2
	BuildSearchUrl($sSrchUrl, $dbo_articulo->DescrNivelInt2, @$_POST["x_DescrNivelInt2"], @$_POST["z_DescrNivelInt2"], @$_POST["v_DescrNivelInt2"], @$_POST["y_DescrNivelInt2"], @$_POST["w_DescrNivelInt2"]);

	// Field TasaIva
	BuildSearchUrl($sSrchUrl, $dbo_articulo->TasaIva, @$_POST["x_TasaIva"], @$_POST["z_TasaIva"], @$_POST["v_TasaIva"], @$_POST["y_TasaIva"], @$_POST["w_TasaIva"]);

	// Field PrecioVta1_PreArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->PrecioVta1_PreArti, @$_POST["x_PrecioVta1_PreArti"], @$_POST["z_PrecioVta1_PreArti"], @$_POST["v_PrecioVta1_PreArti"], @$_POST["y_PrecioVta1_PreArti"], @$_POST["w_PrecioVta1_PreArti"]);

	// Field DescripcionArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->DescripcionArti, @$_POST["x_DescripcionArti"], @$_POST["z_DescripcionArti"], @$_POST["v_DescripcionArti"], @$_POST["y_DescripcionArti"], @$_POST["w_DescripcionArti"]);

	// Field NombreFotoArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->NombreFotoArti, @$_POST["x_NombreFotoArti"], @$_POST["z_NombreFotoArti"], @$_POST["v_NombreFotoArti"], @$_POST["y_NombreFotoArti"], @$_POST["w_NombreFotoArti"]);

	// Field Stock1_StkArti
	BuildSearchUrl($sSrchUrl, $dbo_articulo->Stock1_StkArti, @$_POST["x_Stock1_StkArti"], @$_POST["z_Stock1_StkArti"], @$_POST["v_Stock1_StkArti"], @$_POST["y_Stock1_StkArti"], @$_POST["w_Stock1_StkArti"]);
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
	global $conn, $Security, $dbo_articulo;

	// Call Row Rendering event
	$dbo_articulo->Row_Rendering();

	// Common render codes for all row types
	if ($dbo_articulo->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_SEARCH) { // Search row

		// CodInternoArti
		$dbo_articulo->CodInternoArti->EditCustomAttributes = "";
		$dbo_articulo->CodInternoArti->EditValue = ew_HtmlEncode($dbo_articulo->CodInternoArti->AdvancedSearch->SearchValue);

		// CodBarraArti
		$dbo_articulo->CodBarraArti->EditCustomAttributes = "";
		$dbo_articulo->CodBarraArti->EditValue = ew_HtmlEncode($dbo_articulo->CodBarraArti->AdvancedSearch->SearchValue);

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt4->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchValue);

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt3->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchValue);

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt2->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchValue);

		// TasaIva
		$dbo_articulo->TasaIva->EditCustomAttributes = "";
		$dbo_articulo->TasaIva->EditValue = ew_HtmlEncode($dbo_articulo->TasaIva->AdvancedSearch->SearchValue);

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->EditCustomAttributes = "";
		$dbo_articulo->PrecioVta1_PreArti->EditValue = ew_HtmlEncode($dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchValue);

		// DescripcionArti
		$dbo_articulo->DescripcionArti->EditCustomAttributes = "";
		$dbo_articulo->DescripcionArti->EditValue = ew_HtmlEncode($dbo_articulo->DescripcionArti->AdvancedSearch->SearchValue);

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->EditCustomAttributes = "";
		$dbo_articulo->NombreFotoArti->EditValue = ew_HtmlEncode($dbo_articulo->NombreFotoArti->AdvancedSearch->SearchValue);

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->EditCustomAttributes = "";
		$dbo_articulo->Stock1_StkArti->EditValue = ew_HtmlEncode($dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchValue);
	}

	// Call Row Rendered event
	$dbo_articulo->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_articulo;
	$dbo_articulo->CodInternoArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_CodInternoArti");
	$dbo_articulo->CodInternoArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_CodInternoArti");
	$dbo_articulo->CodBarraArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_CodBarraArti");
	$dbo_articulo->CodBarraArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_CodBarraArti");
	$dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_DescrNivelInt4");
	$dbo_articulo->DescrNivelInt4->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_DescrNivelInt4");
	$dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_DescrNivelInt3");
	$dbo_articulo->DescrNivelInt3->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_DescrNivelInt3");
	$dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_DescrNivelInt2");
	$dbo_articulo->DescrNivelInt2->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_DescrNivelInt2");
	$dbo_articulo->TasaIva->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_TasaIva");
	$dbo_articulo->TasaIva->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_TasaIva");
	$dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_PrecioVta1_PreArti");
	$dbo_articulo->PrecioVta1_PreArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_PrecioVta1_PreArti");
	$dbo_articulo->DescripcionArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_DescripcionArti");
	$dbo_articulo->DescripcionArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_DescripcionArti");
	$dbo_articulo->NombreFotoArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_NombreFotoArti");
	$dbo_articulo->NombreFotoArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_NombreFotoArti");
	$dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchValue = $dbo_articulo->getAdvancedSearch("x_Stock1_StkArti");
	$dbo_articulo->Stock1_StkArti->AdvancedSearch->SearchOperator = $dbo_articulo->getAdvancedSearch("z_Stock1_StkArti");
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
