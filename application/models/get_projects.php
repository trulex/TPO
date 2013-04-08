<?php
class Get_projects extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
}
?> 
