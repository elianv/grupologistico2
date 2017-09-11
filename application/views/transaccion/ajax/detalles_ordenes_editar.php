<div id="ordenes">    
  <?php foreach ($ordenes as $orden) { ?>
    <h3><b>N° Orden :<?php echo $orden[0]['id_orden'];?></b></h3>
    <div>

                      <input type="hidden" name="id_orden[]" value="<?php echo $orden[0]['id_orden'];?>">
                      <div class="control-group">
                        <label class="control-label"><strong>Factura Proveedor</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="factura_tramo[]" id="factura_tramo" value="<?php echo $orden['factura_tramo'];?>" required>
                        </div>
                      </div>  
                      <div class="control-group">
                        <label class="control-label"><strong>Fecha Factura</strong></label>
                        <div class="controls">
                        <?php $date = date_create($orden['fecha_factura']); ?>
                          <input type="text" class="input-large calendario" name="fecha_factura_tramo[]" value="<?php echo date_format($date, 'd-m-Y'); ?>" required>
                        </div>
                      </div>                       

                      <div class="control-group">
                        <label class="control-label"><strong>Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="span5" name="Tramo[]" id="Tramo" value="<?php echo $orden['tramo']['descripcion']; ?>" readonly="" required>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label"><strong>Proveedor</strong></label>
                        <div class="controls">
                          <input type="text" class="span8" name="proveedor_tramo" id="proveedor_tramo" value="<?php echo $orden[0]['proveedor_rut_proveedor']." - ".$orden['proveedor'][0]['razon_social']; ?>" readonly="" required>
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label"><strong>Costo Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_costo_tramo" id="total_costo" value="<?php echo number_format($orden[0]['valor_costo_tramo'],0,'','.'); ?>" readonly="" required>
                        </div>
                      </div> 

                      <div class="control-group">
                        <label class="control-label"><strong>Venta Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_venta_tramo" id="total_venta" value="<?php echo number_format($orden[0]['valor_venta_tramo'],0,'','.'); ?>"  readonly="" required>
                        </div>
                      </div>               
                      <br /> 
                      <?php if(isset($orden['detalle'][0])){ ?>
                          <hr>
                          <strong>Otros Servicios</strong>
                          <br />
                      <?php }?>
                      <?php $detalles = $orden['detalle']; ?>
                      
                      <?php foreach ($detalles as $detalle) { ?>

                          <input type="hidden" name="id_detalle[]" value="<?php echo $detalle['id_detalle']; ?>">
                          <input type="hidden" name="id_orden_detalle[]" value="<?php echo $orden[0]['id_orden'];?>">
                          <br />
                          <div class="control-group">
                            <label class="control-label"><strong>Proveedor</strong></label>
                            <div class="controls">
                              <div>
                                <div class="proveedor_otros_servicios">
                                  <input type="text" class="span8" name="proveedor_servicio[]" id="proveedor_servicio" readonly="" value="<?php echo $detalle['proveedor']; ?>" required>
                                  <a class="btn search_proveedores" data-target="#Proveedores" data-toggle="modal"><i class="icon-search"></i></a>
                                </div>
                                  
                              </div>
                            </div>
                          </div>                          
                          <div class="control-group">
                            <label class="control-label"><strong>Factura Proveedor</strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="factura_otros_servicios[]" value="<?php echo $detalle['factura']; ?>" required>
                            </div>
                          </div>    
                          <div class="control-group">
                            <label class="control-label"><strong>Fecha Factura</strong></label>
                            <div class="controls">
                              <?php $date = date_create($detalle['fecha']); ?>
                              <input type="text" class="input-large calendario" name="fecha_otros_servicios[]" value="<?php echo date_format($date, 'd-m-Y'); ?>" required>
                            </div>
                          </div>  
                          <div class="control-group">
                            <label class="control-label"><strong>Descripcion</strong></label>
                            <div class="controls">
                              <input type="text" class="span5" name="descripcion_otros_servicios[]" value="<?php echo $detalle['descripcion']; ?>" readonly required>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label"><strong>Costo </strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="total_costo_otros_servicios[]" value="<?php echo number_format($detalle['valor_costo'],0,'','.'); ?>" readonly="" required>
                            </div>
                          </div> 

                          <div class="control-group">
                            <label class="control-label"><strong>Venta </strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="total_venta_otros_servicios[]" value="<?php echo number_format($detalle['valor_venta'],0,'','.'); ?>"  readonly="" required>
                            </div>
                          </div>        
                          <hr>
                      
                      <?php }?>
                      <strong>TOTAL ORDEN SERVICIO</strong>
                      <br />
                      <div class="control-group">
                        <label class="control-label"><strong>Total Costo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_costo_factura[]" value="<?php echo number_format($orden['total_compra'],0,'','.'); ?>" readonly="" required>
                        </div>
                      </div> 

                      <div class="control-group">
                        <label class="control-label"><strong>Total Venta</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_venta_factura[]" value="<?php echo number_format($orden['total_venta'],0,'','.'); ?>" readonly="" required>
                        </div>
                      </div>                         
    </div>
  <?php }?> 
</div>    

<?php //"<pre>".print_r($detalles)."</pre>";?>

<div class="modal fade modal-large-custom" id="Proveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                  $(function() {
                    $( "#ordenes" ).accordion({
                       heightStyle: "content",
                       collapsible: true
                    });
                    $('.calendario').datetimepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,                      
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
                       
                    });
                  });
                    
    
                    $('.search_proveedores').click(function(){
                        $(this).parent().addClass('activo');
                        $.ajax({
                          method:"POST",
                          url:"<?php echo base_url();?>index.php/transacciones/facturacion/proveedores_ajax",
                          success: function(response){
                              $('#proveedores').html(response);
                              $('#tabla_proveedores').DataTable();
                          }

                      });                        
                    });       
              </script>
