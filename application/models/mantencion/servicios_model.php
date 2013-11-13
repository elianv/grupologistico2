<?php
class Servicios_model extends CI_Model{
    
     function __construct() {
         parent::__construct();
     }
     
     function ultimo_codigo(){
        
        $this->db->select_max('codigo_servicio');
        $result = $this->db->get('servicio');
        
            return $result->result_array();
     }
     
     function insertar_servicio($servicio){
         
         if($this->db->insert('servicio', $servicio)){
            return true;
        }
        else{
            return false;
        }
         
     }
     
     function listar_servicios(){
         
         $this->db->select('codigo_servicio,descripcion');
         $resultado = $this->db->get('servicio');
         
         return $resultado->result_array();
         
     }
     
}

?>