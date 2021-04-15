<div class="container">
    <legend><h3><center>Notas de cr&eacute;dito</center></h3></legend>

    <div class="container">
        <?php
            if(validation_errors()){
                echo "<div class='alert alert alert-error' align=center>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo validation_errors();
                echo "</div>";
            }
        ?>
    </div>

    <form class="form-horizontal" id="formulario" method="post">

        <div class="row control-group">
            <div class="span6">
                <label class="control-label"><strong>Desde</strong></label>
                <div class="controls"><input type="text" id="desde" name="desde" placeholder="Seleccione fecha" value="<?php echo set_value('desde'); ?>" readonly></div>
            </div>
            <div class="span6">
                <label class="control-label"><strong>Hasta</strong></label>
                <div class="controls"><input type="text" id="hasta" name="hasta" placeholder="Seleccione Fecha" value="<?php echo set_value('hasta'); ?>" readonly></div>
            </div>
        </div>

        <div class="row control-groups">
            <div class="span12">
                <label class="control-label"><strong>Formato de salida</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio1" value="pantalla" checked>Pantalla
                    </label>
                    <label class="radio">
                        <input type="radio" name="salida" id="optionsRadio2" value="excel">Excel
                    </label>
                </div>
            </div>   
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Generar</button>
        </div>
    </form>

    <div>
    <?php 
        if($result){ 
            echo $notas['table'];
        } 
    ?>
    </div>
</div>
<script>
    $(document).ready(function(){
    	$('#desde').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });
    	$('#hasta').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showHour:false,
                        showMinute:false,
                        showTime: false,
                        dateFormat: 'dd-mm-yy'
        });        
        <?php if(isset($notas['js'])) echo $notas['js']; ?>
    });
    
</script>