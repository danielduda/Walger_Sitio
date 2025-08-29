<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($facturas_grid)) $facturas_grid = new cfacturas_grid();

// Page init
$facturas_grid->Page_Init();

// Page main
$facturas_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$facturas_grid->Page_Render();
?>
<?php if ($facturas->Export == "") { ?>
<script type="text/javascript">

// Page object
var facturas_grid = new ew_Page("facturas_grid");
facturas_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = facturas_grid.PageID; // For backward compatibility

// Form object
var ffacturasgrid = new ew_Form("ffacturasgrid");
ffacturasgrid.FormKeyCountName = '<?php echo $facturas_grid->FormKeyCountName ?>';

// Validate form
ffacturasgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_numFactura");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($facturas->numFactura->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_RemitoCabecera");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($facturas->RemitoCabecera->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_RemitoCabecera");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($facturas->RemitoCabecera->FldErrMsg()) ?>");

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
ffacturasgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "numFactura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "RemitoCabecera", false)) return false;
	return true;
}

// Form_CustomValidate event
ffacturasgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffacturasgrid.ValidateRequired = true;
<?php } else { ?>
ffacturasgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($facturas->getCurrentMasterTable() == "" && $facturas_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $facturas_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($facturas->CurrentAction == "gridadd") {
	if ($facturas->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$facturas_grid->TotalRecs = $facturas->SelectRecordCount();
			$facturas_grid->Recordset = $facturas_grid->LoadRecordset($facturas_grid->StartRec-1, $facturas_grid->DisplayRecs);
		} else {
			if ($facturas_grid->Recordset = $facturas_grid->LoadRecordset())
				$facturas_grid->TotalRecs = $facturas_grid->Recordset->RecordCount();
		}
		$facturas_grid->StartRec = 1;
		$facturas_grid->DisplayRecs = $facturas_grid->TotalRecs;
	} else {
		$facturas->CurrentFilter = "0=1";
		$facturas_grid->StartRec = 1;
		$facturas_grid->DisplayRecs = $facturas->GridAddRowCount;
	}
	$facturas_grid->TotalRecs = $facturas_grid->DisplayRecs;
	$facturas_grid->StopRec = $facturas_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$facturas_grid->TotalRecs = $facturas->SelectRecordCount();
	} else {
		if ($facturas_grid->Recordset = $facturas_grid->LoadRecordset())
			$facturas_grid->TotalRecs = $facturas_grid->Recordset->RecordCount();
	}
	$facturas_grid->StartRec = 1;
	$facturas_grid->DisplayRecs = $facturas_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$facturas_grid->Recordset = $facturas_grid->LoadRecordset($facturas_grid->StartRec-1, $facturas_grid->DisplayRecs);
}
$facturas_grid->RenderOtherOptions();
?>
<?php $facturas_grid->ShowPageHeader(); ?>
<?php
$facturas_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="ffacturasgrid" class="ewForm form-horizontal">
<?php if ($facturas_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel ewListOtherOptions">
<?php
	foreach ($facturas_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<div id="gmp_facturas" class="ewGridMiddlePanel">
<table id="tbl_facturasgrid" class="ewTable ewTableSeparate">
<?php echo $facturas->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$facturas_grid->RenderListOptions();

// Render list options (header, left)
$facturas_grid->ListOptions->Render("header", "left");
?>
<?php if ($facturas->numFactura->Visible) { // numFactura ?>
	<?php if ($facturas->SortUrl($facturas->numFactura) == "") { ?>
		<td><div id="elh_facturas_numFactura" class="facturas_numFactura"><div class="ewTableHeaderCaption"><?php echo $facturas->numFactura->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_facturas_numFactura" class="facturas_numFactura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $facturas->numFactura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($facturas->numFactura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($facturas->numFactura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($facturas->RemitoCabecera->Visible) { // RemitoCabecera ?>
	<?php if ($facturas->SortUrl($facturas->RemitoCabecera) == "") { ?>
		<td><div id="elh_facturas_RemitoCabecera" class="facturas_RemitoCabecera"><div class="ewTableHeaderCaption"><?php echo $facturas->RemitoCabecera->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_facturas_RemitoCabecera" class="facturas_RemitoCabecera">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $facturas->RemitoCabecera->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($facturas->RemitoCabecera->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($facturas->RemitoCabecera->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$facturas_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$facturas_grid->StartRec = 1;
$facturas_grid->StopRec = $facturas_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($facturas_grid->FormKeyCountName) && ($facturas->CurrentAction == "gridadd" || $facturas->CurrentAction == "gridedit" || $facturas->CurrentAction == "F")) {
		$facturas_grid->KeyCount = $objForm->GetValue($facturas_grid->FormKeyCountName);
		$facturas_grid->StopRec = $facturas_grid->StartRec + $facturas_grid->KeyCount - 1;
	}
}
$facturas_grid->RecCnt = $facturas_grid->StartRec - 1;
if ($facturas_grid->Recordset && !$facturas_grid->Recordset->EOF) {
	$facturas_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $facturas_grid->StartRec > 1)
		$facturas_grid->Recordset->Move($facturas_grid->StartRec - 1);
} elseif (!$facturas->AllowAddDeleteRow && $facturas_grid->StopRec == 0) {
	$facturas_grid->StopRec = $facturas->GridAddRowCount;
}

// Initialize aggregate
$facturas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$facturas->ResetAttrs();
$facturas_grid->RenderRow();
if ($facturas->CurrentAction == "gridadd")
	$facturas_grid->RowIndex = 0;
if ($facturas->CurrentAction == "gridedit")
	$facturas_grid->RowIndex = 0;
while ($facturas_grid->RecCnt < $facturas_grid->StopRec) {
	$facturas_grid->RecCnt++;
	if (intval($facturas_grid->RecCnt) >= intval($facturas_grid->StartRec)) {
		$facturas_grid->RowCnt++;
		if ($facturas->CurrentAction == "gridadd" || $facturas->CurrentAction == "gridedit" || $facturas->CurrentAction == "F") {
			$facturas_grid->RowIndex++;
			$objForm->Index = $facturas_grid->RowIndex;
			if ($objForm->HasValue($facturas_grid->FormActionName))
				$facturas_grid->RowAction = strval($objForm->GetValue($facturas_grid->FormActionName));
			elseif ($facturas->CurrentAction == "gridadd")
				$facturas_grid->RowAction = "insert";
			else
				$facturas_grid->RowAction = "";
		}

		// Set up key count
		$facturas_grid->KeyCount = $facturas_grid->RowIndex;

		// Init row class and style
		$facturas->ResetAttrs();
		$facturas->CssClass = "";
		if ($facturas->CurrentAction == "gridadd") {
			if ($facturas->CurrentMode == "copy") {
				$facturas_grid->LoadRowValues($facturas_grid->Recordset); // Load row values
				$facturas_grid->SetRecordKey($facturas_grid->RowOldKey, $facturas_grid->Recordset); // Set old record key
			} else {
				$facturas_grid->LoadDefaultValues(); // Load default values
				$facturas_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$facturas_grid->LoadRowValues($facturas_grid->Recordset); // Load row values
		}
		$facturas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($facturas->CurrentAction == "gridadd") // Grid add
			$facturas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($facturas->CurrentAction == "gridadd" && $facturas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$facturas_grid->RestoreCurrentRowFormValues($facturas_grid->RowIndex); // Restore form values
		if ($facturas->CurrentAction == "gridedit") { // Grid edit
			if ($facturas->EventCancelled) {
				$facturas_grid->RestoreCurrentRowFormValues($facturas_grid->RowIndex); // Restore form values
			}
			if ($facturas_grid->RowAction == "insert")
				$facturas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$facturas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($facturas->CurrentAction == "gridedit" && ($facturas->RowType == EW_ROWTYPE_EDIT || $facturas->RowType == EW_ROWTYPE_ADD) && $facturas->EventCancelled) // Update failed
			$facturas_grid->RestoreCurrentRowFormValues($facturas_grid->RowIndex); // Restore form values
		if ($facturas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$facturas_grid->EditRowCnt++;
		if ($facturas->CurrentAction == "F") // Confirm row
			$facturas_grid->RestoreCurrentRowFormValues($facturas_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$facturas->RowAttrs = array_merge($facturas->RowAttrs, array('data-rowindex'=>$facturas_grid->RowCnt, 'id'=>'r' . $facturas_grid->RowCnt . '_facturas', 'data-rowtype'=>$facturas->RowType));

		// Render row
		$facturas_grid->RenderRow();

		// Render list options
		$facturas_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($facturas_grid->RowAction <> "delete" && $facturas_grid->RowAction <> "insertdelete" && !($facturas_grid->RowAction == "insert" && $facturas->CurrentAction == "F" && $facturas_grid->EmptyRow())) {
?>
	<tr<?php echo $facturas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$facturas_grid->ListOptions->Render("body", "left", $facturas_grid->RowCnt);
?>
	<?php if ($facturas->numFactura->Visible) { // numFactura ?>
		<td<?php echo $facturas->numFactura->CellAttributes() ?>>
<?php if ($facturas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $facturas_grid->RowCnt ?>_facturas_numFactura" class="control-group facturas_numFactura">
<input type="text" data-field="x_numFactura" name="x<?php echo $facturas_grid->RowIndex ?>_numFactura" id="x<?php echo $facturas_grid->RowIndex ?>_numFactura" size="30" maxlength="10" placeholder="<?php echo $facturas->numFactura->PlaceHolder ?>" value="<?php echo $facturas->numFactura->EditValue ?>"<?php echo $facturas->numFactura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_numFactura" name="o<?php echo $facturas_grid->RowIndex ?>_numFactura" id="o<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->OldValue) ?>">
<?php } ?>
<?php if ($facturas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $facturas_grid->RowCnt ?>_facturas_numFactura" class="control-group facturas_numFactura">
<span<?php echo $facturas->numFactura->ViewAttributes() ?>>
<?php echo $facturas->numFactura->EditValue ?></span>
</span>
<input type="hidden" data-field="x_numFactura" name="x<?php echo $facturas_grid->RowIndex ?>_numFactura" id="x<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->CurrentValue) ?>">
<?php } ?>
<?php if ($facturas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $facturas->numFactura->ViewAttributes() ?>>
<?php echo $facturas->numFactura->ListViewValue() ?></span>
<input type="hidden" data-field="x_numFactura" name="x<?php echo $facturas_grid->RowIndex ?>_numFactura" id="x<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->FormValue) ?>">
<input type="hidden" data-field="x_numFactura" name="o<?php echo $facturas_grid->RowIndex ?>_numFactura" id="o<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->OldValue) ?>">
<?php } ?>
<a id="<?php echo $facturas_grid->PageObjName . "_row_" . $facturas_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($facturas->RemitoCabecera->Visible) { // RemitoCabecera ?>
		<td<?php echo $facturas->RemitoCabecera->CellAttributes() ?>>
<?php if ($facturas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($facturas->RemitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $facturas->RemitoCabecera->ViewAttributes() ?>>
<?php echo $facturas->RemitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" size="30" placeholder="<?php echo $facturas->RemitoCabecera->PlaceHolder ?>" value="<?php echo $facturas->RemitoCabecera->EditValue ?>"<?php echo $facturas->RemitoCabecera->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_RemitoCabecera" name="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->OldValue) ?>">
<?php } ?>
<?php if ($facturas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($facturas->RemitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $facturas->RemitoCabecera->ViewAttributes() ?>>
<?php echo $facturas->RemitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" size="30" placeholder="<?php echo $facturas->RemitoCabecera->PlaceHolder ?>" value="<?php echo $facturas->RemitoCabecera->EditValue ?>"<?php echo $facturas->RemitoCabecera->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($facturas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $facturas->RemitoCabecera->ViewAttributes() ?>>
<?php echo $facturas->RemitoCabecera->ListViewValue() ?></span>
<input type="hidden" data-field="x_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->FormValue) ?>">
<input type="hidden" data-field="x_RemitoCabecera" name="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->OldValue) ?>">
<?php } ?>
<a id="<?php echo $facturas_grid->PageObjName . "_row_" . $facturas_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$facturas_grid->ListOptions->Render("body", "right", $facturas_grid->RowCnt);
?>
	</tr>
<?php if ($facturas->RowType == EW_ROWTYPE_ADD || $facturas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ffacturasgrid.UpdateOpts(<?php echo $facturas_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($facturas->CurrentAction <> "gridadd" || $facturas->CurrentMode == "copy")
		if (!$facturas_grid->Recordset->EOF) $facturas_grid->Recordset->MoveNext();
}
?>
<?php
	if ($facturas->CurrentMode == "add" || $facturas->CurrentMode == "copy" || $facturas->CurrentMode == "edit") {
		$facturas_grid->RowIndex = '$rowindex$';
		$facturas_grid->LoadDefaultValues();

		// Set row properties
		$facturas->ResetAttrs();
		$facturas->RowAttrs = array_merge($facturas->RowAttrs, array('data-rowindex'=>$facturas_grid->RowIndex, 'id'=>'r0_facturas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($facturas->RowAttrs["class"], "ewTemplate");
		$facturas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$facturas_grid->RenderRow();

		// Render list options
		$facturas_grid->RenderListOptions();
		$facturas_grid->StartRowCnt = 0;
?>
	<tr<?php echo $facturas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$facturas_grid->ListOptions->Render("body", "left", $facturas_grid->RowIndex);
?>
	<?php if ($facturas->numFactura->Visible) { // numFactura ?>
		<td>
<?php if ($facturas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_facturas_numFactura" class="control-group facturas_numFactura">
<input type="text" data-field="x_numFactura" name="x<?php echo $facturas_grid->RowIndex ?>_numFactura" id="x<?php echo $facturas_grid->RowIndex ?>_numFactura" size="30" maxlength="10" placeholder="<?php echo $facturas->numFactura->PlaceHolder ?>" value="<?php echo $facturas->numFactura->EditValue ?>"<?php echo $facturas->numFactura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_facturas_numFactura" class="control-group facturas_numFactura">
<span<?php echo $facturas->numFactura->ViewAttributes() ?>>
<?php echo $facturas->numFactura->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_numFactura" name="x<?php echo $facturas_grid->RowIndex ?>_numFactura" id="x<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_numFactura" name="o<?php echo $facturas_grid->RowIndex ?>_numFactura" id="o<?php echo $facturas_grid->RowIndex ?>_numFactura" value="<?php echo ew_HtmlEncode($facturas->numFactura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($facturas->RemitoCabecera->Visible) { // RemitoCabecera ?>
		<td>
<?php if ($facturas->CurrentAction <> "F") { ?>
<?php if ($facturas->RemitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $facturas->RemitoCabecera->ViewAttributes() ?>>
<?php echo $facturas->RemitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" size="30" placeholder="<?php echo $facturas->RemitoCabecera->PlaceHolder ?>" value="<?php echo $facturas->RemitoCabecera->EditValue ?>"<?php echo $facturas->RemitoCabecera->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $facturas->RemitoCabecera->ViewAttributes() ?>>
<?php echo $facturas->RemitoCabecera->ViewValue ?></span>
<input type="hidden" data-field="x_RemitoCabecera" name="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="x<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_RemitoCabecera" name="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" id="o<?php echo $facturas_grid->RowIndex ?>_RemitoCabecera" value="<?php echo ew_HtmlEncode($facturas->RemitoCabecera->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$facturas_grid->ListOptions->Render("body", "right", $facturas_grid->RowCnt);
?>
<script type="text/javascript">
ffacturasgrid.UpdateOpts(<?php echo $facturas_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($facturas->CurrentMode == "add" || $facturas->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $facturas_grid->FormKeyCountName ?>" id="<?php echo $facturas_grid->FormKeyCountName ?>" value="<?php echo $facturas_grid->KeyCount ?>">
<?php echo $facturas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($facturas->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $facturas_grid->FormKeyCountName ?>" id="<?php echo $facturas_grid->FormKeyCountName ?>" value="<?php echo $facturas_grid->KeyCount ?>">
<?php echo $facturas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($facturas->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffacturasgrid">
</div>
<?php

// Close recordset
if ($facturas_grid->Recordset)
	$facturas_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($facturas->Export == "") { ?>
<script type="text/javascript">
ffacturasgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$facturas_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$facturas_grid->Page_Terminate();
?>
