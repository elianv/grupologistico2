<?php

class Orden_model extends CI_Model{

    function ultimo_codigo(){

        $this->db->select_max('id_orden');
        $result = $this->db->get('orden');
        return $result->result_array();
    }

    function insert_orden($orden){

        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        $this->db->insert('orden',$orden);
        $query = $this->db->query('SELECT LAST_INSERT_ID() as last_id');
        //var_dump($this->db->last_query());
        //print_r($this->db->last_query());
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }
        else {
            $this->db->trans_commit();  
            $result = $query->result_array();
            return $result[0]['last_id'];
        }
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

		$this->db->select('*');
		$this->db->from('orden');
		$this->db->where('id_orden',$id_orden);
		$result = $this->db->get();

		return $result->result_array();

	}

    function getDetalleByOrdenId($id_orden){

		$this->db->select('detalle.*, servicio.descripcion')
		          ->from('detalle')
                  ->join('servicio','servicio.codigo_servicio = detalle.servicio_codigo_servicio ')
		          ->where('orden_id_orden',$id_orden);
		$result = $this->db->get();
		//var_dump($this->db->last_query());
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

    function getOrden($desde,$limit,$where=null,$order=null,$by=null,$count=0,$opc = 0)
    {

        $orden_status = array(
            0 => '2,3',
            1 => '1',
            2 => '2',   
            3 => '3',
            4 => '1,2,3'
        );

        $in = $orden_status[$opc];

        switch ($by) {
            case 0:
                $valor = 'orden.id_orden';
            break;
            case 1:
                $valor = 'proveedor.razon_social';
            break;
            case 2:
                $valor = 'cliente.razon_social';
            break;
        }

        $sql = "SELECT CONCAT(\"<a class='codigo-click' onclick='datos( \", orden.id_orden ,\"  )' data-codigo=' \", orden.id_orden  ,\" ' >  \", orden.id_orden , \" </a> \" ) id, COALESCE(proveedor.razon_social, 'S/P') as proveedor, COALESCE(cliente.razon_social, 'S/C') as cliente";
        $sql .= "
            FROM
                orden
                    left join
                proveedor ON orden.proveedor_rut_proveedor = proveedor.rut_proveedor
                    left join
                cliente ON cliente.rut_cliente = orden.cliente_rut_cliente ";
        if($where)
        {
            $sql .= 'WHERE ( CAST(orden.id_orden as CHAR) like "%'.$where.'%" OR cliente.razon_social like "%'.$where.'%"  OR proveedor.razon_social like "%'.$where.'%" ) ';
            $sql .= 'AND ( orden.id_orden IS NOT NULL AND cliente.razon_social IS NOT NULL AND proveedor.razon_social IS NOT NULL )';
            $sql .= "AND orden.id_estado_orden in ({$in})";
        }
        else
            $sql .= " WHERE orden.id_estado_orden in ({$in})";

        $sql .= "ORDER BY {$valor} {$order} ";

        if(!$count)
            $sql .= "limit  {$desde}, {$limit} ";

        $query = $this->db->query($sql);

        //var_dump($this->db->last_query());
        if(!$count){
            return $query->result_array();
        }

        else
            return $query->num_rows();
    }

    function orden($id){

        $this->db->select(' orden.id_orden, orden.proveedor_rut_proveedor, orden.cliente_rut_cliente, orden.tramo_codigo_tramo, tramo.descripcion as tramo, orden.valor_costo_tramo, orden.valor_venta_tramo, proveedor.razon_social as proveedor, cliente.razon_social as cliente')
                ->join('proveedor' , 'orden.proveedor_rut_proveedor = proveedor.rut_proveedor' , 'left')
                ->join('cliente' , 'cliente.rut_cliente = orden.cliente_rut_cliente' , 'left')
                ->join('tramo' , 'tramo.codigo_tramo = orden.tramo_codigo_tramo' , 'left')
                ->where('orden.id_orden' , $id);

        $result = $this->db->get('orden');

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

    function ordenes(){
        $this->db->select('*');
        $this->db->from('ordenes');
        $this->db->where('id_estado_orden', 1);

        $result = $this->db->get();

        return $result->result_array();
    }
}
?>
