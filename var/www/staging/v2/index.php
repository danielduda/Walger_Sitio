<?php
include_once("inc/inc.php");
include_once("api/consultas.php"); 

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
  <?php facebookMetas() ?>  
</head>

<body>
  <?php include_once("inc/analyticstracking.php") ?>

  <header>

  <?php renderHeader() ?>

  </header>

  <!-- Contenido Móvil -->

  <div class="container-fluid">
    <div class="row">
      <main>

        <!-- Slide -->
    
        <?php renderSlider() ?>

        <!-- Fin Slide-->

        <!-- Categorías-->

        <?php renderCategorias() ?>

        <!-- Fin Categorías-->
        
        <!-- Destacados-->
        <div class="container">
          <?php
            if ($GLOBALS["configuracion"]["productosnovedades"]===TRUE) {
              renderDestacados("novedades");
            }          
            if ($GLOBALS["configuracion"]["destacados"]===TRUE) {
              renderDestacados("ofertas");
            }
          ?>
        </div>


        <!--Fin Destacados-->

        <!-- Novedades-->

        <?php renderNovedades() ?>

        <!-- Fin Novedades-->

        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter--> 

      </main>          
    </div>
  </div>

  <!-- Fin Contenido Móvil-->

  <!-- Modal Subcategorías-->

  <?php renderSubcategorias() ?>

  <!-- Fin Modal Subcategorías-->

  <!-- Scripts-->

  <?php renderScripts() ?>

  <script>

  /* Inicio Camera
  =============================================*/
  $(document).ready(function(){
      
      $('#slider').camera({
          height: '<?php echo $GLOBALS["configuracion"]["slider"]["altura"] ?>',
          pagination: false
      });

      var elementos=['.categoria-titulo1','.categoria-titulo2','.categoria-detalle','.novedades-titulo','.destacados-descripcion p', '.destacados-contenedor'];
      igualarAlto(elementos);

      $(".grid").show();
      var $grid = $('.grid').isotope({
        itemSelector: '.element-item'
      });      
      
  }) 

$( window ).resize(function() {

  var elementos=['.categoria-titulo1','.categoria-titulo2','.categoria-detalle','.novedades-titulo','.destacados-descripcion p', '.destacados-contenedor'];
  igualarAlto(elementos);

  $(".grid").show();
  var $grid = $('.grid').isotope({
    itemSelector: '.element-item'
  });  

});   

  </script>

  <!-- Fin Scripts--> 


</body>

</html>
