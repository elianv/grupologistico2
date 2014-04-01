<legend><h3><center>Mantención Bodegas</center></h3></legend> 
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
    <div class="span6 form-left-bodegas">
          <form class="form-horizontal" style="margin-left: 10px" method="post">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_bodega"><strong>Código Bodega</strong></label>
                <div class="controls">
                <?php    
                echo "<input type='text' class='span2' id='codigo_bodega' name='codigo_bodega' placeholder=".$form['codigo_bodega'].">";
                ?>
                </div>
                
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="direccion"><strong>Dirección</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="direccion" name="direccion" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="contacto"><strong>Contacto</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="contacto" name="contacto" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="telefono" name="telefono" placeholder="cod - telefóno">
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/bodegas/guardar_bodega'" value="Guardar" />
                <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/bodegas/modificar_bodega'" value="Modificar" />

             </div>
           </fieldset>
          </form>
    </div>
    
    <div class="span8 form-bodegas" style="margin-left: 50px">
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
								  
                                  //if($tabla['codigo_bodega'] < 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_bodega'].">".$tabla['codigo_bodega']."</a></td>";
                                  //}
                                  //else{
                                  //    echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_bodega'].">".$tabla['codigo_bodega']."</a></td>";
                                  //}
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
</div>
