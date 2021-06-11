<?php

Class consultas_model extends CI_Model{

	function __construct(){
		parent::__construct();

	}

	public function generar_ordenes($estado = null, $desde = null, $hasta = null, $todas = null){

		$this->db->select('
						    orden.id_orden,
						    orden.fecha_creacion,
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
			$this->db->where('orden.fecha_creacion between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
		}

		$result = $this->db->get();
		return $result->result_array();
	}

	public function ordenes_proveedor($proveedor, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_presentacion,
				    coalesce(SUM(detalle.valor_costo), 0) + coalesce(orden.valor_costo_tramo, 0) as total_neto,
				    cliente.razon_social,
				    coalesce(ordenes_facturas.factura_tramo, 'N/A') as factura_proveedor
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    detalle ON detalle.orden_id_orden = orden.id_orden
				        left join
				    ordenes_facturas ON ordenes_facturas.id_orden = orden.id_orden
				        left join
				    factura ON ordenes_facturas.id_factura = factura.id
				where
				    orden.proveedor_rut_proveedor = '".$proveedor."' ";


		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function ordenes_clientes($cliente, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
					orden.fecha_presentacion,
					orden.referencia,
				    tipo_orden.tipo_orden,
				    orden.numero as contenedor,
				    cliente.razon_social,
				    coalesce(factura.numero_factura, 'N/A') as factura
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    ordenes_facturas ON ordenes_facturas.id_orden = orden.id_orden
				        left join
				    factura ON ordenes_facturas.id_factura = factura.id
				    where orden.cliente_rut_cliente = '".$cliente."' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden order by fecha_presentacion, id_orden";

		$result = $this->db->query($sql);
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function ordenes_conductor($conductor, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_presentacion,
				    coalesce(SUM(detalle.valor_costo), 0) + coalesce(orden.valor_costo_tramo, 0) as total_neto,
				    cliente.razon_social,
					orden.numero as contenedor
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    detalle ON detalle.orden_id_orden = orden.id_orden
						inner join
					viaje ON orden.viaje_id_viaje = viaje.id_viaje
				where
					viaje.conductor_rut = '".$conductor."' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";
		}

		$sql .= " group by id_orden";

		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function ordenes_camion($camion, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_presentacion,
				    coalesce(SUM(detalle.valor_costo), 0) + coalesce(orden.valor_costo_tramo, 0) as total_neto,
				    cliente.razon_social,
					orden.numero as contenedor
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    detalle ON detalle.orden_id_orden = orden.id_orden
						inner join
					viaje ON orden.viaje_id_viaje = viaje.id_viaje
				where
					viaje.camion_camion_id = '".$camion."' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";
		}

		$sql .= " group by id_orden";

		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function ordenes_puerto($puerto, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_presentacion,
				    orden.numero as contenedor,
				    orden.referencia,
					tramo.descripcion as tramo
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
						inner join
					tramo ON tramo.codigo_tramo = orden.tramo_codigo_tramo
				where
				    orden.puerto_codigo_puerto = '".$puerto."' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function ordenes_retiro($deposito, $desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_presentacion,
				    orden.numero as contenedor,
				    orden.referencia,
					tramo.descripcion as tramo
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
						inner join
					tramo ON tramo.codigo_tramo = orden.tramo_codigo_tramo
				where
				    orden.deposito_codigo_deposito = ".$deposito." ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function ordenes_referencia($referencia, $desde = null, $hasta = null, $todas = null){
		$sql =  "SELECT
				    orden.id_orden, orden.numero as contenedor, orden.referencia, orden.fecha_presentacion, cliente.razon_social, orden.referencia_2
				FROM
				    orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				where
				    referencia like '%".$referencia."%'";
				//referencia like '%".$referencia."%' OR referencia_2 like '%".$referencia."%'";
		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function ordenes_contenedor($contenedor, $desde = null, $hasta = null, $todas = null){
		$sql =  "SELECT
				    orden.id_orden, orden.numero as contenedor, orden.referencia, orden.fecha_presentacion, cliente.razon_social, orden.referencia_2
				FROM
				    orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				where
				    numero like '%".$contenedor."%' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function realizadas($desde = null, $hasta = null, $todas = null){

		$sql = "select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    estado_orden.estado,
				    orden.fecha_creacion,
						orden.fecha_presentacion,
				    coalesce(SUM(detalle.valor_venta), 0) + coalesce(orden.valor_venta_tramo, 0) as total_neto,
				    cliente.razon_social
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    estado_orden ON estado_orden.id = orden.id_estado_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    detalle ON detalle.orden_id_orden = orden.id_orden ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " WHERE orden.fecha_creacion >= '".$desde->format('Y-m-d')." 00:00:01' AND orden.fecha_creacion <='".$hasta->format('Y-m-d')." 23:59:59'";

		}
		$sql .= " group by id_orden";

		$result = $this->db->query($sql);
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function facturadas($cliente = null,   $desde = null, $hasta = null, $todas = null){

		$sql= 	"select
				    orden.id_orden,
				    tipo_orden.tipo_orden,
				    orden.fecha_presentacion,
				    coalesce(SUM(detalle.valor_venta), 0) + coalesce(orden.valor_venta_tramo, 0) as total_neto,
				    factura.numero_factura,
				    factura.fecha as fecha_factura,
				    factura.total_venta as neto_factura,
				    cliente.razon_social
				from
				    orden
				        inner join
				    tipo_orden ON tipo_orden.id_tipo_orden = orden.tipo_orden_id_tipo_orden
				        inner join
				    cliente ON cliente.rut_cliente = orden.cliente_rut_cliente
				        left join
				    detalle ON detalle.orden_id_orden = orden.id_orden
				        left join
				    ordenes_facturas ON ordenes_facturas.id_orden = orden.id_orden
				        left join
				    factura ON ordenes_facturas.id_factura = factura.id
				where
				    factura.estado_factura_id_estado_factura != 1 ";
 		if( $cliente )
 			$sql .= " AND orden.cliente_rut_cliente = '".$cliente."' ";

		if($todas == null){
			$desde = new DateTime($desde);
			$hasta = new DateTime($hasta);
			$sql .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' AND '".$hasta->format('Y-m-d')."'";

		}
		$sql .= " group by id_orden ";
		$sql .= " union
					select
					    IF(1 =  1, 'N/A', '') AS id_orden,
						IF(1 =  1, 'N/A', '') AS tipo_orden,
					    IF(1 =  1, '2000-01-01 00:00:01', '') AS fecha,
					    IF(1 =  1, 0, 0) AS total_neto,
					    factura.numero_factura,
					    factura.fecha as fecha_factura,
					    IF(1 =  1, 0, '') AS neto_factura,
					    IF(1 =  1, 'FACTURA NULA', '') AS razon_social
					from
					    factura
					where
					    factura.estado_factura_id_estado_factura = 3";



		$result = $this->db->query($sql);

		return $result->result_array();
	}

	public function facturas($facturas = null, $ordenes = null, $cliente = null, $nave = null , $puerto = null, $contenedor = null, $desde = null, $hasta = null){
			$string = '';
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
						    factura.id as id_factura,
							ordenes_facturas.factura_tramo as factura_proveedor,
						    factura.total_costo as precio_costo,
						    factura.numero_factura as factura_log,
						    factura.total_venta as precio_venta,
							DATE_FORMAT(factura.fecha,\'%d-%m-%Y\') as fecha,
						    orden.observacion,
							factura.total_venta - factura.total_costo as  margen,
							(factura.total_venta - factura.total_costo) * 100 /factura.total_costo as porcentaje
						from
								orden
										left join
								ordenes_facturas ON orden.id_orden = ordenes_facturas.id_orden
										left join
								factura ON ordenes_facturas.id_factura = factura.id
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
			if($puerto){
				$query .= ' 	LEFT JOIN 
							puerto ON puerto.codigo_puerto = orden.puerto_codigo_puerto ';
			}
			$query .= 'WHERE 1 ';

			if($facturas){
					$facturas = explode(',', $facturas);

					$i = 0;

					if($facturas != ''){
							foreach ($facturas as $factura) {
								if ($i > 0 )
									$string .= ' OR factura.numero_factura = '.$factura;
								else
									$string .= ' AND factura.numero_factura = '.$factura;
								$i++;
							}
					}
					$query .= $string;
			}

			if($ordenes){
					$ordenes = explode(',', $ordenes);

					$i = 0;

					if($ordenes != ''){
							foreach ($ordenes as $orden) {
								if ($i > 0 )
									$string .= ' OR orden.id_orden = '.$orden;
								else
									$string .= ' AND orden.id_orden = '.$orden;
								$i++;
							}
					}
					$query .= $string;
			}

			if($cliente){

					$string .= ' AND cliente.rut_cliente = "'.$cliente.'"';
					$query .= $string;
			}
			if($nave){

					$string .= 'AND nave.codigo_nave = '.$nave;
					$query .= $string;
			}
			if($puerto){
					$query .= ' AND puerto.codigo_puerto = '.$puerto;
					$query .= $string;
			}
			if($contenedor){

					$string .= 'AND orden.numero like "%'.$contenedor.'%"';
					$query .= $string;
			}
			if($desde && $hasta){
					$desde = new DateTime($desde);
					$hasta = new DateTime($hasta);
					//print_r($string);

					//$string .= " AND orden.fecha_presentacion between '".$desde->format('Y-m-d')."' and '".$hasta->format('Y-m-d')."'";
					$string .= " AND orden.id_orden IN
													(SELECT id_orden
													FROM ordenes_facturas
													WHERE id_factura IN
													( SELECT id FROM factura WHERE fecha >= '{$desde->format('Y-m-d')}' AND fecha <= '{$hasta->format('Y-m-d')}' )) ";
					$query .= $string;
			}


			$sql = $this->db->query($query);
			//var_dump($this->db->last_query());
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
				$this->db->join('servicio' , 'servicio.codigo_servicio = detalle.servicio_codigo_servicio');
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
	    							    orden.fecha_presentacion as fecha_creacion,
	    							    orden.mercaderia,
	    							    orden.numero as contenedor,
												bodega.nombre as nombre_bodega,
												tramo.descripcion as tramo,
												orden.fecha_presentacion,
												proveedor.razon_social as proveedor,
	    							    orden.observacion,
	    							    orden.valor_costo_tramo as precio_costo,
	    							    orden.valor_venta_tramo as precio_venta,
	    							    orden.booking,
	    							    orden.set_point,
	    							    orden.peso,
	    							    p.nombre as p_destino,
	    							    puerto.nombre as p_embarque,
												conductor.descripcion as conductor

		    				from
									proveedor,
								    tramo,
								    nave,
								    bodega,
								    orden,
								    cliente,
								    puerto as p,
								    puerto,
										conductor,
										viaje
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
										orden.destino = p.codigo_puerto
									and
										orden.puerto_codigo_puerto = puerto.codigo_puerto
									and
										viaje.id_viaje = orden.viaje_id_viaje
									and
										viaje.conductor_rut = conductor.rut
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

					$string = ' LEFT JOIN puerto ON puerto.codigo_puerto = orden.puerto_codigo_puerto ';
					$string .= ' and orden.puerto_codigo_puerto = '.$puerto;
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

	function getByIdOrden($id){
			$query = "SELECT
								detalle.*, servicio.descripcion, servicios_orden_factura.*
							FROM
								detalle
										LEFT JOIN
								servicio ON servicio.codigo_servicio = detalle.servicio_codigo_servicio
										LEFT JOIN
								servicios_orden_factura ON servicios_orden_factura.detalle_id_detalle = detalle.id_detalle
							WHERE
								orden_id_orden = {$id}";
			$sql = $this->db->query($query);
			//var_dump($this->db->last_query());
			return $sql->result_array();
	}

	function total_ordenes($id_orden){

		$query = "SELECT
								(valor_costo_tramo + COALESCE(det_costo,0)) as total_costo,
									(valor_venta_tramo + COALESCE(det_venta,0)) as total_venta,
									(valor_venta_tramo + COALESCE(det_venta,0)) - (valor_costo_tramo + COALESCE(det_costo,0)) AS margen
							FROM
								orden,
								(SELECT
									SUM(valor_costo) AS det_costo, SUM(valor_venta) AS det_venta
								FROM
									detalle
								WHERE
									orden_id_orden = {$id_orden}) det
							WHERE
								id_orden = {$id_orden}";

			$sql = $this->db->query($query);
			//var_dump($this->db->last_query());
			return $sql->result_array();
	}
        }
        
?>
