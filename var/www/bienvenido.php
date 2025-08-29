<?php include_once("inc/inc.php") ?>

<?php 
if (sesion()!=true) {
  header("Location: ./index.php");
  exit(); 
}
 ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
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

        <!-- Bienvenido -->

        <?php renderBienvenido() ?>

        <!-- Fin Bienvenido -->

        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter-->         

      </main> 
    </div>
  </div>

  <!-- Fin Contenido Móvil-->


  <!-- Scripts-->

  <?php renderScripts() ?>

  <!-- Fin Scripts--> 

  <script>

  /* Inicio Camera
  =============================================*/
  $(document).ready(function(){
      
      var elementos=['.categoria-titulo1','.categoria-titulo2','.categoria-detalle','.novedades-titulo','.destacados-descripcion p'];
      igualarAlto(elementos);
      listarMensajes()
      
  }) 

$( window ).resize(function() {

  var elementos=['.categoria-titulo1','.categoria-titulo2','.categoria-detalle','.novedades-titulo','.destacados-descripcion p'];
  igualarAlto(elementos);


});   

  </script>

</body>

</html>
