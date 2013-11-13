<?php
class Naves extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Naves_model');
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
                   
            $session_data = $this->session->userdata('logged_in');
            $datos['navieras'] = $this->Naves_model->nombre_navieras();
            
           
            $data['tablas'] = $this->Naves_model->listar_naves();
            $resultado = $this->Naves_model->ultimo_codigo();
            
            if ($resultado[0]['codigo_nave'] == ""){
                  $data['codigo_nave'] = 1;
                          
              }
              else{
                  $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
              }
                       
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/naves',$data);
            $this->load->view('modal/modal_naves',$datos);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_nave(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre Nave','trim|required|xss_clean');
            $this->form_validation->set_rules('codigo_naviera', 'Codigo Naviera','numeric|trim|xss_clean|required|callback_check_unique');
           
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $datos['navieras'] = $this->Naves_model->nombre_navieras();
                                
                $resultado = $this->Naves_model->ultimo_codigo();
                $data['tablas'] = $this->Naves_model->listar_naves();
                if ($resultado[0]['codigo_nave'] == ""){
                    $data['codigo_nave'] = 1;
                          
                }
                else{
                    $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
                }
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('mantencion/naves',$data);
                    $this->load->view('modal/modal_naves',$datos);
                    $this->load->view('include/script');
                }
            else{
                
                                
                $nave = array(
                        'nombre' => $this->input->post('nombre'),
                        'naviera_codigo_naviera' => $this->input->post('codigo_naviera')
                        );
                $this->Naves_model->insertar_nave($nave);
                redirect('mantencion/naves','refresh');
 
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
    }
    
    function check_unique($naviera_codigo_naviera){
              
        $result = $this->Naves_model->existe($naviera_codigo_naviera);
                
        if($result){
            $this->form_validation->set_message('check_unique','El codigo de Naviera que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
            
        }
        /*print_r($codigo);
        $this->load->view('prueba');
         */
    }
}
?>
