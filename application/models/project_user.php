<!-- Created by: Lovrenc -->
<!-- table "project_user": [PID|UID|role] -->
<?php
class Project_user extends CI_Model{
	
	function getRole($UID, $PID){
		if( $this->session->userdata('PID')){
			$query = $this->db->query("SELECT MAX(role) AS role FROM project_user WHERE PID=$PID and UID=$UID");
			if ($query->num_rows==0){
				return 0;
			}
			else{
				return $query->row()->role;
			}
		}
		else{
			return 0;
		}
	}
		function getAllFromProject($PID){
			$query=$this->db->query("SELECT UID, users.name FROM project_user LEFT JOIN users ON(project_user.UID=users.id) WHERE PID=$PID");
			return $query->result();
	}
	
	function getScrumMaster($PID){
		$this->db->select('UID');
		$this->db->from('project_user');
		$this->db->where('PID',$PID);
		$this->db->where('role',1);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->UID;
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
		$this->db->select('UID');
		$this->db->from('project_user');
		$this->db->where('PID',$PID);
		$this->db->where('role',2);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->UID;
		}else{
			return 0;
		}
	}
	
	function getTeamMembersID($PID){
		$this->db->select('UID');
		$this->db->from('project_user');
		$this->db->where('PID',$PID);
		$this->db->where('role',0);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			$teammembers = array();
			foreach ($query->result() as $row) {
				$teammembers[] = $row->UID;
			}
		}else{
			return 0;
		}
	}
}
?>