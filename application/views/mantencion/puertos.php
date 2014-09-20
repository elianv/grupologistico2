<div class="row">
    <legend><h3><center>Mantención Puertos</center></h3></legend>
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
    <div class="span6 form-left-puertos">

          <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_puerto"><strong>Código Puerto</strong></label>
                <div class="controls">
                 <?php   
                 echo "<input type='text' class='span2' id='codigo_puerto' name='codigo_puerto' value=".$form['codigo_puerto'].">";
                 ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Puerto</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" name="nombre" id="nombre" placeholder="">
                </div>
            </div>

            <div class="form-actions">
                    <input data-toggle="tooltip" data-placement="top" title="Guardar Nuevo Puerto" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/puertos/insertar_puerto'" value="Nuevo" />
                    <input data-toggle="tooltip" data-placement="top" title="Editar Puerto existente" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/puertos/modificar_puerto'" value="Modificar" />
             </div>
           </fieldset>
          </form>

            </div>
       
    <div class="span8 form-puertos" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo '<td><a class="sorting_1 codigo-click" data-codigo='.$tabla['codigo_puerto'].'>'.$tabla['codigo_puerto'].'</a></td>';
                                  echo "<td class='nombre'>".strtoupper($tabla['nombre'])."</td>";
                              }
                              ?>
                       </tbody>
                  </table>    
              </div>   
</div>



