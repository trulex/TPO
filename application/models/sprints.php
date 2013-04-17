<!-- table "sprints": [id|start_date|finish_date|velocity|PID] -->
<?php
class Sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints ORDER BY start_date");
		return $query->result();
	}
	
	function getProjectSprints($projectid){
		$query = $this->db->query("SELECT id, start_date, finish_date, velocity FROM sprints WHERE PID='$projectid'");
		if ($query->num_rows==0){
			return FALSE;
		}
		else{
			return $query->result();
		}
	}
	
	function getCurrentSprint($projectId) {
	    $sprints=$this->getProjectSprints($projectId);
	    if ($sprints != FALSE) {
		foreach($sprints as $row):
		    $today = strtotime(date("Y-m-d"));
		    if($today >= strtotime($row->start_date) && $today <= strtotime($row->finish_date)):
			return $row->id;
		endif;
		endforeach;
	    } else {
		return 0;
	    }
	}
}
?> 
