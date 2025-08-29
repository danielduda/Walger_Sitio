<?php 

function renderUltimosComprados(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Últimos Items Comprados</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

					<!-- Últimos Pedidos-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>					

					<h3 class="titulo">Últimos Items Comprados</h3>
					<div class="row">
						<div class="col-xs-12">						
							<table id="ultimos-comprados" class="table">
								<thead>
									<tr>
										<th>Código</th>
										<th>Descripción</th>
										<th>Importe</th>
										<th>Fecha compra</th>										
										<th>Volver a Comprar</th>										
									</tr>
								</thead>
								<tbody>
																																								
								</tbody>
							</table>
						</div>
					</div>                           

					<!-- Fin Últimos Pedidos-->

				</div> 

				<!-- Panel Central -->   

			</div>
		</div>         

	</section>

	<?php 

}

?>