
<div id="modal" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione una Naviera</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <select multiple="multiple" id="multiselect"name="multiselect" style="width:500px" size="10">
             <?php 
             echo $navieras;
                foreach($navieras as $naviera){
                    echo "<option>[".$naviera['codigo_naviera']."] - ";
                    echo $naviera['nombre']."</option>"; 
                }
             ?>

         </select>
    </div>
    
    <div class="modal-footer">
        <input type="submit" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naves/seleccion_naviera'" class="btn btn-success" value="Aceptar">
        
    </div>
        </form>
</div>