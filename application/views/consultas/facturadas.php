<legend><h3><center>Ordenes de Trabajo Facturadas</center></h3></legend> 

<div class="container-fluid">

        <form class="form-horizontal" id="formulario" action="<?php echo base_url('index.php/consultas/facturadas/generar_ordenes');?>" method="post">
            <fieldset>
                <label class="control-label"><strong>Formato de Salida</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
                    </label>
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel  
                    </label>
                    
                </div>
                <div class="control-group">
                    <label class="control-label"><strong>Estado O.S.</strong></label>
                    <div class="controls">
                        <select id="estado_os" name="estado_os">
                            <?php foreach ($estados as $estado) { ?>
                                    <option value=" <?php echo $estado['id']; ?> "><?php echo $estado['estado']; ?></option>
                            <?php } ?>
                        </select>
                    </div>                    
                </div>
                <label class="control-label"><strong>Periodo de Tiempo</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="time" id="Todas" value="todas" >Todas
                    </label>
                    <label class="radio">
                        <input type="radio" name="time" id="porFechas" value="fechas" checked>Rango de Fechas
                    </label>
                    
                </div>
                <div id="fechas">                
                    <div class="control-group">
                        <label class="control-label" for="desde"><strong>Desde :</strong></label> 
                        <div class="controls"><input type="text" id="datepicker" name="desde" class="span2" readonly="" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="hasta"><strong>Hasta :</strong></label> 
                        <div class="controls"><input type="text" id="datepicker2" name="hasta" class="span2" readonly="" /></div>
                    </div>
                </div>
                <div class="form-actions">
                            <input type="submit" class="btn btn-success" value="Generar"/>
                </div>

            </fieldset>
        </form>
        <div id="tabla">
        <?php if($salida == 1) { ?>
                <table id="tabla_ordenes" class="table table-hover table-condensed" cellspacing="0" width="100%">
                        <thead  class="thead">
                            <tr>
                                <th>N°</th>
                                <th>Tipo Orden</th>
                                <th>Fecha</th>
                                <th>Referencia</th>
                                <th>Booking</th>
                                <th>N&uacute;mero</th>
                                <th>Peso</th>
                                <th>Set Point</th>
                                <th>Fecha Presentación</th>
                                <th>Ref. 2</th>
                                <th>Mercader&iacute;a</th>
                                <th>Lugar Retiro</th>
                                <th>Puerto Destino</th>
                                <th>Aduana</th>
                                <th>Bodega</th>
                                <th>Rut Cliente</th>
                                <th>Raz&oacute;n Social</th>
                                <th>Deposito</th>
                                <th>Nombre Nave</th>
                                <th>Rut Proveedor</th>
                                <th>Proveedor</th>
                                <th>Giro</th>
                                <th>Puerto</th>
                                <th>Carga</th>
                                <th>Tramo</th>
                                <th>Naviera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordenes as $orden) { ?>
                                <tr>
                                    <td><font size="1"><?php echo $orden['id_orden']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['tipo_orden']; ?></td></font>
                                    <?php $fecha = new DateTime($orden['fecha']); ?>
                                    <td><font size="1"><?php echo $fecha->format('d-m-Y'); ?></td></font>
                                    <td><font size="1"><?php echo $orden['referencia']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['booking']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['numero']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['peso']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['set_point']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['fecha_presentacion']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['referencia_2']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['mercaderia']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['lugar_retiro']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['nombre_puerto_destino']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['nombre_aduana']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['nombre_bodega']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['rut_cliente']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['razon_social']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['deposito']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['nombre_nave']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['rut_proveedor']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['rs_proveedor']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['rs_giro']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['prto_nombre']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['carga']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['descripcion']; ?></td></font>
                                    <td><font size="1"><?php echo $orden['naviera']; ?></td></font>

                                </tr>
                            <?php } ?>
                            
                        </tbody>
                </table>
                <br />        
        <?php } ?>
        </div>

</div>
<script type="text/javascript">

    $('#Todas').click(function(){
        
        $("#Todas").prop("checked", true);
        $('#fechas').hide();
        $('#tabla').html("");
    });
    $('#porFechas').click(function(){
        
        $("#porFechas").prop("checked", true);
        $('#fechas').show();
    });
        

</script>