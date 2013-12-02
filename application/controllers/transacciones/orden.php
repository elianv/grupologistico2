<?php

class Orden extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Orden_model');
        $this->load->model('transacciones/Orden_detalle_model');
        $this->load->model('utils/Facturacion');
        $this->load->model('utils/Viaje');
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
                 /*
                  $this->form_validation->set_rules('cliente','RUT Cliente','trim|xss_clean|required|min_length[7]|callback_check_cliente');
                  $this->form_validation->set_rules('tramo','Tramo','trim|xss_clean|numeric|required|callback_check_tramo');
                  $this->form_validation->set_rules('aduana','Aduana','trim|xss_clean|numeric|required|callback_check_aduana');
                  $this->form_validation->set_rules('bodega','Bodega','trim|xss_clean|numeric|required|callback_check_bodega');
                  $this->form_validation->set_rules('puerto','Puerto','trim|xss_clean|numeric|required|callback_check_puerto');
                  $this->form_validation->set_rules('rut','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor');
                  $this->form_validation->set_rules('servicio','Servicio','trim|xss_clean|required|numeric|callback_check_servicio');
                  $this->form_validation->set_rules('carga','Carga','trim|xss_clean|required|numeric|callback_check_carga');
                  $this->form_validation->set_rules('conductor','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor');
                  $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente');
                  $this->form_validation->set_rules('deposito', 'Deposito','trim|xss_clean|required|numeric|callback_check_deposito');
                  * 
                  */
                  $this->form_validation->set_rules('nave','Nave','trim|xss_clean|numeric|required|callback_check_nave');
                  
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
                    $viaje = array(
                                'camion_patente' => $this->input->post('patente'),
                                'conductor_rut' => $this->input->post('conductor')
                            );
                    //$this->Viaje->crear_viaje($viaje);
                    //obtengo ultimo viaje creado
                    $ultimo_viaje = $this->Viaje->ultimo_codigo();
                    
                   $orden = array(
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $this->input->post('fecha'),
                        'cliente_rut_cliente' => $this->input->post('cliente'),
                        'booking' => $this->input->post('booking'),
                        'aduana_codigo_aduana' => $this->input->post('aduana'),
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'ret_contenedor' => $this->input->post('contenedor'),
                        'fecha_presentacion' => $this->input->post('fecha_prensentacion'),
                        'bodega_codigo_bodega' => $this->input->post('bodega'),
                        'puerto_embarque' => $this->input->post('destino'),
                        'puerto_codigo_puerto' => $this->input->post('puerto'),
                        'proveedor_rut_proveedor' => $this->input->post('rut'),
                        'observacion' => $this->input->post('observacion'),
                        'servicio_codigo_servicio' => $this->input->post('servicio'),
                        'referencia_2' => $this->input->post('referencia2'),
                        'viaje_id_viaje' => $ultimo_viaje[0]['id_viaje'],
                        'tipo_carga_codigo_carga'	=> $this->input->post('carga'),
                        'tipo_factura_id_tipo_facturacion' => '',
                        'deposito_codigo_deposito' => $this->input->post('deposito'),
                        'nave_codigo_nave' => $this->input->post('nave'),
                        'mercaderia' =>  $this->input->post('mercaderia')  
                    );
                   
                    $tipo_ordenes = $this->Facturacion->tipo_orden();
                 
                    foreach($tipo_ordenes as $tipo_orden){
                    
                        if($tipo_orden['tipo_orden'] == $this->input->post('tipo_factura')){
                             $orden['tipo_orden_id_tipo_tipo_orden'] = $tipo_orden['id_tipo_orden'];
                        }
                    }
                    
                    $detalle = array(
                                    'servicio_codigo_servicio' => $this->input->post('servicio'),
                                    'tramo_codigo_tramo'=> $this->input->post('tramo'),
                                    'orden_id_orden'=> $this->input->post('numero_orden'),
                                );
                   
                                print_r($_POST);
                                
                                if(isset($_POST['valores_tramo'])){
                                    echo "</br>";
                                    echo "check box tramo seleccionado";
                                }
                                
                                if(isset($_POST['valores_servicio'])){
                                    echo "</br>";   
                                    echo "check box servicio seleccionado";
                                }
                    //$this->Orden_model->insert_orden($orden);
                    //$this->Orden_detalle_model->guardar_detalle($detalle);
                    //redirect('transacciones/orden','refresh');
                    
                    
                    //$this->load->view('prueba');
                    $this->pdf->Output("Lista de alumnos.pdf", 'I');

                    
                }
            }
            
            else{
                redirect('home','refresh');
            }
            
    }
    
    function editar(){
        if($this->session->userdata('logged_in')){
            
                $this->load->library('form_validation');
                 
                $this->form_validation->set_rules('numero_orden','O.S. N°','trim|xss_clean|required|numeric|callback_check_orden');
                $this->form_validation->set_rules('cliente','RUT Cliente','trim|xss_clean|required|min_length[7]|callback_check_cliente2');
                $this->form_validation->set_rules('tramo','Tramo','trim|xss_clean|numeric|required|callback_check_tramo2');
                $this->form_validation->set_rules('aduana','Aduana','trim|xss_clean|numeric|required|callback_check_aduana2');
                $this->form_validation->set_rules('bodega','Bodega','trim|xss_clean|numeric|required|callback_check_bodega2');
                $this->form_validation->set_rules('puerto','Puerto','trim|xss_clean|numeric|required|callback_check_puerto2');
                $this->form_validation->set_rules('rut','Rut Proveedor','trim|xss_clean|min_length[7]|required|callback_check_proveedor2');
                $this->form_validation->set_rules('servicio','Servicio','trim|xss_clean|required|numeric|callback_check_servicio2');
                $this->form_validation->set_rules('carga','Carga','trim|xss_clean|required|numeric|callback_check_carga2');
                $this->form_validation->set_rules('conductor','Conductor','trim|xss_clean|required|min_length[7]|callback_check_conductor2');
                $this->form_validation->set_rules('patente','Patente','trim|xss_clean|required|exact_length[6]|callback_check_patente2');
                $this->form_validation->set_rules('deposito', 'Deposito','trim|xss_clean|required|numeric|callback_check_deposito2');
                $this->form_validation->set_rules('nave','Nave','trim|xss_clean|numeric|required|callback_check_nave2');
                
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
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('transaccion/orden',$data);
                    $this->load->view('modal/modal_aduana', $data);
                    $this->load->view('modal/modal_cliente',$data);
                    $this->load->view('modal/modal_tramo',$data);
                    $this->load->view('modal/modal_bodega',$data);
                    $this->load->view('modal/modal_puerto',$data);
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
                    
                    
                    $viaje = array(
                        'camion_patente' => $this->input->post('patente'),
                        'conductor_rut' => $this->input->post('conductor')
                    );
                    
                    //obtengo id del viaje a editar
                    $id_viaje = $this->Orden_model->obtener_viaje($this->input->post('numero_orden'));
                    $id_viaje = $id_viaje[0]['viaje_id_viaje'];
                                        
                    //cambio el chofer y camion del viaje y luego lo asocio a la orden 
                    $this->Viaje->editar_viaje($id_viaje,$viaje);
                    
                    $orden = array(
                        'id_orden' => $this->input->post('numero_orden'),
                        'referencia' => $this->input->post('referencia'),
                        'fecha' => $this->input->post('fecha'),
                        'cliente_rut_cliente' => $this->input->post('cliente'),
                        'booking' => $this->input->post('booking'),
                        'tramo_codigo_tramo' => $this->input->post('tramo'),
                        'aduana_codigo_aduana' => $this->input->post('aduana'),
                        'numero' => $this->input->post('numero'),
                        'peso' => $this->input->post('peso'),
                        'set_point' => $this->input->post('set_point'),
                        'ret_contenedor' => $this->input->post('contenedor'),
                        'fecha_presentacion' => $this->input->post('fecha_prensentacion'),
                        'bodega_codigo_bodega' => $this->input->post('bodega'),
                        'puerto_embarque' => $this->input->post('destino'),
                        'puerto_codigo_puerto' => $this->input->post('puerto'),
                        'proveedor_rut_proveedor' => $this->input->post('rut'),
                        'observacion' => $this->input->post('observacion'),
                        'servicio_codigo_servicio' => $this->input->post('servicio'),
                        'referencia_2' => $this->input->post('referencia2'),
                        'viaje_id_viaje' => $id_viaje,
                        'tipo_carga_codigo_carga'	=> $this->input->post('carga'),
                        'tipo_factura_id_tipo_facturacion' => '',
                        'deposito_codigo_deposito' => $this->input->post('deposito'),
                        'nave_codigo_nave' => $this->input->post('nave')
                    );
                    
                    $tfacturas = $this->Facturacion->GetTipo();
                 
                    foreach($tfacturas as $tfactura){
                    
                        if($tfactura['tipo_facturacion'] == $this->input->post('tipo_factura')){
                             $orden['tipo_factura_id_tipo_facturacion'] = $tfactura['id_tipo_facturacion'];
                        }
                    }
                    
                    $this->Orden_model->editar_orden($orden);
                    redirect('transacciones/orden','refresh');
                    
               }
            
        }
        
        else{
            redirect('home','refresh');
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
