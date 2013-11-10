

<div class="container">
        
          <legend><h3>Mantención Agencias Aduaneras</h3></legend> 
          
          <div class="row">
              <div class="span6">
                  <?php echo validation_errors(); ?>
                  <form class="form-horizontal" method="post">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_aduna"><strong>Código Agencia A.</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' id='codigo_aduana' name='codigo_aduana' placeholder='' value=".$codigo_aduana.">";
                     ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Agencia A.</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="">
                </div>
            </div>
              
            <div class="control-group">
                <label class="control-label" for="contacto"><strong>Contacto Agencia</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="contacto" name="contacto" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="telefono" name="telefono" placeholder="cod-telefóno">
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/agencias/guardar_aduana'" value="Guardar" />
                <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/agencias/index'" value="Borrar" />
             </div>
           </fieldset>
          </form>
              </div>
              <div class="span6">
                  
              </div>
          </div>

            </div>