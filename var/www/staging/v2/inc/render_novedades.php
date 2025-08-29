<?php 

function renderPaginaNovedades(){
  ?>

  <section>

    <div class="container">
      <div class="row">          

        <!-- Encabezado Página -->

        <div class="col-xs-12">
          
          <!-- Breadcrumb -->

          <hr>
          <h5><a href="">Novedades</a></h5>
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

          <h3 class="bold titulo">Novedades</h3>

          <div id="paginanovedades">
            
          </div>

          <div id="preloader" class="row">
            <div class="col-md-12">
              <div class="preloader-titulo breath"></div>
              <div class="preloader-imagen breath"></div>
              <div class="preloader-parrafo breath"></div>
              <div class="preloader-boton breath"></div>
            </div>
          </div>

          <div class="cargarmas col-xs-12">
            <a class="btn btn-danger btn-lg" href="javascript:void(0)" onclick="retornarNovedades(this)">Cargar Más</a>
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

