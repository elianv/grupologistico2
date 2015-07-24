<legend><h3><center>C&oacute;digos Sistemas</center></h3></legend> 
        <?php
            echo '<div class="container">';
            $correcto = $this->session->flashdata('mensaje');
            if ($correcto){
                echo "<div class='alert alert-error' align=center>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
        ?>
                        <?php 
                if(validation_errors()){
                    echo "<div class='alert alert-info' align=center>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
                echo '</div>';
            ?>

          <div class="row">
              <div class="span8">
                  <form class="form-horizontal" method="post" style="margin-left: 10px">
                      <fieldset>  
                          <div class="control-group">
                              <label class="control-label"><strong>Código</strong></label>
                              <div class="controls">
                                  <input type='text' class='span2' id='codigo' name='codigo' >
                              </div>
                          </div>
                          <div class="control-group">
                              <label class="control-label"><strong>Nombre &iacute;tems.</strong></label>
                              <div class="controls">
                                  <input type="text" class="input-xlarge" id="nombre" name="nombre" >
                              </div>
                          </div>
                          <div class="control-group">
                              <label class="control-label"><strong>Cuenta Contable</strong></label>
                              <div class="controls">
                                  <input type="text" class="span2" id="cta_contable" name="cta_contable" >
                              </div>
                          </div>
                          <input type="hidden" class="span2" id="id" name="id" >
                          <div class="form-actions">
                              <input data-toggle="tooltip" data-placement="top" title="Guardar Código" type="submit" class="btn btn-success" onclick = "this.form.action = '<?php echo base_url('index.php/especificos/especificos/guardar_codigo_sistema');?>'" value="Nueva" />
                              <input data-toggle="tooltip" data-placement="top" title="Editar Código" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url('index.php/especificos/especificos/editar_codigo_sistema');?>'" value="Modificar" />
                         </div>
                      </fieldset>
                  </form>
              </div>
              <div class="span8 " style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered codigo_list" id="codigo_list">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre &iacute;tem</th>
                            <th>Cuenta Contable</th>
			                  </tr>
                      </thead>
                      <tbody>
                              <?php foreach ($codigos as $codigo){ ?>
                                  <tr>
                                      <td><a class="codigo-click" data-id="<?php echo $codigo['id']; ?>" data-codigo="<?php echo $codigo['codigo_sistema']; ?>" data-item="<?php echo $codigo['item']; ?>" data-cta="<?php echo $codigo['cuenta_contable']; ?>" ><?php echo $codigo['codigo_sistema']; ?></a></td>
                                      <td><?php echo $codigo['item']; ?></td>
                                      <td><?php echo $codigo['cuenta_contable']; ?></td>
                                  </tr>
                              <?php } ?>
                      </tbody>
                  </table>    
              </div>
          </div>

<script type="text/javascript">
$( document ).ready(function() {
    $('.codigo_list .codigo-click').click(function(e){
        e.preventDefault();
        $('#id').val($(this).attr('data-id'));
        $('#nombre').val(item = $(this).attr('data-item'));
        $('#codigo').val($(this).attr('data-codigo'));
        $('#cta_contable').val($(this).attr('data-cta'));
      
    }); 
});

</script>

            
