<?php
class Facturacion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/facturacion_model');
        $this->load->model('transacciones/orden_model');
        $this->load->model('utils/Detalle');
        $this->load->model('mantencion/servicios_model');
        $this->load->model('mantencion/tramos_model');
    }
    
    function index(){
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $resultado = $this->facturacion_model->ultimo_numero();
            $data['tablas'] = $this->facturacion_model->listar_facturas();
            //listado clientes
            $data['ordenes'] = $this->orden_model->listar_ordenes();
            
            
            if ($resultado[0]['numero_factura'] == ""){
                  $data['form']['numero_factura'] = 1;
                          
              }
              else{
                  $data['form']['numero_factura'] = $resultado[0]['numero_factura'] + 1;
                  
              }
            
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/home',$data);
            $this->load->view('include/script');
           
        }
        else{
            redirect('home','refresh');
        }
            
    }
    
    function insertar_facturacion(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('factura_numero', 'Numero Factura','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('orden_id_orden','Orden Id','trim|xss_clean|required|callback_check_database');
                    
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->facturacion_model->ultimo_numero();
           //     $data['tablas'] = $this->facturacion_model->listar_facturas();
                if ($resultado[0]['numero_factura'] == ""){
                    $data['form']['numero_factura'] = 1;
                          
                }
                else{
                    $data['form']['numero_factura'] = $resultado[0]['numero_factura'] + 1;
                }
            
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/facturacion',$data);
                $this->load->view('include/script');
            }
            else{
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->facturacion_model->ultimo_numero();
           //     $data['tablas'] = $this->facturacion_model->listar_facturas();
                if ($resultado[0]['numero_factura'] == ""){
                    $data['form']['numero_factura'] = 1;
                          
                }
                else{
                    $data['form']['numero_factura'] = $resultado[0]['numero_factura'] + 1;
                }
                
                $arreglo = implode(",",'guia_despacho');
                $factura = array(
                            'numero_factura' => $this->input->post('factura_numero'),
                            'orden_id_orden' => $this->input->post('orden_id_orden'),
                            'estado_factura_id_estado_factura' => 1,
                            'valor_total' => $this->input->post('valor'),
                            'guia_despacho' => $arreglo                    
                        );
                $servicio_factura = array(
                            'factura_numero_factura' => $this->input->post('factura_numero'),
                            'proveedor_rut_proveedor' => $this->input->post('proveedor_rut_proveedor')           
                        );         
                $this->facturacion_model->insertar_facturacion($factura);
                $this->facturacion_model->insertar_servicio_facturacion($servicio_factura);
                $this->session->set_flashdata('mensaje','Facturación guardada con éxito');
                redirect('transacciones/facturacion','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function modificar_facturacion(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('numero_factura', 'Numero Factura','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('estado','Estado','trim|xss_clean|required|callback_check_database');
                    
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Facturacion_model->ultimo_numero();
                $data['tablas'] = $this->Facturacion_model->listar_facturas();
                if ($resultado[0]['numero_factura'] == ""){
                    $data['form']['numero_factura'] = 1;
                          
                }
                else{
                    $data['form']['numero_factura'] = $resultado[0]['numero_factura'] + 1;
                }
            
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/facturacion',$data);
                $this->load->view('include/script');
            }
            else{
                $factura = array(
                            'estado' => $this->input->post('estado')
                        );
                $numero_factura = $this->input->post('numero_factura');
                
                $this->facturacion_model->modificar_facturacion($factura,$numero_factura);
				$this->session->set_flashdata('mensaje','Factura editada con éxito');
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
            $i        = 0;

            $detalle['total_venta']  = 0;
            $detalle['total_compra'] = 0;
            foreach ($ordenes_ as $orden) {
                $detalle['ordenes'][$i]              = $this->orden_model->get_orden($orden);
                $tramo                               = $this->tramos_model->datos_tramo($detalle['ordenes'][$i][0]['tramo_codigo_tramo']);
                $detalle['ordenes'][$i]['tramo']     = $tramo[0];
                $detalle['ordenes'][$i]['detalle']   = $this->Detalle->detalle_orden($orden);
                $detalle['total_venta']             += $detalle['ordenes'][$i][0]['valor_venta_tramo'];
                $detalle['total_compra']            += $detalle['ordenes'][$i][0]['valor_costo_tramo'];

                $servicios                           = $detalle['ordenes'][$i]['detalle'];

                $j = 0;
                foreach ( $servicios as $servicio) {

                    $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                    $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                    $detalle['total_venta']                              += $servicio['valor_venta'];
                    $detalle['total_compra']                             += $servicio['valor_costo'];
                    
                    $j ++;
                }

                $i ++;
            }
            //print_r($detalle);

            $theHTMLResponse['html'] = $this->load->view('transaccion/ajax/detalles_ordenes',$detalle,true); 
            $theHTMLResponse['total_compra'] = $detalle['total_compra'];
            $theHTMLResponse['total_venta'] = $detalle['total_venta'];

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($theHTMLResponse));
        }
        else
            redirect('home','refresh');        
    }

    function check_database($numero_factura){
        $result = $this->facturacion_model->factura_repetida($numero_factura);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El Nombre que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
        
    }
}
?>
