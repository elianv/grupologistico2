<?php

class Puertos_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_puerto');
        $result = $this->db->get('puerto');
        
        return $result->result_array();
        
    }
    
    function insertar_puerto($puerto){
        if($this->db->insert('puerto', $puerto)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function modificar_puerto($puerto,$codigo_puerto){
        $this->db->where('codigo_puerto', $codigo_puerto);   
        if($this->db->update('puerto', $puerto)){
            return true;
        }
        else{
            return false;
        }
    }

    function nombre_repetido($nombre){
        
        $this->db->select ('nombre');
        $this->db->from('puerto');
        $this->db->where('nombre',$nombre);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_puertos(){
        $this->db->select('codigo_puerto,nombre');
        $resultado = $this->db->get('puerto');
        
        return $resultado->result_array();
    }
    
    function existe_puerto($puerto){
        $this->db->select ('codigo_puerto');
        $this->db->from('puerto');
        $this->db->where('codigo_puerto',$puerto);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
    function datos_puerto($rut) {
			$this->db->select ();
			$this->db->from('puerto');
			$this->db->where('codigo_puerto',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
    
}

?>
