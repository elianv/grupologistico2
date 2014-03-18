<?php

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
