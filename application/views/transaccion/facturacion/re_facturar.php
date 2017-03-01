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
                success: function(response){
                    var tDetalle = "<table class='table table-bordered table-striped dataTable'><thead><tr><th>Orden N°</th><th>Código MANAGER</th><th>Mensaje MANAGER</th></tr></thead><tbody>";
                    for(var k in response) {
                       tDetalle += "<tr><td>"+response[k].num_orden+"</td><td>"+response[k].cabecera.codigo+"</td><td>"+response[k].cabecera.error+"</td></tr>";
                    }
                    tDetalle +="</tbody></table>";
                    $('#detalle').html(tDetalle);

                },
                error: function(jqXHR, textStatus, errorThrown){
                  mensaje = '<div class="alert alert-success" role="alert"><strong>ERROR!</strong><br>Error al comunicarse con MANAGER</div>';
                  $('#detalle').html(mensaje);
                }

          }).fail( function( jqXHR, textStatus, errorThrown ) {
            mensaje = '<div class="alert alert-success" role="alert"><strong>ERROR!</strong><br>Error al comunicarse con MANAGER</div>';
            $('#detalle').html(mensaje);

          });
    });
  });
</script>
