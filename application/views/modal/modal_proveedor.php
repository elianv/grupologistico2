<div id="modal-proveedor" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Proveedores</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <select multiple="multiple" id="multiselect"name="multiselect" style="width:500px" size="10">
             <?php 
             //echo $clientes;
                foreach($proveedores as $proveedor){
                    echo "<option>[".$proveedor['rut_proveedor']."] - ";
                    echo $proveedor['razon_social']."</option>"; 
                }
             ?>

         </select>
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>
