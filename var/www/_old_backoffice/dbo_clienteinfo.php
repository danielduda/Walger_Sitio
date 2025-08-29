<?php

// PHPMaker 5 configuration for Table dbo_cliente
$dbo_cliente = new cdbo_cliente; // Initialize table object

// Define table class
class cdbo_cliente {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $CodigoCli;
	var $RazonSocialCli;
	var $CuitCli;
	var $IngBrutosCli;
	var $Regis_IvaC;
	var $Regis_ListaPrec;
	var $emailCli;
	var $RazonSocialFlete;
	var $Direccion;
	var $BarrioCli;
	var $LocalidadCli;
	var $DescrProvincia;
	var $CodigoPostalCli;
	var $DescrPais;
	var $Telefono;
	var $FaxCli;
	var $PaginaWebCli;
	var $fields = array();

	function cdbo_cliente() {
		$this->TableVar = "dbo_cliente";
		$this->TableName = "dbo_cliente";
		$this->SelectLimit = TRUE;
		$this->CodigoCli = new cField('dbo_cliente', 'x_CodigoCli', 'CodigoCli', "`CodigoCli`", 200, -1, FALSE);
		$this->fields['CodigoCli'] =& $this->CodigoCli;
		$this->RazonSocialCli = new cField('dbo_cliente', 'x_RazonSocialCli', 'RazonSocialCli', "`RazonSocialCli`", 200, -1, FALSE);
		$this->fields['RazonSocialCli'] =& $this->RazonSocialCli;
		$this->CuitCli = new cField('dbo_cliente', 'x_CuitCli', 'CuitCli', "`CuitCli`", 200, -1, FALSE);
		$this->fields['CuitCli'] =& $this->CuitCli;
		$this->IngBrutosCli = new cField('dbo_cliente', 'x_IngBrutosCli', 'IngBrutosCli', "`IngBrutosCli`", 200, -1, FALSE);
		$this->fields['IngBrutosCli'] =& $this->IngBrutosCli;
		$this->Regis_IvaC = new cField('dbo_cliente', 'x_Regis_IvaC', 'Regis_IvaC', "`Regis_IvaC`", 3, -1, FALSE);
		$this->fields['Regis_IvaC'] =& $this->Regis_IvaC;
		$this->Regis_ListaPrec = new cField('dbo_cliente', 'x_Regis_ListaPrec', 'Regis_ListaPrec', "`Regis_ListaPrec`", 3, -1, FALSE);
		$this->fields['Regis_ListaPrec'] =& $this->Regis_ListaPrec;
		$this->emailCli = new cField('dbo_cliente', 'x_emailCli', 'emailCli', "`emailCli`", 200, -1, FALSE);
		$this->fields['emailCli'] =& $this->emailCli;
		$this->RazonSocialFlete = new cField('dbo_cliente', 'x_RazonSocialFlete', 'RazonSocialFlete', "`RazonSocialFlete`", 200, -1, FALSE);
		$this->fields['RazonSocialFlete'] =& $this->RazonSocialFlete;
		$this->Direccion = new cField('dbo_cliente', 'x_Direccion', 'Direccion', "`Direccion`", 200, -1, FALSE);
		$this->fields['Direccion'] =& $this->Direccion;
		$this->BarrioCli = new cField('dbo_cliente', 'x_BarrioCli', 'BarrioCli', "`BarrioCli`", 200, -1, FALSE);
		$this->fields['BarrioCli'] =& $this->BarrioCli;
		$this->LocalidadCli = new cField('dbo_cliente', 'x_LocalidadCli', 'LocalidadCli', "`LocalidadCli`", 200, -1, FALSE);
		$this->fields['LocalidadCli'] =& $this->LocalidadCli;
		$this->DescrProvincia = new cField('dbo_cliente', 'x_DescrProvincia', 'DescrProvincia', "`DescrProvincia`", 200, -1, FALSE);
		$this->fields['DescrProvincia'] =& $this->DescrProvincia;
		$this->CodigoPostalCli = new cField('dbo_cliente', 'x_CodigoPostalCli', 'CodigoPostalCli', "`CodigoPostalCli`", 200, -1, FALSE);
		$this->fields['CodigoPostalCli'] =& $this->CodigoPostalCli;
		$this->DescrPais = new cField('dbo_cliente', 'x_DescrPais', 'DescrPais', "`DescrPais`", 200, -1, FALSE);
		$this->fields['DescrPais'] =& $this->DescrPais;
		$this->Telefono = new cField('dbo_cliente', 'x_Telefono', 'Telefono', "`Telefono`", 200, -1, FALSE);
		$this->fields['Telefono'] =& $this->Telefono;
		$this->FaxCli = new cField('dbo_cliente', 'x_FaxCli', 'FaxCli', "`FaxCli`", 200, -1, FALSE);
		$this->fields['FaxCli'] =& $this->FaxCli;
		$this->PaginaWebCli = new cField('dbo_cliente', 'x_PaginaWebCli', 'PaginaWebCli', "`PaginaWebCli`", 200, -1, FALSE);
		$this->fields['PaginaWebCli'] =& $this->PaginaWebCli;
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
		return "SELECT * FROM `dbo_cliente`";
	}

	function SqlWhere() { // Where
		return "";
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
		return "INSERT INTO `dbo_cliente` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `dbo_cliente` SET ";
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
		$SQL = "DELETE FROM `dbo_cliente` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'CodigoCli' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['CodigoCli'], $this->CodigoCli->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`CodigoCli` = '@CodigoCli@'";
	}

	// Return url
	function getReturnUrl() {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "dbo_clientelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("dbo_clienteview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("dbo_clienteedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("dbo_clientelist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("dbo_clienteadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("dbo_clientelist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("dbo_clientedelete.php");
	}

	// Key url
	function KeyUrl($url, $action = "") {
		$sUrl = $url . "?";
		if ($action <> "") $sUrl .= $action . "&";
		if (!is_null($this->CodigoCli->CurrentValue)) {
			$sUrl .= "CodigoCli=" . urlencode($this->CodigoCli->CurrentValue);
		} else {
			return "javascript:alert('Registro inválido!');";
		}
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
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
		$this->CuitCli->setDbValue($rs->fields('CuitCli'));
		$this->IngBrutosCli->setDbValue($rs->fields('IngBrutosCli'));
		$this->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
		$this->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
		$this->emailCli->setDbValue($rs->fields('emailCli'));
		$this->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
		$this->Direccion->setDbValue($rs->fields('Direccion'));
		$this->BarrioCli->setDbValue($rs->fields('BarrioCli'));
		$this->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
		$this->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
		$this->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
		$this->DescrPais->setDbValue($rs->fields('DescrPais'));
		$this->Telefono->setDbValue($rs->fields('Telefono'));
		$this->FaxCli->setDbValue($rs->fields('FaxCli'));
		$this->PaginaWebCli->setDbValue($rs->fields('PaginaWebCli'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// CodigoCli
		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
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

		// IngBrutosCli
		$this->IngBrutosCli->ViewValue = $this->IngBrutosCli->CurrentValue;
		$this->IngBrutosCli->CssStyle = "";
		$this->IngBrutosCli->CssClass = "";
		$this->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		if (!is_null($this->Regis_IvaC->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrIvaC` FROM `dbo_ivacondicion` WHERE `Regis_IvaC` = " . ew_AdjustSql($this->Regis_IvaC->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$this->Regis_IvaC->ViewValue = $rswrk->fields('DescrIvaC');
				}
				$rswrk->Close();
			} else {
				$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
			}
		} else {
			$this->Regis_IvaC->ViewValue = NULL;
		}
		$this->Regis_IvaC->CssStyle = "";
		$this->Regis_IvaC->CssClass = "";
		$this->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		if (!is_null($this->Regis_ListaPrec->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios` WHERE `Regis_ListaPrec` = " . ew_AdjustSql($this->Regis_ListaPrec->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$this->Regis_ListaPrec->ViewValue = $rswrk->fields('DescrListaPrec');
					$this->Regis_ListaPrec->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigListaPrec');
				}
				$rswrk->Close();
			} else {
				$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$this->Regis_ListaPrec->ViewValue = NULL;
		}
		$this->Regis_ListaPrec->CssStyle = "";
		$this->Regis_ListaPrec->CssClass = "";
		$this->Regis_ListaPrec->ViewCustomAttributes = "";

		// emailCli
		$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
		$this->emailCli->CssStyle = "";
		$this->emailCli->CssClass = "";
		$this->emailCli->ViewCustomAttributes = "";

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

		// CodigoPostalCli
		$this->CodigoPostalCli->ViewValue = $this->CodigoPostalCli->CurrentValue;
		$this->CodigoPostalCli->CssStyle = "";
		$this->CodigoPostalCli->CssClass = "";
		$this->CodigoPostalCli->ViewCustomAttributes = "";

		// DescrPais
		$this->DescrPais->ViewValue = $this->DescrPais->CurrentValue;
		$this->DescrPais->CssStyle = "";
		$this->DescrPais->CssClass = "";
		$this->DescrPais->ViewCustomAttributes = "";

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

		// PaginaWebCli
		$this->PaginaWebCli->ViewValue = $this->PaginaWebCli->CurrentValue;
		$this->PaginaWebCli->CssStyle = "";
		$this->PaginaWebCli->CssClass = "";
		$this->PaginaWebCli->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$this->RazonSocialCli->HrefValue = "";

		// CuitCli
		$this->CuitCli->HrefValue = "";

		// IngBrutosCli
		$this->IngBrutosCli->HrefValue = "";

		// Regis_IvaC
		$this->Regis_IvaC->HrefValue = "";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->HrefValue = "";

		// emailCli
		$this->emailCli->HrefValue = "";

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

		// CodigoPostalCli
		$this->CodigoPostalCli->HrefValue = "";

		// DescrPais
		$this->DescrPais->HrefValue = "";

		// Telefono
		$this->Telefono->HrefValue = "";

		// FaxCli
		$this->FaxCli->HrefValue = "";

		// PaginaWebCli
		$this->PaginaWebCli->HrefValue = "";
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
