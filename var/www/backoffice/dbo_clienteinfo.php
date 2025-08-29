<?php

// Global variable for table object
$dbo_cliente = NULL;

//
// Table class for dbo_cliente
//
class cdbo_cliente extends cTable {
	var $CodigoCli;
	var $RazonSocialCli;
	var $pedidosPendientes;
	var $vencimientosPendientes;
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

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'dbo_cliente';
		$this->TableName = 'dbo_cliente';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`dbo_cliente`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);
		$this->BasicSearch->TypeDefault = "AND";

		// CodigoCli
		$this->CodigoCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CodigoCli', 'CodigoCli', '`CodigoCli`', '`CodigoCli`', 200, -1, FALSE, '`CodigoCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CodigoCli->Sortable = TRUE; // Allow sort
		$this->fields['CodigoCli'] = &$this->CodigoCli;

		// RazonSocialCli
		$this->RazonSocialCli = new cField('dbo_cliente', 'dbo_cliente', 'x_RazonSocialCli', 'RazonSocialCli', '`RazonSocialCli`', '`RazonSocialCli`', 200, -1, FALSE, '`RazonSocialCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RazonSocialCli->Sortable = TRUE; // Allow sort
		$this->fields['RazonSocialCli'] = &$this->RazonSocialCli;

		// pedidosPendientes
		$this->pedidosPendientes = new cField('dbo_cliente', 'dbo_cliente', 'x_pedidosPendientes', 'pedidosPendientes', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pedidosPendientes->FldIsCustom = TRUE; // Custom field
		$this->pedidosPendientes->Sortable = FALSE; // Allow sort
		$this->fields['pedidosPendientes'] = &$this->pedidosPendientes;

		// vencimientosPendientes
		$this->vencimientosPendientes = new cField('dbo_cliente', 'dbo_cliente', 'x_vencimientosPendientes', 'vencimientosPendientes', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->vencimientosPendientes->FldIsCustom = TRUE; // Custom field
		$this->vencimientosPendientes->Sortable = FALSE; // Allow sort
		$this->fields['vencimientosPendientes'] = &$this->vencimientosPendientes;

		// CuitCli
		$this->CuitCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CuitCli', 'CuitCli', '`CuitCli`', '`CuitCli`', 200, -1, FALSE, '`CuitCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CuitCli->Sortable = TRUE; // Allow sort
		$this->fields['CuitCli'] = &$this->CuitCli;

		// IngBrutosCli
		$this->IngBrutosCli = new cField('dbo_cliente', 'dbo_cliente', 'x_IngBrutosCli', 'IngBrutosCli', '`IngBrutosCli`', '`IngBrutosCli`', 200, -1, FALSE, '`IngBrutosCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IngBrutosCli->Sortable = TRUE; // Allow sort
		$this->fields['IngBrutosCli'] = &$this->IngBrutosCli;

		// Regis_IvaC
		$this->Regis_IvaC = new cField('dbo_cliente', 'dbo_cliente', 'x_Regis_IvaC', 'Regis_IvaC', '`Regis_IvaC`', '`Regis_IvaC`', 3, -1, FALSE, '`Regis_IvaC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Regis_IvaC->Sortable = TRUE; // Allow sort
		$this->Regis_IvaC->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Regis_IvaC'] = &$this->Regis_IvaC;

		// Regis_ListaPrec
		$this->Regis_ListaPrec = new cField('dbo_cliente', 'dbo_cliente', 'x_Regis_ListaPrec', 'Regis_ListaPrec', '`Regis_ListaPrec`', '`Regis_ListaPrec`', 3, -1, FALSE, '`Regis_ListaPrec`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Regis_ListaPrec->Sortable = TRUE; // Allow sort
		$this->Regis_ListaPrec->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Regis_ListaPrec'] = &$this->Regis_ListaPrec;

		// emailCli
		$this->emailCli = new cField('dbo_cliente', 'dbo_cliente', 'x_emailCli', 'emailCli', '`emailCli`', '`emailCli`', 200, -1, FALSE, '`emailCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->emailCli->Sortable = TRUE; // Allow sort
		$this->fields['emailCli'] = &$this->emailCli;

		// RazonSocialFlete
		$this->RazonSocialFlete = new cField('dbo_cliente', 'dbo_cliente', 'x_RazonSocialFlete', 'RazonSocialFlete', '`RazonSocialFlete`', '`RazonSocialFlete`', 200, -1, FALSE, '`RazonSocialFlete`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RazonSocialFlete->Sortable = TRUE; // Allow sort
		$this->fields['RazonSocialFlete'] = &$this->RazonSocialFlete;

		// Direccion
		$this->Direccion = new cField('dbo_cliente', 'dbo_cliente', 'x_Direccion', 'Direccion', '`Direccion`', '`Direccion`', 200, -1, FALSE, '`Direccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Direccion->Sortable = TRUE; // Allow sort
		$this->fields['Direccion'] = &$this->Direccion;

		// BarrioCli
		$this->BarrioCli = new cField('dbo_cliente', 'dbo_cliente', 'x_BarrioCli', 'BarrioCli', '`BarrioCli`', '`BarrioCli`', 200, -1, FALSE, '`BarrioCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BarrioCli->Sortable = TRUE; // Allow sort
		$this->fields['BarrioCli'] = &$this->BarrioCli;

		// LocalidadCli
		$this->LocalidadCli = new cField('dbo_cliente', 'dbo_cliente', 'x_LocalidadCli', 'LocalidadCli', '`LocalidadCli`', '`LocalidadCli`', 200, -1, FALSE, '`LocalidadCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LocalidadCli->Sortable = TRUE; // Allow sort
		$this->fields['LocalidadCli'] = &$this->LocalidadCli;

		// DescrProvincia
		$this->DescrProvincia = new cField('dbo_cliente', 'dbo_cliente', 'x_DescrProvincia', 'DescrProvincia', '`DescrProvincia`', '`DescrProvincia`', 200, -1, FALSE, '`DescrProvincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescrProvincia->Sortable = TRUE; // Allow sort
		$this->fields['DescrProvincia'] = &$this->DescrProvincia;

		// CodigoPostalCli
		$this->CodigoPostalCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CodigoPostalCli', 'CodigoPostalCli', '`CodigoPostalCli`', '`CodigoPostalCli`', 200, -1, FALSE, '`CodigoPostalCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CodigoPostalCli->Sortable = TRUE; // Allow sort
		$this->fields['CodigoPostalCli'] = &$this->CodigoPostalCli;

		// DescrPais
		$this->DescrPais = new cField('dbo_cliente', 'dbo_cliente', 'x_DescrPais', 'DescrPais', '`DescrPais`', '`DescrPais`', 200, -1, FALSE, '`DescrPais`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescrPais->Sortable = TRUE; // Allow sort
		$this->fields['DescrPais'] = &$this->DescrPais;

		// Telefono
		$this->Telefono = new cField('dbo_cliente', 'dbo_cliente', 'x_Telefono', 'Telefono', '`Telefono`', '`Telefono`', 200, -1, FALSE, '`Telefono`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Telefono->Sortable = TRUE; // Allow sort
		$this->fields['Telefono'] = &$this->Telefono;

		// FaxCli
		$this->FaxCli = new cField('dbo_cliente', 'dbo_cliente', 'x_FaxCli', 'FaxCli', '`FaxCli`', '`FaxCli`', 200, -1, FALSE, '`FaxCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FaxCli->Sortable = TRUE; // Allow sort
		$this->fields['FaxCli'] = &$this->FaxCli;

		// PaginaWebCli
		$this->PaginaWebCli = new cField('dbo_cliente', 'dbo_cliente', 'x_PaginaWebCli', 'PaginaWebCli', '`PaginaWebCli`', '`PaginaWebCli`', 200, -1, FALSE, '`PaginaWebCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PaginaWebCli->Sortable = TRUE; // Allow sort
		$this->fields['PaginaWebCli'] = &$this->PaginaWebCli;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "trama_mensajes2Dclientes") {
			$sDetailUrl = $GLOBALS["trama_mensajes2Dclientes"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_CodigoCli=" . urlencode($this->CodigoCli->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "dbo_clientelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`dbo_cliente`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, '' AS `pedidosPendientes`, '' AS `vencimientosPendientes` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('CodigoCli', $rs))
				ew_AddFilter($where, ew_QuotedName('CodigoCli', $this->DBID) . '=' . ew_QuotedValue($rs['CodigoCli'], $this->CodigoCli->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`CodigoCli` = '@CodigoCli@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@CodigoCli@", ew_AdjustSql($this->CodigoCli->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "dbo_clientelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "dbo_clientelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dbo_clienteview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dbo_clienteview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "dbo_clienteadd.php?" . $this->UrlParm($parm);
		else
			$url = "dbo_clienteadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dbo_clienteedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dbo_clienteedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dbo_clienteadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dbo_clienteadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("dbo_clientedelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "CodigoCli:" . ew_VarToJson($this->CodigoCli->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->CodigoCli->CurrentValue)) {
			$sUrl .= "CodigoCli=" . urlencode($this->CodigoCli->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["CodigoCli"]))
				$arKeys[] = ew_StripSlashes($_POST["CodigoCli"]);
			elseif (isset($_GET["CodigoCli"]))
				$arKeys[] = ew_StripSlashes($_GET["CodigoCli"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->CodigoCli->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
		$this->pedidosPendientes->setDbValue($rs->fields('pedidosPendientes'));
		$this->vencimientosPendientes->setDbValue($rs->fields('vencimientosPendientes'));
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
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CodigoCli

		$this->CodigoCli->CellCssStyle = "white-space: nowrap;";

		// RazonSocialCli
		$this->RazonSocialCli->CellCssStyle = "white-space: nowrap;";

		// pedidosPendientes
		$this->pedidosPendientes->CellCssStyle = "white-space: nowrap;";

		// vencimientosPendientes
		$this->vencimientosPendientes->CellCssStyle = "white-space: nowrap;";

		// CuitCli
		$this->CuitCli->CellCssStyle = "white-space: nowrap;";

		// IngBrutosCli
		$this->IngBrutosCli->CellCssStyle = "white-space: nowrap;";

		// Regis_IvaC
		$this->Regis_IvaC->CellCssStyle = "white-space: nowrap;";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->CellCssStyle = "white-space: nowrap;";

		// emailCli
		$this->emailCli->CellCssStyle = "white-space: nowrap;";

		// RazonSocialFlete
		$this->RazonSocialFlete->CellCssStyle = "white-space: nowrap;";

		// Direccion
		$this->Direccion->CellCssStyle = "white-space: nowrap;";

		// BarrioCli
		$this->BarrioCli->CellCssStyle = "white-space: nowrap;";

		// LocalidadCli
		$this->LocalidadCli->CellCssStyle = "white-space: nowrap;";

		// DescrProvincia
		$this->DescrProvincia->CellCssStyle = "white-space: nowrap;";

		// CodigoPostalCli
		$this->CodigoPostalCli->CellCssStyle = "white-space: nowrap;";

		// DescrPais
		$this->DescrPais->CellCssStyle = "white-space: nowrap;";

		// Telefono
		$this->Telefono->CellCssStyle = "white-space: nowrap;";

		// FaxCli
		$this->FaxCli->CellCssStyle = "white-space: nowrap;";

		// PaginaWebCli
		$this->PaginaWebCli->CellCssStyle = "white-space: nowrap;";

		// CodigoCli
		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
		$this->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$this->RazonSocialCli->ViewValue = $this->RazonSocialCli->CurrentValue;
		$this->RazonSocialCli->ViewCustomAttributes = "";

		// pedidosPendientes
		$this->pedidosPendientes->ViewValue = $this->pedidosPendientes->CurrentValue;
		$this->pedidosPendientes->ViewCustomAttributes = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->ViewValue = $this->vencimientosPendientes->CurrentValue;
		$this->vencimientosPendientes->ViewCustomAttributes = "";

		// CuitCli
		$this->CuitCli->ViewValue = $this->CuitCli->CurrentValue;
		$this->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$this->IngBrutosCli->ViewValue = $this->IngBrutosCli->CurrentValue;
		$this->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
		if (strval($this->Regis_IvaC->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_IvaC`" . ew_SearchString("=", $this->Regis_IvaC->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_IvaC`, `DescrIvaC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_ivacondicion`";
		$sWhereWrk = "";
		$this->Regis_IvaC->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_IvaC, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
			}
		} else {
			$this->Regis_IvaC->ViewValue = NULL;
		}
		$this->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
		if (strval($this->Regis_ListaPrec->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_ListaPrec`" . ew_SearchString("=", $this->Regis_ListaPrec->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_ListaPrec`, `DescrListaPrec` AS `DispFld`, `Regis_ListaPrec` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_listaprecios`";
		$sWhereWrk = "";
		$this->Regis_ListaPrec->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_ListaPrec, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$this->Regis_ListaPrec->ViewValue = NULL;
		}
		$this->Regis_ListaPrec->ViewCustomAttributes = "";

		// emailCli
		$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
		$this->emailCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$this->RazonSocialFlete->ViewValue = $this->RazonSocialFlete->CurrentValue;
		$this->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$this->Direccion->ViewValue = $this->Direccion->CurrentValue;
		$this->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$this->BarrioCli->ViewValue = $this->BarrioCli->CurrentValue;
		$this->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$this->LocalidadCli->ViewValue = $this->LocalidadCli->CurrentValue;
		$this->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$this->DescrProvincia->ViewValue = $this->DescrProvincia->CurrentValue;
		$this->DescrProvincia->ViewCustomAttributes = "";

		// CodigoPostalCli
		$this->CodigoPostalCli->ViewValue = $this->CodigoPostalCli->CurrentValue;
		$this->CodigoPostalCli->ViewCustomAttributes = "";

		// DescrPais
		$this->DescrPais->ViewValue = $this->DescrPais->CurrentValue;
		$this->DescrPais->ViewCustomAttributes = "";

		// Telefono
		$this->Telefono->ViewValue = $this->Telefono->CurrentValue;
		$this->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$this->FaxCli->ViewValue = $this->FaxCli->CurrentValue;
		$this->FaxCli->ViewCustomAttributes = "";

		// PaginaWebCli
		$this->PaginaWebCli->ViewValue = $this->PaginaWebCli->CurrentValue;
		$this->PaginaWebCli->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->LinkCustomAttributes = "";
		$this->CodigoCli->HrefValue = "";
		$this->CodigoCli->TooltipValue = "";

		// RazonSocialCli
		$this->RazonSocialCli->LinkCustomAttributes = "";
		$this->RazonSocialCli->HrefValue = "";
		$this->RazonSocialCli->TooltipValue = "";

		// pedidosPendientes
		$this->pedidosPendientes->LinkCustomAttributes = "";
		$this->pedidosPendientes->HrefValue = "";
		$this->pedidosPendientes->TooltipValue = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->LinkCustomAttributes = "";
		$this->vencimientosPendientes->HrefValue = "";
		$this->vencimientosPendientes->TooltipValue = "";

		// CuitCli
		$this->CuitCli->LinkCustomAttributes = "";
		$this->CuitCli->HrefValue = "";
		$this->CuitCli->TooltipValue = "";

		// IngBrutosCli
		$this->IngBrutosCli->LinkCustomAttributes = "";
		$this->IngBrutosCli->HrefValue = "";
		$this->IngBrutosCli->TooltipValue = "";

		// Regis_IvaC
		$this->Regis_IvaC->LinkCustomAttributes = "";
		$this->Regis_IvaC->HrefValue = "";
		$this->Regis_IvaC->TooltipValue = "";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->LinkCustomAttributes = "";
		$this->Regis_ListaPrec->HrefValue = "";
		$this->Regis_ListaPrec->TooltipValue = "";

		// emailCli
		$this->emailCli->LinkCustomAttributes = "";
		$this->emailCli->HrefValue = "";
		$this->emailCli->TooltipValue = "";

		// RazonSocialFlete
		$this->RazonSocialFlete->LinkCustomAttributes = "";
		$this->RazonSocialFlete->HrefValue = "";
		$this->RazonSocialFlete->TooltipValue = "";

		// Direccion
		$this->Direccion->LinkCustomAttributes = "";
		$this->Direccion->HrefValue = "";
		$this->Direccion->TooltipValue = "";

		// BarrioCli
		$this->BarrioCli->LinkCustomAttributes = "";
		$this->BarrioCli->HrefValue = "";
		$this->BarrioCli->TooltipValue = "";

		// LocalidadCli
		$this->LocalidadCli->LinkCustomAttributes = "";
		$this->LocalidadCli->HrefValue = "";
		$this->LocalidadCli->TooltipValue = "";

		// DescrProvincia
		$this->DescrProvincia->LinkCustomAttributes = "";
		$this->DescrProvincia->HrefValue = "";
		$this->DescrProvincia->TooltipValue = "";

		// CodigoPostalCli
		$this->CodigoPostalCli->LinkCustomAttributes = "";
		$this->CodigoPostalCli->HrefValue = "";
		$this->CodigoPostalCli->TooltipValue = "";

		// DescrPais
		$this->DescrPais->LinkCustomAttributes = "";
		$this->DescrPais->HrefValue = "";
		$this->DescrPais->TooltipValue = "";

		// Telefono
		$this->Telefono->LinkCustomAttributes = "";
		$this->Telefono->HrefValue = "";
		$this->Telefono->TooltipValue = "";

		// FaxCli
		$this->FaxCli->LinkCustomAttributes = "";
		$this->FaxCli->HrefValue = "";
		$this->FaxCli->TooltipValue = "";

		// PaginaWebCli
		$this->PaginaWebCli->LinkCustomAttributes = "";
		$this->PaginaWebCli->HrefValue = "";
		$this->PaginaWebCli->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// CodigoCli
		$this->CodigoCli->EditAttrs["class"] = "form-control";
		$this->CodigoCli->EditCustomAttributes = "";
		$this->CodigoCli->EditValue = $this->CodigoCli->CurrentValue;
		$this->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$this->RazonSocialCli->EditAttrs["class"] = "form-control";
		$this->RazonSocialCli->EditCustomAttributes = "";
		$this->RazonSocialCli->EditValue = $this->RazonSocialCli->CurrentValue;
		$this->RazonSocialCli->PlaceHolder = ew_RemoveHtml($this->RazonSocialCli->FldCaption());

		// pedidosPendientes
		$this->pedidosPendientes->EditAttrs["class"] = "form-control";
		$this->pedidosPendientes->EditCustomAttributes = "";
		$this->pedidosPendientes->EditValue = $this->pedidosPendientes->CurrentValue;
		$this->pedidosPendientes->ViewCustomAttributes = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->EditAttrs["class"] = "form-control";
		$this->vencimientosPendientes->EditCustomAttributes = "";
		$this->vencimientosPendientes->EditValue = $this->vencimientosPendientes->CurrentValue;
		$this->vencimientosPendientes->ViewCustomAttributes = "";

		// CuitCli
		$this->CuitCli->EditAttrs["class"] = "form-control";
		$this->CuitCli->EditCustomAttributes = "";
		$this->CuitCli->EditValue = $this->CuitCli->CurrentValue;
		$this->CuitCli->PlaceHolder = ew_RemoveHtml($this->CuitCli->FldCaption());

		// IngBrutosCli
		$this->IngBrutosCli->EditAttrs["class"] = "form-control";
		$this->IngBrutosCli->EditCustomAttributes = "";
		$this->IngBrutosCli->EditValue = $this->IngBrutosCli->CurrentValue;
		$this->IngBrutosCli->PlaceHolder = ew_RemoveHtml($this->IngBrutosCli->FldCaption());

		// Regis_IvaC
		$this->Regis_IvaC->EditAttrs["class"] = "form-control";
		$this->Regis_IvaC->EditCustomAttributes = "";
		$this->Regis_IvaC->EditValue = $this->Regis_IvaC->CurrentValue;
		$this->Regis_IvaC->PlaceHolder = ew_RemoveHtml($this->Regis_IvaC->FldCaption());

		// Regis_ListaPrec
		$this->Regis_ListaPrec->EditAttrs["class"] = "form-control";
		$this->Regis_ListaPrec->EditCustomAttributes = "";
		$this->Regis_ListaPrec->EditValue = $this->Regis_ListaPrec->CurrentValue;
		$this->Regis_ListaPrec->PlaceHolder = ew_RemoveHtml($this->Regis_ListaPrec->FldCaption());

		// emailCli
		$this->emailCli->EditAttrs["class"] = "form-control";
		$this->emailCli->EditCustomAttributes = "";
		$this->emailCli->EditValue = $this->emailCli->CurrentValue;
		$this->emailCli->PlaceHolder = ew_RemoveHtml($this->emailCli->FldCaption());

		// RazonSocialFlete
		$this->RazonSocialFlete->EditAttrs["class"] = "form-control";
		$this->RazonSocialFlete->EditCustomAttributes = "";
		$this->RazonSocialFlete->EditValue = $this->RazonSocialFlete->CurrentValue;
		$this->RazonSocialFlete->PlaceHolder = ew_RemoveHtml($this->RazonSocialFlete->FldCaption());

		// Direccion
		$this->Direccion->EditAttrs["class"] = "form-control";
		$this->Direccion->EditCustomAttributes = "";
		$this->Direccion->EditValue = $this->Direccion->CurrentValue;
		$this->Direccion->PlaceHolder = ew_RemoveHtml($this->Direccion->FldCaption());

		// BarrioCli
		$this->BarrioCli->EditAttrs["class"] = "form-control";
		$this->BarrioCli->EditCustomAttributes = "";
		$this->BarrioCli->EditValue = $this->BarrioCli->CurrentValue;
		$this->BarrioCli->PlaceHolder = ew_RemoveHtml($this->BarrioCli->FldCaption());

		// LocalidadCli
		$this->LocalidadCli->EditAttrs["class"] = "form-control";
		$this->LocalidadCli->EditCustomAttributes = "";
		$this->LocalidadCli->EditValue = $this->LocalidadCli->CurrentValue;
		$this->LocalidadCli->PlaceHolder = ew_RemoveHtml($this->LocalidadCli->FldCaption());

		// DescrProvincia
		$this->DescrProvincia->EditAttrs["class"] = "form-control";
		$this->DescrProvincia->EditCustomAttributes = "";
		$this->DescrProvincia->EditValue = $this->DescrProvincia->CurrentValue;
		$this->DescrProvincia->PlaceHolder = ew_RemoveHtml($this->DescrProvincia->FldCaption());

		// CodigoPostalCli
		$this->CodigoPostalCli->EditAttrs["class"] = "form-control";
		$this->CodigoPostalCli->EditCustomAttributes = "";
		$this->CodigoPostalCli->EditValue = $this->CodigoPostalCli->CurrentValue;
		$this->CodigoPostalCli->PlaceHolder = ew_RemoveHtml($this->CodigoPostalCli->FldCaption());

		// DescrPais
		$this->DescrPais->EditAttrs["class"] = "form-control";
		$this->DescrPais->EditCustomAttributes = "";
		$this->DescrPais->EditValue = $this->DescrPais->CurrentValue;
		$this->DescrPais->PlaceHolder = ew_RemoveHtml($this->DescrPais->FldCaption());

		// Telefono
		$this->Telefono->EditAttrs["class"] = "form-control";
		$this->Telefono->EditCustomAttributes = "";
		$this->Telefono->EditValue = $this->Telefono->CurrentValue;
		$this->Telefono->PlaceHolder = ew_RemoveHtml($this->Telefono->FldCaption());

		// FaxCli
		$this->FaxCli->EditAttrs["class"] = "form-control";
		$this->FaxCli->EditCustomAttributes = "";
		$this->FaxCli->EditValue = $this->FaxCli->CurrentValue;
		$this->FaxCli->PlaceHolder = ew_RemoveHtml($this->FaxCli->FldCaption());

		// PaginaWebCli
		$this->PaginaWebCli->EditAttrs["class"] = "form-control";
		$this->PaginaWebCli->EditCustomAttributes = "";
		$this->PaginaWebCli->EditValue = $this->PaginaWebCli->CurrentValue;
		$this->PaginaWebCli->PlaceHolder = ew_RemoveHtml($this->PaginaWebCli->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->CodigoCli->Exportable) $Doc->ExportCaption($this->CodigoCli);
					if ($this->RazonSocialCli->Exportable) $Doc->ExportCaption($this->RazonSocialCli);
					if ($this->pedidosPendientes->Exportable) $Doc->ExportCaption($this->pedidosPendientes);
					if ($this->vencimientosPendientes->Exportable) $Doc->ExportCaption($this->vencimientosPendientes);
					if ($this->CuitCli->Exportable) $Doc->ExportCaption($this->CuitCli);
					if ($this->IngBrutosCli->Exportable) $Doc->ExportCaption($this->IngBrutosCli);
					if ($this->Regis_IvaC->Exportable) $Doc->ExportCaption($this->Regis_IvaC);
					if ($this->Regis_ListaPrec->Exportable) $Doc->ExportCaption($this->Regis_ListaPrec);
					if ($this->emailCli->Exportable) $Doc->ExportCaption($this->emailCli);
					if ($this->RazonSocialFlete->Exportable) $Doc->ExportCaption($this->RazonSocialFlete);
					if ($this->Direccion->Exportable) $Doc->ExportCaption($this->Direccion);
					if ($this->BarrioCli->Exportable) $Doc->ExportCaption($this->BarrioCli);
					if ($this->LocalidadCli->Exportable) $Doc->ExportCaption($this->LocalidadCli);
					if ($this->DescrProvincia->Exportable) $Doc->ExportCaption($this->DescrProvincia);
					if ($this->CodigoPostalCli->Exportable) $Doc->ExportCaption($this->CodigoPostalCli);
					if ($this->DescrPais->Exportable) $Doc->ExportCaption($this->DescrPais);
					if ($this->Telefono->Exportable) $Doc->ExportCaption($this->Telefono);
					if ($this->FaxCli->Exportable) $Doc->ExportCaption($this->FaxCli);
					if ($this->PaginaWebCli->Exportable) $Doc->ExportCaption($this->PaginaWebCli);
				} else {
					if ($this->CodigoCli->Exportable) $Doc->ExportCaption($this->CodigoCli);
					if ($this->RazonSocialCli->Exportable) $Doc->ExportCaption($this->RazonSocialCli);
					if ($this->CuitCli->Exportable) $Doc->ExportCaption($this->CuitCli);
					if ($this->IngBrutosCli->Exportable) $Doc->ExportCaption($this->IngBrutosCli);
					if ($this->Regis_IvaC->Exportable) $Doc->ExportCaption($this->Regis_IvaC);
					if ($this->Regis_ListaPrec->Exportable) $Doc->ExportCaption($this->Regis_ListaPrec);
					if ($this->emailCli->Exportable) $Doc->ExportCaption($this->emailCli);
					if ($this->RazonSocialFlete->Exportable) $Doc->ExportCaption($this->RazonSocialFlete);
					if ($this->Direccion->Exportable) $Doc->ExportCaption($this->Direccion);
					if ($this->BarrioCli->Exportable) $Doc->ExportCaption($this->BarrioCli);
					if ($this->LocalidadCli->Exportable) $Doc->ExportCaption($this->LocalidadCli);
					if ($this->DescrProvincia->Exportable) $Doc->ExportCaption($this->DescrProvincia);
					if ($this->CodigoPostalCli->Exportable) $Doc->ExportCaption($this->CodigoPostalCli);
					if ($this->DescrPais->Exportable) $Doc->ExportCaption($this->DescrPais);
					if ($this->Telefono->Exportable) $Doc->ExportCaption($this->Telefono);
					if ($this->FaxCli->Exportable) $Doc->ExportCaption($this->FaxCli);
					if ($this->PaginaWebCli->Exportable) $Doc->ExportCaption($this->PaginaWebCli);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->CodigoCli->Exportable) $Doc->ExportField($this->CodigoCli);
						if ($this->RazonSocialCli->Exportable) $Doc->ExportField($this->RazonSocialCli);
						if ($this->pedidosPendientes->Exportable) $Doc->ExportField($this->pedidosPendientes);
						if ($this->vencimientosPendientes->Exportable) $Doc->ExportField($this->vencimientosPendientes);
						if ($this->CuitCli->Exportable) $Doc->ExportField($this->CuitCli);
						if ($this->IngBrutosCli->Exportable) $Doc->ExportField($this->IngBrutosCli);
						if ($this->Regis_IvaC->Exportable) $Doc->ExportField($this->Regis_IvaC);
						if ($this->Regis_ListaPrec->Exportable) $Doc->ExportField($this->Regis_ListaPrec);
						if ($this->emailCli->Exportable) $Doc->ExportField($this->emailCli);
						if ($this->RazonSocialFlete->Exportable) $Doc->ExportField($this->RazonSocialFlete);
						if ($this->Direccion->Exportable) $Doc->ExportField($this->Direccion);
						if ($this->BarrioCli->Exportable) $Doc->ExportField($this->BarrioCli);
						if ($this->LocalidadCli->Exportable) $Doc->ExportField($this->LocalidadCli);
						if ($this->DescrProvincia->Exportable) $Doc->ExportField($this->DescrProvincia);
						if ($this->CodigoPostalCli->Exportable) $Doc->ExportField($this->CodigoPostalCli);
						if ($this->DescrPais->Exportable) $Doc->ExportField($this->DescrPais);
						if ($this->Telefono->Exportable) $Doc->ExportField($this->Telefono);
						if ($this->FaxCli->Exportable) $Doc->ExportField($this->FaxCli);
						if ($this->PaginaWebCli->Exportable) $Doc->ExportField($this->PaginaWebCli);
					} else {
						if ($this->CodigoCli->Exportable) $Doc->ExportField($this->CodigoCli);
						if ($this->RazonSocialCli->Exportable) $Doc->ExportField($this->RazonSocialCli);
						if ($this->CuitCli->Exportable) $Doc->ExportField($this->CuitCli);
						if ($this->IngBrutosCli->Exportable) $Doc->ExportField($this->IngBrutosCli);
						if ($this->Regis_IvaC->Exportable) $Doc->ExportField($this->Regis_IvaC);
						if ($this->Regis_ListaPrec->Exportable) $Doc->ExportField($this->Regis_ListaPrec);
						if ($this->emailCli->Exportable) $Doc->ExportField($this->emailCli);
						if ($this->RazonSocialFlete->Exportable) $Doc->ExportField($this->RazonSocialFlete);
						if ($this->Direccion->Exportable) $Doc->ExportField($this->Direccion);
						if ($this->BarrioCli->Exportable) $Doc->ExportField($this->BarrioCli);
						if ($this->LocalidadCli->Exportable) $Doc->ExportField($this->LocalidadCli);
						if ($this->DescrProvincia->Exportable) $Doc->ExportField($this->DescrProvincia);
						if ($this->CodigoPostalCli->Exportable) $Doc->ExportField($this->CodigoPostalCli);
						if ($this->DescrPais->Exportable) $Doc->ExportField($this->DescrPais);
						if ($this->Telefono->Exportable) $Doc->ExportField($this->Telefono);
						if ($this->FaxCli->Exportable) $Doc->ExportField($this->FaxCli);
						if ($this->PaginaWebCli->Exportable) $Doc->ExportField($this->PaginaWebCli);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
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

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {
		$this->RazonSocialCli->ViewValue = '<a href="vencimientos.php?CodigoCliente=' . $this->CodigoCli->ViewValue . '" data-caption="Vencimientos" data-original-title="Vencimientos" class="ewTooltip">' . ucWords(mb_strtolower($this->RazonSocialCli->ViewValue,'UTF-8') . "</a>");
		$this->emailCli->ViewValue = mb_strtolower($this->emailCli->ViewValue,'UTF-8');
		$this->RazonSocialFlete->ViewValue = ucWords(mb_strtolower($this->RazonSocialFlete->ViewValue,'UTF-8'));
		$this->Direccion->ViewValue = ucWords(mb_strtolower($this->Direccion->ViewValue,'UTF-8'));
		$this->BarrioCli->ViewValue = ucWords(mb_strtolower($this->BarrioCli->ViewValue,'UTF-8'));
		$this->LocalidadCli->ViewValue = ucWords(mb_strtolower($this->LocalidadCli->ViewValue,'UTF-8'));
		$this->DescrProvincia->ViewValue = ucWords(mb_strtolower($this->DescrProvincia->ViewValue,'UTF-8'));
		$this->DescrPais->ViewValue = ucWords(mb_strtolower($this->DescrPais->ViewValue,'UTF-8'));
		$this->PaginaWebCli->ViewValue = mb_strtolower($this->PaginaWebCli->ViewValue,'UTF-8');
		$this->pedidosPendientes->ViewValue = 0;	
		$rs = ew_Execute("SELECT COUNT(estado) AS c FROM walger_pedidos WHERE estado IN ('N', 'X') AND CodigoCli = '" . $this->CodigoCli->ViewValue . "' GROUP BY estado");
		if ($rs && $rs->RecordCount() > 0) {
			$rs->MoveFirst();
			$this->pedidosPendientes->ViewValue = $rs->fields("c") . ' <a href="walger_pedidoslist.php?x_CodigoCli=' . $this->CodigoCli->ViewValue . '&z_CodigoCli=%3D&x_estado=N&z_estado=%3D&v_estado=OR&y_estado=X&w_estado=%3D&cmd=search&psearchtype=" class="ewTooltip" data-caption="Pedidos" data-original-title="Pedidos">(ver)</a>';
			$rs->Close();
		}
		$this->vencimientosPendientes->ViewValue = 0;	
		$rs = ew_Execute("SELECT COUNT(Regis_CliTra) AS c FROM dbo_clientevtotransa WHERE CodigoCli = '" . $this->CodigoCli->ViewValue . "'");
		if ($rs && $rs->RecordCount() > 0) {
			$rs->MoveFirst();
			if ($rs->fields("c") > 0)
			{
					$this->vencimientosPendientes->ViewValue = $rs->fields("c") . ' <a href="vencimientos.php?CodigoCliente=' . $this->CodigoCli->ViewValue . '" class="ewTooltip" data-caption="Vencimientos" data-original-title="Vencimientos">(ver)</a>';
			}
			$rs->Close();
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
