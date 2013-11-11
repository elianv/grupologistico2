
        
    <legend><h3><center>Mantención Camiones</center></h3></legend> 
          <div class="row">
              <div class="span6">
                  <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="patente"><strong>Patente</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="patente" name="patente" placeholder="AAAA11 ó AA1111">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefono Celular</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" name="telefono" id="telefono" placeholder="09 - número">
                </div>
            </div>
               
            <div class="form-actions">
                    <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/camiones/guardar_camion'" value="Guardar" />
                    <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/camiones/guardar_camion'" value="Borrar" />
             </div>
           </fieldset>
          </form>
              </div>
              <div class="span8" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Patente</th>
                            <th>Celular</th>
			</tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td>".strtoupper($tabla['patente'])."</td>";
                                  echo "<td>".$tabla['celular']."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
                 
              
          </div>
          
          



