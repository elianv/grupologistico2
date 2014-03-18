<?php

class Home extends CI_Controller{
    /*
     * funcion que llama a la vista con  formulario de login
     * 
     */
    public function index(){
        
        $this->load->helper(array('form'));
        $this->load->view('login');
        
    }   
    
}

?>
