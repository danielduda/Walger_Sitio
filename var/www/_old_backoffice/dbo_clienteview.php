<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_cliente', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_clienteinfo.php" ?>
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
$dbo_cliente->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_cliente->Export; // Get export parameter, used in header
$sExportFile = $dbo_cliente->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["CodigoCli"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["CodigoCli"]);
}
if ($dbo_cliente->Export == "html") {

	// Printer friendly, no action required
}
if ($dbo_cliente->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($dbo_cliente->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($dbo_cliente->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($dbo_cliente->Export == "csv") {
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
if (@$_GET["CodigoCli"] <> "") {
	$dbo_cliente->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$dbo_cliente->CurrentAction = $_POST["a_view"];
} else {
	$dbo_cliente->CurrentAction = "I"; // Display form
}
switch ($dbo_cliente->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("dbo_clientelist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($dbo_cliente->CodigoCli->CurrentValue) == strval($rs->fields('CodigoCli'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("dbo_clientelist.php"); // Return to list
			} else {
				$dbo_cliente->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($dbo_cliente->Export == "xml" || $dbo_cliente->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$dbo_cliente->setReturnUrl("dbo_clienteview.php");

// Render row
$dbo_cliente->RowType = EW_ROWTYPE_VIEW;
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
<p><span class="phpmaker">Ver : Clientes (ISIS)
<?php if ($dbo_cliente->Export == "") { ?>
&nbsp;&nbsp;<a href="dbo_clienteview.php?export=html&CodigoCli=<?php echo urlencode($dbo_cliente->CodigoCli->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="dbo_clienteview.php?export=excel&CodigoCli=<?php echo urlencode($dbo_cliente->CodigoCli->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="dbo_clienteview.php?export=word&CodigoCli=<?php echo urlencode($dbo_cliente->CodigoCli->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="dbo_clienteview.php?export=xml&CodigoCli=<?php echo urlencode($dbo_cliente->CodigoCli->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="dbo_clienteview.php?export=csv&CodigoCli=<?php echo urlencode($dbo_cliente->CodigoCli->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($dbo_cliente->Export == "") { ?>
<a href="dbo_clientelist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="dbo_clienteadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_cliente->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $dbo_cliente->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $dbo_cliente->DeleteUrl() ?>">Eliminar</a>&nbsp;
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
<?php if ($dbo_cliente->Export == "") { ?>
<form action="dbo_clienteview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_clienteview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
		<td class="ewTableHeader">Código</td>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>><?php echo $dbo_cliente->CodigoCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Razón Social</td>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">CUIT</td>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>><?php echo $dbo_cliente->CuitCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Ingresos Brutos</td>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>><?php echo $dbo_cliente->IngBrutosCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Condición IVA</td>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_IvaC->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Lista de Precios</td>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_ListaPrec->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">EMail</td>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>><?php echo $dbo_cliente->emailCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Razón Social Flete</td>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialFlete->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Dirección</td>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>><?php echo $dbo_cliente->Direccion->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Barrio</td>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>><?php echo $dbo_cliente->BarrioCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Localidad</td>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>><?php echo $dbo_cliente->LocalidadCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Provincia</td>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>><?php echo $dbo_cliente->DescrProvincia->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">CP</td>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>><?php echo $dbo_cliente->CodigoPostalCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">País</td>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>><?php echo $dbo_cliente->DescrPais->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Teléfono</td>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>><?php echo $dbo_cliente->Telefono->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Fax</td>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>><?php echo $dbo_cliente->FaxCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Pagina Web</td>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>><?php echo $dbo_cliente->PaginaWebCli->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($dbo_cliente->Export == "") { ?>
<form action="dbo_clienteview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="dbo_clienteview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="dbo_clienteview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
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
	global $conn, $dbo_cliente;

	// Call Recordset Selecting event
	$dbo_cliente->Recordset_Selecting($dbo_cliente->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_cliente->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_cliente->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_cliente;
	$sFilter = $dbo_cliente->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($dbo_cliente->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_cliente->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_cliente->CurrentFilter = $sFilter;
	$sSql = $dbo_cliente->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_cliente->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_cliente;
	$dbo_cliente->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$dbo_cliente->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
	$dbo_cliente->CuitCli->setDbValue($rs->fields('CuitCli'));
	$dbo_cliente->IngBrutosCli->setDbValue($rs->fields('IngBrutosCli'));
	$dbo_cliente->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_cliente->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_cliente->emailCli->setDbValue($rs->fields('emailCli'));
	$dbo_cliente->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
	$dbo_cliente->Direccion->setDbValue($rs->fields('Direccion'));
	$dbo_cliente->BarrioCli->setDbValue($rs->fields('BarrioCli'));
	$dbo_cliente->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
	$dbo_cliente->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
	$dbo_cliente->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
	$dbo_cliente->DescrPais->setDbValue($rs->fields('DescrPais'));
	$dbo_cliente->Telefono->setDbValue($rs->fields('Telefono'));
	$dbo_cliente->FaxCli->setDbValue($rs->fields('FaxCli'));
	$dbo_cliente->PaginaWebCli->setDbValue($rs->fields('PaginaWebCli'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_cliente;

	// Call Row Rendering event
	$dbo_cliente->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$dbo_cliente->CodigoCli->CellCssStyle = "";
	$dbo_cliente->CodigoCli->CellCssClass = "";

	// RazonSocialCli
	$dbo_cliente->RazonSocialCli->CellCssStyle = "";
	$dbo_cliente->RazonSocialCli->CellCssClass = "";

	// CuitCli
	$dbo_cliente->CuitCli->CellCssStyle = "";
	$dbo_cliente->CuitCli->CellCssClass = "";

	// IngBrutosCli
	$dbo_cliente->IngBrutosCli->CellCssStyle = "";
	$dbo_cliente->IngBrutosCli->CellCssClass = "";

	// Regis_IvaC
	$dbo_cliente->Regis_IvaC->CellCssStyle = "";
	$dbo_cliente->Regis_IvaC->CellCssClass = "";

	// Regis_ListaPrec
	$dbo_cliente->Regis_ListaPrec->CellCssStyle = "";
	$dbo_cliente->Regis_ListaPrec->CellCssClass = "";

	// emailCli
	$dbo_cliente->emailCli->CellCssStyle = "";
	$dbo_cliente->emailCli->CellCssClass = "";

	// RazonSocialFlete
	$dbo_cliente->RazonSocialFlete->CellCssStyle = "";
	$dbo_cliente->RazonSocialFlete->CellCssClass = "";

	// Direccion
	$dbo_cliente->Direccion->CellCssStyle = "";
	$dbo_cliente->Direccion->CellCssClass = "";

	// BarrioCli
	$dbo_cliente->BarrioCli->CellCssStyle = "";
	$dbo_cliente->BarrioCli->CellCssClass = "";

	// LocalidadCli
	$dbo_cliente->LocalidadCli->CellCssStyle = "";
	$dbo_cliente->LocalidadCli->CellCssClass = "";

	// DescrProvincia
	$dbo_cliente->DescrProvincia->CellCssStyle = "";
	$dbo_cliente->DescrProvincia->CellCssClass = "";

	// CodigoPostalCli
	$dbo_cliente->CodigoPostalCli->CellCssStyle = "";
	$dbo_cliente->CodigoPostalCli->CellCssClass = "";

	// DescrPais
	$dbo_cliente->DescrPais->CellCssStyle = "";
	$dbo_cliente->DescrPais->CellCssClass = "";

	// Telefono
	$dbo_cliente->Telefono->CellCssStyle = "";
	$dbo_cliente->Telefono->CellCssClass = "";

	// FaxCli
	$dbo_cliente->FaxCli->CellCssStyle = "";
	$dbo_cliente->FaxCli->CellCssClass = "";

	// PaginaWebCli
	$dbo_cliente->PaginaWebCli->CellCssStyle = "";
	$dbo_cliente->PaginaWebCli->CellCssClass = "";
	if ($dbo_cliente->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		$dbo_cliente->CodigoCli->ViewValue = $dbo_cliente->CodigoCli->CurrentValue;
		$dbo_cliente->CodigoCli->CssStyle = "";
		$dbo_cliente->CodigoCli->CssClass = "";
		$dbo_cliente->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->ViewValue = $dbo_cliente->RazonSocialCli->CurrentValue;
		$dbo_cliente->RazonSocialCli->CssStyle = "";
		$dbo_cliente->RazonSocialCli->CssClass = "";
		$dbo_cliente->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$dbo_cliente->CuitCli->ViewValue = $dbo_cliente->CuitCli->CurrentValue;
		$dbo_cliente->CuitCli->CssStyle = "";
		$dbo_cliente->CuitCli->CssClass = "";
		$dbo_cliente->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->ViewValue = $dbo_cliente->IngBrutosCli->CurrentValue;
		$dbo_cliente->IngBrutosCli->CssStyle = "";
		$dbo_cliente->IngBrutosCli->CssClass = "";
		$dbo_cliente->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		if (!is_null($dbo_cliente->Regis_IvaC->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrIvaC` FROM `dbo_ivacondicion` WHERE `Regis_IvaC` = " . ew_AdjustSql($dbo_cliente->Regis_IvaC->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_IvaC->ViewValue = $rswrk->fields('DescrIvaC');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_IvaC->ViewValue = $dbo_cliente->Regis_IvaC->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_IvaC->ViewValue = NULL;
		}
		$dbo_cliente->Regis_IvaC->CssStyle = "";
		$dbo_cliente->Regis_IvaC->CssClass = "";
		$dbo_cliente->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		if (!is_null($dbo_cliente->Regis_ListaPrec->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios` WHERE `Regis_ListaPrec` = " . ew_AdjustSql($dbo_cliente->Regis_ListaPrec->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_ListaPrec->ViewValue = $rswrk->fields('DescrListaPrec');
					$dbo_cliente->Regis_ListaPrec->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigListaPrec');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_ListaPrec->ViewValue = $dbo_cliente->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_ListaPrec->ViewValue = NULL;
		}
		$dbo_cliente->Regis_ListaPrec->CssStyle = "";
		$dbo_cliente->Regis_ListaPrec->CssClass = "";
		$dbo_cliente->Regis_ListaPrec->ViewCustomAttributes = "";

		// emailCli
		$dbo_cliente->emailCli->ViewValue = $dbo_cliente->emailCli->CurrentValue;
		$dbo_cliente->emailCli->CssStyle = "";
		$dbo_cliente->emailCli->CssClass = "";
		$dbo_cliente->emailCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->ViewValue = $dbo_cliente->RazonSocialFlete->CurrentValue;
		$dbo_cliente->RazonSocialFlete->CssStyle = "";
		$dbo_cliente->RazonSocialFlete->CssClass = "";
		$dbo_cliente->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$dbo_cliente->Direccion->ViewValue = $dbo_cliente->Direccion->CurrentValue;
		$dbo_cliente->Direccion->CssStyle = "";
		$dbo_cliente->Direccion->CssClass = "";
		$dbo_cliente->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->ViewValue = $dbo_cliente->BarrioCli->CurrentValue;
		$dbo_cliente->BarrioCli->CssStyle = "";
		$dbo_cliente->BarrioCli->CssClass = "";
		$dbo_cliente->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->ViewValue = $dbo_cliente->LocalidadCli->CurrentValue;
		$dbo_cliente->LocalidadCli->CssStyle = "";
		$dbo_cliente->LocalidadCli->CssClass = "";
		$dbo_cliente->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->ViewValue = $dbo_cliente->DescrProvincia->CurrentValue;
		$dbo_cliente->DescrProvincia->CssStyle = "";
		$dbo_cliente->DescrProvincia->CssClass = "";
		$dbo_cliente->DescrProvincia->ViewCustomAttributes = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->ViewValue = $dbo_cliente->CodigoPostalCli->CurrentValue;
		$dbo_cliente->CodigoPostalCli->CssStyle = "";
		$dbo_cliente->CodigoPostalCli->CssClass = "";
		$dbo_cliente->CodigoPostalCli->ViewCustomAttributes = "";

		// DescrPais
		$dbo_cliente->DescrPais->ViewValue = $dbo_cliente->DescrPais->CurrentValue;
		$dbo_cliente->DescrPais->CssStyle = "";
		$dbo_cliente->DescrPais->CssClass = "";
		$dbo_cliente->DescrPais->ViewCustomAttributes = "";

		// Telefono
		$dbo_cliente->Telefono->ViewValue = $dbo_cliente->Telefono->CurrentValue;
		$dbo_cliente->Telefono->CssStyle = "";
		$dbo_cliente->Telefono->CssClass = "";
		$dbo_cliente->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$dbo_cliente->FaxCli->ViewValue = $dbo_cliente->FaxCli->CurrentValue;
		$dbo_cliente->FaxCli->CssStyle = "";
		$dbo_cliente->FaxCli->CssClass = "";
		$dbo_cliente->FaxCli->ViewCustomAttributes = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->ViewValue = $dbo_cliente->PaginaWebCli->CurrentValue;
		$dbo_cliente->PaginaWebCli->CssStyle = "";
		$dbo_cliente->PaginaWebCli->CssClass = "";
		$dbo_cliente->PaginaWebCli->ViewCustomAttributes = "";

		// CodigoCli
		$dbo_cliente->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->HrefValue = "";

		// CuitCli
		$dbo_cliente->CuitCli->HrefValue = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->HrefValue = "";

		// Regis_IvaC
		$dbo_cliente->Regis_IvaC->HrefValue = "";

		// Regis_ListaPrec
		$dbo_cliente->Regis_ListaPrec->HrefValue = "";

		// emailCli
		$dbo_cliente->emailCli->HrefValue = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->HrefValue = "";

		// Direccion
		$dbo_cliente->Direccion->HrefValue = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->HrefValue = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->HrefValue = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->HrefValue = "";

		// DescrPais
		$dbo_cliente->DescrPais->HrefValue = "";

		// Telefono
		$dbo_cliente->Telefono->HrefValue = "";

		// FaxCli
		$dbo_cliente->FaxCli->HrefValue = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->HrefValue = "";
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_cliente->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $dbo_cliente;
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
	if ($dbo_cliente->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($dbo_cliente->Export == "csv") {
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "RazonSocialCli" . ",";
		$sCsvStr .= "CuitCli" . ",";
		$sCsvStr .= "IngBrutosCli" . ",";
		$sCsvStr .= "Regis_IvaC" . ",";
		$sCsvStr .= "Regis_ListaPrec" . ",";
		$sCsvStr .= "emailCli" . ",";
		$sCsvStr .= "RazonSocialFlete" . ",";
		$sCsvStr .= "Direccion" . ",";
		$sCsvStr .= "BarrioCli" . ",";
		$sCsvStr .= "LocalidadCli" . ",";
		$sCsvStr .= "DescrProvincia" . ",";
		$sCsvStr .= "CodigoPostalCli" . ",";
		$sCsvStr .= "DescrPais" . ",";
		$sCsvStr .= "Telefono" . ",";
		$sCsvStr .= "FaxCli" . ",";
		$sCsvStr .= "PaginaWebCli" . ",";
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
			if ($dbo_cliente->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodigoCli', $dbo_cliente->CodigoCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialCli', $dbo_cliente->RazonSocialCli->CurrentValue);
				$XmlDoc->AddField('CuitCli', $dbo_cliente->CuitCli->CurrentValue);
				$XmlDoc->AddField('IngBrutosCli', $dbo_cliente->IngBrutosCli->CurrentValue);
				$XmlDoc->AddField('Regis_IvaC', $dbo_cliente->Regis_IvaC->CurrentValue);
				$XmlDoc->AddField('Regis_ListaPrec', $dbo_cliente->Regis_ListaPrec->CurrentValue);
				$XmlDoc->AddField('emailCli', $dbo_cliente->emailCli->CurrentValue);
				$XmlDoc->AddField('RazonSocialFlete', $dbo_cliente->RazonSocialFlete->CurrentValue);
				$XmlDoc->AddField('Direccion', $dbo_cliente->Direccion->CurrentValue);
				$XmlDoc->AddField('BarrioCli', $dbo_cliente->BarrioCli->CurrentValue);
				$XmlDoc->AddField('LocalidadCli', $dbo_cliente->LocalidadCli->CurrentValue);
				$XmlDoc->AddField('DescrProvincia', $dbo_cliente->DescrProvincia->CurrentValue);
				$XmlDoc->AddField('CodigoPostalCli', $dbo_cliente->CodigoPostalCli->CurrentValue);
				$XmlDoc->AddField('DescrPais', $dbo_cliente->DescrPais->CurrentValue);
				$XmlDoc->AddField('Telefono', $dbo_cliente->Telefono->CurrentValue);
				$XmlDoc->AddField('FaxCli', $dbo_cliente->FaxCli->CurrentValue);
				$XmlDoc->AddField('PaginaWebCli', $dbo_cliente->PaginaWebCli->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($dbo_cliente->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->RazonSocialCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CuitCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->IngBrutosCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Regis_IvaC->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Regis_ListaPrec->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->emailCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->RazonSocialFlete->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Direccion->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->BarrioCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->LocalidadCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->DescrProvincia->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->CodigoPostalCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->DescrPais->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->Telefono->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->FaxCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($dbo_cliente->PaginaWebCli->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($dbo_cliente->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($dbo_cliente->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $dbo_cliente;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$dbo_cliente->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $dbo_cliente->getStartRecordNumber();
		}
	} else {
		$nStartRec = $dbo_cliente->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$dbo_cliente->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$dbo_cliente->setStartRecordNumber($nStartRec);
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
