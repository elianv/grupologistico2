<?php

class Facturacion_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
     
     function insertar_factura($factura){
         
         if($this->db->insert('factura', $factura)){
            return true;
        }
        else{
            return false;
        }
         
     }     
     
     function listar_facturas(){
         
         $this->db->select('numero_factura,estado_factura_id_estado_factura');
         $resultado = $this->db->get('factura');
         
         return $resultado->result_array();
         
     }
    
}
?>