<?php 

function renderRegistro(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Registro</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div id="formulario-registro" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

					<!-- Registro-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>					

					<h3 class="titulo2">Registrarme</h3>
					<h3 class="titulo3">Datos generales</h3>
					<div class="row">
						<div class="col-md-12 contenedor">
							<div class="inner">
								<div class="row">
									<div class="col-md-6">

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["tipo-cliente"]["mostrar"]===TRUE) {
												?>

													<!-- Select Basic -->
													<div class="form-group">
														<label class="control-label" for="tipo-cliente"><?php echo $GLOBALS["configuracion"]["camposregistro"]["tipo-cliente"]["nombre"] ?></label>
														<div class="">
															<select <?php echo $GLOBALS["configuracion"]["camposregistro"]["tipo-cliente"]["obligatorio"]===TRUE?' required ':''  ?> id="tipo-cliente" class="form-control" data-elemento-dependiente="true">
																<?php 
										              $tiposClientes=retornarTiposClientes();

										              if($tiposClientes["error"]==true){
										                for ($i=0; $i < count($tiposClientes["errores"]["mensajeerror"]); $i++) { 
										                  echo $tiposClientes["errores"]["mensajeerror"][$i]."<br>";
										                }
										              }else{
										              	foreach ($tiposClientes["exito"] as $key => $value) {
																		?>
																			<option value="<?php echo $key ?>"><?php echo $value ?></option>
																		<?php							                    		
										              	}
										              }
																 ?>													
															</select>
														</div>
													</div>
												
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["razon-social"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":true}'>
														<label class="control-label" for="razon-social"><?php echo $GLOBALS["configuracion"]["camposregistro"]["razon-social"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["razon-social"]["obligatorio"]===TRUE?' required ':''  ?> id="razon-social" type="text" placeholder="Razón Social" class="form-control input-md">
															<span class="help-block">Indique su Razón Social</span>  
														</div>
													</div>
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["cuit"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
														<label class="control-label" for="cuit"><?php echo $GLOBALS["configuracion"]["camposregistro"]["cuit"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["cuit"]["obligatorio"]===TRUE?' required ':''  ?> id="cuit" type="text" placeholder="CUIT" class="form-control input-md">
															<span class="help-block">Indique su CUIT</span>  
														</div>
													</div> 
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["direccion-postal"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class=" control-label" for="direccion-postal"><?php echo $GLOBALS["configuracion"]["camposregistro"]["direccion-postal"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["direccion-postal"]["obligatorio"]===TRUE?' required ':''  ?> id="direccion-postal" type="text" placeholder="Dirección Postal" class="form-control input-md">
															<span class="help-block">Indique su Dirección Postal</span>  
														</div>
													</div> 
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["codigo-postal"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class=" control-label" for="codigo-postal"><?php echo $GLOBALS["configuracion"]["camposregistro"]["codigo-postal"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["codigo-postal"]["obligatorio"]===TRUE?' required ':''  ?> id="codigo-postal" type="text" placeholder="Código Postal" class="form-control input-md">
															<span class="help-block">Indique su Código Postal</span>  
														</div>
													</div>
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["telefono"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class=" control-label" for="telefono"><?php echo $GLOBALS["configuracion"]["camposregistro"]["telefono"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["telefono"]["obligatorio"]===TRUE?' required ':''  ?> id="telefono" type="text" placeholder="Teléfono" class="form-control input-md">
															<span class="help-block">Indique su Teléfono</span>  
														</div>
													</div>
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["pagina-web"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class=" control-label" for="pagina-web"><?php echo $GLOBALS["configuracion"]["camposregistro"]["pagina-web"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["pagina-web"]["obligatorio"]===TRUE?' required ':''  ?> id="pagina-web" type="text" placeholder="Página Web" class="form-control input-md">
															<span class="help-block">Indique su Página Web</span>
														</div>
													</div>
												<?php
											}

										?>


										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="contrasena">Contraseña</label>  
											<div class="">
												<input required id="contrasena" type="password" placeholder="Contraseña" class="form-control input-md">
												<span class="help-block">Indique su Contraseña</span> 
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="repetir-contrasena">Repetir contraseña</label>  
											<div class="">
												<input required id="repetir-contrasena" type="password" placeholder="Repetir contraseña" class="form-control input-md">
												<span class="help-block">Indique su Contraseña</span> 
											</div>
										</div>                                                                                                      
									</div>
									<div class="col-md-6">


										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["ingresos-brutos"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
														<label class=" control-label" for="ingresos-brutos"><?php echo $GLOBALS["configuracion"]["camposregistro"]["ingresos-brutos"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["ingresos-brutos"]["obligatorio"]===TRUE?' required ':''  ?> id="ingresos-brutos" type="text" placeholder="Ingresos Brutos" class="form-control input-md">
															<span class="help-block">Indique su nº de Ingresos Brutos</span>
														</div>
													</div>
												<?php
											}

										?>										

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["condicion-iva"]["mostrar"]===TRUE) {
												?>
													<!-- Select Basic -->
													<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":true}'>											
														<label class="control-label" for="condicion-iva"><?php echo $GLOBALS["configuracion"]["camposregistro"]["condicion-iva"]["nombre"] ?></label>
														<div class="">
															<select <?php echo $GLOBALS["configuracion"]["camposregistro"]["condicion-iva"]["obligatorio"]===TRUE?' required ':''  ?> id="condicion-iva" class="form-control">
																<?php 
										              $condicionesIva=retornarCondicionesIva();

										              if($condicionesIva["error"]==true){
										                for ($i=0; $i < count($condicionesIva["errores"]["mensajeerror"]); $i++) { 
										                  echo $condicionesIva["errores"]["mensajeerror"][$i]."<br>";
										                }
										              }else{
										              	foreach ($condicionesIva["exito"] as $key => $value) {
																			?>
																				<option value="<?php echo $key ?>"><?php echo $value ?></option>
																			<?php							                    		
										              	}
										              }
																 ?>	
															</select>
														</div>
													</div>
												<?php
											}

										?>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["pais"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="pais"><?php echo $GLOBALS["configuracion"]["camposregistro"]["pais"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["pais"]["obligatorio"]===TRUE?' required ':''  ?> id="pais" type="text" placeholder="País" class="form-control input-md">
															<span class="help-block">Indique su País</span>
														</div>
													</div>
												<?php
											}

										?>											

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["provincia"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="provincia"><?php echo $GLOBALS["configuracion"]["camposregistro"]["provincia"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["provincia"]["obligatorio"]===TRUE?' required ':''  ?> id="provincia" type="text" placeholder="Provincia" class="form-control input-md">
															<span class="help-block">Indique su Provincia</span>  
														</div>
													</div>   
												<?php
											}

										?>	

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["localidad"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="localidad"><?php echo $GLOBALS["configuracion"]["camposregistro"]["localidad"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["localidad"]["obligatorio"]===TRUE?' required ':''  ?> id="localidad" type="text" placeholder="Localidad" class="form-control input-md">
															<span class="help-block">Indique su Localidad</span>
														</div>
													</div>   
												<?php
											}

										?>	                     

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["barrio"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="barrio"><?php echo $GLOBALS["configuracion"]["camposregistro"]["barrio"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["barrio"]["obligatorio"]===TRUE?' required ':''  ?> id="barrio" type="text" placeholder="Barrio" class="form-control input-md">
															<span class="help-block">Indique su Barrio</span>
														</div>
													</div> 
												<?php
											}

										?>	  

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["fax"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="fax"><?php echo $GLOBALS["configuracion"]["camposregistro"]["fax"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["fax"]["obligatorio"]===TRUE?' required ':''  ?> id="fax" type="text" placeholder="Fax" class="form-control input-md">
															<span class="help-block">Indique su Fax</span>
														</div>
													</div> 
												<?php
											}

										?>	

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["fax"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="fax"><?php echo $GLOBALS["configuracion"]["camposregistro"]["fax"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["fax"]["obligatorio"]===TRUE?' required ':''  ?> id="fax" type="text" placeholder="Fax" class="form-control input-md">
															<span class="help-block">Indique su Fax</span>
														</div>
													</div> 
												<?php
											}

										?>	

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="email">Email</label>  
											<div class="">
												<input required id="email" type="email" placeholder="Email" class="form-control input-md">
												<span class="help-block">Indique su Email</span>
											</div>
										</div>

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["flete"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div id="test" class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
														<label class="control-label" for="flete"><?php echo $GLOBALS["configuracion"]["camposregistro"]["flete"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["flete"]["obligatorio"]===TRUE?' required ':''  ?> id="flete" type="text" placeholder="Flete" class="form-control input-md">
															<span class="help-block">Indique su Flete</span>
														</div>
													</div>
												<?php
											}

										?>	

									</div>
								</div>
							</div>
						</div>
					</div>

					<h3 class="titulo3">Datos del Contacto</h3>
					<div class="row">
						<div class="col-md-12 contenedor">
							<div class="inner">
								<div class="row">
									<div class="col-md-6">

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["apellido-nombre"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="apellido-nombre"><?php echo $GLOBALS["configuracion"]["camposregistro"]["apellido-nombre"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["apellido-nombre"]["obligatorio"]===TRUE?' required ':''  ?> id="apellido-nombre" type="text" placeholder="Apellido y Nombre" class="form-control input-md">
															<span class="help-block">Indique su Apellido y Nombre</span>
														</div>
													</div>
												<?php
											}

										?>											

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["comentarios"]["mostrar"]===TRUE) {
												?>
													<!-- Textarea-->
													<div class="form-group">
														<label class="control-label" for="comentarios"><?php echo $GLOBALS["configuracion"]["camposregistro"]["comentarios"]["nombre"] ?></label>  
														<div class="">
															<textarea <?php echo $GLOBALS["configuracion"]["camposregistro"]["comentarios"]["obligatorio"]===TRUE?' required ':''  ?> class="form-control" id="comentarios" name="textarea"></textarea>
															<span class="help-block">Indique su Comentario</span>
														</div>
													</div>   
												<?php
											}

										?>	
                     
										
									</div>
									<div class="col-md-6">

										<?php

											if ($GLOBALS["configuracion"]["camposregistro"]["cargo"]["mostrar"]===TRUE) {
												?>
													<!-- Text input-->
													<div class="form-group">
														<label class="control-label" for="cargo"><?php echo $GLOBALS["configuracion"]["camposregistro"]["cargo"]["nombre"] ?></label>  
														<div class="">
															<input <?php echo $GLOBALS["configuracion"]["camposregistro"]["cargo"]["obligatorio"]===TRUE?' required ':''  ?> id="cargo" type="text" placeholder="Cargo" class="form-control input-md">
															<span class="help-block">Cargo</span>
														</div>
													</div>
												<?php
											}

										?>											
									
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 contenedor">
							<div class="row">
								<div class="col-md-6">
									<div class="g-recaptcha" data-sitekey="<?php echo $GLOBALS["configuracion"]["captchasitekey"] ?>"></div>
								</div>
								<div class="col-md-6">
									<button type="submit" class="btn btn-primary form-submit" onclick="enviarFormularioCaptcha(this)" data-formulario="formulario-registro">Registrarme</button>
								</div>
							</div>

						</div>
					</div>                            

					<!-- Fin Registro-->

				</div> 

				<!-- Panel Central -->   

			</div>
		</div>         

	</section>

	<?php 

}

?>