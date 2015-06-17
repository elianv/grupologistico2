<div class="tabla-proveedores">
	<table id="tabla_proveedores" class="table table-bordered table-striped dataTable">
		<thead>
			<tr>
				<th>RUT</th>
				<th>Raz&oacute;n Social</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach ($proveedores as $proveedor) { ?>
					<tr>
						<td><a><?php echo $proveedor['rut_proveedor']?></a></td>
						<td><?php echo $proveedor['razon_social']?></td>
					</tr>
				<?php }?>
		</tbody>
	</table>
</div>