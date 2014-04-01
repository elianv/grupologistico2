
        
    <legend><h3><center>Mantención de Proveedores</center></h3></legend> 
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
     <div class="span6 form-left-proveedores">

         
         <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label"><strong>R.U.T</strong></label>
                <div class="controls">
                 <input type="text" class="span2" id="rut" name="rut" placeholder="sin puntos, ni guion">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><strong>Razón Social</strong></label>
                <div class="controls">
                    <textarea type="text" class="input-xlarge" rows="3" name="rsocial" id="rsocial" placeholder=""></textarea>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Giro</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="giro" name="giro" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Dirección</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="direccion" name="direccion" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Comuna</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="comuna" name="comuna" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Ciudad</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="ciudad" name="ciudad" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="telefono" name="telefono" placeholder="cod-telefóno">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="celular"><strong>Celular</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="celular" name="celular" placeholder="09-telefóno">
                </div>
            </div>
                            <div class="form-actions">
                 
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/proveedores/guardar_proveedor'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/proveedores/modificar_proveedor'" value="Modificar" />
 
             </div>
           </fieldset>
          </form>
        </div>
               
      <div class="span8 form-proveedores" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Razón Social</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$tabla['rut_proveedor'].">".$tabla['rut_proveedor']."</a></td>";
                                  echo "<td>".strtoupper($tabla['razon_social'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>
               

     </div>



