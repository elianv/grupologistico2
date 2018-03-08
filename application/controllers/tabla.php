<?php
 class Tabla extends CI_Controller
    {

        function index()
        {
         
        	echo "hola";

        }

        function test(){
        	$this->load->library('Data_tables');

            $params = array('titulos' => array('Numero','Cliente','Monto','Factura','Fecha'),
                            'titulo' => 'Notas de crédito',
                            'clase' => 'nCredito',

                            );
        	$data = new Data_tables($params);

            $view['content'] = $data->render();

            
            $session_data = $this->session->userdata('logged_in');
            //$session_data = '';

            $this->load->view('include/head',$session_data);
            $this->load->view('obj/blank',$view);
            $this->load->view('include/script');
        	
           $data->render();
        }
    }
?>
