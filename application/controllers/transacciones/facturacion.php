<?php
class Facturacion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/facturacion_model');
        $this->load->model('transacciones/orden_model');
        $this->load->model('utils/detalle');
        $this->load->model('mantencion/servicios_model');
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
            $this->load->view('transaccion/facturacion',$data);
            $this->load->view('include/script');
           
        }
        else{
            redirect('home','refresh');
        }
            
    }
    
    function insertar_facturacion(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('numero_factura', 'Numero Factura','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('orden_id_orden','Orden Id','trim|xss_clean|required|callback_check_database');
                    
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->facturacion_model->ultimo_numero();
                $data['tablas'] = $this->facturacion_model->listar_facturas();
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
                            'orden_id_orden' => $this->input->post('orden_id_orden'),
                            'estado_factura_id_estado_factura' => 1
                        );
                $this->facturacion_model->insertar_facturacion($factura);
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

    function orden_servicio_ajax(){
        if($this->session->userdata('logged_in')){
            
            $orden    = $this->orden_model->get_orden($this->input->post('id_orden'));
            $detalles = $this->detalle->detalle_orden($this->input->post('id_orden'));
            $valor    = $orden[0]['valor_venta_tramo'];          
            $html     = '<legend>Otros Servicios</legend>';

            foreach ($detalles as $detalle) {


                $otro_servicio = $this->servicios_model->datos_servicio($detalle['servicio_codigo_servicio']);
                $valor = $valor + $otro_servicio[0]['valor_venta'];

                $html .= '<div class="control-group">';
                $html .=    '<label class="control-label" for="rut"><strong>R.U.T Proveedor</strong></label>';
                $html .=    '<div class="controls">';
                $html .=        '<div class="input-append">';
                $html .=            '<input type="text" class="span2" id="rut" name="rut_proveedor_otro_servicio[]" value="">';
                $html .=            '<a class="btn" id="search_ordenes" onclick="ordenes_servicios();" data-target="#ordenServicio" data-toggle="modal"><i class="icon-search"></i></a>';
                $html .=        '</div>';
                $html .=    '</div>';
                $html .= '</div>';
                $html .= '<div class="control-group">';
                $html .= '<label class="control-label" for="rut"><strong>Otro Servicio</strong></label>';
                $html .= '<div class="controls">';
                $html .= '<input type="text" class="span3" id="rut" name="otro_servicio[]" value="'.$otro_servicio[0]['descripcion'].'">';
                $html .= '</div></div>'; 
            }

            $salida = array('html'        => $html,
                            'orden'       => $orden,
                            'valor_total' => $valor
                    );

            echo json_encode($salida);
            
            
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
