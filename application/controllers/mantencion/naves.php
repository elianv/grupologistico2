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
            $data['naviera_codigo_naviera'] = '';
            $data['placeholder'] = '"Ingrese solo código"';
            
            $resultado = $this->Naves_model->ultimo_codigo();
            
            if ($resultado[0]['codigo_nave'] == ""){
                  $data['codigo_nave'] = 1;
                          
              }
              else{
                  $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
              }
                       
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/naves',$data);
            $this->load->view('include/modal_naves',$datos);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function seleccion_naviera(){
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $datos['navieras'] = $this->Naves_model->nombre_navieras();
            $data['placeholder'] = '0 ';
            
            $resultado = $this->Naves_model->ultimo_codigo();
            $codigo_nombre = explode('-',$this->input->post('multiselect'));
            $codigo_nombre[0] = str_replace('[', '', $codigo_nombre[0]);
            $codigo_nombre[0] = str_replace(']', '', $codigo_nombre[0]);
            
            $data['naviera_codigo_naviera'] = (integer)$codigo_nombre[0];
            
            if ($resultado[0]['codigo_nave'] == ""){
                  $data['codigo_nave'] = 1;
                          
              }
              else{
                  $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
              }
                       
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/naves',$data);
            $this->load->view('include/modal_naves',$datos);
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
            $this->form_validation->set_rules('naviera_codigo_naviera', 'Naviera','numeric|trim|xss_clean|required');
           
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $datos['navieras'] = $this->Naves_model->nombre_navieras();
                $data['naviera_codigo_naviera'] = "Inserte solo código";
            
                $resultado = $this->Naves_model->ultimo_codigo();
                
                if ($resultado[0]['codigo_nave'] == ""){
                    $data['codigo_nave'] = 1;
                          
                }
                else{
                    $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
                }
            
                    $this->load->view('include/head',$session_data);
                    $this->load->view('mantencion/naves',$data);
                    $this->load->view('include/modal_naves',$datos);
                    $this->load->view('include/script');
                }
            else{
                
                $naviera = explode('-', $this->input->post('naviera_codigo_naviera'));
                
                $nave = array(
                        'nombre' => $this->input->post('nombre'),
                        'naviera_codigo_naviera' => $naviera[0]
                        );
                $this->Naves_model->insertar_nave($nave);
                redirect('mantencion/naves','refresh');
                    
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
    }
}
?>
