<?php

// Global variable for table object
$remitosview = NULL;

//
// Table class for remitosview
//
class cremitosview extends cTable {
	var $Id_Remito;
	var $Cliente;
	var $Fecha;
	var $Proveedor;
	var $Transporte;
	var $OperadorTraslado;
	var $NumeroDeBultos;
	var $OperadorEntrego;
	var $OperadorVerifico;
	var $Observaciones;
	var $Importe;
	var $facturas;
	var $Id_RemitoDetalle;
	var $remitoCabecera;
	var $cantidad;
	var $descripcion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'remitosview';
		$this->TableName = 'remitosview';
		$this->TableType = 'VIEW';
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

		// Id_Remito
		$this->Id_Remito = new cField('remitosview', 'remitosview', 'x_Id_Remito', 'Id_Remito', '`Id_Remito`', '`Id_Remito`', 19, -1, FALSE, '`Id_Remito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_Remito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Remito'] = &$this->Id_Remito;

		// Cliente
		$this->Cliente = new cField('remitosview', 'remitosview', 'x_Cliente', 'Cliente', '`Cliente`', '`Cliente`', 200, -1, FALSE, '`Cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Cliente'] = &$this->Cliente;

		// Fecha
		$this->Fecha = new cField('remitosview', 'remitosview', 'x_Fecha', 'Fecha', '`Fecha`', 'DATE_FORMAT(`Fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`Fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Fecha'] = &$this->Fecha;

		// Proveedor
		$this->Proveedor = new cField('remitosview', 'remitosview', 'x_Proveedor', 'Proveedor', '`Proveedor`', '`Proveedor`', 3, -1, FALSE, '`Proveedor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Proveedor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Proveedor'] = &$this->Proveedor;

		// Transporte
		$this->Transporte = new cField('remitosview', 'remitosview', 'x_Transporte', 'Transporte', '`Transporte`', '`Transporte`', 3, -1, FALSE, '`Transporte`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Transporte->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Transporte'] = &$this->Transporte;

		// OperadorTraslado
		$this->OperadorTraslado = new cField('remitosview', 'remitosview', 'x_OperadorTraslado', 'OperadorTraslado', '`OperadorTraslado`', '`OperadorTraslado`', 3, -1, FALSE, '`OperadorTraslado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorTraslado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorTraslado'] = &$this->OperadorTraslado;

		// NumeroDeBultos
		$this->NumeroDeBultos = new cField('remitosview', 'remitosview', 'x_NumeroDeBultos', 'NumeroDeBultos', '`NumeroDeBultos`', '`NumeroDeBultos`', 3, -1, FALSE, '`NumeroDeBultos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->NumeroDeBultos->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['NumeroDeBultos'] = &$this->NumeroDeBultos;

		// OperadorEntrego
		$this->OperadorEntrego = new cField('remitosview', 'remitosview', 'x_OperadorEntrego', 'OperadorEntrego', '`OperadorEntrego`', '`OperadorEntrego`', 3, -1, FALSE, '`OperadorEntrego`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorEntrego->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorEntrego'] = &$this->OperadorEntrego;

		// OperadorVerifico
		$this->OperadorVerifico = new cField('remitosview', 'remitosview', 'x_OperadorVerifico', 'OperadorVerifico', '`OperadorVerifico`', '`OperadorVerifico`', 3, -1, FALSE, '`OperadorVerifico`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->OperadorVerifico->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OperadorVerifico'] = &$this->OperadorVerifico;

		// Observaciones
		$this->Observaciones = new cField('remitosview', 'remitosview', 'x_Observaciones', 'Observaciones', '`Observaciones`', '`Observaciones`', 200, -1, FALSE, '`Observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Observaciones'] = &$this->Observaciones;

		// Importe
		$this->Importe = new cField('remitosview', 'remitosview', 'x_Importe', 'Importe', '`Importe`', '`Importe`', 200, -1, FALSE, '`Importe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['Importe'] = &$this->Importe;

		// facturas
		$this->facturas = new cField('remitosview', 'remitosview', 'x_facturas', 'facturas', '`facturas`', '`facturas`', 200, -1, FALSE, '`facturas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['facturas'] = &$this->facturas;

		// Id_RemitoDetalle
		$this->Id_RemitoDetalle = new cField('remitosview', 'remitosview', 'x_Id_RemitoDetalle', 'Id_RemitoDetalle', '`Id_RemitoDetalle`', '`Id_RemitoDetalle`', 19, -1, FALSE, '`Id_RemitoDetalle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->Id_RemitoDetalle->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_RemitoDetalle'] = &$this->Id_RemitoDetalle;

		// remitoCabecera
		$this->remitoCabecera = new cField('remitosview', 'remitosview', 'x_remitoCabecera', 'remitoCabecera', '`remitoCabecera`', '`remitoCabecera`', 3, -1, FALSE, '`remitoCabecera`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->remitoCabecera->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['remitoCabecera'] = &$this->remitoCabecera;

		// cantidad
		$this->cantidad = new cField('remitosview', 'remitosview', 'x_cantidad', 'cantidad', '`cantidad`', '`cantidad`', 200, -1, FALSE, '`cantidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cantidad'] = &$this->cantidad;

		// descripcion
		$this->descripcion = new cField('remitosview', 'remitosview', 'x_descripcion', 'descripcion', '`descripcion`', '`descripcion`', 3, -1, FALSE, '`descripcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->descripcion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['descripcion'] = &$this->descripcion;
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
		return "`remitosview`";
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
		return "";
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
	var $UpdateTable = "`remitosview`";

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
			if (array_key_exists('Id_Remito', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_Remito') . '=' . ew_QuotedValue($rs['Id_Remito'], $this->Id_Remito->FldDataType));
			if (array_key_exists('Id_RemitoDetalle', $rs))
				ew_AddFilter($where, ew_QuotedName('Id_RemitoDetalle') . '=' . ew_QuotedValue($rs['Id_RemitoDetalle'], $this->Id_RemitoDetalle->FldDataType));
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
		return "`Id_Remito` = @Id_Remito@ AND `Id_RemitoDetalle` = @Id_RemitoDetalle@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Id_Remito->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_Remito@", ew_AdjustSql($this->Id_Remito->CurrentValue), $sKeyFilter); // Replace key value
		if (!is_numeric($this->Id_RemitoDetalle->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Id_RemitoDetalle@", ew_AdjustSql($this->Id_RemitoDetalle->CurrentValue), $sKeyFilter); // Replace key value
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
			return "remitosviewlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "remitosviewlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("remitosviewview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("remitosviewview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "remitosviewadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("remitosviewedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("remitosviewadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("remitosviewdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Id_Remito->CurrentValue)) {
			$sUrl .= "Id_Remito=" . urlencode($this->Id_Remito->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->Id_RemitoDetalle->CurrentValue)) {
			$sUrl .= "&Id_RemitoDetalle=" . urlencode($this->Id_RemitoDetalle->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET)) {
			$arKey[] = @$_GET["Id_Remito"]; // Id_Remito
			$arKey[] = @$_GET["Id_RemitoDetalle"]; // Id_RemitoDetalle
			$arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_array($key) || count($key) <> 2)
				continue; // Just skip so other keys will still work
			if (!is_numeric($key[0])) // Id_Remito
				continue;
			if (!is_numeric($key[1])) // Id_RemitoDetalle
				continue;
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
			$this->Id_Remito->CurrentValue = $key[0];
			$this->Id_RemitoDetalle->CurrentValue = $key[1];
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
		$this->Id_Remito->setDbValue($rs->fields('Id_Remito'));
		$this->Cliente->setDbValue($rs->fields('Cliente'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Proveedor->setDbValue($rs->fields('Proveedor'));
		$this->Transporte->setDbValue($rs->fields('Transporte'));
		$this->OperadorTraslado->setDbValue($rs->fields('OperadorTraslado'));
		$this->NumeroDeBultos->setDbValue($rs->fields('NumeroDeBultos'));
		$this->OperadorEntrego->setDbValue($rs->fields('OperadorEntrego'));
		$this->OperadorVerifico->setDbValue($rs->fields('OperadorVerifico'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Importe->setDbValue($rs->fields('Importe'));
		$this->facturas->setDbValue($rs->fields('facturas'));
		$this->Id_RemitoDetalle->setDbValue($rs->fields('Id_RemitoDetalle'));
		$this->remitoCabecera->setDbValue($rs->fields('remitoCabecera'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Id_Remito
		// Cliente
		// Fecha
		// Proveedor
		// Transporte
		// OperadorTraslado
		// NumeroDeBultos
		// OperadorEntrego
		// OperadorVerifico
		// Observaciones
		// Importe
		// facturas
		// Id_RemitoDetalle
		// remitoCabecera
		// cantidad
		// descripcion
		// Id_Remito

		$this->Id_Remito->ViewValue = $this->Id_Remito->CurrentValue;
		$this->Id_Remito->ViewCustomAttributes = "";

		// Cliente
		if (strval($this->Cliente->CurrentValue) <> "") {
			$sFilterWrk = "`CodigoCli`" . ew_SearchString("=", $this->Cliente->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `CodigoCli`, `RazonSocialCli` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `dbo_cliente`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Cliente, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `RazonSocialCli` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Cliente->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Cliente->ViewValue = $this->Cliente->CurrentValue;
			}
		} else {
			$this->Cliente->ViewValue = NULL;
		}
		$this->Cliente->ViewCustomAttributes = "";

		// Fecha
		$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
		$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
		$this->Fecha->ViewCustomAttributes = "";

		// Proveedor
		if (strval($this->Proveedor->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Proveedores`" . ew_SearchString("=", $this->Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Proveedores`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Proveedor, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `razonSocial` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Proveedor->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Proveedor->ViewValue = $this->Proveedor->CurrentValue;
			}
		} else {
			$this->Proveedor->ViewValue = NULL;
		}
		$this->Proveedor->ViewCustomAttributes = "";

		// Transporte
		if (strval($this->Transporte->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Transporte`" . ew_SearchString("=", $this->Transporte->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Transporte`, `razonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `transporte`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->Transporte, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `razonSocial` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->Transporte->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->Transporte->ViewValue = $this->Transporte->CurrentValue;
			}
		} else {
			$this->Transporte->ViewValue = NULL;
		}
		$this->Transporte->ViewCustomAttributes = "";

		// OperadorTraslado
		if (strval($this->OperadorTraslado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorTraslado->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->OperadorTraslado, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->OperadorTraslado->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->OperadorTraslado->ViewValue = $this->OperadorTraslado->CurrentValue;
			}
		} else {
			$this->OperadorTraslado->ViewValue = NULL;
		}
		$this->OperadorTraslado->ViewCustomAttributes = "";

		// NumeroDeBultos
		$this->NumeroDeBultos->ViewValue = $this->NumeroDeBultos->CurrentValue;
		$this->NumeroDeBultos->ViewCustomAttributes = "";

		// OperadorEntrego
		if (strval($this->OperadorEntrego->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorEntrego->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->OperadorEntrego, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->OperadorEntrego->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->OperadorEntrego->ViewValue = $this->OperadorEntrego->CurrentValue;
			}
		} else {
			$this->OperadorEntrego->ViewValue = NULL;
		}
		$this->OperadorEntrego->ViewCustomAttributes = "";

		// OperadorVerifico
		if (strval($this->OperadorVerifico->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Operadores`" . ew_SearchString("=", $this->OperadorVerifico->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Operadores`, `nombreOperadores` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `operadores`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->OperadorVerifico, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombreOperadores` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->OperadorVerifico->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->OperadorVerifico->ViewValue = $this->OperadorVerifico->CurrentValue;
			}
		} else {
			$this->OperadorVerifico->ViewValue = NULL;
		}
		$this->OperadorVerifico->ViewCustomAttributes = "";

		// Observaciones
		$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
		$this->Observaciones->ViewCustomAttributes = "";

		// Importe
		$this->Importe->ViewValue = $this->Importe->CurrentValue;
		$this->Importe->ViewCustomAttributes = "";

		// facturas
		$this->facturas->ViewValue = $this->facturas->CurrentValue;
		$this->facturas->ViewCustomAttributes = "";

		// Id_RemitoDetalle
		$this->Id_RemitoDetalle->ViewValue = $this->Id_RemitoDetalle->CurrentValue;
		$this->Id_RemitoDetalle->ViewCustomAttributes = "";

		// remitoCabecera
		$this->remitoCabecera->ViewValue = $this->remitoCabecera->CurrentValue;
		$this->remitoCabecera->ViewCustomAttributes = "";

		// cantidad
		$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
		$this->cantidad->ViewCustomAttributes = "";

		// descripcion
		if (strval($this->descripcion->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Productos`" . ew_SearchString("=", $this->descripcion->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `Id_Productos`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `productos`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->descripcion, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `denominacion` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->descripcion->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
			}
		} else {
			$this->descripcion->ViewValue = NULL;
		}
		$this->descripcion->ViewCustomAttributes = "";

		// Id_Remito
		$this->Id_Remito->LinkCustomAttributes = "";
		$this->Id_Remito->HrefValue = "";
		$this->Id_Remito->TooltipValue = "";

		// Cliente
		$this->Cliente->LinkCustomAttributes = "";
		$this->Cliente->HrefValue = "";
		$this->Cliente->TooltipValue = "";

		// Fecha
		$this->Fecha->LinkCustomAttributes = "";
		$this->Fecha->HrefValue = "";
		$this->Fecha->TooltipValue = "";

		// Proveedor
		$this->Proveedor->LinkCustomAttributes = "";
		$this->Proveedor->HrefValue = "";
		$this->Proveedor->TooltipValue = "";

		// Transporte
		$this->Transporte->LinkCustomAttributes = "";
		$this->Transporte->HrefValue = "";
		$this->Transporte->TooltipValue = "";

		// OperadorTraslado
		$this->OperadorTraslado->LinkCustomAttributes = "";
		$this->OperadorTraslado->HrefValue = "";
		$this->OperadorTraslado->TooltipValue = "";

		// NumeroDeBultos
		$this->NumeroDeBultos->LinkCustomAttributes = "";
		$this->NumeroDeBultos->HrefValue = "";
		$this->NumeroDeBultos->TooltipValue = "";

		// OperadorEntrego
		$this->OperadorEntrego->LinkCustomAttributes = "";
		$this->OperadorEntrego->HrefValue = "";
		$this->OperadorEntrego->TooltipValue = "";

		// OperadorVerifico
		$this->OperadorVerifico->LinkCustomAttributes = "";
		$this->OperadorVerifico->HrefValue = "";
		$this->OperadorVerifico->TooltipValue = "";

		// Observaciones
		$this->Observaciones->LinkCustomAttributes = "";
		$this->Observaciones->HrefValue = "";
		$this->Observaciones->TooltipValue = "";

		// Importe
		$this->Importe->LinkCustomAttributes = "";
		$this->Importe->HrefValue = "";
		$this->Importe->TooltipValue = "";

		// facturas
		$this->facturas->LinkCustomAttributes = "";
		$this->facturas->HrefValue = "";
		$this->facturas->TooltipValue = "";

		// Id_RemitoDetalle
		$this->Id_RemitoDetalle->LinkCustomAttributes = "";
		$this->Id_RemitoDetalle->HrefValue = "";
		$this->Id_RemitoDetalle->TooltipValue = "";

		// remitoCabecera
		$this->remitoCabecera->LinkCustomAttributes = "";
		$this->remitoCabecera->HrefValue = "";
		$this->remitoCabecera->TooltipValue = "";

		// cantidad
		$this->cantidad->LinkCustomAttributes = "";
		$this->cantidad->HrefValue = "";
		$this->cantidad->TooltipValue = "";

		// descripcion
		$this->descripcion->LinkCustomAttributes = "";
		$this->descripcion->HrefValue = "";
		$this->descripcion->TooltipValue = "";

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
				if ($this->Id_Remito->Exportable) $Doc->ExportCaption($this->Id_Remito);
				if ($this->Cliente->Exportable) $Doc->ExportCaption($this->Cliente);
				if ($this->Fecha->Exportable) $Doc->ExportCaption($this->Fecha);
				if ($this->Proveedor->Exportable) $Doc->ExportCaption($this->Proveedor);
				if ($this->Transporte->Exportable) $Doc->ExportCaption($this->Transporte);
				if ($this->OperadorTraslado->Exportable) $Doc->ExportCaption($this->OperadorTraslado);
				if ($this->NumeroDeBultos->Exportable) $Doc->ExportCaption($this->NumeroDeBultos);
				if ($this->OperadorEntrego->Exportable) $Doc->ExportCaption($this->OperadorEntrego);
				if ($this->OperadorVerifico->Exportable) $Doc->ExportCaption($this->OperadorVerifico);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->Importe->Exportable) $Doc->ExportCaption($this->Importe);
				if ($this->facturas->Exportable) $Doc->ExportCaption($this->facturas);
				if ($this->Id_RemitoDetalle->Exportable) $Doc->ExportCaption($this->Id_RemitoDetalle);
				if ($this->remitoCabecera->Exportable) $Doc->ExportCaption($this->remitoCabecera);
				if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
				if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
			} else {
				if ($this->Id_Remito->Exportable) $Doc->ExportCaption($this->Id_Remito);
				if ($this->Cliente->Exportable) $Doc->ExportCaption($this->Cliente);
				if ($this->Fecha->Exportable) $Doc->ExportCaption($this->Fecha);
				if ($this->Proveedor->Exportable) $Doc->ExportCaption($this->Proveedor);
				if ($this->Transporte->Exportable) $Doc->ExportCaption($this->Transporte);
				if ($this->OperadorTraslado->Exportable) $Doc->ExportCaption($this->OperadorTraslado);
				if ($this->NumeroDeBultos->Exportable) $Doc->ExportCaption($this->NumeroDeBultos);
				if ($this->OperadorEntrego->Exportable) $Doc->ExportCaption($this->OperadorEntrego);
				if ($this->OperadorVerifico->Exportable) $Doc->ExportCaption($this->OperadorVerifico);
				if ($this->Observaciones->Exportable) $Doc->ExportCaption($this->Observaciones);
				if ($this->Importe->Exportable) $Doc->ExportCaption($this->Importe);
				if ($this->facturas->Exportable) $Doc->ExportCaption($this->facturas);
				if ($this->Id_RemitoDetalle->Exportable) $Doc->ExportCaption($this->Id_RemitoDetalle);
				if ($this->remitoCabecera->Exportable) $Doc->ExportCaption($this->remitoCabecera);
				if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
				if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
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
					if ($this->Id_Remito->Exportable) $Doc->ExportField($this->Id_Remito);
					if ($this->Cliente->Exportable) $Doc->ExportField($this->Cliente);
					if ($this->Fecha->Exportable) $Doc->ExportField($this->Fecha);
					if ($this->Proveedor->Exportable) $Doc->ExportField($this->Proveedor);
					if ($this->Transporte->Exportable) $Doc->ExportField($this->Transporte);
					if ($this->OperadorTraslado->Exportable) $Doc->ExportField($this->OperadorTraslado);
					if ($this->NumeroDeBultos->Exportable) $Doc->ExportField($this->NumeroDeBultos);
					if ($this->OperadorEntrego->Exportable) $Doc->ExportField($this->OperadorEntrego);
					if ($this->OperadorVerifico->Exportable) $Doc->ExportField($this->OperadorVerifico);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->Importe->Exportable) $Doc->ExportField($this->Importe);
					if ($this->facturas->Exportable) $Doc->ExportField($this->facturas);
					if ($this->Id_RemitoDetalle->Exportable) $Doc->ExportField($this->Id_RemitoDetalle);
					if ($this->remitoCabecera->Exportable) $Doc->ExportField($this->remitoCabecera);
					if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
					if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
				} else {
					if ($this->Id_Remito->Exportable) $Doc->ExportField($this->Id_Remito);
					if ($this->Cliente->Exportable) $Doc->ExportField($this->Cliente);
					if ($this->Fecha->Exportable) $Doc->ExportField($this->Fecha);
					if ($this->Proveedor->Exportable) $Doc->ExportField($this->Proveedor);
					if ($this->Transporte->Exportable) $Doc->ExportField($this->Transporte);
					if ($this->OperadorTraslado->Exportable) $Doc->ExportField($this->OperadorTraslado);
					if ($this->NumeroDeBultos->Exportable) $Doc->ExportField($this->NumeroDeBultos);
					if ($this->OperadorEntrego->Exportable) $Doc->ExportField($this->OperadorEntrego);
					if ($this->OperadorVerifico->Exportable) $Doc->ExportField($this->OperadorVerifico);
					if ($this->Observaciones->Exportable) $Doc->ExportField($this->Observaciones);
					if ($this->Importe->Exportable) $Doc->ExportField($this->Importe);
					if ($this->facturas->Exportable) $Doc->ExportField($this->facturas);
					if ($this->Id_RemitoDetalle->Exportable) $Doc->ExportField($this->Id_RemitoDetalle);
					if ($this->remitoCabecera->Exportable) $Doc->ExportField($this->remitoCabecera);
					if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
					if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
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
