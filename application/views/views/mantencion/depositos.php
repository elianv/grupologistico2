        
    <legend><h3><center>Mantención Depósitos</center></h3></legend> 
    <div class="container">
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
        </div>
          <div class="row">
              <div class="span6 form-left-depositos">
                  
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_deposito"><strong>Código Depósito</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' name='codigo_deposito' id='codigo_deposito' placeholder=".$form['cod_deposito'].">";
                        
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
                 
                 <input data-toggle="tooltip" data-placement="top" title="Guardar Nuevo Dep&oacute;sito" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/depositos/guarda_deposito'" value="Nuevo" />
                 <input data-toggle="tooltip" data-placement="top" title="Editar Dep&oacute;sito existente" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/depositos/modifica_deposito'" value="Modificar" />
 
             </div>
           </fieldset>
          </form>
              
              </div>
                <div class="span8 form-depositos" style="margin-left: 50px">
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
                                  echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_deposito'].">".$tabla['codigo_deposito']."</a></td>";
                                  echo "<td class='descripcion'>".strtoupper($tabla['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>
         
