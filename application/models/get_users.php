<?php
class Get_users extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
	function getUserName($id){
		$query = $this->db->query("SELECT username FROM users WHERE id=$id");
		return $query->row()->username;
	}
}
?>