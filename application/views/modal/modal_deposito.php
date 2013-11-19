<div id="modal-deposito" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Depósitos</center></h3>
     </div>
    
     <div class="modal-body">
         
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($depositos as $deposito){
                                  echo "<tr>";
                                  if($deposito['codigo_deposito']<10){
                                      echo "<td><a class='codigo-click' data-codigo=".$deposito['codigo_deposito'].">0".$deposito['codigo_deposito']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$deposito['codigo_deposito'].">".$deposito['codigo_deposito']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($deposito['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    

         
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>

