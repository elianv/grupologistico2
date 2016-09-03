
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
<legend><h3><center>Facturas</center></h3></legend>
    <!-- <div class="tabla-facturas"> -->
        <table id="tabla-facturas" class="table table-bordered table-striped dataTable">
            <thead>
            <tr>
                <th>N° OS</th>
                <th>Cliente</th>
                <th>Proveedor</th>
            </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    <!-- </div> -->
    <br>

    <div id="detalle">
    </div>
    
</div>

<script>
    $( document ).ready(function() {
        
        $('#tabla-facturas').DataTable({
            
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
