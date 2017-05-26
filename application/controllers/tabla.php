<?php
 class Tabla extends CI_Controller
    {

        function index()
        {
          //phpinfo( );

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope
    xmlns:soap="http://www.w3.org/2003/05/soap-envelope"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <IngresaCabeceraDeNotaDeVentaResponse
            xmlns="http://manager.cl/ventas/">
            <IngresaCabeceraDeNotaDeVentaResult>
                <transaccionResult>
                    <Mensaje>Nota de venta grabada con \xc3\xa9xito:6975</Mensaje>
                    <Error>0</Error>
                </transaccionResult>
            </IngresaCabeceraDeNotaDeVentaResult>
        </IngresaCabeceraDeNotaDeVentaResponse>
    </soap:Body>
</soap:Envelope>';
$doc = new DOMDocument('1.0', 'utf-8');
$doc->loadXML( $xml );
$XMLresults2     = $doc->getElementsByTagName("Mensaje");
$XMLresults      = $doc->getElementsByTagName("Error");

print_r($XMLresults);
print_r($XMLresults2);

        }
    }
?>
