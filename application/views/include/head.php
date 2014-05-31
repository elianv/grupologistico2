<!DOCTYPE html>
<html>
    <head>
        <title>Grupo Log&iacute;stico GLC Chile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href=<?php echo base_url().'bootstrap/css/bootstrap.css' ?> rel="stylesheet">
           
    </head>

    <body>
		<div class="navbar ">
			<div class="navbar-inner">
				<div class="container" style="width: auto">
					<a class="brand logo" href=<?php echo base_url();?>index.php/main>Grupo Logistico</a>
					<ul class="nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantención <b class="caret"></b></a>
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
								<li><a href=<?php echo base_url();?>index.php/mantencion/depositos>Depósitos</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/bodegas>Bodegas</a></li>
								<li><a href=<?php echo base_url();?>index.php/mantencion/servicios>Otros Servicios</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href=<?php echo base_url();?>index.php/transacciones/orden>Orden de Servicio</a></li>
								<li><a href=<?php echo base_url();?>index.php/transacciones/facturacion>Facturación</a></li>
							</ul>
						</li>    
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Generar Datos</a></li>
								<li class="divider"></li>
								<li><a href="#">Libro de Ventas</a></li>
								<li class="divider"></li>
								<li class="nav-header">O.S.</li>
								<li><a href=<?php echo base_url();?>index.php/consultas/facturadas  >Facturadas</a></li>
								<li><a href="#">Realizadas</a></li>
								<li><a href="#">Clientes</a></li>
								<li><a href="#">Proveedor</a></li>
								<li><a href="#">Camión</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Específicos<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Fecha del día</a></li>
								<li><a href="#">Claves de Acceso</a></li>
								<li><a href="#">Parámetros</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav pull-right">
						<li><a href=""><i class="icon-user"></i><?php echo $nombre; ?></a></li>
						<li class="divider-vertical"></li>            
						<li><a href="<?php echo base_url();?>/index.php/main/logout"><i class="icon-off"></i>Cerrar Sesión</a></li>
					</ul>
				</div>
			</div>
		</div>