<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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
if (@$_GET["fecha"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["fecha"]);
}
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
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["fecha"] <> "") {
	$walger_actualizaciones->fecha->setQueryStringValue($_GET["fecha"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$walger_actualizaciones->CurrentAction = $_POST["a_view"];
} else {
	$walger_actualizaciones->CurrentAction = "I"; // Display form
}
switch ($walger_actualizaciones->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("walger_actualizacioneslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($walger_actualizaciones->fecha->CurrentValue) == strval($rs->fields('fecha'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("walger_actualizacioneslist.php"); // Return to list
			} else {
				$walger_actualizaciones->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($walger_actualizaciones->Export == "xml" || $walger_actualizaciones->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$walger_actualizaciones->setReturnUrl("walger_actualizacionesview.php");

// Render row
$walger_actualizaciones->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Actualizaciones
<?php if ($walger_actualizaciones->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_actualizacionesview.php?export=html&fecha=<?php echo urlencode($walger_actualizaciones->fecha->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_actualizacionesview.php?export=excel&fecha=<?php echo urlencode($walger_actualizaciones->fecha->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_actualizacionesview.php?export=word&fecha=<?php echo urlencode($walger_actualizaciones->fecha->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_actualizacionesview.php?export=xml&fecha=<?php echo urlencode($walger_actualizaciones->fecha->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_actualizacionesview.php?export=csv&fecha=<?php echo urlencode($walger_actualizaciones->fecha->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($walger_actualizaciones->Export == "") { ?>
<a href="walger_actualizacioneslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_actualizacionesadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_actualizaciones->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_actualizaciones->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $walger_actualizaciones->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($walger_actualizaciones->Export == "") { ?>
<form action="walger_actualizacionesview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_actualizacionesview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td class="ewTableHeader">Fecha</td>
		<td<?php echo $walger_actualizaciones->fecha->CellAttributes() ?>>
<div<?php echo $walger_actualizaciones->fecha->ViewAttributes() ?>><?php echo $walger_actualizaciones->fecha->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Pendiente ?</td>
		<td<?php echo $walger_actualizaciones->pendiente->CellAttributes() ?>>
<div<?php echo $walger_actualizaciones->pendiente->ViewAttributes() ?>><?php echo $walger_actualizaciones->pendiente->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($walger_actualizaciones->Export == "") { ?>
<form action="walger_actualizacionesview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_actualizacionesview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_actualizacionesview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_actualizaciones;
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

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
