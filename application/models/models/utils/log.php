<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class log extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function insertar_log($data){
        $this->db->trans_start();
        $this->db->insert('log', $data);
        $this->db->trans_complete();
        return $this->db->insert_id();

    }
    
    
}

?>