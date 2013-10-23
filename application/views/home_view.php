<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href=<?php echo base_url().'bootstrap/css/bootstrap.css' ?> rel="stylesheet">
           
    </head>

    <body>
  <div class="navbar ">
  <div class="navbar-inner">
  <div class="container" style="width: auto:">
    <a class="brand" href="#">Grupo Logistico</a>
      <ul class="nav">
  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantención <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="clientes.html">Cientes</a></li>
                      <li><a href="naves.html">Naves</a></li>
                      <li><a href="navieras.html">Navieras</a></li>
                      <li><a href="agencias.html">Agencias Aduanas</a></li>
                      <li><a href="tramos.html">Tramos</a></li>
                      <li><a href="camiones.html">Camiones/Choferes</a></li>
                      <li><a href="proveedores.html">Proveedores</a></li>
                      <li><a href="puertos.html">Puertos</a></li>
                      <li><a href="carga.html">Tipos de Carga</a></li>
                      <li><a href="depositos.html">Depósitos</a></li>
                      <li><a href="bodegas.html">Bodegas</a></li>
                    </ul>
  </li>
    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transacciones<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="orden_servicio.html">Orden de Servicio</a></li>
                      <li><a href="#">Emisión de Documentos</a></li>
                      <li><a href="#">Crea Factura Nula</a></li>
                    </ul>
  </li>    
      <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Generar Datos</a></li>
                       <li class="divider"></li>
                      <li><a href="#">Informe Cobranzas</a></li>
                      <li><a href="#">Libro de Ventas</a></li>
                       <li class="divider"></li>
                       <li class="nav-header">O.T.</li>
                      <li><a href="#">Facturadas</a></li>
                      <li><a href="#">Realizadas</a></li>
                      <li><a href="#">Clientes</a></li>
                      <li><a href="#">Proveedor</a></li>
                      <li><a href="#">Por Origen</a></li>
                      <li><a href="#">P. Embarque</a></li>
                      <li><a href="#">Camión</a></li>
                      <li><a href="#">D. Precios</a></li>
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
	<li class="divider-vertical"></li>            
        <li><a href="main/logout"><i class="icon-off"></i>Cerrar Sesión</a></li>
        </ul>
    </div>
  </div>
</div>
        <div class="container">
            <div><h1>Mensaje de Bienvenida</h1></div>
        </div>
       
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 
    <script src=<?php echo base_url().'bootstrap/js/bootstrap-dropdown' ?> type="text/javascript"></script> 

    </body>
</html>
