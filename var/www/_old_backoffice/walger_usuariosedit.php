<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_usuarios', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php include "userfn50.php" ?>
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
$walger_usuarios->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_usuarios->Export; // Get export parameter, used in header
$sExportFile = $walger_usuarios->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["idUsuario"] <> "") {
	$walger_usuarios->idUsuario->setQueryStringValue($_GET["idUsuario"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_usuarios->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_usuarios->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_usuarios->idUsuario->CurrentValue == "") Page_Terminate($walger_usuarios->getReturnUrl()); // Invalid key, exit
switch ($walger_usuarios->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_usuarios->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_usuarios->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_usuarios->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_usuarios->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_usuario"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Usuario"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_contrasenia"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Contraseña"))
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
<p><span class="phpmaker">Editar : Usuarios<br><br><a href="<?php echo $walger_usuarios->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_usuariosedit" id="fwalger_usuariosedit" action="walger_usuariosedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID</td>
		<td<?php echo $walger_usuarios->idUsuario->CellAttributes() ?>><span id="cb_x_idUsuario">
<div<?php echo $walger_usuarios->idUsuario->ViewAttributes() ?>><?php echo $walger_usuarios->idUsuario->EditValue ?></div>
<input type="hidden" name="x_idUsuario" id="x_idUsuario" value="<?php echo ew_HtmlEncode($walger_usuarios->idUsuario->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Usuario<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_usuarios->usuario->CellAttributes() ?>><span id="cb_x_usuario">
<input type="text" name="x_usuario" id="x_usuario" title="" size="30" maxlength="20" value="<?php echo $walger_usuarios->usuario->EditValue ?>"<?php echo $walger_usuarios->usuario->EditAttributes() ?>>
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Contraseña<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_usuarios->contrasenia->CellAttributes() ?>><span id="cb_x_contrasenia">
<input type="text" name="x_contrasenia" id="x_contrasenia" title="" size="30" maxlength="20" value="<?php echo $walger_usuarios->contrasenia->EditValue ?>"<?php echo $walger_usuarios->contrasenia->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  Editar  ">
</form>
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
	global $objForm, $walger_usuarios;
	$walger_usuarios->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
	$walger_usuarios->usuario->setFormValue($objForm->GetValue("x_usuario"));
	$walger_usuarios->contrasenia->setFormValue($objForm->GetValue("x_contrasenia"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_usuarios;
	$walger_usuarios->idUsuario->CurrentValue = $walger_usuarios->idUsuario->FormValue;
	$walger_usuarios->usuario->CurrentValue = $walger_usuarios->usuario->FormValue;
	$walger_usuarios->contrasenia->CurrentValue = $walger_usuarios->contrasenia->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_usuarios;
	$sFilter = $walger_usuarios->SqlKeyFilter();
	if (!is_numeric($walger_usuarios->idUsuario->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idUsuario@", ew_AdjustSql($walger_usuarios->idUsuario->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_usuarios->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_usuarios->CurrentFilter = $sFilter;
	$sSql = $walger_usuarios->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_usuarios->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_usuarios;
	$walger_usuarios->idUsuario->setDbValue($rs->fields('idUsuario'));
	$walger_usuarios->usuario->setDbValue($rs->fields('usuario'));
	$walger_usuarios->contrasenia->setDbValue($rs->fields('contrasenia'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_usuarios;

	// Call Row Rendering event
	$walger_usuarios->Row_Rendering();

	// Common render codes for all row types
	// idUsuario

	$walger_usuarios->idUsuario->CellCssStyle = "";
	$walger_usuarios->idUsuario->CellCssClass = "";

	// usuario
	$walger_usuarios->usuario->CellCssStyle = "";
	$walger_usuarios->usuario->CellCssClass = "";

	// contrasenia
	$walger_usuarios->contrasenia->CellCssStyle = "";
	$walger_usuarios->contrasenia->CellCssClass = "";
	if ($walger_usuarios->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// idUsuario
		$walger_usuarios->idUsuario->EditCustomAttributes = "";
		$walger_usuarios->idUsuario->EditValue = $walger_usuarios->idUsuario->CurrentValue;
		$walger_usuarios->idUsuario->CssStyle = "";
		$walger_usuarios->idUsuario->CssClass = "";
		$walger_usuarios->idUsuario->ViewCustomAttributes = "";

		// usuario
		$walger_usuarios->usuario->EditCustomAttributes = "";
		$walger_usuarios->usuario->EditValue = ew_HtmlEncode($walger_usuarios->usuario->CurrentValue);

		// contrasenia
		$walger_usuarios->contrasenia->EditCustomAttributes = "";
		$walger_usuarios->contrasenia->EditValue = ew_HtmlEncode($walger_usuarios->contrasenia->CurrentValue);
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_usuarios->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_usuarios;
	$sFilter = $walger_usuarios->SqlKeyFilter();
	if (!is_numeric($walger_usuarios->idUsuario->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@idUsuario@", ew_AdjustSql($walger_usuarios->idUsuario->CurrentValue), $sFilter); // Replace key value
	if ($walger_usuarios->usuario->CurrentValue <> "") { // Check field with unique index
		$sFilterChk = "(`usuario` = '" . ew_AdjustSql($walger_usuarios->usuario->CurrentValue) . "')";
		$sFilterChk .= " AND NOT (" . $sFilter . ")";
		$walger_usuarios->CurrentFilter = $sFilterChk;
		$sSqlChk = $walger_usuarios->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rsChk = $conn->Execute($sSqlChk);
		$conn->raiseErrorFn = '';
		if ($rsChk === FALSE) {
			return FALSE;
		} elseif (!$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado del índice -- `usuario`, valor  " . $walger_usuarios->usuario->CurrentValue;
			$rsChk->Close();
			return FALSE;
		}
		$rsChk->Close();
	}
	$walger_usuarios->CurrentFilter = $sFilter;
	$sSql = $walger_usuarios->SQL();
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

		// Field idUsuario
		// Field usuario

		$walger_usuarios->usuario->SetDbValueDef($walger_usuarios->usuario->CurrentValue, "");
		$rsnew['usuario'] =& $walger_usuarios->usuario->DbValue;

		// Field contrasenia
		$walger_usuarios->contrasenia->SetDbValueDef($walger_usuarios->contrasenia->CurrentValue, "");
		$rsnew['contrasenia'] =& $walger_usuarios->contrasenia->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_usuarios->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_usuarios->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_usuarios->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_usuarios->CancelMessage;
				$walger_usuarios->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_usuarios->Row_Updated($rsold, $rsnew);
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
