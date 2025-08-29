<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_articulo', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_articuloinfo.php" ?>
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
$dbo_articulo->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_articulo->Export; // Get export parameter, used in header
$sExportFile = $dbo_articulo->TableVar; // Get export file, used in header
?>
<?php

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["CodInternoArti"] != "") {
  $dbo_articulo->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $dbo_articulo->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $dbo_articulo->CurrentAction = "C"; // Copy Record
  } else {
    $dbo_articulo->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($dbo_articulo->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
      Page_Terminate($dbo_articulo->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$dbo_articulo->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Se ha guardado el nuevo registro"; // Set up success message
      Page_Terminate($dbo_articulo->KeyUrl($dbo_articulo->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$dbo_articulo->RowType = EW_ROWTYPE_ADD;  // Render add type
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
		elm = fobj.elements["x" + infix + "_TasaIva"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Tasa IVA"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_PrecioVta1_PreArti"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Precio de Venta"))
				return false; 
		}
		elm = fobj.elements["x" + infix + "_Stock1_StkArti"];
		if (elm && !ew_CheckNumber(elm.value)) {
			if (!ew_OnError(elm, "Valor decimal incorrecto - Stock"))
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
<p><span class="phpmaker">Agregar a : Artículos (ISIS)<br><br><a href="<?php echo $dbo_articulo->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fdbo_articuloadd" id="fdbo_articuloadd" action="dbo_articuloadd.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">Codigo Interno</td>
    <td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>><span id="cb_x_CodInternoArti">
<input type="text" name="x_CodInternoArti" id="x_CodInternoArti" title="" size="30" maxlength="24" value="<?php echo $dbo_articulo->CodInternoArti->EditValue ?>"<?php echo $dbo_articulo->CodInternoArti->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Codigo de Barras</td>
    <td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>><span id="cb_x_CodBarraArti">
<input type="text" name="x_CodBarraArti" id="x_CodBarraArti" title="" size="30" maxlength="24" value="<?php echo $dbo_articulo->CodBarraArti->EditValue ?>"<?php echo $dbo_articulo->CodBarraArti->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Catálogo</td>
    <td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>><span id="cb_x_DescrNivelInt4">
<input type="text" name="x_DescrNivelInt4" id="x_DescrNivelInt4" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt4->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt4->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Línea</td>
    <td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>><span id="cb_x_DescrNivelInt3">
<input type="text" name="x_DescrNivelInt3" id="x_DescrNivelInt3" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt3->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt3->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Marca</td>
    <td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>><span id="cb_x_DescrNivelInt2">
<input type="text" name="x_DescrNivelInt2" id="x_DescrNivelInt2" title="" size="30" maxlength="30" value="<?php echo $dbo_articulo->DescrNivelInt2->EditValue ?>"<?php echo $dbo_articulo->DescrNivelInt2->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Tasa IVA</td>
    <td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>><span id="cb_x_TasaIva">
<input type="text" name="x_TasaIva" id="x_TasaIva" title="" size="30" value="<?php echo $dbo_articulo->TasaIva->EditValue ?>"<?php echo $dbo_articulo->TasaIva->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Precio de Venta</td>
    <td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>><span id="cb_x_PrecioVta1_PreArti">
<input type="text" name="x_PrecioVta1_PreArti" id="x_PrecioVta1_PreArti" title="" size="30" value="<?php echo $dbo_articulo->PrecioVta1_PreArti->EditValue ?>"<?php echo $dbo_articulo->PrecioVta1_PreArti->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Descripcion</td>
    <td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>><span id="cb_x_DescripcionArti">
<input type="text" name="x_DescripcionArti" id="x_DescripcionArti" title="" size="30" maxlength="60" value="<?php echo $dbo_articulo->DescripcionArti->EditValue ?>"<?php echo $dbo_articulo->DescripcionArti->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Ruta a la Foto</td>
    <td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>><span id="cb_x_NombreFotoArti">
<input type="text" name="x_NombreFotoArti" id="x_NombreFotoArti" title="" size="30" maxlength="100" value="<?php echo $dbo_articulo->NombreFotoArti->EditValue ?>"<?php echo $dbo_articulo->NombreFotoArti->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Stock</td>
    <td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>><span id="cb_x_Stock1_StkArti">
<input type="text" name="x_Stock1_StkArti" id="x_Stock1_StkArti" title="" size="30" value="<?php echo $dbo_articulo->Stock1_StkArti->EditValue ?>"<?php echo $dbo_articulo->Stock1_StkArti->EditAttributes() ?>>
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
	global $dbo_articulo;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $dbo_articulo;
	$dbo_articulo->CodInternoArti->setFormValue($objForm->GetValue("x_CodInternoArti"));
	$dbo_articulo->CodBarraArti->setFormValue($objForm->GetValue("x_CodBarraArti"));
	$dbo_articulo->DescrNivelInt4->setFormValue($objForm->GetValue("x_DescrNivelInt4"));
	$dbo_articulo->DescrNivelInt3->setFormValue($objForm->GetValue("x_DescrNivelInt3"));
	$dbo_articulo->DescrNivelInt2->setFormValue($objForm->GetValue("x_DescrNivelInt2"));
	$dbo_articulo->TasaIva->setFormValue($objForm->GetValue("x_TasaIva"));
	$dbo_articulo->PrecioVta1_PreArti->setFormValue($objForm->GetValue("x_PrecioVta1_PreArti"));
	$dbo_articulo->DescripcionArti->setFormValue($objForm->GetValue("x_DescripcionArti"));
	$dbo_articulo->NombreFotoArti->setFormValue($objForm->GetValue("x_NombreFotoArti"));
	$dbo_articulo->Stock1_StkArti->setFormValue($objForm->GetValue("x_Stock1_StkArti"));
}

// Restore form values
function RestoreFormValues() {
	global $dbo_articulo;
	$dbo_articulo->CodInternoArti->CurrentValue = $dbo_articulo->CodInternoArti->FormValue;
	$dbo_articulo->CodBarraArti->CurrentValue = $dbo_articulo->CodBarraArti->FormValue;
	$dbo_articulo->DescrNivelInt4->CurrentValue = $dbo_articulo->DescrNivelInt4->FormValue;
	$dbo_articulo->DescrNivelInt3->CurrentValue = $dbo_articulo->DescrNivelInt3->FormValue;
	$dbo_articulo->DescrNivelInt2->CurrentValue = $dbo_articulo->DescrNivelInt2->FormValue;
	$dbo_articulo->TasaIva->CurrentValue = $dbo_articulo->TasaIva->FormValue;
	$dbo_articulo->PrecioVta1_PreArti->CurrentValue = $dbo_articulo->PrecioVta1_PreArti->FormValue;
	$dbo_articulo->DescripcionArti->CurrentValue = $dbo_articulo->DescripcionArti->FormValue;
	$dbo_articulo->NombreFotoArti->CurrentValue = $dbo_articulo->NombreFotoArti->FormValue;
	$dbo_articulo->Stock1_StkArti->CurrentValue = $dbo_articulo->Stock1_StkArti->FormValue;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_articulo;
	$sFilter = $dbo_articulo->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($dbo_articulo->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_articulo->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_articulo->CurrentFilter = $sFilter;
	$sSql = $dbo_articulo->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_articulo->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_articulo;
	$dbo_articulo->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$dbo_articulo->CodBarraArti->setDbValue($rs->fields('CodBarraArti'));
	$dbo_articulo->DescrNivelInt4->setDbValue($rs->fields('DescrNivelInt4'));
	$dbo_articulo->DescrNivelInt3->setDbValue($rs->fields('DescrNivelInt3'));
	$dbo_articulo->DescrNivelInt2->setDbValue($rs->fields('DescrNivelInt2'));
	$dbo_articulo->TasaIva->setDbValue($rs->fields('TasaIva'));
	$dbo_articulo->PrecioVta1_PreArti->setDbValue($rs->fields('PrecioVta1_PreArti'));
	$dbo_articulo->DescripcionArti->setDbValue($rs->fields('DescripcionArti'));
	$dbo_articulo->NombreFotoArti->setDbValue($rs->fields('NombreFotoArti'));
	$dbo_articulo->Stock1_StkArti->setDbValue($rs->fields('Stock1_StkArti'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_articulo;

	// Call Row Rendering event
	$dbo_articulo->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$dbo_articulo->CodInternoArti->CellCssStyle = "";
	$dbo_articulo->CodInternoArti->CellCssClass = "";

	// CodBarraArti
	$dbo_articulo->CodBarraArti->CellCssStyle = "";
	$dbo_articulo->CodBarraArti->CellCssClass = "";

	// DescrNivelInt4
	$dbo_articulo->DescrNivelInt4->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt4->CellCssClass = "";

	// DescrNivelInt3
	$dbo_articulo->DescrNivelInt3->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt3->CellCssClass = "";

	// DescrNivelInt2
	$dbo_articulo->DescrNivelInt2->CellCssStyle = "";
	$dbo_articulo->DescrNivelInt2->CellCssClass = "";

	// TasaIva
	$dbo_articulo->TasaIva->CellCssStyle = "";
	$dbo_articulo->TasaIva->CellCssClass = "";

	// PrecioVta1_PreArti
	$dbo_articulo->PrecioVta1_PreArti->CellCssStyle = "";
	$dbo_articulo->PrecioVta1_PreArti->CellCssClass = "";

	// DescripcionArti
	$dbo_articulo->DescripcionArti->CellCssStyle = "";
	$dbo_articulo->DescripcionArti->CellCssClass = "";

	// NombreFotoArti
	$dbo_articulo->NombreFotoArti->CellCssStyle = "";
	$dbo_articulo->NombreFotoArti->CellCssClass = "";

	// Stock1_StkArti
	$dbo_articulo->Stock1_StkArti->CellCssStyle = "";
	$dbo_articulo->Stock1_StkArti->CellCssClass = "";
	if ($dbo_articulo->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_ADD) { // Add row

		// CodInternoArti
		$dbo_articulo->CodInternoArti->EditCustomAttributes = "";
		$dbo_articulo->CodInternoArti->EditValue = ew_HtmlEncode($dbo_articulo->CodInternoArti->CurrentValue);

		// CodBarraArti
		$dbo_articulo->CodBarraArti->EditCustomAttributes = "";
		$dbo_articulo->CodBarraArti->EditValue = ew_HtmlEncode($dbo_articulo->CodBarraArti->CurrentValue);

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt4->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt4->CurrentValue);

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt3->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt3->CurrentValue);

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->EditCustomAttributes = "";
		$dbo_articulo->DescrNivelInt2->EditValue = ew_HtmlEncode($dbo_articulo->DescrNivelInt2->CurrentValue);

		// TasaIva
		$dbo_articulo->TasaIva->EditCustomAttributes = "";
		$dbo_articulo->TasaIva->EditValue = ew_HtmlEncode($dbo_articulo->TasaIva->CurrentValue);

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->EditCustomAttributes = "";
		$dbo_articulo->PrecioVta1_PreArti->EditValue = ew_HtmlEncode($dbo_articulo->PrecioVta1_PreArti->CurrentValue);

		// DescripcionArti
		$dbo_articulo->DescripcionArti->EditCustomAttributes = "";
		$dbo_articulo->DescripcionArti->EditValue = ew_HtmlEncode($dbo_articulo->DescripcionArti->CurrentValue);

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->EditCustomAttributes = "";
		$dbo_articulo->NombreFotoArti->EditValue = ew_HtmlEncode($dbo_articulo->NombreFotoArti->CurrentValue);

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->EditCustomAttributes = "";
		$dbo_articulo->Stock1_StkArti->EditValue = ew_HtmlEncode($dbo_articulo->Stock1_StkArti->CurrentValue);
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_articulo->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $dbo_articulo;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $dbo_articulo->SqlKeyFilter();
	if (trim(strval($dbo_articulo->CodInternoArti->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($dbo_articulo->CodInternoArti->CurrentValue), $sFilter); // Replace key value
	}
	if ($bCheckKey) {
		$rsChk = $dbo_articulo->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Valor duplicado de la clave";
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field CodInternoArti
	$dbo_articulo->CodInternoArti->SetDbValueDef($dbo_articulo->CodInternoArti->CurrentValue, NULL);
	$rsnew['CodInternoArti'] =& $dbo_articulo->CodInternoArti->DbValue;

	// Field CodBarraArti
	$dbo_articulo->CodBarraArti->SetDbValueDef($dbo_articulo->CodBarraArti->CurrentValue, NULL);
	$rsnew['CodBarraArti'] =& $dbo_articulo->CodBarraArti->DbValue;

	// Field DescrNivelInt4
	$dbo_articulo->DescrNivelInt4->SetDbValueDef($dbo_articulo->DescrNivelInt4->CurrentValue, NULL);
	$rsnew['DescrNivelInt4'] =& $dbo_articulo->DescrNivelInt4->DbValue;

	// Field DescrNivelInt3
	$dbo_articulo->DescrNivelInt3->SetDbValueDef($dbo_articulo->DescrNivelInt3->CurrentValue, NULL);
	$rsnew['DescrNivelInt3'] =& $dbo_articulo->DescrNivelInt3->DbValue;

	// Field DescrNivelInt2
	$dbo_articulo->DescrNivelInt2->SetDbValueDef($dbo_articulo->DescrNivelInt2->CurrentValue, NULL);
	$rsnew['DescrNivelInt2'] =& $dbo_articulo->DescrNivelInt2->DbValue;

	// Field TasaIva
	$dbo_articulo->TasaIva->SetDbValueDef($dbo_articulo->TasaIva->CurrentValue, NULL);
	$rsnew['TasaIva'] =& $dbo_articulo->TasaIva->DbValue;

	// Field PrecioVta1_PreArti
	$dbo_articulo->PrecioVta1_PreArti->SetDbValueDef($dbo_articulo->PrecioVta1_PreArti->CurrentValue, NULL);
	$rsnew['PrecioVta1_PreArti'] =& $dbo_articulo->PrecioVta1_PreArti->DbValue;

	// Field DescripcionArti
	$dbo_articulo->DescripcionArti->SetDbValueDef($dbo_articulo->DescripcionArti->CurrentValue, NULL);
	$rsnew['DescripcionArti'] =& $dbo_articulo->DescripcionArti->DbValue;

	// Field NombreFotoArti
	$dbo_articulo->NombreFotoArti->SetDbValueDef($dbo_articulo->NombreFotoArti->CurrentValue, NULL);
	$rsnew['NombreFotoArti'] =& $dbo_articulo->NombreFotoArti->DbValue;

	// Field Stock1_StkArti
	$dbo_articulo->Stock1_StkArti->SetDbValueDef($dbo_articulo->Stock1_StkArti->CurrentValue, NULL);
	$rsnew['Stock1_StkArti'] =& $dbo_articulo->Stock1_StkArti->DbValue;

	// Call Row Inserting event
	$bInsertRow = $dbo_articulo->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($dbo_articulo->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($dbo_articulo->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_articulo->CancelMessage;
			$dbo_articulo->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Cancelado";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {

		// Call Row Inserted event
		$dbo_articulo->Row_Inserted($rsnew);
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
