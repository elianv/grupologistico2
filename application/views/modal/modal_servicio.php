<div id="modal-servicio" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Otros Servicios</center></h3>
     </div>

     <div class="modal-body">
         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-servicio">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($servicios as $servicio){
                                  echo "<tr>";
                                  if($servicio['codigo_servicio']< 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$servicio['codigo_servicio'].">0".$servicio['codigo_servicio']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$servicio['codigo_servicio'].">".$servicio['codigo_servicio']."</a></td>";
                                  }
                                  
                                  echo "<td>".strtoupper($servicio['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>