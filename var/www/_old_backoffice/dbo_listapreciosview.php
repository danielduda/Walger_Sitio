<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_listaprecios', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_listapreciosinfo.php" ?>
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
$dbo_listaprecios->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_listaprecios->Export; // Get export parameter, used in header
$sExportFile = $dbo_listaprecios->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["Regis_ListaPrec"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["Regis_ListaPrec"]);
}
if ($dbo_listaprecios->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_listaprecios->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_listaprecios->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_listaprecios->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_listaprecios->Export == "csv") {
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
if (@$_GET["Regis_ListaPrec"] <> "") {
	$dbo_listaprecios->Regis_ListaPrec->setQueryStringValue($_GET["Regis_ListaPrec"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$dbo_listaprecios->CurrentAction = $_POST["a_view"];
} else {
	$dbo_listaprecios->CurrentAction = "I"; // Display form
}
switch ($dbo_listaprecios->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("dbo_listaprecioslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($dbo_listaprecios->Regis_ListaPrec->CurrentValue) == strval($rs->fields('Regis_ListaPrec'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("dbo_listaprecioslist.php"); // Return to list
			} else {
				$dbo_listaprecios->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($dbo_listaprecios->Export == "xml" || $dbo_listaprecios->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$dbo_listaprecios->setReturnUrl("dbo_listapreciosview.php");

// Render row
$dbo_listaprecios->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Listas de precios (ISIS)
<?php if ($dbo_listaprecios->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_listapreciosview.php?export=html&Regis_ListaPrec=<?php echo urlencode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_listapreciosview.php?export=excel&Regis_ListaPrec=<?php echo urlencode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_listapreciosview.php?export=word&Regis_ListaPrec=<?php echo urlencode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_listapreciosview.php?export=xml&Regis_ListaPrec=<?php echo urlencode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_listapreciosview.php?export=csv&Regis_ListaPrec=<?php echo urlencode($dbo_listaprecios->Regis_ListaPrec->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($dbo_listaprecios->Export == "") { ?>
<a href="dbo_listaprecioslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_listapreciosadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_listaprecios->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_listaprecios->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $dbo_listaprecios->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($dbo_listaprecios->Export == "") { ?>
<form action="dbo_listapreciosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_listapreciosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->Regis_ListaPrec->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Código</td>
		<td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->CodigListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->CodigListaPrec->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Descripción</td>
		<td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->DescrListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->DescrListaPrec->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Regraba ?</td>
		<td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegrabaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegrabaPrec->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Lista Madre</td>
		<td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegisListaMadre->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegisListaMadre->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Variación Lista Madre</td>
		<td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->VariacionListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->VariacionListaPrec->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($dbo_listaprecios->Export == "") { ?>
<form action="dbo_listapreciosview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_listapreciosview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_listapreciosview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $dbo_listaprecios;

	// Call Recordset Selecting event
	$dbo_listaprecios->Recordset_Selecting($dbo_listaprecios->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_listaprecios->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_listaprecios->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_listaprecios;
	$sFilter = $dbo_listaprecios->SqlKeyFilter();
	if (!is_numeric($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_ListaPrec@", ew_AdjustSql($dbo_listaprecios->Regis_ListaPrec->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_listaprecios->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_listaprecios->CurrentFilter = $sFilter;
	$sSql = $dbo_listaprecios->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_listaprecios->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_listaprecios->CodigListaPrec->setDbValue($rs->fields('CodigListaPrec'));
	$dbo_listaprecios->DescrListaPrec->setDbValue($rs->fields('DescrListaPrec'));
	$dbo_listaprecios->RegrabaPrec->setDbValue($rs->fields('RegrabaPrec'));
	$dbo_listaprecios->RegisListaMadre->setDbValue($rs->fields('RegisListaMadre'));
	$dbo_listaprecios->VariacionListaPrec->setDbValue($rs->fields('VariacionListaPrec'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_listaprecios;

	// Call Row Rendering event
	$dbo_listaprecios->Row_Rendering();

	// Common render codes for all row types
	// Regis_ListaPrec

	$dbo_listaprecios->Regis_ListaPrec->CellCssStyle = "";
	$dbo_listaprecios->Regis_ListaPrec->CellCssClass = "";

	// CodigListaPrec
	$dbo_listaprecios->CodigListaPrec->CellCssStyle = "";
	$dbo_listaprecios->CodigListaPrec->CellCssClass = "";

	// DescrListaPrec
	$dbo_listaprecios->DescrListaPrec->CellCssStyle = "";
	$dbo_listaprecios->DescrListaPrec->CellCssClass = "";

	// RegrabaPrec
	$dbo_listaprecios->RegrabaPrec->CellCssStyle = "";
	$dbo_listaprecios->RegrabaPrec->CellCssClass = "";

	// RegisListaMadre
	$dbo_listaprecios->RegisListaMadre->CellCssStyle = "";
	$dbo_listaprecios->RegisListaMadre->CellCssClass = "";

	// VariacionListaPrec
	$dbo_listaprecios->VariacionListaPrec->CellCssStyle = "";
	$dbo_listaprecios->VariacionListaPrec->CellCssClass = "";
	if ($dbo_listaprecios->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->ViewValue = $dbo_listaprecios->Regis_ListaPrec->CurrentValue;
		$dbo_listaprecios->Regis_ListaPrec->CssStyle = "";
		$dbo_listaprecios->Regis_ListaPrec->CssClass = "";
		$dbo_listaprecios->Regis_ListaPrec->ViewCustomAttributes = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->ViewValue = $dbo_listaprecios->CodigListaPrec->CurrentValue;
		$dbo_listaprecios->CodigListaPrec->CssStyle = "";
		$dbo_listaprecios->CodigListaPrec->CssClass = "";
		$dbo_listaprecios->CodigListaPrec->ViewCustomAttributes = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->ViewValue = $dbo_listaprecios->DescrListaPrec->CurrentValue;
		$dbo_listaprecios->DescrListaPrec->CssStyle = "";
		$dbo_listaprecios->DescrListaPrec->CssClass = "";
		$dbo_listaprecios->DescrListaPrec->ViewCustomAttributes = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->ViewValue = $dbo_listaprecios->RegrabaPrec->CurrentValue;
		$dbo_listaprecios->RegrabaPrec->CssStyle = "";
		$dbo_listaprecios->RegrabaPrec->CssClass = "";
		$dbo_listaprecios->RegrabaPrec->ViewCustomAttributes = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->ViewValue = $dbo_listaprecios->RegisListaMadre->CurrentValue;
		$dbo_listaprecios->RegisListaMadre->CssStyle = "";
		$dbo_listaprecios->RegisListaMadre->CssClass = "";
		$dbo_listaprecios->RegisListaMadre->ViewCustomAttributes = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->ViewValue = $dbo_listaprecios->VariacionListaPrec->CurrentValue;
		$dbo_listaprecios->VariacionListaPrec->CssStyle = "";
		$dbo_listaprecios->VariacionListaPrec->CssClass = "";
		$dbo_listaprecios->VariacionListaPrec->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->HrefValue = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->HrefValue = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->HrefValue = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->HrefValue = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->HrefValue = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->HrefValue = "";
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_listaprecios->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_listaprecios;
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
	if ($dbo_listaprecios->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_listaprecios->Export == "csv") {
		$sCsvStr .= "Regis_ListaPrec" . ",";
		$sCsvStr .= "CodigListaPrec" . ",";
		$sCsvStr .= "DescrListaPrec" . ",";
		$sCsvStr .= "RegrabaPrec" . ",";
		$sCsvStr .= "RegisListaMadre" . ",";
		$sCsvStr .= "VariacionListaPrec" . ",";
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
			if ($dbo_listaprecios->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('Regis_ListaPrec', $dbo_listaprecios->Regis_ListaPrec->CurrentValue);
				$XmlDoc->AddField('CodigListaPrec', $dbo_listaprecios->CodigListaPrec->CurrentValue);
				$XmlDoc->AddField('DescrListaPrec', $dbo_listaprecios->DescrListaPrec->CurrentValue);
				$XmlDoc->AddField('RegrabaPrec', $dbo_listaprecios->RegrabaPrec->CurrentValue);
				$XmlDoc->AddField('RegisListaMadre', $dbo_listaprecios->RegisListaMadre->CurrentValue);
				$XmlDoc->AddField('VariacionListaPrec', $dbo_listaprecios->VariacionListaPrec->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_listaprecios->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->CodigListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->DescrListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->RegrabaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->RegisListaMadre->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_listaprecios->VariacionListaPrec->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_listaprecios->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_listaprecios->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_listaprecios;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_listaprecios->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_listaprecios->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_listaprecios->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_listaprecios->setStartRecordNumber($nStartRec);
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
