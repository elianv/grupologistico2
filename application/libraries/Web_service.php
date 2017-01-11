<?php

/**
*
*/
class Web_service
{

	private $fechaOS;
	private $rutEmpresa;
	private $rutCliente;
	private $codigoVendedor;
	private $numNota;
    private $observaciones;
	private $clienteWS;
	private $codWS;
    private $codigo_sistema;
    private $cta_cble;
    private $error_h;
	public  $xml     = '';


	function __construct()
	{

	}

    public function setDatos($rutcliente, $fechaos, $numnota)
    {
        $this->fechaOS        = date("d/m/Y",strtotime($fechaos));
        $this->rutCliente     = str_replace("." , "", $rutcliente);
        $this->rutEmpresa     = '76010628-3';
        $this->codigoVendedor = 'ADM';
        $this->numNota        = $numnota;
        $this->error_h        = 'vacio';
        $this->codWS          = 'vacio';

    }

    public function setCodigos($codigo_sistema,$cta_cble){
        $this->$codigo_sistema  = $codigo_sistema;
        $this->$cta_cble        = $cta_cble;
    }

    public function getCodigos()
    {
        return 'codigo sistema: '.$this->codigo_sistema.'| cta toable: '.$this->cta_cble;
    }

	public function new_soap($url)
	{
        $CI =& get_instance();

		$CI->load->library('lib/nusoap_base');

		$this->clienteWS = new nusoap_client($url , true);
        $this->clienteWS->soap_defencoding = 'UTF-8';
        $this->clienteWS->decode_utf8 = false;
	}


	public function XmlHeader()
	{
        $xml =  '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ven="http://manager.cl/ventas/">
                   <soap:Header/>
                   <soap:Body>
                      <ven:IngresaCabeceraDeNotaDeVenta>
                         <!--Optional:-->
                         <ven:rutEmpresa>'.str_replace(" ", "", $this->rutEmpresa).'</ven:rutEmpresa>
                         <ven:numNota>'.str_replace(" ", "",$this->numNota).'</ven:numNota>
                         <!--Optional:-->
                         <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                         <!--Optional:-->
                         <ven:rutFacA>'.$this->rutCliente.'</ven:rutFacA>
                         <!--Optional:-->
                         <ven:rutCliente>'.$this->rutCliente.'</ven:rutCliente>
                         <!--Optional:-->
                         <ven:codigoVendedor>'.$this->codigoVendedor.'</ven:codigoVendedor>
                         <!--Optional:-->
                         <ven:glosaPago>2</ven:glosaPago>
                         <!--Optional:-->
                         <ven:codigoSucursal>1</ven:codigoSucursal>
                         <!--Optional:-->
                         <ven:tipoVenta>0</ven:tipoVenta>
                         <!--Optional:-->
                         <ven:ocNum>0</ven:ocNum>
                         <!--Optional:-->
                         <ven:codigoMoneda>$</ven:codigoMoneda>
                         <ven:comision>0</ven:comision>
                         <ven:pagoA>30</ven:pagoA>
                         <ven:descuentoTipo>1</ven:descuentoTipo>
                         <ven:descuento>0</ven:descuento>
                         <ven:aprobado>0</ven:aprobado>
                         <ven:contratoArriendo>0</ven:contratoArriendo>
                         <!--Optional:-->
                         <ven:formaPago>2</ven:formaPago>
                         <!--Optional:-->
                         <ven:observacionesNv>SIN OBSERVACIONES</ven:observacionesNv>
                         <!--Optional:-->
                         <ven:observacionesFormaPago>30 dias</ven:observacionesFormaPago>
                         <!--Optional:-->
                         <ven:observacionesGdv>0</ven:observacionesGdv>
                         <!--Optional:-->
                         <ven:observacionesFactura></ven:observacionesFactura>
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

	public function XmlBody($valor_venta, $codigo_sistema , $cta_cble)
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
                <ven:codigoProducto>'.$codigo_sistema.'</ven:codigoProducto>
                <ven:cantidad>1</ven:cantidad>
                <ven:precioUnitario>'.$valor_venta.'</ven:precioUnitario>
                <ven:cantidadDespachada>0</ven:cantidadDespachada>
                <ven:descuento>0</ven:descuento>
                 <!--Optional:-->
                <ven:codigoCtaCble>'.$cta_cble.'</ven:codigoCtaCble>
                 <!--Optional:-->
                <ven:codigoCentroCosto>'.$codigo_sistema.'</ven:codigoCentroCosto>
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

    public function eliminarXmlBody($item)
    {
        $xml =
            '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ven="http://manager.cl/ventas/">
                <soap:Header/>
                    <soap:Body>
                        <ven:EliminaDetalleDeNotaDeVenta>
                        <!--Optional:-->
                        <ven:rutEmpresa>'.str_replace(" ", "", $this->rutEmpresa).'</ven:rutEmpresa>
                        <ven:numNota>'.str_replace(" ", "",$this->numNota).'</ven:numNota>
                        <!--Optional:-->
                        <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                        <ven:item>'.$item.'</ven:item>
                        </ven:EliminaDetalleDeNotaDeVenta>
                    </soap:Body>
                </soap:Envelope>';

        return $xml;
    }

    public function eliminarXmlHeader()
    {
        $xml =  '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ven="http://manager.cl/ventas/">
                           <soap:Header/>
                           <soap:Body>
                              <ven:EliminaCabeceraDeNotaDeVenta>
                                 <!--Optional:-->
                                 <ven:rutEmpresa>'.str_replace(" ", "", $this->rutEmpresa).'</ven:rutEmpresa>
                                 <ven:numNota>'.str_replace(" ", "",$this->numNota).'</ven:numNota>
                                 <!--Optional:-->
                                 <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                              </ven:EliminaCabeceraDeNotaDeVenta>
                           </soap:Body>
                        </soap:Envelope>';
        return $xml;
    }

    public function ActualizarXmlHeader($observaciones)
    {
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ven="http://manager.cl/ventas/">
                   <soapenv:Header/>
                   <soapenv:Body>
                      <ven:ActualizaCabeceraDeNotaDeVenta>
                         <!--Optional:-->
                         <ven:rutEmpresa>'.$this->rutEmpresa.'</ven:rutEmpresa>
                         <ven:numNota>'.$this->numNota.'</ven:numNota>
                         <!--Optional:-->
                         <ven:fecha>'.$this->fechaOS.'</ven:fecha>
                         <!--Optional:-->
                         <ven:rutFacA>'.$this->rutCliente.'</ven:rutFacA>
                         <!--Optional:-->
                         <ven:rutCliente>'.$this->rutCliente.'</ven:rutCliente>
                         <!--Optional:-->
                         <ven:codigoVendedor>'.$this->codigoVendedor.'</ven:codigoVendedor>
                         <!--Optional:-->
                         <ven:glosaPago>2</ven:glosaPago>
                         <!--Optional:-->
                         <ven:codigoSucursal>1</ven:codigoSucursal>
                         <!--Optional:-->
                         <ven:tipoVenta>0</ven:tipoVenta>
                         <!--Optional:-->

                         <!--Optional:-->
                         <ven:codigoMoneda>$</ven:codigoMoneda>
                         <ven:comision>0</ven:comision>
                         <ven:pagoA>30</ven:pagoA>
                         <ven:descuentoTipo>1</ven:descuentoTipo>
                         <ven:descuento>0</ven:descuento>
                         <ven:aprobado>0</ven:aprobado>
                         <ven:contratoArriendo>0</ven:contratoArriendo>
                         <!--Optional:-->
                         <ven:formaPago>2</ven:formaPago>
                         <!--Optional:-->
                         <ven:observacionesNv>0</ven:observacionesNv>
                         <!--Optional:-->
                         <ven:observacionesFormaPago>30</ven:observacionesFormaPago>
                         <!--Optional:-->
                         <ven:observacionesGdv>0</ven:observacionesGdv>
                         <!--Optional:-->
                         <ven:observacionesFactura>'.$observaciones.'</ven:observacionesFactura>
                         <!--Optional:-->
                         <ven:atencionA>0</ven:atencionA>
                         <!--Optional:-->
                         <ven:obra>0</ven:obra>
                         <!--Optional:-->
                         <ven:codigoPersonal>ADM</ven:codigoPersonal>
                      </ven:ActualizaCabeceraDeNotaDeVenta>
                   </soapenv:Body>
                </soapenv:Envelope>';

        return $xml;
    }

	public function mensaje( $action , $xml , $opc=0 )
	{

        $this->clienteWS->send( $xml , $action);

        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML( $this->clienteWS->responseData );

        //echo 'REQUEST<br>'.$this->clienteWS->request.'<br> ---------- <br>';
        //echo 'RESPONSE<br>'.$this->clienteWS->getDebug().'<br> ---------- <br>';
        //echo 'RESPONSE<br>'.$this->clienteWS->response.'<br> ---------- <br>';
        $XMLresults2     = $doc->getElementsByTagName("Mensaje");
        $XMLresults      = $doc->getElementsByTagName("Error");
        //if ($opc)
            //print_r(htmlentities($this->clienteWS->responseData));

        $this->codWS   = (int)$XMLresults->item(0)->nodeValue;
        $this->error_h = '<strong>Mensaje Manager: <br>'.$XMLresults2->item(0)->nodeValue.'</strong><br>';

	}

	public function getCodigo()
	{
		return $this->codWS;
        //return 0;
	}

	public function getError()
	{
		return $this->error_h;
	}


}
