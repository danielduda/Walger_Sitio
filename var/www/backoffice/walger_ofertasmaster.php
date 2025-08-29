<?php

// oferta
// activo
// fecha

?>
<?php if ($walger_ofertas->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $walger_ofertas->TableCaption() ?></h4> -->
<table id="tbl_walger_ofertasmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $walger_ofertas->TableCustomInnerHtml ?>
	<tbody>
<?php if ($walger_ofertas->oferta->Visible) { // oferta ?>
		<tr id="r_oferta">
			<td><?php echo $walger_ofertas->oferta->FldCaption() ?></td>
			<td<?php echo $walger_ofertas->oferta->CellAttributes() ?>>
<span id="el_walger_ofertas_oferta">
<span<?php echo $walger_ofertas->oferta->ViewAttributes() ?>>
<?php echo $walger_ofertas->oferta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($walger_ofertas->activo->Visible) { // activo ?>
		<tr id="r_activo">
			<td><?php echo $walger_ofertas->activo->FldCaption() ?></td>
			<td<?php echo $walger_ofertas->activo->CellAttributes() ?>>
<span id="el_walger_ofertas_activo">
<span<?php echo $walger_ofertas->activo->ViewAttributes() ?>>
<?php echo $walger_ofertas->activo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($walger_ofertas->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $walger_ofertas->fecha->FldCaption() ?></td>
			<td<?php echo $walger_ofertas->fecha->CellAttributes() ?>>
<span id="el_walger_ofertas_fecha">
<span<?php echo $walger_ofertas->fecha->ViewAttributes() ?>>
<?php echo $walger_ofertas->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
