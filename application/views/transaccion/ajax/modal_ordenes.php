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
			<?php if($orden['id_estado_orden'] == 1){ ?>
				<tr>
					<td><?php echo $orden['id_orden']; ?></td>
					<td align="center"><input type="checkbox" value="<?php echo $orden['id_orden']; ?>" name"ordenes[]"></td>
					<td><?php echo $orden['razon_social']; ?></td>
					<td><?php echo $orden['fecha']; ?></td>
				</tr>
			<?php } ?>
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
		$.ajax({
				type:'post',
				url:'<?php echo base_url();?>index.php/transacciones/facturacion/detalles_ordenes_ajax',
				dataType: 'json',
				data: { ordenes : checkedValues},
				beforeSend: function(){
					$('#detalles_orden').html("");
					console.log(ordenes);
				},
				success: function(response){
					if(response.clientes){
						$('#cliente_factura_').val(response.cliente);
						$('#botones').show();
					}
					else{
						$('#cliente_factura_').val("--");
						$('#botones').hide();
					}
					//console.log(response.total_compra);
					$('#detalles_orden').html(response.html);
					$('#total_costo').val(response.total_compra);
					$('#total_venta').val(response.total_venta);
		
					

				}
		});
		$('#ordenServicio').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			$('#detalles_orden').slideDown('slow');
		
		});
    });
</script>