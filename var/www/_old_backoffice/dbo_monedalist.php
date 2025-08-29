<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_moneda', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_monedainfo.php" ?>
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
$dbo_moneda->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_moneda->Export; // Get export parameter, used in header
$sExportFile = $dbo_moneda->TableVar; // Get export file, used in header
?>
<?php
if ($dbo_moneda->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_moneda->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_moneda->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_moneda->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_moneda->Export == "csv") {
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
	$dbo_moneda->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$dbo_moneda->setStartRecordNumber($nStartRec);
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
$dbo_moneda->setSessionWhere($sFilter);
$dbo_moneda->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($dbo_moneda->Export == "xml" || $dbo_moneda->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$dbo_moneda->setReturnUrl("dbo_monedalist.php");
?>
<?php include "header.php" ?>
<?php if ($dbo_moneda->Export == "") { ?>
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
<?php if ($dbo_moneda->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $dbo_moneda->Export <> "");
$bSelectLimit = ($dbo_moneda->Export == "" && $dbo_moneda->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $dbo_moneda->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Monedas (ISIS)
<?php if ($dbo_moneda->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_monedalist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_monedalist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_monedalist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_monedalist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_monedalist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($dbo_moneda->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($dbo_moneda->getBasicSearchType() == "") $dbo_moneda->setBasicSearchType("AND"); ?>

<form name="fdbo_monedalistsrch" id="fdbo_monedalistsrch" action="dbo_monedalist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbo_moneda->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="dbo_monedalist.php?cmd=reset">Mostrar todos</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($dbo_moneda->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($dbo_moneda->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($dbo_moneda->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($dbo_moneda->Export == "") { ?>
<form action="dbo_monedalist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_monedalist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fdbo_monedalist" id="fdbo_monedalist">
<?php if ($dbo_moneda->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_monedaadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_monedalist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_monedalist.action='dbo_monedadelete.php';document.fdbo_monedalist.encoding='application/x-www-form-urlencoded';document.fdbo_monedalist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_moneda->Export <> "") { ?>
ID
<?php } else { ?>
	<a href="dbo_monedalist.php?order=<?php echo urlencode('Regis_Mda') ?>&ordertype=<?php echo $dbo_moneda->Regis_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID<?php if ($dbo_moneda->Regis_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_moneda->Regis_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_moneda->Export <> "") { ?>
Descripción
<?php } else { ?>
	<a href="dbo_monedalist.php?order=<?php echo urlencode('Descr_Mda') ?>&ordertype=<?php echo $dbo_moneda->Descr_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Descripción&nbsp;(*)<?php if ($dbo_moneda->Descr_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_moneda->Descr_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_moneda->Export <> "") { ?>
Signo
<?php } else { ?>
	<a href="dbo_monedalist.php?order=<?php echo urlencode('Signo_Mda') ?>&ordertype=<?php echo $dbo_moneda->Signo_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Signo&nbsp;(*)<?php if ($dbo_moneda->Signo_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_moneda->Signo_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_moneda->Export <> "") { ?>
Cotización
<?php } else { ?>
	<a href="dbo_monedalist.php?order=<?php echo urlencode('Cotiz_Mda') ?>&ordertype=<?php echo $dbo_moneda->Cotiz_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Cotización<?php if ($dbo_moneda->Cotiz_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_moneda->Cotiz_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_moneda->Export <> "") { ?>
Código AFIP
<?php } else { ?>
	<a href="dbo_monedalist.php?order=<?php echo urlencode('CodigoAFIP_Mda') ?>&ordertype=<?php echo $dbo_moneda->CodigoAFIP_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Código AFIP&nbsp;(*)<?php if ($dbo_moneda->CodigoAFIP_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_moneda->CodigoAFIP_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($dbo_moneda->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $dbo_moneda->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbo_moneda->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$dbo_moneda->CssClass = "ewTableRow";
	$dbo_moneda->CssStyle = "";

	// Init row event
	$dbo_moneda->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$dbo_moneda->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$dbo_moneda->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $dbo_moneda->DisplayAttributes() ?>>
		<!-- Regis_Mda -->
		<td<?php echo $dbo_moneda->Regis_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Regis_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Regis_Mda->ViewValue ?></div>
</td>
		<!-- Descr_Mda -->
		<td<?php echo $dbo_moneda->Descr_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Descr_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Descr_Mda->ViewValue ?></div>
</td>
		<!-- Signo_Mda -->
		<td<?php echo $dbo_moneda->Signo_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Signo_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Signo_Mda->ViewValue ?></div>
</td>
		<!-- Cotiz_Mda -->
		<td<?php echo $dbo_moneda->Cotiz_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Cotiz_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Cotiz_Mda->ViewValue ?></div>
</td>
		<!-- CodigoAFIP_Mda -->
		<td<?php echo $dbo_moneda->CodigoAFIP_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->CodigoAFIP_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->CodigoAFIP_Mda->ViewValue ?></div>
</td>
<?php if ($dbo_moneda->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_moneda->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_moneda->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_moneda->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($dbo_moneda->Regis_Mda->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($dbo_moneda->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_monedaadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_monedalist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_monedalist.action='dbo_monedadelete.php';document.fdbo_monedalist.encoding='application/x-www-form-urlencoded';document.fdbo_monedalist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_moneda->Export == "") { ?>
<form action="dbo_monedalist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_monedalist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_monedalist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($dbo_moneda->Export == "") { ?>
<?php } ?>
<?php if ($dbo_moneda->Export == "") { ?>
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

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`Descr_Mda` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Signo_Mda` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`CodigoAFIP_Mda` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $dbo_moneda;
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
		$dbo_moneda->setBasicSearchKeyword($sSearchKeyword);
		$dbo_moneda->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $dbo_moneda;
	$sSrchWhere = "";
	$dbo_moneda->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $dbo_moneda;
	$dbo_moneda->setBasicSearchKeyword("");
	$dbo_moneda->setBasicSearchType("");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $dbo_moneda;
	$sSrchWhere = $dbo_moneda->getSearchWhere();
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $dbo_moneda;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$dbo_moneda->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$dbo_moneda->CurrentOrderType = @$_GET["ordertype"];

		// Field Regis_Mda
		$dbo_moneda->UpdateSort($dbo_moneda->Regis_Mda, $bCtrl);

		// Field Descr_Mda
		$dbo_moneda->UpdateSort($dbo_moneda->Descr_Mda, $bCtrl);

		// Field Signo_Mda
		$dbo_moneda->UpdateSort($dbo_moneda->Signo_Mda, $bCtrl);

		// Field Cotiz_Mda
		$dbo_moneda->UpdateSort($dbo_moneda->Cotiz_Mda, $bCtrl);

		// Field CodigoAFIP_Mda
		$dbo_moneda->UpdateSort($dbo_moneda->CodigoAFIP_Mda, $bCtrl);
		$dbo_moneda->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $dbo_moneda->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($dbo_moneda->SqlOrderBy() <> "") {
			$sOrderBy = $dbo_moneda->SqlOrderBy();
			$dbo_moneda->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $dbo_moneda;

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
			$dbo_moneda->setSessionOrderBy($sOrderBy);
			$dbo_moneda->Regis_Mda->setSort("");
			$dbo_moneda->Descr_Mda->setSort("");
			$dbo_moneda->Signo_Mda->setSort("");
			$dbo_moneda->Cotiz_Mda->setSort("");
			$dbo_moneda->CodigoAFIP_Mda->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$dbo_moneda->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_moneda;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_moneda->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_moneda->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_moneda->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_moneda->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_moneda;

	// Call Recordset Selecting event
	$dbo_moneda->Recordset_Selecting($dbo_moneda->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_moneda->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_moneda->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_moneda;
	$sFilter = $dbo_moneda->SqlKeyFilter();
	if (!is_numeric($dbo_moneda->Regis_Mda->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_Mda@", ew_AdjustSql($dbo_moneda->Regis_Mda->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_moneda->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_moneda->CurrentFilter = $sFilter;
	$sSql = $dbo_moneda->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_moneda->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$dbo_moneda->Descr_Mda->setDbValue($rs->fields('Descr_Mda'));
	$dbo_moneda->Signo_Mda->setDbValue($rs->fields('Signo_Mda'));
	$dbo_moneda->Cotiz_Mda->setDbValue($rs->fields('Cotiz_Mda'));
	$dbo_moneda->CodigoAFIP_Mda->setDbValue($rs->fields('CodigoAFIP_Mda'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_moneda;

	// Call Row Rendering event
	$dbo_moneda->Row_Rendering();

	// Common render codes for all row types
	// Regis_Mda

	$dbo_moneda->Regis_Mda->CellCssStyle = "";
	$dbo_moneda->Regis_Mda->CellCssClass = "";

	// Descr_Mda
	$dbo_moneda->Descr_Mda->CellCssStyle = "";
	$dbo_moneda->Descr_Mda->CellCssClass = "";

	// Signo_Mda
	$dbo_moneda->Signo_Mda->CellCssStyle = "";
	$dbo_moneda->Signo_Mda->CellCssClass = "";

	// Cotiz_Mda
	$dbo_moneda->Cotiz_Mda->CellCssStyle = "";
	$dbo_moneda->Cotiz_Mda->CellCssClass = "";

	// CodigoAFIP_Mda
	$dbo_moneda->CodigoAFIP_Mda->CellCssStyle = "";
	$dbo_moneda->CodigoAFIP_Mda->CellCssClass = "";
	if ($dbo_moneda->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_Mda
		$dbo_moneda->Regis_Mda->ViewValue = $dbo_moneda->Regis_Mda->CurrentValue;
		$dbo_moneda->Regis_Mda->CssStyle = "";
		$dbo_moneda->Regis_Mda->CssClass = "";
		$dbo_moneda->Regis_Mda->ViewCustomAttributes = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->ViewValue = $dbo_moneda->Descr_Mda->CurrentValue;
		$dbo_moneda->Descr_Mda->CssStyle = "";
		$dbo_moneda->Descr_Mda->CssClass = "";
		$dbo_moneda->Descr_Mda->ViewCustomAttributes = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->ViewValue = $dbo_moneda->Signo_Mda->CurrentValue;
		$dbo_moneda->Signo_Mda->CssStyle = "";
		$dbo_moneda->Signo_Mda->CssClass = "";
		$dbo_moneda->Signo_Mda->ViewCustomAttributes = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->ViewValue = $dbo_moneda->Cotiz_Mda->CurrentValue;
		$dbo_moneda->Cotiz_Mda->CssStyle = "";
		$dbo_moneda->Cotiz_Mda->CssClass = "";
		$dbo_moneda->Cotiz_Mda->ViewCustomAttributes = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->ViewValue = $dbo_moneda->CodigoAFIP_Mda->CurrentValue;
		$dbo_moneda->CodigoAFIP_Mda->CssStyle = "";
		$dbo_moneda->CodigoAFIP_Mda->CssClass = "";
		$dbo_moneda->CodigoAFIP_Mda->ViewCustomAttributes = "";

		// Regis_Mda
		$dbo_moneda->Regis_Mda->HrefValue = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->HrefValue = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->HrefValue = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->HrefValue = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->HrefValue = "";
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_moneda->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_moneda;
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
	if ($dbo_moneda->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_moneda->Export == "csv") {
		$sCsvStr .= "Regis_Mda" . ",";
		$sCsvStr .= "Descr_Mda" . ",";
		$sCsvStr .= "Signo_Mda" . ",";
		$sCsvStr .= "Cotiz_Mda" . ",";
		$sCsvStr .= "CodigoAFIP_Mda" . ",";
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
			if ($dbo_moneda->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_Mda', $dbo_moneda->Regis_Mda->CurrentValue);
				$XmlDoc->AddField('Descr_Mda', $dbo_moneda->Descr_Mda->CurrentValue);
				$XmlDoc->AddField('Signo_Mda', $dbo_moneda->Signo_Mda->CurrentValue);
				$XmlDoc->AddField('Cotiz_Mda', $dbo_moneda->Cotiz_Mda->CurrentValue);
				$XmlDoc->AddField('CodigoAFIP_Mda', $dbo_moneda->CodigoAFIP_Mda->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_moneda->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Regis_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Descr_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Signo_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Cotiz_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->CodigoAFIP_Mda->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_moneda->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_moneda->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Page Load event
function Page_Load() {

	//echo "Page Load";
    echo "<br /><ul><li>Recuerde que los datos modificados o ingresados en esta tabla serán eliminados la próxima vez que se ejecute el exportador.</li></ul>";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
