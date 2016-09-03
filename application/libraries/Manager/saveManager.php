<?

/**
* 
*/
class saveManager 
{
	
	var $datosWS;
	var $DetalleOS;
	var $actualizar;
	var $observaciones;
	var $WS;


	function __construct($ordenes)
	{
		$CI =& get_instance();
		$CI->load->model('facturacion_model');
		$CI->load->model('servicios_model');
		$CI->load->model('orden_model');
		$CI->load->model('naves_model');
		$CI->load->model('tramos_model');
		$CI->load->library('Web_service');
		
		//$CI->your_library->do_something(); 

        $this->datosWS       = $this->facturacion_model->manager("manager" , "cabecera");
        $this->DetalleOS     = $this->facturacion_model->manager("manager" , "detalle");
        $this->actualizar    = $this->facturacion_model->manager("manager" , "cabeceraactualizar");		
        $this->WS 			 = new Web_service();
        $this->observaciones = '';
	}

	function header($orden){
		$this->WS->new_soap($this->datosWS[0]->url );
		$codSalida = 0;

			
			$this->WS->setDatos($fOrdenes[0]['cliente_rut_cliente'],$fOrdenes[0]['fecha'],$orden,'');
            $this->WS->codWS = 100;
            $this->WS->mensaje($this->datosWS[0]->action, $this->WS->XmlHeader());

			if($WS->getCodigo != 0){
				$codSalida = 1;
	            
	            $detalle[$key]['ok']['cabecera']['codigo'] = $this->WS->getCodigo();
    	        $detalle[$key]['ok']['cabecera']['error']  = $this->WS->getError();
			}
			else{
	            $detalle[$key]['error']['cabecera']['codigo'] = $this->WS->getCodigo();
    	        $detalle[$key]['error']['cabecera']['error']  = $this->WS->getError();
			}
			
			$salida = array ($detalle, $codSalida);

			return $salida;
	}

	function detalle($orden_){


		$fOrdenes = $CI->facturacion_model->getFacturaOrden($orden_);

		foreach ($fOrdenes as $f_ord) {
			$orden            = $CI->orden_model->get_orden($f_ord['id_orden']);
            $detalle_servicio = $CI->orden_model->getDetalleByOrdenId($f_ord['id_orden']);
            $nave             = $CI->naves_model->datos_nave($orden[0]['nave_codigo_nave']);
            //print_r($f_ord);
            
            if($orden[0]['tramo_codigo_tramo'] > 0)
                $tramo_ = $CI->tramos_model->datos_tramo($orden[0]['tramo_codigo_tramo']);

            switch ($orden[0]['tipo_orden_id_tipo_orden']) {
                case 5:
                    $T_ORDEN = 'EXPORTACION';
                    break;
                case 6:
                    $T_ORDEN = 'IMPORTACION';
                    break;
                case 7:
                    $T_ORDEN = 'NACIONAL';
                    break;                                            
                case 8:
                    $T_ORDEN = 'OTRO SERVICIO';
                    break;                                            
                default:
                    $T_ORDEN = '';
                    break;
            }

            $this->observaciones .= 'TIPO '.$T_ORDEN."^ \n";
            $this->observaciones .= 'MN '.$nave[0]['nombre']."^ \n";
            if($orden[0]['tramo_codigo_tramo'] > 0)
                $this->observaciones .= 'TRAMO '.str_replace("\n", " ", $tramo_[0]['descripcion'])."^ \n";
            $this->observaciones .= 'REF.1 : '.$orden[0]['referencia']."^ \n";
            $orden[0]['referencia_2'] != '' ? $this->observaciones .= 'REF.2 : '.$orden[0]['referencia_2']."^ \n" : $this->observaciones .="^\n";
            $this->observaciones .= 'UNIDAD : '.$orden[0]['numero']."^ \n";
            $this->observaciones .= "^ \n";
            $this->observaciones .= "^ \n";
            $this->observaciones .= "^ \n";
            $this->observaciones .= "^ \n";
            $this->observaciones .= 'OS/'.$f_ord['id_orden']."^ \n"; 

            if($orden[0]['tramo_codigo_tramo'] > 0)
            {

                $this->WS->setDatos($f_ord['cliente_rut_cliente'],$f_ord['fecha'],$orden_,$this->observaciones);
                $this->WS->mensaje( $this->DetalleOS[0]->action, $this->WS->XmlBody($f_ord['valor_venta_tramo'] , $f_ord['id_codigo_sistema'] , $f_ord['cuenta_contable'] ));
                
                $detalle[$key]['detalle']['codigo'][] = $this->WS->getCodigo();
                $detalle[$key]['detalle']['error'][]  = $this->WS->getError();
                $valida_Error = $this->WS->getCodigo();                            
                           
            }
            foreach ($detalle_servicio as $det_servicio) {
                if($valida_Error == 0){

                    $serv_ = $CI->servicios_model->datos_servicio($det_servicio['servicio_codigo_servicio']);

                    $this->WS->mensaje( $this->DetalleOS[0]->action, $this->WS->XmlBody($det_servicio['valor_venta'], $serv_[0]['codigo_sistema'], $serv_[0]['cuenta_contable'] ) );
                    
                    $detalle[$key]['detalle']['codigo'][] = $this->WS->getCodigo();
                    $detalle[$key]['detalle']['error'][]  = $this->WS->getError(); 
                    $valida_Error = $this->WS->getCodigo();                                   
                }
            }            
		}
	}

	function actualizar($orden){
                        $this->WS->mensaje($this->actualizar[0]->action, $this->WS->ActualizarXmlHeader($this->observaciones));
                        $detalle[$key]['cabeceraactualizar']['codigo'][] = $this->WS->getCodigo();
                        $detalle[$key]['cabeceraactualizar']['error'][] = $this->WS->getError();
	}	
}
?>