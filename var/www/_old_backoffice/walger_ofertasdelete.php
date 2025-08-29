<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_ofertas', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_ofertasinfo.php" ?>
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
$walger_ofertas->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_ofertas->Export; // Get export parameter, used in header
$sExportFile = $walger_ofertas->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["idOferta"] <> "") {
	$walger_ofertas->idOferta->setQueryStringValue($_GET["idOferta"]);
	if (!is_numeric($walger_ofertas->idOferta->QueryStringValue)) {
		Page_Terminate($walger_ofertas->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $walger_ofertas->idOferta->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($walger_ofertas->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($walger_ofertas->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`idOferta`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in walger_ofertas class, walger_ofertasinfo.php

$walger_ofertas->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$walger_ofertas->CurrentAction = $_POST["a_delete"];
} else {
	$walger_ofertas->CurrentAction = "D"; // Delete record directly
}
switch ($walger_ofertas->CurrentAction) {
	case "D": // Delete
		$walger_ofertas->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($walger_ofertas->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($walger_ofertas->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Ofertas<br><br><a href="<?php echo $walger_ofertas->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="walger_ofertasdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">id Oferta</td>
		<td valign="top">Oferta</td>
		<td valign="top">Activo ?</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$walger_ofertas->CssClass = "ewTableRow";
	$walger_ofertas->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$walger_ofertas->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$walger_ofertas->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $walger_ofertas->DisplayAttributes() ?>>
		<td<?php echo $walger_ofertas->idOferta->CellAttributes() ?>>
<div<?php echo $walger_ofertas->idOferta->ViewAttributes() ?>><?php echo $walger_ofertas->idOferta->ViewValue ?></div>
</td>
		<td<?php echo $walger_ofertas->oferta->CellAttributes() ?>>
<div<?php echo $walger_ofertas->oferta->ViewAttributes() ?>><?php echo $walger_ofertas->oferta->ViewValue ?></div>
</td>
		<td<?php echo $walger_ofertas->activo->CellAttributes() ?>>
<div<?php echo $walger_ofertas->activo->ViewAttributes() ?>><?php echo $walger_ofertas->activo->ViewValue ?></div>
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
	global $conn, $Security, $walger_ofertas;
	$DeleteRows = TRUE;
	$sWrkFilter = $walger_ofertas->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in walger_ofertas class, walger_ofertasinfo.php

	$walger_ofertas->CurrentFilter = $sWrkFilter;
	$sSql = $walger_ofertas->SQL();
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
			$DeleteRows = $walger_ofertas->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['idOferta'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($walger_ofertas->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($walger_ofertas->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_ofertas->CancelMessage;
			$walger_ofertas->CancelMessage = "";
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
			$walger_ofertas->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_ofertas;

	// Call Recordset Selecting event
	$walger_ofertas->Recordset_Selecting($walger_ofertas->CurrentFilter);

	// Load list page sql
	$sSql = $walger_ofertas->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_ofertas->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_ofertas;
	$sFilter = $walger_ofertas->SqlKeyFilter();
	if (!is_numeric($walger_ofertas->idOferta->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idOferta@", ew_AdjustSql($walger_ofertas->idOferta->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_ofertas->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_ofertas->CurrentFilter = $sFilter;
	$sSql = $walger_ofertas->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_ofertas->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_ofertas;
	$walger_ofertas->idOferta->setDbValue($rs->fields('idOferta'));
	$walger_ofertas->oferta->setDbValue($rs->fields('oferta'));
	$walger_ofertas->activo->setDbValue($rs->fields('activo'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_ofertas;

	// Call Row Rendering event
	$walger_ofertas->Row_Rendering();

	// Common render codes for all row types
	// idOferta

	$walger_ofertas->idOferta->CellCssStyle = "";
	$walger_ofertas->idOferta->CellCssClass = "";

	// oferta
	$walger_ofertas->oferta->CellCssStyle = "";
	$walger_ofertas->oferta->CellCssClass = "";

	// activo
	$walger_ofertas->activo->CellCssStyle = "";
	$walger_ofertas->activo->CellCssClass = "";
	if ($walger_ofertas->RowType == EW_ROWTYPE_VIEW) { // View row

		// idOferta
		$walger_ofertas->idOferta->ViewValue = $walger_ofertas->idOferta->CurrentValue;
		$walger_ofertas->idOferta->CssStyle = "";
		$walger_ofertas->idOferta->CssClass = "";
		$walger_ofertas->idOferta->ViewCustomAttributes = "";

		// oferta
		$walger_ofertas->oferta->ViewValue = $walger_ofertas->oferta->CurrentValue;
		$walger_ofertas->oferta->CssStyle = "";
		$walger_ofertas->oferta->CssClass = "";
		$walger_ofertas->oferta->ViewCustomAttributes = "";

		// activo
		if (!is_null($walger_ofertas->activo->CurrentValue)) {
			switch ($walger_ofertas->activo->CurrentValue) {
				case "S":
					$walger_ofertas->activo->ViewValue = "Si";
					break;
				case "N":
					$walger_ofertas->activo->ViewValue = "No";
					break;
				default:
					$walger_ofertas->activo->ViewValue = $walger_ofertas->activo->CurrentValue;
			}
		} else {
			$walger_ofertas->activo->ViewValue = NULL;
		}
		$walger_ofertas->activo->CssStyle = "";
		$walger_ofertas->activo->CssClass = "";
		$walger_ofertas->activo->ViewCustomAttributes = "";

		// idOferta
		$walger_ofertas->idOferta->HrefValue = "";

		// oferta
		$walger_ofertas->oferta->HrefValue = "";

		// activo
		$walger_ofertas->activo->HrefValue = "";
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_ofertas->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_ofertas->Row_Rendered();
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
