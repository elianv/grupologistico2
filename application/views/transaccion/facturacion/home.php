<div class="container">
    <legend><h3><center>Facturación</center></h3></legend> 
      <div style="margin-left: 10px">
            <?php 
            
                if(validation_errors()){
                    echo "<div class='alert alert-info '>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
            ?>
      </div>
            <?php
                $correcto = $this->session->flashdata('mensaje');
                if ($correcto){
                    echo "<div class='alert alert-error'>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo "<span id='registroCorrecto'>".$correcto."</span>";
                    echo "</div>";
                }
            ?>
    

    <form class="form-horizontal" method="post" id="target">
        <fieldset>
        
        <div class="row show-grid">
            <div class="span6">
              <div class="control-group">
    						  <label class="control-label"><strong>Factura N°</strong></label>
    						  <div class="controls">
                      <div class="input-append">
        							   <input type="text" class="span2" name="factura_numero" id="numero_factura" placeholder="Solo números" value="<?php echo set_value('factura_numero'); ?>">
                         <a class="btn" id="search_facturas" onclick="search_facturas();" data-target="#Facturas" data-toggle="modal"><i class="icon-search"></i></a>
                      </div>
    						  </div>
    		      </div>
                    
              <div class="control-group">
                        <label class="control-label" for="numero_factura"><strong>Ordenes de Servicio</strong></label>
                        <div class="controls">
                            <div class="">
            						        
            						        <a class="btn" id="search_ordenes" onclick="ordenes_servicios();" data-target="#ordenServicio" data-toggle="modal"><i class="icon-search"></i></a>
        					           </div>
                        </div>
              </div>

                  <div class="control-group">
                    <label class="control-label"><strong>Cliente</strong></label>
                    <div class="controls">
                      <input type="text" class="input-large" name="cliente_factura" id="cliente_factura_" value="<?php echo set_value('cliente_factura'); ?>" readonly="" required>
                    </div>
                  </div>              

                      <div class="control-group">
                        <label class="control-label"><strong>Fecha Factura</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large calendario" name="fecha_factura" value="<?php echo set_value('fecha_factura'); ?>" id="fecha_factura" onclick="calendario();" required>
                        </div>
                      </div> 

              <div id="guia_despacho">
                  <div class="repetir-guia" >
                      <div class="control-group">
                        <label class="control-label"><strong>Guía Despacho</strong></label>
                        <div class="controls">
                          <input type="text" class="input-large" name="guia_despacho[]" id="numero_factura" placeholder="Solo números">
                        </div>
                      </div>

                  </div>                
              </div>

      				<div class="boton-clonar">
      					<a href="#">Agregar otra guía <span>+</span></a>
      				</div>

				
            </div>         
            
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label"><strong>Factura Nula?</strong></label>
                    <div class="controls">
                      <input type="checkbox" id="nula" name="nula" value="">
                    </div>
                  </div>                   

                  <div class="control-group">
                    <label class="control-label"><strong>Valor Total Costo</strong></label>
                    <div class="controls">
                      <input type="text" class="input-large" name="total_costo" id="total_costo" value="<?php echo set_value('total_costo'); ?>" readonly="">
                    </div>
                  </div> 
                  <div class="control-group">
                    <label class="control-label"><strong>Valor Total Venta</strong></label>
                    <div class="controls">
                      <input type="text" class="input-large" name="total_venta" id="total_venta" value="<?php echo set_value('total_venta'); ?>" readonly="">
                    </div>
                  </div>
              </div>
        </div>
        <br>
        <div class="row show-grid">
            
              <legend>Detalles Ordenes</legend>
              <div id="detalles_orden">
              </div>  
            
        </div>
        
        

        <div class="form-actions" id="botones" >
        
            <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/insertar_facturacion'" value="Guardar"/>
            <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/modificar_facturacion'" value="Editar" />
            <div id="imprimir"></div>
        
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
<div class="modal fade modal-large-custom" id="Facturas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Facturas</h4>
            </div>
            <div class="modal-body" id="tabla_Facturas">
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

            function calendario(){
                    $('#fecha_factura').datetimepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,                      
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
                  });              
            };


    function ordenes_servicios(){
      $("#detalles_orden").html("");
      $.ajax({
        method:"POST",
        url:"<?php echo base_url();?>index.php/transacciones/facturacion/ordenes_servicios_ajax",
        success: function(response){
            $('#ordenes').html(response);
            $('#tabla_ordenes').dataTable();
        }

      });
    };

    function search_facturas(){
      $.ajax({
        method:"POST",
        url:"<?php echo base_url();?>index.php/transacciones/facturacion/facturas_ajax",
        success: function(response){
            $('#tabla_Facturas').html(response);
            $('#tabla-facturas').dataTable();
        }

      });        
    };

</script>
