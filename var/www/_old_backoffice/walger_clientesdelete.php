<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
define("EW_TABLE_NAME", 'walger_clientes', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "walger_clientesinfo.php" ?>
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
$walger_clientes->Export = @$_GET["export"]; // Get export parameter
$sExport = $walger_clientes->Export; // Get export parameter, used in header
$sExportFile = $walger_clientes->TableVar; // Get export file, used in header
?>
<?php

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["CodigoCli"] <> "") {
	$walger_clientes->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
	$sKey .= $walger_clientes->CodigoCli->QueryStringValue;
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
if ($nKeySelected <= 0) Page_Terminate($walger_clientes->getReturnUrl()); // No key specified, exit

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
// Sql constructor in walger_clientes class, walger_clientesinfo.php

$walger_clientes->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$walger_clientes->CurrentAction = $_POST["a_delete"];
} else {
	$walger_clientes->CurrentAction = "D"; // Delete record directly
}
switch ($walger_clientes->CurrentAction) {
	case "D": // Delete
		$walger_clientes->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Se ha eliminado"; // Set up success message
			Page_Terminate($walger_clientes->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($walger_clientes->getReturnUrl()); // Return to caller
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
<p><span class="phpmaker">Eliminar : Clientes<br><br><a href="<?php echo $walger_clientes->getReturnUrl() ?>"></a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="walger_clientesdelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">Cliente</td>
		<td valign="top">Contraseña</td>
		<td valign="top">IP</td>
		<td valign="top">Ultimo Login</td>
		<td valign="top">Habilitado</td>
		<td valign="top">Tipo de Cliente</td>
		<td valign="top">Moneda</td>
		<td valign="top">Apellido y Nombre</td>
		<td valign="top">Cargo</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$walger_clientes->CssClass = "ewTableRow";
	$walger_clientes->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$walger_clientes->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$walger_clientes->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $walger_clientes->DisplayAttributes() ?>>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<div<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>><?php echo $walger_clientes->CodigoCli->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<div<?php echo $walger_clientes->Contrasenia->ViewAttributes() ?>><?php echo $walger_clientes->Contrasenia->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>>
<div<?php echo $walger_clientes->IP->ViewAttributes() ?>><?php echo $walger_clientes->IP->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>>
<div<?php echo $walger_clientes->UltimoLogin->ViewAttributes() ?>><?php echo $walger_clientes->UltimoLogin->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<div<?php echo $walger_clientes->Habilitado->ViewAttributes() ?>><?php echo $walger_clientes->Habilitado->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<div<?php echo $walger_clientes->TipoCliente->ViewAttributes() ?>><?php echo $walger_clientes->TipoCliente->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<div<?php echo $walger_clientes->Regis_Mda->ViewAttributes() ?>><?php echo $walger_clientes->Regis_Mda->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<div<?php echo $walger_clientes->ApellidoNombre->ViewAttributes() ?>><?php echo $walger_clientes->ApellidoNombre->ViewValue ?></div>
</td>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<div<?php echo $walger_clientes->Cargo->ViewAttributes() ?>><?php echo $walger_clientes->Cargo->ViewValue ?></div>
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
	global $conn, $Security, $walger_clientes;
	$DeleteRows = TRUE;
	$sWrkFilter = $walger_clientes->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in walger_clientes class, walger_clientesinfo.php

	$walger_clientes->CurrentFilter = $sWrkFilter;
	$sSql = $walger_clientes->SQL();
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
			$DeleteRows = $walger_clientes->Row_Deleting($row);
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
			$DeleteRows = $conn->Execute($walger_clientes->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($walger_clientes->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $walger_clientes->CancelMessage;
			$walger_clientes->CancelMessage = "";
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
			$walger_clientes->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $walger_clientes;

	// Call Recordset Selecting event
	$walger_clientes->Recordset_Selecting($walger_clientes->CurrentFilter);

	// Load list page sql
	$sSql = $walger_clientes->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$walger_clientes->Recordset_Selected($rs);
	return $rs;
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $walger_clientes;
	$sFilter = $walger_clientes->SqlKeyFilter();
	$sFilter = str_replace("@CodigoCli@", ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$walger_clientes->Row_Selecting($sFilter);

	// Load sql based on filter
	$walger_clientes->CurrentFilter = $sFilter;
	$sSql = $walger_clientes->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$walger_clientes->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $walger_clientes;
	$walger_clientes->CodigoCli->setDbValue($rs->fields('CodigoCli'));
	$walger_clientes->Contrasenia->setDbValue($rs->fields('Contrasenia'));
	$walger_clientes->IP->setDbValue($rs->fields('IP'));
	$walger_clientes->UltimoLogin->setDbValue($rs->fields('UltimoLogin'));
	$walger_clientes->Habilitado->setDbValue($rs->fields('Habilitado'));
	$walger_clientes->TipoCliente->setDbValue($rs->fields('TipoCliente'));
	$walger_clientes->Regis_Mda->setDbValue($rs->fields('Regis_Mda'));
	$walger_clientes->ApellidoNombre->setDbValue($rs->fields('ApellidoNombre'));
	$walger_clientes->Cargo->setDbValue($rs->fields('Cargo'));
	$walger_clientes->Comentarios->setDbValue($rs->fields('Comentarios'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $walger_clientes;

	// Call Row Rendering event
	$walger_clientes->Row_Rendering();

	// Common render codes for all row types
	// CodigoCli

	$walger_clientes->CodigoCli->CellCssStyle = "";
	$walger_clientes->CodigoCli->CellCssClass = "";

	// Contrasenia
	$walger_clientes->Contrasenia->CellCssStyle = "";
	$walger_clientes->Contrasenia->CellCssClass = "";

	// IP
	$walger_clientes->IP->CellCssStyle = "";
	$walger_clientes->IP->CellCssClass = "";

	// UltimoLogin
	$walger_clientes->UltimoLogin->CellCssStyle = "";
	$walger_clientes->UltimoLogin->CellCssClass = "";

	// Habilitado
	$walger_clientes->Habilitado->CellCssStyle = "";
	$walger_clientes->Habilitado->CellCssClass = "";

	// TipoCliente
	$walger_clientes->TipoCliente->CellCssStyle = "";
	$walger_clientes->TipoCliente->CellCssClass = "";

	// Regis_Mda
	$walger_clientes->Regis_Mda->CellCssStyle = "";
	$walger_clientes->Regis_Mda->CellCssClass = "";

	// ApellidoNombre
	$walger_clientes->ApellidoNombre->CellCssStyle = "";
	$walger_clientes->ApellidoNombre->CellCssClass = "";

	// Cargo
	$walger_clientes->Cargo->CellCssStyle = "";
	$walger_clientes->Cargo->CellCssClass = "";
	if ($walger_clientes->RowType == EW_ROWTYPE_VIEW) { // View row

		// CodigoCli
		if (!is_null($walger_clientes->CodigoCli->CurrentValue)) {
			$sSqlWrk = "SELECT `RazonSocialCli`, `CodigoCli` FROM `dbo_cliente` WHERE `CodigoCli` = '" . ew_AdjustSql($walger_clientes->CodigoCli->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `RazonSocialCli` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_clientes->CodigoCli->ViewValue = $rswrk->fields('RazonSocialCli');
					$walger_clientes->CodigoCli->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('CodigoCli');
				}
				$rswrk->Close();
			} else {
				$walger_clientes->CodigoCli->ViewValue = $walger_clientes->CodigoCli->CurrentValue;
			}
		} else {
			$walger_clientes->CodigoCli->ViewValue = NULL;
		}
		$walger_clientes->CodigoCli->CssStyle = "";
		$walger_clientes->CodigoCli->CssClass = "";
		$walger_clientes->CodigoCli->ViewCustomAttributes = "";

		// Contrasenia
		$walger_clientes->Contrasenia->ViewValue = $walger_clientes->Contrasenia->CurrentValue;
		$walger_clientes->Contrasenia->CssStyle = "";
		$walger_clientes->Contrasenia->CssClass = "";
		$walger_clientes->Contrasenia->ViewCustomAttributes = "";

		// IP
		$walger_clientes->IP->ViewValue = $walger_clientes->IP->CurrentValue;
		$walger_clientes->IP->CssStyle = "";
		$walger_clientes->IP->CssClass = "";
		$walger_clientes->IP->ViewCustomAttributes = "";

		// UltimoLogin
		$walger_clientes->UltimoLogin->ViewValue = $walger_clientes->UltimoLogin->CurrentValue;
		$walger_clientes->UltimoLogin->ViewValue = ew_FormatDateTime($walger_clientes->UltimoLogin->ViewValue, 7);
		$walger_clientes->UltimoLogin->CssStyle = "";
		$walger_clientes->UltimoLogin->CssClass = "";
		$walger_clientes->UltimoLogin->ViewCustomAttributes = "";

		// Habilitado
		if (!is_null($walger_clientes->Habilitado->CurrentValue)) {
			switch ($walger_clientes->Habilitado->CurrentValue) {
				case "S":
					$walger_clientes->Habilitado->ViewValue = "Si";
					break;
				case "N":
					$walger_clientes->Habilitado->ViewValue = "No";
					break;
				default:
					$walger_clientes->Habilitado->ViewValue = $walger_clientes->Habilitado->CurrentValue;
			}
		} else {
			$walger_clientes->Habilitado->ViewValue = NULL;
		}
		$walger_clientes->Habilitado->CssStyle = "";
		$walger_clientes->Habilitado->CssClass = "";
		$walger_clientes->Habilitado->ViewCustomAttributes = "";

		// TipoCliente
		if (!is_null($walger_clientes->TipoCliente->CurrentValue)) {
			switch ($walger_clientes->TipoCliente->CurrentValue) {
				case "Consumidor Final":
					$walger_clientes->TipoCliente->ViewValue = "Consumidor Final";
					break;
				case "Casa de Repuestos":
					$walger_clientes->TipoCliente->ViewValue = "Casa de Repuestos";
					break;
				case "Distribuidor":
					$walger_clientes->TipoCliente->ViewValue = "Distribuidor";
					break;
				default:
					$walger_clientes->TipoCliente->ViewValue = $walger_clientes->TipoCliente->CurrentValue;
			}
		} else {
			$walger_clientes->TipoCliente->ViewValue = NULL;
		}
		$walger_clientes->TipoCliente->CssStyle = "";
		$walger_clientes->TipoCliente->CssClass = "";
		$walger_clientes->TipoCliente->ViewCustomAttributes = "";

		// Regis_Mda
		if (!is_null($walger_clientes->Regis_Mda->CurrentValue)) {
			$sSqlWrk = "SELECT `CodigoAFIP_Mda`, `Signo_Mda` FROM `dbo_moneda` WHERE `Regis_Mda` = " . ew_AdjustSql($walger_clientes->Regis_Mda->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `CodigoAFIP_Mda` ";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$walger_clientes->Regis_Mda->ViewValue = $rswrk->fields('CodigoAFIP_Mda');
					$walger_clientes->Regis_Mda->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('Signo_Mda');
				}
				$rswrk->Close();
			} else {
				$walger_clientes->Regis_Mda->ViewValue = $walger_clientes->Regis_Mda->CurrentValue;
			}
		} else {
			$walger_clientes->Regis_Mda->ViewValue = NULL;
		}
		$walger_clientes->Regis_Mda->CssStyle = "";
		$walger_clientes->Regis_Mda->CssClass = "";
		$walger_clientes->Regis_Mda->ViewCustomAttributes = "";

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->ViewValue = $walger_clientes->ApellidoNombre->CurrentValue;
		$walger_clientes->ApellidoNombre->CssStyle = "";
		$walger_clientes->ApellidoNombre->CssClass = "";
		$walger_clientes->ApellidoNombre->ViewCustomAttributes = "";

		// Cargo
		$walger_clientes->Cargo->ViewValue = $walger_clientes->Cargo->CurrentValue;
		$walger_clientes->Cargo->CssStyle = "";
		$walger_clientes->Cargo->CssClass = "";
		$walger_clientes->Cargo->ViewCustomAttributes = "";

		// CodigoCli
		$walger_clientes->CodigoCli->HrefValue = "";

		// Contrasenia
		$walger_clientes->Contrasenia->HrefValue = "";

		// IP
		$walger_clientes->IP->HrefValue = "";

		// UltimoLogin
		$walger_clientes->UltimoLogin->HrefValue = "";

		// Habilitado
		$walger_clientes->Habilitado->HrefValue = "";

		// TipoCliente
		$walger_clientes->TipoCliente->HrefValue = "";

		// Regis_Mda
		$walger_clientes->Regis_Mda->HrefValue = "";

		// ApellidoNombre
		$walger_clientes->ApellidoNombre->HrefValue = "";

		// Cargo
		$walger_clientes->Cargo->HrefValue = "";
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_clientes->Row_Rendered();
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
