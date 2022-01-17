<style type="text/css">
.modal.large {
    width: 70%; /* respsonsive width */
    margin-left:-30%; /* width/2) */ 
}
</style>
<br>
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

<div class="container">
    <legend><center><h3>Cerrar ordenes</h3></center></legend>

    <form class="form-horizontal" id="form_os_selected" name="form_os_selected" method="post">

        <div class="row">
            <div class="span6">
                <div class="control-group input-append">
                    <label class="control-label"><strong>N° Factura SCT</strong></label>
                    <div class="controls">
                        <input class="input-medium" type="text" id="fact_sct" name="fact_sct" value="<?php echo set_value('num_factura'); ?>" readonly>
                        <span class="add-omn">
                            <a class="btn" id="modal-fact"><i class="icon-search"></i></a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="control-group">
                        <label class="control-label"><strong>Factura Manager</strong></label>
                        <div class="controls">
                            <input class="input-medium" type="text" id="fact_manager" name="fact_manager">
                        </div>
                </div>
            </div>  
        </div>
        <input class="input-medium" type="hidden" id="orden" name="orden">
        <div class="form-actions">
            <a id="facturar" class="btn btn-success">Guardar</a>
        </div>

    </form>

    </div>
</div>

<?php echo $fact['table']; ?>

<script>
    $( document ).ready(function() {
        
        $("#sel_modal_fact").click(function(e){
            $("#myModal_facturas_os").modal('toggle');
        });        

        $("#modal-fact").click(function(e){
            $('#myModal_facturas_os').modal();
        })

        $('#facturar').click(function(e){
            e.preventDefault();
            console.log('form search');
            var fact_sct = $('#fact_sct').val();
            var fact_manager = $('#fact_manager').val();
            var orden = $('#orden').val();
            
            if (fact_sct == ''){
                $("#modalBody").html("Debe seleccionar la factura SCT");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }

            if (fact_manager == ''){
                $("#modalBody").html("Debe ingresar la factura de MANAGER");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }

            if (orden == ''){
                $("#modalBody").html("ERROR INTERNO");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }
            
            $.ajax({
				type:'post',
				url:'<?php echo base_url('index.php/transacciones/orden/send_cerraros_ajax');?>',
				dataType: 'json',
				data: { fact_sct: fact_sct, fact_manager: fact_manager, orden: orden},
				success: function(response){
                    console.log("success");
					console.log(response);
                    $('#fact_sct').val('');
                    $('#fact_manager').val('');
                    $("#modalBody").html("Orden facturada con éxito");
                    $("#modalHeader").html("Operación completada");
                    $('#myModal').modal()
                    $('#tabla-facturas_os').DataTable().ajax.reload();
				},
                error: function(jqXHR, textStatus, errorThrown){
                    $("#modalBody").html(jqXHR.responseJSON.ERROR);
                    $("#modalHeader").html("ERROR");
                    $('#myModal').modal()
                    $('#orden').val('');
                }
    	    }); 

        });

        <?php if(isset($fact['js'])) echo $fact['js']; ?>
    });
    function datos(dato){
        window.open("<?php echo base_url('index.php/transacciones/orden/pdf/');?>/" + dato , "_blank")
    }

    function check_fact(id,id_orden){
        $("#fact_sct").val(id);
        $("#orden").val(id_orden);

    }

</script>

