<?php

class Agencias_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_aduana');
        $result = $this->db->get('aduana');
        
            return $result->result_array();
     }
     
     function insertar_agencia($agencia){
         
         if($this->db->insert('aduana', $agencia)){
            return true;
        }
        else{
            return false;
        }
         
     }
     
     function listar_agencias(){
         
         $this->db->select('codigo_aduana,nombre');
         $resultado = $this->db->get('aduana');
         
         return $resultado->result_array();
         
     }
    
}
?>