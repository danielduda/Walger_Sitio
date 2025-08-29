<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
if ($dbo_cliente->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_cliente->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_cliente->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_cliente->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_cliente->Export == "csv") {
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
$sDbMasterFilter = "RazonSocialCli"; // Master filter
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
	$dbo_cliente->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$dbo_cliente->setStartRecordNumber($nStartRec);
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
$dbo_cliente->setSessionWhere($sFilter);
$dbo_cliente->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($dbo_cliente->Export == "xml" || $dbo_cliente->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$dbo_cliente->setReturnUrl("dbo_clientelist.php");
?>
<?php include "header.php" ?>
<?php if ($dbo_cliente->Export == "") { ?>
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
<?php if ($dbo_cliente->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $dbo_cliente->Export <> "");
$bSelectLimit = ($dbo_cliente->Export == "" && $dbo_cliente->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $dbo_cliente->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Clientes (ISIS)
<?php if ($dbo_cliente->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_clientelist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_clientelist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_clientelist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_clientelist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_clientelist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($dbo_cliente->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($dbo_cliente->getBasicSearchType() == "") $dbo_cliente->setBasicSearchType("AND"); ?>

<form name="fdbo_clientelistsrch" id="fdbo_clientelistsrch" action="dbo_clientelist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($dbo_cliente->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="dbo_clientelist.php?cmd=reset">Mostrar todos</a>&nbsp;
			<a href="dbo_clientesrch.php">Búsqueda avanzada</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($dbo_cliente->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($dbo_cliente->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($dbo_cliente->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($dbo_cliente->Export == "") { ?>
<form action="dbo_clientelist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_clientelist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fdbo_clientelist" id="fdbo_clientelist">
<?php if ($dbo_cliente->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_clienteadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_clientelist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_clientelist.action='dbo_clientedelete.php';document.fdbo_clientelist.encoding='application/x-www-form-urlencoded';document.fdbo_clientelist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_cliente->Export <> "") { ?>
Código
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('CodigoCli') ?>&ordertype=<?php echo $dbo_cliente->CodigoCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Código&nbsp;(*)<?php if ($dbo_cliente->CodigoCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->CodigoCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Razón Social
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('RazonSocialCli') ?>&ordertype=<?php echo $dbo_cliente->RazonSocialCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Razón Social&nbsp;(*)<?php if ($dbo_cliente->RazonSocialCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->RazonSocialCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
CUIT
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('CuitCli') ?>&ordertype=<?php echo $dbo_cliente->CuitCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">CUIT&nbsp;(*)<?php if ($dbo_cliente->CuitCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->CuitCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Ingresos Brutos
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('IngBrutosCli') ?>&ordertype=<?php echo $dbo_cliente->IngBrutosCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Ingresos Brutos&nbsp;(*)<?php if ($dbo_cliente->IngBrutosCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->IngBrutosCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Condición IVA
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('Regis_IvaC') ?>&ordertype=<?php echo $dbo_cliente->Regis_IvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Condición IVA<?php if ($dbo_cliente->Regis_IvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->Regis_IvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Lista de Precios
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('Regis_ListaPrec') ?>&ordertype=<?php echo $dbo_cliente->Regis_ListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Lista de Precios<?php if ($dbo_cliente->Regis_ListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->Regis_ListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
EMail
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('emailCli') ?>&ordertype=<?php echo $dbo_cliente->emailCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">EMail&nbsp;(*)<?php if ($dbo_cliente->emailCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->emailCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Razón Social Flete
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('RazonSocialFlete') ?>&ordertype=<?php echo $dbo_cliente->RazonSocialFlete->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Razón Social Flete&nbsp;(*)<?php if ($dbo_cliente->RazonSocialFlete->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->RazonSocialFlete->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Dirección
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('Direccion') ?>&ordertype=<?php echo $dbo_cliente->Direccion->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Dirección&nbsp;(*)<?php if ($dbo_cliente->Direccion->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->Direccion->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Barrio
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('BarrioCli') ?>&ordertype=<?php echo $dbo_cliente->BarrioCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Barrio&nbsp;(*)<?php if ($dbo_cliente->BarrioCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->BarrioCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Localidad
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('LocalidadCli') ?>&ordertype=<?php echo $dbo_cliente->LocalidadCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Localidad&nbsp;(*)<?php if ($dbo_cliente->LocalidadCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->LocalidadCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Provincia
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('DescrProvincia') ?>&ordertype=<?php echo $dbo_cliente->DescrProvincia->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Provincia&nbsp;(*)<?php if ($dbo_cliente->DescrProvincia->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->DescrProvincia->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
CP
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('CodigoPostalCli') ?>&ordertype=<?php echo $dbo_cliente->CodigoPostalCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">CP&nbsp;(*)<?php if ($dbo_cliente->CodigoPostalCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->CodigoPostalCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
País
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('DescrPais') ?>&ordertype=<?php echo $dbo_cliente->DescrPais->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">País&nbsp;(*)<?php if ($dbo_cliente->DescrPais->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->DescrPais->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Teléfono
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('Telefono') ?>&ordertype=<?php echo $dbo_cliente->Telefono->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Teléfono&nbsp;(*)<?php if ($dbo_cliente->Telefono->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->Telefono->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Fax
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('FaxCli') ?>&ordertype=<?php echo $dbo_cliente->FaxCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Fax&nbsp;(*)<?php if ($dbo_cliente->FaxCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->FaxCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($dbo_cliente->Export <> "") { ?>
Pagina Web
<?php } else { ?>
	<a href="dbo_clientelist.php?order=<?php echo urlencode('PaginaWebCli') ?>&ordertype=<?php echo $dbo_cliente->PaginaWebCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Pagina Web&nbsp;(*)<?php if ($dbo_cliente->PaginaWebCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dbo_cliente->PaginaWebCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($dbo_cliente->Export == "") { ?>
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
if (defined("EW_EXPORT_ALL") && $dbo_cliente->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$dbo_cliente->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$dbo_cliente->CssClass = "ewTableRow";
	$dbo_cliente->CssStyle = "";

	// Init row event
	$dbo_cliente->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$dbo_cliente->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$dbo_cliente->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $dbo_cliente->DisplayAttributes() ?>>
		<!-- CodigoCli -->
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>><a href="../vto.php?c=<?php echo $dbo_cliente->CodigoCli->ViewValue ?>" target="_blank"><?php echo $dbo_cliente->CodigoCli->ViewValue ?></a></div>
</td>
		<!-- RazonSocialCli -->
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialCli->ViewValue ?></div>
</td>
		<!-- CuitCli -->
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>><?php echo $dbo_cliente->CuitCli->ViewValue ?></div>
</td>
		<!-- IngBrutosCli -->
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>><?php echo $dbo_cliente->IngBrutosCli->ViewValue ?></div>
</td>
		<!-- Regis_IvaC -->
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_IvaC->ViewValue ?></div>
</td>
		<!-- Regis_ListaPrec -->
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_ListaPrec->ViewValue ?></div>
</td>
		<!-- emailCli -->
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>><?php echo $dbo_cliente->emailCli->ViewValue ?></div>
</td>
		<!-- RazonSocialFlete -->
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialFlete->ViewValue ?></div>
</td>
		<!-- Direccion -->
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>><?php echo $dbo_cliente->Direccion->ViewValue ?></div>
</td>
		<!-- BarrioCli -->
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>><?php echo $dbo_cliente->BarrioCli->ViewValue ?></div>
</td>
		<!-- LocalidadCli -->
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>><?php echo $dbo_cliente->LocalidadCli->ViewValue ?></div>
</td>
		<!-- DescrProvincia -->
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>><?php echo $dbo_cliente->DescrProvincia->ViewValue ?></div>
</td>
		<!-- CodigoPostalCli -->
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>><?php echo $dbo_cliente->CodigoPostalCli->ViewValue ?></div>
</td>
		<!-- DescrPais -->
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>><?php echo $dbo_cliente->DescrPais->ViewValue ?></div>
</td>
		<!-- Telefono -->
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>><?php echo $dbo_cliente->Telefono->ViewValue ?></div>
</td>
		<!-- FaxCli -->
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>><?php echo $dbo_cliente->FaxCli->ViewValue ?></div>
</td>
		<!-- PaginaWebCli -->
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>><?php echo $dbo_cliente->PaginaWebCli->ViewValue ?></div>
</td>
<?php if ($dbo_cliente->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_cliente->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_cliente->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $dbo_cliente->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<input type="checkbox" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($dbo_cliente->CodigoCli->CurrentValue) ?>" class="phpmaker" onclick='ew_ClickMultiCheckbox(this);'>
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
<?php if ($dbo_cliente->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_clienteadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="" onClick="if (!ew_Selected(document.fdbo_clientelist)) alert('No se seleccionó ningún registro'); else if (ew_Confirm('Realmente quiere eliminar éste registro?')) {document.fdbo_clientelist.action='dbo_clientedelete.php';document.fdbo_clientelist.encoding='application/x-www-form-urlencoded';document.fdbo_clientelist.submit();};return false;">Eliminar registros seleccionados</a>&nbsp;&nbsp;
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
<?php if ($dbo_cliente->Export == "") { ?>
<form action="dbo_clientelist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_clientelist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_clientelist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($dbo_cliente->Export == "") { ?>
<?php } ?>
<?php if ($dbo_cliente->Export == "") { ?>
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
	global $Security, $dbo_cliente;
	$sWhere = "";

	// Field CodigoCli
	BuildSearchSql($sWhere, $dbo_cliente->CodigoCli, @$_GET["x_CodigoCli"], @$_GET["z_CodigoCli"], @$_GET["v_CodigoCli"], @$_GET["y_CodigoCli"], @$_GET["w_CodigoCli"]);

	// Field RazonSocialCli
	BuildSearchSql($sWhere, $dbo_cliente->RazonSocialCli, @$_GET["x_RazonSocialCli"], @$_GET["z_RazonSocialCli"], @$_GET["v_RazonSocialCli"], @$_GET["y_RazonSocialCli"], @$_GET["w_RazonSocialCli"]);

	// Field CuitCli
	BuildSearchSql($sWhere, $dbo_cliente->CuitCli, @$_GET["x_CuitCli"], @$_GET["z_CuitCli"], @$_GET["v_CuitCli"], @$_GET["y_CuitCli"], @$_GET["w_CuitCli"]);

	// Field IngBrutosCli
	BuildSearchSql($sWhere, $dbo_cliente->IngBrutosCli, @$_GET["x_IngBrutosCli"], @$_GET["z_IngBrutosCli"], @$_GET["v_IngBrutosCli"], @$_GET["y_IngBrutosCli"], @$_GET["w_IngBrutosCli"]);

	// Field Regis_IvaC
	BuildSearchSql($sWhere, $dbo_cliente->Regis_IvaC, @$_GET["x_Regis_IvaC"], @$_GET["z_Regis_IvaC"], @$_GET["v_Regis_IvaC"], @$_GET["y_Regis_IvaC"], @$_GET["w_Regis_IvaC"]);

	// Field Regis_ListaPrec
	BuildSearchSql($sWhere, $dbo_cliente->Regis_ListaPrec, @$_GET["x_Regis_ListaPrec"], @$_GET["z_Regis_ListaPrec"], @$_GET["v_Regis_ListaPrec"], @$_GET["y_Regis_ListaPrec"], @$_GET["w_Regis_ListaPrec"]);

	// Field emailCli
	BuildSearchSql($sWhere, $dbo_cliente->emailCli, @$_GET["x_emailCli"], @$_GET["z_emailCli"], @$_GET["v_emailCli"], @$_GET["y_emailCli"], @$_GET["w_emailCli"]);

	// Field RazonSocialFlete
	BuildSearchSql($sWhere, $dbo_cliente->RazonSocialFlete, @$_GET["x_RazonSocialFlete"], @$_GET["z_RazonSocialFlete"], @$_GET["v_RazonSocialFlete"], @$_GET["y_RazonSocialFlete"], @$_GET["w_RazonSocialFlete"]);

	// Field Direccion
	BuildSearchSql($sWhere, $dbo_cliente->Direccion, @$_GET["x_Direccion"], @$_GET["z_Direccion"], @$_GET["v_Direccion"], @$_GET["y_Direccion"], @$_GET["w_Direccion"]);

	// Field BarrioCli
	BuildSearchSql($sWhere, $dbo_cliente->BarrioCli, @$_GET["x_BarrioCli"], @$_GET["z_BarrioCli"], @$_GET["v_BarrioCli"], @$_GET["y_BarrioCli"], @$_GET["w_BarrioCli"]);

	// Field LocalidadCli
	BuildSearchSql($sWhere, $dbo_cliente->LocalidadCli, @$_GET["x_LocalidadCli"], @$_GET["z_LocalidadCli"], @$_GET["v_LocalidadCli"], @$_GET["y_LocalidadCli"], @$_GET["w_LocalidadCli"]);

	// Field DescrProvincia
	BuildSearchSql($sWhere, $dbo_cliente->DescrProvincia, @$_GET["x_DescrProvincia"], @$_GET["z_DescrProvincia"], @$_GET["v_DescrProvincia"], @$_GET["y_DescrProvincia"], @$_GET["w_DescrProvincia"]);

	// Field CodigoPostalCli
	BuildSearchSql($sWhere, $dbo_cliente->CodigoPostalCli, @$_GET["x_CodigoPostalCli"], @$_GET["z_CodigoPostalCli"], @$_GET["v_CodigoPostalCli"], @$_GET["y_CodigoPostalCli"], @$_GET["w_CodigoPostalCli"]);

	// Field DescrPais
	BuildSearchSql($sWhere, $dbo_cliente->DescrPais, @$_GET["x_DescrPais"], @$_GET["z_DescrPais"], @$_GET["v_DescrPais"], @$_GET["y_DescrPais"], @$_GET["w_DescrPais"]);

	// Field Telefono
	BuildSearchSql($sWhere, $dbo_cliente->Telefono, @$_GET["x_Telefono"], @$_GET["z_Telefono"], @$_GET["v_Telefono"], @$_GET["y_Telefono"], @$_GET["w_Telefono"]);

	// Field FaxCli
	BuildSearchSql($sWhere, $dbo_cliente->FaxCli, @$_GET["x_FaxCli"], @$_GET["z_FaxCli"], @$_GET["v_FaxCli"], @$_GET["y_FaxCli"], @$_GET["w_FaxCli"]);

	// Field PaginaWebCli
	BuildSearchSql($sWhere, $dbo_cliente->PaginaWebCli, @$_GET["x_PaginaWebCli"], @$_GET["z_PaginaWebCli"], @$_GET["v_PaginaWebCli"], @$_GET["y_PaginaWebCli"], @$_GET["w_PaginaWebCli"]);

	//AdvancedSearchWhere = sWhere
	// Set up search parm

	if ($sWhere <> "") {

		// Field CodigoCli
		SetSearchParm($dbo_cliente->CodigoCli, @$_GET["x_CodigoCli"], @$_GET["z_CodigoCli"], @$_GET["v_CodigoCli"], @$_GET["y_CodigoCli"], @$_GET["w_CodigoCli"]);

		// Field RazonSocialCli
		SetSearchParm($dbo_cliente->RazonSocialCli, @$_GET["x_RazonSocialCli"], @$_GET["z_RazonSocialCli"], @$_GET["v_RazonSocialCli"], @$_GET["y_RazonSocialCli"], @$_GET["w_RazonSocialCli"]);

		// Field CuitCli
		SetSearchParm($dbo_cliente->CuitCli, @$_GET["x_CuitCli"], @$_GET["z_CuitCli"], @$_GET["v_CuitCli"], @$_GET["y_CuitCli"], @$_GET["w_CuitCli"]);

		// Field IngBrutosCli
		SetSearchParm($dbo_cliente->IngBrutosCli, @$_GET["x_IngBrutosCli"], @$_GET["z_IngBrutosCli"], @$_GET["v_IngBrutosCli"], @$_GET["y_IngBrutosCli"], @$_GET["w_IngBrutosCli"]);

		// Field Regis_IvaC
		SetSearchParm($dbo_cliente->Regis_IvaC, @$_GET["x_Regis_IvaC"], @$_GET["z_Regis_IvaC"], @$_GET["v_Regis_IvaC"], @$_GET["y_Regis_IvaC"], @$_GET["w_Regis_IvaC"]);

		// Field Regis_ListaPrec
		SetSearchParm($dbo_cliente->Regis_ListaPrec, @$_GET["x_Regis_ListaPrec"], @$_GET["z_Regis_ListaPrec"], @$_GET["v_Regis_ListaPrec"], @$_GET["y_Regis_ListaPrec"], @$_GET["w_Regis_ListaPrec"]);

		// Field emailCli
		SetSearchParm($dbo_cliente->emailCli, @$_GET["x_emailCli"], @$_GET["z_emailCli"], @$_GET["v_emailCli"], @$_GET["y_emailCli"], @$_GET["w_emailCli"]);

		// Field RazonSocialFlete
		SetSearchParm($dbo_cliente->RazonSocialFlete, @$_GET["x_RazonSocialFlete"], @$_GET["z_RazonSocialFlete"], @$_GET["v_RazonSocialFlete"], @$_GET["y_RazonSocialFlete"], @$_GET["w_RazonSocialFlete"]);

		// Field Direccion
		SetSearchParm($dbo_cliente->Direccion, @$_GET["x_Direccion"], @$_GET["z_Direccion"], @$_GET["v_Direccion"], @$_GET["y_Direccion"], @$_GET["w_Direccion"]);

		// Field BarrioCli
		SetSearchParm($dbo_cliente->BarrioCli, @$_GET["x_BarrioCli"], @$_GET["z_BarrioCli"], @$_GET["v_BarrioCli"], @$_GET["y_BarrioCli"], @$_GET["w_BarrioCli"]);

		// Field LocalidadCli
		SetSearchParm($dbo_cliente->LocalidadCli, @$_GET["x_LocalidadCli"], @$_GET["z_LocalidadCli"], @$_GET["v_LocalidadCli"], @$_GET["y_LocalidadCli"], @$_GET["w_LocalidadCli"]);

		// Field DescrProvincia
		SetSearchParm($dbo_cliente->DescrProvincia, @$_GET["x_DescrProvincia"], @$_GET["z_DescrProvincia"], @$_GET["v_DescrProvincia"], @$_GET["y_DescrProvincia"], @$_GET["w_DescrProvincia"]);

		// Field CodigoPostalCli
		SetSearchParm($dbo_cliente->CodigoPostalCli, @$_GET["x_CodigoPostalCli"], @$_GET["z_CodigoPostalCli"], @$_GET["v_CodigoPostalCli"], @$_GET["y_CodigoPostalCli"], @$_GET["w_CodigoPostalCli"]);

		// Field DescrPais
		SetSearchParm($dbo_cliente->DescrPais, @$_GET["x_DescrPais"], @$_GET["z_DescrPais"], @$_GET["v_DescrPais"], @$_GET["y_DescrPais"], @$_GET["w_DescrPais"]);

		// Field Telefono
		SetSearchParm($dbo_cliente->Telefono, @$_GET["x_Telefono"], @$_GET["z_Telefono"], @$_GET["v_Telefono"], @$_GET["y_Telefono"], @$_GET["w_Telefono"]);

		// Field FaxCli
		SetSearchParm($dbo_cliente->FaxCli, @$_GET["x_FaxCli"], @$_GET["z_FaxCli"], @$_GET["v_FaxCli"], @$_GET["y_FaxCli"], @$_GET["w_FaxCli"]);

		// Field PaginaWebCli
		SetSearchParm($dbo_cliente->PaginaWebCli, @$_GET["x_PaginaWebCli"], @$_GET["z_PaginaWebCli"], @$_GET["v_PaginaWebCli"], @$_GET["y_PaginaWebCli"], @$_GET["w_PaginaWebCli"]);
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
	global $dbo_cliente;
	$FldParm = substr($Fld->FldVar, 2);
	$FldVal = ew_StripSlashes($FldVal);
	if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
	$FldVal2 = ew_StripSlashes($FldVal2);
	if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
	$dbo_cliente->setAdvancedSearch("x_" . $FldParm, $FldVal);
	$dbo_cliente->setAdvancedSearch("z_" . $FldParm, $FldOpr);
	$dbo_cliente->setAdvancedSearch("v_" . $FldParm, $FldCond);
	$dbo_cliente->setAdvancedSearch("y_" . $FldParm, $FldVal2);
	$dbo_cliente->setAdvancedSearch("w_" . $FldParm, $FldOpr2);
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`CodigoCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`RazonSocialCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`CuitCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`IngBrutosCli` LIKE '%" . $sKeyword . "%' OR ";
	if (is_numeric($sKeyword)) $sql .= "`Regis_IvaC` = " . $sKeyword . " OR ";
	if (is_numeric($sKeyword)) $sql .= "`Regis_ListaPrec` = " . $sKeyword . " OR ";
	$sql .= "`emailCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`RazonSocialFlete` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Direccion` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`BarrioCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`LocalidadCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`DescrProvincia` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`CodigoPostalCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`DescrPais` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`Telefono` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`FaxCli` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`PaginaWebCli` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $dbo_cliente;
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
		$dbo_cliente->setBasicSearchKeyword($sSearchKeyword);
		$dbo_cliente->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $dbo_cliente;
	$sSrchWhere = "";
	$dbo_cliente->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();

	// Clear advanced search parameters
	ResetAdvancedSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $dbo_cliente;
	$dbo_cliente->setBasicSearchKeyword("");
	$dbo_cliente->setBasicSearchType("");
}

// Clear all advanced search parameters
function ResetAdvancedSearchParms() {

	// Clear advanced search parameters
	global $dbo_cliente;
	$dbo_cliente->setAdvancedSearch("x_CodigoCli", "");
	$dbo_cliente->setAdvancedSearch("z_CodigoCli", "");
	$dbo_cliente->setAdvancedSearch("x_RazonSocialCli", "");
	$dbo_cliente->setAdvancedSearch("z_RazonSocialCli", "");
	$dbo_cliente->setAdvancedSearch("x_CuitCli", "");
	$dbo_cliente->setAdvancedSearch("z_CuitCli", "");
	$dbo_cliente->setAdvancedSearch("x_IngBrutosCli", "");
	$dbo_cliente->setAdvancedSearch("z_IngBrutosCli", "");
	$dbo_cliente->setAdvancedSearch("x_Regis_IvaC", "");
	$dbo_cliente->setAdvancedSearch("z_Regis_IvaC", "");
	$dbo_cliente->setAdvancedSearch("x_Regis_ListaPrec", "");
	$dbo_cliente->setAdvancedSearch("z_Regis_ListaPrec", "");
	$dbo_cliente->setAdvancedSearch("x_emailCli", "");
	$dbo_cliente->setAdvancedSearch("z_emailCli", "");
	$dbo_cliente->setAdvancedSearch("x_RazonSocialFlete", "");
	$dbo_cliente->setAdvancedSearch("z_RazonSocialFlete", "");
	$dbo_cliente->setAdvancedSearch("x_Direccion", "");
	$dbo_cliente->setAdvancedSearch("z_Direccion", "");
	$dbo_cliente->setAdvancedSearch("x_BarrioCli", "");
	$dbo_cliente->setAdvancedSearch("z_BarrioCli", "");
	$dbo_cliente->setAdvancedSearch("x_LocalidadCli", "");
	$dbo_cliente->setAdvancedSearch("z_LocalidadCli", "");
	$dbo_cliente->setAdvancedSearch("x_DescrProvincia", "");
	$dbo_cliente->setAdvancedSearch("z_DescrProvincia", "");
	$dbo_cliente->setAdvancedSearch("x_CodigoPostalCli", "");
	$dbo_cliente->setAdvancedSearch("z_CodigoPostalCli", "");
	$dbo_cliente->setAdvancedSearch("x_DescrPais", "");
	$dbo_cliente->setAdvancedSearch("z_DescrPais", "");
	$dbo_cliente->setAdvancedSearch("x_Telefono", "");
	$dbo_cliente->setAdvancedSearch("z_Telefono", "");
	$dbo_cliente->setAdvancedSearch("x_FaxCli", "");
	$dbo_cliente->setAdvancedSearch("z_FaxCli", "");
	$dbo_cliente->setAdvancedSearch("x_PaginaWebCli", "");
	$dbo_cliente->setAdvancedSearch("z_PaginaWebCli", "");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $dbo_cliente;
	$sSrchWhere = $dbo_cliente->getSearchWhere();

	// Restore advanced search settings
	RestoreAdvancedSearchParms();
}

// Restore all advanced search parameters
function RestoreAdvancedSearchParms() {

	// Restore advanced search parms
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $dbo_cliente;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$dbo_cliente->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$dbo_cliente->CurrentOrderType = @$_GET["ordertype"];

		// Field CodigoCli
		$dbo_cliente->UpdateSort($dbo_cliente->CodigoCli, $bCtrl);

		// Field RazonSocialCli
		$dbo_cliente->UpdateSort($dbo_cliente->RazonSocialCli, $bCtrl);

		// Field CuitCli
		$dbo_cliente->UpdateSort($dbo_cliente->CuitCli, $bCtrl);

		// Field IngBrutosCli
		$dbo_cliente->UpdateSort($dbo_cliente->IngBrutosCli, $bCtrl);

		// Field Regis_IvaC
		$dbo_cliente->UpdateSort($dbo_cliente->Regis_IvaC, $bCtrl);

		// Field Regis_ListaPrec
		$dbo_cliente->UpdateSort($dbo_cliente->Regis_ListaPrec, $bCtrl);

		// Field emailCli
		$dbo_cliente->UpdateSort($dbo_cliente->emailCli, $bCtrl);

		// Field RazonSocialFlete
		$dbo_cliente->UpdateSort($dbo_cliente->RazonSocialFlete, $bCtrl);

		// Field Direccion
		$dbo_cliente->UpdateSort($dbo_cliente->Direccion, $bCtrl);

		// Field BarrioCli
		$dbo_cliente->UpdateSort($dbo_cliente->BarrioCli, $bCtrl);

		// Field LocalidadCli
		$dbo_cliente->UpdateSort($dbo_cliente->LocalidadCli, $bCtrl);

		// Field DescrProvincia
		$dbo_cliente->UpdateSort($dbo_cliente->DescrProvincia, $bCtrl);

		// Field CodigoPostalCli
		$dbo_cliente->UpdateSort($dbo_cliente->CodigoPostalCli, $bCtrl);

		// Field DescrPais
		$dbo_cliente->UpdateSort($dbo_cliente->DescrPais, $bCtrl);

		// Field Telefono
		$dbo_cliente->UpdateSort($dbo_cliente->Telefono, $bCtrl);

		// Field FaxCli
		$dbo_cliente->UpdateSort($dbo_cliente->FaxCli, $bCtrl);

		// Field PaginaWebCli
		$dbo_cliente->UpdateSort($dbo_cliente->PaginaWebCli, $bCtrl);
		$dbo_cliente->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $dbo_cliente->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($dbo_cliente->SqlOrderBy() <> "") {
			$sOrderBy = $dbo_cliente->SqlOrderBy();
			$dbo_cliente->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $dbo_cliente;

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
			$dbo_cliente->setSessionOrderBy($sOrderBy);
			$dbo_cliente->CodigoCli->setSort("");
			$dbo_cliente->RazonSocialCli->setSort("");
			$dbo_cliente->CuitCli->setSort("");
			$dbo_cliente->IngBrutosCli->setSort("");
			$dbo_cliente->Regis_IvaC->setSort("");
			$dbo_cliente->Regis_ListaPrec->setSort("");
			$dbo_cliente->emailCli->setSort("");
			$dbo_cliente->RazonSocialFlete->setSort("");
			$dbo_cliente->Direccion->setSort("");
			$dbo_cliente->BarrioCli->setSort("");
			$dbo_cliente->LocalidadCli->setSort("");
			$dbo_cliente->DescrProvincia->setSort("");
			$dbo_cliente->CodigoPostalCli->setSort("");
			$dbo_cliente->DescrPais->setSort("");
			$dbo_cliente->Telefono->setSort("");
			$dbo_cliente->FaxCli->setSort("");
			$dbo_cliente->PaginaWebCli->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$dbo_cliente->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_cliente;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_cliente->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_cliente->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_cliente->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_cliente->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_cliente;

	// Call Recordset Selecting event
	$dbo_cliente->Recordset_Selecting($dbo_cliente->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_cliente->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_cliente->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_cliente;
	$sFilter = $dbo_cliente->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($dbo_cliente->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_cliente->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_cliente->CurrentFilter = $sFilter;
	$sSql = $dbo_cliente->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_cliente->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_cliente;
	$dbo_cliente->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$dbo_cliente->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
	$dbo_cliente->CuitCli->setDbValue($rs->fields('CuitCli'));
	$dbo_cliente->IngBrutosCli->setDbValue($rs->fields('IngBrutosCli'));
	$dbo_cliente->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_cliente->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_cliente->emailCli->setDbValue($rs->fields('emailCli'));
	$dbo_cliente->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
	$dbo_cliente->Direccion->setDbValue($rs->fields('Direccion'));
	$dbo_cliente->BarrioCli->setDbValue($rs->fields('BarrioCli'));
	$dbo_cliente->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
	$dbo_cliente->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
	$dbo_cliente->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
	$dbo_cliente->DescrPais->setDbValue($rs->fields('DescrPais'));
	$dbo_cliente->Telefono->setDbValue($rs->fields('Telefono'));
	$dbo_cliente->FaxCli->setDbValue($rs->fields('FaxCli'));
	$dbo_cliente->PaginaWebCli->setDbValue($rs->fields('PaginaWebCli'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_cliente;

	// Call Row Rendering event
	$dbo_cliente->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$dbo_cliente->CodigoCli->CellCssStyle = "";
	$dbo_cliente->CodigoCli->CellCssClass = "";

	// RazonSocialCli
	$dbo_cliente->RazonSocialCli->CellCssStyle = "";
	$dbo_cliente->RazonSocialCli->CellCssClass = "";

	// CuitCli
	$dbo_cliente->CuitCli->CellCssStyle = "";
	$dbo_cliente->CuitCli->CellCssClass = "";

	// IngBrutosCli
	$dbo_cliente->IngBrutosCli->CellCssStyle = "";
	$dbo_cliente->IngBrutosCli->CellCssClass = "";

	// Regis_IvaC
	$dbo_cliente->Regis_IvaC->CellCssStyle = "";
	$dbo_cliente->Regis_IvaC->CellCssClass = "";

	// Regis_ListaPrec
	$dbo_cliente->Regis_ListaPrec->CellCssStyle = "";
	$dbo_cliente->Regis_ListaPrec->CellCssClass = "";

	// emailCli
	$dbo_cliente->emailCli->CellCssStyle = "";
	$dbo_cliente->emailCli->CellCssClass = "";

	// RazonSocialFlete
	$dbo_cliente->RazonSocialFlete->CellCssStyle = "";
	$dbo_cliente->RazonSocialFlete->CellCssClass = "";

	// Direccion
	$dbo_cliente->Direccion->CellCssStyle = "";
	$dbo_cliente->Direccion->CellCssClass = "";

	// BarrioCli
	$dbo_cliente->BarrioCli->CellCssStyle = "";
	$dbo_cliente->BarrioCli->CellCssClass = "";

	// LocalidadCli
	$dbo_cliente->LocalidadCli->CellCssStyle = "";
	$dbo_cliente->LocalidadCli->CellCssClass = "";

	// DescrProvincia
	$dbo_cliente->DescrProvincia->CellCssStyle = "";
	$dbo_cliente->DescrProvincia->CellCssClass = "";

	// CodigoPostalCli
	$dbo_cliente->CodigoPostalCli->CellCssStyle = "";
	$dbo_cliente->CodigoPostalCli->CellCssClass = "";

	// DescrPais
	$dbo_cliente->DescrPais->CellCssStyle = "";
	$dbo_cliente->DescrPais->CellCssClass = "";

	// Telefono
	$dbo_cliente->Telefono->CellCssStyle = "";
	$dbo_cliente->Telefono->CellCssClass = "";

	// FaxCli
	$dbo_cliente->FaxCli->CellCssStyle = "";
	$dbo_cliente->FaxCli->CellCssClass = "";

	// PaginaWebCli
	$dbo_cliente->PaginaWebCli->CellCssStyle = "";
	$dbo_cliente->PaginaWebCli->CellCssClass = "";
	if ($dbo_cliente->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		$dbo_cliente->CodigoCli->ViewValue = $dbo_cliente->CodigoCli->CurrentValue;
		$dbo_cliente->CodigoCli->CssStyle = "";
		$dbo_cliente->CodigoCli->CssClass = "";
		$dbo_cliente->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->ViewValue = $dbo_cliente->RazonSocialCli->CurrentValue;
		$dbo_cliente->RazonSocialCli->CssStyle = "";
		$dbo_cliente->RazonSocialCli->CssClass = "";
		$dbo_cliente->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$dbo_cliente->CuitCli->ViewValue = $dbo_cliente->CuitCli->CurrentValue;
		$dbo_cliente->CuitCli->CssStyle = "";
		$dbo_cliente->CuitCli->CssClass = "";
		$dbo_cliente->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->ViewValue = $dbo_cliente->IngBrutosCli->CurrentValue;
		$dbo_cliente->IngBrutosCli->CssStyle = "";
		$dbo_cliente->IngBrutosCli->CssClass = "";
		$dbo_cliente->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		if (!is_null($dbo_cliente->Regis_IvaC->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrIvaC` FROM `dbo_ivacondicion` WHERE `Regis_IvaC` = " . ew_AdjustSql($dbo_cliente->Regis_IvaC->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_IvaC->ViewValue = $rswrk->fields('DescrIvaC');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_IvaC->ViewValue = $dbo_cliente->Regis_IvaC->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_IvaC->ViewValue = NULL;
		}
		$dbo_cliente->Regis_IvaC->CssStyle = "";
		$dbo_cliente->Regis_IvaC->CssClass = "";
		$dbo_cliente->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		if (!is_null($dbo_cliente->Regis_ListaPrec->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios` WHERE `Regis_ListaPrec` = " . ew_AdjustSql($dbo_cliente->Regis_ListaPrec->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_ListaPrec->ViewValue = $rswrk->fields('DescrListaPrec');
					$dbo_cliente->Regis_ListaPrec->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigListaPrec');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_ListaPrec->ViewValue = $dbo_cliente->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_ListaPrec->ViewValue = NULL;
		}
		$dbo_cliente->Regis_ListaPrec->CssStyle = "";
		$dbo_cliente->Regis_ListaPrec->CssClass = "";
		$dbo_cliente->Regis_ListaPrec->ViewCustomAttributes = "";

		// emailCli
		$dbo_cliente->emailCli->ViewValue = $dbo_cliente->emailCli->CurrentValue;
		$dbo_cliente->emailCli->CssStyle = "";
		$dbo_cliente->emailCli->CssClass = "";
		$dbo_cliente->emailCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->ViewValue = $dbo_cliente->RazonSocialFlete->CurrentValue;
		$dbo_cliente->RazonSocialFlete->CssStyle = "";
		$dbo_cliente->RazonSocialFlete->CssClass = "";
		$dbo_cliente->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$dbo_cliente->Direccion->ViewValue = $dbo_cliente->Direccion->CurrentValue;
		$dbo_cliente->Direccion->CssStyle = "";
		$dbo_cliente->Direccion->CssClass = "";
		$dbo_cliente->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->ViewValue = $dbo_cliente->BarrioCli->CurrentValue;
		$dbo_cliente->BarrioCli->CssStyle = "";
		$dbo_cliente->BarrioCli->CssClass = "";
		$dbo_cliente->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->ViewValue = $dbo_cliente->LocalidadCli->CurrentValue;
		$dbo_cliente->LocalidadCli->CssStyle = "";
		$dbo_cliente->LocalidadCli->CssClass = "";
		$dbo_cliente->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->ViewValue = $dbo_cliente->DescrProvincia->CurrentValue;
		$dbo_cliente->DescrProvincia->CssStyle = "";
		$dbo_cliente->DescrProvincia->CssClass = "";
		$dbo_cliente->DescrProvincia->ViewCustomAttributes = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->ViewValue = $dbo_cliente->CodigoPostalCli->CurrentValue;
		$dbo_cliente->CodigoPostalCli->CssStyle = "";
		$dbo_cliente->CodigoPostalCli->CssClass = "";
		$dbo_cliente->CodigoPostalCli->ViewCustomAttributes = "";

		// DescrPais
		$dbo_cliente->DescrPais->ViewValue = $dbo_cliente->DescrPais->CurrentValue;
		$dbo_cliente->DescrPais->CssStyle = "";
		$dbo_cliente->DescrPais->CssClass = "";
		$dbo_cliente->DescrPais->ViewCustomAttributes = "";

		// Telefono
		$dbo_cliente->Telefono->ViewValue = $dbo_cliente->Telefono->CurrentValue;
		$dbo_cliente->Telefono->CssStyle = "";
		$dbo_cliente->Telefono->CssClass = "";
		$dbo_cliente->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$dbo_cliente->FaxCli->ViewValue = $dbo_cliente->FaxCli->CurrentValue;
		$dbo_cliente->FaxCli->CssStyle = "";
		$dbo_cliente->FaxCli->CssClass = "";
		$dbo_cliente->FaxCli->ViewCustomAttributes = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->ViewValue = $dbo_cliente->PaginaWebCli->CurrentValue;
		$dbo_cliente->PaginaWebCli->CssStyle = "";
		$dbo_cliente->PaginaWebCli->CssClass = "";
		$dbo_cliente->PaginaWebCli->ViewCustomAttributes = "";

		// CodigoCli
		$dbo_cliente->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->HrefValue = "";

		// CuitCli
		$dbo_cliente->CuitCli->HrefValue = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->HrefValue = "";

		// Regis_IvaC
		$dbo_cliente->Regis_IvaC->HrefValue = "";

		// Regis_ListaPrec
		$dbo_cliente->Regis_ListaPrec->HrefValue = "";

		// emailCli
		$dbo_cliente->emailCli->HrefValue = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->HrefValue = "";

		// Direccion
		$dbo_cliente->Direccion->HrefValue = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->HrefValue = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->HrefValue = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->HrefValue = "";

		// DescrPais
		$dbo_cliente->DescrPais->HrefValue = "";

		// Telefono
		$dbo_cliente->Telefono->HrefValue = "";

		// FaxCli
		$dbo_cliente->FaxCli->HrefValue = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->HrefValue = "";
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_cliente->Row_Rendered();
}
?>
<?php

// Load advanced search
function LoadAdvancedSearch() {
	global $dbo_cliente;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_cliente;
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
	if ($dbo_cliente->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_cliente->Export == "csv") {
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "RazonSocialCli" . ",";
		$sCsvStr .= "CuitCli" . ",";
		$sCsvStr .= "IngBrutosCli" . ",";
		$sCsvStr .= "Regis_IvaC" . ",";
		$sCsvStr .= "Regis_ListaPrec" . ",";
		$sCsvStr .= "emailCli" . ",";
		$sCsvStr .= "RazonSocialFlete" . ",";
		$sCsvStr .= "Direccion" . ",";
		$sCsvStr .= "BarrioCli" . ",";
		$sCsvStr .= "LocalidadCli" . ",";
		$sCsvStr .= "DescrProvincia" . ",";
		$sCsvStr .= "CodigoPostalCli" . ",";
		$sCsvStr .= "DescrPais" . ",";
		$sCsvStr .= "Telefono" . ",";
		$sCsvStr .= "FaxCli" . ",";
		$sCsvStr .= "PaginaWebCli" . ",";
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
			if ($dbo_cliente->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodigoCli', $dbo_cliente->CodigoCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialCli', $dbo_cliente->RazonSocialCli->CurrentValue);
				$XmlDoc->AddField('CuitCli', $dbo_cliente->CuitCli->CurrentValue);
				$XmlDoc->AddField('IngBrutosCli', $dbo_cliente->IngBrutosCli->CurrentValue);
				$XmlDoc->AddField('Regis_IvaC', $dbo_cliente->Regis_IvaC->CurrentValue);
				$XmlDoc->AddField('Regis_ListaPrec', $dbo_cliente->Regis_ListaPrec->CurrentValue);
				$XmlDoc->AddField('emailCli', $dbo_cliente->emailCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialFlete', $dbo_cliente->RazonSocialFlete->CurrentValue);
				$XmlDoc->AddField('Direccion', $dbo_cliente->Direccion->CurrentValue);
				$XmlDoc->AddField('BarrioCli', $dbo_cliente->BarrioCli->CurrentValue);
				$XmlDoc->AddField('LocalidadCli', $dbo_cliente->LocalidadCli->CurrentValue);
				$XmlDoc->AddField('DescrProvincia', $dbo_cliente->DescrProvincia->CurrentValue);
				$XmlDoc->AddField('CodigoPostalCli', $dbo_cliente->CodigoPostalCli->CurrentValue);
				$XmlDoc->AddField('DescrPais', $dbo_cliente->DescrPais->CurrentValue);
				$XmlDoc->AddField('Telefono', $dbo_cliente->Telefono->CurrentValue);
				$XmlDoc->AddField('FaxCli', $dbo_cliente->FaxCli->CurrentValue);
				$XmlDoc->AddField('PaginaWebCli', $dbo_cliente->PaginaWebCli->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_cliente->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->RazonSocialCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CuitCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->IngBrutosCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Regis_IvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Regis_ListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->emailCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->RazonSocialFlete->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Direccion->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->BarrioCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->LocalidadCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->DescrProvincia->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CodigoPostalCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->DescrPais->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Telefono->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->FaxCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->PaginaWebCli->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_cliente->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_cliente->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Page Load event
function Page_Load() {
    echo "<ul><li>Recuerde que los datos modificados o ingresados en esta tabla serán eliminados la próxima vez que se ejecute el exportador.</li></ul>";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
