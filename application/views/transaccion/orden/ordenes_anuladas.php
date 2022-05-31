
<div class="container">
    <?php $correcto = $this->session->flashdata('mensaje'); ?>
    <?php if($correcto){ ?>
        <div class='alert alert alert-error' align=center>
            <a class='close' data-dismiss='alert'>×</a>
            <?php echo $correcto; ?>
        </div>
    <?php } ?>

    <?php if(validation_errors()){ ?>
        <div class='alert alert alert-info' align=center>
            <a class='close' data-dismiss='alert'>×</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>    
</div>

<legend><center><h3>Ordenes Anuladas</h3></center></legend>
<div class="container">
    
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"><?php echo $dt['table']; ?></div>
        <div class="col-md-2"></div>
    </div>
    <div></div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="form-anular" style="display: none;">
            <legend></legend>
            
            <form class="form-horizontal" id="anular_form" name="anular_form" method="post">
                
                <div class="control-group">
                    <label class="control-label" ><strong>N°</strong></label>
                    <div class="controls">
                        <input type="text" id="id_os" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"><strong>Observación</strong></label>
                    <div class="controls">
                        <textarea class="input-xxlarge" type="textarea" rows="3" id="observacion" name="observacion" readonly></textarea>
                    </div>
                
                </div>                
            </form>

        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        
        <?php if(isset($dt['js'])) echo $dt['js']; ?>

    });

    function datos(os_id){
        console.log(os_id);
        $("#id_os").val(os_id);
        $("#num_os").val(os_id);
        id_nula = os_id;
        $.ajax({
				type:'post',
				url:'<?php echo base_url('index.php/transacciones/orden/get_detalle_nula');?>',
				dataType: 'json',
				data: { id_orden: id_nula},
				success: function(response){
                    console.log(response.data[0]['observacion'])
                    if (response.response == 'OK'){
                        console.log(response.data[0].observacion)
                        $("#observacion").val(response.data[0]['observacion']);
                    }
				},
                error: function(jqXHR, textStatus, errorThrown){
                    if (typeof jqXHR.responseJSON !== 'undefined'){
                        body = jqXHR.responseJSON.ERROR;
                    }
                    else{
                        body = jqXHR.statusText;
                    }
                    $("#modalBody").html(body);
                    $("#modalHeader").html("ERROR");
                    $('#myModal').modal()
                    $('#orden').val('');
                }
    	    });         

        $('#form-anular').css("display","");
    }

    $("#facturar").click(function(e){

    });

</script>

