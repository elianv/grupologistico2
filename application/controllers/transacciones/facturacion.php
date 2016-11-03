<?php
class Facturacion extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/facturacion_model');
        $this->load->model('transacciones/orden_model');
        $this->load->model('utils/Detalle');
        $this->load->model('mantencion/servicios_model');
        $this->load->model('mantencion/tramos_model');
        $this->load->model('mantencion/proveedores_model');
        $this->load->model('mantencion/clientes_model');
        $this->load->model('mantencion/naves_model');
    }

    function index(){
        if($this->session->userdata('logged_in')){

            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/home');
            $this->load->view('include/script');

        }
        else{
            redirect('home','refresh');
        }
    }

    function insertar_facturacion(){

        if($this->session->userdata('logged_in')){

            $this->load->library('form_validation');

            if( $this->input->post('factura_papel') == 1){
                $this->form_validation->set_rules('factura_numero', 'Numero Factura','trim|required|xss_clean|numeric|callback_check_database');
            }

            $this->form_validation->set_rules('fecha_factura', 'Fecha de la Factura','trim|required|xss_clean');

            if(!isset($_POST['nula'])){
                $this->form_validation->set_rules('total_venta', 'Valor Total Venta','trim|required|xss_clean');
                $this->form_validation->set_rules('total_costo', 'Valor Total Costo','trim|required|xss_clean');
                $this->form_validation->set_rules('cliente_factura', 'Cliente','trim|required|xss_clean');
            }

            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/facturacion/home');
                $this->load->view('include/script');
            }
            else{
                if(isset($_POST['nula'])){

                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));
                        $factura = array(
                                    'numero_factura'                   => $this->input->post('factura_numero'),
                                    'estado_factura_id_estado_factura' => 3,
                                    'fecha'                            => $fecha_factura
                                );

                        $this->facturacion_model->insertar_facturacion($factura);
                        $this->session->set_flashdata('mensaje','Factura Nula guardada con éxito');
                        redirect('transacciones/facturacion','refresh');
                }
                else{
                        $session_data = $this->session->userdata('logged_in');

                        $arreglo       = implode("|",$this->input->post('guia_despacho'));
                        $total_costo   = str_replace(".", "", $this->input->post('total_costo'));
                        $total_venta   = str_replace(".", "", $this->input->post('total_venta'));
                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));

                        $factura = array(

                                    'estado_factura_id_estado_factura' => 1,
                                    'total_costo'                      => $total_costo,
                                    'total_venta'                      => $total_venta,
                                    'guia_despacho'                    => $arreglo,
                                    'fecha'                            => $fecha_factura

                                );

                        if(isset( $_POST['factura_papel'] ) )
                        {
                            $factura['numero_factura']  = $this->input->post('factura_numero');
                            $factura['tipo_factura_id'] = 1;
                        }
                        else
                            $factura['tipo_factura_id'] = 2;

                        $id_factura                    = $this->facturacion_model->insertar_facturacion($factura);
                        $catch_factura[0]['id']        = $id_factura;

                        $ordenes              = $this->input->post('id_orden');
                        $factura_tramo        = $this->input->post('factura_tramo');
                        $fecha_factura_tramo  = $this->input->post('fecha_factura_tramo');
                        $ordenes_detalle      = $this->input->post('id_orden_detalle');
                        $i = 0;
                        $k = 0;

                        foreach ($ordenes as $orden) {

                            $fecha_factura_tramo[$i] = str_replace('/','-', $fecha_factura_tramo[$i]);
                            $fecha_factura_tramo[$i] = date("Y-m-d ",strtotime($fecha_factura_tramo[$i]));

                            $orden_factura = array(
                                    'factura_tramo' => $factura_tramo[$i],
                                    'fecha_factura' => $fecha_factura_tramo[$i],
                                    'id_factura'    => $catch_factura[0]['id'],
                                    'id_orden'      => $orden
                                );
                            $i++;

                            $this->facturacion_model->insertar_orden_facturacion($orden_factura);
                            $dato = array('id_estado_orden' => 2);
                            $this->orden_model->editar_orden($dato, $orden);

                            $id_orden_faturacion     = $this->facturacion_model->ultimo_id_orden_facturacion();
                            $fecha_otros_servicios   = $this->input->post('fecha_otros_servicios');
                            $factura_otros_servicios = $this->input->post('factura_otros_servicios');
                            $proveedor_servicio      = $this->input->post('proveedor_servicio');
                            $id_detalle              = $this->input->post('id_detalle');

                            $j = 0;
                            if(isset($ordenes_detalle[0])){
                                    foreach ($ordenes_detalle as $orden_detalle) {
                                        if($orden == $orden_detalle ){
                                            $fecha_otros_servicios[$j] = str_replace('/','-', $fecha_otros_servicios[$j]);
                                            $fecha_otros_servicios[$j] = date("Y-m-d ",strtotime($fecha_otros_servicios[$j]));
                                            $prov                      = explode(" - ", $proveedor_servicio[$k]);
                                            $k++;

                                            $servicios_orden_factura = array(
                                                        'detalle_id_detalle'     => $id_detalle[$j],
                                                        'factura_numero_factura' => $factura_otros_servicios[$j],
                                                        'proveedor_rut_proveedor'=> $prov[0],
                                                        'fecha_factura_servicio' => $fecha_otros_servicios[$j],
                                                        'id_ordenes_facturas'    => $id_orden_faturacion[0]['id']
                                            );
                                            $this->facturacion_model->insertar_servicios_orden_factura($servicios_orden_factura);
                                            $j++;
                                        }

                                    }
                            }
                        }

                        if( $_POST['factura_papel'] == 0)
                        {
                            $this->load->library('lib/nusoap_base');

                            //Ingreso cabereca NOTA DE VENTA
                            $datosWS = $this->facturacion_model->manager("manager", "cabecera");

                            $cliente = new nusoap_client($datosWS[0]->url , true);
                            $cliente->soap_defencoding = 'UTF-8';
                            $cliente->decode_utf8 = false;

                            $fechaOS = date("d/m/Y",strtotime($fecha_factura));
                            $RUTcliente = explode(" - ", $this->input->post('cliente_factura'));
                            $flag1   = 0;
                            $flag2   = 0;
                            $errorH  = '<strong>Mensaje Manager: </strong>';
                            $errorB  = '<strong>Mensaje Manager: </strong>';
                            $observaciones = '';

                            $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ven="http://manager.cl/ventas/">
                                       <soap:Header/>
                                       <soap:Body>
                                          <ven:IngresaCabeceraDeNotaDeVenta>
                                             <!--Optional:-->
                                             <ven:rutEmpresa>76010628-3</ven:rutEmpresa>
                                             <ven:numNota>'.$catch_factura[0]["id"].'</ven:numNota>
                                             <!--Optional:-->
                                             <ven:fecha>'.$fechaOS.'</ven:fecha>
                                             <!--Optional:-->
                                             <ven:rutFacA>'.str_replace("." , "", $RUTcliente[0]).'</ven:rutFacA>
                                             <!--Optional:-->
                                             <ven:rutCliente>'.str_replace("." , "", $RUTcliente[0]).'</ven:rutCliente>
                                             <!--Optional:-->
                                             <ven:codigoVendedor>ADM</ven:codigoVendedor>
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
                                             <ven:observacionesFactura>0</ven:observacionesFactura>
                                             <!--Optional:-->
                                             <ven:atencionA>0</ven:atencionA>
                                             <!--Optional:-->
                                             <ven:obra>0</ven:obra>
                                             <!--Optional:-->
                                             <ven:codigoPersonal>ADM</ven:codigoPersonal>
                                          </ven:IngresaCabeceraDeNotaDeVenta>
                                       </soap:Body>
                                    </soap:Envelope>
                            ';
                            $cliente->send( $xml , $datosWS[0]->action);


                            $doc = new DOMDocument('1.0', 'utf-8');
                            $doc->loadXML( $cliente->responseData );

                            $XMLresults2     = $doc->getElementsByTagName("Mensaje");
                            $XMLresults     = $doc->getElementsByTagName("Error");

                            $codWS = $XMLresults->item(0)->nodeValue;
                            $errorH .= '<br><strong>'.$XMLresults2->item(0)->nodeValue.'</strong><br>';

                            if($codWS != '0' ){
                                $flag1 = 1;
                            }

                            //DETALLE NOTA DE VENTA
                            $DetalleOS          = $this->facturacion_model->manager("manager" , "detalle");
                            $ordenes_facturas   = $this->facturacion_model->getOrdenes($id_factura);

                            foreach ($ordenes_facturas as $o_facturas) {


                                    $orden            = $this->orden_model->get_orden($o_facturas['id_orden']);
                                    $detalle_servicio = $this->orden_model->getDetalleByOrdenId($orden[0]['id_orden']);
                                    $nave             = $this->naves_model->datos_nave($orden[0]['nave_codigo_nave']);


                                    if($orden[0]['tramo_codigo_tramo'] > 0)
                                        $tramo_ = $this->tramos_model->datos_tramo($orden[0]['tramo_codigo_tramo']);

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

                                    $observaciones .= 'TIPO '.$T_ORDEN."^ \n";
                                    $observaciones .= 'MN '.$nave[0]['nombre']."^ \n";
                                    if($orden[0]['tramo_codigo_tramo'] > 0)
                                        $observaciones .= 'TRAMO '.str_replace("\n", " ", $tramo_[0]['descripcion'])."^ \n";
                                    $observaciones .= 'REF.1 : '.$orden[0]['referencia']."^ \n";
                                    $orden[0]['referencia_2'] != '' ? $observaciones .= 'REF.2 : '.$orden[0]['referencia_2']."^ \n" : $observaciones .="^\n";
                                    $observaciones .= 'UNIDAD : '.$orden[0]['numero']."^ \n";
                                    $observaciones .= "^ \n";
                                    $observaciones .= "^ \n";
                                    $observaciones .= "^ \n";
                                    $observaciones .= "^ \n";
                                    $observaciones .= 'OS/'.$o_facturas['id_orden']."^ \n";

                                    if($orden[0]['tramo_codigo_tramo'] > 0)
                                    {
                                            $xml2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ven="http://manager.cl/ventas/">
                                               <soapenv:Header/>
                                               <soapenv:Body>
                                                  <ven:IngresaDetalleDeNotaDeVenta>
                                                     <!--Optional:-->
                                                    <ven:rutEmpresa>76010628-3</ven:rutEmpresa>
                                                    <ven:numNota>'.$catch_factura[0]["id"].'</ven:numNota>
                                                    <ven:fecha>'.$fechaOS.'</ven:fecha>
                                                     <!--Optional:-->
                                                    <ven:codigoProducto>1001</ven:codigoProducto>
                                                    <ven:cantidad>1</ven:cantidad>
                                                    <ven:precioUnitario>'.$orden[0]['valor_venta_tramo'].'</ven:precioUnitario>
                                                    <ven:cantidadDespachada>0</ven:cantidadDespachada>
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
                                                    <ven:fechaEntrega>'.$fechaOS.'</ven:fechaEntrega>
                                                     <!--Optional:-->
                                                    <ven:codigoPersonal>ADM</ven:codigoPersonal>
                                                  </ven:IngresaDetalleDeNotaDeVenta>
                                               </soapenv:Body>
                                            </soapenv:Envelope>
                                            ';
                                            $cliente->send( $xml2 , $DetalleOS[0]->action);

                                            $doc->loadXML( $cliente->responseData );

                                            $XMLresults2Detalle     = $doc->getElementsByTagName("Mensaje");
                                            $XMLresultsDetalle     = $doc->getElementsByTagName("Error");

                                            $codWS = $XMLresults->item(0)->nodeValue;
                                            if($codWS != '0' ){
                                                $flag2 ++;
                                                $errorB .= '<br><strong>'.$XMLresults2Detalle->item(0)->nodeValue.'</strong>';

                                            }
                                    }


                                    foreach ($detalle_servicio as $det_servicio) {


                                            $serv_ = $this->servicios_model->datos_servicio($det_servicio['servicio_codigo_servicio']);

                                            //$observacionesOS .= 'OS/'.$o_facturas['id_orden'].' - OTROS SERVICIOS - '.str_replace("\n", " ", $serv_[0]['descripcion'])."\n";

                                            $xml2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ven="http://manager.cl/ventas/">
                                               <soapenv:Header/>
                                               <soapenv:Body>
                                                  <ven:IngresaDetalleDeNotaDeVenta>
                                                     <!--Optional:-->
                                                    <ven:rutEmpresa>76010628-3</ven:rutEmpresa>
                                                    <ven:numNota>'.$catch_factura[0]["id"].'</ven:numNota>
                                                    <ven:fecha>'.$fechaOS.'</ven:fecha>
                                                     <!--Optional:-->
                                                    <ven:codigoProducto>'.$serv_[0]['codigo_sistema'].'</ven:codigoProducto>
                                                    <ven:cantidad>1</ven:cantidad>
                                                    <ven:precioUnitario>'.$det_servicio['valor_venta'].'</ven:precioUnitario>
                                                    <ven:cantidadDespachada>0</ven:cantidadDespachada>
                                                    <ven:descuento>0</ven:descuento>
                                                     <!--Optional:-->
                                                    <ven:codigoCtaCble>'.$serv_[0]['cuenta_contable'].'</ven:codigoCtaCble>
                                                     <!--Optional:-->
                                                    <ven:codigoCentroCosto>'.$serv_[0]['codigo_sistema'].'</ven:codigoCentroCosto>
                                                    <ven:estado>0</ven:estado>
                                                     <!--Optional:-->
                                                    <ven:codigoBodega>0</ven:codigoBodega>
                                                    <ven:facturable>0</ven:facturable>
                                                    <ven:despachable>0</ven:despachable>
                                                    <ven:fechaEntrega>'.$fechaOS.'</ven:fechaEntrega>
                                                     <!--Optional:-->
                                                    <ven:codigoPersonal>ADM</ven:codigoPersonal>
                                                  </ven:IngresaDetalleDeNotaDeVenta>
                                               </soapenv:Body>
                                            </soapenv:Envelope>
                                            ';

                                            $cliente->send( $xml2 , $DetalleOS[0]->action);

                                            $doc->loadXML( $cliente->responseData );

                                            $XMLresults2Detalle     = $doc->getElementsByTagName("Mensaje");
                                            $XMLresultsDetalle     = $doc->getElementsByTagName("Error");

                                            $codWS = $XMLresults->item(0)->nodeValue;
                                            if($codWS != '0' ){
                                                $flag2 ++;
                                                $errorB .= '<br><strong>'.$XMLresults2Detalle->item(0)->nodeValue.'</strong>';

                                            }
                                    }
                            }

                            //ACUTALIZO LA CABECERA PARA INGRESAR OBSERVACIONES

                            $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ven="http://manager.cl/ventas/">
                                       <soapenv:Header/>
                                       <soapenv:Body>
                                          <ven:ActualizaCabeceraDeNotaDeVenta>
                                             <!--Optional:-->
                                             <ven:rutEmpresa>76010628-3</ven:rutEmpresa>
                                             <ven:numNota>'.$catch_factura[0]["id"].'</ven:numNota>
                                             <!--Optional:-->
                                             <ven:fecha>'.$fechaOS.'</ven:fecha>
                                             <!--Optional:-->
                                             <ven:rutFacA>'.str_replace("." , "", $RUTcliente[0]).'</ven:rutFacA>
                                             <!--Optional:-->
                                             <ven:rutCliente>'.str_replace("." , "", $RUTcliente[0]).'</ven:rutCliente>
                                             <!--Optional:-->
                                             <ven:codigoVendedor>ADM</ven:codigoVendedor>
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
                                             <ven:observacionesNv>0</ven:observacionesNv>
                                             <!--Optional:-->
                                             <ven:observacionesFormaPago>30 dias</ven:observacionesFormaPago>
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
                            $actualizar = $this->facturacion_model->manager("manager" , "cabeceraactualizar");
                            $cliente->send( $xml , $actualizar[0]->action);

                            $doc = new DOMDocument('1.0', 'utf-8');
                            $doc->loadXML( $cliente->responseData );

                            $XMLresults2     = $doc->getElementsByTagName("Mensaje");
                            $XMLresults     = $doc->getElementsByTagName("Error");

                            $codWS = $XMLresults->item(0)->nodeValue;
                            $errorH .= '<br><strong>'.$XMLresults2->item(0)->nodeValue.'</strong><br>';

                            if($codWS != '0' ){
                                $flag1 = 1;
                            }

                            if( $flag1 || $flag2 )
                                if($flag1)
                                    $this->session->set_flashdata('mensaje','<strong>NO se cargo al ERP MANGER la OS N° '.$catch_factura[0]["id"].'</strong>.<br>ERROR ERP: '.$errorH.'<br>Facturación guardada con éxito en SCT.');
                                else
                                    $this->session->set_flashdata('mensaje','<strong>NO se cargo al ERP MANGER la OS N° '.$catch_factura[0]["id"].'</strong>.<br>ERROR ERP: '.$errorB.'<br>Facturación guardada con éxito en SCT.');
                            else
                                $this->session->set_flashdata('mensaje','<strong>Se cargo al ERP MANGER la OS N° '.$catch_factura[0]["id"].'</strong>.<br> Facturación guardada con éxito SCT.');
                        }

                        //$this->session->set_flashdata('mensaje','Facturación guardada con éxito SCT. <br><strong>NUMERO '.$catch_factura[0]["id"].'</strong>');
                        redirect('transacciones/facturacion','refresh');
                }
            }
        }
        else{
            redirect('home','refresh');
        }
    }

    function cargar_facturas(){
        if($this->session->userdata('logged_in')){
            $factura               = $this->facturacion_model->datos_factura($this->input->post('num_factura') , $this->input->post('os_manager'));

            if($factura[0]['estado_factura_id_estado_factura'] == 3){
                    $theHTMLResponse['clientes']     = 1;
                    $theHTMLResponse['html']         = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Factura Nula. Sin Ordenes de Servicio.</strong> </div>';
                    $theHTMLResponse['total_compra'] = "--";
                    $theHTMLResponse['total_venta']  = "--";
                    $theHTMLResponse['cliente']      = "--";
                    $theHTMLResponse['factura']      = $factura[0];


                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }
            else{
                    $data['guias_despacho'] = $factura[0]['guia_despacho'];
                    $ordenes  = $this->facturacion_model->getOrdenes($factura[0]['id']);

                    $i = 0;
                    $totales                 = $this->facturacion_model->valor_factura($this->input->post('os_manager'));

                    $detalle['total_venta']  = $totales[0]['total_venta'];
                    $detalle['total_compra'] = $totales[0]['total_costo'];

                    foreach ($ordenes as $orden) {


                                $detalle['ordenes'][$i]                  = $this->orden_model->get_orden($orden['id_orden']);
                                $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];
                                $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];
                                $detalle['ordenes'][$i]['total_compra']  = 0;
                                $detalle['ordenes'][$i]['total_venta']   = 0;
                                $rut_cliente                             = $detalle['ordenes'][$i][0]['cliente_rut_cliente'];
                                $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i][0]['tramo_codigo_tramo']);

                                $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                                $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden['id_orden']);

                                $detalle['ordenes'][$i]['total_compra'] += $detalle['ordenes'][$i][0]['valor_costo_tramo'];
                                $detalle['ordenes'][$i]['total_venta']  += $detalle['ordenes'][$i][0]['valor_venta_tramo'];

                                $detalle['ordenes'][$i]['proveedor']     = $this->proveedores_model->datos_proveedor($detalle['ordenes'][$i][0]['proveedor_rut_proveedor']);
                                $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];
                                $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];


                                $servicios                               = $detalle['ordenes'][$i]['detalle'];

                                $j = 0;


                                foreach ( $servicios as $servicio) {


                                    $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                                    $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                                    $serv_odn_factura                                     = $this->facturacion_model->getServicioOrdenFacturabydetalle($servicio['id_detalle']);
                                    $proveedor                                            = $this->proveedores_model->datos_proveedor($serv_odn_factura[0]['proveedor_rut_proveedor']);

                                    $detalle['ordenes'][$i]['detalle'][$j]['factura']     = $serv_odn_factura[0]['factura_numero_factura'];
                                    $detalle['ordenes'][$i]['detalle'][$j]['fecha']       = $serv_odn_factura[0]['fecha_factura_servicio'];

                                    $detalle['ordenes'][$i]['total_compra']              += $servicio['valor_costo'];
                                    $detalle['ordenes'][$i]['total_venta']               += $servicio['valor_venta'];
                                    $detalle['ordenes'][$i]['detalle'][$j]['proveedor']   = $proveedor[0]['rut_proveedor'].' - '.$proveedor[0]['razon_social'];

                                    $j ++;
                                }

                                $i ++;
                    }

                    $detalle['total_compra'] = number_format($detalle['total_compra'],0,'','.');
                    $detalle['total_venta']  = number_format($detalle['total_venta'],0,'','.');
                    $nombre_cliente          = $this->clientes_model->datos_cliente($rut_cliente);

                    $theHTMLResponse['clientes']     = 1;
                    $theHTMLResponse['html']         = $this->load->view('transaccion/ajax/detalles_ordenes_editar',$detalle,true);
                    $theHTMLResponse['guia']         = $this->load->view('transaccion/ajax/guias_despacho',$data,true);
                    $theHTMLResponse['total_compra'] = $detalle['total_compra'];
                    $theHTMLResponse['total_venta']  = $detalle['total_venta'];
                    $theHTMLResponse['cliente']      = $rut_cliente." - ".$nombre_cliente[0]['razon_social'];
                    $theHTMLResponse['factura']      = $factura[0];
                    $theHTMLResponse['factura']['os_manager']      = $factura[0]['id'];

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }

        }
        else
            redirect('home','refresh');
    }

    function modificar_facturacion(){

        if( $this->session->userdata('logged_in') ){
            $datos = $this->facturacion_model->datos_factura($this->input->post('factura_numero'));

            if($datos[0]['estado_factura_id_estado_factura'] == 2 ){

                if(isset($_POST['nula']))
                {
                        $ordenes_facts = $this->facturacion_model->getOrdenes($datos[0]['id']);

                        foreach($ordenes_facts as $orden_fact){
                            if(isset($orden_fact['id'])){
                                $this->facturacion_model->eliminarServiciosOrdeneFactura($orden_fact['id']);
                                $dato = array('id_estado_orden' => 1);
                                $this->orden_model->editar_orden($dato, $orden_fact['id_orden']);

                            }
                        }

                        $this->facturacion_model->eliminarOrdenesFactura($datos[0]['id']);
                        $this->facturacion_model->eliminarFactura($datos[0]['id']);
                        $fecha_factura = $this->input->post('fecha_factura');
                        $fecha_factura = str_replace('/','-', $fecha_factura);
                        $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));
                        $factura = array(
                                    'numero_factura'                   => $this->input->post('factura_numero'),
                                    'estado_factura_id_estado_factura' => 3,
                                    'fecha'                            => $fecha_factura
                                );

                        $this->facturacion_model->insertar_facturacion($factura);
                        $this->session->set_flashdata('mensaje','La Factura se ha anulado con éxito');
                        redirect('transacciones/facturacion/editar','refresh');
                }
                else
                {
                    $this->session->set_flashdata('mensaje','La factura que desea editar, ya se encuentra facturada. Intente con otra.');
                    redirect('transacciones/facturacion/editar','refresh');
                }

            }
            else{
                $this->load->library('form_validation');
                $this->form_validation->set_rules('factura_numero', 'Numero Factura','trim|required|xss_clean|numeric');
                $this->form_validation->set_rules('fecha_factura', 'Fecha de la Factura','trim|required|xss_clean');

                if(!isset($_POST['nula'])){
                    $this->form_validation->set_rules('total_venta', 'Valor Total Venta','trim|required|xss_clean');
                    $this->form_validation->set_rules('total_costo', 'Valor Total Costo','trim|required|xss_clean');
                    $this->form_validation->set_rules('cliente_factura', 'Cliente','trim|required|xss_clean');
                }

                if($this->form_validation->run() == FALSE){
                    $session_data = $this->session->userdata('logged_in');
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/facturacion/home');
                    $this->load->view('include/script');
                }
                else{

                    $ordenes_facts = $this->facturacion_model->getOrdenes($datos[0]['id']);

                    foreach($ordenes_facts as $orden_fact){
                        if(isset($orden_fact['id'])){
                            $this->facturacion_model->eliminarServiciosOrdeneFactura($orden_fact['id']);
                            $dato = array('id_estado_orden' => 1);
                            $this->orden_model->editar_orden($dato, $orden_fact['id_orden']);

                        }
                    }

                    $this->facturacion_model->eliminarOrdenesFactura($datos[0]['id']);
                    $this->facturacion_model->eliminarFactura($datos[0]['id']);
                    if(isset($_POST['nula'])){

                            $fecha_factura = $this->input->post('fecha_factura');
                            $fecha_factura = str_replace('/','-', $fecha_factura);
                            $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));
                            $factura = array(
                                        'numero_factura'                   => $this->input->post('factura_numero'),
                                        'estado_factura_id_estado_factura' => 3,
                                        'fecha'                            => $fecha_factura
                                    );

                            $this->facturacion_model->insertar_facturacion($factura);
                            $this->session->set_flashdata('mensaje','La Factura se ha anulado con éxito');
                            redirect('transacciones/facturacion/editar','refresh');
                    }
                    else{
                            $session_data = $this->session->userdata('logged_in');

                            $arreglo       = implode("|",$this->input->post('guia_despacho'));
                            $total_costo   = str_replace(".", "", $this->input->post('total_costo'));
                            $total_venta   = str_replace(".", "", $this->input->post('total_venta'));
                            $fecha_factura = $this->input->post('fecha_factura');
                            $fecha_factura = str_replace('/','-', $fecha_factura);
                            $fecha_factura = date("Y-m-d ",strtotime($fecha_factura));

                            $factura = array(
                                        'numero_factura'                   => $this->input->post('factura_numero'),
                                        'estado_factura_id_estado_factura' => 1,
                                        'total_costo'                      => $total_costo,
                                        'total_venta'                      => $total_venta,
                                        'guia_despacho'                    => $arreglo,
                                        'fecha'                            => $fecha_factura
                                    );

                            $this->facturacion_model->insertar_facturacion($factura);
                            $catch_factura        = $this->facturacion_model->ultimo_numero();

                            $ordenes              = $this->input->post('id_orden');
                            $factura_tramo        = $this->input->post('factura_tramo');
                            $fecha_factura_tramo  = $this->input->post('fecha_factura_tramo');
                            $ordenes_detalle      = $this->input->post('id_orden_detalle');
                            $i = 0;
                            $k = 0;
                            foreach ($ordenes as $orden) {

                                $fecha_factura_tramo[$i] = str_replace('/','-', $fecha_factura_tramo[$i]);
                                $fecha_factura_tramo[$i] = date("Y-m-d ",strtotime($fecha_factura_tramo[$i]));

                                $orden_factura = array(
                                        'factura_tramo' => $factura_tramo[$i],
                                        'fecha_factura' => $fecha_factura_tramo[$i],
                                        'id_factura'    => $catch_factura[0]['id'],
                                        'id_orden'      => $orden
                                    );
                                $i++;

                                $this->facturacion_model->insertar_orden_facturacion($orden_factura);

                                $dato = array('id_estado_orden' => 2);
                                $this->orden_model->editar_orden($dato, $orden);

                                $id_orden_faturacion     = $this->facturacion_model->ultimo_id_orden_facturacion();
                                $fecha_otros_servicios   = $this->input->post('fecha_otros_servicios');
                                $factura_otros_servicios = $this->input->post('factura_otros_servicios');
                                $proveedor_servicio      = $this->input->post('proveedor_servicio');
                                $id_detalle              = $this->input->post('id_detalle');

                                $j = 0;

                                if(isset($ordenes_detalle[0])){
                                        foreach ($ordenes_detalle as $orden_detalle) {
                                            if($orden == $orden_detalle ){
                                                $fecha_otros_servicios[$j] = str_replace('/','-', $fecha_otros_servicios[$j]);
                                                $fecha_otros_servicios[$j] = date("Y-m-d ",strtotime($fecha_otros_servicios[$j]));
                                                $prov                      = explode(" - ", $proveedor_servicio[$k]);

                                                $k++;

                                                $servicios_orden_factura = array(
                                                            'detalle_id_detalle'     => $id_detalle[$j],
                                                            'factura_numero_factura' => $factura_otros_servicios[$j],
                                                            'proveedor_rut_proveedor'=> $prov[0],
                                                            'fecha_factura_servicio' => $fecha_otros_servicios[$j],
                                                            'id_ordenes_facturas'    => $id_orden_faturacion[0]['id']
                                                );
                                                $this->facturacion_model->insertar_servicios_orden_factura($servicios_orden_factura);
                                                $j++;

                                            }

                                        }
                                }


                            }

                            $this->session->set_flashdata('mensaje','Factura editada con éxito');
                            redirect('transacciones/facturacion/editar','refresh');
                    }
                }
            }

        }
        else{

            redirect('home','refresh');
        }
    }

    function editar(){
        if($this->session->userdata('logged_in')){

            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/editar_factura');
            $this->load->view('include/script');

        }
        else{
            redirect('home','refresh');
        }
    }

    public function realizadas(){
        if($this->session->userdata('logged_in')){

            $session_data   = $this->session->userdata('logged_in');
            $data['tipo']   = 0;

            if ( isset($_POST['salida']) )
            {

                $time   = $this->input->post('time');

                $this->load->library('form_validation');
                $this->form_validation->set_rules('salida', 'Formato de Salida','trim|xss_clean|required');

                if($time == 'fechas')
                {
                    $this->form_validation->set_rules('desde', 'Fecha de Inicio','trim|xss_clean|required');
                    $this->form_validation->set_rules('hasta', 'Fecha de Fin','trim|xss_clean|required');
                }

                if($this->form_validation->run() == FALSE)
                {
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/facturacion/realizadas', $data);
                    $this->load->view('include/script');

                }
                else
                {

                    $data['tipo']       = 1;

                    if($time == 'fechas')
                        $data['facturas']   = $this->facturacion_model->getFacturabyFecha($this->input->post('desde') , $this->input->post('hasta') );
                    else
                        $data['facturas']   = $this->facturacion_model->getFacturabyFecha( '' , '' );

                    if($this->input->post('salida') == 'pantalla')
                    {
                        $this->load->view('include/head',$session_data);
                        $this->load->view('transaccion/facturacion/realizadas', $data);
                        $this->load->view('include/script');
                    }
                    else
                    {
                        $this->load->library('excel');
                        $this->excel->setActiveSheetIndex(0);
                        $this->excel->getActiveSheet()->setTitle('Facturas Realizadas');

                        $this->excel->getActiveSheet()->setCellValue('A2', 'N°');
                        $this->excel->getActiveSheet()->setCellValue('B2', 'Cliente');
                        $this->excel->getActiveSheet()->setCellValue('C2', 'Estado Factura');
                        $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha');

                        $this->excel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(8);
                        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

                        foreach(range('A','D') as $columnID) {
                            $this->excel->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);
                        }

                        $i = 3;
                        foreach ($data['facturas'] as $orden) {

                                    $this->excel->getActiveSheet()->setCellValue('A'.$i,$orden['numero_factura']);
                                    $this->excel->getActiveSheet()->setCellValue('B'.$i,$orden['razon_social']);
                                    $this->excel->getActiveSheet()->setCellValue('C'.$i,$orden['tipo_factura']);
                                    $fecha = new DateTime($orden['fecha']);
                                    $this->excel->getActiveSheet()->setCellValue('D'.$i,$fecha->format('d-m-Y'));
                                    $i++;

                        }

                        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                        $filename='facturas_realizadas.xlsx'; //save our workbook as this file name
                        header('Content-Type: application/vnd.ms-excel'); //mime type
                        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                        header('Cache-Control: max-age=0'); //no cache

                        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                        //if you want to save it as .XLSX Excel 2007 format
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        //$objWriter->save("/temp/test1.xls");
                        //force user to download the Excel file without writing it to server's HD
                        $objWriter->save('php://output');
                    }
                }
            }

            else{

                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/facturacion/realizadas', $data);
                $this->load->view('include/script');

            }


        }
        else{
            redirect('home','refresh');
        }
    }

    function imprimir($numero = NULL , $opc = NULL){
        if($this->session->userdata('logged_in')){

            if($numero && $this->facturacion_model->existe_factura($numero)){
                $fact = $this->facturacion_model->factura_nula($numero);

                if( $fact[0]['estado_factura_id_estado_factura'] == 3 ){

                    $this->session->set_flashdata('mensaje','Las Facturas Nulas no generan impresión.');
                    redirect('transacciones/facturacion','refresh');
                }
                else{
                    $factura  = $this->facturacion_model->datos_factura($numero);
                    $ordenes  = $this->facturacion_model->getOrdenes($factura[0]['id']);

                    $fact_['estado_factura_id_estado_factura'] = 2;
                    //usar facturacion id no el numero!
                    $this->facturacion_model->modificar_facturacion($fact_,$numero);

                    $i = 0;

                    foreach ($ordenes as $orden) {

                                $orden_temp                              = $this->orden_model->get_orden($orden['id_orden']);
                                $detalle['ordenes'][$i]                  = $orden_temp[0];
                                $rut_cliente                             = $detalle['ordenes'][$i]['cliente_rut_cliente'];
                                $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i]['tramo_codigo_tramo']);

                                $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                                $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden['id_orden']);

                                $detalle['ordenes'][$i]['factura_tramo'] = $orden['factura_tramo'];
                                $detalle['ordenes'][$i]['fecha_factura'] = $orden['fecha_factura'];


                                $servicios                               = $detalle['ordenes'][$i]['detalle'];

                                $j = 0;
                                foreach ( $servicios as $servicio) {

                                    $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                                    $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                                    $serv_odn_factura                                     = $this->facturacion_model->getServicioOrdenFactura($orden['id']);
                                    $detalle['ordenes'][$i]['detalle'][$j]['factura']     = $serv_odn_factura[0]['factura_numero_factura'];
                                    $detalle['ordenes'][$i]['detalle'][$j]['fecha']       = $serv_odn_factura[0]['fecha_factura_servicio'];


                                    $j ++;
                                }

                                if($opc == 1 && $factura[0]['tipo_factura_id'] == 1){
                                    $dato = array('id_estado_orden' => 2);
                                    $this->orden_model->editar_orden($dato, $orden['id_orden']);
                                }


                                $i ++;
                    }
                    $nombre_cliente      = $this->clientes_model->datos_cliente($rut_cliente);

                    $data['cliente']     = $nombre_cliente[0];
                    $data['detalle']     = $detalle;
                    $data['numero']      = $numero;
                    $data['factura']     = $factura;
                    $session_data        = $this->session->userdata('logged_in');

                    $this->load->view('transaccion/facturacion/factura',$data);
                }
            }
            else{
                    $this->session->set_flashdata('mensaje','Intente con otra factura.');
                    redirect('transacciones/facturacion','refresh');
            }
        }
        else{
            redirect('home','refresh');
        }
    }

    function reFacturar(){

        if($this->session->userdata('logged_in')){

            $session_data     = $this->session->userdata('logged_in');

            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/re_facturar');
            $this->load->view('include/script');

        }
        else{

        }
    }

    function datosFaltantes(){
        if($this->session->userdata('logged_in')){

            $session_data = $this->session->userdata('logged_in');
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/costos');
            $this->load->view('include/script');

        }
        else{
            redirect('home','refresh');
        }
    }

    function sincronizar(){
        $session_data = $this->session->userdata('logged_in');
        if($session_data['id_tipo_usuario'] == 0 && isset($session_data['id_tipo_usuario']) ){
			$data['opc'] = 0;
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/sincronizar',$data);
            $this->load->view('include/script');

        }
        else
            redirect('main','refresh');
    }

    function FORMsincronizar(){

        $session_data = $this->session->userdata('logged_in');

        if($session_data['id_tipo_usuario'] == 0 && isset($session_data['id_tipo_usuario']) && $_FILES['uploadFile']['error'] == 0 ){


            $fact = 0;
            $os = 0;
            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //agregar mas formatos de excel
            $objReader->setReadDataOnly(true);


            //validadiones de archivo
            if ( $objReader->canRead($_FILES['uploadFile']['tmp_name'])){
                $objPHPExcel = $objReader->load($_FILES['uploadFile']['tmp_name']);
                $objWorksheet = $objPHPExcel->getActiveSheet();

                $u_fila = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                if($objPHPExcel->getActiveSheet()->getCell('G1')->getFormattedValue() == 'numfact' && $objPHPExcel->getActiveSheet()->getCell('AC1')->getFormattedValue() == 'num_ot'){

                    for($i = 2; $i <= $u_fila ; $i++){
                        $id       = trim($objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getFormattedValue());
                        $num_fact = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue());

                        if ( $num_fact != "" && $num_fact != " " && strlen($num_fact) > 0 && $id != "" && $id != " " && strlen($id) > 0 ){

                            $OK[$objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getFormattedValue()] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue();
                            // guardo el id;

                            $this->facturacion_model->actualizarOS($id);
                            $this->facturacion_model->sincronizarFact($id,$num_fact);

                        }
                    }
					$data['opc'] = 1;
					$data['ok']  = json_encode($OK);
		            $this->load->view('include/head',$session_data);
		            $this->load->view('transaccion/facturacion/sincronizar',$data);
		            $this->load->view('include/script');
                }
				else {
					$this->session->set_flashdata('mensaje','<b>Error al cargar el archivo</b><br>La columna de numfact o num_ot no corresponde a las indicadas.<br>La operación de sincronización se abortara.');
                	redirect('transacciones/facturacion/sincronizar','refresh');
				}
            }
            else{
                $this->session->set_flashdata('mensaje','Error al cargar el archivo');
                redirect('transacciones/facturacion/sincronizar','refresh');
            }

        }
        else{
            $this->session->set_flashdata('mensaje','<b>¡Error!</b>.<br>No ha cargado ningún archivo');
			redirect('transacciones/facturacion/sincronizar','refresh');
        }
    }

    function porFacturar_ajax(){

        //print_r($_GET);
        if($this->session->userdata('logged_in') && isset($_GET['start']) ) {

                $inicio    = $_GET['start'];
                $cantidad  = $_GET['length'];
                $where     = $_GET['search']['value'];
                $order     = $_GET['order'][0]['dir'];
                $by        = $_GET['order'][0]['column'];

                $total = $this->facturacion_model->getFacturasPendientes($inicio, $cantidad,$where,$order,$by,1,1);


                $data['draw']              = $_GET['draw'];
                $data['recordsTotal']      = $total;
                $data['recordsFiltered']   = $total;
                $data['data']              = $this->facturacion_model->getFacturasPendientes($inicio, $cantidad,$where,$order,$by,0);
                echo json_encode($data);
        }
        else{
            redirect('home','refresh');
        }
    }
/*
    function reFacturacion_ajax(){

        if ($this->session->userdata('logged_in')){
            if( !isset($_POST['ordenes']) ){
                        $error['result'] =
                           '<br>
                           <div class="container">
                                <div class="alert alert alert-error" align=center>
                                <a class="close" data-dismiss="alert">×</a>
                                    Error! debe seleccionar al menos UNA factura.
                                </div>
                            </div>';

                        echo json_encode($error);
                        return FALSE;
            }

            $ordenes = $_POST['ordenes'];

            $this->load->library('Web_service');



            //obtengo URL
            $datosWS      = $this->facturacion_model->manager("manager", "cabecera");
            $DetalleOS    = $this->facturacion_model->manager("manager" , "detalle");
            $actualizar   = $this->facturacion_model->manager("manager" , "cabeceraactualizar");

            //creo objeto
            $WS = new Web_service();

            //le doi al objeto las url de los WS
            $WS->new_soap($datosWS[0]->url );
            //

            foreach ($ordenes as $key => $value) {
                # code...
                $observaciones = '';

                $fOrdenes = $this->facturacion_model->getFacturaOrden($value);

                //print_r($fOrdenes);
                //INGRESO CABECERA
                $WS->setDatos($fOrdenes[0]['cliente_rut_cliente'],$fOrdenes[0]['fecha'],$value,'');
                $WS->codWS = 100;
                $WS->mensaje($datosWS[0]->action, $WS->XmlHeader());

                $detalle[$key]['cabecera']['codigo'][] = $WS->getCodigo();
                $detalle[$key]['cabecera']['error'][] = $WS->getError();

                //primero que se cargue en MANAGER

                if($WS->getCodigo() == 0){
                    foreach ($fOrdenes as $f_ord) {
                            $orden            = $this->orden_model->get_orden($f_ord['id_orden']);
                            $detalle_servicio = $this->orden_model->getDetalleByOrdenId($f_ord['id_orden']);
                            $nave             = $this->naves_model->datos_nave($orden[0]['nave_codigo_nave']);
                            //print_r($f_ord);

                            if($orden[0]['tramo_codigo_tramo'] > 0)
                                $tramo_ = $this->tramos_model->datos_tramo($orden[0]['tramo_codigo_tramo']);

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

                            $observaciones .= 'TIPO '.$T_ORDEN."^ \n";
                            $observaciones .= 'MN '.$nave[0]['nombre']."^ \n";
                            if($orden[0]['tramo_codigo_tramo'] > 0)
                                $observaciones .= 'TRAMO '.str_replace("\n", " ", $tramo_[0]['descripcion'])."^ \n";
                            $observaciones .= 'REF.1 : '.$orden[0]['referencia']."^ \n";
                            $orden[0]['referencia_2'] != '' ? $observaciones .= 'REF.2 : '.$orden[0]['referencia_2']."^ \n" : $observaciones .="^\n";
                            $observaciones .= 'UNIDAD : '.$orden[0]['numero']."^ \n";
                            $observaciones .= "^ \n";
                            $observaciones .= "^ \n";
                            $observaciones .= "^ \n";
                            $observaciones .= "^ \n";
                            $observaciones .= 'OS/'.$f_ord['id_orden']."^ \n";

                            if($orden[0]['tramo_codigo_tramo'] > 0)
                            {

                                $WS->setDatos($f_ord['cliente_rut_cliente'],$f_ord['fecha'],$value,$observaciones);
                                $WS->mensaje( $DetalleOS[0]->action, $WS->XmlBody($f_ord['valor_venta_tramo'] , $f_ord['id_codigo_sistema'] , $f_ord['cuenta_contable'] ));

                                $detalle[$key]['detalle']['codigo'][] = $WS->getCodigo();
                                $detalle[$key]['detalle']['error'][] = $WS->getError();
                                $valida_Error = $WS->getCodigo();

                            }

                            foreach ($detalle_servicio as $det_servicio) {
                                if($valida_Error == 0){
                                    //print_r($detalle_servicio);
                                    $serv_ = $this->servicios_model->datos_servicio($det_servicio['servicio_codigo_servicio']);
                                    //print_r($serv_);
                                    //$WS->setCodigos( $serv_[0]['codigo_sistema'] , $serv_[0]['cuenta_contable'] );

                                    $WS->mensaje( $DetalleOS[0]->action, $WS->XmlBody($det_servicio['valor_venta'], $serv_[0]['codigo_sistema'], $serv_[0]['cuenta_contable'] ) );

                                    $detalle[$key]['detalle']['codigo'][] = $WS->getCodigo();
                                    $detalle[$key]['detalle']['error'][] = $WS->getError();
                                    $valida_Error = $WS->getCodigo();
                                }
                            }
                    }
                    if($valida_Error == 0)
                    {
                        $WS->mensaje($actualizar[0]->action, $WS->ActualizarXmlHeader($observaciones));
                        $detalle[$key]['cabeceraactualizar']['codigo'][] = $WS->getCodigo();
                        $detalle[$key]['cabeceraactualizar']['error'][] = $WS->getError();
                        //$ordenesERROR[$value]['codigo'] = 0;
                        //$ordenesERROR[$value]['error']  = 'La Orden se cargo con éxito.';
                    }
                }
                else{
                    $ordenesERROR[$value]['codigo'] = $WS->getCodigo();
                    $ordenesERROR[$value]['error']  = $WS->getError();
                }
                $theHTMLResponse['detalle'] = $detalle;
                $theHTMLResponse['result'] = "<legend><h3>Resultado</h3></legend>
                    <table class=\"table table-bordered table-striped\">
                        <thead>
                            <tr>
                                <th>N° Factura</th>
                                <th>Codigo Error Manager</th>
                                <th>Error Manager</th>
                            <tr>
                        </thead>
                        <tbody>
                        ";

                foreach ($ordenesERROR as $key => $value) {

                    //echo "value ".$value['error']."<br>";
                    //echo "key ".$key."<br>";
                    $theHTMLResponse['result'] .=
                    "<tr>
                        <td>{$key}</td>
                        <td>".(string)$value['codigo']."</td>
                        <td>".(string)$value['error']."</td>
                    </tr>";
                }

                $theHTMLResponse['result'] .="
                        </tbody>
                    </table>

                ";

                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($theHTMLResponse));
                //echo json_encode($theHTMLResponse);
            }

        }
        else
            redirect('home','refresh');
    }
*/
    function reFacturacion_ajax()
    {

        $this->load->library('Web_service');

        $ordenes = $_POST['ordenes'];
        //obtengo URL
        $datosWS      = $this->facturacion_model->manager("manager", "cabecera");
        $DetalleOS    = $this->facturacion_model->manager("manager" , "detalle");
        $actualizar   = $this->facturacion_model->manager("manager" , "cabeceraactualizar");

        //creo objeto
        $WS = new Web_service();

        //le doi al objeto las url de los WS
        $WS->new_soap($datosWS[0]->url );
        //
        foreach ($ordenes as $key => $value) {
            
            $detalle[$key]['num_orden'] = $value;
            $observaciones = '';

            $fOrdenes = $this->facturacion_model->getFacturaOrden($value);
            //print_r($fOrdenes);
            //INGRESO CABECERA
            $WS->setDatos($fOrdenes[0]['cliente_rut_cliente'],$fOrdenes[0]['fecha'],$value,'');
            $WS->mensaje($datosWS[0]->action, $WS->XmlHeader());
            //print_r($WS->XmlHeader());
            $detalle[$key]['cabecera']['codigo'][] = $WS->getCodigo();
            $detalle[$key]['cabecera']['error'][] = $WS->getError();

            //primero que se cargue en MANAGER
            if($WS->getCodigo() == 0){
                foreach ($fOrdenes as $f_ord) {
                        $orden            = $this->orden_model->get_orden($f_ord['id_orden']);
                        $detalle_servicio = $this->orden_model->getDetalleByOrdenId($f_ord['id_orden']);
                        $nave             = $this->naves_model->datos_nave($orden[0]['nave_codigo_nave']);
                        //print_r($f_ord);

                        if($orden[0]['tramo_codigo_tramo'] > 0)
                            $tramo_ = $this->tramos_model->datos_tramo($orden[0]['tramo_codigo_tramo']);
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
                        $observaciones .= 'TIPO '.$T_ORDEN."^ \n";
                        $observaciones .= 'MN '.$nave[0]['nombre']."^ \n";
                        if($orden[0]['tramo_codigo_tramo'] > 0)
                            $observaciones .= 'TRAMO '.str_replace("\n", " ", $tramo_[0]['descripcion'])."^ \n";
                        $observaciones .= 'REF.1 : '.$orden[0]['referencia']."^ \n";
                        $orden[0]['referencia_2'] != '' ? $observaciones .= 'REF.2 : '.$orden[0]['referencia_2']."^ \n" : $observaciones .="^\n";
                        $observaciones .= 'UNIDAD : '.$orden[0]['numero']."^ \n";
                        $observaciones .= "^ \n";
                        $observaciones .= "^ \n";
                        $observaciones .= "^ \n";
                        $observaciones .= "^ \n";
                        $observaciones .= 'OS/'.$f_ord['id_orden']."^ \n";
                        if($orden[0]['tramo_codigo_tramo'] > 0)
                        {
                            $WS->setDatos($f_ord['cliente_rut_cliente'],$f_ord['fecha'],$value,$observaciones);
                            $WS->mensaje( $DetalleOS[0]->action, $WS->XmlBody($f_ord['valor_venta_tramo'] , $f_ord['id_codigo_sistema'] , $f_ord['cuenta_contable'] ));

                            $detalle[$key]['detalle']['codigo'][] = $WS->getCodigo();
                            $detalle[$key]['detalle']['error'][] = $WS->getError();


                        }
                        foreach ($detalle_servicio as $det_servicio) {


                                $serv_ = $this->servicios_model->datos_servicio($det_servicio['servicio_codigo_servicio']);
                                $WS->setCodigos( $serv_[0]['codigo_sistema'] , $serv_[0]['cuenta_contable'] );
                                $WS->mensaje( $DetalleOS[0]->action, $WS->XmlBody($det_servicio['valor_venta'], $det_servicio['id_codigo_sistema'], $det_servicio['cuenta_contable'] ) );

                                $detalle[$key]['detalle']['codigo'][] = $WS->getCodigo();
                                $detalle[$key]['detalle']['error'][] = $WS->getError();
                        }
                }
                //$WS->setDatos($fOrdenes[0]['cliente_rut_cliente'],$fOrdenes[0]['fecha'],$value,$observaciones);
                $WS->mensaje($actualizar[0]->action, $WS->ActualizarXmlHeader($observaciones));
                $detalle[$key]['cabeceraactualizar']['codigo'][] = $WS->getCodigo();
                $detalle[$key]['cabeceraactualizar']['error'][] = $WS->getError();
            }
            else{
            }
        }
        //print_r($detalle);
		$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($detalle));
        //creo y genero cabecera
            //ingreso detalle
        /*
            $session_data     = $this->session->userdata('logged_in');

            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/facturacion/re_facturar');
            $this->load->view('include/script');
        */
}

    function ordenes_servicios_ajax(){

        if($this->session->userdata('logged_in')){
            $data['ordenes'] = $this->orden_model->listar_ordenes();

            $this->load->view('transaccion/ajax/modal_ordenes',$data);
        }
        else
            redirect('home','refresh');
    }

    function detalles_ordenes_ajax(){
        if($this->session->userdata('logged_in')){

            $ordenes_ = $this->input->post('ordenes');
            $i = 0;

            foreach ($ordenes_ as $ordenes) {
                if($ordenes == ""){
                    unset($ordenes_[$i]);
                }
                $i++;
            }

            $cant = $this->facturacion_model->cant_clientes_orden($ordenes_);

            if($cant == 1){
                    $i = 0;

                    $detalle['total_venta']  = 0;
                    $detalle['total_compra'] = 0;
                    foreach ($ordenes_ as $orden) {


                        $detalle['ordenes'][$i]                  = $this->orden_model->get_orden($orden);
                        $detalle['ordenes'][$i]['total_compra']  = 0;
                        $detalle['ordenes'][$i]['total_venta']   = 0;
                        $rut_cliente                             = $detalle['ordenes'][$i][0]['cliente_rut_cliente'];
                        $tramo                                   = $this->tramos_model->datos_tramo($detalle['ordenes'][$i][0]['tramo_codigo_tramo']);

                        $detalle['ordenes'][$i]['tramo']         = $tramo[0];
                        $detalle['ordenes'][$i]['detalle']       = $this->Detalle->detalle_orden($orden);
                        $detalle['total_venta']                 += $detalle['ordenes'][$i][0]['valor_venta_tramo'];
                        $detalle['total_compra']                += $detalle['ordenes'][$i][0]['valor_costo_tramo'];

                        $detalle['ordenes'][$i]['total_compra'] += $detalle['ordenes'][$i][0]['valor_costo_tramo'];
                        $detalle['ordenes'][$i]['total_venta']  += $detalle['ordenes'][$i][0]['valor_venta_tramo'];

                        $detalle['ordenes'][$i]['proveedor']     = $this->proveedores_model->datos_proveedor($detalle['ordenes'][$i][0]['proveedor_rut_proveedor']);
                        $servicios                               = $detalle['ordenes'][$i]['detalle'];

                        $j = 0;
                        foreach ( $servicios as $servicio) {

                            $detalle_                                             = $this->servicios_model->datos_servicio($servicio['servicio_codigo_servicio']);
                            $detalle['ordenes'][$i]['detalle'][$j]['descripcion'] = $detalle_[0]['descripcion'];
                            $detalle['total_venta']                              += $servicio['valor_venta'];
                            $detalle['total_compra']                             += $servicio['valor_costo'];
                            $detalle['ordenes'][$i]['total_compra']              += $servicio['valor_costo'];
                            $detalle['ordenes'][$i]['total_venta']               += $servicio['valor_venta'];

                            $j ++;
                        }

                        $i ++;
                    }

                    $detalle['total_compra'] = number_format($detalle['total_compra'],0,'','.');
                    $detalle['total_venta']  = number_format($detalle['total_venta'],0,'','.');
                    $nombre_cliente          = $this->clientes_model->datos_cliente($rut_cliente);

                    $theHTMLResponse['clientes']      = 1;
                    $theHTMLResponse['html'] = $this->load->view('transaccion/ajax/detalles_ordenes',$detalle,true);
                    $theHTMLResponse['total_compra']  = $detalle['total_compra'];
                    $theHTMLResponse['total_venta']   = $detalle['total_venta'];
                    $theHTMLResponse['cliente']       = $rut_cliente." - ".$nombre_cliente[0]['razon_social'];

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }
            else{
                    $theHTMLResponse['clientes']     = 0;
                    $theHTMLResponse['html']         = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Debe seleccionar ordenes con el mismo cliente</strong> </div>';
                    $theHTMLResponse['total_compra'] = "--";
                    $theHTMLResponse['total_venta']  = "--";

                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode($theHTMLResponse));
            }

        }
        else
            redirect('home','refresh');
    }

    function proveedores_ajax(){
        if($this->session->userdata('logged_in')){
            $data['proveedores'] = $this->proveedores_model->listar_proveedores();
            $this->load->view('transaccion/ajax/proveedores',$data);
        }
        else
            redirect('home','refresh');
    }

    function facturas_ajax(){
        if($this->session->userdata('logged_in')){
            $facturas = $this->facturacion_model->listar_facturas();

            $i = 0;
            foreach ($facturas as $factura) {
                if($factura['estado_factura_id_estado_factura'] != 3){

                        $ordenes = $this->facturacion_model->getOrdenes($factura['id']);
                        if ( isset($factura['id']) && isset($ordenes[0]['id_orden']) )
                            $orden   = $this->orden_model->get_orden($ordenes[0]['id_orden']);
                        if( isset($orden[0]['cliente_rut_cliente']) )
                            $cliente = $this->clientes_model->datos_cliente($orden[0]['cliente_rut_cliente']);
                        if( isset($cliente[0]['rut_cliente']) )
                            $facturas[$i]['cliente'] = $cliente[0]['rut_cliente']." - ".$cliente[0]['razon_social'];

                }
                else{
                    $facturas[$i]['cliente'] = "--";
                }
                $i++;
            }

            $data['facturas'] = $facturas;
            $this->load->view('transaccion/ajax/modal_facturas',$data);
        }
        else
            redirect('home','refresh');
    }

    function check_database($numero_factura){
        $result = $this->facturacion_model->factura_repetida($numero_factura);

        if($result){

            $this->form_validation->set_message('check_database','El número de factura que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{

            return true;
        }
    }

    function check_date($fecha){
        $fecha = explode(" ",$fecha);
        //$fecha = unset( $fecha[1] );
        $fecha = explode("-",$fecha[0]);

        if(isset($fecha[0]) && isset($fecha[1]) && isset($fecha[2])){
            if($fecha[0] > 0 && $fecha[0] < 32 && $fecha[1] > 0 && $fecha[1] < 13 &&  $fecha[2] > 2000 ){
                return true;
            }
            else{
                $this->form_validation->set_message('check_date','El formato de fecha para la factura que ingresa es incorrecto. Intente con otro.');
                return false;
            }
        }
        else{
            $this->form_validation->set_message('check_date','El formato de fecha para la factura que ingresa es incorrecto. Intente con otro.');
            return false;
        }
    }
}
?>
