<legend><h3><center>Facturas Realizadas</center></h3></legend> 

<div class="container">
	<?php if(validation_errors()){ ?>
	    <div class='alert alert alert-error' align=center>
		    <a class='close' data-dismiss='alert'>×</a>
		    <?php echo validation_errors(); ?>
	    </div>
	<?php } ?>
</div>

<form class="form-horizontal" id="formulario" method="post" action="<?php echo base_url('index.php/transacciones/facturacion/realizadas')?>">
	<fieldset>
		<div class="row">
			    <div class="span6 offset4">

	                <label class="control-label"><strong>Formato de Salida</strong></label>
	                <div class="controls">
	                    <label class="radio">
	                        <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
	                    </label>
	                    <label class="radio">
	                        <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel  
	                    </label>
	                </div>

			    </div>
			    <div class="span6">

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
		</div>
		<div class="form-actions">
			    	<input type="submit" class="btn btn-success offset4" value="Generar"/>
		</div>		
			
			
		</div>
	</fieldset>
</form>  
<?php if($tipo){ ?>
	<center><h2>Facturas Realizadas</h2></center>
	<div class="container">
            <table id="tabla-facturas-realizadas" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Cliente</th>
                                <th>Estado Factura</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($facturas as $factura) { ?>
                                <tr>
                                    <td><a href=#"<?php //echo base_url('index.php/transacciones/orden/pdf/'.$facturas['id_orden'])?>" title="Para ver la Factura haga click"><?php echo $factura['numero_factura']; ?></a></td>
                                    <td><?php echo $factura['razon_social']; ?></td>
                                    <td><?php echo $factura['tipo_factura']; ?></td>
                                    <?php $fecha = new DateTime($factura['fecha']); ?>
                                    <td><?php echo $fecha->format('d-m-Y'); ?></td>                                            
                                </tr>
                            <?php } ?>
                        </tbody>
            </table> 
	</div>
<?php } ?>
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
	    $('#tabla-facturas-realizadas').dataTable();
    });
</script>           