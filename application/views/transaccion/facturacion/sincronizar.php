<div class="container">
    <legend><h3><center>Sincronizar con MANAGER</center></h3></legend>

    <div style="margin-left: 10px">
        <?php if(validation_errors()){ ?>
            <div class='alert alert-info '>
                <a class='close' data-dismiss='alert'>×</a>
                <?php echo validation_errors(); ?>
            </div>
        <?php }  ?>
    </div>

    <?php $correcto = $this->session->flashdata('mensaje'); ?>

    <?php if ($correcto){ ?>
        <div class='alert alert-error'>
            <a class='close' data-dismiss='alert'>×</a>
            <span id='registroCorrecto'><?php echo $correcto;?></span>
        </div>
    <?php } ?>

    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="FORMsincronizar" id="form-file">
        <fieldset>

            <label for="exampleInputFile">Seleccion un archivo</label>
            <input type="file" id="uploadFile" name="uploadFile">
            <p class="help-block">Solo se permite la carga de archivos excel.</p>
            <br>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert"></button>
                <strong>¡Atención!</strong>
                <p> El número de factura (numfact) debe ser la columna G.</p>
                <p>El numero de la orden de servicio (num_ot) debe ser la columna AC.</p>
                En caso de no cumplirse la operación no se llevara a cabo.
            </div>
            <div class="form-actions" id="botones">
                <button type="submit" class="btn btn-success">Sincronizar</button>
            </div>
        </fieldset>
    </form>
    
    <br>
    <br>
    <div id="response">
    	<?php if ($opc == 1){ ?>
    		<center><h3>Datos sincronizados correctamente.</h3></center>
    		<br>
    		<br>
    		<table id="tablaOK" class="display" cellspacing="0" width="100%">
    			<thead>
    				<tr>
    					<th>N° Factura</th>
    					<th>N° OS</th>
    				</tr>
    			</thead>
    			<tbody id="body">
    				
    			</tbody>
    		</table>
    			
    	<?php } ?>
    </div>
    
</div>
<?php if ($opc == 1){ ?>
<script>
	$(document).ready(function(){
		var data = <?php echo $ok; ?>;
		var tabla ='';	
		$.each(data, function(i,item){
			tabla = tabla+'<tr><td>'+item+'</td><td>'+i+'</td></tr>';
		});
		$('#body').html(tabla);
		$('#tablaOK').DataTable();	
	});
</script>
<?php } ?>