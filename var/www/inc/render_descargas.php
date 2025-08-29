<?php 

include_once("api/consultas.php");

function renderDescargas(){

  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Descargas</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

          <!-- Estado de Cuenta-->


          <div class="row">




            <div class="col-md-12">
              <ul class="fa-ul">
                <h3 class="bold titulo">Descargas</h3>

                <?php

                  $descargas=retornarDescargas();

                  if ($GLOBALS["configuracion"]["descargarlistadeprecios"]===TRUE) {
                    ?>
                      <li>
                        <a href="descargarlistaprecios.php">
                          <i class="fa fa-download" aria-hidden="true"></i> 
                          <span class="descargas-tamanoarchivo">
                            ---
                          </span> 
                          <span class="descargas-tipoarchivo">
                            xls
                          </span> 
                          <span class="descargas-nombrearchivo">
                            Lista Completa de Precios
                          </span>
                        </a>
                      </li>
                    <?php                     
                  }

                  if($descargas["error"]==true){
                    for ($i=0; $i < count($descargas["errores"]["mensajeerror"]); $i++) { 
                      echo $descargas["errores"]["mensajeerror"][$i]."<br>";
                    }
                  }else{
                    for ($i=0; $i < count($descargas["exito"]); $i++) {
                      ?>
                        <li>
                          <a href="<?php echo $GLOBALS["configuracion"]["carpetadescargas"].$descargas["exito"][$i]["nombreArchivo"]?>">
                            <i class="fa fa-download" aria-hidden="true"></i> 
                            <span class="descargas-tamanoarchivo">
                              <?php echo $descargas["exito"][$i]["tamanoArchivo"] ?>
                            </span> 
                            <span class="descargas-tipoarchivo">
                              <?php echo $descargas["exito"][$i]["tipoArchivo"] ?>
                            </span> 
                            <span class="descargas-nombrearchivo">
                              <?php echo $descargas["exito"][$i]["descripcion"] ?>
                            </span>
                          </a>
                        </li>
                      <?php                                   
                    }
                  };
                 ?>
              </ul>
            </div>
          </div>                                       

          <!-- Fin Estado de Cuenta-->

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

