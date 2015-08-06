<?php

class Usuarios extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('utils/Usuario');
        $this->load->model('especificos/Usuarios_model');
        
        
    }
    
    function index(){
	
		$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
		
		if(isset($codigo) && $codigo != ''){
			
			// set no layout para que el response del ajax sea de la consulta al modelo segun el rut, return array..
			// codigo aqui..
			$response = json_encode($this->datos_usuarios($codigo));
			
			echo $response;
		
		} else{
        
			if($this->session->userdata('logged_in')){
					   
				$session_data = $this->session->userdata('logged_in');            
 
				$data['tusuario'] = $this->Usuario->GetTipo();
				$data['tablas'] = ($this->Usuarios_model->listar_usuarios());
				$this->load->view('include/head',$session_data);
				$this->load->view('especificos/usuarios',$data);
				$this->load->view('include/script');
				 
			}
			
			else{
				redirect('home','refresh');
			}
           
        }
    }
    
/*    function borrar_tramo(){
        
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
*/    

    function guardar_usuario(){
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de moneda para el formulario
            $data['tusuario'] = $this->Usuario->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre','trim|required|xss_clean');
            $this->form_validation->set_rules('clave', 'Clave','trim|required|xss_clean');
			$this->form_validation->set_rules('rut_usuario', 'rut_usuario','trim|required|xss_clean');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                
                $data['tusuario'] = $this->Usuario->GetTipo();
                
                $data['tablas'] = $this->Usuarios_model->listar_usuarios();               
                $this->load->view('include/head',$session_data);
                $this->load->view('especificos/usuarios',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                					'rut_usuario' => $this->input->post('rut_usuario'),
                                    'nombre' => $this->input->post('nombre'),
                                    'clave' => $this->input->post('clave'),
                                );

                $tusuario = $this->Usuario->GetTipo();
                

                foreach($tusuario as $dato){
                    if($dato['id'] == $this->input->post('tusuario')){
                        $arreglo['tipo_usuario'] = $dato['id'];
                    }
                }

                $this->Usuarios_model->insertar($arreglo);
                $this->session->set_flashdata('mensaje','Usuario guardado con éxito');
                redirect('especificos/usuarios','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }

/*    
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
                $this->session->set_flashdata('mensaje','Tramo editado con éxito');
                redirect('mantencion/tramos','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }

 * 
 */	
	function datos_usuario($rut){
        
        $this->Usuarios_model->datos_usuario($rut);
        
		$ret = $this->Usuarios_model->datos_usuario($rut);
		return $ret;
        
    }
     
}

?>
