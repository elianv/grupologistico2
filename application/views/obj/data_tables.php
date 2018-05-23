<legend><h3><center><?php echo $titulo; ?></center></h3></legend>

<div class="container">
    <?php if(validation_errors()){ ?>
        <div class='alert alert alert-error' align=center>
            <a class='close' data-dismiss='alert'>×</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
</div>

<div class="container">



    <div class=<?php echo "tabla-div-".$clase."\""; ?>">
        <table id=<?php echo "tabla-".$clase; ?> class="table table-bordered table-striped dataTable">

            <thead>
            <tr>
                <?php 
                    foreach($titulos as $titulo) { 
                        echo "<th>".$titulo."</th>";
                    } 
                ?> 
            </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    </div>
    <br>
    <div align="right">
        <?php 
            if(isset($botones)){
                foreach ($botones as $boton) {  
                echo "<a class='btn btn-".$boton['tipo']."' id='".$boton['id']."'>".$boton['texto']."</a>";}
        } ?>
        
    </div>
    <div id="detalle">
    </div>

</div>

<script>
    $( document ).ready(function() {
            <?php echo $js_ajax; ?> 

    /*
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
    */
  });
</script>
