         
    <legend><h3><center>Mantención Cargas</center></h3></legend>
            <?php
            $correcto = $this->session->flashdata('mensaje');
            if ($correcto){
                echo "<div class='alert alert-error' align=center>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
 
                if(validation_errors()){
                    echo "<div class='alert alert-info' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
            ?> 
          <div class="row">
              <div class="span6 form-left-cargas">
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_carga"><strong>Código Carga</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' name='codigo_carga' id='codigo_carga' placeholder=".$form['cod_carga'].">";
                        
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="descripcion"><strong>Descripción</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="descripcion" name="descripcion" >
                </div>
            </div>

            <div class="form-actions">
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/cargas/guarda_carga'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/cargas/modificar_carga'" value="Modificar" />
 
             </div>
           </fieldset>
          </form>
              
              </div>
                <div class="span8 form-cargas" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
			</tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  if($tabla['codigo_carga'] <10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_carga'].">0".$tabla['codigo_carga']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_carga'].">".$tabla['codigo_carga']."</a></td>";
                                  }
                                      
                                  echo "<td class='descripcion'>".strtoupper($tabla['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>
