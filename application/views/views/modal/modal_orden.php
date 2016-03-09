<div id="modal-orden" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione Una Orden</center></h3>
     </div>

     <div class="modal-body">

         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-orden">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($ordenes as $orden){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$orden['id_orden'].">".$orden['id_orden']."</a></td>";
                                  echo "<td>".strtoupper($orden['razon_social'])."</td>";
                                  echo "<td>".$orden['fecha']."</td>";
                              }
                              ?>
                       </tbody>
         </table>    
         
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>

</div>

