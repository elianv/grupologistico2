/*--Ordenes--*/

$('.boton-repetir a').click(function(e){


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
	console.log('ELIMINAR....')
	e.preventDefault();

	$(this).closest('.campo-a-repetir').remove();

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