<?php 

function renderOlvideContrasena(){

?>

  <div id="olvide-contrasena" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Olvidé mi Contraseña</h4>
        </div>
        <div class="modal-body">
          <h6>Si olvidó su contraseña, ingrese su Email en la siguiente casilla y haga click en "Restaurar Contraseña" y se le enviará una nueva contraseña a su casilla</h6>
          <input id="olvide-contrasena-email" type="email" class="form-control" placeholder="Ingrese su Email">
        </div>
        <div class="modal-footer">
          <form action="" class="form-inline">
            <a onclick="restaurarContrasena(this)" class="btn btn-danger" type="button"><i class="fa fa-fw fa-key" aria-hidden="true"></i> Restaurar Contraseña</a>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php

}


function renderModalMensajes(){

?>

  <div id="modal-mensajes" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 id="modal-mensaje-texto"></h4>
        </div>
      </div>
    </div>
  </div>

<?php

}

 ?>