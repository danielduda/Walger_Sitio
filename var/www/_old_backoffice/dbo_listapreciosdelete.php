<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["Regis_ListaPrec"] <> "") {
	$dbo_listaprecios->Regis_ListaPrec->setQueryStringValue($_GET["Regis_ListaPrec"]);
	if (!is_numeric($dbo_listaprecios->Regis_ListaPrec->QueryStringValue)) {
		Page_Terminate($dbo_listaprecios->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $dbo_listaprecios->Regis_ListaPrec->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($dbo_listaprecios->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($dbo_listaprecios->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`Regis_ListaPrec`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in dbo_listaprecios class, dbo_listapreciosinfo.php

$dbo_listaprecios->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$dbo_listaprecios->CurrentAction = $_POST["a_delete"];
} else {
	$dbo_listaprecios->CurrentAction = "D"; // Delete record directly
}
switch ($dbo_listaprecios->CurrentAction) {
	case "D": // Delete
		$dbo_listaprecios->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($dbo_listaprecios->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($dbo_listaprecios->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Listas de precios (ISIS)<br><br><a href="<?php echo $dbo_listaprecios->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="dbo_listapreciosdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID</td>
		<td valign="top">Código</td>
		<td valign="top">Descripción</td>
		<td valign="top">Regraba ?</td>
		<td valign="top">Lista Madre</td>
		<td valign="top">Variación Lista Madre</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$dbo_listaprecios->CssClass = "ewTableRow";
	$dbo_listaprecios->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$dbo_listaprecios->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$dbo_listaprecios->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $dbo_listaprecios->DisplayAttributes() ?>>
		<td<?php echo $dbo_listaprecios->Regis_ListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->Regis_ListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->Regis_ListaPrec->ViewValue ?></div>
</td>
		<td<?php echo $dbo_listaprecios->CodigListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->CodigListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->CodigListaPrec->ViewValue ?></div>
</td>
		<td<?php echo $dbo_listaprecios->DescrListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->DescrListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->DescrListaPrec->ViewValue ?></div>
</td>
		<td<?php echo $dbo_listaprecios->RegrabaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegrabaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegrabaPrec->ViewValue ?></div>
</td>
		<td<?php echo $dbo_listaprecios->RegisListaMadre->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->RegisListaMadre->ViewAttributes() ?>><?php echo $dbo_listaprecios->RegisListaMadre->ViewValue ?></div>
</td>
		<td<?php echo $dbo_listaprecios->VariacionListaPrec->CellAttributes() ?>>
<div<?php echo $dbo_listaprecios->VariacionListaPrec->ViewAttributes() ?>><?php echo $dbo_listaprecios->VariacionListaPrec->ViewValue ?></div>
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
	global $conn, $Security, $dbo_listaprecios;
	$DeleteRows = TRUE;
	$sWrkFilter = $dbo_listaprecios->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in dbo_listaprecios class, dbo_listapreciosinfo.php

	$dbo_listaprecios->CurrentFilter = $sWrkFilter;
	$sSql = $dbo_listaprecios->SQL();
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
			$DeleteRows = $dbo_listaprecios->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['Regis_ListaPrec'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($dbo_listaprecios->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($dbo_listaprecios->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $dbo_listaprecios->CancelMessage;
			$dbo_listaprecios->CancelMessage = "";
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
			$dbo_listaprecios->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $dbo_listaprecios;

	// Call Recordset Selecting event
	$dbo_listaprecios->Recordset_Selecting($dbo_listaprecios->CurrentFilter);

	// Load list page sql
	$sSql = $dbo_listaprecios->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$dbo_listaprecios->Recordset_Selected($rs);
	return $rs;
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

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->ViewValue = $dbo_listaprecios->Regis_ListaPrec->CurrentValue;
		$dbo_listaprecios->Regis_ListaPrec->CssStyle = "";
		$dbo_listaprecios->Regis_ListaPrec->CssClass = "";
		$dbo_listaprecios->Regis_ListaPrec->ViewCustomAttributes = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->ViewValue = $dbo_listaprecios->CodigListaPrec->CurrentValue;
		$dbo_listaprecios->CodigListaPrec->CssStyle = "";
		$dbo_listaprecios->CodigListaPrec->CssClass = "";
		$dbo_listaprecios->CodigListaPrec->ViewCustomAttributes = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->ViewValue = $dbo_listaprecios->DescrListaPrec->CurrentValue;
		$dbo_listaprecios->DescrListaPrec->CssStyle = "";
		$dbo_listaprecios->DescrListaPrec->CssClass = "";
		$dbo_listaprecios->DescrListaPrec->ViewCustomAttributes = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->ViewValue = $dbo_listaprecios->RegrabaPrec->CurrentValue;
		$dbo_listaprecios->RegrabaPrec->CssStyle = "";
		$dbo_listaprecios->RegrabaPrec->CssClass = "";
		$dbo_listaprecios->RegrabaPrec->ViewCustomAttributes = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->ViewValue = $dbo_listaprecios->RegisListaMadre->CurrentValue;
		$dbo_listaprecios->RegisListaMadre->CssStyle = "";
		$dbo_listaprecios->RegisListaMadre->CssClass = "";
		$dbo_listaprecios->RegisListaMadre->ViewCustomAttributes = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->ViewValue = $dbo_listaprecios->VariacionListaPrec->CurrentValue;
		$dbo_listaprecios->VariacionListaPrec->CssStyle = "";
		$dbo_listaprecios->VariacionListaPrec->CssClass = "";
		$dbo_listaprecios->VariacionListaPrec->ViewCustomAttributes = "";

		// Regis_ListaPrec
		$dbo_listaprecios->Regis_ListaPrec->HrefValue = "";

		// CodigListaPrec
		$dbo_listaprecios->CodigListaPrec->HrefValue = "";

		// DescrListaPrec
		$dbo_listaprecios->DescrListaPrec->HrefValue = "";

		// RegrabaPrec
		$dbo_listaprecios->RegrabaPrec->HrefValue = "";

		// RegisListaMadre
		$dbo_listaprecios->RegisListaMadre->HrefValue = "";

		// VariacionListaPrec
		$dbo_listaprecios->VariacionListaPrec->HrefValue = "";
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($dbo_listaprecios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$dbo_listaprecios->Row_Rendered();
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
