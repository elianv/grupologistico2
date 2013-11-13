<?php

class Cargas extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Cargas_model');
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            
              $session_data = $this->session->userdata('logged_in');
              
              $resultado = $this->Cargas_model->ultimo_codigo();
              $data['tablas'] = $this->Cargas_model->listar_cargas();
              
              if ($resultado[0]['codigo_carga'] == ""){
                  $data['form']['cod_carga'] = 1;
                 
                  //print_r($this->Navieras_model->ultimo_codigo());
              
              }
              else{
                  $data['form']['cod_carga'] = $resultado[0]['codigo_carga'] + 1;
                  //$data['cod_naviera'] = $this->Navieras_model->ultimo_codigo();
              }
                 
              
              $this->load->view('include/head',$session_data);
              $this->load->view('mantencion/cargas',$data);
              $this->load->view('include/script');
        }
        else{
            redirect('home','refresh');
        }
        
        
    }
    function guarda_carga(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $resultado = $this->Cargas_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_carga'] == ""){
                      $data['form']['cod_carga'] = 1;
                }
              
                else{
                      $data['form']['cod_carga'] = $resultado[0]['codigo_carga'] + 1;
                }
                $data['tablas'] = $this->Cargas_model->listar_cargas();             
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/cargas',$data);
                $this->load->view('include/script');
                
            }
            else{
                echo $this->input->post('descripcion');
                $datos = array(
                        'descripcion'=>$this->input->post('descripcion'),
                        );
            
                $this->Cargas_model->insertar_carga($datos);
                redirect('mantencion/cargas','refresh');
            }
            
            
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function borra_carga(){
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
