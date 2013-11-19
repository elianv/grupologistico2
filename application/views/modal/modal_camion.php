<div id="modal-camion" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Camiones</center></h3>
     </div>
    
     <div class="modal-body">
         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Patente</th>
                            <th>Celular</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($camiones as $camion){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".strtoupper($camion['patente']).">".strtoupper($camion['patente'])."</a></td>";
                                  echo "<td>".$camion['celular']."</td>";
                              }
                              ?>
                       </tbody>
        </table>    
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>