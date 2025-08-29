<?php 

function renderContactos(){

  foreach ($GLOBALS["configuracion"]["contactos"] as $key => $value) {
  ?>                        
    <div class="col-md-1 contactos-iconos">
      <i class="cl-color-1 fa-2x fa <?php echo $value["icono"] ?>" aria-hidden="true"></i>
    </div>
    <div class="col-md-11">
      <h5 class="mayuscula"><?php echo $value["denominacion"] ?></h5>
      <?php if (isset($value["link"])) {
        ?>
        <a href="<?php echo $value["link"] ?>">
          <<?php echo $value["etiqueta"] ?> class="<?php echo $value["clases"] ?>"><?php echo $value["valor"] ?></<?php echo $value["etiqueta"] ?>>
        </a>
        <?php 
      }else{
        ?>
        <<?php echo $value["etiqueta"] ?> class="<?php echo $value["clases"] ?>"><?php echo $value["valor"] ?></<?php echo $value["etiqueta"] ?>>
        <?php
      }
      ?> 
    </div>
  <?php
  }
  
}

 ?>