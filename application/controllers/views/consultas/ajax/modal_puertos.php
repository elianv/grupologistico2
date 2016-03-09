<div class="tabla-naves">
<table id="tabla_puertos" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>C&oacute;digo</th>
			<th>Puerto</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($puertos as $puerto){ ?>
			
				<tr>
                    <td><a class='codigo-click' data-codigo=" <?php echo $puerto['codigo_puerto'];?> " data-nombre="<?php echo strtoupper($puerto['nombre']); ?>" ><?php echo $puerto['codigo_puerto']; ?></a></td>
                    <td><?php echo strtoupper($puerto['nombre']); ?></td>
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
			$('#puerto').val(codigo+" - "+nombre);
			$('#id-puerto').val(codigo);
			$('#modal-puertos').fadeOut('fast',function(){
				$('body').removeClass('modal-open');
				$('.modal-backdrop.fade.in').remove();
			});
		});	
</script>