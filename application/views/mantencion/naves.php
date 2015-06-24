
    <legend><h3><center>Mantención Naves</center></h3></legend> 
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
<div class="span6 form-left-naves">

    <form class="form-horizontal" method="post" style="margin-left: 10px">
           <fieldset>  
            <div class="control-group">
                <label class="control-label" for="codigo_nave"><strong>Código Nave</strong></label>
                <div class="controls">
                    <?php 
                     echo "<input type='text' class='span2' id='codigo_nave' name='codigo_nave' placeholder=".$codigo_nave." >";
                     ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Nave</strong></label>
                <div class="controls">
                 <input type="text" class="input-xlarge" id="nombre" name="nombre" placeholder="">
                </div>
            </div>

            <input type="hidden" id="codigo_naviera" name="codigo_vaviera" value="1 - dato">
            
            <div class="form-actions">
                    <input data-toggle="tooltip" data-placement="top" title="Guardar Nueva Nave" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naves/guardar_nave'" value="Nueva" />
                    <input data-toggle="tooltip" data-placement="top" title="Editar Nave existente" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/mantencion/naves/modificar_nave'" value="Modificar" />
             </div>
           </fieldset>
          </form>

            </div>

      <div class="span8 form-naves" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Nave</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($tablas as $tabla){
                                  echo "<tr>";
                                  echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_nave'].">".$tabla['codigo_nave']."</a></td>";
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                                  echo "</tr>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>
</div>


