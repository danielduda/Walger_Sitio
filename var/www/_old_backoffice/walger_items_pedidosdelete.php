<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["idItemPedido"] <> "") {
	$walger_items_pedidos->idItemPedido->setQueryStringValue($_GET["idItemPedido"]);
	if (!is_numeric($walger_items_pedidos->idItemPedido->QueryStringValue)) {
		Page_Terminate($walger_items_pedidos->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $walger_items_pedidos->idItemPedido->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($walger_items_pedidos->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($walger_items_pedidos->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`idItemPedido`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in walger_items_pedidos class, walger_items_pedidosinfo.php

$walger_items_pedidos->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$walger_items_pedidos->CurrentAction = $_POST["a_delete"];
} else {
	$walger_items_pedidos->CurrentAction = "D"; // Delete record directly
}
switch ($walger_items_pedidos->CurrentAction) {
	case "D": // Delete
		$walger_items_pedidos->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($walger_items_pedidos->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($walger_items_pedidos->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Items Pedidos<br><br><a href="<?php echo $walger_items_pedidos->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="walger_items_pedidosdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID Item</td>
		<td valign="top">ID Pedido</td>
		<td valign="top">Artículo</td>
		<td valign="top">Precio</td>
		<td valign="top">Cantidad</td>
		<td valign="top">Estado</td>
		<td valign="top">Fecha Entregado</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$walger_items_pedidos->CssClass = "ewTableRow";
	$walger_items_pedidos->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$walger_items_pedidos->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$walger_items_pedidos->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $walger_items_pedidos->DisplayAttributes() ?>>
		<td<?php echo $walger_items_pedidos->idItemPedido->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->idItemPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idItemPedido->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->idPedido->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_items_pedidos->idPedido->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_items_pedidos->CodInternoArti->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->precio->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->precio->ViewAttributes() ?>><?php echo $walger_items_pedidos->precio->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->cantidad->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->cantidad->ViewAttributes() ?>><?php echo $walger_items_pedidos->cantidad->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->estado->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->estado->ViewAttributes() ?>><?php echo $walger_items_pedidos->estado->ViewValue ?></div>
</td>
		<td<?php echo $walger_items_pedidos->fechaEntregado->CellAttributes() ?>>
<div<?php echo $walger_items_pedidos->fechaEntregado->ViewAttributes() ?>><?php echo $walger_items_pedidos->fechaEntregado->ViewValue ?></div>
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
	global $conn, $Security, $walger_items_pedidos;
	$DeleteRows = TRUE;
	$sWrkFilter = $walger_items_pedidos->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in walger_items_pedidos class, walger_items_pedidosinfo.php

	$walger_items_pedidos->CurrentFilter = $sWrkFilter;
	$sSql = $walger_items_pedidos->SQL();
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
			$DeleteRows = $walger_items_pedidos->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['idItemPedido'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($walger_items_pedidos->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($walger_items_pedidos->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_items_pedidos->CancelMessage;
			$walger_items_pedidos->CancelMessage = "";
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
			$walger_items_pedidos->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_items_pedidos;

	// Call Recordset Selecting event
	$walger_items_pedidos->Recordset_Selecting($walger_items_pedidos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_items_pedidos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_items_pedidos->Recordset_Selected($rs);
	return $rs;
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

		// idItemPedido
		$walger_items_pedidos->idItemPedido->ViewValue = $walger_items_pedidos->idItemPedido->CurrentValue;
		$walger_items_pedidos->idItemPedido->CssStyle = "";
		$walger_items_pedidos->idItemPedido->CssClass = "";
		$walger_items_pedidos->idItemPedido->ViewCustomAttributes = "";

		// idPedido
		$walger_items_pedidos->idPedido->ViewValue = $walger_items_pedidos->idPedido->CurrentValue;
		$walger_items_pedidos->idPedido->CssStyle = "";
		$walger_items_pedidos->idPedido->CssClass = "";
		$walger_items_pedidos->idPedido->ViewCustomAttributes = "";

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

		// precio
		$walger_items_pedidos->precio->ViewValue = $walger_items_pedidos->precio->CurrentValue;
		$walger_items_pedidos->precio->CssStyle = "";
		$walger_items_pedidos->precio->CssClass = "";
		$walger_items_pedidos->precio->ViewCustomAttributes = "";

		// cantidad
		$walger_items_pedidos->cantidad->ViewValue = $walger_items_pedidos->cantidad->CurrentValue;
		$walger_items_pedidos->cantidad->CssStyle = "";
		$walger_items_pedidos->cantidad->CssClass = "";
		$walger_items_pedidos->cantidad->ViewCustomAttributes = "";

		// estado
		if (!is_null($walger_items_pedidos->estado->CurrentValue)) {
			switch ($walger_items_pedidos->estado->CurrentValue) {
				case "P":
					$walger_items_pedidos->estado->ViewValue = "Pendiente de entrega";
					break;
				case "F":
					$walger_items_pedidos->estado->ViewValue = "Facturado";
					break;
				case "C":
					$walger_items_pedidos->estado->ViewValue = "Cancelado";
					break;
				default:
					$walger_items_pedidos->estado->ViewValue = $walger_items_pedidos->estado->CurrentValue;
			}
		} else {
			$walger_items_pedidos->estado->ViewValue = NULL;
		}
		$walger_items_pedidos->estado->CssStyle = "";
		$walger_items_pedidos->estado->CssClass = "";
		$walger_items_pedidos->estado->ViewCustomAttributes = "";

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->ViewValue = $walger_items_pedidos->fechaEntregado->CurrentValue;
		$walger_items_pedidos->fechaEntregado->ViewValue = ew_FormatDateTime($walger_items_pedidos->fechaEntregado->ViewValue, 7);
		$walger_items_pedidos->fechaEntregado->CssStyle = "";
		$walger_items_pedidos->fechaEntregado->CssClass = "";
		$walger_items_pedidos->fechaEntregado->ViewCustomAttributes = "";

		// idItemPedido
		$walger_items_pedidos->idItemPedido->HrefValue = "";

		// idPedido
		$walger_items_pedidos->idPedido->HrefValue = "";

		// CodInternoArti
		$walger_items_pedidos->CodInternoArti->HrefValue = "";

		// precio
		$walger_items_pedidos->precio->HrefValue = "";

		// cantidad
		$walger_items_pedidos->cantidad->HrefValue = "";

		// estado
		$walger_items_pedidos->estado->HrefValue = "";

		// fechaEntregado
		$walger_items_pedidos->fechaEntregado->HrefValue = "";
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_items_pedidos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_items_pedidos->Row_Rendered();
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
