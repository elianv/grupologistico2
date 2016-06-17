<?php

class Test extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/facturacion_model');

    }

    function index(){
    	$datosWS = $this->facturacion_model->manager("manager", "cabecera");
    	$this->load->library('Web_service');

    	$prueba = new Web_service();
    	$prueba->setDatos('16018542-2','29-02-2016 23:02',25,'OBSER');
echo "<br><pre>";
    	print_r(htmlentities($prueba->XmlHeader()));
echo "<br><br>";
    	print_r(htmlentities($prueba->XmlBody(100000)));
		$prueba->new_soap($datosWS[0]->url );

    	$prueba->mensaje($datosWS[0]->action, $prueba->XmlHeader());


    	echo "codigo :".print_r(htmlentities($prueba->getCodigo()));
    	echo "<br><br>";
    	print_r(htmlentities($prueba->getError()));
    }


}

?>