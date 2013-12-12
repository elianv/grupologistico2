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
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-camiones #patente').attr('value', codigo);
	
	var nombre = $(this).parent().next('.celular').text();

	$('.form-left-camiones #telefono').attr('value', nombre);

});

/*Conductores*/

$('.form-conductores .codigo-click').click(function(e){

	e.preventDefault();
	
	var codigo = $(this).attr('data-codigo');
	
	$('.form-left-conductores #rut').attr('value', codigo);
	
	var nombre = $(this).parent().next('.descripcion').text();

	$('.form-left-conductores #descripcion').attr('value', nombre);

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
			$('#tfactura').val(response[0].tipo_factura_id_tipo_facturacion);
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

$.datepicker.regional['es'] = {
		clearText: 'Borra',
		clearStatus: 'Borra fecha actual',
		closeText: 'Cerrar',
		closeStatus: 'Cerrar sin guardar',
		prevText: '<Ant',
		prevBigText: '<<',
		prevStatus: 'Mostrar mes anterior',
		prevBigStatus: 'Mostrar año anterior',
		nextText: 'Sig>',
		nextBigText: '>>',
		nextStatus: 'Mostrar mes siguiente',
		nextBigStatus: 'Mostrar año siguiente',
		currentText: 'Hoy',
		currentStatus: 'Mostrar mes actual',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		monthStatus: 'Seleccionar otro mes',
		yearStatus: 'Seleccionar otro año',
		weekHeader: 'Sm',
		weekStatus: 'Semana del año',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		dayStatus: 'Set DD as first week day',
		dateStatus: 'Select D, M d',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		initStatus: 'Seleccionar fecha',
		isRTL: false
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	
	
	
/*Pasar de modal*/

$('#modal-cliente .codigo-click').click(function(e){

	e.preventDefault();
	
	$('.form-orden #cliente').attr('value', $(this).data('codigo'));
	
	$('#modal-cliente').fadeOut('fast',function(){
	
		$('body').removeClass('modal-open');
		
		$('.modal-backdrop.fade.in').remove();
	
	
	});

});

/*Duplicar*/

$('.boton-repetir a').click(function(e){

	e.preventDefault();
	
	$('.campo-a-repetir:last').after($('.campo-a-repetir:last').clone());

});

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
			$('#codigo_naviera').val(response[0].naviera_codigo_naviera);
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
			$('#tfactura').val(response[0].moneda_id_moneda);
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