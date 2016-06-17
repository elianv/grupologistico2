<legend><h3><center>Facturas Pendientes</center></h3></legend>

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
                <th>Seleccionar</th>
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
    <div align="right">
        <a class="btn btn-success" id="procesar">Re facturar seleccionados</a>
    </div>
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
                {data:"boton"},
                {data:"id"},
                {data:"cliente"},
                {data:"fecha"}
                
            ]
        });
     
        $('#procesar').click( function () {
            var checkedValues = $('input:checkbox:checked').map(function() {
                return this.value;
            }).get()
                    
            $.ajax({
                method:"POST",
                url:"<?php echo base_url();?>index.php/transacciones/facturacion/reFacturacion_ajax",
                dataType: 'json',
                data: { ordenes : checkedValues},
                beforeSend: function(){
                    console.log(checkedValues);
                },              
                success: function(response){
                    $('#detalle').html(response);
                }

          });                        
                    
        } );
    });
</script>