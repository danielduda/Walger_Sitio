<?php 

function renderFooter(){

renderOlvideContrasena();

renderModalMensajes();
?>


        <footer class="bg-gray-1">
          <div id="contenedor-contactos">
            <div class="container">
              <div class="row">

                <!-- Datos Contacto-->

                <div class="col-md-6 ">
                  <div class="row">
                    <div class="col-xs-12">
                      <div id="contactos">
                        <h3 class="bold mayuscula">Contacto</h3>
                        <?php 

                          renderContactos();

                         ?>        
                      </div>
                    </div>
                  </div>

                  <?php 

                    if ($GLOBALS["configuracion"]["newsletter"]===TRUE) {
                      ?>
                        <div class="row">
                          <div class="col-xs-12">
                            <div id="newsletter-container">
                              <h3 class="bold mayuscula">Newsletter</h3>
                              <div class="form-group">
                                <div class="input-group">
                                  <input id="newsletter" name="newsletter" class="form-control" placeholder="Ingrese su correo" type="text">
                                  <span class="input-group-addon"><button onclick="suscribirsenewsletter(this)" class="btn btn-danger">Suscribirse</button></span>
                                </div>
                              </div>                                               
                            </div>
                          </div>  
                        </div>
                      <?php
                    }


                   ?>

                </div>

                <!-- Fin Datos Contacto-->

                <?php 

                  if ($GLOBALS["configuracion"]["mapa"]["activo"]===TRUE) {
                    ?>                
                    <!-- Mapa-->

                    <div class="col-md-6 text-center">
                      <iframe src="<?php echo $GLOBALS["configuracion"]["mapa"]["src"] ?>" width="100%" height="<?php echo $GLOBALS["configuracion"]["mapa"]["altura"] ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>

                    <!-- Fin Mapa-->
                    <?php
                  }

                 ?>


              </div>
            </div>
            
          </div>
          <div id="pie">
            <div class="container">
              <div class="row">
                <div class="col-xs-6">
                  <a href="sitemap.php"><i class="fa fa-sitemap" aria-hidden="true"></i> Mapa del Sitio</a></br>
                  <a target="_blank" href="https://www.argentina.gob.ar/produccion/defensadelconsumidor/formulario">Defensa de las y los Consumidores. Para reclamos Ingrese aquí</a>
                </div>
                <div class="col-xs-6 text-right">
                  <a target="blank" href="http://trama.solutions/">
                    <img width="30px" src="img/iso.png" alt="">
                    <h6 style="display:inline-block">Desarrolado por Trama.Solutions </h6>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </footer>


<?php

}

 ?>