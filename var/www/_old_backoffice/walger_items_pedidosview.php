<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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
if (@$_GET["idItemPedido"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["idItemPedido"]);
}
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
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["idItemPedido"] <> "") {
	$walger_items_pedidos->idItemPedido->setQueryStringValue($_GET["idItemPedido"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$walger_items_pedidos->CurrentAction = $_POST["a_view"];
} else {
	$walger_items_pedidos->CurrentAction = "I"; // Display form
}
switch ($walger_items_pedidos->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("walger_items_pedidoslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($walger_items_pedidos->idItemPedido->CurrentValue) == strval($rs->fields('idItemPedido'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("walger_items_pedidoslist.php"); // Return to list
			} else {
				$walger_items_pedidos->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($walger_items_pedidos->Export == "xml" || $walger_items_pedidos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$walger_items_pedidos->setReturnUrl("walger_items_pedidosview.php");

// Render row
$walger_items_pedidos->RowType = EW_ROWTYPE_VIEW;
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "view"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Ver : Items Pedidos
<?php if ($walger_items_pedidos->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_items_pedidosview.php?export=html&idItemPedido=<?php echo urlencode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_items_pedidosview.php?export=excel&idItemPedido=<?php echo urlencode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_items_pedidosview.php?export=word&idItemPedido=<?php echo urlencode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_items_pedidosview.php?export=xml&idItemPedido=<?php echo urlencode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_items_pedidosview.php?export=csv&idItemPedido=<?php echo urlencode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($walger_items_pedidos->Export == "") { ?>
<a href="walger_items_pedidoslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_items_pedidosadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_items_pedidos->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_items_pedidos->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php } ?>
</span>
</p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<p>
<?php if ($walger_items_pedidos->Export == "") { ?>
<form action="walger_items_pedidosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_items_pedidosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<form>
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID Item</td>
		<td<?php echo $walger_items_pedidos->idItemPedido->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->idItemPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idItemPedido->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">ID Pedido</td>
		<td<?php echo $walger_items_pedidos->idPedido->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idPedido->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Artículo</td>
		<td<?php echo $walger_items_pedidos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_items_pedidos->CodInternoArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Precio</td>
		<td<?php echo $walger_items_pedidos->precio->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->precio->ViewAttributes() ?>><?php echo $walger_items_pedidos->precio->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cantidad</td>
		<td<?php echo $walger_items_pedidos->cantidad->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->cantidad->ViewAttributes() ?>><?php echo $walger_items_pedidos->cantidad->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Estado</td>
		<td<?php echo $walger_items_pedidos->estado->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->estado->ViewAttributes() ?>><?php echo $walger_items_pedidos->estado->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Fecha Entregado</td>
		<td<?php echo $walger_items_pedidos->fechaEntregado->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->fechaEntregado->ViewAttributes() ?>><?php echo $walger_items_pedidos->fechaEntregado->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($walger_items_pedidos->Export == "") { ?>
<form action="walger_items_pedidosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_items_pedidosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_items_pedidosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
<p>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
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
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_items_pedidos->Row_Rendered();
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
		SetUpStartRec(); // Set Up Start Record Position

		// Set the last record to display
		if ($nDisplayRecs < 0) {
			$nStopRec = $nTotalRecs;
		} else {
			$nStopRec = $nStartRec + $nDisplayRecs - 1;
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

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
