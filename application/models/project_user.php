<!-- Created by: Lovrenc -->
<!-- table "project_user": [project_id|user_id|role] -->
<?php
class Project_user extends CI_Model{
	
	function getRole($UID, $PID){
		$query = $this->db->query("SELECT role FROM project_user WHERE project_id=$PID and user_id=$UID");
		if ($query->num_rows==0){
			return 0;
		}
		else{
			return $query->row()->role;
		}
	}
		function getAllFromProject($PID){
			$query=$this->db->query("SELECT user_id FROM project_user WHERE project_id=$PID");
			return $query->result();
	}
	
	function getScrumMaster($PID){
		$this->db->select('user_id');
		$this->db->from('project_user');
		$this->db->where('project_id',$PID);
		$this->db->where('role',1);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->user_id;
		}else{
			return 0;
		}
	}
	
	function getName($UID){
		$query = $this->db->query("SELECT username FROM users WHERE id=$UID");
		if($query->num_rows() > 0){
			return $query->row()->username;
		}else{
			return "-";
		}
	}
	
	function getProductOwner($PID){
		$this->db->select('user_id');
		$this->db->from('project_user');
		$this->db->where('project_id',$PID);
		$this->db->where('role',2);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->user_id;
		}else{
			return 0;
		}
	}
	
	function getTeamMembersID($PID){
		$this->db->select('user_id');
		$this->db->from('project_user');
		$this->db->where('project_id',$PID);
		$this->db->where('role',0);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$teammembers = array();
			foreach ($query->result() as $row) {
				$teammembers[] = $row->user_id;
			}
		}else{
			return 0;
		}
	}
}
?>