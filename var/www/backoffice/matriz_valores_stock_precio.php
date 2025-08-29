<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "walger_usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$matriz_valores_stock_precio_php = NULL; // Initialize page object first

class cmatriz_valores_stock_precio_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'matriz_valores_stock_precio.php';

	// Page object name
	var $PageObjName = 'matriz_valores_stock_precio_php';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'matriz_valores_stock_precio.php', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// User table object (walger_usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cwalger_usuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		 // Close connection

		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("custom", "matriz_valores_stock_precio_php", $url, "", "matriz_valores_stock_precio_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($matriz_valores_stock_precio_php)) $matriz_valores_stock_precio_php = new cmatriz_valores_stock_precio_php();

// Page init
$matriz_valores_stock_precio_php->Page_Init();

// Page main
$matriz_valores_stock_precio_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<?php if (!@$gbSkipHeaderFooter) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<style>
	.dato {
		display: block;
		margin: 5px;
	}
</style>

<?PHP

	if (isset($_REQUEST["indice"]))
	{

		for ($i = 0; $i <= $_REQUEST["indice"]; $i++)
		{

			if (!isset($_REQUEST["v1_" . $i])) $_REQUEST["v1_" . $i] = "0";
			if (!isset($_REQUEST["v2_" . $i])) $_REQUEST["v2_" . $i] = "0";
			if (!isset($_REQUEST["v3_" . $i])) $_REQUEST["v3_" . $i] = "0";
			if (!isset($_REQUEST["v4_" . $i])) $_REQUEST["v4_" . $i] = "0";

			ew_Execute(
				"INSERT INTO `trama_articulos-valores-stock-precio` (idArticulo, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, precio, stock) " .
				"VALUES ('".$_REQUEST["id"]."', '".$_REQUEST["v1_" . $i]."', '".$_REQUEST["v2_" . $i]."', '".$_REQUEST["v3_" . $i]."', '".$_REQUEST["v4_" . $i]."', '0', '0', '0', '0', '0', '".$_REQUEST["precio_" . $i]."', '".$_REQUEST["stock_" . $i]."') " .
				"ON DUPLICATE KEY UPDATE precio = '".$_REQUEST["precio_" . $i]."', stock = '".$_REQUEST["stock_" . $i]."'"
				);

		}
	
	}

?>


<form action="matriz_valores_stock_precio.php" method="GET">

	<div class="panel panel-default ewGrid">

		<div class="panel-heading ewGridUpperPanel">

			Artículo: &nbsp;<select class="ewDropdownList form-control dropdown-toggle" name="id" onchange="location.href = 'matriz_valores_stock_precio.php?id=' + $(this).val();">
			<option>(Seleccione una opción)</option>
			<?PHP

				$rs = ew_Execute("SELECT CodInternoArti AS id, DescripcionArti AS descr " .
								 "FROM dbo_articulo " .
								 "WHERE idTipoArticulo > 0 " . 
								 "ORDER BY CodInternoArti ");

				if ($rs && $rs->RecordCount() > 0) {
						$rs->MoveFirst();
						do
						{
							echo('<option value="' . $rs->fields("id") . '"' . ($_REQUEST["id"] == $rs->fields("id") ? "selected" : "") . '>' . $rs->fields("id") . " | " . $rs->fields("descr") . '</option>');
						}
						while($rs->MoveNext());
						$rs->Close();
				}

			?>

			</select>

		</div>

		<div class="table-responsive ewGridMiddlePanel">

			<?PHP

				if (@$_REQUEST ["id"] != "") {

					$rs = ew_Execute("SELECT idTipoArticulo " .
									 "FROM dbo_articulo " .
									 "WHERE CodInternoArti = '" . $_REQUEST ["id"] . "'");

					if ($rs && $rs->RecordCount() > 0) {

							$rs->MoveFirst();

							$rs = ew_Execute("SELECT atributo1, ta1.denominacion as d1, atributo2, ta2.denominacion as d2, " .
							     			 "       atributo3, ta3.denominacion as d3, atributo4, ta4.denominacion as d4 " .
								 			 "FROM `trama_tipos-articulos` ta " .
								 			 "LEFT JOIN `trama_atributos` ta1 ON ta1.id = atributo1 " .
								 			 "LEFT JOIN `trama_atributos` ta2 ON ta2.id = atributo2 " .
								 			 "LEFT JOIN `trama_atributos` ta3 ON ta3.id = atributo3 " .
								 			 "LEFT JOIN `trama_atributos` ta4 ON ta4.id = atributo4 " .
								 			 "WHERE ta.id = '" . $rs->fields("idTipoArticulo") . "'");

							if ($rs && $rs->RecordCount() > 0) {

									$rs->MoveFirst();

									echo('<table class="table ewTable">');
									echo('<thead>');
									echo('<tr class="ewTableHeader">');
									if ($rs->fields("d1") != "") echo("<th>" . $rs->fields("d1") . "</th>");
									if ($rs->fields("d2") != "") echo("<th>" . $rs->fields("d2") . "</th>");
									if ($rs->fields("d3") != "") echo("<th>" . $rs->fields("d3") . "</th>");
									if ($rs->fields("d4") != "") echo("<th>" . $rs->fields("d4") . "</th>");
									echo("<th>Precio Vta</th>");
									echo("<th>Stock</th>");
									echo("</tr>");
									echo('</thead>');
									echo('<tbody>');

									$rs_valores_1 = ew_Execute("SELECT tav1.valor as v1, tav1.id as idv1 " .
															   ($rs->fields("d2") != "" ? ", tav2.valor as v2, tav2.id as idv2 " : "") . 
															   ($rs->fields("d3") != "" ? ", tav3.valor as v3, tav3.id as idv3 " : "") . 
															   ($rs->fields("d4") != "" ? ", tav4.valor as v4, tav4.id as idv4 " : "") . 
													 		   "FROM `trama_atributos-valores` tav1 " . 
													 		   ($rs->fields("d2") != "" ? ", `trama_atributos-valores` tav2 " : "") . 
													 		   ($rs->fields("d3") != "" ? ", `trama_atributos-valores` tav3 " : "") . 
													 		   ($rs->fields("d4") != "" ? ", `trama_atributos-valores` tav4 " : "") . 
													 		   "WHERE tav1.idAtributo = '" . $rs->fields("atributo1") . "' " .
													 		   ($rs->fields("d2") != "" ? " AND tav2.idAtributo = '" . $rs->fields("atributo2") . "' " : "") . 
													 		   ($rs->fields("d3") != "" ? " AND tav3.idAtributo = '" . $rs->fields("atributo3") . "' " : "") . 
													 		   ($rs->fields("d4") != "" ? " AND tav4.idAtributo = '" . $rs->fields("atributo4") . "' " : ""));


									$alt = "";
									$i = 0;

									if ($rs_valores_1 && $rs_valores_1->RecordCount() > 0) {
											$rs_valores_1->MoveFirst();
											do
											{


												echo('<tr class="ewTable' . $alt . 'Row">');
												if ($rs->fields("d1") != "") echo('<td class="ewListOptionBody"><span class="dato">' . $rs_valores_1->fields("v1") . '</span><input type="hidden" value="'.$rs_valores_1->fields("idv1").'" name="v1_'.$i.'"></td>');
												if ($rs->fields("d2") != "") echo('<td class="ewListOptionBody"><span class="dato">' . $rs_valores_1->fields("v2") . '</span><input type="hidden" value="'.$rs_valores_1->fields("idv2").'" name="v2_'.$i.'"></td>');									
												if ($rs->fields("d3") != "") echo('<td class="ewListOptionBody"><span class="dato">' . $rs_valores_1->fields("v3") . '</span><input type="hidden" value="'.$rs_valores_1->fields("idv3").'" name="v3_'.$i.'"></td>');									
												if ($rs->fields("d4") != "") echo('<td class="ewListOptionBody"><span class="dato">' . $rs_valores_1->fields("v4") . '</span><input type="hidden" value="'.$rs_valores_1->fields("idv4").'" name="v4_'.$i.'"></td>');									

												$rs_precio_stock = ew_Execute("SELECT * FROM `trama_articulos-valores-stock-precio` " . 
																			  "WHERE idArticulo = '" . $_REQUEST ["id"] . "' " .
																			  "AND valor1 = '" . $rs_valores_1->fields("idv1") . "'" . 
																			  ($rs->fields("d2") != "" ? " AND valor2 = '" . $rs_valores_1->fields("idv2") . "'" : "") . 
																			  ($rs->fields("d3") != "" ? " AND valor3 = '" . $rs_valores_1->fields("idv3") . "'" : "") . 
																			  ($rs->fields("d4") != "" ? " AND valor4 = '" . $rs_valores_1->fields("idv4") . "'" : ""));

												$precio = 0;
												$stock = 0;
												if ($rs_precio_stock && $rs_precio_stock->RecordCount() > 0) {
													$rs_precio_stock->MoveFirst();											
													$precio = $rs_precio_stock->fields("precio");
													$stock = $rs_precio_stock->fields("stock");
												}

												echo('<td class="ewListOptionBody" style="width: 5px;"><input type="text" name="precio_'.$i.'" value="' . $precio . '" class="form-control" size="3" style="margin: 0px;"></td>');									
												echo('<td class="ewListOptionBody" style="width: 5px;"><input type="text" name="stock_'.$i.'" value="' . $stock . '" class="form-control" size="3"></td>');									
												echo('</tr>');
												if ($alt == "") $alt = "Alt";
												else $alt = "";

												$i ++;

											}
											while($rs_valores_1->MoveNext());
											$rs_valores_1->Close();

									}

									echo('</tbody>');
									echo("</table>");

							}						

					}		

				}


				if (isset($i)) $i--;

			?>

		</div>

	</div>

	<input type="hidden" name="indice" value="<?PHP echo($i); ?>">
	<input type="submit" value="Guardar" class="btn btn-primary ewButton">

</form>


<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$matriz_valores_stock_precio_php->Page_Terminate();
?>
