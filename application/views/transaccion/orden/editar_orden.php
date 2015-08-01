<legend><h3><center>Editar Orden de Servicio</center></h3></legend>

<form class="form-horizontal form-orden" method="post">
    <fieldset>
<div class="container">
    <div class="row">
        <div class="span6">


                        <div class="control-group">
                            <label class="control-label" for="tipo_orden"><strong>Tipo de Orden</strong></label>
                            <div class="controls">
                                <select name="tipo_orden" id="tipo_factura">
                                    <option value="4">TODAS</option>
                                    <option value="5">EXPORTACI&Oacute;N</option>
                                    <option value="6">IMPORTACI&Oacute;N</option>
                                    <option value="7">NACIONAL</option>
                                    <option value="8">OTRO SERVICIO</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="cliente_razon"><strong>Raz&oacute;n Social Cliente</strong></label>
                                <div class="controls">
                                    <input type="text" class="large" name="cliente" id="cliente_razon" placeholder="Nombre cliente">
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
</div>
<div class="container">
    <?php 
    
            if(isset($ordenes)){ 
                          echo "<legend>Ordenes de Servicios </legend>";    
                          echo "<br>";                
                          echo "<table cellpadding='0' class='table table-hover table-condensed' id='tabla-ordenes'>";
                              echo "<thead>";
                                echo "<tr>";
                                    echo "<th>N°</th>";
                                    echo "<th>Cliente</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Acci&oacute;n</th>";
                                    echo "<th>Fecha</th>";
                                    echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";

                                      foreach ($ordenes as $orden){
                                          echo "<tr>";
                                          if ($orden['id_estado_orden'] != 1 ){
                                                  echo '<td><a data-toggle="tooltip" data-placement="top" title="La orden '.$orden['id_orden'].' se encuentra facturada, no se puede editar" >'.$orden['id_orden'].'</a></td>';
                                          }
                                          else{
                                                  echo '<td><a data-toggle="tooltip" data-placement="top" title="Editar Orden '.$orden['id_orden'].'" >'.$orden['id_orden'].'</a></td>';
                                          }
                                          echo "<td>".strtoupper($orden['razon_social'])."</td>";
                                          echo "<td>".$orden['estado']."</td>";
                                          echo "<td>";
                                          echo "<a class='btn btn-primary' href='".base_url()."index.php/transacciones/orden/pdf/".$orden['id_orden']."'><i class='icon-print icon-white'></i>Imprimir</a>";
                                          echo " ";
                                          if ($orden['id_estado_orden'] == 1 )
                                          {
                                                  echo "<a class='btn btn-success' target='_blank' href='".base_url()."index.php/transacciones/orden/formulario_editar/".$orden['id_orden']."'><i class='icon-print icon-white'></i>Editar</a>";
                                          }
                                          echo "</td>";
                                          echo "<td>".$orden['fecha']."</td>";                                                                                          
                                          echo "</tr>";
                                      }

                               echo "</tbody>";
                          echo "</table>";    


        } ?>
</div>


<br>
              <script type="text/javascript">
              $(document).ready(function(){
                  $('#tabla-ordenes').DataTable();
                });
              </script>   





