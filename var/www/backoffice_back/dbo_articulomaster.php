<?php

// CodInternoArti
// CodBarraArti
// idTipoArticulo
// DescripcionArti
// PrecioVta1_PreArti
// Stock1_StkArti
// NombreFotoArti
// DescrNivelInt4
// DescrNivelInt3
// DescrNivelInt2

?>
<?php if ($dbo_articulo->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $dbo_articulo->TableCaption() ?></h4> -->
<table id="tbl_dbo_articulomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $dbo_articulo->TableCustomInnerHtml ?>
	<tbody>
<?php if ($dbo_articulo->CodInternoArti->Visible) { // CodInternoArti ?>
		<tr id="r_CodInternoArti">
			<td><?php echo $dbo_articulo->CodInternoArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->CodInternoArti->CellAttributes() ?>>
<span id="el_dbo_articulo_CodInternoArti">
<span<?php echo $dbo_articulo->CodInternoArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodInternoArti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->CodBarraArti->Visible) { // CodBarraArti ?>
		<tr id="r_CodBarraArti">
			<td><?php echo $dbo_articulo->CodBarraArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->CodBarraArti->CellAttributes() ?>>
<span id="el_dbo_articulo_CodBarraArti">
<span<?php echo $dbo_articulo->CodBarraArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->CodBarraArti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->idTipoArticulo->Visible) { // idTipoArticulo ?>
		<tr id="r_idTipoArticulo">
			<td><?php echo $dbo_articulo->idTipoArticulo->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->idTipoArticulo->CellAttributes() ?>>
<span id="el_dbo_articulo_idTipoArticulo">
<span<?php echo $dbo_articulo->idTipoArticulo->ViewAttributes() ?>>
<?php echo $dbo_articulo->idTipoArticulo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->DescripcionArti->Visible) { // DescripcionArti ?>
		<tr id="r_DescripcionArti">
			<td><?php echo $dbo_articulo->DescripcionArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->DescripcionArti->CellAttributes() ?>>
<span id="el_dbo_articulo_DescripcionArti">
<span<?php echo $dbo_articulo->DescripcionArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescripcionArti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->PrecioVta1_PreArti->Visible) { // PrecioVta1_PreArti ?>
		<tr id="r_PrecioVta1_PreArti">
			<td><?php echo $dbo_articulo->PrecioVta1_PreArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->PrecioVta1_PreArti->CellAttributes() ?>>
<span id="el_dbo_articulo_PrecioVta1_PreArti">
<span<?php echo $dbo_articulo->PrecioVta1_PreArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->PrecioVta1_PreArti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->Stock1_StkArti->Visible) { // Stock1_StkArti ?>
		<tr id="r_Stock1_StkArti">
			<td><?php echo $dbo_articulo->Stock1_StkArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->Stock1_StkArti->CellAttributes() ?>>
<span id="el_dbo_articulo_Stock1_StkArti">
<span<?php echo $dbo_articulo->Stock1_StkArti->ViewAttributes() ?>>
<?php echo $dbo_articulo->Stock1_StkArti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->NombreFotoArti->Visible) { // NombreFotoArti ?>
		<tr id="r_NombreFotoArti">
			<td><?php echo $dbo_articulo->NombreFotoArti->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->NombreFotoArti->CellAttributes() ?>>
<span id="el_dbo_articulo_NombreFotoArti">
<span<?php echo $dbo_articulo->NombreFotoArti->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($dbo_articulo->NombreFotoArti, $dbo_articulo->NombreFotoArti->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt4->Visible) { // DescrNivelInt4 ?>
		<tr id="r_DescrNivelInt4">
			<td><?php echo $dbo_articulo->DescrNivelInt4->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->DescrNivelInt4->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt4">
<span<?php echo $dbo_articulo->DescrNivelInt4->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt4->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt3->Visible) { // DescrNivelInt3 ?>
		<tr id="r_DescrNivelInt3">
			<td><?php echo $dbo_articulo->DescrNivelInt3->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->DescrNivelInt3->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt3">
<span<?php echo $dbo_articulo->DescrNivelInt3->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt3->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_articulo->DescrNivelInt2->Visible) { // DescrNivelInt2 ?>
		<tr id="r_DescrNivelInt2">
			<td><?php echo $dbo_articulo->DescrNivelInt2->FldCaption() ?></td>
			<td<?php echo $dbo_articulo->DescrNivelInt2->CellAttributes() ?>>
<span id="el_dbo_articulo_DescrNivelInt2">
<span<?php echo $dbo_articulo->DescrNivelInt2->ViewAttributes() ?>>
<?php echo $dbo_articulo->DescrNivelInt2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
