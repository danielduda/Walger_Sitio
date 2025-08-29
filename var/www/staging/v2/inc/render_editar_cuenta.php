<?php 

function renderEditarCuenta(){

	$cliente=retornarCliente();

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Editar Cuenta</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

				<div id="formulario-editar-registro" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">

					<!-- Registro-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>					

					<h3 class="titulo2">Editar Cuenta</h3>
					<h3 class="titulo3">Datos de la empresa</h3>
					<div class="row">
						<div class="col-md-12 contenedor">
							<div class="inner">
								<div class="row">
									<div class="col-md-6">

										<!-- Select Basic -->
										<div class="form-group">
											<label class="control-label" for="tipo-cliente">Tipo de Cliente</label>
											<div class="">
												<select id="tipo-cliente" class="form-control" data-elemento-dependiente="true">
													<?php 
							              $tiposClientes=retornarTiposClientes();

							              if($tiposClientes["error"]==true){
							                for ($i=0; $i < count($tiposClientes["errores"]["mensajeerror"]); $i++) { 
							                  echo $tiposClientes["errores"]["mensajeerror"][$i]."<br>";
							                }
							              }else{
							              	foreach ($tiposClientes["exito"] as $key => $value) {
								              	if ($cliente["exito"][0]["TipoCliente"]==$value) {
								              		?>
																		<option selected value="<?php echo $key ?>"><?php echo $value ?></option>
								              		<?php
								              	}else{
																	?>
																		<option value="<?php echo $key ?>"><?php echo $value ?></option>
																	<?php							                    		
								              	}
							              	}
							              }
													 ?>													
												</select>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
											<label class="control-label" for="razon-social">Razón Social</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["RazonSocialCli"] ?>" required id="razon-social" type="text" placeholder="Razón Social" class="form-control input-md">
												<span class="help-block">Indique su Razón Social</span>  
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
											<label class="control-label" for="cuit">CUIT</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["CuitCli"] ?>" id="cuit" type="text" placeholder="CUIT" class="form-control input-md">
												<span class="help-block">Indique su CUIT</span>  
											</div>
										</div> 

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="direccion-postal">Dirección Postal</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["Direccion"] ?>" required id="direccion-postal" type="text" placeholder="Dirección Postal" class="form-control input-md">
												<span class="help-block">Indique su Dirección Postal</span>  
											</div>
										</div> 

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="codigo-postal">Código Postal</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["CodigoPostalCli"] ?>" required id="codigo-postal" type="text" placeholder="Código Postal" class="form-control input-md">
												<span class="help-block">Indique su Código Postal</span>  
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="telefono">Teléfono</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["Telefono"] ?>" required id="telefono" type="text" placeholder="Teléfono" class="form-control input-md">
												<span class="help-block">Indique su Teléfono</span>  
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="pagina-web">Página Web</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["PaginaWebCli"] ?>" id="pagina-web" type="text" placeholder="Página Web" class="form-control input-md">
												<span class="help-block">Indique su Página Web</span>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="contrasena">Contraseña</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["Contrasenia"] ?>" required id="contrasena" type="password" placeholder="Contraseña" class="form-control input-md">
												<span class="help-block">Indique su Contraseña</span> 
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class=" control-label" for="repetir-contrasena">Repetir contraseña</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["Contrasenia"] ?>" required id="repetir-contrasena" type="password" placeholder="Repetir contraseña" class="form-control input-md">
												<span class="help-block">Indique su Contraseña</span> 
											</div>
										</div>                                                                                                      
									</div>
									<div class="col-md-6">

										<!-- Text input-->
										<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
											<label class=" control-label" for="ingresos-brutos">Ingresos Brutos</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["IngBrutosCli"] ?>" id="ingresos-brutos" type="text" placeholder="Ingresos Brutos" class="form-control input-md">
												<span class="help-block">Indique su nº de Ingresos Brutos</span>
											</div>
										</div>

										<!-- Select Basic -->
										<div class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
											<label class="control-label" for="condicion-iva">Condición de IVA</label>
											<div class="">
												<select id="condicion-iva" class="form-control">													
													<?php 
							              $condicionesIva=retornarCondicionesIva();

							              if($condicionesIva["error"]==true){
							                for ($i=0; $i < count($condicionesIva["errores"]["mensajeerror"]); $i++) { 
							                  echo $condicionesIva["errores"]["mensajeerror"][$i]."<br>";
							                }
							              }else{
							              	foreach ($condicionesIva["exito"] as $key => $value) {
								              	if ($cliente["exito"][0]["Regis_IvaC"]==$key) {
								              		?>
																		<option selected value="<?php echo $key ?>"><?php echo $value ?></option>
								              		<?php
								              	}else{
																	?>
																		<option value="<?php echo $key ?>"><?php echo $value ?></option>
																	<?php							                    		
								              	}
							              	}
							              }
													 ?>	
												</select>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="pais">País</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["DescrPais"] ?>" required id="pais" type="text" placeholder="País" class="form-control input-md">
												<span class="help-block">Indique su País</span>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label required class="control-label" for="provincia">Provincia</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["DescrProvincia"] ?>" id="provincia" type="text" placeholder="Provincia" class="form-control input-md">
												<span class="help-block">Indique su Provincia</span>  
											</div>
										</div>                        

										<!-- Text input-->
										<div class="form-group">
											<label required class="control-label" for="localidad">Localidad</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["LocalidadCli"] ?>" id="localidad" type="text" placeholder="Localidad" class="form-control input-md">
												<span class="help-block">Indique su Localidad</span>
											</div>
										</div>
										
										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="barrio">Barrio</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["BarrioCli"] ?>" id="barrio" type="text" placeholder="Barrio" class="form-control input-md">
												<span class="help-block">Indique su Barrio</span>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="fax">Fax</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["FaxCli"] ?>" id="fax" type="text" placeholder="Fax" class="form-control input-md">
												<span class="help-block">Indique su Fax</span>
											</div>
										</div>

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="email">Email</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["emailCli"] ?>" required id="email" type="email" placeholder="Email" class="form-control input-md">
												<span class="help-block">Indique su Email</span>
											</div>
										</div>

										<!-- Text input-->
										<div id="test" class="form-group" data-dependiente="tipo-cliente" data-visible='{"1":true,"2":true,"3":false}'>
											<label class="control-label" for="flete">Flete (Razón Social)</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["RazonSocialFlete"] ?>" id="flete" type="text" placeholder="Flete" class="form-control input-md">
												<span class="help-block">Indique su Flete</span>
											</div>
										</div>                                                                                                
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

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="apellido-nombre">Apellido y Nombre</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["ApellidoNombre"] ?>" id="apellido-nombre" type="text" placeholder="Apellido y Nombre" class="form-control input-md">
												<span class="help-block">Indique su Apellido y Nombre</span>
											</div>
										</div>

										<!-- Textarea-->
										<div class="form-group">
											<label class="control-label" for="comentarios">Comentarios</label>  
											<div class="">
												<textarea class="form-control" id="comentarios" name="textarea"><?php echo $cliente["exito"][0]["Comentarios"] ?></textarea>
												<span class="help-block">Indique su Comentario</span>
											</div>
										</div>                        
										
									</div>
									<div class="col-md-6">

										<!-- Text input-->
										<div class="form-group">
											<label class="control-label" for="cargo">Cargo</label>  
											<div class="">
												<input value="<?php echo $cliente["exito"][0]["Cargo"] ?>" id="cargo" type="text" placeholder="Cargo" class="form-control input-md">
												<span class="help-block">Cargo</span>
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
									<button type="submit" class="btn btn-primary form-submit" onclick="enviarFormularioCaptcha(this)" data-formulario="formulario-editar-registro">Registrarme</button>
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