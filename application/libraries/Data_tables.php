<?php



/**
* 
*/
class Data_tables
{

	public $titulos;
	public $titulo;
	public $pColumna;
	public $clase;
	public $ajax;
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		

	}


	function setData($params){
		$this->titulos 	= $params['titulos'];
		$this->titulo 	= $params['titulo'];
		$this->clase 	= $params['clase'];
		$this->ajax 	= $params['ajax'];
		$this->botones  = $params['botones'];
	}

	function render(){

		$datos = array('titulos' 	=> $this->titulos,
						'titulo' 	=> $this->titulo,
						'clase'		=> $this->clase,
						'js_ajax' 	=> $this->ajax_tabla(),
						'botones'	=> $this->botones
					);

		$view = $this->CI->load->view('obj/data_tables',$datos,true);
		return $view;
	}
	
	function ajax_tabla(){

		$columns = '';
		foreach ($this->titulos as $key => $value) {
			$columns .= "{data:\"{$value}\"},\n";
		}
		$js ="	
		        $('#tabla-{$this->clase}').DataTable({
		            \"processing\": true,
		            \"serverSide\": true,
		            \"bProcessing\": true,
		            \"ajax\": \"{$this->ajax}\" ,
		
		            columns: [{$columns}]
		        });";
		return $js;
	}

	function dTables_ajax($ruta_model,$nombre_model, $function, $GET){
                $inicio    = $GET['start'];
                $cantidad  = $GET['length'];
                $where     = $GET['search']['value'];
                $order     = $GET['order'][0]['dir'];
                $by        = $GET['order'][0]['column'];

                $this->CI->load->model($ruta_model.'/'.$nombre_model);
                
                $total = $this->CI->$nombre_model->$function($inicio, $cantidad,$where,$order,$by,1,0);

                $data['draw']              = $GET['draw'];
                $data['recordsTotal']      = $total;
                $data['recordsFiltered']   = $total;
                $data['data']              = $this->CI->$nombre_model->$function($inicio, $cantidad,$where,$order,$by);
                return $data;

	}



}