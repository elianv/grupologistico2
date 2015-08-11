<div class="tabla-ordenes">
<table id="tabla_ordenes" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>N° Orden</th>
			<th>Seleccionar</th>
			<th>Cliente</th>
			<th>Fecha</th>	
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ordenes as $orden) { ?>
			
				<tr>
					<td><?php echo $orden['id_orden']; ?></td>
					<td align="center"><input type="checkbox" value="<?php echo $orden['id_orden']; ?>" name"ordenes[]"></td>
					<td><?php echo $orden['razon_social']; ?></td>
					<td><?php echo $orden['fecha']; ?></td>
				</tr>
			
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
	$("#seleccionar").click(function(){
        //console.log("boton seleccion");
        
        var list = new Array();
		var checkedValues = $('input:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		//console.log(checkedValues);
		$("#n_orden").val(checkedValues);
		$('#modal-ordenes').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			
		
		});
    });	
</script>