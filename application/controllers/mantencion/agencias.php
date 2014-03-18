<?php

class Agencias extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Agencias_model');
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_aduanas($codigo));
			
			echo $response;
		
		} else{
		
			if($this->session->userdata('logged_in')){
				
			 $session_data = $this->session->userdata('logged_in');
			 $resultado = $this->Agencias_model->ultimo_codigo();
			 
			 
			 if ($resultado[0]['codigo_aduana'] == ""){
				$data['form']['codigo_aduana'] = 1;
					  
			 }
			 else{
				$data['form']['codigo_aduana'] = $resultado[0]['codigo_aduana'] + 1;
			  
			 }
			 
			 $data['tablas'] = $this->Agencias_model->listar_agencias();
			 $this->load->view('include/head',$session_data);
			 $this->load->view('mantencion/agencias',$data);
			 $this->load->view('include/script');
			 
			}
			else{
			 redirect('home','refresh');
			}
		}          
    }
    
    function guardar_aduana(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_aduana', 'Código Agencia','trim|xss_clean|numeric');
            $this->form_validation->set_rules('nombre', 'Nombre Agencia','trim|xss_clean|required');
           
            if($this->form_validation->run() == FALSE){ 
                
                    $session_data = $this->session->userdata('logged_in');
                    $resultado = $this->Agencias_model->ultimo_codigo();
                                     
                 if ($resultado[0]['codigo_aduana'] == ""){
                    $data['form']['codigo_aduana'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_aduana'] = $resultado[0]['codigo_aduana'] + 1;
                  
                 }
                 $data['tablas'] = $this->Agencias_model->listar_agencias();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/agencias',$data);
                 $this->load->view('include/script');
            }
            
            else{
                
                $agencia = array(
                                'nombre' => $this->input->post('nombre'),
                                'contacto' => $this->input->post('contacto'),
                                'telefono' => $this->input->post('telefono')
                            );
                            
                $this->Agencias_model->insertar_agencia($agencia);
                redirect('mantencion/agencias','refresh');
                
            }
        }
        else{
                 redirect('home','refresh');
             }
    }
    
    function modificar_aduana(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('codigo_aduana', 'Código Agencia','trim|xss_clean|numeric');
            $this->form_validation->set_rules('nombre', 'Nombre Agencia','trim|xss_clean|required');
           
            if($this->form_validation->run() == FALSE){ 
                
                    $session_data = $this->session->userdata('logged_in');
                    $resultado = $this->Agencias_model->ultimo_codigo();
                                     
                 if ($resultado[0]['codigo_aduana'] == ""){
                    $data['form']['codigo_aduana'] = 1;
                          
                 }
                 else{
                    $data['form']['codigo_aduana'] = $resultado[0]['codigo_aduana'] + 1;
                  
                 }
                 $data['tablas'] = $this->Agencias_model->listar_agencias();
                 $this->load->view('include/head',$session_data);
                 $this->load->view('mantencion/agencias',$data);
                 $this->load->view('include/script');
            }
            
            else{
                
                $agencia = array(
                                'nombre' => $this->input->post('nombre'),
                                'contacto' => $this->input->post('contacto'),
                                'telefono' => $this->input->post('telefono')
                            );
                            
                $codigo_agencia = $this->input->post('codigo_aduana');
            
                $this->Agencias_model->modificar_agencia($agencia,$codigo_agencia);                
                redirect('mantencion/agencias','refresh');
                
            }
        }
        else{
                 redirect('home','refresh');
             }
    }
	
	function datos_aduanas($rut){
        
        $this->Agencias_model->datos_aduana($rut);
        
		$ret = $this->Agencias_model->datos_aduana($rut);
		return $ret;
        
    }
	
}
?>