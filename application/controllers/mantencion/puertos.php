<?php
class Puertos extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Puertos_model');
    }
    
    function index(){
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $resultado = $this->Puertos_model->ultimo_codigo();
            $data['tablas'] = $this->Puertos_model->listar_puertos();
            
            if ($resultado[0]['codigo_puerto'] == ""){
                  $data['form']['codigo_puerto'] = 1;
                          
              }
              else{
                  $data['form']['codigo_puerto'] = $resultado[0]['codigo_puerto'] + 1;
                  
              }
            
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/puertos',$data);
            $this->load->view('include/script');
            
        }
        else{
            redirect('home','refresh');
        }
            
    }
    
    function insertar_puerto(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_puerto', 'Codigo Puerto','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('nombre','Nombre Puerto','trim|xss_clean|required|callback_check_database');
                    
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Puertos_model->ultimo_codigo();
                $data['tablas'] = $this->Puertos_model->listar_puertos();
                if ($resultado[0]['codigo_puerto'] == ""){
                    $data['form']['codigo_puerto'] = 1;
                          
                }
                else{
                    $data['form']['codigo_puerto'] = $resultado[0]['codigo_puerto'] + 1;
                }
            
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/puertos',$data);
                $this->load->view('include/script');
            }
            else{
                $puerto = array(
                            'nombre' => $this->input->post('nombre')
                        );
                $this->Puertos_model->insertar_puerto($puerto);
                redirect('mantencion/puertos','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function modificar_puerto(){
        
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_puerto', 'Codigo Puerto','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('nombre','Nombre Puerto','trim|xss_clean|required|callback_check_database');
                    
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Puertos_model->ultimo_codigo();
                $data['tablas'] = $this->Puertos_model->listar_puertos();
                if ($resultado[0]['codigo_puerto'] == ""){
                    $data['form']['codigo_puerto'] = 1;
                          
                }
                else{
                    $data['form']['codigo_puerto'] = $resultado[0]['codigo_puerto'] + 1;
                }
            
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/puertos',$data);
                $this->load->view('include/script');
            }
            else{
                $puerto = array(
                            'nombre' => $this->input->post('nombre')
                        );
                $codigo_puerto = $this->input->post('codigo_puerto');
                
                $this->Puertos_model->modificar_puerto($puerto,$codigo_puerto);
                redirect('mantencion/puertos','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function check_database($nombre){
        $result = $this->Puertos_model->nombre_repetido($nombre);
        
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