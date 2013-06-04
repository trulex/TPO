<!-- models/sprint_story.php -->
<!-- avtor: Lovrenc -->
<!-- table "sprint_story": [StID|SpID] -->
<?php
class Sprint_story extends CI_Model{

	// 	Set sprint for this story
	function setSprint($StID,$SpID){
		$this->db->query("INSERT INTO sprint_story (SpID,StID) VALUES ($SpID, $StID)");
	}
	
}
?> 
