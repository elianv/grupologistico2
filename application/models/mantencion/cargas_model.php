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
    
}

?>