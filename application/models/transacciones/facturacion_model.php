<?php

class Facturacion_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_numero(){
        
        $this->db->select_max('numero_factura');
        $result = $this->db->get('factura');
        
        return $result->result_array();
        
    }
    
    function insertar_facturacion($factura){
        if($this->db->insert('factura', $factura)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function insertar_servicio_facturacion($servicio_factura){
        if($this->db->insert('servicio_factura',$servicio_factura)){
            return true;
        }
        else{
            return false;
        }
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
        $this->db->select('numero_factura,estado_factura_id_estado_factura');
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
			$this->db->select ();
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
    
}

?>
