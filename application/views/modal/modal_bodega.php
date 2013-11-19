<div id="modal-bodega" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Bodegas</center></h3>
     </div>
    
     <div class="modal-body">
         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($bodegas as $bodega){
                                  echo "<tr>";
                                  if($bodega['codigo_bodega']< 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$bodega['codigo_bodega'].">0".$bodega['codigo_bodega']."</a></td>";
                                  }
                                  else
                                  {
                                      echo "<td><a class='codigo-click' data-codigo=".$bodega['codigo_bodega'].">".$bodega['codigo_bodega']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($bodega['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>
