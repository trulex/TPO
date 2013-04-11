<?php
class Get_users extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
}
?>