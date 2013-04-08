<?php
//Created by lovrenc
class Get_tasks extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM tasks");
		return $query->result();
	}
	function getOwn(){
		$query = $this->db->query("SELECT * FROM tasks where UID={$data['id']}");
		return $query->result();
	}
}

?>