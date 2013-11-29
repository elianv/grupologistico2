<div id="modal-carga" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione un Tipo de Carga</center></h3>
     </div>

     <div class="modal-body">

         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-carga">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($cargas as $carga){
                                  echo "<tr>";
                                  if($carga['codigo_carga']< 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$carga['codigo_carga'].">0".$carga['codigo_carga']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$carga['codigo_carga'].">".$carga['codigo_carga']."</a></td>";
                                  }
                                  
                                  echo "<td>".strtoupper($carga['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
         </table>    
         
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>


