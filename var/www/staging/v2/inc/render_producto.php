<?php 

function renderProducto(){       

	?>

	<section>

		<div class="container">
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">

					<!-- Breadcrumb -->

					<hr>
					<h5><a href="productos.php">Catálogo</a></h5>					
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

					<div class="col-xs 12" id="producto-contenedor">
						
					</div>
              <?php
                if ($GLOBALS["configuracion"]["redessociales"]["botonesfacebook"]===TRUE) {
                  facebookMeGusta();                          
                  facebookSeguir();
                  facebookCompartir();
                  facebookEnviar(); 
                }

              ?>						
				</div> 

				<!-- Panel Central -->            
			</div>
		</div>

	</section>

	<?php

	

}

?>