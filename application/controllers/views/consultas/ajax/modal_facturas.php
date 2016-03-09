<table id="tabla_facturas" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>Factura</th>
			<th>Seleccionar</th>
			<th>Estado</th>
			<th>Fecha</th>	
		</tr>
	</thead>
	<tbody>
		<?php foreach ($facturas as $factura) { ?>
			
				<tr>
					<td><center><?php echo $factura['numero_factura']; ?></center></td>
					<td align="center"><input class="select_facturas" type="checkbox" value="<?php echo $factura['numero_factura']; ?>" name"facturas[]"></td>
					<?php $date = date_create($factura['fecha']); ?>
					<?php if($factura['estado_factura_id_estado_factura'] == 3) {?>
						<td>Factura Nula</td>
					<?php } elseif($factura['estado_factura_id_estado_factura'] == 2){ ?>
						<td>Facturada</td>
					<?php } elseif($factura['estado_factura_id_estado_factura'] == 1){ ?>
						<td>Por Facturar</td>
					<?php } ?>					
					<td><?php echo date_format($date, 'd-m-Y'); ?></td>
				</tr>
			
		<?php }?>
	</tbody>

</table>

<script type="text/javascript">
	$("#seleccionar_facturas").click(function(){
        //console.log("boton seleccion");
        $('#tabla_ordenes :checked').removeAttr('checked');
        var list = new Array();
		var checkedValues = $('input:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		
		console.log(String(checkedValues).substr(2));
		
		$("#factura").val(String(checkedValues).substr(2));
		$('#modal-facturas').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
			
		
		});
		
    });	
</script>