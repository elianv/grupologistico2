<?php

class Especificos extends CI_Controller{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('especificos/especificos_model');
	}

	public function index()
	{
		redirect('main','refresh');
	}

	public function codigos_sistema()
	{
		if($this->session->userdata('logged_in'))
		{
		
			$session_data = $this->session->userdata('logged_in');

			$data['codigos'] = $this->especificos_model->codigos_sistema();
            $this->load->view('include/head',$session_data);
            $this->load->view('especificos/codigo_sistema',$data);
            $this->load->view('include/script');	
        }	
        else
        	redirect('home','refresh');
	}

	public function guardar_codigo_sistema()
	{
		if($this->session->userdata('logged_in') && isset($_POST['nombre']))
		{
			$session_data = $this->session->userdata('logged_in');

            $this->load->library('form_validation');
            $this->form_validation->set_rules('cta_contable', 'Cuenta Contable','trim|xss_clean|numeric|required');
            $this->form_validation->set_rules('nombre', 'Nombre ítem','trim|xss_clean|required|');			
            $this->form_validation->set_rules('codigo', 'Código Sistema','trim|xss_clean|required|numeric|callback_check_codigo_guardar');

            if($this->form_validation->run() == FALSE)
            {
				$data['codigos'] = $this->especificos_model->codigos_sistema();
	            $this->load->view('include/head',$session_data);
	            $this->load->view('especificos/codigo_sistema',$data);
	            $this->load->view('include/script');	
            } 
            else
            {
            	$codigo = array(
            		'item' => $this->input->post('nombre'), 
            		'cuenta_contable' => $this->input->post('cta_contable'),
            		'codigo_sistema' => $this->input->post('codigo'),
            		);
            	$this->especificos_model->guardar_codigo_sistema($codigo);

                $this->session->set_flashdata('mensaje','Código creado con exito');
                redirect('especificos/especificos/codigos_sistema','refresh');            	
            }


        }	
        else
        	redirect('home','refresh');
	}

	public function editar_codigo_sistema()
	{
		if($this->session->userdata('logged_in') && isset($_POST['id']))
		{
			$session_data = $this->session->userdata('logged_in');

            $this->load->library('form_validation');
            $this->form_validation->set_rules('cta_contable', 'Cuenta Contable','trim|xss_clean|numeric|required');
            $this->form_validation->set_rules('nombre', 'Nombre ítem','trim|xss_clean|required|');			
            $this->form_validation->set_rules('codigo', 'Código Sistema','trim|xss_clean|required|numeric|callback_check_codigo_editar');
            $this->form_validation->set_rules('id', 'Código Sistema','trim|xss_clean|callback_check_id');

            if($this->form_validation->run() == FALSE)
            {
				$data['codigos'] = $this->especificos_model->codigos_sistema();
	            $this->load->view('include/head',$session_data);
	            $this->load->view('especificos/codigo_sistema',$data);
	            $this->load->view('include/script');	
            } 
            else
            {
            	$id     = $this->input->post('id');
            	$codigo = array(
            		'item' => $this->input->post('nombre'), 
            		'cuenta_contable' => $this->input->post('cta_contable'),
            		'codigo_sistema' => $this->input->post('codigo')
            	);

            	$this->especificos_model->editar_codigo_sistema($codigo,$id);

                $this->session->set_flashdata('mensaje','Código editado con exito');
                redirect('especificos/especificos/codigos_sistema','refresh');            	
            }


        }	
        else
        	redirect('home','refresh');
	}	

    public function parametros(){
        if($this->session->userdata('logged_in'))
        {
        
            $session_data = $this->session->userdata('logged_in');
            $data['correlativo'] = $this->especificos_model->correlativo_os();
            $this->load->view('include/head',$session_data);
            $this->load->view('especificos/parametros',$data);
            $this->load->view('include/script');    
        }   
        else
            redirect('home','refresh');        
    }

    public function guardar_parametro(){
        if($this->session->userdata('logged_in'))
        {
        
            $session_data = $this->session->userdata('logged_in');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('correlativo_os', 'Correlativo ','trim|xss_clean|numeric|required');
            if($this->form_validation->run() == FALSE)
            {
                $data['correlativo'] = $this->especificos_model->correlativo_os();
                $this->load->view('include/head',$session_data);
                $this->load->view('especificos/parametros',$data);
                $this->load->view('include/script');                    
            }            
            else{
                $data = array(  'parametro' => 'CORRELATIVO', 
                                'valor' => $this->input->post('correlativo_os')
                            );
                $this->especificos_model->guardar_correlativo_os($data);
                $this->session->set_flashdata('mensaje','Correlativo creado con exito');
                redirect('especificos/especificos/parametros','refresh');  

            }                        
 
        }   
        else
            redirect('home','refresh');           
    }

	public function check_id($id)
	{
    
        $result = $this->especificos_model->existe_id_codigo_sistema($id);
        
        if($result > 0){
            
            return true;
        }
        else{
            $this->form_validation->set_message('check_id','El código de sistema que desea editar no existe.');
            return false;
            
        }
    }

	public function check_codigo_guardar($codigo)
	{
        $result = $this->especificos_model->existe_codigo_sistema_guardar($codigo);
        
        if($result == 0){
            
            return true;
        }
        else{
            $this->form_validation->set_message('check_codigo_guardar','El código de sistema que ingresa ya existe.');
            return false;
            
        }
	}

	public function check_codigo_editar($codigo)
	{
		$id     = $this->input->post('id');
        $result = $this->especificos_model->existe_codigo_sistema_editar($codigo,$id);
        
        if($result == 0){
            
            return true;
        }
        else{
            $this->form_validation->set_message('check_codigo_editar','El código de sistema que ingresa ya existe.');
            return false;
            
        }		
	}

}

?>