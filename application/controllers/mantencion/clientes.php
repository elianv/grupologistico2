<?php

class Clientes extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/Facturacion');
        $this->load->model('mantencion/Clientes_model');
        
        
    }
    
    function index(){
		
		//Juano
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_cliente($codigo));
			
			echo $response;
			
		} else {
		
			if($this->session->userdata('logged_in')){
                   
				$session_data = $this->session->userdata('logged_in');
				
				$data['tfacturacion'] = $this->Facturacion->GetTipo();
				$data['tablas'] = ($this->Clientes_model->listar_clientes());
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/clientes',$data);
				$this->load->view('include/script');
			}
        
			else{
				redirect('home','refresh');
			}
		
		}
        //fin Juano
		
        /*if($this->session->userdata('logged_in')){
                   
            $session_data = $this->session->userdata('logged_in');
            
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            $data['tablas'] = ($this->Clientes_model->listar_clientes());
            $this->load->view('include/head',$session_data);
            $this->load->view('mantencion/clientes',$data);
            $this->load->view('include/script');
        }
        
        else{
            redirect('home','refresh');
        }*/
           
        
    }
    
    function borrar_cliente(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            

            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            
            if($this->form_validation->run() == FALSE){
                
                $data['tfacturacion'] = $this->Facturacion->GetTipo();
                $data['tablas'] = $this->Clientes_model->listar_clientes();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
            }
            
            else{
            
            }
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_cliente(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de facturacion para el formulario
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]|callback_check_database');
            $this->form_validation->set_rules('dplazo', 'Días Plazo','numeric');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tfacturacion'] = $this->Facturacion->GetTipo();
                $data['tablas'] = $this->Clientes_model->listar_clientes();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'contacto' => $this->input->post('contacto'),
                                    'direccion' => $this->input->post('direccion'),
                                    'dias_plazo' => $this->input->post('dplazo'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_cliente' => $this->input->post('rut'),
                                    'fono' => $this->input->post('telefono'),
                                    'tipo_factura_id_tipo_facturacion' => ""
                                );
                $tfacturas = $this->Facturacion->GetTipo();
                 
                foreach($tfacturas as $dato){
                    
                    if($dato['tipo_facturacion'] == $this->input->post('tfactura')){
                         $arreglo['tipo_factura_id_tipo_facturacion'] = $dato['id_tipo_facturacion'];
                    }
                }

                $this->Clientes_model->insertar($arreglo);
                
                redirect('mantencion/clientes','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function modificar_cliente(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de facturacion para el formulario
            $data['tfacturacion'] = $this->Facturacion->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('rut', 'RUT','trim|required|xss_clean|min_length[7]');
            $this->form_validation->set_rules('dplazo', 'Días Plazo','numeric');
            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tfacturacion'] = $this->Facturacion->GetTipo();
                $data['tablas'] = $this->Clientes_model->listar_clientes();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/clientes',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'celular' => $this->input->post('celular'),
                                    'ciudad' => $this->input->post('ciudad'),
                                    'comuna' => $this->input->post('comuna'),
                                    'contacto' => $this->input->post('contacto'),
                                    'direccion' => $this->input->post('direccion'),
                                    'dias_plazo' => $this->input->post('dplazo'),
                                    'giro' => $this->input->post('giro'),
                                    'razon_social' => $this->input->post('rsocial'),
                                    'rut_cliente' => $this->input->post('rut'),
                                    'fono' => $this->input->post('telefono'),
                                    'tipo_factura_id_tipo_facturacion' => ""
                                );
                $tfacturas = $this->Facturacion->GetTipo();
                 
                foreach($tfacturas as $dato){
                    
                    if($dato['tipo_facturacion'] == $this->input->post('tfactura')){
                         $arreglo['tipo_factura_id_tipo_facturacion'] = $dato['id_tipo_facturacion'];
                    }
                }

                $rut_cliente = $this->input->post('rut');
                $this->Clientes_model->modificar($arreglo,$rut_cliente);
                
                redirect('mantencion/clientes','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }

    function check_database($rut){
        $rut2 = $this->input->post('rut');
        
        $result = $this->Clientes_model->repetido($rut);
        
        if($result){
            
            $this->form_validation->set_message('check_database','El RUT que ingresa ya se encuentra en el sistema, intente con otro.');
            return false;
        }
        else{
            
            return true;
        }
            
    }
    
    function datos_cliente($rut){
        
        $this->Clientes_model->datos_cliente($rut);
        
		$ret = $this->Clientes_model->datos_cliente($rut);
		return $ret;
        
    }
     
}

?>
