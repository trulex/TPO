<?php
//Created by lovrenc
class Stories extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, name, text FROM stories");
		return $query->result();
	}
	function getOwn($id){
		$query = $this->db->query("select id, name, text from stories where id=(select StID from tasks where UID=$id)");
		return $query->result();
	}
	function getCurrent($PID){
		$query =$this->db->query("select id, name from stories where PID=$id");
		return $query->result();
	}
}
	
?>