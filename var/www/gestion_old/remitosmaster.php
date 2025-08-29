<?php

// Id_Remito
// numeroRemito
// Fecha
// Cliente
// Proveedor
// Transporte
// NumeroDeBultos
// OperadorTraslado
// OperadorVerifico
// Importe
// observacionesInternas
// estado
// resultado

?>
<?php if ($remitos->Visible) { ?>
<table cellspacing="0" id="t_remitos" class="ewGrid"><tr><td>
<table id="tbl_remitosmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($remitos->Id_Remito->Visible) { // Id_Remito ?>
		<tr id="r_Id_Remito">
			<td><?php echo $remitos->Id_Remito->FldCaption() ?></td>
			<td<?php echo $remitos->Id_Remito->CellAttributes() ?>>
<span id="el_remitos_Id_Remito" class="control-group">
<span<?php echo $remitos->Id_Remito->ViewAttributes() ?>>
<?php echo $remitos->Id_Remito->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->numeroRemito->Visible) { // numeroRemito ?>
		<tr id="r_numeroRemito">
			<td><?php echo $remitos->numeroRemito->FldCaption() ?></td>
			<td<?php echo $remitos->numeroRemito->CellAttributes() ?>>
<span id="el_remitos_numeroRemito" class="control-group">
<span<?php echo $remitos->numeroRemito->ViewAttributes() ?>>
<?php echo $remitos->numeroRemito->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->Fecha->Visible) { // Fecha ?>
		<tr id="r_Fecha">
			<td><?php echo $remitos->Fecha->FldCaption() ?></td>
			<td<?php echo $remitos->Fecha->CellAttributes() ?>>
<span id="el_remitos_Fecha" class="control-group">
<span<?php echo $remitos->Fecha->ViewAttributes() ?>>
<?php echo $remitos->Fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->Cliente->Visible) { // Cliente ?>
		<tr id="r_Cliente">
			<td><?php echo $remitos->Cliente->FldCaption() ?></td>
			<td<?php echo $remitos->Cliente->CellAttributes() ?>>
<span id="el_remitos_Cliente" class="control-group">
<span<?php echo $remitos->Cliente->ViewAttributes() ?>>
<?php echo $remitos->Cliente->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->Proveedor->Visible) { // Proveedor ?>
		<tr id="r_Proveedor">
			<td><?php echo $remitos->Proveedor->FldCaption() ?></td>
			<td<?php echo $remitos->Proveedor->CellAttributes() ?>>
<span id="el_remitos_Proveedor" class="control-group">
<span<?php echo $remitos->Proveedor->ViewAttributes() ?>>
<?php echo $remitos->Proveedor->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->Transporte->Visible) { // Transporte ?>
		<tr id="r_Transporte">
			<td><?php echo $remitos->Transporte->FldCaption() ?></td>
			<td<?php echo $remitos->Transporte->CellAttributes() ?>>
<span id="el_remitos_Transporte" class="control-group">
<span<?php echo $remitos->Transporte->ViewAttributes() ?>>
<?php echo $remitos->Transporte->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->NumeroDeBultos->Visible) { // NumeroDeBultos ?>
		<tr id="r_NumeroDeBultos">
			<td><?php echo $remitos->NumeroDeBultos->FldCaption() ?></td>
			<td<?php echo $remitos->NumeroDeBultos->CellAttributes() ?>>
<span id="el_remitos_NumeroDeBultos" class="control-group">
<span<?php echo $remitos->NumeroDeBultos->ViewAttributes() ?>>
<?php echo $remitos->NumeroDeBultos->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->OperadorTraslado->Visible) { // OperadorTraslado ?>
		<tr id="r_OperadorTraslado">
			<td><?php echo $remitos->OperadorTraslado->FldCaption() ?></td>
			<td<?php echo $remitos->OperadorTraslado->CellAttributes() ?>>
<span id="el_remitos_OperadorTraslado" class="control-group">
<span<?php echo $remitos->OperadorTraslado->ViewAttributes() ?>>
<?php echo $remitos->OperadorTraslado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->OperadorVerifico->Visible) { // OperadorVerifico ?>
		<tr id="r_OperadorVerifico">
			<td><?php echo $remitos->OperadorVerifico->FldCaption() ?></td>
			<td<?php echo $remitos->OperadorVerifico->CellAttributes() ?>>
<span id="el_remitos_OperadorVerifico" class="control-group">
<span<?php echo $remitos->OperadorVerifico->ViewAttributes() ?>>
<?php echo $remitos->OperadorVerifico->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->Importe->Visible) { // Importe ?>
		<tr id="r_Importe">
			<td><?php echo $remitos->Importe->FldCaption() ?></td>
			<td<?php echo $remitos->Importe->CellAttributes() ?>>
<span id="el_remitos_Importe" class="control-group">
<span<?php echo $remitos->Importe->ViewAttributes() ?>>
<?php echo $remitos->Importe->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->observacionesInternas->Visible) { // observacionesInternas ?>
		<tr id="r_observacionesInternas">
			<td><?php echo $remitos->observacionesInternas->FldCaption() ?></td>
			<td<?php echo $remitos->observacionesInternas->CellAttributes() ?>>
<span id="el_remitos_observacionesInternas" class="control-group">
<span<?php echo $remitos->observacionesInternas->ViewAttributes() ?>>
<?php echo $remitos->observacionesInternas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $remitos->estado->FldCaption() ?></td>
			<td<?php echo $remitos->estado->CellAttributes() ?>>
<span id="el_remitos_estado" class="control-group">
<span<?php echo $remitos->estado->ViewAttributes() ?>>
<?php echo $remitos->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($remitos->resultado->Visible) { // resultado ?>
		<tr id="r_resultado">
			<td><?php echo $remitos->resultado->FldCaption() ?></td>
			<td<?php echo $remitos->resultado->CellAttributes() ?>>
<span id="el_remitos_resultado" class="control-group">
<span<?php echo $remitos->resultado->ViewAttributes() ?>>
<?php echo $remitos->resultado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
