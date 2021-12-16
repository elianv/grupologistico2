
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
    <form class="form-horizontal" id="formulario" name="form" method="post">
        <legend><center><h3>Buscar ordenes entre fechas</h3></center></legend>
        <div class="row" id="input_fechas">
            <div class="span6">
                <label class="control-label"><strong>Desde</strong></label>
                <div class="controls"><input type="text" id="desde" name="desde" placeholder="Seleccione fecha" value="<?php echo set_value('desde'); ?>" readonly></div>
            </div>
            <div class="span6">
                <label class="control-label"><strong>Hasta</strong></label>
                <div class="controls"><input type="text" id="hasta" name="hasta" placeholder="Seleccione Fecha" value="<?php echo set_value('hasta'); ?>" readonly></div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Generar</button>
        </div>
    </form>

    <div id="result">

        <?php if($result) echo $ordenes['table']; ?>
        
    </div>
    
</div>

<script>
    $( document ).ready(function() {
        
        $('#tabla-ordenes').DataTable({
            
            "processing": true,
            "serverSide": true,
            "bProcessing": true,
            "ajax": "listarOrdenes" ,

            columns: [
                {data:"id"},
                {data:"cliente"},
                {data:"proveedor"}
            ]
        });

        $('#desde').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
        $('#hasta').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });

        <?php if(isset($ordenes['js'])) echo $ordenes['js']; ?>
    });
    function datos(dato){

    	$.ajax({
				type:'post',
				url:'<?php echo base_url();?>index.php/transacciones/orden/costos_ajax',
				dataType: 'json',
				data: { id : dato},
				beforeSend: function(){
					$('#detalle').html();
				},
				success: function(response){

					$('#detalle').html(response.view);
                    $('#inputProveedor').focus();
				}
    	});
    }
</script>
