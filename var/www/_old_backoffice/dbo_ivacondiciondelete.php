<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'dbo_ivacondicion', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "dbo_ivacondicioninfo.php" ?>
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
$dbo_ivacondicion->Export = @$_GET["export"]; // Get export parameter
$sExport = $dbo_ivacondicion->Export; // Get export parameter, used in header
$sExportFile = $dbo_ivacondicion->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["Regis_IvaC"] <> "") {
	$dbo_ivacondicion->Regis_IvaC->setQueryStringValue($_GET["Regis_IvaC"]);
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->QueryStringValue)) {
		Page_Terminate($dbo_ivacondicion->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $dbo_ivacondicion->Regis_IvaC->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($dbo_ivacondicion->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($dbo_ivacondicion->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`Regis_IvaC`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in dbo_ivacondicion class, dbo_ivacondicioninfo.php

$dbo_ivacondicion->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$dbo_ivacondicion->CurrentAction = $_POST["a_delete"];
} else {
	$dbo_ivacondicion->CurrentAction = "D"; // Delete record directly
}
switch ($dbo_ivacondicion->CurrentAction) {
	case "D": // Delete
		$dbo_ivacondicion->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($dbo_ivacondicion->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($dbo_ivacondicion->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Condiciones IVA (ISIS)<br><br><a href="<?php echo $dbo_ivacondicion->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="dbo_ivacondiciondelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID</td>
		<td valign="top">Descripción</td>
		<td valign="top">Calcula Iva ?</td>
		<td valign="top">Discrimina Iva ?</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$dbo_ivacondicion->CssClass = "ewTableRow";
	$dbo_ivacondicion->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$dbo_ivacondicion->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$dbo_ivacondicion->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $dbo_ivacondicion->DisplayAttributes() ?>>
		<td<?php echo $dbo_ivacondicion->Regis_IvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->Regis_IvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->Regis_IvaC->ViewValue ?></div>
</td>
		<td<?php echo $dbo_ivacondicion->DescrIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DescrIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DescrIvaC->ViewValue ?></div>
</td>
		<td<?php echo $dbo_ivacondicion->CalculaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->CalculaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->CalculaIvaC->ViewValue ?></div>
</td>
		<td<?php echo $dbo_ivacondicion->DiscriminaIvaC->CellAttributes() ?>>
<div<?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewAttributes() ?>><?php echo $dbo_ivacondicion->DiscriminaIvaC->ViewValue ?></div>
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
	global $conn, $Security, $dbo_ivacondicion;
	$DeleteRows = TRUE;
	$sWrkFilter = $dbo_ivacondicion->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in dbo_ivacondicion class, dbo_ivacondicioninfo.php

	$dbo_ivacondicion->CurrentFilter = $sWrkFilter;
	$sSql = $dbo_ivacondicion->SQL();
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
			$DeleteRows = $dbo_ivacondicion->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['Regis_IvaC'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($dbo_ivacondicion->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($dbo_ivacondicion->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_ivacondicion->CancelMessage;
			$dbo_ivacondicion->CancelMessage = "";
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
			$dbo_ivacondicion->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_ivacondicion;

	// Call Recordset Selecting event
	$dbo_ivacondicion->Recordset_Selecting($dbo_ivacondicion->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_ivacondicion->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_ivacondicion->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $dbo_ivacondicion;
	$sFilter = $dbo_ivacondicion->SqlKeyFilter();
	if (!is_numeric($dbo_ivacondicion->Regis_IvaC->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@Regis_IvaC@", ew_AdjustSql($dbo_ivacondicion->Regis_IvaC->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$dbo_ivacondicion->Row_Selecting($sFilter);

	// Load sql based on filter
	$dbo_ivacondicion->CurrentFilter = $sFilter;
	$sSql = $dbo_ivacondicion->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$dbo_ivacondicion->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $dbo_ivacondicion;
	$dbo_ivacondicion->Regis_IvaC->setDbValue($rs->fields('Regis_IvaC'));
	$dbo_ivacondicion->DescrIvaC->setDbValue($rs->fields('DescrIvaC'));
	$dbo_ivacondicion->CalculaIvaC->setDbValue($rs->fields('CalculaIvaC'));
	$dbo_ivacondicion->DiscriminaIvaC->setDbValue($rs->fields('DiscriminaIvaC'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $dbo_ivacondicion;

	// Call Row Rendering event
	$dbo_ivacondicion->Row_Rendering();

	// Common render codes for all row types
	// Regis_IvaC

	$dbo_ivacondicion->Regis_IvaC->CellCssStyle = "";
	$dbo_ivacondicion->Regis_IvaC->CellCssClass = "";

	// DescrIvaC
	$dbo_ivacondicion->DescrIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DescrIvaC->CellCssClass = "";

	// CalculaIvaC
	$dbo_ivacondicion->CalculaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->CalculaIvaC->CellCssClass = "";

	// DiscriminaIvaC
	$dbo_ivacondicion->DiscriminaIvaC->CellCssStyle = "";
	$dbo_ivacondicion->DiscriminaIvaC->CellCssClass = "";
	if ($dbo_ivacondicion->RowType == EW_ROWTYPE_VIEW) { // View row

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->ViewValue = $dbo_ivacondicion->Regis_IvaC->CurrentValue;
		$dbo_ivacondicion->Regis_IvaC->CssStyle = "";
		$dbo_ivacondicion->Regis_IvaC->CssClass = "";
		$dbo_ivacondicion->Regis_IvaC->ViewCustomAttributes = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->ViewValue = $dbo_ivacondicion->DescrIvaC->CurrentValue;
		$dbo_ivacondicion->DescrIvaC->CssStyle = "";
		$dbo_ivacondicion->DescrIvaC->CssClass = "";
		$dbo_ivacondicion->DescrIvaC->ViewCustomAttributes = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->ViewValue = $dbo_ivacondicion->CalculaIvaC->CurrentValue;
		$dbo_ivacondicion->CalculaIvaC->CssStyle = "";
		$dbo_ivacondicion->CalculaIvaC->CssClass = "";
		$dbo_ivacondicion->CalculaIvaC->ViewCustomAttributes = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->ViewValue = $dbo_ivacondicion->DiscriminaIvaC->CurrentValue;
		$dbo_ivacondicion->DiscriminaIvaC->CssStyle = "";
		$dbo_ivacondicion->DiscriminaIvaC->CssClass = "";
		$dbo_ivacondicion->DiscriminaIvaC->ViewCustomAttributes = "";

		// Regis_IvaC
		$dbo_ivacondicion->Regis_IvaC->HrefValue = "";

		// DescrIvaC
		$dbo_ivacondicion->DescrIvaC->HrefValue = "";

		// CalculaIvaC
		$dbo_ivacondicion->CalculaIvaC->HrefValue = "";

		// DiscriminaIvaC
		$dbo_ivacondicion->DiscriminaIvaC->HrefValue = "";
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_ivacondicion->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_ivacondicion->Row_Rendered();
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
