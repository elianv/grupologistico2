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
						<td><a class="codigo-click" data-codigo="<?php echo $proveedor['rut_proveedor']." - ".$proveedor['razon_social']?>" ><?php echo $proveedor['rut_proveedor']?></a></td>
						<td><?php echo $proveedor['razon_social']; ?></td>
					</tr>
				<?php }?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('.tabla-proveedores .codigo-click').click(function(e){
		e.preventDefault();
		var codigo = $(this).attr('data-codigo');
		//$('.form-left-puertos #codigo_puerto').attr('value', codigo);
		console.log(codigo);
		$('.activo #proveedor_servicio').attr( "value", codigo );
		$('#Proveedores').fadeOut('fast',function(){
			$('body').removeClass('modal-open');
			$('.modal-backdrop.fade.in').remove();
		});
	});

</script>