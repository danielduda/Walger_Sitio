<?php include_once "usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($remitodetalle_grid)) $remitodetalle_grid = new cremitodetalle_grid();

// Page init
$remitodetalle_grid->Page_Init();

// Page main
$remitodetalle_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$remitodetalle_grid->Page_Render();
?>
<?php if ($remitodetalle->Export == "") { ?>
<script type="text/javascript">

// Page object
var remitodetalle_grid = new ew_Page("remitodetalle_grid");
remitodetalle_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = remitodetalle_grid.PageID; // For backward compatibility

// Form object
var fremitodetallegrid = new ew_Form("fremitodetallegrid");
fremitodetallegrid.FormKeyCountName = '<?php echo $remitodetalle_grid->FormKeyCountName ?>';

// Validate form
fremitodetallegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_remitoCabecera");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->remitoCabecera->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_remitoCabecera");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($remitodetalle->remitoCabecera->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->cantidad->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_descripcion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->descripcion->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_CodigoCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->CodigoCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_RazonSocialCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->RazonSocialCli->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_Direccion");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->Direccion->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_LocalidadCli");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($remitodetalle->LocalidadCli->FldCaption()) ?>");

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
fremitodetallegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "remitoCabecera", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "descripcion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "CodigoCli", false)) return false;
	if (ew_ValueChanged(fobj, infix, "RazonSocialCli", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Direccion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "LocalidadCli", false)) return false;
	return true;
}

// Form_CustomValidate event
fremitodetallegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fremitodetallegrid.ValidateRequired = true;
<?php } else { ?>
fremitodetallegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fremitodetallegrid.Lists["x_descripcion"] = {"LinkField":"x_Id_Productos","Ajax":null,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($remitodetalle->getCurrentMasterTable() == "" && $remitodetalle_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $remitodetalle_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($remitodetalle->CurrentAction == "gridadd") {
	if ($remitodetalle->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$remitodetalle_grid->TotalRecs = $remitodetalle->SelectRecordCount();
			$remitodetalle_grid->Recordset = $remitodetalle_grid->LoadRecordset($remitodetalle_grid->StartRec-1, $remitodetalle_grid->DisplayRecs);
		} else {
			if ($remitodetalle_grid->Recordset = $remitodetalle_grid->LoadRecordset())
				$remitodetalle_grid->TotalRecs = $remitodetalle_grid->Recordset->RecordCount();
		}
		$remitodetalle_grid->StartRec = 1;
		$remitodetalle_grid->DisplayRecs = $remitodetalle_grid->TotalRecs;
	} else {
		$remitodetalle->CurrentFilter = "0=1";
		$remitodetalle_grid->StartRec = 1;
		$remitodetalle_grid->DisplayRecs = $remitodetalle->GridAddRowCount;
	}
	$remitodetalle_grid->TotalRecs = $remitodetalle_grid->DisplayRecs;
	$remitodetalle_grid->StopRec = $remitodetalle_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$remitodetalle_grid->TotalRecs = $remitodetalle->SelectRecordCount();
	} else {
		if ($remitodetalle_grid->Recordset = $remitodetalle_grid->LoadRecordset())
			$remitodetalle_grid->TotalRecs = $remitodetalle_grid->Recordset->RecordCount();
	}
	$remitodetalle_grid->StartRec = 1;
	$remitodetalle_grid->DisplayRecs = $remitodetalle_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$remitodetalle_grid->Recordset = $remitodetalle_grid->LoadRecordset($remitodetalle_grid->StartRec-1, $remitodetalle_grid->DisplayRecs);
}
$remitodetalle_grid->RenderOtherOptions();
?>
<?php $remitodetalle_grid->ShowPageHeader(); ?>
<?php
$remitodetalle_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fremitodetallegrid" class="ewForm form-horizontal">
<?php if ($remitodetalle_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel ewListOtherOptions">
<?php
	foreach ($remitodetalle_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<div id="gmp_remitodetalle" class="ewGridMiddlePanel">
<table id="tbl_remitodetallegrid" class="ewTable ewTableSeparate">
<?php echo $remitodetalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$remitodetalle_grid->RenderListOptions();

// Render list options (header, left)
$remitodetalle_grid->ListOptions->Render("header", "left");
?>
<?php if ($remitodetalle->remitoCabecera->Visible) { // remitoCabecera ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->remitoCabecera) == "") { ?>
		<td><div id="elh_remitodetalle_remitoCabecera" class="remitodetalle_remitoCabecera"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->remitoCabecera->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_remitoCabecera" class="remitodetalle_remitoCabecera">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->remitoCabecera->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->remitoCabecera->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->remitoCabecera->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->cantidad->Visible) { // cantidad ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->cantidad) == "") { ?>
		<td><div id="elh_remitodetalle_cantidad" class="remitodetalle_cantidad"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->cantidad->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_cantidad" class="remitodetalle_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->descripcion->Visible) { // descripcion ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->descripcion) == "") { ?>
		<td><div id="elh_remitodetalle_descripcion" class="remitodetalle_descripcion"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->descripcion->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_descripcion" class="remitodetalle_descripcion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->descripcion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->descripcion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->descripcion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->CodigoCli->Visible) { // CodigoCli ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->CodigoCli) == "") { ?>
		<td><div id="elh_remitodetalle_CodigoCli" class="remitodetalle_CodigoCli"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->CodigoCli->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_CodigoCli" class="remitodetalle_CodigoCli">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->CodigoCli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->CodigoCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->CodigoCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->RazonSocialCli->Visible) { // RazonSocialCli ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->RazonSocialCli) == "") { ?>
		<td><div id="elh_remitodetalle_RazonSocialCli" class="remitodetalle_RazonSocialCli"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->RazonSocialCli->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_RazonSocialCli" class="remitodetalle_RazonSocialCli">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->RazonSocialCli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->RazonSocialCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->RazonSocialCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->Direccion->Visible) { // Direccion ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->Direccion) == "") { ?>
		<td><div id="elh_remitodetalle_Direccion" class="remitodetalle_Direccion"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->Direccion->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_Direccion" class="remitodetalle_Direccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->Direccion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->Direccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->Direccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($remitodetalle->LocalidadCli->Visible) { // LocalidadCli ?>
	<?php if ($remitodetalle->SortUrl($remitodetalle->LocalidadCli) == "") { ?>
		<td><div id="elh_remitodetalle_LocalidadCli" class="remitodetalle_LocalidadCli"><div class="ewTableHeaderCaption"><?php echo $remitodetalle->LocalidadCli->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_remitodetalle_LocalidadCli" class="remitodetalle_LocalidadCli">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $remitodetalle->LocalidadCli->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($remitodetalle->LocalidadCli->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($remitodetalle->LocalidadCli->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$remitodetalle_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$remitodetalle_grid->StartRec = 1;
$remitodetalle_grid->StopRec = $remitodetalle_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($remitodetalle_grid->FormKeyCountName) && ($remitodetalle->CurrentAction == "gridadd" || $remitodetalle->CurrentAction == "gridedit" || $remitodetalle->CurrentAction == "F")) {
		$remitodetalle_grid->KeyCount = $objForm->GetValue($remitodetalle_grid->FormKeyCountName);
		$remitodetalle_grid->StopRec = $remitodetalle_grid->StartRec + $remitodetalle_grid->KeyCount - 1;
	}
}
$remitodetalle_grid->RecCnt = $remitodetalle_grid->StartRec - 1;
if ($remitodetalle_grid->Recordset && !$remitodetalle_grid->Recordset->EOF) {
	$remitodetalle_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $remitodetalle_grid->StartRec > 1)
		$remitodetalle_grid->Recordset->Move($remitodetalle_grid->StartRec - 1);
} elseif (!$remitodetalle->AllowAddDeleteRow && $remitodetalle_grid->StopRec == 0) {
	$remitodetalle_grid->StopRec = $remitodetalle->GridAddRowCount;
}

// Initialize aggregate
$remitodetalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$remitodetalle->ResetAttrs();
$remitodetalle_grid->RenderRow();
if ($remitodetalle->CurrentAction == "gridadd")
	$remitodetalle_grid->RowIndex = 0;
if ($remitodetalle->CurrentAction == "gridedit")
	$remitodetalle_grid->RowIndex = 0;
while ($remitodetalle_grid->RecCnt < $remitodetalle_grid->StopRec) {
	$remitodetalle_grid->RecCnt++;
	if (intval($remitodetalle_grid->RecCnt) >= intval($remitodetalle_grid->StartRec)) {
		$remitodetalle_grid->RowCnt++;
		if ($remitodetalle->CurrentAction == "gridadd" || $remitodetalle->CurrentAction == "gridedit" || $remitodetalle->CurrentAction == "F") {
			$remitodetalle_grid->RowIndex++;
			$objForm->Index = $remitodetalle_grid->RowIndex;
			if ($objForm->HasValue($remitodetalle_grid->FormActionName))
				$remitodetalle_grid->RowAction = strval($objForm->GetValue($remitodetalle_grid->FormActionName));
			elseif ($remitodetalle->CurrentAction == "gridadd")
				$remitodetalle_grid->RowAction = "insert";
			else
				$remitodetalle_grid->RowAction = "";
		}

		// Set up key count
		$remitodetalle_grid->KeyCount = $remitodetalle_grid->RowIndex;

		// Init row class and style
		$remitodetalle->ResetAttrs();
		$remitodetalle->CssClass = "";
		if ($remitodetalle->CurrentAction == "gridadd") {
			if ($remitodetalle->CurrentMode == "copy") {
				$remitodetalle_grid->LoadRowValues($remitodetalle_grid->Recordset); // Load row values
				$remitodetalle_grid->SetRecordKey($remitodetalle_grid->RowOldKey, $remitodetalle_grid->Recordset); // Set old record key
			} else {
				$remitodetalle_grid->LoadDefaultValues(); // Load default values
				$remitodetalle_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$remitodetalle_grid->LoadRowValues($remitodetalle_grid->Recordset); // Load row values
		}
		$remitodetalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($remitodetalle->CurrentAction == "gridadd") // Grid add
			$remitodetalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($remitodetalle->CurrentAction == "gridadd" && $remitodetalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$remitodetalle_grid->RestoreCurrentRowFormValues($remitodetalle_grid->RowIndex); // Restore form values
		if ($remitodetalle->CurrentAction == "gridedit") { // Grid edit
			if ($remitodetalle->EventCancelled) {
				$remitodetalle_grid->RestoreCurrentRowFormValues($remitodetalle_grid->RowIndex); // Restore form values
			}
			if ($remitodetalle_grid->RowAction == "insert")
				$remitodetalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$remitodetalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($remitodetalle->CurrentAction == "gridedit" && ($remitodetalle->RowType == EW_ROWTYPE_EDIT || $remitodetalle->RowType == EW_ROWTYPE_ADD) && $remitodetalle->EventCancelled) // Update failed
			$remitodetalle_grid->RestoreCurrentRowFormValues($remitodetalle_grid->RowIndex); // Restore form values
		if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$remitodetalle_grid->EditRowCnt++;
		if ($remitodetalle->CurrentAction == "F") // Confirm row
			$remitodetalle_grid->RestoreCurrentRowFormValues($remitodetalle_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$remitodetalle->RowAttrs = array_merge($remitodetalle->RowAttrs, array('data-rowindex'=>$remitodetalle_grid->RowCnt, 'id'=>'r' . $remitodetalle_grid->RowCnt . '_remitodetalle', 'data-rowtype'=>$remitodetalle->RowType));

		// Render row
		$remitodetalle_grid->RenderRow();

		// Render list options
		$remitodetalle_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($remitodetalle_grid->RowAction <> "delete" && $remitodetalle_grid->RowAction <> "insertdelete" && !($remitodetalle_grid->RowAction == "insert" && $remitodetalle->CurrentAction == "F" && $remitodetalle_grid->EmptyRow())) {
?>
	<tr<?php echo $remitodetalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$remitodetalle_grid->ListOptions->Render("body", "left", $remitodetalle_grid->RowCnt);
?>
	<?php if ($remitodetalle->remitoCabecera->Visible) { // remitoCabecera ?>
		<td<?php echo $remitodetalle->remitoCabecera->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($remitodetalle->remitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $remitodetalle->remitoCabecera->ViewAttributes() ?>>
<?php echo $remitodetalle->remitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" size="30" placeholder="<?php echo $remitodetalle->remitoCabecera->PlaceHolder ?>" value="<?php echo $remitodetalle->remitoCabecera->EditValue ?>"<?php echo $remitodetalle->remitoCabecera->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_remitoCabecera" name="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($remitodetalle->remitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $remitodetalle->remitoCabecera->ViewAttributes() ?>>
<?php echo $remitodetalle->remitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" size="30" placeholder="<?php echo $remitodetalle->remitoCabecera->PlaceHolder ?>" value="<?php echo $remitodetalle->remitoCabecera->EditValue ?>"<?php echo $remitodetalle->remitoCabecera->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->remitoCabecera->ViewAttributes() ?>>
<?php echo $remitodetalle->remitoCabecera->ListViewValue() ?></span>
<input type="hidden" data-field="x_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->FormValue) ?>">
<input type="hidden" data-field="x_remitoCabecera" name="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_Id_RemitoDetalle" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitodetalle->Id_RemitoDetalle->CurrentValue) ?>">
<input type="hidden" data-field="x_Id_RemitoDetalle" name="o<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" id="o<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitodetalle->Id_RemitoDetalle->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT || $remitodetalle->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_Id_RemitoDetalle" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Id_RemitoDetalle" value="<?php echo ew_HtmlEncode($remitodetalle->Id_RemitoDetalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($remitodetalle->cantidad->Visible) { // cantidad ?>
		<td<?php echo $remitodetalle->cantidad->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_cantidad" class="control-group remitodetalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitodetalle->cantidad->PlaceHolder ?>" value="<?php echo $remitodetalle->cantidad->EditValue ?>"<?php echo $remitodetalle->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitodetalle->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_cantidad" class="control-group remitodetalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitodetalle->cantidad->PlaceHolder ?>" value="<?php echo $remitodetalle->cantidad->EditValue ?>"<?php echo $remitodetalle->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->cantidad->ViewAttributes() ?>>
<?php echo $remitodetalle->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitodetalle->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitodetalle->cantidad->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitodetalle->descripcion->Visible) { // descripcion ?>
		<td<?php echo $remitodetalle->descripcion->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_descripcion" class="control-group remitodetalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion"<?php echo $remitodetalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitodetalle->descripcion->EditValue)) {
	$arwrk = $remitodetalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitodetalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitodetalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitodetallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitodetalle->descripcion->EditValue)) ? ew_ArrayToJson($remitodetalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitodetalle->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_descripcion" class="control-group remitodetalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion"<?php echo $remitodetalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitodetalle->descripcion->EditValue)) {
	$arwrk = $remitodetalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitodetalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitodetalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitodetallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitodetalle->descripcion->EditValue)) ? ew_ArrayToJson($remitodetalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->descripcion->ViewAttributes() ?>>
<?php echo $remitodetalle->descripcion->ListViewValue() ?></span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitodetalle->descripcion->FormValue) ?>">
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitodetalle->descripcion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitodetalle->CodigoCli->Visible) { // CodigoCli ?>
		<td<?php echo $remitodetalle->CodigoCli->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_CodigoCli" class="control-group remitodetalle_CodigoCli">
<input type="text" data-field="x_CodigoCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" size="30" maxlength="10" placeholder="<?php echo $remitodetalle->CodigoCli->PlaceHolder ?>" value="<?php echo $remitodetalle->CodigoCli->EditValue ?>"<?php echo $remitodetalle->CodigoCli->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_CodigoCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_CodigoCli" class="control-group remitodetalle_CodigoCli">
<span<?php echo $remitodetalle->CodigoCli->ViewAttributes() ?>>
<?php echo $remitodetalle->CodigoCli->EditValue ?></span>
</span>
<input type="hidden" data-field="x_CodigoCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->CurrentValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->CodigoCli->ViewAttributes() ?>>
<?php echo $remitodetalle->CodigoCli->ListViewValue() ?></span>
<input type="hidden" data-field="x_CodigoCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->FormValue) ?>">
<input type="hidden" data-field="x_CodigoCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitodetalle->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<td<?php echo $remitodetalle->RazonSocialCli->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_RazonSocialCli" class="control-group remitodetalle_RazonSocialCli">
<input type="text" data-field="x_RazonSocialCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" size="30" maxlength="60" placeholder="<?php echo $remitodetalle->RazonSocialCli->PlaceHolder ?>" value="<?php echo $remitodetalle->RazonSocialCli->EditValue ?>"<?php echo $remitodetalle->RazonSocialCli->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_RazonSocialCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" value="<?php echo ew_HtmlEncode($remitodetalle->RazonSocialCli->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_RazonSocialCli" class="control-group remitodetalle_RazonSocialCli">
<input type="text" data-field="x_RazonSocialCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" size="30" maxlength="60" placeholder="<?php echo $remitodetalle->RazonSocialCli->PlaceHolder ?>" value="<?php echo $remitodetalle->RazonSocialCli->EditValue ?>"<?php echo $remitodetalle->RazonSocialCli->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->RazonSocialCli->ViewAttributes() ?>>
<?php echo $remitodetalle->RazonSocialCli->ListViewValue() ?></span>
<input type="hidden" data-field="x_RazonSocialCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" value="<?php echo ew_HtmlEncode($remitodetalle->RazonSocialCli->FormValue) ?>">
<input type="hidden" data-field="x_RazonSocialCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" value="<?php echo ew_HtmlEncode($remitodetalle->RazonSocialCli->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitodetalle->Direccion->Visible) { // Direccion ?>
		<td<?php echo $remitodetalle->Direccion->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_Direccion" class="control-group remitodetalle_Direccion">
<input type="text" data-field="x_Direccion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" size="30" maxlength="90" placeholder="<?php echo $remitodetalle->Direccion->PlaceHolder ?>" value="<?php echo $remitodetalle->Direccion->EditValue ?>"<?php echo $remitodetalle->Direccion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_Direccion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" value="<?php echo ew_HtmlEncode($remitodetalle->Direccion->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_Direccion" class="control-group remitodetalle_Direccion">
<input type="text" data-field="x_Direccion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" size="30" maxlength="90" placeholder="<?php echo $remitodetalle->Direccion->PlaceHolder ?>" value="<?php echo $remitodetalle->Direccion->EditValue ?>"<?php echo $remitodetalle->Direccion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->Direccion->ViewAttributes() ?>>
<?php echo $remitodetalle->Direccion->ListViewValue() ?></span>
<input type="hidden" data-field="x_Direccion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" value="<?php echo ew_HtmlEncode($remitodetalle->Direccion->FormValue) ?>">
<input type="hidden" data-field="x_Direccion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" value="<?php echo ew_HtmlEncode($remitodetalle->Direccion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($remitodetalle->LocalidadCli->Visible) { // LocalidadCli ?>
		<td<?php echo $remitodetalle->LocalidadCli->CellAttributes() ?>>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_LocalidadCli" class="control-group remitodetalle_LocalidadCli">
<input type="text" data-field="x_LocalidadCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" size="30" maxlength="40" placeholder="<?php echo $remitodetalle->LocalidadCli->PlaceHolder ?>" value="<?php echo $remitodetalle->LocalidadCli->EditValue ?>"<?php echo $remitodetalle->LocalidadCli->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_LocalidadCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" value="<?php echo ew_HtmlEncode($remitodetalle->LocalidadCli->OldValue) ?>">
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $remitodetalle_grid->RowCnt ?>_remitodetalle_LocalidadCli" class="control-group remitodetalle_LocalidadCli">
<input type="text" data-field="x_LocalidadCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" size="30" maxlength="40" placeholder="<?php echo $remitodetalle->LocalidadCli->PlaceHolder ?>" value="<?php echo $remitodetalle->LocalidadCli->EditValue ?>"<?php echo $remitodetalle->LocalidadCli->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $remitodetalle->LocalidadCli->ViewAttributes() ?>>
<?php echo $remitodetalle->LocalidadCli->ListViewValue() ?></span>
<input type="hidden" data-field="x_LocalidadCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" value="<?php echo ew_HtmlEncode($remitodetalle->LocalidadCli->FormValue) ?>">
<input type="hidden" data-field="x_LocalidadCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" value="<?php echo ew_HtmlEncode($remitodetalle->LocalidadCli->OldValue) ?>">
<?php } ?>
<a id="<?php echo $remitodetalle_grid->PageObjName . "_row_" . $remitodetalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$remitodetalle_grid->ListOptions->Render("body", "right", $remitodetalle_grid->RowCnt);
?>
	</tr>
<?php if ($remitodetalle->RowType == EW_ROWTYPE_ADD || $remitodetalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fremitodetallegrid.UpdateOpts(<?php echo $remitodetalle_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($remitodetalle->CurrentAction <> "gridadd" || $remitodetalle->CurrentMode == "copy")
		if (!$remitodetalle_grid->Recordset->EOF) $remitodetalle_grid->Recordset->MoveNext();
}
?>
<?php
	if ($remitodetalle->CurrentMode == "add" || $remitodetalle->CurrentMode == "copy" || $remitodetalle->CurrentMode == "edit") {
		$remitodetalle_grid->RowIndex = '$rowindex$';
		$remitodetalle_grid->LoadDefaultValues();

		// Set row properties
		$remitodetalle->ResetAttrs();
		$remitodetalle->RowAttrs = array_merge($remitodetalle->RowAttrs, array('data-rowindex'=>$remitodetalle_grid->RowIndex, 'id'=>'r0_remitodetalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($remitodetalle->RowAttrs["class"], "ewTemplate");
		$remitodetalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$remitodetalle_grid->RenderRow();

		// Render list options
		$remitodetalle_grid->RenderListOptions();
		$remitodetalle_grid->StartRowCnt = 0;
?>
	<tr<?php echo $remitodetalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$remitodetalle_grid->ListOptions->Render("body", "left", $remitodetalle_grid->RowIndex);
?>
	<?php if ($remitodetalle->remitoCabecera->Visible) { // remitoCabecera ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<?php if ($remitodetalle->remitoCabecera->getSessionValue() <> "") { ?>
<span<?php echo $remitodetalle->remitoCabecera->ViewAttributes() ?>>
<?php echo $remitodetalle->remitoCabecera->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" size="30" placeholder="<?php echo $remitodetalle->remitoCabecera->PlaceHolder ?>" value="<?php echo $remitodetalle->remitoCabecera->EditValue ?>"<?php echo $remitodetalle->remitoCabecera->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $remitodetalle->remitoCabecera->ViewAttributes() ?>>
<?php echo $remitodetalle->remitoCabecera->ViewValue ?></span>
<input type="hidden" data-field="x_remitoCabecera" name="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="x<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_remitoCabecera" name="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" id="o<?php echo $remitodetalle_grid->RowIndex ?>_remitoCabecera" value="<?php echo ew_HtmlEncode($remitodetalle->remitoCabecera->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_cantidad" class="control-group remitodetalle_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" size="30" maxlength="5" placeholder="<?php echo $remitodetalle->cantidad->PlaceHolder ?>" value="<?php echo $remitodetalle->cantidad->EditValue ?>"<?php echo $remitodetalle->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_cantidad" class="control-group remitodetalle_cantidad">
<span<?php echo $remitodetalle->cantidad->ViewAttributes() ?>>
<?php echo $remitodetalle->cantidad->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="x<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitodetalle->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" id="o<?php echo $remitodetalle_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($remitodetalle->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->descripcion->Visible) { // descripcion ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_descripcion" class="control-group remitodetalle_descripcion">
<select data-field="x_descripcion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion"<?php echo $remitodetalle->descripcion->EditAttributes() ?>>
<?php
if (is_array($remitodetalle->descripcion->EditValue)) {
	$arwrk = $remitodetalle->descripcion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($remitodetalle->descripcion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $remitodetalle->descripcion->OldValue = "";
?>
</select>
<script type="text/javascript">
fremitodetallegrid.Lists["x_descripcion"].Options = <?php echo (is_array($remitodetalle->descripcion->EditValue)) ? ew_ArrayToJson($remitodetalle->descripcion->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_descripcion" class="control-group remitodetalle_descripcion">
<span<?php echo $remitodetalle->descripcion->ViewAttributes() ?>>
<?php echo $remitodetalle->descripcion->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitodetalle->descripcion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($remitodetalle->descripcion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->CodigoCli->Visible) { // CodigoCli ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_CodigoCli" class="control-group remitodetalle_CodigoCli">
<input type="text" data-field="x_CodigoCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" size="30" maxlength="10" placeholder="<?php echo $remitodetalle->CodigoCli->PlaceHolder ?>" value="<?php echo $remitodetalle->CodigoCli->EditValue ?>"<?php echo $remitodetalle->CodigoCli->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_CodigoCli" class="control-group remitodetalle_CodigoCli">
<span<?php echo $remitodetalle->CodigoCli->ViewAttributes() ?>>
<?php echo $remitodetalle->CodigoCli->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_CodigoCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_CodigoCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_CodigoCli" value="<?php echo ew_HtmlEncode($remitodetalle->CodigoCli->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_RazonSocialCli" class="control-group remitodetalle_RazonSocialCli">
<input type="text" data-field="x_RazonSocialCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" size="30" maxlength="60" placeholder="<?php echo $remitodetalle->RazonSocialCli->PlaceHolder ?>" value="<?php echo $remitodetalle->RazonSocialCli->EditValue ?>"<?php echo $remitodetalle->RazonSocialCli->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_RazonSocialCli" class="control-group remitodetalle_RazonSocialCli">
<span<?php echo $remitodetalle->RazonSocialCli->ViewAttributes() ?>>
<?php echo $remitodetalle->RazonSocialCli->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_RazonSocialCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" value="<?php echo ew_HtmlEncode($remitodetalle->RazonSocialCli->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_RazonSocialCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_RazonSocialCli" value="<?php echo ew_HtmlEncode($remitodetalle->RazonSocialCli->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->Direccion->Visible) { // Direccion ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_Direccion" class="control-group remitodetalle_Direccion">
<input type="text" data-field="x_Direccion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" size="30" maxlength="90" placeholder="<?php echo $remitodetalle->Direccion->PlaceHolder ?>" value="<?php echo $remitodetalle->Direccion->EditValue ?>"<?php echo $remitodetalle->Direccion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_Direccion" class="control-group remitodetalle_Direccion">
<span<?php echo $remitodetalle->Direccion->ViewAttributes() ?>>
<?php echo $remitodetalle->Direccion->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_Direccion" name="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="x<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" value="<?php echo ew_HtmlEncode($remitodetalle->Direccion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_Direccion" name="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" id="o<?php echo $remitodetalle_grid->RowIndex ?>_Direccion" value="<?php echo ew_HtmlEncode($remitodetalle->Direccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($remitodetalle->LocalidadCli->Visible) { // LocalidadCli ?>
		<td>
<?php if ($remitodetalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_remitodetalle_LocalidadCli" class="control-group remitodetalle_LocalidadCli">
<input type="text" data-field="x_LocalidadCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" size="30" maxlength="40" placeholder="<?php echo $remitodetalle->LocalidadCli->PlaceHolder ?>" value="<?php echo $remitodetalle->LocalidadCli->EditValue ?>"<?php echo $remitodetalle->LocalidadCli->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_remitodetalle_LocalidadCli" class="control-group remitodetalle_LocalidadCli">
<span<?php echo $remitodetalle->LocalidadCli->ViewAttributes() ?>>
<?php echo $remitodetalle->LocalidadCli->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_LocalidadCli" name="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="x<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" value="<?php echo ew_HtmlEncode($remitodetalle->LocalidadCli->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_LocalidadCli" name="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" id="o<?php echo $remitodetalle_grid->RowIndex ?>_LocalidadCli" value="<?php echo ew_HtmlEncode($remitodetalle->LocalidadCli->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$remitodetalle_grid->ListOptions->Render("body", "right", $remitodetalle_grid->RowCnt);
?>
<script type="text/javascript">
fremitodetallegrid.UpdateOpts(<?php echo $remitodetalle_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($remitodetalle->CurrentMode == "add" || $remitodetalle->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $remitodetalle_grid->FormKeyCountName ?>" id="<?php echo $remitodetalle_grid->FormKeyCountName ?>" value="<?php echo $remitodetalle_grid->KeyCount ?>">
<?php echo $remitodetalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($remitodetalle->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $remitodetalle_grid->FormKeyCountName ?>" id="<?php echo $remitodetalle_grid->FormKeyCountName ?>" value="<?php echo $remitodetalle_grid->KeyCount ?>">
<?php echo $remitodetalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($remitodetalle->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fremitodetallegrid">
</div>
<?php

// Close recordset
if ($remitodetalle_grid->Recordset)
	$remitodetalle_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($remitodetalle->Export == "") { ?>
<script type="text/javascript">
fremitodetallegrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$remitodetalle_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$remitodetalle_grid->Page_Terminate();
?>
