<?php

class Especificos_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }

    public function codigos_sistema(){
    	$this->db->select('*');
    	$this->db->from('codigos_sistema');

    	$result = $this->db->get();

    	return $result->result_array();
    }
    public function codigos_sistema_otros(){
        $this->db->select('*');
        $this->db->from('codigos_sistema');
        $this->db->where('id != 1');

        $result = $this->db->get();

        return $result->result_array();
    }    

    public function guardar_codigo_sistema($codigo)
    {
         
        $this->db->insert('codigos_sistema', $codigo);

    }    

    public function editar_codigo_sistema($codigo, $id)
    {
		$this->db->where('id', $id);
		$this->db->update('codigos_sistema', $codigo);     	
    }

    public function existe_id_codigo_sistema($id)
    {
    	$this->db->select('*');
    	$this->db->from('codigos_sistema');
    	$this->db->where('id', $id);

    	$result = $this->db->get();

    	return $result->num_rows();    	
    }

    public function existe_codigo_sistema_guardar($codigo)
    {
    	$this->db->select('*');
    	$this->db->from('codigos_sistema');
    	$this->db->where('codigo_sistema', $codigo);

    	$result = $this->db->get();

    	return $result->num_rows();    	
    }    
    public function existe_codigo_sistema_editar($codigo,$id)
    {
    	$this->db->select('*');
    	$this->db->from('codigos_sistema');
    	$this->db->where('codigo_sistema', $codigo);
    	$this->db->where('id !=', $id);

    	$result = $this->db->get();

    	return $result->num_rows();    	
    }      

}

?>