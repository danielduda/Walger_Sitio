<?php 

function renderMiCuenta(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Mi cuenta</a>/Estado de cuenta</h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>


        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div id="" class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

          <!-- Estado de Cuenta-->

          <h3 class="titulo2">Estado de Cuenta</h3>

          <div class="spinner">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
          </div>                   

          <div class="row">
            <div style="overflow:auto" class="col-md-12 contenedor">
              <table id="estado-cuenta" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Vto.</th>
                    <th>Emisión</th>
                    <th>Días</th>
                    <th>Div.</th>
                    <th>Comprobante</th>
                    <th>Mda.</th>
                    <th>Pendiente</th>
                    <th>Acumulado</th>
                  </tr>
                </thead>
                <tbody>
                                         
                </tbody>
              </table>
            </div>
          </div>

          <div id="estado-cuenta-pago" class="row">
            <div class="col-md-12 contenedor">
              <div class="inner">
                <div class="row">
                  <div class="col-md-6">

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="control-label" for="monto-seleccionado">Monto Seleccionado</label>  
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input disabled read-only id="monto-seleccionado" type="number" class="form-control input-md" value="0">
                      </div>                          
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="control-label" for="monto-abonar">Monto total a abonar</label>
                      <div class="input-group">
                        <span class="input-group-addon"> $ </span>
                        <input oninput="calculaImporteFinal()" onchange="calculaImporteFinal()" required min="0" placeholder="Ingrese el monto deseado" id="monto-abonar" type="number" class="form-control input-md" value="0">
                      </div>                            
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                      <label class="control-label" for="medios-pagos">Medio de Pago</label>
                      <div class="">
                        <select onchange="recargoMedioPago(this)" data-elemento-dependiente="true" id="medios-pagos" class="form-control">
                          <option value="0">Seleccione ...</option>
                          <?php 

                            $mediospagos=retornarMediosPagoCC();

                            foreach ($mediospagos["exito"] as $key => $value) {
                              ?>
                                <option value="<?php echo $value["id"] ?>"><?php echo $value["denominacion"] ?></option>
                              <?php
                            }

                          ?>
                        </select>
                      </div>
                    </div>




                  </div>
                  <div class="col-md-6">

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":true,"2":false,"3":false, "4":false}'>
                      <label class="control-label" for="fecha-hora-deposito">Fecha y hora de depósito</label>
                      <input placeholder="Fecha y hora de depósito" id="fecha-hora-deposito" type="datetime-local" class="form-control input-md" value="">
                    </div>
                                                                                       
                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":true,"2":false,"3":false, "4":false}'>
                      <label class="control-label" for="banco">Banco</label>
                      <input placeholder="Banco" id="banco" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":true,"2":false,"3":false, "4":false}'>
                      <label class="control-label" for="numero-comprobante">Número de comprobante</label>
                      <input placeholder="Número de comprobante" id="numero-comprobante" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":true,"3":true, "4":false}'>
                      <label class="control-label" for="fecha-deposito">Fecha</label>
                      <input placeholder="Fecha" id="fecha-deposito" type="date" class="form-control input-md" value="">
                    </div>
                                                                                       
                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":true,"3":false, "4":false}'>
                      <label class="control-label" for="empresa-correo">Empresa de correo</label>
                      <input placeholder="Empresa de correo" id="empresa-correo" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":true,"3":false, "4":false}'>
                      <label class="control-label" for="numero-oblea">Número de oblea</label>
                      <input placeholder="Número de oblea" id="numero-oblea" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":false,"3":true, "4":false}'>
                      <label class="control-label" for="nombre-transporte">Nombre del transporte</label>
                      <input placeholder="Nombre del transporte" id="nombre-transporte" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":false,"3":true, "4":false}'>
                      <label class="control-label" for="numero-guia">Número de guía</label>
                      <input placeholder="Número de guía" id="numero-guia" type="text" class="form-control input-md" value="">
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":false,"3":false,"4":true}'>
                      <label class="control-label" for="recargo-medio-pago">Recargo por Medio de Pago</label>
                      <div class="input-group">
                        <span class="input-group-addon"> % </span>
                        <input disabled read-only min="0" placeholder="Recargo por Medio de Pago" id="recargo-medio-pago" type="number" class="form-control input-md" value="0">
                      </div>
                    </div>                     

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":false,"3":false,"4":true}'>
                      <label class="control-label" for="importe-final">Importe Final</label>
                      <div class="input-group">
                        <span class="input-group-addon"> $ </span>
                        <input disabled read-only min="0" placeholder="Importe Final" id="importe-final" type="number" class="form-control input-md" value="0">
                      </div>
                    </div>

                    <!-- file input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":true,"2":false,"3":false,"4":false}'>
                      <label class="control-label" for="prependedtext">Archivo </label>
                      <div>
                        <span class="btn btn-primary fileinput-button" data-orden="1">
                      <span>Seleccionar Archivo</span>
                      <input id="fileupload1" type="file" name="files[]" >
                      </span>
                      <div style="margin-top:10px" id="progress1" class="progress">
                      <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <div id="files1" class="files">
                      
                      </div>
                      <div id="alert1" class="alert alert-danger" style="display:none;">
                      <p id="mensaje-error1"></p>
                      </div>
                      </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group" data-dependiente="medios-pagos" data-visible='{"0":false,"1":false,"2":false,"3":false,"4":false,"5":true}'>
                      <label class="control-label">Escanee el QR para abonar mediante MercadoPago</label>
                      <div>
                        <img src="img/<?php echo $GLOBALS["configuracion"]["imagenqrmercadopago"] ?>" width="100%" alt="">
                      </div>
                    </div>                                                            

                    <!-- Textarea-->
                    <div class="form-group">
                      <label class="control-label" for="comentarios">Comentarios</label>  
                      <div class="">
                        <textarea class="form-control" id="comentarios" name="textarea"></textarea>
                        <span class="help-block">Indique su Comentario</span>
                      </div>
                    </div>

                    <button type="submit" onclick="enviarformulario(this)" data-formulario="estado-cuenta-pago" class="btn btn-primary form-submit">Enviar</button>                

                  </div>
                </div>
              </div>
            </div>
          </div> 

          <?php renderFormasPago() ?>                                      

          <!-- Fin Estado de Cuenta-->

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

