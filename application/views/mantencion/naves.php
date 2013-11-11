
    <legend><h3><center>Mantención Naves</center></h3></legend> 
<div class="row">
<div class="span6">
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
    <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_nave"><strong>Código Nave</strong></label>
                <div class="controls">
                    <?php 
                     echo "<input type='text' class='span2' id='codigo_nave' name='codigo_nave' placeholder=".$codigo_nave." >";
                     ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Nave</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="naviera"><strong>Naviera</strong></label>
                <div class="controls">
                    <?php
                        echo "<div class='input-append'><input type='text' class='input-large' id='naviera_codigo_naviera' name='naviera_codigo_naviera' placeholder='".$placeholder."'  value='".$naviera_codigo_naviera."'><span class='add-on'><i class='icon-search' data-toggle='modal' href='#modal'></i></span></div>";
                    ?>
                </div>
            </div>

            <div class="form-actions">
                    <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naves/guardar_nave'" value="Guardar" />
                    <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naves/borrar_nave'" value="Borrar" />
             </div>
           </fieldset>
          </form>

            </div>

      <div class="span8" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Nave</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td>".$tabla['codigo_nave']."</td>";
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>
</div>


