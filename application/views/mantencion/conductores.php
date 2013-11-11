
        
    <legend><h3><center>Mantención Conductores</center></h3></legend> 
          <div class="row">
              <div class="span6">
                    <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="rut"><strong>RUT</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="rut" name="rut" placeholder="Sin puntos ni guión">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="contacto"><strong>Contacto</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" name="contacto" id="contacto" placeholder="">
                </div>
            </div>
               
            <div class="form-actions">
                    <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/conductores/guardar_conductor'" value="Guardar" />
                    <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/conductores/guardar_conductor'" value="Borrar" />
             </div>
           </fieldset>
          </form>
              </div>
                <div class="span8" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
			</tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td>".$tabla['rut']."</td>";
                                  echo "<td>".strtoupper($tabla['contacto'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
                 
              
          </div>
          
          

     
