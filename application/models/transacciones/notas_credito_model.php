<?php

class notas_credito_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }


    function getData($desde,$limit,$where=null,$order=null,$by=null,$count=0, $opc=array()){

        switch ($by) {
            case 0:
                $valor = 'nc.numero_nota';
                break;
            case 1:
                $valor = 'c.rut_cliente';
                break;
            case 2:
                $valor = 'c.razon_social';
                break;
            case 3:
                $valor = 'nc.monto';
                break;
            case 4:
                $valor = 'f.numero_factura';
                break;
            case 5:
                $valor = 'nc.fecha';
                break;

        }
        
        $sql = "SELECT 
                    nc.numero_nota AS Numero,
                    c.rut_cliente AS 'Rut Cliente',
                    c.razon_social AS 'Razon social',
                    nc.monto AS Monto,
                    f.numero_factura AS Factura,
                    nc.codigo_sistema AS 'Codigo sistema', 
                    nc.fecha AS Fecha
                FROM
                    notas_credito AS nc
                        INNER JOIN
                    factura AS f ON f.id = nc.id_factura
                        INNER JOIN
                    ordenes_facturas AS orv ON orv.id_factura = f.id
                        INNER JOIN
                    orden AS o ON o.id_orden = orv.id_orden
                        INNER JOIN
                    cliente AS c ON c.rut_cliente = o.cliente_rut_cliente
                WHERE 
                    nc.numero_nota IS NOT NULL ";
        if($where != '' and !is_null($where))
        {
            $sql .= ' AND ( CAST(nc.numero_nota as CHAR) like "%'.$where.'%" 
            OR c.rut_cliente like "%'.$where.'%" 
            OR c.razon_social like "%'.$where.'%" 
            OR CAST(nc.monto as CHAR) like "%'.$where.'%" 
            OR CAST(f.numero_factura AS CHAR) like "%'.$where.'%" 
            OR CAST(nc.fecha AS CHAR) like "%'.$where.'%") ';
        }
        
        if (array_key_exists('desde', $opc) && array_key_exists('hasta', $opc)){

            $o_desde = new DateTime($opc['desde']);
            $o_hasta = new DateTime($opc['hasta']);
            $sql .= ' AND nc.fecha between "'.$o_desde->format('Y-m-d').'" '.$opc['operador'].' "'.$o_hasta->format('Y-m-d').' "' ;

        }
        
        $sql .= "ORDER BY {$valor} {$order} ";
        
        if(!$count){
            $sql .= "limit  {$desde}, {$limit} ";
        }

        $query = $this->db->query($sql);
        if ($count){
            return $query->num_rows();
        }
        else{
            return $query->result_array();    
        }
    	
    }

    function insertar_nc($nota){

    	$this->db->trans_begin();
    	$this->db->insert('notas_credito',$nota);
    	if ($this->db->trans_status() === FALSE){
        	$this->db->trans_rollback();
        	return FALSE;
		}
		else{
        	$this->db->trans_commit();
        	return TRUE;
		}

    }

    function getNotaByFactura($id_factura){
        $sql  = "SELECT numero_nota, SUM(monto) as suma FROM notas_credito WHERE id_factura = ? GROUP BY numero_nota";
        $query = $this->db->query($sql, array($id_factura));
        
        //var_dump( $this->db->last_query() );
        return $query->result_array();
    }

    function GetNotas($desde=NULL, $hasta=NULL){

        $this->db->select("nc.numero_nota,
                            c.rut_cliente,
                            c.razon_social,
                            nc.monto,
                            f.numero_factura,
                            nc.codigo_sistema, 
                            nc.fecha");
        $this->db->from("notas_credito AS nc");
        $this->db->join("factura f", "f.id = nc.id_factura");
        $this->db->join("ordenes_facturas orv","orv.id_factura = f.id");
        $this->db->join("orden o", "o.id_orden = orv.id_orden");
        $this->db->join("cliente c", "c.rut_cliente = o.cliente_rut_cliente");
        $this->db->where("nc.numero_nota IS NOT NULL");

        if (!is_null($desde) && !is_null($hasta) && $hasta != "" && $desde != ""){
            $o_desde = new DateTime($desde);
            $o_hasta = new DateTime($hasta);
            $where = 'nc.fecha between "'.$o_desde->format('Y-m-d').'" AND "'.$o_hasta->format('Y-m-d').'"' ;
            $this->db->where($where);
        }
        
        $result = $this->db->get();
        //var_dump( $this->db->last_query() );
		return $result->result_array();
    }
}