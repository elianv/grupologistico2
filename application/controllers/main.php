<?php

session_start();

class Main extends CI_Controller{

    function __construct() {
        /*
         * constructor
         */
        parent::__construct();
        error_reporting(E_ERROR);
    }

    function index(){

        /*
         * chequea si el usuario esta logueado, si esta, llama a las 3 vistas
         * para la creacion de la pagina
         *
         */

        if($this->session->userdata('logged_in')){

            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/script');
            $this->load->view('include/head',$session_data);
            $this->load->view('home_view');



        }

        else{

            /*si no esta logueado lo envia nuevamente al home
             *
             */
            redirect('home','refresh');

        }
    }
        function logout(){
            /*
             * Funcion para desloguear usuarios
             */

            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect('main','refresh');

        }
}

?>
