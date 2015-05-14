<div class="tabla-ordenes">
<table id="tabla_ordenes" class="table table-bordered table-striped dataTable">
	<thead>
		<tr>
			<th>N° Orden</th>
			<th>Cliente</th>
			<th>Fecha</th>	
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ordenes as $orden) { ?>
			<tr>
				<td><a class="codigo-click" data-codigo="<?php echo $orden['id_orden']; ?>" ><?php echo $orden['id_orden']; ?></a></td>
				<td><?php echo $orden['razon_social']; ?></td>
				<td><?php echo $orden['fecha']; ?></td>
			</tr>
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
	$('.tabla-ordenes .codigo-click').click(function(e){
  
  e.preventDefault();
  		console.log($(this).data('codigo'));
		  	$.ajax({
		    type:'post',
		    url:'<?php echo base_url();?>index.php/transacciones/facturacion/orden_servicio_ajax',
		    dataType: 'json',
		    data:{id_orden:$(this).data('codigo')},
		    beforeSend: function(){
		    	$('#detalles_orden').html('');
		    },
		    success:function(response) {
		    	console.log(response.html);
		      $('#orden').val(response.orden[0].id_orden);
		      $('#rut').val(response.orden[0].proveedor_rut_proveedor);
		      $('#valor_total').val(response.valor_total);
		      $('#detalles_orden').html(response.html);
		    }
	  	});
	  	$('#ordenServicio').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
		
		});

	});
</script>