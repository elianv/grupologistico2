
<div class="row">
    <legend><h3><center>Mantención Puertos</center></h3></legend>
    <div class="span6">
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
          <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_puerto"><strong>Código Puerto</strong></label>
                <div class="controls">
                 <?php   
                 echo "<input type='text' class='span2' id='codigo_puerto' name='codigo_puerto' value=".$form['codigo_puerto'].">";
                 ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Puerto</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" name="nombre" id="nombre" placeholder="">
                </div>
            </div>

            <div class="form-actions">
                    <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/puertos/insertar_puerto'" value="Guardar" />
                    <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/puertos/index'" value="Borrar" />
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
                                  echo "<td>".$tabla['codigo_puerto']."</td>";
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>   
</div>



