<?php
class Bodegas_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_codigo(){
        
    }
    
    function insertar_bodega($bodega){
        if($this->db->insert('bodega', $bodega)){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    function listar_bodegas(){
        
    }
}
?>
