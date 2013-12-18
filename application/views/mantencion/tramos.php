    <legend><h3><center>Mantención de Tramos</center></h3></legend> 
    
  <div class="row">
     <div class="span6 form-left-tramos">
         <div style="margin-left: 10px"><?php echo validation_errors(); ?></div>
         
         <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_tramo"><strong>Código Tramo</strong></label>
                <div class="controls">
                    <?php
                        echo "<input type='text' class='span2' name='codigo_tramo' id='codigo_tramo' placeholder=".$form['cod_tramo'].">";
                        
                    ?>
                </div>
            </div>

            
            <div class="control-group">
                <label class="control-label"><strong>Descripción</strong></label>
                <div class="controls">
                    <textarea type="text" class="input-xlarge" rows="3" name="descripcion" id="descripcion" placeholder=""></textarea>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Valor Costo</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="valor_costo" name="valor_costo" placeholder="" >
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Valor Venta</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="valor_venta" name="valor_venta" placeholder="" >
                </div>
            </div>             
              
               <div class="row show-grid">

                <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="tmoneda"><strong>Tipo Moneda</strong></label>
                    <div class="controls">
                       <select id="tfactura" name="tmoneda">
                           <?php
                                  // print_r(tfacturacion[0]);
                                   foreach ($tmoneda as $tipo){
                                       
                                       echo "<option>".$tipo['moneda']."</option>";
                                       
                                   }
                                
                                
                           ?>
                       </select>
                    </div>
                </div>
                </div>
               </div>
               

               
             <div class="form-actions">
                 
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/tramos/guardar_tramo'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/tramos/modificar_tramo'" value="Modificar" />
 
             </div>
           </fieldset>
          </form>
     </div>
      <div class="span8 form-tramos" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código Tramo</th>
                            <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  if($tabla['codigo_tramo'] <10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_tramo'].">0".$tabla['codigo_tramo']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_tramo'].">".$tabla['codigo_tramo']."</a></td>";
                                  }
                                  echo "<td>".strtoupper($tabla['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>
        
          
      </div>
  </div>


