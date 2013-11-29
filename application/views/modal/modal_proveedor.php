<div id="modal-proveedor" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Proveedores</center></h3>
     </div>

     <div class="modal-body">
         <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-proveedor">
                      <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Razón Social</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($proveedores as $proveedor){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$proveedor['rut_proveedor'].">".$proveedor['rut_proveedor']."</a></td>";
                                  echo "<td>".strtoupper($proveedor['razon_social'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>

</div>
