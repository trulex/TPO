<!-- Created by lovrenc -->
<!-- table "stories": [id|name|text|tests|priority|busvalue|SpID|PID|project_name] -->

<?php
class Stories extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, name, text, SpID FROM stories");
		return $query->result();
	}
	
	function getOwn($id){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE id=(SELECT StID FROM tasks WHERE UID=$id)");
		return $query->result();
	}
	
	function getFromProject($PID){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE PID=$PID");
		return $query->result();
	}
	function getCurrent($SpID){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE SpID=$SpID");
		return $query->result();
	}
	function getSprintID($SpID){
		$query = $this->db->query("SELECT id, FROM stories WHERE SpID=$SpID");
		return $query->result();
	}
	function setSprint($ID,$SpID){
		$this->db->query("UPDATE stories SET SpID=$SpID WHERE id=$ID");
	}
}
?>