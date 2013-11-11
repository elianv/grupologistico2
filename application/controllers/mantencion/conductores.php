<?php

class Conductores extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Conductores_model');
    }
    
    function index(){
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['tablas'] = $this->Conductores_model->listar_conductores();
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/conductores',$data);
            $this->load->view('include/script');
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function guardar_conductor(){
        
        if($this->session->userdata('logged_in')){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]|callback_check_database');
            $this->form_validation->set_rules('contacto', 'Contacto', 'trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $data['tablas'] = $this->Conductores_model->listar_conductores();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/conductores',$data);
                $this->load->view('include/script');
            }
        
            else{
                $conductor = array(
                            'rut' => $this->input->post('rut'),
                            'contacto' => $this->input->post('contacto')
                            );
                
                $this->Conductores_model->insertar_conductor($conductor);
                redirect('mantencion/conductores','refresh');
            }
        }
        else{
            redirect('home',refresh);
        }
            
    }
    
    function check_database($rut){
        
        $result = $this->Conductores_model->repetido($rut);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El RUT que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
        
    }
}

?>