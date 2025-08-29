<?php

if ($_GET ["export"] == "html") {

  header ("location:http://servidor.walger.com.ar/pedido_admin.php?idPedido=".$_GET["idPedido"]);
  exit ();

}

define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_pedidos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_pedidosinfo.php" ?>
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
$walger_pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_pedidos->Export; // Get export parameter, used in header
$sExportFile = $walger_pedidos->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["idPedido"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["idPedido"]);
}
if ($walger_pedidos->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_pedidos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_pedidos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_pedidos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_pedidos->Export == "csv") {
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
if (@$_GET["idPedido"] <> "") {
	$walger_pedidos->idPedido->setQueryStringValue($_GET["idPedido"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$walger_pedidos->CurrentAction = $_POST["a_view"];
} else {
	$walger_pedidos->CurrentAction = "I"; // Display form
}
switch ($walger_pedidos->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("walger_pedidoslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($walger_pedidos->idPedido->CurrentValue) == strval($rs->fields('idPedido'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("walger_pedidoslist.php"); // Return to list
			} else {
				$walger_pedidos->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($walger_pedidos->Export == "xml" || $walger_pedidos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$walger_pedidos->setReturnUrl("walger_pedidosview.php");

// Render row
$walger_pedidos->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Pedidos
<?php if ($walger_pedidos->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_pedidosview.php?export=html&idPedido=<?php echo urlencode($walger_pedidos->idPedido->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_pedidosview.php?export=excel&idPedido=<?php echo urlencode($walger_pedidos->idPedido->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_pedidosview.php?export=word&idPedido=<?php echo urlencode($walger_pedidos->idPedido->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_pedidosview.php?export=xml&idPedido=<?php echo urlencode($walger_pedidos->idPedido->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_pedidosview.php?export=csv&idPedido=<?php echo urlencode($walger_pedidos->idPedido->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($walger_pedidos->Export == "") { ?>
<a href="walger_pedidoslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_pedidosadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_pedidos->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_pedidos->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $walger_pedidos->DeleteUrl() ?>">Eliminar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_items_pedidoslist.php?<?php echo EW_TABLE_SHOW_MASTER ?>=walger_pedidos&idPedido=<?php echo urlencode(strval($walger_pedidos->idPedido->CurrentValue)) ?>">Items Pedidos...</a>
&nbsp;
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
<?php if ($walger_pedidos->Export == "") { ?>
<form action="walger_pedidosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_pedidosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td class="ewTableHeader">ID</td>
		<td<?php echo $walger_pedidos->idPedido->CellAttributes() ?>>
<div<?php echo $walger_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_pedidos->idPedido->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Cliente</td>
		<td<?php echo $walger_pedidos->CodigoCli->CellAttributes() ?>>
<div<?php echo $walger_pedidos->CodigoCli->ViewAttributes() ?>><?php echo $walger_pedidos->CodigoCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Estado</td>
		<td<?php echo $walger_pedidos->estado->CellAttributes() ?>>
<div<?php echo $walger_pedidos->estado->ViewAttributes() ?>><?php echo $walger_pedidos->estado->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Fecha Cambio de Estado</td>
		<td<?php echo $walger_pedidos->fechaEstado->CellAttributes() ?>>
<div<?php echo $walger_pedidos->fechaEstado->ViewAttributes() ?>><?php echo $walger_pedidos->fechaEstado->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Fecha de Facturación</td>
		<td<?php echo $walger_pedidos->fechaFacturacion->CellAttributes() ?>>
<div<?php echo $walger_pedidos->fechaFacturacion->ViewAttributes() ?>><?php echo $walger_pedidos->fechaFacturacion->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Factura</td>
		<td<?php echo $walger_pedidos->factura->CellAttributes() ?>>
<div<?php echo $walger_pedidos->factura->ViewAttributes() ?>><?php echo $walger_pedidos->factura->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Comentario</td>
		<td<?php echo $walger_pedidos->comentario->CellAttributes() ?>>
<div<?php echo $walger_pedidos->comentario->ViewAttributes() ?>><?php echo $walger_pedidos->comentario->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($walger_pedidos->Export == "") { ?>
<form action="walger_pedidosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_pedidosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_pedidosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $walger_pedidos;

	// Call Recordset Selecting event
	$walger_pedidos->Recordset_Selecting($walger_pedidos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_pedidos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_pedidos->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_pedidos;
	$sFilter = $walger_pedidos->SqlKeyFilter();
	if (!is_numeric($walger_pedidos->idPedido->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idPedido@", ew_AdjustSql($walger_pedidos->idPedido->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_pedidos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_pedidos->CurrentFilter = $sFilter;
	$sSql = $walger_pedidos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_pedidos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_pedidos;
	$walger_pedidos->idPedido->setDbValue($rs->fields('idPedido'));
	$walger_pedidos->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$walger_pedidos->estado->setDbValue($rs->fields('estado'));
	$walger_pedidos->fechaEstado->setDbValue($rs->fields('fechaEstado'));
	$walger_pedidos->fechaFacturacion->setDbValue($rs->fields('fechaFacturacion'));
	$walger_pedidos->factura->setDbValue($rs->fields('factura'));
	$walger_pedidos->comentario->setDbValue($rs->fields('comentario'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_pedidos;

	// Call Row Rendering event
	$walger_pedidos->Row_Rendering();

	// Common render codes for all row types
	// idPedido

	$walger_pedidos->idPedido->CellCssStyle = "";
	$walger_pedidos->idPedido->CellCssClass = "";

	// CodigoCli
	$walger_pedidos->CodigoCli->CellCssStyle = "";
	$walger_pedidos->CodigoCli->CellCssClass = "";

	// estado
	$walger_pedidos->estado->CellCssStyle = "";
	$walger_pedidos->estado->CellCssClass = "";

	// fechaEstado
	$walger_pedidos->fechaEstado->CellCssStyle = "";
	$walger_pedidos->fechaEstado->CellCssClass = "";

	// fechaFacturacion
	$walger_pedidos->fechaFacturacion->CellCssStyle = "";
	$walger_pedidos->fechaFacturacion->CellCssClass = "";

	// factura
	$walger_pedidos->factura->CellCssStyle = "";
	$walger_pedidos->factura->CellCssClass = "";

	// comentario
	$walger_pedidos->comentario->CellCssStyle = "";
	$walger_pedidos->comentario->CellCssClass = "";
	if ($walger_pedidos->RowType == EW_ROWTYPE_VIEW) { // View row

		// idPedido
		$walger_pedidos->idPedido->ViewValue = $walger_pedidos->idPedido->CurrentValue;
		$walger_pedidos->idPedido->CssStyle = "";
		$walger_pedidos->idPedido->CssClass = "";
		$walger_pedidos->idPedido->ViewCustomAttributes = "";

		// CodigoCli
		if (!is_null($walger_pedidos->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($walger_pedidos->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_pedidos->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$walger_pedidos->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$walger_pedidos->CodigoCli->ViewValue = $walger_pedidos->CodigoCli->CurrentValue;
			}
		} else {
			$walger_pedidos->CodigoCli->ViewValue = NULL;
		}
		$walger_pedidos->CodigoCli->CssStyle = "";
		$walger_pedidos->CodigoCli->CssClass = "";
		$walger_pedidos->CodigoCli->ViewCustomAttributes = "";

		// estado
		if (!is_null($walger_pedidos->estado->CurrentValue)) {
			switch ($walger_pedidos->estado->CurrentValue) {
				case "N":
					$walger_pedidos->estado->ViewValue = "No confirmado";
					break;
				case "X":
					$walger_pedidos->estado->ViewValue = "Confirmado no entregado";
					break;
				case "E":
					$walger_pedidos->estado->ViewValue = "En preparación";
					break;
				case "P":
					$walger_pedidos->estado->ViewValue = "Pendiente de pago";
					break;
				case "F":
					$walger_pedidos->estado->ViewValue = "Facturado";
					break;
				case "C":
					$walger_pedidos->estado->ViewValue = "Cancelado";
					break;
				default:
					$walger_pedidos->estado->ViewValue = $walger_pedidos->estado->CurrentValue;
			}
		} else {
			$walger_pedidos->estado->ViewValue = NULL;
		}
		$walger_pedidos->estado->CssStyle = "";
		$walger_pedidos->estado->CssClass = "";
		$walger_pedidos->estado->ViewCustomAttributes = "";

		// fechaEstado
		$walger_pedidos->fechaEstado->ViewValue = $walger_pedidos->fechaEstado->CurrentValue;
		$walger_pedidos->fechaEstado->ViewValue = ew_FormatDateTime($walger_pedidos->fechaEstado->ViewValue, 7);
		$walger_pedidos->fechaEstado->CssStyle = "";
		$walger_pedidos->fechaEstado->CssClass = "";
		$walger_pedidos->fechaEstado->ViewCustomAttributes = "";

		// fechaFacturacion
		$walger_pedidos->fechaFacturacion->ViewValue = $walger_pedidos->fechaFacturacion->CurrentValue;
		$walger_pedidos->fechaFacturacion->ViewValue = ew_FormatDateTime($walger_pedidos->fechaFacturacion->ViewValue, 7);
		$walger_pedidos->fechaFacturacion->CssStyle = "";
		$walger_pedidos->fechaFacturacion->CssClass = "";
		$walger_pedidos->fechaFacturacion->ViewCustomAttributes = "";

		// factura
		$walger_pedidos->factura->ViewValue = $walger_pedidos->factura->CurrentValue;
		$walger_pedidos->factura->CssStyle = "";
		$walger_pedidos->factura->CssClass = "";
		$walger_pedidos->factura->ViewCustomAttributes = "";

		// comentario
		$walger_pedidos->comentario->ViewValue = $walger_pedidos->comentario->CurrentValue;
		if (!is_null($walger_pedidos->comentario->ViewValue)) $walger_pedidos->comentario->ViewValue = str_replace("\n", "<br>", $walger_pedidos->comentario->ViewValue); 
		$walger_pedidos->comentario->CssStyle = "";
		$walger_pedidos->comentario->CssClass = "";
		$walger_pedidos->comentario->ViewCustomAttributes = "";

		// idPedido
		$walger_pedidos->idPedido->HrefValue = "";

		// CodigoCli
		$walger_pedidos->CodigoCli->HrefValue = "";

		// estado
		$walger_pedidos->estado->HrefValue = "";

		// fechaEstado
		$walger_pedidos->fechaEstado->HrefValue = "";

		// fechaFacturacion
		$walger_pedidos->fechaFacturacion->HrefValue = "";

		// factura
		$walger_pedidos->factura->HrefValue = "";

		// comentario
		$walger_pedidos->comentario->HrefValue = "";
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_pedidos->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_pedidos;
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
	if ($walger_pedidos->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_pedidos->Export == "csv") {
		$sCsvStr .= "idPedido" . ",";
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "estado" . ",";
		$sCsvStr .= "fechaEstado" . ",";
		$sCsvStr .= "fechaFacturacion" . ",";
		$sCsvStr .= "factura" . ",";
		$sCsvStr .= "comentario" . ",";
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
			if ($walger_pedidos->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('idPedido', $walger_pedidos->idPedido->CurrentValue);
				$XmlDoc->AddField('CodigoCli', $walger_pedidos->CodigoCli->CurrentValue);
				$XmlDoc->AddField('estado', $walger_pedidos->estado->CurrentValue);
				$XmlDoc->AddField('fechaEstado', $walger_pedidos->fechaEstado->CurrentValue);
				$XmlDoc->AddField('fechaFacturacion', $walger_pedidos->fechaFacturacion->CurrentValue);
				$XmlDoc->AddField('factura', $walger_pedidos->factura->CurrentValue);
				$XmlDoc->AddField('comentario', $walger_pedidos->comentario->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_pedidos->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->idPedido->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->estado->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->fechaEstado->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->fechaFacturacion->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->factura->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_pedidos->comentario->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_pedidos->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_pedidos->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_pedidos;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_pedidos->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_pedidos->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_pedidos->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_pedidos->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_pedidos->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_pedidos->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_pedidos->setStartRecordNumber($nStartRec);
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
