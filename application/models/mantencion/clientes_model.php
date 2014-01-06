<?php

class Clientes_model extends CI_Model{
    
    function insertar($datos){
        
        if($this->db->insert('cliente', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }

    function modificar($datos,$rut_cliente){
        $this->db->where('rut_cliente',$rut_cliente);               
        
        if($this->db->update('cliente', $datos)){
            return true;
        }
        else{
            return false;
        }
         
    }    
    
    function repetido($rut){
        
        $this->db->select ('rut_cliente');
        $this->db->from('cliente');
        $this->db->where('rut_cliente',$rut);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_clientes(){
        
        $this->db->select('rut_cliente,razon_social');
        $resultado = $this->db->get('cliente');
        
        return $resultado->result_array();
        
    }
    
    function existe_rut($rut){
        $this->db->select ('rut_cliente');
        $this->db->from('cliente');
        $this->db->where('rut_cliente',$rut);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
        function datos_cliente($rut) {
			$this->db->select ('rut_cliente,razon_social,giro,direccion,comuna,ciudad,fono,contacto,celular,dias_plazo,tipo_factura');
			$this->db->from('cliente');
			$this->db->where('rut_cliente',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }
}

?>

