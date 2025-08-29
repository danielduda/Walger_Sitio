<?php 

function renderPedidos(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Pedidos</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

					<!-- Pedidos-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>					

					<h3 class="titulo">Pedidos</h3>
					<div class="row">
						<div class="col-xs-12">						
							<table id="mis-pedidos" class="table">
								<thead>
									<tr>
										<th></th>
										<th>Detalle</th>
										<th>Nº Pedido</th>
										<th>Estado</th>
										<th>Fecha</th>
										<th>Fecha Factura</th>										
										<th>Factura</th>
									</tr>
								</thead>
								<tbody>
																																								
								</tbody>
							</table>
						</div>
					</div>                           

					<!-- Fin Pedidos-->

				</div> 

				<!-- Panel Central -->   

			</div>
		</div>         

	</section>

	<div class="modal fade" id="detalle-pedido-modal" tabindex="-1" role="dialog" aria-labelledby="detalle-pedido">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Detalle de Pedido</h4>
	      </div>
	      <div class="modal-body">
 					<div class="row">
						<div class="col-xs-12">						
							<table id="detalle-pedido" class="table">
								<thead>
									<tr>
										<th>Cant</th>
										<th>Código</th>
										<th>Descripción</th>
										<th>Importe</th>
										<th>Subtotal</th>
										<?php 
												if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
													?>
														<th>IVA</th>
													<?php
												}
										 ?>									
									</tr>
								</thead>
								<tbody>
																																								
								</tbody>
							</table>
						</div>
					</div>       
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>	

	<?php 

}

?>