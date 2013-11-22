<?php

class Facturacion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
            
    function index(){
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion');
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }
    }
}

?>
