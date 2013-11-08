<div class="container">
        
    <legend><h3><center>Mantención Navieras</center></h3></legend> 
          <div class="row">
              <div class="span6">
                  <form class="form-horizontal" action="post">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_naviera"><strong>Código Naviera</strong></label>
                <div class="controls">
                    <?php
                        if ($cod_naviera == 0){
                            echo "<input type='text' class='span2' name='cnaviera' id='cnaviera' placeholder='' readonly='readonly'>";
                        }
                        else{
                            echo "<input type='text' class='span2' name='cnaviera' id='cnaviera' placeholder=".$cod_naviera." readonly='readonly'>";
                        }
                    ?>
                    
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre_naviera"><strong>Nombre Naviera</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre_naviera" name="nombre_naviera" placeholder="">
                </div>
            </div>

            <div class="form-actions">
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/navieras/guardar_naviera'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naviera/borrar_naviera'" value="Borrar" />
 
             </div>
           </fieldset>
          </form>
              
              </div>
              <div class="span6"></div>
          </div>
          
</div>