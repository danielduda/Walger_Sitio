<?php

// PHPMaker 5 configuration for Table dbo_articulo
$dbo_articulo = new cdbo_articulo; // Initialize table object

// Define table class
class cdbo_articulo {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $CodInternoArti;
	var $CodBarraArti;
	var $DescrNivelInt4;
	var $DescrNivelInt3;
	var $DescrNivelInt2;
	var $TasaIva;
	var $PrecioVta1_PreArti;
	var $DescripcionArti;
	var $NombreFotoArti;
	var $Stock1_StkArti;
	var $fields = array();

	function cdbo_articulo() {
		$this->TableVar = "dbo_articulo";
		$this->TableName = "dbo_articulo";
		$this->SelectLimit = TRUE;
		$this->CodInternoArti = new cField('dbo_articulo', 'x_CodInternoArti', 'CodInternoArti', "`CodInternoArti`", 200, -1, FALSE);
		$this->fields['CodInternoArti'] =& $this->CodInternoArti;
		$this->CodBarraArti = new cField('dbo_articulo', 'x_CodBarraArti', 'CodBarraArti', "`CodBarraArti`", 200, -1, FALSE);
		$this->fields['CodBarraArti'] =& $this->CodBarraArti;
		$this->DescrNivelInt4 = new cField('dbo_articulo', 'x_DescrNivelInt4', 'DescrNivelInt4', "`DescrNivelInt4`", 200, -1, FALSE);
		$this->fields['DescrNivelInt4'] =& $this->DescrNivelInt4;
		$this->DescrNivelInt3 = new cField('dbo_articulo', 'x_DescrNivelInt3', 'DescrNivelInt3', "`DescrNivelInt3`", 200, -1, FALSE);
		$this->fields['DescrNivelInt3'] =& $this->DescrNivelInt3;
		$this->DescrNivelInt2 = new cField('dbo_articulo', 'x_DescrNivelInt2', 'DescrNivelInt2', "`DescrNivelInt2`", 200, -1, FALSE);
		$this->fields['DescrNivelInt2'] =& $this->DescrNivelInt2;
		$this->TasaIva = new cField('dbo_articulo', 'x_TasaIva', 'TasaIva', "`TasaIva`", 4, -1, FALSE);
		$this->fields['TasaIva'] =& $this->TasaIva;
		$this->PrecioVta1_PreArti = new cField('dbo_articulo', 'x_PrecioVta1_PreArti', 'PrecioVta1_PreArti', "`PrecioVta1_PreArti`", 4, -1, FALSE);
		$this->fields['PrecioVta1_PreArti'] =& $this->PrecioVta1_PreArti;
		$this->DescripcionArti = new cField('dbo_articulo', 'x_DescripcionArti', 'DescripcionArti', "`DescripcionArti`", 200, -1, FALSE);
		$this->fields['DescripcionArti'] =& $this->DescripcionArti;
		$this->NombreFotoArti = new cField('dbo_articulo', 'x_NombreFotoArti', 'NombreFotoArti', "`NombreFotoArti`", 200, -1, FALSE);
		$this->fields['NombreFotoArti'] =& $this->NombreFotoArti;
		$this->Stock1_StkArti = new cField('dbo_articulo', 'x_Stock1_StkArti', 'Stock1_StkArti', "`Stock1_StkArti`", 4, -1, FALSE);
		$this->fields['Stock1_StkArti'] =& $this->Stock1_StkArti;
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
		return "SELECT * FROM `dbo_articulo`";
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
		return "INSERT INTO `dbo_articulo` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `dbo_articulo` SET ";
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
		$SQL = "DELETE FROM `dbo_articulo` WHERE ";
		$SQL .= EW_DB_QUOTE_START . 'CodInternoArti' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['CodInternoArti'], $this->CodInternoArti->FldDataType) . ' AND ';
		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`CodInternoArti` = '@CodInternoArti@'";
	}

	// Return url
	function getReturnUrl() {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "dbo_articulolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("dbo_articuloview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("dbo_articuloedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("dbo_articulolist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("dbo_articuloadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("dbo_articulolist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("dbo_articulodelete.php");
	}

	// Key url
	function KeyUrl($url, $action = "") {
		$sUrl = $url . "?";
		if ($action <> "") $sUrl .= $action . "&";
		if (!is_null($this->CodInternoArti->CurrentValue)) {
			$sUrl .= "CodInternoArti=" . urlencode($this->CodInternoArti->CurrentValue);
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
		$this->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
		$this->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
		$this->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
		$this->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
		$this->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
		$this->TasaIva->setDbValue($rs->fields('TasaIva'));
		$this->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
		$this->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
		$this->NombreFotoArti->setDbValue($rs->fields('NombreFotoArti'));
		$this->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// CodInternoArti
		$this->CodInternoArti->ViewValue = $this->CodInternoArti->CurrentValue;
		$this->CodInternoArti->CssStyle = "";
		$this->CodInternoArti->CssClass = "";
		$this->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$this->CodBarraArti->ViewValue = $this->CodBarraArti->CurrentValue;
		$this->CodBarraArti->CssStyle = "";
		$this->CodBarraArti->CssClass = "";
		$this->CodBarraArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->ViewValue = $this->DescrNivelInt4->CurrentValue;
		$this->DescrNivelInt4->CssStyle = "";
		$this->DescrNivelInt4->CssClass = "";
		$this->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->ViewValue = $this->DescrNivelInt3->CurrentValue;
		$this->DescrNivelInt3->CssStyle = "";
		$this->DescrNivelInt3->CssClass = "";
		$this->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->ViewValue = $this->DescrNivelInt2->CurrentValue;
		$this->DescrNivelInt2->CssStyle = "";
		$this->DescrNivelInt2->CssClass = "";
		$this->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$this->TasaIva->ViewValue = $this->TasaIva->CurrentValue;
		$this->TasaIva->CssStyle = "";
		$this->TasaIva->CssClass = "";
		$this->TasaIva->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->ViewValue = $this->PrecioVta1_PreArti->CurrentValue;
		$this->PrecioVta1_PreArti->CssStyle = "";
		$this->PrecioVta1_PreArti->CssClass = "";
		$this->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// DescripcionArti
		$this->DescripcionArti->ViewValue = $this->DescripcionArti->CurrentValue;
		$this->DescripcionArti->CssStyle = "";
		$this->DescripcionArti->CssClass = "";
		$this->DescripcionArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$this->NombreFotoArti->ViewValue = $this->NombreFotoArti->CurrentValue;
		$this->NombreFotoArti->CssStyle = "";
		$this->NombreFotoArti->CssClass = "";
		$this->NombreFotoArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->ViewValue = $this->Stock1_StkArti->CurrentValue;
		$this->Stock1_StkArti->CssStyle = "";
		$this->Stock1_StkArti->CssClass = "";
		$this->Stock1_StkArti->ViewCustomAttributes = "";

		// CodInternoArti
		$this->CodInternoArti->HrefValue = "";

		// CodBarraArti
		$this->CodBarraArti->HrefValue = "";

		// DescrNivelInt4
		$this->DescrNivelInt4->HrefValue = "";

		// DescrNivelInt3
		$this->DescrNivelInt3->HrefValue = "";

		// DescrNivelInt2
		$this->DescrNivelInt2->HrefValue = "";

		// TasaIva
		$this->TasaIva->HrefValue = "";

		// PrecioVta1_PreArti
		$this->PrecioVta1_PreArti->HrefValue = "";

		// DescripcionArti
		$this->DescripcionArti->HrefValue = "";

		// NombreFotoArti
		$this->NombreFotoArti->HrefValue = "";

		// Stock1_StkArti
		$this->Stock1_StkArti->HrefValue = "";
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
