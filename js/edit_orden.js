/*--Ordenes--*/

$('.boton-repetir a').click(function(e){

	console.log('repetir')
	$('.inputFechaOS').datetimepicker({
		changeMonth: true,
		changeYear: true,
		showHour:false,                      
		showMinute:false,
		showTime: false,
		dateFormat: 'dd-mm-yy'
	});

	e.preventDefault();

	$('.campo-a-repetir:last').after($('.campo-a-repetir:last').clone());

	$('.campo-a-repetir:last').removeClass('original');

	var value = $('.campo-a-repetir').not('.original').last().attr('data-form');

	$('.campo-a-repetir').not('.original').last().attr('data-form', parseInt(value)+1);

	$('.campo-a-repetir').not('.original').last().find('.inputFechaOS').attr('class', "input-medium inputFechaOS");

	$('.campo-a-repetir').not('.original').last().find('.boton-levantar-modal').attr('data-form', parseInt(value)+1);

	$('.campo-a-repetir').not('.original').last().find('.boton-levantar-modal-2').attr('data-form', parseInt(value)+1);
	
	$('.campo-a-repetir').not('.original').last().find("#inputProveedor_").val('')

	$('.campo-a-repetir').not('.original').last().find("#inputOtroServicio").val('')

	$('.campo-a-repetir').not('.original').last().find('.inputFechaOS').datetimepicker({
		changeMonth: true,
		changeYear: true,
		showHour:false,                      
		showMinute:false,
		showTime: false,
		dateFormat: 'dd-mm-yy'
	});

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

$('.eliminar-campo a').click(function(e){
	e.preventDefault();
	// va a buscar el último que no sea el original
	$('.campo-a-repetir').not('.original').last().remove();

});

/*Pasar de modal c/s clon*/

$('#modal-servicio .codigo-click').click(function(e){

	e.preventDefault();

	if($('form.form-orden').hasClass('editar_orden'))
	{
		url_controller = url_server+'/mantencion/servicios';
		console.log('Editando');
	}
	else if($('.alert.alert-info'))
	{
		console.log('Con Error');
		url_controller = url_server+'/mantencion/servicios';
	}
	else{
		url_controller = url_server+'/mantencion/servicios';
		console.log('Creando');
	}

	$.ajax({
		type:'post',
		//url:'../mantencion/servicios',
		url:url_controller,
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