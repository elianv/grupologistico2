<?php

class Usuarios_model extends CI_Model{
    
    function insertar($datos){
        
        if($this->db->insert('usuario', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }
      
    function modificar($datos,$rut_usuario){
        $this->db->where('rut_usuario',$rut_usuario);               
        
        if($this->db->update('usuario', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }    
       
    function listar_usuarios(){
        
        $this->db->select('rut_usuario,nombre');
        $resultado = $this->db->get('usuario');
        
        return $resultado->result_array();
        
    }
    
    function existe_usuario($usuario){
        $this->db->select ('rut_usuario');
        $this->db->from('usuario');
        $this->db->where('rut_usuario',$usuario);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
	
	function datos_usuario($rut) {
			$this->db->select ();
			$this->db->from('usuario');
			$this->db->where('rut_usuario',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
	
}

?>