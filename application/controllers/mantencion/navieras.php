<?php

class Navieras extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Navieras_model');
        
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
              
              //if ($this->Navieras_model->ultimo_codigo() == 0){
                  $data['cod_naviera'] = 0;
                  print_r($this->Navieras_model->ultimo_codigo());
              /*    
              }
              else{
                  print_r($this->Navieras_model->ultimo_codigo());
              }
                 
               * 
               */ 
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
            
            $dato['nombre_naviera'] = $this->input->post('nombre_naviera'); 
            
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
