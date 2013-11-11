<?php

class Conductores_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function repetido($conductor){
        
        $this->db->select ('rut');
        $this->db->from('conductor');
        $this->db->where('rut',$conductor);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function insertar_conductor($conductor){
        if($this->db->insert('conductor', $conductor)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function listar_conductores(){
        $this->db->select('rut,contacto');
        $resultado = $this->db->get('conductor');
        
        return $resultado->result_array();
        
    }
    
}
?>