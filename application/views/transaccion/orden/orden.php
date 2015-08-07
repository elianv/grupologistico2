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
        
		<form class="form-horizontal form-orden editar_orden" method="post">
			<fieldset>  
			<div class="row show-grid">
				<div class="span5">
					<div class="control-group">
						
						<label class="control-label" for="numero_orden"><strong>O.S. N°</strong></label>
						<div class="controls">
							<?php echo "<div class='input-append'><input type='text' disabled='disabled' class='span2' name='id_orden' id='id_orden' value=".$orden[0]['id_orden']."></div>"; ?>
							<input type="hidden" name="numero_orden" id="numero_orden" value="<?php echo $orden[0]['id_orden']; ?>">
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
						   <select id="tipo_factura" name="tipo_orden" class="span2" onchange="cambioOrden(this)">
								<?php
									// print_r(tfacturacion[0]);
									foreach ($tfacturacion as $tipo){
                                                                                if($orden[0]['tipo_orden_id_tipo_orden'] == $tipo['id_tipo_orden']){
                                                                                    echo "<option selected value='".$tipo['tipo_orden']."'>".$tipo['tipo_orden']."</option>";
                                                                                }
                                                                                else{
                                                                                    echo "<option value='".$tipo['tipo_orden']."'>".$tipo['tipo_orden']."</option>";
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
						<input type="text" class="span2" id="cliente" name="cliente_rut_cliente" value="<?php echo $orden[0]['cliente_rut_cliente']; ?>" readonly>
						<button class="btn" type="button" data-toggle="modal" href="#modal-cliente"><i class="icon-search"></i></button>
						<input  class="nombre-cliente" type="text" disabled="disabled" value="<?php echo $cliente[0]['razon_social']; ?>" placeholder="Nombre Cliente..." readonly>
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
                    <div class="input-append"><input type="text" class="input-xlarge" id="aduana" name="aduana_codigo_aduana" value="<?php echo $aduana[0]['codigo_aduana']." - ".$aduana[0]['nombre']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-aduana"><i class="icon-search"></i></button></div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Contacto Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="contacto" disabled="disabled" name="contacto_aduana" value="<?php echo $aduana[0]['contacto'];?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Fono Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="telefono" disabled="disabled" name="fono_aduana" value="<?php echo $aduana[0]['telefono'];?>">
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" for="Nave"><strong>Nave</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="nave" name="nave_codigo_nave" value="<?php echo $nave[0]['codigo_nave']." - ".$nave[0]['nombre']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-nave"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Naviera"><strong>Naviera</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="naviera" name="naviera_codigo_naviera" value="<?php echo $naviera[0]['codigo_naviera']." - ".$naviera[0]['nombre']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-naviera"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group" id="check_tramo" style="display:none;">
                <label class="control-label"></label>
                <div class="checkbox">
                        <input type="checkbox" name="enable_tramo" id="enable_tramo" value="1" onclick="check();"/>      En caso de usar un Tramo selecciones esta opci&oacute;n
                </div>
                </label>
            </div>

            <?php if($orden[0]['tipo_orden_id_tipo_orden'] == 8){ ?>
                <div style="display:none;" id="select_tramo">
            <?php } else{?>
                <div style="display:;" id="select_tramo">
            <?php } ?>
            <div class="control-group tramo" >
                <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="tramo" name="tramo_codigo_tramo" value="<?php echo $tramo[0]['codigo_tramo']." - ".$tramo[0]['descripcion']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-tramo"><i class="icon-search"></i></button></div>
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
         </div>

               </br>


<!--   ##############################################################     -->
            <div class="control-group">
                <label class="control-label" for="fecha"><strong>Fecha retiro</strong></label>
                <div class="controls">
					<input type="text" class="input-large" name="fecha" id="fecha_1" value="<?php echo $orden[0]['fecha']; ?>">
                </div>
            </div> 
  
            <div class="control-group">
                <label class="control-label" for="carga"><strong>Carga</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="carga" name="tipo_carga_codigo_carga" value="<?php echo $carga[0]['codigo_carga']." - ".$carga[0]['descripcion']; ?>" readonly>
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

            <?php 
                if($orden[0]['tipo_orden_id_tipo_orden'] == 6)
                    echo '<div class="control-group" id="form_deposito" style="display:none;">';
                else
                    echo '<div class="control-group" id="form_deposito" style="display:;">';
            ?>
            
                <label class="control-label" for="bodega"><strong>Dep&oacute;sito</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="deposito" name="deposito_codigo_deposito" value="<?php echo $deposito[0]['codigo_deposito']." - ".$deposito[0]['descripcion']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-deposito"><i class="icon-search"></i></button></div>
                </div>
            </div>   
            
            <?php 
                if($orden[0]['tipo_orden_id_tipo_orden'] == 6)
                    echo '<div class="control-group retiro" id="form_lugar_retiro" style="display:;">';
                else
                    echo '<div class="control-group retiro" id="form_lugar_retiro" style="display:none;">';
            ?>
            
                <label class="control-label" for="retiro"><strong>Lugar de Retiro</strong></label>
                <div class="controls">
                    <textarea class="input-xxlarge" id="lugar_retiro" name="lugar_retiro" placeholder="" ><?php echo $orden[0]['lugar_retiro']; ?></textarea>
                </div>
            </div>  

               
            <div class="control-group">
                <label class="control-label" for="fecha_presentacion"><strong>Fecha Presentación</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="fecha_presentacion" name="fecha_presentacion" value="<?php echo $orden[0]['fecha_presentacion']; ?>">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega_codigo_bodega" value="<?php echo $bodega[0]['codigo_bodega']." - ".$bodega[0]['nombre']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-bodega"><i class="icon-search"></i></button></div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Direcci&oacute;n Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" id="direccion_bodega" value=" <?php echo $bodega[0]['direccion'];?>"></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Contacto Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" id="contacto_bodega" value=" <?php echo $bodega[0]['contacto'];?>"></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bodega"><strong>Tel&eacute;fono Bodega</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" disabled="disabled" class="input-xxlarge" id="telefono_bodega" value=" <?php echo $bodega[0]['telefono'];?>"></div>
                </div>
            </div>
            
            <?php 
                if($orden[0]['tipo_orden_id_tipo_orden'] == 5)
                    echo '<div class="control-group" id="form_puerto_embarque" style="display:;">';
                else
                    echo '<div class="control-group" id="form_puerto_embarque" style="display:none;">';
            ?>
            
                <label class="control-label" for="puerto"><strong>Puerto Embarque</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="puerto" name="puerto_codigo_puerto" value="<?php echo $puerto_embarque[0]['codigo_puerto']." - ".$puerto_embarque[0]['nombre']; ?>" readonly>
                	<button class="btn" type="button" data-toggle="modal" href="#modal-puerto"><i class="icon-search"></i></button>
                    </div>
                </div>
            </div>           

            <div class="control-group destino">
                <label class="control-label" for="destino"><strong>Puerto Destino</strong></label>
                    <div class="controls">
                        <div class="input-append"><input type="text" class="input-xxlarge" id="destino" name="destino" value="<?php echo $destino[0]['codigo_puerto']." - ".$destino[0]['nombre']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-destino"><i class="icon-search"></i></button></div>
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
                </div>
                
            </div>

                        <div class="control-group">
                            <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
                            <div class="controls">
                                <div class="input-append">
                                    <input readonly type="text" class="span2" id="rut" name="proveedor_rut_proveedor" value="<?php echo $proveedor[0]['rut_proveedor']; ?>" >
                                    <button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button>
                                    <input  class="span4" id="rsocial" type="text" disabled="disabled" value="<?php echo $proveedor[0]['razon_social']; ?>" placeholder="Nombre Proveedor..." style="margin-left: 40px;" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="observacion"><strong>Observación</strong></label>
                            <div class="controls">
                             <textarea class="input-xxlarge" id="observacion" name="observacion" rows="3"nombre><?php echo $orden[0]['observacion']; ?></textarea>
                            </div>
                        </div>
                        <?php if(count($detalles)){ ?>
						<?php foreach($detalles as $detalle){ ?>
						<div class="campo-a-repetir original">

							<div class="control-group">
								<label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
								<div class="controls">
									<div class="input-append">
										<input type="text" class="input-xxlarge" id="servicio" name="codigo_servicio[]" value="<?php echo $detalle['servicio_codigo_servicio']." - ".$detalle['descripcion']; ?>" readonly>
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
                        
                                                
                        <div class="boton-repetir">
                            <a href="#">Agregar otro Servicio <span>+</span></a>
                        </div>
                        <?php } } else {?>
                        <div class="campo-a-repetir original">

                            <div class="control-group">
                                <label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" class="input-xxlarge" id="servicio" name="codigo_servicio[]" value="" readonly>
                                                                                <input type="hidden" id="id_detalle" name="id_detalle[]" value="">
                                        <button class="btn" type="button" data-toggle="modal" href="#modal-servicio"><i class="icon-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row show-grid">
                                 <div class="span5">    
                                    <div class="control-group">
                                        <label class="control-label" for="valor_costo_servicio"><strong>Valor Costo</strong></label>
                                        <div class="controls">
                                        <input type="text" class="span2" id="valor_costo_servicio" name="valor_costo_servicio[]" value="">
                                        </div>
                                    </div>
                                 </div>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label" for="valor_venta_servicio"><strong>Valor Venta</strong></label>
                                    <div class="controls">
                                    <input type="text" class="span2" id="valor_venta_servicio" name="valor_venta_servicio[]" value="">
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
                        <?php } ?>
						
						
               </br>
               </br>
               </br>
               
               <!--   #########################################################################    -->
                    
       <div class="control-group">
            <label class="control-label" for="conductor"><strong>RUT Conductor</strong></label>
            <div class="controls">
                <div class="input-append">
                                            <input type="text" class="span2" id="conductor" name="conductor_rut" value="<?php echo $conductor[0]['rut']; ?>" readonly>
                                            <button class="btn" type="button" data-toggle="modal" href="#modal-conductor">
                                                    <i class="icon-search"></i>
                                            </button>
                                            <input class="nombre-conductor"  type="text" value=" <?php echo $conductor[0]['descripcion'];?>" placeholder="Nombre Conductor..." disabled="disabled"/>
                </div>
            </div>
       </div>

        <div class="control-group">
            <label class="control-label" for="rut"><strong>Tel&eacute;fono Conductor</strong></label>
            <div class="controls">
                <input class="telefono-conductor" id="telefono_conductor" type="text" value="<?php echo $conductor[0]['telefono']; ?>" disabled="disabled"/>
            </div>
        </div>
               
       <div class="control-group">
           <label class="control-label" for="patente"><strong>Patente Cami&oacute;n</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" value="<?php echo $camion[0]['patente']; ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-camion"><i class="icon-search"></i></button></div>
                <input type="hidden" name="camion_camion_id" id="camion_id" value="<?php echo $camion[0]['camion_id']; ?>">
                <input type="hidden" name="viaje_id" id="viaje_id" value="<?php echo $viaje[0]['id_viaje']; ?>">
            </div>
        </div>
               
               
          
               
               <div class="form-actions" >
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar'" value="Modificar"/>

               </div>
           </fieldset>
          </form>
</div>
<script type="text/javascript">
    $('#fecha_1').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,                      
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
</script>

