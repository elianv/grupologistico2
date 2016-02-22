<?php
 class Tabla extends CI_Controller
    {
        
        function index()
        {
        	echo "<h1>Prueba</h1><pre>";
        	//$url = "http://wss.imanager.cl/manager/ws/erp_v2/ventas.asmx?";
        	$client = new SoapClient('http://wss.imanager.cl/manager/ws/erp_v2/ventas.asmx?WSDL',array('trace' => 1));


			$array =  array(
				'rutEmpresa' 		=> '76010628-3', 
				'numNota' 			=> '1234',
				'fecha' 			=> '10/02/2016',
				'rutFacA'			=> '76010628-3',
				'rutCliente'		=> '76115202-5',
				'codigoVendedor'	=> 'ADM',
				'glosaPago'			=> 'Efectivo',
				'codigoSucursal'	=> '0',
				'tipoVenta'			=> '0',
				'ocNum'				=> '0',
				'codidoMoneda'		=> '$',
				'comision'			=> 0,
				'pagoA'				=> 0,
				'descuentoTipo'		=> 0,
				'descuento'			=> 0,
				'aprobado'			=> 0,
				'contratoArriendo'	=> 0,
				'formaPago'			=> 'Efectivo',
				'observacionesNv'	=> 'Prueba',
				'observacionesFormaPago' => 'Prueba',
				'observacopmesGdv'	=> 'Prueba',
				'observacopmesFactura' => 'Prueba',
				'atencionA'			=> 'Prueba',
				'codigoPersonal'	=> 'ADM'
				);
			
			
			/*		    
		    $opts = array(
		        'http'=>array(
		            'user_agent' => 'PHPSoapClient'
		            )
		        );

		    $context = stream_context_create($opts);
		    $client = new SoapClient('http://wss.imanager.cl/manager/ws/erp_v2/ventas.asmx?WSDL',
		                             array('stream_context' => $context,
		                                   'cache_wsdl' => WSDL_CACHE_NONE,
		                                   'trace => 1'
		                                   ));
			*/
		    //print_r($client->__getFunctions());

		    $client->notaVentaCabeceraIngresar($array);
		    //$client->__call("notaVentaCabeceraIngresar", $datos);
		    //$client->IngresaCabeceraDeNotaDeVenta($array);


			print_r($array);
			echo "Response:\n" . htmlentities($client->__getLastResponse()) . "\n";
			echo "RESPONSE HEADERS:\n" . $client->__getLastResponseHeaders() . "\n";
			echo "\n ############## \n";
			echo "REQUEST HEADERS:\n" . $client->__getLastRequestHeaders() . "\n";
			echo "REQUEST:\n" . htmlentities($client->__getLastRequest()) . "\n";

			$doc = new DOMDocument('1.0', 'utf-8');
		    $doc->loadXML( $client->__getLastResponse() );
		    $XMLresults     = $doc->getElementsByTagName("Error");
		    $output = $XMLresults->item(0)->nodeValue;

		    $XMLresults2     = $doc->getElementsByTagName("Mensaje");
		    echo "Error N ".$output." Mensaje :".$XMLresults2->item(0)->nodeValue;;

		    

        }
    }
?>