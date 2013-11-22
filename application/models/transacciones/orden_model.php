<?php

class Orden_model extends CI_Model{
     
    function ultimo_codigo(){
        
        $this->db->select_max('id_orden');
        $result = $this->db->get('orden');
        
            return $result->result_array();
        
    }
    
    function insert_orden($orden){
                 
         if($this->db->insert('orden', $orden)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function obtener_viaje($id_orden){
        
        $this->db->select('viaje_id_viaje');
        $this->db->where('id_orden',$id_orden);
        $result = $this->db->get('orden');
        
        return $result->result_array();
    }
    
    function editar_orden($orden){
        $this->db->where('id_orden', $orden['id_orden']);
        $this->db->update('orden', $orden); 
    }
    
    function existe_orden($orden){
        $this->db->select ('id_orden');
        $this->db->from('orden');
        $this->db->where('id_orden',$orden);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
    function listar_ordenes(){
         
         $this->db->select('orden.id_orden,orden.fecha,cliente.razon_social');
         $this->db->from('orden');
         $this->db->join('cliente','orden.cliente_rut_cliente = cliente.rut_cliente','inner');
         $resultado = $this->db->get();
         
         return $resultado->result_array();
         
     }
}


?>

