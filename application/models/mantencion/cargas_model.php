<?php

class Cargas_model extends CI_Model{
    
    function insertar_carga($datos){
        if($this->db->insert('tipo_carga', $datos)){
            return true;
        }
        else{
            return false;
        }
    }

    function modificar_carga($datos,$codigo_carga){
        $this->db->where('codigo_carga',$codigo_carga);               
        
        if($this->db->update('tipo_carga', $datos)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_carga');
        $result = $this->db->get('tipo_carga');
        
            return $result->result_array();
        
    }
    
    function listar_cargas(){
        $this->db->select('codigo_carga,descripcion');
        $resultado = $this->db->get('tipo_carga');
        
        return $resultado->result_array();
    }
    
    function existe_carga($carga){
        $this->db->select ('codigo_carga');
        $this->db->from('tipo_carga');
        $this->db->where('codigo_carga',$carga);
                
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