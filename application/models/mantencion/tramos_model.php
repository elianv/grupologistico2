<?php

class Tramos_model extends CI_Model{
    
    function insertar($datos){
        
        if($this->db->insert('tramo', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }
    
    function modificar($datos,$codigo_tramo){
        $this->db->where('codigo_tramo',$codigo_tramo);               
        
        if($this->db->update('tramo', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }    
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_tramo');
        $result = $this->db->get('tramo');
        
            return $result->result_array();
        
    }
        
    function listar_tramos(){
        
        $this->db->select('codigo_tramo,descripcion');
        $this->db->where('codigo_tramo > 0');
        $resultado = $this->db->get('tramo');
        
        return $resultado->result_array();
        
    }
    
    function existe_tramo($tramo){
        $this->db->select ('codigo_tramo');
        $this->db->from('tramo');
        $this->db->where('codigo_tramo',$tramo);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
	
	function datos_tramo($rut) {
			$this->db->select ();
			$this->db->from('tramo');
			$this->db->where('codigo_tramo',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
	
}

?>