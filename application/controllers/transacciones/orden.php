<?php

class Orden extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Orden_model');
        $this->load->model('utils/Facturacion');
        $this->load->model('utils/Viaje');
        $this->load->model('utils/Detalle');
        $this->load->model('mantencion/Clientes_model');
        $this->load->model('mantencion/Agencias_model');
        $this->load->model('mantencion/Bodegas_model');
        $this->load->model('mantencion/Puertos_model');
        $this->load->model('mantencion/Proveedores_model');
        $this->load->model('mantencion/Camiones_model');
        $this->load->model('mantencion/Servicios_model');
        $this->load->model('mantencion/Conductores_model');
        $this->load->model('mantencion/Tramos_model');
        $this->load->model('mantencion/Cargas_model');
        $this->load->model('mantencion/Depositos_model');
        $this->load->model('mantencion/Naves_model');
        
    }
            
    function index(){
        
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            //tipo facturacion
            $data['tfacturacion'] = $this->Facturacion->tipo_orden();
            //listado clientes
            $data['clientes'] = $this->Clientes_model->listar_clientes();
            //listado tramos
            $data['tramos'] = $this->Facturacion->listar_tramos();
            //listado aduanas
            $data['aduanas'] = $this->Agencias_model->listar_agencias();
            //listar bodegas
            $data['bodegas']= $this->Bodegas_model->listar_bodegas();
            //listar puertos
            $data['puertos'] = $this->Puertos_model->listar_puertos();
            //listar proveedores
            $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
            //listar camiones
            $data['camiones'] = $this->Camiones_model->listar_camiones();
            //listar servicios
            $data['servicios'] = $this->Servicios_model->listar_servicios();
            //listar conductores
            $data['conductores'] = $this->Conductores_model->listar_conductores();
            //listar carga
            $data['cargas'] = $this->Cargas_model->listar_cargas();
            //listar depositos
            $data['depositos'] = $this->Depositos_model->listar_depositos();
            //listar naves
            $data['naves'] = $this->Naves_model->listar_naves();
            //listar ordenes
            $data['ordenes'] = $this->Orden_model->listar_ordenes();
            
            $codigo = $this->Orden_model->ultimo_codigo();
            
            if ($codigo[0]['id_orden'] == ""){
                  $data['numero_orden'] = 1;
                          
              }
              else{
                  $data['numero_orden'] = $codigo[0]['id_orden'] + 1;
                  
              }
            $tab['active'] = 'exportacion';
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/orden',$data);
            $this->load->view('modal/modal_aduana', $data);
            $this->load->view('modal/modal_cliente',$data);
            $this->load->view('modal/modal_tramo',$data);
            $this->load->view('modal/modal_bodega',$data);
            $this->load->view('modal/modal_puerto',$data);
            $this->load->view('modal/modal_destino',$data);
            $this->load->view('modal/modal_proveedor',$data);
            $this->load->view('modal/modal_camion',$data);
            $this->load->view('modal/modal_servicio',$data);
            $this->load->view('modal/modal_conductor',$data);
            $this->load->view('modal/modal_carga',$data);
            $this->load->view('modal/modal_deposito',$data);
            $this->load->view('modal/modal_nave',$data);
            $this->load->view('modal/modal_orden',$data);
            $this->load->view('include/script');
        }
          
        else{
            redirect('home','refresh');
        }
                
        
    }
    
    function guardar(){
        
            if($this->session->userdata('logged_in')){
                
                
                $this->load->library('form_validation');
                 
                  $this->form_validation->set_rules('cliente_rut_cliente','RUT Cliente','trim|xss_clean|required|min_length[7]|callback_check_cliente');
                  $this->form_validation->set_rules('tramo_codigo_tramo','Tramo','trim|xss_clean|required|callback_check_tramo');
                  $this->form_validation->set_rules('aduana_codigo_aduana','Aduana','trim|xss_clean|required|callback_check_aduana');
                  $this->form_validation->set_rules('bodega_codigo_bodega','Bodega','trim|xss_clean|required|callback_check_bodega');
                  $this->form_validation->set_rules('puerto_codigo_puerto','Puerto','trim|xss_clean|required|callback_check_puerto');
                  $this->form_validation->set_rules('destino','Destino','trim|xss_clean|required|callback_check_destino');
                  $this->form_validation->set_rules('proveedor_rut_proveedor','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor');
                  $this->form_validation->set_rules('tipo_carga_codigo_carga','Carga','trim|xss_clean|required|callback_check_carga');
                  $this->form_validation->set_rules('conductor_rut','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor');
                  $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente');
                  $this->form_validation->set_rules('deposito_codigo_deposito', 'Deposito','trim|xss_clean|required|callback_check_deposito');
                  $this->form_validation->set_rules('nave_codigo_nave','Nave','trim|xss_clean|callback_check_nave');
                  
                if($this->form_validation->run() == FALSE){
                    $session_data = $this->session->userdata('logged_in');
                    //tipo facturacion
                    $data['tfacturacion'] = $this->Facturacion->tipo_orden();
                    //listado clientes
                    $data['clientes'] = $this->Clientes_model->listar_clientes();
                    //listado tramos
                    $data['tramos'] = $this->Facturacion->listar_tramos();
                    //listado aduanas
                    $data['aduanas'] = $this->Agencias_model->listar_agencias();
                    //listar bodegas
                    $data['bodegas']= $this->Bodegas_model->listar_bodegas();
                    //listar puertos
                    $data['puertos'] = $this->Puertos_model->listar_puertos();
                    //listar proveedores
                    $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                    //listar camiones
                    $data['camiones'] = $this->Camiones_model->listar_camiones();
                    //listar servicios
                    $data['servicios'] = $this->Servicios_model->listar_servicios();
                    //listar conductores
                    $data['conductores'] = $this->Conductores_model->listar_conductores();
                    //listar carga
                    $data['cargas'] = $this->Cargas_model->listar_cargas();
                    //listar depositos
                    $data['depositos'] = $this->Depositos_model->listar_depositos();
                    //listar Naves
                    $data['naves'] = $this->Naves_model->listar_naves();
                    

                    $codigo = $this->Orden_model->ultimo_codigo();

                    if ($codigo[0]['id_orden'] == ""){
                          $data['numero_orden'] = 1;

                    }
                    else{
                          $data['numero_orden'] = $codigo[0]['id_orden'] + 1;

                    }
                    $tab['active'] = 'exportacion';
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/orden',$data);
                    $this->load->view('modal/modal_aduana', $data);
                    $this->load->view('modal/modal_cliente',$data);
                    $this->load->view('modal/modal_tramo',$data);
                    $this->load->view('modal/modal_bodega',$data);
                    $this->load->view('modal/modal_puerto',$data);
                    $this->load->view('modal/modal_destino',$data);
                    $this->load->view('modal/modal_proveedor',$data);
                    $this->load->view('modal/modal_camion',$data);
                    $this->load->view('modal/modal_servicio',$data);
                    $this->load->view('modal/modal_conductor',$data);
                    $this->load->view('modal/modal_carga',$data);
                    $this->load->view('modal/modal_deposito',$data);
                    $this->load->view('modal/modal_nave',$data);
                    $this->load->view('include/script');
                }
                else{

                    //creando nuevo viaje
                    $ultimo_viaje = $this->Viaje->ultimo_codigo();
                    if ($ultimo_viaje[0]['id_viaje'] == NULL){
                        $id_viaje = 1;
                    }
                    else{
                        $id_viaje = $ultimo_viaje[0]['id_viaje'] + 1;
                    }
                       
                    
                    $viaje = array(
                                'camion_camion_id' => $this->input->post('camion_camion_id'),
                                'conductor_rut' => $this->input->post('conductor_rut'),
                                'id_viaje' => $id_viaje
                            );
    
                    $aduana = explode(' - ', $this->input->post('aduana_codigo_aduana'));
                    $nave = explode(' - ',  $this->input->post('nave_codigo_nave'));
                    $bodega = explode(' - ',  $this->input->post('bodega_codigo_bodega'));
                    $destino = explode(' - ',  $this->input->post('destino'));
                    $puerto = explode(' - ', $this->input->post('puerto_codigo_puerto'));
                    $carga = explode(' - ', $this->input->post('tipo_carga_codigo_carga'));
                    $deposito = explode(' - ', $this->input->post('deposito_codigo_deposito'));
                    $tramo = explode(' - ', $this->input->post('tramo_codigo_tramo'));
                    
                    $orden = array(
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $this->input->post('fecha'),
                        'cliente_rut_cliente' => $this->input->post('cliente_rut_cliente'),
                        'booking' => $this->input->post('booking'),
                        'aduana_codigo_aduana' => $aduana[0],
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'fecha_presentacion' => $this->input->post('fecha_prensentacion'),
                        'bodega_codigo_bodega' => $bodega[0],
                        'destino' => $destino[0],
                        'puerto_codigo_puerto' => $puerto[0],
                        'proveedor_rut_proveedor' => $this->input->post('proveedor_rut_proveedor'),
                        'observacion' => $this->input->post('observacion'),
                        'referencia_2' => $this->input->post('referencia2'),
                        'tipo_carga_codigo_carga'=> $carga[0],
                        'tipo_orden_id_tipo_orden' => '',
                        'deposito_codigo_deposito' => $deposito[0],
                        'nave_codigo_nave' => $nave[0],
                        'mercaderia' =>  $this->input->post('mercaderia'),
                        'num_servicios' => count($this->input->post('codigo_Servicio')),
                        'viaje_id_viaje' => $id_viaje,
                        'tramo_codigo_tramo' => $tramo[0],
                        'valor_costo_tramo' => $this->input->post('valor_costo_tramo'),
                        'valor_venta_tramo' => $this->input->post('valor_venta_tramo')
                    );
                   
                    $tipo_ordenes = $this->Facturacion->tipo_orden();
                    foreach($tipo_ordenes as $tipo_orden){
                    
                        if($tipo_orden['tipo_orden'] == $this->input->post('tipo_orden')){
                             $orden['tipo_orden_id_tipo_orden'] = $tipo_orden['id_tipo_orden'];
                        }
                    }
                    

                    //guarda viaje y la orden.
                    $this->Viaje->crear_viaje($viaje);
		    $this->Orden_model->insert_orden($orden);
                    $i = 0;
                                    
                    $num_orden = $this->input->post('numero_orden');
                    $costo = $this->input->post('valor_costo_servicio');
                    $venta = $this->input->post('valor_venta_servicio');
                    
                    $cod_detalle = $this->Detalle->ultimo_codigo();
                        if ( $cod_detalle[0]['id_detalle'] == NULL){
                            $id_detalle = 1;
                        }
                        else{
                            $id_detalle = $cod_detalle[0]['id_detalle'] + 1;
                        }
                                        
                    foreach ($this->input->post('codigo_servicio') as $servicio){
                       $detalle = array(
                                    'id_detalle' => $id_detalle,
                                    'servicio_codigo_servicio' => $servicio,
                                    'orden_id_orden'=> $num_orden,
                                    'valor_costo'=> $costo[$i],
                                    'valor_venta'=> $venta[$i]
                       );
                       $i = $i + 1;
                       $id_detalle = $id_detalle + 1;
                       										
                       //guarda uno a uno los detalles.
                       $this->Detalle->guardar_detalle($detalle);
                    }
                redirect('transacciones/orden','refresh');
                
                    
                }
            }
            
            else{
                redirect('home','refresh');
            }
            
    }
    
    function editar(){
        if($this->session->userdata('logged_in')){
                            
                
                $this->load->library('form_validation');
                 
                  $this->form_validation->set_rules('cliente_rut_cliente','RUT Cliente','trim|xss_clean|required|min_length[7]|callback_check_cliente');
                  $this->form_validation->set_rules('tramo_codigo_tramo','Tramo','trim|xss_clean|required|callback_check_tramo');
                  $this->form_validation->set_rules('aduana_codigo_aduana','Aduana','trim|xss_clean|required|callback_check_aduana');
                  $this->form_validation->set_rules('bodega_codigo_bodega','Bodega','trim|xss_clean|required|callback_check_bodega');
                  $this->form_validation->set_rules('puerto_codigo_puerto','Puerto','trim|xss_clean|required|callback_check_puerto');
                  $this->form_validation->set_rules('destino','Destino','trim|xss_clean|required|callback_check_destino');
                  $this->form_validation->set_rules('proveedor_rut_proveedor','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor');
                  $this->form_validation->set_rules('tipo_carga_codigo_carga','Carga','trim|xss_clean|required|callback_check_carga');
                  $this->form_validation->set_rules('conductor_rut','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor');
                  $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente');
                  $this->form_validation->set_rules('deposito_codigo_deposito', 'Deposito','trim|xss_clean|required|callback_check_deposito');
                  $this->form_validation->set_rules('nave_codigo_nave','Nave','trim|xss_clean|callback_check_nave');
                  
                if($this->form_validation->run() == FALSE){
                    $session_data = $this->session->userdata('logged_in');
                    //tipo facturacion
                    $data['tfacturacion'] = $this->Facturacion->tipo_orden();
                    //listado clientes
                    $data['clientes'] = $this->Clientes_model->listar_clientes();
                    //listado tramos
                    $data['tramos'] = $this->Facturacion->listar_tramos();
                    //listado aduanas
                    $data['aduanas'] = $this->Agencias_model->listar_agencias();
                    //listar bodegas
                    $data['bodegas']= $this->Bodegas_model->listar_bodegas();
                    //listar puertos
                    $data['puertos'] = $this->Puertos_model->listar_puertos();
                    //listar proveedores
                    $data['proveedores'] = $this->Proveedores_model->listar_proveedores();
                    //listar camiones
                    $data['camiones'] = $this->Camiones_model->listar_camiones();
                    //listar servicios
                    $data['servicios'] = $this->Servicios_model->listar_servicios();
                    //listar conductores
                    $data['conductores'] = $this->Conductores_model->listar_conductores();
                    //listar carga
                    $data['cargas'] = $this->Cargas_model->listar_cargas();
                    //listar depositos
                    $data['depositos'] = $this->Depositos_model->listar_depositos();
                    //listar Naves
                    $data['naves'] = $this->Naves_model->listar_naves();
					
					$data['ordenes'] = $this->Orden_model->listar_ordenes();
                    

                    $codigo = $this->Orden_model->ultimo_codigo();

                    if ($codigo[0]['id_orden'] == ""){
                          $data['numero_orden'] = 1;

                    }
                    else{
                          $data['numero_orden'] = $codigo[0]['id_orden'] + 1;

                    }
                    $tab['active'] = 'exportacion';
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/orden',$data);
                    $this->load->view('modal/modal_aduana', $data);
                    $this->load->view('modal/modal_cliente',$data);
                    $this->load->view('modal/modal_tramo',$data);
                    $this->load->view('modal/modal_bodega',$data);
                    $this->load->view('modal/modal_puerto',$data);
                    $this->load->view('modal/modal_destino',$data);
                    $this->load->view('modal/modal_proveedor',$data);
                    $this->load->view('modal/modal_camion',$data);
                    $this->load->view('modal/modal_servicio',$data);
                    $this->load->view('modal/modal_conductor',$data);
                    $this->load->view('modal/modal_carga',$data);
                    $this->load->view('modal/modal_deposito',$data);
                    $this->load->view('modal/modal_nave',$data);
					$this->load->view('modal/modal_orden',$data);
                    $this->load->view('include/script');
                }
                else{
                    	
					$orden_bd = $this->Orden_model->get_orden($this->input->post('numero_orden'));
                    $id_viaje = $this->Viaje->seleccionar_viaje($orden_bd[0]['viaje_id_viaje']);
                    
                    $viaje = array(
                                'camion_camion_id' => $this->input->post('camion_camion_id'),
                                'conductor_rut' => $this->input->post('conductor_rut'),
                                'id_viaje' => $id_viaje[0]['id_viaje']
                            );
    
                    $aduana = explode(' - ', $this->input->post('aduana_codigo_aduana'));
                    $nave = explode(' - ',  $this->input->post('nave_codigo_nave'));
                    $bodega = explode(' - ',  $this->input->post('bodega_codigo_bodega'));
                    $destino = explode(' - ',  $this->input->post('destino'));
                    $puerto = explode(' - ', $this->input->post('puerto_codigo_puerto'));
                    $carga = explode(' - ', $this->input->post('tipo_carga_codigo_carga'));
                    $deposito = explode(' - ', $this->input->post('deposito_codigo_deposito'));
                    $tramo = explode(' - ', $this->input->post('tramo_codigo_tramo'));
                    
								
                    
                    $orden = array(
                        'id_orden' =>$this->input->post('numero_orden'),
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $this->input->post('fecha'),
                        'cliente_rut_cliente' => $this->input->post('cliente_rut_cliente'),
                        'booking' => $this->input->post('booking'),
                        'aduana_codigo_aduana' => $aduana[0],
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'fecha_presentacion' => $this->input->post('fecha_prensentacion'),
                        'bodega_codigo_bodega' => $bodega[0],
                        'destino' => $destino[0],
                        'puerto_codigo_puerto' => $puerto[0],
                        'proveedor_rut_proveedor' => $this->input->post('proveedor_rut_proveedor'),
                        'observacion' => $this->input->post('observacion'),
                        'referencia_2' => $this->input->post('referencia2'),
                        'tipo_carga_codigo_carga'=> $carga[0],
                        'tipo_orden_id_tipo_orden' => '',
                        'deposito_codigo_deposito' => $deposito[0],
                        'nave_codigo_nave' => $nave[0],
                        'mercaderia' =>  $this->input->post('mercaderia'),
                        'num_servicios' => count($this->input->post('codigo_Servicio')),
                        'viaje_id_viaje' => $id_viaje[0]['id_viaje'],
                        'tramo_codigo_tramo' => $tramo[0],
                        'valor_costo_tramo' => $this->input->post('valor_costo_tramo'),
                        'valor_venta_tramo' => $this->input->post('valor_venta_tramo')
                    );
                   
                    $tipo_ordenes = $this->Facturacion->tipo_orden();
                    foreach($tipo_ordenes as $tipo_orden){
                    
                        if($tipo_orden['tipo_orden'] == $this->input->post('tipo_orden')){
                             $orden['tipo_orden_id_tipo_orden'] = $tipo_orden['id_tipo_orden'];
                        }
                    }
                    

                    //guarda viaje y la orden.
                    //$this->Viaje->editar_viaje($viaje);
		            //$this->Orden_model->editar_orden($orden);

                    $id_detalle = $this->input->post('id_detalle');
                    
                    $i = 0;
                    $num_orden = $this->input->post('numero_orden');
                    $costo = $this->input->post('valor_costo_servicio');
                    $venta = $this->input->post('valor_venta_servicio');


                    foreach ($this->input->post('codigo_servicio') as $servicio){
                           
                       $detalle = array(
                                    'id_detalle' => $id_detalle[$i],
                                    'servicio_codigo_servicio' => $servicio,
                                    'orden_id_orden'=> $num_orden,
                                    'valor_costo'=> $costo[$i],
                                    'valor_venta'=> $venta[$i]
                       );
                        $i = $i + 1;
                       //guarda uno a uno los detalles.
                       //$this->Detalle->editar_detalle($detalle);
                    }
                    echo "<pre>";
                    echo "ORDEN:";
                    print_r($orden);
                    echo "<br> DETALLE :";
                    print_r($detalle);
                    echo "<br> VIAJE ";
                    print_r($viaje);
                    echo "</pre>";
                    
                //redirect('transacciones/orden','refresh');

                }
        }    
                
        
        else{
            redirect('home','refresh');
        }
        
    }
            
	function pdf(){
		//print_r($_POST);
		$this->load->library('pdf');
		$this->pdf = new Pdf();
		$this->pdf->AddPage();
		
		$this->pdf->SetTitle("Prueba");
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
		$this->pdf->SetFont('Arial', 'B', 9);
		 
		$this->pdf->Cell(15,7,'NUM','TBL',0,'C','1');
        $this->pdf->Cell(25,7,'PATERNO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'MATERNO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'NOMBRE','TB',0,'L','1');
        $this->pdf->Cell(40,7,'FECHA DE NACIMIENTO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'GRADO','TB',0,'L','1');
        $this->pdf->Cell(25,7,'GRUPO','TBR',0,'C','1');
		$this->pdf->Ln(7);
		
		ob_end_clean();
		$this->pdf->Output("pdf.pdf", 'I');
	}		
			
    function check_cliente($rut){
                
        $result = $this->Clientes_model->existe_rut($rut);
        
        if($result){
            
            $this->form_validation->set_message('check_cliente','El RUT Cliente que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
    
    function check_tramo($tramo){
                
        $result = $this->Tramos_model->existe_tramo($tramo);
        
        if($result){
            
            $this->form_validation->set_message('check_tramo','El Tramo que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
    
    function check_aduana($aduana){
                
        $result = $this->Agencias_model->existe_aduana($aduana);
        
        if($result){
            
            $this->form_validation->set_message('check_aduana','La Agencia de Aduana que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
    
    function check_bodega($bodega){
                
        $result = $this->Bodegas_model->existe_bodega($bodega);
        
        if($result){
            
            $this->form_validation->set_message('check_bodega','La Bodega que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
    
    function check_puerto($puerto){
                
        $result = $this->Puertos_model->existe_puerto($puerto);
        
        if($result){
            
            $this->form_validation->set_message('check_puerto','El Puerto que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }

    function check_destino($puerto){
                
        $result = $this->Puertos_model->existe_puerto($puerto);
        
        if($result){
            
            $this->form_validation->set_message('check_destino','El Destino que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
         
    function check_proveedor($proveedor){
                
        $result = $this->Proveedores_model->existe_rut($proveedor);
        
        if($result){
            
            $this->form_validation->set_message('check_proveedor','El RUT del Proveedor que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
    
    function check_servicio($servicio){
                
        $result = $this->Servicios_model->existe_servicio($servicio);
        
        if($result){
            
            $this->form_validation->set_message('check_servicio','El Servicio que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
    
    function check_conductor($rut){
                
        $result = $this->Conductores_model->existe_conductor($rut);
        
        if($result){
            
            $this->form_validation->set_message('check_conductor','El Rut del Conductor que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
    
    function check_patente($patente){
                
        $result = $this->Camiones_model->existe_camion($patente);
        
        if($result){
            
            $this->form_validation->set_message('check_patente','La Patente del Camión que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
        
    function check_carga($carga){
                
        $result = $this->Cargas_model->existe_carga($carga);
        
        if($result){
            
            $this->form_validation->set_message('check_carga','La Carga que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
            
    function check_deposito($deposito){
                
        $result = $this->Depositos_model->existe_deposito($deposito);
        
        if($result){
            
            $this->form_validation->set_message('check_deposito','El Depósito que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
                
    function check_nave($nave){
                
        $result = $this->Naves_model->existe_nave($nave);
        
        if($result){
            
            $this->form_validation->set_message('check_nave','La Nave que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
    
    }
    
    function check_orden($orden){
                
        $result = $this->Orden_model->existe_orden($orden);
        
        if($result){
            
            $this->form_validation->set_message('check_orden','La O.S. N° que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
}
?>
