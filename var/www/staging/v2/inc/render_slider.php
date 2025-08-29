<?php 

function renderSlider(){

if ($GLOBALS["configuracion"]["slider"]["activo"]===TRUE) {
  

?>


       <section class="well3 center" style="height: <?php echo $GLOBALS["configuracion"]["slider"]["altura"] ?>  ">
          <div id="slider" >

            <?php

              $slider=retornarSlider();

              for ($i=0; $i < count($slider["exito"]) ; $i++) { 
                ?>  
                <!-- Slide -->

                <div data-src="<?php echo $GLOBALS["configuracion"]["carpetaimagenes"].$slider["exito"][$i]["imagen"] ?>">

                <!-- Slide Contenido-->

                <div class="parallax-slider" style="height: <?php echo $GLOBALS["configuracion"]["slider"]["altura"] ?>  ">

                  <div id="mainCaptionHolder">
                    <div class="" style="height: <?php echo $GLOBALS["configuracion"]["slider"]["altura"] ?>">
                      <div class="primaryCaption" style="transition: all 1.5s cubic-bezier(0.215, 0.61, 0.355, 1);">
                        <div class="slider_caption">
                          <?php
                            if ($slider["exito"][$i]["link"]!="") {
                              ?>
                              <a href="<?php echo $slider["exito"][$i]["link"] ?>"><?php echo $slider["exito"][$i]["contenido"] ?></a>
                              <?php
                            }else{
                              echo $slider["exito"][$i]["contenido"];
                            }
                          ?>
                          <em></em>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Fin Slide Contenido-->

                </div>

                <!-- Fin Slide -->
                <?php
               } 

             ?>


          </div>
        </section>

<?php
}

}

 ?>