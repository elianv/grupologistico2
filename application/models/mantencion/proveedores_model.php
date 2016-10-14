<?php

class Proveedores_model extends CI_Model{
    
    function insertar($datos){
        
        if($this->db->insert('proveedor', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }
    
    function modificar($datos,$rut_proveedor){
        $this->db->where('rut_proveedor',$rut_proveedor);               
        
        if($this->db->update('proveedor', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }
    
    function repetido($rut){
        
        $this->db->select ('rut_proveedor');
        $this->db->from('proveedor');
        $this->db->where('rut_proveedor',$rut);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_proveedores(){
        
        $this->db->select('rut_proveedor,razon_social');
        $resultado = $this->db->get('proveedor');
        
        return $resultado->result_array();
        
    }
    
    function existe_rut($rut){
        $this->db->select ('rut_proveedor');
        $this->db->from('proveedor');
        $this->db->where('rut_proveedor',$rut);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
	
	function datos_proveedor($rut) {

            $sql = $this->db->query(" SELECT 
                                coalesce(rut_proveedor,\"\") as rut_proveedor ,
                                coalesce(razon_social,\"\") as razon_social,
                                coalesce(giro,\"\") as giro,
                                coalesce(direccion,\"\") as direccion,
                                coalesce(comuna,\"\") as comuna,
                                coalesce(ciudad,\"\") as ciudad,
                                coalesce(fono,\"\") as fono,
                                coalesce(celular,\"\") as celular
			                 FROM proveedor
			                 WHERE rut_proveedor = '{$rut}' ;");
			
			
			return  $sql->result_array();
        
    }
}

?>