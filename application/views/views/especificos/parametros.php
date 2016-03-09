<legend><h3><center>Par&aacute;metros</center></h3></legend> 

            <?php 
                echo '<div class="container">';
                if(validation_errors()){
                    echo "<div class='alert alert alert-error' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
                echo '</div>';
            ?>

<div class="container">
	<div class="row">
	    <div class="span1"></div>
	    <div class="span6">
	        <form class="form-horizontal" id="formulario" action="<?php echo base_url('index.php/especificos/especificos/guardar_parametro');?>" method="post">
	            <fieldset>
	                    <div class="control-group">
	                        <label class="control-label" for="desde">
	                        		<strong>Correlativo Ordenes :</strong>
	                        </label> 
	                        <div class="controls">
			                        <input type="text" id="correlativo_os" name="correlativo_os" class="span3" value="<?php if(isset($correlativo[0])){echo $correlativo[0]['valor']; }  ?>" />
			                </div>
	                    </div>
	                <div class="form-actions">
	                            <input type="submit" class="btn btn-success" value="Guardar"/>
	                </div>

	            </fieldset>
	        </form>        
	    </div>
	    <div class="span1"></div>
	</div>	
</div>

<script type="text/javascript">
</script>