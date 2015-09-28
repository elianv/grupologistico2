<style type="text/css">
	
</style>
<legend><h3><center>Ordenes de Servicio Realizadas</center></h3></legend> 

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
<form class="form-horizontal" id="formulario" action=" <?php echo base_url('index.php/consultas/facturadas/realizadas') ?> " method="post" >
	<fieldset>
		<div class="row">
			    <div class="span6 offset2">
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
			    <div class="span6 offset2">
			                <label class="control-label"><strong>Periodo de Tiempo</strong></label>
			                <div class="controls">
			                    <label class="radio">
			                        <input type="radio" name="time" id="Todas" value="todas" checked>Todas
			                    </label>
			                    <label class="radio">
			                        <input type="radio" name="time" id="porFechas" value="fechas" >Rango de Fechas
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
			    </div>
	    
		</div>
		<div class="form-actions ">
		    	<input type="submit" class="btn btn-success offset4" value="Generar"/>
	    </div>		
	</fieldset	>
</form> 
		<?php if($tipo == 1){ ?>
		<hr />
		<br />
			<center><h2>Ordenes de Servicio</h2></center>
			<div class="container">
                    <table id="tabla-ordenes-realizadas" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Tipo Orden</th>
                                        <th>Cliente</th>
                                        <th>Neto Total</th>
                                        <th>Estado</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($realizadas as $realizada) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$realizada['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $realizada['id_orden']; ?></a></td>
                                            <?php $fecha = new DateTime($realizada['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>                                            
                                            <td><?php echo $realizada['tipo_orden']; ?></td>
                                            <td><?php echo $realizada['razon_social']; ?></td>
                                            <td><?php echo '$'.number_format($realizada['total_neto'], 0, ',', '.'); ?></td>
                                            <td><?php echo $realizada['estado']; ?></td>


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
		$('#tabla-ordenes-realizadas').DataTable();
    });
</script>