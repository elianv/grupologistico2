                    <table id="tabla-ordenes-proveedores" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proveedores as $proveedor) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$proveedor['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $proveedor['id_orden']; ?></a></td>
                                            <td><?php echo $proveedor['tipo_orden']; ?></td>
                                            <td><?php echo $proveedor['estado']; ?></td>
                                            <?php $fecha = new DateTime($proveedor['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                    </table> 