<?php
//Created by lovrenc
class Tasks extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, task_name, text FROM tasks");
		return $query->result();
	}
	function getOwn(){
		$query = $this->db->query("SELECT id, task_name, text FROM tasks where UID={$data['id']}");
		return $query->result();
	}
}

?>