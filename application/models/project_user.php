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
}
?>