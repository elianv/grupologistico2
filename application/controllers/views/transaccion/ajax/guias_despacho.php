<?php $guias = explode("|", $guias_despacho); ?>
<?php foreach ($guias as $guia) { ?>      
						<div class="repetir-guia" >  					
        					<div class="control-group">
        						<label class="control-label"><strong>Guía Despacho</strong></label>
        						<div class="controls">
        							<input type="text" class="input-large" name="guia_despacho[]" id="numero_factura" placeholder="Solo números" value="<?php echo $guia; ?>">
        						</div>
    					    </div>
    					</div>
<?php } ?>        					