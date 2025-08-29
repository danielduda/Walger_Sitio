<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($remitos_detalle_grid)) $remitos_detalle_grid = new cremitos_detalle_grid();

// Page init
$remitos_detalle_grid->Page_Init();

// Page main
$remitos_detalle_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitos_detalle_grid->Page_Render();
?>
<?php if ($remitos_detalle->Export == "") { ?>
<script type="text/javascript">

// Page object
var remitos_detalle_grid = new ew_Page("remitos_detalle_grid");
remitos_detalle_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = remitos_detalle_grid.PageID; // For backward compatibility

// Form object
var fremitos_detallegrid = new ew_Form("fremitos_detallegrid");
fremitos_detallegrid.FormKeyCountName = '<?php echo $remitos_detalle_grid->FormKeyCountName ?>';

// Validate form
fremitos_detallegrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
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
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitos_detalle->cantidad->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_descripcion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitos_detalle->descripcion->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fremitos_detallegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "descripcion", false)) return false;
	return true;
}

// Form_CustomValidate event
fremitos_detallegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitos_detallegrid.ValidateRequired = true;
<?php } else { ?>
fremitos_detallegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitos_detallegrid.Lists["x_descripcion"] = {"LinkField":"x_Id_Productos","Ajax":null,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($remitos_detalle->getCurrentMasterTable() == "" && $remitos_detalle_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $remitos_detalle_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($remitos_detalle->CurrentAction == "gridadd") {
	if ($remitos_detalle->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$remitos_detalle_grid->TotalRecs = $remitos_detalle->SelectRecordCount();
			$remitos_detalle_grid->Recordset = $remitos_detalle_grid->LoadRecordset($remitos_detalle_grid->StartRec-1, $remitos_detalle_grid->DisplayRecs);
		} else {
			if ($remitos_detalle_grid->Recordset = $remitos_detalle_grid->LoadRecordset())
				$remitos_detalle_grid->TotalRecs = $remitos_detalle_grid->Recordset->RecordCount();
		}
		$remitos_detalle_grid->StartRec = 1;
		$remitos_detalle_grid->DisplayRecs = $remitos_detalle_grid->TotalRecs;
	} else {
		$remitos_detalle->CurrentFilter = "0=1";
		$remitos_detalle_grid->StartRec = 1;
		$remitos_detalle_grid->DisplayRecs = $remitos_detalle->GridAddRowCount;
	}
	$remitos_detalle_grid->TotalRecs = $remitos_detalle_grid->DisplayRecs;
	$remitos_detalle_grid->StopRec = $remitos_detalle_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$remitos_detalle_grid->TotalRecs = $remitos_detalle->SelectRecordCount();
	} else {
		if ($remitos_detalle_grid->Recordset = $remitos_detalle_grid->LoadRecordset())
			$remitos_detalle_grid->TotalRecs = $remitos_detalle_grid->Recordset->RecordCount();
	}
	$remitos_detalle_grid->StartRec = 1;
	$remitos_detalle_grid->DisplayRecs = $remitos_detalle_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$remitos_detalle_grid->Recordset = $remitos_detalle_grid->LoadRecordset($remitos_detalle_grid->StartRec-1, $remitos_detalle_grid->DisplayRecs);
}
$remitos_detalle_grid->RenderOtherOptions();
?>
<?php $remitos_detalle_grid->ShowPageHeader(); ?>
<?php
$remitos_detalle_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fremitos_detallegrid" class="ewForm form-horizontal">
<?php if ($remitos_detalle_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel ewListOtherOptions">
<?php
	foreach ($remitos_detalle_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<div id="gmp_remitos_detalle" class="ewGridMiddlePanel">
<table id="tbl_remitos_detallegrid" class="ewTable ewTableSeparate">
<?php echo $remitos_detalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$remitos_detalle_grid->RenderListOptions();

// Render list options (header, left)
$remitos_detalle_grid->ListOptions->Render("header", "left");
?>
<?php if ($remitos_detalle->cantidad->Visible) { // cantidad ?>
	<?php if ($remitos_detalle->SortUrl($remitos_detalle->cantidad) == "") { ?>
		<td><div id="elh_remitos_detalle_cantidad" class="remitos_detalle_cantidad"><div class="ewTableHeaderCaption"><?php echo $remitos_detalle->cantidad->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitos_detalle_cantidad" class="remitos_detalle_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos_detalle->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitos_detalle->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos_detalle->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitos_detalle->descripcion->Visible) { // descripcion ?>
	<?php if ($remitos_detalle->SortUrl($remitos_detalle->descripcion) == "") { ?>
		<td><div id="elh_remitos_detalle_descripcion" class="remitos_detalle_descripcion"><div class="ewTableHeaderCaption"><?php echo $remitos_detalle->descripcion->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitos_detalle_descripcion" class="remitos_detalle_descripcion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitos_detalle->descripcion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitos_detalle->descripcion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitos_detalle->descripcion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$remitos_detalle_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$remitos_detalle_grid->StartRec = 1;
$remitos_detalle_grid->StopRec = $remitos_detalle_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($remitos_detalle_grid->FormKeyCountName) && ($remitos_detalle->CurrentAction == "gridadd" || $remitos_detalle->CurrentAction == "gridedit" || $remitos_detalle->CurrentAction == "F")) {
		$remitos_detalle_grid->KeyCount = $objForm->GetValue($remitos_detalle_grid->FormKeyCountName);
		$remitos_detalle_grid->StopRec = $remitos_detalle_grid->StartRec + $remitos_detalle_grid->KeyCount - 1;
	}
}
$remitos_detalle_grid->RecCnt = $remitos_detalle_grid->StartRec - 1;
if ($remitos_detalle_grid->Recordset && !$remitos_detalle_grid->Recordset->EOF) {
	$remitos_detalle_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $remitos_detalle_grid->StartRec > 1)
		$remitos_detalle_grid->Recordset->Move($remitos_detalle_grid->StartRec - 1);
} elseif (!$remitos_detalle->AllowAddDeleteRow && $remitos_detalle_grid->StopRec == 0) {
	$remitos_detalle_grid->StopRec = $remitos_detalle->GridAddRowCount;
}

// Initialize aggregate
$remitos_detalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$remitos_detalle->ResetAttrs();
$remitos_detalle_grid->RenderRow();
if ($remitos_detalle->CurrentAction == "gridadd")
	$remitos_detalle_grid->RowIndex = 0;
if ($remitos_detalle->CurrentAction == "gridedit")
	$remitos_detalle_grid->RowIndex = 0;
while ($remitos_detalle_grid->RecCnt < $remitos_detalle_grid->StopRec) {
	$remitos_detalle_grid->RecCnt++;
	if (intval($remitos_detalle_grid->RecCnt) >= intval($remitos_detalle_grid->StartRec)) {
		$remitos_detalle_grid->RowCnt++;
		if ($remitos_detalle->CurrentAction == "gridadd" || $remitos_detalle->CurrentAction == "gridedit" || $remitos_detalle->CurrentAction == "F") {
			$remitos_detalle_grid->RowIndex++;
			$objForm->Index = $remitos_detalle_grid->RowIndex;
			if ($objForm->HasValue($remitos_detalle_grid->FormActionName))
				$remitos_detalle_grid->RowAction = strval($objForm->GetValue($remitos_detalle_grid->FormActionName));
			elseif ($remitos_detalle->CurrentAction == "gridadd")
				$remitos_detalle_grid->RowAction = "insert";
			else
				$remitos_detalle_grid->RowAction = "";
		}

		// Set up key count
		$remitos_detalle_grid->KeyCount = $remitos_detalle_grid->RowIndex;

		// Init row class and style
		$remitos_detalle->ResetAttrs();
		$remitos_detalle->CssClass = "";
		if ($remitos_detalle->CurrentAction == "gridadd") {
			if ($remitos_detalle->CurrentMode == "copy") {
				$remitos_detalle_grid->LoadRowValues($remitos_detalle_grid->Recordset); // Load row values
				$remitos_detalle_grid->SetRecordKey($remitos_detalle_grid->RowOldKey, $remitos_detalle_grid->Recordset); // Set old record key
			} else {
				$remitos_detalle_grid->LoadDefaultValues(); // Load default values
				$remitos_detalle_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$remitos_detalle_grid->LoadRowValues($remitos_detalle_grid->Recordset); // Load row values
		}
		$remitos_detalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($remitos_detalle->CurrentAction == "gridadd") // Grid add
			$remitos_detalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($remitos_detalle->CurrentAction == "gridadd" && $remitos_detalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$remitos_detalle_grid->RestoreCurrentRowFormValues($remitos_detalle_grid->RowIndex); // Restore form values
		if ($remitos_detalle->CurrentAction == "gridedit") { // Grid edit
			if ($remitos_detalle->EventCancelled) {
				$remitos_detalle_grid->RestoreCurrentRowFormValues($remitos_detalle_grid->RowIndex); // Restore form values
			}
			if ($remitos_detalle_grid->RowAction == "insert")
				$remitos_detalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$remitos_detalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($remitos_detalle->CurrentAction == "gridedit" && ($remitos_detalle->RowType == EW_ROWTYPE_EDIT || $remitos_detalle->RowType == EW_ROWTYPE_ADD) && $remitos_detalle->EventCancelled) // Update failed
			$remitos_detalle_grid->RestoreCurrentRowFormValues($remitos_detalle_grid->RowIndex); // Restore form values
		if ($remitos_detalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$remitos_detalle_grid->EditRowCnt++;
		if ($remitos_detalle->CurrentAction == "F") // Confirm row
			$remitos_detalle_grid->RestoreCurrentRowFormValues($remitos_detalle_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$remitos_detalle->RowAttrs = array_merge($remitos_detalle->RowAttrs, array('data-rowindex'=>$remitos_detalle_grid->RowCnt, 'id'=>'r' . $remitos_detalle_grid->RowCnt . '_remitos_detalle', 'data-rowtype'=>$remitos_detalle->RowType));

		// Render row
		$remitos_detalle_grid->RenderRow();

		// Render list options
		$remitos_detalle_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($remitos_detalle_grid->RowAction <> "delete" && $remitos_detalle_grid->RowAction <> "insertdelete" && !($remitos_detalle_grid->RowAction == "insert" && $remitos_detalle->CurrentAction == "F" && $remitos_detalle_grid->EmptyRow())) {
?>
	<tr<?php echo $remitos_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$remitos_detalle_grid->ListOptions->Render("body", "left", $remitos_detalle_grid->RowCnt);
?>
	<?php if ($remitos_detalle->cantidad->Visible) { // cantidad ?>
		<td<?php echo $remitos_detalle->cantidad->CellAttributes() ?>>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitos_detalle_grid->RowCnt ?>_remitos_detalle_cantidad" class="control-group remitos_detalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitos_detalle->cantidad->PlaceHolder ?>" value="<?php echo $remitos_detalle->cantidad->EditValue ?>"<?php echo $remitos_detalle->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitos_detalle->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_detalle_grid->RowCnt ?>_remitos_detalle_cantidad" class="control-group remitos_detalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitos_detalle->cantidad->PlaceHolder ?>" value="<?php echo $remitos_detalle->cantidad->EditValue ?>"<?php echo $remitos_detalle->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos_detalle->cantidad->ViewAttributes() ?>>
<?php echo $remitos_detalle->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitos_detalle->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitos_detalle->cantidad->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitos_detalle_grid->PageObjName . "_row_" . $remitos_detalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_Id_RemitoDetalle" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitos_detalle->Id_RemitoDetalle->CurrentValue) ?>">
<input type="hidden" data-field="x_Id_RemitoDetalle" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitos_detalle->Id_RemitoDetalle->OldValue) ?>">
<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_EDIT || $remitos_detalle->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_Id_RemitoDetalle" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitos_detalle->Id_RemitoDetalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($remitos_detalle->descripcion->Visible) { // descripcion ?>
		<td<?php echo $remitos_detalle->descripcion->CellAttributes() ?>>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitos_detalle_grid->RowCnt ?>_remitos_detalle_descripcion" class="control-group remitos_detalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion"<?php echo $remitos_detalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitos_detalle->descripcion->EditValue)) {
	$arwrk = $remitos_detalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos_detalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitos_detalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitos_detallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitos_detalle->descripcion->EditValue)) ? ew_ArrayToJson($remitos_detalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitos_detalle->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitos_detalle_grid->RowCnt ?>_remitos_detalle_descripcion" class="control-group remitos_detalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion"<?php echo $remitos_detalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitos_detalle->descripcion->EditValue)) {
	$arwrk = $remitos_detalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos_detalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitos_detalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitos_detallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitos_detalle->descripcion->EditValue)) ? ew_ArrayToJson($remitos_detalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitos_detalle->descripcion->ViewAttributes() ?>>
<?php echo $remitos_detalle->descripcion->ListViewValue() ?></span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitos_detalle->descripcion->FormValue) ?>">
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitos_detalle->descripcion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitos_detalle_grid->PageObjName . "_row_" . $remitos_detalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$remitos_detalle_grid->ListOptions->Render("body", "right", $remitos_detalle_grid->RowCnt);
?>
	</tr>
<?php if ($remitos_detalle->RowType == EW_ROWTYPE_ADD || $remitos_detalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fremitos_detallegrid.UpdateOpts(<?php echo $remitos_detalle_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($remitos_detalle->CurrentAction <> "gridadd" || $remitos_detalle->CurrentMode == "copy")
		if (!$remitos_detalle_grid->Recordset->EOF) $remitos_detalle_grid->Recordset->MoveNext();
}
?>
<?php
	if ($remitos_detalle->CurrentMode == "add" || $remitos_detalle->CurrentMode == "copy" || $remitos_detalle->CurrentMode == "edit") {
		$remitos_detalle_grid->RowIndex = '$rowindex$';
		$remitos_detalle_grid->LoadDefaultValues();

		// Set row properties
		$remitos_detalle->ResetAttrs();
		$remitos_detalle->RowAttrs = array_merge($remitos_detalle->RowAttrs, array('data-rowindex'=>$remitos_detalle_grid->RowIndex, 'id'=>'r0_remitos_detalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($remitos_detalle->RowAttrs["class"], "ewTemplate");
		$remitos_detalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$remitos_detalle_grid->RenderRow();

		// Render list options
		$remitos_detalle_grid->RenderListOptions();
		$remitos_detalle_grid->StartRowCnt = 0;
?>
	<tr<?php echo $remitos_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$remitos_detalle_grid->ListOptions->Render("body", "left", $remitos_detalle_grid->RowIndex);
?>
	<?php if ($remitos_detalle->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($remitos_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitos_detalle_cantidad" class="control-group remitos_detalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitos_detalle->cantidad->PlaceHolder ?>" value="<?php echo $remitos_detalle->cantidad->EditValue ?>"<?php echo $remitos_detalle->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitos_detalle_cantidad" class="control-group remitos_detalle_cantidad">
<span<?php echo $remitos_detalle->cantidad->ViewAttributes() ?>>
<?php echo $remitos_detalle->cantidad->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitos_detalle->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitos_detalle->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitos_detalle->descripcion->Visible) { // descripcion ?>
		<td>
<?php if ($remitos_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitos_detalle_descripcion" class="control-group remitos_detalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion"<?php echo $remitos_detalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitos_detalle->descripcion->EditValue)) {
	$arwrk = $remitos_detalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitos_detalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitos_detalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitos_detallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitos_detalle->descripcion->EditValue)) ? ew_ArrayToJson($remitos_detalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitos_detalle_descripcion" class="control-group remitos_detalle_descripcion">
<span<?php echo $remitos_detalle->descripcion->ViewAttributes() ?>>
<?php echo $remitos_detalle->descripcion->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" id="x<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitos_detalle->descripcion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitos_detalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitos_detalle->descripcion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$remitos_detalle_grid->ListOptions->Render("body", "right", $remitos_detalle_grid->RowCnt);
?>
<script type="text/javascript">
fremitos_detallegrid.UpdateOpts(<?php echo $remitos_detalle_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($remitos_detalle->CurrentMode == "add" || $remitos_detalle->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $remitos_detalle_grid->FormKeyCountName ?>" id="<?php echo $remitos_detalle_grid->FormKeyCountName ?>" value="<?php echo $remitos_detalle_grid->KeyCount ?>">
<?php echo $remitos_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($remitos_detalle->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $remitos_detalle_grid->FormKeyCountName ?>" id="<?php echo $remitos_detalle_grid->FormKeyCountName ?>" value="<?php echo $remitos_detalle_grid->KeyCount ?>">
<?php echo $remitos_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($remitos_detalle->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fremitos_detallegrid">
</div>
<?php

// Close recordset
if ($remitos_detalle_grid->Recordset)
	$remitos_detalle_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($remitos_detalle->Export == "") { ?>
<script type="text/javascript">
fremitos_detallegrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$remitos_detalle_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$remitos_detalle_grid->Page_Terminate();
?>
