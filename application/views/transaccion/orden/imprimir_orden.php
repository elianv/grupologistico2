<legend><h3><center>Imprimir, Eliminar Orden de Servicio</center></h3></legend>
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
        <input type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url();?>index.php/transacciones/orden/imprimir_orden/1'" value="Buscar"/>
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
									echo "<th>Acci&oacute;n</th>";
                                    echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";

                                      foreach ($ordenes as $orden){
                                          echo "<tr>";
                                          echo '<td><a href="'.base_url().'index.php/transacciones/orden/formulario_editar/'.$orden['id_orden'].'" target="_blank">'.$orden['id_orden'].'</a></td>';
                                          echo "<td>".strtoupper($orden['razon_social'])."</td>";
                                          echo "<td>".$orden['fecha']."</td>";
										  echo "<td>";
										  	echo "<a class='btn btn-primary' href='".base_url()."index.php/transacciones/orden/pdf/".$orden['id_orden']."'><i class='icon-print icon-white'></i>Imprimir</a>";
											echo " <a class='btn btn-danger' href='#'><i class='icon-trash icon-white'></i>Eliminar</a></td>";
                                          echo "</tr>";
                                      }

                               echo "</tbody>";
                       echo "</table>";    
             
            }
        ?>
</div>
<br>