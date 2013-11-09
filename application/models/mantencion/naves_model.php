<?php
class Naves_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function nombre_navieras(){
        $this->db->select('nombre , codigo_naviera');
        $this->db->from('naviera');
        $this->db->order_by('codigo_naviera');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_nave');
        $result = $this->db->get('nave');
        
            return $result->result_array();
        
    }
    
    function insertar_nave($nave){
        if($this->db->insert('nave', $nave)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function repetido(){
        
    }
}
?>


