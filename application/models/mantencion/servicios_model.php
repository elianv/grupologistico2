<?php
class Servicios_model extends CI_Model{
    
     function __construct() {
         parent::__construct();
     }
     
     function ultimo_codigo(){
        
        $this->db->select_max('codigo_servicio');
        $result = $this->db->get('servicio');
        
            return $result->result_array();
     }
     
     function insertar_servicio($servicio){
         
         if($this->db->insert('servicio', $servicio)){
            return true;
        }
        else{
            return false;
        }
         
     }

     function modificar_servicio($servicio,$codigo_servicio){
        $this->db->where('codigo_servicio',$codigo_servicio);               
         
         if($this->db->update('servicio', $servicio)){
            return true;
        }
        else{
            return false;
        }
         
     }
     
     function listar_servicios(){
         
         $this->db->select('codigo_servicio,descripcion');
         $this->db->where('codigo_servicio > 0');
         $resultado = $this->db->get('servicio');
         
         return $resultado->result_array();
         
     }
     
     function existe_servicio($servicio){
        $this->db->select ('codigo_servicio');
        $this->db->from('servicio');
        $this->db->where('codigo_servicio',$servicio);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
	
     function datos_servicio($rut) {
			$this->db->select('*')
			         ->from('servicio')
                     ->join('codigos_sistema', 'servicio.id_codigo_sistema = codigos_sistema.id')   
                     //->where('servicio.id_codigo_sistema = codigos_sistema.id')
			         ->where('servicio.codigo_servicio',$rut);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
        
    }     

}

?>