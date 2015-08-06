                    <table id="tabla-ordenes-clientes" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clientes as $cliente) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$cliente['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $cliente['id_orden']; ?></a></td>
                                            <td><?php echo $cliente['tipo_orden']; ?></td>
                                            <td><?php echo $cliente['estado']; ?></td>
                                            <?php $fecha = new DateTime($cliente['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                    </table> 