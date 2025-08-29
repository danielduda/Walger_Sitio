<?php 

function renderListaPrecios(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Lista de Precios</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Panel Central -->

				<div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

					<!-- Pedidos-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando... Este proceso puede demorar
					</div>

					<?php 

					$listaprecios=retornarListaPrecios();

					?>										

					<div class="row">
						<div class="col-md-6">
							<h3 class="titulo">Lista de Precios</h3>
							
						</div>
						<div class="col-md-6 text-right">
							<h4 style="display:inline-block">DESCARGAR</h4>
							<button onclick="exportarExcel()" title="Descargar Excel" class="btn btn-danger" href=""><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
							<button onclick="exportarPdf()" title="Descargar PDF" class="btn btn-danger" href=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>							
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">						
							<table data-exportar="true" id="lista-precios" class="table" style="font-size: 8pt;">
								<thead>
									<tr>
										<th>Código</th>
										<th>Referencia</th>
										<th>Categoría</th>
										<th>Línea</th>
										<th>Marca</th>
										<th>Descripción</th>
										<th>Precio</th>
										<?php 
											if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
												$cantidadcolumnas=8;
												?>
													<th>IVA</th>
												<?php
											}else{
												$cantidadcolumnas=7;
											}
										?>												
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

	<?php 

}

?>