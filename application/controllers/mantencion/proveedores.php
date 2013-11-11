<?php

class Proveedores extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Proveedores_model');
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
                   
            $session_data = $this->session->userdata('logged_in');
            
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/proveedores',$data);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
           
        
    }
    
    function borrar_proveedor(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            
            if($this->form_validation->run() == FALSE){
                
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/proveedores',$data);
                $this->load->view('include/script');
            }
            
            else{
            
            }
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_proveedor(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            //inicializo la validacion de campos
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]|callback_check_database');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/proveedores',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'direccion' => $this->input->post('direccion'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_cliente' => $this->input->post('rut'),
                                    'fono' => $this->input->post('telefono'),
                                );
                }
                //print_r($arreglo);
                $this->Proveedores_model->insertar($arreglo);
                
                redirect('mantencion/proveedores','refresh');
                /*
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
                 
                 * 
                 */
                
                
            }
            
        else{
            redirect('home','refresh');
        }
        
    }
    
    function check_database($rut){
        $rut2 = $this->input->post('rut');
        
        $result = $this->Proveedores_model->repetido($rut);
        
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
