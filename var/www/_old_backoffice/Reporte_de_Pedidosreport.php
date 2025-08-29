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

// PHPMaker 5 configuration for Table Reporte de Pedidos
$Reporte_de_Pedidos = new cReporte_de_Pedidos; // Initialize table object

// Define table class
class cReporte_de_Pedidos {

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

	function cReporte_de_Pedidos() {
		$this->TableVar = "Reporte_de_Pedidos";
		$this->TableName = "Reporte de Pedidos";
		$this->idPedido = new cField('Reporte_de_Pedidos', 'x_idPedido', 'idPedido', "walger_pedidos.idPedido", 19, -1, FALSE);
		$this->fields['idPedido'] =& $this->idPedido;
		$this->CodInternoArti = new cField('Reporte_de_Pedidos', 'x_CodInternoArti', 'CodInternoArti', "walger_items_pedidos.CodInternoArti", 200, -1, FALSE);
		$this->fields['CodInternoArti'] =& $this->CodInternoArti;
		$this->precio = new cField('Reporte_de_Pedidos', 'x_precio', 'precio', "walger_items_pedidos.precio", 4, -1, FALSE);
		$this->fields['precio'] =& $this->precio;
		$this->cantidad = new cField('Reporte_de_Pedidos', 'x_cantidad', 'cantidad', "walger_items_pedidos.cantidad", 3, -1, FALSE);
		$this->fields['cantidad'] =& $this->cantidad;
		$this->TasaIva = new cField('Reporte_de_Pedidos', 'x_TasaIva', 'TasaIva', "dbo_articulo.TasaIva", 4, -1, FALSE);
		$this->fields['TasaIva'] =& $this->TasaIva;
		$this->CodigoCli = new cField('Reporte_de_Pedidos', 'x_CodigoCli', 'CodigoCli', "walger_pedidos.CodigoCli", 200, -1, FALSE);
		$this->fields['CodigoCli'] =& $this->CodigoCli;
		$this->RazonSocialCli = new cField('Reporte_de_Pedidos', 'x_RazonSocialCli', 'RazonSocialCli', "dbo_cliente.RazonSocialCli", 200, -1, FALSE);
		$this->fields['RazonSocialCli'] =& $this->RazonSocialCli;
		$this->CuitCli = new cField('Reporte_de_Pedidos', 'x_CuitCli', 'CuitCli', "dbo_cliente.CuitCli", 200, -1, FALSE);
		$this->fields['CuitCli'] =& $this->CuitCli;
		$this->RazonSocialFlete = new cField('Reporte_de_Pedidos', 'x_RazonSocialFlete', 'RazonSocialFlete', "dbo_cliente.RazonSocialFlete", 200, -1, FALSE);
		$this->fields['RazonSocialFlete'] =& $this->RazonSocialFlete;
		$this->Direccion = new cField('Reporte_de_Pedidos', 'x_Direccion', 'Direccion', "dbo_cliente.Direccion", 200, -1, FALSE);
		$this->fields['Direccion'] =& $this->Direccion;
		$this->BarrioCli = new cField('Reporte_de_Pedidos', 'x_BarrioCli', 'BarrioCli', "dbo_cliente.BarrioCli", 200, -1, FALSE);
		$this->fields['BarrioCli'] =& $this->BarrioCli;
		$this->LocalidadCli = new cField('Reporte_de_Pedidos', 'x_LocalidadCli', 'LocalidadCli', "dbo_cliente.LocalidadCli", 200, -1, FALSE);
		$this->fields['LocalidadCli'] =& $this->LocalidadCli;
		$this->DescrProvincia = new cField('Reporte_de_Pedidos', 'x_DescrProvincia', 'DescrProvincia', "dbo_cliente.DescrProvincia", 200, -1, FALSE);
		$this->fields['DescrProvincia'] =& $this->DescrProvincia;
		$this->DescrPais = new cField('Reporte_de_Pedidos', 'x_DescrPais', 'DescrPais', "dbo_cliente.DescrPais", 200, -1, FALSE);
		$this->fields['DescrPais'] =& $this->DescrPais;
		$this->CodigoPostalCli = new cField('Reporte_de_Pedidos', 'x_CodigoPostalCli', 'CodigoPostalCli', "dbo_cliente.CodigoPostalCli", 200, -1, FALSE);
		$this->fields['CodigoPostalCli'] =& $this->CodigoPostalCli;
		$this->Telefono = new cField('Reporte_de_Pedidos', 'x_Telefono', 'Telefono', "dbo_cliente.Telefono", 200, -1, FALSE);
		$this->fields['Telefono'] =& $this->Telefono;
		$this->FaxCli = new cField('Reporte_de_Pedidos', 'x_FaxCli', 'FaxCli', "dbo_cliente.FaxCli", 200, -1, FALSE);
		$this->fields['FaxCli'] =& $this->FaxCli;
		$this->emailCli = new cField('Reporte_de_Pedidos', 'x_emailCli', 'emailCli', "dbo_cliente.emailCli", 200, -1, FALSE);
		$this->fields['emailCli'] =& $this->emailCli;
		$this->DescrIvaC = new cField('Reporte_de_Pedidos', 'x_DescrIvaC', 'DescrIvaC', "dbo_ivacondicion.DescrIvaC", 200, -1, FALSE);
		$this->fields['DescrIvaC'] =& $this->DescrIvaC;
		$this->DescrListaPrec = new cField('Reporte_de_Pedidos', 'x_DescrListaPrec', 'DescrListaPrec', "dbo_listaprecios.DescrListaPrec", 200, -1, FALSE);
		$this->fields['DescrListaPrec'] =& $this->DescrListaPrec;
	}

	// Report Group Level SQL
	function SqlGroupSelect() { // Select
		return "SELECT DISTINCT walger_pedidos.CodigoCli,walger_pedidos.idPedido FROM walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec)";
	}

	function SqlGroupWhere() { // Where
		return "(walger_pedidos.idPedido)";
	}

	function SqlGroupGroupBy() { // Group By
		return "";
	}

	function SqlGroupHaving() { // Having
		return "";
	}

	function SqlGroupOrderBy() { // Order By
		return "walger_pedidos.CodigoCli ASC,walger_pedidos.idPedido ASC";
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
		return "walger_items_pedidos.CodInternoArti ASC";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Return report group sql
	function GroupSQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = "";
		return ew_BuildSql($this->SqlGroupSelect(), $this->SqlGroupWhere(),
			 $this->SqlGroupGroupBy(), $this->SqlGroupHaving(),
			 $this->SqlGroupOrderBy(), $sFilter, $sSort);
	}

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
			return "Reporte_de_Pedidoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("Reporte_de_Pedidosview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("Reporte_de_Pedidosedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("Reporte_de_Pedidoslist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("Reporte_de_Pedidosadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("Reporte_de_Pedidoslist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("Reporte_de_Pedidosdelete.php");
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

		// idPedido
		$Reporte_de_Pedidos->idPedido->ViewValue = $Reporte_de_Pedidos->idPedido->CurrentValue;
		$Reporte_de_Pedidos->idPedido->CssStyle = "";
		$Reporte_de_Pedidos->idPedido->CssClass = "";
		$Reporte_de_Pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$Reporte_de_Pedidos->CodInternoArti->ViewValue = $Reporte_de_Pedidos->CodInternoArti->CurrentValue;
		$Reporte_de_Pedidos->CodInternoArti->CssStyle = "";
		$Reporte_de_Pedidos->CodInternoArti->CssClass = "";
		$Reporte_de_Pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$Reporte_de_Pedidos->precio->ViewValue = $Reporte_de_Pedidos->precio->CurrentValue;
		$Reporte_de_Pedidos->precio->CssStyle = "";
		$Reporte_de_Pedidos->precio->CssClass = "";
		$Reporte_de_Pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$Reporte_de_Pedidos->cantidad->ViewValue = $Reporte_de_Pedidos->cantidad->CurrentValue;
		$Reporte_de_Pedidos->cantidad->CssStyle = "";
		$Reporte_de_Pedidos->cantidad->CssClass = "";
		$Reporte_de_Pedidos->cantidad->ViewCustomAttributes = "";

		// TasaIva
		$Reporte_de_Pedidos->TasaIva->ViewValue = $Reporte_de_Pedidos->TasaIva->CurrentValue;
		$Reporte_de_Pedidos->TasaIva->CssStyle = "";
		$Reporte_de_Pedidos->TasaIva->CssClass = "";
		$Reporte_de_Pedidos->TasaIva->ViewCustomAttributes = "";

		// CodigoCli
		if (!is_null($Reporte_de_Pedidos->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($Reporte_de_Pedidos->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$Reporte_de_Pedidos->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$Reporte_de_Pedidos->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$Reporte_de_Pedidos->CodigoCli->ViewValue = $Reporte_de_Pedidos->CodigoCli->CurrentValue;
			}
		} else {
			$Reporte_de_Pedidos->CodigoCli->ViewValue = NULL;
		}
		$Reporte_de_Pedidos->CodigoCli->CssStyle = "";
		$Reporte_de_Pedidos->CodigoCli->CssClass = "";
		$Reporte_de_Pedidos->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$Reporte_de_Pedidos->RazonSocialCli->ViewValue = $Reporte_de_Pedidos->RazonSocialCli->CurrentValue;
		$Reporte_de_Pedidos->RazonSocialCli->CssStyle = "";
		$Reporte_de_Pedidos->RazonSocialCli->CssClass = "";
		$Reporte_de_Pedidos->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$Reporte_de_Pedidos->CuitCli->ViewValue = $Reporte_de_Pedidos->CuitCli->CurrentValue;
		$Reporte_de_Pedidos->CuitCli->CssStyle = "";
		$Reporte_de_Pedidos->CuitCli->CssClass = "";
		$Reporte_de_Pedidos->CuitCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$Reporte_de_Pedidos->RazonSocialFlete->ViewValue = $Reporte_de_Pedidos->RazonSocialFlete->CurrentValue;
		$Reporte_de_Pedidos->RazonSocialFlete->CssStyle = "";
		$Reporte_de_Pedidos->RazonSocialFlete->CssClass = "";
		$Reporte_de_Pedidos->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$Reporte_de_Pedidos->Direccion->ViewValue = $Reporte_de_Pedidos->Direccion->CurrentValue;
		$Reporte_de_Pedidos->Direccion->CssStyle = "";
		$Reporte_de_Pedidos->Direccion->CssClass = "";
		$Reporte_de_Pedidos->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$Reporte_de_Pedidos->BarrioCli->ViewValue = $Reporte_de_Pedidos->BarrioCli->CurrentValue;
		$Reporte_de_Pedidos->BarrioCli->CssStyle = "";
		$Reporte_de_Pedidos->BarrioCli->CssClass = "";
		$Reporte_de_Pedidos->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$Reporte_de_Pedidos->LocalidadCli->ViewValue = $Reporte_de_Pedidos->LocalidadCli->CurrentValue;
		$Reporte_de_Pedidos->LocalidadCli->CssStyle = "";
		$Reporte_de_Pedidos->LocalidadCli->CssClass = "";
		$Reporte_de_Pedidos->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$Reporte_de_Pedidos->DescrProvincia->ViewValue = $Reporte_de_Pedidos->DescrProvincia->CurrentValue;
		$Reporte_de_Pedidos->DescrProvincia->CssStyle = "";
		$Reporte_de_Pedidos->DescrProvincia->CssClass = "";
		$Reporte_de_Pedidos->DescrProvincia->ViewCustomAttributes = "";

		// DescrPais
		$Reporte_de_Pedidos->DescrPais->ViewValue = $Reporte_de_Pedidos->DescrPais->CurrentValue;
		$Reporte_de_Pedidos->DescrPais->CssStyle = "";
		$Reporte_de_Pedidos->DescrPais->CssClass = "";
		$Reporte_de_Pedidos->DescrPais->ViewCustomAttributes = "";

		// CodigoPostalCli
		$Reporte_de_Pedidos->CodigoPostalCli->ViewValue = $Reporte_de_Pedidos->CodigoPostalCli->CurrentValue;
		$Reporte_de_Pedidos->CodigoPostalCli->CssStyle = "";
		$Reporte_de_Pedidos->CodigoPostalCli->CssClass = "";
		$Reporte_de_Pedidos->CodigoPostalCli->ViewCustomAttributes = "";

		// Telefono
		$Reporte_de_Pedidos->Telefono->ViewValue = $Reporte_de_Pedidos->Telefono->CurrentValue;
		$Reporte_de_Pedidos->Telefono->CssStyle = "";
		$Reporte_de_Pedidos->Telefono->CssClass = "";
		$Reporte_de_Pedidos->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$Reporte_de_Pedidos->FaxCli->ViewValue = $Reporte_de_Pedidos->FaxCli->CurrentValue;
		$Reporte_de_Pedidos->FaxCli->CssStyle = "";
		$Reporte_de_Pedidos->FaxCli->CssClass = "";
		$Reporte_de_Pedidos->FaxCli->ViewCustomAttributes = "";

		// emailCli
		$Reporte_de_Pedidos->emailCli->ViewValue = $Reporte_de_Pedidos->emailCli->CurrentValue;
		$Reporte_de_Pedidos->emailCli->CssStyle = "";
		$Reporte_de_Pedidos->emailCli->CssClass = "";
		$Reporte_de_Pedidos->emailCli->ViewCustomAttributes = "";

		// DescrIvaC
		$Reporte_de_Pedidos->DescrIvaC->ViewValue = $Reporte_de_Pedidos->DescrIvaC->CurrentValue;
		$Reporte_de_Pedidos->DescrIvaC->CssStyle = "";
		$Reporte_de_Pedidos->DescrIvaC->CssClass = "";
		$Reporte_de_Pedidos->DescrIvaC->ViewCustomAttributes = "";

		// DescrListaPrec
		$Reporte_de_Pedidos->DescrListaPrec->ViewValue = $Reporte_de_Pedidos->DescrListaPrec->CurrentValue;
		$Reporte_de_Pedidos->DescrListaPrec->CssStyle = "";
		$Reporte_de_Pedidos->DescrListaPrec->CssClass = "";
		$Reporte_de_Pedidos->DescrListaPrec->ViewCustomAttributes = "";

		// idPedido
		$Reporte_de_Pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		$Reporte_de_Pedidos->CodInternoArti->HrefValue = "";

		// precio
		$Reporte_de_Pedidos->precio->HrefValue = "";

		// cantidad
		$Reporte_de_Pedidos->cantidad->HrefValue = "";

		// TasaIva
		$Reporte_de_Pedidos->TasaIva->HrefValue = "";

		// CodigoCli
		$Reporte_de_Pedidos->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$Reporte_de_Pedidos->RazonSocialCli->HrefValue = "";

		// CuitCli
		$Reporte_de_Pedidos->CuitCli->HrefValue = "";

		// RazonSocialFlete
		$Reporte_de_Pedidos->RazonSocialFlete->HrefValue = "";

		// Direccion
		$Reporte_de_Pedidos->Direccion->HrefValue = "";

		// BarrioCli
		$Reporte_de_Pedidos->BarrioCli->HrefValue = "";

		// LocalidadCli
		$Reporte_de_Pedidos->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$Reporte_de_Pedidos->DescrProvincia->HrefValue = "";

		// DescrPais
		$Reporte_de_Pedidos->DescrPais->HrefValue = "";

		// CodigoPostalCli
		$Reporte_de_Pedidos->CodigoPostalCli->HrefValue = "";

		// Telefono
		$Reporte_de_Pedidos->Telefono->HrefValue = "";

		// FaxCli
		$Reporte_de_Pedidos->FaxCli->HrefValue = "";

		// emailCli
		$Reporte_de_Pedidos->emailCli->HrefValue = "";

		// DescrIvaC
		$Reporte_de_Pedidos->DescrIvaC->HrefValue = "";

		// DescrListaPrec
		$Reporte_de_Pedidos->DescrListaPrec->HrefValue = "";
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
$Reporte_de_Pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $Reporte_de_Pedidos->Export; // Get export parameter, used in header
$sExportFile = $Reporte_de_Pedidos->TableVar; // Get export file, used in header
?>
<?php
if ($Reporte_de_Pedidos->Export == "html") {

	// Printer friendly, no action required
}
if ($Reporte_de_Pedidos->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($Reporte_de_Pedidos->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($Reporte_de_Pedidos->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($Reporte_de_Pedidos->Export == "csv") {
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
$vGrps = ew_InitArray(3, NULL);
$nCntRecs = ew_InitArray(3, 0);
$bLvlBreak = ew_InitArray(3, FALSE);
$nTotals = ew_Init2DArray(3, 19, 0);
$nMaxs = ew_Init2DArray(3, 19, 0);
$nMins = ew_Init2DArray(3, 19, 0);
?>
<?php include "header.php" ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php if ($Reporte_de_Pedidos->Export == "") { ?>
<?php } ?>
<p><span class="phpmaker">Reporte: Reporte de Pedidos
<?php if ($Reporte_de_Pedidos->Export == "") { ?>
&nbsp;&nbsp;<a href="Reporte_de_Pedidosreport.php?export=html">Vista impresión</a>
&nbsp;&nbsp;<a href="Reporte_de_Pedidosreport.php?export=excel">Exportar a Excel</a>
&nbsp;&nbsp;<a href="Reporte_de_Pedidosreport.php?export=word">Exportar a Word</a>
<?php } ?>
</span></p>
<form method="post">
<table class="ewReportTable" cellspacing="-1">
<?php
$sFilter = "";
if ($sDbDetailFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sDbDetailFilter . ")";
}

// Set up filter and load Group level sql
$Reporte_de_Pedidos->CurrentFilter = $sFilter;
$sSql = $Reporte_de_Pedidos->GroupSQL();

// echo $sSql;
// Load recordset

$rs = $conn->Execute($sSql);

// Get First Row
if (!$rs->EOF) {
	$Reporte_de_Pedidos->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$vGrps[0] = $Reporte_de_Pedidos->CodigoCli->DbValue;
	$Reporte_de_Pedidos->idPedido->setDbValue($rs->fields('idPedido'));

	//$Reporte_de_Pedidos->idPedido->setDbValue(ew_Conv($Reporte_de_Pedidos->idPedido->DbValue, 19)); // Convert UnsignedSmallInt/UnsignedInt
	$vGrps[1] = $Reporte_de_Pedidos->idPedido->DbValue;
}
$nRecCount = 0;
$nCntRecs[0] = 0;
ChkLvlBreak();
while (!$rs->EOF) {

	// Render for view
	$Reporte_de_Pedidos->RowType = EW_ROWTYPE_VIEW;
	RenderRow();

	// Show group headers
	if ($bLvlBreak[1]) { // Reset counter and aggregation
?>
	<tr><td class="ewGroupField"><span class="phpmaker">Código Cliente</span></td>
	<td colspan=17 class="ewGroupName"><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->CodigoCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->CodigoCli->ViewValue ?></div>
</span></td></tr>
<?php
	}
	if ($bLvlBreak[2]) { // Reset counter and aggregation
?>
	<tr><td class="ewGroupField"><span class="phpmaker">ID Pedido</span></td>
	<td colspan=17 class="ewGroupName"><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->idPedido->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->idPedido->ViewValue ?></div>
</span></td></tr>
<?php
	}

	// Get detail records
	$sFilter = "";
	if ($sFilter <> "") $sFilter .= " AND ";
	if (is_null($Reporte_de_Pedidos->CodigoCli->CurrentValue)) {
		$sFilter .= "(walger_pedidos.CodigoCli IS NULL)";
	} else {
		$sFilter .= "(walger_pedidos.CodigoCli = '" . ew_AdjustSql($Reporte_de_Pedidos->CodigoCli->CurrentValue) . "')";
	}
	if ($sFilter <> "") $sFilter .= " AND ";
	if (is_null($Reporte_de_Pedidos->idPedido->CurrentValue)) {
		$sFilter .= "(walger_pedidos.idPedido IS NULL)";
	} else {
		$sFilter .= "(walger_pedidos.idPedido = " . ew_AdjustSql($Reporte_de_Pedidos->idPedido->CurrentValue) . ")";
	}
	if ($sDbDetailFilter <> "") {
		if ($sFilter <> "") $sFilter .= " AND ";
		$sFilter .= "(" . $sDbDetailFilter . ")";
	}

	// Set up detail SQL
	$Reporte_de_Pedidos->CurrentFilter = $sFilter;
	$sSql = $Reporte_de_Pedidos->DetailSQL();

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
	for ($i = 1; $i <= 2; $i++) {
		if ($bLvlBreak[$i]) { // Reset counter and aggregation
			$nCntRecs[$i] = 0;
		}
	}
	$nCntRecs[0] += $nDtlRecs;
	$nCntRecs[1] += $nDtlRecs;
	$nCntRecs[2] += $nDtlRecs;
?>
	<tr>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Código Artículo</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Precio</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Cantidad</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Tasa Iva</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Razon Social</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">CUIT</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Razon Social Flete</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Dirección</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Barrio</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Localidad</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Provincia</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">País</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Codigo Postal</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Teléfono</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Fax</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">EMail</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Condición IVA</span></td>
		<td valign="top" class="ewGroupHeader"><span class="phpmaker">Lista de Precios</span></td>
	</tr>
<?php
	while (!$rsdtl->EOF) {
		$Reporte_de_Pedidos->CodInternoArti->setDbValue($rsdtl->fields('CodInternoArti'));
		$Reporte_de_Pedidos->precio->setDbValue($rsdtl->fields('precio'));
		$Reporte_de_Pedidos->cantidad->setDbValue($rsdtl->fields('cantidad'));
		$Reporte_de_Pedidos->TasaIva->setDbValue($rsdtl->fields('TasaIva'));
		$Reporte_de_Pedidos->RazonSocialCli->setDbValue($rsdtl->fields('RazonSocialCli'));
		$Reporte_de_Pedidos->CuitCli->setDbValue($rsdtl->fields('CuitCli'));
		$Reporte_de_Pedidos->RazonSocialFlete->setDbValue($rsdtl->fields('RazonSocialFlete'));
		$Reporte_de_Pedidos->Direccion->setDbValue($rsdtl->fields('Direccion'));
		$Reporte_de_Pedidos->BarrioCli->setDbValue($rsdtl->fields('BarrioCli'));
		$Reporte_de_Pedidos->LocalidadCli->setDbValue($rsdtl->fields('LocalidadCli'));
		$Reporte_de_Pedidos->DescrProvincia->setDbValue($rsdtl->fields('DescrProvincia'));
		$Reporte_de_Pedidos->DescrPais->setDbValue($rsdtl->fields('DescrPais'));
		$Reporte_de_Pedidos->CodigoPostalCli->setDbValue($rsdtl->fields('CodigoPostalCli'));
		$Reporte_de_Pedidos->Telefono->setDbValue($rsdtl->fields('Telefono'));
		$Reporte_de_Pedidos->FaxCli->setDbValue($rsdtl->fields('FaxCli'));
		$Reporte_de_Pedidos->emailCli->setDbValue($rsdtl->fields('emailCli'));
		$Reporte_de_Pedidos->DescrIvaC->setDbValue($rsdtl->fields('DescrIvaC'));
		$Reporte_de_Pedidos->DescrListaPrec->setDbValue($rsdtl->fields('DescrListaPrec'));

		// Render for view
		$Reporte_de_Pedidos->RowType = EW_ROWTYPE_VIEW;
		RenderRow();
?>
	<tr>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->CodInternoArti->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->precio->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->precio->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->cantidad->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->cantidad->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->TasaIva->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->TasaIva->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->RazonSocialCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->RazonSocialCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->CuitCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->CuitCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->RazonSocialFlete->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->RazonSocialFlete->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->Direccion->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->Direccion->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->BarrioCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->BarrioCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->LocalidadCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->LocalidadCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->DescrProvincia->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->DescrProvincia->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->DescrPais->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->DescrPais->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->CodigoPostalCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->CodigoPostalCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->Telefono->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->Telefono->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->FaxCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->FaxCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->emailCli->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->emailCli->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->DescrIvaC->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->DescrIvaC->ViewValue ?></div>
</span></td>
		<td><span class="phpmaker">
<div<?php echo $Reporte_de_Pedidos->DescrListaPrec->ViewAttributes() ?>><?php echo $Reporte_de_Pedidos->DescrListaPrec->ViewValue ?></div>
</span></td>
	</tr>
<?php
		$rsdtl->MoveNext();
	}
	$rsdtl->Close();

	// Save old group data
	$vGrps[0] = $Reporte_de_Pedidos->CodigoCli->CurrentValue;
	$vGrps[1] = $Reporte_de_Pedidos->idPedido->CurrentValue;

	// Get next record
	$rs->MoveNext();
	if ($rs->EOF) {
		$nRecCount = 0; // EOF, force all level breaks
	} else {
		$Reporte_de_Pedidos->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$Reporte_de_Pedidos->idPedido->setDbValue($rs->fields('idPedido'));

		//$Reporte_de_Pedidos->idPedido->setDbValue = ew_Conv($Reporte_de_Pedidos->idPedido->DbValue, 19); // Convert UnsignedSmallInt/UnsignedInt
	}
	ChkLvlBreak();

	// Show Footers
	if ($bLvlBreak[2]) {
		$Reporte_de_Pedidos->idPedido->CurrentValue = $vGrps[1];

		// Render row for view
		$Reporte_de_Pedidos->RowType = EW_ROWTYPE_VIEW;
		RenderRow();
		$Reporte_de_Pedidos->idPedido->CurrentValue = $Reporte_de_Pedidos->idPedido->DbValue;
?>
<?php
}
	if ($bLvlBreak[1]) {
		$Reporte_de_Pedidos->CodigoCli->CurrentValue = $vGrps[0];

		// Render row for view
		$Reporte_de_Pedidos->RowType = EW_ROWTYPE_VIEW;
		RenderRow();
		$Reporte_de_Pedidos->CodigoCli->CurrentValue = $Reporte_de_Pedidos->CodigoCli->DbValue;
?>
<?php
}
}

// Close recordset
$rs->Close();
?>
	<tr><td colspan=18><span class="phpmaker">&nbsp;<br></span></td></tr>
	<tr><td colspan=18 class="ewGrandSummary"><span class="phpmaker">Total (<?php echo ew_FormatNumber($nCntRecs[0],0) ?> Registro de detalle)</span></td></tr>
	<tr><td colspan=18><span class="phpmaker">&nbsp;<br></span></td></tr>
</table>
</form>
<?php

// Check level break
function ChkLvlBreak() {
	global $nRecCount, $bLvlBreak, $vGrps, $Reporte_de_Pedidos;
	$bLvlBreak[1] = FALSE;
	$bLvlBreak[2] = FALSE;
	if ($nRecCount == 0) { // Start Or End of Recordset
		$bLvlBreak[1] = TRUE;
		$bLvlBreak[2] = TRUE;
	} else {
		if (!ew_CompareValue($Reporte_de_Pedidos->CodigoCli->CurrentValue, $vGrps[0])) {
			$bLvlBreak[1] = TRUE;
			$bLvlBreak[2] = TRUE;
		}
		if (!ew_CompareValue($Reporte_de_Pedidos->idPedido->CurrentValue, $vGrps[1])) {
			$bLvlBreak[2] = TRUE;
		}
	}
}
?>
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
	global $conn, $Security, $Reporte_de_Pedidos;

	// Common render codes for all row types
	// idPedido

	$Reporte_de_Pedidos->idPedido->CellCssStyle = "";
	$Reporte_de_Pedidos->idPedido->CellCssClass = "";

	// CodInternoArti
	$Reporte_de_Pedidos->CodInternoArti->CellCssStyle = "";
	$Reporte_de_Pedidos->CodInternoArti->CellCssClass = "";

	// precio
	$Reporte_de_Pedidos->precio->CellCssStyle = "";
	$Reporte_de_Pedidos->precio->CellCssClass = "";

	// cantidad
	$Reporte_de_Pedidos->cantidad->CellCssStyle = "";
	$Reporte_de_Pedidos->cantidad->CellCssClass = "";

	// TasaIva
	$Reporte_de_Pedidos->TasaIva->CellCssStyle = "";
	$Reporte_de_Pedidos->TasaIva->CellCssClass = "";

	// CodigoCli
	$Reporte_de_Pedidos->CodigoCli->CellCssStyle = "";
	$Reporte_de_Pedidos->CodigoCli->CellCssClass = "";

	// RazonSocialCli
	$Reporte_de_Pedidos->RazonSocialCli->CellCssStyle = "";
	$Reporte_de_Pedidos->RazonSocialCli->CellCssClass = "";

	// CuitCli
	$Reporte_de_Pedidos->CuitCli->CellCssStyle = "";
	$Reporte_de_Pedidos->CuitCli->CellCssClass = "";

	// RazonSocialFlete
	$Reporte_de_Pedidos->RazonSocialFlete->CellCssStyle = "";
	$Reporte_de_Pedidos->RazonSocialFlete->CellCssClass = "";

	// Direccion
	$Reporte_de_Pedidos->Direccion->CellCssStyle = "";
	$Reporte_de_Pedidos->Direccion->CellCssClass = "";

	// BarrioCli
	$Reporte_de_Pedidos->BarrioCli->CellCssStyle = "";
	$Reporte_de_Pedidos->BarrioCli->CellCssClass = "";

	// LocalidadCli
	$Reporte_de_Pedidos->LocalidadCli->CellCssStyle = "";
	$Reporte_de_Pedidos->LocalidadCli->CellCssClass = "";

	// DescrProvincia
	$Reporte_de_Pedidos->DescrProvincia->CellCssStyle = "";
	$Reporte_de_Pedidos->DescrProvincia->CellCssClass = "";

	// DescrPais
	$Reporte_de_Pedidos->DescrPais->CellCssStyle = "";
	$Reporte_de_Pedidos->DescrPais->CellCssClass = "";

	// CodigoPostalCli
	$Reporte_de_Pedidos->CodigoPostalCli->CellCssStyle = "";
	$Reporte_de_Pedidos->CodigoPostalCli->CellCssClass = "";

	// Telefono
	$Reporte_de_Pedidos->Telefono->CellCssStyle = "";
	$Reporte_de_Pedidos->Telefono->CellCssClass = "";

	// FaxCli
	$Reporte_de_Pedidos->FaxCli->CellCssStyle = "";
	$Reporte_de_Pedidos->FaxCli->CellCssClass = "";

	// emailCli
	$Reporte_de_Pedidos->emailCli->CellCssStyle = "";
	$Reporte_de_Pedidos->emailCli->CellCssClass = "";

	// DescrIvaC
	$Reporte_de_Pedidos->DescrIvaC->CellCssStyle = "";
	$Reporte_de_Pedidos->DescrIvaC->CellCssClass = "";

	// DescrListaPrec
	$Reporte_de_Pedidos->DescrListaPrec->CellCssStyle = "";
	$Reporte_de_Pedidos->DescrListaPrec->CellCssClass = "";
	if ($Reporte_de_Pedidos->RowType == EW_ROWTYPE_VIEW) { // View row

		// idPedido
		$Reporte_de_Pedidos->idPedido->ViewValue = $Reporte_de_Pedidos->idPedido->CurrentValue;
		$Reporte_de_Pedidos->idPedido->CssStyle = "";
		$Reporte_de_Pedidos->idPedido->CssClass = "";
		$Reporte_de_Pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$Reporte_de_Pedidos->CodInternoArti->ViewValue = $Reporte_de_Pedidos->CodInternoArti->CurrentValue;
		$Reporte_de_Pedidos->CodInternoArti->CssStyle = "";
		$Reporte_de_Pedidos->CodInternoArti->CssClass = "";
		$Reporte_de_Pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$Reporte_de_Pedidos->precio->ViewValue = $Reporte_de_Pedidos->precio->CurrentValue;
		$Reporte_de_Pedidos->precio->CssStyle = "";
		$Reporte_de_Pedidos->precio->CssClass = "";
		$Reporte_de_Pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$Reporte_de_Pedidos->cantidad->ViewValue = $Reporte_de_Pedidos->cantidad->CurrentValue;
		$Reporte_de_Pedidos->cantidad->CssStyle = "";
		$Reporte_de_Pedidos->cantidad->CssClass = "";
		$Reporte_de_Pedidos->cantidad->ViewCustomAttributes = "";

		// TasaIva
		$Reporte_de_Pedidos->TasaIva->ViewValue = $Reporte_de_Pedidos->TasaIva->CurrentValue;
		$Reporte_de_Pedidos->TasaIva->CssStyle = "";
		$Reporte_de_Pedidos->TasaIva->CssClass = "";
		$Reporte_de_Pedidos->TasaIva->ViewCustomAttributes = "";

		// CodigoCli
		if (!is_null($Reporte_de_Pedidos->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($Reporte_de_Pedidos->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$Reporte_de_Pedidos->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$Reporte_de_Pedidos->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$Reporte_de_Pedidos->CodigoCli->ViewValue = $Reporte_de_Pedidos->CodigoCli->CurrentValue;
			}
		} else {
			$Reporte_de_Pedidos->CodigoCli->ViewValue = NULL;
		}
		$Reporte_de_Pedidos->CodigoCli->CssStyle = "";
		$Reporte_de_Pedidos->CodigoCli->CssClass = "";
		$Reporte_de_Pedidos->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$Reporte_de_Pedidos->RazonSocialCli->ViewValue = $Reporte_de_Pedidos->RazonSocialCli->CurrentValue;
		$Reporte_de_Pedidos->RazonSocialCli->CssStyle = "";
		$Reporte_de_Pedidos->RazonSocialCli->CssClass = "";
		$Reporte_de_Pedidos->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$Reporte_de_Pedidos->CuitCli->ViewValue = $Reporte_de_Pedidos->CuitCli->CurrentValue;
		$Reporte_de_Pedidos->CuitCli->CssStyle = "";
		$Reporte_de_Pedidos->CuitCli->CssClass = "";
		$Reporte_de_Pedidos->CuitCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$Reporte_de_Pedidos->RazonSocialFlete->ViewValue = $Reporte_de_Pedidos->RazonSocialFlete->CurrentValue;
		$Reporte_de_Pedidos->RazonSocialFlete->CssStyle = "";
		$Reporte_de_Pedidos->RazonSocialFlete->CssClass = "";
		$Reporte_de_Pedidos->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$Reporte_de_Pedidos->Direccion->ViewValue = $Reporte_de_Pedidos->Direccion->CurrentValue;
		$Reporte_de_Pedidos->Direccion->CssStyle = "";
		$Reporte_de_Pedidos->Direccion->CssClass = "";
		$Reporte_de_Pedidos->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$Reporte_de_Pedidos->BarrioCli->ViewValue = $Reporte_de_Pedidos->BarrioCli->CurrentValue;
		$Reporte_de_Pedidos->BarrioCli->CssStyle = "";
		$Reporte_de_Pedidos->BarrioCli->CssClass = "";
		$Reporte_de_Pedidos->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$Reporte_de_Pedidos->LocalidadCli->ViewValue = $Reporte_de_Pedidos->LocalidadCli->CurrentValue;
		$Reporte_de_Pedidos->LocalidadCli->CssStyle = "";
		$Reporte_de_Pedidos->LocalidadCli->CssClass = "";
		$Reporte_de_Pedidos->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$Reporte_de_Pedidos->DescrProvincia->ViewValue = $Reporte_de_Pedidos->DescrProvincia->CurrentValue;
		$Reporte_de_Pedidos->DescrProvincia->CssStyle = "";
		$Reporte_de_Pedidos->DescrProvincia->CssClass = "";
		$Reporte_de_Pedidos->DescrProvincia->ViewCustomAttributes = "";

		// DescrPais
		$Reporte_de_Pedidos->DescrPais->ViewValue = $Reporte_de_Pedidos->DescrPais->CurrentValue;
		$Reporte_de_Pedidos->DescrPais->CssStyle = "";
		$Reporte_de_Pedidos->DescrPais->CssClass = "";
		$Reporte_de_Pedidos->DescrPais->ViewCustomAttributes = "";

		// CodigoPostalCli
		$Reporte_de_Pedidos->CodigoPostalCli->ViewValue = $Reporte_de_Pedidos->CodigoPostalCli->CurrentValue;
		$Reporte_de_Pedidos->CodigoPostalCli->CssStyle = "";
		$Reporte_de_Pedidos->CodigoPostalCli->CssClass = "";
		$Reporte_de_Pedidos->CodigoPostalCli->ViewCustomAttributes = "";

		// Telefono
		$Reporte_de_Pedidos->Telefono->ViewValue = $Reporte_de_Pedidos->Telefono->CurrentValue;
		$Reporte_de_Pedidos->Telefono->CssStyle = "";
		$Reporte_de_Pedidos->Telefono->CssClass = "";
		$Reporte_de_Pedidos->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$Reporte_de_Pedidos->FaxCli->ViewValue = $Reporte_de_Pedidos->FaxCli->CurrentValue;
		$Reporte_de_Pedidos->FaxCli->CssStyle = "";
		$Reporte_de_Pedidos->FaxCli->CssClass = "";
		$Reporte_de_Pedidos->FaxCli->ViewCustomAttributes = "";

		// emailCli
		$Reporte_de_Pedidos->emailCli->ViewValue = $Reporte_de_Pedidos->emailCli->CurrentValue;
		$Reporte_de_Pedidos->emailCli->CssStyle = "";
		$Reporte_de_Pedidos->emailCli->CssClass = "";
		$Reporte_de_Pedidos->emailCli->ViewCustomAttributes = "";

		// DescrIvaC
		$Reporte_de_Pedidos->DescrIvaC->ViewValue = $Reporte_de_Pedidos->DescrIvaC->CurrentValue;
		$Reporte_de_Pedidos->DescrIvaC->CssStyle = "";
		$Reporte_de_Pedidos->DescrIvaC->CssClass = "";
		$Reporte_de_Pedidos->DescrIvaC->ViewCustomAttributes = "";

		// DescrListaPrec
		$Reporte_de_Pedidos->DescrListaPrec->ViewValue = $Reporte_de_Pedidos->DescrListaPrec->CurrentValue;
		$Reporte_de_Pedidos->DescrListaPrec->CssStyle = "";
		$Reporte_de_Pedidos->DescrListaPrec->CssClass = "";
		$Reporte_de_Pedidos->DescrListaPrec->ViewCustomAttributes = "";

		// idPedido
		$Reporte_de_Pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		$Reporte_de_Pedidos->CodInternoArti->HrefValue = "";

		// precio
		$Reporte_de_Pedidos->precio->HrefValue = "";

		// cantidad
		$Reporte_de_Pedidos->cantidad->HrefValue = "";

		// TasaIva
		$Reporte_de_Pedidos->TasaIva->HrefValue = "";

		// CodigoCli
		$Reporte_de_Pedidos->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$Reporte_de_Pedidos->RazonSocialCli->HrefValue = "";

		// CuitCli
		$Reporte_de_Pedidos->CuitCli->HrefValue = "";

		// RazonSocialFlete
		$Reporte_de_Pedidos->RazonSocialFlete->HrefValue = "";

		// Direccion
		$Reporte_de_Pedidos->Direccion->HrefValue = "";

		// BarrioCli
		$Reporte_de_Pedidos->BarrioCli->HrefValue = "";

		// LocalidadCli
		$Reporte_de_Pedidos->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$Reporte_de_Pedidos->DescrProvincia->HrefValue = "";

		// DescrPais
		$Reporte_de_Pedidos->DescrPais->HrefValue = "";

		// CodigoPostalCli
		$Reporte_de_Pedidos->CodigoPostalCli->HrefValue = "";

		// Telefono
		$Reporte_de_Pedidos->Telefono->HrefValue = "";

		// FaxCli
		$Reporte_de_Pedidos->FaxCli->HrefValue = "";

		// emailCli
		$Reporte_de_Pedidos->emailCli->HrefValue = "";

		// DescrIvaC
		$Reporte_de_Pedidos->DescrIvaC->HrefValue = "";

		// DescrListaPrec
		$Reporte_de_Pedidos->DescrListaPrec->HrefValue = "";
	} elseif ($Reporte_de_Pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($Reporte_de_Pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($Reporte_de_Pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
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
