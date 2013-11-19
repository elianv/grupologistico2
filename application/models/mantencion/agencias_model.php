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
     
    function modificar_agencia($agencia,$codigo_agencia){
        $this->db->where('codigo_aduana',$codigo_agencia);               
        if($this->db->update('aduana', $agencia)){
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
     
        function existe_aduana($aduana){
            $this->db->select ('codigo_aduana');
            $this->db->from('aduana');
            $this->db->where('codigo_aduana',$aduana);

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