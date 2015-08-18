<?php

Class consultas_model extends CI_Model{

	function __construct(){
		parent::__construct();

	}

	public function generar_ordenes($estado = null, $desde = null, $hasta = null, $todas = null){

		$this->db->select('
						    orden.id_orden,
						    orden.fecha,
						    orden.referencia,
						    orden.booking,
						    orden.numero,
						    orden.peso,
						    orden.set_point,
						    orden.ret_contenedor,
						    orden.fecha_presentacion,
						    orden.referencia_2,
						    orden.observacion,
						    orden.mercaderia,
						    orden.lugar_retiro,
						    puerto.nombre as nombre_puerto_destino,
						    aduana.nombre as nombre_aduana,
						    bodega.nombre as nombre_bodega,
						    cliente.rut_cliente,
						    cliente.razon_social,
						    deposito.descripcion as deposito,
						    nave.nombre as nombre_nave,
						    proveedor.rut_proveedor,
						    proveedor.razon_social as rs_proveedor,
						    proveedor.giro as rs_giro,
						    prto.nombre as prto_nombre,
						    tipo_carga.descripcion as carga,
						    tipo_orden.tipo_orden,
						    tramo.descripcion,
						    orden.valor_costo_tramo,
						    orden.valor_venta_tramo,
						    naviera.nombre as naviera');
		$this->db->from('
						    proveedor,
						    naviera,
						    tramo,
						    tipo_orden,
						    tipo_carga,
						    puerto,
						    nave,
						    bodega,
						    orden,
						    puerto as prto,
						    aduana,
						    cliente,
						    deposito');
		$this->db->where('orden.destino = puerto.codigo_puerto');
		$this->db->where('orden.naviera_codigo_naviera = naviera.codigo_naviera');
		$this->db->where('orden.tramo_codigo_tramo = tramo.codigo_tramo');
		$this->db->where('orden.tipo_orden_id_tipo_orden = tipo_orden.id_tipo_orden');
		$this->db->where('orden.tipo_carga_codigo_carga = tipo_carga.codigo_carga');
		$this->db->where('orden.puerto_codigo_puerto = prto.codigo_puerto');
		$this->db->where('orden.aduana_codigo_aduana = aduana.codigo_aduana');
		$this->db->where('orden.proveedor_rut_proveedor = proveedor.rut_proveedor');
		$this->db->where('orden.nave_codigo_nave = nave.codigo_nave');
		$this->db->where('orden.deposito_codigo_deposito = deposito.codigo_deposito');
		$this->db->where('orden.bodega_codigo_bodega = bodega.codigo_bodega');
		$this->db->where('orden.cliente_rut_cliente = cliente.rut_cliente');
		$this->db->where('orden.id_estado_orden',$estado);

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$this->db->where('orden.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
		}

		$result = $this->db->get();
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function ordenes_proveedor($proveedor, $desde = null, $hasta = null, $todas = null){

		$this->db->select('orden.id_orden, tipo_orden.tipo_orden, estado_orden.estado, orden.fecha');
		$this->db->from('orden, tipo_orden, estado_orden');
		$this->db->where('orden.id_estado_orden = estado_orden.id');
		$this->db->where('orden.tipo_orden_id_tipo_orden = tipo_orden.id_tipo_orden');
		$this->db->where('orden.proveedor_rut_proveedor',$proveedor);

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$this->db->where('orden.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
		}

		$result = $this->db->get();
		//var_dump($this->db->last_query());
		return $result->result_array();		
	}

	public function ordenes_clientes($cliente, $desde = null, $hasta = null, $todas = null){

		$this->db->select('orden.id_orden, tipo_orden.tipo_orden, estado_orden.estado, orden.fecha');
		$this->db->from(' orden, tipo_orden, estado_orden');
		$this->db->where('orden.id_estado_orden = estado_orden.id');
		$this->db->where('orden.tipo_orden_id_tipo_orden = tipo_orden.id_tipo_orden');
		$this->db->where('orden.cliente_rut_cliente',$cliente);

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$this->db->where('orden.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
		}

		$result = $this->db->get();
		
		return $result->result_array();		
	}	

	public function ordenes_conductor($conductor, $desde = null, $hasta = null, $todas = null){

		$this->db->select('orden.id_orden, tipo_orden.tipo_orden, estado_orden.estado, orden.fecha, viaje.conductor_rut');
		$this->db->from('orden, tipo_orden, estado_orden, viaje');
		$this->db->where('orden.id_estado_orden = estado_orden.id');
		$this->db->where('orden.tipo_orden_id_tipo_orden = tipo_orden.id_tipo_orden');
		$this->db->where('orden.viaje_id_viaje = viaje.id_viaje');
		$this->db->where('viaje.conductor_rut',$conductor);

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$this->db->where('orden.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
		}

		$result = $this->db->get();
		
		return $result->result_array();		
	}

	public function facturas($facturas = null, $ordenes = null, $cliente = null, $nave = null , $puerto = null, $contenedor = null, $desde = null, $hasta = null){
		
		$query = '	select 
					    orden.id_orden,
					    cliente.razon_social,
					    nave.nombre as nombre_nave,
					    orden.referencia,
					    orden.referencia_2,
					    orden.mercaderia,
					    orden.numero as contenedor,
					    factura.guia_despacho,
					    bodega.nombre as nombre_bodega,
					    tramo.descripcion as tramo,
					    orden.fecha_presentacion,
					    proveedor.razon_social as proveedor,
						ordenes_facturas.factura_tramo as factura_proveedor,
					    factura.total_costo as precio_costo,
					    factura.numero_factura as factura_log,
					    factura.total_venta as precio_venta,
					    orden.observacion,
						factura.total_venta - factura.total_costo as  margen,
						(factura.total_venta - factura.total_costo) * 100 /factura.total_costo as porcentaje
					from
					    factura
					        left join
					    ordenes_facturas ON factura.id = ordenes_facturas.id_factura
					        left join
					    orden ON orden.id_orden = ordenes_facturas.id_orden
					        left join
					    cliente ON orden.cliente_rut_cliente = cliente.rut_cliente
					        left join
					    nave ON nave.codigo_nave = orden.nave_codigo_nave
					        left join
					    bodega ON bodega.codigo_bodega = orden.bodega_codigo_bodega
					        left join
					    tramo ON orden.tramo_codigo_tramo = tramo.codigo_tramo
					        left join
					    proveedor ON proveedor.rut_proveedor = orden.proveedor_rut_proveedor ';

		if($facturas){
				$facturas = explode(',', $facturas);
				
				$i = 0;
				$string = ' where ';
				if($facturas != ''){
						foreach ($facturas as $factura) {
							if ($i > 0 )
								$string .= ' OR factura.numero_factura = '.$factura;
							else
								$string .= ' factura.numero_factura = '.$factura;
							$i++;
						}
				}
				$query .= $string;
		}

		if($ordenes){
				$ordenes = explode(',', $ordenes);
				
				$i = 0;
				$string = ' where ';
				if($ordenes != ''){
						foreach ($ordenes as $orden) {
							if ($i > 0 )
								$string .= ' OR orden.id_orden = '.$orden;
							else
								$string .= ' orden.id_orden = '.$orden;
							$i++;
						}
				}
				$query .= $string;			
		}

		if($cliente){
				
				$string = ' where cliente.rut_cliente = "'.$cliente.'"';
				$query .= $string;			
		}	
		if($nave){
				
				$string = ' where nave.codigo_nave = '.$nave;
				$query .= $string;			
		}	
		if($puerto){
				
				$string = ' where puerto.codigo_puerto = '.$puerto;
				$query .= $string;			
		}		
		if($contenedor){
				
				$string = ' where orden.numero like "%'.$contenedor.'%"';
				$query .= $string;			
		}	
		if($desde && $hasta){
				$desde = new DateTime($desde);
				$hasta = new DateTime($hasta);
				
				$string = ' where orden.fecha_presentacion between "'.$desde->format('Y-m-d').'" and "'.$hasta->format('Y-m-d').'"';
				$query .= $string;			
		}							

		
		$sql = $this->db->query($query);

		$result = $sql->result_array();
		
		return $result;
	}

    function getServicioOrdenFacturaByIdDetalle($id){
        $this->db->select('*');
        $this->db->from('servicios_orden_factura');
        $this->db->where('detalle_id_detalle',$id);
        $resultado = $this->db->get();
        
        return $resultado->result_array();        
    }	

    function getDetalleByIdDetalle($id){
    	$this->db->select('*');
    	$this->db->from('detalle');
    	$this->db->where('id_detalle',$id);

        $resultado = $this->db->get();
        
        return $resultado->result_array();     	

    }

    public function ordenes_procesos($ordenes = null, $cliente = null, $nave = null , $puerto = null, $contenedor = null, $desde = null, $hasta = null){
    	$query = (		'select 
    	    						orden.id_orden,
    	    						cliente.razon_social,
    	    						nave.nombre as nombre_nave,
    	    						orden.referencia,
    	    						orden.referencia_2,
    							    orden.fecha,
    							    orden.mercaderia,
    							    orden.numero as contenedor,
									bodega.nombre as nombre_bodega,
									tramo.descripcion as tramo,
									orden.fecha_presentacion,
									proveedor.razon_social as proveedor,
    							    orden.observacion,
    							    orden.valor_costo_tramo as precio_costo,
    							    orden.valor_venta_tramo as precio_venta
	    				from
								proveedor,
							    tramo,
							    nave,
							    bodega,
							    orden,
							    cliente
						where 
									orden.tramo_codigo_tramo = tramo.codigo_tramo
								and 
									orden.proveedor_rut_proveedor = proveedor.rut_proveedor
								and 
									orden.nave_codigo_nave = nave.codigo_nave
								and 
									orden.bodega_codigo_bodega = bodega.codigo_bodega
								and 
									orden.cliente_rut_cliente = cliente.rut_cliente
								and 
									orden.id_estado_orden = 1 ');

		if($ordenes){
				$ordenes = explode(',', $ordenes);
				
				$i = 0;
				$string = ' and ';
				if($ordenes != ''){
						foreach ($ordenes as $orden) {
							if ($i > 0 )
								$string .= ' OR orden.id_orden = '.$orden;
							else
								$string .= ' orden.id_orden = '.$orden;
							$i++;
						}
				}
				$query .= $string;			
		}

		if($cliente){
				
				$string = ' and orden.cliente_rut_cliente = "'.$cliente.'"';
				$query .= $string;			
		}	
		if($nave){
				
				$string = ' and orden.nave_codigo_nave = '.$nave;
				$query .= $string;			
		}	
		if($puerto){
				
				$string = ' and orden.puerto_codigo_puerto = '.$puerto;
				$query .= $string;			
		}		
		if($contenedor){
				
				$string = ' and orden.numero like "%'.$contenedor.'%"';
				$query .= $string;			
		}	
		if($desde && $hasta){
				$desde = new DateTime($desde);
				$hasta = new DateTime($hasta);
				
				$string = ' and orden.fecha_presentacion between "'.$desde->format('Y-m-d').'" and "'.$hasta->format('Y-m-d').'"';
				$query .= $string;			
		}							

		
		$sql = $this->db->query($query);

		$result = $sql->result_array();
		//var_dump($this->db->last_query());
		return $result;
    }

}

?>