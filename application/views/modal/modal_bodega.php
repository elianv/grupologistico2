<div id="modal-bodega" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Listado de Bodegas</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <select multiple="multiple" id="multiselect"name="multiselect" style="width:500px" size="10">
             <?php 
             //echo $clientes;
                foreach($bodegas as $bodega){
                    echo "<option>[".$bodega['codigo_bodega']."] - ";
                    echo $bodega['nombre']."</option>"; 
                }
             ?>

         </select>
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>
