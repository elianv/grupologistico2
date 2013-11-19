<div id="modal-puerto" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Puertos</center></h3>
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
                              foreach ($puertos as $puerto){
                                  echo "<tr>";
                                  if($puerto['codigo_puerto']<10){
                                      echo "<td><a class='codigo-click' data-codigo=".$puerto['codigo_puerto'].">0".$puerto['codigo_puerto']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$puerto['codigo_puerto'].">".$puerto['codigo_puerto']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($puerto['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table> 
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>