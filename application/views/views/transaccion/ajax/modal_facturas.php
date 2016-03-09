<div class="tabla-facturas">
<table id="tabla-facturas" class="table table-bordered table-striped dataTable">
	<thead>
		<tr>
			<th>Factura </th>
			<th>N° OS ERP</th>
			<th>Cliente</th>
			<th>Fecha</th>	
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($facturas as $factura) { ?>
			<tr>
				<td><a class="codigo-click" data-codigo="<?php echo $factura['numero_factura']; ?>" data-os="<?php echo $factura['id']; ?>" ><?php echo $factura['numero_factura']; ?></a></td>
				<td><?php echo $factura['id']; ?></td>
				<td><?php echo $factura['cliente']; ?></td>
				 <?php $date = date_create($factura['fecha']); ?>
				<td><?php echo date_format($date, 'd-m-Y'); ?></td>
				<?php if($factura['estado_factura_id_estado_factura'] == 3) {?>
					<td>Factura Nula</td>
				<?php } elseif($factura['estado_factura_id_estado_factura'] == 2){ ?>
					<td>Facturada</td>
				<?php } elseif($factura['estado_factura_id_estado_factura'] == 1){ ?>
					<td>Por Facturar</td>
				<?php } ?>
			</tr>
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
	$('.tabla-facturas .codigo-click').click(function(e){
		e.preventDefault();
		var codigo = $(this).attr('data-codigo');
		var os_manager = $(this).attr('data-os');
		$.ajax({
				type:'post',
				url:'<?php echo base_url();?>index.php/transacciones/facturacion/cargar_facturas',
				dataType: 'json',
				data: { num_factura : codigo, os_manager : os_manager},

				beforeSend: function(){
					$('#detalles_orden').html();
				},
				success: function(response){
					if(response.clientes){
						$('#cliente_factura_').val(response.cliente);
					}
					else{
						$('#cliente_factura_').val("--");
						
					}

					//console.log(response.total_compra);
					$('#detalles_orden').html(response.html);
					$("#numero_factura").val(response.factura.numero_factura);
					$("#fecha_factura").val(response.factura.fecha);
					$('#total_costo').val(response.total_compra);
					$('#total_venta').val(response.total_venta);
					$('#os_manager').val(response.factura.os_manager);
					
					if(response.factura.estado_factura_id_estado_factura == 3){
						$("#nula").prop('checked', true);
						$('#botones').html('<input type="submit" class="btn btn-danger" onclick = "this.form.action = \'<?php echo base_url("index.php/transacciones/facturacion/modificar_facturacion");?>\';" value="Editar" />');
					}
					else{
						$("#nula").prop('checked', false);
						$('#botones').html('<input type="submit" class="btn btn-danger" onclick = "this.form.action = \'<?php echo base_url("index.php/transacciones/facturacion/modificar_facturacion");?>\';" value="Editar" /> <a type="button" class="btn btn-info" id="imprimir" href="<?php echo base_url();?>index.php/transacciones/facturacion/imprimir/'+response.factura.numero_factura+'/1" target="_blank"><i class="icon-print icon-white"></i>Imprimir</a>');
					}

					$('#guia_despacho').html(response.guia);

		
					

				}
		});
		$('#Facturas').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			$('#detalles_orden').slideDown('slow');
		
		});
		
		console.log(codigo);
	});
</script>