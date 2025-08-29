<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_articulo', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_articuloinfo.php" ?>
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
$dbo_articulo->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_articulo->Export; // Get export parameter, used in header
$sExportFile = $dbo_articulo->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["CodInternoArti"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["CodInternoArti"]);
}
if ($dbo_articulo->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_articulo->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_articulo->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_articulo->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_articulo->Export == "csv") {
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
if (@$_GET["CodInternoArti"] <> "") {
	$dbo_articulo->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$dbo_articulo->CurrentAction = $_POST["a_view"];
} else {
	$dbo_articulo->CurrentAction = "I"; // Display form
}
switch ($dbo_articulo->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("dbo_articulolist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($dbo_articulo->CodInternoArti->CurrentValue) == strval($rs->fields('CodInternoArti'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("dbo_articulolist.php"); // Return to list
			} else {
				$dbo_articulo->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($dbo_articulo->Export == "xml" || $dbo_articulo->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$dbo_articulo->setReturnUrl("dbo_articuloview.php");

// Render row
$dbo_articulo->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Artículos (ISIS)
<?php if ($dbo_articulo->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_articuloview.php?export=html&CodInternoArti=<?php echo urlencode($dbo_articulo->CodInternoArti->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_articuloview.php?export=excel&CodInternoArti=<?php echo urlencode($dbo_articulo->CodInternoArti->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_articuloview.php?export=word&CodInternoArti=<?php echo urlencode($dbo_articulo->CodInternoArti->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_articuloview.php?export=xml&CodInternoArti=<?php echo urlencode($dbo_articulo->CodInternoArti->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_articuloview.php?export=csv&CodInternoArti=<?php echo urlencode($dbo_articulo->CodInternoArti->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($dbo_articulo->Export == "") { ?>
<a href="dbo_articulolist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_articuloadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_articulo->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_articulo->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $dbo_articulo->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($dbo_articulo->Export == "") { ?>
<form action="dbo_articuloview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_articuloview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td class="ewTableHeader">Codigo Interno</td>
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodInternoArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Codigo de Barras</td>
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodBarraArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Catálogo</td>
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt4->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Línea</td>
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt3->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Marca</td>
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt2->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Tasa IVA</td>
		<td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>>
<div<?php echo $dbo_articulo->TasaIva->ViewAttributes() ?>><?php echo $dbo_articulo->TasaIva->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Precio de Venta</td>
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>><?php echo $dbo_articulo->PrecioVta1_PreArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Descripcion</td>
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>><?php echo $dbo_articulo->DescripcionArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Ruta a la Foto</td>
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>><?php echo $dbo_articulo->NombreFotoArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Stock</td>
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>><?php echo $dbo_articulo->Stock1_StkArti->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($dbo_articulo->Export == "") { ?>
<form action="dbo_articuloview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_articuloview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_articuloview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $dbo_articulo;

	// Call Recordset Selecting event
	$dbo_articulo->Recordset_Selecting($dbo_articulo->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_articulo->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_articulo->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_articulo;
	$sFilter = $dbo_articulo->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($dbo_articulo->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_articulo->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_articulo->CurrentFilter = $sFilter;
	$sSql = $dbo_articulo->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_articulo->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_articulo;
	$dbo_articulo->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$dbo_articulo->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
	$dbo_articulo->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
	$dbo_articulo->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
	$dbo_articulo->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
	$dbo_articulo->TasaIva->setDbValue($rs->fields('TasaIva'));
	$dbo_articulo->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
	$dbo_articulo->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
	$dbo_articulo->NombreFotoArti->setDbValue($rs->fields('NombreFotoArti'));
	$dbo_articulo->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_articulo;

	// Call Row Rendering event
	$dbo_articulo->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$dbo_articulo->CodInternoArti->CellCssStyle = "";
	$dbo_articulo->CodInternoArti->CellCssClass = "";

	// CodBarraArti
	$dbo_articulo->CodBarraArti->CellCssStyle = "";
	$dbo_articulo->CodBarraArti->CellCssClass = "";

	// DescrNivelInt4
	$dbo_articulo->DescrNivelInt4->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt4->CellCssClass = "";

	// DescrNivelInt3
	$dbo_articulo->DescrNivelInt3->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt3->CellCssClass = "";

	// DescrNivelInt2
	$dbo_articulo->DescrNivelInt2->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt2->CellCssClass = "";

	// TasaIva
	$dbo_articulo->TasaIva->CellCssStyle = "";
	$dbo_articulo->TasaIva->CellCssClass = "";

	// PrecioVta1_PreArti
	$dbo_articulo->PrecioVta1_PreArti->CellCssStyle = "";
	$dbo_articulo->PrecioVta1_PreArti->CellCssClass = "";

	// DescripcionArti
	$dbo_articulo->DescripcionArti->CellCssStyle = "";
	$dbo_articulo->DescripcionArti->CellCssClass = "";

	// NombreFotoArti
	$dbo_articulo->NombreFotoArti->CellCssStyle = "";
	$dbo_articulo->NombreFotoArti->CellCssClass = "";

	// Stock1_StkArti
	$dbo_articulo->Stock1_StkArti->CellCssStyle = "";
	$dbo_articulo->Stock1_StkArti->CellCssClass = "";
	if ($dbo_articulo->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		$dbo_articulo->CodInternoArti->ViewValue = $dbo_articulo->CodInternoArti->CurrentValue;
		$dbo_articulo->CodInternoArti->CssStyle = "";
		$dbo_articulo->CodInternoArti->CssClass = "";
		$dbo_articulo->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->ViewValue = $dbo_articulo->CodBarraArti->CurrentValue;
		$dbo_articulo->CodBarraArti->CssStyle = "";
		$dbo_articulo->CodBarraArti->CssClass = "";
		$dbo_articulo->CodBarraArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->ViewValue = $dbo_articulo->DescrNivelInt4->CurrentValue;
		$dbo_articulo->DescrNivelInt4->CssStyle = "";
		$dbo_articulo->DescrNivelInt4->CssClass = "";
		$dbo_articulo->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->ViewValue = $dbo_articulo->DescrNivelInt3->CurrentValue;
		$dbo_articulo->DescrNivelInt3->CssStyle = "";
		$dbo_articulo->DescrNivelInt3->CssClass = "";
		$dbo_articulo->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->ViewValue = $dbo_articulo->DescrNivelInt2->CurrentValue;
		$dbo_articulo->DescrNivelInt2->CssStyle = "";
		$dbo_articulo->DescrNivelInt2->CssClass = "";
		$dbo_articulo->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$dbo_articulo->TasaIva->ViewValue = $dbo_articulo->TasaIva->CurrentValue;
		$dbo_articulo->TasaIva->CssStyle = "";
		$dbo_articulo->TasaIva->CssClass = "";
		$dbo_articulo->TasaIva->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->ViewValue = $dbo_articulo->PrecioVta1_PreArti->CurrentValue;
		$dbo_articulo->PrecioVta1_PreArti->CssStyle = "";
		$dbo_articulo->PrecioVta1_PreArti->CssClass = "";
		$dbo_articulo->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->ViewValue = $dbo_articulo->DescripcionArti->CurrentValue;
		$dbo_articulo->DescripcionArti->CssStyle = "";
		$dbo_articulo->DescripcionArti->CssClass = "";
		$dbo_articulo->DescripcionArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->ViewValue = $dbo_articulo->NombreFotoArti->CurrentValue;
		$dbo_articulo->NombreFotoArti->CssStyle = "";
		$dbo_articulo->NombreFotoArti->CssClass = "";
		$dbo_articulo->NombreFotoArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->ViewValue = $dbo_articulo->Stock1_StkArti->CurrentValue;
		$dbo_articulo->Stock1_StkArti->CssStyle = "";
		$dbo_articulo->Stock1_StkArti->CssClass = "";
		$dbo_articulo->Stock1_StkArti->ViewCustomAttributes = "";

		// CodInternoArti
		$dbo_articulo->CodInternoArti->HrefValue = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->HrefValue = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->HrefValue = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->HrefValue = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->HrefValue = "";

		// TasaIva
		$dbo_articulo->TasaIva->HrefValue = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->HrefValue = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->HrefValue = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->HrefValue = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->HrefValue = "";
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_articulo->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_articulo;
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
	if ($dbo_articulo->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_articulo->Export == "csv") {
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "CodBarraArti" . ",";
		$sCsvStr .= "DescrNivelInt4" . ",";
		$sCsvStr .= "DescrNivelInt3" . ",";
		$sCsvStr .= "DescrNivelInt2" . ",";
		$sCsvStr .= "TasaIva" . ",";
		$sCsvStr .= "PrecioVta1_PreArti" . ",";
		$sCsvStr .= "DescripcionArti" . ",";
		$sCsvStr .= "NombreFotoArti" . ",";
		$sCsvStr .= "Stock1_StkArti" . ",";
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
			if ($dbo_articulo->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodInternoArti', $dbo_articulo->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('CodBarraArti', $dbo_articulo->CodBarraArti->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt4', $dbo_articulo->DescrNivelInt4->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt3', $dbo_articulo->DescrNivelInt3->CurrentValue);
				$XmlDoc->AddField('DescrNivelInt2', $dbo_articulo->DescrNivelInt2->CurrentValue);
				$XmlDoc->AddField('TasaIva', $dbo_articulo->TasaIva->CurrentValue);
				$XmlDoc->AddField('PrecioVta1_PreArti', $dbo_articulo->PrecioVta1_PreArti->CurrentValue);
				$XmlDoc->AddField('DescripcionArti', $dbo_articulo->DescripcionArti->CurrentValue);
				$XmlDoc->AddField('NombreFotoArti', $dbo_articulo->NombreFotoArti->CurrentValue);
				$XmlDoc->AddField('Stock1_StkArti', $dbo_articulo->Stock1_StkArti->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_articulo->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->CodBarraArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt4->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt3->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescrNivelInt2->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->TasaIva->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->PrecioVta1_PreArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->DescripcionArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->NombreFotoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_articulo->Stock1_StkArti->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_articulo->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_articulo->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_articulo;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_articulo->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_articulo->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_articulo->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_articulo->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_articulo->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Page Load event
function Page_Load() {
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
