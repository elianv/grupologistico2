<legend><h3><center>Ordenes de Servicio Por Conductor</center></h3></legend> 

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
<form class="form-horizontal" id="formulario" method="post">
	<fieldset>
		<div class="row">
			    <div class="span6 offset4">
			                <div class="control-group">
			                    <label class="control-label"><strong>Conductor</strong></label>
			                    <div class="controls">
			                        <input type="text" name="conductor" id="conductor" readonly="">
			                        <input type="hidden" name="id" id="id">
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
			    <div class="span9" style="margin-left: 50px">
			                    <table id="tabla-conductores" class="table table-hover table-condensed" cellspacing="0" width="100%">
			                                <thead>
			                                    <tr>
			                                        <th>Rut</th>
			                                        <th>Nombre</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <?php foreach ($conductores as $conductor) { ?>
			                                        <tr>
			                                            <td><a class="codigo-click" data-codigo="<?php echo $conductor['rut']; ?>" data-nombre="<?php echo $conductor['descripcion']; ?>"><?php echo $conductor['rut']; ?></a></td>
			                                            <td><?php echo $conductor['descripcion']; ?></td>
			                                        </tr>
			                                    <?php } ?>
			                                    
			                                </tbody>
			                    </table>                    
			    </div>
		</div>
		<div class="form-actions">
		    	<input type="submit" class="btn btn-success offset4" value="Generar"/>
	    </div>		
	</fieldset>
</form> 

	<?php if($tipo){ ?>
					<hr />
					<center><h2><?php echo $titulo; ?></h2></center>
					<div class="container">
                    <table id="tabla-ordenes-conductor" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha Creaci&oacute;n</th>
                                        <th>Cliente</th>
                                        <th>Costo</th>
                                        <th>Contenedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($conductores_ as $conductor) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$conductor['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $conductor['id_orden']; ?></a></td>
                                            <?php $fecha = new DateTime($conductor['fecha_presentacion']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>                                            
                                            <td><?php echo $conductor['razon_social']; ?></td>
                                            <td><?php echo '$'.number_format($conductor['total_neto'], 0, ',', '.'); ?></td>
                                            <td><?php echo $conductor['contenedor']; ?></td>
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
			var nombre = $(this).attr('data-nombre');
			$('#conductor').val(codigo+" - "+nombre);
			$('#id').val(codigo);
		});
		$('#tabla-ordenes-conductor').DataTable();
        $('#tabla-conductores').DataTable();		

    });
        

</script>