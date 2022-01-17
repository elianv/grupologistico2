<?php



/**
* 
*/
class Data_tables
{

	public $titulos;
	public $titulo;
	public $columns;
	public $clase;
	public $ajax;
	public $vista;
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}


	function setData($params){
		$this->titulos 	= (isset($params['titulos'])) ? $params['titulos'] : '';
		$this->titulo 	= (isset($params['titulo'])) ? $params['titulo'] : '';
		$this->clase 	= (isset($params['clase'])) ? $params['clase'] : '';
		$this->ajax 	= (isset($params['ajax'])) ? $params['ajax'] : '';
		$this->botones  = (isset($params['botones'])) ? $params['botones'] : NULL;
		$this->columns 	= (isset($params['columns'])) ? $params['columns'] : '';
		$this->vista	= (isset($params['vista'])) ? $params['vista'] : '';
	}

	function render($otro_js = NULL){

		$datos = array('titulos' 	=> $this->titulos,
						'titulo' 	=> $this->titulo,
						'clase'		=> $this->clase,
						'botones'	=> $this->botones,
					);
		if ($this->vista == 'tabla_modal')

			$view['table'] = $this->CI->load->view('obj/table_modal',$datos,true);
		else
			$view['table'] = $this->CI->load->view('obj/data_tables',$datos,true);
		
		$view['js'] = $this->ajax_tabla();

		if(!is_null($otro_js)){
			$view['otro_js'] = $this->CI->load->view($otro_js, $datos,true);
		}
		return $view;
	}
	
	function ajax_tabla(){

		$columns = '';
		foreach ($this->columns as $key => $value) {
			$columns .= "{data:\"{$value}\"},\n";
		}
		$js ="	
		        $('#tabla-{$this->clase}').DataTable({
		            \"processing\": true,
		            \"serverSide\": true,
		            \"bProcessing\": true,
		            \"ajax\": {
						\"url\" : \"{$this->ajax}\",
						\"type\" : \"POST\",
					},
		            columns: [{$columns}]
		        });";
		return $js;
	}

	function dTables_ajax($ruta_model,$nombre_model, $function, $POST, $opc=array()){
                $inicio    = $POST['start'];
                $cantidad  = $POST['length'];
                $where     = $POST['search']['value'];
                $order     = $POST['order'][0]['dir'];
                $by        = $POST['order'][0]['column'];

                $this->CI->load->model($ruta_model.'/'.$nombre_model);
                
                $total = $this->CI->$nombre_model->$function($inicio, $cantidad,$where,$order,$by,1, $opc);

                $data['draw']              = $POST['draw'];
                $data['recordsTotal']      = $total;
                $data['recordsFiltered']   = $total;
                $data['data']              = $this->CI->$nombre_model->$function($inicio, $cantidad,$where,$order,$by, 0, $opc);
                return $data;

	}



}