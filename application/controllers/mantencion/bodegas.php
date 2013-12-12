<?php

class Bodegas extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Bodegas_model');
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_bodegas($codigo));
			
			echo $response;
		
		} else{
    
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				
				$data['tablas'] = $this->Bodegas_model->listar_bodegas();
				$resultado = $this->Bodegas_model->ultimo_codigo();
				
				if ($resultado[0]['codigo_bodega'] == ""){
					  $data['form']['codigo_bodega'] = 1;
							  
				  }
				  else{
					  $data['form']['codigo_bodega'] = $resultado[0]['codigo_bodega'] + 1;
					  
				  }
				
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/bodegas',$data);
				$this->load->view('include/script');
			}
			else{
				redirect('home','refresh');
			}
        }
    }
    
    function guardar_bodega(){
         
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre','trim|required|xss_clean|callback_check_unico');
           
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
            
                $data['tablas'] = $this->Bodegas_model->listar_bodegas();
                $resultado = $this->Bodegas_model->ultimo_codigo();
            
                if ($resultado[0]['codigo_bodega'] == ""){
                   $data['form']['codigo_bodega'] = 1;
                          
                }
                else{
                  $data['form']['codigo_bodega'] = $resultado[0]['codigo_bodega'] + 1;
                }
                
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/bodegas',$data);
                $this->load->view('include/script');
            }
            else{
                $bodega = array(
                            'nombre' => $this->input->post('nombre'),
                            'direccion' => $this->input->post('direccion'),
                            'contacto' => $this->input->post('contacto'),
                            'telefono' => $this->input->post('telefono')
                                );
                $this->Bodegas_model->insertar_bodega($bodega);
                redirect('mantencion/bodegas','refresh');
                $this->load->view('prueba');
            }
                  
        }
        else{
            redirect('home','refresh');
        }
    }

    function modificar_bodega(){
         
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre','trim|required|xss_clean|callback_check_unico');
           
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
            
                $data['tablas'] = $this->Bodegas_model->listar_bodegas();
                $resultado = $this->Bodegas_model->ultimo_codigo();
            
                if ($resultado[0]['codigo_bodega'] == ""){
                   $data['form']['codigo_bodega'] = 1;
                          
                }
                else{
                  $data['form']['codigo_bodega'] = $resultado[0]['codigo_bodega'] + 1;
                }
                
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/bodegas',$data);
                $this->load->view('include/script');
            }
            else{
                $bodega = array(
                            'nombre' => $this->input->post('nombre'),
                            'direccion' => $this->input->post('direccion'),
                            'contacto' => $this->input->post('contacto'),
                            'telefono' => $this->input->post('telefono')
                                );
                
                $codigo_bodega = $this->input->post('codigo_bodega');
                $this->Bodegas_model->modificar_bodega($bodega,$codigo_bodega);
                redirect('mantencion/bodegas','refresh');
                $this->load->view('prueba');
            }
                  
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function check_unico($nombre){
        
        
        $result = $this->Bodegas_model->existe_nombre($nombre);
        
        if($result){
            $this->form_validation->set_message('check_unico','El Nombre que ingresa se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            return true;
            
        }
    }
	
	function datos_bodegas($rut){
        
        $this->Bodegas_model->datos_bodega($rut);
        
		$ret = $this->Bodegas_model->datos_bodega($rut);
		return $ret;
        
    }
	
}
?>
