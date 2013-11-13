<?php

class Orden_model extends CI_Model{
     function ultimo_codigo(){
        
        $this->db->select_max('id_orden');
        $result = $this->db->get('orden');
        
            return $result->result_array();
        
    }
}


?>

