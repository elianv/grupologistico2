<?php

class Agencias extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Agencias_model');
    }
    
    function index(){
             if($this->session->userdata('logged_in')){
                    
                 $session_data = $this->session->userdata('logged_in');
                 $resultado = $this->Agencias_model->ultimo_codigo();
                 
                 
                 if ($resultado[0]['codigo_aduana'] == ""){
                    $data['form']['codigo_aduana'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_aduana'] = $resultado[0]['codigo_aduana'] + 1;
                  
                 }
                 
                 $data['tablas'] = $this->Agencias_model->listar_agencias();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/agencias',$data);
                 $this->load->view('include/script');
                 
             }
             else{
                 redirect('home','refresh');
             }
                   
    }
    
    function guardar_aduana(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_aduana', 'Código Agencia','trim|xss_clean|numeric');
            $this->form_validation->set_rules('nombre', 'Nombre Agencia','trim|xss_clean|required');
           
            if($this->form_validation->run() == FALSE){ 
                
                    $session_data = $this->session->userdata('logged_in');
                    $resultado = $this->Agencias_model->ultimo_codigo();
                                     
                 if ($resultado[0]['codigo_aduana'] == ""){
                    $data['form']['codigo_aduana'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_aduana'] = $resultado[0]['codigo_aduana'] + 1;
                  
                 }
                 $data['tablas'] = $this->Agencias_model->listar_agencias();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/agencias',$data);
                 $this->load->view('include/script');
            }
            
            else{
                
                $agencia = array(
                                'nombre' => $this->input->post('nombre'),
                                'contacto' => $this->input->post('contacto'),
                                'telefono' => $this->input->post('telefono')
                            );
                            
                $this->Agencias_model->insertar_agencia($agencia);
                redirect('mantencion/agencias','refresh');
                
            }
        }
        else{
                 redirect('home','refresh');
             }
    }
}
?>