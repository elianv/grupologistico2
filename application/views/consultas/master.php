<legend><h3><center>Master</center></h3></legend>

            <?php
                echo '<div class="container">';
                if(validation_errors()){
                    echo "<div class='alert alert alert-error' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                }
                echo '</div>';
            ?>
<form class="form-horizontal" id="formulario" method="post" action="<?php echo base_url('index.php/consultas/facturadas/generar_master')?>">
	<fieldset>
		<div class="row">
			    <div class="span6 offset4">
			                <div class="control-group">
			                    <label class="control-label"><strong>N° Orden</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" id="check_orden" name="check_orden" value="1"> Filtrar por Orden
									</label>
			                    	<div class="input-append" id="input-orden">
			                    		<input type="text" name="n_orden" id="n_orden" readonly="">
			                    		<a class="btn" id="modal_ordenes" data-target="#modal-ordenes" data-toggle="modal"><i class="icon-search"></i></a>
			                    	</div>
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label"><strong>Factura</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" id="check_factura" name="check_factura" value="1"> Filtrar por Factura
									</label>
			                    	<div class="input-append" id="input-factura">
			                    		<input type="text" name="factura" id="factura" readonly="">
			                    		<a class="btn" id="modal_facturas" data-target="#modal-facturas" data-toggle="modal"><i class="icon-search"></i></a>
			                    	</div>
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label"><strong>Cliente</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="check_cliente" id="check_cliente" value="1"> Filtrar por Cliente
									</label>
			                    	<div class="input-append" id="input-cliente">
			                    		<input type="text" name="cliente" id="cliente" disabled="disabled">
			                    		<a class="btn" id="modal_clientes" data-target="#modal-clientes" data-toggle="modal"><i class="icon-search"></i></a>
			                    		<input type="hidden" name="id-cliente" id="id-cliente" value="">
			                    	</div>
			                    </div>
			                </div>
			                <label class="control-label"><strong>Formato de Salida</strong></label>
			                <div class="controls">
			                    <label class="radio">
			                        <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
			                    </label>
			                    <label class="radio">
			                        <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel
			                    </label>
			                </div>

			    </div>
			    <div class="span6">
			                <div class="control-group">
			                    <label class="control-label"><strong>Nave</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="check_nave" id="check_nave" value="1"> Filtrar por Nave
									</label>
			                    	<div class="input-append" id="input-nave">
			                    		<input type="text" name="nave" id="nave" disabled="disabled">
			                    		<input type="hidden" name="id-nave" id="id-nave">
			                    		<a class="btn" id="modal_naves" data-target="#modal-naves" data-toggle="modal"><i class="icon-search"></i></a>
			                    	</div>
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label"><strong>Puerto Embarque</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="check_puerto" id="check_puerto" value="1"> Filtrar por Puerto
									</label>
			                    	<div class="input-append" id="input-puerto">
			                    		<input type="text" name="puerto" id="puerto" disabled="disabled">
			                    		<input type="hidden" name="id-puerto" id="id-puerto">
			                    		<a class="btn" id="modal_puertos" data-target="#modal-puertos" data-toggle="modal"><i class="icon-search"></i></a>
			                    	</div>
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label"><strong>Contenedor</strong></label>
			                    <div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="check_contenedor" id="check_contenedor" value="1"> Filtrar por Contenedor
									</label>
			                    	<div id="input-contenedor">
			                    		<input type="text" name="contenedor" id="contenedor">
			                    		<p class="help-block">Ingrese el texto o parte del para buscar coinciencias.</p>
			                    	</div>
			                    </div>
			                </div>
			                <label class="control-label"><strong>Periodo de Tiempo</strong></label>
			                <div class="controls">
			                    <label class="radio">
			                        <input type="radio" name="time" id="Todas" value="todas" checked>Todas
			                    </label>
			                    <label class="radio">
			                        <input type="radio" name="time" id="porFechas" value="fechas" >Rango de Fechas
			                    </label>
			                </div>
			                <div id="fechas">
			                    <div class="control-group">
			                        <label class="control-label" for="desde"><strong>Desde :</strong></label>
			                        <div class="controls"><input type="text" id="datepicker" name="desde" class="span2" readonly="" /></div>
			                    </div>
			                    <div class="control-group">
			                        <label class="control-label" for="hasta"><strong>Hasta :</strong></label>
			                        <div class="controls"><input type="text" id="datepicker2" name="hasta" class="span2" readonly="" /></div>
			                    </div>
			                </div>

			    </div>
		</div>
		<div class="form-actions">
			    	<input type="submit" class="btn btn-success offset4" value="Generar"/>
		</div>


		</div>
	</fieldset>
</form>
<!--  MODAL ORDENES  -->
<div class="modal fade modal-large-custom" id="modal-ordenes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Ordenes de Servicio</h4>
            </div>
            <div class="modal-body" id="data-ordenes">
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a id="seleccionar" type="button" class="btn btn-success" data-dismiss="modal">Seleccionar</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--  MODAL CLIENTES  -->
<div class="modal fade modal-large-custom" id="modal-clientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Clientes</h4>
            </div>
            <div class="modal-body" id="data-clientes">
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--  MODAL NAVE  -->
<div class="modal fade modal-large-custom" id="modal-naves" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Naves</h4>
            </div>
            <div class="modal-body" id="data-naves">
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--  MODAL PUERTOS  -->
<div class="modal fade modal-large-custom" id="modal-puertos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Puertos de Embarque</h4>
            </div>
            <div class="modal-body" id="data-puertos">
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--  MODAL FACTURAS  -->
<div class="modal fade modal-large-custom" id="modal-facturas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Facturas</h4>
            </div>
            <div class="modal-body" id="data-facturas">
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a id="seleccionar_facturas" type="button" class="btn btn-success" data-dismiss="modal">Seleccionar</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php if ($tipo) { ?>
	<hr />
	<center><h2>Facturas</h2></center>
		<div style="margin-left: 10px;">
				<table id="tabla-facturas" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N° OS</th>
                                        <th>Cliente</th>
                                        <th>Nave</th>
                                        <th>Referencia</th>
                                        <th>Referencia 2</th>
                                        <th>Mercaderia</th>
                                        <th>Contenedor</th>
                                        <th>Guias</th>
                                        <th>Bodega</th>
                                        <th>Tramo</th>
                                        <th>Fecha Presen.</th>
                                        <th>Proveedor</th>
                                        <th>T. servicio</th>
                                        <th>Fact. Proveedor</th>
                                        <th>P. Costo</th>
                                        <th>Factura Log.</th>
                                        <th>Fecha Factura</th>
                                        <th>P. Venta</th>
                                        <th>Observacion</th>
                                        <th>Margen</th>
                                        <th>Porcentaje</th>
                                        <th>Nota de crédito</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($facturas as $factura) { ?>
	                                        <tr>
	                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$factura['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $factura['id_orden']; ?></a></td>
	                                            <td><?php echo $factura['razon_social']; ?></td>
	                                            <td><?php echo $factura['nombre_nave']; ?></td>
	                                            <td><?php echo $factura['referencia']; ?></td>
	                                            <td><?php echo $factura['referencia_2']; ?></td>
	                                            <td><?php echo $factura['mercaderia']; ?></td>
	                                            <td><?php echo $factura['contenedor']; ?></td>
	                                            <td><?php echo $factura['guia_despacho']; ?></td>
	                                            <td><?php echo $factura['nombre_bodega']; ?></td>
	                                            <td><?php echo $factura['tramo']; ?></td>
	                                            <?php $fecha = new DateTime($factura['fecha_presentacion']); ?>
	                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>
	                                            <td><?php echo $factura['proveedor']; ?></td>
                                              <td></td>
	                                            <td><?php echo $factura['factura_proveedor']; ?></td>
	                                            <td><?php echo '$'.number_format($factura['precio_costo'], 0, ',', '.'); ?></td>
	                                            <td><?php echo $factura['factura_log']; ?></td>
                                              <td><?php echo $factura['fecha']; ?></td>
	                                            <td><?php echo '$'.number_format($factura['precio_venta'], 0, ',', '.'); ?></td>
	                                            <td><?php echo $factura['observacion']; ?></td>
	                                            <td><?php echo '$'.number_format($factura['margen']+$factura['sum'], 0, ',', '.'); ?></td>
	                                            <td><?php echo number_format($factura['porcentaje'], 2, ',', '.').'%.'; ?></td>
	                                            <td><?php echo $factura['nc']; ?></td>
	                                            <td><?php echo '$'.number_format($factura['sum']*(-1),0, ',', '.'); ?></td>
	                                            <!-- <td><?php //echo number_format(($factura['precio_venta'] - $factura['precio_costo'])*100/$factura['precio_costo'],2, ',', '.').'%.' ?></td>-->


	                                        </tr>
	                                        <?php if(isset($factura['otros_servicios'][0])) { ?>
	                                        	<?php foreach ($factura['otros_servicios'] as $otro_servicio) { ?>
			                                        	<tr>
			                                        		<td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$factura['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $factura['id_orden']; ?></a></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <td></td>
				                                            <?php $fecha = new DateTime($factura['fecha_presentacion']); ?>
				                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>
                                                    <td><?php echo( isset($otro_servicio['proveedor'] )?$otro_servicio['proveedor']:''); ?></td>
                                                    <td><?php echo $otro_servicio['descripcion']; ?></td>
				                                            <td><?php echo $otro_servicio['factura_numero_factura'];?></td>
				                                            <td><?php echo '$'.number_format($otro_servicio['valor_costo'], 0, ',', '.'); ?></td>
				                                            <td><?php echo $factura['factura_log']; ?></td>
                                                    <td></td>
				                                            <td><?php echo '$'.number_format($otro_servicio['valor_venta'], 0, ',', '.'); ?></td>
				                                            <td></td>
				                                            <td>$0</td>
				                                            <td>0%</td>
	                                            			<td></td>
	                                            			<td></td>
			                                        	</tr>
	                                        	<?php }?>
	                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                    </table>
		</div>

<?php	} ?>

<script type="text/javascript">
    $(document).ready(function(){
    	$('#datepicker').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
    	$('#datepicker2').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
        $('#tabla-facturas').DataTable();
        $('#fechas').hide();
        $('#input-cliente').hide();
        $('#input-orden').hide();
        $('#input-nave').hide();
        $('#input-puerto').hide();
        $('#input-embarque').hide();
        $('#input-contenedor').hide();
        $('#input-factura').hide();
		$("#check_orden").click(function() {
		        if($("#check_orden").is(':checked')) {
		            $('#input-orden').show();
					$("#check_cliente").attr('checked', false);
					$("#check_nave").attr('checked', false);
					$("#check_puerto").attr('checked', false);
					$("#check_contenedor").attr('checked', false);
					$("#check_factura").attr('checked', false);
					$('#input-factura').hide();
			        $('#input-cliente').hide();
			        $('#input-nave').hide();
			        $('#input-puerto').hide();
			        $('#input-embarque').hide();
			        $('#input-contenedor').hide();
		        }
		        else {
		            $('#input-orden').hide();
		        }
		});
		$("#check_cliente").click(function() {
		        if($("#check_cliente").is(':checked')) {
		            $('#input-cliente').show();
					$("#check_orden").attr('checked', false);
					$("#check_nave").attr('checked', false);
					$("#check_puerto").attr('checked', false);
					$("#check_contenedor").attr('checked', false);
					$("#check_factura").attr('checked', false);
					$('#input-factura').hide();
			        $('#input-orden').hide();
			        $('#input-nave').hide();
			        $('#input-puerto').hide();
			        $('#input-embarque').hide();
			        $('#input-contenedor').hide();
		        }
		        else {
		            $('#input-cliente').hide();
		        }
		});
		$("#check_nave").click(function() {
		        if($("#check_nave").is(':checked')) {
		            $('#input-nave').show();
					$("#check_orden").attr('checked', false);
					$("#check_cliente").attr('checked', false);
					$("#check_puerto").attr('checked', false);
					$("#check_contenedor").attr('checked', false);
					$("#check_factura").attr('checked', false);
					$('#input-factura').hide();
			        $('#input-orden').hide();
			        $('#input-cliente').hide();
			        $('#input-puerto').hide();
			        $('#input-embarque').hide();
			        $('#input-contenedor').hide();
		        }
		        else {
		            $('#input-nave').hide();
		        }
		});
		$("#check_puerto").click(function() {
		        if($("#check_puerto").is(':checked')) {
		            $('#input-puerto').show();
					$("#check_orden").attr('checked', false);
					$("#check_cliente").attr('checked', false);
					$("#check_nave").attr('checked', false);
					$("#check_contenedor").attr('checked', false);
					$("#check_factura").attr('checked', false);
					$('#input-factura').hide();
			        $('#input-orden').hide();
			        $('#input-cliente').hide();
			        $('#input-nave').hide();
			        $('#input-embarque').hide();
			        $('#input-contenedor').hide();
		        }
		        else {
		            $('#input-puerto').hide();
		        }
		});
		$("#check_contenedor").click(function() {
		        if($("#check_contenedor").is(':checked')) {
		            $('#input-contenedor').show();
					$("#check_orden").attr('checked', false);
					$("#check_cliente").attr('checked', false);
					$("#check_nave").attr('checked', false);
					$("#check_puerto").attr('checked', false);
					$("#check_factura").attr('checked', false);
					$('#input-factura').hide();
			        $('#input-orden').hide();
			        $('#input-cliente').hide();
			        $('#input-nave').hide();
			        $('#input-embarque').hide();
			        $('#input-puerto').hide();
		        }
		        else {
		            $('#input-contenedor').hide();
		        }
		});
		$("#check_factura").click(function() {
		        if($("#check_factura").is(':checked')) {
		            $('#input-factura').show();
					$("#check_orden").attr('checked', false);
					$("#check_cliente").attr('checked', false);
					$("#check_nave").attr('checked', false);
					$("#check_puerto").attr('checked', false);
					$("#check_contenedor").attr('checked', false);
					$('#input-contenedor').hide();
			        $('#input-orden').hide();
			        $('#input-cliente').hide();
			        $('#input-nave').hide();
			        $('#input-embarque').hide();
			        $('#input-puerto').hide();
		        }
		        else {
		            $('#input-factura').hide();
		        }
		});
	    $('#Todas').click(function(){

	        $("#Todas").prop("checked", true);
	        $('#fechas').hide();
	        $('#tabla').html("");
	    });
	    $('#porFechas').click(function(){

	        $("#porFechas").prop("checked", true);
	        $('#fechas').show();
	    });
		$('#modal_ordenes').click(function(){
		    $.ajax({
		        method:"POST",
		        url:"<?php echo base_url('index.php/consultas/facturadas/tabla_ordenes_ajax');?>",
		        success: function(response){
		            $('#data-ordenes').html(response);
		            $('#tabla_ordenes').dataTable();
		        }

		    });
		});
		$('#modal_clientes').click(function(){
		    $.ajax({
		        method:"POST",
		        url:"<?php echo base_url('index.php/consultas/facturadas/tabla_clientes_ajax');?>",
		        success: function(response){
		            $('#data-clientes').html(response);
		            $('#tabla_clientes').dataTable();
		        }

		    });
		});
		$('#modal_naves').click(function(){
		    $.ajax({
		        method:"POST",
		        url:"<?php echo base_url('index.php/consultas/facturadas/tabla_naves_ajax');?>",
		        success: function(response){
		            $('#data-naves').html(response);
		            $('#tabla_naves').dataTable();
		        }

		    });
		});
		$('#modal_puertos').click(function(){
		    $.ajax({
		        method:"POST",
		        url:"<?php echo base_url('index.php/consultas/facturadas/tabla_puertos_ajax');?>",
		        success: function(response){
		            $('#data-puertos').html(response);
		            $('#tabla_puertos').dataTable();
		        }

		    });
		});
		$('#modal_facturas').click(function(){
		    $.ajax({
		        method:"POST",
		        url:"<?php echo base_url('index.php/consultas/facturadas/tabla_facturas_ajax');?>",
		        success: function(response){
		            $('#data-facturas').html(response);
		            $('#tabla_facturas').dataTable();
		        }

		    });
		});
    });
</script>
