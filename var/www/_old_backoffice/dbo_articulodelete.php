<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["CodInternoArti"] <> "") {
	$dbo_articulo->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
	$sKey .= $dbo_articulo->CodInternoArti->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($dbo_articulo->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	$sFilter .= "`CodInternoArti`='" . ew_AdjustSql($sKeyFld) . "' AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in dbo_articulo class, dbo_articuloinfo.php

$dbo_articulo->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$dbo_articulo->CurrentAction = $_POST["a_delete"];
} else {
	$dbo_articulo->CurrentAction = "D"; // Delete record directly
}
switch ($dbo_articulo->CurrentAction) {
	case "D": // Delete
		$dbo_articulo->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($dbo_articulo->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($dbo_articulo->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Artículos (ISIS)<br><br><a href="<?php echo $dbo_articulo->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="dbo_articulodelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">Codigo Interno</td>
		<td valign="top">Codigo de Barras</td>
		<td valign="top">Catálogo</td>
		<td valign="top">Línea</td>
		<td valign="top">Marca</td>
		<td valign="top">Tasa IVA</td>
		<td valign="top">Precio de Venta</td>
		<td valign="top">Descripcion</td>
		<td valign="top">Ruta a la Foto</td>
		<td valign="top">Stock</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$dbo_articulo->CssClass = "ewTableRow";
	$dbo_articulo->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$dbo_articulo->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$dbo_articulo->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $dbo_articulo->DisplayAttributes() ?>>
		<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodInternoArti->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>><?php echo $dbo_articulo->CodBarraArti->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt4->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt3->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>><?php echo $dbo_articulo->DescrNivelInt2->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->TasaIva->CellAttributes() ?>>
<div<?php echo $dbo_articulo->TasaIva->ViewAttributes() ?>><?php echo $dbo_articulo->TasaIva->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>><?php echo $dbo_articulo->PrecioVta1_PreArti->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>><?php echo $dbo_articulo->DescripcionArti->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>><?php echo $dbo_articulo->NombreFotoArti->ViewValue ?></div>
</td>
		<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<div<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>><?php echo $dbo_articulo->Stock1_StkArti->ViewValue ?></div>
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
	global $conn, $Security, $dbo_articulo;
	$DeleteRows = TRUE;
	$sWrkFilter = $dbo_articulo->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in dbo_articulo class, dbo_articuloinfo.php

	$dbo_articulo->CurrentFilter = $sWrkFilter;
	$sSql = $dbo_articulo->SQL();
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
			$DeleteRows = $dbo_articulo->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['CodInternoArti'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($dbo_articulo->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($dbo_articulo->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_articulo->CancelMessage;
			$dbo_articulo->CancelMessage = "";
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
			$dbo_articulo->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_articulo;

	// Call Recordset Selecting event
	$dbo_articulo->Recordset_Selecting($dbo_articulo->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_articulo->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_articulo->Recordset_Selected($rs);
	return $rs;
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

		// CodInternoArti
		$dbo_articulo->CodInternoArti->ViewValue = $dbo_articulo->CodInternoArti->CurrentValue;
		$dbo_articulo->CodInternoArti->CssStyle = "";
		$dbo_articulo->CodInternoArti->CssClass = "";
		$dbo_articulo->CodInternoArti->ViewCustomAttributes = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->ViewValue = $dbo_articulo->CodBarraArti->CurrentValue;
		$dbo_articulo->CodBarraArti->CssStyle = "";
		$dbo_articulo->CodBarraArti->CssClass = "";
		$dbo_articulo->CodBarraArti->ViewCustomAttributes = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->ViewValue = $dbo_articulo->DescrNivelInt4->CurrentValue;
		$dbo_articulo->DescrNivelInt4->CssStyle = "";
		$dbo_articulo->DescrNivelInt4->CssClass = "";
		$dbo_articulo->DescrNivelInt4->ViewCustomAttributes = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->ViewValue = $dbo_articulo->DescrNivelInt3->CurrentValue;
		$dbo_articulo->DescrNivelInt3->CssStyle = "";
		$dbo_articulo->DescrNivelInt3->CssClass = "";
		$dbo_articulo->DescrNivelInt3->ViewCustomAttributes = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->ViewValue = $dbo_articulo->DescrNivelInt2->CurrentValue;
		$dbo_articulo->DescrNivelInt2->CssStyle = "";
		$dbo_articulo->DescrNivelInt2->CssClass = "";
		$dbo_articulo->DescrNivelInt2->ViewCustomAttributes = "";

		// TasaIva
		$dbo_articulo->TasaIva->ViewValue = $dbo_articulo->TasaIva->CurrentValue;
		$dbo_articulo->TasaIva->CssStyle = "";
		$dbo_articulo->TasaIva->CssClass = "";
		$dbo_articulo->TasaIva->ViewCustomAttributes = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->ViewValue = $dbo_articulo->PrecioVta1_PreArti->CurrentValue;
		$dbo_articulo->PrecioVta1_PreArti->CssStyle = "";
		$dbo_articulo->PrecioVta1_PreArti->CssClass = "";
		$dbo_articulo->PrecioVta1_PreArti->ViewCustomAttributes = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->ViewValue = $dbo_articulo->DescripcionArti->CurrentValue;
		$dbo_articulo->DescripcionArti->CssStyle = "";
		$dbo_articulo->DescripcionArti->CssClass = "";
		$dbo_articulo->DescripcionArti->ViewCustomAttributes = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->ViewValue = $dbo_articulo->NombreFotoArti->CurrentValue;
		$dbo_articulo->NombreFotoArti->CssStyle = "";
		$dbo_articulo->NombreFotoArti->CssClass = "";
		$dbo_articulo->NombreFotoArti->ViewCustomAttributes = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->ViewValue = $dbo_articulo->Stock1_StkArti->CurrentValue;
		$dbo_articulo->Stock1_StkArti->CssStyle = "";
		$dbo_articulo->Stock1_StkArti->CssClass = "";
		$dbo_articulo->Stock1_StkArti->ViewCustomAttributes = "";

		// CodInternoArti
		$dbo_articulo->CodInternoArti->HrefValue = "";

		// CodBarraArti
		$dbo_articulo->CodBarraArti->HrefValue = "";

		// DescrNivelInt4
		$dbo_articulo->DescrNivelInt4->HrefValue = "";

		// DescrNivelInt3
		$dbo_articulo->DescrNivelInt3->HrefValue = "";

		// DescrNivelInt2
		$dbo_articulo->DescrNivelInt2->HrefValue = "";

		// TasaIva
		$dbo_articulo->TasaIva->HrefValue = "";

		// PrecioVta1_PreArti
		$dbo_articulo->PrecioVta1_PreArti->HrefValue = "";

		// DescripcionArti
		$dbo_articulo->DescripcionArti->HrefValue = "";

		// NombreFotoArti
		$dbo_articulo->NombreFotoArti->HrefValue = "";

		// Stock1_StkArti
		$dbo_articulo->Stock1_StkArti->HrefValue = "";
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_articulo->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_articulo->Row_Rendered();
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
