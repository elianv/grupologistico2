<div class="container">
        
    <legend><h3><center>Mantención de Clientes</center></h3></legend> 
  <div class="row">
     <div class="span6">
          <?php echo validation_errors(); ?>
          <form class="form-horizontal" method="post" accept-charset="utf-8">
          
           <fieldset>  
            <div class="control-group">
                <label class="control-label"><strong>R.U.T</strong></label>
                <div class="controls">
                 <input type="text" class="span2" id="rut" placeholder="sin puntos, ni guion">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><strong>Razón Social</strong></label>
                <div class="controls">
                    <textarea type="text" class="input-xlarge" rows="3" id="rsocial" placeholder=""></textarea>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Giro</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="giro" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Dirección</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="direccion" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Comuna</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="comuna" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Ciudad</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="ciudad" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="telefono" placeholder="cod-telefóno">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="celular"><strong>Celular</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="celular" placeholder="09-telefóno">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="contacto"><strong>Contacto</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="contacto" placeholder="">
                </div>
            </div>
               <div class="row show-grid">
                <div class="span3">
                    <div class="control-group">
                     <label class="control-label" for="dplazo"><strong>Días Plazo</strong></label>
                     <div class="controls">
                      <input type="text" class="span1" id="dplazo" placeholder="">
                     </div>
                    </div>
                </div>
                <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="tfactura"><strong>Tipo Factura</strong></label>
                    <div class="controls">
                       <select id="tfactura">
                           <?php
                                  // print_r(tfacturacion[0]);
                                   foreach ($tfacturacion as $tipo){
                                       
                                       echo "<option>".$tipo['tipo_facturacion']."</option>";
                                       
                                   }
                                
                                
                           ?>
                       </select>
                    </div>
                </div>
                </div>
               </div>
               

               
             <div class="form-actions">
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/clientes/guardar_cliente'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/clientes/borrar_cliente'" value="Borrar" />
                 
             </div>
           </fieldset>
          </form>
     </div>
      <div class="span6">
          hola!
          
      </div>
  </div>
              


