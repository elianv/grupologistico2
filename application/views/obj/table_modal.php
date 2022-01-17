<style type="text/css">
.modal.large {
    width: 70%; /* respsonsive width */
    margin-left:-30%; /* width/2) */ 
}
</style>
<div id="myModal_<?php echo $clase; ?>" class="modal hide fade large">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="modalHeader_<?php echo $clase; ?>"><?php echo $titulo; ?></h3>
    </div>
    
    <div class="modal-body" id="modalBody_<?php echo $clase; ?>">
        <div class=<?php echo "tabla-div-".$clase."\""; ?>">
            <table id=<?php echo "tabla-".$clase; ?> class="table table-bordered table-striped dataTable">

                <thead>
                <tr>
                    <?php 
                        foreach($titulos as $titulo) { 
                            echo "<th>".$titulo."</th>";
                        } 
                    ?> 
                </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>
        <br>
        
        <div id="detalle"></div>        
    </div>

    <div class="modal-footer" id="modalFooter_<?php echo $clase; ?>">
        
        <?php 
            if(isset($botones)){
                foreach ($botones as $boton) {  
                echo "<a class='btn btn-".$boton['tipo']."' id='".$boton['id']."'>".$boton['texto']."</a>";
            }
        } ?>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>

</div>