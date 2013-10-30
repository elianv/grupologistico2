<?php

session_start();

class Main extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
                      
            $data['nombre'] = $session_data['nombre'];
            
            $this->load->view('include/head',$data);
            $this->load->view('home_view', $data);
            $this->load->view('include/script', $data);
            
            
        }
        
        else{
            
            redirect('home','refresh');
            
        }
    }        
        function logout(){
            
            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect('main','refresh');
            
        }
}

?>

