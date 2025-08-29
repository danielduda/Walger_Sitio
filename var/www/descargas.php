<?php include_once("inc/inc.php") ?>

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

        <!-- Descargas -->

        <?php renderDescargas() ?>

        <!-- Fin Descargas -->

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
