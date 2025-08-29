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

        <?php renderListaPrecios() ?>

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
  <script>
    $(document).ready(function(){
      listaprecios();
    })

  </script>
  <script type="text/javascript" src="js/tableExport/libs/FileSaver/FileSaver.min.js"></script>
  <script type="text/javascript" src="js/tableExport/libs/jsPDF/jspdf.min.js"></script>
  <script type="text/javascript" src="js/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript" src="js/tableExport/libs/html2canvas/html2canvas.min.js"></script>
  <script type="text/javascript" src="js/tableExport/tableExport.min.js?r=5"></script>  

</body>

</html>
