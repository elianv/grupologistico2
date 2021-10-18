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
            
            //obtengo los tipo de usuario para el formulario
            $data['tusuario'] = $this->Usuario->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre','trim|required|xss_clean');
            $this->form_validation->set_rules('clave', 'Clave','trim|required|xss_clean');
			$this->form_validation->set_rules('rut_usuario', 'rut_usuario','trim|required|xss_clean|callback_valida_rut');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                                
                $data['tablas'] = $this->Usuarios_model->listar_usuarios();               
                $this->load->view('include/head',$session_data);
                $this->load->view('especificos/usuarios',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                $arreglo = array(
                					'rut_usuario' => $this->input->post('rut_usuario'),
                                    'nombre' => $this->input->post('nombre'),
                                    'clave' => md5($this->input->post('clave')),
                                    'id_tipo_usuario' => $this->input->post('tusuario'),
                                );

                $this->Usuarios_model->insertar($arreglo);
                $this->session->set_flashdata('mensaje','Usuario guardado con éxito');
                redirect('especificos/usuarios','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }
        
    }
 
    function modificar_usuario(){
        
        
        if($this->session->userdata('logged_in')){
            
            //asigno los datos de session
            $session_data = $this->session->userdata('logged_in');
            
            //obtengo los tipo de usuario para el formulario
            $data['tusuario'] = $this->Usuario->GetTipo();
            //inicializo la validacion de campos
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nombre', 'Nombre','trim|required|xss_clean');
            //$this->form_validation->set_rules('clave', 'Clave','trim|required|xss_clean');
			$this->form_validation->set_rules('rut_usuario', 'rut_usuario','trim|required|xss_clean');

            // si validacion incorrecta
            if($this->form_validation->run() == FALSE){
                                
                $data['tablas'] = $this->Usuarios_model->listar_usuarios();               
                $this->load->view('include/head',$session_data);
                $this->load->view('especificos/usuarios',$data);
                $this->load->view('include/script');
            }
            
            else{
                
                if ($this->input->post('clave') != ''){
                    $arreglo = array(
                                    'rut_usuario' => $this->input->post('rut_usuario'),
                                    'nombre' => $this->input->post('nombre'),
                                    'clave' => md5($this->input->post('clave')),
                                    'id_tipo_usuario' => $this->input->post('tusuario')
                                );                    
                }
                else{
                    $arreglo = array(
                                    'rut_usuario' => $this->input->post('rut_usuario'),
                                    'nombre' => $this->input->post('nombre'),
                                    'id_tipo_usuario' => $this->input->post('tusuario')
                                );                          
                }
                
                $this->Usuarios_model->modificar($arreglo,$arreglo['rut_usuario']);
                $this->session->set_flashdata('mensaje','Usuario modificado con éxito');
                redirect('especificos/usuarios','refresh');
              
            }
            
        }
        
        else{
            redirect('home','refresh');
        }    }

	function datos_usuario($rut){
        
        $this->Usuarios_model->datos_usuario($rut);
        
		$ret = $this->Usuarios_model->datos_usuario($rut);
		return $ret;
        
    }
     
    function valida_rut($rut)
    {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        foreach(array_reverse(str_split($numero)) as $v)
        {
            if($i==8)
                $i = 2;
    
            $suma += $v * $i;
            ++$i;
        }
    
        $dvr = 11 - ($suma % 11);
        
        if($dvr == 11)
            $dvr = 0;
        if($dvr == 10)
            $dvr = 'K';
    
        if($dvr != strtoupper($dv)){
            $this->form_validation->set_message('valida_rut','RUT ingresado no es válido.');
            return false;
        }
    }

}

?>
