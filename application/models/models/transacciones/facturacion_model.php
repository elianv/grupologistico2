<?php

class Facturacion_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_numero(){
        
        $this->db->select_max('id');
        $result = $this->db->get('factura');
        
        return $result->result_array();
    }

    function ultimo_id_orden_facturacion(){
        $this->db->select_max('id');
        $result = $this->db->get('ordenes_facturas');
        
        return $result->result_array();
    }
    
    function insertar_facturacion($factura){
        
        $this->db->insert('factura', $factura);
        $insert_id = $this->db->insert_id();

   return  $insert_id;
    }
    
    function insertar_orden_facturacion($orden){
        $this->db->trans_start();
        $this->db->insert('ordenes_facturas', $orden);
        $this->db->trans_complete();
        return $this->db->insert_id();
    }

    function insertar_servicios_orden_factura($data){
        $this->db->trans_start();
        $this->db->insert('servicios_orden_factura', $data);
        $this->db->trans_complete();
        return $this->db->insert_id();        
    }
    
    function modificar_facturacion($factura,$numero_factura){
        $this->db->where('numero_factura', $numero_factura);   
        if($this->db->update('factura', $factura)){
            return true;
        }
        else{
            return false;
        }
    }

    function factura_repetida($numero_factura){
        
        $this->db->select ('numero_factura');
        $this->db->from('factura');
        $this->db->where('numero_factura',$numero_factura);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_facturas(){
        $this->db->select('*');
        $resultado = $this->db->get('factura');
        
        return $resultado->result_array();
    }
    
    function existe_factura($factura){
        $this->db->select ('numero_factura');
        $this->db->from('factura');
        $this->db->where('numero_factura',$factura);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return $query->num_rows();
        }
        
        else{
            
            return $query->num_rows();
        }
    }
    
    function datos_factura($numero_factura , $os_manager = NULL) {
			$this->db->select('*');
			$this->db->from('factura');
			$this->db->where('numero_factura',$numero_factura);
            if($os_manager)
                $this->db->where('id', $os_manager);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
    }

    function cant_clientes_orden($clientes){
        $this->db->select('cliente_rut_cliente');
        $this->db->from('orden');
        foreach ($clientes as $cliente) {
            $this->db->or_where('id_orden',$cliente);    
        }
        $this->db->group_by("cliente_rut_cliente"); 
        $resultado = $this->db->get();

        return $resultado->num_rows();
    }

    function tiene_detalle($id_orden){
        $this->db->select('*');
        $this->db->from('detalle');
        $this->db->where('orden_id_orden',$id_orden);

        $result = $this->db->get();

        return $result->num_rows();
    }

    function getOrdenes($id_factura){
        $this->db->select('*');
        $this->db->from('ordenes_facturas');
        $this->db->where('id_factura',$id_factura);
        $resultado = $this->db->get();
            
        return $resultado->result_array();

    }

    function getServicioOrdenFactura($id){
        $this->db->select('*');
        $this->db->from('servicios_orden_factura');
        $this->db->where('id_ordenes_facturas',$id);
        $resultado = $this->db->get();
        
        return $resultado->result_array();        
    }

    function eliminarFactura($id){

        $this->db->where('id', $id);
        $this->db->delete('factura'); 

    }

    function eliminarOrdenesFactura($id){
        $this->db->where('id_factura', $id);
        $this->db->delete('ordenes_facturas'); 
    }

    function eliminarServiciosOrdeneFactura($id){
        $this->db->where('id_ordenes_facturas', $id);
        $this->db->delete('servicios_orden_factura'); 
    }    

    function factura_nula($numero_factura){
            $this->db->select('estado_factura_id_estado_factura');
            $this->db->from('factura');
            $this->db->where('numero_factura',$numero_factura);
            
            $resultado = $this->db->get();
            
            return $resultado->result_array();        
    }

    function valor_factura($id_factura ){

        $sql = "select ( SUM(coalesce(detalle.valor_costo,0) ) + coalesce(orden.valor_costo_tramo,0) ) as total_costo,
                       ( SUM(coalesce(detalle.valor_venta,0) ) + coalesce(orden.valor_venta_tramo,0) ) as total_venta
                from factura
                left join ordenes_facturas ON ordenes_facturas.id_factura = factura.id
                left join detalle ON ordenes_facturas.id_orden = detalle.orden_id_orden
                left join orden ON orden.id_orden = ordenes_facturas.id_orden
                where factura.numero_factura =".$id_factura;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function getOrdenFacturaByOrden($orden)
    {
    	$this->db->select('id,id_factura,id_orden')
    			->where('id_orden',$orden);

    	$result = $this->db->get('ordenes_facturas');

    	return $result->result_array();
    }

    function getFacturabyId($id)
    {
    	$this->db->select('id,numero_factura')
    			->where('id',$id);

    	$result = $this->db->get('factura');

    	return $result->result_array();
    }

    function getFacturabyFecha($desde = null, $hasta = null)
    {
        $this->db->select('factura.`numero_factura`, factura.`id`, factura.`fecha`, estado_factura.tipo_factura, cliente.razon_social')
                    ->join('ordenes_facturas','ordenes_facturas.id_factura = factura.id','inner')
                    ->join('orden','ordenes_facturas.id_orden = orden.id_orden','inner')
                    ->join('cliente', 'orden.cliente_rut_cliente = cliente.rut_cliente', 'inner')
                    ->join('estado_factura' , 'estado_factura.id_estado_factura = factura.estado_factura_id_estado_factura', 'inner');

        if($desde && $hasta)
        {
            $desde = new DateTime($desde);
            $hasta = new DateTime($hasta);
            $this->db->where('factura.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
        }

        $result = $this->db->get('factura');

        return $result->result_array();

    }

    function manager($ws,$method)
    {
        $this->db->select('url, name, action')
                 ->where('name' , $ws)
                 ->where('method' , $method);
        $query = $this->db->get('web_service');

        return $query->result();
    }    

}

?>

