<?php
define("EW_PAGE_ID", "edit", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_items_pedidos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_items_pedidosinfo.php" ?>
<?php include "userfn50.php" ?>
<?php include "walger_pedidosinfo.php" ?>
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
$walger_items_pedidos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_items_pedidos->Export; // Get export parameter, used in header
$sExportFile = $walger_items_pedidos->TableVar; // Get export file, used in header
?>
<?php

// Load key from QueryString
if (@$_GET["idItemPedido"] <> "") {
	$walger_items_pedidos->idItemPedido->setQueryStringValue($_GET["idItemPedido"]);
}

// Create form object
$objForm = new cFormObj();
if (@$_POST["a_edit"] <> "") {
	$walger_items_pedidos->CurrentAction = $_POST["a_edit"]; // Get action code
	LoadFormValues(); // Get form values
} else {
	$walger_items_pedidos->CurrentAction = "I"; // Default action is display
}

// Check if valid key
if ($walger_items_pedidos->idItemPedido->CurrentValue == "") Page_Terminate($walger_items_pedidos->getReturnUrl()); // Invalid key, exit
switch ($walger_items_pedidos->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
			Page_Terminate($walger_items_pedidos->getReturnUrl()); // Return to caller
		}
		break;
	Case "U": // Update
		$walger_items_pedidos->SendEmail = TRUE; // Send email on update success
		if (EditRow()) { // Update Record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "Actualización correcta"; // Update success
			Page_Terminate($walger_items_pedidos->getReturnUrl()); // Return to caller
		} else {
			RestoreFormValues(); // Restore form values if update failed
		}
}

// Render the record
$walger_items_pedidos->RowType = EW_ROWTYPE_EDIT; // Render as edit
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
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Ingrese el campo requerido - Estado"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_fechaEntregado"];
		if (elm && !ew_CheckEuroDate(elm.value)) {
			if (!ew_OnError(elm, "Fecha incorrecta, formato = dd/mm/yyyy - Fecha Entregado"))
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
<p><span class="phpmaker">Editar : Items Pedidos<br><br><a href="<?php echo $walger_items_pedidos->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form name="fwalger_items_pedidosedit" id="fwalger_items_pedidosedit" action="walger_items_pedidosedit.php" method="post" onSubmit="return ew_ValidateForm(this);">
<p>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">ID Item</td>
		<td<?php echo $walger_items_pedidos->idItemPedido->CellAttributes() ?>><span id="cb_x_idItemPedido">
<div<?php echo $walger_items_pedidos->idItemPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idItemPedido->EditValue ?></div>
<input type="hidden" name="x_idItemPedido" id="x_idItemPedido" value="<?php echo ew_HtmlEncode($walger_items_pedidos->idItemPedido->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">ID Pedido<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_items_pedidos->idPedido->CellAttributes() ?>><span id="cb_x_idPedido">
<div<?php echo $walger_items_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idPedido->EditValue ?></div>
<input type="hidden" name="x_idPedido" id="x_idPedido" value="<?php echo ew_HtmlEncode($walger_items_pedidos->idPedido->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Artículo<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_items_pedidos->CodInternoArti->CellAttributes() ?>><span id="cb_x_CodInternoArti">
<div<?php echo $walger_items_pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_items_pedidos->CodInternoArti->EditValue ?></div>
<input type="hidden" name="x_CodInternoArti" id="x_CodInternoArti" value="<?php echo ew_HtmlEncode($walger_items_pedidos->CodInternoArti->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Precio<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_items_pedidos->precio->CellAttributes() ?>><span id="cb_x_precio">
<div<?php echo $walger_items_pedidos->precio->ViewAttributes() ?>><?php echo $walger_items_pedidos->precio->EditValue ?></div>
<input type="hidden" name="x_precio" id="x_precio" value="<?php echo ew_HtmlEncode($walger_items_pedidos->precio->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cantidad<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_items_pedidos->cantidad->CellAttributes() ?>><span id="cb_x_cantidad">
<div<?php echo $walger_items_pedidos->cantidad->ViewAttributes() ?>><?php echo $walger_items_pedidos->cantidad->EditValue ?></div>
<input type="hidden" name="x_cantidad" id="x_cantidad" value="<?php echo ew_HtmlEncode($walger_items_pedidos->cantidad->CurrentValue) ?>">
</span></td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Estado<span class='ewmsg'>&nbsp;*</span></td>
		<td<?php echo $walger_items_pedidos->estado->CellAttributes() ?>><span id="cb_x_estado">
<select id="x_estado" name="x_estado"<?php echo $walger_items_pedidos->estado->EditAttributes() ?>>
<!--option value="">Seleccione</option-->
<?php
if (is_array($walger_items_pedidos->estado->EditValue)) {
	$arwrk = $walger_items_pedidos->estado->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($walger_items_pedidos->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
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
		<td class="ewTableHeader">Fecha Entregado</td>
		<td<?php echo $walger_items_pedidos->fechaEntregado->CellAttributes() ?>><span id="cb_x_fechaEntregado">
<input type="text" name="x_fechaEntregado" id="x_fechaEntregado" title="" value="<?php echo $walger_items_pedidos->fechaEntregado->EditValue ?>"<?php echo $walger_items_pedidos->fechaEntregado->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  Editar  ">
</form>
<script language="JavaScript">
<!--
var f = document.fwalger_items_pedidosedit;
ew_UpdateOpt(f.x_CodInternoArti, ar_x_CodInternoArti, f.x_CodInternoArti);

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
	global $objForm, $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->setFormValue($objForm->GetValue("x_idItemPedido"));
	$walger_items_pedidos->idPedido->setFormValue($objForm->GetValue("x_idPedido"));
	$walger_items_pedidos->CodInternoArti->setFormValue($objForm->GetValue("x_CodInternoArti"));
	$walger_items_pedidos->precio->setFormValue($objForm->GetValue("x_precio"));
	$walger_items_pedidos->cantidad->setFormValue($objForm->GetValue("x_cantidad"));
	$walger_items_pedidos->estado->setFormValue($objForm->GetValue("x_estado"));
	$walger_items_pedidos->fechaEntregado->setFormValue($objForm->GetValue("x_fechaEntregado"));
	$walger_items_pedidos->fechaEntregado->CurrentValue = ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7);
}

// Restore form values
function RestoreFormValues() {
	global $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->CurrentValue = $walger_items_pedidos->idItemPedido->FormValue;
	$walger_items_pedidos->idPedido->CurrentValue = $walger_items_pedidos->idPedido->FormValue;
	$walger_items_pedidos->CodInternoArti->CurrentValue = $walger_items_pedidos->CodInternoArti->FormValue;
	$walger_items_pedidos->precio->CurrentValue = $walger_items_pedidos->precio->FormValue;
	$walger_items_pedidos->cantidad->CurrentValue = $walger_items_pedidos->cantidad->FormValue;
	$walger_items_pedidos->estado->CurrentValue = $walger_items_pedidos->estado->FormValue;
	$walger_items_pedidos->fechaEntregado->CurrentValue = $walger_items_pedidos->fechaEntregado->FormValue;
	$walger_items_pedidos->fechaEntregado->CurrentValue = ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7);
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_items_pedidos;
	$sFilter = $walger_items_pedidos->SqlKeyFilter();
	if (!is_numeric($walger_items_pedidos->idItemPedido->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idItemPedido@", ew_AdjustSql($walger_items_pedidos->idItemPedido->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_items_pedidos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_items_pedidos->CurrentFilter = $sFilter;
	$sSql = $walger_items_pedidos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_items_pedidos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_items_pedidos;
	$walger_items_pedidos->idItemPedido->setDbValue($rs->fields('idItemPedido'));
	$walger_items_pedidos->idPedido->setDbValue($rs->fields('idPedido'));
	$walger_items_pedidos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$walger_items_pedidos->precio->setDbValue($rs->fields('precio'));
	$walger_items_pedidos->cantidad->setDbValue($rs->fields('cantidad'));
	$walger_items_pedidos->estado->setDbValue($rs->fields('estado'));
	$walger_items_pedidos->fechaEntregado->setDbValue($rs->fields('fechaEntregado'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_items_pedidos;

	// Call Row Rendering event
	$walger_items_pedidos->Row_Rendering();

	// Common render codes for all row types
	// idItemPedido

	$walger_items_pedidos->idItemPedido->CellCssStyle = "";
	$walger_items_pedidos->idItemPedido->CellCssClass = "";

	// idPedido
	$walger_items_pedidos->idPedido->CellCssStyle = "";
	$walger_items_pedidos->idPedido->CellCssClass = "";

	// CodInternoArti
	$walger_items_pedidos->CodInternoArti->CellCssStyle = "";
	$walger_items_pedidos->CodInternoArti->CellCssClass = "";

	// precio
	$walger_items_pedidos->precio->CellCssStyle = "";
	$walger_items_pedidos->precio->CellCssClass = "";

	// cantidad
	$walger_items_pedidos->cantidad->CellCssStyle = "";
	$walger_items_pedidos->cantidad->CellCssClass = "";

	// estado
	$walger_items_pedidos->estado->CellCssStyle = "";
	$walger_items_pedidos->estado->CellCssClass = "";

	// fechaEntregado
	$walger_items_pedidos->fechaEntregado->CellCssStyle = "";
	$walger_items_pedidos->fechaEntregado->CellCssClass = "";
	if ($walger_items_pedidos->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row

		// idItemPedido
		$walger_items_pedidos->idItemPedido->EditCustomAttributes = "";
		$walger_items_pedidos->idItemPedido->EditValue = $walger_items_pedidos->idItemPedido->CurrentValue;
		$walger_items_pedidos->idItemPedido->CssStyle = "";
		$walger_items_pedidos->idItemPedido->CssClass = "";
		$walger_items_pedidos->idItemPedido->ViewCustomAttributes = "";

		// idPedido
		$walger_items_pedidos->idPedido->EditCustomAttributes = "";
		$walger_items_pedidos->idPedido->EditValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";

		// CodInternoArti
		$walger_items_pedidos->CodInternoArti->EditCustomAttributes = "";
		if (!is_null($walger_items_pedidos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_items_pedidos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_items_pedidos->CodInternoArti->EditValue = $rswrk->fields('CodInternoArti');
					$walger_items_pedidos->CodInternoArti->EditValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_items_pedidos->CodInternoArti->EditValue = $walger_items_pedidos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_items_pedidos->CodInternoArti->EditValue = NULL;
		}
		$walger_items_pedidos->CodInternoArti->CssStyle = "";
		$walger_items_pedidos->CodInternoArti->CssClass = "";
		$walger_items_pedidos->CodInternoArti->ViewCustomAttributes = "";

		// precio
		$walger_items_pedidos->precio->EditCustomAttributes = "";
		$walger_items_pedidos->precio->EditValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$walger_items_pedidos->cantidad->EditCustomAttributes = "";
		$walger_items_pedidos->cantidad->EditValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";

		// estado
		$walger_items_pedidos->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array("P", "Pendiente de entrega");
		$arwrk[] = array("F", "Facturado");
		$arwrk[] = array("C", "Cancelado");
		array_unshift($arwrk, array("", "Seleccione"));
		$walger_items_pedidos->estado->EditValue = $arwrk;

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->EditCustomAttributes = "";
		$walger_items_pedidos->fechaEntregado->EditValue = ew_HtmlEncode(ew_FormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7));

		// idPedido
		$walger_items_pedidos->idPedido->ViewValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";
		$walger_items_pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		if (!is_null($walger_items_pedidos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_items_pedidos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_items_pedidos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_items_pedidos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_items_pedidos->CodInternoArti->ViewValue = $walger_items_pedidos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_items_pedidos->CodInternoArti->ViewValue = NULL;
		}
		$walger_items_pedidos->CodInternoArti->CssStyle = "";
		$walger_items_pedidos->CodInternoArti->CssClass = "";
		$walger_items_pedidos->CodInternoArti->ViewCustomAttributes = "";
		$walger_items_pedidos->CodInternoArti->HrefValue = "";

		// precio
		$walger_items_pedidos->precio->ViewValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";
		$walger_items_pedidos->precio->HrefValue = "";

		// cantidad
		$walger_items_pedidos->cantidad->ViewValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";
		$walger_items_pedidos->cantidad->HrefValue = "";
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_items_pedidos->Row_Rendered();
}
?>
<?php

// Update record based on key values
function EditRow() {
	global $conn, $Security, $walger_items_pedidos;
	$sFilter = $walger_items_pedidos->SqlKeyFilter();
	if (!is_numeric($walger_items_pedidos->idItemPedido->CurrentValue)) {
		return FALSE;
	}
	$sFilter = str_replace("@idItemPedido@", ew_AdjustSql($walger_items_pedidos->idItemPedido->CurrentValue), $sFilter); // Replace key value
	$walger_items_pedidos->CurrentFilter = $sFilter;
	$sSql = $walger_items_pedidos->SQL();
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

		// Field idItemPedido
		// Field estado

		$walger_items_pedidos->estado->SetDbValueDef($walger_items_pedidos->estado->CurrentValue, "");
		$rsnew['estado'] =& $walger_items_pedidos->estado->DbValue;

		// Field fechaEntregado
		$walger_items_pedidos->fechaEntregado->SetDbValueDef(ew_UnFormatDateTime($walger_items_pedidos->fechaEntregado->CurrentValue, 7), NULL);
		$rsnew['fechaEntregado'] =& $walger_items_pedidos->fechaEntregado->DbValue;

		// Call Row Updating event
		$bUpdateRow = $walger_items_pedidos->Row_Updating($rsold, $rsnew);
		if ($bUpdateRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$EditRow = $conn->Execute($walger_items_pedidos->UpdateSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($walger_items_pedidos->CancelMessage <> "") {
				$_SESSION[EW_SESSION_MESSAGE] = $walger_items_pedidos->CancelMessage;
				$walger_items_pedidos->CancelMessage = "";
			} else {
				$_SESSION[EW_SESSION_MESSAGE] = "Actualizar";
			}
			$EditRow = FALSE;
		}
	}

	// Call Row Updated event
	if ($EditRow) {
		$walger_items_pedidos->Row_Updated($rsold, $rsnew);
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
