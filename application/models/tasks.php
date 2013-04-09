<?php
//Created by lovrenc
class Tasks extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, task_name, text, StID FROM tasks");
		return $query->result();
	}
	function getOwn($id){
		$query = $this->db->query("SELECT id, task_name, text, StID FROM tasks where UID=$id");
		return $query->result();
	}
	function insert($row){
		$this->db->insert('task',$row);
	}
}

?>