<?php 

function renderNovedades(){
  if ($GLOBALS["configuracion"]["novedades"]===TRUE) {

	?>

        <section id="novedades" class="well3 center bg-gray-5">
          <div class="container">
            <div class="row">

            <?php

              $ultimasNovedades=retornarUltimasNovedades();

              if($ultimasNovedades["error"]==true){
                for ($i=0; $i < count($ultimasNovedades["errores"]["mensajeerror"]); $i++) { 
                  echo $ultimasNovedades["errores"]["mensajeerror"][$i]."<br>";
                }
              }else{
                for ($i=0; $i < count($ultimasNovedades["exito"]); $i++) {
                  ?>
                    <div class="col-md-6 novedades-contenedor">
                      <div class="novedades-inner">
                        <div class="col-md-12 col-sm-6 no-padding">
                          <div class="novedades-zoom">
                            <a class="cl-color-3" href="novedad.php?novedad=<?php echo $ultimasNovedades["exito"][$i]["id"] ?>"><i class="fa fa-4x fa-search-plus" aria-hidden="true"></i></a>
                          </div>
                          <div class="novedades-imagen" style="background-image:url('<?php echo $GLOBALS["configuracion"]["carpetaupload"].$ultimasNovedades["exito"][$i]["imagen"]?>')">

                          </div>
                        </div>
                        <div class="col-md-12 col-sm-6 no-padding novedades-descripcion flex">
                          <div class="col-xs-10 no-padding">
                            <h6 class="cl-color-1"><?php echo date('d-m-Y', strtotime(str_replace('-','/', $ultimasNovedades["exito"][$i]["fecha"])))  ?></h6>
                            <h2 class="novedades-titulo"><?php echo $ultimasNovedades["exito"][$i]["titulo"]?></h2>
                            <p class="cl-gray-2"><?php echo substr($ultimasNovedades["exito"][$i]["contenido"], 0, $GLOBALS["configuracion"]["paginanovedades"]["limiteCaracteresContenidoPrevio"])."..."?></p>
                          </div>
                          <div class="col-xs-2">
                            <a class="btn btn-danger novedades-btn" href="novedad.php?novedad=<?php echo $ultimasNovedades["exito"][$i]["id"] ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php                                   
                }
              };
             ?>
                          

            </div>            
          </div>            
        </section>

	<?php
  }

}

 ?>