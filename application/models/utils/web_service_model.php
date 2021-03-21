<?php 
	/**
	* 
	*/
	class Web_service_model extends CI_Model
	{
		
            function __construct()
            {
                    parent::__construct();
            }
            
            function get($campo, $valor){
                $query = $this->db->get_where('web_service', array($campo=>$valor));
                        
                return $query->result_array();
            }


	}
?>