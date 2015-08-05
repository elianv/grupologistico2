<?php

class Usuario extends CI_Model{

    function __construct() {
        parent::__construct();
    }
    
     function GetTipo(){
        $query = $this->db->get('tipos_usuario');
        //$query = "select * from tipo_factura;";
        return $query->result_array();
    }
}

?>
