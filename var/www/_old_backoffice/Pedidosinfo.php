<?php

// PHPMaker 5 configuration for Table Pedidos
$Pedidos = new cPedidos; // Initialize table object

// Define table class
class cPedidos {

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

	function cPedidos() {
		$this->TableVar = "Pedidos";
		$this->TableName = "Pedidos";
		$this->idPedido = new cField('Pedidos', 'x_idPedido', 'idPedido', "walger_pedidos.idPedido", 19, -1, FALSE);
		$this->fields['idPedido'] =& $this->idPedido;
		$this->CodInternoArti = new cField('Pedidos', 'x_CodInternoArti', 'CodInternoArti', "walger_items_pedidos.CodInternoArti", 200, -1, FALSE);
		$this->fields['CodInternoArti'] =& $this->CodInternoArti;
		$this->precio = new cField('Pedidos', 'x_precio', 'precio', "walger_items_pedidos.precio", 4, -1, FALSE);
		$this->fields['precio'] =& $this->precio;
		$this->cantidad = new cField('Pedidos', 'x_cantidad', 'cantidad', "walger_items_pedidos.cantidad", 3, -1, FALSE);
		$this->fields['cantidad'] =& $this->cantidad;
		$this->TasaIva = new cField('Pedidos', 'x_TasaIva', 'TasaIva', "dbo_articulo.TasaIva", 4, -1, FALSE);
		$this->fields['TasaIva'] =& $this->TasaIva;
		$this->CodigoCli = new cField('Pedidos', 'x_CodigoCli', 'CodigoCli', "walger_pedidos.CodigoCli", 200, -1, FALSE);
		$this->fields['CodigoCli'] =& $this->CodigoCli;
		$this->RazonSocialCli = new cField('Pedidos', 'x_RazonSocialCli', 'RazonSocialCli', "dbo_cliente.RazonSocialCli", 200, -1, FALSE);
		$this->fields['RazonSocialCli'] =& $this->RazonSocialCli;
		$this->CuitCli = new cField('Pedidos', 'x_CuitCli', 'CuitCli', "dbo_cliente.CuitCli", 200, -1, FALSE);
		$this->fields['CuitCli'] =& $this->CuitCli;
		$this->RazonSocialFlete = new cField('Pedidos', 'x_RazonSocialFlete', 'RazonSocialFlete', "dbo_cliente.RazonSocialFlete", 200, -1, FALSE);
		$this->fields['RazonSocialFlete'] =& $this->RazonSocialFlete;
		$this->Direccion = new cField('Pedidos', 'x_Direccion', 'Direccion', "dbo_cliente.Direccion", 200, -1, FALSE);
		$this->fields['Direccion'] =& $this->Direccion;
		$this->BarrioCli = new cField('Pedidos', 'x_BarrioCli', 'BarrioCli', "dbo_cliente.BarrioCli", 200, -1, FALSE);
		$this->fields['BarrioCli'] =& $this->BarrioCli;
		$this->LocalidadCli = new cField('Pedidos', 'x_LocalidadCli', 'LocalidadCli', "dbo_cliente.LocalidadCli", 200, -1, FALSE);
		$this->fields['LocalidadCli'] =& $this->LocalidadCli;
		$this->DescrProvincia = new cField('Pedidos', 'x_DescrProvincia', 'DescrProvincia', "dbo_cliente.DescrProvincia", 200, -1, FALSE);
		$this->fields['DescrProvincia'] =& $this->DescrProvincia;
		$this->DescrPais = new cField('Pedidos', 'x_DescrPais', 'DescrPais', "dbo_cliente.DescrPais", 200, -1, FALSE);
		$this->fields['DescrPais'] =& $this->DescrPais;
		$this->CodigoPostalCli = new cField('Pedidos', 'x_CodigoPostalCli', 'CodigoPostalCli', "dbo_cliente.CodigoPostalCli", 200, -1, FALSE);
		$this->fields['CodigoPostalCli'] =& $this->CodigoPostalCli;
		$this->Telefono = new cField('Pedidos', 'x_Telefono', 'Telefono', "dbo_cliente.Telefono", 200, -1, FALSE);
		$this->fields['Telefono'] =& $this->Telefono;
		$this->FaxCli = new cField('Pedidos', 'x_FaxCli', 'FaxCli', "dbo_cliente.FaxCli", 200, -1, FALSE);
		$this->fields['FaxCli'] =& $this->FaxCli;
		$this->emailCli = new cField('Pedidos', 'x_emailCli', 'emailCli', "dbo_cliente.emailCli", 200, -1, FALSE);
		$this->fields['emailCli'] =& $this->emailCli;
		$this->DescrIvaC = new cField('Pedidos', 'x_DescrIvaC', 'DescrIvaC', "dbo_ivacondicion.DescrIvaC", 200, -1, FALSE);
		$this->fields['DescrIvaC'] =& $this->DescrIvaC;
		$this->DescrListaPrec = new cField('Pedidos', 'x_DescrListaPrec', 'DescrListaPrec', "dbo_listaprecios.DescrListaPrec", 200, -1, FALSE);
		$this->fields['DescrListaPrec'] =& $this->DescrListaPrec;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search Keyword
	function getBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic Search Type
	function getBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search where clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session WHERE Clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session Key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Table level SQL
	function SqlSelect() { // Select
		return "SELECT walger_pedidos.CodigoCli, walger_items_pedidos.CodInternoArti, walger_pedidos.idPedido, walger_items_pedidos.precio, walger_items_pedidos.cantidad, dbo_cliente.RazonSocialCli, dbo_cliente.CuitCli, dbo_cliente.emailCli, dbo_cliente.RazonSocialFlete, dbo_cliente.Direccion, dbo_cliente.BarrioCli, dbo_cliente.LocalidadCli, dbo_cliente.DescrProvincia, dbo_cliente.CodigoPostalCli, dbo_cliente.DescrPais, dbo_cliente.Telefono, dbo_cliente.FaxCli, dbo_articulo.TasaIva, dbo_ivacondicion.DescrIvaC, dbo_listaprecios.DescrListaPrec FROM walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec)";
	}

	function SqlWhere() { // Where
		return "(walger_pedidos.idPedido)";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Report table sql
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return table sql with list page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter .= " AND ";
			$sFilter .= $this->CurrentFilter;
		}
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return record count
	function SelectRecordCount() {
		global $conn;
		$cnt = -1;
		$sFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		if ($this->SelectLimit) {
			$sSelect = $this->SelectSQL();
			if (strtoupper(substr($sSelect, 0, 13)) == "SELECT * FROM") {
				$sSelect = "SELECT COUNT(*) FROM" . substr($sSelect, 13);
				if ($rs = $conn->Execute($sSelect)) {
					if (!$rs->EOF) $cnt = $rs->fields[0];
					$rs->Close();
				}
			}
		}
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $sFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= (is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec) ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec) SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=" .
					(is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
		$SQL = "DELETE FROM walger_pedidos INNER JOIN walger_items_pedidos ON (walger_pedidos.idPedido = walger_items_pedidos.idPedido) INNER JOIN dbo_cliente ON (walger_pedidos.CodigoCli = dbo_cliente.CodigoCli) INNER JOIN dbo_articulo ON (walger_items_pedidos.CodInternoArti = dbo_articulo.CodInternoArti) INNER JOIN dbo_ivacondicion ON (dbo_cliente.Regis_IvaC = dbo_ivacondicion.Regis_IvaC) INNER JOIN dbo_listaprecios ON (dbo_cliente.Regis_ListaPrec = dbo_listaprecios.Regis_ListaPrec) WHERE ";
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "";
	}

	// Return url
	function getReturnUrl() {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "Pedidoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("Pedidosview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("Pedidosedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("Pedidoslist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("Pedidosadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("Pedidoslist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("Pedidosdelete.php");
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
		$this->idPedido->ViewValue = $this->idPedido->CurrentValue;
		$this->idPedido->CssStyle = "";
		$this->idPedido->CssClass = "";
		$this->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$this->CodInternoArti->ViewValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->CssStyle = "";
		$this->CodInternoArti->CssClass = "";
		$this->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$this->precio->ViewValue = $this->precio->CurrentValue;
		$this->precio->CssStyle = "";
		$this->precio->CssClass = "";
		$this->precio->ViewCustomAttributes = "";

		// cantidad
		$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
		$this->cantidad->CssStyle = "";
		$this->cantidad->CssClass = "";
		$this->cantidad->ViewCustomAttributes = "";

		// TasaIva
		$this->TasaIva->ViewValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->CssStyle = "";
		$this->TasaIva->CssClass = "";
		$this->TasaIva->ViewCustomAttributes = "";

		// CodigoCli
		if (!is_null($this->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($this->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$this->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$this->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->ViewValue = NULL;
		}
		$this->CodigoCli->CssStyle = "";
		$this->CodigoCli->CssClass = "";
		$this->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$this->RazonSocialCli->ViewValue = $this->RazonSocialCli->CurrentValue;
		$this->RazonSocialCli->CssStyle = "";
		$this->RazonSocialCli->CssClass = "";
		$this->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$this->CuitCli->ViewValue = $this->CuitCli->CurrentValue;
		$this->CuitCli->CssStyle = "";
		$this->CuitCli->CssClass = "";
		$this->CuitCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$this->RazonSocialFlete->ViewValue = $this->RazonSocialFlete->CurrentValue;
		$this->RazonSocialFlete->CssStyle = "";
		$this->RazonSocialFlete->CssClass = "";
		$this->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$this->Direccion->ViewValue = $this->Direccion->CurrentValue;
		$this->Direccion->CssStyle = "";
		$this->Direccion->CssClass = "";
		$this->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$this->BarrioCli->ViewValue = $this->BarrioCli->CurrentValue;
		$this->BarrioCli->CssStyle = "";
		$this->BarrioCli->CssClass = "";
		$this->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$this->LocalidadCli->ViewValue = $this->LocalidadCli->CurrentValue;
		$this->LocalidadCli->CssStyle = "";
		$this->LocalidadCli->CssClass = "";
		$this->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$this->DescrProvincia->ViewValue = $this->DescrProvincia->CurrentValue;
		$this->DescrProvincia->CssStyle = "";
		$this->DescrProvincia->CssClass = "";
		$this->DescrProvincia->ViewCustomAttributes = "";

		// DescrPais
		$this->DescrPais->ViewValue = $this->DescrPais->CurrentValue;
		$this->DescrPais->CssStyle = "";
		$this->DescrPais->CssClass = "";
		$this->DescrPais->ViewCustomAttributes = "";

		// CodigoPostalCli
		$this->CodigoPostalCli->ViewValue = $this->CodigoPostalCli->CurrentValue;
		$this->CodigoPostalCli->CssStyle = "";
		$this->CodigoPostalCli->CssClass = "";
		$this->CodigoPostalCli->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->CssStyle = "";
		$this->Telefono->CssClass = "";
		$this->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$this->FaxCli->ViewValue = $this->FaxCli->CurrentValue;
		$this->FaxCli->CssStyle = "";
		$this->FaxCli->CssClass = "";
		$this->FaxCli->ViewCustomAttributes = "";

		// emailCli
		$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
		$this->emailCli->CssStyle = "";
		$this->emailCli->CssClass = "";
		$this->emailCli->ViewCustomAttributes = "";

		// DescrIvaC
		$this->DescrIvaC->ViewValue = $this->DescrIvaC->CurrentValue;
		$this->DescrIvaC->CssStyle = "";
		$this->DescrIvaC->CssClass = "";
		$this->DescrIvaC->ViewCustomAttributes = "";

		// DescrListaPrec
		$this->DescrListaPrec->ViewValue = $this->DescrListaPrec->CurrentValue;
		$this->DescrListaPrec->CssStyle = "";
		$this->DescrListaPrec->CssClass = "";
		$this->DescrListaPrec->ViewCustomAttributes = "";

		// idPedido
		$this->idPedido->HrefValue = "";

		// CodInternoArti
		$this->CodInternoArti->HrefValue = "";

		// precio
		$this->precio->HrefValue = "";

		// cantidad
		$this->cantidad->HrefValue = "";

		// TasaIva
		$this->TasaIva->HrefValue = "";

		// CodigoCli
		$this->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$this->RazonSocialCli->HrefValue = "";

		// CuitCli
		$this->CuitCli->HrefValue = "";

		// RazonSocialFlete
		$this->RazonSocialFlete->HrefValue = "";

		// Direccion
		$this->Direccion->HrefValue = "";

		// BarrioCli
		$this->BarrioCli->HrefValue = "";

		// LocalidadCli
		$this->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$this->DescrProvincia->HrefValue = "";

		// DescrPais
		$this->DescrPais->HrefValue = "";

		// CodigoPostalCli
		$this->CodigoPostalCli->HrefValue = "";

		// Telefono
		$this->Telefono->HrefValue = "";

		// FaxCli
		$this->FaxCli->HrefValue = "";

		// emailCli
		$this->emailCli->HrefValue = "";

		// DescrIvaC
		$this->DescrIvaC->HrefValue = "";

		// DescrListaPrec
		$this->DescrListaPrec->HrefValue = "";
	}
	var $CurrentAction; // Current action
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
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

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted(&$rs) {

		//echo "Row Inserted";
	}

	// Row Updating event
	function Row_Updating(&$rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Updated event
	function Row_Updated(&$rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Deleting event
	function Row_Deleting($rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}
}
?>
