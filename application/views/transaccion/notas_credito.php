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

        <div class="row control-groups">
            <div class="span12">
                <label class="control-label"><strong>Rango de fechas</strong></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="fechas" id="todas_fechas" value="todo" checked>Todas las fechas
                    </label>
                    <label class="radio">
                        <input type="radio" name="fechas" id="rango_fechas" value="rango">Rango de fechas
                    </label>
                </div>
            </div>   
        </div>

        <div class="row control-group" id="input_fechas" style="display: none;">
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

        $('#todas_fechas').click(function(){
            $('#desde').val("");
            $('#hasta').val("");
            $('#input_fechas').css("display","none");
            
        });
        $('#rango_fechas').click(function(){
            $('#input_fechas').css("display","");
        })

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