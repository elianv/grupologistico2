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
}


?>

