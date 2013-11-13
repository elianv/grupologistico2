<?php

class Orden extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('transacciones/Orden_model');
        $this->load->model('utils/Facturacion');
        $this->load->model('mantencion/Clientes_model');
        $this->load->model('mantencion/Agencias_model');
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
            
            $codigo = $this->Orden_model->ultimo_codigo();
            
            if ($codigo[0]['id_orden'] == ""){
                  $data['numero_orden'] = 1;
                          
              }
              else{
                  $data['numero_orden'] = $codigo[0]['id_orden'] + 1;
                  
              }
              print_r($data['tramos']);
            $this->load->view('include/head',$session_data);
            $this->load->view('transaccion/orden',$data);
            $this->load->view('modal/modal_aduana', $data);
            $this->load->view('modal/modal_cliente',$data);
            $this->load->view('modal/modal_tramo',$data);
            $this->load->view('include/script');
        }
          
        else{
            redirect('home','refresh');
        }
                
        
    }
    
}

?>
