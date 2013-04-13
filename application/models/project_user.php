<!-- Created by: Lovrenc -->
<!-- table "project_user": [project_id|user_id|role] -->
<?php
class Project_user extends CI_Model{
	
	function getRole($UID, $PID){
		$query = $this->db->query("SELECT rights FROM project_users WHERE project_id=$UID and user_id=$PID");
		return $query->row()->user_id;
	}
}
?>