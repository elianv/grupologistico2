<div id="ordenes">
  <?php foreach ($ordenes as $orden) { ?>
    <h3><b>N° Orden :<?php echo $orden[0]['id_orden'];?></b></h3>
    <div>
                      <div class="control-group">
                        <label class="control-label"><strong>Factura Proveedor</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="factura_tramo[]" id="factura_tramo" >
                        </div>
                      </div>  
                      <div class="control-group">
                        <label class="control-label"><strong>Fecha Factura</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="fecha_factura[]" id="fecha_factura">
                        </div>
                      </div>                       

                      <div class="control-group">
                        <label class="control-label"><strong>Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="span5" name="Tramo[]" id="Tramo[]" value="<?php echo $orden['tramo']['descripcion']; ?>" readonly="">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label"><strong>Proveedor</strong></label>
                        <div class="controls">
                          <input type="text" class="span8" name="proveedor_tramo" id="proveedor_tramo" value="<?php echo $orden[0]['proveedor_rut_proveedor']." - ".$orden['proveedor'][0]['razon_social']; ?>" readonly="">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label"><strong>Costo Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_costo" id="total_costo" value="<?php echo number_format($orden[0]['valor_costo_tramo'],0,'','.'); ?>" readonly="">
                        </div>
                      </div> 

                      <div class="control-group">
                        <label class="control-label"><strong>Venta Tramo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_venta" id="total_venta" value="<?php echo number_format($orden[0]['valor_venta_tramo'],0,'','.'); ?>"  readonly="">
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
                          
                          <br />
                          <div class="control-group">
                            <label class="control-label"><strong>Factura Proveedor</strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="factura_otros_servicios[]" id="factura_otros_servicios" >
                            </div>
                          </div>    
                          <div class="control-group">
                            <label class="control-label"><strong>Fecha Factura</strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="factura_otros_servicios[]" id="factura_otros_servicios" >
                            </div>
                          </div>  
                          <div class="control-group">
                            <label class="control-label"><strong>Descripcion</strong></label>
                            <div class="controls">
                              <input type="text" class="span5" name="factura_otros_servicios[]" value="<?php echo $detalle['descripcion']; ?>" id="factura_otros_servicios" readonly>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label"><strong>Costo </strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="total_costo" id="total_costo" value="<?php echo number_format($detalle['valor_costo'],0,'','.'); ?>" readonly="">
                            </div>
                          </div> 

                          <div class="control-group">
                            <label class="control-label"><strong>Venta </strong></label>
                            <div class="controls">
                              <input type="text" class="input-large" name="total_venta" id="total_venta" value="<?php echo number_format($detalle['valor_venta'],0,'','.'); ?>"  readonly="">
                            </div>
                          </div>        
                          <hr>
                      
                      <?php }?>
                      <strong>TOTAL ORDEN SERVICIO</strong>
                      <br />
                      <div class="control-group">
                        <label class="control-label"><strong>Total Costo</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_costo" value="<?php echo number_format($orden['total_compra'],0,'','.'); ?>" id="total_costo" readonly="">
                        </div>
                      </div> 

                      <div class="control-group">
                        <label class="control-label"><strong>Total Venta</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="total_venta" value="<?php echo number_format($orden['total_venta'],0,'','.'); ?>" id="total_venta" readonly="">
                        </div>
                      </div>                         
    </div>
  <?php } ?>                      
</div>

              <script type="text/javascript">
                  $(function() {
                    $( "#ordenes" ).accordion({
                       heightStyle: "content",
                       collapsible: true
                    });
                    $('#fecha_factura').datetimepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,                      
                        showMinute:false,
                        showTime: false
                       
                    });
                  });
              </script>
