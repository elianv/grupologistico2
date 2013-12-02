<?php

class Orden_detalle_model extends CI_Model{
    
    function guardar_detalle($orden){
        if($this->db->insert('detalle', $orden)){
            return true;
        }
        else{
            return false;
        }
    }
    
    function listar_detalle(){
         $this->db->select('id_detalle,servicio_codigo_servicio,orden_id_orden,tramo_codigo_tramo,valor_costo,valor_venta');
         $resultado = $this->db->get('detalle');
         
         return $resultado->result_array();
    }

    
}

?>