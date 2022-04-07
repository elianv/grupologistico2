<br>
<hr>
<br>
<legend><h3><center>Editar Orden </center></h3></legend>
<form class="form-horizontal" method="POST" action="<?php echo base_url('index.php/transacciones/orden/editarDatosFaltantes'); ?>">
  	
  	<div class="control-group">
    	<label class="control-label"><b>N° Orden</b></label>
    	<div class="controls">
      	<input type="text" id="inputOrden" placeholder="Orden" disabled="" value="<?php echo $data[0]['id_orden'];?>">
      	<input type="hidden" id="inputOrden_" name="inputOrden_" value="<?php echo $data[0]['id_orden']; ?>">
    	</div>
  	</div>

  	<div class="control-group">
    	<label class="control-label" ><b>Proveedor</b></label>
    	<div class="controls">
    		<div class="input-append">
      			<input type="text" class="input-xxlarge" id="inputProveedor" value="<?php echo $data[0]['proveedor_rut_proveedor'].'   '.$data[0]['proveedor'] ;?>" readonly>
  				<a class="btn" type="button" onclick="openModal('proveedor')"><i class="icon-search"></i></a>
			</div>      			
      		<input class="input-xxlarge" type="hidden" id="inputProveedor_" name="inputProveedor"value="<?php echo $data[0]['proveedor_rut_proveedor'];?>" >
    	</div>
  	</div>

<?php if (isset($orden_factura[0])) { ?>
    <h6>Factura proveedor</h6>

    <input type="hidden" id="ordenFactura" name="ordenFactura" value="<?php echo $orden_factura[0]['id_of'];?>" >

    <div class="control-group">
        <label class="control-label" ><b>Factura Proveedor</b></label>
        <div class="controls">
            <input type="text" class="input-small" id="inputFactProveedor" value="<?php echo $orden_factura[0]['factura_tramo'];?>" name="factura_proveedor" required>
        </div>
    </div>    

    <div class="control-group">
        <label class="control-label" ><b>Fecha Factura Proveedor</b></label>
        <div class="controls">
            <input type="text" class="input-medium" id="inputFechaProveedor" value="<?php echo $orden_factura[0]['fecha_factura_tramo'];?>" name="fecha_factura_proveedor" required readonly>
        </div>
    </div>    

    <input type="hidden" name="idFactura_" value="<?php echo $orden_factura[0]['id_factura'];?>">
<?php } ?>
  	<div class="control-group">
    	<label class="control-label" ><b>Cliente</b></label>
    	<div class="controls">
    		<div class="input-append">
      			<input type="text" class="input-xxlarge" id="inputCliente" value="<?php echo $data[0]['cliente_rut_cliente'].'    '.$data[0]['cliente'];?>" readonly>
  				<a class="btn" type="button" onclick="openModal('cliente')"><i class="icon-search"></i></a>
			</div>      			    	
      		<input class="input-xxlarge" type="hidden" id="inputCliente_" name="inputCliente" value="<?php echo $data[0]['cliente_rut_cliente'];?>">
    	</div>
  	</div>  	
  	
  	<div class="control-group">
    	<label class="control-label" ><b>Tramo</b></label>
    	<div class="controls">
    		<div class="input-append">
      			<input type="text" id="inputTramo" class="input-xlarge" value="<?php echo $data[0]['tramo_codigo_tramo'].' - '.$data[0]['tramo'];?>" readonly>
  				<a class="btn" type="button" onclick="openModal('tramo')"><i class="icon-search" ></i></a>
			</div>      			    	      		
      		<input type="hidden" id="inputTramo_" name="inputTramo" value="<?php echo $data[0]['tramo_codigo_tramo'];?>">
    	</div>
  	</div>  	
  	
  	<div class="control-group">
    	<label class="control-label" ><b>Costo Tramo</b></label>
    	<div class="controls">
      		<input type="text" id="inputCosto" name="inputCosto" value="<?php echo number_format($data[0]['valor_costo_tramo'], 0, ',', '.') ?>">
    	</div>
  	</div>
  	
  	<div class="control-group">
    	<label class="control-label" ><b>Venta Tramo</b></label>
    	<div class="controls">
      		<input type="text" id="inputVenta" disabled="" value="<?php echo number_format($data[0]['valor_venta_tramo'], 0, ',', '.') ?>">
    	</div>
  	</div>

    <?php if ( isset($detalle[0]) ){?>
        <hr>
        <?php $i = 0; ?>
        <?php foreach ($detalle as $d) { ?>
            <h6>Otros servicios</h6>
            <input type="hidden" id="inputIdOtroServicio" value="<?php echo $d['id_detalle']; ?>">

            <div class="control-group">
                <label class="control-label" ><b>Otro Servicio</b></label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" id="inputOtroServicio" disabled="" value="<?php echo $d['servicio_codigo_servicio'].'  -  '.$d['descripcion']; ?>">
                    <input type="hidden" id="inputOtroServicio" value="<?php echo $d['servicio_codigo_servicio']; ?>">

                </div>
            </div>     
                </div>     
            </div>     

            <div class="control-group">
                <label class="control-label" ><b>Proveedor otro servicio</b></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="inputProveedor_<?php echo $i; ?>" value="<?php echo $d['proveedor_rut_proveedor'].'   '.$d['razon_social'] ;?>" readonly>
                        <a class="btn" type="button" onclick="openModal('proveedor',<?php echo "'".$i."'"; ?>)"><i class="icon-search"></i></a>
                    </div>                  
                        </div>                  
                    </div>                  
                    <input class="input-xxlarge" type="hidden" id="inputProveedorOtroServicio_<?php echo $i; ?>" name="inputProveedorOtroServicio_[]" value="<?php echo $d['proveedor_rut_proveedor'].'W'.$d['id'].'W'.$d['detalle_id_detalle'].'W'.$d['orden_id_orden'].'W'.$d['id_ordenes_facturas']  ;?>" >
                    <input type="hidden" id="inputProveedorOtroServicioNew_<?php echo $i; ?>" name="inputProveedorOtroServicioNew_[]" value="<?php echo $d['proveedor_rut_proveedor'];?>" >
                </div>
            </div>                 
                </div>                 
            </div>                 

            <div class="control-group">
                <label class="control-label" ><b>Factura Proveedor Otro Servicio</b></label>
                <div class="controls">
                    <input type="text" class="input-small" name="inputFacturaOS_[]" id="inputFacturaOS_<?php echo $i; ?>" value="<?php echo $d['factura_numero_factura'];?>" >
                </div>
            </div>    
                </div>    
            </div>    

            <div class="control-group">
                <label class="control-label" ><b>Fecha Factura Proveedor Otro Servicio</b></label>
                <div class="controls">
                <?php $fecha = new DateTime($d['fecha_factura_servicio']);?>
                    <input type="text" onclick="calendario(<?php echo $i; ?>)" class="input-medium" name="inputFechaOS_[]" id="inputFechaOS_<?php echo $i; ?>" value="<?php echo $fecha->format('d-m-Y');?>" >
                </div>
            </div>             
                </div>             
            </div>             

            <div class="control-group">
                <label class="control-label" ><b>Costo otro servicio</b></label>
                <div class="controls">
                    <input type="text" name="inputCostoOS_[]" id="inputCostoOS_<?php echo $i; ?>" value="<?php echo number_format($d['valor_costo'], 0, ',', '.') ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" ><b>Venta otro servicio</b></label>
                <div class="controls">
                    <input type="text" id="inputVenta" disabled="" value="<?php echo number_format($d['valor_venta'], 0, ',', '.') ?>">
                </div>
            </div>
                </div>                
            </div>

        <?php $i++; ?>
        <?php } ?>
        
	<?php } ?>
    
    <div class="campo-a-repetir original" data-form="0">
        <hr>
        <h6>Otros servicios</h6>
            <div class="control-group">
                <label class="control-label" ><b>Otro Servicio</b></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="inputOtroServicio" name="append_inputOtroServicio_[]" value="">
                        <a class="btn" type="button" onclick="openModal('otro servicio',)"><i class="icon-search"></i></a>
                    </div>
                </div>
            </div>     

            <div class="control-group">
                <label class="control-label" ><b>Proveedor otro servicio</b></label>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" class="input-xxlarge" id="inputProveedor_" name="append_inputProveedor_[]" value="" >
                        <a class="btn boton-levantar-modal" type="button" onclick="openModal('proveedor', '', '0')" data-form="0"><i class="icon-search" style="pointer-events: none"></i></a>
                    </div>                  
                </div>
            </div>                 

            <div class="control-group">
                <label class="control-label" ><b>Factura Proveedor Otro Servicio</b></label>
                <div class="controls">
                    <input type="text" class="input-small" name="append_inputFacturaOS_[]" id="_inputFacturaOS_" value="" >
                </div>
            </div>    

            <div class="control-group">
                <label class="control-label" ><b>Fecha Factura Proveedor Otro Servicio</b></label>
                <div class="controls">
                    <input type="text" class="input-medium inputFechaOS" name="append_inputFechaOS_[]" value="" readonly >
                </div>
            </div>             

            <div class="control-group">
                <label class="control-label" ><b>Costo otro servicio</b></label>
                <div class="controls">
                    <input type="text" name="append_inputCostoOS_[]" id="inputCostoOS_" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" ><b>Venta otro servicio</b></label>
                <div class="controls">
                    <input type="text" name="append_inputVenta_[]" id="inputVenta" value="">
                </div>
            </div>
    </div>
    
    <div class="control-group">
        <div class="eliminar-campo">
            <a >Eliminar Servicio <span>-</span></a>
        </div>
    </div>
    
    <div class="control-group">
        <div class="boton-repetir">
            <a >Agregar otro Servicio <span>+</span></a>
        </div>
    </div>

    <div class="form-actions">
        <div class="controls">
            <button type="submit" class="btn btn-success">Editar</button>
        </div>
    </div>

    
</form>
<br>
<hr>
<br>
<script type="text/javascript">

    $( document ).ready( function(){

        $('.inputFechaOS').datetimepicker({
                changeMonth: true,
                changeYear: true,
                showHour:false,                      
                showMinute:false,
                showTime: false,
                dateFormat: 'dd-mm-yy'
        }); 


        $('#inputFechaProveedor').datetimepicker({
                changeMonth: true,
                changeYear: true,
                showHour:false,                      
                showMinute:false,
                showTime: false,
                dateFormat: 'dd-mm-yy'
        });        
        $('#inputFechaProveedor').datetimepicker({
                changeMonth: true,
                changeYear: true,
                showHour:false,                      
                showMinute:false,
                showTime: false,
                dateFormat: 'dd-mm-yy'
        });        
        function calendario(id){
            $('#inputFechaOS_'+id).datetimepicker({
                changeMonth: true,
                changeYear: true,
                showHour:false,                      
                showMinute:false,
                showTime: false,
                dateFormat: 'dd-mm-yy'
            });              
        }
   
    });

    $('.inputFechaOS').click(function(){
        $('.inputFechaOS').datetimepicker({
                changeMonth: true,
                changeYear: true,
                showHour:false,                      
                showMinute:false,
                showTime: false,
                dateFormat: 'dd-mm-yy'
        });              
    });

    function openModal(id, serv, currentForm) {
        
        var currentElement = event.target.getAttribute('data-form')
        $('#modalBody').html();
        tHeader = '<table id="tabla_modal" class="table table-bordered table-striped dataTable"><thead><tr>';
        tBody   = '<th>RUT</th><th>Razón Social</th></tr></thead><tbody>';
        tFooter = '</tbody></table>';
        $('#modalHeader').html('Seleccione un '+id);
        switch (id){
            case 'proveedor':
                opc = 1;
            break;
            case 'cliente':
                opc = 2;
            break;
            case 'tramo':
                opc = 3;
                tBody = '<th>Código</th><th>Tramo</th></tr></thead><tbody>';
            break;
            case 'otro servicio':
                opc = 4;
                tBody = '<th>Código</th><th>Otro servicio</th></tr></thead><tbody>';
        }
        $.ajax({
                type:'post',
                url:'<?php echo base_url();?>index.php/transacciones/orden/modalDatosFaltantes_ajax',
                dataType: 'json',
                data: { dato : opc},
                beforeSend: function(){
                    $('#modalHeader').html();
                    $('#modalBody').html();
                },
                success: function(response){

                    $('#modalHeader').html('Seleccione un '+id);
                    switch (id){
                        case 'proveedor':
                            $.each(response, function(i, item) {
                                if (serv === undefined){
                                    tBody = tBody + "<tr><td><a onclick=\"imputText('"+item.rut_proveedor+"', '"+item.razon_social+"', 'inputProveedor')\">"+ item.rut_proveedor +"</a></td><td>"+item.razon_social+"</td></tr>";
                                }
                                else{
                                    tBody = tBody + "<tr><td><a onclick=\"imputText('"+item.rut_proveedor+"', '"+item.razon_social+"', 'inputProveedor_"+serv+"','"+serv+"', '"+currentElement+"'  )\" data-element="+currentElement+">"+ item.rut_proveedor +"</a></td><td>"+item.razon_social+"</td></tr>";   
                                }
                                
                            });              
                        break;
                        case 'cliente':
                            $.each(response, function(i, item) {
                                tBody = tBody + "<tr><td><a onclick=\"imputText('"+item.rut_cliente+"', '"+item.razon_social+"', 'inputCliente')\">"+ item.rut_cliente +"</a></td> <td>"+item.razon_social+"</td></tr>";
                            });                                      
                        break;
                        case 'tramo':
                            $.each(response, function(i, item) {
                                tBody = tBody + "<tr><td><a onclick=\"imputText('"+item.codigo_tramo+"', '"+item.descripcion+"', 'inputTramo')\">"+ item.codigo_tramo +"</a></td> <td>"+item.descripcion+"</td></tr>";
                            });                                      
                        break;
                        case 'otro servicio':
                            $.each(response, function(i, item) {
                                tBody = tBody + "<tr><td><a onclick=\"imputText('"+item.codigo_servicio+"', '"+item.descripcion+"', 'inputOtroServicio')\">"+ item.codigo_servicio +"</a></td> <td>"+item.descripcion+"</td></tr>";
                            });                                      
                        break;                        
                    }       
                    tabla = tBody+'';          
                    //console.log(tHeader+''+tBody+''+tFooter);
                    $('#modalBody').html(tHeader+''+tBody+''+tFooter);
                    $('#tabla_modal').DataTable();
                }
        });
        
        $('#myModal').modal();

    }

    function imputText(codigo, texto, opc, serv, currentForm ){

        var currentElement = event.target.getAttribute("data-element");

        $('#'+opc).val(codigo+'   '+texto);
        $('#'+opc+'_').val(codigo);
        $('#myModal').modal('hide')
        if( serv !== undefined){
            $('#inputProveedorOtroServicioNew_'+serv).val(codigo);
        }

        currentForm ? $(".campo-a-repetir[data-form="+currentElement+"]").find("#inputProveedor_").val(codigo +' - '+texto) : '';
    }
    


</script>

<script type="text/javascript" charset="utf-8" language="javascript" src="<?php echo base_url(); ?>js/edit_orden.js"></script>