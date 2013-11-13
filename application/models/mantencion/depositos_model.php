<?php

class Depositos_model extends CI_Model{
    
    function insertar_deposito($datos){
        if($this->db->insert('deposito', $datos)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_deposito');
        $result = $this->db->get('deposito');
        
            return $result->result_array();
        
    }
    
    function listar_depositos(){
        $this->db->select('codigo_deposito,descripcion');
        $resultado = $this->db->get('deposito');
        
        return $resultado->result_array();
    }
    
}

?>