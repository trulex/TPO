<?php
class Sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints ORDER BY start_date");
		return $query->result();
	}
	
	function getProjectSprints($projectid){
		$query = $this->db->query("SELECT id, start_date, finish_date FROM sprints WHERE PID='$projectid'");
		return $query->result();
	}
}
?> 
