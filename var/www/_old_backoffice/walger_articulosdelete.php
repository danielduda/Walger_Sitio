<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_articulos', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_articulosinfo.php" ?>
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
$walger_articulos->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_articulos->Export; // Get export parameter, used in header
$sExportFile = $walger_articulos->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["CodInternoArti"] <> "") {
	$walger_articulos->CodInternoArti->setQueryStringValue($_GET["CodInternoArti"]);
	$sKey .= $walger_articulos->CodInternoArti->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($walger_articulos->getReturnUrl()); // No key specified, exit

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
// Sql constructor in walger_articulos class, walger_articulosinfo.php

$walger_articulos->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$walger_articulos->CurrentAction = $_POST["a_delete"];
} else {
	$walger_articulos->CurrentAction = "D"; // Delete record directly
}
switch ($walger_articulos->CurrentAction) {
	case "D": // Delete
		$walger_articulos->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($walger_articulos->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($walger_articulos->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Artículos<br><br><a href="<?php echo $walger_articulos->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="walger_articulosdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">Artículo</td>
		<td valign="top">Oferta ?</td>
		<td valign="top">Novedad ?</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$walger_articulos->CssClass = "ewTableRow";
	$walger_articulos->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$walger_articulos->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$walger_articulos->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $walger_articulos->DisplayAttributes() ?>>
		<td<?php echo $walger_articulos->CodInternoArti->CellAttributes() ?>>
<div<?php echo $walger_articulos->CodInternoArti->ViewAttributes() ?>><?php echo $walger_articulos->CodInternoArti->ViewValue ?></div>
</td>
		<td<?php echo $walger_articulos->Oferta->CellAttributes() ?>>
<div<?php echo $walger_articulos->Oferta->ViewAttributes() ?>><?php echo $walger_articulos->Oferta->ViewValue ?></div>
</td>
		<td<?php echo $walger_articulos->Novedad->CellAttributes() ?>>
<div<?php echo $walger_articulos->Novedad->ViewAttributes() ?>><?php echo $walger_articulos->Novedad->ViewValue ?></div>
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
	global $conn, $Security, $walger_articulos;
	$DeleteRows = TRUE;
	$sWrkFilter = $walger_articulos->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in walger_articulos class, walger_articulosinfo.php

	$walger_articulos->CurrentFilter = $sWrkFilter;
	$sSql = $walger_articulos->SQL();
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
			$DeleteRows = $walger_articulos->Row_Deleting($row);
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
			$DeleteRows = $conn->Execute($walger_articulos->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($walger_articulos->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_articulos->CancelMessage;
			$walger_articulos->CancelMessage = "";
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
			$walger_articulos->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_articulos;

	// Call Recordset Selecting event
	$walger_articulos->Recordset_Selecting($walger_articulos->CurrentFilter);

	// Load list page sql
	$sSql = $walger_articulos->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_articulos->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_articulos;
	$sFilter = $walger_articulos->SqlKeyFilter();
	$sFilter = str_replace("@CodInternoArti@", ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_articulos->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_articulos->CurrentFilter = $sFilter;
	$sSql = $walger_articulos->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_articulos->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_articulos;
	$walger_articulos->CodInternoArti->setDbValue($rs->fields('CodInternoArti'));
	$walger_articulos->Oferta->setDbValue($rs->fields('Oferta'));
	$walger_articulos->Novedad->setDbValue($rs->fields('Novedad'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_articulos;

	// Call Row Rendering event
	$walger_articulos->Row_Rendering();

	// Common render codes for all row types
	// CodInternoArti

	$walger_articulos->CodInternoArti->CellCssStyle = "";
	$walger_articulos->CodInternoArti->CellCssClass = "";

	// Oferta
	$walger_articulos->Oferta->CellCssStyle = "";
	$walger_articulos->Oferta->CellCssClass = "";

	// Novedad
	$walger_articulos->Novedad->CellCssStyle = "";
	$walger_articulos->Novedad->CellCssClass = "";
	if ($walger_articulos->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodInternoArti
		if (!is_null($walger_articulos->CodInternoArti->CurrentValue)) {
			$sSqlWrk = "SELECT `CodInternoArti`, `DescripcionArti` FROM `dbo_articulo` WHERE `CodInternoArti` = '" . ew_AdjustSql($walger_articulos->CodInternoArti->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `CodInternoArti` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_articulos->CodInternoArti->ViewValue = $rswrk->fields('CodInternoArti');
					$walger_articulos->CodInternoArti->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('DescripcionArti');
				}
				$rswrk->Close();
			} else {
				$walger_articulos->CodInternoArti->ViewValue = $walger_articulos->CodInternoArti->CurrentValue;
			}
		} else {
			$walger_articulos->CodInternoArti->ViewValue = NULL;
		}
		$walger_articulos->CodInternoArti->CssStyle = "";
		$walger_articulos->CodInternoArti->CssClass = "";
		$walger_articulos->CodInternoArti->ViewCustomAttributes = "";

		// Oferta
		if (!is_null($walger_articulos->Oferta->CurrentValue)) {
			switch ($walger_articulos->Oferta->CurrentValue) {
				case "S":
					$walger_articulos->Oferta->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Oferta->ViewValue = "No";
					break;
				default:
					$walger_articulos->Oferta->ViewValue = $walger_articulos->Oferta->CurrentValue;
			}
		} else {
			$walger_articulos->Oferta->ViewValue = NULL;
		}
		$walger_articulos->Oferta->CssStyle = "";
		$walger_articulos->Oferta->CssClass = "";
		$walger_articulos->Oferta->ViewCustomAttributes = "";

		// Novedad
		if (!is_null($walger_articulos->Novedad->CurrentValue)) {
			switch ($walger_articulos->Novedad->CurrentValue) {
				case "S":
					$walger_articulos->Novedad->ViewValue = "Si";
					break;
				case "N":
					$walger_articulos->Novedad->ViewValue = "No";
					break;
				default:
					$walger_articulos->Novedad->ViewValue = $walger_articulos->Novedad->CurrentValue;
			}
		} else {
			$walger_articulos->Novedad->ViewValue = NULL;
		}
		$walger_articulos->Novedad->CssStyle = "";
		$walger_articulos->Novedad->CssClass = "";
		$walger_articulos->Novedad->ViewCustomAttributes = "";

		// CodInternoArti
		$walger_articulos->CodInternoArti->HrefValue = "";

		// Oferta
		$walger_articulos->Oferta->HrefValue = "";

		// Novedad
		$walger_articulos->Novedad->HrefValue = "";
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_articulos->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_articulos->Row_Rendered();
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
