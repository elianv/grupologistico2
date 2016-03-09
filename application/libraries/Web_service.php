<?php

/**
* 
*/
class Web_service 
{
	
	private $fechaOS;
	private $Rut_empresa;
	private $rutCliente;
	private $codigoVendedor;
	private $numNota;
	private $cliente;
	private $codWS;

    private $errorH;
	public  $xml     = '';

	
	function __construct($rutcliente, fechaos, numnota)
	{
		$this->fechaOS    	  = date("d/m/Y",strtotime($fechaos));
		$this->rutCliente 	  = str_replace("." , "", $rutcliente);
		$this->rutEmpresa 	  = '76010628-3';
		$this->codigoVendedor = 'ADM';
		$this->numNota 		  = $numnota;

	}


	public function new_soap($url)
	{

		$this->load->library('lib/nusoap_base');

		$this->cliente = new nusoap_client($url , true);       
        $this->cliente->soap_defencoding = 'UTF-8';
        $this->cliente->decode_utf8 = false; 		
	}


	public function XmlHeader()
	{
        $xml =  '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ven="http://manager.cl/ventas/">
                   <soap:Header/>
                   <soap:Body>
                      <ven:IngresaCabeceraDeNotaDeVenta>
                         <!--Optional:-->
                         <ven:rutEmpresa>'.$this->rutEmpresa.'</ven:rutEmpresa>
                         <ven:numNota>'.$this->numNota.'</ven:numNota>
                         <!--Optional:-->
                         <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                         <!--Optional:-->
                         <ven:rutFacA>'.$this->rutEmpresa.'</ven:rutFacA>
                         <!--Optional:-->
                         <ven:rutCliente>'.$this->RUTcliente.'</ven:rutCliente>
                         <!--Optional:-->
                         <ven:codigoVendedor>'.$this->codigoVendedor.'</ven:codigoVendedor>
                         <!--Optional:-->
                         <ven:glosaPago>0</ven:glosaPago>
                         <!--Optional:-->
                         <ven:codigoSucursal>0</ven:codigoSucursal>
                         <!--Optional:-->
                         <ven:tipoVenta>0</ven:tipoVenta>
                         <!--Optional:-->
                         <ven:ocNum>1</ven:ocNum>
                         <!--Optional:-->
                         <ven:codigoMoneda>$</ven:codigoMoneda>
                         <ven:comision>0</ven:comision>
                         <ven:pagoA>0</ven:pagoA>
                         <ven:descuentoTipo>0</ven:descuentoTipo>
                         <ven:descuento>0</ven:descuento>
                         <ven:aprobado>0</ven:aprobado>
                         <ven:contratoArriendo>0</ven:contratoArriendo>
                         <!--Optional:-->
                         <ven:formaPago>Efectivo</ven:formaPago>
                         <!--Optional:-->
                         <ven:observacionesNv>XML</ven:observacionesNv>
                         <!--Optional:-->
                         <ven:observacionesFormaPago>Efectivo</ven:observacionesFormaPago>
                         <!--Optional:-->
                         <ven:observacionesGdv>0</ven:observacionesGdv>
                         <!--Optional:-->
                         <ven:observacionesFactura>0</ven:observacionesFactura>
                         <!--Optional:-->
                         <ven:atencionA>0</ven:atencionA>
                         <!--Optional:-->
                         <ven:obra>0</ven:obra>
                         <!--Optional:-->
                         <ven:codigoPersonal>'.$this->codigoVendedor.'</ven:codigoPersonal>
                      </ven:IngresaCabeceraDeNotaDeVenta>
                   </soap:Body>
                </soap:Envelope>
        ';	

        return $xml;
	}

	public function XmlBody($valor_venta)
	{
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ven="http://manager.cl/ventas/">
           <soapenv:Header/>
           <soapenv:Body>
              <ven:IngresaDetalleDeNotaDeVenta>
                 <!--Optional:-->
                <ven:rutEmpresa>'.$this->rutEmpresa.'</ven:rutEmpresa>
                <ven:numNota>'.$this->numNota.'</ven:numNota>
                <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                 <!--Optional:-->
                <ven:codigoProducto>1001</ven:codigoProducto>
                <ven:cantidad>1</ven:cantidad>
                <ven:precioUnitario>'.$valor_venta.'</ven:precioUnitario>
                <ven:cantidadDespachada>1</ven:cantidadDespachada>
                <ven:descuento>0</ven:descuento>
                 <!--Optional:-->
                <ven:codigoCtaCble>310101001</ven:codigoCtaCble>
                 <!--Optional:-->
                <ven:codigoCentroCosto>1001</ven:codigoCentroCosto>
                <ven:estado>0</ven:estado>
                 <!--Optional:-->
                <ven:codigoBodega>0</ven:codigoBodega>
                <ven:facturable>0</ven:facturable>
                <ven:despachable>0</ven:despachable>
                 <!--Optional:-->
                <ven:codigoPersonal>'.$this->codigoVendedor.'</ven:codigoPersonal>
              </ven:IngresaDetalleDeNotaDeVenta>
           </soapenv:Body>
        </soapenv:Envelope>
        '; 

        return $xml;  		
	}

	public function mensaje( $action , $xml )
	{
        $this->cliente->send( $xml , $action);
        
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML( $cliente->responseData );
        
        $XMLresults2     = $doc->getElementsByTagName("Mensaje");
        $XMLresults     = $doc->getElementsByTagName("Error");
        
        $this->codWS   = $XMLresults->item(0)->nodeValue;
        $this->errorH = '<strong>Mensaje Manager: <br>'.$XMLresults2->item(0)->nodeValue.'</strong><br>';		

	}	

	public function getCodigo()
	{
		return $this->codWS;
	}

	public function getError()
	{
		return $this->errorH;
	}


}

?>