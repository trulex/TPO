<?php
//Created by lovrenc
class Tasks extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, task_name, text, StID, UID, accepted FROM tasks");
		return $query->result();
	}
	function getOwn($id){
		$query = $this->db->query("SELECT id, task_name, text, StID, UID, accepted FROM tasks where UID=$id");
		return $query->result();
	}
	function getCurrent($StID){
		$query=$this->db->query("SELECT id, task_name, text, StID, UID FROM tasks where StID=$StID");
		return $query->result();
	}
	function insert($row){
		$this->db->insert('task',$row);
	}
	function setUID($id,$UID){
		$this->db->query("UPDATE tasks SET UID=$UID WHERE id=$id");
	}
}

?>