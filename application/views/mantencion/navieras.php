        
    <legend><h3><center>Mantención Navieras</center></h3></legend> 
          <div class="row">
              <div class="span6">
                  <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_naviera"><strong>Código Naviera</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' name='codigo_naviera' id='codigo_naviera' placeholder=".$form['cod_naviera'].">";
                        
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Naviera</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre" name="nombre" >
                </div>
            </div>

            <div class="form-actions">
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/navieras/guarda_naviera'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/navieras/modificar_naviera'" value="Modificar" />
 
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
                                  echo "<td>".$tabla['codigo_naviera']."</td>";
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>
         
