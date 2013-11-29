<div id="modal-nave" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Naves</center></h3>
     </div>
    
     <div class="modal-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-nave">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre Nave</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($naves as $nave){
                                  echo "<tr>";
                                  if($nave['codigo_nave'] < 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$nave['codigo_nave'].">0".$nave['codigo_nave']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo='codigo_nave'>".$nave['codigo_nave']."</a></td>";
                                  }
                                  
                                  echo "<td>".strtoupper($nave['nombre'])."</td>";
                                  echo "</tr>";
                              }
                              ?>
                       </tbody>
                  </table>    
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>
