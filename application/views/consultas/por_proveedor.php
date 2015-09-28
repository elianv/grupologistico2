<style type="text/css">
	
</style>
<legend><h3><center>Ordenes de Servicio Por Proveedor</center></h3></legend> 

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
<form class="form-horizontal" id="formulario" action=" <?php echo base_url('index.php/consultas/facturadas/por_proveedor') ?> " method="post" >
	<fieldset>
		<div class="row">
			    <div class="span6 offset4" >
			                <div class="control-group">
			                    <label class="control-label"><strong>Proveedor</strong></label>
			                    <div class="controls">
			                        <input type="text" name="proveedor" id="proveedor" readonly="">
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
			    <div class="span8" style="margin-left: 50px">
			                    <table id="tabla-proveedor" class="table table-hover table-condensed" cellspacing="0" width="100%">
			                                <thead>
			                                    <tr>
			                                        <th style="width:20%">Rut</th>
			                                        <th style="width:80%">Raz&oacute;n Social</th>
			                                    </tr>
			                                </thead>
			                                <tbody>
			                                    <?php foreach ($proveedores as $proveedor) { ?>
			                                        <tr>
			                                            <td><a class="codigo-click" data-codigo="<?php echo $proveedor['rut_proveedor']; ?>" data-rs="<?php echo $proveedor['razon_social']; ?>"><?php echo $proveedor['rut_proveedor']; ?></a></td>
			                                            <td><?php echo $proveedor['razon_social']; ?></td>
			                                        </tr>
			                                    <?php } ?>
			                                    
			                                </tbody>
			                    </table>                    
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
			<center><h2><?php echo $titulo; ?></h2></center>
			<div class="container">
                    <table id="tabla-ordenes-proveedores" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Tipo Orden</th>
                                        <th>Cliente</th>
                                        <th>Costo</th>
                                        <th>N° Factura</th>
                                        <th>Estado</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proveedores_ as $proveedor) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$proveedor['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $proveedor['id_orden']; ?></a></td>
                                            <?php $fecha = new DateTime($proveedor['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>                                            
                                            <td><?php echo $proveedor['tipo_orden']; ?></td>
                                            <td><?php echo $proveedor['razon_social']; ?></td>
                                            <td><?php echo '$'.number_format($proveedor['total_neto'], 0, ',', '.'); ?></td>
                                            <td><?php echo $proveedor['factura_proveedor']; ?></td>
                                            <td><?php echo $proveedor['estado']; ?></td>


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
			$('#proveedor').val(codigo+" - "+rs);
			$('#id').val(codigo);
		});
		$('#tabla-ordenes-proveedores').DataTable();
        $('#tabla-proveedor').DataTable();		
    });
</script>