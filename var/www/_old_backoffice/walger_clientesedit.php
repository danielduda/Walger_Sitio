<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_clientes', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_clientesinfo.php" ?>
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
$walger_clientes->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_clientes->Export; // Get export parameter, used in header
$sExportFile = $walger_clientes->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["CodigoCli"] <> "") {
	$walger_clientes->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_clientes->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_clientes->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_clientes->CodigoCli->CurrentValue == "") Page_Terminate($walger_clientes->getReturnUrl()); // Invalid key, exit
switch ($walger_clientes->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_clientes->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_clientes->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_clientes->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_clientes->RowType = EW_ROWTYPE_EDIT; // Render as edit
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "edit"; // Page id

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
		elm = fobj.elements["x" + infix + "_CodigoCli"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Cliente"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Contrasenia"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Contraseña"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_UltimoLogin"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Ultimo Login"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_Habilitado"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Habilitado"))
				return false;
		}
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
<p><span class="phpmaker">Editar : Clientes<br><br><a href="<?php echo $walger_clientes->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_clientesedit" id="fwalger_clientesedit" action="walger_clientesedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cliente<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>><span id="cb_x_CodigoCli">
<div<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>><?php echo $walger_clientes->CodigoCli->EditValue ?></div>
<input type="hidden" name="x_CodigoCli" id="x_CodigoCli" value="<?php echo ew_HtmlEncode($walger_clientes->CodigoCli->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Contraseña<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>><span id="cb_x_Contrasenia">
<input type="text" name="x_Contrasenia" id="x_Contrasenia" title="" size="30" maxlength="20" value="<?php echo $walger_clientes->Contrasenia->EditValue ?>"<?php echo $walger_clientes->Contrasenia->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">IP<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>><span id="cb_x_IP">
<input type="text" name="x_IP" id="x_IP" title="" size="30" maxlength="15" value="<?php echo $walger_clientes->IP->EditValue ?>"<?php echo $walger_clientes->IP->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Ultimo Login<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>><span id="cb_x_UltimoLogin">
<input type="text" name="x_UltimoLogin" id="x_UltimoLogin" title="" value="<?php echo $walger_clientes->UltimoLogin->EditValue ?>"<?php echo $walger_clientes->UltimoLogin->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Habilitado<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>><span id="cb_x_Habilitado">
<select id="x_Habilitado" name="x_Habilitado"<?php echo $walger_clientes->Habilitado->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->Habilitado->EditValue)) {
	$arwrk = $walger_clientes->Habilitado->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->Habilitado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
			}
}
?>
</select>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Tipo de Cliente<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>><span id="cb_x_TipoCliente">
<select id="x_TipoCliente" name="x_TipoCliente"<?php echo $walger_clientes->TipoCliente->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->TipoCliente->EditValue)) {
	$arwrk = $walger_clientes->TipoCliente->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->TipoCliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
			}
}
?>
</select>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Moneda</td>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>><span id="cb_x_Regis_Mda">
<select id="x_Regis_Mda" name="x_Regis_Mda"<?php echo $walger_clientes->Regis_Mda->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_clientes->Regis_Mda->EditValue)) {
	$arwrk = $walger_clientes->Regis_Mda->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_clientes->Regis_Mda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Apellido y Nombre<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>><span id="cb_x_ApellidoNombre">
<input type="text" name="x_ApellidoNombre" id="x_ApellidoNombre" title="" size="30" maxlength="30" value="<?php echo $walger_clientes->ApellidoNombre->EditValue ?>"<?php echo $walger_clientes->ApellidoNombre->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cargo<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>><span id="cb_x_Cargo">
<input type="text" name="x_Cargo" id="x_Cargo" title="" size="30" maxlength="30" value="<?php echo $walger_clientes->Cargo->EditValue ?>"<?php echo $walger_clientes->Cargo->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Comentarios<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_clientes->Comentarios->CellAttributes() ?>><span id="cb_x_Comentarios">
<textarea name="x_Comentarios" id="x_Comentarios" cols="35" rows="4"<?php echo $walger_clientes->Comentarios->EditAttributes() ?>><?php echo $walger_clientes->Comentarios->EditValue ?></textarea>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  Editar  ">
</form>
<script language="JavaScript">
<!--
var f = document.fwalger_clientesedit;
ew_UpdateOpt(f.x_CodigoCli, ar_x_CodigoCli, f.x_CodigoCli);

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

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $walger_clientes;
	$walger_clientes->CodigoCli->setFormValue($objForm->GetValue("x_CodigoCli"));
	$walger_clientes->Contrasenia->setFormValue($objForm->GetValue("x_Contrasenia"));
	$walger_clientes->IP->setFormValue($objForm->GetValue("x_IP"));
	$walger_clientes->UltimoLogin->setFormValue($objForm->GetValue("x_UltimoLogin"));
	$walger_clientes->UltimoLogin->CurrentValue = ew_UnFormatDateTime($walger_clientes->UltimoLogin->CurrentValue, 7);
	$walger_clientes->Habilitado->setFormValue($objForm->GetValue("x_Habilitado"));
	$walger_clientes->TipoCliente->setFormValue($objForm->GetValue("x_TipoCliente"));
	$walger_clientes->Regis_Mda->setFormValue($objForm->GetValue("x_Regis_Mda"));
	$walger_clientes->ApellidoNombre->setFormValue($objForm->GetValue("x_ApellidoNombre"));
	$walger_clientes->Cargo->setFormValue($objForm->GetValue("x_Cargo"));
	$walger_clientes->Comentarios->setFormValue($objForm->GetValue("x_Comentarios"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_clientes;
	$walger_clientes->CodigoCli->CurrentValue = $walger_clientes->CodigoCli->FormValue;
	$walger_clientes->Contrasenia->CurrentValue = $walger_clientes->Contrasenia->FormValue;
	$walger_clientes->IP->CurrentValue = $walger_clientes->IP->FormValue;
	$walger_clientes->UltimoLogin->CurrentValue = $walger_clientes->UltimoLogin->FormValue;
	$walger_clientes->UltimoLogin->CurrentValue = ew_UnFormatDateTime($walger_clientes->UltimoLogin->CurrentValue, 7);
	$walger_clientes->Habilitado->CurrentValue = $walger_clientes->Habilitado->FormValue;
	$walger_clientes->TipoCliente->CurrentValue = $walger_clientes->TipoCliente->FormValue;
	$walger_clientes->Regis_Mda->CurrentValue = $walger_clientes->Regis_Mda->FormValue;
	$walger_clientes->ApellidoNombre->CurrentValue = $walger_clientes->ApellidoNombre->FormValue;
	$walger_clientes->Cargo->CurrentValue = $walger_clientes->Cargo->FormValue;
	$walger_clientes->Comentarios->CurrentValue = $walger_clientes->Comentarios->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_clientes;
	$sFilter = $walger_clientes->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_clientes->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_clientes->CurrentFilter = $sFilter;
	$sSql = $walger_clientes->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_clientes->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_clientes;
	$walger_clientes->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$walger_clientes->Contrasenia->setDbValue($rs->fields('Contrasenia'));
	$walger_clientes->IP->setDbValue($rs->fields('IP'));
	$walger_clientes->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
	$walger_clientes->Habilitado->setDbValue($rs->fields('Habilitado'));
	$walger_clientes->TipoCliente->setDbValue($rs->fields('TipoCliente'));
	$walger_clientes->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$walger_clientes->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
	$walger_clientes->Cargo->setDbValue($rs->fields('Cargo'));
	$walger_clientes->Comentarios->setDbValue($rs->fields('Comentarios'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_clientes;

	// Call Row Rendering event
	$walger_clientes->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$walger_clientes->CodigoCli->CellCssStyle = "";
	$walger_clientes->CodigoCli->CellCssClass = "";

	// Contrasenia
	$walger_clientes->Contrasenia->CellCssStyle = "";
	$walger_clientes->Contrasenia->CellCssClass = "";

	// IP
	$walger_clientes->IP->CellCssStyle = "";
	$walger_clientes->IP->CellCssClass = "";

	// UltimoLogin
	$walger_clientes->UltimoLogin->CellCssStyle = "";
	$walger_clientes->UltimoLogin->CellCssClass = "";

	// Habilitado
	$walger_clientes->Habilitado->CellCssStyle = "";
	$walger_clientes->Habilitado->CellCssClass = "";

	// TipoCliente
	$walger_clientes->TipoCliente->CellCssStyle = "";
	$walger_clientes->TipoCliente->CellCssClass = "";

	// Regis_Mda
	$walger_clientes->Regis_Mda->CellCssStyle = "";
	$walger_clientes->Regis_Mda->CellCssClass = "";

	// ApellidoNombre
	$walger_clientes->ApellidoNombre->CellCssStyle = "";
	$walger_clientes->ApellidoNombre->CellCssClass = "";

	// Cargo
	$walger_clientes->Cargo->CellCssStyle = "";
	$walger_clientes->Cargo->CellCssClass = "";

	// Comentarios
	$walger_clientes->Comentarios->CellCssStyle = "";
	$walger_clientes->Comentarios->CellCssClass = "";
	if ($walger_clientes->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// CodigoCli
		$walger_clientes->CodigoCli->EditCustomAttributes = "";
		if (!is_null($walger_clientes->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_clientes->CodigoCli->EditValue = $rswrk->fields('RazonSocialCli');
					$walger_clientes->CodigoCli->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$walger_clientes->CodigoCli->EditValue = $walger_clientes->CodigoCli->CurrentValue;
			}
		} else {
			$walger_clientes->CodigoCli->EditValue = NULL;
		}
		$walger_clientes->CodigoCli->CssStyle = "";
		$walger_clientes->CodigoCli->CssClass = "";
		$walger_clientes->CodigoCli->ViewCustomAttributes = "";

		// Contrasenia
		$walger_clientes->Contrasenia->EditCustomAttributes = "";
		$walger_clientes->Contrasenia->EditValue = ew_HtmlEncode($walger_clientes->Contrasenia->CurrentValue);

		// IP
		$walger_clientes->IP->EditCustomAttributes = "";
		$walger_clientes->IP->EditValue = ew_HtmlEncode($walger_clientes->IP->CurrentValue);

		// UltimoLogin
		$walger_clientes->UltimoLogin->EditCustomAttributes = "";
		$walger_clientes->UltimoLogin->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_clientes->UltimoLogin->CurrentValue, 7));

		// Habilitado
		$walger_clientes->Habilitado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("S", "Si");
		$arwrk[] = array("N", "No");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_clientes->Habilitado->EditValue = $arwrk;

		// TipoCliente
		$walger_clientes->TipoCliente->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("Consumidor Final", "Consumidor Final");
		$arwrk[] = array("Casa de Repuestos", "Casa de Repuestos");
		$arwrk[] = array("Distribuidor", "Distribuidor");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_clientes->TipoCliente->EditValue = $arwrk;

		// Regis_Mda
		$walger_clientes->Regis_Mda->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `Regis_Mda`, `CodigoAFIP_Mda`, `Signo_Mda` FROM `dbo_moneda`";
		$sSqlWrk .= " ORDER BY `CodigoAFIP_Mda` ";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Seleccione", ""));
		$walger_clientes->Regis_Mda->EditValue = $arwrk;

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->EditCustomAttributes = "";
		$walger_clientes->ApellidoNombre->EditValue = ew_HtmlEncode($walger_clientes->ApellidoNombre->CurrentValue);

		// Cargo
		$walger_clientes->Cargo->EditCustomAttributes = "";
		$walger_clientes->Cargo->EditValue = ew_HtmlEncode($walger_clientes->Cargo->CurrentValue);

		// Comentarios
		$walger_clientes->Comentarios->EditCustomAttributes = "";
		$walger_clientes->Comentarios->EditValue = ew_HtmlEncode($walger_clientes->Comentarios->CurrentValue);
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_clientes->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_clientes;
	$sFilter = $walger_clientes->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue), $sFilter); // Replace key value
	$walger_clientes->CurrentFilter = $sFilter;
	$sSql = $walger_clientes->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE)
		return FALSE;
	if ($rs->EOF) {
		$EditRow = FALSE; // Update Failed
	} else {

		// Save old values
		$rsold =& $rs->fields;
		$rsnew = array();

		// Field CodigoCli
		// Field Contrasenia

		$walger_clientes->Contrasenia->SetDbValueDef($walger_clientes->Contrasenia->CurrentValue, "");
		$rsnew['Contrasenia'] =& $walger_clientes->Contrasenia->DbValue;

		// Field IP
		$walger_clientes->IP->SetDbValueDef($walger_clientes->IP->CurrentValue, "");
		$rsnew['IP'] =& $walger_clientes->IP->DbValue;

		// Field UltimoLogin
		$walger_clientes->UltimoLogin->SetDbValueDef(ew_UnFormatDateTime($walger_clientes->UltimoLogin->CurrentValue, 7), ew_CurrentDate());
		$rsnew['UltimoLogin'] =& $walger_clientes->UltimoLogin->DbValue;

		// Field Habilitado
		$walger_clientes->Habilitado->SetDbValueDef($walger_clientes->Habilitado->CurrentValue, "");
		$rsnew['Habilitado'] =& $walger_clientes->Habilitado->DbValue;

		// Field TipoCliente
		$walger_clientes->TipoCliente->SetDbValueDef($walger_clientes->TipoCliente->CurrentValue, "");
		$rsnew['TipoCliente'] =& $walger_clientes->TipoCliente->DbValue;

		// Field Regis_Mda
		$walger_clientes->Regis_Mda->SetDbValueDef($walger_clientes->Regis_Mda->CurrentValue, NULL);
		$rsnew['Regis_Mda'] =& $walger_clientes->Regis_Mda->DbValue;

		// Field ApellidoNombre
		$walger_clientes->ApellidoNombre->SetDbValueDef($walger_clientes->ApellidoNombre->CurrentValue, "");
		$rsnew['ApellidoNombre'] =& $walger_clientes->ApellidoNombre->DbValue;

		// Field Cargo
		$walger_clientes->Cargo->SetDbValueDef($walger_clientes->Cargo->CurrentValue, "");
		$rsnew['Cargo'] =& $walger_clientes->Cargo->DbValue;

		// Field Comentarios
		$walger_clientes->Comentarios->SetDbValueDef($walger_clientes->Comentarios->CurrentValue, "");
		$rsnew['Comentarios'] =& $walger_clientes->Comentarios->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_clientes->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_clientes->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_clientes->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_clientes->CancelMessage;
				$walger_clientes->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_clientes->Row_Updated($rsold, $rsnew);
	}
	$rs->Close();
	return $EditRow;
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
