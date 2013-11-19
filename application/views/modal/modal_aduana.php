<div id="modal-aduana" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione una A.A.</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <select multiple="multiple" id="multiselect"name="multiselect" style="width:500px" size="10">
             <?php 
             //echo $clientes;
                foreach($aduanas as $aduana){
                    echo "<option>[".$aduana['codigo_aduana']."] - ";
                    echo $aduana['nombre']."</option>"; 
                }
             ?>

         </select>
    </div>  
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>

