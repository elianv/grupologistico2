<legend><h3><center>Facturas</center></h3></legend>

<div class="container">
    <?php if(validation_errors()){ ?>
        <div class='alert alert alert-error' align=center>
            <a class='close' data-dismiss='alert'>×</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
</div>

<div class="container">
    <div class="tabla-facturas">
        <table id="tabla-facturas" class="table table-bordered table-striped dataTable">
            <thead>
            <tr>
                <th>N° OS ERP</th>
                <th>Cliente</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    </div>
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
            "ajax": "porFacturar_ajax" ,

            columns: [
                {data:"id"},
                {data:"cliente"},
                {data:"fecha"}
            ]
        });
	
    });
    function datos(dato){

    	$.ajax({
				type:'post',
				url:'<?php echo base_url();?>index.php/transacciones/facturacion/costos_ajax',
				dataType: 'json',
				data: { id : dato},
				beforeSend: function(){
					//$('#detalle').html();
				},
				success: function(response){
					$('#detalle').html("response");
				}
    	});
    }
</script>
