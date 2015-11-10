<legend><h3><center>Ordenes de Servicio Facturadas</center></h3></legend>

            <?php
                echo '<div class="container">';
                if(validation_errors()){
                    echo "<div class='alert alert alert-error' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                }
                echo '</div>';
            ?>
<form class="form-horizontal" id="formulario" method="post" action="<?php echo base_url('index.php/consultas/facturadas/ordenes_facturadas')?>">
    <fieldset>
        <div class="row">
                <div class="span6 offset4">
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="clientes" id="TodosCli" value="0" checked>Todos
                                </label>
                                <label class="radio">
                                    <input type="radio" name="clientes" id="UnCli" value="1" >Por Cliente
                                </label>

                            </div>
                            <div id="showCliente" style="display: none;">
                              <div class="control-group">
                                  <label class="control-label"><strong>Cliente</strong></label>
                                  <div class="controls">
                                      <input type="text" name="cliente" id="cliente" readonly="">
                                      <input type="hidden" name="id" id="id">
                                  </div>
                              </div>
                            </div>


                            <label class="control-label"><strong>Formato de Salida</strong></label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
                                </label>
                                <label class="radio">
                                    <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel
                                </label>
                            </div>
                            <label class="control-label"><strong>Periodo de Tiempo</strong></label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="time" id="Todas" value="todas" checked>Todas
                                </label>
                                <label class="radio">
                                    <input type="radio" name="time" id="porFechas" value="fechas" >Rango de Fechas
                                </label>

                            </div>
                            <div id="fechas" style="display: none;">
                                <div class="control-group">
                                    <label class="control-label" for="desde"><strong>Desde :</strong></label>
                                    <div class="controls"><input type="text" id="datepicker" name="desde" class="span2" readonly="" /></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="hasta"><strong>Hasta :</strong></label>
                                    <div class="controls"><input type="text" id="datepicker2" name="hasta" class="span2" readonly="" /></div>
                                </div>
                            </div>
                </div>
                <div class="span9" style="margin-left: 50px">
                                <table id="tabla-facturadas" class="table table-hover table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Rut</th>
                                                    <th>Raz&oacute;n Social</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($clientes as $cliente) { ?>
                                                    <tr>
                                                        <td><a class="codigo-click" data-codigo="<?php echo $cliente['rut_cliente']; ?>" data-rs="<?php echo $cliente['razon_social']; ?>"><?php echo $cliente['rut_cliente']; ?></a></td>
                                                        <td><?php echo $cliente['razon_social']; ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                </table>
                </div>

        </div>
        <div class="form-actions">
                    <input type="submit" class="btn btn-success offset4" value="Generar"/>
        </div>


        </div>
    </fieldset>
</form>
<?php if($tipo == 1){ ?>
    <hr />
    <center><h2><?php echo $titulo; ?></h2></center>
    <div class="container">
                    <table id="tabla-ordenes-facturadas" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th Colspan="4"><center>Ordenes de Servicio</center></th>
                                        <th Colspan="3"><center>Factura GLC Chile</center></th>

                                    </tr>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Fecha</th>
                                        <th>$ Neto</th>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>$ Neto</th>
                                        <th>Cliente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($facturadas as $cliente) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$cliente['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $cliente['id_orden']; ?></a></td>
                                            <td><?php echo $cliente['tipo_orden']; ?></td>
                                            <?php $fecha = new DateTime($cliente['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                            <td><?php echo'$'.number_format($cliente['total_neto'], 0, ',', '.'); ?></td>
                                            <td><a href="<?php echo base_url('index.php/transacciones/facturacion/imprimir/'.$cliente['numero_factura']); ?>"><?php echo $cliente['numero_factura']; ?></a></td>
                                            <?php $fecha = new DateTime($cliente['fecha_factura']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                            <td><?php echo'$'.number_format($cliente['neto_factura'], 0, ',', '.'); ?></td>
                                            <td><?php echo $cliente['razon_social']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                    </table>
    </div>
<?php } ?>
<br>
<script type="text/javascript">
    $(document).ready(function(){
        $('#datepicker').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
        $('#datepicker2').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });

        $('#fechas').hide();
        $('#Todas').click(function(){

            $("#Todas").prop("checked", true);
            $('#fechas').hide();
            $('#tabla').html("");
        });
        $('#porFechas').click(function(){

            $("#porFechas").prop("checked", true);
            $('#fechas').show();
        });
        $('.table .codigo-click').click(function(e){
            e.preventDefault();
            var codigo = $(this).attr('data-codigo');
            var rs = $(this).attr('data-rs');
            console.log(rs+" "+codigo );
            $('#cliente').val(codigo+" - "+rs);
            $('#id').val(codigo);
        });
        $('#TodosCli').click(function(){
            $('#showCliente').hide();
            $('#cliente').val("");
        });
        $('#UnCli').click(function(){
            $('#showCliente').show()
        });        
        $('#tabla-ordenes-facturadas').DataTable();
        $('#tabla-facturadas').DataTable();
    });


</script>
