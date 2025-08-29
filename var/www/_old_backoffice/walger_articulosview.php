<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_articulos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_articulosinfo.php" ?>
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
$walger_articulos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_articulos->Export; // Get export parameter, used in header
$sExportFile = $walger_articulos->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["CodInternoArti"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["CodInternoArti"]);
}
if ($walger_articulos->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_articulos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_articulos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_articulos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_articulos->Export == "csv") {
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
	$walger_articulos->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$walger_articulos->CurrentAction = $_POST["a_view"];
} else {
	$walger_articulos->CurrentAction = "I"; // Display form
}
switch ($walger_articulos->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("walger_articuloslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($walger_articulos->CodInternoArti->CurrentValue) == strval($rs->fields('CodInternoArti'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("walger_articuloslist.php"); // Return to list
			} else {
				$walger_articulos->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($walger_articulos->Export == "xml" || $walger_articulos->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$walger_articulos->setReturnUrl("walger_articulosview.php");

// Render row
$walger_articulos->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Artículos
<?php if ($walger_articulos->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_articulosview.php?export=html&CodInternoArti=<?php echo urlencode($walger_articulos->CodInternoArti->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_articulosview.php?export=excel&CodInternoArti=<?php echo urlencode($walger_articulos->CodInternoArti->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_articulosview.php?export=word&CodInternoArti=<?php echo urlencode($walger_articulos->CodInternoArti->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_articulosview.php?export=xml&CodInternoArti=<?php echo urlencode($walger_articulos->CodInternoArti->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_articulosview.php?export=csv&CodInternoArti=<?php echo urlencode($walger_articulos->CodInternoArti->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($walger_articulos->Export == "") { ?>
<a href="walger_articuloslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_articulosadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_articulos->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_articulos->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $walger_articulos->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($walger_articulos->Export == "") { ?>
<form action="walger_articulosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_articulosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td class="ewTableHeader">Artículo</td>
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $walger_articulos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_articulos->CodInternoArti->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Oferta ?</td>
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>>
<div<?php echo $walger_articulos->Oferta->ViewAttributes() ?>><?php echo $walger_articulos->Oferta->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Novedad ?</td>
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>>
<div<?php echo $walger_articulos->Novedad->ViewAttributes() ?>><?php echo $walger_articulos->Novedad->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($walger_articulos->Export == "") { ?>
<form action="walger_articulosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_articulosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_articulosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $walger_articulos;

	// Call Recordset Selecting event
	$walger_articulos->Recordset_Selecting($walger_articulos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_articulos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_articulos->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_articulos;
	$sFilter = $walger_articulos->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_articulos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_articulos->CurrentFilter = $sFilter;
	$sSql = $walger_articulos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_articulos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_articulos;
	$walger_articulos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$walger_articulos->Oferta->setDbValue($rs->fields('Oferta'));
	$walger_articulos->Novedad->setDbValue($rs->fields('Novedad'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_articulos;

	// Call Row Rendering event
	$walger_articulos->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$walger_articulos->CodInternoArti->CellCssStyle = "";
	$walger_articulos->CodInternoArti->CellCssClass = "";

	// Oferta
	$walger_articulos->Oferta->CellCssStyle = "";
	$walger_articulos->Oferta->CellCssClass = "";

	// Novedad
	$walger_articulos->Novedad->CellCssStyle = "";
	$walger_articulos->Novedad->CellCssClass = "";
	if ($walger_articulos->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		if (!is_null($walger_articulos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_articulos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_articulos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_articulos->CodInternoArti->ViewValue = $walger_articulos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_articulos->CodInternoArti->ViewValue = NULL;
		}
		$walger_articulos->CodInternoArti->CssStyle = "";
		$walger_articulos->CodInternoArti->CssClass = "";
		$walger_articulos->CodInternoArti->ViewCustomAttributes = "";

		// Oferta
		if (!is_null($walger_articulos->Oferta->CurrentValue)) {
			switch ($walger_articulos->Oferta->CurrentValue) {
				case "S":
					$walger_articulos->Oferta->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Oferta->ViewValue = "No";
					break;
				default:
					$walger_articulos->Oferta->ViewValue = $walger_articulos->Oferta->CurrentValue;
			}
		} else {
			$walger_articulos->Oferta->ViewValue = NULL;
		}
		$walger_articulos->Oferta->CssStyle = "";
		$walger_articulos->Oferta->CssClass = "";
		$walger_articulos->Oferta->ViewCustomAttributes = "";

		// Novedad
		if (!is_null($walger_articulos->Novedad->CurrentValue)) {
			switch ($walger_articulos->Novedad->CurrentValue) {
				case "S":
					$walger_articulos->Novedad->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Novedad->ViewValue = "No";
					break;
				default:
					$walger_articulos->Novedad->ViewValue = $walger_articulos->Novedad->CurrentValue;
			}
		} else {
			$walger_articulos->Novedad->ViewValue = NULL;
		}
		$walger_articulos->Novedad->CssStyle = "";
		$walger_articulos->Novedad->CssClass = "";
		$walger_articulos->Novedad->ViewCustomAttributes = "";

		// CodInternoArti
		$walger_articulos->CodInternoArti->HrefValue = "";

		// Oferta
		$walger_articulos->Oferta->HrefValue = "";

		// Novedad
		$walger_articulos->Novedad->HrefValue = "";
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_articulos->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_articulos;
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
	if ($walger_articulos->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_articulos->Export == "csv") {
		$sCsvStr .= "CodInternoArti" . ",";
		$sCsvStr .= "Oferta" . ",";
		$sCsvStr .= "Novedad" . ",";
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
			if ($walger_articulos->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodInternoArti', $walger_articulos->CodInternoArti->CurrentValue);
				$XmlDoc->AddField('Oferta', $walger_articulos->Oferta->CurrentValue);
				$XmlDoc->AddField('Novedad', $walger_articulos->Novedad->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_articulos->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->CodInternoArti->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->Oferta->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_articulos->Novedad->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_articulos->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_articulos->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_articulos;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_articulos->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_articulos->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_articulos->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_articulos->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_articulos->setStartRecordNumber($nStartRec);
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
