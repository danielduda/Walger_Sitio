<?php include_once "walger_usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($trama_mensajes2Dpublicos2Dleidos_grid)) $trama_mensajes2Dpublicos2Dleidos_grid = new ctrama_mensajes2Dpublicos2Dleidos_grid();

// Page init
$trama_mensajes2Dpublicos2Dleidos_grid->Page_Init();

// Page main
$trama_mensajes2Dpublicos2Dleidos_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_mensajes2Dpublicos2Dleidos_grid->Page_Render();
?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftrama_mensajes2Dpublicos2Dleidosgrid = new ew_Form("ftrama_mensajes2Dpublicos2Dleidosgrid", "grid");
ftrama_mensajes2Dpublicos2Dleidosgrid.FormKeyCountName = '<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName ?>';

// Validate form
ftrama_mensajes2Dpublicos2Dleidosgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftrama_mensajes2Dpublicos2Dleidosgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idCliente", false)) return false;
	return true;
}

// Form_CustomValidate event
ftrama_mensajes2Dpublicos2Dleidosgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_mensajes2Dpublicos2Dleidosgrid.ValidateRequired = true;
<?php } else { ?>
ftrama_mensajes2Dpublicos2Dleidosgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_mensajes2Dpublicos2Dleidosgrid.Lists["x_idCliente"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_CodigoCli","x_RazonSocialCli","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};

// Form object for search
</script>
<?php } ?>
<?php
if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd") {
	if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "copy") {
		$bSelectLimit = $trama_mensajes2Dpublicos2Dleidos_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs = $trama_mensajes2Dpublicos2Dleidos->SelectRecordCount();
			$trama_mensajes2Dpublicos2Dleidos_grid->Recordset = $trama_mensajes2Dpublicos2Dleidos_grid->LoadRecordset($trama_mensajes2Dpublicos2Dleidos_grid->StartRec-1, $trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs);
		} else {
			if ($trama_mensajes2Dpublicos2Dleidos_grid->Recordset = $trama_mensajes2Dpublicos2Dleidos_grid->LoadRecordset())
				$trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs = $trama_mensajes2Dpublicos2Dleidos_grid->Recordset->RecordCount();
		}
		$trama_mensajes2Dpublicos2Dleidos_grid->StartRec = 1;
		$trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs = $trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs;
	} else {
		$trama_mensajes2Dpublicos2Dleidos->CurrentFilter = "0=1";
		$trama_mensajes2Dpublicos2Dleidos_grid->StartRec = 1;
		$trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs = $trama_mensajes2Dpublicos2Dleidos->GridAddRowCount;
	}
	$trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs = $trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs;
	$trama_mensajes2Dpublicos2Dleidos_grid->StopRec = $trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs;
} else {
	$bSelectLimit = $trama_mensajes2Dpublicos2Dleidos_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs <= 0)
			$trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs = $trama_mensajes2Dpublicos2Dleidos->SelectRecordCount();
	} else {
		if (!$trama_mensajes2Dpublicos2Dleidos_grid->Recordset && ($trama_mensajes2Dpublicos2Dleidos_grid->Recordset = $trama_mensajes2Dpublicos2Dleidos_grid->LoadRecordset()))
			$trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs = $trama_mensajes2Dpublicos2Dleidos_grid->Recordset->RecordCount();
	}
	$trama_mensajes2Dpublicos2Dleidos_grid->StartRec = 1;
	$trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs = $trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$trama_mensajes2Dpublicos2Dleidos_grid->Recordset = $trama_mensajes2Dpublicos2Dleidos_grid->LoadRecordset($trama_mensajes2Dpublicos2Dleidos_grid->StartRec-1, $trama_mensajes2Dpublicos2Dleidos_grid->DisplayRecs);

	// Set no record found message
	if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "" && $trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$trama_mensajes2Dpublicos2Dleidos_grid->setWarningMessage(ew_DeniedMsg());
		if ($trama_mensajes2Dpublicos2Dleidos_grid->SearchWhere == "0=101")
			$trama_mensajes2Dpublicos2Dleidos_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$trama_mensajes2Dpublicos2Dleidos_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$trama_mensajes2Dpublicos2Dleidos_grid->RenderOtherOptions();
?>
<?php $trama_mensajes2Dpublicos2Dleidos_grid->ShowPageHeader(); ?>
<?php
$trama_mensajes2Dpublicos2Dleidos_grid->ShowMessage();
?>
<?php if ($trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs > 0 || $trama_mensajes2Dpublicos2Dleidos->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid trama_mensajes2Dpublicos2Dleidos">
<div id="ftrama_mensajes2Dpublicos2Dleidosgrid" class="ewForm form-inline">
<?php if ($trama_mensajes2Dpublicos2Dleidos_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($trama_mensajes2Dpublicos2Dleidos_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_trama_mensajes2Dpublicos2Dleidos" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_trama_mensajes2Dpublicos2Dleidosgrid" class="table ewTable">
<?php echo $trama_mensajes2Dpublicos2Dleidos->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$trama_mensajes2Dpublicos2Dleidos_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$trama_mensajes2Dpublicos2Dleidos_grid->RenderListOptions();

// Render list options (header, left)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("header", "left");
?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->idCliente->Visible) { // idCliente ?>
	<?php if ($trama_mensajes2Dpublicos2Dleidos->SortUrl($trama_mensajes2Dpublicos2Dleidos->idCliente) == "") { ?>
		<th data-name="idCliente"><div id="elh_trama_mensajes2Dpublicos2Dleidos_idCliente" class="trama_mensajes2Dpublicos2Dleidos_idCliente"><div class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idCliente"><div><div id="elh_trama_mensajes2Dpublicos2Dleidos_idCliente" class="trama_mensajes2Dpublicos2Dleidos_idCliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_mensajes2Dpublicos2Dleidos->idCliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_mensajes2Dpublicos2Dleidos->idCliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$trama_mensajes2Dpublicos2Dleidos_grid->StartRec = 1;
$trama_mensajes2Dpublicos2Dleidos_grid->StopRec = $trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName) && ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd" || $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridedit" || $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "F")) {
		$trama_mensajes2Dpublicos2Dleidos_grid->KeyCount = $objForm->GetValue($trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName);
		$trama_mensajes2Dpublicos2Dleidos_grid->StopRec = $trama_mensajes2Dpublicos2Dleidos_grid->StartRec + $trama_mensajes2Dpublicos2Dleidos_grid->KeyCount - 1;
	}
}
$trama_mensajes2Dpublicos2Dleidos_grid->RecCnt = $trama_mensajes2Dpublicos2Dleidos_grid->StartRec - 1;
if ($trama_mensajes2Dpublicos2Dleidos_grid->Recordset && !$trama_mensajes2Dpublicos2Dleidos_grid->Recordset->EOF) {
	$trama_mensajes2Dpublicos2Dleidos_grid->Recordset->MoveFirst();
	$bSelectLimit = $trama_mensajes2Dpublicos2Dleidos_grid->UseSelectLimit;
	if (!$bSelectLimit && $trama_mensajes2Dpublicos2Dleidos_grid->StartRec > 1)
		$trama_mensajes2Dpublicos2Dleidos_grid->Recordset->Move($trama_mensajes2Dpublicos2Dleidos_grid->StartRec - 1);
} elseif (!$trama_mensajes2Dpublicos2Dleidos->AllowAddDeleteRow && $trama_mensajes2Dpublicos2Dleidos_grid->StopRec == 0) {
	$trama_mensajes2Dpublicos2Dleidos_grid->StopRec = $trama_mensajes2Dpublicos2Dleidos->GridAddRowCount;
}

// Initialize aggregate
$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_AGGREGATEINIT;
$trama_mensajes2Dpublicos2Dleidos->ResetAttrs();
$trama_mensajes2Dpublicos2Dleidos_grid->RenderRow();
if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd")
	$trama_mensajes2Dpublicos2Dleidos_grid->RowIndex = 0;
if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridedit")
	$trama_mensajes2Dpublicos2Dleidos_grid->RowIndex = 0;
while ($trama_mensajes2Dpublicos2Dleidos_grid->RecCnt < $trama_mensajes2Dpublicos2Dleidos_grid->StopRec) {
	$trama_mensajes2Dpublicos2Dleidos_grid->RecCnt++;
	if (intval($trama_mensajes2Dpublicos2Dleidos_grid->RecCnt) >= intval($trama_mensajes2Dpublicos2Dleidos_grid->StartRec)) {
		$trama_mensajes2Dpublicos2Dleidos_grid->RowCnt++;
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd" || $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridedit" || $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "F") {
			$trama_mensajes2Dpublicos2Dleidos_grid->RowIndex++;
			$objForm->Index = $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex;
			if ($objForm->HasValue($trama_mensajes2Dpublicos2Dleidos_grid->FormActionName))
				$trama_mensajes2Dpublicos2Dleidos_grid->RowAction = strval($objForm->GetValue($trama_mensajes2Dpublicos2Dleidos_grid->FormActionName));
			elseif ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd")
				$trama_mensajes2Dpublicos2Dleidos_grid->RowAction = "insert";
			else
				$trama_mensajes2Dpublicos2Dleidos_grid->RowAction = "";
		}

		// Set up key count
		$trama_mensajes2Dpublicos2Dleidos_grid->KeyCount = $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex;

		// Init row class and style
		$trama_mensajes2Dpublicos2Dleidos->ResetAttrs();
		$trama_mensajes2Dpublicos2Dleidos->CssClass = "";
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd") {
			if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "copy") {
				$trama_mensajes2Dpublicos2Dleidos_grid->LoadRowValues($trama_mensajes2Dpublicos2Dleidos_grid->Recordset); // Load row values
				$trama_mensajes2Dpublicos2Dleidos_grid->SetRecordKey($trama_mensajes2Dpublicos2Dleidos_grid->RowOldKey, $trama_mensajes2Dpublicos2Dleidos_grid->Recordset); // Set old record key
			} else {
				$trama_mensajes2Dpublicos2Dleidos_grid->LoadDefaultValues(); // Load default values
				$trama_mensajes2Dpublicos2Dleidos_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$trama_mensajes2Dpublicos2Dleidos_grid->LoadRowValues($trama_mensajes2Dpublicos2Dleidos_grid->Recordset); // Load row values
		}
		$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd") // Grid add
			$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_ADD; // Render add
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridadd" && $trama_mensajes2Dpublicos2Dleidos->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$trama_mensajes2Dpublicos2Dleidos_grid->RestoreCurrentRowFormValues($trama_mensajes2Dpublicos2Dleidos_grid->RowIndex); // Restore form values
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridedit") { // Grid edit
			if ($trama_mensajes2Dpublicos2Dleidos->EventCancelled) {
				$trama_mensajes2Dpublicos2Dleidos_grid->RestoreCurrentRowFormValues($trama_mensajes2Dpublicos2Dleidos_grid->RowIndex); // Restore form values
			}
			if ($trama_mensajes2Dpublicos2Dleidos_grid->RowAction == "insert")
				$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "gridedit" && ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_EDIT || $trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_ADD) && $trama_mensajes2Dpublicos2Dleidos->EventCancelled) // Update failed
			$trama_mensajes2Dpublicos2Dleidos_grid->RestoreCurrentRowFormValues($trama_mensajes2Dpublicos2Dleidos_grid->RowIndex); // Restore form values
		if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_EDIT) // Edit row
			$trama_mensajes2Dpublicos2Dleidos_grid->EditRowCnt++;
		if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction == "F") // Confirm row
			$trama_mensajes2Dpublicos2Dleidos_grid->RestoreCurrentRowFormValues($trama_mensajes2Dpublicos2Dleidos_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$trama_mensajes2Dpublicos2Dleidos->RowAttrs = array_merge($trama_mensajes2Dpublicos2Dleidos->RowAttrs, array('data-rowindex'=>$trama_mensajes2Dpublicos2Dleidos_grid->RowCnt, 'id'=>'r' . $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt . '_trama_mensajes2Dpublicos2Dleidos', 'data-rowtype'=>$trama_mensajes2Dpublicos2Dleidos->RowType));

		// Render row
		$trama_mensajes2Dpublicos2Dleidos_grid->RenderRow();

		// Render list options
		$trama_mensajes2Dpublicos2Dleidos_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($trama_mensajes2Dpublicos2Dleidos_grid->RowAction <> "delete" && $trama_mensajes2Dpublicos2Dleidos_grid->RowAction <> "insertdelete" && !($trama_mensajes2Dpublicos2Dleidos_grid->RowAction == "insert" && $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "F" && $trama_mensajes2Dpublicos2Dleidos_grid->EmptyRow())) {
?>
	<tr<?php echo $trama_mensajes2Dpublicos2Dleidos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("body", "left", $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt);
?>
	<?php if ($trama_mensajes2Dpublicos2Dleidos->idCliente->Visible) { // idCliente ?>
		<td data-name="idCliente"<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->CellAttributes() ?>>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt ?>_trama_mensajes2Dpublicos2Dleidos_idCliente" class="form-group trama_mensajes2Dpublicos2Dleidos_idCliente">
<select data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->idCliente->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt ?>_trama_mensajes2Dpublicos2Dleidos_idCliente" class="form-group trama_mensajes2Dpublicos2Dleidos_idCliente">
<select data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt ?>_trama_mensajes2Dpublicos2Dleidos_idCliente" class="trama_mensajes2Dpublicos2Dleidos_idCliente">
<span<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->ViewAttributes() ?>>
<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->idCliente->FormValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->idCliente->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->PageObjName . "_row_" . $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_id" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->id->CurrentValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_id" name="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" id="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->id->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_EDIT || $trama_mensajes2Dpublicos2Dleidos->CurrentMode == "edit") { ?>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_id" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->id->CurrentValue) ?>">
<?php } ?>
<?php

// Render list options (body, right)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("body", "right", $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt);
?>
	</tr>
<?php if ($trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_ADD || $trama_mensajes2Dpublicos2Dleidos->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftrama_mensajes2Dpublicos2Dleidosgrid.UpdateOpts(<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction <> "gridadd" || $trama_mensajes2Dpublicos2Dleidos->CurrentMode == "copy")
		if (!$trama_mensajes2Dpublicos2Dleidos_grid->Recordset->EOF) $trama_mensajes2Dpublicos2Dleidos_grid->Recordset->MoveNext();
}
?>
<?php
	if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "add" || $trama_mensajes2Dpublicos2Dleidos->CurrentMode == "copy" || $trama_mensajes2Dpublicos2Dleidos->CurrentMode == "edit") {
		$trama_mensajes2Dpublicos2Dleidos_grid->RowIndex = '$rowindex$';
		$trama_mensajes2Dpublicos2Dleidos_grid->LoadDefaultValues();

		// Set row properties
		$trama_mensajes2Dpublicos2Dleidos->ResetAttrs();
		$trama_mensajes2Dpublicos2Dleidos->RowAttrs = array_merge($trama_mensajes2Dpublicos2Dleidos->RowAttrs, array('data-rowindex'=>$trama_mensajes2Dpublicos2Dleidos_grid->RowIndex, 'id'=>'r0_trama_mensajes2Dpublicos2Dleidos', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($trama_mensajes2Dpublicos2Dleidos->RowAttrs["class"], "ewTemplate");
		$trama_mensajes2Dpublicos2Dleidos->RowType = EW_ROWTYPE_ADD;

		// Render row
		$trama_mensajes2Dpublicos2Dleidos_grid->RenderRow();

		// Render list options
		$trama_mensajes2Dpublicos2Dleidos_grid->RenderListOptions();
		$trama_mensajes2Dpublicos2Dleidos_grid->StartRowCnt = 0;
?>
	<tr<?php echo $trama_mensajes2Dpublicos2Dleidos->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("body", "left", $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex);
?>
	<?php if ($trama_mensajes2Dpublicos2Dleidos->idCliente->Visible) { // idCliente ?>
		<td data-name="idCliente">
<?php if ($trama_mensajes2Dpublicos2Dleidos->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trama_mensajes2Dpublicos2Dleidos_idCliente" class="form-group trama_mensajes2Dpublicos2Dleidos_idCliente">
<select data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_trama_mensajes2Dpublicos2Dleidos_idCliente" class="form-group trama_mensajes2Dpublicos2Dleidos_idCliente">
<span<?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dpublicos2Dleidos->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" name="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="x<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->idCliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_mensajes2Dpublicos2Dleidos" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dpublicos2Dleidos->idCliente->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_mensajes2Dpublicos2Dleidos_grid->ListOptions->Render("body", "right", $trama_mensajes2Dpublicos2Dleidos_grid->RowCnt);
?>
<script type="text/javascript">
ftrama_mensajes2Dpublicos2Dleidosgrid.UpdateOpts(<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "add" || $trama_mensajes2Dpublicos2Dleidos->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName ?>" id="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName ?>" value="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->KeyCount ?>">
<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName ?>" id="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->FormKeyCountName ?>" value="<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->KeyCount ?>">
<?php echo $trama_mensajes2Dpublicos2Dleidos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftrama_mensajes2Dpublicos2Dleidosgrid">
</div>
<?php

// Close recordset
if ($trama_mensajes2Dpublicos2Dleidos_grid->Recordset)
	$trama_mensajes2Dpublicos2Dleidos_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos_grid->TotalRecs == 0 && $trama_mensajes2Dpublicos2Dleidos->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($trama_mensajes2Dpublicos2Dleidos_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($trama_mensajes2Dpublicos2Dleidos->Export == "") { ?>
<script type="text/javascript">
ftrama_mensajes2Dpublicos2Dleidosgrid.Init();
</script>
<?php } ?>
<?php
$trama_mensajes2Dpublicos2Dleidos_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$trama_mensajes2Dpublicos2Dleidos_grid->Page_Terminate();
?>
