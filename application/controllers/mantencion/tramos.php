<?php

class Trams extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/Moneda');
        $this->load->model('mantencion/Tramos_model');
        
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
                   
            $session_data = $this->session->userdata('logged_in');
            
            $data['tmoneda'] = $this->Moneda->GetTipo();
            $data['tablas'] = ($this->Tramos_model->listar_tramos());
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/tramos',$data);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
           
        
    }
    
    function borrar_tramo(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            

            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_tramo', 'codigo_tramo','trim|required|xss_clean|min_length[7]');
            
            if($this->form_validation->run() == FALSE){
                
                $data['tmoneda'] = $this->Moneda->GetTipo();
                $data['tablas'] = $this->Tramos_model->listar_tramos();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/tramos',$data);
                $this->load->view('include/script');
            }
            
            else{
            
            }
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_tramo(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de moneda para el formulario
            $data['tmoneda'] = $this->Moneda->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_tramo', 'Código Tramo','trim|required|xss_clean|min_length[7]|callback_check_database');
            $this->form_validation->set_rules('valor_costo', 'Valor Costo','numeric');
            $this->form_validation->set_rules('valor_venta', 'Valor Venta','numeric');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tmoneda'] = $this->Moneda->GetTipo();
                $data['tablas'] = $this->Tramos_model->listar_tramos();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/tramos',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'codigo_tramo' => $this->input->post('codigo_tramo'),
                                    'descripcion' => $this->input->post('descripcion'),
                                    'valor_costo' => $this->input->post('valor_costo'),
                                    'valor_venta' => $this->input->post('valor_venta'),
                                    'tipo_moneda_id_tipo_moneda' => ""
                                );
                $tmoneda = $this->Moneda->GetTipo();
                 
                foreach($tmoneda as $dato){
                    
                    if($dato['tipo_moneda'] == $this->input->post('tmoneda')){
                         $arreglo['tipo_moneda_id_tipo_moneda'] = $dato['id_tipo_moneda'];
                    }
                }

                $this->Tramos_model->insertar($arreglo);
                
                redirect('mantencion/tramos','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function check_database($rut){
        $codigo_tramo2 = $this->input->post('codigo_tramo');
        
        $result = $this->Tramos_model->repetido($codigo_tramo);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El Código que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
     
}

?>
