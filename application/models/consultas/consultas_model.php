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
			$this->db->where('orden.fecha >=',$desde);
			$this->db->where('orden.fecha <=',$hasta);
		}

		$result = $this->db->get();
		//var_dump($this->db->last_query());
		return $result->result_array();
	}

	public function ordenes_conductor(){

	}

	public function ordenes_cliente(){

	}

	public function ordenes_proveedor($proveedor, $desde = null, $hasta = null, $todas = null){

		$this->db->select('orden.id_orden, tipo_orden.tipo_orden, estado_orden.estado, orden.fecha');
		$this->db->from(' orden, tipo_orden, estado_orden');
		$this->db->where('orden.id_estado_orden = estado_orden.id');
		$this->db->where('orden.tipo_orden_id_tipo_orden = tipo_orden.id_tipo_orden');
		$this->db->where('orden.proveedor_rut_proveedor',$proveedor);

		if($todas == null){
			$this->db->where('orden.fecha >=',$desde);
			$this->db->where('orden.fecha <=',$hasta);
		}

		$result = $this->db->get();
		//var_dump($this->db->last_query());
		return $result->result_array();		
	}


}

?>