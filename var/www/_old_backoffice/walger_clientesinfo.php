<?php

// PHPMaker 5 configuration for Table walger_clientes
$walger_clientes = new cwalger_clientes; // Initialize table object

// Define table class
class cwalger_clientes {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $CodigoCli;
	var $Contrasenia;
	var $IP;
	var $UltimoLogin;
	var $Habilitado;
	var $TipoCliente;
	var $Regis_Mda;
	var $ApellidoNombre;
	var $Cargo;
	var $Comentarios;
	var $fields = array();

	function cwalger_clientes() {
		$this->TableVar = "walger_clientes";
		$this->TableName = "walger_clientes";
		$this->SelectLimit = TRUE;
		$this->CodigoCli = new cField('walger_clientes', 'x_CodigoCli', 'CodigoCli', "`CodigoCli`", 200, -1, FALSE);
		$this->fields['CodigoCli'] =& $this->CodigoCli;
		$this->Contrasenia = new cField('walger_clientes', 'x_Contrasenia', 'Contrasenia', "`Contrasenia`", 200, -1, FALSE);
		$this->fields['Contrasenia'] =& $this->Contrasenia;
		$this->IP = new cField('walger_clientes', 'x_IP', 'IP', "`IP`", 200, -1, FALSE);
		$this->fields['IP'] =& $this->IP;
		$this->UltimoLogin = new cField('walger_clientes', 'x_UltimoLogin', 'UltimoLogin', "`UltimoLogin`", 135, 7, FALSE);
		$this->fields['UltimoLogin'] =& $this->UltimoLogin;
		$this->Habilitado = new cField('walger_clientes', 'x_Habilitado', 'Habilitado', "`Habilitado`", 200, -1, FALSE);
		$this->fields['Habilitado'] =& $this->Habilitado;
		$this->TipoCliente = new cField('walger_clientes', 'x_TipoCliente', 'TipoCliente', "`TipoCliente`", 200, -1, FALSE);
		$this->fields['TipoCliente'] =& $this->TipoCliente;
		$this->Regis_Mda = new cField('walger_clientes', 'x_Regis_Mda', 'Regis_Mda', "`Regis_Mda`", 3, -1, FALSE);
		$this->fields['Regis_Mda'] =& $this->Regis_Mda;
		$this->ApellidoNombre = new cField('walger_clientes', 'x_ApellidoNombre', 'ApellidoNombre', "`ApellidoNombre`", 200, -1, FALSE);
		$this->fields['ApellidoNombre'] =& $this->ApellidoNombre;
		$this->Cargo = new cField('walger_clientes', 'x_Cargo', 'Cargo', "`Cargo`", 200, -1, FALSE);
		$this->fields['Cargo'] =& $this->Cargo;
		$this->Comentarios = new cField('walger_clientes', 'x_Comentarios', 'Comentarios', "`Comentarios`", 201, -1, FALSE);
		$this->fields['Comentarios'] =& $this->Comentarios;
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
		return "SELECT * FROM `walger_clientes`";
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
		return "INSERT INTO `walger_clientes` ($names) VALUES ($values)";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `walger_clientes` SET ";
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
		$SQL = "DELETE FROM `walger_clientes` WHERE ";
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
			return "walger_clienteslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("walger_clientesview.php");
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("walger_clientesedit.php");
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl("walger_clienteslist.php", "a=edit");
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("walger_clientesadd.php");
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl("walger_clienteslist.php", "a=copy");
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("walger_clientesdelete.php");
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
		$this->Contrasenia->setDbValue($rs->fields('Contrasenia'));
		$this->IP->setDbValue($rs->fields('IP'));
		$this->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
		$this->Habilitado->setDbValue($rs->fields('Habilitado'));
		$this->TipoCliente->setDbValue($rs->fields('TipoCliente'));
		$this->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
		$this->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
		$this->Cargo->setDbValue($rs->fields('Cargo'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// CodigoCli
		if (!is_null($this->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($this->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` Asc";
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

		// Contrasenia
		$this->Contrasenia->ViewValue = $this->Contrasenia->CurrentValue;
		$this->Contrasenia->CssStyle = "";
		$this->Contrasenia->CssClass = "";
		$this->Contrasenia->ViewCustomAttributes = "";

		// IP
		$this->IP->ViewValue = $this->IP->CurrentValue;
		$this->IP->CssStyle = "";
		$this->IP->CssClass = "";
		$this->IP->ViewCustomAttributes = "";

		// UltimoLogin
		$this->UltimoLogin->ViewValue = $this->UltimoLogin->CurrentValue;
		$this->UltimoLogin->ViewValue = ew_FormatDateTime($this->UltimoLogin->ViewValue, 7);
		$this->UltimoLogin->CssStyle = "";
		$this->UltimoLogin->CssClass = "";
		$this->UltimoLogin->ViewCustomAttributes = "";

		// Habilitado
		if (!is_null($this->Habilitado->CurrentValue)) {
			switch ($this->Habilitado->CurrentValue) {
				case "S":
					$this->Habilitado->ViewValue = "Si";
					break;
				case "N":
					$this->Habilitado->ViewValue = "No";
					break;
				default:
					$this->Habilitado->ViewValue = $this->Habilitado->CurrentValue;
			}
		} else {
			$this->Habilitado->ViewValue = NULL;
		}
		$this->Habilitado->CssStyle = "";
		$this->Habilitado->CssClass = "";
		$this->Habilitado->ViewCustomAttributes = "";

		// TipoCliente
		if (!is_null($this->TipoCliente->CurrentValue)) {
			switch ($this->TipoCliente->CurrentValue) {
				case "Consumidor Final":
					$this->TipoCliente->ViewValue = "Consumidor Final";
					break;
				case "Casa de Repuestos":
					$this->TipoCliente->ViewValue = "Casa de Repuestos";
					break;
				case "Distribuidor":
					$this->TipoCliente->ViewValue = "Distribuidor";
					break;
				default:
					$this->TipoCliente->ViewValue = $this->TipoCliente->CurrentValue;
			}
		} else {
			$this->TipoCliente->ViewValue = NULL;
		}
		$this->TipoCliente->CssStyle = "";
		$this->TipoCliente->CssClass = "";
		$this->TipoCliente->ViewCustomAttributes = "";

		// Regis_Mda
		if (!is_null($this->Regis_Mda->CurrentValue)) {
			$sSqlWrk = "SELECT `CodigoAFIP_Mda`, `Signo_Mda` FROM `dbo_moneda` WHERE `Regis_Mda` = " . ew_AdjustSql($this->Regis_Mda->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `CodigoAFIP_Mda` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$this->Regis_Mda->ViewValue = $rswrk->fields('CodigoAFIP_Mda');
					$this->Regis_Mda->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('Signo_Mda');
				}
				$rswrk->Close();
			} else {
				$this->Regis_Mda->ViewValue = $this->Regis_Mda->CurrentValue;
			}
		} else {
			$this->Regis_Mda->ViewValue = NULL;
		}
		$this->Regis_Mda->CssStyle = "";
		$this->Regis_Mda->CssClass = "";
		$this->Regis_Mda->ViewCustomAttributes = "";

		// ApellidoNombre
		$this->ApellidoNombre->ViewValue = $this->ApellidoNombre->CurrentValue;
		$this->ApellidoNombre->CssStyle = "";
		$this->ApellidoNombre->CssClass = "";
		$this->ApellidoNombre->ViewCustomAttributes = "";

		// Cargo
		$this->Cargo->ViewValue = $this->Cargo->CurrentValue;
		$this->Cargo->CssStyle = "";
		$this->Cargo->CssClass = "";
		$this->Cargo->ViewCustomAttributes = "";

		// CodigoCli
		$this->CodigoCli->HrefValue = "";

		// Contrasenia
		$this->Contrasenia->HrefValue = "";

		// IP
		$this->IP->HrefValue = "";

		// UltimoLogin
		$this->UltimoLogin->HrefValue = "";

		// Habilitado
		$this->Habilitado->HrefValue = "";

		// TipoCliente
		$this->TipoCliente->HrefValue = "";

		// Regis_Mda
		$this->Regis_Mda->HrefValue = "";

		// ApellidoNombre
		$this->ApellidoNombre->HrefValue = "";

		// Cargo
		$this->Cargo->HrefValue = "";
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
	include_once("../inc/funciones.php");
	    //echo "Row Inserted";
	  if ($rs ["Habilitado"] == "S") {
	    $remitenteNombre = "Walger - Tienda Virtual";
	    $remitenteEMail = "administracionventas@walger.com.ar";

	    //$remitenteEMail = "yo@federicopfaffendorf.com.ar";
	    $UN_SALTO = "\r\n";
	    $DOS_SALTOS = "\r\n\r\n";
	    $separador = "_separador_de_trozos_".md5 (uniqid (rand()));
	    $cabecera = "Date: ".date("l j F Y, G:i").$UN_SALTO;
	    $cabecera .= "MIME-Version: 1.0".$UN_SALTO;
	    $cabecera .= "From: ".$remitenteNombre."<".$remitenteEMail.">".$UN_SALTO;
	    $cabecera .= "Return-path: ". $remitenteEMail.$UN_SALTO;
	    $cabecera .= "Reply-To: ".$remitenteEMail.$UN_SALTO;
	    $cabecera .= "X-Mailer: PHP/". phpversion().$UN_SALTO;
	    $cabecera .= "Content-Type: text/html; charset=\"iso-8859-1\"".$UN_SALTO;
	    $q = "SELECT * FROM dbo_cliente WHERE CodigoCli = '".$rs ["CodigoCli"]."'";
	    $q = mysql_query ($q);
	    $f = mysql_fetch_array ($q);
	    $destinatario = $f ["emailCli"];
	    
	    $titulo = "WALGER TIENDA VIRTUAL ==> Usuario habilitado para operar.";

			$mensaje = "Sr/es. ".$rs ["ApellidoNombre"]."<br />
<br />
Le damos la Bienvenida a Walger SRL<br />
<br />
Le informamos que su usuario ya esta habilitado para operar en nuestra Tienda Virtual.<br />
<br />
Su usuario: ".$f ["emailCli"]."<br />
Su contraseña: ".$rs ["Contrasenia"]."<br />
<br />
A partir de ahora Ud. podrá acceder a nuestro carrito de pedidos, cualquier producto cargado a su pedido permanecerá en él hasta que sea confirmado por Ud. así podrá antes de ese proceso, realizar modificaciones sobre los ítems pedidos. Todos los pedidos permanecerán en un historial para que ud pueda repetirlos cuantas veces lo desee.<br />
<br />
Un Carrito de Pedidos no es una compra confirmada. Los pedidos se procesarán por orden de llegada, y su ejecutivo de cuenta se comunicará con Ud. para confirmar la orden o bien, podrá verificar el estado de su pedido on line.<br />
<br />
También Ud. podrá acceder al área de descarga donde podrá descargar la lista de precios actualizada cuando lo desee y realizar cualquier tipo de consulta a través del botón Consultar las 24hs del día. <br />
<br />
Disfrute a partir de ahora su acceso a nuestra Tienda Virtual en http://walger.com.ar y desde ya agradecemos su registración.
<br />
Cualquier consulta no dude en comunicarse con nosotros.<br />
<br />
WALGER SRL<br />
Hidalgo 1736 – Capital Federal<br />
Te: (54-11) 4854-0360 (Líneas Rotativas)<br />
ventas@walger.com.ar<br />
http://www.walger.com.ar<br />
";

	    enviarEmail ($destinatario, $titulo, $mensaje);
	  }

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

include_once("../inc/funciones.php");

  if ($rsnew ["Habilitado"] == "S") {

    $remitenteNombre = "Walger - Tienda Virtual";
    $remitenteEMail = "administracionventas@walger.com.ar";
    //$remitenteEMail = "yo@federicopfaffendorf.com.ar";

    $UN_SALTO = "\r\n";
    $DOS_SALTOS = "\r\n\r\n";

    $separador = "_separador_de_trozos_".md5 (uniqid (rand()));

    $cabecera = "Date: ".date("l j F Y, G:i").$UN_SALTO;
    $cabecera .= "MIME-Version: 1.0".$UN_SALTO;
    $cabecera .= "From: ".$remitenteNombre."<".$remitenteEMail.">".$UN_SALTO;
    $cabecera .= "Return-path: ". $remitenteEMail.$UN_SALTO;
    $cabecera .= "Reply-To: ".$remitenteEMail.$UN_SALTO;
    $cabecera .= "X-Mailer: PHP/". phpversion().$UN_SALTO;
    $cabecera .= "Content-Type: text/html; charset=\"iso-8859-1\"".$UN_SALTO;

    $q = "SELECT * FROM dbo_cliente WHERE CodigoCli = '".$rsold ["CodigoCli"]."'";
    $q = mysql_query ($q);
    $f = mysql_fetch_array ($q);

    $destinatario = $f ["emailCli"];
    $titulo = "WALGER TIENDA VIRTUAL ==> Usuario habilitado para operar.";

			$mensaje = "Sr/es. ".$rsnew ["ApellidoNombre"]."<br />
<br />
Le damos la Bienvenida a Walger SRL<br />
<br />
Le informamos que su usuario ya esta habilitado para operar en nuestra Tienda Virtual.<br />
<br />
Su usuario: ".$f ["emailCli"]."<br />
Su contraseña: ".$rsnew ["Contrasenia"]."<br />
<br />
A partir de ahora Ud. podrá acceder a nuestro carrito de pedidos, cualquier producto cargado a su pedido permanecerá en él hasta que sea confirmado por Ud. así podrá antes de ese proceso, realizar modificaciones sobre los ítems pedidos. Todos los pedidos permanecerán en un historial para que ud pueda repetirlos cuantas veces lo desee.<br />
<br />
Un Carrito de Pedidos no es una compra confirmada. Los pedidos se procesarán por orden de llegada, y su ejecutivo de cuenta se comunicará con Ud. para confirmar la orden o bien, podrá verificar el estado de su pedido on line.<br />
<br />
También Ud. podrá acceder al área de descarga donde podrá descargar la lista de precios actualizada cuando lo desee y realizar cualquier tipo de consulta a través del botón Consultar las 24hs del día. <br />
<br />
Disfrute a partir de ahora su acceso a nuestra Tienda Virtual en http://walger.com.ar y desde ya agradecemos su registración.
<br />
Cualquier consulta no dude en comunicarse con nosotros.<br />
<br />
WALGER SRL<br />
Hidalgo 1736 – Capital Federal<br />
Te: (54-11) 4854-0360 (Líneas Rotativas)<br />
ventas@walger.com.ar<br />
http://www.walger.com.ar<br />
";

enviarEmail ($destinatario, $titulo, $mensaje); 
//    mail($destinatario, $titulo, $mensaje, $cabecera);

  }

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
