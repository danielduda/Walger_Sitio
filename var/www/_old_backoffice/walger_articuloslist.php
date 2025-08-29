<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($walger_articulos->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_articulos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_articulos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_articulos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_articulos->Export == "csv") {
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
	$walger_articulos->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$walger_articulos->setStartRecordNumber($nStartRec);
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
$walger_articulos->setSessionWhere($sFilter);
$walger_articulos->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($walger_articulos->Export == "xml" || $walger_articulos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$walger_articulos->setReturnUrl("walger_articuloslist.php");
?>
<?php include "header.php" ?>
<?php if ($walger_articulos->Export == "") { ?>
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
<?php if ($walger_articulos->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $walger_articulos->Export <> "");
$bSelectLimit = ($walger_articulos->Export == "" && $walger_articulos->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $walger_articulos->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Artículos
<?php if ($walger_articulos->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_articuloslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_articuloslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_articuloslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_articuloslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_articuloslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($walger_articulos->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($walger_articulos->getBasicSearchType() == "") $walger_articulos->setBasicSearchType("AND"); ?>

<form name="fwalger_articuloslistsrch" id="fwalger_articuloslistsrch" action="walger_articuloslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($walger_articulos->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="walger_articuloslist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="walger_articulossrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($walger_articulos->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($walger_articulos->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($walger_articulos->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($walger_articulos->Export == "") { ?>
<form action="walger_articuloslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_articuloslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fwalger_articuloslist" id="fwalger_articuloslist">
<?php if ($walger_articulos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_articulosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_articuloslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_articuloslist.action='walger_articulosdelete.php';document.fwalger_articuloslist.encoding='application/x-www-form-urlencoded';document.fwalger_articuloslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_articulos->Export <> "") { ?>
Artículo
<?php } else { ?>
	<a href="walger_articuloslist.php?order=<?php echo urlencode('CodInternoArti') ?>&ordertype=<?php echo $walger_articulos->CodInternoArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Artículo<?php if ($walger_articulos->CodInternoArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_articulos->CodInternoArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_articulos->Export <> "") { ?>
Oferta ?
<?php } else { ?>
	<a href="walger_articuloslist.php?order=<?php echo urlencode('Oferta') ?>&ordertype=<?php echo $walger_articulos->Oferta->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Oferta ?<?php if ($walger_articulos->Oferta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_articulos->Oferta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_articulos->Export <> "") { ?>
Novedad ?
<?php } else { ?>
	<a href="walger_articuloslist.php?order=<?php echo urlencode('Novedad') ?>&ordertype=<?php echo $walger_articulos->Novedad->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Novedad ?<?php if ($walger_articulos->Novedad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_articulos->Novedad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($walger_articulos->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $walger_articulos->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$walger_articulos->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$walger_articulos->CssClass = "ewTableRow";
	$walger_articulos->CssStyle = "";

	// Init row event
	$walger_articulos->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$walger_articulos->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$walger_articulos->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $walger_articulos->DisplayAttributes() ?>>
		<!-- CodInternoArti -->
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $walger_articulos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_articulos->CodInternoArti->ViewValue ?></div>
</td>
		<!-- Oferta -->
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>>
<div<?php echo $walger_articulos->Oferta->ViewAttributes() ?>><?php echo $walger_articulos->Oferta->ViewValue ?></div>
</td>
		<!-- Novedad -->
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>>
<div<?php echo $walger_articulos->Novedad->ViewAttributes() ?>><?php echo $walger_articulos->Novedad->ViewValue ?></div>
</td>
<?php if ($walger_articulos->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_articulos->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_articulos->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_articulos->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($walger_articulos->CodInternoArti->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($walger_articulos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_articulosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_articuloslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_articuloslist.action='walger_articulosdelete.php';document.fwalger_articuloslist.encoding='application/x-www-form-urlencoded';document.fwalger_articuloslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_articulos->Export == "") { ?>
<form action="walger_articuloslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_articuloslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_articuloslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($walger_articulos->Export == "") { ?>
<?php } ?>
<?php if ($walger_articulos->Export == "") { ?>
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
	global $Security, $walger_articulos;
	$sWhere = "";

	// Field CodInternoArti
	BuildSearchSql($sWhere, $walger_articulos->CodInternoArti, @$_GET["x_CodInternoArti"], @$_GET["z_CodInternoArti"], @$_GET["v_CodInternoArti"], @$_GET["y_CodInternoArti"], @$_GET["w_CodInternoArti"]);

	// Field Oferta
	BuildSearchSql($sWhere, $walger_articulos->Oferta, @$_GET["x_Oferta"], @$_GET["z_Oferta"], @$_GET["v_Oferta"], @$_GET["y_Oferta"], @$_GET["w_Oferta"]);

	// Field Novedad
	BuildSearchSql($sWhere, $walger_articulos->Novedad, @$_GET["x_Novedad"], @$_GET["z_Novedad"], @$_GET["v_Novedad"], @$_GET["y_Novedad"], @$_GET["w_Novedad"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field CodInternoArti
		SetSearchParm($walger_articulos->CodInternoArti, @$_GET["x_CodInternoArti"], @$_GET["z_CodInternoArti"], @$_GET["v_CodInternoArti"], @$_GET["y_CodInternoArti"], @$_GET["w_CodInternoArti"]);

		// Field Oferta
		SetSearchParm($walger_articulos->Oferta, @$_GET["x_Oferta"], @$_GET["z_Oferta"], @$_GET["v_Oferta"], @$_GET["y_Oferta"], @$_GET["w_Oferta"]);

		// Field Novedad
		SetSearchParm($walger_articulos->Novedad, @$_GET["x_Novedad"], @$_GET["z_Novedad"], @$_GET["v_Novedad"], @$_GET["y_Novedad"], @$_GET["w_Novedad"]);
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
	global $walger_articulos;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$walger_articulos->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$walger_articulos->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$walger_articulos->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$walger_articulos->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$walger_articulos->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`CodInternoArti` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Oferta` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Novedad` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $walger_articulos;
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
		$walger_articulos->setBasicSearchKeyword($sSearchKeyword);
		$walger_articulos->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $walger_articulos;
	$sSrchWhere = "";
	$walger_articulos->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $walger_articulos;
	$walger_articulos->setBasicSearchKeyword("");
	$walger_articulos->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $walger_articulos;
	$walger_articulos->setAdvancedSearch("x_CodInternoArti", "");
	$walger_articulos->setAdvancedSearch("z_CodInternoArti", "");
	$walger_articulos->setAdvancedSearch("x_Oferta", "");
	$walger_articulos->setAdvancedSearch("z_Oferta", "");
	$walger_articulos->setAdvancedSearch("x_Novedad", "");
	$walger_articulos->setAdvancedSearch("z_Novedad", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $walger_articulos;
	$sSrchWhere = $walger_articulos->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
	global $walger_articulos;
	 $walger_articulos->CodInternoArti->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_CodInternoArti");
	 $walger_articulos->CodInternoArti->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_CodInternoArti");
	 $walger_articulos->Oferta->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_Oferta");
	 $walger_articulos->Oferta->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_Oferta");
	 $walger_articulos->Novedad->AdvancedSearch->SearchValue = $walger_articulos->getAdvancedSearch("x_Novedad");
	 $walger_articulos->Novedad->AdvancedSearch->SearchOperator = $walger_articulos->getAdvancedSearch("z_Novedad");
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $walger_articulos;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$walger_articulos->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$walger_articulos->CurrentOrderType = @$_GET["ordertype"];

		// Field CodInternoArti
		$walger_articulos->UpdateSort($walger_articulos->CodInternoArti, $bCtrl);

		// Field Oferta
		$walger_articulos->UpdateSort($walger_articulos->Oferta, $bCtrl);

		// Field Novedad
		$walger_articulos->UpdateSort($walger_articulos->Novedad, $bCtrl);
		$walger_articulos->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $walger_articulos->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($walger_articulos->SqlOrderBy() <> "") {
			$sOrderBy = $walger_articulos->SqlOrderBy();
			$walger_articulos->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $walger_articulos;

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
			$walger_articulos->setSessionOrderBy($sOrderBy);
			$walger_articulos->CodInternoArti->setSort("");
			$walger_articulos->Oferta->setSort("");
			$walger_articulos->Novedad->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$walger_articulos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_articulos;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_articulos->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_articulos->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_articulos->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_articulos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_articulos;

	// Call Recordset Selecting event
	$walger_articulos->Recordset_Selecting($walger_articulos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_articulos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_articulos->Recordset_Selected($rs);
	return $rs;
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

		// CodInternoArti
		if (!is_null($walger_articulos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_articulos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_articulos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_articulos->CodInternoArti->ViewValue = $walger_articulos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_articulos->CodInternoArti->ViewValue = NULL;
		}
		$walger_articulos->CodInternoArti->CssStyle = "";
		$walger_articulos->CodInternoArti->CssClass = "";
		$walger_articulos->CodInternoArti->ViewCustomAttributes = "";

		// Oferta
		if (!is_null($walger_articulos->Oferta->CurrentValue)) {
			switch ($walger_articulos->Oferta->CurrentValue) {
				case "S":
					$walger_articulos->Oferta->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Oferta->ViewValue = "No";
					break;
				default:
					$walger_articulos->Oferta->ViewValue = $walger_articulos->Oferta->CurrentValue;
			}
		} else {
			$walger_articulos->Oferta->ViewValue = NULL;
		}
		$walger_articulos->Oferta->CssStyle = "";
		$walger_articulos->Oferta->CssClass = "";
		$walger_articulos->Oferta->ViewCustomAttributes = "";

		// Novedad
		if (!is_null($walger_articulos->Novedad->CurrentValue)) {
			switch ($walger_articulos->Novedad->CurrentValue) {
				case "S":
					$walger_articulos->Novedad->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Novedad->ViewValue = "No";
					break;
				default:
					$walger_articulos->Novedad->ViewValue = $walger_articulos->Novedad->CurrentValue;
			}
		} else {
			$walger_articulos->Novedad->ViewValue = NULL;
		}
		$walger_articulos->Novedad->CssStyle = "";
		$walger_articulos->Novedad->CssClass = "";
		$walger_articulos->Novedad->ViewCustomAttributes = "";

		// CodInternoArti
		$walger_articulos->CodInternoArti->HrefValue = "";

		// Oferta
		$walger_articulos->Oferta->HrefValue = "";

		// Novedad
		$walger_articulos->Novedad->HrefValue = "";
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_articulos->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_articulos;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_articulos;
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
	if ($walger_articulos->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_articulos->Export == "csv") {
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "Oferta" . ",";
		$sCsvStr .= "Novedad" . ",";
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
			if ($walger_articulos->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodInternoArti', $walger_articulos->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('Oferta', $walger_articulos->Oferta->CurrentValue);
				$XmlDoc->AddField('Novedad', $walger_articulos->Novedad->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_articulos->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->Oferta->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->Novedad->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_articulos->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_articulos->Export == "csv") {
		echo $sCsvStr;
	}
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
