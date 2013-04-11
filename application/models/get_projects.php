<?php
class Get_projects extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
	function getID($UName){
		$query = $this->db->query("SELECT id FROM projects WHERE project_name='$UName'");
		return $query->result();
	}
}
?> 