<?php

// CodigoCli
// RazonSocialCli
// pedidosPendientes
// vencimientosPendientes
// CuitCli
// IngBrutosCli
// Regis_IvaC
// Regis_ListaPrec
// emailCli
// RazonSocialFlete
// Direccion
// BarrioCli
// LocalidadCli
// DescrProvincia
// CodigoPostalCli
// DescrPais
// Telefono
// FaxCli
// PaginaWebCli

?>
<?php if ($dbo_cliente->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $dbo_cliente->TableCaption() ?></h4> -->
<table id="tbl_dbo_clientemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $dbo_cliente->TableCustomInnerHtml ?>
	<tbody>
<?php if ($dbo_cliente->CodigoCli->Visible) { // CodigoCli ?>
		<tr id="r_CodigoCli">
			<td><?php echo $dbo_cliente->CodigoCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->CodigoCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CodigoCli">
<span<?php echo $dbo_cliente->CodigoCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialCli->Visible) { // RazonSocialCli ?>
		<tr id="r_RazonSocialCli">
			<td><?php echo $dbo_cliente->RazonSocialCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->RazonSocialCli->CellAttributes() ?>>
<span id="el_dbo_cliente_RazonSocialCli">
<span<?php echo $dbo_cliente->RazonSocialCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->pedidosPendientes->Visible) { // pedidosPendientes ?>
		<tr id="r_pedidosPendientes">
			<td><?php echo $dbo_cliente->pedidosPendientes->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->pedidosPendientes->CellAttributes() ?>>
<span id="el_dbo_cliente_pedidosPendientes">
<span<?php echo $dbo_cliente->pedidosPendientes->ViewAttributes() ?>>
<?php echo $dbo_cliente->pedidosPendientes->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->vencimientosPendientes->Visible) { // vencimientosPendientes ?>
		<tr id="r_vencimientosPendientes">
			<td><?php echo $dbo_cliente->vencimientosPendientes->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->vencimientosPendientes->CellAttributes() ?>>
<span id="el_dbo_cliente_vencimientosPendientes">
<span<?php echo $dbo_cliente->vencimientosPendientes->ViewAttributes() ?>>
<?php echo $dbo_cliente->vencimientosPendientes->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->CuitCli->Visible) { // CuitCli ?>
		<tr id="r_CuitCli">
			<td><?php echo $dbo_cliente->CuitCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->CuitCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CuitCli">
<span<?php echo $dbo_cliente->CuitCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CuitCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->IngBrutosCli->Visible) { // IngBrutosCli ?>
		<tr id="r_IngBrutosCli">
			<td><?php echo $dbo_cliente->IngBrutosCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->IngBrutosCli->CellAttributes() ?>>
<span id="el_dbo_cliente_IngBrutosCli">
<span<?php echo $dbo_cliente->IngBrutosCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->IngBrutosCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->Regis_IvaC->Visible) { // Regis_IvaC ?>
		<tr id="r_Regis_IvaC">
			<td><?php echo $dbo_cliente->Regis_IvaC->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->Regis_IvaC->CellAttributes() ?>>
<span id="el_dbo_cliente_Regis_IvaC">
<span<?php echo $dbo_cliente->Regis_IvaC->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_IvaC->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->Regis_ListaPrec->Visible) { // Regis_ListaPrec ?>
		<tr id="r_Regis_ListaPrec">
			<td><?php echo $dbo_cliente->Regis_ListaPrec->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->Regis_ListaPrec->CellAttributes() ?>>
<span id="el_dbo_cliente_Regis_ListaPrec">
<span<?php echo $dbo_cliente->Regis_ListaPrec->ViewAttributes() ?>>
<?php echo $dbo_cliente->Regis_ListaPrec->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->emailCli->Visible) { // emailCli ?>
		<tr id="r_emailCli">
			<td><?php echo $dbo_cliente->emailCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->emailCli->CellAttributes() ?>>
<span id="el_dbo_cliente_emailCli">
<span<?php echo $dbo_cliente->emailCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->emailCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->RazonSocialFlete->Visible) { // RazonSocialFlete ?>
		<tr id="r_RazonSocialFlete">
			<td><?php echo $dbo_cliente->RazonSocialFlete->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->RazonSocialFlete->CellAttributes() ?>>
<span id="el_dbo_cliente_RazonSocialFlete">
<span<?php echo $dbo_cliente->RazonSocialFlete->ViewAttributes() ?>>
<?php echo $dbo_cliente->RazonSocialFlete->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->Direccion->Visible) { // Direccion ?>
		<tr id="r_Direccion">
			<td><?php echo $dbo_cliente->Direccion->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->Direccion->CellAttributes() ?>>
<span id="el_dbo_cliente_Direccion">
<span<?php echo $dbo_cliente->Direccion->ViewAttributes() ?>>
<?php echo $dbo_cliente->Direccion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->BarrioCli->Visible) { // BarrioCli ?>
		<tr id="r_BarrioCli">
			<td><?php echo $dbo_cliente->BarrioCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->BarrioCli->CellAttributes() ?>>
<span id="el_dbo_cliente_BarrioCli">
<span<?php echo $dbo_cliente->BarrioCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->BarrioCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->LocalidadCli->Visible) { // LocalidadCli ?>
		<tr id="r_LocalidadCli">
			<td><?php echo $dbo_cliente->LocalidadCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->LocalidadCli->CellAttributes() ?>>
<span id="el_dbo_cliente_LocalidadCli">
<span<?php echo $dbo_cliente->LocalidadCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->LocalidadCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->DescrProvincia->Visible) { // DescrProvincia ?>
		<tr id="r_DescrProvincia">
			<td><?php echo $dbo_cliente->DescrProvincia->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->DescrProvincia->CellAttributes() ?>>
<span id="el_dbo_cliente_DescrProvincia">
<span<?php echo $dbo_cliente->DescrProvincia->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrProvincia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->CodigoPostalCli->Visible) { // CodigoPostalCli ?>
		<tr id="r_CodigoPostalCli">
			<td><?php echo $dbo_cliente->CodigoPostalCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->CodigoPostalCli->CellAttributes() ?>>
<span id="el_dbo_cliente_CodigoPostalCli">
<span<?php echo $dbo_cliente->CodigoPostalCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->CodigoPostalCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->DescrPais->Visible) { // DescrPais ?>
		<tr id="r_DescrPais">
			<td><?php echo $dbo_cliente->DescrPais->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->DescrPais->CellAttributes() ?>>
<span id="el_dbo_cliente_DescrPais">
<span<?php echo $dbo_cliente->DescrPais->ViewAttributes() ?>>
<?php echo $dbo_cliente->DescrPais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->Telefono->Visible) { // Telefono ?>
		<tr id="r_Telefono">
			<td><?php echo $dbo_cliente->Telefono->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->Telefono->CellAttributes() ?>>
<span id="el_dbo_cliente_Telefono">
<span<?php echo $dbo_cliente->Telefono->ViewAttributes() ?>>
<?php echo $dbo_cliente->Telefono->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->FaxCli->Visible) { // FaxCli ?>
		<tr id="r_FaxCli">
			<td><?php echo $dbo_cliente->FaxCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->FaxCli->CellAttributes() ?>>
<span id="el_dbo_cliente_FaxCli">
<span<?php echo $dbo_cliente->FaxCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->FaxCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($dbo_cliente->PaginaWebCli->Visible) { // PaginaWebCli ?>
		<tr id="r_PaginaWebCli">
			<td><?php echo $dbo_cliente->PaginaWebCli->FldCaption() ?></td>
			<td<?php echo $dbo_cliente->PaginaWebCli->CellAttributes() ?>>
<span id="el_dbo_cliente_PaginaWebCli">
<span<?php echo $dbo_cliente->PaginaWebCli->ViewAttributes() ?>>
<?php echo $dbo_cliente->PaginaWebCli->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
