<?php

class Servicios extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Servicios_model');
        $this->load->model('especificos/especificos_model');
        $this->load->model('utils/Moneda');
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_servicios($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
						
					 $session_data         = $this->session->userdata('logged_in');
					 $resultado            = $this->Servicios_model->ultimo_codigo();
					 $data['monedas']      = $this->Moneda->GetTipo();
                     $data['cod_sistemas'] = $this->especificos_model->codigos_sistema();
					 
					 
					 if ($resultado[0]['codigo_servicio'] == ""){
						 $data['form']['codigo_servicio'] = 1;
							  
					 }
					 else{
						$data['form']['codigo_servicio'] = $resultado[0]['codigo_servicio'] + 1;
					  
					 }
					 
					 $data['tablas'] = $this->Servicios_model->listar_servicios();
					 $this->load->view('include/head',$session_data);
					 $this->load->view('mantencion/servicios',$data);
					 $this->load->view('include/script');
					 
				 }
				 else{
					 redirect('home','refresh');
				 }
			}
    }
    
    function modificar_servicio(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo', 'Codigo Servicio','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean|');
            $this->form_validation->set_rules('vcosto', 'Valor Costo','trim|numeric|xss_clean|');
            $this->form_validation->set_rules('vventa', 'Valor Venta','trim|numeric|xss_clean|');
            $this->form_validation->set_rules('moneda','Moneda','required|xss_clean');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){     
            
            
                 $session_data = $this->session->userdata('logged_in');
                 $resultado = $this->Servicios_model->ultimo_codigo();
                 $data['monedas'] = $this->Moneda->GetTipo();
                 
                 
                 if ($resultado[0]['codigo_servicio'] == ""){
                     $data['form']['codigo_servicio'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_servicio'] = $resultado[0]['codigo_servicio'] + 1;
                  
                 }
                 
                 $data['tablas'] = $this->Servicios_model->listar_servicios();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/servicios',$data);
                 $this->load->view('include/script');
            }
            else{
                
                $servicio = array(
                                'descripcion'       => $this->input->post('descripcion'),
                                'valor_costo'       => str_replace(".", "", $this->input->post('vcosto') ),
                                'valor_venta'       => str_replace(".", "", $this->input->post('vventa') ),
                                'moneda_id_moneda'  => "",
                                'id_codigo_sistema' => $this->input->post('cod_sistema')
                                
                            );
                $monedas = $this->Moneda->GetTipo();
                
                foreach($monedas as $moneda){
                    
                    if($moneda['moneda'] == $this->input->post('moneda')){
                         $servicio['moneda_id_moneda'] = $moneda['id_moneda'];
                    }
                }
                                
                $codigo_servicio = $this->input->post('codigo');
                $this->Servicios_model->modificar_servicio($servicio,$codigo_servicio);
                $this->session->set_flashdata('mensaje','Servicio modificado con éxito');
                redirect('mantencion/servicios/index','refresh');
               
            }
        }
        else{
            redirect('home','refresh');
        }
    }

    function guardar_servicio(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo', 'Codigo Servicio','trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean|');
            $this->form_validation->set_rules('vcosto', 'Valor Costo','trim|numeric|xss_clean|');
            $this->form_validation->set_rules('vventa', 'Valor Venta','trim|numeric|xss_clean|');
            $this->form_validation->set_rules('moneda','Moneda','required|xss_clean');
            
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){     
            
            
                 $session_data = $this->session->userdata('logged_in');
                 $resultado = $this->Servicios_model->ultimo_codigo();
                 $data['monedas'] = $this->Moneda->GetTipo();
                 
                 
                 if ($resultado[0]['codigo_servicio'] == ""){
                     $data['form']['codigo_servicio'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_servicio'] = $resultado[0]['codigo_servicio'] + 1;
                  
                 }
                 
                 $data['tablas'] = $this->Servicios_model->listar_servicios();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/servicios',$data);
                 $this->load->view('include/script');
            }
            else{
                
                $servicio = array(
                                'descripcion'       => $this->input->post('descripcion'),
                                'valor_costo'       => str_replace(".", "", $this->input->post('vcosto') ),
                                'valor_venta'       => str_replace(".", "", $this->input->post('vventa') ),
                                'moneda_id_moneda'  => "",
                                'id_codigo_sistema' => $this->input->post('cod_sistema')
                                
                            );
                $monedas = $this->Moneda->GetTipo();
                
                foreach($monedas as $moneda){
                    
                    if($moneda['moneda'] == $this->input->post('moneda')){
                         $servicio['moneda_id_moneda'] = $moneda['id_moneda'];
                    }
                }
                
                $this->Servicios_model->insertar_servicio($servicio);
                $this->session->set_flashdata('mensaje','Servicio guardado con éxito');
                
                redirect('mantencion/servicios','refresh');
               
            }
        }
        else{
            redirect('home','refresh');
        }
    }

    function datos_servicios($rut){
        
        $this->Servicios_model->datos_servicio($rut);
        
		$ret = $this->Servicios_model->datos_servicio($rut);
		return $ret;
        
    }
	
}

?>

