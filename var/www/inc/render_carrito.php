<?php 

function renderCarrito(){

	?>

	<section>

		<div class="container">
			
			<div class="row">

				<!-- Encabezado Página -->

				<div class="col-xs-12">
					
					<!-- Breadcrumb -->

					<hr>
					<h5><a href="">Carrito</a></h5>
					<hr>

					<!-- Fin Breadcrumb -->

				</div>

				<!-- Fin Encabezado Página -->

				<!-- Menú Lateral -->

				<?php renderMenuLateral() ?>

				<!-- Fin Menú Lateral -->

				<!-- Panel Central -->

        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

					<!-- Carrito-->

					<div class="spinner">
						<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
					</div>					

					<h3 class="titulo">Carrito</h3>
					<div class="row">
						<div class="col-xs-12">						
							<table id="mis-pedidos" class="table">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th>Cant</th>
										<th>Código</th>
										<th>Descripción</th>
										<th>Importe</th>
										<th>Subtotal</th>
										<?php
											if (sesion()){
												if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
													?>
														<th>IVA</th>
													<?php
												} 	
											} 
										 ?>									
									</tr>
								</thead>
								<tbody>
																																								
								</tbody>
							</table>
						</div>						
					</div>

					<?php 
						if ($GLOBALS["configuracion"]["checkout"]===TRUE) {
							?>
								<div class="row" style="margin-top:30px">
									<div class="col-md-6">
										<div class="form-group">
									  	<?php 
									  		$mediosEntrega=retornarMediosEntrega();
									  		if ($mediosEntrega["error"]===TRUE) {
									  			?>
													  <label class="control-label" for="medio-entrega"><i class="fa fa-truck fa-2x fa-fw" aria-hidden="true"></i> Medio de Entrega</label>
													  <div>
													  	<select name="" class="form-control" disabled id="medio-entrega">
													  		<option value="0"><?php echo $mediosEntrega["errores"]["mensajeerror"][0]; ?></option>
													  	</select>
													  </div>
									  			<?php									  			
									  		}else{
									  			?>
													  <label class="control-label" for="medio-entrega"><i class="fa fa-truck fa-2x fa-fw" aria-hidden="true"></i> Medio de Entrega</label>
													  <div>
													  	<select name="" onchange="seleccionaMediosEntrega(this)" class="form-control" id="medio-entrega">
													  		<?php 
													  			for ($i=0; $i < count($mediosEntrega["exito"]); $i++) { 
													  				?>
													  				<option value="<?php echo $mediosEntrega["exito"][$i]["id"] ?>"><?php echo $mediosEntrega["exito"][$i]["denominacion"] ?></option>
													  				<?php
													  			}
													  		?>
													  	</select>                     
													  </div>
									  			<?php
									  		}
									  	?>
										</div>														
										<div class="form-group">
										  <label class="control-label" for="medio-pago"><i class="fa fa-money fa-2x fa-fw" aria-hidden="true"></i> Medio de Pago</label>
										  <div>
										  	<select name="" onchange="seleccionaMediosPago(this)" class="form-control" id="medio-pago">
										  		
										  	</select>                     
										  </div>
										</div>
										<div style="display:none" id="contenedor-cuotas" class="form-group">
										  <label class="control-label" for="medio-pago"><i class="fa fa-credit-card-alt fa-2x fa-fw" aria-hidden="true"></i> Cuotas</label>
										  <div>
										  	<select name="" onchange="calculaImporteCheckout(this)" class="form-control" id="cuotas">
										  		
										  	</select>
										  </div>
										</div>										
									</div>
									<div class="col-md-6">
										<table class="table">
											<thead>
												<tr>
													<th></th>
													<th>Importe</th>
													<?php
														if (sesion()){
															if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
																?>
																	<th>IVA</th>
																<?php
															} 	
														} 
													 ?>													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><strong>Recargo Medio de Entrega</strong></td>
													<td id="recargomedioentrega"></td>
													<?php
														if (sesion()){
															if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
																?>
																	<td id="recargomedioentregaiva"></td>
																<?php
															} 	
														} 
													 ?>														
												</tr>
												<tr>
													<td><strong>Recargo Medio de Pago</strong></td>
													<td id="recargomediopago"></td>
													<?php
														if (sesion()){
															if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
																?>
																	<td id="recargomediopagoiva"></td>
																<?php
															} 	
														} 
													 ?>	
												</tr>
												<tr class="bg-gray-5 cl-color-3">
													<td><strong>Importe Final</strong></td>
													<td id="importefinal"></td>
													<?php
														if (sesion()){
															if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
																?>
																	<td id="importefinaliva"></td>
																<?php
															} 	
														} 
													 ?>	
												</tr>																								
											</tbody>
										</table>
									</div>
								</div>

								<?php 
									$detalleUsuario=retornarDetalleUsuario();
									$provinciasTodopago=retornarProvinciasTodopago();
								?>

								<div class="row" id="datos-todopago" style="margin-top:30px; display:none">
									<div class="col-md-6">
										<h3 class="titulo">Datos de Facturación</h3>									

										<div class="form-group">
										  <label class="control-label" for="CSBTEMAIL">Email</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["emailCli"] : "" ?>" class="form-control" id="CSBTEMAIL" required type="text">												                   
												<span class="help-block">Campo Requerido</span>  										  	
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSBTFIRSTNAME">Nombre</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["ApellidoNombre"] : "" ?>" class="form-control" id="CSBTFIRSTNAME" required type="text">												                   
												<span class="help-block">Campo Requerido</span>  										  											  
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSBTLASTNAME">Apellido</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["ApellidoNombre"] : "" ?>" class="form-control" id="CSBTLASTNAME" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSBTPHONENUMBER">Teléfono</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["Telefono"] : "" ?>" class="form-control" id="CSBTPHONENUMBER" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSBTPOSTALCODE">Código Postal</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["CodigoPostalCli"] : "" ?>" class="form-control" id="CSBTPOSTALCODE" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>	

										<div class="form-group">
										  <label class="control-label" for="CSBTSTATE">Provincia</label>
										  <div>
												<select class="form-control" id="CSBTSTATE" required>
													<?php 
														if ($provinciasTodopago["error"]===FALSE) {
															for ($i=0; $i < count($provinciasTodopago["exito"]) ; $i++) { 
																?>
																	<option value="<?php echo $provinciasTodopago["exito"][$i]["id"] ?>"><?php echo $provinciasTodopago["exito"][$i]["denominacion"] ?></option>
																<?php
															}
														}
													?>
												</select>
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSBTCITY">Ciudad</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["LocalidadCli"] : "" ?>" class="form-control" id="CSBTCITY" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>												

										<div class="form-group">
										  <label class="control-label" for="CSBTSTREET1">Domicilio</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["Direccion"] : "" ?>" class="form-control" id="CSBTSTREET1" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>													

									</div>
									<div class="col-md-6">
										<h3 class="titulo">Datos de Entrega</h3>

										<div class="form-group">
										  <label class="control-label" for="CSSTEMAIL">Email</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["emailCli"] : "" ?>" class="form-control" id="CSSTEMAIL" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSSTFIRSTNAME">Nombre</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["ApellidoNombre"] : "" ?>" class="form-control" id="CSSTFIRSTNAME" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSSTLASTNAME">Apellido</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["ApellidoNombre"] : "" ?>" class="form-control" id="CSSTLASTNAME" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSSTPHONENUMBER">Teléfono</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["Telefono"] : "" ?>" class="form-control" id="CSSTPHONENUMBER" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSSTPOSTALCODE">Código Postal</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["CodigoPostalCli"] : "" ?>" class="form-control" id="CSSTPOSTALCODE" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>	

										<div class="form-group">
										  <label class="control-label" for="CSSTSTATE">Provincia</label>
										  <div>
												<select class="form-control" id="CSSTSTATE" required>
													<?php 
														if ($provinciasTodopago["error"]===FALSE) {
															for ($i=0; $i < count($provinciasTodopago["exito"]) ; $i++) { 
																?>
																	<option value="<?php echo $provinciasTodopago["exito"][$i]["id"] ?>"><?php echo $provinciasTodopago["exito"][$i]["denominacion"] ?></option>
																<?php
															}
														}
													?>
												</select>
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

										<div class="form-group">
										  <label class="control-label" for="CSSTCITY">Ciudad</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["LocalidadCli"] : "" ?>" class="form-control" id="CSSTCITY" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>												

										<div class="form-group">
										  <label class="control-label" for="CSSTSTREET1">Domicilio</label>
										  <div>
												<input value="<?php echo $detalleUsuario["error"]===FALSE ? $detalleUsuario["exito"][0]["Direccion"] : "" ?>" class="form-control" id="CSSTSTREET1" required type="text">												                   
												<span class="help-block">Campo Requerido</span>
										  </div>
										</div>

									</div>
								</div>  								
 								  							
							<?php
						}
					?>

					<div class="row" style="margin-top:30px">
						<div class="col-md-6">
							<div class="form-group">
							  <label class="control-label" for="comentario">Comentario sobre el Pedido</label>
							  <div>                     
							    <textarea rows="5" class="form-control" id="comentario"></textarea>
							  </div>
							</div>														
						</div>
						<div class="col-md-6 text-right">
							<?php 
							if ($GLOBALS["configuracion"]["checkout"]===FALSE) {
							$medioenviodefault=retornarMedioEntregaDefault();
							?>
							<div class="form-group">
							  <label class="control-label" for="medioenvio">Medio de Envío</label>
							  <div>
							  	<input type="text" class="form-control" id="medioenvio" placeholder="Ingrese el medio por el cual se enviará su pedido" value="<?php echo $medioenviodefault["exito"]["RazonSocialFlete"] ?>">
							  </div>
							</div>
							<?php
							}else{
								?>
							  	<input type="hidden" id="medioenvio" value="">
								<?php								
							}
							?>

							<a style="margin-top:10px" class="text-center mayuscula btn btn-danger" href="productos.php?categoria=" >Agregar Más Productos</a>

							<a style="margin-top:10px;margin-left:10px" class="text-center mayuscula btn btn-danger" href="javascript:void(0)" onclick="confirmarPedido(this)" >Confirmar Pedido</a>
						</div>
					</div>                            

					<!-- Fin Carrito-->

				</div> 

				<!-- Panel Central -->   

			</div>
		</div>         

	</section>

	<?php 

}

?>