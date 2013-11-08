<?php

class Navieras_model extends CI_Model{
    
    function guarda_naviera($datos){
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
        
        if ($result->num_rows() == 0){
            return 0;
        }
        
        else{
            return $result->result_array();
        }
    }
    
}

?>