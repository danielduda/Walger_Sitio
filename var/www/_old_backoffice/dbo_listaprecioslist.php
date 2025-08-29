<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($dbo_listaprecios->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_listaprecios->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_listaprecios->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_listaprecios->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_listaprecios->Export == "csv") {
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
	$dbo_listaprecios->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$dbo_listaprecios->setStartRecordNumber($nStartRec);
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
$dbo_listaprecios->setSessionWhere($sFilter);
$dbo_listaprecios->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($dbo_listaprecios->Export == "xml" || $dbo_listaprecios->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$dbo_listaprecios->setReturnUrl("dbo_listaprecioslist.php");
?>
<?php include "header.php" ?>
<?php if ($dbo_listaprecios->Export == "") { ?>
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $dbo_listaprecios->Export <> "");
$bSelectLimit = ($dbo_listaprecios->Export == "" && $dbo_listaprecios->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $dbo_listaprecios->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Listas de precios (ISIS)
<?php if ($dbo_listaprecios->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_listaprecioslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_listaprecioslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_listaprecioslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_listaprecioslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_listaprecioslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($dbo_listaprecios->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($dbo_listaprecios->getBasicSearchType() == "") $dbo_listaprecios->setBasicSearchType("AND"); ?>

<form name="fdbo_listaprecioslistsrch" id="fdbo_listaprecioslistsrch" action="dbo_listaprecioslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbo_listaprecios->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="dbo_listaprecioslist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="dbo_listapreciossrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($dbo_listaprecios->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($dbo_listaprecios->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($dbo_listaprecios->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<form action="dbo_listaprecioslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_listaprecioslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fdbo_listaprecioslist" id="fdbo_listaprecioslist">
<?php if ($dbo_listaprecios->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_listapreciosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_listaprecioslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_listaprecioslist.action='dbo_listapreciosdelete.php';document.fdbo_listaprecioslist.encoding='application/x-www-form-urlencoded';document.fdbo_listaprecioslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_listaprecios->Export <> "") { ?>
ID
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('Regis_ListaPrec') ?>&ordertype=<?php echo $dbo_listaprecios->Regis_ListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID&nbsp;(*)<?php if ($dbo_listaprecios->Regis_ListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->Regis_ListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_listaprecios->Export <> "") { ?>
Código
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('CodigListaPrec') ?>&ordertype=<?php echo $dbo_listaprecios->CodigListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Código&nbsp;(*)<?php if ($dbo_listaprecios->CodigListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->CodigListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_listaprecios->Export <> "") { ?>
Descripción
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('DescrListaPrec') ?>&ordertype=<?php echo $dbo_listaprecios->DescrListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Descripción&nbsp;(*)<?php if ($dbo_listaprecios->DescrListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->DescrListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_listaprecios->Export <> "") { ?>
Regraba ?
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('RegrabaPrec') ?>&ordertype=<?php echo $dbo_listaprecios->RegrabaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Regraba ?&nbsp;(*)<?php if ($dbo_listaprecios->RegrabaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->RegrabaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_listaprecios->Export <> "") { ?>
Lista Madre
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('RegisListaMadre') ?>&ordertype=<?php echo $dbo_listaprecios->RegisListaMadre->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Lista Madre&nbsp;(*)<?php if ($dbo_listaprecios->RegisListaMadre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->RegisListaMadre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_listaprecios->Export <> "") { ?>
Variación Lista Madre
<?php } else { ?>
	<a href="dbo_listaprecioslist.php?order=<?php echo urlencode('VariacionListaPrec') ?>&ordertype=<?php echo $dbo_listaprecios->VariacionListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Variación Lista Madre&nbsp;(*)<?php if ($dbo_listaprecios->VariacionListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_listaprecios->VariacionListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($dbo_listaprecios->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $dbo_listaprecios->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbo_listaprecios->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$dbo_listaprecios->CssClass = "ewTableRow";
	$dbo_listaprecios->CssStyle = "";

	// Init row event
	$dbo_listaprecios->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$dbo_listaprecios->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$dbo_listaprecios->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $dbo_listaprecios->DisplayAttributes() ?>>
		<!-- Regis_ListaPrec -->
		<td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->Regis_ListaPrec->ViewValue ?></div>
</td>
		<!-- CodigListaPrec -->
		<td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->CodigListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->CodigListaPrec->ViewValue ?></div>
</td>
		<!-- DescrListaPrec -->
		<td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->DescrListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->DescrListaPrec->ViewValue ?></div>
</td>
		<!-- RegrabaPrec -->
		<td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegrabaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegrabaPrec->ViewValue ?></div>
</td>
		<!-- RegisListaMadre -->
		<td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegisListaMadre->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegisListaMadre->ViewValue ?></div>
</td>
		<!-- VariacionListaPrec -->
		<td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->VariacionListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->VariacionListaPrec->ViewValue ?></div>
</td>
<?php if ($dbo_listaprecios->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_listaprecios->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_listaprecios->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_listaprecios->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_listapreciosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_listaprecioslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_listaprecioslist.action='dbo_listapreciosdelete.php';document.fdbo_listaprecioslist.encoding='application/x-www-form-urlencoded';document.fdbo_listaprecioslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<form action="dbo_listaprecioslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_listaprecioslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_listaprecioslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<?php } ?>
<?php if ($dbo_listaprecios->Export == "") { ?>
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
	global $Security, $dbo_listaprecios;
	$sWhere = "";

	// Field Regis_ListaPrec
	BuildSearchSql($sWhere, $dbo_listaprecios->Regis_ListaPrec, @$_GET["x_Regis_ListaPrec"], @$_GET["z_Regis_ListaPrec"], @$_GET["v_Regis_ListaPrec"], @$_GET["y_Regis_ListaPrec"], @$_GET["w_Regis_ListaPrec"]);

	// Field CodigListaPrec
	BuildSearchSql($sWhere, $dbo_listaprecios->CodigListaPrec, @$_GET["x_CodigListaPrec"], @$_GET["z_CodigListaPrec"], @$_GET["v_CodigListaPrec"], @$_GET["y_CodigListaPrec"], @$_GET["w_CodigListaPrec"]);

	// Field DescrListaPrec
	BuildSearchSql($sWhere, $dbo_listaprecios->DescrListaPrec, @$_GET["x_DescrListaPrec"], @$_GET["z_DescrListaPrec"], @$_GET["v_DescrListaPrec"], @$_GET["y_DescrListaPrec"], @$_GET["w_DescrListaPrec"]);

	// Field RegrabaPrec
	BuildSearchSql($sWhere, $dbo_listaprecios->RegrabaPrec, @$_GET["x_RegrabaPrec"], @$_GET["z_RegrabaPrec"], @$_GET["v_RegrabaPrec"], @$_GET["y_RegrabaPrec"], @$_GET["w_RegrabaPrec"]);

	// Field RegisListaMadre
	BuildSearchSql($sWhere, $dbo_listaprecios->RegisListaMadre, @$_GET["x_RegisListaMadre"], @$_GET["z_RegisListaMadre"], @$_GET["v_RegisListaMadre"], @$_GET["y_RegisListaMadre"], @$_GET["w_RegisListaMadre"]);

	// Field VariacionListaPrec
	BuildSearchSql($sWhere, $dbo_listaprecios->VariacionListaPrec, @$_GET["x_VariacionListaPrec"], @$_GET["z_VariacionListaPrec"], @$_GET["v_VariacionListaPrec"], @$_GET["y_VariacionListaPrec"], @$_GET["w_VariacionListaPrec"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field Regis_ListaPrec
		SetSearchParm($dbo_listaprecios->Regis_ListaPrec, @$_GET["x_Regis_ListaPrec"], @$_GET["z_Regis_ListaPrec"], @$_GET["v_Regis_ListaPrec"], @$_GET["y_Regis_ListaPrec"], @$_GET["w_Regis_ListaPrec"]);

		// Field CodigListaPrec
		SetSearchParm($dbo_listaprecios->CodigListaPrec, @$_GET["x_CodigListaPrec"], @$_GET["z_CodigListaPrec"], @$_GET["v_CodigListaPrec"], @$_GET["y_CodigListaPrec"], @$_GET["w_CodigListaPrec"]);

		// Field DescrListaPrec
		SetSearchParm($dbo_listaprecios->DescrListaPrec, @$_GET["x_DescrListaPrec"], @$_GET["z_DescrListaPrec"], @$_GET["v_DescrListaPrec"], @$_GET["y_DescrListaPrec"], @$_GET["w_DescrListaPrec"]);

		// Field RegrabaPrec
		SetSearchParm($dbo_listaprecios->RegrabaPrec, @$_GET["x_RegrabaPrec"], @$_GET["z_RegrabaPrec"], @$_GET["v_RegrabaPrec"], @$_GET["y_RegrabaPrec"], @$_GET["w_RegrabaPrec"]);

		// Field RegisListaMadre
		SetSearchParm($dbo_listaprecios->RegisListaMadre, @$_GET["x_RegisListaMadre"], @$_GET["z_RegisListaMadre"], @$_GET["v_RegisListaMadre"], @$_GET["y_RegisListaMadre"], @$_GET["w_RegisListaMadre"]);

		// Field VariacionListaPrec
		SetSearchParm($dbo_listaprecios->VariacionListaPrec, @$_GET["x_VariacionListaPrec"], @$_GET["z_VariacionListaPrec"], @$_GET["v_VariacionListaPrec"], @$_GET["y_VariacionListaPrec"], @$_GET["w_VariacionListaPrec"]);
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
	global $dbo_listaprecios;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$dbo_listaprecios->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$dbo_listaprecios->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$dbo_listaprecios->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$dbo_listaprecios->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$dbo_listaprecios->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	if (is_numeric($sKeyword)) $sql .= "`Regis_ListaPrec` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`CodigListaPrec` = " . $sKeyword . " OR ";
	$sql .= "`DescrListaPrec` LIKE '%" . $sKeyword . "%' OR ";
	if (is_numeric($sKeyword)) $sql .= "`RegrabaPrec` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`RegisListaMadre` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`VariacionListaPrec` = " . $sKeyword . " OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $dbo_listaprecios;
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
		$dbo_listaprecios->setBasicSearchKeyword($sSearchKeyword);
		$dbo_listaprecios->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $dbo_listaprecios;
	$sSrchWhere = "";
	$dbo_listaprecios->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $dbo_listaprecios;
	$dbo_listaprecios->setBasicSearchKeyword("");
	$dbo_listaprecios->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $dbo_listaprecios;
	$dbo_listaprecios->setAdvancedSearch("x_Regis_ListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("z_Regis_ListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("x_CodigListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("z_CodigListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("x_DescrListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("z_DescrListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("x_RegrabaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("z_RegrabaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("x_RegisListaMadre", "");
	$dbo_listaprecios->setAdvancedSearch("z_RegisListaMadre", "");
	$dbo_listaprecios->setAdvancedSearch("x_VariacionListaPrec", "");
	$dbo_listaprecios->setAdvancedSearch("z_VariacionListaPrec", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $dbo_listaprecios;
	$sSrchWhere = $dbo_listaprecios->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $dbo_listaprecios;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$dbo_listaprecios->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$dbo_listaprecios->CurrentOrderType = @$_GET["ordertype"];

		// Field Regis_ListaPrec
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->Regis_ListaPrec, $bCtrl);

		// Field CodigListaPrec
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->CodigListaPrec, $bCtrl);

		// Field DescrListaPrec
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->DescrListaPrec, $bCtrl);

		// Field RegrabaPrec
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->RegrabaPrec, $bCtrl);

		// Field RegisListaMadre
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->RegisListaMadre, $bCtrl);

		// Field VariacionListaPrec
		$dbo_listaprecios->UpdateSort($dbo_listaprecios->VariacionListaPrec, $bCtrl);
		$dbo_listaprecios->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $dbo_listaprecios->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($dbo_listaprecios->SqlOrderBy() <> "") {
			$sOrderBy = $dbo_listaprecios->SqlOrderBy();
			$dbo_listaprecios->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $dbo_listaprecios;

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
			$dbo_listaprecios->setSessionOrderBy($sOrderBy);
			$dbo_listaprecios->Regis_ListaPrec->setSort("");
			$dbo_listaprecios->CodigListaPrec->setSort("");
			$dbo_listaprecios->DescrListaPrec->setSort("");
			$dbo_listaprecios->RegrabaPrec->setSort("");
			$dbo_listaprecios->RegisListaMadre->setSort("");
			$dbo_listaprecios->VariacionListaPrec->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_listaprecios;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_listaprecios->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_listaprecios->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_listaprecios->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_listaprecios;

	// Call Recordset Selecting event
	$dbo_listaprecios->Recordset_Selecting($dbo_listaprecios->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_listaprecios->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_listaprecios->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_listaprecios;
	$sFilter = $dbo_listaprecios->SqlKeyFilter();
	if (!is_numeric($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_ListaPrec@", ew_AdjustSql($dbo_listaprecios->Regis_ListaPrec->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_listaprecios->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_listaprecios->CurrentFilter = $sFilter;
	$sSql = $dbo_listaprecios->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_listaprecios->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_listaprecios->CodigListaPrec->setDbValue($rs->fields('CodigListaPrec'));
	$dbo_listaprecios->DescrListaPrec->setDbValue($rs->fields('DescrListaPrec'));
	$dbo_listaprecios->RegrabaPrec->setDbValue($rs->fields('RegrabaPrec'));
	$dbo_listaprecios->RegisListaMadre->setDbValue($rs->fields('RegisListaMadre'));
	$dbo_listaprecios->VariacionListaPrec->setDbValue($rs->fields('VariacionListaPrec'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_listaprecios;

	// Call Row Rendering event
	$dbo_listaprecios->Row_Rendering();

	// Common render codes for all row types
	// Regis_ListaPrec

	$dbo_listaprecios->Regis_ListaPrec->CellCssStyle = "";
	$dbo_listaprecios->Regis_ListaPrec->CellCssClass = "";

	// CodigListaPrec
	$dbo_listaprecios->CodigListaPrec->CellCssStyle = "";
	$dbo_listaprecios->CodigListaPrec->CellCssClass = "";

	// DescrListaPrec
	$dbo_listaprecios->DescrListaPrec->CellCssStyle = "";
	$dbo_listaprecios->DescrListaPrec->CellCssClass = "";

	// RegrabaPrec
	$dbo_listaprecios->RegrabaPrec->CellCssStyle = "";
	$dbo_listaprecios->RegrabaPrec->CellCssClass = "";

	// RegisListaMadre
	$dbo_listaprecios->RegisListaMadre->CellCssStyle = "";
	$dbo_listaprecios->RegisListaMadre->CellCssClass = "";

	// VariacionListaPrec
	$dbo_listaprecios->VariacionListaPrec->CellCssStyle = "";
	$dbo_listaprecios->VariacionListaPrec->CellCssClass = "";
	if ($dbo_listaprecios->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->ViewValue = $dbo_listaprecios->Regis_ListaPrec->CurrentValue;
		$dbo_listaprecios->Regis_ListaPrec->CssStyle = "";
		$dbo_listaprecios->Regis_ListaPrec->CssClass = "";
		$dbo_listaprecios->Regis_ListaPrec->ViewCustomAttributes = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->ViewValue = $dbo_listaprecios->CodigListaPrec->CurrentValue;
		$dbo_listaprecios->CodigListaPrec->CssStyle = "";
		$dbo_listaprecios->CodigListaPrec->CssClass = "";
		$dbo_listaprecios->CodigListaPrec->ViewCustomAttributes = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->ViewValue = $dbo_listaprecios->DescrListaPrec->CurrentValue;
		$dbo_listaprecios->DescrListaPrec->CssStyle = "";
		$dbo_listaprecios->DescrListaPrec->CssClass = "";
		$dbo_listaprecios->DescrListaPrec->ViewCustomAttributes = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->ViewValue = $dbo_listaprecios->RegrabaPrec->CurrentValue;
		$dbo_listaprecios->RegrabaPrec->CssStyle = "";
		$dbo_listaprecios->RegrabaPrec->CssClass = "";
		$dbo_listaprecios->RegrabaPrec->ViewCustomAttributes = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->ViewValue = $dbo_listaprecios->RegisListaMadre->CurrentValue;
		$dbo_listaprecios->RegisListaMadre->CssStyle = "";
		$dbo_listaprecios->RegisListaMadre->CssClass = "";
		$dbo_listaprecios->RegisListaMadre->ViewCustomAttributes = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->ViewValue = $dbo_listaprecios->VariacionListaPrec->CurrentValue;
		$dbo_listaprecios->VariacionListaPrec->CssStyle = "";
		$dbo_listaprecios->VariacionListaPrec->CssClass = "";
		$dbo_listaprecios->VariacionListaPrec->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->HrefValue = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->HrefValue = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->HrefValue = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->HrefValue = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->HrefValue = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->HrefValue = "";
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_listaprecios->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_listaprecios;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_listaprecios;
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
	if ($dbo_listaprecios->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_listaprecios->Export == "csv") {
		$sCsvStr .= "Regis_ListaPrec" . ",";
		$sCsvStr .= "CodigListaPrec" . ",";
		$sCsvStr .= "DescrListaPrec" . ",";
		$sCsvStr .= "RegrabaPrec" . ",";
		$sCsvStr .= "RegisListaMadre" . ",";
		$sCsvStr .= "VariacionListaPrec" . ",";
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
			if ($dbo_listaprecios->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_ListaPrec', $dbo_listaprecios->Regis_ListaPrec->CurrentValue);
				$XmlDoc->AddField('CodigListaPrec', $dbo_listaprecios->CodigListaPrec->CurrentValue);
				$XmlDoc->AddField('DescrListaPrec', $dbo_listaprecios->DescrListaPrec->CurrentValue);
				$XmlDoc->AddField('RegrabaPrec', $dbo_listaprecios->RegrabaPrec->CurrentValue);
				$XmlDoc->AddField('RegisListaMadre', $dbo_listaprecios->RegisListaMadre->CurrentValue);
				$XmlDoc->AddField('VariacionListaPrec', $dbo_listaprecios->VariacionListaPrec->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_listaprecios->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->CodigListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->DescrListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->RegrabaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->RegisListaMadre->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->VariacionListaPrec->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_listaprecios->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_listaprecios->Export == "csv") {
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
