<?php
class Facturacion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/facturacion_model');
        $this->load->model('transacciones/orden_model');
        $this->load->model('utils/Detalle');
        $this->load->model('mantencion/servicios_model');
        $this->load->model('mantencion/tramos_model');
        $this->load->model('mantencion/proveedores_model');
        $this->load->model('mantencion/clientes_model');
    }
    
    function index(){
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/home');
            $this->load->view('include/script');
           
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function insertar_facturacion(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            
            if(isset($_POST['factura_papel']) ){
                $this->form_validation->set_rules('factura_numero', 'Numero Factura','trim|required|xss_clean|numeric|callback_check_database');    
            }
            
            $this->form_validation->set_rules('fecha_factura', 'Fecha de la Factura','trim|required|xss_clean');
            
            if(!isset($_POST['nula'])){
                $this->form_validation->set_rules('total_venta', 'Valor Total Venta','trim|required|xss_clean');
                $this->form_validation->set_rules('total_costo', 'Valor Total Costo','trim|required|xss_clean');
                $this->form_validation->set_rules('cliente_factura', 'Cliente','trim|required|xss_clean');                                
            }

            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/facturacion/home');
                $this->load->view('include/script');
            }
            else{
                if(isset($_POST['nula'])){

                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));                    
                        $factura = array(
                                    'numero_factura'                   => $this->input->post('factura_numero'),
                                    'estado_factura_id_estado_factura' => 3,
                                    'fecha'                            => $fecha_factura                    
                                );

                        $this->facturacion_model->insertar_facturacion($factura);
                        $this->session->set_flashdata('mensaje','Factura Nula guardada con éxito');
                        redirect('transacciones/facturacion','refresh');                                            
                }
                else{
                        $session_data = $this->session->userdata('logged_in');
                        
                        $arreglo       = implode("|",$this->input->post('guia_despacho'));
                        $total_costo   = str_replace(".", "", $this->input->post('total_costo'));
                        $total_venta   = str_replace(".", "", $this->input->post('total_venta'));
                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));

                        $factura = array(
                                    
                                    'estado_factura_id_estado_factura' => 1,
                                    'total_costo'                      => $total_costo,
                                    'total_venta'                      => $total_venta,
                                    'guia_despacho'                    => $arreglo,
                                    'fecha'                            => $fecha_factura                    
                                );

                        if(isset( $_POST['factura_papel'] ) )
                        {
                            $factura['numero_factura'] = $this->input->post('factura_numero');

                        }

                        $this->facturacion_model->insertar_facturacion($factura);
                        $catch_factura        = $this->facturacion_model->ultimo_numero();

                        $ordenes              = $this->input->post('id_orden');
                        $factura_tramo        = $this->input->post('factura_tramo');
                        $fecha_factura_tramo  = $this->input->post('fecha_factura_tramo');
                        $ordenes_detalle      = $this->input->post('id_orden_detalle');
                        $i = 0;
                        $k = 0;
                        foreach ($ordenes as $orden) {

                            $fecha_factura_tramo[$i] = str_replace('/','-', $fecha_factura_tramo[$i]);
                            $fecha_factura_tramo[$i] = date("Y-m-d ",strtotime($fecha_factura_tramo[$i]));

                            $orden_factura = array(
                                    'factura_tramo' => $factura_tramo[$i],
                                    'fecha_factura' => $fecha_factura_tramo[$i],
                                    'id_factura'    => $catch_factura[0]['id'],
                                    'id_orden'      => $orden
                                );
                            $i++;
                            
                            $this->facturacion_model->insertar_orden_facturacion($orden_factura);
                            $dato = array('id_estado_orden' => 2);
                            $this->orden_model->editar_orden($dato, $orden);
                            $id_orden_faturacion     = $this->facturacion_model->ultimo_id_orden_facturacion();
                            $fecha_otros_servicios   = $this->input->post('fecha_otros_servicios');
                            $factura_otros_servicios = $this->input->post('factura_otros_servicios');
                            $proveedor_servicio      = $this->input->post('proveedor_servicio');
                            $id_detalle              = $this->input->post('id_detalle');

                            $j = 0;
                            if(isset($ordenes_detalle)){
                                    foreach ($ordenes_detalle as $orden_detalle) {
                                        if($orden == $orden_detalle ){
                                            $fecha_otros_servicios[$j] = str_replace('/','-', $fecha_otros_servicios[$j]);
                                            $fecha_otros_servicios[$j] = date("Y-m-d ",strtotime($fecha_otros_servicios[$j]));
                                            $prov                      = explode(" - ", $proveedor_servicio[$k]);
                                            $k++;

                                            $servicios_orden_factura = array(
                                                        'detalle_id_detalle'     => $id_detalle[$j],
                                                        'factura_numero_factura' => $factura_otros_servicios[$j],
                                                        'proveedor_rut_proveedor'=> $prov[0],
                                                        'fecha_factura_servicio' => $fecha_otros_servicios[$j],
                                                        'id_ordenes_facturas'    => $id_orden_faturacion[0]['id']
                                            );
                                            $this->facturacion_model->insertar_servicios_orden_factura($servicios_orden_factura);
                                            $j++;                        
                                        }

                                    }                        
                            }
                        }
                        
                        $this->session->set_flashdata('mensaje','Facturación guardada con éxito');
                        redirect('transacciones/facturacion','refresh');
                }
            }
        }
        else{
            redirect('home','refresh');
        }
    }

    function cargar_facturas(){
        if($this->session->userdata('logged_in')){
            $factura               = $this->facturacion_model->datos_factura($this->input->post('num_factura'));
            
            
            if($factura[0]['estado_factura_id_estado_factura'] == 3){
                    $theHTMLResponse['clientes']     = 1;
                    $theHTMLResponse['html']         = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Factura Nula. Sin Ordenes de Servicio.</strong> </div>';
                    $theHTMLResponse['total_compra'] = "--";
                    $theHTMLResponse['total_venta']  = "--";
                    $theHTMLResponse['cliente']      = "--";
                    $theHTMLResponse['factura']      = $factura[0];

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));                     
            }
            else{
                    $data['guias_despacho'] = $factura[0]['guia_despacho']; 
                    $ordenes  = $this->facturacion_model->getOrdenes($factura[0]['id']);

                    $i = 0;
                    $detalle['total_venta']  = $factura[0]['total_venta'];
                    $detalle['total_compra'] = $factura[0]['total_costo'];
                    foreach ($ordenes as $orden) {
                                 

                                $detalle['ordenes'][$i]                  = $this->orden_model->get_orden($orden['id_orden']);
                                $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];
                                $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];
                                $detalle['ordenes'][$i]['total_compra']  = 0;
                                $detalle['ordenes'][$i]['total_venta']   = 0;
                                $rut_cliente                             = $detalle['ordenes'][$i][0]['cliente_rut_cliente'];
                                $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i][0]['tramo_codigo_tramo']);
                                
                                $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                                $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden['id_orden']);
                                
                                $detalle['ordenes'][$i]['total_compra'] += $detalle['ordenes'][$i][0]['valor_costo_tramo'];
                                $detalle['ordenes'][$i]['total_venta']  += $detalle['ordenes'][$i][0]['valor_venta_tramo'];

                                $detalle['ordenes'][$i]['proveedor']     = $this->proveedores_model->datos_proveedor($detalle['ordenes'][$i][0]['proveedor_rut_proveedor']);
                                $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];                           
                                $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];


                                $servicios                               = $detalle['ordenes'][$i]['detalle'];

                                $j = 0;
                                foreach ( $servicios as $servicio) {

                                    $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                                    $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                                    $serv_odn_factura                                     = $this->facturacion_model->getServicioOrdenFactura($orden['id']);
                                    $proveedor                                            = $this->proveedores_model->datos_proveedor($serv_odn_factura[0]['proveedor_rut_proveedor']);
                                    
                                    $detalle['ordenes'][$i]['detalle'][$j]['factura']     = $serv_odn_factura[0]['factura_numero_factura'];
                                    $detalle['ordenes'][$i]['detalle'][$j]['fecha']       = $serv_odn_factura[0]['fecha_factura_servicio'];
                                    $detalle['ordenes'][$i]['total_compra']              += $servicio['valor_costo'];
                                    $detalle['ordenes'][$i]['total_venta']               += $servicio['valor_venta'];
                                    $detalle['ordenes'][$i]['detalle'][$j]['proveedor']   = $proveedor[0]['rut_proveedor'].' - '.$proveedor[0]['razon_social'];
                                    
                                    $j ++;
                                }

                                $i ++;
                    }
                            
                    $detalle['total_compra'] = number_format($detalle['total_compra'],0,'','.');
                    $detalle['total_venta']  = number_format($detalle['total_venta'],0,'','.');
                    $nombre_cliente          = $this->clientes_model->datos_cliente($rut_cliente);

                    $theHTMLResponse['clientes']     = 1;
                    $theHTMLResponse['html']         = $this->load->view('transaccion/ajax/detalles_ordenes_editar',$detalle,true); 
                    $theHTMLResponse['guia']         = $this->load->view('transaccion/ajax/guias_despacho',$data,true); 
                    $theHTMLResponse['total_compra'] = $detalle['total_compra'];
                    $theHTMLResponse['total_venta']  = $detalle['total_venta'];
                    $theHTMLResponse['cliente']      = $rut_cliente." - ".$nombre_cliente[0]['razon_social'];
                    $theHTMLResponse['factura']      = $factura[0];

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse)); 
            }

        }
        else
            redirect('home','refresh');
    }
    
    function modificar_facturacion(){
        
        if( $this->session->userdata('logged_in') ){
            $datos = $this->facturacion_model->datos_factura($this->input->post('factura_numero'));
            
            if($datos[0]['estado_factura_id_estado_factura'] == 2 ){

                if(isset($_POST['nula']))
                {
                        $ordenes_facts = $this->facturacion_model->getOrdenes($datos[0]['id']);

                        foreach($ordenes_facts as $orden_fact){
                            if(isset($orden_fact['id'])){
                                $this->facturacion_model->eliminarServiciosOrdeneFactura($orden_fact['id']);
                                $dato = array('id_estado_orden' => 1);
                                $this->orden_model->editar_orden($dato, $orden_fact['id_orden']);                        

                            }
                        }
                        
                        $this->facturacion_model->eliminarOrdenesFactura($datos[0]['id']);
                        $this->facturacion_model->eliminarFactura($datos[0]['id']);                        
                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));                    
                        $factura = array(
                                    'numero_factura'                   => $this->input->post('factura_numero'),
                                    'estado_factura_id_estado_factura' => 3,
                                    'fecha'                            => $fecha_factura                    
                                );

                        $this->facturacion_model->insertar_facturacion($factura);
                        $this->session->set_flashdata('mensaje','La Factura se ha anulado con éxito');
                        redirect('transacciones/facturacion/editar','refresh');                                            
                } 
                else
                {
                    $this->session->set_flashdata('mensaje','La factura que desea editar, ya se encuentra factura. Intente con otra.');
                    redirect('transacciones/facturacion/editar','refresh');
                }               
                
            }
            else{
                $this->load->library('form_validation');
                $this->form_validation->set_rules('factura_numero', 'Numero Factura','trim|required|xss_clean|numeric');
                $this->form_validation->set_rules('fecha_factura', 'Fecha de la Factura','trim|required|xss_clean');
                
                if(!isset($_POST['nula'])){
                    $this->form_validation->set_rules('total_venta', 'Valor Total Venta','trim|required|xss_clean');
                    $this->form_validation->set_rules('total_costo', 'Valor Total Costo','trim|required|xss_clean');
                    $this->form_validation->set_rules('cliente_factura', 'Cliente','trim|required|xss_clean');                                
                }

                if($this->form_validation->run() == FALSE){
                    $session_data = $this->session->userdata('logged_in');
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/facturacion/home');
                    $this->load->view('include/script');
                }
                else{
                    
                    $ordenes_facts = $this->facturacion_model->getOrdenes($datos[0]['id']);

                    foreach($ordenes_facts as $orden_fact){
                        if(isset($orden_fact['id'])){
                            $this->facturacion_model->eliminarServiciosOrdeneFactura($orden_fact['id']);
                            $dato = array('id_estado_orden' => 1);
                            $this->orden_model->editar_orden($dato, $orden_fact['id_orden']);                        

                        }
                    }
                    
                    $this->facturacion_model->eliminarOrdenesFactura($datos[0]['id']);
                    $this->facturacion_model->eliminarFactura($datos[0]['id']);
                    if(isset($_POST['nula'])){

                            $fecha_factura = $this->input->post('fecha_factura');
                            $fecha_factura = str_replace('/','-', $fecha_factura);
                            $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));                    
                            $factura = array(
                                        'numero_factura'                   => $this->input->post('factura_numero'),
                                        'estado_factura_id_estado_factura' => 3,
                                        'fecha'                            => $fecha_factura                    
                                    );

                            $this->facturacion_model->insertar_facturacion($factura);
                            $this->session->set_flashdata('mensaje','La Factura se ha anulado con éxito');
                            redirect('transacciones/facturacion/editar','refresh');                                            
                    }
                    else{
                            $session_data = $this->session->userdata('logged_in');
                            
                            $arreglo       = implode("|",$this->input->post('guia_despacho'));
                            $total_costo   = str_replace(".", "", $this->input->post('total_costo'));
                            $total_venta   = str_replace(".", "", $this->input->post('total_venta'));
                            $fecha_factura = $this->input->post('fecha_factura');
                            $fecha_factura = str_replace('/','-', $fecha_factura);
                            $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));

                            $factura = array(
                                        'numero_factura'                   => $this->input->post('factura_numero'),
                                        'estado_factura_id_estado_factura' => 1,
                                        'total_costo'                      => $total_costo,
                                        'total_venta'                      => $total_venta,
                                        'guia_despacho'                    => $arreglo,
                                        'fecha'                            => $fecha_factura                    
                                    );

                            $this->facturacion_model->insertar_facturacion($factura);
                            $catch_factura        = $this->facturacion_model->ultimo_numero();

                            $ordenes              = $this->input->post('id_orden');
                            $factura_tramo        = $this->input->post('factura_tramo');
                            $fecha_factura_tramo  = $this->input->post('fecha_factura_tramo');
                            $ordenes_detalle      = $this->input->post('id_orden_detalle');
                            $i = 0;
                            $k = 0; 
                            foreach ($ordenes as $orden) {

                                $fecha_factura_tramo[$i] = str_replace('/','-', $fecha_factura_tramo[$i]);
                                $fecha_factura_tramo[$i] = date("Y-m-d ",strtotime($fecha_factura_tramo[$i]));

                                $orden_factura = array(
                                        'factura_tramo' => $factura_tramo[$i],
                                        'fecha_factura' => $fecha_factura_tramo[$i],
                                        'id_factura'    => $catch_factura[0]['id'],
                                        'id_orden'      => $orden
                                    );
                                $i++;
                                
                                $this->facturacion_model->insertar_orden_facturacion($orden_factura);
                                
                                $dato = array('id_estado_orden' => 2);
                                $this->orden_model->editar_orden($dato, $orden);                            
                                
                                $id_orden_faturacion     = $this->facturacion_model->ultimo_id_orden_facturacion();
                                $fecha_otros_servicios   = $this->input->post('fecha_otros_servicios');
                                $factura_otros_servicios = $this->input->post('factura_otros_servicios');
                                $proveedor_servicio      = $this->input->post('proveedor_servicio');
                                $id_detalle              = $this->input->post('id_detalle');

                                $j = 0;
                                
                                if(isset($ordenes_detalle[0])){
                                        foreach ($ordenes_detalle as $orden_detalle) {
                                            if($orden == $orden_detalle ){
                                                $fecha_otros_servicios[$j] = str_replace('/','-', $fecha_otros_servicios[$j]);
                                                $fecha_otros_servicios[$j] = date("Y-m-d ",strtotime($fecha_otros_servicios[$j]));
                                                $prov                      = explode(" - ", $proveedor_servicio[$k]);

                                                $k++; 

                                                $servicios_orden_factura = array(
                                                            'detalle_id_detalle'     => $id_detalle[$j],
                                                            'factura_numero_factura' => $factura_otros_servicios[$j],
                                                            'proveedor_rut_proveedor'=> $prov[0],
                                                            'fecha_factura_servicio' => $fecha_otros_servicios[$j],
                                                            'id_ordenes_facturas'    => $id_orden_faturacion[0]['id']
                                                );
                                                $this->facturacion_model->insertar_servicios_orden_factura($servicios_orden_factura);
                                                $j++;   

                                            }

                                        }                        
                                }
                                  

                            }

                            $this->session->set_flashdata('mensaje','Factura editada con éxito');
                            redirect('transacciones/facturacion/editar','refresh');
                    }
                }                
            }
                
        }
        else{

            redirect('home','refresh');
        }
    }

    function editar()
    {
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/editar_factura');
            $this->load->view('include/script');
           
        }
        else{
            redirect('home','refresh');
        }        
    }

    function imprimir($numero = null){
        if($this->session->userdata('logged_in')){
            
            if($numero && $this->facturacion_model->existe_factura($numero)){
                $fact = $this->facturacion_model->factura_nula($numero);
                
                if( $fact[0]['estado_factura_id_estado_factura'] == 3 ){

                    $this->session->set_flashdata('mensaje','Las Facturas Nulas no generan impresión.');
                    redirect('transacciones/facturacion','refresh');
                }
                else{
                    $factura  = $this->facturacion_model->datos_factura($numero);
                    $ordenes  = $this->facturacion_model->getOrdenes($factura[0]['id']);

                    $fact_['estado_factura_id_estado_factura'] = 2;
                    $this->facturacion_model->modificar_facturacion($fact_,$numero);

                    $i = 0;

                            foreach ($ordenes as $orden) {
                                         
                                        $orden_temp                              = $this->orden_model->get_orden($orden['id_orden']);
                                        $detalle['ordenes'][$i]                  = $orden_temp[0];
                                        $rut_cliente                             = $detalle['ordenes'][$i]['cliente_rut_cliente'];
                                        $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i]['tramo_codigo_tramo']);
                                        
                                        $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                                        $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden['id_orden']);
                                        
                                        $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];                           
                                        $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];


                                        $servicios                               = $detalle['ordenes'][$i]['detalle'];

                                        $j = 0;
                                        foreach ( $servicios as $servicio) {

                                            $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                                            $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                                            $serv_odn_factura                                     = $this->facturacion_model->getServicioOrdenFactura($orden['id']);
                                            $detalle['ordenes'][$i]['detalle'][$j]['factura']     = $serv_odn_factura[0]['factura_numero_factura'];
                                            $detalle['ordenes'][$i]['detalle'][$j]['fecha']       = $serv_odn_factura[0]['fecha_factura_servicio'];
                                            
                                            
                                            $j ++;
                                        }
                                        
                                        $dato = array('id_estado_orden' => 2);
                                        $this->orden_model->editar_orden($dato, $orden['id_orden']);

                                        $i ++;
                            }
                    $nombre_cliente      = $this->clientes_model->datos_cliente($rut_cliente);     

                    $data['cliente']     = $nombre_cliente[0];       
                    $data['detalle']     = $detalle;        
                    $data['numero']      = $numero;
                    $data['factura']     = $factura;           
                    $session_data        = $this->session->userdata('logged_in');
                    
                    $this->load->view('transaccion/facturacion/factura',$data);                
                }
            }
            else{
                    $this->session->set_flashdata('mensaje','Intente con otra factura.');
                    redirect('transacciones/facturacion','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }        
    }
    
    function ordenes_servicios_ajax(){

        if($this->session->userdata('logged_in')){
            $data['ordenes'] = $this->orden_model->listar_ordenes();
        
            $this->load->view('transaccion/ajax/modal_ordenes',$data);
        }
        else
            redirect('home','refresh');
    }

    function detalles_ordenes_ajax(){
        if($this->session->userdata('logged_in')){
            
            $ordenes_ = $this->input->post('ordenes');
            $i = 0;

            foreach ($ordenes_ as $ordenes) {
                if($ordenes == ""){
                    unset($ordenes_[$i]);
                }
                $i++;
            }

            $cant = $this->facturacion_model->cant_clientes_orden($ordenes_);

            if($cant == 1){
                    $i = 0;

                    $detalle['total_venta']  = 0;
                    $detalle['total_compra'] = 0;
                    foreach ($ordenes_ as $orden) {


                        $detalle['ordenes'][$i]                  = $this->orden_model->get_orden($orden);
                        $detalle['ordenes'][$i]['total_compra']  = 0;
                        $detalle['ordenes'][$i]['total_venta']   = 0;
                        $rut_cliente                             = $detalle['ordenes'][$i][0]['cliente_rut_cliente'];
                        $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i][0]['tramo_codigo_tramo']);
                        
                        $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                        $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden);
                        $detalle['total_venta']                 += $detalle['ordenes'][$i][0]['valor_venta_tramo'];
                        $detalle['total_compra']                += $detalle['ordenes'][$i][0]['valor_costo_tramo'];
                        
                        $detalle['ordenes'][$i]['total_compra'] += $detalle['ordenes'][$i][0]['valor_costo_tramo'];
                        $detalle['ordenes'][$i]['total_venta']  += $detalle['ordenes'][$i][0]['valor_venta_tramo'];

                        $detalle['ordenes'][$i]['proveedor']     = $this->proveedores_model->datos_proveedor($detalle['ordenes'][$i][0]['proveedor_rut_proveedor']);
                        $servicios                               = $detalle['ordenes'][$i]['detalle'];

                        $j = 0;
                        foreach ( $servicios as $servicio) {

                            $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                            $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                            $detalle['total_venta']                              += $servicio['valor_venta'];
                            $detalle['total_compra']                             += $servicio['valor_costo'];
                            $detalle['ordenes'][$i]['total_compra']              += $servicio['valor_costo'];
                            $detalle['ordenes'][$i]['total_venta']               += $servicio['valor_venta'];
                            
                            $j ++;
                        }

                        $i ++;
                    }
                    
                    $detalle['total_compra'] = number_format($detalle['total_compra'],0,'','.');
                    $detalle['total_venta']  = number_format($detalle['total_venta'],0,'','.');
                    $nombre_cliente          = $this->clientes_model->datos_cliente($rut_cliente);

                    $theHTMLResponse['clientes']      = 1;
                    $theHTMLResponse['html'] = $this->load->view('transaccion/ajax/detalles_ordenes',$detalle,true);                     
                    $theHTMLResponse['total_compra']  = $detalle['total_compra'];
                    $theHTMLResponse['total_venta']   = $detalle['total_venta'];
                    $theHTMLResponse['cliente']       = $rut_cliente." - ".$nombre_cliente[0]['razon_social'];

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }
            else{
                    $theHTMLResponse['clientes']     = 0;
                    $theHTMLResponse['html']         = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Debe seleccionar ordenes con el mismo cliente</strong> </div>'; 
                    $theHTMLResponse['total_compra'] = "--";
                    $theHTMLResponse['total_venta']  = "--";

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }

        }
        else
            redirect('home','refresh');        
    }

    function proveedores_ajax(){
        if($this->session->userdata('logged_in')){
            $data['proveedores'] = $this->proveedores_model->listar_proveedores();
            $this->load->view('transaccion/ajax/proveedores',$data);
        }
        else
            redirect('home','refresh');
    }

    function facturas_ajax(){
        if($this->session->userdata('logged_in')){
            $facturas = $this->facturacion_model->listar_facturas();

            $i = 0;
            foreach ($facturas as $factura) {
                if($factura['estado_factura_id_estado_factura'] != 3){
                        
                        $ordenes = $this->facturacion_model->getOrdenes($factura['id']);
                        $orden   = $this->orden_model->get_orden($ordenes[0]['id_orden']);
                        $cliente = $this->clientes_model->datos_cliente($orden[0]['cliente_rut_cliente']);
                        $facturas[$i]['cliente'] = $cliente[0]['rut_cliente']." - ".$cliente[0]['razon_social'];
                                         
                }
                else{
                    $facturas[$i]['cliente'] = "--";
                }
                $i++;   
            }

            $data['facturas'] = $facturas;
            $this->load->view('transaccion/ajax/modal_facturas',$data);
        }
        else
            redirect('home','refresh');        
    }

    function check_database($numero_factura){
        $result = $this->facturacion_model->factura_repetida($numero_factura);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El número de factura que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    }

    function check_date($fecha){
        $fecha = explode(" ",$fecha);
        //$fecha = unset( $fecha[1] );
        $fecha = explode("-",$fecha[0]);

        if(isset($fecha[0]) && isset($fecha[1]) && isset($fecha[2])){
            if($fecha[0] > 0 && $fecha[0] < 32 && $fecha[1] > 0 && $fecha[1] < 13 &&  $fecha[2] > 2000 ){
                return true;
            }                        
            else{
                $this->form_validation->set_message('check_date','El formato de fecha para la factura que ingresa es incorrecto. Intente con otro.');
                return false;
            }
        }
        else{
            $this->form_validation->set_message('check_date','El formato de fecha para la factura que ingresa es incorrecto. Intente con otro.');
            return false;
        }
    }
}
?>
