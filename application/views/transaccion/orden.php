<div class="container">
        
    <legend><h3><center>Orden de Servicio</center></h3></legend>
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
          <form class="form-horizontal form-orden" method="post">
           <fieldset>  
               
            <div class="row show-grid">
                <div class="span5">
                     <div class="control-group">
                         <label class="control-label" for="numero_orden"><strong>O.S. N°</strong></label>
                        <div class="controls">
                           
                              <?php echo "<div class='input-append'><input type='text' class='span2' name='numero_orden' id='numero_orden' placeholder='Solo números' value=".$numero_orden."><button class='btn' type='button' data-toggle='modal' href='#modal-orden'><i class='icon-search'></i></button></div>"; ?>
                            
                        </div>
                     </div>
               <div class="control-group">
                <label class="control-label" for="referencia"><strong>Referencia</strong></label>
                <div class="controls">
                 <input type="text" name="referencia" id="referencia" placeholder="">
                </div>
            </div>
                </div>
                

        
                <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="tipo_factura"><strong>Tipo</strong></label>
                    <div class="controls">
                       <select id="tipo_factura" name="tipo_factura" class="span2">
                           <?php
                                  // print_r(tfacturacion[0]);
                                   foreach ($tfacturacion as $tipo){
                                       
                                       echo "<option>".$tipo['tipo_orden']."</option>";
                                       
                                   }
                                
                                
                           ?>
                       </select>
                    </div>
                 </div>
                    
                     <div class="control-group">
                        <label class="control-label" for="fecha"><strong>Fecha</strong></label>
                        <div class="controls">
                            <input type="text" class="span2" name="fecha" id="fecha" placeholder="Seleccione">
                        </div>
                     </div> 
                    
                </div>
            </div>
                

              
            	
               

               </br>
               </br>
<!--   ##############################################################    -->     

            <div class="control-group">
                <label class="control-label" for="cliente"><strong>RUT Cliente</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="cliente" name="cliente" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-cliente"><i class="icon-search"></i></button></div>
                </div>
            </div>

                <div class="row show-grid">
                    <div class="span3">
                        <div class="control-group booking">
                            <label class="control-label" for="booking"><strong>Booking</strong></label>
                            <div class="controls">
                                <input type="text" class="span2" id="booking" name="booking" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            
                            <label class="control-label" for="referencia"><strong>Referencia</strong></label>
                            <div class="controls">
                                 <input type="text" class="span4" id="referencia" name="referencia" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Aduana</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xlarge" id="aduana" name="aduana" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-aduana"><i class="icon-search"></i></button></div>
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" for="cliente"><strong>Nave</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="nave" name="nave" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-nave"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group tramo">
                <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="tramo" name="tramo" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-tramo"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" id="valores_tramo" name="valores_tramo[]" value=1 style="margin-left: 158px">Usar los Precios de Mantención, para Tramo
                </label>
            </div>
            <div class="row show-grid">
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="valor_costo_tramo"><strong>Valor Costo</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="valor_costo_tramo" name="valor_costo_tramo" placeholder="$">
                </div>
            </div>
             </div>
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="valor_venta_tramo"><strong>Valor Venta</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="valor_venta_tramo" name="valor_venta_tramo" placeholder="$">
                </div>
            </div>
             </div>
         </div>

               </br>
               </br>
               </br>

<!--   ##############################################################    -->  
         <div class="row show-grid">
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="carga"><strong>Carga</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="span2" id="carga" name="carga" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-carga"><i class="icon-search"></i></button></div>
                </div>
            </div>
             </div>
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="numero"><strong>N°</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="numero" name="numero" placeholder="">
                </div>
            </div>
             </div>
         </div>
               
         <div class="row show-grid">
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="peso"><strong>Peso</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="peso" name="peso" placeholder="">
                </div>
            </div>
             </div>
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="set_point"><strong>Set Point</strong></label>
                <div class="controls">
                 <input type="text" class="span2" id="set_point" name="set_point" placeholder="">
                </div>
            </div>
             </div>
         </div>
            <div class="control-group ret">
                <label class="control-label" for="contenedor"><strong>Ret. Contenedor</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="contenedor" name ="contenedor" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="observacion"><strong>Mercaderia</strong></label>
                <div class="controls">
                     <textarea class="input-xxlarge" id="mercaderia" name="mercaderia" rows="3"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="fecha_prensentacion"><strong>Fecha Presentación</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="fecha_presentacion" name="fecha_prensentacion" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-bodega"><i class="icon-search"></i></button></div>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Depósito</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="deposito" name="deposito" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-deposito"><i class="icon-search"></i></button></div>
                </div>
            </div>               

               <div class="row show-grid">
                   <div class="span5">
                        <div class="control-group destino">
                            <label class="control-label" for="destino"><strong>Destino</strong></label>
                            <div class="controls">
                                <input type="text" class="input-large" id="destino" name="destino" placeholder="">
                              </div>
                        </div>
                   </div>
                   
                   <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="puerto"><strong>Puerto Embarque</strong></label>
                        <div class="controls">
                            <div class="input-append"><input type="text" class="span2" id="puerto" name="puerto" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-puerto"><i class="icon-search"></i></button></div>
                        </div>
                        </div>
                   </div>
                   
               </div>
<div class="row show-grid">
    
    <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="referencia"><strong>Referencia 2</strong></label>
                        <div class="controls">
                            <input type="text" class="input-large" id="referencia2" name="referencia2" placeholder="">
                        </div>
                        </div>        
    </div>
    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="rut" name="rut" placeholder="sin puntos, ni guion"><button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button></div>
                            </div>
                        </div>
    </div>
    
</div>

               
                        <div class="control-group">
                            <label class="control-label" for="observacion"><strong>Observación</strong></label>
                            <div class="controls">
                             <textarea class="input-xxlarge" id="observacion" name="observacion" rows="3"></textarea>
                            </div>
                        </div>
						
						<div class="campo-a-repetir">

							<div class="control-group">
								<label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
								<div class="controls">
									<div class="input-append">
										<input type="text" class="input-xxlarge" id="servicio" name="servicio[]" >
										<button class="btn" type="button" data-toggle="modal" href="#modal-servicio">
											<i class="icon-search"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="control">
								<label class="checkbox">
									<input type="checkbox" id="valores_servicio" name="valores_servicio[]" value=1   style="margin-left: 158px">Usar los Precios de Mantención, para Otro Servicio
								</label>
							</div>
							<div class="row show-grid">
								 <div class="span5">    
									<div class="control-group">
										<label class="control-label" for="valor_costo_servicio"><strong>Valor Costo</strong></label>
										<div class="controls">
											<input type="text" class="span2" id="valor_costo_servicio" name="valor_costo_servicio[]" placeholder="$">
										</div>
									</div>
								 </div>
							<div class="span5">
								<div class="control-group">
									<label class="control-label" for="valor_venta_servicio"><strong>Valor Venta</strong></label>
									<div class="controls">
										<input type="text" class="span2" id="valor_venta_servicio" name="valor_venta_servicio[]" placeholder="$">
									</div>
								</div>
							 </div>
							</div>
						</div>
						
						<div class="boton-repetir">
							<a href="#">Agregar otro Servicio <span>+</span></a>
						</div>
               </br>
               </br>
               </br>
               
               <!--   #########################################################################    -->
        <div class="row show-grid">
                    
          <div class="span5">
           <div class="control-group">
                <label class="control-label" for="conductor"><strong>Conductor</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="span2" id="conductor" name="conductor" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-conductor"><i class="icon-search"></i></button></div>
                </div>
           </div>
         </div>
            
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="patente"><strong>Patente</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" placeholder="AAAA11 ó 1111AA"><button class="btn" type="button" data-toggle="modal" href="#modal-camion"><i class="icon-search"></i></button></div>
                            </div>
                        </div>
                    </div>
       </div>
          

               <div class="form-actions" >
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/guardar'" value="Guardar"/>
                <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar'" value="Editar" />
               </div>
           </fieldset>
          </form>
</div>
