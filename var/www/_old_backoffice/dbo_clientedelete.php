<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["CodigoCli"] <> "") {
	$dbo_cliente->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
	$sKey .= $dbo_cliente->CodigoCli->QueryStringValue;
} else {
	$bSingleDelete = FALSE;
}
if ($bSingleDelete) {
	$nKeySelected = 1; // Set up key selected count
	$arRecKeys[0] = $sKey;
} else {
	if (isset($_POST["key_m"])) { // Key in form
		$nKeySelected = count($_POST["key_m"]); // Set up key selected count
		$arRecKeys = ew_StripSlashes($_POST["key_m"]);
	}
}
if ($nKeySelected <= 0) Page_Terminate($dbo_cliente->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	$sFilter .= "`CodigoCli`='" . ew_AdjustSql($sKeyFld) . "' AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in dbo_cliente class, dbo_clienteinfo.php

$dbo_cliente->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$dbo_cliente->CurrentAction = $_POST["a_delete"];
} else {
	$dbo_cliente->CurrentAction = "D"; // Delete record directly
}
switch ($dbo_cliente->CurrentAction) {
	case "D": // Delete
		$dbo_cliente->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($dbo_cliente->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($dbo_cliente->getReturnUrl()); // Return to caller
}
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "delete"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Eliminar : Clientes (ISIS)<br><br><a href="<?php echo $dbo_cliente->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="dbo_clientedelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">Código</td>
		<td valign="top">Razón Social</td>
		<td valign="top">CUIT</td>
		<td valign="top">Ingresos Brutos</td>
		<td valign="top">Condición IVA</td>
		<td valign="top">Lista de Precios</td>
		<td valign="top">EMail</td>
		<td valign="top">Razón Social Flete</td>
		<td valign="top">Dirección</td>
		<td valign="top">Barrio</td>
		<td valign="top">Localidad</td>
		<td valign="top">Provincia</td>
		<td valign="top">CP</td>
		<td valign="top">País</td>
		<td valign="top">Teléfono</td>
		<td valign="top">Fax</td>
		<td valign="top">Pagina Web</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$dbo_cliente->CssClass = "ewTableRow";
	$dbo_cliente->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$dbo_cliente->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$dbo_cliente->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $dbo_cliente->DisplayAttributes() ?>>
		<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>><?php echo $dbo_cliente->CodigoCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>><?php echo $dbo_cliente->CuitCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>><?php echo $dbo_cliente->IngBrutosCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_IvaC->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_cliente->Regis_ListaPrec->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>><?php echo $dbo_cliente->emailCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<div<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>><?php echo $dbo_cliente->RazonSocialFlete->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>><?php echo $dbo_cliente->Direccion->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>><?php echo $dbo_cliente->BarrioCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>><?php echo $dbo_cliente->LocalidadCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>><?php echo $dbo_cliente->DescrProvincia->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>><?php echo $dbo_cliente->CodigoPostalCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<div<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>><?php echo $dbo_cliente->DescrPais->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<div<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>><?php echo $dbo_cliente->Telefono->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>><?php echo $dbo_cliente->FaxCli->ViewValue ?></div>
</td>
		<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<div<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>><?php echo $dbo_cliente->PaginaWebCli->ViewValue ?></div>
</td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</table>
<p>
<input type="submit" name="Action" id="Action" value="Confirmar eliminar">
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

// ------------------------------------------------
//  Function DeleteRows
//  - Delete Records based on current filter
function DeleteRows() {
	global $conn, $Security, $dbo_cliente;
	$DeleteRows = TRUE;
	$sWrkFilter = $dbo_cliente->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in dbo_cliente class, dbo_clienteinfo.php

	$dbo_cliente->CurrentFilter = $sWrkFilter;
	$sSql = $dbo_cliente->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE) {
		return FALSE;
	} elseif ($rs->EOF) {
		$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // No record found
		$rs->Close();
		return FALSE;
	}
	$conn->BeginTrans();

	// Clone old rows
	$rsold = ($rs) ? $rs->GetRows() : array();
	if ($rs) $rs->Close();

	// Call row deleting event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$DeleteRows = $dbo_cliente->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['CodigoCli'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($dbo_cliente->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($dbo_cliente->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_cliente->CancelMessage;
			$dbo_cliente->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Eliminar cancelado";
		}
	}
	if ($DeleteRows) {
		$conn->CommitTrans(); // Commit the changes
	} else {
		$conn->RollbackTrans(); // Rollback changes
	}

	// Call recordset deleted event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$dbo_cliente->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_cliente;

	// Call Recordset Selecting event
	$dbo_cliente->Recordset_Selecting($dbo_cliente->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_cliente->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_cliente->Recordset_Selected($rs);
	return $rs;
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

		// CodigoCli
		$dbo_cliente->CodigoCli->ViewValue = $dbo_cliente->CodigoCli->CurrentValue;
		$dbo_cliente->CodigoCli->CssStyle = "";
		$dbo_cliente->CodigoCli->CssClass = "";
		$dbo_cliente->CodigoCli->ViewCustomAttributes = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->ViewValue = $dbo_cliente->RazonSocialCli->CurrentValue;
		$dbo_cliente->RazonSocialCli->CssStyle = "";
		$dbo_cliente->RazonSocialCli->CssClass = "";
		$dbo_cliente->RazonSocialCli->ViewCustomAttributes = "";

		// CuitCli
		$dbo_cliente->CuitCli->ViewValue = $dbo_cliente->CuitCli->CurrentValue;
		$dbo_cliente->CuitCli->CssStyle = "";
		$dbo_cliente->CuitCli->CssClass = "";
		$dbo_cliente->CuitCli->ViewCustomAttributes = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->ViewValue = $dbo_cliente->IngBrutosCli->CurrentValue;
		$dbo_cliente->IngBrutosCli->CssStyle = "";
		$dbo_cliente->IngBrutosCli->CssClass = "";
		$dbo_cliente->IngBrutosCli->ViewCustomAttributes = "";

		// Regis_IvaC
		if (!is_null($dbo_cliente->Regis_IvaC->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrIvaC` FROM `dbo_ivacondicion` WHERE `Regis_IvaC` = " . ew_AdjustSql($dbo_cliente->Regis_IvaC->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrIvaC` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_IvaC->ViewValue = $rswrk->fields('DescrIvaC');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_IvaC->ViewValue = $dbo_cliente->Regis_IvaC->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_IvaC->ViewValue = NULL;
		}
		$dbo_cliente->Regis_IvaC->CssStyle = "";
		$dbo_cliente->Regis_IvaC->CssClass = "";
		$dbo_cliente->Regis_IvaC->ViewCustomAttributes = "";

		// Regis_ListaPrec
		if (!is_null($dbo_cliente->Regis_ListaPrec->CurrentValue)) {
			$sSqlWrk = "SELECT `DescrListaPrec`, `CodigListaPrec` FROM `dbo_listaprecios` WHERE `Regis_ListaPrec` = " . ew_AdjustSql($dbo_cliente->Regis_ListaPrec->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `DescrListaPrec` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$dbo_cliente->Regis_ListaPrec->ViewValue = $rswrk->fields('DescrListaPrec');
					$dbo_cliente->Regis_ListaPrec->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigListaPrec');
				}
				$rswrk->Close();
			} else {
				$dbo_cliente->Regis_ListaPrec->ViewValue = $dbo_cliente->Regis_ListaPrec->CurrentValue;
			}
		} else {
			$dbo_cliente->Regis_ListaPrec->ViewValue = NULL;
		}
		$dbo_cliente->Regis_ListaPrec->CssStyle = "";
		$dbo_cliente->Regis_ListaPrec->CssClass = "";
		$dbo_cliente->Regis_ListaPrec->ViewCustomAttributes = "";

		// emailCli
		$dbo_cliente->emailCli->ViewValue = $dbo_cliente->emailCli->CurrentValue;
		$dbo_cliente->emailCli->CssStyle = "";
		$dbo_cliente->emailCli->CssClass = "";
		$dbo_cliente->emailCli->ViewCustomAttributes = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->ViewValue = $dbo_cliente->RazonSocialFlete->CurrentValue;
		$dbo_cliente->RazonSocialFlete->CssStyle = "";
		$dbo_cliente->RazonSocialFlete->CssClass = "";
		$dbo_cliente->RazonSocialFlete->ViewCustomAttributes = "";

		// Direccion
		$dbo_cliente->Direccion->ViewValue = $dbo_cliente->Direccion->CurrentValue;
		$dbo_cliente->Direccion->CssStyle = "";
		$dbo_cliente->Direccion->CssClass = "";
		$dbo_cliente->Direccion->ViewCustomAttributes = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->ViewValue = $dbo_cliente->BarrioCli->CurrentValue;
		$dbo_cliente->BarrioCli->CssStyle = "";
		$dbo_cliente->BarrioCli->CssClass = "";
		$dbo_cliente->BarrioCli->ViewCustomAttributes = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->ViewValue = $dbo_cliente->LocalidadCli->CurrentValue;
		$dbo_cliente->LocalidadCli->CssStyle = "";
		$dbo_cliente->LocalidadCli->CssClass = "";
		$dbo_cliente->LocalidadCli->ViewCustomAttributes = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->ViewValue = $dbo_cliente->DescrProvincia->CurrentValue;
		$dbo_cliente->DescrProvincia->CssStyle = "";
		$dbo_cliente->DescrProvincia->CssClass = "";
		$dbo_cliente->DescrProvincia->ViewCustomAttributes = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->ViewValue = $dbo_cliente->CodigoPostalCli->CurrentValue;
		$dbo_cliente->CodigoPostalCli->CssStyle = "";
		$dbo_cliente->CodigoPostalCli->CssClass = "";
		$dbo_cliente->CodigoPostalCli->ViewCustomAttributes = "";

		// DescrPais
		$dbo_cliente->DescrPais->ViewValue = $dbo_cliente->DescrPais->CurrentValue;
		$dbo_cliente->DescrPais->CssStyle = "";
		$dbo_cliente->DescrPais->CssClass = "";
		$dbo_cliente->DescrPais->ViewCustomAttributes = "";

		// Telefono
		$dbo_cliente->Telefono->ViewValue = $dbo_cliente->Telefono->CurrentValue;
		$dbo_cliente->Telefono->CssStyle = "";
		$dbo_cliente->Telefono->CssClass = "";
		$dbo_cliente->Telefono->ViewCustomAttributes = "";

		// FaxCli
		$dbo_cliente->FaxCli->ViewValue = $dbo_cliente->FaxCli->CurrentValue;
		$dbo_cliente->FaxCli->CssStyle = "";
		$dbo_cliente->FaxCli->CssClass = "";
		$dbo_cliente->FaxCli->ViewCustomAttributes = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->ViewValue = $dbo_cliente->PaginaWebCli->CurrentValue;
		$dbo_cliente->PaginaWebCli->CssStyle = "";
		$dbo_cliente->PaginaWebCli->CssClass = "";
		$dbo_cliente->PaginaWebCli->ViewCustomAttributes = "";

		// CodigoCli
		$dbo_cliente->CodigoCli->HrefValue = "";

		// RazonSocialCli
		$dbo_cliente->RazonSocialCli->HrefValue = "";

		// CuitCli
		$dbo_cliente->CuitCli->HrefValue = "";

		// IngBrutosCli
		$dbo_cliente->IngBrutosCli->HrefValue = "";

		// Regis_IvaC
		$dbo_cliente->Regis_IvaC->HrefValue = "";

		// Regis_ListaPrec
		$dbo_cliente->Regis_ListaPrec->HrefValue = "";

		// emailCli
		$dbo_cliente->emailCli->HrefValue = "";

		// RazonSocialFlete
		$dbo_cliente->RazonSocialFlete->HrefValue = "";

		// Direccion
		$dbo_cliente->Direccion->HrefValue = "";

		// BarrioCli
		$dbo_cliente->BarrioCli->HrefValue = "";

		// LocalidadCli
		$dbo_cliente->LocalidadCli->HrefValue = "";

		// DescrProvincia
		$dbo_cliente->DescrProvincia->HrefValue = "";

		// CodigoPostalCli
		$dbo_cliente->CodigoPostalCli->HrefValue = "";

		// DescrPais
		$dbo_cliente->DescrPais->HrefValue = "";

		// Telefono
		$dbo_cliente->Telefono->HrefValue = "";

		// FaxCli
		$dbo_cliente->FaxCli->HrefValue = "";

		// PaginaWebCli
		$dbo_cliente->PaginaWebCli->HrefValue = "";
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_cliente->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_cliente->Row_Rendered();
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
