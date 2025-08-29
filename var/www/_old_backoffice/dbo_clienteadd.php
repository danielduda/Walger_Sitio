<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_cliente', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_clienteinfo.php" ?>
<?php include "userfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Open connection to the database
$conn = ew_Connect();
?>
<?php
$Security = new cAdvancedSecurity();
?>
<?php
if (!$Security->IsLoggedIn()) $Security->AutoLogin();
if (!$Security->IsLoggedIn()) {
	$Security->SaveLastUrl();
	Page_Terminate("login.php");
}
?>
<?php

// Common page loading event (in userfn*.php)
Page_Loading();
?>
<?php

// Page load event, used in current page
Page_Load();
?>
<?php
$dbo_cliente->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_cliente->Export; // Get export parameter, used in header
$sExportFile = $dbo_cliente->TableVar; // Get export file, used in header
?>
<?php

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["CodigoCli"] != "") {
  $dbo_cliente->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $dbo_cliente->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $dbo_cliente->CurrentAction = "C"; // Copy Record
  } else {
    $dbo_cliente->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($dbo_cliente->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($dbo_cliente->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$dbo_cliente->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($dbo_cliente->KeyUrl($dbo_cliente->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$dbo_cliente->RowType = EW_ROWTYPE_ADD;  // Render add type
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "add"; // Page id

//-->
</script>
<script type="text/javascript">
<!--

function ew_ValidateForm(fobj) {
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
	}
	return true;
}

//-->
</script>
<script type="text/javascript">
<!--

// js for DHtml Editor
//-->

</script>
<script type="text/javascript">
<!--

// js for Popup Calendar
//-->

</script>
<script type="text/javascript">
<!--
var ew_MultiPagePage = "Página"; // multi-page Page Text
var ew_MultiPageOf = "de"; // multi-page Of Text
var ew_MultiPagePrev = "Anterior"; // multi-page Prev Text
var ew_MultiPageNext = "Siguiente"; // multi-page Next Text

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Agregar a : Clientes (ISIS)<br><br><a href="<?php echo $dbo_cliente->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fdbo_clienteadd" id="fdbo_clienteadd" action="dbo_clienteadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">Código</td>
    <td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>><span id="cb_x_CodigoCli">
<input type="text" name="x_CodigoCli" id="x_CodigoCli" title="" size="30" maxlength="10" value="<?php echo $dbo_cliente->CodigoCli->EditValue ?>"<?php echo $dbo_cliente->CodigoCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Razón Social</td>
    <td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>><span id="cb_x_RazonSocialCli">
<input type="text" name="x_RazonSocialCli" id="x_RazonSocialCli" title="" size="30" maxlength="60" value="<?php echo $dbo_cliente->RazonSocialCli->EditValue ?>"<?php echo $dbo_cliente->RazonSocialCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">CUIT</td>
    <td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>><span id="cb_x_CuitCli">
<input type="text" name="x_CuitCli" id="x_CuitCli" title="" size="30" maxlength="13" value="<?php echo $dbo_cliente->CuitCli->EditValue ?>"<?php echo $dbo_cliente->CuitCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Ingresos Brutos</td>
    <td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>><span id="cb_x_IngBrutosCli">
<input type="text" name="x_IngBrutosCli" id="x_IngBrutosCli" title="" size="30" maxlength="18" value="<?php echo $dbo_cliente->IngBrutosCli->EditValue ?>"<?php echo $dbo_cliente->IngBrutosCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Condición IVA</td>
    <td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>><span id="cb_x_Regis_IvaC">
<select id="x_Regis_IvaC" name="x_Regis_IvaC" onChange="ew_UpdateOpt(this.form.x_Regis_IvaC, ar_x_Regis_IvaC, this);"<?php echo $dbo_cliente->Regis_IvaC->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($dbo_cliente->Regis_IvaC->EditValue)) {
	$arwrk = $dbo_cliente->Regis_IvaC->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($dbo_cliente->Regis_IvaC->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
			}
}
?>
</select>
&nbsp;<a href="javascript:void(0);" onclick="ew_ShowAddOption('x_Regis_IvaC');">Nuevo Condición IVA</a>
</span><span>
<div id="ao_x_Regis_IvaC" style="display: none;">
<input type="hidden" id="ltn_x_Regis_IvaC" value="dbo_ivacondicion">
<input type="hidden" id="lfn_x_Regis_IvaC" value="Regis_IvaC">
<input type="hidden" id="dfn_x_Regis_IvaC" value="DescrIvaC">
<input type="hidden" id="lfm_x_Regis_IvaC" value="Ingrese el campo requerido - ID">
<input type="hidden" id="dfm_x_Regis_IvaC" value="Ingrese el campo requerido - Descripción">
<input type="hidden" id="lfq_x_Regis_IvaC" value="">
<input type="hidden" id="dfq_x_Regis_IvaC" value="'">
<table class="ewAddOption">
<tr><td><span>ID</span></td><td><input type="text" id="lf_x_Regis_IvaC" size="30"></td></tr>
<tr><td><span>Descripción</span></td><td><input type="text" id="df_x_Regis_IvaC" size="30" maxlength="20"></td></tr>
<tr><td colspan="2" align="right"><input type="button" value="Guardar y continuar" onClick="ew_PostNewOption('x_Regis_IvaC')"><input type="button" value="Cancelar" onClick="ew_HideAddOption('x_Regis_IvaC')"></td></tr>
</table>
</div>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Lista de Precios</td>
    <td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>><span id="cb_x_Regis_ListaPrec">
<select id="x_Regis_ListaPrec" name="x_Regis_ListaPrec" onChange="ew_UpdateOpt(this.form.x_Regis_ListaPrec, ar_x_Regis_ListaPrec, this);"<?php echo $dbo_cliente->Regis_ListaPrec->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($dbo_cliente->Regis_ListaPrec->EditValue)) {
	$arwrk = $dbo_cliente->Regis_ListaPrec->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($dbo_cliente->Regis_ListaPrec->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
			}
}
?>
</select>
&nbsp;<a href="javascript:void(0);" onclick="ew_ShowAddOption('x_Regis_ListaPrec');">Nuevo Lista de Precios</a>
</span><span>
<div id="ao_x_Regis_ListaPrec" style="display: none;">
<input type="hidden" id="ltn_x_Regis_ListaPrec" value="dbo_listaprecios">
<input type="hidden" id="lfn_x_Regis_ListaPrec" value="Regis_ListaPrec">
<input type="hidden" id="dfn_x_Regis_ListaPrec" value="DescrListaPrec">
<input type="hidden" id="df2n_x_Regis_ListaPrec" value="CodigListaPrec">
<input type="hidden" id="lfm_x_Regis_ListaPrec" value="Ingrese el campo requerido - ID">
<input type="hidden" id="dfm_x_Regis_ListaPrec" value="Ingrese el campo requerido - Descripción">
<input type="hidden" id="df2m_x_Regis_ListaPrec" value="Ingrese el campo requerido - Código">
<input type="hidden" id="lfq_x_Regis_ListaPrec" value="">
<input type="hidden" id="dfq_x_Regis_ListaPrec" value="'">
<input type="hidden" id="df2q_x_Regis_ListaPrec" value="">
<table class="ewAddOption">
<tr><td><span>ID</span></td><td><input type="text" id="lf_x_Regis_ListaPrec" size="30"></td></tr>
<tr><td><span>Descripción</span></td><td><input type="text" id="df_x_Regis_ListaPrec" size="30" maxlength="30"></td></tr>
<tr><td><span>Código</span></td><td><input type="text" id="df2_x_Regis_ListaPrec" size="30"></td></tr>
<tr><td colspan="2" align="right"><input type="button" value="Guardar y continuar" onClick="ew_PostNewOption('x_Regis_ListaPrec')"><input type="button" value="Cancelar" onClick="ew_HideAddOption('x_Regis_ListaPrec')"></td></tr>
</table>
</div>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">EMail</td>
    <td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>><span id="cb_x_emailCli">
<input type="text" name="x_emailCli" id="x_emailCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->emailCli->EditValue ?>"<?php echo $dbo_cliente->emailCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Razón Social Flete</td>
    <td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>><span id="cb_x_RazonSocialFlete">
<input type="text" name="x_RazonSocialFlete" id="x_RazonSocialFlete" title="" size="30" maxlength="50" value="<?php echo $dbo_cliente->RazonSocialFlete->EditValue ?>"<?php echo $dbo_cliente->RazonSocialFlete->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Dirección</td>
    <td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>><span id="cb_x_Direccion">
<input type="text" name="x_Direccion" id="x_Direccion" title="" size="30" maxlength="90" value="<?php echo $dbo_cliente->Direccion->EditValue ?>"<?php echo $dbo_cliente->Direccion->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Barrio</td>
    <td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>><span id="cb_x_BarrioCli">
<input type="text" name="x_BarrioCli" id="x_BarrioCli" title="" size="30" maxlength="30" value="<?php echo $dbo_cliente->BarrioCli->EditValue ?>"<?php echo $dbo_cliente->BarrioCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Localidad</td>
    <td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>><span id="cb_x_LocalidadCli">
<input type="text" name="x_LocalidadCli" id="x_LocalidadCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->LocalidadCli->EditValue ?>"<?php echo $dbo_cliente->LocalidadCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Provincia</td>
    <td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>><span id="cb_x_DescrProvincia">
<input type="text" name="x_DescrProvincia" id="x_DescrProvincia" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->DescrProvincia->EditValue ?>"<?php echo $dbo_cliente->DescrProvincia->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">CP</td>
    <td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>><span id="cb_x_CodigoPostalCli">
<input type="text" name="x_CodigoPostalCli" id="x_CodigoPostalCli" title="" size="30" maxlength="10" value="<?php echo $dbo_cliente->CodigoPostalCli->EditValue ?>"<?php echo $dbo_cliente->CodigoPostalCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">País</td>
    <td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>><span id="cb_x_DescrPais">
<input type="text" name="x_DescrPais" id="x_DescrPais" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->DescrPais->EditValue ?>"<?php echo $dbo_cliente->DescrPais->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Teléfono</td>
    <td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>><span id="cb_x_Telefono">
<input type="text" name="x_Telefono" id="x_Telefono" title="" size="30" maxlength="90" value="<?php echo $dbo_cliente->Telefono->EditValue ?>"<?php echo $dbo_cliente->Telefono->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Fax</td>
    <td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>><span id="cb_x_FaxCli">
<input type="text" name="x_FaxCli" id="x_FaxCli" title="" size="30" maxlength="30" value="<?php echo $dbo_cliente->FaxCli->EditValue ?>"<?php echo $dbo_cliente->FaxCli->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Pagina Web</td>
    <td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>><span id="cb_x_PaginaWebCli">
<input type="text" name="x_PaginaWebCli" id="x_PaginaWebCli" title="" size="30" maxlength="40" value="<?php echo $dbo_cliente->PaginaWebCli->EditValue ?>"<?php echo $dbo_cliente->PaginaWebCli->EditAttributes() ?>>
</span></td>
  </tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="Guardar y continuar">
</form>
<script language="JavaScript">
<!--
var f = document.fdbo_clienteadd;
ew_UpdateOpt(f.x_Regis_IvaC, ar_x_Regis_IvaC, f.x_Regis_IvaC);
ew_UpdateOpt(f.x_Regis_ListaPrec, ar_x_Regis_ListaPrec, f.x_Regis_ListaPrec);

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

// If control is passed here, simply terminate the page without redirect
Page_Terminate();

// -----------------------------------------------------------------
//  Subroutine Page_Terminate
//  - called when exit page
//  - clean up connection and objects
//  - if url specified, redirect to url, otherwise end response
function Page_Terminate($url = "") {
	global $conn;

	// Page unload event, used in current page
	Page_Unload();

	// Global page unloaded event (in userfn*.php)
	Page_Unloaded();

	 // Close Connection
	$conn->Close();

	// Go to url if specified
	if ($url <> "") {
		ob_end_clean();
		header("Location: $url");
	}
	exit();
}
?>
<?php

// Load default values
function LoadDefaultValues() {
	global $dbo_cliente;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $dbo_cliente;
	$dbo_cliente->CodigoCli->setFormValue($objForm->GetValue("x_CodigoCli"));
	$dbo_cliente->RazonSocialCli->setFormValue($objForm->GetValue("x_RazonSocialCli"));
	$dbo_cliente->CuitCli->setFormValue($objForm->GetValue("x_CuitCli"));
	$dbo_cliente->IngBrutosCli->setFormValue($objForm->GetValue("x_IngBrutosCli"));
	$dbo_cliente->Regis_IvaC->setFormValue($objForm->GetValue("x_Regis_IvaC"));
	$dbo_cliente->Regis_ListaPrec->setFormValue($objForm->GetValue("x_Regis_ListaPrec"));
	$dbo_cliente->emailCli->setFormValue($objForm->GetValue("x_emailCli"));
	$dbo_cliente->RazonSocialFlete->setFormValue($objForm->GetValue("x_RazonSocialFlete"));
	$dbo_cliente->Direccion->setFormValue($objForm->GetValue("x_Direccion"));
	$dbo_cliente->BarrioCli->setFormValue($objForm->GetValue("x_BarrioCli"));
	$dbo_cliente->LocalidadCli->setFormValue($objForm->GetValue("x_LocalidadCli"));
	$dbo_cliente->DescrProvincia->setFormValue($objForm->GetValue("x_DescrProvincia"));
	$dbo_cliente->CodigoPostalCli->setFormValue($objForm->GetValue("x_CodigoPostalCli"));
	$dbo_cliente->DescrPais->setFormValue($objForm->GetValue("x_DescrPais"));
	$dbo_cliente->Telefono->setFormValue($objForm->GetValue("x_Telefono"));
	$dbo_cliente->FaxCli->setFormValue($objForm->GetValue("x_FaxCli"));
	$dbo_cliente->PaginaWebCli->setFormValue($objForm->GetValue("x_PaginaWebCli"));
}

// Restore form values
function RestoreFormValues() {
	global $dbo_cliente;
	$dbo_cliente->CodigoCli->CurrentValue = $dbo_cliente->CodigoCli->FormValue;
	$dbo_cliente->RazonSocialCli->CurrentValue = $dbo_cliente->RazonSocialCli->FormValue;
	$dbo_cliente->CuitCli->CurrentValue = $dbo_cliente->CuitCli->FormValue;
	$dbo_cliente->IngBrutosCli->CurrentValue = $dbo_cliente->IngBrutosCli->FormValue;
	$dbo_cliente->Regis_IvaC->CurrentValue = $dbo_cliente->Regis_IvaC->FormValue;
	$dbo_cliente->Regis_ListaPrec->CurrentValue = $dbo_cliente->Regis_ListaPrec->FormValue;
	$dbo_cliente->emailCli->CurrentValue = $dbo_cliente->emailCli->FormValue;
	$dbo_cliente->RazonSocialFlete->CurrentValue = $dbo_cliente->RazonSocialFlete->FormValue;
	$dbo_cliente->Direccion->CurrentValue = $dbo_cliente->Direccion->FormValue;
	$dbo_cliente->BarrioCli->CurrentValue = $dbo_cliente->BarrioCli->FormValue;
	$dbo_cliente->LocalidadCli->CurrentValue = $dbo_cliente->LocalidadCli->FormValue;
	$dbo_cliente->DescrProvincia->CurrentValue = $dbo_cliente->DescrProvincia->FormValue;
	$dbo_cliente->CodigoPostalCli->CurrentValue = $dbo_cliente->CodigoPostalCli->FormValue;
	$dbo_cliente->DescrPais->CurrentValue = $dbo_cliente->DescrPais->FormValue;
	$dbo_cliente->Telefono->CurrentValue = $dbo_cliente->Telefono->FormValue;
	$dbo_cliente->FaxCli->CurrentValue = $dbo_cliente->FaxCli->FormValue;
	$dbo_cliente->PaginaWebCli->CurrentValue = $dbo_cliente->PaginaWebCli->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_cliente;
	$sFilter = $dbo_cliente->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($dbo_cliente->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_cliente->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_cliente->CurrentFilter = $sFilter;
	$sSql = $dbo_cliente->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_cliente->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_cliente;
	$dbo_cliente->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$dbo_cliente->RazonSocialCli->setDbValue($rs->fields('RazonSocialCli'));
	$dbo_cliente->CuitCli->setDbValue($rs->fields('CuitCli'));
	$dbo_cliente->IngBrutosCli->setDbValue($rs->fields('IngBrutosCli'));
	$dbo_cliente->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_cliente->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_cliente->emailCli->setDbValue($rs->fields('emailCli'));
	$dbo_cliente->RazonSocialFlete->setDbValue($rs->fields('RazonSocialFlete'));
	$dbo_cliente->Direccion->setDbValue($rs->fields('Direccion'));
	$dbo_cliente->BarrioCli->setDbValue($rs->fields('BarrioCli'));
	$dbo_cliente->LocalidadCli->setDbValue($rs->fields('LocalidadCli'));
	$dbo_cliente->DescrProvincia->setDbValue($rs->fields('DescrProvincia'));
	$dbo_cliente->CodigoPostalCli->setDbValue($rs->fields('CodigoPostalCli'));
	$dbo_cliente->DescrPais->setDbValue($rs->fields('DescrPais'));
	$dbo_cliente->Telefono->setDbValue($rs->fields('Telefono'));
	$dbo_cliente->FaxCli->setDbValue($rs->fields('FaxCli'));
	$dbo_cliente->PaginaWebCli->setDbValue($rs->fields('PaginaWebCli'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_cliente;

	// Call Row Rendering event
	$dbo_cliente->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$dbo_cliente->CodigoCli->CellCssStyle = "";
	$dbo_cliente->CodigoCli->CellCssClass = "";

	// RazonSocialCli
	$dbo_cliente->RazonSocialCli->CellCssStyle = "";
	$dbo_cliente->RazonSocialCli->CellCssClass = "";

	// CuitCli
	$dbo_cliente->CuitCli->CellCssStyle = "";
	$dbo_cliente->CuitCli->CellCssClass = "";

	// IngBrutosCli
	$dbo_cliente->IngBrutosCli->CellCssStyle = "";
	$dbo_cliente->IngBrutosCli->CellCssClass = "";

	// Regis_IvaC
	$dbo_cliente->Regis_IvaC->CellCssStyle = "";
	$dbo_cliente->Regis_IvaC->CellCssClass = "";

	// Regis_ListaPrec
	$dbo_cliente->Regis_ListaPrec->CellCssStyle = "";
	$dbo_cliente->Regis_ListaPrec->CellCssClass = "";

	// emailCli
	$dbo_cliente->emailCli->CellCssStyle = "";
	$dbo_cliente->emailCli->CellCssClass = "";

	// RazonSocialFlete
	$dbo_cliente->RazonSocialFlete->CellCssStyle = "";
	$dbo_cliente->RazonSocialFlete->CellCssClass = "";

	// Direccion
	$dbo_cliente->Direccion->CellCssStyle = "";
	$dbo_cliente->Direccion->CellCssClass = "";

	// BarrioCli
	$dbo_cliente->BarrioCli->CellCssStyle = "";
	$dbo_cliente->BarrioCli->CellCssClass = "";

	// LocalidadCli
	$dbo_cliente->LocalidadCli->CellCssStyle = "";
	$dbo_cliente->LocalidadCli->CellCssClass = "";

	// DescrProvincia
	$dbo_cliente->DescrProvincia->CellCssStyle = "";
	$dbo_cliente->DescrProvincia->CellCssClass = "";

	// CodigoPostalCli
	$dbo_cliente->CodigoPostalCli->CellCssStyle = "";
	$dbo_cliente->CodigoPostalCli->CellCssClass = "";

	// DescrPais
	$dbo_cliente->DescrPais->CellCssStyle = "";
	$dbo_cliente->DescrPais->CellCssClass = "";

	// Telefono
	$dbo_cliente->Telefono->CellCssStyle = "";
	$dbo_cliente->Telefono->CellCssClass = "";

	// FaxCli
	$dbo_cliente->FaxCli->CellCssStyle = "";
	$dbo_cliente->FaxCli->CellCssClass = "";

	// PaginaWebCli
	$dbo_cliente->PaginaWebCli->CellCssStyle = "";
	$dbo_cliente->PaginaWebCli->CellCssClass = "";
	if ($dbo_cliente->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_ADD) { // Add row

		// CodigoCli
		$dbo_cliente->CodigoCli->EditCustomAttributes = "";
		$dbo_cliente->CodigoCli->EditValue = ew_HtmlEncode($dbo_cliente->CodigoCli->CurrentValue);

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->EditCustomAttributes = "";
		$dbo_cliente->RazonSocialCli->EditValue = ew_HtmlEncode($dbo_cliente->RazonSocialCli->CurrentValue);

		// CuitCli
		$dbo_cliente->CuitCli->EditCustomAttributes = "";
		$dbo_cliente->CuitCli->EditValue = ew_HtmlEncode($dbo_cliente->CuitCli->CurrentValue);

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->EditCustomAttributes = "";
		$dbo_cliente->IngBrutosCli->EditValue = ew_HtmlEncode($dbo_cliente->IngBrutosCli->CurrentValue);

		// Regis_IvaC
		$dbo_cliente->Regis_IvaC->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_IvaC`, `DescrIvaC` FROM `dbo_ivacondicion`";
		$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione"));
		$dbo_cliente->Regis_IvaC->EditValue = $arwrk;

		// Regis_ListaPrec
		$dbo_cliente->Regis_ListaPrec->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_ListaPrec`, `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios`";
		$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$dbo_cliente->Regis_ListaPrec->EditValue = $arwrk;

		// emailCli
		$dbo_cliente->emailCli->EditCustomAttributes = "";
		$dbo_cliente->emailCli->EditValue = ew_HtmlEncode($dbo_cliente->emailCli->CurrentValue);

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->EditCustomAttributes = "";
		$dbo_cliente->RazonSocialFlete->EditValue = ew_HtmlEncode($dbo_cliente->RazonSocialFlete->CurrentValue);

		// Direccion
		$dbo_cliente->Direccion->EditCustomAttributes = "";
		$dbo_cliente->Direccion->EditValue = ew_HtmlEncode($dbo_cliente->Direccion->CurrentValue);

		// BarrioCli
		$dbo_cliente->BarrioCli->EditCustomAttributes = "";
		$dbo_cliente->BarrioCli->EditValue = ew_HtmlEncode($dbo_cliente->BarrioCli->CurrentValue);

		// LocalidadCli
		$dbo_cliente->LocalidadCli->EditCustomAttributes = "";
		$dbo_cliente->LocalidadCli->EditValue = ew_HtmlEncode($dbo_cliente->LocalidadCli->CurrentValue);

		// DescrProvincia
		$dbo_cliente->DescrProvincia->EditCustomAttributes = "";
		$dbo_cliente->DescrProvincia->EditValue = ew_HtmlEncode($dbo_cliente->DescrProvincia->CurrentValue);

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->EditCustomAttributes = "";
		$dbo_cliente->CodigoPostalCli->EditValue = ew_HtmlEncode($dbo_cliente->CodigoPostalCli->CurrentValue);

		// DescrPais
		$dbo_cliente->DescrPais->EditCustomAttributes = "";
		$dbo_cliente->DescrPais->EditValue = ew_HtmlEncode($dbo_cliente->DescrPais->CurrentValue);

		// Telefono
		$dbo_cliente->Telefono->EditCustomAttributes = "";
		$dbo_cliente->Telefono->EditValue = ew_HtmlEncode($dbo_cliente->Telefono->CurrentValue);

		// FaxCli
		$dbo_cliente->FaxCli->EditCustomAttributes = "";
		$dbo_cliente->FaxCli->EditValue = ew_HtmlEncode($dbo_cliente->FaxCli->CurrentValue);

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->EditCustomAttributes = "";
		$dbo_cliente->PaginaWebCli->EditValue = ew_HtmlEncode($dbo_cliente->PaginaWebCli->CurrentValue);
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_cliente->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $dbo_cliente;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $dbo_cliente->SqlKeyFilter();
	if (trim(strval($dbo_cliente->CodigoCli->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($dbo_cliente->CodigoCli->CurrentValue), $sFilter); // Replace key value
	}
	if ($bCheckKey) {
		$rsChk = $dbo_cliente->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field CodigoCli
	$dbo_cliente->CodigoCli->SetDbValueDef($dbo_cliente->CodigoCli->CurrentValue, NULL);
	$rsnew['CodigoCli'] =& $dbo_cliente->CodigoCli->DbValue;

	// Field RazonSocialCli
	$dbo_cliente->RazonSocialCli->SetDbValueDef($dbo_cliente->RazonSocialCli->CurrentValue, NULL);
	$rsnew['RazonSocialCli'] =& $dbo_cliente->RazonSocialCli->DbValue;

	// Field CuitCli
	$dbo_cliente->CuitCli->SetDbValueDef($dbo_cliente->CuitCli->CurrentValue, NULL);
	$rsnew['CuitCli'] =& $dbo_cliente->CuitCli->DbValue;

	// Field IngBrutosCli
	$dbo_cliente->IngBrutosCli->SetDbValueDef($dbo_cliente->IngBrutosCli->CurrentValue, NULL);
	$rsnew['IngBrutosCli'] =& $dbo_cliente->IngBrutosCli->DbValue;

	// Field Regis_IvaC
	$dbo_cliente->Regis_IvaC->SetDbValueDef($dbo_cliente->Regis_IvaC->CurrentValue, NULL);
	$rsnew['Regis_IvaC'] =& $dbo_cliente->Regis_IvaC->DbValue;

	// Field Regis_ListaPrec
	$dbo_cliente->Regis_ListaPrec->SetDbValueDef($dbo_cliente->Regis_ListaPrec->CurrentValue, NULL);
	$rsnew['Regis_ListaPrec'] =& $dbo_cliente->Regis_ListaPrec->DbValue;

	// Field emailCli
	$dbo_cliente->emailCli->SetDbValueDef($dbo_cliente->emailCli->CurrentValue, NULL);
	$rsnew['emailCli'] =& $dbo_cliente->emailCli->DbValue;

	// Field RazonSocialFlete
	$dbo_cliente->RazonSocialFlete->SetDbValueDef($dbo_cliente->RazonSocialFlete->CurrentValue, NULL);
	$rsnew['RazonSocialFlete'] =& $dbo_cliente->RazonSocialFlete->DbValue;

	// Field Direccion
	$dbo_cliente->Direccion->SetDbValueDef($dbo_cliente->Direccion->CurrentValue, NULL);
	$rsnew['Direccion'] =& $dbo_cliente->Direccion->DbValue;

	// Field BarrioCli
	$dbo_cliente->BarrioCli->SetDbValueDef($dbo_cliente->BarrioCli->CurrentValue, NULL);
	$rsnew['BarrioCli'] =& $dbo_cliente->BarrioCli->DbValue;

	// Field LocalidadCli
	$dbo_cliente->LocalidadCli->SetDbValueDef($dbo_cliente->LocalidadCli->CurrentValue, NULL);
	$rsnew['LocalidadCli'] =& $dbo_cliente->LocalidadCli->DbValue;

	// Field DescrProvincia
	$dbo_cliente->DescrProvincia->SetDbValueDef($dbo_cliente->DescrProvincia->CurrentValue, NULL);
	$rsnew['DescrProvincia'] =& $dbo_cliente->DescrProvincia->DbValue;

	// Field CodigoPostalCli
	$dbo_cliente->CodigoPostalCli->SetDbValueDef($dbo_cliente->CodigoPostalCli->CurrentValue, NULL);
	$rsnew['CodigoPostalCli'] =& $dbo_cliente->CodigoPostalCli->DbValue;

	// Field DescrPais
	$dbo_cliente->DescrPais->SetDbValueDef($dbo_cliente->DescrPais->CurrentValue, NULL);
	$rsnew['DescrPais'] =& $dbo_cliente->DescrPais->DbValue;

	// Field Telefono
	$dbo_cliente->Telefono->SetDbValueDef($dbo_cliente->Telefono->CurrentValue, NULL);
	$rsnew['Telefono'] =& $dbo_cliente->Telefono->DbValue;

	// Field FaxCli
	$dbo_cliente->FaxCli->SetDbValueDef($dbo_cliente->FaxCli->CurrentValue, NULL);
	$rsnew['FaxCli'] =& $dbo_cliente->FaxCli->DbValue;

	// Field PaginaWebCli
	$dbo_cliente->PaginaWebCli->SetDbValueDef($dbo_cliente->PaginaWebCli->CurrentValue, NULL);
	$rsnew['PaginaWebCli'] =& $dbo_cliente->PaginaWebCli->DbValue;

	// Call Row Inserting event
	$bInsertRow = $dbo_cliente->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($dbo_cliente->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($dbo_cliente->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_cliente->CancelMessage;
			$dbo_cliente->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {

		// Call Row Inserted event
		$dbo_cliente->Row_Inserted($rsnew);
	}
	return $AddRow;
}
?>
<?php

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
