<?php

class Navieras_model extends CI_Model{
    
    function insertar_naviera($datos){
        if($this->db->insert('naviera', $datos)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function modificar_naviera($datos,$codigo_naviera){
        $this->db->where('codigo_naviera', $codigo_naviera);           
        if($this->db->update('naviera', $datos)){
            return true;
        }
        else{
            return false;
        }
    } 
    
    function ultimo_codigo(){
        
        $this->db->select_max('codigo_naviera');
        $result = $this->db->get('naviera');
        
            return $result->result_array();
        
    }
    
    function listar_navieras(){
        $this->db->select('codigo_naviera,nombre');
        $resultado = $this->db->get('naviera');
        
        return $resultado->result_array();
    }
    
    
    
    
}

?>