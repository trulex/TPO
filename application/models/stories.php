<?php
//Created by lovrenc
class Stories extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, name, text FROM stories");
		return $query->result();
	}
	function getOwn(){
		$query = $this->db->query("select id, name, text from tasks where UID={$data['id']}");
		return $query->result();
	}

}
	
?>