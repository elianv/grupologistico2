<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Moneda extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function GetTipo(){
        //$this->db->select('tipo_facturacion');
        $query = $this->db->get('moneda');
        //$query = "select * from tipo_factura;";
        return $query->result_array();
    }
    
    
}

?>