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

   function modificar_conductor($conductor,$rut){
        $this->db->where('rut',$rut);               
       
        if($this->db->update('conductor', $conductor)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function listar_conductores(){
        $this->db->select('rut,descripcion');
        $resultado = $this->db->get('conductor');
        
        return $resultado->result_array();
        
    }
    
        
    function existe_conductor($rut){
        $this->db->select ('rut');
        $this->db->from('conductor');
        $this->db->where('rut',$rut);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
	
	function datos_conductor($rut) {
			$this->db->select('rut,descripcion,telefono');
			$this->db->from('conductor');
			$this->db->where('rut',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
    
}
?>