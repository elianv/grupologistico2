
        
    <legend><h3><center>Mantención Conductores</center></h3></legend> 
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
              <div class="span6 form-left-conductores">

                  <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="rut"><strong>RUT</strong></label>
                <div class="controls">
                    <input type="text" class="span2" id="rut" name="rut" placeholder="Sin puntos ni guión">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="descripcion"><strong>Nombre</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" name="descripcion" id="descripcion" placeholder="">
                </div>
            </div>
			
			<div class="control-group">
                <label class="control-label" for="descripcion"><strong>Teléfono</strong></label>
                <div class="controls">
					<input type="text" class="input-xlarge" name="telefono" id="telefono" placeholder="">
                </div>
            </div>
               
            <div class="form-actions">
                    <input data-toggle="tooltip" data-placement="top" title="Guardar Nuevo Conductor" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/conductores/guardar_conductor'" value="Nuevo" />
                    <input data-toggle="tooltip" data-placement="top" title="Editar Conductor existene" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/conductores/modificar_conductor'" value="Modificar" />
             </div>
           </fieldset>
          </form>
              </div>
                <div class="span8 form-conductores" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".strtoupper($tabla['rut']).">".strtoupper($tabla['rut'])."</td>";
                                  echo "<td class='descripcion'>".strtoupper($tabla['descripcion'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
                 
              
          </div>
          
          

     
