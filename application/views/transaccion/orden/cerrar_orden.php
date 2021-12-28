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
                    <label class="control-label"><strong>N° Factura</strong></label>
                    <div class="controls">
                        <input class="input-medium" type="text" id="num_factura" name="num_factura" value="<?php echo set_value('num_factura'); ?>" readonly>
                        <span class="add-omn">
                            <a class="btn" id="modal-fact"><i class="icon-search"></i></a>
                        </span>
                    </div>
                </div>

                <div class="control-group input-append">
                    <label class="control-label"><strong>Orden</strong></label>
                    <div class="controls">
                        <input class="input-medium" type="text" id="ordenes" name="ordenes" readonly>
                        <span class="add-omn">
                            <a class="btn" id="modal-os"><i class="icon-search"></i></a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="control-group">
                    <label class="control-label"><strong>Factura proveedor</strong></label>
                    <div class="controls">
                        <input class="input-medium" type="text" id="factura_proveedor" name="factura_proveedor">
                    </div>
                </div>   
                
                <div class="control-group">
                    <label class="control-label"><strong>Fecha factura</strong></label>
                    <div class="controls">
                        <input class="input-medium" type="text" id="fecha_factura" name="fecha_factura" readonly>
                    </div>
                </div>   
            </div>  
        </div>

        <div class="form-actions">
            <a id="facturar" class="btn btn-success">Facturar</a>
        </div>

    </form>

    </div>
</div>

<?php echo $fact['table']; ?>
<?php echo $ordenes['table']; ?>

<script>
    $( document ).ready(function() {
        
        $("#sel_modal_os").click(function(e){
            $("#myModal_os_facturables").modal('toggle');
        });

        $("#sel_modal_fact").click(function(e){
            $("#myModal_facturas_os").modal('toggle');
        });        

        $("#modal-fact").click(function(e){

            /*
            $.ajax({
				type:'post',
				url:'<?php echo base_url('index.php/transacciones/orden/get_facturas_ajax');?>',
				success: function(response){
					console.log(response);
				},
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    $("#modalBody").html(jqXHR.responseJSON.ERROR);
                    $("#modalHeader").html("ERROR");
                    $('#myModal').modal()
                  
                }
    	    });
            */
            $('#myModal_facturas_os').modal();
        })

        $("#modal-os").click(function(e){
            $('#myModal_os_facturables').modal();
        });        
        
        $('#fecha_factura').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });    

        $('#facturar').click(function(e){
            e.preventDefault();
            console.log('form search');
            var nfactura = $('#num_factura').val();
            var ordenes = $('#ordenes').val();
            var fecha = $("#fecha_factura").val();
            var fac_prove = $("#factura_proveedor").val();
            
            if (nfactura == ''){
                $("#modalBody").html("Debe ingresar un número de factura");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }
            if (ordenes == ''){
                $("#modalBody").html("Debe seleccionar ordenes");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }
            if (fac_prove == ''){
                $("#modalBody").html("Debe ingresar Factura proveedor");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }
            if (fecha == ''){
                $("#modalBody").html("Debe seleccionar una fecha");
                $("#modalHeader").html("ERROR");
                $('#myModal').modal()
            }
            
            $.ajax({
				type:'post',
				url:'<?php echo base_url('index.php/transacciones/orden/send_cerraros_ajax');?>',
				dataType: 'json',
				data: { os : ordenes, fact: nfactura, fecha: fecha, fac_prove: fac_prove},
				success: function(response){
                    console.log("success");
					console.log(response);
                    $('#num_factura').val('');
                    $('#ordenes').val('');
                    $("#fecha_factura").val('');
                    $("#factura_proveedor").val('');
                    $("#modalBody").html("Orden facturada con éxito");
                    $("#modalHeader").html("Operación completada");
                    $('#myModal').modal()
                    $('#tabla-os_facturables').DataTable().ajax.reload();
				},
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    $("#modalBody").html(jqXHR.responseJSON.ERROR);
                    $("#modalHeader").html("ERROR");
                    $('#myModal').modal()
                  
                }
    	    }); 

        });

        <?php if(isset($ordenes['js'])) echo $ordenes['js']; ?>
        <?php if(isset($fact['js'])) echo $fact['js']; ?>
    });
    function datos(dato){
        window.open("<?php echo base_url('index.php/transacciones/orden/pdf/');?>/" + dato , "_blank")
    }

    function checkeable(id){
        $("#ordenes").val(id);
    } 
    function check_fact(id){
        $("#num_factura").val(id);
    }

</script>

