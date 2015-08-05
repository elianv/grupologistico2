                    <table id="tabla-ordenes-conductor" class="table table-hover table-condensed table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Tipo Orden</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($conductores as $conductor) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('index.php/transacciones/orden/pdf/'.$conductor['id_orden'])?>" title="Para ver la Orden haga click"><?php echo $conductor['id_orden']; ?></a></td>
                                            <td><?php echo $conductor['tipo_orden']; ?></td>
                                            <td><?php echo $conductor['estado']; ?></td>
                                            <?php $fecha = new DateTime($conductor['fecha']); ?>
                                            <td><?php echo $fecha->format('d-m-Y'); ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                    </table> 