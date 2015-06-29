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
        
        $this->db->trans_start();
        $this->db->insert('factura', $factura);
        $this->db->trans_complete();
        return $this->db->insert_id();
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
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
    function datos_factura($numero_factura) {
			$this->db->select('*');
			$this->db->from('factura');
			$this->db->where('numero_factura',$numero_factura);
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



}

?>
