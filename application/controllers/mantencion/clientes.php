<?php

class Clientes extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/Facturacion');
        $this->load->model('mantencion/Clientes_model');
        
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
                   
            $session_data = $this->session->userdata('logged_in');
            
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/clientes',$data);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
           
        
    }
    
    function borrar_cliente(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/clientes',$data);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_cliente(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            //obtengo los tipo de facturacion para el formulario
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            //inicializo la validacion de campos
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            $this->form_validation->set_rules('dplazo', 'Días Plazo','numeric');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'contacto' => $this->input->post('contacto'),
                                    'direccion' => $this->input->post('direccion'),
                                    'dias_plazo' => $this->input->post('dplazo'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_cliente' => $this->input->post('rut'),
                                    'id_tipo_facturacion' => ""
                                );
                $tfacturas = $this->Facturacion->GetTipo();
                    
                foreach($tfacturas as $dato){
                    if($dato['tipo_facturacion'] == $this->input->post('tfactura')){
                         $arreglo['id_tipo_facturacion'] = $dato['id_tipo_facturacion'];
                    }
                }
                
                $this->Clientes_model->insertar($arreglo);
                
                redirect('mantencion/clientes','refresh');
                /*
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
                 
                */
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
}

?>
