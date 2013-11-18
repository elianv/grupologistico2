<div id="modal-carga" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione un Tipo de Carga</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <select multiple="multiple" id="multiselect"name="multiselect" style="width:500px" size="10">
             <?php 
             //echo $clientes;
                foreach($cargas as $carga){
                    echo "<option>[".$carga['codigo_carga']."] - ";
                    echo $carga['descripcion']."</option>"; 
                }
             ?>

         </select>
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>


