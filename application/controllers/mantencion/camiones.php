<?php

class Camiones extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Camiones_model');
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_camion($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['tablas'] = $this->Camiones_model->listar_camiones();
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/camiones',$data);
				$this->load->view('include/script');
			}
			else{
				redirect('home','refresh');
			}

		}
	}
    
    function guardar_camion(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('patente', 'Patente','trim|required|xss_clean|callback_check_database|exact_length[6]');
            
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $data['tablas'] = $this->Camiones_model->listar_camiones();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/camiones',$data);
                $this->load->view('include/script');
            }
            else{
                
                $camion = array(
                            'patente' => strtoupper($this->input->post('patente'))
                            );
                
                $this->Camiones_model->insertar_camion($camion);
                $this->session->set_flashdata('mensaje','Camión guardado con éxito');
                redirect('mantencion/camiones','refresh');   
            }
            
        }
        else{
            redirect('home','refresh');
        }
    }
   
        function modificar_camion(){
        if($this->session->userdata('logged_in')){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('patente', 'Patente','trim|required|xss_clean|exact_length[6]');
            
            
            if($this->form_validation->run() == FALSE){
                $session_data = $this->session->userdata('logged_in');
                $data['tablas'] = $this->Camiones_model->listar_camiones();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/camiones',$data);
                $this->load->view('include/script');
            }
            else{
                
                $camion = array(
                            'patente' => strtoupper($this->input->post('patente'))
                            
                            );
                $this->Camiones_model->modificar_camion($camion,$this->input->post('id_camion'));
                $this->session->set_flashdata('mensaje','Camión editado con éxito');
                redirect('mantencion/camiones','refresh');   
            }
            
        }
        else{
            redirect('home','refresh');
        }
    }
    
    function check_database($patente){
               
        $result = $this->Camiones_model->patente_repetida($patente);
        
        if($result){
            
            $this->form_validation->set_message('check_database','La Patetente que ingresa ya se encuentra en el sistema, intente con otra.');
            return false;
        }
        else{
            
            return true;
        }
    }
	
	function datos_camion($rut){
        
        $this->Camiones_model->datos_camion($rut);
        
		$ret = $this->Camiones_model->datos_camion($rut);
		return $ret;
        
    }
}
?>
