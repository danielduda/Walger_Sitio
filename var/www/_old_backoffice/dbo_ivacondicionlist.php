<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($dbo_ivacondicion->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_ivacondicion->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_ivacondicion->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_ivacondicion->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_ivacondicion->Export == "csv") {
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
	$dbo_ivacondicion->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$dbo_ivacondicion->setStartRecordNumber($nStartRec);
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
$dbo_ivacondicion->setSessionWhere($sFilter);
$dbo_ivacondicion->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($dbo_ivacondicion->Export == "xml" || $dbo_ivacondicion->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$dbo_ivacondicion->setReturnUrl("dbo_ivacondicionlist.php");
?>
<?php include "header.php" ?>
<?php if ($dbo_ivacondicion->Export == "") { ?>
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $dbo_ivacondicion->Export <> "");
$bSelectLimit = ($dbo_ivacondicion->Export == "" && $dbo_ivacondicion->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $dbo_ivacondicion->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Condiciones IVA (ISIS)
<?php if ($dbo_ivacondicion->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_ivacondicionlist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionlist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionlist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionlist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionlist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($dbo_ivacondicion->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($dbo_ivacondicion->getBasicSearchType() == "") $dbo_ivacondicion->setBasicSearchType("AND"); ?>

<form name="fdbo_ivacondicionlistsrch" id="fdbo_ivacondicionlistsrch" action="dbo_ivacondicionlist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbo_ivacondicion->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="dbo_ivacondicionlist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="dbo_ivacondicionsrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($dbo_ivacondicion->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($dbo_ivacondicion->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($dbo_ivacondicion->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<form action="dbo_ivacondicionlist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_ivacondicionlist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fdbo_ivacondicionlist" id="fdbo_ivacondicionlist">
<?php if ($dbo_ivacondicion->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_ivacondicionadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_ivacondicionlist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_ivacondicionlist.action='dbo_ivacondiciondelete.php';document.fdbo_ivacondicionlist.encoding='application/x-www-form-urlencoded';document.fdbo_ivacondicionlist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_ivacondicion->Export <> "") { ?>
ID
<?php } else { ?>
	<a href="dbo_ivacondicionlist.php?order=<?php echo urlencode('Regis_IvaC') ?>&ordertype=<?php echo $dbo_ivacondicion->Regis_IvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID&nbsp;(*)<?php if ($dbo_ivacondicion->Regis_IvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_ivacondicion->Regis_IvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_ivacondicion->Export <> "") { ?>
Descripción
<?php } else { ?>
	<a href="dbo_ivacondicionlist.php?order=<?php echo urlencode('DescrIvaC') ?>&ordertype=<?php echo $dbo_ivacondicion->DescrIvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Descripción&nbsp;(*)<?php if ($dbo_ivacondicion->DescrIvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_ivacondicion->DescrIvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_ivacondicion->Export <> "") { ?>
Calcula Iva ?
<?php } else { ?>
	<a href="dbo_ivacondicionlist.php?order=<?php echo urlencode('CalculaIvaC') ?>&ordertype=<?php echo $dbo_ivacondicion->CalculaIvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Calcula Iva ?&nbsp;(*)<?php if ($dbo_ivacondicion->CalculaIvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_ivacondicion->CalculaIvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_ivacondicion->Export <> "") { ?>
Discrimina Iva ?
<?php } else { ?>
	<a href="dbo_ivacondicionlist.php?order=<?php echo urlencode('DiscriminaIvaC') ?>&ordertype=<?php echo $dbo_ivacondicion->DiscriminaIvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Discrimina Iva ?&nbsp;(*)<?php if ($dbo_ivacondicion->DiscriminaIvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_ivacondicion->DiscriminaIvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($dbo_ivacondicion->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $dbo_ivacondicion->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbo_ivacondicion->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$dbo_ivacondicion->CssClass = "ewTableRow";
	$dbo_ivacondicion->CssStyle = "";

	// Init row event
	$dbo_ivacondicion->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$dbo_ivacondicion->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$dbo_ivacondicion->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $dbo_ivacondicion->DisplayAttributes() ?>>
		<!-- Regis_IvaC -->
		<td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->Regis_IvaC->ViewValue ?></div>
</td>
		<!-- DescrIvaC -->
		<td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DescrIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DescrIvaC->ViewValue ?></div>
</td>
		<!-- CalculaIvaC -->
		<td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->CalculaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->CalculaIvaC->ViewValue ?></div>
</td>
		<!-- DiscriminaIvaC -->
		<td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewValue ?></div>
</td>
<?php if ($dbo_ivacondicion->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_ivacondicion->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_ivacondicion->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_ivacondicion->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_ivacondicionadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_ivacondicionlist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_ivacondicionlist.action='dbo_ivacondiciondelete.php';document.fdbo_ivacondicionlist.encoding='application/x-www-form-urlencoded';document.fdbo_ivacondicionlist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<form action="dbo_ivacondicionlist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_ivacondicionlist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_ivacondicionlist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<?php } ?>
<?php if ($dbo_ivacondicion->Export == "") { ?>
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
	global $Security, $dbo_ivacondicion;
	$sWhere = "";

	// Field Regis_IvaC
	BuildSearchSql($sWhere, $dbo_ivacondicion->Regis_IvaC, @$_GET["x_Regis_IvaC"], @$_GET["z_Regis_IvaC"], @$_GET["v_Regis_IvaC"], @$_GET["y_Regis_IvaC"], @$_GET["w_Regis_IvaC"]);

	// Field DescrIvaC
	BuildSearchSql($sWhere, $dbo_ivacondicion->DescrIvaC, @$_GET["x_DescrIvaC"], @$_GET["z_DescrIvaC"], @$_GET["v_DescrIvaC"], @$_GET["y_DescrIvaC"], @$_GET["w_DescrIvaC"]);

	// Field CalculaIvaC
	BuildSearchSql($sWhere, $dbo_ivacondicion->CalculaIvaC, @$_GET["x_CalculaIvaC"], @$_GET["z_CalculaIvaC"], @$_GET["v_CalculaIvaC"], @$_GET["y_CalculaIvaC"], @$_GET["w_CalculaIvaC"]);

	// Field DiscriminaIvaC
	BuildSearchSql($sWhere, $dbo_ivacondicion->DiscriminaIvaC, @$_GET["x_DiscriminaIvaC"], @$_GET["z_DiscriminaIvaC"], @$_GET["v_DiscriminaIvaC"], @$_GET["y_DiscriminaIvaC"], @$_GET["w_DiscriminaIvaC"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field Regis_IvaC
		SetSearchParm($dbo_ivacondicion->Regis_IvaC, @$_GET["x_Regis_IvaC"], @$_GET["z_Regis_IvaC"], @$_GET["v_Regis_IvaC"], @$_GET["y_Regis_IvaC"], @$_GET["w_Regis_IvaC"]);

		// Field DescrIvaC
		SetSearchParm($dbo_ivacondicion->DescrIvaC, @$_GET["x_DescrIvaC"], @$_GET["z_DescrIvaC"], @$_GET["v_DescrIvaC"], @$_GET["y_DescrIvaC"], @$_GET["w_DescrIvaC"]);

		// Field CalculaIvaC
		SetSearchParm($dbo_ivacondicion->CalculaIvaC, @$_GET["x_CalculaIvaC"], @$_GET["z_CalculaIvaC"], @$_GET["v_CalculaIvaC"], @$_GET["y_CalculaIvaC"], @$_GET["w_CalculaIvaC"]);

		// Field DiscriminaIvaC
		SetSearchParm($dbo_ivacondicion->DiscriminaIvaC, @$_GET["x_DiscriminaIvaC"], @$_GET["z_DiscriminaIvaC"], @$_GET["v_DiscriminaIvaC"], @$_GET["y_DiscriminaIvaC"], @$_GET["w_DiscriminaIvaC"]);
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
	global $dbo_ivacondicion;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$dbo_ivacondicion->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$dbo_ivacondicion->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$dbo_ivacondicion->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$dbo_ivacondicion->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$dbo_ivacondicion->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	if (is_numeric($sKeyword)) $sql .= "`Regis_IvaC` = " . $sKeyword . " OR ";
	$sql .= "`DescrIvaC` LIKE '%" . $sKeyword . "%' OR ";
	if (is_numeric($sKeyword)) $sql .= "`CalculaIvaC` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`DiscriminaIvaC` = " . $sKeyword . " OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $dbo_ivacondicion;
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
		$dbo_ivacondicion->setBasicSearchKeyword($sSearchKeyword);
		$dbo_ivacondicion->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $dbo_ivacondicion;
	$sSrchWhere = "";
	$dbo_ivacondicion->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $dbo_ivacondicion;
	$dbo_ivacondicion->setBasicSearchKeyword("");
	$dbo_ivacondicion->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $dbo_ivacondicion;
	$dbo_ivacondicion->setAdvancedSearch("x_Regis_IvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("z_Regis_IvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("x_DescrIvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("z_DescrIvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("x_CalculaIvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("z_CalculaIvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("x_DiscriminaIvaC", "");
	$dbo_ivacondicion->setAdvancedSearch("z_DiscriminaIvaC", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $dbo_ivacondicion;
	$sSrchWhere = $dbo_ivacondicion->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $dbo_ivacondicion;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$dbo_ivacondicion->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$dbo_ivacondicion->CurrentOrderType = @$_GET["ordertype"];

		// Field Regis_IvaC
		$dbo_ivacondicion->UpdateSort($dbo_ivacondicion->Regis_IvaC, $bCtrl);

		// Field DescrIvaC
		$dbo_ivacondicion->UpdateSort($dbo_ivacondicion->DescrIvaC, $bCtrl);

		// Field CalculaIvaC
		$dbo_ivacondicion->UpdateSort($dbo_ivacondicion->CalculaIvaC, $bCtrl);

		// Field DiscriminaIvaC
		$dbo_ivacondicion->UpdateSort($dbo_ivacondicion->DiscriminaIvaC, $bCtrl);
		$dbo_ivacondicion->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $dbo_ivacondicion->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($dbo_ivacondicion->SqlOrderBy() <> "") {
			$sOrderBy = $dbo_ivacondicion->SqlOrderBy();
			$dbo_ivacondicion->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $dbo_ivacondicion;

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
			$dbo_ivacondicion->setSessionOrderBy($sOrderBy);
			$dbo_ivacondicion->Regis_IvaC->setSort("");
			$dbo_ivacondicion->DescrIvaC->setSort("");
			$dbo_ivacondicion->CalculaIvaC->setSort("");
			$dbo_ivacondicion->DiscriminaIvaC->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_ivacondicion;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_ivacondicion->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_ivacondicion->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_ivacondicion->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_ivacondicion;

	// Call Recordset Selecting event
	$dbo_ivacondicion->Recordset_Selecting($dbo_ivacondicion->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_ivacondicion->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_ivacondicion->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_ivacondicion;
	$sFilter = $dbo_ivacondicion->SqlKeyFilter();
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_IvaC@", ew_AdjustSql($dbo_ivacondicion->Regis_IvaC->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_ivacondicion->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_ivacondicion->CurrentFilter = $sFilter;
	$sSql = $dbo_ivacondicion->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_ivacondicion->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_ivacondicion->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
	$dbo_ivacondicion->CalculaIvaC->setDbValue($rs->fields('CalculaIvaC'));
	$dbo_ivacondicion->DiscriminaIvaC->setDbValue($rs->fields('DiscriminaIvaC'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_ivacondicion;

	// Call Row Rendering event
	$dbo_ivacondicion->Row_Rendering();

	// Common render codes for all row types
	// Regis_IvaC

	$dbo_ivacondicion->Regis_IvaC->CellCssStyle = "";
	$dbo_ivacondicion->Regis_IvaC->CellCssClass = "";

	// DescrIvaC
	$dbo_ivacondicion->DescrIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DescrIvaC->CellCssClass = "";

	// CalculaIvaC
	$dbo_ivacondicion->CalculaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->CalculaIvaC->CellCssClass = "";

	// DiscriminaIvaC
	$dbo_ivacondicion->DiscriminaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DiscriminaIvaC->CellCssClass = "";
	if ($dbo_ivacondicion->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->ViewValue = $dbo_ivacondicion->Regis_IvaC->CurrentValue;
		$dbo_ivacondicion->Regis_IvaC->CssStyle = "";
		$dbo_ivacondicion->Regis_IvaC->CssClass = "";
		$dbo_ivacondicion->Regis_IvaC->ViewCustomAttributes = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->ViewValue = $dbo_ivacondicion->DescrIvaC->CurrentValue;
		$dbo_ivacondicion->DescrIvaC->CssStyle = "";
		$dbo_ivacondicion->DescrIvaC->CssClass = "";
		$dbo_ivacondicion->DescrIvaC->ViewCustomAttributes = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->ViewValue = $dbo_ivacondicion->CalculaIvaC->CurrentValue;
		$dbo_ivacondicion->CalculaIvaC->CssStyle = "";
		$dbo_ivacondicion->CalculaIvaC->CssClass = "";
		$dbo_ivacondicion->CalculaIvaC->ViewCustomAttributes = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->ViewValue = $dbo_ivacondicion->DiscriminaIvaC->CurrentValue;
		$dbo_ivacondicion->DiscriminaIvaC->CssStyle = "";
		$dbo_ivacondicion->DiscriminaIvaC->CssClass = "";
		$dbo_ivacondicion->DiscriminaIvaC->ViewCustomAttributes = "";

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->HrefValue = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->HrefValue = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->HrefValue = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->HrefValue = "";
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_ivacondicion->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_ivacondicion;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_ivacondicion;
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
	if ($dbo_ivacondicion->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_ivacondicion->Export == "csv") {
		$sCsvStr .= "Regis_IvaC" . ",";
		$sCsvStr .= "DescrIvaC" . ",";
		$sCsvStr .= "CalculaIvaC" . ",";
		$sCsvStr .= "DiscriminaIvaC" . ",";
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
			if ($dbo_ivacondicion->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_IvaC', $dbo_ivacondicion->Regis_IvaC->CurrentValue);
				$XmlDoc->AddField('DescrIvaC', $dbo_ivacondicion->DescrIvaC->CurrentValue);
				$XmlDoc->AddField('CalculaIvaC', $dbo_ivacondicion->CalculaIvaC->CurrentValue);
				$XmlDoc->AddField('DiscriminaIvaC', $dbo_ivacondicion->DiscriminaIvaC->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_ivacondicion->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->Regis_IvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->DescrIvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->CalculaIvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->DiscriminaIvaC->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_ivacondicion->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_ivacondicion->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Page Load event
function Page_Load() {
    echo "<br /><ul><li>Recuerde que los datos modificados o ingresados serán eliminados la próxima vez que se ejecute el exportador.</li></ul>";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
