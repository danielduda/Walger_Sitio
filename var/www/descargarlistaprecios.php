<?php

header ( "Content-type: application/vnd.ms-excel" );
header ( "Content-Disposition: attachment; filename=descargarlistaprecios.xls" );

include_once("inc/inc.php");

$listaprecios=retornarListaPrecios();

$logo='<img src="'.$GLOBALS["configuracion"]["carpetauploadremoto"].$GLOBALS["configuracion"]["brand"]["logo"].'" aria-hidden="true" width="200" alt="alt_text" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 50px;">';


ob_start()

  ?>

  <html lang="es">

  <head>

  </head>

  <body>
    <table>
      <tbody>
        <tr>
          <td rowspan="6" colspan="3"><?php echo $logo ?></td>
          <td></td>
          <td colspan="3"><h3><?php echo $GLOBALS["configuracion"]["metas"]["title"] ?> LISTA DE PRECIOS</h3></td>
          <td></td>
          <td colspan="2">Vigencia: <?php echo date("d/m/Y") ?></td>
        </tr>
      </tbody>
    </table>

    <table border="1">
      <thead>
        <tr>
          <th>C&oacute;digo</th>
          <th>Referencia</th>
          <th>Categor&iacute;a</th>
          <th>L&iacute;nea</th>
          <th>Marca</th>
          <th>Descripci&oacute;n</th>
          <th>Moneda</th>
          <th>Precio</th>
          <?php 
            if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
              ?>
                <th>IVA</th>
                <th>Porcentaje IVA</th>
              <?php
            }
          ?>                        
        </tr>
      </thead>
      <tbody>
        <?php 
          for ($i=0; $i < count($listaprecios["exito"]); $i++) { 
            ?>
            <tr>
              <td><?php echo $listaprecios["exito"][$i]["CodInternoArti"] ?></td>
              <td><?php echo $listaprecios["exito"][$i]["CodBarraArti"] ?></td>
              <td><?php echo $listaprecios["exito"][$i]["DescrNivelInt4"] ?></td>
              <td><?php echo $listaprecios["exito"][$i]["DescrNivelInt3"] ?></td>
              <td><?php echo $listaprecios["exito"][$i]["DescrNivelInt2"] ?></td>
              <td><?php echo $listaprecios["exito"][$i]["DescripcionArti"] ?></td>
              <td><?php echo $_SESSION["Signo_Mda"] ?></td>              
              <td><?php echo number_format((float)$listaprecios["exito"][$i]["PrecioVta1_PreArti"], $GLOBALS["configuracion"]["precios"]["cantidaddecimales"], $GLOBALS["configuracion"]["precios"]["separadordecimales"], $GLOBALS["configuracion"]["precios"]["separadormiles"]) ?></td>
              <?php 
                if ($_SESSION["CalculaIvaC"]==1 && $_SESSION["DiscriminaIvaC"]==1) {
                  ?>
                    <td><?php echo number_format((float)$listaprecios["exito"][$i]["importeIva"], $GLOBALS["configuracion"]["precios"]["cantidaddecimales"], $GLOBALS["configuracion"]["precios"]["separadordecimales"], $GLOBALS["configuracion"]["precios"]["separadormiles"]) ?></td>
                    <td><?php echo "% ".$listaprecios["exito"][$i]["TasaIva"] ?></td>                    
                  <?php
                }
              ?>              
            </tr>
            <?php
          }
         ?>                                                              
      </tbody>
    </table>

  </body>

  </html>

  <?php 

ob_flush();
   ?>



