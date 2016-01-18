<?php 
	/**
	* 
	*/
	class Web_service extends AnotherClass
	{
		
		function __construct()
		{
			parent::__construct();
		}

		function manager()
		{
			$this->db->select('url, name');

			$query = $this->db->get('web_service');

			return $query->result();
		}
	}
?>