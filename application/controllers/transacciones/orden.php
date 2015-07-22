<?php class Orden extends CI_Controller{
    
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
        $this->load->model('mantencion/Navieras_model');
        date_default_timezone_set('America/Santiago');
        
    }
            
    function index(){
	
		$id_orden = isset($_POST['id_orden'])?$_POST['id_orden']:'';
		$codigo_detalle = isset($_POST['id_orden_detalle'])?$_POST['id_orden_detalle']:'';
		$id_viaje       = isset($_POST['code_id_viaje'])?$_POST['code_id_viaje']:'';	
		
		if(isset($id_orden) && $id_orden != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_ordensh($id_orden));
			
			echo $response;
		
		} else if(isset($codigo_detalle) && $codigo_detalle != '') {
			$response = json_encode($this->datos_detalle($codigo_detalle));
			
			echo $response;
		} else if( isset( $id_viaje ) && $id_viaje != '' ) {
			$response = json_encode($this->datosConductor($id_viaje));
			
			echo $response;
		} else {
        
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
            $data['navieras'] = $this->Navieras_model->listar_navieras();
            
            $codigo = $this->Orden_model->ultimo_codigo();
            
            if ($codigo[0]['id_orden'] == ""){
                  $data['numero_orden'] = 1;
                          
              }
              else{
                  $data['numero_orden'] = $codigo[0]['id_orden'] + 1;
                  
              }
				$tab['active'] = 'exportacion';
				$this->load->view('include/head',$session_data);
				$this->load->view('transaccion/orden/crear_orden',$data);
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
                $this->load->view('modal/modal_naves',$data);
				$this->load->view('modal/modal_orden',$data);
				$this->load->view('include/script');
			}
          
            else{
				redirect('home','refresh');
            }
                
        }
    }
    
    function guardar(){
        
            if($this->session->userdata('logged_in')){
               
                 $this->load->library('form_validation');

                  $this->form_validation->set_rules('cliente_rut_cliente','RUT Cliente','trim|xss_clean|required|min_length[7]|callback_check_cliente');
                  
                  if(!isset($_POST['enable_tramo'])){
                      $this->form_validation->set_rules('tramo_codigo_tramo','Tramo','trim|xss_clean|required|callback_check_tramo');
                  }
                  
                  $this->form_validation->set_rules('aduana_codigo_aduana','Aduana','trim|xss_clean|required|callback_check_aduana');
                  $this->form_validation->set_rules('bodega_codigo_bodega','Bodega','trim|xss_clean|required|callback_check_bodega');
                  
                  if($_POST['tipo_orden'] != "NACIONAL" &&  $_POST['tipo_orden'] != "OTRO SERVICIO"){
                      $this->form_validation->set_rules('destino','Destino','trim|xss_clean|required|callback_check_destino');
                   
                  }

                  if($_POST['tipo_orden'] != "IMPORTACION"){
                    $this->form_validation->set_rules('deposito_codigo_deposito', 'Deposito','trim|xss_clean|required|callback_check_deposito');
                    $this->form_validation->set_rules('puerto_codigo_puerto','Puerto','trim|xss_clean|required|callback_check_puerto');
                  }

                  
                  $this->form_validation->set_rules('proveedor_rut_proveedor','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor');
                  $this->form_validation->set_rules('tipo_carga_codigo_carga','Carga','trim|xss_clean|required|callback_check_carga');
                  $this->form_validation->set_rules('conductor_rut','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor');
                  $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente');

                  $this->form_validation->set_rules('nave_codigo_nave','Nave','required|trim|xss_clean|callback_check_nave');
                  
                  //$this->form_validation->set_rules('numero_orden','O.S N°','required|trim|xss_clean');
                  $this->form_validation->set_rules('naviera_codigo_naviera','Naviera','required|trim|xss_clean');
                
                  
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
                    $data['navieras'] = $this->Navieras_model->listar_navieras();
                    

                    $codigo = $this->Orden_model->ultimo_codigo();

                    if ($codigo[0]['id_orden'] == ""){
                          $data['numero_orden'] = 1;

                    }
                    else{
                          $data['numero_orden'] = $codigo[0]['id_orden'] + 1;

                    }
                    $tab['active'] = 'exportacion';
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/orden/crear_orden',$data);
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
                    $this->load->view('modal/modal_naves',$data);
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

                    $camion = $this->Camiones_model->datos_camion($this->input->post('patente'));

                    $viaje = array(
                                'camion_camion_id' => $camion[0]['camion_id'],
                                'conductor_rut' => $this->input->post('conductor_rut'),
                                'id_viaje' => $id_viaje
                            );

                    $aduana = explode(' - ', $this->input->post('aduana_codigo_aduana'));
                    $nave = explode(' - ',  $this->input->post('nave_codigo_nave'));
                    $bodega = explode(' - ',  $this->input->post('bodega_codigo_bodega'));
                    $destino = explode(' - ',  $this->input->post('destino'));
                    $deposito = explode(' - ', $this->input->post('deposito_codigo_deposito'));
                    $carga = explode(' - ', $this->input->post('tipo_carga_codigo_carga'));
                    
                    if($_POST['tipo_orden'] == "EXPORTACION"){
                        $puerto = explode(' - ', $this->input->post('puerto_codigo_puerto'));
                    }
                    else{

                        $puerto[0] = 1;
                    }

                    if($_POST['tipo_orden'] == "IMPORTACION"){
                        $lugar_retiro = $_POST['lugar_retiro'];
                        $deposito[0] = '-1';
                    }
                    else{
                        $lugar_retiro = "N/A";
                    }
                    
                    if($_POST['tipo_orden'] == "NACIONAL" || $_POST['tipo_orden'] == "OTRO SERVICIO" ){
                         $destino[0] = -1;
                    }

                    
                    $tramo = explode(' - ', $this->input->post('tramo_codigo_tramo'));
                    $fecha = $this->input->post('fecha');
                    $fecha_presentacion = $this->input->post('fecha_presentacion');
                    
                    $fecha = str_replace('/','-', $fecha);
                    $fecha = date("Y-m-d H:i",strtotime($fecha));
                    
                    $fecha_presentacion = str_replace('/','-', $fecha_presentacion);
                    $fecha_presentacion = date("Y-m-d H:i",strtotime($fecha_presentacion));
                    
                    $codigo = $this->Orden_model->ultimo_codigo();
                    
                    $orden = array(
                        'id_orden' => $codigo[0]['id_orden'] + 1,
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $fecha ,
                        'cliente_rut_cliente' => $this->input->post('cliente_rut_cliente'),
                        'booking' => $this->input->post('booking'),
                        'aduana_codigo_aduana' => $aduana[0],
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'fecha_presentacion' => $fecha_presentacion,
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
                        'num_servicios' => count($this->input->post('codigo_servicio')),
                        'viaje_id_viaje' => $id_viaje,
                        'tramo_codigo_tramo' => $tramo[0],
                        'valor_costo_tramo' => str_replace(".", "",$this->input->post('valor_costo_tramo')),
                        'valor_venta_tramo' => str_replace(".", "",$this->input->post('valor_venta_tramo')),
                        'naviera_codigo_naviera' => $this->input->post('naviera_codigo_naviera'),
                        'lugar_retiro' => $lugar_retiro
                    );

                    if(isset($_POST['enable_tramo'])){
                       $orden['tramo_codigo_tramo'] = -1;
                    }
                   
                    $tipo_ordenes = $this->Facturacion->tipo_orden();
                    foreach($tipo_ordenes as $tipo_orden){
                    
                        if($tipo_orden['tipo_orden'] == $this->input->post('tipo_orden')){
                             $orden['tipo_orden_id_tipo_orden'] = $tipo_orden['id_tipo_orden'];
                        }
                    }

            //##########################  guarda viaje y la orden. ########################## 
                    $this->Viaje->crear_viaje($viaje);
		            $this->Orden_model->insert_orden($orden);
                    $i = 0;
                                    
                    $num_orden = $codigo[0]['id_orden'] + 1;
                    $costo = $this->input->post('valor_costo_servicio');
                    $venta = $this->input->post('valor_venta_servicio');
                    
                    $cod_detalle = $this->Detalle->ultimo_codigo();
                        if ( $cod_detalle[0]['id_detalle'] == NULL){
                            $id_detalle = 1;
                        }
                        else{
                            $id_detalle = $cod_detalle[0]['id_detalle'] + 1;
                        }
                                      
                    if($orden['tipo_orden_id_tipo_orden'] == 8){
                            foreach ($this->input->post('codigo_servicio') as $servicio){
                               $cod_servicio = "";
                               $cod_servicio = explode("-",$servicio);
                               $detalle = array(
                                            'id_detalle' => $id_detalle,
                                            'servicio_codigo_servicio' => $servicio[0],
                                            'orden_id_orden'=> $num_orden,
                                            'valor_costo'=> $costo[$i],
                                            'valor_venta'=> $venta[$i]
                               );
                               $i = $i + 1;
                               $id_detalle = $id_detalle + 1;
            //########################## guarda uno a uno los detalles. ########################## 
                               $this->Detalle->guardar_detalle($detalle);
                            }
                    }

                $this->session->set_flashdata('sin_orden','La orden se ha creado con éxito');
                redirect('transacciones/orden/index');
                //$this->load->view('prueba');
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
                  if(!isset($_POST['enable_tramo'])){
                      $this->form_validation->set_rules('tramo_codigo_tramo','Tramo','trim|xss_clean|required|callback_check_tramo');
                  }
                  $this->form_validation->set_rules('aduana_codigo_aduana','Aduana','trim|xss_clean|required|callback_check_aduana');
                  $this->form_validation->set_rules('bodega_codigo_bodega','Bodega','trim|xss_clean|required|callback_check_bodega');
                  $this->form_validation->set_rules('puerto_codigo_puerto','Puerto','trim|xss_clean|required|callback_check_puerto');
                if($_POST['tipo_orden'] != "NACIONAL" &&  $_POST['tipo_orden'] != "OTRO SERVICIO"){
                      $this->form_validation->set_rules('destino','Destino','trim|xss_clean|required|callback_check_destino');
                   
                  }
                  $this->form_validation->set_rules('proveedor_rut_proveedor','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor');
                  $this->form_validation->set_rules('tipo_carga_codigo_carga','Carga','trim|xss_clean|required|callback_check_carga');
                  $this->form_validation->set_rules('conductor_rut','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor');
                  $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente');
                  $this->form_validation->set_rules('deposito_codigo_deposito', 'Deposito','trim|xss_clean|required|callback_check_deposito');
                  $this->form_validation->set_rules('nave_codigo_nave','Nave','required|trim|xss_clean|callback_check_nave');
                  $this->form_validation->set_rules('naviera_codigo_naviera','Naviera','required|trim|xss_clean');
                  $this->form_validation->set_rules('numero_orden','O.S N°','required|trim|xss_clean|callback_check_orden');
                  
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
                    $data['navieras'] = $this->Navieras_model->listar_navieras();
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
                    $this->load->view('modal/modal_naves',$data);
		    $this->load->view('modal/modal_orden',$data);
                    $this->load->view('include/script');
                }
                else{
                  
                    	
                    $orden_bd = $this->Orden_model->get_orden($this->input->post('numero_orden'));
                    $id_viaje = $this->Viaje->seleccionar_viaje($orden_bd[0]['viaje_id_viaje']);
                    $camion = $this->Camiones_model->datos_camion($this->input->post('patente'));
                    
                    $viaje = array(
                                'camion_camion_id' => $camion['0']['camion_id'],
                                'conductor_rut' => $this->input->post('conductor_rut'),
                                'id_viaje' => $orden_bd[0]['viaje_id_viaje']
                            );
    
                    $aduana = explode(' - ', $this->input->post('aduana_codigo_aduana'));
                    $nave = explode(' - ',  $this->input->post('nave_codigo_nave'));
                    $bodega = explode(' - ',  $this->input->post('bodega_codigo_bodega'));
                    $destino = explode(' - ',  $this->input->post('destino'));
                    
                    $carga = explode(' - ', $this->input->post('tipo_carga_codigo_carga'));
                    
                    $tramo = explode(' - ', $this->input->post('tramo_codigo_tramo'));
                    $fecha = $this->input->post('fecha');
                    $fecha_presentacion = $this->input->post('fecha_presentacion');
                    
                    $fecha = str_replace('/','-', $fecha);
                    $fecha = date("Y-m-d H:i",strtotime($fecha));
                    
                    $fecha_presentacion = str_replace('/','-', $fecha_presentacion);
                    $fecha_presentacion = date("Y-m-d H:i",strtotime($fecha_presentacion));
                    
                    if($_POST['tipo_orden'] == "EXPORTACION"){
                        $deposito = explode(' - ', $this->input->post('deposito_codigo_deposito'));
                        $puerto = explode(' - ', $this->input->post('puerto_codigo_puerto'));
                    }
                    else{
                        $deposito[0] = 1;
                        $puerto[0] = 1;
                    }
                    if($_POST['tipo_orden'] == "IMPORTACION"){
                        $lugar_retiro = $_POST['lugar_retiro'];
                        
                    }
                    else{
                        $lugar_retiro = "N/A";
                    }
                    
                    if($_POST['tipo_orden'] == "OTRO SERVICIO"){
                        $destino[0] = -1 ;
                    }						
                    
                    $orden = array(
                        'id_orden' =>$this->input->post('numero_orden'),
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $fecha,
                        'cliente_rut_cliente' => $this->input->post('cliente_rut_cliente'),
                        'booking' => $this->input->post('booking'),
                        'aduana_codigo_aduana' => $aduana[0],
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'fecha_presentacion' => $fecha_presentacion,
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
                        'viaje_id_viaje' => $orden_bd[0]['viaje_id_viaje'],
                        'tramo_codigo_tramo' => $tramo[0],
                        'valor_costo_tramo' => str_replace(".", "",$this->input->post('valor_costo_tramo')),
                        'valor_venta_tramo' => str_replace(".", "",$this->input->post('valor_venta_tramo')),
                        'naviera_codigo_naviera' => $this->input->post('naviera_codigo_naviera'),
                        'lugar_retiro' => $lugar_retiro
                    );
                    
                    if(isset($_POST['enable_tramo'])){
                       $orden['tramo_codigo_tramo'] = -1;
                    }
                   
                    $tipo_ordenes = $this->Facturacion->tipo_orden();
                    foreach($tipo_ordenes as $tipo_orden){
                    
                        if($tipo_orden['tipo_orden'] == $this->input->post('tipo_orden')){
                             $orden['tipo_orden_id_tipo_orden'] = $tipo_orden['id_tipo_orden'];
                        }
                    }
                    

                    //guarda viaje y la orden.
                    $this->Viaje->editar_viaje($orden_bd[0]['viaje_id_viaje'],$viaje);
		            $this->Orden_model->editar_orden($orden,$this->input->post('numero_orden'));
					$this->Detalle->eliminar_detalle($this->input->post('numero_orden'));

                    $i = 0;
                    $num_orden = $this->input->post('numero_orden');
                    $costo = $this->input->post('valor_costo_servicio');
                    $venta = $this->input->post('valor_venta_servicio');
                    
                    if(isset($_POST['codigo_servicio'])){
                    					
                            foreach ($this->input->post('codigo_servicio') as $servicio){
                                $id_detalle = $this->Detalle->ultimo_codigo();
                                $id_detalle[0]['id_detalle'] = $id_detalle[0]['id_detalle'] + 1;                    		
                                $servicio = explode(' - ', $servicio);
                                $detalle = array(
                                    'id_detalle'               => $id_detalle[0]['id_detalle'],
                                    'servicio_codigo_servicio' => (int)$servicio,
                                    'orden_id_orden'           => $num_orden,
                                    'valor_costo'              => str_replace(".", "", $costo[$i]),
                                    'valor_venta'              => str_replace(".", "", $venta[$i])
                                );
                                $i = $i + 1;
                               //guarda uno a uno los detalles.
                               $this->Detalle->guardar_detalle($detalle);
                            }
                    }
		            $this->session->set_flashdata('sin_orden','La Orden de Servicio se edito con éxito');
                    redirect('transacciones/orden/formulario_editar/'.$_POST['numero_orden'],'refresh');

                }
                
        }    
                
        
        else{
            redirect('home','refresh');
        }
    }
    
    function editar_orden($dato = null){
        if($this->session->userdata('logged_in')){
            
            if(!$dato){
                $session_data = $this->session->userdata('logged_in');  
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/orden/editar_orden');
                $this->load->view('include/script');
            }
            else{
                
                $session_data = $this->session->userdata('logged_in');   
                
                if(isset($_POST['tipo_orden'])){
                    
                    if (!empty($_POST['desde'])){
                        $desde = $_POST['desde'];
                        $desde = str_replace('/','-', $desde);
                        $desde = date("Y-m-d H:i",strtotime($desde));
                        $_POST['desde'] = $desde; 
                    }
                    
                    if (!empty($_POST['hasta'])){
                        $hasta = $_POST['hasta'];
                        $hasta = str_replace('/','-', $hasta);
                        $hasta = date("Y-m-d H:i",strtotime($hasta));
                        $_POST['hasta'] = $hasta;
                    }
                    
                    $query = $this->Orden_model->buscar_ordenes($_POST['tipo_orden'],$_POST['desde'],$_POST['hasta'],  strtoupper($_POST['cliente']));
                    
                    $i=0;
                    foreach ($query as $orden){
                        
                        $estado_orden = $this->Facturacion->estado_orden_factura($orden['id_orden']);
                        //print_r($estado_orden);
                        if(isset($estado_orden[0])){
                            if($estado_orden[0]['estado_factura_id_estado_factura'] == 2 ){
                                $query[$i]['estado'] = "";
                                $query[$i]['estado'] = 2;
                            }
                        }
                    $i++;
                    }
                    
                    $data['ordenes'] = $query;

                }
                $this->load->view('include/head',$session_data);
                
                if(isset($_POST['tipo_orden'])){
                    $this->load->view('transaccion/orden/editar_orden',$data);
                }
                else{
                    $this->load->view('transaccion/orden/editar_orden');
                }
                
                $this->load->view('include/script');
            }
        }
        else{
                redirect('home','refresh');
            }
        
    }
    
    function eliminar_orden($id_orden = null){
        if($this->session->userdata('logged_in')){
            
            if (!$id_orden){
                $session_data = $this->session->userdata('logged_in');  
                $this->load->view('include/head',$session_data);
                $this->load->view('transaccion/orden/imprimir_orden');
                $this->load->view('include/script');
            }
            else{
                $this->Detalle->eliminar_detalle($id_orden);
                $this->Orden_model->eliminar_orden($id_orden);
            
                $this->session->set_flashdata('sin_orden','La orden se ha eliminado con éxito');
                redirect('transacciones/orden/imprimir_orden');
            }

        
        }
        else{
                redirect('home','refresh');
            }
    }
    
    function imprimir_orden($dato = null){
        if($this->session->userdata('logged_in')){
        	 if(!$dato){
		            $session_data = $this->session->userdata('logged_in');    
		            $this->load->view('include/head',$session_data);
		            $this->load->view('transaccion/orden/imprimir_orden');
		            $this->load->view('include/script');
			 }
            else{
                
                $session_data = $this->session->userdata('logged_in');   
                
                if(isset($_POST['tipo_orden'])){
                    
                    if (!empty($_POST['desde'])){
                        $desde = $_POST['desde'];
                        $desde = str_replace('/','-', $desde);
                        $desde = date("Y-m-d H:i",strtotime($desde));
                        $_POST['desde'] = $desde; 
                    }
                    
                    if (!empty($_POST['hasta'])){
                        $hasta = $_POST['hasta'];
                        $hasta = str_replace('/','-', $hasta);
                        $hasta = date("Y-m-d H:i",strtotime($hasta));
                        $_POST['hasta'] = $hasta;
                    }
                    
                    $query = $this->Orden_model->buscar_ordenes($_POST['tipo_orden'],$_POST['desde'],$_POST['hasta'],$_POST['cliente']);
                    
                    $i=0;
                    foreach ($query as $orden){
                        
                        $estado_orden = $this->Facturacion->estado_orden_factura($orden['id_orden']);
                        //print_r($estado_orden);
                        if(isset($estado_orden[0])){
                            if($estado_orden[0]['estado_factura_id_estado_factura'] == 2 ){
                            $query[$i]['estado'] = "";
                            $query[$i]['estado'] = 2;
                            }
                        }
                    $i++;
                    }
                    $data['ordenes'] = $query;

                }
                $this->load->view('include/head',$session_data);
                if(isset($_POST['tipo_orden'])){
                    $this->load->view('transaccion/orden/imprimir_orden',$data);
                }
                else{
                    $this->load->view('transaccion/orden/imprimir_orden');
                }
                
                $this->load->view('include/script');
            }
			 
        
        }
        else{
                redirect('home','refresh');
            }
    }
    
    function formulario_editar($id_orden = null){
        if($this->session->userdata('logged_in')){
            if($id_orden){
                
                $datos = $this->session->userdata('logged_in'); 
                $datos['numero_orden'] = $id_orden;
                
                $datos['orden'] = $this->Orden_model->get_orden($id_orden);
                $datos['tfacturacion'] = $this->Facturacion->tipo_orden();
                $datos['detalles'] = $this->Detalle->detalle_orden($id_orden);
                $i=0;
                foreach($datos['detalles'] as $detalle){
                    
                    $temporal = $this->Servicios_model->datos_servicio($datos['detalles'][$i]['servicio_codigo_servicio']);
                    $datos['detalles'][$i]['descripcion'] = $temporal[0]['descripcion'];
                    $i++;

                }
                $datos['cliente']         = $this->Clientes_model->datos_cliente($datos['orden'][0]['cliente_rut_cliente']);
                $datos['aduana']          = $this->Agencias_model->datos_aduana($datos['orden'][0]['aduana_codigo_aduana']);
                $datos['nave']            = $this->Naves_model->datos_nave($datos['orden'][0]['nave_codigo_nave']);
                $datos['naviera']         = $this->Navieras_model->get_naviera($datos['orden'][0]['naviera_codigo_naviera']);
                $datos['tramo']           = $this->Tramos_model->datos_tramo($datos['orden'][0]['tramo_codigo_tramo']);
                $datos['carga']           = $this->Cargas_model->datos_carga($datos['orden'][0]['tipo_carga_codigo_carga']);
                $datos['bodega']          = $this->Bodegas_model->datos_bodega($datos['orden'][0]['tipo_carga_codigo_carga']);
                $datos['deposito']        = $this->Depositos_model->datos_deposito($datos['orden'][0]['deposito_codigo_deposito']);
                $datos['destino']         = $this->Puertos_model->datos_puerto($datos['orden'][0]['destino']);
                $datos['puerto_embarque'] = $this->Puertos_model->datos_puerto($datos['orden'][0]['puerto_codigo_puerto']);
                $datos['proveedor']       = $this->Proveedores_model->datos_proveedor($datos['orden'][0]['proveedor_rut_proveedor']);
                $datos['viaje']           = $this->Viaje->seleccionar_viaje($datos['orden'][0]['viaje_id_viaje']);
                $datos['conductor']       = $this->Conductores_model->datos_conductor($datos['viaje'][0]['conductor_rut']);
                $datos['camion']          = $this->Camiones_model->getCamion($datos['viaje'][0]['camion_camion_id']);
                
                
                
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
                    $data['navieras'] = $this->Navieras_model->listar_navieras();
                    //echo "<pre>";
                    //print_r($datos);
                    //echo "</pre>";
                $this->load->view('include/head',$datos);
                $this->load->view('transaccion/orden/orden',$datos);
                
              
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
                    $this->load->view('modal/modal_naves',$data);
                $this->load->view('include/ready');
                $this->load->view('include/script');
            }
            else{
                redirect('/transacciones/orden/editar_orden','refresh');
            }
        }
        else{
            
        }
    }
            
    function pdf($id = null){
        $orden = $this->Orden_model->get_orden($id);

        
        if(count($orden) == 0){
            $this->session->set_flashdata('sin_orden','No existe la Orden de Servicio N° '.$_POST['numero_orden']);
            redirect('transacciones/orden','refresh');
            
        }
        else{
            $this->load->library('pdf');
            $nombre = $this->session->userdata('logged_in');
            $this->pdf = new Pdf();
            $this->pdf->setVar($nombre['nombre'],$orden[0]['id_orden']);
            $numero = $orden[0]['id_orden'];

            $this->pdf->SetTitle($id);
            $this->pdf->AddPage();
            $this->pdf->SetLeftMargin(15);
            $this->pdf->SetRightMargin(15);
            $this->pdf->SetFillColor(200,200,200);
            
            $nave = $this->Naves_model->datos_nave($orden[0]['nave_codigo_nave']);
            $cliente = $this->Clientes_model->datos_cliente($orden[0]['cliente_rut_cliente']);
            $tramo = $this->Tramos_model->datos_tramo($orden[0]['tramo_codigo_tramo']);
            $aduana = $this->Agencias_model->datos_aduana($orden[0]['aduana_codigo_aduana']);
            $carga = $this->Cargas_model->datos_carga($orden[0]['tipo_carga_codigo_carga']);
            $ret_cont = $this->Depositos_model->datos_deposito($orden[0]['deposito_codigo_deposito']);
            $bodega = $this->Bodegas_model->datos_bodega($orden[0]['bodega_codigo_bodega']);
            $puerto_embarque = $this->Puertos_model->datos_puerto($orden[0]['puerto_codigo_puerto']);
            $destino = $this->Puertos_model->datos_puerto($orden[0]['destino']);
            $proveedor = $this->Proveedores_model->datos_proveedor($orden[0]['proveedor_rut_proveedor']);
            $viaje = $this->Viaje->seleccionar_viaje($orden[0]['viaje_id_viaje']);
            $camion = $this->Camiones_model->getCamion($viaje[0]['camion_camion_id']);
            $chofer = $this->Conductores_model->datos_conductor($viaje[0]['conductor_rut']);
            $detalles = $this->Detalle->detalle_orden($orden[0]['id_orden']);
            

            $orden[0]['nave'] = $nave[0];
            $orden[0]['naviera'] = $this->Navieras_model->get_naviera($orden[0]['naviera_codigo_naviera']);
            $orden[0]['cliente']['rut_cliente'] = $cliente[0]['rut_cliente'];
            $orden[0]['cliente']['razon_social'] = $cliente[0]['razon_social'];
            $orden[0]['tramo']['tramo'] = $tramo[0]['descripcion'];
            $orden[0]['aduana'] = $aduana[0];
            $orden[0]['carga'] = $carga[0];
            $orden[0]['deposito'] = $ret_cont[0];
            $orden[0]['bodega'] = $bodega[0];
            $orden[0]['puerto'] = $puerto_embarque[0];
            $orden[0]['puerto_destino'] = $destino[0]; 
            $orden[0]['proveedor'] = $proveedor[0];
            $orden[0]['camion'] = $camion[0];
            $orden[0]['chofer'] = $chofer[0];
            $orden[0]['fecha_presentacion'] = date("d-m-Y H:i",strtotime($orden[0]['fecha_presentacion']));
            $orden[0]['fecha'] = date("d-m-Y H:i",strtotime($orden[0]['fecha']));
            
            for($j = 0;$j < count($detalles);$j++){
                $orden[0]['detalle'][$j]  = $detalles[$j];
                $datos =  $this->Servicios_model->datos_servicio($detalles[$j]['servicio_codigo_servicio']);
                $orden[0]['detalle'][$j]['datos'] = $datos[0];
            }

            //NACIONAL
            if ($orden[0]['tipo_orden_id_tipo_orden'] == 7 ){
                    $this->pdf->Ln(10); 
                    $this->pdf->SetFont('Arial', 'B', 12);
                    $this->pdf->Cell(150,0,'Cierre Nacional',0,0,'L','0');
                    $this->pdf->Cell(25,0,'Santiago, '.date("j/m/Y"),0,0,'R','0');
                    $this->pdf->Ln(10);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(180,7,"  ".utf8_decode("IDENTIFICACION"),'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Ref. Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Ref. '.utf8_decode("Exportacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia_2']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Nave','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['nave']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'ETA','0',0,'L',0);
                    $this->pdf->Cell(61,6,':','0',1,'L',0);

                    $this->pdf->Cell(60,6,'Booking','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['booking']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Naviera','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['naviera'][0]['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['cliente']['razon_social']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'RUT','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['cliente']['rut_cliente'],'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Tramo','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['tramo']['tramo']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Agencia Aduana','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['aduana']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Contacto AGA','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['aduana']['contacto']),'0',0,'L',0);

                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['aduana']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);


                    $this->pdf->Cell(180,7,"  CARGA",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Carga','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['carga']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Mercadería"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['mercaderia']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['numero'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Peso','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['peso']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Set Point','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['set_point']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Origen','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['deposito']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Fecha '.utf8_decode("Presentacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['fecha_presentacion'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Direccion").' Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['direccion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Contacto Bodega','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['bodega']['contacto']),'0',0,'L',0);
                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['bodega']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Destino','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['puerto_destino']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Observaciones','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['observacion']),'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);

                    $this->pdf->Cell(180,7,"  PROVEEDOR",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Proveedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['proveedor']['razon_social']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Patente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['camion']['patente']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Conductor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['chofer']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Celular','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['chofer']['telefono'],'0',1,'L',0);

                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);
            }

            //IMPORTACION
            if ($orden[0]['tipo_orden_id_tipo_orden'] == 6){
                    $this->pdf->Ln(10); 
                    $this->pdf->SetFont('Arial', 'B', 12);
                    $this->pdf->Cell(150,0,'Cierre de '.  utf8_decode("Importacion"),0,0,'L','0');
                    $this->pdf->Cell(25,0,'Santiago, '.date("j/m/Y"),0,0,'R','0');
                    $this->pdf->Ln(10);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(180,7,"  ".utf8_decode("IDENTIFICACION"),'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Ref. Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Ref. '.utf8_decode("Exportacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia_2']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Nave','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['nave']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'ETA','0',0,'L',0);
                    $this->pdf->Cell(61,6,':','0',1,'L',0);

                    $this->pdf->Cell(60,6,'Tarjeton','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.($orden[0]['booking']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Naviera','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.($orden[0]['naviera'][0]['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.($orden[0]['cliente']['razon_social']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'RUT','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['cliente']['rut_cliente'],'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Tramo','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.($orden[0]['tramo']['tramo']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Agencia Aduana','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['aduana']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Contacto AGA','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['aduana']['contacto']),'0',0,'L',0);

                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['aduana']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);


                    $this->pdf->Cell(180,7,"  CARGA",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Carga','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['carga']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Mercadería"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['mercaderia']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['numero']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Peso','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['peso']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Set Point','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['set_point']),'0',1,'L',0);
                    //RET Contenedor = deposito
                    $this->pdf->Cell(60,6,'Ret. Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['deposito']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Fecha '.utf8_decode("Presentacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['fecha_presentacion'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Direccion").' Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['direccion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Contacto Bodega','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['bodega']['contacto']),'0',0,'L',0);
                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['bodega']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Entrega '. utf8_decode("Vacio"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['puerto_destino']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Observaciones','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['observacion']),'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);

                    $this->pdf->Cell(180,7,"  PROVEEDOR",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Proveedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['proveedor']['razon_social'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Patente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['camion']['patente']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Conductor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['chofer']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Celular','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['chofer']['telefono'],'0',1,'L',0);

                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);
            }
            
            //EXPORTACION
            if ($orden[0]['tipo_orden_id_tipo_orden'] == 5){
                    $this->pdf->Ln(10); 
                    $this->pdf->SetFont('Arial', 'B', 12);
                    $this->pdf->Cell(150,0,'Cierre de Exportacion',0,0,'L','0');
                    $this->pdf->Cell(25,0,'Santiago, '.date("j/m/Y"),0,0,'R','0');
                    $this->pdf->Ln(5);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(180,7,"  ".utf8_decode("IDENTIFICACION"),'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Ref. Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Ref. '.utf8_decode("Exportacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia_2']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Nave','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['nave']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'ETA','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   ','0',1,'L',0);

                    $this->pdf->Cell(60,6,'Booking','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['booking'],'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Naviera','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['naviera'][0]['nombre'],'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['cliente']['razon_social']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'RUT','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['cliente']['rut_cliente'],'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Tramo','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['tramo']['tramo']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Agencia Aduana','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['aduana']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Contacto AGA','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['aduana']['contacto']),'0',0,'L',0);

                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['aduana']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);


                    $this->pdf->Cell(180,7,"  CARGA",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Carga','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['carga']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Mercaderia','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['mercaderia']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['numero']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Peso','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['peso']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Set Point','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['set_point']),'0',1,'L',0);
                    //RET Contenedor = deposito
                    $this->pdf->Cell(60,6,'Ret. Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['deposito']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Fecha de Presentacion','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['fecha_presentacion'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Direccion Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['direccion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Contacto Bodega','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['bodega']['contacto']),'0',0,'L',0);
                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['bodega']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Puerto Embarque','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['puerto']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Puerto Destino','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['puerto_destino']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Observaciones','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['observacion']),'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);

                    $this->pdf->Cell(180,7,"  PROVEEDOR",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Proveedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['proveedor']['razon_social']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Patente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['camion']['patente']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Conductor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['chofer']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Celular','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['chofer']['telefono'],'0',1,'L',0);

                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);
            }
            
            //OTROS SERVICIOS
            if ($orden[0]['tipo_orden_id_tipo_orden'] == 8){
                    $this->pdf->Ln(10); 
                    $this->pdf->SetFont('Arial', 'B', 12);
                    $this->pdf->Cell(150,0,'Cierre de Otro Servicio',0,0,'L','0');
                    $this->pdf->Cell(25,0,'Santiago, '.date("j/m/Y"),0,0,'R','0');
                    $this->pdf->Ln(5);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(180,7,"  ".utf8_decode("IDENTIFICACION"),'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Ref. Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Ref. '.utf8_decode("Exportacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['referencia_2']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Nave','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['nave']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'ETA','0',0,'L',0);
                    $this->pdf->Cell(61,6,':','0',1,'L',0);

                    $this->pdf->Cell(60,6,'Naviera','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['naviera'][0]['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Cliente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['cliente']['razon_social']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'RUT','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['cliente']['rut_cliente'],'0',1,'L',0);
                   
                    for($i = 0;$i < $orden[0]['num_servicios']; $i++ ){
                        $this->pdf->Cell(60,6,  utf8_decode("Descripcion"),'0',0,'L',0);
                        $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['detalle'][$i]['datos']['descripcion']),'0',1,'L',0);
                    }
                    
                    //DESCRIPCION DINAMICA
                    $this->pdf->Cell(60,6,'Agencia Aduana','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['aduana']['nombre']),'0',1,'L',0);

                    $this->pdf->Cell(60,6,'Contacto AGA','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['aduana']['contacto']),'0',0,'L',0);

                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['aduana']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);


                    $this->pdf->Cell(180,7,"  CARGA",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Carga','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['carga']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Mercaderia"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['mercaderia']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Contenedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['numero']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Peso','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['peso']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Set Point','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['set_point']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Fecha '.utf8_decode("Presentacion"),'0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['fecha_presentacion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['nombre']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,  utf8_decode("Direccion").' Bodega','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['bodega']['direccion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Contacto Bodega','0',0,'L',0);
                    $this->pdf->Cell(70,6,':   '.utf8_decode($orden[0]['bodega']['contacto']),'0',0,'L',0);
                    $this->pdf->Cell(20,6,'FONO','0',0,'L',0);
                    $this->pdf->Cell(30,6,':   '.$orden[0]['bodega']['telefono'],'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Observaciones','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['observacion']),'0',1,'L',0);
                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);

                    $this->pdf->Cell(180,7,"  PROVEEDOR",'B',0,'L',0);
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(60,6,'Proveedor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['proveedor']['razon_social']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'N'.utf8_decode('°').' Patente','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['camion']['patente']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Conductor','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.utf8_decode($orden[0]['chofer']['descripcion']),'0',1,'L',0);
                    $this->pdf->Cell(60,6,'Celular','0',0,'L',0);
                    $this->pdf->Cell(61,6,':   '.$orden[0]['chofer']['telefono'],'0',1,'L',0);

                    $this->pdf->Cell(180,8,"  ",'T',0,'L',0);
                    $this->pdf->Ln(7);
            }

            $numero = $id;	
            //ob_end_clean();
 
            $this->pdf->Output("Orden_de_Servicio_".$id.".pdf", 'D');
        }
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
            
            $this->form_validation->set_message('check_patente','La Patente del Camion que ingresa no se encuentra en el sistema, intente con otro.');
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
            
            $this->form_validation->set_message('check_deposito','El Deposito que ingresa no se encuentra en el sistema, intente con otro.');
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
            
            $this->form_validation->set_message('check_orden','La O.S. que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }

    function datos_ordensh($id_orden){
        
        //$this->Orden_model->get_orden($id_orden);
        
		$ret = $this->Orden_model->get_orden($id_orden);
		
		/*
		foreach ( $ret2 as $code_servicio) {
			$ret3[] = $this->Servicios_model->datos_servicio($code_servicio['servicio_codigo_servicio']);
		}
		
		$lastret = array_merge($ret,$ret3);
		*/
		
		
		return $ret;
        
    }
	
    function datos_detalle($id_orden_detalle) {
		$ret = $this->Orden_model->getDetalleByOrdenId($id_orden_detalle);
		foreach ( $ret as $id_servicio) {
			$servicio[] = $this->Servicios_model->datos_servicio($id_servicio['servicio_codigo_servicio']);
		}
		return $servicio;
	}
	
    function datosConductor($id_viaje)
	{
		$ret = $this->Viaje->seleccionar_viaje($id_viaje);
		//$ret[0]['conductor_rut'];
		
		// Patente 
		
		$ret3 = $this->Camiones_model->getCamion($ret[0]['camion_camion_id']);
		
		// Conductor
		$ret2 = $this->Conductores_model->datos_conductor($ret[0]['conductor_rut']);
		
		$lastret = array_merge($ret2, $ret3);
		
		return $lastret;
	}
}
?>