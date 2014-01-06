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
    
    function seleccionar_viaje($id_viaje){
        $this->db->select('camion_patente,conductro,rut');
        $this->db->where('id_viaje',$id_viaje);
        $result = $this->db->get('viaje');
        
        return $result->result_array();
    }
    
    function editar_viaje($id_viaje,$viaje){

       $this->db->where('id_viaje', $id_viaje);
       $this->db->update('viaje', $viaje); 
    
       
    }
    
}

?>
