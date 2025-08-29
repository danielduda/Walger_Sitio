<?php

// Global variable for table object
$walger_pedidos = NULL;

//
// Table class for walger_pedidos
//
class cwalger_pedidos extends cTable {
	var $idPedido;
	var $CodigoCli;
	var $estado;
	var $fechaEstado;
	var $fechaFacturacion;
	var $factura;
	var $comentario;
	var $idMedioEnvio;
	var $idMedioPago;
	var $recargoEnvioIva;
	var $recargoPagoIva;
	var $idCuotaRecargo;
	var $recargoEnvio;
	var $recargoPago;
	var $StatusCode;
	var $StatusMessage;
	var $URL_Request;
	var $RequestKey;
	var $PublicRequestKey;
	var $AnswerKey;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'walger_pedidos';
		$this->TableName = 'walger_pedidos';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`walger_pedidos`";
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

		// idPedido
		$this->idPedido = new cField('walger_pedidos', 'walger_pedidos', 'x_idPedido', 'idPedido', '`idPedido`', '`idPedido`', 19, -1, FALSE, '`idPedido`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idPedido->Sortable = TRUE; // Allow sort
		$this->idPedido->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idPedido'] = &$this->idPedido;

		// CodigoCli
		$this->CodigoCli = new cField('walger_pedidos', 'walger_pedidos', 'x_CodigoCli', 'CodigoCli', '`CodigoCli`', '`CodigoCli`', 200, -1, FALSE, '`CodigoCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CodigoCli->Sortable = TRUE; // Allow sort
		$this->fields['CodigoCli'] = &$this->CodigoCli;

		// estado
		$this->estado = new cField('walger_pedidos', 'walger_pedidos', 'x_estado', 'estado', '`estado`', '`estado`', 200, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->estado->Sortable = TRUE; // Allow sort
		$this->estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->estado->OptionCount = 6;
		$this->fields['estado'] = &$this->estado;

		// fechaEstado
		$this->fechaEstado = new cField('walger_pedidos', 'walger_pedidos', 'x_fechaEstado', 'fechaEstado', '`fechaEstado`', 'DATE_FORMAT(`fechaEstado`, \'%Y/%m/%d\')', 135, 1, FALSE, '`fechaEstado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fechaEstado->Sortable = TRUE; // Allow sort
		$this->fechaEstado->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fechaEstado'] = &$this->fechaEstado;

		// fechaFacturacion
		$this->fechaFacturacion = new cField('walger_pedidos', 'walger_pedidos', 'x_fechaFacturacion', 'fechaFacturacion', '`fechaFacturacion`', 'DATE_FORMAT(`fechaFacturacion`, \'%Y/%m/%d\')', 135, 0, FALSE, '`fechaFacturacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fechaFacturacion->Sortable = TRUE; // Allow sort
		$this->fechaFacturacion->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['fechaFacturacion'] = &$this->fechaFacturacion;

		// factura
		$this->factura = new cField('walger_pedidos', 'walger_pedidos', 'x_factura', 'factura', '`factura`', '`factura`', 200, -1, FALSE, '`factura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->factura->Sortable = TRUE; // Allow sort
		$this->fields['factura'] = &$this->factura;

		// comentario
		$this->comentario = new cField('walger_pedidos', 'walger_pedidos', 'x_comentario', 'comentario', '`comentario`', '`comentario`', 201, -1, FALSE, '`comentario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->comentario->Sortable = FALSE; // Allow sort
		$this->fields['comentario'] = &$this->comentario;

		// idMedioEnvio
		$this->idMedioEnvio = new cField('walger_pedidos', 'walger_pedidos', 'x_idMedioEnvio', 'idMedioEnvio', '`idMedioEnvio`', '`idMedioEnvio`', 19, -1, FALSE, '`idMedioEnvio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idMedioEnvio->Sortable = FALSE; // Allow sort
		$this->idMedioEnvio->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idMedioEnvio'] = &$this->idMedioEnvio;

		// idMedioPago
		$this->idMedioPago = new cField('walger_pedidos', 'walger_pedidos', 'x_idMedioPago', 'idMedioPago', '`idMedioPago`', '`idMedioPago`', 19, -1, FALSE, '`idMedioPago`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idMedioPago->Sortable = FALSE; // Allow sort
		$this->idMedioPago->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idMedioPago'] = &$this->idMedioPago;

		// recargoEnvioIva
		$this->recargoEnvioIva = new cField('walger_pedidos', 'walger_pedidos', 'x_recargoEnvioIva', 'recargoEnvioIva', '`recargoEnvioIva`', '`recargoEnvioIva`', 4, -1, FALSE, '`recargoEnvioIva`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->recargoEnvioIva->Sortable = FALSE; // Allow sort
		$this->recargoEnvioIva->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['recargoEnvioIva'] = &$this->recargoEnvioIva;

		// recargoPagoIva
		$this->recargoPagoIva = new cField('walger_pedidos', 'walger_pedidos', 'x_recargoPagoIva', 'recargoPagoIva', '`recargoPagoIva`', '`recargoPagoIva`', 4, -1, FALSE, '`recargoPagoIva`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->recargoPagoIva->Sortable = FALSE; // Allow sort
		$this->recargoPagoIva->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['recargoPagoIva'] = &$this->recargoPagoIva;

		// idCuotaRecargo
		$this->idCuotaRecargo = new cField('walger_pedidos', 'walger_pedidos', 'x_idCuotaRecargo', 'idCuotaRecargo', '`idCuotaRecargo`', '`idCuotaRecargo`', 19, -1, FALSE, '`idCuotaRecargo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idCuotaRecargo->Sortable = FALSE; // Allow sort
		$this->idCuotaRecargo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idCuotaRecargo'] = &$this->idCuotaRecargo;

		// recargoEnvio
		$this->recargoEnvio = new cField('walger_pedidos', 'walger_pedidos', 'x_recargoEnvio', 'recargoEnvio', '`recargoEnvio`', '`recargoEnvio`', 4, -1, FALSE, '`recargoEnvio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->recargoEnvio->Sortable = FALSE; // Allow sort
		$this->recargoEnvio->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['recargoEnvio'] = &$this->recargoEnvio;

		// recargoPago
		$this->recargoPago = new cField('walger_pedidos', 'walger_pedidos', 'x_recargoPago', 'recargoPago', '`recargoPago`', '`recargoPago`', 4, -1, FALSE, '`recargoPago`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->recargoPago->Sortable = FALSE; // Allow sort
		$this->recargoPago->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['recargoPago'] = &$this->recargoPago;

		// StatusCode
		$this->StatusCode = new cField('walger_pedidos', 'walger_pedidos', 'x_StatusCode', 'StatusCode', '`StatusCode`', '`StatusCode`', 3, -1, FALSE, '`StatusCode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->StatusCode->Sortable = FALSE; // Allow sort
		$this->StatusCode->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['StatusCode'] = &$this->StatusCode;

		// StatusMessage
		$this->StatusMessage = new cField('walger_pedidos', 'walger_pedidos', 'x_StatusMessage', 'StatusMessage', '`StatusMessage`', '`StatusMessage`', 200, -1, FALSE, '`StatusMessage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->StatusMessage->Sortable = FALSE; // Allow sort
		$this->fields['StatusMessage'] = &$this->StatusMessage;

		// URL_Request
		$this->URL_Request = new cField('walger_pedidos', 'walger_pedidos', 'x_URL_Request', 'URL_Request', '`URL_Request`', '`URL_Request`', 200, -1, FALSE, '`URL_Request`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->URL_Request->Sortable = FALSE; // Allow sort
		$this->fields['URL_Request'] = &$this->URL_Request;

		// RequestKey
		$this->RequestKey = new cField('walger_pedidos', 'walger_pedidos', 'x_RequestKey', 'RequestKey', '`RequestKey`', '`RequestKey`', 200, -1, FALSE, '`RequestKey`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RequestKey->Sortable = FALSE; // Allow sort
		$this->fields['RequestKey'] = &$this->RequestKey;

		// PublicRequestKey
		$this->PublicRequestKey = new cField('walger_pedidos', 'walger_pedidos', 'x_PublicRequestKey', 'PublicRequestKey', '`PublicRequestKey`', '`PublicRequestKey`', 200, -1, FALSE, '`PublicRequestKey`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PublicRequestKey->Sortable = FALSE; // Allow sort
		$this->fields['PublicRequestKey'] = &$this->PublicRequestKey;

		// AnswerKey
		$this->AnswerKey = new cField('walger_pedidos', 'walger_pedidos', 'x_AnswerKey', 'AnswerKey', '`AnswerKey`', '`AnswerKey`', 200, -1, FALSE, '`AnswerKey`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->AnswerKey->Sortable = FALSE; // Allow sort
		$this->fields['AnswerKey'] = &$this->AnswerKey;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`walger_pedidos`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`idPedido` DESC";
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
			if (array_key_exists('idPedido', $rs))
				ew_AddFilter($where, ew_QuotedName('idPedido', $this->DBID) . '=' . ew_QuotedValue($rs['idPedido'], $this->idPedido->FldDataType, $this->DBID));
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
		return "`idPedido` = @idPedido@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idPedido->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idPedido@", ew_AdjustSql($this->idPedido->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "walger_pedidoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "walger_pedidoslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("walger_pedidosview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("walger_pedidosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "walger_pedidosadd.php?" . $this->UrlParm($parm);
		else
			$url = "walger_pedidosadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("walger_pedidosedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("walger_pedidosadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("walger_pedidosdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "idPedido:" . ew_VarToJson($this->idPedido->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idPedido->CurrentValue)) {
			$sUrl .= "idPedido=" . urlencode($this->idPedido->CurrentValue);
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
			if ($isPost && isset($_POST["idPedido"]))
				$arKeys[] = ew_StripSlashes($_POST["idPedido"]);
			elseif (isset($_GET["idPedido"]))
				$arKeys[] = ew_StripSlashes($_GET["idPedido"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
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
			$this->idPedido->CurrentValue = $key;
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
		$this->idPedido->setDbValue($rs->fields('idPedido'));
		$this->CodigoCli->setDbValue($rs->fields('CodigoCli'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fechaEstado->setDbValue($rs->fields('fechaEstado'));
		$this->fechaFacturacion->setDbValue($rs->fields('fechaFacturacion'));
		$this->factura->setDbValue($rs->fields('factura'));
		$this->comentario->setDbValue($rs->fields('comentario'));
		$this->idMedioEnvio->setDbValue($rs->fields('idMedioEnvio'));
		$this->idMedioPago->setDbValue($rs->fields('idMedioPago'));
		$this->recargoEnvioIva->setDbValue($rs->fields('recargoEnvioIva'));
		$this->recargoPagoIva->setDbValue($rs->fields('recargoPagoIva'));
		$this->idCuotaRecargo->setDbValue($rs->fields('idCuotaRecargo'));
		$this->recargoEnvio->setDbValue($rs->fields('recargoEnvio'));
		$this->recargoPago->setDbValue($rs->fields('recargoPago'));
		$this->StatusCode->setDbValue($rs->fields('StatusCode'));
		$this->StatusMessage->setDbValue($rs->fields('StatusMessage'));
		$this->URL_Request->setDbValue($rs->fields('URL_Request'));
		$this->RequestKey->setDbValue($rs->fields('RequestKey'));
		$this->PublicRequestKey->setDbValue($rs->fields('PublicRequestKey'));
		$this->AnswerKey->setDbValue($rs->fields('AnswerKey'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idPedido

		$this->idPedido->CellCssStyle = "white-space: nowrap;";

		// CodigoCli
		$this->CodigoCli->CellCssStyle = "white-space: nowrap;";

		// estado
		$this->estado->CellCssStyle = "white-space: nowrap;";

		// fechaEstado
		$this->fechaEstado->CellCssStyle = "white-space: nowrap;";

		// fechaFacturacion
		$this->fechaFacturacion->CellCssStyle = "white-space: nowrap;";

		// factura
		$this->factura->CellCssStyle = "white-space: nowrap;";

		// comentario
		$this->comentario->CellCssStyle = "white-space: nowrap;";

		// idMedioEnvio
		// idMedioPago
		// recargoEnvioIva
		// recargoPagoIva
		// idCuotaRecargo
		// recargoEnvio
		// recargoPago
		// StatusCode
		// StatusMessage
		// URL_Request
		// RequestKey
		// PublicRequestKey
		// AnswerKey
		// idPedido

		$this->idPedido->ViewValue = $this->idPedido->CurrentValue;
		$this->idPedido->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->CodigoCli->ViewValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->ViewValue = NULL;
		}
		$this->CodigoCli->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fechaEstado
		$this->fechaEstado->ViewValue = $this->fechaEstado->CurrentValue;
		$this->fechaEstado->ViewValue = ew_FormatDateTime($this->fechaEstado->ViewValue, 1);
		$this->fechaEstado->ViewCustomAttributes = "";

		// fechaFacturacion
		$this->fechaFacturacion->ViewValue = $this->fechaFacturacion->CurrentValue;
		$this->fechaFacturacion->ViewValue = ew_FormatDateTime($this->fechaFacturacion->ViewValue, 0);
		$this->fechaFacturacion->ViewCustomAttributes = "";

		// factura
		$this->factura->ViewValue = $this->factura->CurrentValue;
		$this->factura->ViewCustomAttributes = "";

		// comentario
		$this->comentario->ViewValue = $this->comentario->CurrentValue;
		$this->comentario->ViewCustomAttributes = "";

		// idMedioEnvio
		$this->idMedioEnvio->ViewValue = $this->idMedioEnvio->CurrentValue;
		$this->idMedioEnvio->ViewCustomAttributes = "";

		// idMedioPago
		$this->idMedioPago->ViewValue = $this->idMedioPago->CurrentValue;
		$this->idMedioPago->ViewCustomAttributes = "";

		// recargoEnvioIva
		$this->recargoEnvioIva->ViewValue = $this->recargoEnvioIva->CurrentValue;
		$this->recargoEnvioIva->ViewCustomAttributes = "";

		// recargoPagoIva
		$this->recargoPagoIva->ViewValue = $this->recargoPagoIva->CurrentValue;
		$this->recargoPagoIva->ViewCustomAttributes = "";

		// idCuotaRecargo
		$this->idCuotaRecargo->ViewValue = $this->idCuotaRecargo->CurrentValue;
		$this->idCuotaRecargo->ViewCustomAttributes = "";

		// recargoEnvio
		$this->recargoEnvio->ViewValue = $this->recargoEnvio->CurrentValue;
		$this->recargoEnvio->ViewCustomAttributes = "";

		// recargoPago
		$this->recargoPago->ViewValue = $this->recargoPago->CurrentValue;
		$this->recargoPago->ViewCustomAttributes = "";

		// StatusCode
		$this->StatusCode->ViewValue = $this->StatusCode->CurrentValue;
		$this->StatusCode->ViewCustomAttributes = "";

		// StatusMessage
		$this->StatusMessage->ViewValue = $this->StatusMessage->CurrentValue;
		$this->StatusMessage->ViewCustomAttributes = "";

		// URL_Request
		$this->URL_Request->ViewValue = $this->URL_Request->CurrentValue;
		$this->URL_Request->ViewCustomAttributes = "";

		// RequestKey
		$this->RequestKey->ViewValue = $this->RequestKey->CurrentValue;
		$this->RequestKey->ViewCustomAttributes = "";

		// PublicRequestKey
		$this->PublicRequestKey->ViewValue = $this->PublicRequestKey->CurrentValue;
		$this->PublicRequestKey->ViewCustomAttributes = "";

		// AnswerKey
		$this->AnswerKey->ViewValue = $this->AnswerKey->CurrentValue;
		$this->AnswerKey->ViewCustomAttributes = "";

		// idPedido
		$this->idPedido->LinkCustomAttributes = "";
		$this->idPedido->HrefValue = "";
		$this->idPedido->TooltipValue = "";

		// CodigoCli
		$this->CodigoCli->LinkCustomAttributes = "";
		$this->CodigoCli->HrefValue = "";
		$this->CodigoCli->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fechaEstado
		$this->fechaEstado->LinkCustomAttributes = "";
		$this->fechaEstado->HrefValue = "";
		$this->fechaEstado->TooltipValue = "";

		// fechaFacturacion
		$this->fechaFacturacion->LinkCustomAttributes = "";
		$this->fechaFacturacion->HrefValue = "";
		$this->fechaFacturacion->TooltipValue = "";

		// factura
		$this->factura->LinkCustomAttributes = "";
		$this->factura->HrefValue = "";
		$this->factura->TooltipValue = "";

		// comentario
		$this->comentario->LinkCustomAttributes = "";
		$this->comentario->HrefValue = "";
		$this->comentario->TooltipValue = "";

		// idMedioEnvio
		$this->idMedioEnvio->LinkCustomAttributes = "";
		$this->idMedioEnvio->HrefValue = "";
		$this->idMedioEnvio->TooltipValue = "";

		// idMedioPago
		$this->idMedioPago->LinkCustomAttributes = "";
		$this->idMedioPago->HrefValue = "";
		$this->idMedioPago->TooltipValue = "";

		// recargoEnvioIva
		$this->recargoEnvioIva->LinkCustomAttributes = "";
		$this->recargoEnvioIva->HrefValue = "";
		$this->recargoEnvioIva->TooltipValue = "";

		// recargoPagoIva
		$this->recargoPagoIva->LinkCustomAttributes = "";
		$this->recargoPagoIva->HrefValue = "";
		$this->recargoPagoIva->TooltipValue = "";

		// idCuotaRecargo
		$this->idCuotaRecargo->LinkCustomAttributes = "";
		$this->idCuotaRecargo->HrefValue = "";
		$this->idCuotaRecargo->TooltipValue = "";

		// recargoEnvio
		$this->recargoEnvio->LinkCustomAttributes = "";
		$this->recargoEnvio->HrefValue = "";
		$this->recargoEnvio->TooltipValue = "";

		// recargoPago
		$this->recargoPago->LinkCustomAttributes = "";
		$this->recargoPago->HrefValue = "";
		$this->recargoPago->TooltipValue = "";

		// StatusCode
		$this->StatusCode->LinkCustomAttributes = "";
		$this->StatusCode->HrefValue = "";
		$this->StatusCode->TooltipValue = "";

		// StatusMessage
		$this->StatusMessage->LinkCustomAttributes = "";
		$this->StatusMessage->HrefValue = "";
		$this->StatusMessage->TooltipValue = "";

		// URL_Request
		$this->URL_Request->LinkCustomAttributes = "";
		$this->URL_Request->HrefValue = "";
		$this->URL_Request->TooltipValue = "";

		// RequestKey
		$this->RequestKey->LinkCustomAttributes = "";
		$this->RequestKey->HrefValue = "";
		$this->RequestKey->TooltipValue = "";

		// PublicRequestKey
		$this->PublicRequestKey->LinkCustomAttributes = "";
		$this->PublicRequestKey->HrefValue = "";
		$this->PublicRequestKey->TooltipValue = "";

		// AnswerKey
		$this->AnswerKey->LinkCustomAttributes = "";
		$this->AnswerKey->HrefValue = "";
		$this->AnswerKey->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idPedido
		$this->idPedido->EditAttrs["class"] = "form-control";
		$this->idPedido->EditCustomAttributes = "";
		$this->idPedido->EditValue = $this->idPedido->CurrentValue;
		$this->idPedido->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->EditAttrs["class"] = "form-control";
		$this->CodigoCli->EditCustomAttributes = "";
		$this->CodigoCli->EditValue = $this->CodigoCli->CurrentValue;
		if (strval($this->CodigoCli->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->CodigoCli->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CodigoCli`, `CodigoCli` AS `DispFld`, `RazonSocialCli` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		$this->CodigoCli->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CodigoCli, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->CodigoCli->EditValue = $this->CodigoCli->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CodigoCli->EditValue = $this->CodigoCli->CurrentValue;
			}
		} else {
			$this->CodigoCli->EditValue = NULL;
		}
		$this->CodigoCli->ViewCustomAttributes = "";

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$this->estado->EditValue = $this->estado->Options(TRUE);

		// fechaEstado
		$this->fechaEstado->EditAttrs["class"] = "form-control";
		$this->fechaEstado->EditCustomAttributes = "";
		$this->fechaEstado->EditValue = $this->fechaEstado->CurrentValue;
		$this->fechaEstado->EditValue = ew_FormatDateTime($this->fechaEstado->EditValue, 1);
		$this->fechaEstado->ViewCustomAttributes = "";

		// fechaFacturacion
		$this->fechaFacturacion->EditAttrs["class"] = "form-control";
		$this->fechaFacturacion->EditCustomAttributes = "";
		$this->fechaFacturacion->EditValue = ew_FormatDateTime($this->fechaFacturacion->CurrentValue, 8);
		$this->fechaFacturacion->PlaceHolder = ew_RemoveHtml($this->fechaFacturacion->FldCaption());

		// factura
		$this->factura->EditAttrs["class"] = "form-control";
		$this->factura->EditCustomAttributes = "";
		$this->factura->EditValue = $this->factura->CurrentValue;
		$this->factura->PlaceHolder = ew_RemoveHtml($this->factura->FldCaption());

		// comentario
		$this->comentario->EditAttrs["class"] = "form-control";
		$this->comentario->EditCustomAttributes = "";
		$this->comentario->EditValue = $this->comentario->CurrentValue;
		$this->comentario->PlaceHolder = ew_RemoveHtml($this->comentario->FldCaption());

		// idMedioEnvio
		$this->idMedioEnvio->EditAttrs["class"] = "form-control";
		$this->idMedioEnvio->EditCustomAttributes = "";
		$this->idMedioEnvio->EditValue = $this->idMedioEnvio->CurrentValue;
		$this->idMedioEnvio->PlaceHolder = ew_RemoveHtml($this->idMedioEnvio->FldCaption());

		// idMedioPago
		$this->idMedioPago->EditAttrs["class"] = "form-control";
		$this->idMedioPago->EditCustomAttributes = "";
		$this->idMedioPago->EditValue = $this->idMedioPago->CurrentValue;
		$this->idMedioPago->PlaceHolder = ew_RemoveHtml($this->idMedioPago->FldCaption());

		// recargoEnvioIva
		$this->recargoEnvioIva->EditAttrs["class"] = "form-control";
		$this->recargoEnvioIva->EditCustomAttributes = "";
		$this->recargoEnvioIva->EditValue = $this->recargoEnvioIva->CurrentValue;
		$this->recargoEnvioIva->PlaceHolder = ew_RemoveHtml($this->recargoEnvioIva->FldCaption());
		if (strval($this->recargoEnvioIva->EditValue) <> "" && is_numeric($this->recargoEnvioIva->EditValue)) $this->recargoEnvioIva->EditValue = ew_FormatNumber($this->recargoEnvioIva->EditValue, -2, -1, -2, 0);

		// recargoPagoIva
		$this->recargoPagoIva->EditAttrs["class"] = "form-control";
		$this->recargoPagoIva->EditCustomAttributes = "";
		$this->recargoPagoIva->EditValue = $this->recargoPagoIva->CurrentValue;
		$this->recargoPagoIva->PlaceHolder = ew_RemoveHtml($this->recargoPagoIva->FldCaption());
		if (strval($this->recargoPagoIva->EditValue) <> "" && is_numeric($this->recargoPagoIva->EditValue)) $this->recargoPagoIva->EditValue = ew_FormatNumber($this->recargoPagoIva->EditValue, -2, -1, -2, 0);

		// idCuotaRecargo
		$this->idCuotaRecargo->EditAttrs["class"] = "form-control";
		$this->idCuotaRecargo->EditCustomAttributes = "";
		$this->idCuotaRecargo->EditValue = $this->idCuotaRecargo->CurrentValue;
		$this->idCuotaRecargo->PlaceHolder = ew_RemoveHtml($this->idCuotaRecargo->FldCaption());

		// recargoEnvio
		$this->recargoEnvio->EditAttrs["class"] = "form-control";
		$this->recargoEnvio->EditCustomAttributes = "";
		$this->recargoEnvio->EditValue = $this->recargoEnvio->CurrentValue;
		$this->recargoEnvio->PlaceHolder = ew_RemoveHtml($this->recargoEnvio->FldCaption());
		if (strval($this->recargoEnvio->EditValue) <> "" && is_numeric($this->recargoEnvio->EditValue)) $this->recargoEnvio->EditValue = ew_FormatNumber($this->recargoEnvio->EditValue, -2, -1, -2, 0);

		// recargoPago
		$this->recargoPago->EditAttrs["class"] = "form-control";
		$this->recargoPago->EditCustomAttributes = "";
		$this->recargoPago->EditValue = $this->recargoPago->CurrentValue;
		$this->recargoPago->PlaceHolder = ew_RemoveHtml($this->recargoPago->FldCaption());
		if (strval($this->recargoPago->EditValue) <> "" && is_numeric($this->recargoPago->EditValue)) $this->recargoPago->EditValue = ew_FormatNumber($this->recargoPago->EditValue, -2, -1, -2, 0);

		// StatusCode
		$this->StatusCode->EditAttrs["class"] = "form-control";
		$this->StatusCode->EditCustomAttributes = "";
		$this->StatusCode->EditValue = $this->StatusCode->CurrentValue;
		$this->StatusCode->PlaceHolder = ew_RemoveHtml($this->StatusCode->FldCaption());

		// StatusMessage
		$this->StatusMessage->EditAttrs["class"] = "form-control";
		$this->StatusMessage->EditCustomAttributes = "";
		$this->StatusMessage->EditValue = $this->StatusMessage->CurrentValue;
		$this->StatusMessage->PlaceHolder = ew_RemoveHtml($this->StatusMessage->FldCaption());

		// URL_Request
		$this->URL_Request->EditAttrs["class"] = "form-control";
		$this->URL_Request->EditCustomAttributes = "";
		$this->URL_Request->EditValue = $this->URL_Request->CurrentValue;
		$this->URL_Request->PlaceHolder = ew_RemoveHtml($this->URL_Request->FldCaption());

		// RequestKey
		$this->RequestKey->EditAttrs["class"] = "form-control";
		$this->RequestKey->EditCustomAttributes = "";
		$this->RequestKey->EditValue = $this->RequestKey->CurrentValue;
		$this->RequestKey->PlaceHolder = ew_RemoveHtml($this->RequestKey->FldCaption());

		// PublicRequestKey
		$this->PublicRequestKey->EditAttrs["class"] = "form-control";
		$this->PublicRequestKey->EditCustomAttributes = "";
		$this->PublicRequestKey->EditValue = $this->PublicRequestKey->CurrentValue;
		$this->PublicRequestKey->PlaceHolder = ew_RemoveHtml($this->PublicRequestKey->FldCaption());

		// AnswerKey
		$this->AnswerKey->EditAttrs["class"] = "form-control";
		$this->AnswerKey->EditCustomAttributes = "";
		$this->AnswerKey->EditValue = $this->AnswerKey->CurrentValue;
		$this->AnswerKey->PlaceHolder = ew_RemoveHtml($this->AnswerKey->FldCaption());

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
					if ($this->idPedido->Exportable) $Doc->ExportCaption($this->idPedido);
					if ($this->CodigoCli->Exportable) $Doc->ExportCaption($this->CodigoCli);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fechaEstado->Exportable) $Doc->ExportCaption($this->fechaEstado);
					if ($this->fechaFacturacion->Exportable) $Doc->ExportCaption($this->fechaFacturacion);
					if ($this->factura->Exportable) $Doc->ExportCaption($this->factura);
					if ($this->comentario->Exportable) $Doc->ExportCaption($this->comentario);
				} else {
					if ($this->idPedido->Exportable) $Doc->ExportCaption($this->idPedido);
					if ($this->CodigoCli->Exportable) $Doc->ExportCaption($this->CodigoCli);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fechaEstado->Exportable) $Doc->ExportCaption($this->fechaEstado);
					if ($this->fechaFacturacion->Exportable) $Doc->ExportCaption($this->fechaFacturacion);
					if ($this->factura->Exportable) $Doc->ExportCaption($this->factura);
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
						if ($this->idPedido->Exportable) $Doc->ExportField($this->idPedido);
						if ($this->CodigoCli->Exportable) $Doc->ExportField($this->CodigoCli);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fechaEstado->Exportable) $Doc->ExportField($this->fechaEstado);
						if ($this->fechaFacturacion->Exportable) $Doc->ExportField($this->fechaFacturacion);
						if ($this->factura->Exportable) $Doc->ExportField($this->factura);
						if ($this->comentario->Exportable) $Doc->ExportField($this->comentario);
					} else {
						if ($this->idPedido->Exportable) $Doc->ExportField($this->idPedido);
						if ($this->CodigoCli->Exportable) $Doc->ExportField($this->CodigoCli);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fechaEstado->Exportable) $Doc->ExportField($this->fechaEstado);
						if ($this->fechaFacturacion->Exportable) $Doc->ExportField($this->fechaFacturacion);
						if ($this->factura->Exportable) $Doc->ExportField($this->factura);
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
		if (!isset($this->estado->AdvancedSearch->SearchValue))
		{
			$this->estado->AdvancedSearch->SearchValue = 'X';
		}
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

		$rsnew["fechaEstado"] = ew_CurrentDateTime();
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
		if(!isset($this->PageID)) return;
		if(($this->PageID == "list") || ($this->PageID == "view") || ($this->PageID == "delete"))
		{
			$rs = ew_Execute("SELECT COUNT(idPedido) AS c FROM walger_items_pedidos WHERE idPedido = '" . $this->idPedido->ViewValue . "'");
			if ($rs && $rs->RecordCount() > 0) {
				$rs->MoveFirst();
				if ($rs->fields("c") > 0)
				{
					$this->idPedido->ViewValue = '<a href="items_pedido.php?idPedido=' . $this->idPedido->ViewValue . '" data-caption="Items del Pedido" data-original-title="Items del Pedido" class="ewTooltip">' . $this->idPedido->ViewValue . '</a>'; 	
				}
				else
				{
					$this->idPedido->ViewValue = '<span data-caption="Pedido sin Items" data-original-title="Pedido sin Items" class="ewTooltip">' . $this->idPedido->ViewValue . '</span>'; 	
				}
				$rs->Close();
			}
			$CodigoCli = ucWords(mb_strtolower($this->CodigoCli->ViewValue,'UTF-8'));
			$CodigoCli_arr = explode(",", $CodigoCli);
			$this->CodigoCli->ViewValue = "";
			for($i = 0; $i < count($CodigoCli_arr); $i++)
			{
				$CodigoCli_arr[$i] = trim($CodigoCli_arr[$i]);
				if ($i != 0) 
							$this->CodigoCli->ViewValue .= trim($CodigoCli_arr[$i]);
				else
							$this->CodigoCli->ViewValue .= mb_strtoupper(trim($CodigoCli_arr[$i]));		
				if ($i + 1 != count($CodigoCli_arr)) $this->CodigoCli->ViewValue .= ", ";
			}
			$this->CodigoCli->ViewValue = '<a href="vencimientos.php?CodigoCliente=' . $CodigoCli_arr[0] . '" data-caption="Vencimientos" data-original-title="Vencimientos" class="ewTooltip">' . $this->CodigoCli->ViewValue . '</a>'; 	
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
