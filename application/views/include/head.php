
<!DOCTYPE html>
<html>
    <head>
    	<script type="text/javascript" charset="utf-8" language="javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <style>
            body {padding-top: 40px;}
        </style>
        <title>Grupo Log&iacute;stico GLC Chile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href=<?php echo base_url().'bootstrap/css/bootstrap.css' ?> rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/dataTables.bootstrap.css'); ?>">
           
    </head>

    <body>
    	<?php if($id_tipo_usuario == 0) { ?>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container" style="width: auto">
					<a style="margin-left: 0px" class="brand logo" href=<?php echo base_url();?>index.php/main>Grupo Logistico</a>
					<ul class="nav"><li class="divider"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantenci&oacute;n <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href=<?php echo base_url();?>index.php/mantencion/clientes>Clientes</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/naves>Naves</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/navieras>Navieras</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/agencias>Agencias Aduanas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/tramos>Tramos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/camiones>Camiones</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/conductores>Conductores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/proveedores>Proveedores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/puertos>Puertos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/cargas>Tipos de Carga</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/depositos>Dep&oacute;sitos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/bodegas>Bodegas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/servicios>Otros Servicios</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Orden de Servicio</li>
								<li class="divider"></li>
								<li><a href=<?php echo base_url();?>index.php/transacciones/orden>Crear O.S.</a></li>
                                <li><a href=<?php echo base_url();?>index.php/transacciones/orden/editar_orden>Editar, Imprimir O.S.</a></li>
							</ul>
						</li> 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Facturaci&oacute;n<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Facturaci&oacute;n</li>
								<li class="divider"></li>							
								<li><a href='<?php echo base_url("index.php/transacciones/facturacion"); ?>' >Crear Factura</a></li>
                                <li><a href='<?php echo base_url("index.php/transacciones/facturacion/editar");?>' >Editar, Imprimir Factura</a></li>
							</ul>
						</li>  						   
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Generar Datos</li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/master');?>">Master</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/resumen');?>">Resumen</a></li>
								<li class="divider"></li>
								<li class="nav-header">O.S por Otros</li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_cliente');?>">Clientes</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_proveedor');?>">Proveedor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_conductor');?>">Conductor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_camion');?>">Camion</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_retiro');?>">Lugar de Retiro</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_puerto');?>">Puerto Embarque</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_referencia');?>">Referencia</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_contenedor');?>">Contenedor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/realizadas');?>">Realizadas</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/ordenes_facturadas');?>">Facturadas</a></li>

							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Espec&iacute;ficos<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Fecha del d&iacute;a</a></li>
								<li><a href=<?php echo base_url('index.php/especificos/usuarios');?>>Usuarios</a></li>
								<li><a href="#">Claves de Acceso</a></li>
								<li><a href="<?php echo base_url('index.php/especificos/especificos/parametros');?>">Par&aacute;metros</a></li>
								<li><a href="<?php echo base_url('index.php/especificos/especificos/codigos_sistema');?>">C&oacute;digos Sistema</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav pull-right">
						<li><a href=""><i class="icon-user"></i><?php echo $nombre; ?></a></li>
						<li class="divider-vertical"></li>            
						<li><a href="<?php echo base_url();?>index.php/main/logout"><i class="icon-off"></i>Cerrar Sesi&oacute;n</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php } ?>
				
		<?php if($id_tipo_usuario == 1) { ?>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container" style="width: auto">
					<a class="brand logo" href=<?php echo base_url();?>index.php/main>Grupo Logistico</a>
					<ul class="nav"><li class="divider"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantenci&oacute;n <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href=<?php echo base_url();?>index.php/mantencion/clientes>Clientes</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/naves>Naves</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/navieras>Navieras</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/agencias>Agencias Aduanas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/tramos>Tramos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/camiones>Camiones</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/conductores>Conductores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/proveedores>Proveedores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/puertos>Puertos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/cargas>Tipos de Carga</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/depositos>Dep&oacute;sitos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/bodegas>Bodegas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/servicios>Otros Servicios</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Orden de Servicio</li>
								<li class="divider"></li>
								<li><a href=<?php echo base_url();?>index.php/transacciones/orden>Crear O.S.</a></li>
                                <li><a href=<?php echo base_url();?>index.php/transacciones/orden/editar_orden>Editar, Imprimir O.S.</a></li>
							</ul>
						</li> 					   
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">O.S por Otros</li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_cliente');?>">Clientes</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_proveedor');?>">Proveedor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_conductor');?>">Conductor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_camion');?>">Camion</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_retiro');?>">Lugar de Retiro</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_puerto');?>">Puerto Embarque</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_referencia');?>">Referencia</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_contenedor');?>">Contenedor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/realizadas');?>">Realizadas</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/ordenes_facturadas');?>">Facturadas</a></li>

							</ul>
						</li>

					</ul>
					<ul class="nav pull-right">
						<li><a href=""><i class="icon-user"></i><?php echo $nombre; ?></a></li>
						<li class="divider-vertical"></li>            
						<li><a href="<?php echo base_url();?>index.php/main/logout"><i class="icon-off"></i>Cerrar Sesi&oacute;n</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php } ?>
		
    	<?php if($id_tipo_usuario == 2) { ?>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container" style="width: auto">
					<a style="margin-left: 0px" class="brand logo" href=<?php echo base_url();?>index.php/main>Grupo Logistico</a>
					<ul class="nav"><li class="divider"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantenci&oacute;n <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href=<?php echo base_url();?>index.php/mantencion/clientes>Clientes</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/naves>Naves</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/navieras>Navieras</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/agencias>Agencias Aduanas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/tramos>Tramos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/camiones>Camiones</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/conductores>Conductores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/proveedores>Proveedores</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/puertos>Puertos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/cargas>Tipos de Carga</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/depositos>Dep&oacute;sitos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/bodegas>Bodegas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/servicios>Otros Servicios</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Orden de Servicio</li>
								<li class="divider"></li>
								<li><a href=<?php echo base_url();?>index.php/transacciones/orden>Crear O.S.</a></li>
                                <li><a href=<?php echo base_url();?>index.php/transacciones/orden/editar_orden>Editar, Imprimir O.S.</a></li>
							</ul>
						</li> 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Facturaci&oacute;n<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Facturaci&oacute;n</li>
								<li class="divider"></li>							
								<li><a href='<?php echo base_url("index.php/transacciones/facturacion"); ?>' >Crear Factura</a></li>
                                <li><a href='<?php echo base_url("index.php/transacciones/facturacion/editar");?>' >Editar, Imprimir Factura</a></li>
							</ul>
						</li>  						   
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/master');?>">Generar Datos</a></li>
								<li class="divider"></li>
								<li class="nav-header">O.S por Otros</li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_cliente');?>">Clientes</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_proveedor');?>">Proveedor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_conductor');?>">Conductor</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_camion');?>">Camion</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_retiro');?>">Lugar de Retiro</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_puerto');?>">Puerto Embarque</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_referencia');?>">Referencia</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/por_contenedor');?>">Contenedor</a></li>								
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/realizadas');?>">Realizadas</a></li>
								<li><a href="<?php echo base_url('index.php/consultas/facturadas/ordenes_facturadas');?>">Facturadas</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav pull-right">
						<li><a href=""><i class="icon-user"></i><?php echo $nombre; ?></a></li>
						<li class="divider-vertical"></li>            
						<li><a href="<?php echo base_url();?>index.php/main/logout"><i class="icon-off"></i>Cerrar Sesi&oacute;n</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php } ?>
		
    	<?php if($id_tipo_usuario == 3) { ?>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container" style="width: auto">
					<a style="margin-left: 0px" class="brand logo" href=<?php echo base_url();?>index.php/main>Grupo Logistico</a>
					<ul class="nav"><li class="divider"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="nav-header">Orden de Servicio</li>
								<li class="divider"></li>
								<li><a href=<?php echo base_url();?>index.php/transacciones/orden>Crear O.S.</a></li>
                                <li><a href=<?php echo base_url();?>index.php/transacciones/orden/editar_orden>Editar, Imprimir O.S.</a></li>
							</ul>
						</li> 
					</ul>
					<ul class="nav pull-right">
						<li><a href=""><i class="icon-user"></i><?php echo $nombre; ?></a></li>
						<li class="divider-vertical"></li>            
						<li><a href="<?php echo base_url();?>index.php/main/logout"><i class="icon-off"></i>Cerrar Sesi&oacute;n</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php } ?>