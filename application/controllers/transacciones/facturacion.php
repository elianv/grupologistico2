<?php
class Facturacion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Facturacion_model');
        $this->load->model('transacciones/orden_model');
    }
    
    function index(){
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $resultado = $this->Facturacion_model->ultimo_numero();
            $data['tablas'] = $this->Facturacion_model->listar_facturas();
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
            $this->load->view('modal/modal_orden',$data);          
        }
        else{
            redirect('home','refresh');
        }
            
    }
    
    function insertar_facturacion(){
        
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
                $this->Facturacion_model->insertar_facturacion($factura);
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
                
                $this->Facturacion_model->modificar_facturacion($factura,$numero_factura);
				$this->session->set_flashdata('mensaje','Factura editada con éxito');
                redirect('transacciones/facturacion','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function check_database($numero_factura){
        $result = $this->Facturacion_model->factura_repetida($numero_factura);
        
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
