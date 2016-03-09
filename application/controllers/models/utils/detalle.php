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
		$this->db->select('*');
		$this->db->where('orden_id_orden',$id_orden);
		$result = $this->db->get('detalle');
        //var_dump($this->db->last_query());
		return $result->result_array();
    }
    
    function modificar_detalle($id_orden,$detalle){
		$this->db->where('id_detalle',$detalle['id_detalle']);
        if($this->db->update('detalle',$detalle)){
            return true;
        }
        else{
            return false;
        }

    }
    
    function ultimo_codigo(){
        $this->db->select_max('id_detalle');
        $result = $this->db->get('detalle');
        
            return $result->result_array();
    }

    function eliminar_detalle($id_orden){
    	$this->db->where('orden_id_orden', $id_orden);
		if($this->db->delete('detalle')){
			return true;
		} 
		else{
			return false;
		}


    }

    function existe_detalle($id_orden){
    	$this->db->select ('id_detalle');
        $this->db->from('detalle');
        $this->db->where('orden_id_orden',$id_orden);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
}

?>