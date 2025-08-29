<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
define("EW_TABLE_NAME", 'Pedidos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "Pedidosinfo.php" ?>
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
$Pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $Pedidos->Export; // Get export parameter, used in header
$sExportFile = $Pedidos->TableVar; // Get export file, used in header
?>
<?php
if ($Pedidos->Export == "html") {

	// Printer friendly, no action required
}
if ($Pedidos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($Pedidos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($Pedidos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($Pedidos->Export == "csv") {
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
	$Pedidos->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$Pedidos->setStartRecordNumber($nStartRec);
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
$Pedidos->setSessionWhere($sFilter);
$Pedidos->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($Pedidos->Export == "xml" || $Pedidos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$Pedidos->setReturnUrl("Pedidoslist.php");
?>
<?php include "header.php" ?>
<?php if ($Pedidos->Export == "") { ?>
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
<?php if ($Pedidos->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $Pedidos->Export <> "");
$bSelectLimit = ($Pedidos->Export == "" && $Pedidos->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $Pedidos->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Vista de Pedidos
<?php if ($Pedidos->Export == "") { ?>
&nbsp;&nbsp;<a href="Pedidoslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="Pedidoslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Pedidoslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="Pedidoslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="Pedidoslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($Pedidos->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($Pedidos->getBasicSearchType() == "") $Pedidos->setBasicSearchType("AND"); ?>

<form name="fPedidoslistsrch" id="fPedidoslistsrch" action="Pedidoslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($Pedidos->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="Pedidoslist.php?cmd=reset">Mostrar todos</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($Pedidos->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($Pedidos->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($Pedidos->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($Pedidos->Export == "") { ?>
<form action="Pedidoslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="Pedidoslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form method="post" name="fPedidoslist" id="fPedidoslist">
<?php if ($Pedidos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
	</span></td></tr>
</table>
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<table id="ewlistmain" class="ewTable">
<?php
	$OptionCnt = 0;
?>
	<!-- Table header -->
	<tr class="ewTableHeader">
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
ID Pedido
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('idPedido') ?>&ordertype=<?php echo $Pedidos->idPedido->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID Pedido<?php if ($Pedidos->idPedido->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->idPedido->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Código Artículo
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('CodInternoArti') ?>&ordertype=<?php echo $Pedidos->CodInternoArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Código Artículo&nbsp;(*)<?php if ($Pedidos->CodInternoArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->CodInternoArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Precio
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('precio') ?>&ordertype=<?php echo $Pedidos->precio->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Precio<?php if ($Pedidos->precio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->precio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Cantidad
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('cantidad') ?>&ordertype=<?php echo $Pedidos->cantidad->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Cantidad<?php if ($Pedidos->cantidad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->cantidad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Tasa Iva
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('TasaIva') ?>&ordertype=<?php echo $Pedidos->TasaIva->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Tasa Iva<?php if ($Pedidos->TasaIva->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->TasaIva->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Código Cliente
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('CodigoCli') ?>&ordertype=<?php echo $Pedidos->CodigoCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Código Cliente<?php if ($Pedidos->CodigoCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->CodigoCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Razon Social
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('RazonSocialCli') ?>&ordertype=<?php echo $Pedidos->RazonSocialCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Razon Social&nbsp;(*)<?php if ($Pedidos->RazonSocialCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->RazonSocialCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
CUIT
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('CuitCli') ?>&ordertype=<?php echo $Pedidos->CuitCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">CUIT&nbsp;(*)<?php if ($Pedidos->CuitCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->CuitCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Razon Social Flete
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('RazonSocialFlete') ?>&ordertype=<?php echo $Pedidos->RazonSocialFlete->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Razon Social Flete&nbsp;(*)<?php if ($Pedidos->RazonSocialFlete->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->RazonSocialFlete->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Dirección
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('Direccion') ?>&ordertype=<?php echo $Pedidos->Direccion->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Dirección&nbsp;(*)<?php if ($Pedidos->Direccion->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->Direccion->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Barrio
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('BarrioCli') ?>&ordertype=<?php echo $Pedidos->BarrioCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Barrio&nbsp;(*)<?php if ($Pedidos->BarrioCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->BarrioCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Localidad
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('LocalidadCli') ?>&ordertype=<?php echo $Pedidos->LocalidadCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Localidad&nbsp;(*)<?php if ($Pedidos->LocalidadCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->LocalidadCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Provincia
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('DescrProvincia') ?>&ordertype=<?php echo $Pedidos->DescrProvincia->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Provincia&nbsp;(*)<?php if ($Pedidos->DescrProvincia->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->DescrProvincia->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
País
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('DescrPais') ?>&ordertype=<?php echo $Pedidos->DescrPais->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">País&nbsp;(*)<?php if ($Pedidos->DescrPais->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->DescrPais->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Codigo Postal
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('CodigoPostalCli') ?>&ordertype=<?php echo $Pedidos->CodigoPostalCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Codigo Postal&nbsp;(*)<?php if ($Pedidos->CodigoPostalCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->CodigoPostalCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Teléfono
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('Telefono') ?>&ordertype=<?php echo $Pedidos->Telefono->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Teléfono&nbsp;(*)<?php if ($Pedidos->Telefono->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->Telefono->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Fax
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('FaxCli') ?>&ordertype=<?php echo $Pedidos->FaxCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Fax&nbsp;(*)<?php if ($Pedidos->FaxCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->FaxCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
EMail
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('emailCli') ?>&ordertype=<?php echo $Pedidos->emailCli->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">EMail&nbsp;(*)<?php if ($Pedidos->emailCli->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->emailCli->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Condición IVA
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('DescrIvaC') ?>&ordertype=<?php echo $Pedidos->DescrIvaC->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Condición IVA&nbsp;(*)<?php if ($Pedidos->DescrIvaC->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->DescrIvaC->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($Pedidos->Export <> "") { ?>
Lista de Precios
<?php } else { ?>
	<a href="Pedidoslist.php?order=<?php echo urlencode('DescrListaPrec') ?>&ordertype=<?php echo $Pedidos->DescrListaPrec->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Lista de Precios&nbsp;(*)<?php if ($Pedidos->DescrListaPrec->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Pedidos->DescrListaPrec->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($Pedidos->Export == "") { ?>
<?php } ?>
	</tr>
<?php
if (defined("EW_EXPORT_ALL") && $Pedidos->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$Pedidos->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$Pedidos->CssClass = "ewTableRow";
	$Pedidos->CssStyle = "";

	// Init row event
	$Pedidos->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$Pedidos->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$Pedidos->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $Pedidos->DisplayAttributes() ?>>
		<!-- idPedido -->
		<td<?php echo $Pedidos->idPedido->CellAttributes() ?>>
<div<?php echo $Pedidos->idPedido->ViewAttributes() ?>><?php echo $Pedidos->idPedido->ViewValue ?></div>
</td>
		<!-- CodInternoArti -->
		<td<?php echo $Pedidos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $Pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $Pedidos->CodInternoArti->ViewValue ?></div>
</td>
		<!-- precio -->
		<td<?php echo $Pedidos->precio->CellAttributes() ?>>
<div<?php echo $Pedidos->precio->ViewAttributes() ?>><?php echo $Pedidos->precio->ViewValue ?></div>
</td>
		<!-- cantidad -->
		<td<?php echo $Pedidos->cantidad->CellAttributes() ?>>
<div<?php echo $Pedidos->cantidad->ViewAttributes() ?>><?php echo $Pedidos->cantidad->ViewValue ?></div>
</td>
		<!-- TasaIva -->
		<td<?php echo $Pedidos->TasaIva->CellAttributes() ?>>
<div<?php echo $Pedidos->TasaIva->ViewAttributes() ?>><?php echo $Pedidos->TasaIva->ViewValue ?></div>
</td>
		<!-- CodigoCli -->
		<td<?php echo $Pedidos->CodigoCli->CellAttributes() ?>>
<div<?php echo $Pedidos->CodigoCli->ViewAttributes() ?>><?php echo $Pedidos->CodigoCli->ViewValue ?></div>
</td>
		<!-- RazonSocialCli -->
		<td<?php echo $Pedidos->RazonSocialCli->CellAttributes() ?>>
<div<?php echo $Pedidos->RazonSocialCli->ViewAttributes() ?>><?php echo $Pedidos->RazonSocialCli->ViewValue ?></div>
</td>
		<!-- CuitCli -->
		<td<?php echo $Pedidos->CuitCli->CellAttributes() ?>>
<div<?php echo $Pedidos->CuitCli->ViewAttributes() ?>><?php echo $Pedidos->CuitCli->ViewValue ?></div>
</td>
		<!-- RazonSocialFlete -->
		<td<?php echo $Pedidos->RazonSocialFlete->CellAttributes() ?>>
<div<?php echo $Pedidos->RazonSocialFlete->ViewAttributes() ?>><?php echo $Pedidos->RazonSocialFlete->ViewValue ?></div>
</td>
		<!-- Direccion -->
		<td<?php echo $Pedidos->Direccion->CellAttributes() ?>>
<div<?php echo $Pedidos->Direccion->ViewAttributes() ?>><?php echo $Pedidos->Direccion->ViewValue ?></div>
</td>
		<!-- BarrioCli -->
		<td<?php echo $Pedidos->BarrioCli->CellAttributes() ?>>
<div<?php echo $Pedidos->BarrioCli->ViewAttributes() ?>><?php echo $Pedidos->BarrioCli->ViewValue ?></div>
</td>
		<!-- LocalidadCli -->
		<td<?php echo $Pedidos->LocalidadCli->CellAttributes() ?>>
<div<?php echo $Pedidos->LocalidadCli->ViewAttributes() ?>><?php echo $Pedidos->LocalidadCli->ViewValue ?></div>
</td>
		<!-- DescrProvincia -->
		<td<?php echo $Pedidos->DescrProvincia->CellAttributes() ?>>
<div<?php echo $Pedidos->DescrProvincia->ViewAttributes() ?>><?php echo $Pedidos->DescrProvincia->ViewValue ?></div>
</td>
		<!-- DescrPais -->
		<td<?php echo $Pedidos->DescrPais->CellAttributes() ?>>
<div<?php echo $Pedidos->DescrPais->ViewAttributes() ?>><?php echo $Pedidos->DescrPais->ViewValue ?></div>
</td>
		<!-- CodigoPostalCli -->
		<td<?php echo $Pedidos->CodigoPostalCli->CellAttributes() ?>>
<div<?php echo $Pedidos->CodigoPostalCli->ViewAttributes() ?>><?php echo $Pedidos->CodigoPostalCli->ViewValue ?></div>
</td>
		<!-- Telefono -->
		<td<?php echo $Pedidos->Telefono->CellAttributes() ?>>
<div<?php echo $Pedidos->Telefono->ViewAttributes() ?>><?php echo $Pedidos->Telefono->ViewValue ?></div>
</td>
		<!-- FaxCli -->
		<td<?php echo $Pedidos->FaxCli->CellAttributes() ?>>
<div<?php echo $Pedidos->FaxCli->ViewAttributes() ?>><?php echo $Pedidos->FaxCli->ViewValue ?></div>
</td>
		<!-- emailCli -->
		<td<?php echo $Pedidos->emailCli->CellAttributes() ?>>
<div<?php echo $Pedidos->emailCli->ViewAttributes() ?>><?php echo $Pedidos->emailCli->ViewValue ?></div>
</td>
		<!-- DescrIvaC -->
		<td<?php echo $Pedidos->DescrIvaC->CellAttributes() ?>>
<div<?php echo $Pedidos->DescrIvaC->ViewAttributes() ?>><?php echo $Pedidos->DescrIvaC->ViewValue ?></div>
</td>
		<!-- DescrListaPrec -->
		<td<?php echo $Pedidos->DescrListaPrec->CellAttributes() ?>>
<div<?php echo $Pedidos->DescrListaPrec->ViewAttributes() ?>><?php echo $Pedidos->DescrListaPrec->ViewValue ?></div>
</td>
<?php if ($Pedidos->Export == "") { ?>
<?php } ?>
	</tr>
<?php
	}
	$rs->MoveNext();
}
?>
</table>
<?php if ($Pedidos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
	</span></td></tr>
</table>
<?php } ?>
<?php } ?>
</form>
<?php

// Close recordset and connection
if ($rs) $rs->Close();
?>
<?php if ($Pedidos->Export == "") { ?>
<form action="Pedidoslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="Pedidoslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="Pedidoslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($Pedidos->Export == "") { ?>
<?php } ?>
<?php if ($Pedidos->Export == "") { ?>
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
	$sql .= "walger_items_pedidos.CodInternoArti LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "walger_pedidos.CodigoCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.RazonSocialCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.CuitCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.RazonSocialFlete LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.Direccion LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.BarrioCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.LocalidadCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.DescrProvincia LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.DescrPais LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.CodigoPostalCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.Telefono LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.FaxCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_cliente.emailCli LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_ivacondicion.DescrIvaC LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "dbo_listaprecios.DescrListaPrec LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $Pedidos;
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
		$Pedidos->setBasicSearchKeyword($sSearchKeyword);
		$Pedidos->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $Pedidos;
	$sSrchWhere = "";
	$Pedidos->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $Pedidos;
	$Pedidos->setBasicSearchKeyword("");
	$Pedidos->setBasicSearchType("");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $Pedidos;
	$sSrchWhere = $Pedidos->getSearchWhere();
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $Pedidos;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$Pedidos->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$Pedidos->CurrentOrderType = @$_GET["ordertype"];

		// Field idPedido
		$Pedidos->UpdateSort($Pedidos->idPedido, $bCtrl);

		// Field CodInternoArti
		$Pedidos->UpdateSort($Pedidos->CodInternoArti, $bCtrl);

		// Field precio
		$Pedidos->UpdateSort($Pedidos->precio, $bCtrl);

		// Field cantidad
		$Pedidos->UpdateSort($Pedidos->cantidad, $bCtrl);

		// Field TasaIva
		$Pedidos->UpdateSort($Pedidos->TasaIva, $bCtrl);

		// Field CodigoCli
		$Pedidos->UpdateSort($Pedidos->CodigoCli, $bCtrl);

		// Field RazonSocialCli
		$Pedidos->UpdateSort($Pedidos->RazonSocialCli, $bCtrl);

		// Field CuitCli
		$Pedidos->UpdateSort($Pedidos->CuitCli, $bCtrl);

		// Field RazonSocialFlete
		$Pedidos->UpdateSort($Pedidos->RazonSocialFlete, $bCtrl);

		// Field Direccion
		$Pedidos->UpdateSort($Pedidos->Direccion, $bCtrl);

		// Field BarrioCli
		$Pedidos->UpdateSort($Pedidos->BarrioCli, $bCtrl);

		// Field LocalidadCli
		$Pedidos->UpdateSort($Pedidos->LocalidadCli, $bCtrl);

		// Field DescrProvincia
		$Pedidos->UpdateSort($Pedidos->DescrProvincia, $bCtrl);

		// Field DescrPais
		$Pedidos->UpdateSort($Pedidos->DescrPais, $bCtrl);

		// Field CodigoPostalCli
		$Pedidos->UpdateSort($Pedidos->CodigoPostalCli, $bCtrl);

		// Field Telefono
		$Pedidos->UpdateSort($Pedidos->Telefono, $bCtrl);

		// Field FaxCli
		$Pedidos->UpdateSort($Pedidos->FaxCli, $bCtrl);

		// Field emailCli
		$Pedidos->UpdateSort($Pedidos->emailCli, $bCtrl);

		// Field DescrIvaC
		$Pedidos->UpdateSort($Pedidos->DescrIvaC, $bCtrl);

		// Field DescrListaPrec
		$Pedidos->UpdateSort($Pedidos->DescrListaPrec, $bCtrl);
		$Pedidos->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $Pedidos->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($Pedidos->SqlOrderBy() <> "") {
			$sOrderBy = $Pedidos->SqlOrderBy();
			$Pedidos->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $Pedidos;

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
			$Pedidos->setSessionOrderBy($sOrderBy);
			$Pedidos->idPedido->setSort("");
			$Pedidos->CodInternoArti->setSort("");
			$Pedidos->precio->setSort("");
			$Pedidos->cantidad->setSort("");
			$Pedidos->TasaIva->setSort("");
			$Pedidos->CodigoCli->setSort("");
			$Pedidos->RazonSocialCli->setSort("");
			$Pedidos->CuitCli->setSort("");
			$Pedidos->RazonSocialFlete->setSort("");
			$Pedidos->Direccion->setSort("");
			$Pedidos->BarrioCli->setSort("");
			$Pedidos->LocalidadCli->setSort("");
			$Pedidos->DescrProvincia->setSort("");
			$Pedidos->DescrPais->setSort("");
			$Pedidos->CodigoPostalCli->setSort("");
			$Pedidos->Telefono->setSort("");
			$Pedidos->FaxCli->setSort("");
			$Pedidos->emailCli->setSort("");
			$Pedidos->DescrIvaC->setSort("");
			$Pedidos->DescrListaPrec->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$Pedidos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $Pedidos;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$Pedidos->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$Pedidos->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $Pedidos->getStartRecordNumber();
		}
	} else {
		$nStartRec = $Pedidos->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$Pedidos->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$Pedidos->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$Pedidos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $Pedidos;

	// Call Recordset Selecting event
	$Pedidos->Recordset_Selecting($Pedidos->CurrentFilter);

	// Load list page sql
	$sSql = $Pedidos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$Pedidos->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $Pedidos;
	$sFilter = $Pedidos->SqlKeyFilter();

	// Call Row Selecting event
	$Pedidos->Row_Selecting($sFilter);

	// Load sql based on filter
	$Pedidos->CurrentFilter = $sFilter;
	$sSql = $Pedidos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$Pedidos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $Pedidos;
	$Pedidos->idPedido->setDbValue($rs->fields('idPedido'));
	$Pedidos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$Pedidos->precio->setDbValue($rs->fields('precio'));
	$Pedidos->cantidad->setDbValue($rs->fields('cantidad'));
	$Pedidos->TasaIva->setDbValue($rs->fields('TasaIva'));
	$Pedidos->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$Pedidos->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
	$Pedidos->CuitCli->setDbValue($rs->fields('CuitCli'));
	$Pedidos->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
	$Pedidos->Direccion->setDbValue($rs->fields('Direccion'));
	$Pedidos->BarrioCli->setDbValue($rs->fields('BarrioCli'));
	$Pedidos->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
	$Pedidos->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
	$Pedidos->DescrPais->setDbValue($rs->fields('DescrPais'));
	$Pedidos->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
	$Pedidos->Telefono->setDbValue($rs->fields('Telefono'));
	$Pedidos->FaxCli->setDbValue($rs->fields('FaxCli'));
	$Pedidos->emailCli->setDbValue($rs->fields('emailCli'));
	$Pedidos->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
	$Pedidos->DescrListaPrec->setDbValue($rs->fields('DescrListaPrec'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $Pedidos;

	// Call Row Rendering event
	$Pedidos->Row_Rendering();

	// Common render codes for all row types
	// idPedido

	$Pedidos->idPedido->CellCssStyle = "";
	$Pedidos->idPedido->CellCssClass = "";

	// CodInternoArti
	$Pedidos->CodInternoArti->CellCssStyle = "";
	$Pedidos->CodInternoArti->CellCssClass = "";

	// precio
	$Pedidos->precio->CellCssStyle = "";
	$Pedidos->precio->CellCssClass = "";

	// cantidad
	$Pedidos->cantidad->CellCssStyle = "";
	$Pedidos->cantidad->CellCssClass = "";

	// TasaIva
	$Pedidos->TasaIva->CellCssStyle = "";
	$Pedidos->TasaIva->CellCssClass = "";

	// CodigoCli
	$Pedidos->CodigoCli->CellCssStyle = "";
	$Pedidos->CodigoCli->CellCssClass = "";

	// RazonSocialCli
	$Pedidos->RazonSocialCli->CellCssStyle = "";
	$Pedidos->RazonSocialCli->CellCssClass = "";

	// CuitCli
	$Pedidos->CuitCli->CellCssStyle = "";
	$Pedidos->CuitCli->CellCssClass = "";

	// RazonSocialFlete
	$Pedidos->RazonSocialFlete->CellCssStyle = "";
	$Pedidos->RazonSocialFlete->CellCssClass = "";

	// Direccion
	$Pedidos->Direccion->CellCssStyle = "";
	$Pedidos->Direccion->CellCssClass = "";

	// BarrioCli
	$Pedidos->BarrioCli->CellCssStyle = "";
	$Pedidos->BarrioCli->CellCssClass = "";

	// LocalidadCli
	$Pedidos->LocalidadCli->CellCssStyle = "";
	$Pedidos->LocalidadCli->CellCssClass = "";

	// DescrProvincia
	$Pedidos->DescrProvincia->CellCssStyle = "";
	$Pedidos->DescrProvincia->CellCssClass = "";

	// DescrPais
	$Pedidos->DescrPais->CellCssStyle = "";
	$Pedidos->DescrPais->CellCssClass = "";

	// CodigoPostalCli
	$Pedidos->CodigoPostalCli->CellCssStyle = "";
	$Pedidos->CodigoPostalCli->CellCssClass = "";

	// Telefono
	$Pedidos->Telefono->CellCssStyle = "";
	$Pedidos->Telefono->CellCssClass = "";

	// FaxCli
	$Pedidos->FaxCli->CellCssStyle = "";
	$Pedidos->FaxCli->CellCssClass = "";

	// emailCli
	$Pedidos->emailCli->CellCssStyle = "";
	$Pedidos->emailCli->CellCssClass = "";

	// DescrIvaC
	$Pedidos->DescrIvaC->CellCssStyle = "";
	$Pedidos->DescrIvaC->CellCssClass = "";

	// DescrListaPrec
	$Pedidos->DescrListaPrec->CellCssStyle = "";
	$Pedidos->DescrListaPrec->CellCssClass = "";
	if ($Pedidos->RowType == EW_ROWTYPE_VIEW) { // View row

		// idPedido
		$Pedidos->idPedido->ViewValue = $Pedidos->idPedido->CurrentValue;
		$Pedidos->idPedido->CssStyle = "";
		$Pedidos->idPedido->CssClass = "";
		$Pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$Pedidos->CodInternoArti->ViewValue = $Pedidos->CodInternoArti->CurrentValue;
		$Pedidos->CodInternoArti->CssStyle = "";
		$Pedidos->CodInternoArti->CssClass = "";
		$Pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$Pedidos->precio->ViewValue = $Pedidos->precio->CurrentValue;
		$Pedidos->precio->CssStyle = "";
		$Pedidos->precio->CssClass = "";
		$Pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$Pedidos->cantidad->ViewValue = $Pedidos->cantidad->CurrentValue;
		$Pedidos->cantidad->CssStyle = "";
		$Pedidos->cantidad->CssClass = "";
		$Pedidos->cantidad->ViewCustomAttributes = "";

		// TasaIva
		$Pedidos->TasaIva->ViewValue = $Pedidos->TasaIva->CurrentValue;
		$Pedidos->TasaIva->CssStyle = "";
		$Pedidos->TasaIva->CssClass = "";
		$Pedidos->TasaIva->ViewCustomAttributes = "";

		// CodigoCli
		if (!is_null($Pedidos->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($Pedidos->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$Pedidos->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$Pedidos->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$Pedidos->CodigoCli->ViewValue = $Pedidos->CodigoCli->CurrentValue;
			}
		} else {
			$Pedidos->CodigoCli->ViewValue = NULL;
		}
		$Pedidos->CodigoCli->CssStyle = "";
		$Pedidos->CodigoCli->CssClass = "";
		$Pedidos->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$Pedidos->RazonSocialCli->ViewValue = $Pedidos->RazonSocialCli->CurrentValue;
		$Pedidos->RazonSocialCli->CssStyle = "";
		$Pedidos->RazonSocialCli->CssClass = "";
		$Pedidos->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$Pedidos->CuitCli->ViewValue = $Pedidos->CuitCli->CurrentValue;
		$Pedidos->CuitCli->CssStyle = "";
		$Pedidos->CuitCli->CssClass = "";
		$Pedidos->CuitCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$Pedidos->RazonSocialFlete->ViewValue = $Pedidos->RazonSocialFlete->CurrentValue;
		$Pedidos->RazonSocialFlete->CssStyle = "";
		$Pedidos->RazonSocialFlete->CssClass = "";
		$Pedidos->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$Pedidos->Direccion->ViewValue = $Pedidos->Direccion->CurrentValue;
		$Pedidos->Direccion->CssStyle = "";
		$Pedidos->Direccion->CssClass = "";
		$Pedidos->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$Pedidos->BarrioCli->ViewValue = $Pedidos->BarrioCli->CurrentValue;
		$Pedidos->BarrioCli->CssStyle = "";
		$Pedidos->BarrioCli->CssClass = "";
		$Pedidos->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$Pedidos->LocalidadCli->ViewValue = $Pedidos->LocalidadCli->CurrentValue;
		$Pedidos->LocalidadCli->CssStyle = "";
		$Pedidos->LocalidadCli->CssClass = "";
		$Pedidos->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$Pedidos->DescrProvincia->ViewValue = $Pedidos->DescrProvincia->CurrentValue;
		$Pedidos->DescrProvincia->CssStyle = "";
		$Pedidos->DescrProvincia->CssClass = "";
		$Pedidos->DescrProvincia->ViewCustomAttributes = "";

		// DescrPais
		$Pedidos->DescrPais->ViewValue = $Pedidos->DescrPais->CurrentValue;
		$Pedidos->DescrPais->CssStyle = "";
		$Pedidos->DescrPais->CssClass = "";
		$Pedidos->DescrPais->ViewCustomAttributes = "";

		// CodigoPostalCli
		$Pedidos->CodigoPostalCli->ViewValue = $Pedidos->CodigoPostalCli->CurrentValue;
		$Pedidos->CodigoPostalCli->CssStyle = "";
		$Pedidos->CodigoPostalCli->CssClass = "";
		$Pedidos->CodigoPostalCli->ViewCustomAttributes = "";

		// Telefono
		$Pedidos->Telefono->ViewValue = $Pedidos->Telefono->CurrentValue;
		$Pedidos->Telefono->CssStyle = "";
		$Pedidos->Telefono->CssClass = "";
		$Pedidos->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$Pedidos->FaxCli->ViewValue = $Pedidos->FaxCli->CurrentValue;
		$Pedidos->FaxCli->CssStyle = "";
		$Pedidos->FaxCli->CssClass = "";
		$Pedidos->FaxCli->ViewCustomAttributes = "";

		// emailCli
		$Pedidos->emailCli->ViewValue = $Pedidos->emailCli->CurrentValue;
		$Pedidos->emailCli->CssStyle = "";
		$Pedidos->emailCli->CssClass = "";
		$Pedidos->emailCli->ViewCustomAttributes = "";

		// DescrIvaC
		$Pedidos->DescrIvaC->ViewValue = $Pedidos->DescrIvaC->CurrentValue;
		$Pedidos->DescrIvaC->CssStyle = "";
		$Pedidos->DescrIvaC->CssClass = "";
		$Pedidos->DescrIvaC->ViewCustomAttributes = "";

		// DescrListaPrec
		$Pedidos->DescrListaPrec->ViewValue = $Pedidos->DescrListaPrec->CurrentValue;
		$Pedidos->DescrListaPrec->CssStyle = "";
		$Pedidos->DescrListaPrec->CssClass = "";
		$Pedidos->DescrListaPrec->ViewCustomAttributes = "";

		// idPedido
		$Pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		$Pedidos->CodInternoArti->HrefValue = "";

		// precio
		$Pedidos->precio->HrefValue = "";

		// cantidad
		$Pedidos->cantidad->HrefValue = "";

		// TasaIva
		$Pedidos->TasaIva->HrefValue = "";

		// CodigoCli
		$Pedidos->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$Pedidos->RazonSocialCli->HrefValue = "";

		// CuitCli
		$Pedidos->CuitCli->HrefValue = "";

		// RazonSocialFlete
		$Pedidos->RazonSocialFlete->HrefValue = "";

		// Direccion
		$Pedidos->Direccion->HrefValue = "";

		// BarrioCli
		$Pedidos->BarrioCli->HrefValue = "";

		// LocalidadCli
		$Pedidos->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$Pedidos->DescrProvincia->HrefValue = "";

		// DescrPais
		$Pedidos->DescrPais->HrefValue = "";

		// CodigoPostalCli
		$Pedidos->CodigoPostalCli->HrefValue = "";

		// Telefono
		$Pedidos->Telefono->HrefValue = "";

		// FaxCli
		$Pedidos->FaxCli->HrefValue = "";

		// emailCli
		$Pedidos->emailCli->HrefValue = "";

		// DescrIvaC
		$Pedidos->DescrIvaC->HrefValue = "";

		// DescrListaPrec
		$Pedidos->DescrListaPrec->HrefValue = "";
	} elseif ($Pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($Pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($Pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$Pedidos->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $Pedidos;
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
	if ($Pedidos->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($Pedidos->Export == "csv") {
		$sCsvStr .= "idPedido" . ",";
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "precio" . ",";
		$sCsvStr .= "cantidad" . ",";
		$sCsvStr .= "TasaIva" . ",";
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "RazonSocialCli" . ",";
		$sCsvStr .= "CuitCli" . ",";
		$sCsvStr .= "RazonSocialFlete" . ",";
		$sCsvStr .= "Direccion" . ",";
		$sCsvStr .= "BarrioCli" . ",";
		$sCsvStr .= "LocalidadCli" . ",";
		$sCsvStr .= "DescrProvincia" . ",";
		$sCsvStr .= "DescrPais" . ",";
		$sCsvStr .= "CodigoPostalCli" . ",";
		$sCsvStr .= "Telefono" . ",";
		$sCsvStr .= "FaxCli" . ",";
		$sCsvStr .= "emailCli" . ",";
		$sCsvStr .= "DescrIvaC" . ",";
		$sCsvStr .= "DescrListaPrec" . ",";
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
			if ($Pedidos->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('idPedido', $Pedidos->idPedido->CurrentValue);
				$XmlDoc->AddField('CodInternoArti', $Pedidos->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('precio', $Pedidos->precio->CurrentValue);
				$XmlDoc->AddField('cantidad', $Pedidos->cantidad->CurrentValue);
				$XmlDoc->AddField('TasaIva', $Pedidos->TasaIva->CurrentValue);
				$XmlDoc->AddField('CodigoCli', $Pedidos->CodigoCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialCli', $Pedidos->RazonSocialCli->CurrentValue);
				$XmlDoc->AddField('CuitCli', $Pedidos->CuitCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialFlete', $Pedidos->RazonSocialFlete->CurrentValue);
				$XmlDoc->AddField('Direccion', $Pedidos->Direccion->CurrentValue);
				$XmlDoc->AddField('BarrioCli', $Pedidos->BarrioCli->CurrentValue);
				$XmlDoc->AddField('LocalidadCli', $Pedidos->LocalidadCli->CurrentValue);
				$XmlDoc->AddField('DescrProvincia', $Pedidos->DescrProvincia->CurrentValue);
				$XmlDoc->AddField('DescrPais', $Pedidos->DescrPais->CurrentValue);
				$XmlDoc->AddField('CodigoPostalCli', $Pedidos->CodigoPostalCli->CurrentValue);
				$XmlDoc->AddField('Telefono', $Pedidos->Telefono->CurrentValue);
				$XmlDoc->AddField('FaxCli', $Pedidos->FaxCli->CurrentValue);
				$XmlDoc->AddField('emailCli', $Pedidos->emailCli->CurrentValue);
				$XmlDoc->AddField('DescrIvaC', $Pedidos->DescrIvaC->CurrentValue);
				$XmlDoc->AddField('DescrListaPrec', $Pedidos->DescrListaPrec->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($Pedidos->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->idPedido->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->precio->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->cantidad->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->TasaIva->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->RazonSocialCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->CuitCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->RazonSocialFlete->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->Direccion->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->BarrioCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->LocalidadCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->DescrProvincia->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->DescrPais->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->CodigoPostalCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->Telefono->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->FaxCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->emailCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->DescrIvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($Pedidos->DescrListaPrec->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($Pedidos->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($Pedidos->Export == "csv") {
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
