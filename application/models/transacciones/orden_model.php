<?php

class Orden_model extends CI_Model{
     
    function ultimo_codigo(){
        
        $this->db->select_max('id_orden');
        $result = $this->db->get('orden');
        return $result->result_array();
    }
    
    function insert_orden($orden){
                 
        $this->db->trans_start();               
        $this->db->insert('orden',$orden);
        $this->db->trans_status();

        if ($this->db->trans_status() === FALSE)
            return FALSE;
        else
            return $this->db->insert_id();
    }
    
    function editar_orden($orden,$id_orden){
        $this->db->where('id_orden', $id_orden);
        $this->db->update('orden', $orden); 
    }
    
    function existe_orden($orden){
        $this->db->select ('id_orden');
        $this->db->from('orden');
        $this->db->where('id_orden',$orden);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return true;
        }
        
        else{
            
            return false;
        }
    }
    
    function listar_ordenes(){
         
         $this->db->select('orden.id_orden,orden.fecha,cliente.razon_social,orden.id_estado_orden');
         $this->db->from('orden');
         $this->db->join('cliente','orden.cliente_rut_cliente = cliente.rut_cliente','inner');
         $resultado = $this->db->get();
         
         return $resultado->result_array();
     }
	
    function get_orden($id_orden){
		
		$this->db->select();
		$this->db->from('orden');
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get();
		
		return $result->result_array();
		
	}
	
    function getDetalleByOrdenId($id_orden){
		
		$this->db->select();
		$this->db->from('detalle');
		$this->db->where('orden_id_orden',$id_orden);
		$result = $this->db->get();
		
		return $result->result_array();
		
	}
        
    function buscar_ordenes($tipo_orden=null,$desde=null,$hasta=null,$cliente=null){
            $this->db->select();
            $this->db->from('orden');
            $this->db->join('cliente','orden.cliente_rut_cliente = cliente.rut_cliente','inner');
            if($tipo_orden != 4){
                $this->db->where('tipo_orden_id_tipo_orden',$tipo_orden);
            }
            if($desde){
                $this->db->where('id_orden >=',$desde);
            }
            if($hasta){
                $this->db->where('id_orden <=',$hasta);
            }
            if($cliente){
               $this->db->like('cliente.razon_social',$cliente); 
            }
            $this->db->join('estado_orden','orden.id_estado_orden = estado_orden.id', 'inner');
            $result = $this->db->get();
            //var_dump($this->db->last_query());
            
            return $result->result_array();
    }
    
    function eliminar_orden($id_orden){
            	$this->db->where('id_orden', $id_orden);
		if($this->db->delete('orden')){
			return true;
		} 
		else{
			return false;
		}
    }

    function estados_orden()
    {
        $this->db->select('*');
        $this->db->from('estado_orden');

        $result = $this->db->get();
        
        return $result->result_array();
    }
}
?>
