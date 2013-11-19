<?php

class Depositos extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Depositos_model');
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            
              $session_data = $this->session->userdata('logged_in');
              
              $resultado = $this->Depositos_model->ultimo_codigo();
              $data['tablas'] = $this->Depositos_model->listar_depositos();
              
              if ($resultado[0]['codigo_deposito'] == ""){
                  $data['form']['cod_deposito'] = 1;
                 
                  //print_r($this->Navieras_model->ultimo_codigo());
              
              }
              else{
                  $data['form']['cod_deposito'] = $resultado[0]['codigo_deposito'] + 1;
                  //$data['cod_naviera'] = $this->Navieras_model->ultimo_codigo();
              }
                 
              
              $this->load->view('include/head',$session_data);
              $this->load->view('mantencion/depositos',$data);
              $this->load->view('include/script');
        }
        else{
            redirect('home','refresh');
        }
        
        
    }

    function guarda_deposito(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Depositos_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_deposito'] == ""){
                      $data['form']['cod_deposito'] = 1;
                }
              
                else{
                      $data['form']['cod_deposito'] = $resultado[0]['codigo_deposito'] + 1;
                }
                $data['tablas'] = $this->Depositos_model->listar_depositos();             
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/depositos',$data);
                $this->load->view('include/script');
                
            }
            else{
                
                $datos = array(
                        'descripcion'=>$this->input->post('descripcion'),
                        );
            
                $this->Depositos_model->insertar_deposito($datos);
                redirect('mantencion/depositos','refresh');
            }
            
            
        }
        else{
            redirect('home','refresh');
        }
    }

    function modifica_deposito(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Depositos_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_deposito'] == ""){
                      $data['form']['cod_deposito'] = 1;
                }
              
                else{
                      $data['form']['cod_deposito'] = $resultado[0]['codigo_deposito'] + 1;
                }
                $data['tablas'] = $this->Depositos_model->listar_depositos();             
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/depositos',$data);
                $this->load->view('include/script');
                
            }
            else{
                
                $datos = array(
                        'descripcion'=>$this->input->post('descripcion'),
                        );
            
                $codigo_deposito = $this->input->post('codigo_deposito');
                $this->Depositos_model->modificar_deposito($datos,$codigo_deposito);
                redirect('mantencion/depositos','refresh');
            }
            
            
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function borra_deposito(){
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
