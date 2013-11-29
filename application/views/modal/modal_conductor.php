<div id="modal-conductor" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Conductores</center></h3>
     </div>
    
     <div class="modal-body">
       <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-conductor">
                      <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($conductores as $conductor){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$conductor['rut'].">".$conductor['rut']."</a></td>";
                                  echo "<td>".strtoupper($conductor['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
      </table>   
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        
</div>