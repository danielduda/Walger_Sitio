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

$vencimientos_php = NULL; // Initialize page object first

class cvencimientos_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{8B1B047A-723B-431D-9264-98AA1CD60F92}";

	// Table name
	var $TableName = 'vencimientos.php';

	// Page object name
	var $PageObjName = 'vencimientos_php';

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
			define("EW_TABLE_NAME", 'vencimientos.php', TRUE);

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
		$Breadcrumb->Add("custom", "vencimientos_php", $url, "", "vencimientos_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($vencimientos_php)) $vencimientos_php = new cvencimientos_php();

// Page init
$vencimientos_php->Page_Init();

// Page main
$vencimientos_php->Page_Main();

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

  global $ruta_absoluta_factura_pdf;
  global $directorio_facturas_pdf;

  global $logo_encabezado_reportes;
  global $texto_contacto;
  global $medios_de_pago;  

  global $email_asunto_vencimientos;

  if (isset($_GET["email"])) ob_start();
  
  // --
  
  $sql = "SELECT * FROM dbo_moneda";

  $rs = ew_Execute($sql);
  if ($rs->RecordCount() == 0) exit();

  $rs->MoveFirst();  

  while ($rs && !$rs->EOF)
  {
	$mdas [$rs->fields ["Regis_Mda"]] = $rs->fields ["Signo_Mda"];
	$rs->MoveNext();
  }

  // --
	
  $sql = "SELECT * FROM dbo_cliente " . 
		 "WHERE CodigoCli = '" . $_GET ["CodigoCliente"] . "'";

  $rs_cliente = ew_Execute($sql);
  if ($rs_cliente->RecordCount() == 0) exit();

  $rs_cliente->MoveFirst();

  // --
  
  $sql = "SELECT * FROM dbo_clientevtotransa " . 
		 "WHERE CodigoCli = '" . $_GET ["CodigoCliente"] . "' " .
		 "ORDER BY Regis_CliTra ASC ";

  $rs_vtos = ew_Execute($sql);

  $rs_vtos->MoveFirst();

  // --

  $acumulado = 0;
  
?>


   <table width="100%" style="border-top: 1px solid #F0F0F0;">
	  <tr>
		 <td style="padding: 20px;">
		 	<img src="<?PHP echo($logo_encabezado_reportes); ?>" width="210" /><br />
		 </td>
		 <td style="text-align: right; vertical-align: bottom; padding: 20px;">
		  	<?PHP echo($texto_contacto); ?>
		 </td>
	  </tr>
   </table>
	  
	  <table width="100%" style="border-top: 2px solid #F0F0F0;">
  	    <tr>
		  <td style="padding: 3px; vertical-align: top;" width="50%"><b>Cliente:</b><br />(<?PHP echo ($rs_cliente->fields ["CodigoCli"]); ?>) <?PHP echo ($rs_cliente->fields ["RazonSocialCli"]); ?></td>
		  <td style="padding: 3px; vertical-align: top;" width="50%"><b>EMail:</b><br /><?PHP echo ($rs_cliente->fields ["emailCli"]); ?></td>
		</tr>
		<tr>
		  <td style="padding: 3px; vertical-align: top;" width="50%"><b>Domicilio:</b><br />
			<?PHP echo ($rs_cliente->fields ["BarrioCli"]); ?>
			<?PHP echo ($rs_cliente->fields ["LocalidadCli"]); ?>
			<?PHP echo ($rs_cliente->fields ["CodigoPostalCli"]); ?>
			<?PHP echo ($rs_cliente->fields ["Direccion"]); ?>
			<?PHP echo ($rs_cliente->fields ["DescrProvincia"]); ?>
			<?PHP echo ($rs_cliente->fields ["DescrPais"]); ?>
		  </td>
		  <td style="padding: 3px; vertical-align: top;" width="50%"><b>Tel.:</b><br />
			<?PHP echo ($rs_cliente->fields ["Telefono"]); ?>
			<?PHP echo ($rs_cliente->fields ["FaxCli"]); ?>
		  </td>			  
		</tr>
	  </table>  

	  <table width="100%" style="border-top: 2px solid #F0F0F0;">
		<tr style="border-bottom: 1px solid #F0F0F0;">
		  <td style="padding: 5px;"><b>Vto.</b></td>
		  <td style="padding: 5px;"><b>Emisi&oacute;n</b></td>
		  <td style="padding: 5px;"><b>D&iacute;as</b></td>
		  <td style="padding: 5px;"><b>Div.</b></td>
		  <td style="padding: 5px;"><b>Comprobante</b></td>
		  <td style="padding: 5px;"><b>Mda.</b></td>
		  <td style="padding: 5px; text-align: right;"><b>Pendiente</b></td>
		  <td style="padding: 5px; text-align: right;"><b>Acumulado</b></td>
		</tr>
		
		<?PHP 

		while ($rs_vtos && !$rs_vtos->EOF)
		{

		?>

<?PHP

  if ($rs_vtos->fields["MdaOper_CliTra"] == 0) $moneda = 1;
  else
  {
	$moneda = $rs_vtos->fields["Regis_Mda" . $rs_vtos->fields["MdaOper_CliTra"]];
  }

  $VTOPHPMONEDA = $moneda;

  if ($rs_vtos->fields["MdaOper_CliTra"] == 0) $cotizacion = 1;
  else
  {
	$cotizacion = $rs_vtos->fields["CotizMda" . $rs_vtos->fields["MdaOper_CliTra"] . "_CliVto"];
  }

  if ($rs_vtos->fields["MdaOper_CliTra"] == 0) $pendiente = $rs_vtos->fields["ImportePes_CliVto"];
  else
  {
	$pendiente = $rs_vtos->fields["ImporteMda" . $rs_vtos->fields["MdaOper_CliTra"] . "_CliVto"];
  }

  if ($rs_vtos->fields["SignoComp"] == "-") $pendiente *= -1;

  $acumulado += $pendiente;

?>


		<tr>
		  <td style="padding: 5px;"><?PHP echo (substr ($rs_vtos->fields["FechaVto_CliVto"], 0, 10)); ?></td>
		  <td style="padding: 5px;"><?PHP echo (substr ($rs_vtos->fields["Fecha_CliTra"], 0, 10)); ?></td>
		  <td style="padding: 5px;"><?PHP echo (diasFechas ($rs_vtos->fields["Fecha_CliTra"])); ?></td>
		  <td style="padding: 5px;"><?PHP echo ($rs_vtos->fields["Regis_Emp"]); ?></td>


<?PHP

$fcisis_doc = "";

@$dh_vto = opendir($directorio_facturas_pdf);
if($dh_vto) {
	while ($f_vto = readdir($dh_vto)) {
		if ((strpos($f_vto, $rs_cliente->fields["CodigoCli"]) === 0) && (strpos($f_vto, $rs_cliente->fields["CuitCli"]) > 0)){
				$dh1_vto = opendir($directorio_facturas_pdf.$f_vto."/");
				while ($f1_vto = readdir($dh1_vto)) {
					if ((strpos($f1_vto, $rs_vtos->fields["NroComprob_CliTra"]) > 0)&&(strpos($f1_vto, ".pdf") > 0)) {
						$fcisis_doc = $ruta_absoluta_factura_pdf."?pdf=".$directorio_facturas_pdf.$f_vto."/".$f1_vto;
						break;
					}
				}
				break;
		}
	}
}


?>

		  <td style="padding: 5px;"><?PHP if ($fcisis_doc != "") { ?><a style="cursor: pointer;" target="_blank" href="<?PHP echo($fcisis_doc); ?>"><?PHP } ?><?PHP echo ($rs_vtos->fields["Abreviatura"]); ?> <?PHP echo ($rs_vtos->fields["NroComprob_CliTra"]); ?><?PHP if ($fcisis_doc != "") { ?></a><?PHP } ?></td>
		  <td style="padding: 5px;"><?PHP echo ($mdas [$moneda]); ?></td>
		  <td style="padding: 5px; text-align: right;"><?PHP echo (number_format ($pendiente, 2, '.', ',')); ?></td>
		  <td style="padding: 5px; text-align: right;"><?PHP echo (number_format ($acumulado, 2, '.', ',')); ?></td>
		</tr>
		
		<?PHP

				$rs_vtos->MoveNext();
		
			}

		?>

	  </table>
	  <table width="100%" style="border-top: 1px solid #F0F0F0; border-bottom: 2px solid #F0F0F0;">
		<tr>
		  <td style="text-align: right; padding: 5px;"><b><?PHP echo (number_format ($acumulado, 2, '.', ',')); ?></b></td>
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
   <?PHP if ($acumulado > 0) { ?>
   
   <script>
   		var show_print_email_buttons = true;
   </script>

   <?PHP } ?>
   <?PHP } ?>
   
<?PHP

	if (isset($_GET["email"]))
	{
		$email_asunto_vencimientos = str_replace("[[RazonSocial]]", $rs_cliente->fields ["RazonSocialCli"], $email_asunto_vencimientos);
		$destinatario = trim(mb_strtolower($rs_cliente->fields ["emailCli"]));
		enviar_email($destinatario, $email_asunto_vencimientos, ob_get_contents());
		ob_end_clean();
		header("location: walger_pedidoslist.php?mensaje=EMail enviado al cliente " . $destinatario);	
	}

	$rs->Close();
	
?>
   


	  


<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$vencimientos_php->Page_Terminate();
?>
