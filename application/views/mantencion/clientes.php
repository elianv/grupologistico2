
        
    <legend><h3><center>Mantención de Clientes</center></h3></legend> 
    <div class="container">
                <?php
            $correcto = $this->session->flashdata('mensaje');
            if ($correcto){
                echo "<div class='alert alert-error' align=center>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
 
                if(validation_errors()){
                    echo "<div class='alert alert-info' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
            ?> 
        </div>
  <div class="row">
     <div class="span6">
         
         <form class="form-horizontal form-left-clientes" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label"><strong>R.U.T</strong></label>
                <div class="controls">
                 <input type="text" class="span2" id="rut" name="rut" placeholder="sin puntos, ni guion">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><strong>Razón Social</strong></label>
                <div class="controls">
                    <textarea type="text" class="input-xlarge" rows="3" name="rsocial" id="rsocial" placeholder=""></textarea>
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Giro</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="giro" name="giro" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Dirección</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="direccion" name="direccion" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Comuna</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="comuna" name="comuna" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label"><strong>Ciudad</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="ciudad" name="ciudad" placeholder="">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="telefono"><strong>Telefóno</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="telefono" name="telefono" placeholder="cod-telefóno">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="celular"><strong>Celular</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="celular" name="celular" placeholder="09-telefóno">
                </div>
            </div>
               
            <div class="control-group">
                <label class="control-label" for="contacto"><strong>Contacto</strong></label>
                <div class="controls">
                 <input type="text" class="span3" id="contacto" name="contacto" placeholder="">
                </div>
            </div>
               <div class="row show-grid">
                <div class="span3">
                    <div class="control-group">
                     <label class="control-label" for="dplazo"><strong>Días Plazo</strong></label>
                     <div class="controls">
                         <select name="dplazo" id="dplazo">
                             <option value="30">30 días</option>
                             <option value="60">60 días</option>
                             <option value="90">90 días</option>
                         </select>
                     </div>
                    </div>
                </div>
                <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="tfactura"><strong>Tipo Factura</strong></label>
                    <div class="controls">
                       <select id="tfactura" name="tfactura">
                                <option value="manual">Manual</option>
                                <option value="automatica">Automatíca</option>
                       </select>
                    </div>
                </div>
                </div>
               </div>
               

               
             <div class="form-actions form-clientes" >
                 
                 
                 <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/clientes/guardar_cliente'" value="Guardar" />
                 <input type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/clientes/modificar_cliente'" value="Modificar" />
 
             </div>
           </fieldset>
          </form>
     </div>
    <div class="span8 form-clientes" style="margin-left: 50px">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
              <tr>
                  <th>RUT</th>
                  <th>Razón Social</th>
              </tr>
            </thead>
            <tbody>
                    <?php
                    foreach ($tablas as $tabla){
                        echo "<tr>";
                        echo "<td><a class='codigo-click' data-codigo=".strtoupper($tabla['rut_cliente']).">".strtoupper($tabla['rut_cliente'])."</a></td>";
                        echo "<td>".strtoupper($tabla['razon_social'])."</td>";
                    }
                    ?>
             </tbody>
        </table>    
     </div>
        
          
      </div>
  </div>

