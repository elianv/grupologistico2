<?php

class Camiones_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function insertar_camion($camion){
        if($this->db->insert('camion', $camion)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function modificar_camion($camion,$id_camion){
        $this->db->where('camion_id',$id_camion);               
        if($this->db->update('camion', $camion)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function patente_repetida($dato){
        $this->db->select('patente');
        $this->db->from('camion');
        $this->db->where('patente',$dato);
          
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
        
    }
    
    function listar_camiones(){
        $this->db->select('patente,celular');
        $resultado = $this->db->get('camion');
        
        return $resultado->result_array();
    }
    
    function existe_camion($patente){
        $this->db->select ('patente');
        $this->db->from('camion');
        $this->db->where('patente',$patente);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
	function datos_camion($rut) {
			$this->db->select ();
			$this->db->from('camion');
			$this->db->where('patente',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
    
    function getCamion($id){
			$this->db->select ();
			$this->db->from('camion');
			$this->db->where('camion_id',$id);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
	}
}

?>
