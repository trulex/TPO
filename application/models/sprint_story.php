<!-- models/sprint_story.php -->
<!-- avtor: Lovrenc -->
<!-- table "sprint_story": [StID|SpID] -->
<?php
class Sprint_story extends CI_Model{

	// 	Set sprint for this story
	function setSprint($StID,$SpID){
		$this->db->query("INSERT INTO sprint_story (SpID,StID) VALUES ($SpID, $StID)");
	}
	function isCurrent($StID){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT * from sprint_story WHERE SpID=$SpID AND StID=$StID");
		if($query->num_rows()){
			return 1;
		}
		else{
			return 0;
		}
	}
}
?> 
