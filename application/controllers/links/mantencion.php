<?php

class Mantencion extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    function clientes(){
        
        $this->load->view('include/head');
        $this->load->view('mantencion/clientes');
        $this->load->view('include/script');
        
    }
}

?>