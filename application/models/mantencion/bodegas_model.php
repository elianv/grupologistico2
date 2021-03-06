<?php
class Bodegas_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    function ultimo_codigo(){
        $this->db->select_max('codigo_bodega');
        $result = $this->db->get('bodega');

            return $result->result_array();
    }

    function insertar_bodega($bodega){
        if($this->db->insert('bodega', $bodega)){
            return true;
        }
        else{
            return false;
        }

    }

    function modificar_bodega($bodega,$codigo_bodega){
        $this->db->where('codigo_bodega',$codigo_bodega);

        if($this->db->update('bodega', $bodega)){
            return true;
        }
        else{
            return false;
        }

    }

    function listar_bodegas(){
        $this->db->select('codigo_bodega,nombre');
        $resultado = $this->db->get('bodega');

        return $resultado->result_array();

    }

    function existe_nombre($nombre){

        $this->db->select('nombre');
        $this->db->from('bodega');
        $this->db->where('nombre',$nombre);
        $query = $this->db->get();

        if($query->num_rows() == 0){

            return false;
        }

        else{

            return true;
        }

    }

    function existe_nombre_editar($bodega, $id)
    {

        $this->db->select('nombre')
                    ->from('bodega')
                    ->where('nombre',$bodega)
                    ->where('codigo_bodega !=',$id);

        $query = $this->db->get();

        if($query->num_rows() == 0){

            return false;
        }

        else{

            return true;
        }

    }    

    function existe_bodega($bodega){
        $this->db->select ('codigo_bodega');
        $this->db->from('bodega');
        $this->db->where('codigo_bodega',$bodega);

        $query = $this->db->get();

        if($query->num_rows() == 0){

            return true;
        }

        else{

            return false;
        }
    }

	function datos_bodega($rut) {
			$this->db->select ();
			$this->db->from('bodega');
			$this->db->where('codigo_bodega',$rut);
			$resultado = $this->db->get();

			return $resultado->result_array();

    }


}
?>
