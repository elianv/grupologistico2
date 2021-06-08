<?php

class Generica extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    /*
     * $where array campo de la tabla=> valor a buscar
     * 
     */
    function SqlSelect($campos, $tabla, $where, $var_dump){
        
        $this->db->select($campos);
        $this->db->from($tabla);

        if (!is_null($where)){
            $this->db->where($where);
        }


        $result = $this->db->get();
        if($var_dump){
            var_dump($this->db->last_query());	
        }

        return $result->result_array();

    }
    
    function SqlInsert($tabla, $campos){
        $this->db->trans_start();
        $this->db->insert($tabla, $campos);
        $query = $this->db->query('SELECT LAST_INSERT_ID() as last_id');
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
                return False;
        }        

        
        $result = $query->result_array();
        return $result[0]['last_id'];
    }

    function column_long($tabla, $campo){
        $this->db->select('CHARACTER_MAXIMUM_LENGTH');
        $this->db->from('information_schema.`COLUMNS`');
        $this->db->where('TABLE_NAME', $tabla);
        $this->db->where('COLUMN_NAME', $campo);
        $query = $this->db->get();

        return $query->result_array();
    }
    }

?>