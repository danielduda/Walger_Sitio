<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_moneda', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_monedainfo.php" ?>
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
$dbo_moneda->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_moneda->Export; // Get export parameter, used in header
$sExportFile = $dbo_moneda->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["Regis_Mda"] <> "") {
	$dbo_moneda->Regis_Mda->setQueryStringValue($_GET["Regis_Mda"]);
	if (!is_numeric($dbo_moneda->Regis_Mda->QueryStringValue)) {
		Page_Terminate($dbo_moneda->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $dbo_moneda->Regis_Mda->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($dbo_moneda->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($dbo_moneda->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`Regis_Mda`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in dbo_moneda class, dbo_monedainfo.php

$dbo_moneda->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$dbo_moneda->CurrentAction = $_POST["a_delete"];
} else {
	$dbo_moneda->CurrentAction = "D"; // Delete record directly
}
switch ($dbo_moneda->CurrentAction) {
	case "D": // Delete
		$dbo_moneda->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($dbo_moneda->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($dbo_moneda->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Monedas (ISIS)<br><br><a href="<?php echo $dbo_moneda->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="dbo_monedadelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID</td>
		<td valign="top">Descripción</td>
		<td valign="top">Signo</td>
		<td valign="top">Cotización</td>
		<td valign="top">Código AFIP</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$dbo_moneda->CssClass = "ewTableRow";
	$dbo_moneda->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$dbo_moneda->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$dbo_moneda->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $dbo_moneda->DisplayAttributes() ?>>
		<td<?php echo $dbo_moneda->Regis_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Regis_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Regis_Mda->ViewValue ?></div>
</td>
		<td<?php echo $dbo_moneda->Descr_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Descr_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Descr_Mda->ViewValue ?></div>
</td>
		<td<?php echo $dbo_moneda->Signo_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Signo_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Signo_Mda->ViewValue ?></div>
</td>
		<td<?php echo $dbo_moneda->Cotiz_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->Cotiz_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->Cotiz_Mda->ViewValue ?></div>
</td>
		<td<?php echo $dbo_moneda->CodigoAFIP_Mda->CellAttributes() ?>>
<div<?php echo $dbo_moneda->CodigoAFIP_Mda->ViewAttributes() ?>><?php echo $dbo_moneda->CodigoAFIP_Mda->ViewValue ?></div>
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
	global $conn, $Security, $dbo_moneda;
	$DeleteRows = TRUE;
	$sWrkFilter = $dbo_moneda->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in dbo_moneda class, dbo_monedainfo.php

	$dbo_moneda->CurrentFilter = $sWrkFilter;
	$sSql = $dbo_moneda->SQL();
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
			$DeleteRows = $dbo_moneda->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['Regis_Mda'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($dbo_moneda->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($dbo_moneda->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_moneda->CancelMessage;
			$dbo_moneda->CancelMessage = "";
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
			$dbo_moneda->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_moneda;

	// Call Recordset Selecting event
	$dbo_moneda->Recordset_Selecting($dbo_moneda->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_moneda->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_moneda->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_moneda;
	$sFilter = $dbo_moneda->SqlKeyFilter();
	if (!is_numeric($dbo_moneda->Regis_Mda->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_Mda@", ew_AdjustSql($dbo_moneda->Regis_Mda->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_moneda->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_moneda->CurrentFilter = $sFilter;
	$sSql = $dbo_moneda->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_moneda->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_moneda;
	$dbo_moneda->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$dbo_moneda->Descr_Mda->setDbValue($rs->fields('Descr_Mda'));
	$dbo_moneda->Signo_Mda->setDbValue($rs->fields('Signo_Mda'));
	$dbo_moneda->Cotiz_Mda->setDbValue($rs->fields('Cotiz_Mda'));
	$dbo_moneda->CodigoAFIP_Mda->setDbValue($rs->fields('CodigoAFIP_Mda'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_moneda;

	// Call Row Rendering event
	$dbo_moneda->Row_Rendering();

	// Common render codes for all row types
	// Regis_Mda

	$dbo_moneda->Regis_Mda->CellCssStyle = "";
	$dbo_moneda->Regis_Mda->CellCssClass = "";

	// Descr_Mda
	$dbo_moneda->Descr_Mda->CellCssStyle = "";
	$dbo_moneda->Descr_Mda->CellCssClass = "";

	// Signo_Mda
	$dbo_moneda->Signo_Mda->CellCssStyle = "";
	$dbo_moneda->Signo_Mda->CellCssClass = "";

	// Cotiz_Mda
	$dbo_moneda->Cotiz_Mda->CellCssStyle = "";
	$dbo_moneda->Cotiz_Mda->CellCssClass = "";

	// CodigoAFIP_Mda
	$dbo_moneda->CodigoAFIP_Mda->CellCssStyle = "";
	$dbo_moneda->CodigoAFIP_Mda->CellCssClass = "";
	if ($dbo_moneda->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_Mda
		$dbo_moneda->Regis_Mda->ViewValue = $dbo_moneda->Regis_Mda->CurrentValue;
		$dbo_moneda->Regis_Mda->CssStyle = "";
		$dbo_moneda->Regis_Mda->CssClass = "";
		$dbo_moneda->Regis_Mda->ViewCustomAttributes = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->ViewValue = $dbo_moneda->Descr_Mda->CurrentValue;
		$dbo_moneda->Descr_Mda->CssStyle = "";
		$dbo_moneda->Descr_Mda->CssClass = "";
		$dbo_moneda->Descr_Mda->ViewCustomAttributes = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->ViewValue = $dbo_moneda->Signo_Mda->CurrentValue;
		$dbo_moneda->Signo_Mda->CssStyle = "";
		$dbo_moneda->Signo_Mda->CssClass = "";
		$dbo_moneda->Signo_Mda->ViewCustomAttributes = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->ViewValue = $dbo_moneda->Cotiz_Mda->CurrentValue;
		$dbo_moneda->Cotiz_Mda->CssStyle = "";
		$dbo_moneda->Cotiz_Mda->CssClass = "";
		$dbo_moneda->Cotiz_Mda->ViewCustomAttributes = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->ViewValue = $dbo_moneda->CodigoAFIP_Mda->CurrentValue;
		$dbo_moneda->CodigoAFIP_Mda->CssStyle = "";
		$dbo_moneda->CodigoAFIP_Mda->CssClass = "";
		$dbo_moneda->CodigoAFIP_Mda->ViewCustomAttributes = "";

		// Regis_Mda
		$dbo_moneda->Regis_Mda->HrefValue = "";

		// Descr_Mda
		$dbo_moneda->Descr_Mda->HrefValue = "";

		// Signo_Mda
		$dbo_moneda->Signo_Mda->HrefValue = "";

		// Cotiz_Mda
		$dbo_moneda->Cotiz_Mda->HrefValue = "";

		// CodigoAFIP_Mda
		$dbo_moneda->CodigoAFIP_Mda->HrefValue = "";
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_moneda->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_moneda->Row_Rendered();
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
