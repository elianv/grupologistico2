<legend><h3><center>Mantención Camiones</center></h3></legend> 
<div class="container">
        <?php
            echo '<div class="container">';
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
                echo '</div>';
            ?>
</div>
          <div class="row">
              <div class="span6 form-left-camiones">
                  
                    <form class="form-horizontal" method="post" style="margin-left: 10px">
                        <fieldset>
                            <div>
                                <input type="hidden" name="id_camion" value="">
                            </div>  
                            <div class="control-group">
                                <label class="control-label" for="patente"><strong>Patente</strong></label>
                                <div class="controls">
                                    <input type="text" class="span2" id="patente" name="patente" placeholder="AAAA11 ó AA1111">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input data-toggle="tooltip" data-placement="top" title="Guardar Nuevo Cami&oacute;n" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/camiones/guardar_camion'" value="Nuevo" />
                                <input data-toggle="tooltip" data-placement="top" title="Editar Cami&oacute;n existente" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/camiones/modificar_camion'" value="Modificar" />
                            </div>
                        </fieldset>
                    </form>
              </div>
              <div class="span8 form-camiones" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                          <tr>
                              <th>Patente</th>
  			                  </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".strtoupper($tabla['patente']).">".strtoupper($tabla['patente'])."</a></td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>
          </div>
