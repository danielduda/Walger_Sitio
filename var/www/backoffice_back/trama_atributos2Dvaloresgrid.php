<?php include_once "walger_usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($trama_atributos2Dvalores_grid)) $trama_atributos2Dvalores_grid = new ctrama_atributos2Dvalores_grid();

// Page init
$trama_atributos2Dvalores_grid->Page_Init();

// Page main
$trama_atributos2Dvalores_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_atributos2Dvalores_grid->Page_Render();
?>
<?php if ($trama_atributos2Dvalores->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftrama_atributos2Dvaloresgrid = new ew_Form("ftrama_atributos2Dvaloresgrid", "grid");
ftrama_atributos2Dvaloresgrid.FormKeyCountName = '<?php echo $trama_atributos2Dvalores_grid->FormKeyCountName ?>';

// Validate form
ftrama_atributos2Dvaloresgrid.Validate = function() {
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
ftrama_atributos2Dvaloresgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idAtributo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "valor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "imagen", false)) return false;
	return true;
}

// Form_CustomValidate event
ftrama_atributos2Dvaloresgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_atributos2Dvaloresgrid.ValidateRequired = true;
<?php } else { ?>
ftrama_atributos2Dvaloresgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_atributos2Dvaloresgrid.Lists["x_idAtributo"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"trama_atributos"};

// Form object for search
</script>
<?php } ?>
<?php
if ($trama_atributos2Dvalores->CurrentAction == "gridadd") {
	if ($trama_atributos2Dvalores->CurrentMode == "copy") {
		$bSelectLimit = $trama_atributos2Dvalores_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$trama_atributos2Dvalores_grid->TotalRecs = $trama_atributos2Dvalores->SelectRecordCount();
			$trama_atributos2Dvalores_grid->Recordset = $trama_atributos2Dvalores_grid->LoadRecordset($trama_atributos2Dvalores_grid->StartRec-1, $trama_atributos2Dvalores_grid->DisplayRecs);
		} else {
			if ($trama_atributos2Dvalores_grid->Recordset = $trama_atributos2Dvalores_grid->LoadRecordset())
				$trama_atributos2Dvalores_grid->TotalRecs = $trama_atributos2Dvalores_grid->Recordset->RecordCount();
		}
		$trama_atributos2Dvalores_grid->StartRec = 1;
		$trama_atributos2Dvalores_grid->DisplayRecs = $trama_atributos2Dvalores_grid->TotalRecs;
	} else {
		$trama_atributos2Dvalores->CurrentFilter = "0=1";
		$trama_atributos2Dvalores_grid->StartRec = 1;
		$trama_atributos2Dvalores_grid->DisplayRecs = $trama_atributos2Dvalores->GridAddRowCount;
	}
	$trama_atributos2Dvalores_grid->TotalRecs = $trama_atributos2Dvalores_grid->DisplayRecs;
	$trama_atributos2Dvalores_grid->StopRec = $trama_atributos2Dvalores_grid->DisplayRecs;
} else {
	$bSelectLimit = $trama_atributos2Dvalores_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($trama_atributos2Dvalores_grid->TotalRecs <= 0)
			$trama_atributos2Dvalores_grid->TotalRecs = $trama_atributos2Dvalores->SelectRecordCount();
	} else {
		if (!$trama_atributos2Dvalores_grid->Recordset && ($trama_atributos2Dvalores_grid->Recordset = $trama_atributos2Dvalores_grid->LoadRecordset()))
			$trama_atributos2Dvalores_grid->TotalRecs = $trama_atributos2Dvalores_grid->Recordset->RecordCount();
	}
	$trama_atributos2Dvalores_grid->StartRec = 1;
	$trama_atributos2Dvalores_grid->DisplayRecs = $trama_atributos2Dvalores_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$trama_atributos2Dvalores_grid->Recordset = $trama_atributos2Dvalores_grid->LoadRecordset($trama_atributos2Dvalores_grid->StartRec-1, $trama_atributos2Dvalores_grid->DisplayRecs);

	// Set no record found message
	if ($trama_atributos2Dvalores->CurrentAction == "" && $trama_atributos2Dvalores_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$trama_atributos2Dvalores_grid->setWarningMessage(ew_DeniedMsg());
		if ($trama_atributos2Dvalores_grid->SearchWhere == "0=101")
			$trama_atributos2Dvalores_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$trama_atributos2Dvalores_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$trama_atributos2Dvalores_grid->RenderOtherOptions();
?>
<?php $trama_atributos2Dvalores_grid->ShowPageHeader(); ?>
<?php
$trama_atributos2Dvalores_grid->ShowMessage();
?>
<?php if ($trama_atributos2Dvalores_grid->TotalRecs > 0 || $trama_atributos2Dvalores->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid trama_atributos2Dvalores">
<div id="ftrama_atributos2Dvaloresgrid" class="ewForm form-inline">
<?php if ($trama_atributos2Dvalores_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($trama_atributos2Dvalores_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_trama_atributos2Dvalores" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_trama_atributos2Dvaloresgrid" class="table ewTable">
<?php echo $trama_atributos2Dvalores->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$trama_atributos2Dvalores_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$trama_atributos2Dvalores_grid->RenderListOptions();

// Render list options (header, left)
$trama_atributos2Dvalores_grid->ListOptions->Render("header", "left");
?>
<?php if ($trama_atributos2Dvalores->id->Visible) { // id ?>
	<?php if ($trama_atributos2Dvalores->SortUrl($trama_atributos2Dvalores->id) == "") { ?>
		<th data-name="id"><div id="elh_trama_atributos2Dvalores_id" class="trama_atributos2Dvalores_id"><div class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_trama_atributos2Dvalores_id" class="trama_atributos2Dvalores_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_atributos2Dvalores->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_atributos2Dvalores->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($trama_atributos2Dvalores->idAtributo->Visible) { // idAtributo ?>
	<?php if ($trama_atributos2Dvalores->SortUrl($trama_atributos2Dvalores->idAtributo) == "") { ?>
		<th data-name="idAtributo"><div id="elh_trama_atributos2Dvalores_idAtributo" class="trama_atributos2Dvalores_idAtributo"><div class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->idAtributo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idAtributo"><div><div id="elh_trama_atributos2Dvalores_idAtributo" class="trama_atributos2Dvalores_idAtributo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->idAtributo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_atributos2Dvalores->idAtributo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_atributos2Dvalores->idAtributo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($trama_atributos2Dvalores->valor->Visible) { // valor ?>
	<?php if ($trama_atributos2Dvalores->SortUrl($trama_atributos2Dvalores->valor) == "") { ?>
		<th data-name="valor"><div id="elh_trama_atributos2Dvalores_valor" class="trama_atributos2Dvalores_valor"><div class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->valor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="valor"><div><div id="elh_trama_atributos2Dvalores_valor" class="trama_atributos2Dvalores_valor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->valor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_atributos2Dvalores->valor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_atributos2Dvalores->valor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($trama_atributos2Dvalores->imagen->Visible) { // imagen ?>
	<?php if ($trama_atributos2Dvalores->SortUrl($trama_atributos2Dvalores->imagen) == "") { ?>
		<th data-name="imagen"><div id="elh_trama_atributos2Dvalores_imagen" class="trama_atributos2Dvalores_imagen"><div class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->imagen->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="imagen"><div><div id="elh_trama_atributos2Dvalores_imagen" class="trama_atributos2Dvalores_imagen">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_atributos2Dvalores->imagen->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_atributos2Dvalores->imagen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_atributos2Dvalores->imagen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$trama_atributos2Dvalores_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$trama_atributos2Dvalores_grid->StartRec = 1;
$trama_atributos2Dvalores_grid->StopRec = $trama_atributos2Dvalores_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($trama_atributos2Dvalores_grid->FormKeyCountName) && ($trama_atributos2Dvalores->CurrentAction == "gridadd" || $trama_atributos2Dvalores->CurrentAction == "gridedit" || $trama_atributos2Dvalores->CurrentAction == "F")) {
		$trama_atributos2Dvalores_grid->KeyCount = $objForm->GetValue($trama_atributos2Dvalores_grid->FormKeyCountName);
		$trama_atributos2Dvalores_grid->StopRec = $trama_atributos2Dvalores_grid->StartRec + $trama_atributos2Dvalores_grid->KeyCount - 1;
	}
}
$trama_atributos2Dvalores_grid->RecCnt = $trama_atributos2Dvalores_grid->StartRec - 1;
if ($trama_atributos2Dvalores_grid->Recordset && !$trama_atributos2Dvalores_grid->Recordset->EOF) {
	$trama_atributos2Dvalores_grid->Recordset->MoveFirst();
	$bSelectLimit = $trama_atributos2Dvalores_grid->UseSelectLimit;
	if (!$bSelectLimit && $trama_atributos2Dvalores_grid->StartRec > 1)
		$trama_atributos2Dvalores_grid->Recordset->Move($trama_atributos2Dvalores_grid->StartRec - 1);
} elseif (!$trama_atributos2Dvalores->AllowAddDeleteRow && $trama_atributos2Dvalores_grid->StopRec == 0) {
	$trama_atributos2Dvalores_grid->StopRec = $trama_atributos2Dvalores->GridAddRowCount;
}

// Initialize aggregate
$trama_atributos2Dvalores->RowType = EW_ROWTYPE_AGGREGATEINIT;
$trama_atributos2Dvalores->ResetAttrs();
$trama_atributos2Dvalores_grid->RenderRow();
if ($trama_atributos2Dvalores->CurrentAction == "gridadd")
	$trama_atributos2Dvalores_grid->RowIndex = 0;
if ($trama_atributos2Dvalores->CurrentAction == "gridedit")
	$trama_atributos2Dvalores_grid->RowIndex = 0;
while ($trama_atributos2Dvalores_grid->RecCnt < $trama_atributos2Dvalores_grid->StopRec) {
	$trama_atributos2Dvalores_grid->RecCnt++;
	if (intval($trama_atributos2Dvalores_grid->RecCnt) >= intval($trama_atributos2Dvalores_grid->StartRec)) {
		$trama_atributos2Dvalores_grid->RowCnt++;
		if ($trama_atributos2Dvalores->CurrentAction == "gridadd" || $trama_atributos2Dvalores->CurrentAction == "gridedit" || $trama_atributos2Dvalores->CurrentAction == "F") {
			$trama_atributos2Dvalores_grid->RowIndex++;
			$objForm->Index = $trama_atributos2Dvalores_grid->RowIndex;
			if ($objForm->HasValue($trama_atributos2Dvalores_grid->FormActionName))
				$trama_atributos2Dvalores_grid->RowAction = strval($objForm->GetValue($trama_atributos2Dvalores_grid->FormActionName));
			elseif ($trama_atributos2Dvalores->CurrentAction == "gridadd")
				$trama_atributos2Dvalores_grid->RowAction = "insert";
			else
				$trama_atributos2Dvalores_grid->RowAction = "";
		}

		// Set up key count
		$trama_atributos2Dvalores_grid->KeyCount = $trama_atributos2Dvalores_grid->RowIndex;

		// Init row class and style
		$trama_atributos2Dvalores->ResetAttrs();
		$trama_atributos2Dvalores->CssClass = "";
		if ($trama_atributos2Dvalores->CurrentAction == "gridadd") {
			if ($trama_atributos2Dvalores->CurrentMode == "copy") {
				$trama_atributos2Dvalores_grid->LoadRowValues($trama_atributos2Dvalores_grid->Recordset); // Load row values
				$trama_atributos2Dvalores_grid->SetRecordKey($trama_atributos2Dvalores_grid->RowOldKey, $trama_atributos2Dvalores_grid->Recordset); // Set old record key
			} else {
				$trama_atributos2Dvalores_grid->LoadDefaultValues(); // Load default values
				$trama_atributos2Dvalores_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$trama_atributos2Dvalores_grid->LoadRowValues($trama_atributos2Dvalores_grid->Recordset); // Load row values
		}
		$trama_atributos2Dvalores->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($trama_atributos2Dvalores->CurrentAction == "gridadd") // Grid add
			$trama_atributos2Dvalores->RowType = EW_ROWTYPE_ADD; // Render add
		if ($trama_atributos2Dvalores->CurrentAction == "gridadd" && $trama_atributos2Dvalores->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$trama_atributos2Dvalores_grid->RestoreCurrentRowFormValues($trama_atributos2Dvalores_grid->RowIndex); // Restore form values
		if ($trama_atributos2Dvalores->CurrentAction == "gridedit") { // Grid edit
			if ($trama_atributos2Dvalores->EventCancelled) {
				$trama_atributos2Dvalores_grid->RestoreCurrentRowFormValues($trama_atributos2Dvalores_grid->RowIndex); // Restore form values
			}
			if ($trama_atributos2Dvalores_grid->RowAction == "insert")
				$trama_atributos2Dvalores->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$trama_atributos2Dvalores->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($trama_atributos2Dvalores->CurrentAction == "gridedit" && ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT || $trama_atributos2Dvalores->RowType == EW_ROWTYPE_ADD) && $trama_atributos2Dvalores->EventCancelled) // Update failed
			$trama_atributos2Dvalores_grid->RestoreCurrentRowFormValues($trama_atributos2Dvalores_grid->RowIndex); // Restore form values
		if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT) // Edit row
			$trama_atributos2Dvalores_grid->EditRowCnt++;
		if ($trama_atributos2Dvalores->CurrentAction == "F") // Confirm row
			$trama_atributos2Dvalores_grid->RestoreCurrentRowFormValues($trama_atributos2Dvalores_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$trama_atributos2Dvalores->RowAttrs = array_merge($trama_atributos2Dvalores->RowAttrs, array('data-rowindex'=>$trama_atributos2Dvalores_grid->RowCnt, 'id'=>'r' . $trama_atributos2Dvalores_grid->RowCnt . '_trama_atributos2Dvalores', 'data-rowtype'=>$trama_atributos2Dvalores->RowType));

		// Render row
		$trama_atributos2Dvalores_grid->RenderRow();

		// Render list options
		$trama_atributos2Dvalores_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($trama_atributos2Dvalores_grid->RowAction <> "delete" && $trama_atributos2Dvalores_grid->RowAction <> "insertdelete" && !($trama_atributos2Dvalores_grid->RowAction == "insert" && $trama_atributos2Dvalores->CurrentAction == "F" && $trama_atributos2Dvalores_grid->EmptyRow())) {
?>
	<tr<?php echo $trama_atributos2Dvalores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_atributos2Dvalores_grid->ListOptions->Render("body", "left", $trama_atributos2Dvalores_grid->RowCnt);
?>
	<?php if ($trama_atributos2Dvalores->id->Visible) { // id ?>
		<td data-name="id"<?php echo $trama_atributos2Dvalores->id->CellAttributes() ?>>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->OldValue) ?>">
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_id" class="form-group trama_atributos2Dvalores_id">
<span<?php echo $trama_atributos2Dvalores->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->CurrentValue) ?>">
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_id" class="trama_atributos2Dvalores_id">
<span<?php echo $trama_atributos2Dvalores->id->ViewAttributes() ?>>
<?php echo $trama_atributos2Dvalores->id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->FormValue) ?>">
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trama_atributos2Dvalores_grid->PageObjName . "_row_" . $trama_atributos2Dvalores_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->idAtributo->Visible) { // idAtributo ?>
		<td data-name="idAtributo"<?php echo $trama_atributos2Dvalores->idAtributo->CellAttributes() ?>>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($trama_atributos2Dvalores->idAtributo->getSessionValue() <> "") { ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<span<?php echo $trama_atributos2Dvalores->idAtributo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->idAtributo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<select data-table="trama_atributos2Dvalores" data-field="x_idAtributo" data-value-separator="<?php echo $trama_atributos2Dvalores->idAtributo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"<?php echo $trama_atributos2Dvalores->idAtributo->EditAttributes() ?>>
<?php echo $trama_atributos2Dvalores->idAtributo->SelectOptionListHtml("x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_atributos2Dvalores->idAtributo->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_atributos2Dvalores->idAtributo->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo $trama_atributos2Dvalores->idAtributo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_idAtributo" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->OldValue) ?>">
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($trama_atributos2Dvalores->idAtributo->getSessionValue() <> "") { ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<span<?php echo $trama_atributos2Dvalores->idAtributo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->idAtributo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<select data-table="trama_atributos2Dvalores" data-field="x_idAtributo" data-value-separator="<?php echo $trama_atributos2Dvalores->idAtributo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"<?php echo $trama_atributos2Dvalores->idAtributo->EditAttributes() ?>>
<?php echo $trama_atributos2Dvalores->idAtributo->SelectOptionListHtml("x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_atributos2Dvalores->idAtributo->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_atributos2Dvalores->idAtributo->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo $trama_atributos2Dvalores->idAtributo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_idAtributo" class="trama_atributos2Dvalores_idAtributo">
<span<?php echo $trama_atributos2Dvalores->idAtributo->ViewAttributes() ?>>
<?php echo $trama_atributos2Dvalores->idAtributo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->FormValue) ?>">
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_idAtributo" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->valor->Visible) { // valor ?>
		<td data-name="valor"<?php echo $trama_atributos2Dvalores->valor->CellAttributes() ?>>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_valor" class="form-group trama_atributos2Dvalores_valor">
<input type="text" data-table="trama_atributos2Dvalores" data-field="x_valor" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->getPlaceHolder()) ?>" value="<?php echo $trama_atributos2Dvalores->valor->EditValue ?>"<?php echo $trama_atributos2Dvalores->valor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_valor" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->OldValue) ?>">
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_valor" class="form-group trama_atributos2Dvalores_valor">
<input type="text" data-table="trama_atributos2Dvalores" data-field="x_valor" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->getPlaceHolder()) ?>" value="<?php echo $trama_atributos2Dvalores->valor->EditValue ?>"<?php echo $trama_atributos2Dvalores->valor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_valor" class="trama_atributos2Dvalores_valor">
<span<?php echo $trama_atributos2Dvalores->valor->ViewAttributes() ?>>
<?php echo $trama_atributos2Dvalores->valor->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_valor" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->FormValue) ?>">
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_valor" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->imagen->Visible) { // imagen ?>
		<td data-name="imagen"<?php echo $trama_atributos2Dvalores->imagen->CellAttributes() ?>>
<?php if ($trama_atributos2Dvalores_grid->RowAction == "insert") { // Add record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_imagen" class="form-group trama_atributos2Dvalores_imagen">
<div id="fd_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen">
<span title="<?php echo $trama_atributos2Dvalores->imagen->FldTitle() ? $trama_atributos2Dvalores->imagen->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($trama_atributos2Dvalores->imagen->ReadOnly || $trama_atributos2Dvalores->imagen->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="trama_atributos2Dvalores" data-field="x_imagen" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen"<?php echo $trama_atributos2Dvalores->imagen->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="0">
<input type="hidden" name="fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="255">
<input type="hidden" name="fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_imagen" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->imagen->OldValue) ?>">
<?php } elseif ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_imagen" class="trama_atributos2Dvalores_imagen">
<span<?php echo $trama_atributos2Dvalores->imagen->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($trama_atributos2Dvalores->imagen, $trama_atributos2Dvalores->imagen->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $trama_atributos2Dvalores_grid->RowCnt ?>_trama_atributos2Dvalores_imagen" class="form-group trama_atributos2Dvalores_imagen">
<div id="fd_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen">
<span title="<?php echo $trama_atributos2Dvalores->imagen->FldTitle() ? $trama_atributos2Dvalores->imagen->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($trama_atributos2Dvalores->imagen->ReadOnly || $trama_atributos2Dvalores->imagen->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="trama_atributos2Dvalores" data-field="x_imagen" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen"<?php echo $trama_atributos2Dvalores->imagen->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="255">
<input type="hidden" name="fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_atributos2Dvalores_grid->ListOptions->Render("body", "right", $trama_atributos2Dvalores_grid->RowCnt);
?>
	</tr>
<?php if ($trama_atributos2Dvalores->RowType == EW_ROWTYPE_ADD || $trama_atributos2Dvalores->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftrama_atributos2Dvaloresgrid.UpdateOpts(<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($trama_atributos2Dvalores->CurrentAction <> "gridadd" || $trama_atributos2Dvalores->CurrentMode == "copy")
		if (!$trama_atributos2Dvalores_grid->Recordset->EOF) $trama_atributos2Dvalores_grid->Recordset->MoveNext();
}
?>
<?php
	if ($trama_atributos2Dvalores->CurrentMode == "add" || $trama_atributos2Dvalores->CurrentMode == "copy" || $trama_atributos2Dvalores->CurrentMode == "edit") {
		$trama_atributos2Dvalores_grid->RowIndex = '$rowindex$';
		$trama_atributos2Dvalores_grid->LoadDefaultValues();

		// Set row properties
		$trama_atributos2Dvalores->ResetAttrs();
		$trama_atributos2Dvalores->RowAttrs = array_merge($trama_atributos2Dvalores->RowAttrs, array('data-rowindex'=>$trama_atributos2Dvalores_grid->RowIndex, 'id'=>'r0_trama_atributos2Dvalores', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($trama_atributos2Dvalores->RowAttrs["class"], "ewTemplate");
		$trama_atributos2Dvalores->RowType = EW_ROWTYPE_ADD;

		// Render row
		$trama_atributos2Dvalores_grid->RenderRow();

		// Render list options
		$trama_atributos2Dvalores_grid->RenderListOptions();
		$trama_atributos2Dvalores_grid->StartRowCnt = 0;
?>
	<tr<?php echo $trama_atributos2Dvalores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_atributos2Dvalores_grid->ListOptions->Render("body", "left", $trama_atributos2Dvalores_grid->RowIndex);
?>
	<?php if ($trama_atributos2Dvalores->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($trama_atributos2Dvalores->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_id" class="form-group trama_atributos2Dvalores_id">
<span<?php echo $trama_atributos2Dvalores->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_id" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->idAtributo->Visible) { // idAtributo ?>
		<td data-name="idAtributo">
<?php if ($trama_atributos2Dvalores->CurrentAction <> "F") { ?>
<?php if ($trama_atributos2Dvalores->idAtributo->getSessionValue() <> "") { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<span<?php echo $trama_atributos2Dvalores->idAtributo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->idAtributo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<select data-table="trama_atributos2Dvalores" data-field="x_idAtributo" data-value-separator="<?php echo $trama_atributos2Dvalores->idAtributo->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"<?php echo $trama_atributos2Dvalores->idAtributo->EditAttributes() ?>>
<?php echo $trama_atributos2Dvalores->idAtributo->SelectOptionListHtml("x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo") ?>
</select>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $trama_atributos2Dvalores->idAtributo->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo',url:'trama_atributosaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $trama_atributos2Dvalores->idAtributo->FldCaption() ?></span></button>
<input type="hidden" name="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="s_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo $trama_atributos2Dvalores->idAtributo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_idAtributo" class="form-group trama_atributos2Dvalores_idAtributo">
<span<?php echo $trama_atributos2Dvalores->idAtributo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->idAtributo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_idAtributo" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_idAtributo" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_idAtributo" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->idAtributo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->valor->Visible) { // valor ?>
		<td data-name="valor">
<?php if ($trama_atributos2Dvalores->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_valor" class="form-group trama_atributos2Dvalores_valor">
<input type="text" data-table="trama_atributos2Dvalores" data-field="x_valor" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->getPlaceHolder()) ?>" value="<?php echo $trama_atributos2Dvalores->valor->EditValue ?>"<?php echo $trama_atributos2Dvalores->valor->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trama_atributos2Dvalores_valor" class="form-group trama_atributos2Dvalores_valor">
<span<?php echo $trama_atributos2Dvalores->valor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_atributos2Dvalores->valor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_valor" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_valor" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->valor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trama_atributos2Dvalores->imagen->Visible) { // imagen ?>
		<td data-name="imagen">
<span id="el$rowindex$_trama_atributos2Dvalores_imagen" class="form-group trama_atributos2Dvalores_imagen">
<div id="fd_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen">
<span title="<?php echo $trama_atributos2Dvalores->imagen->FldTitle() ? $trama_atributos2Dvalores->imagen->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($trama_atributos2Dvalores->imagen->ReadOnly || $trama_atributos2Dvalores->imagen->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="trama_atributos2Dvalores" data-field="x_imagen" name="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id="x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen"<?php echo $trama_atributos2Dvalores->imagen->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fn_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fa_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="0">
<input type="hidden" name="fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fs_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="255">
<input type="hidden" name="fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fx_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id= "fm_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo $trama_atributos2Dvalores->imagen->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="trama_atributos2Dvalores" data-field="x_imagen" name="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" id="o<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>_imagen" value="<?php echo ew_HtmlEncode($trama_atributos2Dvalores->imagen->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_atributos2Dvalores_grid->ListOptions->Render("body", "right", $trama_atributos2Dvalores_grid->RowCnt);
?>
<script type="text/javascript">
ftrama_atributos2Dvaloresgrid.UpdateOpts(<?php echo $trama_atributos2Dvalores_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($trama_atributos2Dvalores->CurrentMode == "add" || $trama_atributos2Dvalores->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $trama_atributos2Dvalores_grid->FormKeyCountName ?>" id="<?php echo $trama_atributos2Dvalores_grid->FormKeyCountName ?>" value="<?php echo $trama_atributos2Dvalores_grid->KeyCount ?>">
<?php echo $trama_atributos2Dvalores_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_atributos2Dvalores->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $trama_atributos2Dvalores_grid->FormKeyCountName ?>" id="<?php echo $trama_atributos2Dvalores_grid->FormKeyCountName ?>" value="<?php echo $trama_atributos2Dvalores_grid->KeyCount ?>">
<?php echo $trama_atributos2Dvalores_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_atributos2Dvalores->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftrama_atributos2Dvaloresgrid">
</div>
<?php

// Close recordset
if ($trama_atributos2Dvalores_grid->Recordset)
	$trama_atributos2Dvalores_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($trama_atributos2Dvalores_grid->TotalRecs == 0 && $trama_atributos2Dvalores->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($trama_atributos2Dvalores_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($trama_atributos2Dvalores->Export == "") { ?>
<script type="text/javascript">
ftrama_atributos2Dvaloresgrid.Init();
</script>
<?php } ?>
<?php
$trama_atributos2Dvalores_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$trama_atributos2Dvalores_grid->Page_Terminate();
?>
