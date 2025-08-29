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
					<?php

					$producto=retornarProducto($_GET["codigo"]);

					?>
					<h5><a href="productos.php">Catálogo</a><?php echo isset($producto["exito"]["DescrNivelInt4"]) && $producto["exito"]["DescrNivelInt4"]!="" ? '<a href="productos.php?favoritos=false&categoria='.$producto["exito"]["DescrNivelInt4"].'"> / '.$producto["exito"]["DescrNivelInt4"].'</a>' :''?><?php echo isset($producto["exito"]["DescrNivelInt3"]) && $producto["exito"]["DescrNivelInt3"]!="" ? '<a href="productos.php?favoritos=false&categoria='.$producto["exito"]["DescrNivelInt4"].'&linea='.$producto["exito"]["DescrNivelInt3"].'"> / '.$producto["exito"]["DescrNivelInt3"].'</a>' :''?></h5>

					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

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