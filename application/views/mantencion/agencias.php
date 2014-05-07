


        
<legend><h3><center>Mantención Agencias Aduaneras</center></h3></legend> 
        <?php
            $correcto = $this->session->flashdata('mensaje');
            if ($correcto){
                echo "<div class='alert alert-error' align=center>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
        ?>
                        <?php 
                if(validation_errors()){
                    echo "<div class='alert alert-info' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
            ?>

          <div class="row">
              <div class="span6 form-left-aduanas">
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
                                  echo '<td><a class="sorting_1 codigo-click" data-codigo='.$tabla['codigo_aduana'].'>'.$tabla['codigo_aduana'].'</a></td>';
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>

            
