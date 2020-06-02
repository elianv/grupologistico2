<center><h3>Datos Cargados</h3></center>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example"> 
    <thead>
        <tr>
            <th>Orden Cliente</th>
            <th>OS GLC</th>
            <th>Acción</th>>
        </tr>
    </thead>
    <tbody>
        <?php foreach($result as $key => $value){ ?>
            <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $value; ?></td>
                <td><a class="btn btn-primary" target="_blank" href="<?php echo base_url('transacciones/orden/formulario_editar/'.$value); ?>" <i class=" icon-edit icon-white"></i> Editar</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>    