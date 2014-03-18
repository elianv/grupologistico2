


        
<legend><h3><center>Mantención Agencias Aduaneras</center></h3></legend> 

          <div class="row">
              <div class="span6 form-left-aduanas">
                  <?php echo validation_errors(); ?>
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_aduna"><strong>Código Agencia A.</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' id='codigo_aduana' name='codigo_aduana' placeholder='' value=".$form['codigo_aduana'].">";
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
                <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/agencias/modificar_aduana'" value="Modificar" />
             </div>
           </fieldset>
          </form>
              </div>
              <div class="span8 form-aduanas" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
			</tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  if($tabla['codigo_aduana'] <10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">0".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>

            
