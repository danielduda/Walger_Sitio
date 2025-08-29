<?php 


function renderCategoriasMenu(){

  $categorias=retornarCategorias();

  $categoriasmenu="";

  for ($i=0; $i < count($categorias["exito"]); $i++) {
    $categoriasmenu.='<li><a href="categorias.php?categoria='.$categorias["exito"][$i]["id"].'">'.$categorias["exito"][$i]["denominacion"].'</a></li>';                                    
  }

  return $categoriasmenu;

}

?>