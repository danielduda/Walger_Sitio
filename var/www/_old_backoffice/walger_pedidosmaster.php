<p><span class="phpmaker">Maestro: Pedidos
<br><a href="<?php echo $sMasterReturnUrl ?>"></a></span>
</p>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">ID</td>
		<td valign="top">Cliente</td>
		<td valign="top">Estado</td>
		<td valign="top">Fecha Cambio de Estado</td>
		<td valign="top">Fecha de Facturación</td>
		<td valign="top">Factura</td>
	</tr>
	<tr class="ewTableSelectRow">
		<td>
<div<?php echo $walger_pedidos->idPedido->ViewAttributes() ?>><?php echo $walger_pedidos->idPedido->ViewValue ?></div>
</td>
		<td>
<div<?php echo $walger_pedidos->CodigoCli->ViewAttributes() ?>><?php echo $walger_pedidos->CodigoCli->ViewValue ?></div>
</td>
		<td>
<div<?php echo $walger_pedidos->estado->ViewAttributes() ?>><?php echo $walger_pedidos->estado->ViewValue ?></div>
</td>
		<td>
<div<?php echo $walger_pedidos->fechaEstado->ViewAttributes() ?>><?php echo $walger_pedidos->fechaEstado->ViewValue ?></div>
</td>
		<td>
<div<?php echo $walger_pedidos->fechaFacturacion->ViewAttributes() ?>><?php echo $walger_pedidos->fechaFacturacion->ViewValue ?></div>
</td>
		<td>
<div<?php echo $walger_pedidos->factura->ViewAttributes() ?>><?php echo $walger_pedidos->factura->ViewValue ?></div>
</td>
	</tr>
</table>
<br>
