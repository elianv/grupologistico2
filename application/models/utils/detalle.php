<?php

Class Detalle extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function guardar_detalle($detalle){
        
        if($this->db->insert('detalle', $detalle)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function detalle_orden($id_orden){

        
    }
    
    function modificar_detalle($id_orden,$detalle){

    }
    
    function ultimo_codigo(){
        $this->db->select_max('id_detalle');
        $result = $this->db->get('detalle');
        
            return $result->result_array();
    }
    
}

?>

