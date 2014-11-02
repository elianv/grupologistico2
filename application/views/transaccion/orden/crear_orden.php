<div class="container">

	<legend><h3><center>Nueva Orden de Servicio</center></h3></legend>
	
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
                                                    <input type="text" class="input-xxlarge" name="referencia" id="referencia" placeholder="">
						</div>
					</div>
				</div>
			
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="tipo_factura"><strong>Tipo</strong></label>
						<div class="controls">
						   <select id="tipo_factura" name="tipo_orden" class="span2" onchange="cambioOrden(this)">
								<?php
									// print_r(tfacturacion[0]);
									foreach ($tfacturacion as $tipo){
										echo "<option value='".$tipo['tipo_orden']."' >".$tipo['tipo_orden']."</option>";
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
						<input type="text" class="span2" id="cliente" name="cliente_rut_cliente" placeholder="">
						<button class="btn" type="button" data-toggle="modal" href="#modal-cliente"><i class="icon-search"></i></button>
						<input class="nombre-cliente" type="text" disabled="disabled" value="" placeholder="Nombre Cliente..."/>
					</div>
                </div>
            </div>


            <div class="control-group booking">
                <label class="control-label" for="booking"><strong>Booking</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="booking" name="booking" placeholder="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Aduana</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="aduana" name="aduana_codigo_aduana"><button class="btn" type="button" data-toggle="modal" href="#modal-aduana"><i class="icon-search"></i></button></div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Contacto Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="contacto" disabled="disabled" name="contacto_aduana">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Fono Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="telefono" disabled="disabled" name="fono_aduana">
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" for="Nave"><strong>Nave</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="nave" name="nave_codigo_nave" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-nave"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Naviera"><strong>Naviera</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="naviera" name="naviera_codigo_naviera" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-naviera"><i class="icon-search"></i></button></div>
                </div>
            </div>
            
            <div class="control-group" id="check_tramo" style="display:none;">
                <label class="control-label"></label>
                <div class="checkbox">
                        <input type="checkbox" name="enable_tramo" value="1">      En caso de usar un Tramo selecciones esta opci&oacute;n
                </div>
                </label>
            </div>
            
            <div class="control-group tramo">
                <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="tramo" name="tramo_codigo_tramo" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-tramo"><i class="icon-search"></i></button></div>
                </div>
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


<!--   ##############################################################    -->
            <div class="control-group">
                <label class="control-label" for="fecha"><strong>Fecha Retiro</strong></label>
                <div class="controls">
                    <input type="text" class="input-large" name="fecha" id="fecha" placeholder="Seleccione Fecha">
                </div>
            </div> 
  
            <div class="control-group">
                <label class="control-label" for="carga"><strong>Carga</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="carga" name="tipo_carga_codigo_carga" placeholder="">
                        <button class="btn" type="button" data-toggle="modal" href="#modal-carga">
                                <i class="icon-search"></i>
                        </button>
                    </div>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="observacion"><strong>Mercader&iacute;a</strong></label>
                <div class="controls">
                     <textarea class="input-xxlarge" id="mercaderia" name="mercaderia" rows="3"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="numero"><strong>N° Contenedor</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="numero" name="numero" placeholder="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="peso"><strong>Peso</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="peso" name="peso" placeholder="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="set_point"><strong>Set Point</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="set_point" name="set_point" placeholder="">
                </div>
            </div>
               
            <div class="control-group deposito" id="form_deposito" style="display:;">
                <label class="control-label" for="bodega"><strong>Dep&oacute;sito</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="deposito" name="deposito_codigo_deposito" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-deposito"><i class="icon-search"></i></button></div>
                </div>
            </div>  
            
                
            <div class="control-group retiro" id="form_lugar_retiro" style="display:none;">
                <label class="control-label" for="retiro"><strong>Lugar de Retiro</strong></label>
                <div class="controls">
                    <textarea class="input-xxlarge" id="lugar_retiro" name="lugar_retiro" placeholder=""></textarea>
                </div>
            </div>              

            <div class="control-group">
                <label class="control-label" for="fecha_presentacion"><strong>Fecha Presentación</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="fecha_presentacion" name="fecha_presentacion" placeholder="Seleccione Fecha">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega_codigo_bodega" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-bodega"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Direcci&oacute;n Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" name="direccion_bodega" id="direccion_bodega" ></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Contacto Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" name="contacto_bodega" id="contacto_bodega"></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Tel&eacute;fono Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" name="telefono_bodega" id="telefono_bodega"></div>
                </div>
            </div>

            <div class="control-group" id="form_puerto_embarque" style="display:;">
                <label class="control-label" for="puerto"><strong>Puerto Embarque</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="puerto" name="puerto_codigo_puerto" placeholder="">
                        <button class="btn" type="button" data-toggle="modal" href="#modal-puerto"><i class="icon-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="control-group destino">
                <label class="control-label" for="destino"><strong>Puerto Destino</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="destino" name="destino" placeholder=""><button class="btn" type="button" data-toggle="modal" href="#modal-destino"><i class="icon-search"></i></button></div>
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
                                <div class="input-append"><input type="text" class="span2" id="rut" name="proveedor_rut_proveedor" placeholder="sin puntos, ni guion"><button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button></div>
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
						
						<div class="campo-a-repetir original">

							<div class="control-group">
								<label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
								<div class="controls">
									<div class="input-append">
										<input type="text" class="input-xxlarge" id="servicio" name="codigo_servicio[]" >
                                        <input type="hidden" id="id_detalle" name="id_detalle[]">
										<button class="btn" type="button" data-toggle="modal" href="#modal-servicio"><i class="icon-search"></i></button>
									</div>
								</div>
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
							
							<div class="eliminar-campo">
								<a href="javascript:void(0);">Eliminar Servicio <span>-</span></a>
							</div>
						
						</div>
						
						<div class="boton-repetir">
							<a href="#">Agregar otro Servicio <span>+</span></a>
						</div>
						
						
               </br>
               </br>
               </br>
               
               <!--   #########################################################################    -->
              
      <div class="control-group">
            <label class="control-label" for="conductor"><strong>Conductor</strong></label>
            <div class="controls">
                <div class="input-append">
                                            <input type="text" class="span2" id="conductor" name="conductor_rut">
                                            <button class="btn" type="button" data-toggle="modal" href="#modal-conductor">
                                                    <i class="icon-search"></i>
                                            </button>
                                            <input id="nombre_conductor" class="nombre-conductor"  type="text" value="" placeholder="Nombre Conductor..." disabled="disabled"/>
                </div>
            </div>
       </div>

        <div class="control-group">
            <label class="control-label" for="rut"><strong>Tel&eacute;fono Conductor</strong></label>
            <div class="controls">
                <input id="telefono_conductor" value="" type="text" disabled="disabled"/>
            </div>
        </div>
               
       <div class="control-group">
           <label class="control-label" for="patente"><strong>Patente Cami&oacute;n</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" ><button class="btn" type="button" data-toggle="modal" href="#modal-camion"><i class="icon-search"></i></button></div>
                <input type="hidden" name="camion_camion_id" id="camion_id" >
                <input type="hidden" name="viaje_id" id="viaje_id">
            </div>
        </div>
          
               
               <div class="form-actions" >
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/guardar'" value="Crear"/>
                <!-- <input type="submit" class="btn btn-danger"  onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar'" value="Editar" /> -->
                <!-- <input type="submit" class="btn"             onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/pdf/'" value="PDF"/> -->
               </div>
           </fieldset>
          </form>
</div>
