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
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_tramo');
        $result = $this->db->get('tramo');
        
            return $result->result_array();
        
    }
        
    function listar_tramos(){
        
        $this->db->select('codigo_tramo,descripcion');
        $resultado = $this->db->get('tramo');
        
        return $resultado->result_array();
        
    }
    
    function existe_tramo($tramo){
        $this->db->select ('codigo_tramo');
        $this->db->from('tramo');
        $this->db->where('codigo_tramo',$tramo);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
}

?>

