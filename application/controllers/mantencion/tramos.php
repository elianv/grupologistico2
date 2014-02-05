<?php

class Tramos extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/Moneda');
        $this->load->model('mantencion/Tramos_model');
        
        
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_tramos($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
					   
				$session_data = $this->session->userdata('logged_in');            
				$resultado = $this->Tramos_model->ultimo_codigo();

				if ($resultado[0]['codigo_tramo'] == ""){
					$data['form']['cod_tramo'] = 1;
					 
				  
				}
				else{
					$data['form']['cod_tramo'] = $resultado[0]['codigo_tramo'] + 1;
				}
	 
				$data['tmoneda'] = $this->Moneda->GetTipo();
				$data['tablas'] = ($this->Tramos_model->listar_tramos());
				$this->load->view('include/head',$session_data);
				$this->load->view('mantencion/tramos',$data);
				$this->load->view('include/script');
				 
			}
			
			else{
				redirect('home','refresh');
			}
           
        }
    }
    
    function borrar_tramo(){
        
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            

            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE){
                
                $data['tmoneda'] = $this->Moneda->GetTipo();
                $data['tablas'] = $this->Tramos_model->listar_tramos();
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/tramos',$data);
                $this->load->view('include/script');
            }
            
            else{
            
            }
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function guardar_tramo(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de moneda para el formulario
            $data['tmoneda'] = $this->Moneda->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            $this->form_validation->set_rules('valor_costo', 'Valor Costo','numeric');
            $this->form_validation->set_rules('valor_venta', 'Valor Venta','numeric');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tmoneda'] = $this->Moneda->GetTipo();
                $resultado = $this->Tramos_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_tramo'] == ""){
                      $data['form']['cod_tramo'] = 1;
                }
              
                else{
                      $data['form']['cod_tramo'] = $resultado[0]['codigo_tramo'] + 1;
                }
                
                $data['tablas'] = $this->Tramos_model->listar_tramos();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/tramos',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'descripcion' => $this->input->post('descripcion'),
                                    'valor_costo' => $this->input->post('valor_costo'),
                                    'valor_venta' => $this->input->post('valor_venta'),
                                    'moneda_id_moneda' => ""
                                );

                $arreglo['valor_venta'] = str_replace(".", "", $arreglo['valor_venta']);
                $arreglo['valor_costo'] = str_replace(".", "", $arreglo['valor_costo']);

                $tmoneda = $this->Moneda->GetTipo();
                

                foreach($tmoneda as $dato){
                    if($dato['id_moneda'] == $this->input->post('tmoneda')){
                        $arreglo['moneda_id_moneda'] = $dato['id_moneda'];
                    }
                }

                $this->Tramos_model->insertar($arreglo);
                
                redirect('mantencion/tramos','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
    
    function modificar_tramo(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de moneda para el formulario
            $data['tmoneda'] = $this->Moneda->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('descripcion', 'Descripción','trim|required|xss_clean');
            $this->form_validation->set_rules('valor_costo', 'Valor Costo','numeric');
            $this->form_validation->set_rules('valor_venta', 'Valor Venta','numeric');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tmoneda'] = $this->Moneda->GetTipo();
                $resultado = $this->Tramos_model->ultimo_codigo();
                             
                if ($resultado[0]['codigo_tramo'] == ""){
                      $data['form']['cod_tramo'] = 1;
                }
              
                else{
                      $data['form']['cod_tramo'] = $resultado[0]['codigo_tramo'] + 1;
                }
                
                $data['tablas'] = $this->Tramos_model->listar_tramos();               
                $this->load->view('include/head',$session_data);
                $this->load->view('mantencion/tramos',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                                    'codigo_tramo' => $this->input->post('codigo_tramo'),
                                    'descripcion' => $this->input->post('descripcion'),
                                    'valor_costo' => $this->input->post('valor_costo'),
                                    'valor_venta' => $this->input->post('valor_venta'),
                                    'moneda_id_moneda' => ""
                                );

                $arreglo['valor_venta'] = str_replace(".", "", $arreglo['valor_venta']);
                $arreglo['valor_costo'] = str_replace(".", "", $arreglo['valor_costo']);

                $tmoneda = $this->Moneda->GetTipo();
                 
                foreach($tmoneda as $dato){
                    
                    if($dato['id_moneda'] == $this->input->post('tmoneda')){
                         $arreglo['moneda_id_moneda'] = $dato['id_moneda'];
                    }
                }

                $codigo_tramo = $this->input->post('codigo_tramo');
                $this->Tramos_model->modificar($arreglo,$codigo_tramo);
                
                redirect('mantencion/tramos','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
	
	function datos_tramos($rut){
        
        $this->Tramos_model->datos_tramo($rut);
        
		$ret = $this->Tramos_model->datos_tramo($rut);
		return $ret;
        
    }
     
}

?>
