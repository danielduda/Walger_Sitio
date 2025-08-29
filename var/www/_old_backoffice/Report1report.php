<?php
define("EW_PAGE_ID", "report", TRUE); // Page ID
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php

// PHPMaker 5 configuration for Table Report1
$Report1 = new cReport1; // Initialize table object

// Define table class
class cReport1 {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $idPedido;
	var $CodInternoArti;
	var $precio;
	var $cantidad;
	var $TasaIva;
	var $CodigoCli;
	var $RazonSocialCli;
	var $CuitCli;
	var $RazonSocialFlete;
	var $Direccion;
	var $BarrioCli;
	var $LocalidadCli;
	var $DescrProvincia;
	var $DescrPais;
	var $CodigoPostalCli;
	var $Telefono;
	var $FaxCli;
	var $emailCli;
	var $DescrIvaC;
	var $DescrListaPrec;
	var $fields = array();

	function cReport1() {
		$this->TableVar = "Report1";
		$this->TableName = "Report1";
		$this->idPedido = new cField('Report1', 'x_idPedido', 'idPedido', "walger_pedidos.idPedido", 19, -1, FALSE);
		$this->fields['idPedido'] =& $this->idPedido;
		$this->CodInternoArti = new cField('Report1', 'x_CodInternoArti', 'CodInternoArti', "walger_items_pedidos.CodInternoArti", 200, -1, FALSE);
		$this->fields['CodInternoArti'] =& $this->CodInternoArti;
		$this->precio = new cField('Report1', 'x_precio', 'precio', "walger_items_pedidos.precio", 4, -1, FALSE);
		$this->fields['precio'] =& $this->precio;
		$this->cantidad = new cField('Report1', 'x_cantidad', 'cantidad', "walger_items_pedidos.cantidad", 3, -1, FALSE);
		$this->fields['cantidad'] =& $this->cantidad;
		$this->TasaIva = new cField('Report1', 'x_TasaIva', 'TasaIva', "dbo_articulo.TasaIva", 4, -1, FALSE);
		$this->fields['TasaIva'] =& $this->TasaIva;
		$this->CodigoCli = new cField('Report1', 'x_CodigoCli', 'CodigoCli', "walger_pedidos.CodigoCli", 200, -1, FALSE);
		$this->fields['CodigoCli'] =& $this->CodigoCli;
		$this->RazonSocialCli = new cField('Report1', 'x_RazonSocialCli', 'RazonSocialCli', "dbo_cliente.RazonSocialCli", 200, -1, FALSE);
		$this->fields['RazonSocialCli'] =& $this->RazonSocialCli;
		$this->CuitCli = new cField('Report1', 'x_CuitCli', 'CuitCli', "dbo_cliente.CuitCli", 200, -1, FALSE);
		$this->fields['CuitCli'] =& $this->CuitCli;
		$this->RazonSocialFlete = new cField('Report1', 'x_RazonSocialFlete', 'RazonSocialFlete', "dbo_cliente.RazonSocialFlete", 200, -1, FALSE);
		$this->fields['RazonSocialFlete'] =& $this->RazonSocialFlete;
		$this->Direccion = new cField('Report1', 'x_Direccion', 'Direccion', "dbo_cliente.Direccion", 200, -1, FALSE);
		$this->fields['Direccion'] =& $this->Direccion;
		$this->BarrioCli = new cField('Report1', 'x_BarrioCli', 'BarrioCli', "dbo_cliente.BarrioCli", 200, -1, FALSE);
		$this->fields['BarrioCli'] =& $this->BarrioCli;
		$this->LocalidadCli = new cField('Report1', 'x_LocalidadCli', 'LocalidadCli', "dbo_cliente.LocalidadCli", 200, -1, FALSE);
		$this->fields['LocalidadCli'] =& $this->LocalidadCli;
		$this->DescrProvincia = new cField('Report1', 'x_DescrProvincia', 'DescrProvincia', "dbo_cliente.DescrProvincia", 200, -1, FALSE);
		$this->fields['DescrProvincia'] =& $this->DescrProvincia;
		$this->DescrPais = new cField('Report1', 'x_DescrPais', 'DescrPais', "dbo_cliente.DescrPais", 200, -1, FALSE);
		$this->fields['DescrPais'] =& $this->DescrPais;
		$this->CodigoPostalCli = new cField('Report1', 'x_CodigoPostalCli', 'CodigoPostalCli', "dbo_cliente.CodigoPostalCli", 200, -1, FALSE);
		$this->fields['CodigoPostalCli'] =& $this->CodigoPostalCli;
		$this->Telefono = new cField('Report1', 'x_Telefono', 'Telefono', "dbo_cliente.Telefono", 200, -1, FALSE);
		$this->fields['Telefono'] =& $this->Telefono;
		$this->FaxCli = new cField('Report1', 'x_FaxCli', 'FaxCli', "dbo_cliente.FaxCli", 200, -1, FALSE);
		$this->fields['FaxCli'] =& $this->FaxCli;
		$this->emailCli = new cField('Report1', 'x_emailCli', 'emailCli', "dbo_cliente.emailCli", 200, -1, FALSE);
		$this->fields['emailCli'] =& $this->emailCli;
		$this->DescrIvaC = new cField('Report1', 'x_DescrIvaC', 'DescrIvaC', "dbo_ivacondicion.DescrIvaC", 200, -1, FALSE);
		$this->fields['DescrIvaC'] =& $this->DescrIvaC;
		$this->DescrListaPrec = new cField('Report1', 'x_DescrListaPrec', 'DescrListaPrec', "dbo_listaprecios.DescrListaPrec", 200, -1, FALSE);
		$this->fields['DescrListaPrec'] =& $this->DescrListaPrec;
	}

	// Report Detail Level SQL
	function SqlDetailSelect() { // Select
		return "SELECT walger_pedidos.CodigoCli, walger_items_pedidos.CodInternoArti, walger_pedidos.idPedido, walger_items_pedidos.precio, walger_items_pedidos.cantidad, dbo_cliente.RazonSocialCli, dbo_cliente.CuitCli, dbo_cliente.emailCli, dbo_cliente.RazonSocialFlete, dbo_cliente.Direccion, dbo_cliente.BarrioCli, dbo_cliente.LocalidadCli, dbo_cliente.DescrProvincia, dbo_cliente.CodigoPostalCli, dbo_cliente.DescrPais, dbo_cliente.Telefono, dbo_cliente.FaxCli, dbo_articulo.TasaIva, dbo_ivacondicion.DescrIvaC, dbo_listaprecios.DescrListaPrec FROM walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec)";
	}

	function SqlDetailWhere() { // Where
		return "(walger_pedidos.idPedido)";
	}

	function SqlDetailGroupBy() { // Group By
		return "";
	}

	function SqlDetailHaving() { // Having
		return "";
	}

	function SqlDetailOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Return report detail sql
	function DetailSQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = "";
		return ew_BuildSql($this->SqlDetailSelect(), $this->SqlDetailWhere(),
			$this->SqlDetailGroupBy(), $this->SqlDetailHaving(),
			$this->SqlDetailOrderBy(), $sFilter, $sSort);
	}

	// Return url
	function getReturnUrl() {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "Report1list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("Report1view.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("Report1edit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("Report1list.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("Report1add.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("Report1list.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("Report1delete.php");
	}

	// Key url
	function KeyUrl($url, $action = "") {
		$sUrl = $url . "?";
		if ($action <> "") $sUrl .= $action . "&";
		return $sUrl;
	}

	// Function LoadRs
	// - Load Row based on Key Value
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from rs
	function LoadListRowValues(&$rs) {
		$this->idPedido->setDbValue($rs->fields('idPedido'));
		$this->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
		$this->precio->setDbValue($rs->fields('precio'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->TasaIva->setDbValue($rs->fields('TasaIva'));
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
		$this->CuitCli->setDbValue($rs->fields('CuitCli'));
		$this->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
		$this->Direccion->setDbValue($rs->fields('Direccion'));
		$this->BarrioCli->setDbValue($rs->fields('BarrioCli'));
		$this->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
		$this->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
		$this->DescrPais->setDbValue($rs->fields('DescrPais'));
		$this->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->FaxCli->setDbValue($rs->fields('FaxCli'));
		$this->emailCli->setDbValue($rs->fields('emailCli'));
		$this->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
		$this->DescrListaPrec->setDbValue($rs->fields('DescrListaPrec'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// CodigoCli
		if (!is_null($Report1->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($Report1->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$Report1->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$Report1->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$Report1->CodigoCli->ViewValue = $Report1->CodigoCli->CurrentValue;
			}
		} else {
			$Report1->CodigoCli->ViewValue = NULL;
		}
		$Report1->CodigoCli->CssStyle = "";
		$Report1->CodigoCli->CssClass = "";
		$Report1->CodigoCli->ViewCustomAttributes = "";

		// CodigoCli
		$Report1->CodigoCli->HrefValue = "";
	}
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Display Attribute
	function DisplayAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . $this->RowClientEvents;
			}
		}
		return $sAtt;
	}

	// Export
	var $Export;

//	 ----------------
//	  Field objects
//	 ----------------
	function fields($fldname) {
		return $this->fields[$fldname];
	}
}
?>
<?php include "userfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php @set_time_limit(999); // Set the maximum execution time (seconds) ?>
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
$Report1->Export = @$_GET["export"]; // Get export parameter
$sExport = $Report1->Export; // Get export parameter, used in header
$sExportFile = $Report1->TableVar; // Get export file, used in header
?>
<?php
if ($Report1->Export == "html") {

	// Printer friendly, no action required
}
if ($Report1->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($Report1->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($Report1->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($Report1->Export == "csv") {
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.csv');
}
?>
<?php
$nRecCount = 0;
$nGrpRecs = 0;
$nDtlnRecCount = 0;
$nDtlRecs = 0;
$sFilter = "";
$sDbMasterFilter = "";
$sDbDetailFilter = "";
$sCmd = "";
$vGrps = ew_InitArray(1, NULL);
$nCntRecs = ew_InitArray(1, 0);
$bLvlBreak = ew_InitArray(1, FALSE);
$nTotals = ew_Init2DArray(1, 2, 0);
$nMaxs = ew_Init2DArray(1, 2, 0);
$nMins = ew_Init2DArray(1, 2, 0);
?>
<?php include "header.php" ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php if ($Report1->Export == "") { ?>
<?php } ?>
<p><span class="phpmaker">Reporte: Reporte de Pedidos
<?php if ($Report1->Export == "") { ?>
&nbsp;&nbsp;<a href="Report1report.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="Report1report.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Report1report.php?export=word">Exportar a Word</a>
<?php } ?>
</span></p>
<form method="post">
<table class="ewReportTable" cellspacing="-1">
<?php
$nRecCount = 1; // No Grouping
if ($sDbDetailFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sDbDetailFilter . ")";
}

	// Get detail records
	$sFilter = "";
	if ($sDbDetailFilter <> "") {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(" . $sDbDetailFilter . ")";
	}

	// Set up detail SQL
	$Report1->CurrentFilter = $sFilter;
	$sSql = $Report1->DetailSQL();

	// Load detail records
	$rsdtl = $conn->Execute($sSql);
	$nDtlRecs = $rsdtl->RecordCount();

	// Initialize Aggregate
	if (!$rsdtl->EOF) {
		$nRecCount++;
	}
	if ($nRecCount == 1) {
		$nCntRecs[0] = 0;
	}
	$nCntRecs[0] += $nDtlRecs;
?>
	<tr>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Código Cliente</span></td>
	</tr>
<?php
	while (!$rsdtl->EOF) {
		$Report1->CodigoCli->setDbValue($rsdtl->fields('CodigoCli'));

		// Render for view
		$Report1->RowType = EW_ROWTYPE_VIEW;
		RenderRow();
?>
	<tr>
		<td><span class="phpmaker">
<div<?php echo $Report1->CodigoCli->ViewAttributes() ?>><?php echo $Report1->CodigoCli->ViewValue ?></div>
</span></td>
	</tr>
<?php
		$rsdtl->MoveNext();
	}
	$rsdtl->Close();
?>
	<tr><td colspan=1><span class="phpmaker">&nbsp;<br></span></td></tr>
	<tr><td colspan=1 class="ewGrandSummary"><span class="phpmaker">Total (<?php echo ew_FormatNumber($nCntRecs[0],0) ?> Registro de detalle)</span></td></tr>
	<tr><td colspan=1><span class="phpmaker">&nbsp;<br></span></td></tr>
</table>
</form>
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

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $Report1;

	// Common render codes for all row types
	// CodigoCli

	$Report1->CodigoCli->CellCssStyle = "";
	$Report1->CodigoCli->CellCssClass = "";
	if ($Report1->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		if (!is_null($Report1->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($Report1->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$Report1->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$Report1->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$Report1->CodigoCli->ViewValue = $Report1->CodigoCli->CurrentValue;
			}
		} else {
			$Report1->CodigoCli->ViewValue = NULL;
		}
		$Report1->CodigoCli->CssStyle = "";
		$Report1->CodigoCli->CssClass = "";
		$Report1->CodigoCli->ViewCustomAttributes = "";

		// CodigoCli
		$Report1->CodigoCli->HrefValue = "";
	} elseif ($Report1->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($Report1->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($Report1->RowType == EW_ROWTYPE_SEARCH) { // Search row
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
