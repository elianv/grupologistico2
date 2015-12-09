<div class="tabla-ordenes">
<table id="tabla_ordenes" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>N° Orden</th>
			<th>Seleccionar</th>
			<th>Cliente</th>
			<th>Fecha Creaci&oacute;n</th>	
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ordenes as $orden) { ?>
				<?php if($orden['id_estado_orden'] != 1){?>
						<tr>
							<td><?php echo $orden['id_orden']; ?></td>
							<td align="center"><input type="checkbox" value="<?php echo $orden['id_orden']; ?>" name"ordenes[]"></td>
							<td><?php echo $orden['razon_social']; ?></td>
							<?php $fecha = new DateTime($orden['fecha_creacion']); ?>
							<td><?php echo $fecha->format('d-m-Y'); ?></td>
						</tr>
				<?php } ?>
			
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
	$("#seleccionar").click(function(){
        //console.log("boton seleccion");
        $('#tabla_facturas :checked').removeAttr('checked');
        var list = new Array();
		var checkedValues = $('input:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		//console.log(checkedValues);
		$("#n_orden").val(String(checkedValues).substr(2) );
		$('#modal-ordenes').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			
		
		});
    });	
</script>