<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
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

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["idUsuario"] != "") {
  $walger_usuarios->idUsuario->setQueryStringValue($_GET["idUsuario"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $walger_usuarios->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $walger_usuarios->CurrentAction = "C"; // Copy Record
  } else {
    $walger_usuarios->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($walger_usuarios->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($walger_usuarios->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$walger_usuarios->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($walger_usuarios->KeyUrl($walger_usuarios->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$walger_usuarios->RowType = EW_ROWTYPE_ADD;  // Render add type
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
<p><span class="phpmaker">Agregar a : Usuarios<br><br><a href="<?php echo $walger_usuarios->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fwalger_usuariosadd" id="fwalger_usuariosadd" action="walger_usuariosadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">Usuario<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $walger_usuarios->usuario->CellAttributes() ?>><span id="cb_x_usuario">
<input type="text" name="x_usuario" id="x_usuario" title="" size="30" maxlength="20" value="<?php echo $walger_usuarios->usuario->EditValue ?>"<?php echo $walger_usuarios->usuario->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Contraseña<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $walger_usuarios->contrasenia->CellAttributes() ?>><span id="cb_x_contrasenia">
<input type="text" name="x_contrasenia" id="x_contrasenia" title="" size="30" maxlength="20" value="<?php echo $walger_usuarios->contrasenia->EditValue ?>"<?php echo $walger_usuarios->contrasenia->EditAttributes() ?>>
</span></td>
  </tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="Guardar y continuar">
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

// Load default values
function LoadDefaultValues() {
	global $walger_usuarios;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $walger_usuarios;
	$walger_usuarios->usuario->setFormValue($objForm->GetValue("x_usuario"));
	$walger_usuarios->contrasenia->setFormValue($objForm->GetValue("x_contrasenia"));
}

// Restore form values
function RestoreFormValues() {
	global $walger_usuarios;
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
	// usuario

	$walger_usuarios->usuario->CellCssStyle = "";
	$walger_usuarios->usuario->CellCssClass = "";

	// contrasenia
	$walger_usuarios->contrasenia->CellCssStyle = "";
	$walger_usuarios->contrasenia->CellCssClass = "";
	if ($walger_usuarios->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_ADD) { // Add row

		// usuario
		$walger_usuarios->usuario->EditCustomAttributes = "";
		$walger_usuarios->usuario->EditValue = ew_HtmlEncode($walger_usuarios->usuario->CurrentValue);

		// contrasenia
		$walger_usuarios->contrasenia->EditCustomAttributes = "";
		$walger_usuarios->contrasenia->EditValue = ew_HtmlEncode($walger_usuarios->contrasenia->CurrentValue);
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_usuarios->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $walger_usuarios;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $walger_usuarios->SqlKeyFilter();
	if (trim(strval($walger_usuarios->idUsuario->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@idUsuario@", ew_AdjustSql($walger_usuarios->idUsuario->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($walger_usuarios->idUsuario->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $walger_usuarios->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	if ($walger_usuarios->usuario->CurrentValue <> "") { // Check field with unique index
		$sFilter = "(`usuario` = '" . ew_AdjustSql($walger_usuarios->usuario->CurrentValue) . "')";
		$rsChk = $walger_usuarios->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado del índice -- `usuario`, valor  " . $walger_usuarios->usuario->CurrentValue;
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field usuario
	$walger_usuarios->usuario->SetDbValueDef($walger_usuarios->usuario->CurrentValue, "");
	$rsnew['usuario'] =& $walger_usuarios->usuario->DbValue;

	// Field contrasenia
	$walger_usuarios->contrasenia->SetDbValueDef($walger_usuarios->contrasenia->CurrentValue, "");
	$rsnew['contrasenia'] =& $walger_usuarios->contrasenia->DbValue;

	// Call Row Inserting event
	$bInsertRow = $walger_usuarios->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($walger_usuarios->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($walger_usuarios->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_usuarios->CancelMessage;
			$walger_usuarios->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {
		$walger_usuarios->idUsuario->setDbValue($conn->Insert_ID());
		$rsnew['idUsuario'] =& $walger_usuarios->idUsuario->DbValue;

		// Call Row Inserted event
		$walger_usuarios->Row_Inserted($rsnew);
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
