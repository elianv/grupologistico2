<legend><h3><center>Mantención Bodegas</center></h3></legend> 
<div class="row">
    <div class="span6">
          <div style="margin-left: 10px"><?php echo validation_errors(); ?></div> 
          <form class="form-horizontal" style="margin-left: 10px" method="post">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="input01"><strong>Código Bodega</strong></label>
                <div class="controls">
                 <input type="text" class="span2" id="input01" placeholder="">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="input02"><strong>Nombre</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="input02" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="input02"><strong>Dirección</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="input02" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="input02"><strong>Contacto</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="input02" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="input07"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="input07" placeholder="cod - telefóno">
                </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-danger">Borrar</button>
             </div>
           </fieldset>
          </form>
    </div>
    
    <div class="span6">
        
    </div>
</div>