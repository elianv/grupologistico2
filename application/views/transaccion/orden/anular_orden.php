
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

<legend><center><h3>Anular ordenes</h3></center></legend>
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
            <legend>Ingrese los datos</legend>
            
            <form class="form-horizontal" id="anular_form" name="anular_form" method="post">
                
                <div class="control-group">
                    <label class="control-label" ><strong>N°</strong></label>
                    <div class="controls">
                        <input type="text" id="id_os" readonly>
                        <input type="hidden" id="num_os">
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"><strong>Observación</strong></label>
                    <div class="controls">
                        <textarea class="input-xxlarge" type="textarea" rows="3" id="observacion" name="observacion" placeholder="observación" required></textarea>
                    </div>
                
                </div>                
            </form>

            <div class="form-actions">
                <a id="facturar" class="btn btn-success">Anular</a>
            </div>
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
        $('#form-anular').css("display","");
    }

    $("#facturar").click(function(e){
        e.preventDefault();
        os_id = $("#num_os").val();
        obs = $("#observacion").val();
        console.log(os_id);
        $.ajax({
				type:'post',
				url:'<?php echo base_url('index.php/transacciones/orden/form_os_anulada');?>',
				dataType: 'json',
				data: { id_orden: os_id, observacion: obs},
				success: function(response){
                    if (response.response == 'ok'){
                        $('#tabla-anular_os').DataTable().ajax.reload();
                        $("#modalBody").html("Orden anulada con éxito");
                        $("#modalHeader").html("Operación exitosa");
                        $('#myModal').modal()
                        $('#orden').val('');
                    }

				},
                error: function(jqXHR, textStatus, errorThrown){
                    $("#modalBody").html(jqXHR.responseJSON.ERROR);
                    $("#modalHeader").html("ERROR");
                    $('#myModal').modal()
                    $('#orden').val('');
                }
    	    }); 
    });

</script>

