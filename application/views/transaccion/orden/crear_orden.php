<div class="container">

	<legend><h3><center>Nueva Orden de Servicio</center></h3></legend>

	<div style="margin-left: 10px">
            <?php

                if(validation_errors()){
                    echo "<div class='alert alert-info '>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                }
            ?>
    </div>
        <?php
            $correcto = $this->session->flashdata('sin_orden');
            if ($correcto){
                echo "<div class='alert alert-error'>";
                echo "<a class='close' data-dismiss='alert'>×</a>";
                echo "<span id='registroCorrecto'>".$correcto."</span>";
                echo "</div>";
            }
        ?>

    <form id="form-crear" class="form-horizontal form-orden" method="post" action='<?php echo base_url("index.php/transacciones/orden/guardar") ?>'>
        <fieldset>
            <div class="row show-grid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="numero_orden"><strong>O.S. N°</strong></label>
                        <div class="controls">
                            <?php echo "<div class='input-append'><input type='text' readonly class='span2' name='numero_orden' id='numero_orden' value=".$numero_orden."></div>"; ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="numero_orden"><strong>Fecha Creaci&oacute;n O.S. </strong></label>
                        <div class="controls">
                            <div class='input-append'><input type='text' readonly class='span2' value="<?php echo date("d-m-Y"); ?>"></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="referencia"><strong>Referencia</strong></label>
                        <div class="controls">
                    <input type="text" class="input-xxlarge" name="referencia" id="referencia" value="<?php echo set_value('referencia'); ?>">
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="control-group">
                        <label class="control-label" for="duplicar_orden"><strong>Duplicar orden</strong></label>
                            <div class="controls">
                                <input type="checkbox" id="checkbox_duplicate" name="checkbox_duplicate">
                            </div>
                        </label>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="tipo_factura"><strong>Tipo</strong></label>
                        <div class="controls">
                            <select id="tipo_factura" name="tipo_orden" class="span2" onchange="cambioOrden(this)">
                                <?php
                                    // print_r(tfacturacion[0]);
                                    foreach ($tfacturacion as $tipo){

                                        if (isset($active)){
                                                if ($active == $tipo['tipo_orden'])
                                                        echo "<option id='".str_replace(' ', '',$tipo['tipo_orden'])."' value='".$tipo['tipo_orden']."' selected>".$tipo['tipo_orden']."</option>";
                                                else {
                                                        echo "<option id='".str_replace(' ', '',$tipo['tipo_orden'])."' value='".$tipo['tipo_orden']."' >".$tipo['tipo_orden']."</option>";
                                                }
                                        }
                                        else {
                                                    echo "<option id='".str_replace(' ', '',$tipo['tipo_orden'])."' value='".$tipo['tipo_orden']."' >".$tipo['tipo_orden']."</option>";

                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            </br>
            </br>
            <!--   ##############################################################    -->

            <div class="control-group">
                <label class="control-label" for="cliente"><strong>RUT Cliente</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="span2" id="cliente" name="cliente_rut_cliente" value="<?php echo set_value('cliente_rut_cliente'); ?>" readonly>
                        <button class="btn" type="button" data-toggle="modal" href="#modal-cliente"><i class="icon-search"></i></button>
                        <input class="nombre-cliente" type="text" readonly="" name="nombre_cliente" value="<?php echo set_value('nombre_cliente'); ?>" placeholder="Nombre Cliente..."/>
                    </div>
                </div>
            </div>


            <div class="control-group booking">
                <label class="control-label" for="booking"><strong>Booking</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="booking" name="booking" value="<?php echo set_value('booking'); ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Aduana</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" value="<?php echo set_value('aduana_codigo_aduana'); ?>" id="aduana" name="aduana_codigo_aduana" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-aduana"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Contacto Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="contacto" readonly="" name="contacto" value="<?php echo set_value('contacto'); ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="aduana"><strong>Fono Aduana</strong></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="telefono" name="fono_aduana" value="<?php echo set_value('fono_aduana'); ?>" readonly >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Nave"><strong>Nave</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="nave" name="nave_codigo_nave" value="<?php echo set_value('nave_codigo_nave'); ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-nave"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Naviera"><strong>Naviera</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="naviera" name="naviera_codigo_naviera" value="<?php echo set_value('naviera_codigo_naviera'); ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-naviera"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="control-group" id="check_tramo" style="display:none;">
                <label class="control-label"></label>
                <div class="checkbox">
                        <input type="checkbox" name="enable_tramo" id="enable_tramo" value="1" onclick="check();"/>      En caso de usar un Tramo selecciones esta opci&oacute;n
                </div>
                </label>
            </div>

            <div style="display:...;" id="select_tramo">
            <div class="control-group tramo" >
                <label class="control-label" for="tramo"><strong>Tramo</strong></label>
                <div class="controls">
                    <div class="input-append"><input type="text" class="input-xxlarge" id="tramo" name="tramo_codigo_tramo" value="<?php echo set_value('tramo_codigo_tramo'); ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-tramo"><i class="icon-search"></i></button></div>
                </div>
            </div>

            <div class="row show-grid">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="valor_costo_tramo"><strong>Valor Costo</strong></label>
                        <div class="controls">
                            <input type="text" class="span2" id="valor_costo_tramo" name="valor_costo_tramo" placeholder="$">
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="valor_venta_tramo"><strong>Valor Venta</strong></label>
                        <div class="controls">
                            <input type="text" class="span2" id="valor_venta_tramo" name="valor_venta_tramo" placeholder="$">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </br>


        <!--   ##############################################################    -->
        <div class="control-group">
            <label class="control-label" for="fecha"><strong>Fecha Retiro</strong></label>
            <div class="controls">
                <input type="text" class="input-large" name="fecha" id="fecha" placeholder="Seleccione Fecha" value="<?php echo set_value('fecha'); ?>" required>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="carga"><strong>Carga</strong></label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" class="input-xxlarge" id="carga" value="<?php echo set_value('tipo_carga_codigo_carga'); ?>" name="tipo_carga_codigo_carga" placeholder="" readonly>
                    <button class="btn" type="button" data-toggle="modal" href="#modal-carga">
                            <i class="icon-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="observacion"><strong>Mercader&iacute;a</strong></label>
            <div class="controls">
                    <textarea class="input-xxlarge" id="mercaderia" name="mercaderia" rows="3"><?php echo set_value('mercaderia'); ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="numero"><strong>N° Contenedor</strong></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="numero" name="numero" value="<?php echo set_value('numero'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="peso"><strong>Peso</strong></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="peso" name="peso" value="<?php echo set_value('peso'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="set_point"><strong>Set Point</strong></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="set_point" name="set_point" value="<?php echo set_value('set_point'); ?>">
            </div>
        </div>

        <div class="control-group deposito" id="form_deposito" style="display:;">
            <label class="control-label" for="bodega"><strong>Dep&oacute;sito</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" value="<?php echo set_value('deposito_codigo_deposito'); ?>" class="input-xxlarge" id="deposito" name="deposito_codigo_deposito" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-deposito"><i class="icon-search"></i></button></div>
            </div>
        </div>


        <div class="control-group retiro" id="form_lugar_retiro" style="display:none;">
            <label class="control-label" for="retiro"><strong>Lugar de Retiro</strong></label>
            <div class="controls">
                <textarea class="input-xxlarge" id="lugar_retiro" name="lugar_retiro" value="<?php echo set_value('lugar_retiro'); ?>"></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="fecha_presentacion"><strong>Fecha Presentación</strong></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="fecha_presentacion" name="fecha_presentacion" placeholder="Seleccione Fecha" value="<?php echo set_value('fecha_presentacion'); ?>" required>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="bodega"><strong>Bodega</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" class="input-xxlarge" id="bodega" name="bodega_codigo_bodega" value="<?php echo set_value('bodega_codigo_bodega'); ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-bodega"><i class="icon-search"></i></button></div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="bodega"><strong>Direcci&oacute;n Bodega</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" readonly="" class="input-xxlarge" name="direccion_bodega" id="direccion_bodega" value="<?php echo set_value('direccion_bodega'); ?>"></div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="bodega"><strong>Contacto Bodega</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" readonly="" class="input-xxlarge" name="contacto_bodega" id="contacto_bodega" value="<?php echo set_value('contacto_bodega'); ?>"></div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="bodega"><strong>Tel&eacute;fono Bodega</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" readonly="" class="input-xxlarge" name="telefono_bodega" id="telefono_bodega" value="<?php echo set_value('telefono_bodega'); ?>" ></div>
            </div>
        </div>

        <div class="control-group" id="form_puerto_embarque" style="display:;">
            <label class="control-label" for="puerto"><strong>Puerto Embarque</strong></label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" class="input-xxlarge" id="puerto" name="puerto_codigo_puerto" value="<?php echo set_value('puerto_codigo_puerto'); ?>" readonly>
                    <button class="btn" type="button" data-toggle="modal" href="#modal-puerto"><i class="icon-search"></i></button>
                </div>
            </div>
        </div>

        <div class="control-group destino" style="display:;" id="p_destino">
            <label class="control-label" for="destino"><strong>Puerto Destino</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" class="input-xxlarge" name="destino" id="destino" value="<?php echo set_value('destino'); ?>" placeholder="" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-destino"><i class="icon-search"></i></button></div>
                </div>
        </div>




        <div class="row show-grid">

            <div class="span5">
                                <div class="control-group">
                                <label class="control-label" for="referencia"><strong>Referencia 2</strong></label>
                                <div class="controls">
                                    <input type="text" class="input-large" id="referencia2" name="referencia2" placeholder="" value="<?php echo set_value('referencia2'); ?>">
                                </div>
                                </div>
            </div>
            <div class="span5">

            </div>

        </div>

        <div class="control-group">
            <label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" class="span2" id="rut" value="<?php echo set_value('proveedor_rut_proveedor'); ?>" name="proveedor_rut_proveedor" placeholder="sin puntos, ni guion" readonly>
                    <button class="btn" type="button" data-toggle="modal" href="#modal-proveedor"><i class="icon-search"></i></button>
                    <input type="text" class="span4" id="rsocial" name="nombre_proveedor" readonly="" placeholder="Nombre Proveedor..." style="margin-left: 40px;" value="<?php echo set_value('nombre_proveedor'); ?>">
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="observacion"><strong>Observación</strong></label>
            <div class="controls">
                <textarea class="input-xxlarge" id="observacion" name="observacion" rows="3"><?php echo set_value('observacion'); ?></textarea>
            </div>
        </div>

        <div class="campo-a-repetir original">

            <div class="control-group">
                <label class="control-label" for="servicio"><strong>Otro Servicio</strong></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="servicio" name="codigo_servicio[]" readonly>
                        <input type="hidden" id="id_detalle" name="id_detalle[]">
                        <button class="btn" type="button" data-toggle="modal" href="#modal-servicio"><i class="icon-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="row show-grid">
                    <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="valor_costo_servicio"><strong>Valor Costo</strong></label>
                        <div class="controls">
                            <input type="text" class="span2" id="valor_costo_servicio" name="valor_costo_servicio[]" placeholder="$">
                        </div>
                    </div>
                    </div>
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="valor_venta_servicio"><strong>Valor Venta</strong></label>
                    <div class="controls">
                        <input type="text" class="span2" id="valor_venta_servicio" name="valor_venta_servicio[]" placeholder="$">
                    </div>
                </div>
                </div>
            </div>

            <div class="eliminar-campo">
                <a href="javascript:void(0);">Eliminar Servicio <span>-</span></a>
            </div>

        </div>

        <div class="boton-repetir">
            <a href="#">Agregar otro Servicio <span>+</span></a>
        </div>


        </br>
        </br>
        </br>

        <!--   #########################################################################    -->

        <div class="control-group">
                <label class="control-label" for="conductor"><strong>Conductor</strong></label>
                <div class="controls">
                    <div class="input-append">
                            <input type="text" class="span2" id="conductor" value="<?php echo set_value('conductor_rut'); ?>" name="conductor_rut" readonly>
                            <button class="btn" type="button" data-toggle="modal" href="#modal-conductor">
                                <i class="icon-search"></i>
                            </button>
                            <input id="nombre_conductor" name="nombre_conductor" class="nombre-conductor"  type="text" placeholder="Nombre Conductor..." readonly="" value="<?php echo set_value('nombre_conductor'); ?>" />
                    </div>
                </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="rut"><strong>Tel&eacute;fono Conductor</strong></label>
            <div class="controls">
                <input id="telefono_conductor" name="telefono_conductor" type="text" readonly="" value="<?php echo set_value('telefono_conductor'); ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="patente"><strong>Patente Cami&oacute;n</strong></label>
            <div class="controls">
                <div class="input-append"><input type="text" class="span2" id="patente" name="patente" value="<?php echo set_value('patente'); ?>" readonly><button class="btn" type="button" data-toggle="modal" href="#modal-camion"><i class="icon-search"></i></button></div>
                <input type="hidden" name="camion_camion_id" id="camion_id" >
                <input type="hidden" name="viaje_id" id="viaje_id">
            </div>
        </div>


        <div class="form-actions" >
            <input type="submit" class="btn btn-success" value="Crear"/> 
            
        </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript">
		$( document ).ready(function() {
					var tipo_orden = $('#tipo_factura').val();
					console.log('tipo de orden :'+tipo_orden);
					switch (tipo_orden) {
						case 'EXPORTACION':
								divC = document.getElementById("form_deposito");
								divC.style.display = "";

								divT = document.getElementById("form_lugar_retiro");
								divT.style.display = "none";

								divP = document.getElementById("form_puerto_embarque");
								divP.style.display = "";

								divB = document.getElementById("check_tramo");
								divB.style.display="none";

								divA = document.getElementById("destino");
								divA.style.display="";
						break;
						case 'IMPORTACION':
								divC = document.getElementById("form_deposito");
								divC.style.display="none";

								divT = document.getElementById("form_lugar_retiro");
								divT.style.display = "";

								divP = document.getElementById("form_puerto_embarque");
								divP.style.display = "none";

								divB = document.getElementById("check_tramo");
								divB.style.display="none";

								divA = document.getElementById("p_destino");
								divA.style.display="";
						break;
						case 'OTRO SERVICIO':
								divC = document.getElementById("check_tramo");
							  divC.style.display="";

			          divA = document.getElementById("p_destino");
			          divA.style.display="none";

							  divB = document.getElementById("select_tramo");
							  divB.style.display="none";

							  divD = document.getElementById("form_deposito");
							  divD.style.display="";
						break;
						case 'NACIONAL':
								divC = document.getElementById("check_tramo");
					  		divC.style.display="none";

			          divA = document.getElementById("p_destino");
			          divA.style.display="none";

					  		divB = document.getElementById("form_deposito");
					  		divB.style.display="";
						break;

					}
		});

		$('.modal').on('shown.bs.modal', function() {
  		$(this).find('[autofocus]').focus();
		});

        
        $('form').submit(function() {
            console.log('enviando ...')
            // when form is submitted for the first time
            // change button text
            // and prevent further form submissions
            if ($('form input[type="submit"]').data('submitted') == '1') {
                return false;
            } else {
                // I've also added a class and 
                // changed the value to make it obvious to the 
                // user that the form is submitting
                // but this is entirely optional
                // and you can customise this as you wish
                $('form input[type="submit"]')
                .attr('data-submitted', '1')
                .addClass('submitting')
                .val('Submitting...')
                .submit();
                $('#form-crear').submit();
            }
        
            return false; // for demo purposes only
        });
        


</script>
