<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_listaprecios', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_listapreciosinfo.php" ?>
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
$dbo_listaprecios->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_listaprecios->Export; // Get export parameter, used in header
$sExportFile = $dbo_listaprecios->TableVar; // Get export file, used in header
?>
<?php

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["Regis_ListaPrec"] != "") {
  $dbo_listaprecios->Regis_ListaPrec->setQueryStringValue($_GET["Regis_ListaPrec"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $dbo_listaprecios->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $dbo_listaprecios->CurrentAction = "C"; // Copy Record
  } else {
    $dbo_listaprecios->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($dbo_listaprecios->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($dbo_listaprecios->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$dbo_listaprecios->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($dbo_listaprecios->KeyUrl($dbo_listaprecios->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$dbo_listaprecios->RowType = EW_ROWTYPE_ADD;  // Render add type
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
		elm = fobj.elements["x" + infix + "_Regis_ListaPrec"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - ID"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Regis_ListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - ID"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_CodigListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Código"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_RegrabaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Regraba ?"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_RegisListaMadre"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Lista Madre"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_VariacionListaPrec"];
		if (elm && !ew_CheckInteger(elm.value)) {
			if (!ew_OnError(elm, "Entero Incorrecto - Variación Lista Madre"))
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
<p><span class="phpmaker">Agregar a : Listas de precios (ISIS)<br><br><a href="<?php echo $dbo_listaprecios->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fdbo_listapreciosadd" id="fdbo_listapreciosadd" action="dbo_listapreciosadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">ID<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>><span id="cb_x_Regis_ListaPrec">
<input type="text" name="x_Regis_ListaPrec" id="x_Regis_ListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->Regis_ListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->Regis_ListaPrec->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Código</td>
    <td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>><span id="cb_x_CodigListaPrec">
<input type="text" name="x_CodigListaPrec" id="x_CodigListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->CodigListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->CodigListaPrec->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Descripción</td>
    <td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>><span id="cb_x_DescrListaPrec">
<input type="text" name="x_DescrListaPrec" id="x_DescrListaPrec" title="" size="30" maxlength="30" value="<?php echo $dbo_listaprecios->DescrListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->DescrListaPrec->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Regraba ?</td>
    <td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>><span id="cb_x_RegrabaPrec">
<input type="text" name="x_RegrabaPrec" id="x_RegrabaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->RegrabaPrec->EditValue ?>"<?php echo $dbo_listaprecios->RegrabaPrec->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Lista Madre</td>
    <td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>><span id="cb_x_RegisListaMadre">
<input type="text" name="x_RegisListaMadre" id="x_RegisListaMadre" title="" size="30" value="<?php echo $dbo_listaprecios->RegisListaMadre->EditValue ?>"<?php echo $dbo_listaprecios->RegisListaMadre->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Variación Lista Madre</td>
    <td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>><span id="cb_x_VariacionListaPrec">
<input type="text" name="x_VariacionListaPrec" id="x_VariacionListaPrec" title="" size="30" value="<?php echo $dbo_listaprecios->VariacionListaPrec->EditValue ?>"<?php echo $dbo_listaprecios->VariacionListaPrec->EditAttributes() ?>>
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
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->CurrentValue = 0;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->setFormValue($objForm->GetValue("x_Regis_ListaPrec"));
	$dbo_listaprecios->CodigListaPrec->setFormValue($objForm->GetValue("x_CodigListaPrec"));
	$dbo_listaprecios->DescrListaPrec->setFormValue($objForm->GetValue("x_DescrListaPrec"));
	$dbo_listaprecios->RegrabaPrec->setFormValue($objForm->GetValue("x_RegrabaPrec"));
	$dbo_listaprecios->RegisListaMadre->setFormValue($objForm->GetValue("x_RegisListaMadre"));
	$dbo_listaprecios->VariacionListaPrec->setFormValue($objForm->GetValue("x_VariacionListaPrec"));
}

// Restore form values
function RestoreFormValues() {
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->CurrentValue = $dbo_listaprecios->Regis_ListaPrec->FormValue;
	$dbo_listaprecios->CodigListaPrec->CurrentValue = $dbo_listaprecios->CodigListaPrec->FormValue;
	$dbo_listaprecios->DescrListaPrec->CurrentValue = $dbo_listaprecios->DescrListaPrec->FormValue;
	$dbo_listaprecios->RegrabaPrec->CurrentValue = $dbo_listaprecios->RegrabaPrec->FormValue;
	$dbo_listaprecios->RegisListaMadre->CurrentValue = $dbo_listaprecios->RegisListaMadre->FormValue;
	$dbo_listaprecios->VariacionListaPrec->CurrentValue = $dbo_listaprecios->VariacionListaPrec->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_listaprecios;
	$sFilter = $dbo_listaprecios->SqlKeyFilter();
	if (!is_numeric($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_ListaPrec@", ew_AdjustSql($dbo_listaprecios->Regis_ListaPrec->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_listaprecios->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_listaprecios->CurrentFilter = $sFilter;
	$sSql = $dbo_listaprecios->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_listaprecios->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_listaprecios;
	$dbo_listaprecios->Regis_ListaPrec->setDbValue($rs->fields('Regis_ListaPrec'));
	$dbo_listaprecios->CodigListaPrec->setDbValue($rs->fields('CodigListaPrec'));
	$dbo_listaprecios->DescrListaPrec->setDbValue($rs->fields('DescrListaPrec'));
	$dbo_listaprecios->RegrabaPrec->setDbValue($rs->fields('RegrabaPrec'));
	$dbo_listaprecios->RegisListaMadre->setDbValue($rs->fields('RegisListaMadre'));
	$dbo_listaprecios->VariacionListaPrec->setDbValue($rs->fields('VariacionListaPrec'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_listaprecios;

	// Call Row Rendering event
	$dbo_listaprecios->Row_Rendering();

	// Common render codes for all row types
	// Regis_ListaPrec

	$dbo_listaprecios->Regis_ListaPrec->CellCssStyle = "";
	$dbo_listaprecios->Regis_ListaPrec->CellCssClass = "";

	// CodigListaPrec
	$dbo_listaprecios->CodigListaPrec->CellCssStyle = "";
	$dbo_listaprecios->CodigListaPrec->CellCssClass = "";

	// DescrListaPrec
	$dbo_listaprecios->DescrListaPrec->CellCssStyle = "";
	$dbo_listaprecios->DescrListaPrec->CellCssClass = "";

	// RegrabaPrec
	$dbo_listaprecios->RegrabaPrec->CellCssStyle = "";
	$dbo_listaprecios->RegrabaPrec->CellCssClass = "";

	// RegisListaMadre
	$dbo_listaprecios->RegisListaMadre->CellCssStyle = "";
	$dbo_listaprecios->RegisListaMadre->CellCssClass = "";

	// VariacionListaPrec
	$dbo_listaprecios->VariacionListaPrec->CellCssStyle = "";
	$dbo_listaprecios->VariacionListaPrec->CellCssClass = "";
	if ($dbo_listaprecios->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_ADD) { // Add row

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->Regis_ListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->Regis_ListaPrec->CurrentValue);

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->CodigListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->CodigListaPrec->CurrentValue);

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->DescrListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->DescrListaPrec->CurrentValue);

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->RegrabaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->RegrabaPrec->CurrentValue);

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->EditCustomAttributes = "";
		$dbo_listaprecios->RegisListaMadre->EditValue = ew_HtmlEncode($dbo_listaprecios->RegisListaMadre->CurrentValue);

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->EditCustomAttributes = "";
		$dbo_listaprecios->VariacionListaPrec->EditValue = ew_HtmlEncode($dbo_listaprecios->VariacionListaPrec->CurrentValue);
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_listaprecios->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $dbo_listaprecios;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $dbo_listaprecios->SqlKeyFilter();
	if (trim(strval($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@Regis_ListaPrec@", ew_AdjustSql($dbo_listaprecios->Regis_ListaPrec->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($dbo_listaprecios->Regis_ListaPrec->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $dbo_listaprecios->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field Regis_ListaPrec
	$dbo_listaprecios->Regis_ListaPrec->SetDbValueDef($dbo_listaprecios->Regis_ListaPrec->CurrentValue, 0);
	$rsnew['Regis_ListaPrec'] =& $dbo_listaprecios->Regis_ListaPrec->DbValue;

	// Field CodigListaPrec
	$dbo_listaprecios->CodigListaPrec->SetDbValueDef($dbo_listaprecios->CodigListaPrec->CurrentValue, NULL);
	$rsnew['CodigListaPrec'] =& $dbo_listaprecios->CodigListaPrec->DbValue;

	// Field DescrListaPrec
	$dbo_listaprecios->DescrListaPrec->SetDbValueDef($dbo_listaprecios->DescrListaPrec->CurrentValue, NULL);
	$rsnew['DescrListaPrec'] =& $dbo_listaprecios->DescrListaPrec->DbValue;

	// Field RegrabaPrec
	$dbo_listaprecios->RegrabaPrec->SetDbValueDef($dbo_listaprecios->RegrabaPrec->CurrentValue, NULL);
	$rsnew['RegrabaPrec'] =& $dbo_listaprecios->RegrabaPrec->DbValue;

	// Field RegisListaMadre
	$dbo_listaprecios->RegisListaMadre->SetDbValueDef($dbo_listaprecios->RegisListaMadre->CurrentValue, NULL);
	$rsnew['RegisListaMadre'] =& $dbo_listaprecios->RegisListaMadre->DbValue;

	// Field VariacionListaPrec
	$dbo_listaprecios->VariacionListaPrec->SetDbValueDef($dbo_listaprecios->VariacionListaPrec->CurrentValue, NULL);
	$rsnew['VariacionListaPrec'] =& $dbo_listaprecios->VariacionListaPrec->DbValue;

	// Call Row Inserting event
	$bInsertRow = $dbo_listaprecios->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($dbo_listaprecios->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($dbo_listaprecios->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_listaprecios->CancelMessage;
			$dbo_listaprecios->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {

		// Call Row Inserted event
		$dbo_listaprecios->Row_Inserted($rsnew);
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
