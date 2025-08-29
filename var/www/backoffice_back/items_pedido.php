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

$items_pedido_php = NULL; // Initialize page object first

class citems_pedido_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'items_pedido.php';

	// Page object name
	var $PageObjName = 'items_pedido_php';

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
			define("EW_TABLE_NAME", 'items_pedido.php', TRUE);

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
		$Breadcrumb->Add("custom", "items_pedido_php", $url, "", "items_pedido_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($items_pedido_php)) $items_pedido_php = new citems_pedido_php();

// Page init
$items_pedido_php->Page_Init();

// Page main
$items_pedido_php->Page_Main();

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
<?PHP

  global $logo_encabezado_reportes;
  global $texto_contacto;
  global $medios_de_pago;  

  global $email_asunto_items_pedidos;

  if (isset($_GET["email"])) ob_start();

  $sql = "SELECT walger_items_pedidos.CodInternoArti, DescripcionArti, Precio, Cantidad,
  		  walger_items_pedidos.Estado, walger_pedidos.idPedido, walger_pedidos.fechaEstado AS FECHAPED,
		  walger_items_pedidos.idItemPedido, walger_clientes.CodigoCli AS CCLI, dbo_cliente.Telefono AS TELE, dbo_cliente.IngbrutosCLI AS INGBRUT,dbo_cliente.CuitCli AS CUIT, dbo_ivacondicion.DescrIvaC AS DESCRIVA,
		  TasaIva, RazonSocialCli, Direccion, BarrioCli, LocalidadCli, DescrProvincia, CodigoPostalCli, DescrPais, RazonSocialFlete, emailCli, walger_pedidos.Comentario, dbo_moneda.Signo_Mda,
		  walger_pedidos.estado AS EstadoPedido
		  FROM dbo_articulo
		  INNER JOIN walger_items_pedidos ON dbo_articulo.CodInternoArti = walger_items_pedidos.CodInternoArti
		  INNER JOIN walger_pedidos ON walger_items_pedidos.idPedido = walger_pedidos.idPedido
		  INNER JOIN dbo_cliente ON dbo_cliente.CodigoCli = walger_pedidos.CodigoCli
		  INNER JOIN dbo_ivacondicion ON dbo_cliente.Regis_ivaC = dbo_ivacondicion.Regis_ivaC
		  INNER JOIN walger_clientes ON dbo_cliente.CodigoCli = walger_clientes.CodigoCli
			   LEFT JOIN dbo_moneda on dbo_moneda.Regis_Mda = walger_clientes.Regis_Mda
		  WHERE walger_pedidos.idPedido = '". $_GET ["idPedido"] ."'
		  ORDER BY walger_items_pedidos.CodInternoArti, DescripcionArti ";

  $rs = ew_Execute($sql);
  if ($rs->RecordCount() == 0) exit();

  $rs->MoveFirst();

  if ($rs->fields ["Signo_Mda"] == "") $rs->fields ["Signo_Mda"] = "$";

  $SUBTOTAL = 0;
  $IVA = 0;
  
?>

   <table width="100%" style="border-top: 1px solid #F0F0F0;">
	  <tr>
		 <td style="padding: 20px;">
		 	<img src="<?PHP echo($logo_encabezado_reportes); ?>" width="210" alt="Walger" /><br />
		 </td>
		 <td style="text-align: right; vertical-align: bottom; padding: 20px;">
		  	<?PHP echo($texto_contacto); ?>
		 </td>
	  </tr>
   </table>

   <table width="100%" style="border-top: 1px solid #F0F0F0;">
	  <tr>
		 <td style="text-align: center; font-size: 20px;">
		 	<b>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "N") echo ("NO CONFIRMADO"); else ?>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "X") echo ("CONFIRMADO NO ENTREGADO"); else ?>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "E") echo ("EN PREPARACIÓN"); else ?>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "P") echo ("PENDIENTE DE PAGO"); else ?>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "F") echo ("FACTURADO"); else ?>
		 	<?PHP if ($rs->fields ["EstadoPedido"] == "C") echo ("CANCELADO"); ?>
		 	</b>
		 </td>
	  </tr>
   </table>
   
   <table width="100%" style="border-top: 2px solid #F0F0F0;">
	 <tr>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Pedido:</b><br /><?PHP echo ($rs->fields ["idPedido"]); ?> </td>
	   <td style="padding: 3px; vertical-align: top;" colspan="3" width="75%"><b>Fecha y Hora:</b><br /><?PHP echo ($rs->fields ["FECHAPED"]); ?></td>
	 </tr>
	 <tr>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Cliente:</b><br />(<?PHP echo ($rs->fields ["CCLI"]); ?>) <?PHP echo ($rs->fields ["RazonSocialCli"]); ?></td>
  	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Dirección:</b><br /> 
		  <?PHP echo ($rs->fields ["Direccion"]); ?>
		  <?PHP echo ($rs->fields ["BarrioCli"]); ?>
		  <?PHP echo ($rs->fields ["LocalidadCli"]); ?>
		  (<?PHP echo ($rs->fields ["CodigoPostalCli"]); ?>)
		  <?PHP echo ($rs->fields ["DescrProvincia"]); ?>
		  <?PHP echo ($rs->fields ["DescrPais"]); ?>
	   </td>	   
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>EMail:</b><br /><?PHP echo ($rs->fields ["emailCli"]); ?></td>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Tel.:</b><br /><?PHP echo ($rs->fields ["TELE"]); ?> </td>
	 </tr>
	 <tr>
  	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>IB:</b><br /><?PHP echo ($rs->fields ["INGBRUT"]); ?></td>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>CUIT:</b><br /><?PHP echo ($rs->fields ["CUIT"]); ?></td>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Tipo IVA:</b><br /><?PHP echo ($rs->fields ["DESCRIVA"]); ?></td>
	   <td style="padding: 3px; vertical-align: top;" width="25%"><b>Transporte:</b><br /><?PHP echo ($rs->fields ["RazonSocialFlete"]); ?></td>
	 </tr>
   </table>
	 
   <table width="100%" style="border-top: 2px solid #F0F0F0;">
   	 <tr  style="border-bottom: 1px solid #F0F0F0;">
	   <td style="text-align: left; padding: 5px;"><b>Código</b></td>
	   <td style="text-align: left; padding: 5px;"><b>Descripción</b></td>
	   <td style="text-align: right; padding: 5px;"><b>Cantidad</b></td>
	   <td style="text-align: right; padding: 5px;"><b>Precio (<?PHP echo ($rs->fields ["Signo_Mda"]); ?>)</b></td>
	   <td style="text-align: right; padding: 5px;"><b>Total Línea (<?PHP echo ($rs->fields ["Signo_Mda"]); ?>)</b></td>
	 </tr>
	 <?PHP
	 	  $rs->MoveFirst();
	  	  while ($rs && !$rs->EOF) {
	 ?>
	 <tr>
		<td style="text-align: left; padding: 5px;"><?PHP echo ($rs->fields ['CodInternoArti']); ?></td>
		<td style="text-align: left; padding: 5px;"><?PHP echo ($rs->fields ['DescripcionArti']); ?></td>
		<td style="text-align: right; padding: 5px;"><?PHP echo ($rs->fields ['Cantidad']); ?></td>
		<td style="text-align: right; padding: 5px;"><?PHP printf("%.2f", $rs->fields ['Precio']); ?></td>
		<td style="text-align: right; padding: 5px;"><?PHP echo($rs->fields ['Cantidad']* $rs->fields['Precio']); ?></td>
	 </tr>

	 <?PHP
			$SUBTOTAL += $rs->fields ['Cantidad'] * $rs->fields ['Precio'];
			$IVA += $rs->fields ['Cantidad'] * $rs->fields ['Precio'] * $rs->fields ['TasaIva'] / 100;
			$rs->MoveNext();
	  	}

	  	$rs->MoveFirst();
	 ?>
		  
   </table>

   <table width="100%" style="border-top: 1px solid #F0F0F0; border-bottom: 2px solid #F0F0F0;">
	  <tr><td style="text-align: right; padding: 5px;"><b>SUBTOTAL (<?PHP echo ($rs->fields ["Signo_Mda"]); ?>)</b></td><td width="100" style="text-align: right; padding: 5px;"><?PHP printf("%.2f", $SUBTOTAL); ?></td></tr>
	  <tr><td style="text-align: right; padding: 5px;"><b>IVA (<?PHP echo ($rs->fields ["Signo_Mda"]); ?>)</b></td><td width="100" style="text-align: right; padding: 5px;"><?PHP printf("%.2f", $IVA); ?></td></tr>
	  <tr><td style="text-align: right; padding: 5px;"><b>TOTAL (<?PHP echo ($rs->fields ["Signo_Mda"]); ?>)</b></td><td width="100" style="text-align: right; padding: 5px;"><?PHP printf("%.2f", $IVA + $SUBTOTAL); ?></td></tr>
   </table>

   <table width="100%" style="border-bottom: 2px solid #F0F0F0;">
	  <tr>
	  	<td style="padding: 5px;">
	  		<b>Comentario: <i><?PHP echo ($rs->fields ['Comentario']); ?></i> -</b>
	  	</td>
	  </tr>
   </table>

   <table width="100%" style="margin-bottom: 20px;">
	  <tr>
		 <td style="padding: 5px;">
		   <?PHP echo ($medios_de_pago); ?>
		 </td>
	  </tr>
   </table>   

   <?PHP if (!isset($_GET["email"])) { ?>
   <?PHP if ($SUBTOTAL > 0) { ?>
   
   <script>
   		var show_print_email_buttons = true;
   </script>

   <?PHP } ?> 
   <?PHP } ?>
   
<?PHP

	if (isset($_GET["email"]))
	{
		$email_asunto_items_pedidos = str_replace("[[idPedido]]", $rs->fields ["idPedido"], $email_asunto_items_pedidos);
		$destinatario = trim(mb_strtolower($rs->fields ["emailCli"]));
		enviar_email($destinatario, $email_asunto_items_pedidos, ob_get_contents());
		ob_end_clean();
		header("location: walger_pedidoslist.php?mensaje=EMail enviado al cliente " . $destinatario);	
	}

	$rs->Close();
	
?>
  


<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$items_pedido_php->Page_Terminate();
?>
