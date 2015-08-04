<div id="modal-naviera" class="modal hide fade in" style="display: none;" >
	<div class="modal-header">
		<a data-dismiss="modal" class="close">×</a>
		<h3><center>Seleccione una Naviera </center></h3>
	</div>

	<div class="modal-body">

		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable" id="example-naviera">
			<thead>
			<tr>
				<th>Código</th>
				<th>Nombre Naviera</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($navieras as $tabla)
				{
					echo "<tr>";
					echo "<td><a class='codigo-click' data-codigo='".$tabla['codigo_naviera']."'>".$tabla['codigo_naviera']."</a></td>";
					echo "<td>".strtoupper($tabla['nombre'])."</td>";
					echo "</tr>";
				}
				?>
			</tbody>

		</table>
	</div>
    
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
	</div>

</div>