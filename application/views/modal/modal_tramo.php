<div id="modal-tramo" class="modal hide fade in" style="display: none;" >
    
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione un Tramo</center></h3>
     </div>

     <div class="modal-body">
              <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-tramo">
                      <thead>
                        <tr>
                            <th>Código Tramo</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tramos as $tramo){
                                  echo "<tr>";
                                  if($tramo['codigo_tramo']< 10){
                                    echo "<td><a class='codigo-click' data-codigo=".$tramo['codigo_tramo'].">".$tramo['codigo_tramo']."</td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tramo['codigo_tramo']."> ".$tramo['codigo_tramo']."</td>";
                                  }
                                  echo "<td>".strtoupper($tramo['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>
