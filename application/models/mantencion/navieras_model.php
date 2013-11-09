<?php

class Navieras_model extends CI_Model{
    
    function insertar_naviera($datos){
        if($this->db->insert('naviera', $datos)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_naviera');
        $result = $this->db->get('naviera');
        
            return $result->result_array();
        
    }
    
}

?>