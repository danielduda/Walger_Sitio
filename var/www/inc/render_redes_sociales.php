<?php 

function renderRedesSociales(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Redes Sociales</a></h5>
          <hr>

          <!-- Fin Breadcrumb -->

        </div>

        <!-- Fin Encabezado Página -->

        <!-- Menú Lateral -->

        <?php renderMenuLateral() ?>

        <!-- Fin Menú Lateral -->

        <!-- Panel Central -->

        <!-- Novedad-->
        
        <div class="<?php echo $GLOBALS["configuracion"]["menulateral"]?"col-lg-9 col-md-9 col-sm-8":"" ?> col-xs-12">

          <h3 class="bold titulo">Instagram</h3>

          <div class="row" id="">  
            
            <div class="col-xs-12 no-padding" id="instagram">
            </div>

          </div>


          <div class="row" id="">
            
            <div class="col-md-6" id="facebook">

            <h3 class="bold titulo">Facebook</h3>

                <?php facebookPluginPaginas() ?>

            </div>
            <div class="col-md-6">

              <?php
                if ($GLOBALS["configuracion"]["redessociales"]["botonesfacebook"]===TRUE) {
                  facebookMeGusta();                          
                  facebookSeguir();
                  facebookCompartir();
                  facebookEnviar(); 
                }

              ?>
      

            </div>

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

