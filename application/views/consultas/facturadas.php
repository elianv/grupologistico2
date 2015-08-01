<style type="text/css">
    .thead{
        background: green;
    }
</style>
<legend><h3><center>Ordenes de Trabajo Facturadas</center></h3></legend> 

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

<div class="row">
    <div class="span1"></div>
    <div class="span6">
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
                        <input type="radio" name="time" id="Todas" value="todas" checked="">Todas
                    </label>
                    <label class="radio">
                        <input type="radio" name="time" id="porFechas" value="fechas">Rango de Fechas
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
    </div>
    <div class="span9" style="margin-left: 50px">
            <?php if($salida == 1) { ?>
                
                
                    <table id="tabla_ordenes" class="table table-hover table-condensed" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ordenes as $orden) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/11')?>" title="Para ver la Orden haga click"><?php echo $orden['id_orden']; ?></a></td>
                                            <td><?php echo $orden['tipo_orden']; ?></td>
                                            <?php $fecha = new DateTime($orden['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>

                                        </tr>
                                    <?php } ?>
                                    
                                </tbody>
                    </table>                    
                      
            <?php } ?>
    </div>
    <div class="span1"></div>
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
    $(document).ready(function(){
        $('#tabla_ordenes').DataTable();
        $('#fechas').hide();
    })
        

</script>