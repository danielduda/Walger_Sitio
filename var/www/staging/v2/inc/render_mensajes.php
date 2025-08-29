<?php 

function renderMensajes(){
?>

<!-- Mensajes-->

<div class="spinner">
  <i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...
</div>          

<h3 class="bold titulo">Mensajes</h3>
<div class="row" style="margin-bottom: 15px;">
  <div class="col-xs-12">           
    <table id="mensajes" class="table">
      <thead>
        <tr>
          <th></th>
          <th>Fecha</th>
          <th>Mensaje</th>                   
        </tr>
      </thead>
      <tbody>
                                                                      
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mensaje</h4>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>                                    

<!-- Fin Mensajes--> 

<?php
}

 ?>