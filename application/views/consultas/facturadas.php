<legend><h3><center>Ordenes de Trabajo Facturadas</center></h3></legend> 

<div class="container-fluid">

        <form class="form-horizontal" method="post">
            <fieldset>
                <label class="control-label"><strong>Formato de Salida</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
                    </label>
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel  
                    </label>
                    
                </div>
                <label class="control-label"><strong>RUT</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="optionsRadios" id="optionsRadio1" value="option1" checked>Un solo Rut
                    </label>
                    <label class="radio">
                        <input type="radio" name="optionsRadios" id="optionsRadio2" value="option2">Todos los RUT  
                    </label>
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="desde"><strong>Desde :</strong></label> 
                    <div class="controls"><input type="text" id="datepicker" name="desde" class="span2"/></div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="hasta"><strong>Hasta :</strong></label> 
                    <div class="controls"><input type="text" id="datepicker2" name="hasta" class="span2"/></div>
                </div>
                <div class="form-actions">
                    
                           <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/consultas/facturadas/generar'" value="Generar" />
                    
                </div>

            </fieldset>
        </form>

</div>