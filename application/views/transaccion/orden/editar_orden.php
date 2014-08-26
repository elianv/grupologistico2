<legend><h3><center>Editar Orden de Servicio</center></h3></legend>
<div class="container">
<form class="form-horizontal" method="post">
    <fieldset>
    <div class="row show-grid">
        <div class="span6">


                        <div class="control-group">
                            <label class="control-label" for="tipo_orden"><strong>Tipo de Orden</strong></label>
                            <div class="controls">
                                <select name="tipo_orden" id="tipo_orden">
                                    <option value="4">TODAS</option>
                                    <option value="5">EXPORTACI&Oacute;N</option>
                                    <option value="6">IMPORTACI&Oacute;N</option>
                                    <option value="7">NACIONAL</option>
                                    <option value="8">OTRO SERVICIO</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="cliente"><strong>Raz&oacute;n Social Cliente</strong></label>
                                <div class="controls">
                                    <input type="text" class="large" name="cliente" id="cliente" placeholder="Nombre cliente">
                                </div>
                        </div> 



        </div>

        <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="desde"><strong>Desde</strong></label>
                                <div class="controls">
                                    <input type="text" class="large" name="desde" id="desde" placeholder="Seleccione">
                                </div>
                        </div> 

                        <div class="control-group">
                            <label class="control-label" for="hasta"><strong>Hasta</strong></label>
                                <div class="controls">
                                    <input type="text" class="large" name="hasta" id="hasta" placeholder="Seleccione">
                                </div>
                        </div> 
        </div>
    </div>
    <div class="form-actions" >
        <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/editar_orden/1'" value="Buscar"/>
    </div>
    </fieldset>
</form>


        <?php 
            if(isset($ordenes)){ 
                        
                          echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
                              echo "<thead>";
                                echo "<tr>";
                                    echo "<th>N° Orden</th>";
                                    echo "<th>Cliente</th>";
                                    echo "<th>Fecha</th>";
                                    echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";

                                      foreach ($ordenes as $orden){
                                          echo "<tr>";
                                          if(isset($orden['estado'])){
                                              if ($orden['estado'] == 2 ){
                                                  echo '<td><a data-toggle="tooltip" data-placement="top" title="La orden '.$orden['id_orden'].' se encuentra facturada, no se puede editar" >'.$orden['id_orden'].'</a></td>';
                                              }
                                              else{
                                                  echo '<td><a data-toggle="tooltip" data-placement="top" title="Editar Orden '.$orden['id_orden'].'" href="'.base_url().'index.php/transacciones/orden/formulario_editar/'.$orden['id_orden'].'" target="_blank">'.$orden['id_orden'].'</a></td>';
                                              }
                                          }
                                          else{
                                            echo '<td><a data-toggle="tooltip" data-placement="top" title="Editar la Orden '.$orden['id_orden'].'" href="'.base_url().'index.php/transacciones/orden/formulario_editar/'.$orden['id_orden'].'" target="_blank">'.$orden['id_orden'].'</a></td>';
                                          }
                                          echo "<td>".strtoupper($orden['razon_social'])."</td>";
                                          echo "<td>".$orden['fecha']."</td>";
                                          echo "</tr>";
                                      }

                               echo "</tbody>";
                          echo "</table>";    
                      
            }
        ?>
</div>
<br>






