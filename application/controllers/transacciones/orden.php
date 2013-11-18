<?php

class Orden extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Orden_model');
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
        
    }
            
    function index(){
        
        if($this->session->userdata('logged_in')){
            
            $session_data = $this->session->userdata('logged_in');
            //tipo facturacion
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
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
            $this->load->view('include/script');
        }
          
        else{
            redirect('home','refresh');
        }
                
        
    }
    
    function guardar(){
        
            if($this->session->userdata('logged_in')){
                
                
                $this->load->library('form_validation');
                
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
                
               
                
                if($this->form_validation->run() == FALSE){
                    $session_data = $this->session->userdata('logged_in');
                    //tipo facturacion
                    $data['tfacturacion'] = $this->Facturacion->GetTipo();
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
                    
                    
                    echo "</br>";
                    
                    
                    $orden = array(
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
                        'viaje_id_viaje' => $ultimo_viaje[0]['id_viaje'],
                        'tipo_carga_codigo_carga'	=> $this->input->post('carga'),
                        'tipo_factura_id_tipo_facturacion' => ''
                    );
                    
                    $tfacturas = $this->Facturacion->GetTipo();
                 
                    foreach($tfacturas as $tfactura){
                    
                        if($tfactura['tipo_facturacion'] == $this->input->post('tipo_factura')){
                             $orden['tipo_factura_id_tipo_facturacion'] = $tfactura['id_tipo_facturacion'];
                        }
                    }
                    
                    print_r($orden);
                    $this->load->view('prueba');
                    
                    $this->Orden_model->insert_orden($orden);
                    //redirect('transaccion/orden','refresh');

                    
                    $this->load->view('prueba');
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
}
?>
