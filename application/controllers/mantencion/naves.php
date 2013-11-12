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
            $data['placeholder'] = "Ingrese solo código";
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
            $data['placeholder'] = '0';
            $data['tablas'] = $this->Naves_model->listar_naves();
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
            $this->form_validation->set_rules('naviera_codigo_naviera', 'Naviera','numeric|trim|xss_clean|required|callback_check_unique');
           
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $datos['navieras'] = $this->Naves_model->nombre_navieras();
                $data['naviera_codigo_naviera'] = "";
                $data['placeholder'] ="Inserte solo código";
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
                    $this->load->view('include/modal_naves',$datos);
                    $this->load->view('include/script');
                }
            else{
                
                $caracter = "-";
                
                if(strpos($this->input->post('naviera_codigo_naviera'), $caracter)){
                    $naviera = explode('-', $this->input->post('naviera_codigo_naviera'));
                    $naviera[0] = str_replace('[', '', $naviera[0]);
                    $naviera[0] = str_replace(']', '', $naviera[0]);  
                }
                else{
                    $naviera[0]= $this->input->post('naviera_codigo_naviera');
                }
                  
                
                $nave = array(
                        'nombre' => $this->input->post('nombre'),
                        'naviera_codigo_naviera' => $naviera[0]
                        );
                $this->Naves_model->insertar_nave($nave);
                redirect('mantencion/naves','refresh');
                
                
                $this->load->view('prueba');    
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
    }
    
    function check_unique($naviera_codigo_naviera){
              
        $result = explode('-',$this->Naves_model->existe($naviera_codigo_naviera));
        $result[0] = str_replace('[', '', $result[0]);
        $result[0] = str_replace(']', '', $result[0]);
            
        $result[0] = (integer)$result[0];
        
        if($result){
            $this->form_validation->set_message('check_unique','El codigo de Naviera que ingresa no se encuentra en el sistema, intente con otro.');
            return 0;
        }
        else{
            
            return 1;
            
        }
        /*print_r($codigo);
        $this->load->view('prueba');
         */
    }
}
?>
