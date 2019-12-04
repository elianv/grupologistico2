    <legend><h3><center>Mantención de Usuarios</center></h3></legend>
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
                <label class="control-label" for="rut_usuario"><strong>Rut Usuario</strong></label>
                <div class="controls">
                 <input type='text' class='span2' name='rut_usuario' id='rut_usuario' placeholder="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="nombre"><strong>Nombre Usuario</strong></label>
                <div class="controls">
                 <input type='text' class='span3' name='nombre' id='nombre' placeholder="">
                </div>
            </div>          
            <div class="control-group">
                <label class="control-label" for="clave"><strong>Clave</strong></label>
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
                                       $num = range(0,100);
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
                 <input data-toggle="tooltip" data-placement="top" title="Editar Usuario existente" type="submit" class="btn btn-danger" onclick = "this.form.action = '<?php echo base_url();?>index.php/especificos/usuarios/modificar_usuario'" value="Modificar" />

             </div>
           </fieldset>
          </form>
     </div>
      <div class="span8 form-usuarios" style="margin-left: 50px">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                      <thead>
                        <tr>
                            <th>Rut Usuario</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php foreach ($tablas as $tabla) { ?>
			                      <tr>
			                      <td><a class="codigo-click" data-rut="<?php echo $tabla['rut_usuario']; ?>" data-nombre="<?php echo $tabla['nombre'];?>" data-tipo="<?php echo $tabla['id_tipo_usuario'];?>"><?php echo $tabla['rut_usuario']; ?></a></td>
			                      <td><?php echo $tabla['nombre']; ?></td>
                            <td><?php echo $tabla['tipo_usuario']; ?></td>
			                      </tr>
			                  <?php } ?>
                       </tbody>
                  </table>    
       </div>
        
          
      </div>
  </div>


<script type="text/javascript">
    $(document).ready(function(){
		$('.table .codigo-click').click(function(e){
			e.preventDefault();
			var rut_usuario = $(this).attr('data-rut');
			var nombre = $(this).attr('data-nombre');
      var tipo = $(this).attr('data-tipo');
      console.log("tipo usuario:"+tipo);
			$('#rut_usuario').val(rut_usuario);
			$('#nombre').val(nombre);
      $('#tusuario').val(tipo).find("option[value="+tipo+"]").attr('selected',true);
		});
		$('#tabla-ordenes-clientes').DataTable();	
    $('#tabla-cliente').DataTable();					           
    });
        

</script>