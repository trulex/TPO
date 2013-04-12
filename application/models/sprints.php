<?php
class Sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints");
		return $query->result();
	}
}
?> 
