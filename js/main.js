$('.form-navieras .codigo-click').click(function(e){

	e.preventDefault();
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-navieras #codigo_naviera').attr('value', codigo);
	
	var nombre = $(this).parent().next('.nombre').text();

	$('.form-left-navieras #nombre').attr('value', nombre);

});

/*Camiones*/

$('.form-camiones .codigo-click').click(function(e){
	
	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/camiones',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('.form-left-camiones input[type="hidden"]').val(response[0].camion_id);
			$('.form-left-camiones #patente').val(response[0].patente);
			$('#telefono').val(response[0].celular);
		}
	});

});

/*Puertos*/

$('.form-puertos .codigo-click').click(function(e){

	e.preventDefault();
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-puertos #codigo_puerto').attr('value', codigo);
	
	var nombre = $(this).parent().next('.nombre').text();

	$('.form-left-puertos #nombre').attr('value', nombre);

});

/*Tipos de Cargas*/

$('.form-cargas .codigo-click').click(function(e){

	e.preventDefault();
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-cargas #codigo_carga').attr('value', codigo);
	
	var nombre = $(this).parent().next('.descripcion').text();

	$('.form-left-cargas #descripcion').attr('value', nombre);

});

/*Depositos*/

$('.form-depositos .codigo-click').click(function(e){

	e.preventDefault();
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-depositos #codigo_deposito').attr('value', codigo);
	
	var nombre = $(this).parent().next('.descripcion').text();

	$('.form-left-depositos #descripcion').attr('value', nombre);

});

//Llevar los datos por Ajax Clientes

$('.form-clientes .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/clientes',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			//console.log(response);
			$('#rut').val(response[0].rut_cliente);
			$('#rsocial').val(response[0].razon_social);
			$('#giro').val(response[0].giro);
			$('#direccion').val(response[0].direccion);
			$('#comuna').val(response[0].comuna);
			$('#ciudad').val(response[0].ciudad);
			$('#telefono').val(response[0].fono);
			$('#celular').val(response[0].celular);
			$('#contacto').val(response[0].contacto);
			$('#dplazo').val(response[0].dias_plazo);
			$('#tfactura').val(response[0].tipo_factura);
		}
	});

});

/*CAmbio campo Ret*/

$('.form-orden #tipo_factura').change(function(){

	var filtro = $('.form-orden #tipo_factura :selected').text();

	if(filtro == 'NACIONAL')
	{
		$('.form-orden .ret label strong').text('Origen');
		$('.form-orden .booking label strong').text('Booking');
		$('.form-orden .destino label strong').text('Destino');
		$('.form-orden .tramo label strong').text('Tramo');
	}
	if(filtro == 'EXPORTACION'){
		$('.form-orden .ret label strong').text('Ret. Contenedor');
		$('.form-orden .booking label strong').text('Booking');
		$('.form-orden .destino label strong').text('Destino');
		$('.form-orden .tramo label strong').text('Tramo');
	}
	if(filtro == 'IMPORTACION'){
		$('.form-orden .ret label strong').text('Ret. Contenedor');
		$('.form-orden .booking label strong').text('Tarjeton');
		$('.form-orden .destino label strong').text('Entrega vacio');
		$('.form-orden .tramo label strong').text('Tramo');		
	}
	if(filtro == 'OTRO SERVICIO'){
		$('.form-orden .ret label strong').text('Ret. Contenedor');
		$('.form-orden .booking label strong').text('Booking');
		$('.form-orden .destino label strong').text('Destino');
		$('.form-orden .tramo label strong').text('Descripcion');		
	}

});


//$('.form-orden #fecha').datepicker();
$('.form-orden #fecha').datetimepicker();
$('.form-orden #fecha_carga').datetimepicker();
$('.form-orden #fecha_presentacion').datetimepicker();

$.datepicker.regional['es'] = {
		clearText: 'Borra',
		clearStatus: 'Borra fecha actual',
		closeText: 'Cerrar',
		closeStatus: 'Cerrar sin guardar',
		prevText: '<Ant',
		prevBigText: '<<',
		prevStatus: 'Mostrar mes anterior',
		prevBigStatus: 'Mostrar a�o anterior',
		nextText: 'Sig>',
		nextBigText: '>>',
		nextStatus: 'Mostrar mes siguiente',
		nextBigStatus: 'Mostrar a�o siguiente',
		currentText: 'Hoy',
		currentStatus: 'Mostrar mes actual',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		monthStatus: 'Seleccionar otro mes',
		yearStatus: 'Seleccionar otro a�o',
		weekHeader: 'Sm',
		weekStatus: 'Semana del a�o',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi�', 'Jue', 'Vie', 'Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		dayStatus: 'Set DD as first week day',
		dateStatus: 'Select D, M d',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		initStatus: 'Seleccionar fecha',
		isRTL: false
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
/*Tipos de Naves*/

$('.form-naves .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/naves',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#codigo_nave').val(response[0].codigo_nave);
			$('#nombre').val(response[0].nombre);
			$('#codigo_naviera').val(response[0].naviera_codigo_naviera+' - '+response[0].nombre);
		}
	});

});

/*Agencias Aduanas*/

$('.form-aduanas .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/agencias',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#codigo_aduana').val(response[0].codigo_aduana);
			$('#nombre').val(response[0].nombre);
			$('#contacto').val(response[0].contacto);
			$('#telefono').val(response[0].telefono);
		}
	});

});

/*Tramos*/

$('.form-tramos .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/tramos',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#codigo_tramo').val(response[0].codigo_tramo);
			$('#descripcion').val(response[0].descripcion);
			$('#valor_costo').val(response[0].valor_costo);
			$('#valor_venta').val(response[0].valor_venta);
			$('#tfactura').val($('#tfactura option[value='+response[0].moneda_id_moneda+']').val());
		}
	});

});

/*Proveedores*/

$('.form-proveedores .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/proveedores',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#rut').val(response[0].rut_proveedor);
			$('#rsocial').val(response[0].razon_social);
			$('#giro').val(response[0].giro);
			$('#direccion').val(response[0].direccion);
			$('#comuna').val(response[0].comuna);
			$('#ciudad').val(response[0].ciudad);
			$('#telefono').val(response[0].fono);
			$('#celular').val(response[0].celular);
			$('#contacto').val(response[0].contacto);
			$('#dplazo').val(response[0].dias_plazo);
			$('#tfactura').val(response[0].tipo_factura_id_tipo_facturacion);
		}
	});

});

/*Bodegas*/

$('.form-bodegas .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/bodegas',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#codigo_bodega').val(response[0].codigo_bodega);
			$('#nombre').val(response[0].nombre);
			$('#contacto').val(response[0].contacto);
			$('#direccion').val(response[0].direccion);
			$('#telefono').val(response[0].telefono);
		}
	});

});

/*Servicios*/

$('.form-servicios .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/servicios',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#codigo').val(response[0].codigo_servicio);
			$('#descripcion').val(response[0].descripcion);
			$('#vcosto').val(response[0].valor_costo);
			$('#vventa').val(response[0].valor_venta);
			$('#moneda').val(response[0].moneda_id_moneda);
		}
	});

});

/*Conductores*/

$('.form-conductores .codigo-click').click(function(e){
	
	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/conductores',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('#rut').val(response[0].rut);
			$('#descripcion').val(response[0].descripcion);
			$('#telefono').val(response[0].telefono);
		}
	});

});

/*--Ordenes--*/

$('.boton-repetir a').click(function(e){

	e.preventDefault();
	
	$('.campo-a-repetir:last').after($('.campo-a-repetir:last').clone());
	
	$('.campo-a-repetir:last').removeClass('original');
	
	document.setCloneEvent();
	
});

/*Repetir campo + funcion para que Clon pueda quedar "activo"*/

(document.setCloneEvent = function(){

	$('.campo-a-repetir .btn').last().click(function(){
		
		$('.campo-a-repetir').removeClass('activo');

		$(this).parent().parent().parent().parent().addClass('activo');

	});
	
})();

$('#modal-servicio .close').click(function(){

	$('.campo-a-repetir').removeClass('activo');

});

/*Pasar de modal c/s clon*/

$('#modal-servicio .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/servicios',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('.campo-a-repetir.activo #servicio').val(response[0].codigo_servicio+' - '+response[0].descripcion);
			$('.campo-a-repetir.activo #valor_costo_servicio').val(response[0].valor_costo);
			$('.campo-a-repetir.activo #valor_venta_servicio').val(response[0].valor_venta);
		}
	});
	
	$('#modal-servicio').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	});

});

/*Pasar de modal*/

$('#modal-cliente .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #cliente').attr('value', $(this).data('codigo'));
	$('.form-orden #cliente').val($(this).data('codigo'));
	$('.form-orden .nombre-cliente').val(nombre);
	
	$('#modal-cliente').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Pasar de modal Navieras*/

$('#modal-servicio .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('#codigo_naviera').attr('value', $(this).data('codigo')+'-'+nombre);
	
	$('.modal-naves').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - Aduanas */

$('#modal-aduana .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #aduana').val($(this).data('codigo')+' - '+nombre);
	
	$('#modal-aduana').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - Nave */

$('#modal-nave .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #nave').val($(this).data('codigo')+' - '+nombre);
	
	$('#modal-nave').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - tramo */

$('#modal-tramo .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$.ajax({
		type:'post',
		url:'../mantencion/tramos',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('.form-orden #tramo').val(response[0].codigo_tramo);
			$('.form-orden #valor_costo_tramo').val(response[0].valor_costo);
			$('.form-orden #valor_venta_tramo').val(response[0].valor_venta);
		}
	});
	
	$('#modal-tramo').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - carga */

$('#modal-carga .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #carga').val($(this).data('codigo')+' - '+nombre);
	
	$('#modal-carga').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - bodega */

$('#modal-bodega .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #bodega').val($(this).data('codigo')+' - '+nombre);
	
	$('#modal-bodega').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - Deposito */

$('#modal-deposito .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #deposito').val($(this).data('codigo')+' - '+nombre);
	
	$('#modal-deposito').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - proveedor */

$('#modal-proveedor .codigo-click').click(function(e){

	e.preventDefault();
	
	$('.form-orden #rut').attr('value', $(this).data('codigo'));
	
	$('#modal-proveedor').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - conductor */

$('#modal-conductor .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #conductor').val($(this).data('codigo'));
	
	$('.form-orden .nombre-conductor').val(nombre);
	
	$('#modal-conductor').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Modal Ordn - Patente */

$('#modal-camion .codigo-click').click(function(e){

	e.preventDefault();
	
	$.ajax({
		type:'post',
		url:'../mantencion/camiones',
		dataType: 'json',
		data:{codigo:$(this).data('codigo')},
		//beforeSend: function(){//},
		success:function(response) {
			console.log(response);
			$('.form-orden #camion_id').val(response[0].camion_id);
			$('.form-orden #patente').val(response[0].patente);
		}
	});
	
	$('#modal-camion').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});


/*Ordenes Servicios*/

$('.modal-naves .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('#codigo_naviera').attr('value', $(this).data('codigo')+'-'+nombre);
	
	$('.modal-naves').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*VAlores Decimales*/

function valor_format(input){

	input = input.replace(/[^0-9]*/gi, '');

    var output = '';
    $(input.split('').reverse()).each(function(i){
        output += this;
        
        if (i % 3 == 2) output += '.';
    });
    return output.split('').reverse().join('').replace(/^\./, '');
}
//valor_format();

$('.form-left-tramos #valor_costo , .form-left-tramos #valor_venta , .form-left-servicios #vcosto , .form-left-servicios #vventa , .form-orden #valor_costo_tramo , .form-orden #valor_venta_tramo , .form-orden #valor_costo_servicio , .form-orden #valor_venta_servicio').on('keyup', function(){

/* Lo mismo de abajo pero en menos lineas
	var valor = $(this).val();
	
	valor = valor_format(valor);
	
	$(this).val(valor);
*/
	
	$(this).val(valor_format($(this).val()));
});

/*Rut*/

$(".form-left-clientes #rut , .form-left-conductores #rut , .form-left-proveedores #rut , .form-orden #cliente , .form-orden #rut , .form-orden #conductor").Rut({
   on_error: function(){ alert('El rut ingresado es incorrecto'); },
    format_on: 'keyup'
})




/*--Ordenes--*/

$('.boton-clonar a').click(function(e){

	e.preventDefault();
	
	$('.repetir-guia:last').after($('.repetir-guia:last').clone());
	
	document.setCloneEvent();
	
});


/*Modal Orden - Puerto*/

$('#modal-puerto .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #puerto').attr('value', '');
	//$('.form-orden #puerto').attr('value', $(this).data('codigo')+'-'+nombre);
	$('.form-orden #puerto').val($(this).data('codigo')+'-'+nombre);
	$('.form-orden #puerto').text($(this).data('codigo')+'-'+nombre);
	
	$('#modal-puerto').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	});

});

/*Modal Orden - Destino*/

$('#modal-destino .codigo-click').click(function(e){

	e.preventDefault();
	
	var nombre = $(this).parent().next('td').text();
	
	$('.form-orden #destino').attr('value', '');
	$('.form-orden #destino').val($(this).data('codigo')+'-'+nombre);
	$('.form-orden #destino').text($(this).data('codigo')+'-'+nombre);
	
	$('#modal-destino').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	});

});

