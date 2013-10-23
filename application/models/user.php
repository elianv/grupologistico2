<?php

Class User extends CI_Model{
    
    function login($rut, $password){
        
        $this->db->select ('rut,nombre,clave');
        $this->db->from('usuario');
        $this->db->where('rut',$rut);
        $this->db->where('clave',$password);
        
        $query = $this->db->get();
        
        if($query ->num_rows() == 1){
            
            return $query->result();
            
        }
        
        else{
            
            return false;
        }
    }
    
            
}

?>