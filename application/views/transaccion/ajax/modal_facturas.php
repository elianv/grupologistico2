<div class="tabla-facturas">
<table id="tabla-facturas" class="table table-bordered table-striped dataTable">
	<thead>
		<tr>
			<th>N° Factura</th>
			<th>Cliente</th>
			<th>Fecha</th>	
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($facturas as $factura) { ?>
			<tr>
				<td><a class="codigo-click" data-codigo="?php echo $factura['numero_factura']; ?>" ><?php echo $factura['numero_factura']; ?></a></td>
				<td><?php //echo $orden['razon_social']; ?></td>
				<td><?php //echo $orden['fecha']; ?></td>
				<td><?php echo $factura['estado_factura_id_estado_factura']; ?></td>
			</tr>
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
</script>