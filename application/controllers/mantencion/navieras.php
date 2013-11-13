<?php

class Navieras extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Navieras_model');
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            
              $session_data = $this->session->userdata('logged_in');
              
              $resultado = $this->Navieras_model->ultimo_codigo();
              $data['tablas'] = $this->Navieras_model->listar_navieras();
              
              
              if ($resultado[0]['codigo_naviera'] == ""){
                  $data['form']['cod_naviera'] = 1;
                 
                  //print_r($this->Navieras_model->ultimo_codigo());
              
              }
              else{
                  $data['form']['cod_naviera'] = $resultado[0]['codigo_naviera'] + 1;
                  //$data['cod_naviera'] = $this->Navieras_model->ultimo_codigo();
              }
                 
              
              $this->load->view('include/head',$session_data);
              $this->load->view('mantencion/navieras',$data);
              $this->load->view('include/script');
        }
        else{
            redirect('home','refresh');
        }
        
        
    }
    function guarda_naviera(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre Naviera','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Navieras_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_naviera'] == ""){
                      $data['form']['cod_naviera'] = 1;
                }
              
                else{
                      $data['form']['cod_naviera'] = $resultado[0]['codigo_naviera'] + 1;
                }
                $data['tablas'] = $this->Navieras_model->listar_navieras();             
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/navieras',$data);
                $this->load->view('include/script');
                
            }
            else{
                
                $datos = array(
                        'nombre'=>$this->input->post('nombre'),
                        );
            
                $this->Navieras_model->insertar_naviera($datos);
                redirect('mantencion/navieras','refresh');
            }
            
            
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function borra_naviera(){
        if($this->session->userdata('logged_in')){
            
        }
        else{
            redirect('home','refresh');
        }
        
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
