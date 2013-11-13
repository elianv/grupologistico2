<?php

class Tramos_model extends CI_Model{
    
    function insertar($datos){
        
        if($this->db->insert('tramo', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }
    
    function repetido($codigo_tramo){
        
        $this->db->select ('codigo_tramo');
        $this->db->from('tramo');
        $this->db->where('codigo_tramo',$codigo_tramo);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_tramos(){
        
        $this->db->select('codigo_tramo,descripcion');
        $resultado = $this->db->get('tramo');
        
        return $resultado->result_array();
        
    }
}

?>

