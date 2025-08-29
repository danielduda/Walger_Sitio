<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_ivacondicion', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_ivacondicioninfo.php" ?>
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
$dbo_ivacondicion->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_ivacondicion->Export; // Get export parameter, used in header
$sExportFile = $dbo_ivacondicion->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["Regis_IvaC"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["Regis_IvaC"]);
}
if ($dbo_ivacondicion->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_ivacondicion->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_ivacondicion->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_ivacondicion->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_ivacondicion->Export == "csv") {
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
if (@$_GET["Regis_IvaC"] <> "") {
	$dbo_ivacondicion->Regis_IvaC->setQueryStringValue($_GET["Regis_IvaC"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$dbo_ivacondicion->CurrentAction = $_POST["a_view"];
} else {
	$dbo_ivacondicion->CurrentAction = "I"; // Display form
}
switch ($dbo_ivacondicion->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("dbo_ivacondicionlist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($dbo_ivacondicion->Regis_IvaC->CurrentValue) == strval($rs->fields('Regis_IvaC'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("dbo_ivacondicionlist.php"); // Return to list
			} else {
				$dbo_ivacondicion->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($dbo_ivacondicion->Export == "xml" || $dbo_ivacondicion->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$dbo_ivacondicion->setReturnUrl("dbo_ivacondicionview.php");

// Render row
$dbo_ivacondicion->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Condiciones IVA (ISIS)
<?php if ($dbo_ivacondicion->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_ivacondicionview.php?export=html&Regis_IvaC=<?php echo urlencode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionview.php?export=excel&Regis_IvaC=<?php echo urlencode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionview.php?export=word&Regis_IvaC=<?php echo urlencode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionview.php?export=xml&Regis_IvaC=<?php echo urlencode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_ivacondicionview.php?export=csv&Regis_IvaC=<?php echo urlencode($dbo_ivacondicion->Regis_IvaC->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($dbo_ivacondicion->Export == "") { ?>
<a href="dbo_ivacondicionlist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_ivacondicionadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_ivacondicion->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_ivacondicion->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $dbo_ivacondicion->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($dbo_ivacondicion->Export == "") { ?>
<form action="dbo_ivacondicionview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_ivacondicionview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->Regis_IvaC->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Descripción</td>
		<td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DescrIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DescrIvaC->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Calcula Iva ?</td>
		<td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->CalculaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->CalculaIvaC->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Discrimina Iva ?</td>
		<td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($dbo_ivacondicion->Export == "") { ?>
<form action="dbo_ivacondicionview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_ivacondicionview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_ivacondicionview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $dbo_ivacondicion;

	// Call Recordset Selecting event
	$dbo_ivacondicion->Recordset_Selecting($dbo_ivacondicion->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_ivacondicion->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_ivacondicion->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_ivacondicion;
	$sFilter = $dbo_ivacondicion->SqlKeyFilter();
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_IvaC@", ew_AdjustSql($dbo_ivacondicion->Regis_IvaC->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_ivacondicion->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_ivacondicion->CurrentFilter = $sFilter;
	$sSql = $dbo_ivacondicion->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_ivacondicion->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_ivacondicion->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
	$dbo_ivacondicion->CalculaIvaC->setDbValue($rs->fields('CalculaIvaC'));
	$dbo_ivacondicion->DiscriminaIvaC->setDbValue($rs->fields('DiscriminaIvaC'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_ivacondicion;

	// Call Row Rendering event
	$dbo_ivacondicion->Row_Rendering();

	// Common render codes for all row types
	// Regis_IvaC

	$dbo_ivacondicion->Regis_IvaC->CellCssStyle = "";
	$dbo_ivacondicion->Regis_IvaC->CellCssClass = "";

	// DescrIvaC
	$dbo_ivacondicion->DescrIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DescrIvaC->CellCssClass = "";

	// CalculaIvaC
	$dbo_ivacondicion->CalculaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->CalculaIvaC->CellCssClass = "";

	// DiscriminaIvaC
	$dbo_ivacondicion->DiscriminaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DiscriminaIvaC->CellCssClass = "";
	if ($dbo_ivacondicion->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->ViewValue = $dbo_ivacondicion->Regis_IvaC->CurrentValue;
		$dbo_ivacondicion->Regis_IvaC->CssStyle = "";
		$dbo_ivacondicion->Regis_IvaC->CssClass = "";
		$dbo_ivacondicion->Regis_IvaC->ViewCustomAttributes = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->ViewValue = $dbo_ivacondicion->DescrIvaC->CurrentValue;
		$dbo_ivacondicion->DescrIvaC->CssStyle = "";
		$dbo_ivacondicion->DescrIvaC->CssClass = "";
		$dbo_ivacondicion->DescrIvaC->ViewCustomAttributes = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->ViewValue = $dbo_ivacondicion->CalculaIvaC->CurrentValue;
		$dbo_ivacondicion->CalculaIvaC->CssStyle = "";
		$dbo_ivacondicion->CalculaIvaC->CssClass = "";
		$dbo_ivacondicion->CalculaIvaC->ViewCustomAttributes = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->ViewValue = $dbo_ivacondicion->DiscriminaIvaC->CurrentValue;
		$dbo_ivacondicion->DiscriminaIvaC->CssStyle = "";
		$dbo_ivacondicion->DiscriminaIvaC->CssClass = "";
		$dbo_ivacondicion->DiscriminaIvaC->ViewCustomAttributes = "";

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->HrefValue = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->HrefValue = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->HrefValue = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->HrefValue = "";
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_ivacondicion->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_ivacondicion;
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
	if ($dbo_ivacondicion->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_ivacondicion->Export == "csv") {
		$sCsvStr .= "Regis_IvaC" . ",";
		$sCsvStr .= "DescrIvaC" . ",";
		$sCsvStr .= "CalculaIvaC" . ",";
		$sCsvStr .= "DiscriminaIvaC" . ",";
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
			if ($dbo_ivacondicion->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_IvaC', $dbo_ivacondicion->Regis_IvaC->CurrentValue);
				$XmlDoc->AddField('DescrIvaC', $dbo_ivacondicion->DescrIvaC->CurrentValue);
				$XmlDoc->AddField('CalculaIvaC', $dbo_ivacondicion->CalculaIvaC->CurrentValue);
				$XmlDoc->AddField('DiscriminaIvaC', $dbo_ivacondicion->DiscriminaIvaC->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_ivacondicion->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->Regis_IvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->DescrIvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->CalculaIvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_ivacondicion->DiscriminaIvaC->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_ivacondicion->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_ivacondicion->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_ivacondicion;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_ivacondicion->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_ivacondicion->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_ivacondicion->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_ivacondicion->setStartRecordNumber($nStartRec);
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
