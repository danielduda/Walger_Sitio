<?php
include_once("inc/inc.php");

if (sesion()!=true && $GLOBALS["configuracion"]["permiteinvitado"]==FALSE){ 
  if (!isset($_GET["favoritos"]) || $_GET["favoritos"]=="true" ) {
    header("Location: ./productos.php?categoria=&favoritos=false");
    exit(); 
  }
} 

?>



<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>
  <?php facebookMetas() ?>  
</head>

<body>
  <?php include_once("inc/analyticstracking.php") ?>
  
  <?php sdkfacebook(); ?>  
  
  <header>

  <?php renderHeader() ?>

  </header>

  <!-- Contenido Móvil -->

  <div class="container-fluid">
    <div class="row">
      <main>

        <!-- Productos -->

        <?php renderProductos() ?>

        <!-- Fin Productos -->

        <!-- Footer--> 

        <?php renderFooter() ?>

        <!-- FinFooter-->         

      </main> 
    </div>
  </div>

  <!-- Fin Contenido Móvil-->


  <!-- Modal Producto-->

  <?php renderDetalleProducto() ?>

  <!-- Fin Modal Producto-->

  <!-- Scripts-->

  <?php renderScripts() ?>

  <script>
    filtrarProductos(this);
  </script>

  <!-- Fin Scripts-->  


</body>

</html>
