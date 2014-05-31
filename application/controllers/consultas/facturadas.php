<?php

    class Facturadas extends CI_Controller{
        
        function __construct() {
            parent::__construct();
            date_default_timezone_set('America/Santiago');
        }
                
        function index(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/facturadas');
                $this->load->view('include/script');
                $this->load->view('include/calendario');
                       
            }
            else{
                redirect('home','refresh');
            }
        }
        
        function generar(){
            if($this->session->userdata('logged_in')){
                $session_data = $this->session->userdata('logged_in');
                $this->load->view('include/head',$session_data);
                $this->load->view('consultas/facturadas');
                $this->load->view('include/script');
                $this->load->view('include/calendario');
                       
            }
            else{
                redirect('home','refresh');
            }
        }
        
    }

?>