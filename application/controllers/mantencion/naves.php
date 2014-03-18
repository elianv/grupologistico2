<?php
class Naves extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Naves_model');
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_naves($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
					   
				$session_data = $this->session->userdata('logged_in');
				$datos['navieras'] = $this->Naves_model->nombre_navieras();
				
			   
				$data['tablas'] = $this->Naves_model->listar_naves();
				$resultado = $this->Naves_model->ultimo_codigo();
				
				if ($resultado[0]['codigo_nave'] == ""){
					  $data['codigo_nave'] = 1;
							  
				  }
				  else{
					  $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
					  
				  }
						   
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/naves',$data);
				$this->load->view('modal/modal_naves',$datos);
				$this->load->view('include/script');
			}
			
			else{
				redirect('home','refresh');
			}
        }
    }
    
    function modificar_nave(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre Nave','trim|required|xss_clean');
            $this->form_validation->set_rules('codigo_naviera', 'Codigo Naviera','trim|xss_clean|required|callback_check_unique');
           
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $datos['navieras'] = $this->Naves_model->nombre_navieras();
                                
                $resultado = $this->Naves_model->ultimo_codigo();
                $data['tablas'] = $this->Naves_model->listar_naves();
                if ($resultado[0]['codigo_nave'] == ""){
                    $data['codigo_nave'] = 1;
                          
                }
                else{
                    $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
                }
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('mantencion/naves',$data);
                    $this->load->view('modal/modal_naves',$datos);
                    $this->load->view('include/script');
                }
            else{
                
                $codigo_naviera = explode("-",$this->input->post('codigo_naviera'));               
                $nave = array(
                        'nombre' => $this->input->post('nombre'),
                        'naviera_codigo_naviera' => $codigo_naviera[0]
                        );
                $codigo_nave = $this->input->post('codigo_nave');
                
                $this->Naves_model->modificar_nave($nave,$codigo_nave);
               
                redirect('mantencion/naves','refresh');
 
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
    }

    function guardar_nave(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre Nave','trim|required|xss_clean');
            $this->form_validation->set_rules('codigo_naviera', 'Codigo Naviera','trim|xss_clean|required|callback_check_unique');
           
            if($this->form_validation->run() == FALSE){
                
                $session_data = $this->session->userdata('logged_in');
                $datos['navieras'] = $this->Naves_model->nombre_navieras();
                                
                $resultado = $this->Naves_model->ultimo_codigo();
                $data['tablas'] = $this->Naves_model->listar_naves();
                if ($resultado[0]['codigo_nave'] == ""){
                    $data['codigo_nave'] = 1;
                          
                }
                else{
                    $data['codigo_nave'] = $resultado[0]['codigo_nave'] + 1;
                  
                }
                    
                    $this->load->view('include/head',$session_data);
                    $this->load->view('mantencion/naves',$data);
                    $this->load->view('modal/modal_naves',$datos);
                    $this->load->view('include/script');
                }
            else{
                
                $codigo_naviera = explode("-",$this->input->post('codigo_naviera'));
                $nave = array(
                        'nombre' => $this->input->post('nombre'),
                        'naviera_codigo_naviera' => $codigo_naviera[0]
                        );
                $this->Naves_model->insertar_nave($nave);
                redirect('mantencion/naves','refresh');
                 
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
    }
    
    function check_unique($codigo){
              
        $codigo_naviera = explode("-",$codigo);
        $result = $this->Naves_model->existe($codigo_naviera[0]);
                
        if($result){
            $this->form_validation->set_message('check_unique','El codigo de Naviera que ingresa no se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
            
        }
        /*print_r($codigo);
        $this->load->view('prueba');
         */
    }
    
    function datos_naves($rut){
        
        $this->Naves_model->datos_nave($rut);
        
		$ret = $this->Naves_model->datos_nave($rut);
		return $ret;
        
    }
	
}
?>
