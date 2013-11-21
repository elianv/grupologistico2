<?php

class Camiones extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Camiones_model');
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['tablas'] = $this->Camiones_model->listar_camiones();
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/camiones',$data);
            $this->load->view('include/script');
        }
        else{
            redirect('home','refresh');
        }

    }
    
    function guardar_camion(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('patente', 'Patente','trim|required|xss_clean|callback_check_database|exact_length[6]');
            $this->form_validation->set_rules('telefono', 'Telefono Celular', 'trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $data['tablas'] = $this->Camiones_model->listar_camiones();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/camiones',$data);
                $this->load->view('include/script');
            }
            else{
                
                $camion = array(
                            'patente' => strtoupper($this->input->post('patente')),
                            'celular' => $this->input->post('telefono')
                            );
                
                $this->Camiones_model->insertar_camion($camion);
                redirect('mantencion/camiones','refresh');   
            }
            
        }
        else{
            redirect('home','refresh');
        }
    }
   
        function modificar_camion(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('patente', 'Patente','trim|required|xss_clean|exact_length[6]');
            $this->form_validation->set_rules('telefono', 'Telefono Celular', 'trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $data['tablas'] = $this->Camiones_model->listar_camiones();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/camiones',$data);
                $this->load->view('include/script');
            }
            else{
                
                $camion = array(
                            'patente' => strtoupper($this->input->post('patente')),
                            'celular' => $this->input->post('telefono')
                            );

                $patente = strtoupper($this->input->post('patente'));

                $this->Camiones_model->modificar_camion($camion,$patente);
                redirect('mantencion/camiones','refresh');   
            }
            
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function check_database($patente){
               
        $result = $this->Camiones_model->patente_repetida($patente);
        
        if($result){
            
            $this->form_validation->set_message('check_database','La Patetente que ingresa ya se encuentra en el sistema, intente con otra.');
            return false;
        }
        else{
            
            return true;
        }
    }
}
?>