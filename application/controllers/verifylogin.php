<?php

class VerifyLogin extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('user','',TRUE);
    }
    
    function index(){
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username','trim|required|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|required|xss_clean|callback_check_database');

        if($this->form_validation->run() == FALSE){
            
            $this->load->view('login_view');
            
        }
        else{
            
            redirect('main','refresh');
        }
            
        
    }
    
    function check_database($password){
        
        //Paso el usuario a traves de post
        $username = $this->input->post('username');
        
        //consulta a la bd
        $result = $this->user->login($username,$password);
        
        if($result){
            
            $sess_array = array();
            foreach ($result as $row){
                $sess_array = array(
                    'rut_usuario'=> $row->rut_usuario,
                    'nombre' => $row->nombre,
                );
                $this->session->set_userdata('logged_in', $sess_array);

            }
            
            return TRUE;
        }
        
        else{
         
            $this->form_validation->set_message('check_database','Rut o Clave incorrecta');
            return false;
        }
    }
            
        
        
    
}


?>
