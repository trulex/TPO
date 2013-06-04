<!-- models/stories.php -->
<!-- Created by lovrenc -->
<!-- table "stories": [id|name|text|tests|difficulty|priority|busvalue|SpID|PID|note] -->

<?php
class Stories extends CI_Model{
// 	Get all stories
	function getAll(){
		$query = $this->db->query("SELECT id, name, text, tests, difficulty, PID, note, finished FROM stories");
		return $query->result();
	}
	
	function getFinished(){
		$query = $this->db->query("SELECT id, name, text, difficulty, PID, note, finished,tests FROM stories WHERE finished=1");
		return $query->result();
	} 
// 	Get all stories from this user
	function getOwn($id){
		$query = $this->db->query("SELECT id, name, text, note, finished, tests FROM stories WHERE id=(SELECT StID FROM tasks WHERE UID=$id)");
		return $query->result();
	}
	
	function getHours($pid){
		$query = $this->db->query("SELECT SUM(difficulty) AS sumDifficulty FROM stories WHERE PID=$pid");
		return $query->row()->sumDifficulty;
	}
	
// 	Get all stories from this project
	function getFromProject($PID){
		$query = $this->db->query("SELECT * FROM stories WHERE PID=$PID");
		return $query->result();
	}
	
// 	Get all stories from current sprint
	function getCurrent(){
		$SpID=$this->session->userdata('SpID');
		$query = $this->db->query("SELECT id, name, text, tests, difficulty, note, finished FROM stories LEFT JOIN sprint_story ON(sprint_story.StID=stories.id) WHERE SpID=$SpID");
		return $query->result();
	}
	
// 	Get all unasigned stories
	function getUnassigned(){
		$PID=$this->session->userdata('PID');
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text,difficulty , note, finished, tests FROM stories WHERE PID=$PID AND NOT EXISTS (SELECT * from sprint_story WHERE StID=stories.id AND SpID=$SpID) AND finished=0");
		return $query->result();
	}
	
// 		Get all assigned stories
	function getAssigned(){
		$PID=$this->session->userdata('PID');
		$query=$this->db->query("SELECT id, name, text,difficulty , note, finished, tests FROM stories WHERE PID=$PID AND EXISTS (SELECT * from sprint_story WHERE StID=stories.id) AND finished=0");
		return $query->result();
	}
	
// 	Get all completed stories
	function getCompleted(){}
// 	Get ids of stories from this sprint
	function getSprintID($SpID){
		$query = $this->db->query("SELECT StID, FROM sprint_story WHERE SpID=$SpID");
		return $query->result();
	}
	
	
// 	Set task difficulty estimate(time estimate)
	function setDifficulty($StID,$difficulty){
		$this->db->query("UPDATE stories SET difficulty=$difficulty WHERE id=$StID");
	}
	
	/* Get story data */
	function getData($storyId) {
	    $this->db->select('name,text,tests,busvalue,priority,note');
	    $this->db->where('id', $storyId);
	    $query=$this->db->get('stories');
	    
	    return $query->row();
	}
	
// 	Edit note
	function editNote($StID,$note){
		$this->db->query("UPDATE stories SET note='$note' WHERE id=$StID");
	}
	
	function getStory($StID){
		$query=$this->db->query("SELECT name, note, id FROM stories WHERE id=$StID");
		if($query->num_rows){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	
	function endStory($StID){
		$this->db->query("UPDATE stories SET finished=1 WHERE id=$StID");
	}
	
	function reopenStory($StID){
		$this->db->query("UPDATE stories SET finished=0 WHERE id=$StID");
	}
}
?>