<?php include_once "walger_usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($trama_articulos2Dimagenes2Dadicionales_grid)) $trama_articulos2Dimagenes2Dadicionales_grid = new ctrama_articulos2Dimagenes2Dadicionales_grid();

// Page init
$trama_articulos2Dimagenes2Dadicionales_grid->Page_Init();

// Page main
$trama_articulos2Dimagenes2Dadicionales_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_articulos2Dimagenes2Dadicionales_grid->Page_Render();
?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftrama_articulos2Dimagenes2Dadicionalesgrid = new ew_Form("ftrama_articulos2Dimagenes2Dadicionalesgrid", "grid");
ftrama_articulos2Dimagenes2Dadicionalesgrid.FormKeyCountName = '<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName ?>';

// Validate form
ftrama_articulos2Dimagenes2Dadicionalesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idArticulo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $trama_articulos2Dimagenes2Dadicionales->idArticulo->FldCaption(), $trama_articulos2Dimagenes2Dadicionales->idArticulo->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftrama_articulos2Dimagenes2Dadicionalesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idArticulo", false)) return false;
	return true;
}

// Form_CustomValidate event
ftrama_articulos2Dimagenes2Dadicionalesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_articulos2Dimagenes2Dadicionalesgrid.ValidateRequired = true;
<?php } else { ?>
ftrama_articulos2Dimagenes2Dadicionalesgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd") {
	if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "copy") {
		$bSelectLimit = $trama_articulos2Dimagenes2Dadicionales_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs = $trama_articulos2Dimagenes2Dadicionales->SelectRecordCount();
			$trama_articulos2Dimagenes2Dadicionales_grid->Recordset = $trama_articulos2Dimagenes2Dadicionales_grid->LoadRecordset($trama_articulos2Dimagenes2Dadicionales_grid->StartRec-1, $trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs);
		} else {
			if ($trama_articulos2Dimagenes2Dadicionales_grid->Recordset = $trama_articulos2Dimagenes2Dadicionales_grid->LoadRecordset())
				$trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs = $trama_articulos2Dimagenes2Dadicionales_grid->Recordset->RecordCount();
		}
		$trama_articulos2Dimagenes2Dadicionales_grid->StartRec = 1;
		$trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs = $trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs;
	} else {
		$trama_articulos2Dimagenes2Dadicionales->CurrentFilter = "0=1";
		$trama_articulos2Dimagenes2Dadicionales_grid->StartRec = 1;
		$trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs = $trama_articulos2Dimagenes2Dadicionales->GridAddRowCount;
	}
	$trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs = $trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs;
	$trama_articulos2Dimagenes2Dadicionales_grid->StopRec = $trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs;
} else {
	$bSelectLimit = $trama_articulos2Dimagenes2Dadicionales_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs <= 0)
			$trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs = $trama_articulos2Dimagenes2Dadicionales->SelectRecordCount();
	} else {
		if (!$trama_articulos2Dimagenes2Dadicionales_grid->Recordset && ($trama_articulos2Dimagenes2Dadicionales_grid->Recordset = $trama_articulos2Dimagenes2Dadicionales_grid->LoadRecordset()))
			$trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs = $trama_articulos2Dimagenes2Dadicionales_grid->Recordset->RecordCount();
	}
	$trama_articulos2Dimagenes2Dadicionales_grid->StartRec = 1;
	$trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs = $trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$trama_articulos2Dimagenes2Dadicionales_grid->Recordset = $trama_articulos2Dimagenes2Dadicionales_grid->LoadRecordset($trama_articulos2Dimagenes2Dadicionales_grid->StartRec-1, $trama_articulos2Dimagenes2Dadicionales_grid->DisplayRecs);

	// Set no record found message
	if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "" && $trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$trama_articulos2Dimagenes2Dadicionales_grid->setWarningMessage(ew_DeniedMsg());
		if ($trama_articulos2Dimagenes2Dadicionales_grid->SearchWhere == "0=101")
			$trama_articulos2Dimagenes2Dadicionales_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$trama_articulos2Dimagenes2Dadicionales_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$trama_articulos2Dimagenes2Dadicionales_grid->RenderOtherOptions();
?>
<?php $trama_articulos2Dimagenes2Dadicionales_grid->ShowPageHeader(); ?>
<?php
$trama_articulos2Dimagenes2Dadicionales_grid->ShowMessage();
?>
<?php if ($trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs > 0 || $trama_articulos2Dimagenes2Dadicionales->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid trama_articulos2Dimagenes2Dadicionales">
<div id="ftrama_articulos2Dimagenes2Dadicionalesgrid" class="ewForm form-inline">
<?php if ($trama_articulos2Dimagenes2Dadicionales_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($trama_articulos2Dimagenes2Dadicionales_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_trama_articulos2Dimagenes2Dadicionales" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_trama_articulos2Dimagenes2Dadicionalesgrid" class="table ewTable">
<?php echo $trama_articulos2Dimagenes2Dadicionales->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$trama_articulos2Dimagenes2Dadicionales_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$trama_articulos2Dimagenes2Dadicionales_grid->RenderListOptions();

// Render list options (header, left)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("header", "left");
?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->Visible) { // idArticulo ?>
	<?php if ($trama_articulos2Dimagenes2Dadicionales->SortUrl($trama_articulos2Dimagenes2Dadicionales->idArticulo) == "") { ?>
		<th data-name="idArticulo"><div id="elh_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="trama_articulos2Dimagenes2Dadicionales_idArticulo"><div class="ewTableHeaderCaption"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idArticulo"><div><div id="elh_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="trama_articulos2Dimagenes2Dadicionales_idArticulo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_articulos2Dimagenes2Dadicionales->idArticulo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$trama_articulos2Dimagenes2Dadicionales_grid->StartRec = 1;
$trama_articulos2Dimagenes2Dadicionales_grid->StopRec = $trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName) && ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd" || $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridedit" || $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "F")) {
		$trama_articulos2Dimagenes2Dadicionales_grid->KeyCount = $objForm->GetValue($trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName);
		$trama_articulos2Dimagenes2Dadicionales_grid->StopRec = $trama_articulos2Dimagenes2Dadicionales_grid->StartRec + $trama_articulos2Dimagenes2Dadicionales_grid->KeyCount - 1;
	}
}
$trama_articulos2Dimagenes2Dadicionales_grid->RecCnt = $trama_articulos2Dimagenes2Dadicionales_grid->StartRec - 1;
if ($trama_articulos2Dimagenes2Dadicionales_grid->Recordset && !$trama_articulos2Dimagenes2Dadicionales_grid->Recordset->EOF) {
	$trama_articulos2Dimagenes2Dadicionales_grid->Recordset->MoveFirst();
	$bSelectLimit = $trama_articulos2Dimagenes2Dadicionales_grid->UseSelectLimit;
	if (!$bSelectLimit && $trama_articulos2Dimagenes2Dadicionales_grid->StartRec > 1)
		$trama_articulos2Dimagenes2Dadicionales_grid->Recordset->Move($trama_articulos2Dimagenes2Dadicionales_grid->StartRec - 1);
} elseif (!$trama_articulos2Dimagenes2Dadicionales->AllowAddDeleteRow && $trama_articulos2Dimagenes2Dadicionales_grid->StopRec == 0) {
	$trama_articulos2Dimagenes2Dadicionales_grid->StopRec = $trama_articulos2Dimagenes2Dadicionales->GridAddRowCount;
}

// Initialize aggregate
$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_AGGREGATEINIT;
$trama_articulos2Dimagenes2Dadicionales->ResetAttrs();
$trama_articulos2Dimagenes2Dadicionales_grid->RenderRow();
if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd")
	$trama_articulos2Dimagenes2Dadicionales_grid->RowIndex = 0;
if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridedit")
	$trama_articulos2Dimagenes2Dadicionales_grid->RowIndex = 0;
while ($trama_articulos2Dimagenes2Dadicionales_grid->RecCnt < $trama_articulos2Dimagenes2Dadicionales_grid->StopRec) {
	$trama_articulos2Dimagenes2Dadicionales_grid->RecCnt++;
	if (intval($trama_articulos2Dimagenes2Dadicionales_grid->RecCnt) >= intval($trama_articulos2Dimagenes2Dadicionales_grid->StartRec)) {
		$trama_articulos2Dimagenes2Dadicionales_grid->RowCnt++;
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd" || $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridedit" || $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "F") {
			$trama_articulos2Dimagenes2Dadicionales_grid->RowIndex++;
			$objForm->Index = $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex;
			if ($objForm->HasValue($trama_articulos2Dimagenes2Dadicionales_grid->FormActionName))
				$trama_articulos2Dimagenes2Dadicionales_grid->RowAction = strval($objForm->GetValue($trama_articulos2Dimagenes2Dadicionales_grid->FormActionName));
			elseif ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd")
				$trama_articulos2Dimagenes2Dadicionales_grid->RowAction = "insert";
			else
				$trama_articulos2Dimagenes2Dadicionales_grid->RowAction = "";
		}

		// Set up key count
		$trama_articulos2Dimagenes2Dadicionales_grid->KeyCount = $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex;

		// Init row class and style
		$trama_articulos2Dimagenes2Dadicionales->ResetAttrs();
		$trama_articulos2Dimagenes2Dadicionales->CssClass = "";
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd") {
			if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "copy") {
				$trama_articulos2Dimagenes2Dadicionales_grid->LoadRowValues($trama_articulos2Dimagenes2Dadicionales_grid->Recordset); // Load row values
				$trama_articulos2Dimagenes2Dadicionales_grid->SetRecordKey($trama_articulos2Dimagenes2Dadicionales_grid->RowOldKey, $trama_articulos2Dimagenes2Dadicionales_grid->Recordset); // Set old record key
			} else {
				$trama_articulos2Dimagenes2Dadicionales_grid->LoadDefaultValues(); // Load default values
				$trama_articulos2Dimagenes2Dadicionales_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$trama_articulos2Dimagenes2Dadicionales_grid->LoadRowValues($trama_articulos2Dimagenes2Dadicionales_grid->Recordset); // Load row values
		}
		$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd") // Grid add
			$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_ADD; // Render add
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridadd" && $trama_articulos2Dimagenes2Dadicionales->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$trama_articulos2Dimagenes2Dadicionales_grid->RestoreCurrentRowFormValues($trama_articulos2Dimagenes2Dadicionales_grid->RowIndex); // Restore form values
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridedit") { // Grid edit
			if ($trama_articulos2Dimagenes2Dadicionales->EventCancelled) {
				$trama_articulos2Dimagenes2Dadicionales_grid->RestoreCurrentRowFormValues($trama_articulos2Dimagenes2Dadicionales_grid->RowIndex); // Restore form values
			}
			if ($trama_articulos2Dimagenes2Dadicionales_grid->RowAction == "insert")
				$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "gridedit" && ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_EDIT || $trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_ADD) && $trama_articulos2Dimagenes2Dadicionales->EventCancelled) // Update failed
			$trama_articulos2Dimagenes2Dadicionales_grid->RestoreCurrentRowFormValues($trama_articulos2Dimagenes2Dadicionales_grid->RowIndex); // Restore form values
		if ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_EDIT) // Edit row
			$trama_articulos2Dimagenes2Dadicionales_grid->EditRowCnt++;
		if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction == "F") // Confirm row
			$trama_articulos2Dimagenes2Dadicionales_grid->RestoreCurrentRowFormValues($trama_articulos2Dimagenes2Dadicionales_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$trama_articulos2Dimagenes2Dadicionales->RowAttrs = array_merge($trama_articulos2Dimagenes2Dadicionales->RowAttrs, array('data-rowindex'=>$trama_articulos2Dimagenes2Dadicionales_grid->RowCnt, 'id'=>'r' . $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt . '_trama_articulos2Dimagenes2Dadicionales', 'data-rowtype'=>$trama_articulos2Dimagenes2Dadicionales->RowType));

		// Render row
		$trama_articulos2Dimagenes2Dadicionales_grid->RenderRow();

		// Render list options
		$trama_articulos2Dimagenes2Dadicionales_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($trama_articulos2Dimagenes2Dadicionales_grid->RowAction <> "delete" && $trama_articulos2Dimagenes2Dadicionales_grid->RowAction <> "insertdelete" && !($trama_articulos2Dimagenes2Dadicionales_grid->RowAction == "insert" && $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "F" && $trama_articulos2Dimagenes2Dadicionales_grid->EmptyRow())) {
?>
	<tr<?php echo $trama_articulos2Dimagenes2Dadicionales->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("body", "left", $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt);
?>
	<?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->Visible) { // idArticulo ?>
		<td data-name="idArticulo"<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->CellAttributes() ?>>
<?php if ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->getSessionValue() <> "") { ?>
<span id="el<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt ?>_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<span<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt ?>_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<input type="text" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->getPlaceHolder()) ?>" value="<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->EditValue ?>"<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->OldValue) ?>">
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt ?>_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<span<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->EditValue ?></p></span>
</span>
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->CurrentValue) ?>">
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt ?>_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="trama_articulos2Dimagenes2Dadicionales_idArticulo">
<span<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewAttributes() ?>>
<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->FormValue) ?>">
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->PageObjName . "_row_" . $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("body", "right", $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt);
?>
	</tr>
<?php if ($trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_ADD || $trama_articulos2Dimagenes2Dadicionales->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftrama_articulos2Dimagenes2Dadicionalesgrid.UpdateOpts(<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction <> "gridadd" || $trama_articulos2Dimagenes2Dadicionales->CurrentMode == "copy")
		if (!$trama_articulos2Dimagenes2Dadicionales_grid->Recordset->EOF) $trama_articulos2Dimagenes2Dadicionales_grid->Recordset->MoveNext();
}
?>
<?php
	if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "add" || $trama_articulos2Dimagenes2Dadicionales->CurrentMode == "copy" || $trama_articulos2Dimagenes2Dadicionales->CurrentMode == "edit") {
		$trama_articulos2Dimagenes2Dadicionales_grid->RowIndex = '$rowindex$';
		$trama_articulos2Dimagenes2Dadicionales_grid->LoadDefaultValues();

		// Set row properties
		$trama_articulos2Dimagenes2Dadicionales->ResetAttrs();
		$trama_articulos2Dimagenes2Dadicionales->RowAttrs = array_merge($trama_articulos2Dimagenes2Dadicionales->RowAttrs, array('data-rowindex'=>$trama_articulos2Dimagenes2Dadicionales_grid->RowIndex, 'id'=>'r0_trama_articulos2Dimagenes2Dadicionales', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($trama_articulos2Dimagenes2Dadicionales->RowAttrs["class"], "ewTemplate");
		$trama_articulos2Dimagenes2Dadicionales->RowType = EW_ROWTYPE_ADD;

		// Render row
		$trama_articulos2Dimagenes2Dadicionales_grid->RenderRow();

		// Render list options
		$trama_articulos2Dimagenes2Dadicionales_grid->RenderListOptions();
		$trama_articulos2Dimagenes2Dadicionales_grid->StartRowCnt = 0;
?>
	<tr<?php echo $trama_articulos2Dimagenes2Dadicionales->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("body", "left", $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex);
?>
	<?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->Visible) { // idArticulo ?>
		<td data-name="idArticulo">
<?php if ($trama_articulos2Dimagenes2Dadicionales->CurrentAction <> "F") { ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->idArticulo->getSessionValue() <> "") { ?>
<span id="el$rowindex$_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<span<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<input type="text" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->getPlaceHolder()) ?>" value="<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->EditValue ?>"<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_trama_articulos2Dimagenes2Dadicionales_idArticulo" class="form-group trama_articulos2Dimagenes2Dadicionales_idArticulo">
<span<?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_articulos2Dimagenes2Dadicionales->idArticulo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="x<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_articulos2Dimagenes2Dadicionales" data-field="x_idArticulo" name="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" id="o<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>_idArticulo" value="<?php echo ew_HtmlEncode($trama_articulos2Dimagenes2Dadicionales->idArticulo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_articulos2Dimagenes2Dadicionales_grid->ListOptions->Render("body", "right", $trama_articulos2Dimagenes2Dadicionales_grid->RowCnt);
?>
<script type="text/javascript">
ftrama_articulos2Dimagenes2Dadicionalesgrid.UpdateOpts(<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "add" || $trama_articulos2Dimagenes2Dadicionales->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName ?>" id="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName ?>" value="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->KeyCount ?>">
<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName ?>" id="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->FormKeyCountName ?>" value="<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->KeyCount ?>">
<?php echo $trama_articulos2Dimagenes2Dadicionales_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftrama_articulos2Dimagenes2Dadicionalesgrid">
</div>
<?php

// Close recordset
if ($trama_articulos2Dimagenes2Dadicionales_grid->Recordset)
	$trama_articulos2Dimagenes2Dadicionales_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales_grid->TotalRecs == 0 && $trama_articulos2Dimagenes2Dadicionales->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($trama_articulos2Dimagenes2Dadicionales_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($trama_articulos2Dimagenes2Dadicionales->Export == "") { ?>
<script type="text/javascript">
ftrama_articulos2Dimagenes2Dadicionalesgrid.Init();
</script>
<?php } ?>
<?php
$trama_articulos2Dimagenes2Dadicionales_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$trama_articulos2Dimagenes2Dadicionales_grid->Page_Terminate();
?>
