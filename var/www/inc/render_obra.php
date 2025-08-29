<?php 

function renderObra(){

  $obra=retornarObra();

  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="portfolio.php"><?php echo $GLOBALS["configuracion"]["textos"]["tituloportfolio"] ?></a> / <?php echo $obra["exito"][0]["denominacion"] ?></h5>
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

          <h3 class="bold titulo"><?php echo $GLOBALS["configuracion"]["textos"]["tituloportfolio"] ?></h3>

            <div class="row novedad">
            <div class="col-md-12">
            <h3 class="bold mayuscula titulo2"><?php echo $obra["exito"][0]["denominacion"] ?></h3>
            <?php 
            if ($obra["exito"][0]["imagen"]!="") {
              ?>
                <img src="<?php echo $GLOBALS["configuracion"]["carpetaupload"].$obra["exito"][0]["imagen"] ?>" alt="">
              <?php
            }
            ?>
            <div><?php echo $obra["exito"][0]["contenido"] ?></div>
            </div>
            </div>         

          <!-- Fin Novedad-->
              <?php
                if ($GLOBALS["configuracion"]["redessociales"]["botonesfacebook"]===TRUE) {
                  facebookMeGusta();                          
                  facebookSeguir();
                  facebookCompartir();
                  facebookEnviar(); 
                }

              ?>  
        </div> 

        <!-- Panel Central -->

      </div> 
    </div>             

  </section>

  <?php
}

?>

