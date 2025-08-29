<?php include_once "walger_usuariosinfo.php" ?>
<?php

// Create page object
if (!isset($trama_mensajes2Dclientes_grid)) $trama_mensajes2Dclientes_grid = new ctrama_mensajes2Dclientes_grid();

// Page init
$trama_mensajes2Dclientes_grid->Page_Init();

// Page main
$trama_mensajes2Dclientes_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trama_mensajes2Dclientes_grid->Page_Render();
?>
<?php if ($trama_mensajes2Dclientes->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftrama_mensajes2Dclientesgrid = new ew_Form("ftrama_mensajes2Dclientesgrid", "grid");
ftrama_mensajes2Dclientesgrid.FormKeyCountName = '<?php echo $trama_mensajes2Dclientes_grid->FormKeyCountName ?>';

// Validate form
ftrama_mensajes2Dclientesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($trama_mensajes2Dclientes->fecha->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftrama_mensajes2Dclientesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idCliente", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mensaje", false)) return false;
	return true;
}

// Form_CustomValidate event
ftrama_mensajes2Dclientesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrama_mensajes2Dclientesgrid.ValidateRequired = true;
<?php } else { ?>
ftrama_mensajes2Dclientesgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftrama_mensajes2Dclientesgrid.Lists["x_idCliente"] = {"LinkField":"x_CodigoCli","Ajax":true,"AutoFill":false,"DisplayFields":["x_RazonSocialCli","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"dbo_cliente"};

// Form object for search
</script>
<?php } ?>
<?php
if ($trama_mensajes2Dclientes->CurrentAction == "gridadd") {
	if ($trama_mensajes2Dclientes->CurrentMode == "copy") {
		$bSelectLimit = $trama_mensajes2Dclientes_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$trama_mensajes2Dclientes_grid->TotalRecs = $trama_mensajes2Dclientes->SelectRecordCount();
			$trama_mensajes2Dclientes_grid->Recordset = $trama_mensajes2Dclientes_grid->LoadRecordset($trama_mensajes2Dclientes_grid->StartRec-1, $trama_mensajes2Dclientes_grid->DisplayRecs);
		} else {
			if ($trama_mensajes2Dclientes_grid->Recordset = $trama_mensajes2Dclientes_grid->LoadRecordset())
				$trama_mensajes2Dclientes_grid->TotalRecs = $trama_mensajes2Dclientes_grid->Recordset->RecordCount();
		}
		$trama_mensajes2Dclientes_grid->StartRec = 1;
		$trama_mensajes2Dclientes_grid->DisplayRecs = $trama_mensajes2Dclientes_grid->TotalRecs;
	} else {
		$trama_mensajes2Dclientes->CurrentFilter = "0=1";
		$trama_mensajes2Dclientes_grid->StartRec = 1;
		$trama_mensajes2Dclientes_grid->DisplayRecs = $trama_mensajes2Dclientes->GridAddRowCount;
	}
	$trama_mensajes2Dclientes_grid->TotalRecs = $trama_mensajes2Dclientes_grid->DisplayRecs;
	$trama_mensajes2Dclientes_grid->StopRec = $trama_mensajes2Dclientes_grid->DisplayRecs;
} else {
	$bSelectLimit = $trama_mensajes2Dclientes_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($trama_mensajes2Dclientes_grid->TotalRecs <= 0)
			$trama_mensajes2Dclientes_grid->TotalRecs = $trama_mensajes2Dclientes->SelectRecordCount();
	} else {
		if (!$trama_mensajes2Dclientes_grid->Recordset && ($trama_mensajes2Dclientes_grid->Recordset = $trama_mensajes2Dclientes_grid->LoadRecordset()))
			$trama_mensajes2Dclientes_grid->TotalRecs = $trama_mensajes2Dclientes_grid->Recordset->RecordCount();
	}
	$trama_mensajes2Dclientes_grid->StartRec = 1;
	$trama_mensajes2Dclientes_grid->DisplayRecs = $trama_mensajes2Dclientes_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$trama_mensajes2Dclientes_grid->Recordset = $trama_mensajes2Dclientes_grid->LoadRecordset($trama_mensajes2Dclientes_grid->StartRec-1, $trama_mensajes2Dclientes_grid->DisplayRecs);

	// Set no record found message
	if ($trama_mensajes2Dclientes->CurrentAction == "" && $trama_mensajes2Dclientes_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$trama_mensajes2Dclientes_grid->setWarningMessage(ew_DeniedMsg());
		if ($trama_mensajes2Dclientes_grid->SearchWhere == "0=101")
			$trama_mensajes2Dclientes_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$trama_mensajes2Dclientes_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$trama_mensajes2Dclientes_grid->RenderOtherOptions();
?>
<?php $trama_mensajes2Dclientes_grid->ShowPageHeader(); ?>
<?php
$trama_mensajes2Dclientes_grid->ShowMessage();
?>
<?php if ($trama_mensajes2Dclientes_grid->TotalRecs > 0 || $trama_mensajes2Dclientes->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid trama_mensajes2Dclientes">
<div id="ftrama_mensajes2Dclientesgrid" class="ewForm form-inline">
<?php if ($trama_mensajes2Dclientes_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($trama_mensajes2Dclientes_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_trama_mensajes2Dclientes" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_trama_mensajes2Dclientesgrid" class="table ewTable">
<?php echo $trama_mensajes2Dclientes->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$trama_mensajes2Dclientes_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$trama_mensajes2Dclientes_grid->RenderListOptions();

// Render list options (header, left)
$trama_mensajes2Dclientes_grid->ListOptions->Render("header", "left");
?>
<?php if ($trama_mensajes2Dclientes->idCliente->Visible) { // idCliente ?>
	<?php if ($trama_mensajes2Dclientes->SortUrl($trama_mensajes2Dclientes->idCliente) == "") { ?>
		<th data-name="idCliente"><div id="elh_trama_mensajes2Dclientes_idCliente" class="trama_mensajes2Dclientes_idCliente"><div class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->idCliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idCliente"><div><div id="elh_trama_mensajes2Dclientes_idCliente" class="trama_mensajes2Dclientes_idCliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->idCliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_mensajes2Dclientes->idCliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_mensajes2Dclientes->idCliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($trama_mensajes2Dclientes->fecha->Visible) { // fecha ?>
	<?php if ($trama_mensajes2Dclientes->SortUrl($trama_mensajes2Dclientes->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_trama_mensajes2Dclientes_fecha" class="trama_mensajes2Dclientes_fecha"><div class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_trama_mensajes2Dclientes_fecha" class="trama_mensajes2Dclientes_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_mensajes2Dclientes->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_mensajes2Dclientes->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($trama_mensajes2Dclientes->mensaje->Visible) { // mensaje ?>
	<?php if ($trama_mensajes2Dclientes->SortUrl($trama_mensajes2Dclientes->mensaje) == "") { ?>
		<th data-name="mensaje"><div id="elh_trama_mensajes2Dclientes_mensaje" class="trama_mensajes2Dclientes_mensaje"><div class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->mensaje->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mensaje"><div><div id="elh_trama_mensajes2Dclientes_mensaje" class="trama_mensajes2Dclientes_mensaje">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trama_mensajes2Dclientes->mensaje->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trama_mensajes2Dclientes->mensaje->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trama_mensajes2Dclientes->mensaje->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$trama_mensajes2Dclientes_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$trama_mensajes2Dclientes_grid->StartRec = 1;
$trama_mensajes2Dclientes_grid->StopRec = $trama_mensajes2Dclientes_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($trama_mensajes2Dclientes_grid->FormKeyCountName) && ($trama_mensajes2Dclientes->CurrentAction == "gridadd" || $trama_mensajes2Dclientes->CurrentAction == "gridedit" || $trama_mensajes2Dclientes->CurrentAction == "F")) {
		$trama_mensajes2Dclientes_grid->KeyCount = $objForm->GetValue($trama_mensajes2Dclientes_grid->FormKeyCountName);
		$trama_mensajes2Dclientes_grid->StopRec = $trama_mensajes2Dclientes_grid->StartRec + $trama_mensajes2Dclientes_grid->KeyCount - 1;
	}
}
$trama_mensajes2Dclientes_grid->RecCnt = $trama_mensajes2Dclientes_grid->StartRec - 1;
if ($trama_mensajes2Dclientes_grid->Recordset && !$trama_mensajes2Dclientes_grid->Recordset->EOF) {
	$trama_mensajes2Dclientes_grid->Recordset->MoveFirst();
	$bSelectLimit = $trama_mensajes2Dclientes_grid->UseSelectLimit;
	if (!$bSelectLimit && $trama_mensajes2Dclientes_grid->StartRec > 1)
		$trama_mensajes2Dclientes_grid->Recordset->Move($trama_mensajes2Dclientes_grid->StartRec - 1);
} elseif (!$trama_mensajes2Dclientes->AllowAddDeleteRow && $trama_mensajes2Dclientes_grid->StopRec == 0) {
	$trama_mensajes2Dclientes_grid->StopRec = $trama_mensajes2Dclientes->GridAddRowCount;
}

// Initialize aggregate
$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_AGGREGATEINIT;
$trama_mensajes2Dclientes->ResetAttrs();
$trama_mensajes2Dclientes_grid->RenderRow();
if ($trama_mensajes2Dclientes->CurrentAction == "gridadd")
	$trama_mensajes2Dclientes_grid->RowIndex = 0;
if ($trama_mensajes2Dclientes->CurrentAction == "gridedit")
	$trama_mensajes2Dclientes_grid->RowIndex = 0;
while ($trama_mensajes2Dclientes_grid->RecCnt < $trama_mensajes2Dclientes_grid->StopRec) {
	$trama_mensajes2Dclientes_grid->RecCnt++;
	if (intval($trama_mensajes2Dclientes_grid->RecCnt) >= intval($trama_mensajes2Dclientes_grid->StartRec)) {
		$trama_mensajes2Dclientes_grid->RowCnt++;
		if ($trama_mensajes2Dclientes->CurrentAction == "gridadd" || $trama_mensajes2Dclientes->CurrentAction == "gridedit" || $trama_mensajes2Dclientes->CurrentAction == "F") {
			$trama_mensajes2Dclientes_grid->RowIndex++;
			$objForm->Index = $trama_mensajes2Dclientes_grid->RowIndex;
			if ($objForm->HasValue($trama_mensajes2Dclientes_grid->FormActionName))
				$trama_mensajes2Dclientes_grid->RowAction = strval($objForm->GetValue($trama_mensajes2Dclientes_grid->FormActionName));
			elseif ($trama_mensajes2Dclientes->CurrentAction == "gridadd")
				$trama_mensajes2Dclientes_grid->RowAction = "insert";
			else
				$trama_mensajes2Dclientes_grid->RowAction = "";
		}

		// Set up key count
		$trama_mensajes2Dclientes_grid->KeyCount = $trama_mensajes2Dclientes_grid->RowIndex;

		// Init row class and style
		$trama_mensajes2Dclientes->ResetAttrs();
		$trama_mensajes2Dclientes->CssClass = "";
		if ($trama_mensajes2Dclientes->CurrentAction == "gridadd") {
			if ($trama_mensajes2Dclientes->CurrentMode == "copy") {
				$trama_mensajes2Dclientes_grid->LoadRowValues($trama_mensajes2Dclientes_grid->Recordset); // Load row values
				$trama_mensajes2Dclientes_grid->SetRecordKey($trama_mensajes2Dclientes_grid->RowOldKey, $trama_mensajes2Dclientes_grid->Recordset); // Set old record key
			} else {
				$trama_mensajes2Dclientes_grid->LoadDefaultValues(); // Load default values
				$trama_mensajes2Dclientes_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$trama_mensajes2Dclientes_grid->LoadRowValues($trama_mensajes2Dclientes_grid->Recordset); // Load row values
		}
		$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($trama_mensajes2Dclientes->CurrentAction == "gridadd") // Grid add
			$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_ADD; // Render add
		if ($trama_mensajes2Dclientes->CurrentAction == "gridadd" && $trama_mensajes2Dclientes->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$trama_mensajes2Dclientes_grid->RestoreCurrentRowFormValues($trama_mensajes2Dclientes_grid->RowIndex); // Restore form values
		if ($trama_mensajes2Dclientes->CurrentAction == "gridedit") { // Grid edit
			if ($trama_mensajes2Dclientes->EventCancelled) {
				$trama_mensajes2Dclientes_grid->RestoreCurrentRowFormValues($trama_mensajes2Dclientes_grid->RowIndex); // Restore form values
			}
			if ($trama_mensajes2Dclientes_grid->RowAction == "insert")
				$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($trama_mensajes2Dclientes->CurrentAction == "gridedit" && ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT || $trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD) && $trama_mensajes2Dclientes->EventCancelled) // Update failed
			$trama_mensajes2Dclientes_grid->RestoreCurrentRowFormValues($trama_mensajes2Dclientes_grid->RowIndex); // Restore form values
		if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT) // Edit row
			$trama_mensajes2Dclientes_grid->EditRowCnt++;
		if ($trama_mensajes2Dclientes->CurrentAction == "F") // Confirm row
			$trama_mensajes2Dclientes_grid->RestoreCurrentRowFormValues($trama_mensajes2Dclientes_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$trama_mensajes2Dclientes->RowAttrs = array_merge($trama_mensajes2Dclientes->RowAttrs, array('data-rowindex'=>$trama_mensajes2Dclientes_grid->RowCnt, 'id'=>'r' . $trama_mensajes2Dclientes_grid->RowCnt . '_trama_mensajes2Dclientes', 'data-rowtype'=>$trama_mensajes2Dclientes->RowType));

		// Render row
		$trama_mensajes2Dclientes_grid->RenderRow();

		// Render list options
		$trama_mensajes2Dclientes_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($trama_mensajes2Dclientes_grid->RowAction <> "delete" && $trama_mensajes2Dclientes_grid->RowAction <> "insertdelete" && !($trama_mensajes2Dclientes_grid->RowAction == "insert" && $trama_mensajes2Dclientes->CurrentAction == "F" && $trama_mensajes2Dclientes_grid->EmptyRow())) {
?>
	<tr<?php echo $trama_mensajes2Dclientes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_mensajes2Dclientes_grid->ListOptions->Render("body", "left", $trama_mensajes2Dclientes_grid->RowCnt);
?>
	<?php if ($trama_mensajes2Dclientes->idCliente->Visible) { // idCliente ?>
		<td data-name="idCliente"<?php echo $trama_mensajes2Dclientes->idCliente->CellAttributes() ?>>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($trama_mensajes2Dclientes->idCliente->getSessionValue() <> "") { ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<select data-table="trama_mensajes2Dclientes" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dclientes->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dclientes->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dclientes->idCliente->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($trama_mensajes2Dclientes->idCliente->getSessionValue() <> "") { ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<select data-table="trama_mensajes2Dclientes" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dclientes->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dclientes->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dclientes->idCliente->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_idCliente" class="trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->idCliente->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->FormValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trama_mensajes2Dclientes_grid->PageObjName . "_row_" . $trama_mensajes2Dclientes_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_id" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->id->CurrentValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_id" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->id->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT || $trama_mensajes2Dclientes->CurrentMode == "edit") { ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_id" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($trama_mensajes2Dclientes->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $trama_mensajes2Dclientes->fecha->CellAttributes() ?>>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_fecha" class="form-group trama_mensajes2Dclientes_fecha">
<input type="text" data-table="trama_mensajes2Dclientes" data-field="x_fecha" data-format="2" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->getPlaceHolder()) ?>" value="<?php echo $trama_mensajes2Dclientes->fecha->EditValue ?>"<?php echo $trama_mensajes2Dclientes->fecha->EditAttributes() ?>>
<?php if (!$trama_mensajes2Dclientes->fecha->ReadOnly && !$trama_mensajes2Dclientes->fecha->Disabled && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["readonly"]) && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftrama_mensajes2Dclientesgrid", "x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha", 2);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_fecha" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_fecha" class="form-group trama_mensajes2Dclientes_fecha">
<input type="text" data-table="trama_mensajes2Dclientes" data-field="x_fecha" data-format="2" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->getPlaceHolder()) ?>" value="<?php echo $trama_mensajes2Dclientes->fecha->EditValue ?>"<?php echo $trama_mensajes2Dclientes->fecha->EditAttributes() ?>>
<?php if (!$trama_mensajes2Dclientes->fecha->ReadOnly && !$trama_mensajes2Dclientes->fecha->Disabled && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["readonly"]) && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftrama_mensajes2Dclientesgrid", "x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha", 2);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_fecha" class="trama_mensajes2Dclientes_fecha">
<span<?php echo $trama_mensajes2Dclientes->fecha->ViewAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->fecha->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_fecha" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->FormValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_fecha" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($trama_mensajes2Dclientes->mensaje->Visible) { // mensaje ?>
		<td data-name="mensaje"<?php echo $trama_mensajes2Dclientes->mensaje->CellAttributes() ?>>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_mensaje" class="form-group trama_mensajes2Dclientes_mensaje">
<textarea data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->getPlaceHolder()) ?>"<?php echo $trama_mensajes2Dclientes->mensaje->EditAttributes() ?>><?php echo $trama_mensajes2Dclientes->mensaje->EditValue ?></textarea>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->OldValue) ?>">
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_mensaje" class="form-group trama_mensajes2Dclientes_mensaje">
<textarea data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->getPlaceHolder()) ?>"<?php echo $trama_mensajes2Dclientes->mensaje->EditAttributes() ?>><?php echo $trama_mensajes2Dclientes->mensaje->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $trama_mensajes2Dclientes_grid->RowCnt ?>_trama_mensajes2Dclientes_mensaje" class="trama_mensajes2Dclientes_mensaje">
<span<?php echo $trama_mensajes2Dclientes->mensaje->ViewAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->mensaje->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->FormValue) ?>">
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_mensajes2Dclientes_grid->ListOptions->Render("body", "right", $trama_mensajes2Dclientes_grid->RowCnt);
?>
	</tr>
<?php if ($trama_mensajes2Dclientes->RowType == EW_ROWTYPE_ADD || $trama_mensajes2Dclientes->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftrama_mensajes2Dclientesgrid.UpdateOpts(<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($trama_mensajes2Dclientes->CurrentAction <> "gridadd" || $trama_mensajes2Dclientes->CurrentMode == "copy")
		if (!$trama_mensajes2Dclientes_grid->Recordset->EOF) $trama_mensajes2Dclientes_grid->Recordset->MoveNext();
}
?>
<?php
	if ($trama_mensajes2Dclientes->CurrentMode == "add" || $trama_mensajes2Dclientes->CurrentMode == "copy" || $trama_mensajes2Dclientes->CurrentMode == "edit") {
		$trama_mensajes2Dclientes_grid->RowIndex = '$rowindex$';
		$trama_mensajes2Dclientes_grid->LoadDefaultValues();

		// Set row properties
		$trama_mensajes2Dclientes->ResetAttrs();
		$trama_mensajes2Dclientes->RowAttrs = array_merge($trama_mensajes2Dclientes->RowAttrs, array('data-rowindex'=>$trama_mensajes2Dclientes_grid->RowIndex, 'id'=>'r0_trama_mensajes2Dclientes', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($trama_mensajes2Dclientes->RowAttrs["class"], "ewTemplate");
		$trama_mensajes2Dclientes->RowType = EW_ROWTYPE_ADD;

		// Render row
		$trama_mensajes2Dclientes_grid->RenderRow();

		// Render list options
		$trama_mensajes2Dclientes_grid->RenderListOptions();
		$trama_mensajes2Dclientes_grid->StartRowCnt = 0;
?>
	<tr<?php echo $trama_mensajes2Dclientes->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trama_mensajes2Dclientes_grid->ListOptions->Render("body", "left", $trama_mensajes2Dclientes_grid->RowIndex);
?>
	<?php if ($trama_mensajes2Dclientes->idCliente->Visible) { // idCliente ?>
		<td data-name="idCliente">
<?php if ($trama_mensajes2Dclientes->CurrentAction <> "F") { ?>
<?php if ($trama_mensajes2Dclientes->idCliente->getSessionValue() <> "") { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<select data-table="trama_mensajes2Dclientes" data-field="x_idCliente" data-value-separator="<?php echo $trama_mensajes2Dclientes->idCliente->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente"<?php echo $trama_mensajes2Dclientes->idCliente->EditAttributes() ?>>
<?php echo $trama_mensajes2Dclientes->idCliente->SelectOptionListHtml("x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente") ?>
</select>
<input type="hidden" name="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="s_x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo $trama_mensajes2Dclientes->idCliente->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_idCliente" class="form-group trama_mensajes2Dclientes_idCliente">
<span<?php echo $trama_mensajes2Dclientes->idCliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->idCliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_idCliente" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_idCliente" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_idCliente" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->idCliente->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trama_mensajes2Dclientes->fecha->Visible) { // fecha ?>
		<td data-name="fecha">
<?php if ($trama_mensajes2Dclientes->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_fecha" class="form-group trama_mensajes2Dclientes_fecha">
<input type="text" data-table="trama_mensajes2Dclientes" data-field="x_fecha" data-format="2" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->getPlaceHolder()) ?>" value="<?php echo $trama_mensajes2Dclientes->fecha->EditValue ?>"<?php echo $trama_mensajes2Dclientes->fecha->EditAttributes() ?>>
<?php if (!$trama_mensajes2Dclientes->fecha->ReadOnly && !$trama_mensajes2Dclientes->fecha->Disabled && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["readonly"]) && !isset($trama_mensajes2Dclientes->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ftrama_mensajes2Dclientesgrid", "x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha", 2);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_fecha" class="form-group trama_mensajes2Dclientes_fecha">
<span<?php echo $trama_mensajes2Dclientes->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_fecha" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_fecha" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trama_mensajes2Dclientes->mensaje->Visible) { // mensaje ?>
		<td data-name="mensaje">
<?php if ($trama_mensajes2Dclientes->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_mensaje" class="form-group trama_mensajes2Dclientes_mensaje">
<textarea data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->getPlaceHolder()) ?>"<?php echo $trama_mensajes2Dclientes->mensaje->EditAttributes() ?>><?php echo $trama_mensajes2Dclientes->mensaje->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_trama_mensajes2Dclientes_mensaje" class="form-group trama_mensajes2Dclientes_mensaje">
<span<?php echo $trama_mensajes2Dclientes->mensaje->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $trama_mensajes2Dclientes->mensaje->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="x<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="trama_mensajes2Dclientes" data-field="x_mensaje" name="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" id="o<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>_mensaje" value="<?php echo ew_HtmlEncode($trama_mensajes2Dclientes->mensaje->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trama_mensajes2Dclientes_grid->ListOptions->Render("body", "right", $trama_mensajes2Dclientes_grid->RowCnt);
?>
<script type="text/javascript">
ftrama_mensajes2Dclientesgrid.UpdateOpts(<?php echo $trama_mensajes2Dclientes_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($trama_mensajes2Dclientes->CurrentMode == "add" || $trama_mensajes2Dclientes->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $trama_mensajes2Dclientes_grid->FormKeyCountName ?>" id="<?php echo $trama_mensajes2Dclientes_grid->FormKeyCountName ?>" value="<?php echo $trama_mensajes2Dclientes_grid->KeyCount ?>">
<?php echo $trama_mensajes2Dclientes_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $trama_mensajes2Dclientes_grid->FormKeyCountName ?>" id="<?php echo $trama_mensajes2Dclientes_grid->FormKeyCountName ?>" value="<?php echo $trama_mensajes2Dclientes_grid->KeyCount ?>">
<?php echo $trama_mensajes2Dclientes_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftrama_mensajes2Dclientesgrid">
</div>
<?php

// Close recordset
if ($trama_mensajes2Dclientes_grid->Recordset)
	$trama_mensajes2Dclientes_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($trama_mensajes2Dclientes_grid->TotalRecs == 0 && $trama_mensajes2Dclientes->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($trama_mensajes2Dclientes_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($trama_mensajes2Dclientes->Export == "") { ?>
<script type="text/javascript">
ftrama_mensajes2Dclientesgrid.Init();
</script>
<?php } ?>
<?php
$trama_mensajes2Dclientes_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$trama_mensajes2Dclientes_grid->Page_Terminate();
?>
