
<div class="row">
    <legend><h3><center>Mantención Servicios</center></h3></legend>
    <div class="span6">
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
          <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo"><strong>Código Servicio</strong></label>
                <div class="controls">
                 <?php   
                 echo "<input type='text' class='span2' id='codigo' name='codigo' value=".$form['codigo_servicio'].">";
                 ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><strong>Descripción</strong></label>
                <div class="controls">
                    <textarea type="text" class="input-xlarge" rows="3" name="descripcion" id="descripcion" placeholder=""></textarea>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Valor Costo</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="vcosto" name="vcosto" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Valor Venta</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="vventa" name="vventa" placeholder="">
                </div>
            </div>
               

                 <div class="control-group">
                     <label class="control-label" for="moneda"><strong>Moneda</strong></label>
                    <div class="controls">
                       <select id="moneda" name="moneda">
                           <?php
                                  foreach ($monedas as $moneda){
                                    echo "<option>".$moneda['moneda']."</option>";
                                  }
                           ?>
                       </select>
                    </div>
                </div>
 

            <div class="form-actions">
                    <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/servicios/guardar_servicio'" value="Guardar" />
                    <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/servicios/modificar_servicio'" value="Modificar" />
             </div>
           </fieldset>
          </form>

            </div>
       
    <div class="span8" style="margin-left: 50px">
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
                                  echo "<td>".$tabla['codigo_servicio']."</td>";
                                  echo "<td>".strtoupper($tabla['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>   
</div>