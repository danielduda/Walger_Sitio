<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_items_pedidos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_items_pedidosinfo.php" ?>
<?php include "userfn50.php" ?>
<?php include "walger_pedidosinfo.php" ?>
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
$walger_items_pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_items_pedidos->Export; // Get export parameter, used in header
$sExportFile = $walger_items_pedidos->TableVar; // Get export file, used in header
?>
<?php
if ($walger_items_pedidos->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_items_pedidos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_items_pedidos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_items_pedidos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_items_pedidos->Export == "csv") {
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

// Set up master detail parameters
SetUpMasterDetail();

// Check QueryString parameters
if (@$_GET["a"] <> "") {
	$walger_items_pedidos->CurrentAction = $_GET["a"];

	// Clear inline mode
	if ($walger_items_pedidos->CurrentAction == "cancel") {
		ClearInlineMode();
	}

	// Switch to grid edit mode
	if ($walger_items_pedidos->CurrentAction == "gridedit") {
		GridEditMode();
	}

	// Switch to inline edit mode
	if ($walger_items_pedidos->CurrentAction == "edit") {
		InlineEditMode();
	}
} else {

	// Create form object
	$objForm = new cFormObj;
	if (@$_POST["a_list"] <> "") {
		$walger_items_pedidos->CurrentAction = $_POST["a_list"]; // Get action

		// Grid Update
		if ($walger_items_pedidos->CurrentAction == "gridupdate" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
			GridUpdate();
		}

		// Inline Update
		if ($walger_items_pedidos->CurrentAction == "update" && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit") {
			InlineUpdate();
		}
	}
}

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
	$walger_items_pedidos->setSearchWhere($sSrchWhere); // Save to Session
	$nStartRec = 1; // Reset start record counter
	$walger_items_pedidos->setStartRecordNumber($nStartRec);
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

// Load master record
if ($walger_items_pedidos->getMasterFilter() <> "" && $walger_items_pedidos->getCurrentMasterTable() == "walger_pedidos") {
	$rsmaster = $walger_pedidos->LoadRs($sDbMasterFilter);
	$bMasterRecordExists = ($rsmaster && !$rsmaster->EOF);
	if (!$bMasterRecordExists) {
		$walger_items_pedidos->setMasterFilter(""); // Clear master filter
		$walger_items_pedidos->setDetailFilter(""); // Clear detail filter
		$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record found
		Page_Terminate("walger_pedidoslist.php"); // Return to caller
	} else {
		$walger_pedidos->LoadListRowValues($rsmaster);
		$walger_pedidos->RenderListRow();
		$rsmaster->Close();
	}
}

// Set up filter in Session
$walger_items_pedidos->setSessionWhere($sFilter);
$walger_items_pedidos->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Export data only
if ($walger_items_pedidos->Export == "xml" || $walger_items_pedidos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set Return Url
$walger_items_pedidos->setReturnUrl("walger_items_pedidoslist.php");
?>
<?php include "header.php" ?>
<?php if ($walger_items_pedidos->Export == "") { ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "list"; // Page id

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
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Estado"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_fechaEntregado"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Entregado"))
				return false; 
		}
	}
	return true;
}

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
<?php if ($walger_items_pedidos->Export == "") { ?>
<?php
$sMasterReturnUrl = "walger_pedidoslist.php";
if ($walger_items_pedidos->getMasterFilter() <> "" && $walger_items_pedidos->getCurrentMasterTable() == "walger_pedidos") {
	if ($bMasterRecordExists) {
		if ($walger_items_pedidos->getCurrentMasterTable() == $walger_items_pedidos->TableVar) $sMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include "walger_pedidosmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $walger_items_pedidos->Export <> "");
$bSelectLimit = ($walger_items_pedidos->Export == "" && $walger_items_pedidos->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $walger_items_pedidos->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">: Items Pedidos
<?php if ($walger_items_pedidos->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_items_pedidoslist.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_items_pedidoslist.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_items_pedidoslist.php?export=word">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_items_pedidoslist.php?export=xml">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_items_pedidoslist.php?export=csv">Exportar a CSV</a>
<?php } ?>
</span></p>
<?php if ($walger_items_pedidos->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>

<?PHP if (!isset($_GET["psearchtype"])) if ($walger_items_pedidos->getBasicSearchType() == "") $walger_items_pedidos->setBasicSearchType("AND"); ?>

<form name="fwalger_items_pedidoslistsrch" id="fwalger_items_pedidoslistsrch" action="walger_items_pedidoslist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($walger_items_pedidos->getBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="Buscar (*)">&nbsp;
			<a href="walger_items_pedidoslist.php?cmd=reset">Mostrar todos</a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="" <?php if ($walger_items_pedidos->getBasicSearchType() == "") { ?>checked<?php } ?>>Frase exacta&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND" <?php if ($walger_items_pedidos->getBasicSearchType() == "AND") { ?>checked<?php } ?>>Todas las palabras&nbsp;&nbsp;<input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR" <?php if ($walger_items_pedidos->getBasicSearchType() == "OR") { ?>checked<?php } ?>>Cualquier palabra</span></td>
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
<?php if ($walger_items_pedidos->Export == "") { ?>
<form action="walger_items_pedidoslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_items_pedidoslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form name="fwalger_items_pedidoslist" id="fwalger_items_pedidoslist" action="walger_items_pedidoslist.php" method="post">
<?php if ($walger_items_pedidos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($walger_items_pedidos->CurrentAction <> "gridedit") { // Not grid edit mode ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_items_pedidosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($nTotalRecs > 0) { ?>
<a href="walger_items_pedidoslist.php?a=gridedit">Editar todos</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid edit mode ?>
<a href="" onClick="if (ew_ValidateForm(document.fwalger_items_pedidoslist)) document.fwalger_items_pedidoslist.submit();return false;">Guardar</a>&nbsp;&nbsp;
<a href="walger_items_pedidoslist.php?a=cancel">Cancelar</a>&nbsp;&nbsp;
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
?>
	<!-- Table header -->
	<tr class="ewTableHeader">
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
ID Item
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('idItemPedido') ?>&ordertype=<?php echo $walger_items_pedidos->idItemPedido->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID Item<?php if ($walger_items_pedidos->idItemPedido->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->idItemPedido->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
ID Pedido
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('idPedido') ?>&ordertype=<?php echo $walger_items_pedidos->idPedido->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">ID Pedido<?php if ($walger_items_pedidos->idPedido->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->idPedido->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
Artículo
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('CodInternoArti') ?>&ordertype=<?php echo $walger_items_pedidos->CodInternoArti->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Artículo<?php if ($walger_items_pedidos->CodInternoArti->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->CodInternoArti->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
Precio
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('precio') ?>&ordertype=<?php echo $walger_items_pedidos->precio->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Precio<?php if ($walger_items_pedidos->precio->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->precio->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
Cantidad
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('cantidad') ?>&ordertype=<?php echo $walger_items_pedidos->cantidad->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Cantidad<?php if ($walger_items_pedidos->cantidad->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->cantidad->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
Estado
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('estado') ?>&ordertype=<?php echo $walger_items_pedidos->estado->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Estado<?php if ($walger_items_pedidos->estado->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->estado->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top">
<?php if ($walger_items_pedidos->Export <> "") { ?>
Fecha Entregado
<?php } else { ?>
	<a href="walger_items_pedidoslist.php?order=<?php echo urlencode('fechaEntregado') ?>&ordertype=<?php echo $walger_items_pedidos->fechaEntregado->ReverseSort() ?>" onMouseDown="ew_Sort(event, this.href);">Fecha Entregado<?php if ($walger_items_pedidos->fechaEntregado->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($walger_items_pedidos->fechaEntregado->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($walger_items_pedidos->Export == "") { ?>
<?php if ($walger_items_pedidos->CurrentAction <> "gridedit") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap>&nbsp;</td>
<?php } ?>
<?php } ?>
<?php } ?>
	</tr>
<?php
if (defined("EW_EXPORT_ALL") && $walger_items_pedidos->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$walger_items_pedidos->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
$nEditRowCnt = 0;
if ($walger_items_pedidos->CurrentAction == "edit") $RowIndex = 1;
if ($walger_items_pedidos->CurrentAction == "gridedit") $RowIndex = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;
		if ($walger_items_pedidos->CurrentAction == "gridedit") $RowIndex++;

	// Init row class and style
	$walger_items_pedidos->CssClass = "ewTableRow";
	$walger_items_pedidos->CssStyle = "";

	// Init row event
	$walger_items_pedidos->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$walger_items_pedidos->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$walger_items_pedidos->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($walger_items_pedidos->CurrentAction == "edit") {
		if (CheckInlineEditKey() && $nEditRowCnt == 0) { // Inline edit
			$walger_items_pedidos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($walger_items_pedidos->CurrentAction == "gridedit") { // Grid edit
		$walger_items_pedidos->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
		if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT && $walger_items_pedidos->EventCancelled) { // Update failed
			if ($walger_items_pedidos->CurrentAction == "edit") {
				RestoreFormValues(); // Restore form values
			}
			if ($walger_items_pedidos->CurrentAction == "gridedit") {
				RestoreCurrentRowFormValues(); // Restore form values
			}
		}
		if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
			$nEditRowCnt++;
			$walger_items_pedidos->CssClass = "ewTableEditRow";
			$walger_items_pedidos->RowClientEvents = "onmouseover='this.edit=true;ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";
		}
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $walger_items_pedidos->DisplayAttributes() ?>>
		<!-- idItemPedido -->
		<td<?php echo $walger_items_pedidos->idItemPedido->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<div<?php echo $walger_items_pedidos->idItemPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idItemPedido->EditValue ?></div>
<input type="hidden" name="x<?php echo $RowIndex ?>_idItemPedido" id="x<?php echo $RowIndex ?>_idItemPedido" value="<?php echo ew_HtmlEncode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $walger_items_pedidos->idItemPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idItemPedido->ViewValue ?></div>
<?php } ?>
</td>
		<!-- idPedido -->
		<td<?php echo $walger_items_pedidos->idPedido->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<div<?php echo $walger_items_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idPedido->EditValue ?></div>
<input type="hidden" name="x<?php echo $RowIndex ?>_idPedido" id="x<?php echo $RowIndex ?>_idPedido" value="<?php echo ew_HtmlEncode($walger_items_pedidos->idPedido->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $walger_items_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idPedido->ViewValue ?></div>
<?php } ?>
</td>
		<!-- CodInternoArti -->
		<td<?php echo $walger_items_pedidos->CodInternoArti->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<div<?php echo $walger_items_pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_items_pedidos->CodInternoArti->EditValue ?></div>
<input type="hidden" name="x<?php echo $RowIndex ?>_CodInternoArti" id="x<?php echo $RowIndex ?>_CodInternoArti" value="<?php echo ew_HtmlEncode($walger_items_pedidos->CodInternoArti->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $walger_items_pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_items_pedidos->CodInternoArti->ViewValue ?></div>
<?php } ?>
</td>
		<!-- precio -->
		<td<?php echo $walger_items_pedidos->precio->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<div<?php echo $walger_items_pedidos->precio->ViewAttributes() ?>><?php echo $walger_items_pedidos->precio->EditValue ?></div>
<input type="hidden" name="x<?php echo $RowIndex ?>_precio" id="x<?php echo $RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($walger_items_pedidos->precio->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $walger_items_pedidos->precio->ViewAttributes() ?>><?php echo $walger_items_pedidos->precio->ViewValue ?></div>
<?php } ?>
</td>
		<!-- cantidad -->
		<td<?php echo $walger_items_pedidos->cantidad->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<div<?php echo $walger_items_pedidos->cantidad->ViewAttributes() ?>><?php echo $walger_items_pedidos->cantidad->EditValue ?></div>
<input type="hidden" name="x<?php echo $RowIndex ?>_cantidad" id="x<?php echo $RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($walger_items_pedidos->cantidad->CurrentValue) ?>">
<?php } else { ?>
<div<?php echo $walger_items_pedidos->cantidad->ViewAttributes() ?>><?php echo $walger_items_pedidos->cantidad->ViewValue ?></div>
<?php } ?>
</td>
		<!-- estado -->
		<td<?php echo $walger_items_pedidos->estado->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<select id="x<?php echo $RowIndex ?>_estado" name="x<?php echo $RowIndex ?>_estado"<?php echo $walger_items_pedidos->estado->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_items_pedidos->estado->EditValue)) {
	$arwrk = $walger_items_pedidos->estado->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_items_pedidos->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
			}
}
?>
</select>
<?php } else { ?>
<div<?php echo $walger_items_pedidos->estado->ViewAttributes() ?>><?php echo $walger_items_pedidos->estado->ViewValue ?></div>
<?php } ?>
</td>
		<!-- fechaEntregado -->
		<td<?php echo $walger_items_pedidos->fechaEntregado->CellAttributes() ?>>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit Record ?>
<input type="text" name="x<?php echo $RowIndex ?>_fechaEntregado" id="x<?php echo $RowIndex ?>_fechaEntregado" title="" value="<?php echo $walger_items_pedidos->fechaEntregado->EditValue ?>"<?php echo $walger_items_pedidos->fechaEntregado->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $walger_items_pedidos->fechaEntregado->ViewAttributes() ?>><?php echo $walger_items_pedidos->fechaEntregado->ViewValue ?></div>
<?php } ?>
</td>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { ?>
<?php if ($walger_items_pedidos->CurrentAction == "edit") { ?>
<td colspan="<?php echo $OptionCnt ?>"><span class="phpmaker">
<a href="" onClick="if (ew_ValidateForm(document.fwalger_items_pedidoslist)) document.fwalger_items_pedidoslist.submit();return false;">Actualizar</a>&nbsp;<a href="walger_items_pedidoslist.php?a=cancel">Cancelar</a>
<input type="hidden" name="a_list" id="a_list" value="update">
</span></td>
<?php } ?>
<?php if ($walger_items_pedidos->CurrentAction == "gridedit") { ?>
<input type="hidden" name="k<?php echo $RowIndex ?>_key" id="k<?php echo $RowIndex ?>_key" value="<?php echo ew_HtmlEncode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">
<?php } ?>
<?php } else { ?>
<?php if ($walger_items_pedidos->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_items_pedidos->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_items_pedidos->EditUrl() ?>">Editar</a><span class="ewSeparator">&nbsp;|&nbsp;</span><a href="<?php echo $walger_items_pedidos->InlineEditUrl() ?>">Editar En Linea</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $walger_items_pedidos->CopyUrl() ?>">Copiar</a>
</span></td>
<?php } ?>
<?php } ?>
<?php } ?>
	</tr>
<?php if ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { ?>
<script language="JavaScript">
<!--
var f = document.fwalger_items_pedidoslist;
ew_UpdateOpt(f.x<?php echo $RowIndex ?>_CodInternoArti, ar_x<?php echo $RowIndex ?>_CodInternoArti, f.x<?php echo $RowIndex ?>_CodInternoArti);

//-->
</script>
<?php } ?>
<?php
	}
	$rs->MoveNext();
}
?>
</table>
<?php if ($walger_items_pedidos->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<?php if ($walger_items_pedidos->CurrentAction <> "gridedit") { // Not grid edit mode ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_items_pedidosadd.php">Nuevo</a>&nbsp;&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($nTotalRecs > 0) { ?>
<a href="walger_items_pedidoslist.php?a=gridedit">Editar todos</a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
<?php } else { // Grid edit mode ?>
<a href="" onClick="if (ew_ValidateForm(document.fwalger_items_pedidoslist)) document.fwalger_items_pedidoslist.submit();return false;">Guardar</a>&nbsp;&nbsp;
<a href="walger_items_pedidoslist.php?a=cancel">Cancelar</a>&nbsp;&nbsp;
<?php } ?>
	</span></td></tr>
</table>
<?php } ?>
<?php } ?>
<?php if ($walger_items_pedidos->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $RowIndex ?>">
<?php } ?>
<?php if ($walger_items_pedidos->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $RowIndex ?>">
<?php } ?>
</form>
<?php

// Close recordset and connection
if ($rs) $rs->Close();
?>
<?php if ($walger_items_pedidos->Export == "") { ?>
<form action="walger_items_pedidoslist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_items_pedidoslist.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_items_pedidoslist.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<?php if ($walger_items_pedidos->Export == "") { ?>
<?php } ?>
<?php if ($walger_items_pedidos->Export == "") { ?>
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

//  Exit out of inline mode
function ClearInlineMode() {
	global $walger_items_pedidos;
	$walger_items_pedidos->setKey("idItemPedido", ""); // Clear inline edit key
	$walger_items_pedidos->CurrentAction = ""; // Clear action
	$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
}

// Switch to Grid Edit Mode
function GridEditMode() {
	$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
}

// Switch to Inline Edit Mode
function InlineEditMode() {
	global $Security, $walger_items_pedidos;
	$bInlineEdit = TRUE;
	if (@$_GET["idItemPedido"] <> "") {
		$walger_items_pedidos->idItemPedido->setQueryStringValue($_GET["idItemPedido"]);
	} else {
		$bInlineEdit = FALSE;
	}
	if ($bInlineEdit) {
		if (LoadRow()) {
			$walger_items_pedidos->setKey("idItemPedido", $walger_items_pedidos->idItemPedido->CurrentValue); // Set up inline edit key
			$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
		}
	}
}

// Peform update to inline edit record
function InlineUpdate() {
	global $objForm, $walger_items_pedidos;
	$objForm->Index = 1; 
	LoadFormValues(); // Get form values
	if (CheckInlineEditKey()) { // Check key
		$walger_items_pedidos->SendEmail = TRUE; // Send email on update success
		$bInlineUpdate = EditRow(); // Update record
	} else {
		$bInlineUpdate = FALSE;
	}
	if ($bInlineUpdate) { // Update success
		$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Set success message
		ClearInlineMode(); // Clear inline edit mode
	} else {
		if (@$_SESSION[EW_SESSION_MESSAGE] == "") {
			$_SESSION[EW_SESSION_MESSAGE] = "No se pudo actualizar"; // Set update failed message
		}
		$walger_items_pedidos->EventCancelled = TRUE; // Cancel event
		$walger_items_pedidos->CurrentAction = "edit"; // Stay in edit mode
	}
}

// Check inline edit key
function CheckInlineEditKey() {
	global $walger_items_pedidos;

	//CheckInlineEditKey = True
	if (strval($walger_items_pedidos->getKey("idItemPedido")) <> strval($walger_items_pedidos->idItemPedido->CurrentValue)) {
		return FALSE;
	}
	return TRUE;
}

// Peform update to grid
function GridUpdate() {
	global $conn, $objForm, $walger_items_pedidos;
	$rowindex = 1;
	$bGridUpdate = TRUE;

	// Begin transaction
	$conn->BeginTrans();
	$sKey = "";

	// Update row index and get row key
	$objForm->Index = $rowindex;
	$sThisKey = strval($objForm->GetValue("k_key"));

	// Update all rows based on key
	while ($sThisKey <> "") {

		// Load all values & keys
		LoadFormValues(); // Get form values
		if (LoadKeyValues($sThisKey)) { // Get key values
			$walger_items_pedidos->SendEmail = FALSE; // Do not send email on update success
			$bGridUpdate = EditRow(); // Update this row
		} else {
			$bGridUpdate = FALSE; // update failed
		}
		if ($bGridUpdate) {
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		} else {
			break;
		}

		// Update row index and get row key
		$rowindex++; // next row
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
	}
	if ($bGridUpdate) {
		$conn->CommitTrans(); // Commit transaction
		$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Set update success message
		ClearInlineMode(); // Clear inline edit mode
	} else {
		$conn->RollbackTrans(); // Rollback transaction
		if (@$_SESSION[EW_SESSION_MESSAGE] == "") {
			$_SESSION[EW_SESSION_MESSAGE] = "No se pudo actualizar"; // Set update failed message
		}
		$walger_items_pedidos->EventCancelled = TRUE; // Set event cancelled
		$walger_items_pedidos->CurrentAction = "gridedit"; // Stay in gridedit mode
	}
}

// Load key values
function LoadKeyValues($sKey) {
	global $walger_items_pedidos;
	$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, strval($sKey));
	if (count($arrKeyFlds) >= 1) {
		$walger_items_pedidos->idItemPedido->setFormValue($arrKeyFlds[0]);
		if (!is_numeric($walger_items_pedidos->idItemPedido->FormValue)) {
			return FALSE;
		}
	}
	return TRUE;
}

// Restore form values for current row
function RestoreCurrentRowFormValues() {
	global $objForm, $walger_items_pedidos;

	// Update row index and get row key
	$rowindex = 1;
	$objForm->Index = $rowindex;
	$sKey = strval($objForm->GetValue("k_key"));
	while ($sKey <> "") {
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, strval($sKey));
		if (count($arrKeyFlds) >= 1) {
			if (strval($arrKeyFlds[0]) == strval($walger_items_pedidos->idItemPedido->CurrentValue)) {
				$objForm->Index = $rowindex;
				LoadFormValues(); // Load form values
				return;
			}
		}

		// Update row index and get row key
		$rowindex++;
		$objForm->Index = $rowindex;
		$sKey = strval($objForm->GetValue("k_key"));
	}
}

// Return Basic Search sql
function BasicSearchSQL($Keyword) {
	$sKeyword = ew_AdjustSql($Keyword);
	$sql = "";
	$sql .= "`CodInternoArti` LIKE '%" . $sKeyword . "%' OR ";
	$sql .= "`estado` LIKE '%" . $sKeyword . "%' OR ";
	if (substr($sql, -4) == " OR ") $sql = substr($sql, 0, strlen($sql)-4);
	return $sql;
}

// Return Basic Search Where based on search keyword and type
function BasicSearchWhere() {
	global $Security, $walger_items_pedidos;
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
		$walger_items_pedidos->setBasicSearchKeyword($sSearchKeyword);
		$walger_items_pedidos->setBasicSearchType($sSearchType);
	}
	return $sSearchStr;
}

// Clear all search parameters
function ResetSearchParms() {

	// Clear search where
	global $walger_items_pedidos;
	$sSrchWhere = "";
	$walger_items_pedidos->setSearchWhere($sSrchWhere);

	// Clear basic search parameters
	ResetBasicSearchParms();
}

// Clear all basic search parameters
function ResetBasicSearchParms() {

	// Clear basic search parameters
	global $walger_items_pedidos;
	$walger_items_pedidos->setBasicSearchKeyword("");
	$walger_items_pedidos->setBasicSearchType("");
}

// Restore all search parameters
function RestoreSearchParms() {
	global $sSrchWhere, $walger_items_pedidos;
	$sSrchWhere = $walger_items_pedidos->getSearchWhere();
}

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $walger_items_pedidos;

	// Check for Ctrl pressed
	$bCtrl = (@$_GET["ctrl"] <> "");

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$walger_items_pedidos->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$walger_items_pedidos->CurrentOrderType = @$_GET["ordertype"];

		// Field idItemPedido
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->idItemPedido, $bCtrl);

		// Field idPedido
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->idPedido, $bCtrl);

		// Field CodInternoArti
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->CodInternoArti, $bCtrl);

		// Field precio
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->precio, $bCtrl);

		// Field cantidad
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->cantidad, $bCtrl);

		// Field estado
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->estado, $bCtrl);

		// Field fechaEntregado
		$walger_items_pedidos->UpdateSort($walger_items_pedidos->fechaEntregado, $bCtrl);
		$walger_items_pedidos->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $walger_items_pedidos->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($walger_items_pedidos->SqlOrderBy() <> "") {
			$sOrderBy = $walger_items_pedidos->SqlOrderBy();
			$walger_items_pedidos->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $walger_items_pedidos;

	// Get reset cmd
	if (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];

		// Reset search criteria
		if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall") {
			ResetSearchParms();
		}

		// Reset master/detail keys
		if (strtolower($sCmd) == "resetall") {
			$walger_items_pedidos->setMasterFilter(""); // Clear master filter
			$sDbMasterFilter = "";
			$walger_items_pedidos->setDetailFilter(""); // Clear detail filter
			$sDbDetailFilter = "";
			$walger_items_pedidos->idPedido->setSessionValue("");
		}

		// Reset Sort Criteria
		if (strtolower($sCmd) == "resetsort") {
			$sOrderBy = "";
			$walger_items_pedidos->setSessionOrderBy($sOrderBy);
			$walger_items_pedidos->idItemPedido->setSort("");
			$walger_items_pedidos->idPedido->setSort("");
			$walger_items_pedidos->CodInternoArti->setSort("");
			$walger_items_pedidos->precio->setSort("");
			$walger_items_pedidos->cantidad->setSort("");
			$walger_items_pedidos->estado->setSort("");
			$walger_items_pedidos->fechaEntregado->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_items_pedidos;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_items_pedidos->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_items_pedidos->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_items_pedidos->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->setFormValue($objForm->GetValue("x_idItemPedido"));
	$walger_items_pedidos->idPedido->setFormValue($objForm->GetValue("x_idPedido"));
	$walger_items_pedidos->CodInternoArti->setFormValue($objForm->GetValue("x_CodInternoArti"));
	$walger_items_pedidos->precio->setFormValue($objForm->GetValue("x_precio"));
	$walger_items_pedidos->cantidad->setFormValue($objForm->GetValue("x_cantidad"));
	$walger_items_pedidos->estado->setFormValue($objForm->GetValue("x_estado"));
	$walger_items_pedidos->fechaEntregado->setFormValue($objForm->GetValue("x_fechaEntregado"));
	$walger_items_pedidos->fechaEntregado->CurrentValue = ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7);
}

// Restore form values
function RestoreFormValues() {
	global $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->CurrentValue = $walger_items_pedidos->idItemPedido->FormValue;
	$walger_items_pedidos->idPedido->CurrentValue = $walger_items_pedidos->idPedido->FormValue;
	$walger_items_pedidos->CodInternoArti->CurrentValue = $walger_items_pedidos->CodInternoArti->FormValue;
	$walger_items_pedidos->precio->CurrentValue = $walger_items_pedidos->precio->FormValue;
	$walger_items_pedidos->cantidad->CurrentValue = $walger_items_pedidos->cantidad->FormValue;
	$walger_items_pedidos->estado->CurrentValue = $walger_items_pedidos->estado->FormValue;
	$walger_items_pedidos->fechaEntregado->CurrentValue = $walger_items_pedidos->fechaEntregado->FormValue;
	$walger_items_pedidos->fechaEntregado->CurrentValue = ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7);
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_items_pedidos;

	// Call Recordset Selecting event
	$walger_items_pedidos->Recordset_Selecting($walger_items_pedidos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_items_pedidos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_items_pedidos->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_items_pedidos;
	$sFilter = $walger_items_pedidos->SqlKeyFilter();
	if (!is_numeric($walger_items_pedidos->idItemPedido->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idItemPedido@", ew_AdjustSql($walger_items_pedidos->idItemPedido->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_items_pedidos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_items_pedidos->CurrentFilter = $sFilter;
	$sSql = $walger_items_pedidos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_items_pedidos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->setDbValue($rs->fields('idItemPedido'));
	$walger_items_pedidos->idPedido->setDbValue($rs->fields('idPedido'));
	$walger_items_pedidos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$walger_items_pedidos->precio->setDbValue($rs->fields('precio'));
	$walger_items_pedidos->cantidad->setDbValue($rs->fields('cantidad'));
	$walger_items_pedidos->estado->setDbValue($rs->fields('estado'));
	$walger_items_pedidos->fechaEntregado->setDbValue($rs->fields('fechaEntregado'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_items_pedidos;

	// Call Row Rendering event
	$walger_items_pedidos->Row_Rendering();

	// Common render codes for all row types
	// idItemPedido

	$walger_items_pedidos->idItemPedido->CellCssStyle = "";
	$walger_items_pedidos->idItemPedido->CellCssClass = "";

	// idPedido
	$walger_items_pedidos->idPedido->CellCssStyle = "";
	$walger_items_pedidos->idPedido->CellCssClass = "";

	// CodInternoArti
	$walger_items_pedidos->CodInternoArti->CellCssStyle = "";
	$walger_items_pedidos->CodInternoArti->CellCssClass = "";

	// precio
	$walger_items_pedidos->precio->CellCssStyle = "";
	$walger_items_pedidos->precio->CellCssClass = "";

	// cantidad
	$walger_items_pedidos->cantidad->CellCssStyle = "";
	$walger_items_pedidos->cantidad->CellCssClass = "";

	// estado
	$walger_items_pedidos->estado->CellCssStyle = "";
	$walger_items_pedidos->estado->CellCssClass = "";

	// fechaEntregado
	$walger_items_pedidos->fechaEntregado->CellCssStyle = "";
	$walger_items_pedidos->fechaEntregado->CellCssClass = "";
	if ($walger_items_pedidos->RowType == EW_ROWTYPE_VIEW) { // View row

		// idItemPedido
		$walger_items_pedidos->idItemPedido->ViewValue = $walger_items_pedidos->idItemPedido->CurrentValue;
		$walger_items_pedidos->idItemPedido->CssStyle = "";
		$walger_items_pedidos->idItemPedido->CssClass = "";
		$walger_items_pedidos->idItemPedido->ViewCustomAttributes = "";

		// idPedido
		$walger_items_pedidos->idPedido->ViewValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		if (!is_null($walger_items_pedidos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_items_pedidos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_items_pedidos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_items_pedidos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_items_pedidos->CodInternoArti->ViewValue = $walger_items_pedidos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_items_pedidos->CodInternoArti->ViewValue = NULL;
		}
		$walger_items_pedidos->CodInternoArti->CssStyle = "";
		$walger_items_pedidos->CodInternoArti->CssClass = "";
		$walger_items_pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$walger_items_pedidos->precio->ViewValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$walger_items_pedidos->cantidad->ViewValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";

		// estado
		if (!is_null($walger_items_pedidos->estado->CurrentValue)) {
			switch ($walger_items_pedidos->estado->CurrentValue) {
				case "P":
					$walger_items_pedidos->estado->ViewValue = "Pendiente de entrega";
					break;
				case "F":
					$walger_items_pedidos->estado->ViewValue = "Facturado";
					break;
				case "C":
					$walger_items_pedidos->estado->ViewValue = "Cancelado";
					break;
				default:
					$walger_items_pedidos->estado->ViewValue = $walger_items_pedidos->estado->CurrentValue;
			}
		} else {
			$walger_items_pedidos->estado->ViewValue = NULL;
		}
		$walger_items_pedidos->estado->CssStyle = "";
		$walger_items_pedidos->estado->CssClass = "";
		$walger_items_pedidos->estado->ViewCustomAttributes = "";

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->ViewValue = $walger_items_pedidos->fechaEntregado->CurrentValue;
		$walger_items_pedidos->fechaEntregado->ViewValue = ew_FormatDateTime($walger_items_pedidos->fechaEntregado->ViewValue, 7);
		$walger_items_pedidos->fechaEntregado->CssStyle = "";
		$walger_items_pedidos->fechaEntregado->CssClass = "";
		$walger_items_pedidos->fechaEntregado->ViewCustomAttributes = "";

		// idItemPedido
		$walger_items_pedidos->idItemPedido->HrefValue = "";

		// idPedido
		$walger_items_pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		$walger_items_pedidos->CodInternoArti->HrefValue = "";

		// precio
		$walger_items_pedidos->precio->HrefValue = "";

		// cantidad
		$walger_items_pedidos->cantidad->HrefValue = "";

		// estado
		$walger_items_pedidos->estado->HrefValue = "";

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->HrefValue = "";
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// idItemPedido
		$walger_items_pedidos->idItemPedido->EditCustomAttributes = "";
		$walger_items_pedidos->idItemPedido->EditValue = $walger_items_pedidos->idItemPedido->CurrentValue;
		$walger_items_pedidos->idItemPedido->CssStyle = "";
		$walger_items_pedidos->idItemPedido->CssClass = "";
		$walger_items_pedidos->idItemPedido->ViewCustomAttributes = "";

		// idPedido
		$walger_items_pedidos->idPedido->EditCustomAttributes = "";
		$walger_items_pedidos->idPedido->EditValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$walger_items_pedidos->CodInternoArti->EditCustomAttributes = "";
		if (!is_null($walger_items_pedidos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_items_pedidos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_items_pedidos->CodInternoArti->EditValue = $rswrk->fields('CodInternoArti');
					$walger_items_pedidos->CodInternoArti->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_items_pedidos->CodInternoArti->EditValue = $walger_items_pedidos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_items_pedidos->CodInternoArti->EditValue = NULL;
		}
		$walger_items_pedidos->CodInternoArti->CssStyle = "";
		$walger_items_pedidos->CodInternoArti->CssClass = "";
		$walger_items_pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$walger_items_pedidos->precio->EditCustomAttributes = "";
		$walger_items_pedidos->precio->EditValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$walger_items_pedidos->cantidad->EditCustomAttributes = "";
		$walger_items_pedidos->cantidad->EditValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";

		// estado
		$walger_items_pedidos->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("P", "Pendiente de entrega");
		$arwrk[] = array("F", "Facturado");
		$arwrk[] = array("C", "Cancelado");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_items_pedidos->estado->EditValue = $arwrk;

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->EditCustomAttributes = "";
		$walger_items_pedidos->fechaEntregado->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7));

		// idPedido
		$walger_items_pedidos->idPedido->ViewValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";
		$walger_items_pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		if (!is_null($walger_items_pedidos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_items_pedidos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_items_pedidos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_items_pedidos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_items_pedidos->CodInternoArti->ViewValue = $walger_items_pedidos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_items_pedidos->CodInternoArti->ViewValue = NULL;
		}
		$walger_items_pedidos->CodInternoArti->CssStyle = "";
		$walger_items_pedidos->CodInternoArti->CssClass = "";
		$walger_items_pedidos->CodInternoArti->ViewCustomAttributes = "";
		$walger_items_pedidos->CodInternoArti->HrefValue = "";

		// precio
		$walger_items_pedidos->precio->ViewValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";
		$walger_items_pedidos->precio->HrefValue = "";

		// cantidad
		$walger_items_pedidos->cantidad->ViewValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";
		$walger_items_pedidos->cantidad->HrefValue = "";
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_items_pedidos->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_items_pedidos;
	$sFilter = $walger_items_pedidos->SqlKeyFilter();
	if (!is_numeric($walger_items_pedidos->idItemPedido->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@idItemPedido@", ew_AdjustSql($walger_items_pedidos->idItemPedido->CurrentValue), $sFilter); // Replace key value
	$walger_items_pedidos->CurrentFilter = $sFilter;
	$sSql = $walger_items_pedidos->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE)
		return FALSE;
	if ($rs->EOF) {
		$EditRow = FALSE; // Update Failed
	} else {

		// Save old values
		$rsold =& $rs->fields;
		$rsnew = array();

		// Field idItemPedido
		// Field estado

		$walger_items_pedidos->estado->SetDbValueDef($walger_items_pedidos->estado->CurrentValue, "");
		$rsnew['estado'] =& $walger_items_pedidos->estado->DbValue;

		// Field fechaEntregado
		$walger_items_pedidos->fechaEntregado->SetDbValueDef(ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7), NULL);
		$rsnew['fechaEntregado'] =& $walger_items_pedidos->fechaEntregado->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_items_pedidos->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_items_pedidos->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_items_pedidos->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_items_pedidos->CancelMessage;
				$walger_items_pedidos->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_items_pedidos->Row_Updated($rsold, $rsnew);
	}
	$rs->Close();
	return $EditRow;
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_items_pedidos;
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
	if ($walger_items_pedidos->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_items_pedidos->Export == "csv") {
		$sCsvStr .= "idItemPedido" . ",";
		$sCsvStr .= "idPedido" . ",";
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "precio" . ",";
		$sCsvStr .= "cantidad" . ",";
		$sCsvStr .= "estado" . ",";
		$sCsvStr .= "fechaEntregado" . ",";
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
			if ($walger_items_pedidos->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('idItemPedido', $walger_items_pedidos->idItemPedido->CurrentValue);
				$XmlDoc->AddField('idPedido', $walger_items_pedidos->idPedido->CurrentValue);
				$XmlDoc->AddField('CodInternoArti', $walger_items_pedidos->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('precio', $walger_items_pedidos->precio->CurrentValue);
				$XmlDoc->AddField('cantidad', $walger_items_pedidos->cantidad->CurrentValue);
				$XmlDoc->AddField('estado', $walger_items_pedidos->estado->CurrentValue);
				$XmlDoc->AddField('fechaEntregado', $walger_items_pedidos->fechaEntregado->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_items_pedidos->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->idItemPedido->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->idPedido->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->precio->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->cantidad->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->estado->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_items_pedidos->fechaEntregado->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_items_pedidos->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_items_pedidos->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Master Detail based on querystring parameter
function SetUpMasterDetail() {
	global $nStartRec, $sDbMasterFilter, $sDbDetailFilter, $walger_items_pedidos;
	$bValidMaster = FALSE;

	// Get the keys for master table
	if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
		$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
		if ($sMasterTblVar == "") {
			$bValidMaster = TRUE;
			$sDbMasterFilter = "";
			$sDbDetailFilter = "";
		}
		if ($sMasterTblVar == "walger_pedidos") {
			$bValidMaster = TRUE;
			$sDbMasterFilter = $walger_items_pedidos->SqlMasterFilter_walger_pedidos();
			$sDbDetailFilter = $walger_items_pedidos->SqlDetailFilter_walger_pedidos();
			if (@$_GET["idPedido"] <> "") {
				$GLOBALS["walger_pedidos"]->idPedido->setQueryStringValue($_GET["idPedido"]);
				$walger_items_pedidos->idPedido->setQueryStringValue($GLOBALS["walger_pedidos"]->idPedido->QueryStringValue);
				$walger_items_pedidos->idPedido->setSessionValue($walger_items_pedidos->idPedido->QueryStringValue);
				if (!is_numeric($GLOBALS["walger_pedidos"]->idPedido->QueryStringValue)) $bValidMaster = FALSE;
				$sDbMasterFilter = str_replace("@idPedido@", ew_AdjustSql($GLOBALS["walger_pedidos"]->idPedido->QueryStringValue), $sDbMasterFilter);
				$sDbDetailFilter = str_replace("@idPedido@", ew_AdjustSql($GLOBALS["walger_pedidos"]->idPedido->QueryStringValue), $sDbDetailFilter);
			} else {
				$bValidMaster = FALSE;
			}
		}
	}
	if ($bValidMaster) {

		// Save current master table
		$walger_items_pedidos->setCurrentMasterTable($sMasterTblVar);

		// Reset start record counter (new master key)
		$nStartRec = 1;
		$walger_items_pedidos->setStartRecordNumber($nStartRec);
		$walger_items_pedidos->setMasterFilter($sDbMasterFilter); // Set up master filter
		$walger_items_pedidos->setDetailFilter($sDbDetailFilter); // Set up detail filter

		// Clear previous master session values
		if ($sMasterTblVar <> "walger_pedidos") {
			if ($walger_items_pedidos->idPedido->QueryStringValue == "") $walger_items_pedidos->idPedido->setSessionValue("");
		}
	} else {
		$sDbMasterFilter = $walger_items_pedidos->getMasterFilter(); //  Restore master filter
		$sDbDetailFilter = $walger_items_pedidos->getDetailFilter(); // Restore detail filter
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
