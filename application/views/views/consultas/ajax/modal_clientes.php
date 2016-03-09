<div class="tabla-clientes">
<table id="tabla_clientes" class="table table-condensed table-bordered">
            <thead>
              <tr>
                  <th>RUT</th>
                  <th>Razón Social</th>
              </tr>
            </thead>
            <tbody>
                    <?php
                    foreach ($clientes as $cliente){
                        echo "<tr>";
                        echo "<td><a class='codigo-click' data-rs='".$cliente['razon_social']."' data-codigo='".$cliente['rut_cliente']."'>".strtoupper($cliente['rut_cliente'])."</a></td>";
                        echo "<td>".$cliente['razon_social']."</td>";
                    }
                    ?>
             </tbody>

</table>
</div>
<script type="text/javascript">
		$('.table .codigo-click').click(function(e){
			e.preventDefault();
			var codigo = $(this).attr('data-codigo');
			var rs = $(this).attr('data-rs');
			console.log(codigo+" - "+rs);
			$('#cliente').val(codigo+" - "+rs);
      $('#id-cliente').val(codigo);
			$('#modal-clientes').fadeOut('fast',function(){
				$('body').removeClass('modal-open');
				$('.modal-backdrop.fade.in').remove();
			});
		});	
</script>