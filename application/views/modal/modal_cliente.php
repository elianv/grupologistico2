<div id="modal-cliente" class="modal hide fade in" style="display: none;" >

    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione un Cliente</center></h3>
     </div>
   
     <div class="modal-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example-cliente">
            <thead>
              <tr>
                  <th>RUT</th>
                  <th>Razón Social</th>
              </tr>
            </thead>
            <tbody>
                    <?php
                    foreach ($clientes as $cliente){
                        echo "<tr>";
                        echo "<td><a class='codigo-click' data-codigo=".$cliente['rut_cliente'].">".strtoupper($cliente['rut_cliente'])."</a></td>";
                        echo "<td>".$cliente['razon_social']."</td>";
                    }
                    ?>
             </tbody>
        </table>
     </div>	 
	 
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
        
</div>