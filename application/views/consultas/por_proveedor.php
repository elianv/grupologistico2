<legend><h3><center>Ordenes de Trabajo Por Proveedor</center></h3></legend> 

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
<form class="form-horizontal" id="formulario">
	<fieldset>
		<div class="row">
				<div class="span1"></div>
			    <div class="span6">
			                <div class="control-group">
			                    <label class="control-label"><strong>Proveedor</strong></label>
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
			                    <table id="tabla-proveedor" class="table table-hover table-condensed" cellspacing="0" width="100%">
			                                <thead>
			                                    <tr>
			                                        <th>Rut</th>
			                                        <th>Raz&oacute;n Social</th>
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
			    <div class="span1"></div>
		</div>
		<div class="row">
			<div class="span6"></div>
			<div class="span1">
				<div class="form-actions">
			    	<input type="submit" class="btn btn-success" value="Generar"/>
			    </div>		
			</div>
			<div class="span6"></div>
		</div>
	</fieldset	>
</form> 
<div class="row">
	<div class="span2"></div>
	<div class="span12" id="ordenes-proveedores"></div>
	<div class="span2"></div>
	
</div>
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
        $('#tabla-proveedor').DataTable();
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
		$( "#formulario" ).submit(function( event ) {
			event.preventDefault();
		  	datos = $( this ).serializeArray();
          	$.ajax({
                method:"POST",
                url:"<?php echo base_url('index.php/consultas/facturadas/generar_ordenes_por_proveedor');?>",
                data: datos,
                success: function(response){
	                $('#ordenes-proveedores').html(response.html);
	                $('#tabla-ordenes-proveedores').DataTable();
                }
            });    		  

		});			           
    });
        

</script>