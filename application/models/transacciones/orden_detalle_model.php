<?php

class Orden_detalle_model extends CI_Model{
    
    function guardar_detalle(){
        if($this->db->insert('detalle', $orden)){
            return true;
        }
        else{
            return false;
        }
    }

    
}

?>