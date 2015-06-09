<div class="container">
    <legend><h3><center>Facturación</center></h3></legend> 
    <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
    <form class="form-horizontal" method="post">
        <fieldset>
        
        <div class="row show-grid">
            <div class="span6">
              <div class="control-group">
    						  <label class="control-label"><strong>Factura N°</strong></label>
    						  <div class="controls">
                      <div class="input-append">
        							   <input type="text" class="span2" name="factura_numero" id="numero_factura" placeholder="Solo números">
                         <a class="btn" id="search_ordenes" onclick="facturas();" data-target="#ordenServicio" data-toggle="modal"><i class="icon-search"></i></a>
                      </div>
    						  </div>
    		      </div>
                    
              <div class="control-group">
                        <label class="control-label" for="numero_factura"><strong>Orden Servicio</strong></label>
                        <div class="controls">
                            <div class="input-append">
            						        <input type="text" class="span2" id="orden" name="orden_id_orden" readonly="">
            						        <a class="btn" id="search_ordenes" onclick="ordenes_servicios();" data-target="#ordenServicio" data-toggle="modal"><i class="icon-search"></i></a>
        					           </div>
                        </div>
              </div>
 
              <div class="repetir-guia">
        					<div class="control-group">
        						<label class="control-label"><strong>Guía Despacho</strong></label>
        						<div class="controls">
        							<input type="text" class="input-large" name="guia_despacho[]" id="numero_factura" placeholder="Solo números">
        						</div>
    					    </div>

    				  </div>
      				<div class="boton-clonar">
      					<a href="#">Agregar otra guía <span>+</span></a>
      				</div>

				
            </div>         
            
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label"><strong>Valor Total Costo</strong></label>
                    <div class="controls">
                      <input type="text" class="input-large" name="valor" id="valor_total" readonly="">
                    </div>
                  </div> 
                  <div class="control-group">
                    <label class="control-label"><strong>Valor Total Venta</strong></label>
                    <div class="controls">
                      <input type="text" class="input-large" name="valor" id="valor_total" readonly="">
                    </div>
                  </div>
              </div>
        </div>
        <br>
        <div class="row show-grid">
            <div class="span12">
              <legend>Detalles Ordenes</legend>
              <div id="detalles_orden">
              </div>  
            </div>
        </div>
        
        

        <div class="form-actions" >
            <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/insertar_facturacion'" value="Guardar"/>
            <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/modificar_facturacion'" value="Editar" />
        </div>    
        </fieldset>
    </form>
</div>
<!-- MODAL ORDENES-->
<div class="modal fade modal-large-custom" id="ordenServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Ordenes de Servicio</h4>
            </div>
            <div class="modal-body" id="ordenes">
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
<!-- /.modal -->
<!-- MODAL PROVEEDORES -->
<div class="modal fade modal-large-custom" id="RutProveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Proveedores</h4>
            </div>
            <div class="modal-body" id="proveedores">
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


<script type="text/javascript">
    function ordenes_servicios(){

      $.ajax({
        method:"POST",
        url:"<?php echo base_url();?>index.php/transacciones/facturacion/ordenes_servicios_ajax",
        success: function(response){
            $('#ordenes').html(response);
            $('#tabla_ordenes').dataTable();
        }

      })
    };

    function proveedores(){
      $.ajax({
        method:"POST",
        url:"<?php echo base_url();?>index.php/transacciones/facturacion/proveedores_ajax",
        success: function(response){
            $('#proveedores').html(response);
            $('#tabla_proveedores').dataTable();
        }

      })      
    };

    $("#seleccionar").click(function(){
        console.log("boton seleccion");
    });



   
</script>
