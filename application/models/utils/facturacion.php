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
    
    function GetTipo(){
        //$this->db->select('tipo_facturacion');
        $query = $this->db->get('tipo_factura');
        //$query = "select * from tipo_factura;";
        return $query->result_array();
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
    
    
}

?>