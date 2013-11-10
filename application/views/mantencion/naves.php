<div class="container">
    <legend><h3><center>Mantención Naves</center></h3></legend> 
<div class="row">
<div class="span6">
          <?php echo validation_errors(); ?>
    <form class="form-horizontal" method="post">
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

<div class="span6"></div>
</div>
</div>

