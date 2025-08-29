<?php 

function renderPortfolio(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href=""><?php echo $GLOBALS["configuracion"]["textos"]["tituloportfolio"] ?></a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <!-- Novedad-->
        
        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?>col-xs-12">
          <input type="hidden" id="novedadesoffset" value="0">

          <h3 class="bold titulo"><?php echo $GLOBALS["configuracion"]["textos"]["tituloportfolio"] ?></h3>

          <div id="paginaportfolio">

            <?php 


            if ($GLOBALS["configuracion"]["portfolio"]==1) {
              
              $categoriasPortfolio=retornarCategoriasPortfolio();
              
              ?>
                <div id="filters" class="button-group">
                  <button class="btn btn-primary is-checked" data-filter="*">Mostrar Todos</button>

                  <?php

                  if (count($categoriasPortfolio["exito"]) > 0) {
                    for ($i=0; $i < count($categoriasPortfolio["exito"]); $i++) { 
                      ?>
                        <button class="btn btn-primary" data-filter=".categoria<?php echo $categoriasPortfolio["exito"][$i]["id"] ?>"><?php echo $categoriasPortfolio["exito"][$i]["denominacion"] ?></button>
                      <?php
                    }
                  }

                  ?>
                </div>

                <div id="preloader" class="row">
                  <div class="col-md-12">
                    <div class="preloader-titulo breath"></div>
                    <div class="preloader-imagen breath"></div>
                    <div class="preloader-parrafo breath"></div>
                    <div class="preloader-boton breath"></div>
                  </div>
                </div>             

                <div class="grid row">

                </div>

              <?php              
            }else if($GLOBALS["configuracion"]["portfolio"]==2){

              $portfolio=retornarPorfolioCompleto();

              foreach ($portfolio["exito"] as $key => $value) {
                ?>
                  <div class="row">
                    <div class="col-md-6">
                      <h3 class="titulo2 portfolio2-categoria"><?php echo $value[0]["categoria"] ?></h3>
                      <ul class="fa-ul">
                        <?php 
                          for ($i=0; $i < count($value); $i++) { 
                            ?>
                              <li>
                                <i class="fa fa-check cl-color-1" aria-hidden="true"></i>
                                <?php
                                  if ($value[$i]["contenido"]=="" && $value[$i]["imagen"]=="") {
                                    ?>
                                    <span style="margin-left:10px"><?php echo $value[$i]["denominacion"]; ?></span>
                                    <?php
                                    
                                  }else{
                                    ?>
                                    <a href="obra.php?obra=<?php echo $value[$i]["id"] ?>"><?php echo $value[$i]["denominacion"] ?></a>
                                    <?php
                                  }
                                ?>
                              </li>
                            <?php
                          }
                        ?>                        
                      </ul>
                    </div>
                    
                    <div class="col-md-6">
                    <?php
                      $contenidocamera='';
                      for ($i=0; $i < count($value); $i++) { 
                        if ($value[$i]["imagen"]!="") { 
                          $contenidocamera.='<div data-src="'.$GLOBALS["configuracion"]["carpetaupload"].$value[$i]["imagen"].'"></div>';
                        }
                      }
                      if ($contenidocamera!='') {
                        ?>
                        <div class="camera_wrap" style="margin-top:15px">
                        <?php
                        echo $contenidocamera;
                        ?>
                        </div>
                        <?php
                      }
                    ?>
                    </div>
                  </div>
                <?php
              }

              ?>
              <?php
            }
            ?>


          </div>

          <!-- Fin Novedad-->

        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

