<?php

class Orden extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Orden_model');
        $this->load->model('utils/Facturacion');
        $this->load->model('mantencion/Clientes_model');
        $this->load->model('mantencion/Agencias_model');
        $this->load->model('mantencion/Bodegas_model');
        $this->load->model('mantencion/Puertos_model');
        $this->load->model('mantencion/Proveedores_model');
        $this->load->model('mantencion/Camiones_model');
        $this->load->model('mantencion/Servicios_model');
        $this->load->model('mantencion/Conductores_model');
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
            $this->load->view('include/script');
        }
          
        else{
            redirect('home','refresh');
        }
                
        
    }
    
}

?>
