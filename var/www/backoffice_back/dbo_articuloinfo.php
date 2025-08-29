<?php

// Global variable for table object
$dbo_articulo = NULL;

//
// Table class for dbo_articulo
//
class cdbo_articulo extends cTable {
	var $CodInternoArti;
	var $CodBarraArti;
	var $idTipoArticulo;
	var $DescripcionArti;
	var $detalle;
	var $PrecioVta1_PreArti;
	var $Stock1_StkArti;
	var $NombreFotoArti;
	var $DescrNivelInt4;
	var $DescrNivelInt3;
	var $DescrNivelInt2;
	var $TasaIva;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'dbo_articulo';
		$this->TableName = 'dbo_articulo';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`dbo_articulo`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);
		$this->BasicSearch->TypeDefault = "AND";

		// CodInternoArti
		$this->CodInternoArti = new cField('dbo_articulo', 'dbo_articulo', 'x_CodInternoArti', 'CodInternoArti', '`CodInternoArti`', '`CodInternoArti`', 200, -1, FALSE, '`CodInternoArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CodInternoArti->Sortable = TRUE; // Allow sort
		$this->fields['CodInternoArti'] = &$this->CodInternoArti;

		// CodBarraArti
		$this->CodBarraArti = new cField('dbo_articulo', 'dbo_articulo', 'x_CodBarraArti', 'CodBarraArti', '`CodBarraArti`', '`CodBarraArti`', 200, -1, FALSE, '`CodBarraArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CodBarraArti->Sortable = TRUE; // Allow sort
		$this->fields['CodBarraArti'] = &$this->CodBarraArti;

		// idTipoArticulo
		$this->idTipoArticulo = new cField('dbo_articulo', 'dbo_articulo', 'x_idTipoArticulo', 'idTipoArticulo', '`idTipoArticulo`', '`idTipoArticulo`', 3, -1, FALSE, '`idTipoArticulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idTipoArticulo->Sortable = TRUE; // Allow sort
		$this->idTipoArticulo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idTipoArticulo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->idTipoArticulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idTipoArticulo'] = &$this->idTipoArticulo;

		// DescripcionArti
		$this->DescripcionArti = new cField('dbo_articulo', 'dbo_articulo', 'x_DescripcionArti', 'DescripcionArti', '`DescripcionArti`', '`DescripcionArti`', 200, -1, FALSE, '`DescripcionArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescripcionArti->Sortable = TRUE; // Allow sort
		$this->fields['DescripcionArti'] = &$this->DescripcionArti;

		// detalle
		$this->detalle = new cField('dbo_articulo', 'dbo_articulo', 'x_detalle', 'detalle', '`detalle`', '`detalle`', 201, -1, FALSE, '`detalle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->detalle->Sortable = TRUE; // Allow sort
		$this->fields['detalle'] = &$this->detalle;

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti = new cField('dbo_articulo', 'dbo_articulo', 'x_PrecioVta1_PreArti', 'PrecioVta1_PreArti', '`PrecioVta1_PreArti`', '`PrecioVta1_PreArti`', 4, -1, FALSE, '`PrecioVta1_PreArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PrecioVta1_PreArti->Sortable = TRUE; // Allow sort
		$this->PrecioVta1_PreArti->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['PrecioVta1_PreArti'] = &$this->PrecioVta1_PreArti;

		// Stock1_StkArti
		$this->Stock1_StkArti = new cField('dbo_articulo', 'dbo_articulo', 'x_Stock1_StkArti', 'Stock1_StkArti', '`Stock1_StkArti`', '`Stock1_StkArti`', 4, -1, FALSE, '`Stock1_StkArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Stock1_StkArti->Sortable = TRUE; // Allow sort
		$this->Stock1_StkArti->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Stock1_StkArti'] = &$this->Stock1_StkArti;

		// NombreFotoArti
		$this->NombreFotoArti = new cField('dbo_articulo', 'dbo_articulo', 'x_NombreFotoArti', 'NombreFotoArti', '`NombreFotoArti`', '`NombreFotoArti`', 200, -1, TRUE, '`NombreFotoArti`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->NombreFotoArti->Sortable = TRUE; // Allow sort
		$this->fields['NombreFotoArti'] = &$this->NombreFotoArti;

		// DescrNivelInt4
		$this->DescrNivelInt4 = new cField('dbo_articulo', 'dbo_articulo', 'x_DescrNivelInt4', 'DescrNivelInt4', '`DescrNivelInt4`', '`DescrNivelInt4`', 200, -1, FALSE, '`DescrNivelInt4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescrNivelInt4->Sortable = TRUE; // Allow sort
		$this->fields['DescrNivelInt4'] = &$this->DescrNivelInt4;

		// DescrNivelInt3
		$this->DescrNivelInt3 = new cField('dbo_articulo', 'dbo_articulo', 'x_DescrNivelInt3', 'DescrNivelInt3', '`DescrNivelInt3`', '`DescrNivelInt3`', 200, -1, FALSE, '`DescrNivelInt3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescrNivelInt3->Sortable = TRUE; // Allow sort
		$this->fields['DescrNivelInt3'] = &$this->DescrNivelInt3;

		// DescrNivelInt2
		$this->DescrNivelInt2 = new cField('dbo_articulo', 'dbo_articulo', 'x_DescrNivelInt2', 'DescrNivelInt2', '`DescrNivelInt2`', '`DescrNivelInt2`', 200, -1, FALSE, '`DescrNivelInt2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DescrNivelInt2->Sortable = TRUE; // Allow sort
		$this->fields['DescrNivelInt2'] = &$this->DescrNivelInt2;

		// TasaIva
		$this->TasaIva = new cField('dbo_articulo', 'dbo_articulo', 'x_TasaIva', 'TasaIva', '`TasaIva`', '`TasaIva`', 4, -1, FALSE, '`TasaIva`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TasaIva->Sortable = TRUE; // Allow sort
		$this->TasaIva->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TasaIva'] = &$this->TasaIva;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`dbo_articulo`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`CodInternoArti` ASC,`CodBarraArti` ASC";
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
			if (array_key_exists('CodInternoArti', $rs))
				ew_AddFilter($where, ew_QuotedName('CodInternoArti', $this->DBID) . '=' . ew_QuotedValue($rs['CodInternoArti'], $this->CodInternoArti->FldDataType, $this->DBID));
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
		return "`CodInternoArti` = '@CodInternoArti@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@CodInternoArti@", ew_AdjustSql($this->CodInternoArti->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "dbo_articulolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "dbo_articulolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dbo_articuloview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dbo_articuloview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "dbo_articuloadd.php?" . $this->UrlParm($parm);
		else
			$url = "dbo_articuloadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("dbo_articuloedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("dbo_articuloadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("dbo_articulodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "CodInternoArti:" . ew_VarToJson($this->CodInternoArti->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->CodInternoArti->CurrentValue)) {
			$sUrl .= "CodInternoArti=" . urlencode($this->CodInternoArti->CurrentValue);
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
			if ($isPost && isset($_POST["CodInternoArti"]))
				$arKeys[] = ew_StripSlashes($_POST["CodInternoArti"]);
			elseif (isset($_GET["CodInternoArti"]))
				$arKeys[] = ew_StripSlashes($_GET["CodInternoArti"]);
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
			$this->CodInternoArti->CurrentValue = $key;
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
		$this->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
		$this->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
		$this->idTipoArticulo->setDbValue($rs->fields('idTipoArticulo'));
		$this->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
		$this->detalle->setDbValue($rs->fields('detalle'));
		$this->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
		$this->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
		$this->NombreFotoArti->Upload->DbValue = $rs->fields('NombreFotoArti');
		$this->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
		$this->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
		$this->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
		$this->TasaIva->setDbValue($rs->fields('TasaIva'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CodInternoArti

		$this->CodInternoArti->CellCssStyle = "white-space: nowrap;";

		// CodBarraArti
		$this->CodBarraArti->CellCssStyle = "white-space: nowrap;";

		// idTipoArticulo
		// DescripcionArti

		$this->DescripcionArti->CellCssStyle = "white-space: nowrap;";

		// detalle
		// PrecioVta1_PreArti

		$this->PrecioVta1_PreArti->CellCssStyle = "white-space: nowrap;";

		// Stock1_StkArti
		$this->Stock1_StkArti->CellCssStyle = "white-space: nowrap;";

		// NombreFotoArti
		$this->NombreFotoArti->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt4
		$this->DescrNivelInt4->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt3
		$this->DescrNivelInt3->CellCssStyle = "white-space: nowrap;";

		// DescrNivelInt2
		$this->DescrNivelInt2->CellCssStyle = "white-space: nowrap;";

		// TasaIva
		$this->TasaIva->CellCssStyle = "white-space: nowrap;";

		// CodInternoArti
		$this->CodInternoArti->ViewValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$this->CodBarraArti->ViewValue = $this->CodBarraArti->CurrentValue;
		$this->CodBarraArti->ViewCustomAttributes = "";

		// idTipoArticulo
		if (strval($this->idTipoArticulo->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->idTipoArticulo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `trama_tipos-articulos`";
		$sWhereWrk = "";
		$this->idTipoArticulo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idTipoArticulo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idTipoArticulo->ViewValue = $this->idTipoArticulo->CurrentValue;
			}
		} else {
			$this->idTipoArticulo->ViewValue = NULL;
		}
		$this->idTipoArticulo->ViewCustomAttributes = "";

		// DescripcionArti
		$this->DescripcionArti->ViewValue = $this->DescripcionArti->CurrentValue;
		$this->DescripcionArti->ViewCustomAttributes = "";

		// detalle
		$this->detalle->ViewValue = $this->detalle->CurrentValue;
		$this->detalle->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->ViewValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->PrecioVta1_PreArti->ViewValue = ew_FormatNumber($this->PrecioVta1_PreArti->ViewValue, 2, -1, 0, 0);
		$this->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->ViewValue = $this->Stock1_StkArti->CurrentValue;
		$this->Stock1_StkArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$this->NombreFotoArti->UploadPath = "../articulos/";
		if (!ew_Empty($this->NombreFotoArti->Upload->DbValue)) {
			$this->NombreFotoArti->ViewValue = $this->NombreFotoArti->Upload->DbValue;
		} else {
			$this->NombreFotoArti->ViewValue = "";
		}
		$this->NombreFotoArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->ViewValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->ViewValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->ViewValue = $this->DescrNivelInt2->CurrentValue;
		$this->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$this->TasaIva->ViewValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->ViewValue = ew_FormatNumber($this->TasaIva->ViewValue, 2, -1, 0, 0);
		$this->TasaIva->ViewCustomAttributes = "";

		// CodInternoArti
		$this->CodInternoArti->LinkCustomAttributes = "";
		$this->CodInternoArti->HrefValue = "";
		$this->CodInternoArti->TooltipValue = "";

		// CodBarraArti
		$this->CodBarraArti->LinkCustomAttributes = "";
		$this->CodBarraArti->HrefValue = "";
		$this->CodBarraArti->TooltipValue = "";

		// idTipoArticulo
		$this->idTipoArticulo->LinkCustomAttributes = "";
		$this->idTipoArticulo->HrefValue = "";
		$this->idTipoArticulo->TooltipValue = "";

		// DescripcionArti
		$this->DescripcionArti->LinkCustomAttributes = "";
		$this->DescripcionArti->HrefValue = "";
		$this->DescripcionArti->TooltipValue = "";

		// detalle
		$this->detalle->LinkCustomAttributes = "";
		$this->detalle->HrefValue = "";
		$this->detalle->TooltipValue = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->LinkCustomAttributes = "";
		$this->PrecioVta1_PreArti->HrefValue = "";
		$this->PrecioVta1_PreArti->TooltipValue = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->LinkCustomAttributes = "";
		$this->Stock1_StkArti->HrefValue = "";
		$this->Stock1_StkArti->TooltipValue = "";

		// NombreFotoArti
		$this->NombreFotoArti->LinkCustomAttributes = "";
		$this->NombreFotoArti->HrefValue = "";
		$this->NombreFotoArti->HrefValue2 = $this->NombreFotoArti->UploadPath . $this->NombreFotoArti->Upload->DbValue;
		$this->NombreFotoArti->TooltipValue = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->LinkCustomAttributes = "";
		$this->DescrNivelInt4->HrefValue = "";
		$this->DescrNivelInt4->TooltipValue = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->LinkCustomAttributes = "";
		$this->DescrNivelInt3->HrefValue = "";
		$this->DescrNivelInt3->TooltipValue = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->LinkCustomAttributes = "";
		$this->DescrNivelInt2->HrefValue = "";
		$this->DescrNivelInt2->TooltipValue = "";

		// TasaIva
		$this->TasaIva->LinkCustomAttributes = "";
		$this->TasaIva->HrefValue = "";
		$this->TasaIva->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// CodInternoArti
		$this->CodInternoArti->EditAttrs["class"] = "form-control";
		$this->CodInternoArti->EditCustomAttributes = "";
		$this->CodInternoArti->EditValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$this->CodBarraArti->EditAttrs["class"] = "form-control";
		$this->CodBarraArti->EditCustomAttributes = "";
		$this->CodBarraArti->EditValue = $this->CodBarraArti->CurrentValue;
		$this->CodBarraArti->PlaceHolder = ew_RemoveHtml($this->CodBarraArti->FldCaption());

		// idTipoArticulo
		$this->idTipoArticulo->EditCustomAttributes = "";

		// DescripcionArti
		$this->DescripcionArti->EditAttrs["class"] = "form-control";
		$this->DescripcionArti->EditCustomAttributes = "";
		$this->DescripcionArti->EditValue = $this->DescripcionArti->CurrentValue;
		$this->DescripcionArti->PlaceHolder = ew_RemoveHtml($this->DescripcionArti->FldCaption());

		// detalle
		$this->detalle->EditAttrs["class"] = "form-control";
		$this->detalle->EditCustomAttributes = "";
		$this->detalle->EditValue = $this->detalle->CurrentValue;
		$this->detalle->PlaceHolder = ew_RemoveHtml($this->detalle->FldCaption());

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->EditAttrs["class"] = "form-control";
		$this->PrecioVta1_PreArti->EditCustomAttributes = "";
		$this->PrecioVta1_PreArti->EditValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->PrecioVta1_PreArti->PlaceHolder = ew_RemoveHtml($this->PrecioVta1_PreArti->FldCaption());
		if (strval($this->PrecioVta1_PreArti->EditValue) <> "" && is_numeric($this->PrecioVta1_PreArti->EditValue)) $this->PrecioVta1_PreArti->EditValue = ew_FormatNumber($this->PrecioVta1_PreArti->EditValue, -2, -1, 0, 0);

		// Stock1_StkArti
		$this->Stock1_StkArti->EditAttrs["class"] = "form-control";
		$this->Stock1_StkArti->EditCustomAttributes = "";
		$this->Stock1_StkArti->EditValue = $this->Stock1_StkArti->CurrentValue;
		$this->Stock1_StkArti->PlaceHolder = ew_RemoveHtml($this->Stock1_StkArti->FldCaption());
		if (strval($this->Stock1_StkArti->EditValue) <> "" && is_numeric($this->Stock1_StkArti->EditValue)) $this->Stock1_StkArti->EditValue = ew_FormatNumber($this->Stock1_StkArti->EditValue, -2, -1, -2, 0);

		// NombreFotoArti
		$this->NombreFotoArti->EditAttrs["class"] = "form-control";
		$this->NombreFotoArti->EditCustomAttributes = "";
		$this->NombreFotoArti->UploadPath = "../articulos/";
		if (!ew_Empty($this->NombreFotoArti->Upload->DbValue)) {
			$this->NombreFotoArti->EditValue = $this->NombreFotoArti->Upload->DbValue;
		} else {
			$this->NombreFotoArti->EditValue = "";
		}
		if (!ew_Empty($this->NombreFotoArti->CurrentValue))
			$this->NombreFotoArti->Upload->FileName = $this->NombreFotoArti->CurrentValue;

		// DescrNivelInt4
		$this->DescrNivelInt4->EditAttrs["class"] = "form-control";
		$this->DescrNivelInt4->EditCustomAttributes = "";
		$this->DescrNivelInt4->EditValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt4->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt4->FldCaption());

		// DescrNivelInt3
		$this->DescrNivelInt3->EditAttrs["class"] = "form-control";
		$this->DescrNivelInt3->EditCustomAttributes = "";
		$this->DescrNivelInt3->EditValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt3->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt3->FldCaption());

		// DescrNivelInt2
		$this->DescrNivelInt2->EditAttrs["class"] = "form-control";
		$this->DescrNivelInt2->EditCustomAttributes = "";
		$this->DescrNivelInt2->EditValue = $this->DescrNivelInt2->CurrentValue;
		$this->DescrNivelInt2->PlaceHolder = ew_RemoveHtml($this->DescrNivelInt2->FldCaption());

		// TasaIva
		$this->TasaIva->EditAttrs["class"] = "form-control";
		$this->TasaIva->EditCustomAttributes = "";
		$this->TasaIva->EditValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->PlaceHolder = ew_RemoveHtml($this->TasaIva->FldCaption());
		if (strval($this->TasaIva->EditValue) <> "" && is_numeric($this->TasaIva->EditValue)) $this->TasaIva->EditValue = ew_FormatNumber($this->TasaIva->EditValue, -2, -1, 0, 0);

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
					if ($this->CodInternoArti->Exportable) $Doc->ExportCaption($this->CodInternoArti);
					if ($this->CodBarraArti->Exportable) $Doc->ExportCaption($this->CodBarraArti);
					if ($this->idTipoArticulo->Exportable) $Doc->ExportCaption($this->idTipoArticulo);
					if ($this->DescripcionArti->Exportable) $Doc->ExportCaption($this->DescripcionArti);
					if ($this->detalle->Exportable) $Doc->ExportCaption($this->detalle);
					if ($this->PrecioVta1_PreArti->Exportable) $Doc->ExportCaption($this->PrecioVta1_PreArti);
					if ($this->Stock1_StkArti->Exportable) $Doc->ExportCaption($this->Stock1_StkArti);
					if ($this->NombreFotoArti->Exportable) $Doc->ExportCaption($this->NombreFotoArti);
					if ($this->DescrNivelInt4->Exportable) $Doc->ExportCaption($this->DescrNivelInt4);
					if ($this->DescrNivelInt3->Exportable) $Doc->ExportCaption($this->DescrNivelInt3);
					if ($this->DescrNivelInt2->Exportable) $Doc->ExportCaption($this->DescrNivelInt2);
					if ($this->TasaIva->Exportable) $Doc->ExportCaption($this->TasaIva);
				} else {
					if ($this->CodInternoArti->Exportable) $Doc->ExportCaption($this->CodInternoArti);
					if ($this->CodBarraArti->Exportable) $Doc->ExportCaption($this->CodBarraArti);
					if ($this->idTipoArticulo->Exportable) $Doc->ExportCaption($this->idTipoArticulo);
					if ($this->DescripcionArti->Exportable) $Doc->ExportCaption($this->DescripcionArti);
					if ($this->PrecioVta1_PreArti->Exportable) $Doc->ExportCaption($this->PrecioVta1_PreArti);
					if ($this->Stock1_StkArti->Exportable) $Doc->ExportCaption($this->Stock1_StkArti);
					if ($this->NombreFotoArti->Exportable) $Doc->ExportCaption($this->NombreFotoArti);
					if ($this->DescrNivelInt4->Exportable) $Doc->ExportCaption($this->DescrNivelInt4);
					if ($this->DescrNivelInt3->Exportable) $Doc->ExportCaption($this->DescrNivelInt3);
					if ($this->DescrNivelInt2->Exportable) $Doc->ExportCaption($this->DescrNivelInt2);
					if ($this->TasaIva->Exportable) $Doc->ExportCaption($this->TasaIva);
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
						if ($this->CodInternoArti->Exportable) $Doc->ExportField($this->CodInternoArti);
						if ($this->CodBarraArti->Exportable) $Doc->ExportField($this->CodBarraArti);
						if ($this->idTipoArticulo->Exportable) $Doc->ExportField($this->idTipoArticulo);
						if ($this->DescripcionArti->Exportable) $Doc->ExportField($this->DescripcionArti);
						if ($this->detalle->Exportable) $Doc->ExportField($this->detalle);
						if ($this->PrecioVta1_PreArti->Exportable) $Doc->ExportField($this->PrecioVta1_PreArti);
						if ($this->Stock1_StkArti->Exportable) $Doc->ExportField($this->Stock1_StkArti);
						if ($this->NombreFotoArti->Exportable) $Doc->ExportField($this->NombreFotoArti);
						if ($this->DescrNivelInt4->Exportable) $Doc->ExportField($this->DescrNivelInt4);
						if ($this->DescrNivelInt3->Exportable) $Doc->ExportField($this->DescrNivelInt3);
						if ($this->DescrNivelInt2->Exportable) $Doc->ExportField($this->DescrNivelInt2);
						if ($this->TasaIva->Exportable) $Doc->ExportField($this->TasaIva);
					} else {
						if ($this->CodInternoArti->Exportable) $Doc->ExportField($this->CodInternoArti);
						if ($this->CodBarraArti->Exportable) $Doc->ExportField($this->CodBarraArti);
						if ($this->idTipoArticulo->Exportable) $Doc->ExportField($this->idTipoArticulo);
						if ($this->DescripcionArti->Exportable) $Doc->ExportField($this->DescripcionArti);
						if ($this->PrecioVta1_PreArti->Exportable) $Doc->ExportField($this->PrecioVta1_PreArti);
						if ($this->Stock1_StkArti->Exportable) $Doc->ExportField($this->Stock1_StkArti);
						if ($this->NombreFotoArti->Exportable) $Doc->ExportField($this->NombreFotoArti);
						if ($this->DescrNivelInt4->Exportable) $Doc->ExportField($this->DescrNivelInt4);
						if ($this->DescrNivelInt3->Exportable) $Doc->ExportField($this->DescrNivelInt3);
						if ($this->DescrNivelInt2->Exportable) $Doc->ExportField($this->DescrNivelInt2);
						if ($this->TasaIva->Exportable) $Doc->ExportField($this->TasaIva);
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
		global $ruta_imagenes_articulos;
		global $codigo_articulo_linkeado_valores_stock_precios;
		$this->DescripcionArti->ViewValue = ucWords(mb_strtolower($this->DescripcionArti->ViewValue,'UTF-8'));
		$this->DescrNivelInt4->ViewValue = ucWords(mb_strtolower($this->DescrNivelInt4->ViewValue,'UTF-8'));
		$this->DescrNivelInt3->ViewValue = ucWords(mb_strtolower($this->DescrNivelInt3->ViewValue,'UTF-8'));
		$this->DescrNivelInt2->ViewValue = ucWords(mb_strtolower($this->DescrNivelInt2->ViewValue,'UTF-8'));
		$foto = $this->NombreFotoArti->ViewValue;
		if (strpos(strtolower($foto), "disponible") !== false) $foto = "";
		$this->NombreFotoArti->ViewValue = '<a href="#none" onmouseover="$(\'.foto_pequenia\').hide(); $(\'#' . md5($foto) . '\').show();">' . $foto . '</a><div id="' . md5($foto) . '" onmouseout="$(\'.foto_pequenia\').hide();" style="z-index: 1000; overflow: auto; display: none; position: absolute; background: white;" class="foto_pequenia"><img src="' . $ruta_imagenes_articulos . $foto . '" width="200" style="border: 2px solid #969696; padding: 3px; border-radius: 5px;" /></div>';
		if ($codigo_articulo_linkeado_valores_stock_precios)
			if($this->idTipoArticulo->ViewValue != "")
				$this->CodInternoArti->ViewValue = '<a href="matriz_valores_stock_precio.php?id=' . $this->CodInternoArti->ViewValue . '" data-caption="Valores, Stock y Precios" data-original-title="Valores, Stock y Precios" class="ewTooltip">' . $this->CodInternoArti->ViewValue . '</a>';
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
