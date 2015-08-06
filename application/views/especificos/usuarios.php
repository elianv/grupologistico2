    <legend><h3><center>Mantención de Tramos</center></h3></legend>
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
    <div class="span6 form-left-tramos">
         
         
         <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_tramo"><strong>Rut Usuario</strong></label>
                <div class="controls">
                 <input type='text' class='span2' name='rut_usuario' id='rut_usuario' placeholder="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="codigo_tramo"><strong>Nombre Usuario</strong></label>
                <div class="controls">
                 <input type='text' class='span3' name='nombre' id='nombre' placeholder="">
                </div>
            </div>          
            <div class="control-group">
                <label class="control-label" for="codigo_tramo"><strong>Clave</strong></label>
                <div class="controls">
                 <input type='text' class='span3' name='clave' id='clave' placeholder="">
                </div>
            </div>              
    <div class="row show-grid">

                <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="tusuario"><strong>Tipo Usuario</strong></label>
                    <div class="controls">
                       <select id="tusuario" name="tusuario">
                           <?php
                                   foreach ($tusuario as  $index => $tipo){
                                       $num = range(3,100);
                                       echo "<option value='".$num[$index]."'>".$tipo['tipo_usuario']."</option>";
                                       
                                   }
                                
                                
                           ?>
                       </select>
                    </div>
                </div>
                </div>
    </div>
               

               
             <div class="form-actions">
                 
                 
                 <input data-toggle="tooltip" data-placement="top" title="Guardar Nuevo Usuario" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/especificos/usuarios/guardar_usuario'" value="Nuevo" />
 
             </div>
           </fieldset>
          </form>
     </div>
      <div class="span8 form-tramos" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Rut Usuario</th>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$tabla['rut_usuario'].">".$tabla['rut_usuario']."</a></td>";
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>
        
          
      </div>
  </div>


