<?php
//Created by lovrenc
class Stories extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, name, text FROM stories");
		return $query->result();
	}
	function getOwn($id){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE id=(SELECT StID FROM tasks WHERE UID=$id)");
		return $query->result();
	}
	function getCurrent($PID){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE PID=$PID");
		return $query->result();
	}
}
	
?>