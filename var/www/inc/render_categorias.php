<?php 

function renderCategorias(){
  if ($GLOBALS["configuracion"]["categorias"]===TRUE) {

  ?>
  
        <section id="categorias" class="well6 center">
          <div class="container">

            <?php

              $categorias=retornarCategorias();

              if($categorias["error"]==true){
                for ($i=0; $i < count($categorias["errores"]["mensajeerror"]); $i++) { 
                  echo $categorias["errores"]["mensajeerror"][$i]."<br>";
                }
              }else{
                if ($GLOBALS["configuracion"]["estilocategorias"]===1) {
                  for ($i=0; $i < count($categorias["exito"]); $i++) {
                    if ($i % 2==0) {
                      ?>
                        <div class="row">
                      <?php
                    }
                    ?>
                      <div class="col-md-6 categoria-contenedor">
                        <div class="categoria-inner">
                          <div class="col-md-6 categoria-descripcion">
                            <h1 class="cl-color-1 categoria-titulo2"><?php echo $categorias["exito"][$i]["denominacion"]?></h1>
                            <p class="categoria-detalle"><?php echo $categorias["exito"][$i]["descripcion"] ?></p>
                            <?php 
                              if ($GLOBALS["configuracion"]["categoriasinicio"]["accionboton"]=="modal") {
                                ?>
                                  <a class="btn btn-danger btn-lg" onclick="verCatalogo('<?php echo $categorias["exito"][$i]["denominacion"] ?>')" href="javascript:void(0)">Ver Catálogo</a>
                                <?php
                              }else{
                                ?>
                                  <a class="btn btn-danger btn-lg" href="productos.php?categoria=<?php echo $categorias["exito"][$i]["denominacion"]?>&favoritos=false">Ver Catálogo</a>
                                <?php                              
                              }
                            ?>
                          </div>
                          <div class="col-md-6">
                            <div class="categoria-imagen" style="background-image:url('<?php echo $GLOBALS["configuracion"]["carpetaupload"].$categorias["exito"][$i]["imagen"] ?>')">
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php 
                    if (($i+1) % 2==0) {
                      ?>
                        </div>
                      <?php
                    }                                   
                  }
                }else if($GLOBALS["configuracion"]["estilocategorias"]===2){
                  ?>
                  <div class="grid grid row">
                    <?php 
                      for ($i=0; $i < count($categorias["exito"]); $i++) {
                        ?>
                          <div class="element-item col-md-6 col-sm-12 col-xs-12 categoria-contenedor categorias-grandes">
                            <div class="categoria-inner">
                              <div class="categoria-descripcion">
                                <h1 class="cl-color-1 categoria-titulo2"><?php echo $categorias["exito"][$i]["denominacion"]?></h1>
                                <h3 class="categoria-detalle"><?php echo $categorias["exito"][$i]["descripcion"] ?></h3>                              
                              </div>
                              <?php 
                                if ($GLOBALS["configuracion"]["categoriasinicio"]["accionboton"]=="modal") {
                                  ?>
                                    <a onclick="verCatalogo('<?php echo $categorias["exito"][$i]["denominacion"] ?>')" href="javascript:void(0)">
                                      <img width="100%" src="<?php echo $GLOBALS["configuracion"]["carpetaupload"].$categorias["exito"][$i]["imagen"] ?>" alt="">
                                    </a>
                                  <?php
                                }else{
                                  ?>
                                    <a href="productos.php?categoria=<?php echo $categorias["exito"][$i]["denominacion"]?>&favoritos=false">
                                      <img width="100%" src="<?php echo $GLOBALS["configuracion"]["carpetaupload"].$categorias["exito"][$i]["imagen"] ?>" alt="">
                                    </a>
                                  <?php                              
                                }
                              ?>                              
                            </div>
                            
                          </div>
                        <?php
                      }
                    ?>
                  </div> 
                  <?php
                }
              };
             ?>

          </div>        
        </section>
  

  <?php
  }
}

 ?>