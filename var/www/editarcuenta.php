
<?php

include_once("inc/inc.php");

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

        <!-- Mi Cuenta -->

        <?php renderEditarCuenta() ?>

        <!-- Fin Mi Cuenta -->

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
  


</body>

</html>
