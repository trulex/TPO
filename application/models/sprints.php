<!-- table "sprints": [id|start_date|finish_date|velocity|PID] -->
<?php
class Sprints extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT * FROM sprints ORDER BY start_date");
		return $query->result();
	}
	
	function getProjectSprints($projectid){
		if($this->session->userdata('PID')){
			$query = $this->db->query("SELECT id, start_date, finish_date, velocity FROM sprints WHERE PID='$projectid' ORDER BY start_date");
			if ($query->num_rows==0){
				return FALSE;
			}
			else{
				return $query->result();
			}
		}
		else{
			return FALSE;
		}
	}
	
	function getCurrentSprint($projectId) {
	    $sprints=$this->getProjectSprints($projectId);
	    if ($sprints != FALSE) {
		foreach($sprints as $row):
		    $today = date("Y-m-d");
		    if($today >= $row->start_date && $today <= $row->finish_date):
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
	
	function getProjectStart($PID){
		$query=$this->db->query("SELECT MIN(start_date) AS startDate FROM sprints WHERE PID=$PID");
		
		if($query->num_rows() > 0){
			return $query->row()->startDate;
		}else{
			return 0;
		}
	}
	
	function getProjectEnd($PID){
		$query=$this->db->query("SELECT MAX(finish_date) AS finishDate FROM sprints WHERE PID=$PID");
		
		if($query->num_rows() > 0){
			return $query->row()->finishDate;
		}else{
			return 0;
		}
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
