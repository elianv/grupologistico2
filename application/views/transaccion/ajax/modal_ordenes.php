<div class="tabla-ordenes">
<table id="tabla_ordenes" class="table table-bordered table-striped dataTable">
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
		console.log(checkedValues);
		$.ajax({
				type:'post',
				url:'<?php echo base_url();?>index.php/transacciones/facturacion/detalles_ordenes_ajax',
				dataType: 'json',
				data: { ordenes : checkedValues},
				beforeSend: function(){
					$('#detalles_orden').html();
				},
				success: function(response){
					//console.log(response.total_compra);
					$('#total_costo').val(response.total_compra);
					$('#total_venta').val(response.total_venta);
					$('#detalles_orden').html(response.html);
					valida = 1;

				}
		});
		$('#ordenServicio').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			$('#detalles_orden').slideDown('slow');
		
		});
    });
</script>