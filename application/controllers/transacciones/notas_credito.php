<?php
class notas_credito extends CI_Controller{

    public $data;

    function __construct() {
        
        parent::__construct();
        $this->load->library('Data_tables');
        $this->data = new Data_tables();
        $this->load->model('transacciones/notas_credito_model');

    }

    function index(){
        	
        if($this->session->userdata('logged_in')){    
            $session_data = $this->session->userdata('logged_in');

            $params = array('titulos'   => array('Numero','Rut Cliente','Razon social','Monto','Factura','Codigo sistema','Fecha'),
                            'titulo'    => 'Notas de crédito',
                            'clase'     => 'ncredito',
                            'ajax'      => 'notas_credito/listar_ajax',
                            'botones'   => null
                            );

        	$this->data->setData($params);

            $view['content'] = $this->data->render();

            $this->load->view('include/head',$session_data);
            $this->load->view('obj/blank',$view);
            $this->load->view('include/script');
            //echo "<pre>".print_r($params,true)."</pre>";
        	
           
        }
        else{
            redirect('home','refresh');
        }
    }

    function listar_ajax(){
        if($this->session->userdata('logged_in')){

            $datos = $this->data->dTables_ajax('transacciones','notas_credito_model','getData',$_GET);
            echo json_encode($datos);
        }
        else
            echo '{"ERROR":"ERROR"}';
    }
}
