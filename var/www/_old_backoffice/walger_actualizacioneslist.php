<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_actualizaciones', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_actualizacionesinfo.php" ?>
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
$walger_actualizaciones->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_actualizaciones->Export; // Get export parameter, used in header
$sExportFile = $walger_actualizaciones->TableVar; // Get export file, used in header
?>
<?php
if ($walger_actualizaciones->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_actualizaciones->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_actualizaciones->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_actualizaciones->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_actualizaciones->Export == "csv") {
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
	$walger_actualizaciones->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$walger_actualizaciones->setStartRecordNumber($nStartRec);
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
$walger_actualizaciones->setSessionWhere($sFilter);
$walger_actualizaciones->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($walger_actualizaciones->Export == "xml" || $walger_actualizaciones->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$walger_actualizaciones->setReturnUrl("walger_actualizacioneslist.php");
?>
<?php include "header.php" ?>
<?php if ($walger_actualizaciones->Export == "") { ?>
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $walger_actualizaciones->Export <> "");
$bSelectLimit = ($walger_actualizaciones->Export == "" && $walger_actualizaciones->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $walger_actualizaciones->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Actualizaciones
<?php if ($walger_actualizaciones->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_actualizacioneslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_actualizacioneslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_actualizacioneslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_actualizacioneslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_actualizacioneslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($walger_actualizaciones->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($walger_actualizaciones->getBasicSearchType() == "") $walger_actualizaciones->setBasicSearchType("AND"); ?>

<form name="fwalger_actualizacioneslistsrch" id="fwalger_actualizacioneslistsrch" action="walger_actualizacioneslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($walger_actualizaciones->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="walger_actualizacioneslist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="walger_actualizacionessrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($walger_actualizaciones->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($walger_actualizaciones->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($walger_actualizaciones->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<form action="walger_actualizacioneslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_actualizacioneslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fwalger_actualizacioneslist" id="fwalger_actualizacioneslist">
<?php if ($walger_actualizaciones->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_actualizacionesadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_actualizacioneslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_actualizacioneslist.action='walger_actualizacionesdelete.php';document.fwalger_actualizacioneslist.encoding='application/x-www-form-urlencoded';document.fwalger_actualizacioneslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_actualizaciones->Export <> "") { ?>
Fecha
<?php } else { ?>
	<a href="walger_actualizacioneslist.php?order=<?php echo urlencode('fecha') ?>&ordertype=<?php echo $walger_actualizaciones->fecha->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Fecha<?php if ($walger_actualizaciones->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_actualizaciones->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_actualizaciones->Export <> "") { ?>
Pendiente ?
<?php } else { ?>
	<a href="walger_actualizacioneslist.php?order=<?php echo urlencode('pendiente') ?>&ordertype=<?php echo $walger_actualizaciones->pendiente->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Pendiente ?&nbsp;(*)<?php if ($walger_actualizaciones->pendiente->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_actualizaciones->pendiente->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($walger_actualizaciones->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $walger_actualizaciones->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$walger_actualizaciones->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$walger_actualizaciones->CssClass = "ewTableRow";
	$walger_actualizaciones->CssStyle = "";

	// Init row event
	$walger_actualizaciones->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$walger_actualizaciones->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$walger_actualizaciones->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $walger_actualizaciones->DisplayAttributes() ?>>
		<!-- fecha -->
		<td<?php echo $walger_actualizaciones->fecha->CellAttributes() ?>>
<div<?php echo $walger_actualizaciones->fecha->ViewAttributes() ?>><?php echo $walger_actualizaciones->fecha->ViewValue ?></div>
</td>
		<!-- pendiente -->
		<td<?php echo $walger_actualizaciones->pendiente->CellAttributes() ?>>
<div<?php echo $walger_actualizaciones->pendiente->ViewAttributes() ?>><?php echo $walger_actualizaciones->pendiente->ViewValue ?></div>
</td>
<?php if ($walger_actualizaciones->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_actualizaciones->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_actualizaciones->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_actualizaciones->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($walger_actualizaciones->fecha->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_actualizacionesadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_actualizacioneslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_actualizacioneslist.action='walger_actualizacionesdelete.php';document.fwalger_actualizacioneslist.encoding='application/x-www-form-urlencoded';document.fwalger_actualizacioneslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<form action="walger_actualizacioneslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_actualizacioneslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_actualizacioneslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<?php } ?>
<?php if ($walger_actualizaciones->Export == "") { ?>
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
	global $Security, $walger_actualizaciones;
	$sWhere = "";

	// Field fecha
	BuildSearchSql($sWhere, $walger_actualizaciones->fecha, ew_UnFormatDateTime(@$_GET["x_fecha"],7), @$_GET["z_fecha"], @$_GET["v_fecha"], ew_UnFormatDateTime(@$_GET["y_fecha"],7), @$_GET["w_fecha"]);

	// Field pendiente
	BuildSearchSql($sWhere, $walger_actualizaciones->pendiente, @$_GET["x_pendiente"], @$_GET["z_pendiente"], @$_GET["v_pendiente"], @$_GET["y_pendiente"], @$_GET["w_pendiente"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field fecha
		SetSearchParm($walger_actualizaciones->fecha, ew_UnFormatDateTime(@$_GET["x_fecha"],7), @$_GET["z_fecha"], @$_GET["v_fecha"], ew_UnFormatDateTime(@$_GET["y_fecha"],7), @$_GET["w_fecha"]);

		// Field pendiente
		SetSearchParm($walger_actualizaciones->pendiente, @$_GET["x_pendiente"], @$_GET["z_pendiente"], @$_GET["v_pendiente"], @$_GET["y_pendiente"], @$_GET["w_pendiente"]);
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
	global $walger_actualizaciones;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$walger_actualizaciones->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$walger_actualizaciones->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$walger_actualizaciones->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$walger_actualizaciones->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$walger_actualizaciones->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`pendiente` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $walger_actualizaciones;
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
		$walger_actualizaciones->setBasicSearchKeyword($sSearchKeyword);
		$walger_actualizaciones->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $walger_actualizaciones;
	$sSrchWhere = "";
	$walger_actualizaciones->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $walger_actualizaciones;
	$walger_actualizaciones->setBasicSearchKeyword("");
	$walger_actualizaciones->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $walger_actualizaciones;
	$walger_actualizaciones->setAdvancedSearch("x_fecha", "");
	$walger_actualizaciones->setAdvancedSearch("x_pendiente", "");
	$walger_actualizaciones->setAdvancedSearch("z_pendiente", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $walger_actualizaciones;
	$sSrchWhere = $walger_actualizaciones->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
	global $walger_actualizaciones;
	 $walger_actualizaciones->fecha->AdvancedSearch->SearchValue = $walger_actualizaciones->getAdvancedSearch("x_fecha");
	 $walger_actualizaciones->pendiente->AdvancedSearch->SearchValue = $walger_actualizaciones->getAdvancedSearch("x_pendiente");
	 $walger_actualizaciones->pendiente->AdvancedSearch->SearchOperator = $walger_actualizaciones->getAdvancedSearch("z_pendiente");
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $walger_actualizaciones;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$walger_actualizaciones->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$walger_actualizaciones->CurrentOrderType = @$_GET["ordertype"];

		// Field fecha
		$walger_actualizaciones->UpdateSort($walger_actualizaciones->fecha, $bCtrl);

		// Field pendiente
		$walger_actualizaciones->UpdateSort($walger_actualizaciones->pendiente, $bCtrl);
		$walger_actualizaciones->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $walger_actualizaciones->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($walger_actualizaciones->SqlOrderBy() <> "") {
			$sOrderBy = $walger_actualizaciones->SqlOrderBy();
			$walger_actualizaciones->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $walger_actualizaciones;

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
			$walger_actualizaciones->setSessionOrderBy($sOrderBy);
			$walger_actualizaciones->fecha->setSort("");
			$walger_actualizaciones->pendiente->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$walger_actualizaciones->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_actualizaciones;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_actualizaciones->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_actualizaciones->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_actualizaciones->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_actualizaciones->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_actualizaciones->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_actualizaciones->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_actualizaciones->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_actualizaciones;

	// Call Recordset Selecting event
	$walger_actualizaciones->Recordset_Selecting($walger_actualizaciones->CurrentFilter);

	// Load list page sql
	$sSql = $walger_actualizaciones->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_actualizaciones->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_actualizaciones;
	$sFilter = $walger_actualizaciones->SqlKeyFilter();
	$sFilter = str_replace("@fecha@", ew_AdjustSql($walger_actualizaciones->fecha->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_actualizaciones->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_actualizaciones->CurrentFilter = $sFilter;
	$sSql = $walger_actualizaciones->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_actualizaciones->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_actualizaciones;
	$walger_actualizaciones->fecha->setDbValue($rs->fields('fecha'));
	$walger_actualizaciones->pendiente->setDbValue($rs->fields('pendiente'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_actualizaciones;

	// Call Row Rendering event
	$walger_actualizaciones->Row_Rendering();

	// Common render codes for all row types
	// fecha

	$walger_actualizaciones->fecha->CellCssStyle = "";
	$walger_actualizaciones->fecha->CellCssClass = "";

	// pendiente
	$walger_actualizaciones->pendiente->CellCssStyle = "";
	$walger_actualizaciones->pendiente->CellCssClass = "";
	if ($walger_actualizaciones->RowType == EW_ROWTYPE_VIEW) { // View row

		// fecha
		$walger_actualizaciones->fecha->ViewValue = $walger_actualizaciones->fecha->CurrentValue;
		$walger_actualizaciones->fecha->ViewValue = ew_FormatDateTime($walger_actualizaciones->fecha->ViewValue, 7);
		$walger_actualizaciones->fecha->CssStyle = "";
		$walger_actualizaciones->fecha->CssClass = "";
		$walger_actualizaciones->fecha->ViewCustomAttributes = "";

		// pendiente
		$walger_actualizaciones->pendiente->ViewValue = $walger_actualizaciones->pendiente->CurrentValue;
		$walger_actualizaciones->pendiente->CssStyle = "";
		$walger_actualizaciones->pendiente->CssClass = "";
		$walger_actualizaciones->pendiente->ViewCustomAttributes = "";

		// fecha
		$walger_actualizaciones->fecha->HrefValue = "";

		// pendiente
		$walger_actualizaciones->pendiente->HrefValue = "";
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_actualizaciones->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_actualizaciones->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_actualizaciones;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_actualizaciones;
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
	if ($walger_actualizaciones->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_actualizaciones->Export == "csv") {
		$sCsvStr .= "fecha" . ",";
		$sCsvStr .= "pendiente" . ",";
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
			if ($walger_actualizaciones->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('fecha', $walger_actualizaciones->fecha->CurrentValue);
				$XmlDoc->AddField('pendiente', $walger_actualizaciones->pendiente->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_actualizaciones->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_actualizaciones->fecha->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_actualizaciones->pendiente->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_actualizaciones->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_actualizaciones->Export == "csv") {
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
