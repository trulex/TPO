<!-- Created by lovrenc -->
<!-- table "stories": [id|name|text|tests|difficulty|priority|busvalue|SpID|PID] -->

<?php
class Stories extends CI_Model{
// 	Get all stories
	function getAll(){
		$query = $this->db->query("SELECT id, name, text, difficulty, SpID, PID FROM stories");
		return $query->result();
	}
	
// 	Get all stories from this user
	function getOwn($id){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE id=(SELECT StID FROM tasks WHERE UID=$id)");
		return $query->result();
	}
	
// 	Get all stories from this project
	function getFromProject($PID){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE PID=$PID");
		return $query->result();
	}
	
// 	Get all stories from current sprint
	function getCurrent($SpID){
		$query = $this->db->query("SELECT id, name, text FROM stories WHERE SpID=$SpID");
		return $query->result();
	}
	function getUnasigned($PID){
		$query=$this->db->query("SELECT id, name, text,difficulty FROM stories WHERE PID=$PID and SpID=0");
		return $query->result();
	}
	
// 	Get ids of stories from this sprint
	function getSprintID($SpID){
		$query = $this->db->query("SELECT id, FROM stories WHERE SpID=$SpID");
		return $query->result();
	}
	
// 	Set sprint for this story
	function setSprint($ID,$SpID){
		$this->db->query("UPDATE stories SET SpID=$SpID WHERE id=$ID");
	}
	
// 	Set task difficulty estimate(time estimate)
	function setDifficulty($StID,$difficulty){
		$this->db->query("UPDATE stories SET difficulty=$difficulty WHERE id=$StID");
	}

}
?>