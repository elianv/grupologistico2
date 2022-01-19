<style type="text/css">
.modal.large {
    width: 50%; /* respsonsive width */
    margin-left:-30%; /* width/2) */ 
}
</style>
<div id="myModal_<?php echo $name; ?>"class="modal hide fade large">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="modalHeader_<?php echo $name; ?>"></h3>
    </div>
    
    <div class="modal-body" id="modalBody_<?php echo $name; ?>">
        
    </div>
    <div class="modal-footer" id="modalFooter_<?php echo $name; ?>">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
</div>