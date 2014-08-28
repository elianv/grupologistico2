<div class="container">

	<legend><h3><center>Editar Orden de Servicio</center></h3></legend>
	
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
            $correcto = $this->session->flashdata('sin_orden');
            if ($correcto){
                echo "<div class='alert alert-error'>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
        ?>
        
		<form class="form-horizontal form-orden" method="post">
			<fieldset>  
			<div class="row show-grid">
				<div class="span5">
					<div class="control-group">
						
                                            <label class="control-label" for="numero_orden"><strong>O.S. N°</strong></label>
                                            <div class="controls">
                                                <?php echo "<div class='input-append'><input type='text' disabled='disabled' class='span2' name='numero_orden' id='numero_orden' placeholder=".$numero_orden."></div>"; ?>
                                            </div>
						
					</div>
					<div class="control-group">
						<label class="control-label" for="referencia"><strong>Referencia</strong></label>
						<div class="controls">
							<input type="text" class="input-xxlarge" name="referencia" id="referencia" value = "<?php echo $orden[0]['referencia']; ?>">
						</div>
					</div>
				</div>
			
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="tipo_factura"><strong>Tipo</strong></label>
						<div class="controls">
						   <select id="tipo_factura" name="tipo_orden" class="span2">
								<?php
									// print_r(tfacturacion[0]);
									foreach ($tfacturacion as $tipo){
                                                                                if($orden[0]['tipo_orden_id_tipo_orden'] == $tipo['id_tipo_orden']){
                                                                                    echo "<option selected>".$tipo['tipo_orden']."</option>";
                                                                                }
                                                                                else{
                                                                                    echo "<option>".$tipo['tipo_orden']."</option>";
                                                                                }
									}
								?>
							</select>
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
                    <div class="input-append">
						<input type="text" class="span2" id="cliente" name="cliente_rut_cliente" value="<?php echo $orden[0]['cliente_rut_cliente']; ?>">
						<button class="btn" type="button" data-toggle="modal" href="#modal-cliente"><i class="icon-search"></i></button>
						<input class="nombre-cliente" type="text" disabled="disabled" value="<?php echo $cliente[0]['razon_social']; ?>" placeholder="Nombre Cliente..."/>
					</div>
                </div>
            </div>

                <div class="row show-grid">
                    <div class="span3">
                        <div class="control-group booking">
                            <label class="control-label" for="booking"><strong>Booking</strong></label>
                            <div class="controls">
                                <input type="text" class="input-xxlarge" id="booking" name="booking" value="<?php echo $orden[0]['booking']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                        </div>
                    </div>
                </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Aduana</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xlarge" id="aduana" name="aduana_codigo_aduana" value="<?php echo $aduana[0]['codigo_aduana']." - ".$aduana[0]['nombre']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-aduana"><i class="icon-search"></i></button></div>
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" for="Nave"><strong>Nave</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="nave" name="nave_codigo_nave" value="<?php echo $nave[0]['codigo_nave']." - ".$nave[0]['nombre']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-nave"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Naviera"><strong>Naviera</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="naviera" name="naviera_codigo_naviera" value="<?php //echo $naviera[0]['codigo_naviera']." - ".$naviera[0]['nombre']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-naviera"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group tramo">
                <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="tramo" name="tramo_codigo_tramo" value="<?php echo $tramo[0]['codigo_tramo']." - ".$tramo[0]['descripcion']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-tramo"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="row show-grid">
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="valor_costo_tramo"><strong>Valor Costo</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="valor_costo_tramo" name="valor_costo_tramo" value="<?php echo number_format($orden[0]['valor_costo_tramo'], 0, ',', '.') ?>">
                </div>
            </div>
             </div>
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="valor_venta_tramo"><strong>Valor Venta</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="valor_venta_tramo" name="valor_venta_tramo" value="<?php echo number_format($orden[0]['valor_venta_tramo'], 0, ',', '.') ?>">
                </div>
            </div>
             </div>
         </div>

               </br>


<!--   ##############################################################    -->  
            <div class="control-group">
                <label class="control-label" for="fecha"><strong>Fecha Carga</strong></label>
                <div class="controls">
					<input type="text" class="input-large" name="fecha_carga" id="fecha_carga" placeholder="Seleccione Fecha">
                </div>
            </div> 
 
            <div class="control-group">
                <label class="control-label" for="carga"><strong>Carga</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="carga" name="tipo_carga_codigo_carga" value="<?php echo $carga[0]['codigo_carga']." - ".$carga[0]['descripcion']; ?>">
                        <button class="btn" type="button" data-toggle="modal" href="#modal-carga">
                                <i class="icon-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="observacion"><strong>Mercaderia</strong></label>
                <div class="controls">
                     <textarea class="input-xxlarge" id="mercaderia" name="mercaderia" rows="3"><?php echo $orden[0]['mercaderia']; ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="numero"><strong>N° Contenedor</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="numero" name="numero" value="<?php echo $orden[0]['numero']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="peso"><strong>Peso</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="peso" name="peso" value="<?php echo $orden[0]['peso']; ?>">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="set_point"><strong>Set Point</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="set_point" name="set_point" value="<?php echo $orden[0]['set_point']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Depósito</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="deposito" name="deposito_codigo_deposito" value="<?php echo $deposito[0]['codigo_deposito']." - ".$deposito[0]['descripcion']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-deposito"><i class="icon-search"></i></button></div>
                </div>
            </div>   

               
            <div class="control-group">
                <label class="control-label" for="fecha_presentacion"><strong>Fecha Presentación</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="fecha" name="fecha" value="<?php echo $orden[0]['fecha']; ?>">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega_codigo_bodega" value="<?php echo $bodega[0]['codigo_bodega']." - ".$bodega[0]['nombre']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-bodega"><i class="icon-search"></i></button></div>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="puerto"><strong>Puerto Embarque</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="puerto" name="puerto_codigo_puerto" value="<?php echo $puerto_embarque[0]['codigo_puerto']." - ".$puerto_embarque[0]['nombre']; ?>">
                	<button class="btn" type="button" data-toggle="modal" href="#modal-puerto"><i class="icon-search"></i></button>
                    </div>
                </div>
            </div>           

            <div class="control-group destino">
                <label class="control-label" for="destino"><strong>Puerto Destino</strong></label>
                    <div class="controls">
                        <div class="input-append"><input type="text" class="input-xxlarge" id="destino" name="destino" value="<?php echo $destino[0]['codigo_puerto']." - ".$destino[0]['nombre']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-destino"><i class="icon-search"></i></button></div>
                    </div>
            </div>

<div class="row show-grid">
    
    <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="referencia"><strong>Referencia 2</strong></label>
                        <div class="controls">
                            <input type="text" class="input-large" id="referencia2" name="referencia2" value="<?php echo $orden[0]['referencia']; ?>">
                        </div>
                        </div>        
    </div>
    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="rut" name="proveedor_rut_proveedor" value="<?php echo $proveedor[0]['rut_proveedor']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button></div>
                            </div>
                        </div>
    </div>
    
</div>

               
                        <div class="control-group">
                            <label class="control-label" for="observacion"><strong>Observación</strong></label>
                            <div class="controls">
                             <textarea class="input-xxlarge" id="observacion" name="observacion" rows="3"><?php echo $orden[0]['observacion']; ?></textarea>
                            </div>
                        </div>
						<?php foreach($detalles as $detalle){ ?>
						<div class="campo-a-repetir original">

							<div class="control-group">
								<label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
								<div class="controls">
									<div class="input-append">
										<input type="text" class="input-xxlarge" id="servicio" name="codigo_servicio[]" value="<?php echo $detalle['servicio_codigo_servicio']." - ".$detalle['descripcion']; ?>" >
                                                                                <input type="hidden" id="id_detalle" name="id_detalle[]" value="<?php echo $detalle['id_detalle']; ?>">
										<button class="btn" type="button" data-toggle="modal" href="#modal-servicio"><i class="icon-search"></i></button>
									</div>
								</div>
							</div>

							<div class="row show-grid">
								 <div class="span5">    
									<div class="control-group">
										<label class="control-label" for="valor_costo_servicio"><strong>Valor Costo</strong></label>
										<div class="controls">
										<input type="text" class="span2" id="valor_costo_servicio" name="valor_costo_servicio[]" value="<?php echo number_format($detalle['valor_costo'], 0, ',', '.') ?>">
										</div>
									</div>
								 </div>
							<div class="span5">
								<div class="control-group">
									<label class="control-label" for="valor_venta_servicio"><strong>Valor Venta</strong></label>
									<div class="controls">
									<input type="text" class="span2" id="valor_venta_servicio" name="valor_venta_servicio[]" value="<?php echo number_format($detalle['valor_venta'], 0, ',', '.') ?>">
									</div>
								</div>
							 </div>
							</div>
							
							<div class="eliminar-campo">
								<a href="javascript:void(0);">Eliminar Servicio <span>-</span></a>
							</div>
						
						</div>
                                                <?php } ?>
                                                
                                                        <div class="boton-repetir">
                                                            <a href="#">Agregar otro Servicio <span>+</span></a>
                                                        </div>
 
						
						
               </br>
               </br>
               </br>
               
               <!--   #########################################################################    -->
        <div class="row show-grid">
                    
          <div class="span12">
           <div class="control-group">
                <label class="control-label" for="conductor"><strong>Conductor</strong></label>
                <div class="controls">
                    <div class="input-append">
						<input type="text" class="span2" id="conductor" name="conductor_rut" value="<?php echo $conductor[0]['rut']; ?>">
						<button class="btn" type="button" data-toggle="modal" href="#modal-conductor">
							<i class="icon-search"></i>
						</button>
						<input class="nombre-conductor"  type="text" value="<?php echo $conductor[0]['descripcion']; ?>" disabled="disabled"/>
					</div>
                </div>
           </div>
         </div>
            
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="patente"><strong>Patente</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" value="<?php echo $camion[0]['patente']; ?>"><button class="btn" type="button" data-toggle="modal" href="#modal-camion"><i class="icon-search"></i></button></div>
                                <input type="hidden" name="camion_camion_id" id="camion_id" value="<?php echo $camion[0]['camion_id']; ?>">
                                <input type="hidden" name="viaje_id" id="viaje_id" value="<?php echo $viaje[0]['id_viaje']; ?>">
                            </div>
                        </div>
                    </div>
       </div>
          
               
               <div class="form-actions" >
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar'" value="Modificar"/>

               </div>
           </fieldset>
          </form>
</div>
