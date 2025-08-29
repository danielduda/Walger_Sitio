<?php 

function renderProductos(){


	?>

	<section>

		<div class="container">
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">

					<!-- Breadcrumb -->

					<hr style="margin-bottom:10px">
					<div class="row">
						<div class="col-xs-12 col-sm-8">
							<h5><a href="productos.php">Catálogo</a><?php echo isset($_GET["categoria"]) && $_GET["categoria"]!="" ? '<a href="productos.php?categoria='.$_GET["categoria"].'"> / '.$_GET["categoria"].'</a>' :''?><?php echo isset($_GET["linea"]) && $_GET["linea"]!="" ? '<a href="productos.php?categoria='.$_GET["categoria"].'&linea='.$_GET["linea"].'"> / '.$_GET["linea"].'</a>' :''?></h5>
						</div>
						<?php 
							if ($GLOBALS["configuracion"]["productos"]["selectorenbreadcrumb"]===TRUE) {
								?>
									<div class="col-xs-6 col-sm-4 text-right productosMostrar">
										<button onclick="MostrarLista()" class="btn  btn-danger" href=""><i class="fa fa-list" aria-hidden="true"></i></button>
										<button onclick="MostrarGrilla()" class="btn btn-danger" href=""><i class="fa fa-th-large" aria-hidden="true"></i></button>
									</div>						
								<?php 
							}
						?>
					</div>
					<hr style="margin-top:10px">

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">
					<div class="col-xs 12" id="productos-contenedor">
						<?php 
							if ($GLOBALS["configuracion"]["productos"]["muestratitulo"]===TRUE) {
								?>
									<h3 class="bold titulo">
										<?php 

				            if (isset($_GET["favoritos"])) {
				              if ($_GET["favoritos"]=="false") {
				                ?>
				                Productos
				                <?php
				              }else{
				                ?>
				                Favoritos
				                <?php
				              }
				            }else{
			                ?>
			                Productos
			                <?php           
				            }							

										 ?>
									</h3>						
								<?php 
							}
						?>

						<!-- Menú superior -->
						<?php
							$formasordenamiento=retornarProductosOrdenamiento();
						
						if (($formasordenamiento["error"]===TRUE || count($formasordenamiento["exito"])==1) && $GLOBALS["configuracion"]["productos"]["selectorenpanel"]===FALSE) {
						?>						
							<div class="row" id="productos-panel" style="margin-top:-15px">
						<?php 
						}else{
						?>						
							<div class="row" id="productos-panel">
						<?php 							
						}
						?>

							<div class="col-xs-12 col-sm-4">
							</div>
							
							<?php
							if ($formasordenamiento["error"]===TRUE || count($formasordenamiento["exito"])==1) {
								?>
									<div class="col-xs-6 col-sm-8 text-right productosMostrar">
								<?php
							}else{
								?>
									<div class="col-xs-6 col-sm-4 text-right productosMostrar">
								<?php								
							}

								if ($GLOBALS["configuracion"]["productos"]["selectorenpanel"]===TRUE) {
									?>
										<button onclick="MostrarLista()" class="btn  btn-danger" href=""><i class="fa fa-list" aria-hidden="true"></i></button>
										<button onclick="MostrarGrilla()" class="btn btn-danger" href=""><i class="fa fa-th-large" aria-hidden="true"></i></button>
									<?php 
								}
							?>
							</div>						

								<?php 

								if ($formasordenamiento["error"]==false) {
									if (count($formasordenamiento["exito"])>1) {
										?>
											<div class="col-sm-8 col-md-4" >
												<select onchange="cambiaorden(this)" id="formasordenamiento" name="formasordenamiento" class="form-control">
										<?php
										for ($i=0; $i < count($formasordenamiento["exito"]); $i++) { 
												?>
													<option value="<?php echo $i ?>"><?php echo $formasordenamiento["exito"][$i]["denominacion"] ?></option>
												<?php
										}
										?>
												</select>
											</div>
										<?php
									}else{
										?>
											<input type="hidden" value="0">
										<?php
									}
								}

								 ?>

						</div>

						<!-- Fin Menú superior -->

						<div class="panel-group">


						</div>
	          <div id="preloader" class="row">
	            <div class="col-md-12">
	              <div class="preloader-parrafo breath"></div>
	            </div>
	          </div>

	          <div class="cargarmas col-xs-12">
	            <a id="cargarmas" class="btn btn-danger btn-lg" href="javascript:void(0)" onclick="filtrarProductos(this)">Cargar Más Productos</a>
	          </div>
					</div>
				</div> 

				<!-- Panel Central -->            
			</div>
		</div>

	</section>

	<?php

	
}

?>