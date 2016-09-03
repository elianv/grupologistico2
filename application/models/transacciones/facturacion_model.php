<?php

class Facturacion_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function ultimo_numero(){
        
        $this->db->select_max('id');
        $result = $this->db->get('factura');
        
        return $result->result_array();
    }

    function ultimo_id_orden_facturacion(){
        $this->db->select_max('id');
        $result = $this->db->get('ordenes_facturas');
        
        return $result->result_array();
    }
    
    function insertar_facturacion($factura){
        
        $this->db->insert('factura', $factura);
        $insert_id = $this->db->insert_id();

   return  $insert_id;
    }
    
    function insertar_orden_facturacion($orden){
        $this->db->trans_start();
        $this->db->insert('ordenes_facturas', $orden);
        $this->db->trans_complete();
        return $this->db->insert_id();
    }

    function insertar_servicios_orden_factura($data){
        $this->db->trans_start();
        $this->db->insert('servicios_orden_factura', $data);
        $this->db->trans_complete();
        return $this->db->insert_id();        
    }
    
    function modificar_facturacion($factura,$id){
        $this->db->where('id', $id);   
        if($this->db->update('factura', $factura)){
            return true;
        }
        else{
            return false;
        }
        
    }

    function factura_repetida($numero_factura){
        
        $this->db->select ('numero_factura');
        $this->db->from('factura');
        $this->db->where('numero_factura',$numero_factura);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return false;
        }
        
        else{
            
            return true;
        }
    }
    
    function listar_facturas(){
        $this->db->select('*');
        $resultado = $this->db->get('factura');
        
        return $resultado->result_array();
    }
    
    function existe_factura($factura){
        $this->db->select ('numero_factura');
        $this->db->from('factura');
        $this->db->where('numero_factura',$factura);
                
        $query = $this->db->get();
        
        if($query->num_rows() == 0){
            
            return $query->num_rows();
        }
        
        else{
            
            return $query->num_rows();
        }
    }
    
    function datos_factura($numero_factura , $os_manager = NULL) {
			$this->db->select('*');
			$this->db->from('factura');
			$this->db->where('numero_factura',$numero_factura);
            if($os_manager)
                $this->db->where('id', $os_manager);
			$resultado = $this->db->get();
			
			return $resultado->result_array();
    }

    function cant_clientes_orden($clientes){
        $this->db->select('cliente_rut_cliente');
        $this->db->from('orden');
        foreach ($clientes as $cliente) {
            $this->db->or_where('id_orden',$cliente);    
        }
        $this->db->group_by("cliente_rut_cliente"); 
        $resultado = $this->db->get();

        return $resultado->num_rows();
    }

    function tiene_detalle($id_orden){
        $this->db->select('*');
        $this->db->from('detalle');
        $this->db->where('orden_id_orden',$id_orden);

        $result = $this->db->get();

        return $result->num_rows();
    }

    function getOrdenes($id_factura){
        $this->db->select('*');
        $this->db->from('ordenes_facturas');
        $this->db->where('id_factura',$id_factura);
        $resultado = $this->db->get();
            
        return $resultado->result_array();

    }

    function getServicioOrdenFactura($id){
        $this->db->select('*');
        $this->db->from('servicios_orden_factura');
        $this->db->where('id_ordenes_facturas',$id);
        $resultado = $this->db->get();
        
        return $resultado->result_array();        
    }

    function eliminarFactura($id){

        $this->db->where('id', $id);
        $this->db->delete('factura'); 

    }

    function eliminarOrdenesFactura($id){
        $this->db->where('id_factura', $id);
        $this->db->delete('ordenes_facturas'); 
    }

    function eliminarServiciosOrdeneFactura($id){
        $this->db->where('id_ordenes_facturas', $id);
        $this->db->delete('servicios_orden_factura'); 
    }    

    function factura_nula($numero_factura){
            $this->db->select('estado_factura_id_estado_factura');
            $this->db->from('factura');
            $this->db->where('numero_factura',$numero_factura);
            
            $resultado = $this->db->get();
            
            return $resultado->result_array();        
    }

    function valor_factura($id_factura ){

        $sql = "select ( SUM(coalesce(detalle.valor_costo,0) ) + coalesce(orden.valor_costo_tramo,0) ) as total_costo,
                       ( SUM(coalesce(detalle.valor_venta,0) ) + coalesce(orden.valor_venta_tramo,0) ) as total_venta
                from factura
                left join ordenes_facturas ON ordenes_facturas.id_factura = factura.id
                left join detalle ON ordenes_facturas.id_orden = detalle.orden_id_orden
                left join orden ON orden.id_orden = ordenes_facturas.id_orden
                where factura.id =".$id_factura;

        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    function getOrdenFacturaByOrden($orden)
    {
    	$sql = "SELECT 
                    COALESCE(of.id,'SIN DATOS') id,
                    COALESCE(of.id_factura,'SIN DATOS') id_factura,
                    COALESCE(of.id_orden,'SIN DATOS') id_orden,
                    COALESCE(of.factura_tramo,'SIN DATOS') factura_tramo,
                    COALESCE(DATE_FORMAT(of.fecha_factura , \"%d-%m-%Y\"), '') as fecha_factura_tramo,
                    f.*
                FROM 
                    ordenes_facturas of 
                LEFT JOIN
                    factura f ON f.id = of.id_factura
                WHERE
                    id_orden = {$orden}
                ";
                //->join('factura f,')
    			
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    function getFacturabyId($id)
    {
    	$sql = "select 
                    id,
                    numero_factura,
                    DATE_FORMAT(fecha,\"%d-%m-%Y\") as fecha
                from 
                    factura
    			where id = {$id} ";

        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    function getFacturabyFecha($desde = null, $hasta = null)
    {
        $this->db->select('factura.`numero_factura`, factura.`id`, factura.`fecha`, estado_factura.tipo_factura, cliente.razon_social')
                    ->join('ordenes_facturas','ordenes_facturas.id_factura = factura.id','inner')
                    ->join('orden','ordenes_facturas.id_orden = orden.id_orden','inner')
                    ->join('cliente', 'orden.cliente_rut_cliente = cliente.rut_cliente', 'inner')
                    ->join('estado_factura' , 'estado_factura.id_estado_factura = factura.estado_factura_id_estado_factura', 'inner');

        if($desde && $hasta)
        {
            $desde = new DateTime($desde);
            $hasta = new DateTime($hasta);
            $this->db->where('factura.fecha between "'.$desde->format('Y-m-d').'" AND "'.$hasta->format('Y-m-d').'"');
        }

        $result = $this->db->get('factura', 10, 20);

        return $result->result_array();

    }

    function getFacturasPendientes($desde,$limit,$where=null,$order=null,$by=null,$count=0,$opc = 0)
    {
        
        switch ($by) {
            case 0:
                $valor = 'factura.id';
            break;
            case 1:
                $valor = 'factura.id';
            break;
            case 2:
                $valor = 'cliente';
            break;
            case 3:
                $valor = 'factura.fecha';
            break;

        }
        
        if(!$opc)
            $sql = "SELECT CONCAT(\"<input type='checkbox' name='select' value=' \", factura.id, \" ' > \" ) boton, factura.id, factura.numero_factura, DATE_FORMAT(factura.fecha,'%d-%m-%Y') as fecha, cliente.razon_social as cliente";
        else
            $sql = "SELECT CONCAT(\"<a class='codigo-click' onclick='datos( \", factura.id ,\"  )' data-codigo=' \", factura.id  ,\" ' >  \", factura.id, \" </a> \" ) id, factura.numero_factura, DATE_FORMAT(factura.fecha,'%d-%m-%Y') as fecha, cliente.razon_social as cliente";
        $sql .= "
                    FROM (factura)
                    INNER JOIN ordenes_facturas ON ordenes_facturas.id_factura = factura.id
                    INNER JOIN orden ON ordenes_facturas.id_orden = orden.id_orden
                    INNER JOIN cliente ON orden.cliente_rut_cliente = cliente.rut_cliente
                    WHERE numero_factura = 0
                    AND estado_factura_id_estado_factura = 1 ";
        if($where)
        {
            $sql .= 'AND ( CAST(factura.id as CHAR) like "%'.$where.'%" OR cliente.razon_social like "%'.$where.'%"  OR CAST(factura.fecha as CHAR) like "%'.$where.'%" ) ';
        }                    
        
        $sql .= "ORDER BY {$valor} {$order} ";
        
        if(!$count)            
            $sql .= "limit  {$desde}, {$limit} ";        

        $query = $this->db->query($sql);
        

        if(!$count){
            //var_dump($this->db->last_query());
            return $query->result_array();                             
        }
            
        else 
            return $query->num_rows();
    }

    function getFacturaOrden($id_factura)
    {
        $sql = $this->db->query("
            SELECT 
                DATE_FORMAT(f.fecha, \"%d-%m-%Y\") fecha,
                or_f.factura_tramo,
                or_f.id_orden,
                o.cliente_rut_cliente,
                o.valor_venta_tramo,
                t.codigo_tramo,
                t.descripcion,
                t.id_codigo_sistema,
                cs.cuenta_contable
            FROM
                ordenes_facturas or_f,
                orden o,
                tramo t,
                codigos_sistema cs,
                factura f
            WHERE
                or_f.id_factura = f.id
            AND o.id_orden = or_f.id_orden
            AND o.tramo_codigo_tramo = t.codigo_tramo
            AND t.id_codigo_sistema = cs.codigo_sistema
            AND f.id = {$id_factura}");

            

        return $sql->result_array();                             
    }


    function detalleTotalByOrden($id_orden){
        $sql = $this->db->query("SELECT 
                                    servicios_orden_factura.*,
                                    tx.*,
                                    proveedor.razon_social
                                FROM
                                    servicios_orden_factura,
                                    (SELECT 
                                        det2 . *, ser.descripcion
                                    FROM
                                        detalle det2, (SELECT 
                                        ser.codigo_servicio, ser.descripcion
                                    FROM
                                        servicio ser) ser
                                    where
                                        ser.codigo_servicio = det2.servicio_codigo_servicio) as tx,
                                    proveedor
                                WHERE
                                    tx.orden_id_orden = {$id_orden}
                                AND detalle_id_detalle = tx.id_detalle
                                AND proveedor.rut_proveedor = servicios_orden_factura.proveedor_rut_proveedor;");

        return $sql->result_array();                    
    }

    function editarServiciosOrdenesFacturas($id, $datos){

            $this->db->where('id',$id);
            if($this->db->update('servicios_orden_factura',$datos)){
                return true;
            }
            else{
                return false;
            }
    }

    function total_costo($id){
        
        $sql = $this->db->query("SELECT od_costo + det_costo as TOTAL_COSTO FROM
                (SELECT SUM(valor_costo_tramo) as od_costo FROM orden where id_orden IN (SELECT id_orden FROM glc_sct.ordenes_facturas where id_factura = {$id} )) as od,
                (SELECT SUM(valor_costo) as det_costo FROM detalle WHERE orden_id_orden IN (SELECT id_orden FROM glc_sct.ordenes_facturas where id_factura = {$id} )) as det");
        
        return $sql->result_array();
    }

    function manager($ws,$method)
    {
        $this->db->select('url, name, action')
                 ->where('name' , $ws)
                 ->where('method' , $method);
        $query = $this->db->get('web_service');

        return $query->result();
    }    

}

?>

