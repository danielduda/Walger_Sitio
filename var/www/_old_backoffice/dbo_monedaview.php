<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_moneda', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_monedainfo.php" ?>
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
$dbo_moneda->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_moneda->Export; // Get export parameter, used in header
$sExportFile = $dbo_moneda->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["Regis_Mda"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["Regis_Mda"]);
}
if ($dbo_moneda->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_moneda->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_moneda->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_moneda->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_moneda->Export == "csv") {
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
if (@$_GET["Regis_Mda"] <> "") {
	$dbo_moneda->Regis_Mda->setQueryStringValue($_GET["Regis_Mda"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$dbo_moneda->CurrentAction = $_POST["a_view"];
} else {
	$dbo_moneda->CurrentAction = "I"; // Display form
}
switch ($dbo_moneda->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("dbo_monedalist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($dbo_moneda->Regis_Mda->CurrentValue) == strval($rs->fields('Regis_Mda'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("dbo_monedalist.php"); // Return to list
			} else {
				$dbo_moneda->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($dbo_moneda->Export == "xml" || $dbo_moneda->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$dbo_moneda->setReturnUrl("dbo_monedaview.php");

// Render row
$dbo_moneda->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Monedas (ISIS)
<?php if ($dbo_moneda->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_monedaview.php?export=html&Regis_Mda=<?php echo urlencode($dbo_moneda->Regis_Mda->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_monedaview.php?export=excel&Regis_Mda=<?php echo urlencode($dbo_moneda->Regis_Mda->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_monedaview.php?export=word&Regis_Mda=<?php echo urlencode($dbo_moneda->Regis_Mda->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_monedaview.php?export=xml&Regis_Mda=<?php echo urlencode($dbo_moneda->Regis_Mda->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_monedaview.php?export=csv&Regis_Mda=<?php echo urlencode($dbo_moneda->Regis_Mda->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($dbo_moneda->Export == "") { ?>
<a href="dbo_monedalist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_monedaadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_moneda->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_moneda->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $dbo_moneda->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($dbo_moneda->Export == "") { ?>
<form action="dbo_monedaview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_monedaview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td<?php echo $dbo_moneda->Regis_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Regis_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Regis_Mda->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Descripción</td>
		<td<?php echo $dbo_moneda->Descr_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Descr_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Descr_Mda->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Signo</td>
		<td<?php echo $dbo_moneda->Signo_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Signo_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Signo_Mda->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Cotización</td>
		<td<?php echo $dbo_moneda->Cotiz_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Cotiz_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Cotiz_Mda->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Código AFIP</td>
		<td<?php echo $dbo_moneda->CodigoAFIP_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->CodigoAFIP_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->CodigoAFIP_Mda->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($dbo_moneda->Export == "") { ?>
<form action="dbo_monedaview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_monedaview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_monedaview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $dbo_moneda;

	// Call Recordset Selecting event
	$dbo_moneda->Recordset_Selecting($dbo_moneda->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_moneda->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_moneda->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_moneda;
	$sFilter = $dbo_moneda->SqlKeyFilter();
	if (!is_numeric($dbo_moneda->Regis_Mda->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_Mda@", ew_AdjustSql($dbo_moneda->Regis_Mda->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_moneda->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_moneda->CurrentFilter = $sFilter;
	$sSql = $dbo_moneda->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_moneda->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$dbo_moneda->Descr_Mda->setDbValue($rs->fields('Descr_Mda'));
	$dbo_moneda->Signo_Mda->setDbValue($rs->fields('Signo_Mda'));
	$dbo_moneda->Cotiz_Mda->setDbValue($rs->fields('Cotiz_Mda'));
	$dbo_moneda->CodigoAFIP_Mda->setDbValue($rs->fields('CodigoAFIP_Mda'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_moneda;

	// Call Row Rendering event
	$dbo_moneda->Row_Rendering();

	// Common render codes for all row types
	// Regis_Mda

	$dbo_moneda->Regis_Mda->CellCssStyle = "";
	$dbo_moneda->Regis_Mda->CellCssClass = "";

	// Descr_Mda
	$dbo_moneda->Descr_Mda->CellCssStyle = "";
	$dbo_moneda->Descr_Mda->CellCssClass = "";

	// Signo_Mda
	$dbo_moneda->Signo_Mda->CellCssStyle = "";
	$dbo_moneda->Signo_Mda->CellCssClass = "";

	// Cotiz_Mda
	$dbo_moneda->Cotiz_Mda->CellCssStyle = "";
	$dbo_moneda->Cotiz_Mda->CellCssClass = "";

	// CodigoAFIP_Mda
	$dbo_moneda->CodigoAFIP_Mda->CellCssStyle = "";
	$dbo_moneda->CodigoAFIP_Mda->CellCssClass = "";
	if ($dbo_moneda->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_Mda
		$dbo_moneda->Regis_Mda->ViewValue = $dbo_moneda->Regis_Mda->CurrentValue;
		$dbo_moneda->Regis_Mda->CssStyle = "";
		$dbo_moneda->Regis_Mda->CssClass = "";
		$dbo_moneda->Regis_Mda->ViewCustomAttributes = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->ViewValue = $dbo_moneda->Descr_Mda->CurrentValue;
		$dbo_moneda->Descr_Mda->CssStyle = "";
		$dbo_moneda->Descr_Mda->CssClass = "";
		$dbo_moneda->Descr_Mda->ViewCustomAttributes = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->ViewValue = $dbo_moneda->Signo_Mda->CurrentValue;
		$dbo_moneda->Signo_Mda->CssStyle = "";
		$dbo_moneda->Signo_Mda->CssClass = "";
		$dbo_moneda->Signo_Mda->ViewCustomAttributes = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->ViewValue = $dbo_moneda->Cotiz_Mda->CurrentValue;
		$dbo_moneda->Cotiz_Mda->CssStyle = "";
		$dbo_moneda->Cotiz_Mda->CssClass = "";
		$dbo_moneda->Cotiz_Mda->ViewCustomAttributes = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->ViewValue = $dbo_moneda->CodigoAFIP_Mda->CurrentValue;
		$dbo_moneda->CodigoAFIP_Mda->CssStyle = "";
		$dbo_moneda->CodigoAFIP_Mda->CssClass = "";
		$dbo_moneda->CodigoAFIP_Mda->ViewCustomAttributes = "";

		// Regis_Mda
		$dbo_moneda->Regis_Mda->HrefValue = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->HrefValue = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->HrefValue = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->HrefValue = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->HrefValue = "";
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_moneda->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_moneda;
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
	if ($dbo_moneda->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_moneda->Export == "csv") {
		$sCsvStr .= "Regis_Mda" . ",";
		$sCsvStr .= "Descr_Mda" . ",";
		$sCsvStr .= "Signo_Mda" . ",";
		$sCsvStr .= "Cotiz_Mda" . ",";
		$sCsvStr .= "CodigoAFIP_Mda" . ",";
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
			if ($dbo_moneda->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_Mda', $dbo_moneda->Regis_Mda->CurrentValue);
				$XmlDoc->AddField('Descr_Mda', $dbo_moneda->Descr_Mda->CurrentValue);
				$XmlDoc->AddField('Signo_Mda', $dbo_moneda->Signo_Mda->CurrentValue);
				$XmlDoc->AddField('Cotiz_Mda', $dbo_moneda->Cotiz_Mda->CurrentValue);
				$XmlDoc->AddField('CodigoAFIP_Mda', $dbo_moneda->CodigoAFIP_Mda->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_moneda->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Regis_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Descr_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Signo_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->Cotiz_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_moneda->CodigoAFIP_Mda->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_moneda->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_moneda->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_moneda;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_moneda->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_moneda->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_moneda->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_moneda->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_moneda->setStartRecordNumber($nStartRec);
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
