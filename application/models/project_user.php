<!-- Created by: Lovrenc -->
<!-- table "project_user": [project_id|user_id|role] -->
<?php
class Project_user extends CI_Model{
	
	function getRole($UID, $PID){
		$query = $this->db->query("SELECT role FROM project_user WHERE project_id=$PID and user_id=$UID");
		return $query->result();
	}
		function getAllFromProject($PID){
		$query=$this->db->query("SELECT user_id FROM project_user WHERE project_id=$PID");
		return $query->result();
	}
}
?>