<?php

// Global variable for table object
$dbo_cliente = NULL;

//
// Table class for dbo_cliente
//
class cdbo_cliente extends cTable {
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
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// CodigoCli
		$this->CodigoCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CodigoCli', 'CodigoCli', '`CodigoCli`', '`CodigoCli`', 200, -1, FALSE, '`CodigoCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CodigoCli'] = &$this->CodigoCli;

		// RazonSocialCli
		$this->RazonSocialCli = new cField('dbo_cliente', 'dbo_cliente', 'x_RazonSocialCli', 'RazonSocialCli', '`RazonSocialCli`', '`RazonSocialCli`', 200, -1, FALSE, '`RazonSocialCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RazonSocialCli'] = &$this->RazonSocialCli;

		// CuitCli
		$this->CuitCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CuitCli', 'CuitCli', '`CuitCli`', '`CuitCli`', 200, -1, FALSE, '`CuitCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CuitCli'] = &$this->CuitCli;

		// IngBrutosCli
		$this->IngBrutosCli = new cField('dbo_cliente', 'dbo_cliente', 'x_IngBrutosCli', 'IngBrutosCli', '`IngBrutosCli`', '`IngBrutosCli`', 200, -1, FALSE, '`IngBrutosCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['IngBrutosCli'] = &$this->IngBrutosCli;

		// Regis_IvaC
		$this->Regis_IvaC = new cField('dbo_cliente', 'dbo_cliente', 'x_Regis_IvaC', 'Regis_IvaC', '`Regis_IvaC`', '`Regis_IvaC`', 3, -1, FALSE, '`Regis_IvaC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Regis_IvaC->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Regis_IvaC'] = &$this->Regis_IvaC;

		// Regis_ListaPrec
		$this->Regis_ListaPrec = new cField('dbo_cliente', 'dbo_cliente', 'x_Regis_ListaPrec', 'Regis_ListaPrec', '`Regis_ListaPrec`', '`Regis_ListaPrec`', 3, -1, FALSE, '`Regis_ListaPrec`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Regis_ListaPrec->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Regis_ListaPrec'] = &$this->Regis_ListaPrec;

		// emailCli
		$this->emailCli = new cField('dbo_cliente', 'dbo_cliente', 'x_emailCli', 'emailCli', '`emailCli`', '`emailCli`', 200, -1, FALSE, '`emailCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['emailCli'] = &$this->emailCli;

		// RazonSocialFlete
		$this->RazonSocialFlete = new cField('dbo_cliente', 'dbo_cliente', 'x_RazonSocialFlete', 'RazonSocialFlete', '`RazonSocialFlete`', '`RazonSocialFlete`', 200, -1, FALSE, '`RazonSocialFlete`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['RazonSocialFlete'] = &$this->RazonSocialFlete;

		// Direccion
		$this->Direccion = new cField('dbo_cliente', 'dbo_cliente', 'x_Direccion', 'Direccion', '`Direccion`', '`Direccion`', 200, -1, FALSE, '`Direccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Direccion'] = &$this->Direccion;

		// BarrioCli
		$this->BarrioCli = new cField('dbo_cliente', 'dbo_cliente', 'x_BarrioCli', 'BarrioCli', '`BarrioCli`', '`BarrioCli`', 200, -1, FALSE, '`BarrioCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['BarrioCli'] = &$this->BarrioCli;

		// LocalidadCli
		$this->LocalidadCli = new cField('dbo_cliente', 'dbo_cliente', 'x_LocalidadCli', 'LocalidadCli', '`LocalidadCli`', '`LocalidadCli`', 200, -1, FALSE, '`LocalidadCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['LocalidadCli'] = &$this->LocalidadCli;

		// DescrProvincia
		$this->DescrProvincia = new cField('dbo_cliente', 'dbo_cliente', 'x_DescrProvincia', 'DescrProvincia', '`DescrProvincia`', '`DescrProvincia`', 200, -1, FALSE, '`DescrProvincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['DescrProvincia'] = &$this->DescrProvincia;

		// CodigoPostalCli
		$this->CodigoPostalCli = new cField('dbo_cliente', 'dbo_cliente', 'x_CodigoPostalCli', 'CodigoPostalCli', '`CodigoPostalCli`', '`CodigoPostalCli`', 200, -1, FALSE, '`CodigoPostalCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['CodigoPostalCli'] = &$this->CodigoPostalCli;

		// DescrPais
		$this->DescrPais = new cField('dbo_cliente', 'dbo_cliente', 'x_DescrPais', 'DescrPais', '`DescrPais`', '`DescrPais`', 200, -1, FALSE, '`DescrPais`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['DescrPais'] = &$this->DescrPais;

		// Telefono
		$this->Telefono = new cField('dbo_cliente', 'dbo_cliente', 'x_Telefono', 'Telefono', '`Telefono`', '`Telefono`', 200, -1, FALSE, '`Telefono`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Telefono'] = &$this->Telefono;

		// FaxCli
		$this->FaxCli = new cField('dbo_cliente', 'dbo_cliente', 'x_FaxCli', 'FaxCli', '`FaxCli`', '`FaxCli`', 200, -1, FALSE, '`FaxCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['FaxCli'] = &$this->FaxCli;

		// PaginaWebCli
		$this->PaginaWebCli = new cField('dbo_cliente', 'dbo_cliente', 'x_PaginaWebCli', 'PaginaWebCli', '`PaginaWebCli`', '`PaginaWebCli`', 200, -1, FALSE, '`PaginaWebCli`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['PaginaWebCli'] = &$this->PaginaWebCli;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`dbo_cliente`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`RazonSocialCli` ASC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
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
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
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
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`dbo_cliente`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('CodigoCli', $rs))
				ew_AddFilter($where, ew_QuotedName('CodigoCli') . '=' . ew_QuotedValue($rs['CodigoCli'], $this->CodigoCli->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`CodigoCli` = '@CodigoCli@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@CodigoCli@", ew_AdjustSql($this->CodigoCli->CurrentValue), $sKeyFilter); // Replace key value
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
			return $this->KeyUrl("dbo_clienteview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("dbo_clienteview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "dbo_clienteadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("dbo_clienteedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("dbo_clienteadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("dbo_clientedelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->CodigoCli->CurrentValue)) {
			$sUrl .= "CodigoCli=" . urlencode($this->CodigoCli->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
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
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["CodigoCli"]; // CodigoCli

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			$ar[] = $key;
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
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
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

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// CodigoCli
		// RazonSocialCli
		// CuitCli
		// IngBrutosCli
		// Regis_IvaC
		// Regis_ListaPrec
		// emailCli
		// RazonSocialFlete
		// Direccion
		// BarrioCli
		// LocalidadCli
		// DescrProvincia
		// CodigoPostalCli
		// DescrPais
		// Telefono
		// FaxCli
		// PaginaWebCli
		// CodigoCli

		$this->CodigoCli->ViewValue = $this->CodigoCli->CurrentValue;
		$this->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$this->RazonSocialCli->ViewValue = $this->RazonSocialCli->CurrentValue;
		$this->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$this->CuitCli->ViewValue = $this->CuitCli->CurrentValue;
		$this->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$this->IngBrutosCli->ViewValue = $this->IngBrutosCli->CurrentValue;
		$this->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		$this->Regis_IvaC->ViewValue = $this->Regis_IvaC->CurrentValue;
		$this->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$this->Regis_ListaPrec->ViewValue = $this->Regis_ListaPrec->CurrentValue;
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

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
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
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
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
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
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

		// Enter your code here
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

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
