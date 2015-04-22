<div class="container">
    <legend><h3><center>Facturación</center></h3></legend> 
    <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
    <form class="form-horizontal" method="post">
        <fieldset>
        
        <div class="row show-grid">
            <div class="span5">
              
                <div class="control-group">
						<label class="control-label"><strong>Factura N°</strong></label>
						<div class="controls">
							<input type="text" class="input-large" name="factura_numero" id="numero_factura" placeholder="Solo números">
						</div>
		</div>
                
                <div class="control-group">
                    <label class="control-label" for="numero_factura"><strong>Orden Servicio</strong></label>
                    <div class="controls">
                    <div class="input-append">
						<input type="text" class="span2" id="orden" name="orden_servicio" placeholder="">
						<button class="btn" type="button" data-toggle="modal" href="#modal-orden"><i class="icon-search"></i></button>
					</div>
                    </div>
                </div>
                
                <div class="control-group">
						<label class="control-label"><strong>Valor</strong></label>
						<div class="controls">
							<input type="text" class="input-large" name="valor" id="valor_despacho" placeholder="Solo números">
						</div>
					</div>
                
                <div class="repetir-guia">
					<div class="control-group">
						<label class="control-label"><strong>Guía Despacho</strong></label>
						<div class="controls">
							<input type="text" class="input-large" name="guia_despacho[]" id="numero_factura" placeholder="Solo números">
						</div>
					</div>
                                        <div class="control-group">
                                                <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
                                                <div class="controls">
                                                <div class="input-append">
                                                        <input type="text" class="span2" id="rut" name="proveedor_rut_proveedor" placeholder="">
                                                        <button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button></div>
                                                </div>
                                        </div>
				</div>
				<div class="boton-clonar">
					<a href="#">Agregar otra guía <span>+</span></a>
				</div>
				
            </div>         
            
              <div class="span6" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                          <tr>
                            <th>Nº Factura</th>
                            <th>Estado</th>
			                   </tr>
                      </thead>
                      <tbody>
                              <?php
                              /*
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  
                                  if($tabla['codigo_aduana'] <10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">0".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              } 
                              */
                              ?>
                       </tbody>
                  </table>    
              </div>
        </div>

        <div class="form-actions" >
            <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/insertar_factura'" value="Guardar"/>
            <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/facturacion/modificar_factura'" value="Editar" />
        </div>    
        </fieldset>
    </form>
</div>
