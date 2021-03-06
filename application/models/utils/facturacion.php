<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Facturacion extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function listar_tramos(){
        
        $this->db->select('codigo_tramo,descripcion');
        $result = $this->db->get('tramo');
        
        return $result->result_array();
        
    }
    
    //obtiene el tipo de orden (exp,imp,nac,otro s.)
    function tipo_orden(){
        
        $query = $this->db->get('tipo_orden');
        
        return $query->result_array();
        
    }
    
    function estado_orden_factura($id_orden){
        
        $this->db->select('factura.estado_factura_id_estado_factura, ordenes_facturas.id_orden');
        $this->db->from('factura, ordenes_facturas');
        $this->db->where('ordenes_facturas.id_factura = factura.id');
        $this->db->where('ordenes_facturas.id_orden',$id_orden);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    
}

?>