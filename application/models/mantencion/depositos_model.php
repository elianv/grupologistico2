<?php

class Depositos_model extends CI_Model{
    
    function insertar_deposito($datos){
        if($this->db->insert('deposito', $datos)){
            return true;
        }
        else{
            return false;
        }
    }

    function modificar_deposito($datos,$codigo_deposito){
        $this->db->where('codigo_deposito',$codigo_deposito);               
        
        if($this->db->update('deposito', $datos)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_deposito');
        $result = $this->db->get('deposito');
        
            return $result->result_array();
        
    }
    
    function listar_depositos(){
        $this->db->select('codigo_deposito,descripcion');
        $resultado = $this->db->get('deposito');
        
        return $resultado->result_array();
    }
    
    function existe_deposito($deposito){
        $this->db->select ('codigo_deposito');
        $this->db->from('deposito');
        $this->db->where('codigo_deposito',$deposito);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
    function datos_deposito($id){
		$this->db->select ();
		$this->db->from('deposito');
		$this->db->where('codigo_deposito',$id);
		$resultado = $this->db->get();
			
		return $resultado->result_array();
	}
}

?>
