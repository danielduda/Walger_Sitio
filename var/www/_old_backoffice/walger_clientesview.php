<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
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
if (@$_GET["CodigoCli"] <> "") {
	if ($sExportFile <> "") $sExportFile .= "_";
	$sExportFile .= ew_StripSlashes($_GET["CodigoCli"]);
}
if ($walger_clientes->Export == "html") {

	// Printer friendly, no action required
}
if ($walger_clientes->Export == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xls');
}
if ($walger_clientes->Export == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.doc');
}
if ($walger_clientes->Export == "xml") {
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.xml');
}
if ($walger_clientes->Export == "csv") {
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=' . $sExportFile .'.csv');
}
?>
<?php

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 1;
$nRecRange = 10;

// Load current record
$bLoadCurrentRecord = FALSE;
if (@$_GET["CodigoCli"] <> "") {
	$walger_clientes->CodigoCli->setQueryStringValue($_GET["CodigoCli"]);
} else {
	$bLoadCurrentRecord = TRUE;
}

// Get action
if (@$_POST["a_view"] <> "") {
	$walger_clientes->CurrentAction = $_POST["a_view"];
} else {
	$walger_clientes->CurrentAction = "I"; // Display form
}
switch ($walger_clientes->CurrentAction) {
	case "I": // Get a record to display
		$nStartRec = 1; // Initialize start position
		$rs = LoadRecordset(); // Load records
		$nTotalRecs = $rs->RecordCount(); // Get record count
		if ($nTotalRecs <= 0) { // No record found
			$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
			Page_Terminate("walger_clienteslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($nStartRec) <= intval($nTotalRecs)) {
				$rs->Move($nStartRec-1);
			}
		} else { // Match key values
			$bMatchRecord = FALSE;
			while (!$rs->EOF) {
				if (strval($walger_clientes->CodigoCli->CurrentValue) == strval($rs->fields('CodigoCli'))) {
					$bMatchRecord = TRUE;
					break;
				} else {
					$nStartRec++;
					$rs->MoveNext();
				}
			}
			if (!$bMatchRecord) {
				$_SESSION[EW_SESSION_MESSAGE] = "No se encontraron datos"; // Set no record message
				Page_Terminate("walger_clienteslist.php"); // Return to list
			} else {
				$walger_clientes->setStartRecordNumber($nStartRec); // Save record position
			}
		}
		LoadRowValues($rs); // Load row values
}

// Export data only
if ($walger_clientes->Export == "xml" || $walger_clientes->Export == "csv") {
	ExportData();
	Page_Terminate(); // Terminate response
}

// Set return url
$walger_clientes->setReturnUrl("walger_clientesview.php");

// Render row
$walger_clientes->RowType = EW_ROWTYPE_VIEW;
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "view"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Ver : Clientes
<?php if ($walger_clientes->Export == "") { ?>
&nbsp;&nbsp;<a href="walger_clientesview.php?export=html&CodigoCli=<?php echo urlencode($walger_clientes->CodigoCli->CurrentValue) ?>">Vista impresión</a>
&nbsp;&nbsp;<a href="walger_clientesview.php?export=excel&CodigoCli=<?php echo urlencode($walger_clientes->CodigoCli->CurrentValue) ?>">Exportar a Excel</a>
&nbsp;&nbsp;<a href="walger_clientesview.php?export=word&CodigoCli=<?php echo urlencode($walger_clientes->CodigoCli->CurrentValue) ?>">Exportar a Word</a>
&nbsp;&nbsp;<a href="walger_clientesview.php?export=xml&CodigoCli=<?php echo urlencode($walger_clientes->CodigoCli->CurrentValue) ?>">Exportar a XML</a>
&nbsp;&nbsp;<a href="walger_clientesview.php?export=csv&CodigoCli=<?php echo urlencode($walger_clientes->CodigoCli->CurrentValue) ?>">Exportar a CSV</a>
<?php } ?>
<br><br>
<?php if ($walger_clientes->Export == "") { ?>
<a href="walger_clienteslist.php">Lista</a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="walger_clientesadd.php">Agregar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_clientes->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $walger_clientes->CopyUrl() ?>">Copiar</a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a onclick="return ew_Confirm('Realmente quiere eliminar éste registro?');" href="<?php echo $walger_clientes->DeleteUrl() ?>">Eliminar</a>&nbsp;
<?php } ?>
<?php } ?>
</span>
</p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<p>
<?php if ($walger_clientes->Export == "") { ?>
<form action="walger_clientesview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_clientesview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->ButtonCount > 0) { ?><br><?php } ?>
	Registros <?php echo $Pager->FromIndex ?> al <?php echo $Pager->ToIndex ?> de <?php echo $Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($sSrchWhere == "0=101") { ?>
	Ingrese el criterio requerido
	<?php } else { ?>
	No se encontraron datos
	<?php } ?>
<?php } ?>
</span>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<form>
<table class="ewTable">
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cliente</td>
		<td<?php echo $walger_clientes->CodigoCli->CellAttributes() ?>>
<div<?php echo $walger_clientes->CodigoCli->ViewAttributes() ?>><?php echo $walger_clientes->CodigoCli->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Contraseña</td>
		<td<?php echo $walger_clientes->Contrasenia->CellAttributes() ?>>
<div<?php echo $walger_clientes->Contrasenia->ViewAttributes() ?>><?php echo $walger_clientes->Contrasenia->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">IP</td>
		<td<?php echo $walger_clientes->IP->CellAttributes() ?>>
<div<?php echo $walger_clientes->IP->ViewAttributes() ?>><?php echo $walger_clientes->IP->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Ultimo Login</td>
		<td<?php echo $walger_clientes->UltimoLogin->CellAttributes() ?>>
<div<?php echo $walger_clientes->UltimoLogin->ViewAttributes() ?>><?php echo $walger_clientes->UltimoLogin->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Habilitado</td>
		<td<?php echo $walger_clientes->Habilitado->CellAttributes() ?>>
<div<?php echo $walger_clientes->Habilitado->ViewAttributes() ?>><?php echo $walger_clientes->Habilitado->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Tipo de Cliente</td>
		<td<?php echo $walger_clientes->TipoCliente->CellAttributes() ?>>
<div<?php echo $walger_clientes->TipoCliente->ViewAttributes() ?>><?php echo $walger_clientes->TipoCliente->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Moneda</td>
		<td<?php echo $walger_clientes->Regis_Mda->CellAttributes() ?>>
<div<?php echo $walger_clientes->Regis_Mda->ViewAttributes() ?>><?php echo $walger_clientes->Regis_Mda->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Apellido y Nombre</td>
		<td<?php echo $walger_clientes->ApellidoNombre->CellAttributes() ?>>
<div<?php echo $walger_clientes->ApellidoNombre->ViewAttributes() ?>><?php echo $walger_clientes->ApellidoNombre->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableRow">
		<td class="ewTableHeader">Cargo</td>
		<td<?php echo $walger_clientes->Cargo->CellAttributes() ?>>
<div<?php echo $walger_clientes->Cargo->ViewAttributes() ?>><?php echo $walger_clientes->Cargo->ViewValue ?></div>
</td>
	</tr>
	<tr class="ewTableAltRow">
		<td class="ewTableHeader">Comentarios</td>
		<td<?php echo $walger_clientes->Comentarios->CellAttributes() ?>>
<div<?php echo $walger_clientes->Comentarios->ViewAttributes() ?>><?php echo $walger_clientes->Comentarios->ViewValue ?></div>
</td>
	</tr>
</table>
</form>
<?php if ($walger_clientes->Export == "") { ?>
<form action="walger_clientesview.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<span class="phpmaker">
<?php if (!isset($Pager)) $Pager = new cNumericPager($nStartRec, $nDisplayRecs, $nTotalRecs, $nRecRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->FirstButton->Start ?>"><b>Primero</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->PrevButton->Start ?>"><b>Anterior</b></a>&nbsp;
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<?php if ($PagerItem->Enabled) { ?><a href="walger_clientesview.php?start=<?php echo $PagerItem->Start ?>"><?php } ?><b><?php echo $PagerItem->Text ?></b><?php if ($PagerItem->Enabled) { ?></a><?php } ?>&nbsp;
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->NextButton->Start ?>"><b>Siguiente</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a href="walger_clientesview.php?start=<?php echo $Pager->LastButton->Start ?>"><b>Ultimo</b></a>&nbsp;
	<?php } ?>
	<?php if ($Pager->ButtonCount > 0) { ?><br><?php } ?>
	Registros <?php echo $Pager->FromIndex ?> al <?php echo $Pager->ToIndex ?> de <?php echo $Pager->RecordCount ?>
<?php } else { ?>	
	<?php if ($sSrchWhere == "0=101") { ?>
	Ingrese el criterio requerido
	<?php } else { ?>
	No se encontraron datos
	<?php } ?>
<?php } ?>
</span>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<p>
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

	// Comentarios
	$walger_clientes->Comentarios->CellCssStyle = "";
	$walger_clientes->Comentarios->CellCssClass = "";
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

		// Comentarios
		$walger_clientes->Comentarios->ViewValue = $walger_clientes->Comentarios->CurrentValue;
		if (!is_null($walger_clientes->Comentarios->ViewValue)) $walger_clientes->Comentarios->ViewValue = str_replace("\n", "<br>", $walger_clientes->Comentarios->ViewValue); 
		$walger_clientes->Comentarios->CssStyle = "";
		$walger_clientes->Comentarios->CssClass = "";
		$walger_clientes->Comentarios->ViewCustomAttributes = "";

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

		// Comentarios
		$walger_clientes->Comentarios->HrefValue = "";
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($walger_clientes->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$walger_clientes->Row_Rendered();
}
?>
<?php

// Export data in Xml or Csv format
function ExportData() {
	global $nTotalRecs, $nStartRec, $nStopRec, $nTotalRecs, $nDisplayRecs, $walger_clientes;
	$sCsvStr = "";
	$rs = LoadRecordset();
	$nTotalRecs = $rs->RecordCount();
	$nStartRec = 1;
		SetUpStartRec(); // Set Up Start Record Position

		// Set the last record to display
		if ($nDisplayRecs < 0) {
			$nStopRec = $nTotalRecs;
		} else {
			$nStopRec = $nStartRec + $nDisplayRecs - 1;
		}
	if ($walger_clientes->Export == "xml") {
		$XmlDoc = new cXMLDocument();
	}
	if ($walger_clientes->Export == "csv") {
		$sCsvStr .= "CodigoCli" . ",";
		$sCsvStr .= "Contrasenia" . ",";
		$sCsvStr .= "IP" . ",";
		$sCsvStr .= "UltimoLogin" . ",";
		$sCsvStr .= "Habilitado" . ",";
		$sCsvStr .= "TipoCliente" . ",";
		$sCsvStr .= "Regis_Mda" . ",";
		$sCsvStr .= "ApellidoNombre" . ",";
		$sCsvStr .= "Cargo" . ",";
		$sCsvStr .= "Comentarios" . ",";
		$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
		$sCsvStr .= "\n";
	}

	// Move to first record directly for performance reason
	$nRecCount = $nStartRec - 1;
	if (!$rs->EOF) {
		$rs->MoveFirst();
		$rs->Move($nStartRec - 1);
	}
	while (!$rs->EOF && $nRecCount < $nStopRec) {
		$nRecCount++;
		if (intval($nRecCount) >= intval($nStartRec)) {
			LoadRowValues($rs);
			if ($walger_clientes->Export == "xml") {
				$XmlDoc->BeginRow();
				$XmlDoc->AddField('CodigoCli', $walger_clientes->CodigoCli->CurrentValue);
				$XmlDoc->AddField('Contrasenia', $walger_clientes->Contrasenia->CurrentValue);
				$XmlDoc->AddField('IP', $walger_clientes->IP->CurrentValue);
				$XmlDoc->AddField('UltimoLogin', $walger_clientes->UltimoLogin->CurrentValue);
				$XmlDoc->AddField('Habilitado', $walger_clientes->Habilitado->CurrentValue);
				$XmlDoc->AddField('TipoCliente', $walger_clientes->TipoCliente->CurrentValue);
				$XmlDoc->AddField('Regis_Mda', $walger_clientes->Regis_Mda->CurrentValue);
				$XmlDoc->AddField('ApellidoNombre', $walger_clientes->ApellidoNombre->CurrentValue);
				$XmlDoc->AddField('Cargo', $walger_clientes->Cargo->CurrentValue);
				$XmlDoc->AddField('Comentarios', $walger_clientes->Comentarios->CurrentValue);
				$XmlDoc->EndRow();
			}
			if ($walger_clientes->Export == "csv") {
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->CodigoCli->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Contrasenia->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->IP->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->UltimoLogin->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Habilitado->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->TipoCliente->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Regis_Mda->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->ApellidoNombre->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Cargo->CurrentValue)) . '",';
				$sCsvStr .= '"' . str_replace('"', '""', strval($walger_clientes->Comentarios->CurrentValue)) . '",';
				$sCsvStr = substr($sCsvStr, 0, strlen($sCsvStr)-1); // Remove last comma
				$sCsvStr .= "\n";
			}
		}
		$rs->MoveNext();
	}

	// Close recordset
	$rs->Close();
	if ($walger_clientes->Export == "xml") {
		header("Content-Type: text/xml");
		echo $XmlDoc->XML();
	}
	if ($walger_clientes->Export == "csv") {
		echo $sCsvStr;
	}
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $walger_clientes;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$walger_clientes->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $walger_clientes->getStartRecordNumber();
		}
	} else {
		$nStartRec = $walger_clientes->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$walger_clientes->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$walger_clientes->setStartRecordNumber($nStartRec);
	}
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
