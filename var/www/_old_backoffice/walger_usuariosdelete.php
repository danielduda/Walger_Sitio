<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_usuarios', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_usuariosinfo.php" ?>
<?php include "userfn50.php" ?>
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
$walger_usuarios->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_usuarios->Export; // Get export parameter, used in header
$sExportFile = $walger_usuarios->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["idUsuario"] <> "") {
	$walger_usuarios->idUsuario->setQueryStringValue($_GET["idUsuario"]);
	if (!is_numeric($walger_usuarios->idUsuario->QueryStringValue)) {
		Page_Terminate($walger_usuarios->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $walger_usuarios->idUsuario->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($walger_usuarios->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($walger_usuarios->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`idUsuario`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in walger_usuarios class, walger_usuariosinfo.php

$walger_usuarios->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$walger_usuarios->CurrentAction = $_POST["a_delete"];
} else {
	$walger_usuarios->CurrentAction = "D"; // Delete record directly
}
switch ($walger_usuarios->CurrentAction) {
	case "D": // Delete
		$walger_usuarios->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($walger_usuarios->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($walger_usuarios->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Usuarios<br><br><a href="<?php echo $walger_usuarios->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="walger_usuariosdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID</td>
		<td valign="top">Usuario</td>
		<td valign="top">Contraseña</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$walger_usuarios->CssClass = "ewTableRow";
	$walger_usuarios->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$walger_usuarios->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$walger_usuarios->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $walger_usuarios->DisplayAttributes() ?>>
		<td<?php echo $walger_usuarios->idUsuario->CellAttributes() ?>>
<div<?php echo $walger_usuarios->idUsuario->ViewAttributes() ?>><?php echo $walger_usuarios->idUsuario->ViewValue ?></div>
</td>
		<td<?php echo $walger_usuarios->usuario->CellAttributes() ?>>
<div<?php echo $walger_usuarios->usuario->ViewAttributes() ?>><?php echo $walger_usuarios->usuario->ViewValue ?></div>
</td>
		<td<?php echo $walger_usuarios->contrasenia->CellAttributes() ?>>
<div<?php echo $walger_usuarios->contrasenia->ViewAttributes() ?>><?php echo $walger_usuarios->contrasenia->ViewValue ?></div>
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
	global $conn, $Security, $walger_usuarios;
	$DeleteRows = TRUE;
	$sWrkFilter = $walger_usuarios->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in walger_usuarios class, walger_usuariosinfo.php

	$walger_usuarios->CurrentFilter = $sWrkFilter;
	$sSql = $walger_usuarios->SQL();
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
			$DeleteRows = $walger_usuarios->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['idUsuario'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($walger_usuarios->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($walger_usuarios->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_usuarios->CancelMessage;
			$walger_usuarios->CancelMessage = "";
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
			$walger_usuarios->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_usuarios;

	// Call Recordset Selecting event
	$walger_usuarios->Recordset_Selecting($walger_usuarios->CurrentFilter);

	// Load list page sql
	$sSql = $walger_usuarios->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_usuarios->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_usuarios;
	$sFilter = $walger_usuarios->SqlKeyFilter();
	if (!is_numeric($walger_usuarios->idUsuario->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@idUsuario@", ew_AdjustSql($walger_usuarios->idUsuario->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_usuarios->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_usuarios->CurrentFilter = $sFilter;
	$sSql = $walger_usuarios->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_usuarios->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_usuarios;
	$walger_usuarios->idUsuario->setDbValue($rs->fields('idUsuario'));
	$walger_usuarios->usuario->setDbValue($rs->fields('usuario'));
	$walger_usuarios->contrasenia->setDbValue($rs->fields('contrasenia'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_usuarios;

	// Call Row Rendering event
	$walger_usuarios->Row_Rendering();

	// Common render codes for all row types
	// idUsuario

	$walger_usuarios->idUsuario->CellCssStyle = "";
	$walger_usuarios->idUsuario->CellCssClass = "";

	// usuario
	$walger_usuarios->usuario->CellCssStyle = "";
	$walger_usuarios->usuario->CellCssClass = "";

	// contrasenia
	$walger_usuarios->contrasenia->CellCssStyle = "";
	$walger_usuarios->contrasenia->CellCssClass = "";
	if ($walger_usuarios->RowType == EW_ROWTYPE_VIEW) { // View row

		// idUsuario
		$walger_usuarios->idUsuario->ViewValue = $walger_usuarios->idUsuario->CurrentValue;
		$walger_usuarios->idUsuario->CssStyle = "";
		$walger_usuarios->idUsuario->CssClass = "";
		$walger_usuarios->idUsuario->ViewCustomAttributes = "";

		// usuario
		$walger_usuarios->usuario->ViewValue = $walger_usuarios->usuario->CurrentValue;
		$walger_usuarios->usuario->CssStyle = "";
		$walger_usuarios->usuario->CssClass = "";
		$walger_usuarios->usuario->ViewCustomAttributes = "";

		// contrasenia
		$walger_usuarios->contrasenia->ViewValue = $walger_usuarios->contrasenia->CurrentValue;
		$walger_usuarios->contrasenia->CssStyle = "";
		$walger_usuarios->contrasenia->CssClass = "";
		$walger_usuarios->contrasenia->ViewCustomAttributes = "";

		// idUsuario
		$walger_usuarios->idUsuario->HrefValue = "";

		// usuario
		$walger_usuarios->usuario->HrefValue = "";

		// contrasenia
		$walger_usuarios->contrasenia->HrefValue = "";
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_usuarios->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_usuarios->Row_Rendered();
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
