<?php

class Viaje extends CI_Model{
    
    function ultimo_codigo(){
        $this->db->select_max('id_viaje');
        $result = $this->db->get('viaje');
        
            return $result->result_array();
    }
    
    function crear_viaje($viaje){
        if($this->db->insert('viaje', $viaje)){
            return true;
        }
        else{
            return false;
        }
    }
    
}

?>

