<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($walger_clientes->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_clientes->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_clientes->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_clientes->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_clientes->Export == "csv") {
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
	$walger_clientes->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$walger_clientes->setStartRecordNumber($nStartRec);
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
$walger_clientes->setSessionWhere($sFilter);
$walger_clientes->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($walger_clientes->Export == "xml" || $walger_clientes->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$walger_clientes->setReturnUrl("walger_clienteslist.php");
?>
<?php include "header.php" ?>
<?php if ($walger_clientes->Export == "") { ?>
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
<?php if ($walger_clientes->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $walger_clientes->Export <> "");
$bSelectLimit = ($walger_clientes->Export == "" && $walger_clientes->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $walger_clientes->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Clientes
<?php if ($walger_clientes->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_clienteslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_clienteslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_clienteslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_clienteslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_clienteslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($walger_clientes->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($walger_clientes->getBasicSearchType() == "") $walger_clientes->setBasicSearchType("AND"); ?>

<form name="fwalger_clienteslistsrch" id="fwalger_clienteslistsrch" action="walger_clienteslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($walger_clientes->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="walger_clienteslist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="walger_clientessrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($walger_clientes->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($walger_clientes->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($walger_clientes->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($walger_clientes->Export == "") { ?>
<form action="walger_clienteslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_clienteslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fwalger_clienteslist" id="fwalger_clienteslist">
<?php if ($walger_clientes->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_clientesadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_clienteslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_clienteslist.action='walger_clientesdelete.php';document.fwalger_clienteslist.encoding='application/x-www-form-urlencoded';document.fwalger_clienteslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_clientes->Export <> "") { ?>
Cliente
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('CodigoCli') ?>&ordertype=<?php echo $walger_clientes->CodigoCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Cliente<?php if ($walger_clientes->CodigoCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->CodigoCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
EMail
		</td>
		<td valign="top" style="width: 90px;">
<?php if ($walger_clientes->Export <> "") { ?>
Contraseña
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('Contrasenia') ?>&ordertype=<?php echo $walger_clientes->Contrasenia->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Contraseña&nbsp;(*)<?php if ($walger_clientes->Contrasenia->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->Contrasenia->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
IP
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('IP') ?>&ordertype=<?php echo $walger_clientes->IP->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">IP&nbsp;(*)<?php if ($walger_clientes->IP->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->IP->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Ultimo Login
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('UltimoLogin') ?>&ordertype=<?php echo $walger_clientes->UltimoLogin->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Ultimo Login<?php if ($walger_clientes->UltimoLogin->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->UltimoLogin->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<!--		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Habilitado
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('Habilitado') ?>&ordertype=<?php echo $walger_clientes->Habilitado->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Habilitado<?php if ($walger_clientes->Habilitado->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->Habilitado->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>-->
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Tipo de Cliente
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('TipoCliente') ?>&ordertype=<?php echo $walger_clientes->TipoCliente->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Tipo de Cliente<?php if ($walger_clientes->TipoCliente->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->TipoCliente->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Moneda
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('Regis_Mda') ?>&ordertype=<?php echo $walger_clientes->Regis_Mda->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Moneda<?php if ($walger_clientes->Regis_Mda->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->Regis_Mda->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Apellido y Nombre
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('ApellidoNombre') ?>&ordertype=<?php echo $walger_clientes->ApellidoNombre->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Apellido y Nombre&nbsp;(*)<?php if ($walger_clientes->ApellidoNombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->ApellidoNombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_clientes->Export <> "") { ?>
Cargo
<?php } else { ?>
	<a href="walger_clienteslist.php?order=<?php echo urlencode('Cargo') ?>&ordertype=<?php echo $walger_clientes->Cargo->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Cargo&nbsp;(*)<?php if ($walger_clientes->Cargo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_clientes->Cargo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($walger_clientes->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $walger_clientes->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$walger_clientes->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$walger_clientes->CssClass = "ewTableRow";
	$walger_clientes->CssStyle = "";

	// Init row event
	$walger_clientes->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$walger_clientes->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$walger_clientes->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $walger_clientes->DisplayAttributes() ?>>
		<!-- CodigoCli -->

<?PHP
//print_r($walger_clientes);
?>

		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<div<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>>
<a href="../vto.php?c=<?php echo $walger_clientes->CodigoCli->CurrentValue ?>" target="_blank">
<?php echo $walger_clientes->CodigoCli->ViewValue ?></a>
</div>
</td>
		<!-- EMail -->
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<div<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>>

<?PHP 

$f__ = mysql_query ("SELECT emailCli FROM dbo_cliente WHERE CodigoCli = '" . $walger_clientes->CodigoCli->CurrentValue . "'"); 
$f__ = mysql_fetch_array ($f__);
echo ($f__ ["emailCli"]);
//echo ("SELECT emailCli FROM dbo_cliente WHERE CodigoCli = " . $walger_clientes->CodigoCli->CurrentValue);

?>

</div>
</td>
		<!-- Contrasenia -->
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<div<?php echo $walger_clientes->Contrasenia->ViewAttributes() ?>><?php echo $walger_clientes->Contrasenia->ViewValue ?> <?php if ($walger_clientes->Habilitado->ViewValue == "Si") { echo ('<img src="./green.png" style="float: right;">'); } else { echo ('<img src="./red.png" style="float: right;">'); } ?></div>
</td>
		<!-- IP -->
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>>
<div<?php echo $walger_clientes->IP->ViewAttributes() ?>><?php echo $walger_clientes->IP->ViewValue ?></div>
</td>
		<!-- UltimoLogin -->
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>>
<div<?php echo $walger_clientes->UltimoLogin->ViewAttributes() ?>><?php echo $walger_clientes->UltimoLogin->CurrentValue ?></div>
</td>

<?PHP //print_r($walger_clientes->UltimoLogin); ?>

		<!-- Habilitado -->
<!--		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<div<?php echo $walger_clientes->Habilitado->ViewAttributes() ?>><?php echo $walger_clientes->Habilitado->ViewValue ?></div>
</td>-->
		<!-- TipoCliente -->
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<div<?php echo $walger_clientes->TipoCliente->ViewAttributes() ?>><?php echo $walger_clientes->TipoCliente->ViewValue ?></div>
</td>
		<!-- Regis_Mda -->
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<div<?php echo $walger_clientes->Regis_Mda->ViewAttributes() ?>><?php echo $walger_clientes->Regis_Mda->ViewValue ?></div>
</td>
		<!-- ApellidoNombre -->
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<div<?php echo $walger_clientes->ApellidoNombre->ViewAttributes() ?>><?php echo $walger_clientes->ApellidoNombre->ViewValue ?></div>
</td>
		<!-- Cargo -->
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<div<?php echo $walger_clientes->Cargo->ViewAttributes() ?>><?php echo $walger_clientes->Cargo->ViewValue ?></div>
</td>
<?php if ($walger_clientes->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_clientes->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_clientes->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_clientes->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($walger_clientes->CodigoCli->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($walger_clientes->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_clientesadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fwalger_clienteslist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fwalger_clienteslist.action='walger_clientesdelete.php';document.fwalger_clienteslist.encoding='application/x-www-form-urlencoded';document.fwalger_clienteslist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($walger_clientes->Export == "") { ?>
<form action="walger_clienteslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_clienteslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_clienteslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($walger_clientes->Export == "") { ?>
<?php } ?>
<?php if ($walger_clientes->Export == "") { ?>
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
	global $Security, $walger_clientes;
	$sWhere = "";

	// Field CodigoCli
	BuildSearchSql($sWhere, $walger_clientes->CodigoCli, @$_GET["x_CodigoCli"], @$_GET["z_CodigoCli"], @$_GET["v_CodigoCli"], @$_GET["y_CodigoCli"], @$_GET["w_CodigoCli"]);

	// Field Contrasenia
	BuildSearchSql($sWhere, $walger_clientes->Contrasenia, @$_GET["x_Contrasenia"], @$_GET["z_Contrasenia"], @$_GET["v_Contrasenia"], @$_GET["y_Contrasenia"], @$_GET["w_Contrasenia"]);

	// Field IP
	BuildSearchSql($sWhere, $walger_clientes->IP, @$_GET["x_IP"], @$_GET["z_IP"], @$_GET["v_IP"], @$_GET["y_IP"], @$_GET["w_IP"]);

	// Field UltimoLogin
	BuildSearchSql($sWhere, $walger_clientes->UltimoLogin, ew_UnFormatDateTime(@$_GET["x_UltimoLogin"],7), @$_GET["z_UltimoLogin"], @$_GET["v_UltimoLogin"], ew_UnFormatDateTime(@$_GET["y_UltimoLogin"],7), @$_GET["w_UltimoLogin"]);

	// Field Habilitado
	BuildSearchSql($sWhere, $walger_clientes->Habilitado, @$_GET["x_Habilitado"], @$_GET["z_Habilitado"], @$_GET["v_Habilitado"], @$_GET["y_Habilitado"], @$_GET["w_Habilitado"]);

	// Field TipoCliente
	BuildSearchSql($sWhere, $walger_clientes->TipoCliente, @$_GET["x_TipoCliente"], @$_GET["z_TipoCliente"], @$_GET["v_TipoCliente"], @$_GET["y_TipoCliente"], @$_GET["w_TipoCliente"]);

	// Field Regis_Mda
	BuildSearchSql($sWhere, $walger_clientes->Regis_Mda, @$_GET["x_Regis_Mda"], @$_GET["z_Regis_Mda"], @$_GET["v_Regis_Mda"], @$_GET["y_Regis_Mda"], @$_GET["w_Regis_Mda"]);

	// Field ApellidoNombre
	BuildSearchSql($sWhere, $walger_clientes->ApellidoNombre, @$_GET["x_ApellidoNombre"], @$_GET["z_ApellidoNombre"], @$_GET["v_ApellidoNombre"], @$_GET["y_ApellidoNombre"], @$_GET["w_ApellidoNombre"]);

	// Field Cargo
	BuildSearchSql($sWhere, $walger_clientes->Cargo, @$_GET["x_Cargo"], @$_GET["z_Cargo"], @$_GET["v_Cargo"], @$_GET["y_Cargo"], @$_GET["w_Cargo"]);

	// Field Comentarios
	BuildSearchSql($sWhere, $walger_clientes->Comentarios, @$_GET["x_Comentarios"], @$_GET["z_Comentarios"], @$_GET["v_Comentarios"], @$_GET["y_Comentarios"], @$_GET["w_Comentarios"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field CodigoCli
		SetSearchParm($walger_clientes->CodigoCli, @$_GET["x_CodigoCli"], @$_GET["z_CodigoCli"], @$_GET["v_CodigoCli"], @$_GET["y_CodigoCli"], @$_GET["w_CodigoCli"]);

		// Field Contrasenia
		SetSearchParm($walger_clientes->Contrasenia, @$_GET["x_Contrasenia"], @$_GET["z_Contrasenia"], @$_GET["v_Contrasenia"], @$_GET["y_Contrasenia"], @$_GET["w_Contrasenia"]);

		// Field IP
		SetSearchParm($walger_clientes->IP, @$_GET["x_IP"], @$_GET["z_IP"], @$_GET["v_IP"], @$_GET["y_IP"], @$_GET["w_IP"]);

		// Field UltimoLogin
		SetSearchParm($walger_clientes->UltimoLogin, ew_UnFormatDateTime(@$_GET["x_UltimoLogin"],7), @$_GET["z_UltimoLogin"], @$_GET["v_UltimoLogin"], ew_UnFormatDateTime(@$_GET["y_UltimoLogin"],7), @$_GET["w_UltimoLogin"]);

		// Field Habilitado
		SetSearchParm($walger_clientes->Habilitado, @$_GET["x_Habilitado"], @$_GET["z_Habilitado"], @$_GET["v_Habilitado"], @$_GET["y_Habilitado"], @$_GET["w_Habilitado"]);

		// Field TipoCliente
		SetSearchParm($walger_clientes->TipoCliente, @$_GET["x_TipoCliente"], @$_GET["z_TipoCliente"], @$_GET["v_TipoCliente"], @$_GET["y_TipoCliente"], @$_GET["w_TipoCliente"]);

		// Field Regis_Mda
		SetSearchParm($walger_clientes->Regis_Mda, @$_GET["x_Regis_Mda"], @$_GET["z_Regis_Mda"], @$_GET["v_Regis_Mda"], @$_GET["y_Regis_Mda"], @$_GET["w_Regis_Mda"]);

		// Field ApellidoNombre
		SetSearchParm($walger_clientes->ApellidoNombre, @$_GET["x_ApellidoNombre"], @$_GET["z_ApellidoNombre"], @$_GET["v_ApellidoNombre"], @$_GET["y_ApellidoNombre"], @$_GET["w_ApellidoNombre"]);

		// Field Cargo
		SetSearchParm($walger_clientes->Cargo, @$_GET["x_Cargo"], @$_GET["z_Cargo"], @$_GET["v_Cargo"], @$_GET["y_Cargo"], @$_GET["w_Cargo"]);

		// Field Comentarios
		SetSearchParm($walger_clientes->Comentarios, @$_GET["x_Comentarios"], @$_GET["z_Comentarios"], @$_GET["v_Comentarios"], @$_GET["y_Comentarios"], @$_GET["w_Comentarios"]);
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
	global $walger_clientes;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$walger_clientes->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$walger_clientes->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$walger_clientes->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$walger_clientes->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$walger_clientes->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`CodigoCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Contrasenia` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`IP` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Habilitado` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`TipoCliente` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`ApellidoNombre` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Cargo` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Comentarios` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $walger_clientes;
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
		$walger_clientes->setBasicSearchKeyword($sSearchKeyword);
		$walger_clientes->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $walger_clientes;
	$sSrchWhere = "";
	$walger_clientes->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $walger_clientes;
	$walger_clientes->setBasicSearchKeyword("");
	$walger_clientes->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $walger_clientes;
	$walger_clientes->setAdvancedSearch("x_CodigoCli", "");
	$walger_clientes->setAdvancedSearch("z_CodigoCli", "");
	$walger_clientes->setAdvancedSearch("x_Contrasenia", "");
	$walger_clientes->setAdvancedSearch("z_Contrasenia", "");
	$walger_clientes->setAdvancedSearch("x_IP", "");
	$walger_clientes->setAdvancedSearch("z_IP", "");
	$walger_clientes->setAdvancedSearch("x_UltimoLogin", "");
	$walger_clientes->setAdvancedSearch("z_UltimoLogin", "");
	$walger_clientes->setAdvancedSearch("x_Habilitado", "");
	$walger_clientes->setAdvancedSearch("z_Habilitado", "");
	$walger_clientes->setAdvancedSearch("x_TipoCliente", "");
	$walger_clientes->setAdvancedSearch("z_TipoCliente", "");
	$walger_clientes->setAdvancedSearch("x_Regis_Mda", "");
	$walger_clientes->setAdvancedSearch("x_ApellidoNombre", "");
	$walger_clientes->setAdvancedSearch("z_ApellidoNombre", "");
	$walger_clientes->setAdvancedSearch("x_Cargo", "");
	$walger_clientes->setAdvancedSearch("z_Cargo", "");
	$walger_clientes->setAdvancedSearch("x_Comentarios", "");
	$walger_clientes->setAdvancedSearch("z_Comentarios", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $walger_clientes;
	$sSrchWhere = $walger_clientes->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $walger_clientes;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$walger_clientes->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$walger_clientes->CurrentOrderType = @$_GET["ordertype"];

		// Field CodigoCli
		$walger_clientes->UpdateSort($walger_clientes->CodigoCli, $bCtrl);

		// Field Contrasenia
		$walger_clientes->UpdateSort($walger_clientes->Contrasenia, $bCtrl);

		// Field IP
		$walger_clientes->UpdateSort($walger_clientes->IP, $bCtrl);

		// Field UltimoLogin
		$walger_clientes->UpdateSort($walger_clientes->UltimoLogin, $bCtrl);

		// Field Habilitado
		$walger_clientes->UpdateSort($walger_clientes->Habilitado, $bCtrl);

		// Field TipoCliente
		$walger_clientes->UpdateSort($walger_clientes->TipoCliente, $bCtrl);

		// Field Regis_Mda
		$walger_clientes->UpdateSort($walger_clientes->Regis_Mda, $bCtrl);

		// Field ApellidoNombre
		$walger_clientes->UpdateSort($walger_clientes->ApellidoNombre, $bCtrl);

		// Field Cargo
		$walger_clientes->UpdateSort($walger_clientes->Cargo, $bCtrl);
		$walger_clientes->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $walger_clientes->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($walger_clientes->SqlOrderBy() <> "") {
			$sOrderBy = $walger_clientes->SqlOrderBy();
			$walger_clientes->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $walger_clientes;

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
			$walger_clientes->setSessionOrderBy($sOrderBy);
			$walger_clientes->CodigoCli->setSort("");
			$walger_clientes->Contrasenia->setSort("");
			$walger_clientes->IP->setSort("");
			$walger_clientes->UltimoLogin->setSort("");
			$walger_clientes->Habilitado->setSort("");
			$walger_clientes->TipoCliente->setSort("");
			$walger_clientes->Regis_Mda->setSort("");
			$walger_clientes->ApellidoNombre->setSort("");
			$walger_clientes->Cargo->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$walger_clientes->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_clientes;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_clientes->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_clientes->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_clientes->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_clientes->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_clientes;

	// Call Recordset Selecting event
	$walger_clientes->Recordset_Selecting($walger_clientes->CurrentFilter);

	// Load list page sql
	$sSql = $walger_clientes->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_clientes->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_clientes;
	$sFilter = $walger_clientes->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_clientes->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_clientes->CurrentFilter = $sFilter;
	$sSql = $walger_clientes->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_clientes->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_clientes;
	$walger_clientes->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$walger_clientes->Contrasenia->setDbValue($rs->fields('Contrasenia'));
	$walger_clientes->IP->setDbValue($rs->fields('IP'));
	$walger_clientes->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
	$walger_clientes->Habilitado->setDbValue($rs->fields('Habilitado'));
	$walger_clientes->TipoCliente->setDbValue($rs->fields('TipoCliente'));
	$walger_clientes->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$walger_clientes->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
	$walger_clientes->Cargo->setDbValue($rs->fields('Cargo'));
	$walger_clientes->Comentarios->setDbValue($rs->fields('Comentarios'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_clientes;

	// Call Row Rendering event
	$walger_clientes->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$walger_clientes->CodigoCli->CellCssStyle = "";
	$walger_clientes->CodigoCli->CellCssClass = "";

	// Contrasenia
	$walger_clientes->Contrasenia->CellCssStyle = "";
	$walger_clientes->Contrasenia->CellCssClass = "";

	// IP
	$walger_clientes->IP->CellCssStyle = "";
	$walger_clientes->IP->CellCssClass = "";

	// UltimoLogin
	$walger_clientes->UltimoLogin->CellCssStyle = "";
	$walger_clientes->UltimoLogin->CellCssClass = "";

	// Habilitado
	$walger_clientes->Habilitado->CellCssStyle = "";
	$walger_clientes->Habilitado->CellCssClass = "";

	// TipoCliente
	$walger_clientes->TipoCliente->CellCssStyle = "";
	$walger_clientes->TipoCliente->CellCssClass = "";

	// Regis_Mda
	$walger_clientes->Regis_Mda->CellCssStyle = "";
	$walger_clientes->Regis_Mda->CellCssClass = "";

	// ApellidoNombre
	$walger_clientes->ApellidoNombre->CellCssStyle = "";
	$walger_clientes->ApellidoNombre->CellCssClass = "";

	// Cargo
	$walger_clientes->Cargo->CellCssStyle = "";
	$walger_clientes->Cargo->CellCssClass = "";
	if ($walger_clientes->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		if (!is_null($walger_clientes->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_clientes->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$walger_clientes->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$walger_clientes->CodigoCli->ViewValue = $walger_clientes->CodigoCli->CurrentValue;
			}
		} else {
			$walger_clientes->CodigoCli->ViewValue = NULL;
		}
		$walger_clientes->CodigoCli->CssStyle = "";
		$walger_clientes->CodigoCli->CssClass = "";
		$walger_clientes->CodigoCli->ViewCustomAttributes = "";

		// Contrasenia
		$walger_clientes->Contrasenia->ViewValue = $walger_clientes->Contrasenia->CurrentValue;
		$walger_clientes->Contrasenia->CssStyle = "";
		$walger_clientes->Contrasenia->CssClass = "";
		$walger_clientes->Contrasenia->ViewCustomAttributes = "";

		// IP
		$walger_clientes->IP->ViewValue = $walger_clientes->IP->CurrentValue;
		$walger_clientes->IP->CssStyle = "";
		$walger_clientes->IP->CssClass = "";
		$walger_clientes->IP->ViewCustomAttributes = "";

		// UltimoLogin
		$walger_clientes->UltimoLogin->ViewValue = $walger_clientes->UltimoLogin->CurrentValue;
		$walger_clientes->UltimoLogin->ViewValue = ew_FormatDateTime($walger_clientes->UltimoLogin->ViewValue, 7);
		$walger_clientes->UltimoLogin->CssStyle = "";
		$walger_clientes->UltimoLogin->CssClass = "";
		$walger_clientes->UltimoLogin->ViewCustomAttributes = "";

		// Habilitado
		if (!is_null($walger_clientes->Habilitado->CurrentValue)) {
			switch ($walger_clientes->Habilitado->CurrentValue) {
				case "S":
					$walger_clientes->Habilitado->ViewValue = "Si";
					break;
				case "N":
					$walger_clientes->Habilitado->ViewValue = "No";
					break;
				default:
					$walger_clientes->Habilitado->ViewValue = $walger_clientes->Habilitado->CurrentValue;
			}
		} else {
			$walger_clientes->Habilitado->ViewValue = NULL;
		}
		$walger_clientes->Habilitado->CssStyle = "";
		$walger_clientes->Habilitado->CssClass = "";
		$walger_clientes->Habilitado->ViewCustomAttributes = "";

		// TipoCliente
		if (!is_null($walger_clientes->TipoCliente->CurrentValue)) {
			switch ($walger_clientes->TipoCliente->CurrentValue) {
				case "Consumidor Final":
					$walger_clientes->TipoCliente->ViewValue = "Consumidor Final";
					break;
				case "Casa de Repuestos":
					$walger_clientes->TipoCliente->ViewValue = "Casa de Repuestos";
					break;
				case "Distribuidor":
					$walger_clientes->TipoCliente->ViewValue = "Distribuidor";
					break;
				default:
					$walger_clientes->TipoCliente->ViewValue = $walger_clientes->TipoCliente->CurrentValue;
			}
		} else {
			$walger_clientes->TipoCliente->ViewValue = NULL;
		}
		$walger_clientes->TipoCliente->CssStyle = "";
		$walger_clientes->TipoCliente->CssClass = "";
		$walger_clientes->TipoCliente->ViewCustomAttributes = "";

		// Regis_Mda
		if (!is_null($walger_clientes->Regis_Mda->CurrentValue)) {
			$sSqlWrk = "SELECT `CodigoAFIP_Mda`, `Signo_Mda` FROM `dbo_moneda` WHERE `Regis_Mda` = " . ew_AdjustSql($walger_clientes->Regis_Mda->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `CodigoAFIP_Mda` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_clientes->Regis_Mda->ViewValue = $rswrk->fields('CodigoAFIP_Mda');
					$walger_clientes->Regis_Mda->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('Signo_Mda');
				}
				$rswrk->Close();
			} else {
				$walger_clientes->Regis_Mda->ViewValue = $walger_clientes->Regis_Mda->CurrentValue;
			}
		} else {
			$walger_clientes->Regis_Mda->ViewValue = NULL;
		}
		$walger_clientes->Regis_Mda->CssStyle = "";
		$walger_clientes->Regis_Mda->CssClass = "";
		$walger_clientes->Regis_Mda->ViewCustomAttributes = "";

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->ViewValue = $walger_clientes->ApellidoNombre->CurrentValue;
		$walger_clientes->ApellidoNombre->CssStyle = "";
		$walger_clientes->ApellidoNombre->CssClass = "";
		$walger_clientes->ApellidoNombre->ViewCustomAttributes = "";

		// Cargo
		$walger_clientes->Cargo->ViewValue = $walger_clientes->Cargo->CurrentValue;
		$walger_clientes->Cargo->CssStyle = "";
		$walger_clientes->Cargo->CssClass = "";
		$walger_clientes->Cargo->ViewCustomAttributes = "";

		// CodigoCli
		$walger_clientes->CodigoCli->HrefValue = "";

		// Contrasenia
		$walger_clientes->Contrasenia->HrefValue = "";

		// IP
		$walger_clientes->IP->HrefValue = "";

		// UltimoLogin
		$walger_clientes->UltimoLogin->HrefValue = "";

		// Habilitado
		$walger_clientes->Habilitado->HrefValue = "";

		// TipoCliente
		$walger_clientes->TipoCliente->HrefValue = "";

		// Regis_Mda
		$walger_clientes->Regis_Mda->HrefValue = "";

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->HrefValue = "";

		// Cargo
		$walger_clientes->Cargo->HrefValue = "";
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_clientes->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $walger_clientes;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_clientes;
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
	if ($walger_clientes->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_clientes->Export == "csv") {
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "Contrasenia" . ",";
		$sCsvStr .= "IP" . ",";
		$sCsvStr .= "UltimoLogin" . ",";
		$sCsvStr .= "Habilitado" . ",";
		$sCsvStr .= "TipoCliente" . ",";
		$sCsvStr .= "Regis_Mda" . ",";
		$sCsvStr .= "ApellidoNombre" . ",";
		$sCsvStr .= "Cargo" . ",";
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
			if ($walger_clientes->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodigoCli', $walger_clientes->CodigoCli->CurrentValue);
				$XmlDoc->AddField('Contrasenia', $walger_clientes->Contrasenia->CurrentValue);
				$XmlDoc->AddField('IP', $walger_clientes->IP->CurrentValue);
				$XmlDoc->AddField('UltimoLogin', $walger_clientes->UltimoLogin->CurrentValue);
				$XmlDoc->AddField('Habilitado', $walger_clientes->Habilitado->CurrentValue);
				$XmlDoc->AddField('TipoCliente', $walger_clientes->TipoCliente->CurrentValue);
				$XmlDoc->AddField('Regis_Mda', $walger_clientes->Regis_Mda->CurrentValue);
				$XmlDoc->AddField('ApellidoNombre', $walger_clientes->ApellidoNombre->CurrentValue);
				$XmlDoc->AddField('Cargo', $walger_clientes->Cargo->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_clientes->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Contrasenia->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->IP->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->UltimoLogin->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Habilitado->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->TipoCliente->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Regis_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->ApellidoNombre->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Cargo->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_clientes->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_clientes->Export == "csv") {
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
