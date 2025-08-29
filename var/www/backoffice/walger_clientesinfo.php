<?php

// Global variable for table object
$walger_clientes = NULL;

//
// Table class for walger_clientes
//
class cwalger_clientes extends cTable {
	var $CodigoCli;
	var $pedidosPendientes;
	var $vencimientosPendientes;
	var $emailCli;
	var $Contrasenia;
	var $Habilitado;
	var $IP;
	var $UltimoLogin;
	var $TipoCliente;
	var $Regis_Mda;
	var $ApellidoNombre;
	var $Cargo;
	var $Comentarios;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'walger_clientes';
		$this->TableName = 'walger_clientes';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`walger_clientes`";
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
		$this->CodigoCli = new cField('walger_clientes', 'walger_clientes', 'x_CodigoCli', 'CodigoCli', '`CodigoCli`', '`CodigoCli`', 200, -1, FALSE, '`EV__CodigoCli`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->CodigoCli->Sortable = TRUE; // Allow sort
		$this->CodigoCli->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->CodigoCli->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['CodigoCli'] = &$this->CodigoCli;

		// pedidosPendientes
		$this->pedidosPendientes = new cField('walger_clientes', 'walger_clientes', 'x_pedidosPendientes', 'pedidosPendientes', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->pedidosPendientes->FldIsCustom = TRUE; // Custom field
		$this->pedidosPendientes->Sortable = FALSE; // Allow sort
		$this->fields['pedidosPendientes'] = &$this->pedidosPendientes;

		// vencimientosPendientes
		$this->vencimientosPendientes = new cField('walger_clientes', 'walger_clientes', 'x_vencimientosPendientes', 'vencimientosPendientes', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->vencimientosPendientes->FldIsCustom = TRUE; // Custom field
		$this->vencimientosPendientes->Sortable = FALSE; // Allow sort
		$this->fields['vencimientosPendientes'] = &$this->vencimientosPendientes;

		// emailCli
		$this->emailCli = new cField('walger_clientes', 'walger_clientes', 'x_emailCli', 'emailCli', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->emailCli->FldIsCustom = TRUE; // Custom field
		$this->emailCli->Sortable = FALSE; // Allow sort
		$this->fields['emailCli'] = &$this->emailCli;

		// Contrasenia
		$this->Contrasenia = new cField('walger_clientes', 'walger_clientes', 'x_Contrasenia', 'Contrasenia', '`Contrasenia`', '`Contrasenia`', 200, -1, FALSE, '`Contrasenia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Contrasenia->Sortable = TRUE; // Allow sort
		$this->fields['Contrasenia'] = &$this->Contrasenia;

		// Habilitado
		$this->Habilitado = new cField('walger_clientes', 'walger_clientes', 'x_Habilitado', 'Habilitado', '`Habilitado`', '`Habilitado`', 200, -1, FALSE, '`Habilitado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Habilitado->Sortable = TRUE; // Allow sort
		$this->Habilitado->OptionCount = 2;
		$this->fields['Habilitado'] = &$this->Habilitado;

		// IP
		$this->IP = new cField('walger_clientes', 'walger_clientes', 'x_IP', 'IP', '`IP`', '`IP`', 200, -1, FALSE, '`IP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IP->Sortable = TRUE; // Allow sort
		$this->fields['IP'] = &$this->IP;

		// UltimoLogin
		$this->UltimoLogin = new cField('walger_clientes', 'walger_clientes', 'x_UltimoLogin', 'UltimoLogin', '`UltimoLogin`', 'DATE_FORMAT(`UltimoLogin`, \'%Y/%m/%d\')', 135, 1, FALSE, '`UltimoLogin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->UltimoLogin->Sortable = TRUE; // Allow sort
		$this->UltimoLogin->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['UltimoLogin'] = &$this->UltimoLogin;

		// TipoCliente
		$this->TipoCliente = new cField('walger_clientes', 'walger_clientes', 'x_TipoCliente', 'TipoCliente', '`TipoCliente`', '`TipoCliente`', 200, -1, FALSE, '`TipoCliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->TipoCliente->Sortable = TRUE; // Allow sort
		$this->TipoCliente->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->TipoCliente->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->TipoCliente->OptionCount = 3;
		$this->fields['TipoCliente'] = &$this->TipoCliente;

		// Regis_Mda
		$this->Regis_Mda = new cField('walger_clientes', 'walger_clientes', 'x_Regis_Mda', 'Regis_Mda', '`Regis_Mda`', '`Regis_Mda`', 3, -1, FALSE, '`Regis_Mda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Regis_Mda->Sortable = TRUE; // Allow sort
		$this->Regis_Mda->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Regis_Mda->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Regis_Mda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Regis_Mda'] = &$this->Regis_Mda;

		// ApellidoNombre
		$this->ApellidoNombre = new cField('walger_clientes', 'walger_clientes', 'x_ApellidoNombre', 'ApellidoNombre', '`ApellidoNombre`', '`ApellidoNombre`', 200, -1, FALSE, '`ApellidoNombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ApellidoNombre->Sortable = TRUE; // Allow sort
		$this->fields['ApellidoNombre'] = &$this->ApellidoNombre;

		// Cargo
		$this->Cargo = new cField('walger_clientes', 'walger_clientes', 'x_Cargo', 'Cargo', '`Cargo`', '`Cargo`', 200, -1, FALSE, '`Cargo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Cargo->Sortable = TRUE; // Allow sort
		$this->fields['Cargo'] = &$this->Cargo;

		// Comentarios
		$this->Comentarios = new cField('walger_clientes', 'walger_clientes', 'x_Comentarios', 'Comentarios', '`Comentarios`', '`Comentarios`', 201, -1, FALSE, '`Comentarios`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Comentarios->Sortable = TRUE; // Allow sort
		$this->fields['Comentarios'] = &$this->Comentarios;
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`walger_clientes`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, '' AS `pedidosPendientes`, '' AS `vencimientosPendientes`, '' AS `emailCli` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, '' AS `pedidosPendientes`, '' AS `vencimientosPendientes`, '' AS `emailCli`, (SELECT CONCAT(`CodigoCli`,'" . ew_ValueSeparator(1, $this->CodigoCli) . "',`RazonSocialCli`,'" . ew_ValueSeparator(2, $this->CodigoCli) . "',`emailCli`) FROM `dbo_cliente` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`CodigoCli` = `walger_clientes`.`CodigoCli` LIMIT 1) AS `EV__CodigoCli` FROM `walger_clientes`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`UltimoLogin` DESC";
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
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->BasicSearch->getKeyword() <> "")
			return TRUE;
		if ($this->CodigoCli->AdvancedSearch->SearchValue <> "" ||
			$this->CodigoCli->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->CodigoCli->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->CodigoCli->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
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
			return "walger_clienteslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "walger_clienteslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("walger_clientesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("walger_clientesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "walger_clientesadd.php?" . $this->UrlParm($parm);
		else
			$url = "walger_clientesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("walger_clientesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("walger_clientesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("walger_clientesdelete.php", $this->UrlParm());
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
		$this->pedidosPendientes->setDbValue($rs->fields('pedidosPendientes'));
		$this->vencimientosPendientes->setDbValue($rs->fields('vencimientosPendientes'));
		$this->emailCli->setDbValue($rs->fields('emailCli'));
		$this->Contrasenia->setDbValue($rs->fields('Contrasenia'));
		$this->Habilitado->setDbValue($rs->fields('Habilitado'));
		$this->IP->setDbValue($rs->fields('IP'));
		$this->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
		$this->TipoCliente->setDbValue($rs->fields('TipoCliente'));
		$this->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
		$this->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
		$this->Cargo->setDbValue($rs->fields('Cargo'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CodigoCli

		$this->CodigoCli->CellCssStyle = "white-space: nowrap;";

		// pedidosPendientes
		$this->pedidosPendientes->CellCssStyle = "white-space: nowrap;";

		// vencimientosPendientes
		$this->vencimientosPendientes->CellCssStyle = "white-space: nowrap;";

		// emailCli
		$this->emailCli->CellCssStyle = "white-space: nowrap;";

		// Contrasenia
		$this->Contrasenia->CellCssStyle = "white-space: nowrap;";

		// Habilitado
		$this->Habilitado->CellCssStyle = "white-space: nowrap;";

		// IP
		$this->IP->CellCssStyle = "white-space: nowrap;";

		// UltimoLogin
		$this->UltimoLogin->CellCssStyle = "white-space: nowrap;";

		// TipoCliente
		$this->TipoCliente->CellCssStyle = "white-space: nowrap;";

		// Regis_Mda
		$this->Regis_Mda->CellCssStyle = "white-space: nowrap;";

		// ApellidoNombre
		$this->ApellidoNombre->CellCssStyle = "white-space: nowrap;";

		// Cargo
		$this->Cargo->CellCssStyle = "white-space: nowrap;";

		// Comentarios
		$this->Comentarios->CellCssStyle = "white-space: nowrap;";

		// CodigoCli
		if ($this->CodigoCli->VirtualValue <> "") {
			$this->CodigoCli->ViewValue = $this->CodigoCli->VirtualValue;
		} else {
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, `emailCli` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array("dx1" => "`CodigoCli`", "dx2" => "`RazonSocialCli`", "dx3" => "`emailCli`");
		$lookuptblfilter = " `CodigoCli` NOT IN ( SELECT `CodigoCli` FROM walger_clientes ) ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `CodigoCli`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->CodigoCli->ViewValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->ViewValue = NULL;
		}
		}
		$this->CodigoCli->ViewCustomAttributes = "";

		// pedidosPendientes
		$this->pedidosPendientes->ViewValue = $this->pedidosPendientes->CurrentValue;
		$this->pedidosPendientes->ViewCustomAttributes = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->ViewValue = $this->vencimientosPendientes->CurrentValue;
		$this->vencimientosPendientes->ViewCustomAttributes = "";

		// emailCli
		$this->emailCli->ViewValue = $this->emailCli->CurrentValue;
		$this->emailCli->ViewCustomAttributes = "";

		// Contrasenia
		$this->Contrasenia->ViewValue = $this->Contrasenia->CurrentValue;
		$this->Contrasenia->ViewCustomAttributes = "";

		// Habilitado
		if (strval($this->Habilitado->CurrentValue) <> "") {
			$this->Habilitado->ViewValue = $this->Habilitado->OptionCaption($this->Habilitado->CurrentValue);
		} else {
			$this->Habilitado->ViewValue = NULL;
		}
		$this->Habilitado->ViewCustomAttributes = "";

		// IP
		$this->IP->ViewValue = $this->IP->CurrentValue;
		$this->IP->ViewCustomAttributes = "";

		// UltimoLogin
		$this->UltimoLogin->ViewValue = $this->UltimoLogin->CurrentValue;
		$this->UltimoLogin->ViewValue = ew_FormatDateTime($this->UltimoLogin->ViewValue, 1);
		$this->UltimoLogin->ViewCustomAttributes = "";

		// TipoCliente
		if (strval($this->TipoCliente->CurrentValue) <> "") {
			$this->TipoCliente->ViewValue = $this->TipoCliente->OptionCaption($this->TipoCliente->CurrentValue);
		} else {
			$this->TipoCliente->ViewValue = NULL;
		}
		$this->TipoCliente->ViewCustomAttributes = "";

		// Regis_Mda
		if (strval($this->Regis_Mda->CurrentValue) <> "") {
			$sFilterWrk = "`Regis_Mda`" . ew_SearchString("=", $this->Regis_Mda->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Regis_Mda`, `Descr_Mda` AS `DispFld`, `Signo_Mda` AS `Disp2Fld`, `Cotiz_Mda` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_moneda`";
		$sWhereWrk = "";
		$this->Regis_Mda->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Regis_Mda, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descr_Mda`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = ew_FormatNumber($rswrk->fields('Disp3Fld'), 2, -1, 0, 0);
				$this->Regis_Mda->ViewValue = $this->Regis_Mda->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Regis_Mda->ViewValue = $this->Regis_Mda->CurrentValue;
			}
		} else {
			$this->Regis_Mda->ViewValue = NULL;
		}
		$this->Regis_Mda->ViewCustomAttributes = "";

		// ApellidoNombre
		$this->ApellidoNombre->ViewValue = $this->ApellidoNombre->CurrentValue;
		$this->ApellidoNombre->ViewCustomAttributes = "";

		// Cargo
		$this->Cargo->ViewValue = $this->Cargo->CurrentValue;
		$this->Cargo->ViewCustomAttributes = "";

		// Comentarios
		$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
		$this->Comentarios->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->LinkCustomAttributes = "";
		$this->CodigoCli->HrefValue = "";
		$this->CodigoCli->TooltipValue = "";

		// pedidosPendientes
		$this->pedidosPendientes->LinkCustomAttributes = "";
		$this->pedidosPendientes->HrefValue = "";
		$this->pedidosPendientes->TooltipValue = "";

		// vencimientosPendientes
		$this->vencimientosPendientes->LinkCustomAttributes = "";
		$this->vencimientosPendientes->HrefValue = "";
		$this->vencimientosPendientes->TooltipValue = "";

		// emailCli
		$this->emailCli->LinkCustomAttributes = "";
		$this->emailCli->HrefValue = "";
		$this->emailCli->TooltipValue = "";

		// Contrasenia
		$this->Contrasenia->LinkCustomAttributes = "";
		$this->Contrasenia->HrefValue = "";
		$this->Contrasenia->TooltipValue = "";

		// Habilitado
		$this->Habilitado->LinkCustomAttributes = "";
		$this->Habilitado->HrefValue = "";
		$this->Habilitado->TooltipValue = "";

		// IP
		$this->IP->LinkCustomAttributes = "";
		$this->IP->HrefValue = "";
		$this->IP->TooltipValue = "";

		// UltimoLogin
		$this->UltimoLogin->LinkCustomAttributes = "";
		$this->UltimoLogin->HrefValue = "";
		$this->UltimoLogin->TooltipValue = "";

		// TipoCliente
		$this->TipoCliente->LinkCustomAttributes = "";
		$this->TipoCliente->HrefValue = "";
		$this->TipoCliente->TooltipValue = "";

		// Regis_Mda
		$this->Regis_Mda->LinkCustomAttributes = "";
		$this->Regis_Mda->HrefValue = "";
		$this->Regis_Mda->TooltipValue = "";

		// ApellidoNombre
		$this->ApellidoNombre->LinkCustomAttributes = "";
		$this->ApellidoNombre->HrefValue = "";
		$this->ApellidoNombre->TooltipValue = "";

		// Cargo
		$this->Cargo->LinkCustomAttributes = "";
		$this->Cargo->HrefValue = "";
		$this->Cargo->TooltipValue = "";

		// Comentarios
		$this->Comentarios->LinkCustomAttributes = "";
		$this->Comentarios->HrefValue = "";
		$this->Comentarios->TooltipValue = "";

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
		if ($this->CodigoCli->VirtualValue <> "") {
			$this->CodigoCli->ViewValue = $this->CodigoCli->VirtualValue;
		} else {
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, `emailCli` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array("dx1" => "`CodigoCli`", "dx2" => "`RazonSocialCli`", "dx3" => "`emailCli`");
		$lookuptblfilter = " `CodigoCli` NOT IN ( SELECT `CodigoCli` FROM walger_clientes ) ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `CodigoCli`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->CodigoCli->EditValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->EditValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->EditValue = NULL;
		}
		}
		$this->CodigoCli->ViewCustomAttributes = "";

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

		// emailCli
		$this->emailCli->EditAttrs["class"] = "form-control";
		$this->emailCli->EditCustomAttributes = "";
		$this->emailCli->EditValue = $this->emailCli->CurrentValue;
		$this->emailCli->PlaceHolder = ew_RemoveHtml($this->emailCli->FldCaption());

		// Contrasenia
		$this->Contrasenia->EditAttrs["class"] = "form-control";
		$this->Contrasenia->EditCustomAttributes = "";
		$this->Contrasenia->EditValue = $this->Contrasenia->CurrentValue;
		$this->Contrasenia->PlaceHolder = ew_RemoveHtml($this->Contrasenia->FldCaption());

		// Habilitado
		$this->Habilitado->EditCustomAttributes = "";
		$this->Habilitado->EditValue = $this->Habilitado->Options(FALSE);

		// IP
		$this->IP->EditAttrs["class"] = "form-control";
		$this->IP->EditCustomAttributes = "";
		$this->IP->EditValue = $this->IP->CurrentValue;
		$this->IP->PlaceHolder = ew_RemoveHtml($this->IP->FldCaption());

		// UltimoLogin
		$this->UltimoLogin->EditAttrs["class"] = "form-control";
		$this->UltimoLogin->EditCustomAttributes = "";
		$this->UltimoLogin->EditValue = ew_FormatDateTime($this->UltimoLogin->CurrentValue, 8);
		$this->UltimoLogin->PlaceHolder = ew_RemoveHtml($this->UltimoLogin->FldCaption());

		// TipoCliente
		$this->TipoCliente->EditAttrs["class"] = "form-control";
		$this->TipoCliente->EditCustomAttributes = "";
		$this->TipoCliente->EditValue = $this->TipoCliente->Options(TRUE);

		// Regis_Mda
		$this->Regis_Mda->EditAttrs["class"] = "form-control";
		$this->Regis_Mda->EditCustomAttributes = "";

		// ApellidoNombre
		$this->ApellidoNombre->EditAttrs["class"] = "form-control";
		$this->ApellidoNombre->EditCustomAttributes = "";
		$this->ApellidoNombre->EditValue = $this->ApellidoNombre->CurrentValue;
		$this->ApellidoNombre->PlaceHolder = ew_RemoveHtml($this->ApellidoNombre->FldCaption());

		// Cargo
		$this->Cargo->EditAttrs["class"] = "form-control";
		$this->Cargo->EditCustomAttributes = "";
		$this->Cargo->EditValue = $this->Cargo->CurrentValue;
		$this->Cargo->PlaceHolder = ew_RemoveHtml($this->Cargo->FldCaption());

		// Comentarios
		$this->Comentarios->EditAttrs["class"] = "form-control";
		$this->Comentarios->EditCustomAttributes = "";
		$this->Comentarios->EditValue = $this->Comentarios->CurrentValue;
		$this->Comentarios->PlaceHolder = ew_RemoveHtml($this->Comentarios->FldCaption());

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
					if ($this->pedidosPendientes->Exportable) $Doc->ExportCaption($this->pedidosPendientes);
					if ($this->vencimientosPendientes->Exportable) $Doc->ExportCaption($this->vencimientosPendientes);
					if ($this->emailCli->Exportable) $Doc->ExportCaption($this->emailCli);
					if ($this->Contrasenia->Exportable) $Doc->ExportCaption($this->Contrasenia);
					if ($this->Habilitado->Exportable) $Doc->ExportCaption($this->Habilitado);
					if ($this->IP->Exportable) $Doc->ExportCaption($this->IP);
					if ($this->UltimoLogin->Exportable) $Doc->ExportCaption($this->UltimoLogin);
					if ($this->TipoCliente->Exportable) $Doc->ExportCaption($this->TipoCliente);
					if ($this->Regis_Mda->Exportable) $Doc->ExportCaption($this->Regis_Mda);
					if ($this->ApellidoNombre->Exportable) $Doc->ExportCaption($this->ApellidoNombre);
					if ($this->Cargo->Exportable) $Doc->ExportCaption($this->Cargo);
					if ($this->Comentarios->Exportable) $Doc->ExportCaption($this->Comentarios);
				} else {
					if ($this->CodigoCli->Exportable) $Doc->ExportCaption($this->CodigoCli);
					if ($this->Contrasenia->Exportable) $Doc->ExportCaption($this->Contrasenia);
					if ($this->Habilitado->Exportable) $Doc->ExportCaption($this->Habilitado);
					if ($this->IP->Exportable) $Doc->ExportCaption($this->IP);
					if ($this->UltimoLogin->Exportable) $Doc->ExportCaption($this->UltimoLogin);
					if ($this->TipoCliente->Exportable) $Doc->ExportCaption($this->TipoCliente);
					if ($this->Regis_Mda->Exportable) $Doc->ExportCaption($this->Regis_Mda);
					if ($this->ApellidoNombre->Exportable) $Doc->ExportCaption($this->ApellidoNombre);
					if ($this->Cargo->Exportable) $Doc->ExportCaption($this->Cargo);
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
						if ($this->pedidosPendientes->Exportable) $Doc->ExportField($this->pedidosPendientes);
						if ($this->vencimientosPendientes->Exportable) $Doc->ExportField($this->vencimientosPendientes);
						if ($this->emailCli->Exportable) $Doc->ExportField($this->emailCli);
						if ($this->Contrasenia->Exportable) $Doc->ExportField($this->Contrasenia);
						if ($this->Habilitado->Exportable) $Doc->ExportField($this->Habilitado);
						if ($this->IP->Exportable) $Doc->ExportField($this->IP);
						if ($this->UltimoLogin->Exportable) $Doc->ExportField($this->UltimoLogin);
						if ($this->TipoCliente->Exportable) $Doc->ExportField($this->TipoCliente);
						if ($this->Regis_Mda->Exportable) $Doc->ExportField($this->Regis_Mda);
						if ($this->ApellidoNombre->Exportable) $Doc->ExportField($this->ApellidoNombre);
						if ($this->Cargo->Exportable) $Doc->ExportField($this->Cargo);
						if ($this->Comentarios->Exportable) $Doc->ExportField($this->Comentarios);
					} else {
						if ($this->CodigoCli->Exportable) $Doc->ExportField($this->CodigoCli);
						if ($this->Contrasenia->Exportable) $Doc->ExportField($this->Contrasenia);
						if ($this->Habilitado->Exportable) $Doc->ExportField($this->Habilitado);
						if ($this->IP->Exportable) $Doc->ExportField($this->IP);
						if ($this->UltimoLogin->Exportable) $Doc->ExportField($this->UltimoLogin);
						if ($this->TipoCliente->Exportable) $Doc->ExportField($this->TipoCliente);
						if ($this->Regis_Mda->Exportable) $Doc->ExportField($this->Regis_Mda);
						if ($this->ApellidoNombre->Exportable) $Doc->ExportField($this->ApellidoNombre);
						if ($this->Cargo->Exportable) $Doc->ExportField($this->Cargo);
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
		$rs = ew_Execute(
			"SELECT NOW()"
		);
		if ($rs->RecordCount() > 0)
		{
			$rs->MoveFirst();
			$rsnew["UltimoLogin"] = $rs->fields[0];
		}
		$rs->Close();
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {
		global $email_asunto_usuario_habilitado;
		global $email_mensaje_plano_usuario_habilitado;
		global $email_mensaje_html_usuario_habilitado;
		if ($rsnew["Habilitado"] == "S")
		{
			$rs = ew_Execute(
				"SELECT emailCli ".
				"FROM dbo_cliente ".
				"WHERE CodigoCli = '" . $rsnew["CodigoCli"] . "' ".
				"LIMIT 1"
			);
			if ($rs->RecordCount() > 0)
			{
				$rs->MoveFirst();
				if ($rs->fields["emailCli"] != "")
				{
					$destinatario = trim(mb_strtolower($rs->fields["emailCli"]));
					$asunto = $email_asunto_usuario_habilitado;	
					$mensaje_html = $email_mensaje_html_usuario_habilitado;
					$mensaje_html = str_replace("[[ApellidoNombre]]", $rsnew["ApellidoNombre"], $mensaje_html);
					$mensaje_html = str_replace("[[emailCli]]", $rs->fields["emailCli"], $mensaje_html);
					$mensaje_html = str_replace("[[Contrasenia]]", $rsnew["Contrasenia"], $mensaje_html);								
					enviar_email($destinatario, $asunto, $mensaje_html);
				}
			}
		}
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {
		global $email_asunto_usuario_habilitado;
		global $email_mensaje_plano_usuario_habilitado;
		global $email_mensaje_html_usuario_habilitado;
		if (($rsold["Habilitado"] == "N") && ($rsnew["Habilitado"] == "S"))
		{
			$rs = ew_Execute(
				"SELECT emailCli ".
				"FROM dbo_cliente ".
				"WHERE CodigoCli = '" . $rsold["CodigoCli"] . "' ".
				"LIMIT 1"
			);
			if ($rs->RecordCount() > 0)
			{
				$rs->MoveFirst();
				if ($rs->fields["emailCli"] != "")
				{
					$destinatario = trim(mb_strtolower($rs->fields["emailCli"]));
					$asunto = $email_asunto_usuario_habilitado;	
					$mensaje_html = $email_mensaje_html_usuario_habilitado;
					$mensaje_html = str_replace("[[ApellidoNombre]]", $rsnew["ApellidoNombre"], $mensaje_html);
					$mensaje_html = str_replace("[[emailCli]]", $rs->fields["emailCli"], $mensaje_html);
					$mensaje_html = str_replace("[[Contrasenia]]", $rsnew["Contrasenia"], $mensaje_html);								
					enviar_email($destinatario, $asunto, $mensaje_html);
				}
			}
		}
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

		// Eliminar filtro cuando esté listando
		if($this->PageID == "list")
		{
			$filter = str_replace("`CodigoCli` NOT IN ( SELECT `CodigoCli` FROM walger_clientes )", "1 = 1", $filter);
		}
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {
		if(!isset($this->PageID)) return;
		if(($this->PageID == "list") || ($this->PageID == "view") || ($this->PageID == "delete"))
		{
			$CodigoCli = ucWords(mb_strtolower($this->CodigoCli->ViewValue,'UTF-8'));
			$CodigoCli_arr = explode(",", $CodigoCli);
			$this->CodigoCli->ViewValue = "";
			for($i = 0; $i < count($CodigoCli_arr) - 1; $i++)
			{
				$CodigoCli_arr[$i] = trim($CodigoCli_arr[$i]);
				if ($i != 0) 
							$this->CodigoCli->ViewValue .= trim($CodigoCli_arr[$i]);
				else
							$this->CodigoCli->ViewValue .= mb_strtoupper(trim($CodigoCli_arr[$i]));		
				if ($i + 1 != count($CodigoCli_arr) - 1) $this->CodigoCli->ViewValue .= ", ";
			}
			$this->CodigoCli->ViewValue = '<a href="vencimientos.php?CodigoCliente=' . $CodigoCli_arr[0] . '" data-caption="Vencimientos" data-original-title="Vencimientos" class="ewTooltip">' . $this->CodigoCli->ViewValue . '</a>'; 	
			$this->IP->ViewValue = '<a href="http://whatismyipaddress.com/ip/' . $this->IP->ViewValue . '" target="_blank" data-caption="Localizar" data-original-title="Localizar" class="ewTooltip">' . $this->IP->ViewValue . '</a>';
			$this->ApellidoNombre->ViewValue = ucWords(mb_strtolower($this->ApellidoNombre->ViewValue,'UTF-8'));
			if($this->Habilitado->ViewValue == "Si")
			{
				$this->Habilitado->ViewValue = '<span class="glyphicon-ok-circle glyphicon" style="font-size: 16px; color: green; font-weight: bold;"></span> Si';
			}
			else
			if($this->Habilitado->ViewValue == "No")
			{
				$this->Habilitado->ViewValue = '<span class="glyphicon-remove-circle glyphicon" style="font-size: 16px; color: red; font-weight: bold;"></span> No';
			}

			// Obtener el email del cliente actual
			$rs = ew_Execute(
				"SELECT emailCli ".
				"FROM dbo_cliente ".
				"WHERE CodigoCli = '" . $this->CodigoCli->DbValue . "' ".
				"LIMIT 1"
			);
			if ($rs->RecordCount() > 0)
			{
				$rs->MoveFirst();
				$this->emailCli->ViewValue = mb_strtolower($rs->fields[0]);
			}
			$rs->Close();
			$this->pedidosPendientes->ViewValue = 0;	
			$rs = ew_Execute("SELECT COUNT(estado) AS c FROM walger_pedidos WHERE estado IN ('N', 'X') AND CodigoCli = '" . $CodigoCli_arr[0] . "' GROUP BY estado");
			if ($rs && $rs->RecordCount() > 0) {
				$rs->MoveFirst();
				$this->pedidosPendientes->ViewValue = $rs->fields("c") . ' <a href="walger_pedidoslist.php?x_CodigoCli=' . $CodigoCli_arr[0] . '&z_CodigoCli=%3D&x_estado=N&z_estado=%3D&v_estado=OR&y_estado=X&w_estado=%3D&cmd=search&psearchtype=" class="ewTooltip" data-caption="Pedidos" data-original-title="Pedidos">(ver)</a>';
				$rs->Close();
			}
			$this->vencimientosPendientes->ViewValue = 0;	
			$rs = ew_Execute("SELECT COUNT(Regis_CliTra) AS c FROM dbo_clientevtotransa WHERE CodigoCli = '" . $CodigoCli_arr[0] . "'");
			if ($rs && $rs->RecordCount() > 0) {
				$rs->MoveFirst();
				if ($rs->fields("c") > 0)
				{
					$this->vencimientosPendientes->ViewValue = $rs->fields("c") . ' <a href="vencimientos.php?CodigoCliente=' . $CodigoCli_arr[0] . '" class="ewTooltip" data-caption="Vencimientos" data-original-title="Vencimientos">(ver)</a>';
				}
				$rs->Close();
			}
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
