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