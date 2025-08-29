<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($dbo_articulo->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_articulo->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_articulo->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_articulo->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_articulo->Export == "csv") {
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.csv');
}
?>
<?php

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 20;
$nRecRange = 10;
$nRecCount = 0; // Record count

// Search filters
$sSrchAdvanced = ""; // Advanced search filter
$sSrchBasic = ""; // Basic search filter
$sSrchWhere = ""; // Search where clause
$sFilter = "";
$sDeleteConfirmMsg = "Realmente desea eliminar éstos registros?"; // Delete confirm message

// Master/Detail
$sDbMasterFilter = ""; // Master filter
$sDbDetailFilter = ""; // Detail filter
$sSqlMaster = ""; // Sql for master record

// Handle reset command
ResetCmd();

// Get search criteria for advanced search
$sSrchAdvanced = AdvancedSearchWhere();

// Get basic search criteria
$sSrchBasic = BasicSearchWhere();

// Build search criteria
if ($sSrchAdvanced <> "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchAdvanced . ")";
}
if ($sSrchBasic <> "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchBasic . ")";
}

// Save search criteria
if ($sSrchWhere <> "") {
	if ($sSrchBasic == "") ResetBasicSearchParms();
	if ($sSrchAdvanced == "") ResetAdvancedSearchParms();
	$dbo_articulo->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$dbo_articulo->setStartRecordNumber($nStartRec);
} else {
	RestoreSearchParms();
}

// Build filter
$sFilter = "";
if ($sDbDetailFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sDbDetailFilter . ")";
}
if ($sSrchWhere <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sSrchWhere . ")";
}

// Set up filter in Session
$dbo_articulo->setSessionWhere($sFilter);
$dbo_articulo->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($dbo_articulo->Export == "xml" || $dbo_articulo->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$dbo_articulo->setReturnUrl("dbo_articulolist.php");
?>
<?php include "header.php" ?>
<?php if ($dbo_articulo->Export == "") { ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "list"; // Page id

//-->
</script>
<script type="text/javascript">
<!--
var firstrowoffset = 1; // First data row start at
var lastrowoffset = 0; // Last data row end at
var EW_LIST_TABLE_NAME = 'ewlistmain'; // Table name for list page
var rowclass = 'ewTableRow'; // Row class
var rowaltclass = 'ewTableAltRow'; // Row alternate class
var rowmoverclass = 'ewTableHighlightRow'; // Row mouse over class
var rowselectedclass = 'ewTableSelectRow'; // Row selected class
var roweditclass = 'ewTableEditRow'; // Row edit class

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

function ew_SelectKey(elem) {
	var f = elem.form;	
	if (!f.elements["key_m[]"]) return;
	if (f.elements["key_m[]"][0]) {
		for (var i=0; i<f.elements["key_m[]"].length; i++)
			f.elements["key_m[]"][i].checked = elem.checked;	
	} else {
		f.elements["key_m[]"].checked = elem.checked;	
	}
	ew_ClickAll(elem);
}

function ew_Selected(f) {
	if (!f.elements["key_m[]"]) return false;
	if (f.elements["key_m[]"][0]) {
		for (var i=0; i<f.elements["key_m[]"].length; i++)
			if (f.elements["key_m[]"][i].checked) return true;
	} else {
		return f.elements["key_m[]"].checked;
	}
	return false;
}

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $dbo_articulo->Export <> "");
$bSelectLimit = ($dbo_articulo->Export == "" && $dbo_articulo->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $dbo_articulo->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Artículos (ISIS)
<?php if ($dbo_articulo->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_articulolist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_articulolist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_articulolist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_articulolist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_articulolist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($dbo_articulo->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($dbo_articulo->getBasicSearchType() == "") $dbo_articulo->setBasicSearchType("AND"); ?>

<form name="fdbo_articulolistsrch" id="fdbo_articulolistsrch" action="dbo_articulolist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbo_articulo->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="dbo_articulolist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="dbo_articulosrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($dbo_articulo->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($dbo_articulo->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($dbo_articulo->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
	</tr>
</table>
</form>
<?php } ?>
<?php } ?>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<?php if ($dbo_articulo->Export == "") { ?>
<form action="dbo_articulolist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_articulolist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->ButtonCount > 0) { ?><br><?php } ?>
	Registros <?php echo $Pager->FromIndex ?> al <?php echo $Pager->ToIndex ?> de <?php echo $Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($sSrchWhere == "0=101") { ?>
	Ingrese el criterio requerido
	<?php } else { ?>
	No se encontraron datos
	<?php } ?>
<?php } ?>
</span>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<form method="post" name="fdbo_articulolist" id="fdbo_articulolist">
<?php if ($dbo_articulo->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_articuloadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_articulolist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_articulolist.action='dbo_articulodelete.php';document.fdbo_articulolist.encoding='application/x-www-form-urlencoded';document.fdbo_articulolist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
	</span></td></tr>
</table>
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<table id="ewlistmain" class="ewTable">
<?php
	$OptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // view
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // copy
}
if ($Security->IsLoggedIn()) {
	$OptionCnt++; // multi select
}
?>
	<!-- Table header -->
	<tr class="ewTableHeader">
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Codigo Interno
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('CodInternoArti') ?>&ordertype=<?php echo $dbo_articulo->CodInternoArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Codigo Interno&nbsp;(*)<?php if ($dbo_articulo->CodInternoArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->CodInternoArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Codigo de Barras
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('CodBarraArti') ?>&ordertype=<?php echo $dbo_articulo->CodBarraArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Codigo de Barras&nbsp;(*)<?php if ($dbo_articulo->CodBarraArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->CodBarraArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Catálogo
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('DescrNivelInt4') ?>&ordertype=<?php echo $dbo_articulo->DescrNivelInt4->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Catálogo&nbsp;(*)<?php if ($dbo_articulo->DescrNivelInt4->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->DescrNivelInt4->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Línea
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('DescrNivelInt3') ?>&ordertype=<?php echo $dbo_articulo->DescrNivelInt3->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Línea&nbsp;(*)<?php if ($dbo_articulo->DescrNivelInt3->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->DescrNivelInt3->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Marca
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('DescrNivelInt2') ?>&ordertype=<?php echo $dbo_articulo->DescrNivelInt2->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Marca&nbsp;(*)<?php if ($dbo_articulo->DescrNivelInt2->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->DescrNivelInt2->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Tasa IVA
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('TasaIva') ?>&ordertype=<?php echo $dbo_articulo->TasaIva->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Tasa IVA&nbsp;(*)<?php if ($dbo_articulo->TasaIva->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->TasaIva->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Precio de Venta
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('PrecioVta1_PreArti') ?>&ordertype=<?php echo $dbo_articulo->PrecioVta1_PreArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Precio de Venta&nbsp;(*)<?php if ($dbo_articulo->PrecioVta1_PreArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->PrecioVta1_PreArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Descripcion
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('DescripcionArti') ?>&ordertype=<?php echo $dbo_articulo->DescripcionArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Descripcion&nbsp;(*)<?php if ($dbo_articulo->DescripcionArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->DescripcionArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Ruta a la Foto
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('NombreFotoArti') ?>&ordertype=<?php echo $dbo_articulo->NombreFotoArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Ruta a la Foto&nbsp;(*)<?php if ($dbo_articulo->NombreFotoArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->NombreFotoArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_articulo->Export <> "") { ?>
Stock
<?php } else { ?>
	<a href="dbo_articulolist.php?order=<?php echo urlencode('Stock1_StkArti') ?>&ordertype=<?php echo $dbo_articulo->Stock1_StkArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Stock&nbsp;(*)<?php if ($dbo_articulo->Stock1_StkArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_articulo->Stock1_StkArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($dbo_articulo->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><input type="checkbox" class="phpmaker" onClick="ew_SelectKey(this);"></td>
<?php } ?>
<?php } ?>
	</tr>
<?php
if (defined("EW_EXPORT_ALL") && $dbo_articulo->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbo_articulo->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$dbo_articulo->CssClass = "ewTableRow";
	$dbo_articulo->CssStyle = "";

	// Init row event
	$dbo_articulo->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$dbo_articulo->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$dbo_articulo->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $dbo_articulo->DisplayAttributes() ?>>
		<!-- CodInternoArti -->
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodInternoArti->ViewValue ?></div>
</td>
		<!-- CodBarraArti -->
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodBarraArti->ViewValue ?></div>
</td>
		<!-- DescrNivelInt4 -->
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt4->ViewValue ?></div>
</td>
		<!-- DescrNivelInt3 -->
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt3->ViewValue ?></div>
</td>
		<!-- DescrNivelInt2 -->
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt2->ViewValue ?></div>
</td>
		<!-- TasaIva -->
		<td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>>
<div<?php echo $dbo_articulo->TasaIva->ViewAttributes() ?>><?php echo $dbo_articulo->TasaIva->ViewValue ?></div>
</td>
		<!-- PrecioVta1_PreArti -->
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>><?php echo $dbo_articulo->PrecioVta1_PreArti->ViewValue ?></div>
</td>
		<!-- DescripcionArti -->
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>><?php echo $dbo_articulo->DescripcionArti->ViewValue ?></div>
</td>
		<!-- NombreFotoArti -->
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>><?php echo $dbo_articulo->NombreFotoArti->ViewValue ?></div>
</td>
		<!-- Stock1_StkArti -->
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>><?php echo $dbo_articulo->Stock1_StkArti->ViewValue ?></div>
</td>
<?php if ($dbo_articulo->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_articulo->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_articulo->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_articulo->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($dbo_articulo->CodInternoArti->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
</span></td>
<?php } ?>
<?php } ?>
	</tr>
<?php
	}
	$rs->MoveNext();
}
?>
</table>
<?php if ($dbo_articulo->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_articuloadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_articulolist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_articulolist.action='dbo_articulodelete.php';document.fdbo_articulolist.encoding='application/x-www-form-urlencoded';document.fdbo_articulolist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
	</span></td></tr>
</table>
<?php } ?>
<?php } ?>
</form>
<?php

// Close recordset and connection
if ($rs) $rs->Close();
?>
<?php if ($dbo_articulo->Export == "") { ?>
<form action="dbo_articulolist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_articulolist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_articulolist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->ButtonCount > 0) { ?><br><?php } ?>
	Registros <?php echo $Pager->FromIndex ?> al <?php echo $Pager->ToIndex ?> de <?php echo $Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($sSrchWhere == "0=101") { ?>
	Ingrese el criterio requerido
	<?php } else { ?>
	No se encontraron datos
	<?php } ?>
<?php } ?>
</span>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<?php } ?>
<?php if ($dbo_articulo->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
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

// Return Advanced Search Where based on QueryString parameters
function AdvancedSearchWhere() {
	global $Security, $dbo_articulo;
	$sWhere = "";

	// Field CodInternoArti
	BuildSearchSql($sWhere, $dbo_articulo->CodInternoArti, @$_GET["x_CodInternoArti"], @$_GET["z_CodInternoArti"], @$_GET["v_CodInternoArti"], @$_GET["y_CodInternoArti"], @$_GET["w_CodInternoArti"]);

	// Field CodBarraArti
	BuildSearchSql($sWhere, $dbo_articulo->CodBarraArti, @$_GET["x_CodBarraArti"], @$_GET["z_CodBarraArti"], @$_GET["v_CodBarraArti"], @$_GET["y_CodBarraArti"], @$_GET["w_CodBarraArti"]);

	// Field DescrNivelInt4
	BuildSearchSql($sWhere, $dbo_articulo->DescrNivelInt4, @$_GET["x_DescrNivelInt4"], @$_GET["z_DescrNivelInt4"], @$_GET["v_DescrNivelInt4"], @$_GET["y_DescrNivelInt4"], @$_GET["w_DescrNivelInt4"]);

	// Field DescrNivelInt3
	BuildSearchSql($sWhere, $dbo_articulo->DescrNivelInt3, @$_GET["x_DescrNivelInt3"], @$_GET["z_DescrNivelInt3"], @$_GET["v_DescrNivelInt3"], @$_GET["y_DescrNivelInt3"], @$_GET["w_DescrNivelInt3"]);

	// Field DescrNivelInt2
	BuildSearchSql($sWhere, $dbo_articulo->DescrNivelInt2, @$_GET["x_DescrNivelInt2"], @$_GET["z_DescrNivelInt2"], @$_GET["v_DescrNivelInt2"], @$_GET["y_DescrNivelInt2"], @$_GET["w_DescrNivelInt2"]);

	// Field TasaIva
	BuildSearchSql($sWhere, $dbo_articulo->TasaIva, @$_GET["x_TasaIva"], @$_GET["z_TasaIva"], @$_GET["v_TasaIva"], @$_GET["y_TasaIva"], @$_GET["w_TasaIva"]);

	// Field PrecioVta1_PreArti
	BuildSearchSql($sWhere, $dbo_articulo->PrecioVta1_PreArti, @$_GET["x_PrecioVta1_PreArti"], @$_GET["z_PrecioVta1_PreArti"], @$_GET["v_PrecioVta1_PreArti"], @$_GET["y_PrecioVta1_PreArti"], @$_GET["w_PrecioVta1_PreArti"]);

	// Field DescripcionArti
	BuildSearchSql($sWhere, $dbo_articulo->DescripcionArti, @$_GET["x_DescripcionArti"], @$_GET["z_DescripcionArti"], @$_GET["v_DescripcionArti"], @$_GET["y_DescripcionArti"], @$_GET["w_DescripcionArti"]);

	// Field NombreFotoArti
	BuildSearchSql($sWhere, $dbo_articulo->NombreFotoArti, @$_GET["x_NombreFotoArti"], @$_GET["z_NombreFotoArti"], @$_GET["v_NombreFotoArti"], @$_GET["y_NombreFotoArti"], @$_GET["w_NombreFotoArti"]);

	// Field Stock1_StkArti
	BuildSearchSql($sWhere, $dbo_articulo->Stock1_StkArti, @$_GET["x_Stock1_StkArti"], @$_GET["z_Stock1_StkArti"], @$_GET["v_Stock1_StkArti"], @$_GET["y_Stock1_StkArti"], @$_GET["w_Stock1_StkArti"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field CodInternoArti
		SetSearchParm($dbo_articulo->CodInternoArti, @$_GET["x_CodInternoArti"], @$_GET["z_CodInternoArti"], @$_GET["v_CodInternoArti"], @$_GET["y_CodInternoArti"], @$_GET["w_CodInternoArti"]);

		// Field CodBarraArti
		SetSearchParm($dbo_articulo->CodBarraArti, @$_GET["x_CodBarraArti"], @$_GET["z_CodBarraArti"], @$_GET["v_CodBarraArti"], @$_GET["y_CodBarraArti"], @$_GET["w_CodBarraArti"]);

		// Field DescrNivelInt4
		SetSearchParm($dbo_articulo->DescrNivelInt4, @$_GET["x_DescrNivelInt4"], @$_GET["z_DescrNivelInt4"], @$_GET["v_DescrNivelInt4"], @$_GET["y_DescrNivelInt4"], @$_GET["w_DescrNivelInt4"]);

		// Field DescrNivelInt3
		SetSearchParm($dbo_articulo->DescrNivelInt3, @$_GET["x_DescrNivelInt3"], @$_GET["z_DescrNivelInt3"], @$_GET["v_DescrNivelInt3"], @$_GET["y_DescrNivelInt3"], @$_GET["w_DescrNivelInt3"]);

		// Field DescrNivelInt2
		SetSearchParm($dbo_articulo->DescrNivelInt2, @$_GET["x_DescrNivelInt2"], @$_GET["z_DescrNivelInt2"], @$_GET["v_DescrNivelInt2"], @$_GET["y_DescrNivelInt2"], @$_GET["w_DescrNivelInt2"]);

		// Field TasaIva
		SetSearchParm($dbo_articulo->TasaIva, @$_GET["x_TasaIva"], @$_GET["z_TasaIva"], @$_GET["v_TasaIva"], @$_GET["y_TasaIva"], @$_GET["w_TasaIva"]);

		// Field PrecioVta1_PreArti
		SetSearchParm($dbo_articulo->PrecioVta1_PreArti, @$_GET["x_PrecioVta1_PreArti"], @$_GET["z_PrecioVta1_PreArti"], @$_GET["v_PrecioVta1_PreArti"], @$_GET["y_PrecioVta1_PreArti"], @$_GET["w_PrecioVta1_PreArti"]);

		// Field DescripcionArti
		SetSearchParm($dbo_articulo->DescripcionArti, @$_GET["x_DescripcionArti"], @$_GET["z_DescripcionArti"], @$_GET["v_DescripcionArti"], @$_GET["y_DescripcionArti"], @$_GET["w_DescripcionArti"]);

		// Field NombreFotoArti
		SetSearchParm($dbo_articulo->NombreFotoArti, @$_GET["x_NombreFotoArti"], @$_GET["z_NombreFotoArti"], @$_GET["v_NombreFotoArti"], @$_GET["y_NombreFotoArti"], @$_GET["w_NombreFotoArti"]);

		// Field Stock1_StkArti
		SetSearchParm($dbo_articulo->Stock1_StkArti, @$_GET["x_Stock1_StkArti"], @$_GET["z_Stock1_StkArti"], @$_GET["v_Stock1_StkArti"], @$_GET["y_Stock1_StkArti"], @$_GET["w_Stock1_StkArti"]);
	}
	return $sWhere;
}

// Build search sql
function BuildSearchSql(&$Where, &$Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2) {
	$sWrk = "";
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$FldOpr = strtoupper(trim($FldOpr));
	if ($FldOpr == "") $FldOpr = "=";
	$FldOpr2 = strtoupper(trim($FldOpr2));
	if ($FldOpr2 == "") $FldOpr2 = "=";
	if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
		if ($FldVal <> "") $FldVal = ($FldVal == "1") ? $Fld->TrueValue : $Fld->FalseValue;
		if ($FldVal2 <> "") $FldVal2 = ($FldVal2 == "1") ? $Fld->TrueValue : $Fld->FalseValue;
	} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
		if ($FldVal <> "") $FldVal = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		if ($FldVal2 <> "") $FldVal2 = ew_UnFormatDateTime($FldVal2, $Fld->FldDateTimeFormat);
	}
	if ($FldOpr == "BETWEEN") {
		$IsValidValue = (($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType == EW_DATATYPE_NUMBER && is_numeric($FldVal) && is_numeric($FldVal2)));
		if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
			$sWrk = $Fld->FldExpression . " BETWEEN " . ew_QuotedValue($FldVal, $Fld->FldDataType) .
				" AND " . ew_QuotedValue($FldVal2, $Fld->FldDataType);
		}
	} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL") {
		$sWrk = $Fld->FldExpression . " " . $FldOpr;
	} else {
		$IsValidValue = (($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType == EW_DATATYPE_NUMBER && is_numeric($FldVal)));
		if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $Fld->FldDataType)) {
			$sWrk = $Fld->FldExpression . SearchString($FldOpr, $FldVal, $Fld->FldDataType);
		}
		$IsValidValue = (($Fld->FldDataType <> EW_DATATYPE_NUMBER) ||
			($Fld->FldDataType == EW_DATATYPE_NUMBER && is_numeric($FldVal2)));
		if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $Fld->FldDataType)) {
			if ($sWrk <> "") {
				$sWrk .= " " . (($FldCond=="OR")?"OR":"AND") . " ";
			}
			$sWrk .= $Fld->FldExpression . SearchString($FldOpr2, $FldVal2, $Fld->FldDataType);
		}
	}
	if ($sWrk <> "") {
		if ($Where <> "") $Where .= " AND ";
		$Where .= "(" . $sWrk . ")";
	}
}

// Return search string
function SearchString($FldOpr, $FldVal, $FldType) {
	if ($FldOpr == "LIKE" || $FldOpr == "NOT LIKE") {
		return " " . $FldOpr . " " . ew_QuotedValue("%" . $FldVal . "%", $FldType);
	} elseif ($FldOpr == "STARTS WITH") {
		return " LIKE " . ew_QuotedValue($FldVal . "%", $FldType);
	} else {
		return " " . $FldOpr . " " . ew_QuotedValue($FldVal, $FldType);
	}
}

// Set search parm
function SetSearchParm($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2) {
	global $dbo_articulo;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$dbo_articulo->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$dbo_articulo->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$dbo_articulo->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$dbo_articulo->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$dbo_articulo->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`CodInternoArti` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`CodBarraArti` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`DescrNivelInt4` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`DescrNivelInt3` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`DescrNivelInt2` LIKE '%" . $sKeyword . "%' OR ";
	if (is_numeric($sKeyword)) $sql .= "`TasaIva` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`PrecioVta1_PreArti` = " . $sKeyword . " OR ";
	$sql .= "`DescripcionArti` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`NombreFotoArti` LIKE '%" . $sKeyword . "%' OR ";
	if (is_numeric($sKeyword)) $sql .= "`Stock1_StkArti` = " . $sKeyword . " OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $dbo_articulo;
	$sSearchStr = "";
	$sSearchKeyword = ew_StripSlashes(@$_GET[EW_TABLE_BASIC_SEARCH]);
	$sSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	if ($sSearchKeyword <> "") {
		$sSearch = trim($sSearchKeyword);
		if ($sSearchType <> "") {
			while (strpos($sSearch, "  ") !== FALSE)
				$sSearch = str_replace("  ", " ", $sSearch);
			$arKeyword = explode(" ", trim($sSearch));
			foreach ($arKeyword as $sKeyword) {
				if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
				$sSearchStr .= "(" . BasicSearchSQL($sKeyword) . ")";
			}
		} else {
			$sSearchStr = BasicSearchSQL($sSearch);
		}
	}
	if ($sSearchKeyword <> "") {
		$dbo_articulo->setBasicSearchKeyword($sSearchKeyword);
		$dbo_articulo->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $dbo_articulo;
	$sSrchWhere = "";
	$dbo_articulo->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $dbo_articulo;
	$dbo_articulo->setBasicSearchKeyword("");
	$dbo_articulo->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $dbo_articulo;
	$dbo_articulo->setAdvancedSearch("x_CodInternoArti", "");
	$dbo_articulo->setAdvancedSearch("z_CodInternoArti", "");
	$dbo_articulo->setAdvancedSearch("x_CodBarraArti", "");
	$dbo_articulo->setAdvancedSearch("z_CodBarraArti", "");
	$dbo_articulo->setAdvancedSearch("x_DescrNivelInt4", "");
	$dbo_articulo->setAdvancedSearch("z_DescrNivelInt4", "");
	$dbo_articulo->setAdvancedSearch("x_DescrNivelInt3", "");
	$dbo_articulo->setAdvancedSearch("z_DescrNivelInt3", "");
	$dbo_articulo->setAdvancedSearch("x_DescrNivelInt2", "");
	$dbo_articulo->setAdvancedSearch("z_DescrNivelInt2", "");
	$dbo_articulo->setAdvancedSearch("x_TasaIva", "");
	$dbo_articulo->setAdvancedSearch("z_TasaIva", "");
	$dbo_articulo->setAdvancedSearch("x_PrecioVta1_PreArti", "");
	$dbo_articulo->setAdvancedSearch("z_PrecioVta1_PreArti", "");
	$dbo_articulo->setAdvancedSearch("x_DescripcionArti", "");
	$dbo_articulo->setAdvancedSearch("z_DescripcionArti", "");
	$dbo_articulo->setAdvancedSearch("x_NombreFotoArti", "");
	$dbo_articulo->setAdvancedSearch("z_NombreFotoArti", "");
	$dbo_articulo->setAdvancedSearch("x_Stock1_StkArti", "");
	$dbo_articulo->setAdvancedSearch("z_Stock1_StkArti", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $dbo_articulo;
	$sSrchWhere = $dbo_articulo->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $dbo_articulo;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$dbo_articulo->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$dbo_articulo->CurrentOrderType = @$_GET["ordertype"];

		// Field CodInternoArti
		$dbo_articulo->UpdateSort($dbo_articulo->CodInternoArti, $bCtrl);

		// Field CodBarraArti
		$dbo_articulo->UpdateSort($dbo_articulo->CodBarraArti, $bCtrl);

		// Field DescrNivelInt4
		$dbo_articulo->UpdateSort($dbo_articulo->DescrNivelInt4, $bCtrl);

		// Field DescrNivelInt3
		$dbo_articulo->UpdateSort($dbo_articulo->DescrNivelInt3, $bCtrl);

		// Field DescrNivelInt2
		$dbo_articulo->UpdateSort($dbo_articulo->DescrNivelInt2, $bCtrl);

		// Field TasaIva
		$dbo_articulo->UpdateSort($dbo_articulo->TasaIva, $bCtrl);

		// Field PrecioVta1_PreArti
		$dbo_articulo->UpdateSort($dbo_articulo->PrecioVta1_PreArti, $bCtrl);

		// Field DescripcionArti
		$dbo_articulo->UpdateSort($dbo_articulo->DescripcionArti, $bCtrl);

		// Field NombreFotoArti
		$dbo_articulo->UpdateSort($dbo_articulo->NombreFotoArti, $bCtrl);

		// Field Stock1_StkArti
		$dbo_articulo->UpdateSort($dbo_articulo->Stock1_StkArti, $bCtrl);
		$dbo_articulo->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $dbo_articulo->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($dbo_articulo->SqlOrderBy() <> "") {
			$sOrderBy = $dbo_articulo->SqlOrderBy();
			$dbo_articulo->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $dbo_articulo;

	// Get reset cmd
	if (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];

		// Reset search criteria
		if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall") {
			ResetSearchParms();
		}

		// Reset Sort Criteria
		if (strtolower($sCmd) == "resetsort") {
			$sOrderBy = "";
			$dbo_articulo->setSessionOrderBy($sOrderBy);
			$dbo_articulo->CodInternoArti->setSort("");
			$dbo_articulo->CodBarraArti->setSort("");
			$dbo_articulo->DescrNivelInt4->setSort("");
			$dbo_articulo->DescrNivelInt3->setSort("");
			$dbo_articulo->DescrNivelInt2->setSort("");
			$dbo_articulo->TasaIva->setSort("");
			$dbo_articulo->PrecioVta1_PreArti->setSort("");
			$dbo_articulo->DescripcionArti->setSort("");
			$dbo_articulo->NombreFotoArti->setSort("");
			$dbo_articulo->Stock1_StkArti->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$dbo_articulo->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_articulo;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_articulo->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_articulo->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_articulo->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_articulo->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_articulo;

	// Call Recordset Selecting event
	$dbo_articulo->Recordset_Selecting($dbo_articulo->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_articulo->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_articulo->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_articulo;
	$sFilter = $dbo_articulo->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($dbo_articulo->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_articulo->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_articulo->CurrentFilter = $sFilter;
	$sSql = $dbo_articulo->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_articulo->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_articulo;
	$dbo_articulo->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$dbo_articulo->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
	$dbo_articulo->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
	$dbo_articulo->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
	$dbo_articulo->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
	$dbo_articulo->TasaIva->setDbValue($rs->fields('TasaIva'));
	$dbo_articulo->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
	$dbo_articulo->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
	$dbo_articulo->NombreFotoArti->setDbValue($rs->fields('NombreFotoArti'));
	$dbo_articulo->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_articulo;

	// Call Row Rendering event
	$dbo_articulo->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$dbo_articulo->CodInternoArti->CellCssStyle = "";
	$dbo_articulo->CodInternoArti->CellCssClass = "";

	// CodBarraArti
	$dbo_articulo->CodBarraArti->CellCssStyle = "";
	$dbo_articulo->CodBarraArti->CellCssClass = "";

	// DescrNivelInt4
	$dbo_articulo->DescrNivelInt4->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt4->CellCssClass = "";

	// DescrNivelInt3
	$dbo_articulo->DescrNivelInt3->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt3->CellCssClass = "";

	// DescrNivelInt2
	$dbo_articulo->DescrNivelInt2->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt2->CellCssClass = "";

	// TasaIva
	$dbo_articulo->TasaIva->CellCssStyle = "";
	$dbo_articulo->TasaIva->CellCssClass = "";

	// PrecioVta1_PreArti
	$dbo_articulo->PrecioVta1_PreArti->CellCssStyle = "";
	$dbo_articulo->PrecioVta1_PreArti->CellCssClass = "";

	// DescripcionArti
	$dbo_articulo->DescripcionArti->CellCssStyle = "";
	$dbo_articulo->DescripcionArti->CellCssClass = "";

	// NombreFotoArti
	$dbo_articulo->NombreFotoArti->CellCssStyle = "";
	$dbo_articulo->NombreFotoArti->CellCssClass = "";

	// Stock1_StkArti
	$dbo_articulo->Stock1_StkArti->CellCssStyle = "";
	$dbo_articulo->Stock1_StkArti->CellCssClass = "";
	if ($dbo_articulo->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		$dbo_articulo->CodInternoArti->ViewValue = $dbo_articulo->CodInternoArti->CurrentValue;
		$dbo_articulo->CodInternoArti->CssStyle = "";
		$dbo_articulo->CodInternoArti->CssClass = "";
		$dbo_articulo->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->ViewValue = $dbo_articulo->CodBarraArti->CurrentValue;
		$dbo_articulo->CodBarraArti->CssStyle = "";
		$dbo_articulo->CodBarraArti->CssClass = "";
		$dbo_articulo->CodBarraArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->ViewValue = $dbo_articulo->DescrNivelInt4->CurrentValue;
		$dbo_articulo->DescrNivelInt4->CssStyle = "";
		$dbo_articulo->DescrNivelInt4->CssClass = "";
		$dbo_articulo->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->ViewValue = $dbo_articulo->DescrNivelInt3->CurrentValue;
		$dbo_articulo->DescrNivelInt3->CssStyle = "";
		$dbo_articulo->DescrNivelInt3->CssClass = "";
		$dbo_articulo->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->ViewValue = $dbo_articulo->DescrNivelInt2->CurrentValue;
		$dbo_articulo->DescrNivelInt2->CssStyle = "";
		$dbo_articulo->DescrNivelInt2->CssClass = "";
		$dbo_articulo->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$dbo_articulo->TasaIva->ViewValue = $dbo_articulo->TasaIva->CurrentValue;
		$dbo_articulo->TasaIva->CssStyle = "";
		$dbo_articulo->TasaIva->CssClass = "";
		$dbo_articulo->TasaIva->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->ViewValue = $dbo_articulo->PrecioVta1_PreArti->CurrentValue;
		$dbo_articulo->PrecioVta1_PreArti->CssStyle = "";
		$dbo_articulo->PrecioVta1_PreArti->CssClass = "";
		$dbo_articulo->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->ViewValue = $dbo_articulo->DescripcionArti->CurrentValue;
		$dbo_articulo->DescripcionArti->CssStyle = "";
		$dbo_articulo->DescripcionArti->CssClass = "";
		$dbo_articulo->DescripcionArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->ViewValue = $dbo_articulo->NombreFotoArti->CurrentValue;
		$dbo_articulo->NombreFotoArti->CssStyle = "";
		$dbo_articulo->NombreFotoArti->CssClass = "";
		$dbo_articulo->NombreFotoArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->ViewValue = $dbo_articulo->Stock1_StkArti->CurrentValue;
		$dbo_articulo->Stock1_StkArti->CssStyle = "";
		$dbo_articulo->Stock1_StkArti->CssClass = "";
		$dbo_articulo->Stock1_StkArti->ViewCustomAttributes = "";

		// CodInternoArti
		$dbo_articulo->CodInternoArti->HrefValue = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->HrefValue = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->HrefValue = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->HrefValue = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->HrefValue = "";

		// TasaIva
		$dbo_articulo->TasaIva->HrefValue = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->HrefValue = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->HrefValue = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->HrefValue = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->HrefValue = "";
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_articulo->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_articulo;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_articulo;
	$sCsvStr = "";
	$rs = LoadRecordset();
	$nTotalRecs = $rs->RecordCount();
	$nStartRec = 1;

	// Export all
	if (defined("EW_EXPORT_ALL")) {
		$nStopRec = $nTotalRecs;
	} else { // Export 1 page only
		SetUpStartRec(); // Set Up Start Record Position

		// Set the last record to display
		if ($nDisplayRecs < 0) {
			$nStopRec = $nTotalRecs;
		} else {
			$nStopRec = $nStartRec + $nDisplayRecs - 1;
		}
	}
	if ($dbo_articulo->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_articulo->Export == "csv") {
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "CodBarraArti" . ",";
		$sCsvStr .= "DescrNivelInt4" . ",";
		$sCsvStr .= "DescrNivelInt3" . ",";
		$sCsvStr .= "DescrNivelInt2" . ",";
		$sCsvStr .= "TasaIva" . ",";
		$sCsvStr .= "PrecioVta1_PreArti" . ",";
		$sCsvStr .= "DescripcionArti" . ",";
		$sCsvStr .= "NombreFotoArti" . ",";
		$sCsvStr .= "Stock1_StkArti" . ",";
		$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
		$sCsvStr .= "\n";
	}

	// Move to first record directly for performance reason
	$nRecCount = $nStartRec - 1;
	if (!$rs->EOF) {
		$rs->MoveFirst();
		$rs->Move($nStartRec - 1);
	}
	while (!$rs->EOF && $nRecCount < $nStopRec) {
		$nRecCount++;
		if (intval($nRecCount) >= intval($nStartRec)) {
			LoadRowValues($rs);
			if ($dbo_articulo->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodInternoArti', $dbo_articulo->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('CodBarraArti', $dbo_articulo->CodBarraArti->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt4', $dbo_articulo->DescrNivelInt4->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt3', $dbo_articulo->DescrNivelInt3->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt2', $dbo_articulo->DescrNivelInt2->CurrentValue);
				$XmlDoc->AddField('TasaIva', $dbo_articulo->TasaIva->CurrentValue);
				$XmlDoc->AddField('PrecioVta1_PreArti', $dbo_articulo->PrecioVta1_PreArti->CurrentValue);
				$XmlDoc->AddField('DescripcionArti', $dbo_articulo->DescripcionArti->CurrentValue);
				$XmlDoc->AddField('NombreFotoArti', $dbo_articulo->NombreFotoArti->CurrentValue);
				$XmlDoc->AddField('Stock1_StkArti', $dbo_articulo->Stock1_StkArti->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_articulo->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->CodBarraArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt4->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt3->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt2->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->TasaIva->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->PrecioVta1_PreArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescripcionArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->NombreFotoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->Stock1_StkArti->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_articulo->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_articulo->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Page Load event
function Page_Load() {
    echo "<br /><ul><li>Recuerde que los datos modificados o ingresados en esta tabla serán eliminados la próxima vez que se ejecute el exportador.</li></ul>";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
