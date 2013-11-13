<div class="container">
        
    <legend><h3><center>Orden de Servicio</center></h3></legend> 
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
          <form class="form-horizontal">
           <fieldset>  
               
            <div class="row show-grid">
                <div class="span5">
                     <div class="control-group">
                        <label class="control-label" for="numero_orden"><strong>O.S. N°</strong></label>
                        <div class="controls">
                            <?php
                                echo "<input type='text' class='span2' name='numero_orden' id='numero_orden' placeholder='Solo números' value=".$numero_orden.">";
                            ?>
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
                    <label class="control-label" for="tipo_factura">Tipo Factura</label>
                    <div class="controls">
                       <select id="tipo_factura" name="tipo_factura" class="span2">
                           <?php
                                  // print_r(tfacturacion[0]);
                                   foreach ($tfacturacion as $tipo){
                                       
                                       echo "<option>".$tipo['tipo_facturacion']."</option>";
                                       
                                   }
                                
                                
                           ?>
                       </select>
                    </div>
                 </div>
                    
                     <div class="control-group">
                        <label class="control-label" for="fecha"><strong>Fecha</strong></label>
                        <div class="controls">
                            <input type="text" class="span2" name="fecha" id="fecha" placeholder="dd-mm-aaaa">
                        </div>
                     </div> 
                    
                </div>
            </div>
                

              
            	
               

               </br>
               </br>
<!--   ##############################################################    -->     

            <div class="control-group">
                <label class="control-label" for="cliente"><strong>Cliente</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="cliente" name="cliente" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-cliente"></i></span></div>
                </div>
            </div>

                <div class="row show-grid">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="booking"><strong>Booking</strong></label>
                            <div class="controls">
                                <input type="text" class="span2" id="booking" name="booking" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="tramo" name="tramo" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-tramo"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Aduana</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xlarge" id="aduana" name="aduana" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-aduana"></i></span></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="referencia"><strong>Referencia</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="referencia" name="referencia" placeholder="">
                </div>
            </div>
               </br>
               </br>
<!--   ##############################################################    -->  
         <div class="row show-grid">
             <div class="span5">
            <div class="control-group">
                <label class="control-label" for="carga"><strong>Carga</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="carga" name="carga" placeholder="">
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
            <div class="control-group">
                <label class="control-label" for="contenedor"><strong>Ret. Contenedor</strong></label>
                <div class="controls">
                 <input type="text" class="input-xxlarge" id="contenedor" name ="contenedor" placeholder="">
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
                    <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-bodega"></i></span></div>
                </div>
            </div>
               
               <div class="row show-grid">
                   <div class="span5">
                        <div class="control-group">
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
                            <div class="input-append"><input type="text" class="span2" id="puerto" id="puerto" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-puerto"></i></span></div>
                        </div>
                        </div>
                   </div>
                   
               </div>
<div class="row show-grid">
    
    <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="referencia"><strong>Referencia 2</strong></label>
                        <div class="controls">
                            <input type="text" class="input-large" id="referencia" name="referencia" placeholder="">
                        </div>
                        </div>        
    </div>
    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="rut" name="rut" placeholder="sin puntos, ni guion"><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-proveedor"></i></span></div>
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

                        <div class="control-group">
                            <label class="control-label" for="servicio"><strong>Servicio</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="input-xxlarge" id="servicio" name="servicio" ><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-servicio"></i></span></div>
                            </div>
                        </div>
               </br>
               </br>
               
               <!--   #########################################################################    -->
        <div class="row show-grid">
                    
          <div class="span5">
           <div class="control-group">
                <label class="control-label" for="conductor"><strong>Conductor</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="span2" id="conductor" name="conductor" placeholder=""><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-conductor"></i></span></div>
                </div>
           </div>
         </div>
            
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label" for="patente"><strong>Patente</strong></label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" placeholder="AAAA11 ó 1111AA"><span class="add-on"><i class="icon-search" data-toggle="modal" href="#modal-conductor"></i></span></div>
                            </div>
                        </div>
                    </div>
       </div>
          

               <div class="form-actions" >
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn">Buscar</button>
              <button class="btn btn-danger">Borrar</button>
             </div>
           </fieldset>
          </form>
</div>
