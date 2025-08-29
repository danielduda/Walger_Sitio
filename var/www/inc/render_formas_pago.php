<?php 

function renderFormasPago(){
	?>

          <div class="row">
            <div class="col-md-12">
                <h3 class="bold titulo">Formas de Pago</h3>
								<dl>
									<?php 
										for ($i=0; $i < count($GLOBALS["configuracion"]["textos"]["formasdepago"]); $i++) { 
											?>
											<dt><?php echo $GLOBALS["configuracion"]["textos"]["formasdepago"][$i]["titulo"]; ?></dt>
											<dd><?php echo $GLOBALS["configuracion"]["textos"]["formasdepago"][$i]["detalle"]; ?></dd>											
											<?php
										}
									?>
						    </dl>                
            </div>
          </div> 
	<?php 
}

 ?>