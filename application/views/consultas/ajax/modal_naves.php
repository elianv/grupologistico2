<div class="tabla-naves">
<table id="tabla_naves" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>C&oacute;digo</th>
			<th>Nave</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($naves as $nave){ ?>
			
				<tr>
                    <td><a class='codigo-click' data-codigo=" <?php echo $nave['codigo_nave'];?> " data-nombre="<?php echo strtoupper($nave['nombre']); ?>" ><?php echo $nave['codigo_nave']; ?></a></td>
                    <td><?php echo strtoupper($nave['nombre']); ?></td>
				</tr>
			
		<?php }?>
	</tbody>

</table>
</div>
<script type="text/javascript">
		$('.table .codigo-click').click(function(e){
			e.preventDefault();
			var codigo = $(this).attr('data-codigo');
			var nombre = $(this).attr('data-nombre');
			console.log(codigo+" - "+nombre);
			$('#nave').val(codigo+" - "+nombre);
			$('#id-nave').val(codigo);
			$('#modal-naves').fadeOut('fast',function(){
				$('body').removeClass('modal-open');
				$('.modal-backdrop.fade.in').remove();
			});
		});	
</script>