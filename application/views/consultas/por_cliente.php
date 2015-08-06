<legend><h3><center>Ordenes de Trabajo Por Cliente</center></h3></legend> 

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
<form class="form-horizontal" id="formulario" method="post" action="<?php echo base_url('index.php/consultas/facturadas/por_cliente')?>">
	<fieldset>
		<div class="row">
			    <div class="span6 offset4">
			                <div class="control-group">
			                    <label class="control-label"><strong>Cliente</strong></label>
			                    <div class="controls">
			                        <input type="text" name="cliente" id="cliente" readonly="">
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
			                    <table id="tabla-cliente" class="table table-hover table-condensed" cellspacing="0" width="100%">
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
                    <table id="tabla-ordenes-clientes" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clientes_ as $cliente) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$cliente['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $cliente['id_orden']; ?></a></td>
                                            <td><?php echo $cliente['tipo_orden']; ?></td>
                                            <td><?php echo $cliente['estado']; ?></td>
                                            <?php $fecha = new DateTime($cliente['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>

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
        $('#tabla-cliente').DataTable();
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
			$('#cliente').val(codigo+" - "+rs);
			$('#id').val(codigo);
		});
		$('#tabla-ordenes-clientes').DataTable();				           
    });
        

</script>