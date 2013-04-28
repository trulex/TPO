<!-- table "sprints": [id|start_date|finish_date|velocity|PID] -->
<?php
class Sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints ORDER BY start_date");
		return $query->result();
	}
	
	function getProjectSprints($projectid){
		$query = $this->db->query("SELECT id, start_date, finish_date, velocity FROM sprints WHERE PID='$projectid' ORDER BY CAST(start_date AS datetime)");
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
	function getSprint($SpID){
		$query=$this->db->query("SELECT start_date, finish_date, velocity, id FROM sprints WHERE id=$SpID");
		return $qurey->row();
	}
	
	function getStartDate($sprintID){
		$this->db->select('start_date');
		$this->db->from('sprints');
		$this->db->where('id',$sprintID);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->start_date;
		}else{
			return 0;
		}
	}
	
	function getFinishDate($sprintID){
		$this->db->select('finish_date');
		$this->db->from('sprints');
		$this->db->where('id',$sprintID);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->finish_date;
		}else{
			return 0;
		}
	}
	
	function getVelocity($sprintID){
		$this->db->select('velocity');
		$this->db->from('sprints');
		$this->db->where('id',$sprintID);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->velocity;
		}else{
			return 0;
		}
	}
}
?> 
