<?php 

function renderContacto(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Contacto</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->
        <div id="formulario-contacto" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

					<h3 class="titulo">Contacto</h3>

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>

					<!-- Registro-->

					<?php 

					$detalleusuario=retornarDetalleUsuario();
					
					if ($detalleusuario["error"]==false) {
						$nombre=$detalleusuario["exito"][0]["ApellidoNombre"];
						$email=$detalleusuario["exito"][0]["emailCli"];
						$telefono=$detalleusuario["exito"][0]["Telefono"];
					}else{
						$nombre="";
						$email="";
						$telefono="";						
					}

					 ?>

					<div class="row">
						<div class="col-md-12 contenedor">
							<div class="inner">
								<div class="row">
									<div class="col-md-4">

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="nombre">Nombre</label>  
											<div class="">
												<input required id="nombre" type="text" placeholder="Nombre" class="form-control input-md" value="<?php echo $nombre ?>">
												<span class="help-block">Indique su Nombre</span>  
											</div>
										</div> 

									</div>

									<div class="col-md-4">

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="email">Email</label>  
											<div class="">
												<input required id="email" type="email" placeholder="Email" class="form-control input-md" value="<?php echo $email ?>">
												<span class="help-block">Indique su Email</span>  
											</div>
										</div> 

									</div>

									<div class="col-md-4">

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="telefono">Teléfono</label>  
											<div class="">
												<input required id="telefono" type="phone" placeholder="Teléfono" class="form-control input-md" value="<?php echo $telefono ?>">
												<span class="help-block">Indique su Teléfono</span>  
											</div>
										</div> 
                                                                                               
									</div>

									<div class="col-xs-12">

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="mensaje">Mensaje</label>  
											<div class="">
												<textarea class="form-control" required id="mensaje" cols="30" rows="10"></textarea>
												<span class="help-block">Escriba su Mensaje</span>  
											</div>
										</div> 

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
									<button type="submit" class="btn btn-primary form-submit" onclick="enviarFormularioCaptcha(this)" data-formulario="formulario-contacto">Enviar</button>
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