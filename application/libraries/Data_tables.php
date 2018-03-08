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
	
	function __construct($params = NULL)
	{
		$this->CI =& get_instance();
		$this->titulos = $params['titulos'];
		$this->titulo = $params['titulo'];
		$this->clase = $params['clase'];

	}


	function render(){

		$datos = array('titulos' => $this->titulos,
						'titulo' => $this->titulo,
						'clase'	=> $this->clase,
					);
		$view = $this->CI->load->view('obj/data_tables',$datos,true);
		return $view;
	}
	
	function ajax_tabla(){

		$columns = '';
		foreach ($this->titulos as $key => $value) {
			$columns .= "{data:\"{$value}\"},";
		}
		$js ="
		        $('#tabla-facturas').DataTable({
		            \"processing\": true,
		            \"serverSide\": true,
		            \"bProcessing\": true,
		            \"ajax\": \"{$this->ajax}\" ,
		
		            columns: [{$columns}]
		        });";
	}



}