<?php

class Clientes extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/facturacion');
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['tfacturacion'] = $this->facturacion->GetTipo();
            // print_r($data);
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
            echo "Cliente Borrado";
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/clientes');
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_cliente(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            echo "Cliente Guardado";
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/clientes');
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
}

?>
