<?php

class Proveedores extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('mantencion/Proveedores_model');
        
        
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_proveedores($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
					   
				$session_data = $this->session->userdata('logged_in');
				
				$data['tablas'] = ($this->Proveedores_model->listar_proveedores());
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/proveedores',$data);
				$this->load->view('include/script');
			}
			
			else{
				redirect('home','refresh');
			}
           
        }
		
		//Fin Juano
		/*
			if($this->session->userdata('logged_in')){
					   
				$session_data = $this->session->userdata('logged_in');
				
				$data['tablas'] = ($this->Proveedores_model->listar_proveedores());
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/proveedores',$data);
				$this->load->view('include/script');
			}
			
			else{
				redirect('home','refresh');
			}
		*/
		
    }
    
    function borrar_proveedor(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            

            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            
            if($this->form_validation->run() == FALSE){
                
                $data['tablas'] = $this->Proveedores_model->listar_proveedores();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/proveedores',$data);
                $this->load->view('include/script');
            }
            
            else{
            
            }
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_proveedor(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]|callback_check_database');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tablas'] = $this->Proveedores_model->listar_proveedores();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/proveedores',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'direccion' => $this->input->post('direccion'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_proveedor' => $this->input->post('rut'),
                                    'fono' => $this->input->post('telefono'),
                                );
                

                $this->Proveedores_model->insertar($arreglo);
                $this->session->set_flashdata('mensaje','Proveedor guardado con éxito');
                redirect('mantencion/proveedores','refresh');
                }
            }
            
        
        
        else{
            redirect('home','refresh');
        }
        
    }

    function modificar_proveedor(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tablas'] = $this->Proveedores_model->listar_proveedores();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/proveedores',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'direccion' => $this->input->post('direccion'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_proveedor' => $this->input->post('rut'),
                                    'fono' => $this->input->post('telefono'),
                                );
                
                $rut_proveedor = $this->input->post('rut');
                
                $this->Proveedores_model->modificar($arreglo,$rut_proveedor);
                $this->session->set_flashdata('mensaje','Proveedor editado con éxito');
                redirect('mantencion/proveedores','refresh');
                }
            }
            
        
        
        else{
            redirect('home','refresh');
        }
        
    }
        
    function check_database($rut){
        $rut2 = $this->input->post('rut');
        
        $result = $this->Proveedores_model->repetido($rut);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El RUT que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
	
	function datos_proveedores($rut){
        
        $this->Proveedores_model->datos_proveedor($rut);
        
		$ret = $this->Proveedores_model->datos_proveedor($rut);
		return $ret;
        
    }
     
}

?>
