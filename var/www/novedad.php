<?php include_once("inc/inc.php") ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php renderHead() ?>

  <?php 

    $novedad=retornarNovedad();
    facebookMetasArticle($novedad["exito"][0]["titulo"], $novedad["exito"][0]["contenido"], $novedad["exito"][0]["imagen"]);  

  ?>
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

        <!-- Servicios -->

        <?php renderNovedad() ?>

        <!-- Fin Servicios -->

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



  $(document).ready(function(){
    retornarNovedades();
  })

  </script>  


</body>

</html>
