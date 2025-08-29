<?php

// id
// denominacion

?>
<?php if ($trama_atributos->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $trama_atributos->TableCaption() ?></h4> -->
<table id="tbl_trama_atributosmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $trama_atributos->TableCustomInnerHtml ?>
	<tbody>
<?php if ($trama_atributos->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $trama_atributos->id->FldCaption() ?></td>
			<td<?php echo $trama_atributos->id->CellAttributes() ?>>
<span id="el_trama_atributos_id">
<span<?php echo $trama_atributos->id->ViewAttributes() ?>>
<?php echo $trama_atributos->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($trama_atributos->denominacion->Visible) { // denominacion ?>
		<tr id="r_denominacion">
			<td><?php echo $trama_atributos->denominacion->FldCaption() ?></td>
			<td<?php echo $trama_atributos->denominacion->CellAttributes() ?>>
<span id="el_trama_atributos_denominacion">
<span<?php echo $trama_atributos->denominacion->ViewAttributes() ?>>
<?php echo $trama_atributos->denominacion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
