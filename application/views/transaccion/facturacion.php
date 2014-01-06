<div class="container">
    <legend><h3><center>Facturación</center></h3></legend> 
    <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
    <form class="form-horizontal" method="post">
        <fieldset>
        <div class="row show-grid">
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="numero_factura"><strong>Factura N°</strong></label>
                    <div class="controls">
                        <div class="input-append"><input type="text" class="span2" name="numero_factura" id="numero_factura" placeholder="Solo números"><button class="btn" type="button" data-toggle="modal" href="#modal-factura"><i class="icon-search"></i></button></div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="guia_despacho"><strong>Guía Despacho</strong></label>
                    <div class="controls">
                        <input type="text" class="input-xxlarge" name="guia_despacho" id="numero_factura" placeholder="Solo números">
                    </div>
                </div>
                
            </div>
            
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="nula"><strong>¿Factura Nula?</strong></label>
                    <div class="controls">
                        <label class="checkbox inline">
                            <input type="checkbox" id="nula" name="nula[]" value=1>Si</label>
                        </label>
                    </div>
                </div>
                

                
            </div>
            
        </div>         
            <div style="margin-left: 30px"><h3>Asociar O.S.</h3></div>
            
              <div class="span8" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
			</tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  if($tabla['codigo_aduana'] <10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">0".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_aduana'].">".$tabla['codigo_aduana']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>

        <div class="form-actions" >
            <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/guardar'" value="Guardar"/>
            <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar'" value="Editar" />
        </div>    
        </fieldset>
    </form>
</div>