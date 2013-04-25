<!--avtor:darko-->
<!-- table "projects":[id|project_name|description] -->
<?php
Class Projects extends CI_Model {
    function getProjects($rights) {
		if($rights) {
			$query=$this->db->query("SELECT id, name FROM projects");
			return $query->result();
		}
		else {
			//returns ids of projects of user with id $userid
			$query=$this->db->query(" select id, name, max(role) from projects left JOIN project_user on(project_user.PID=projects.id) where project_user.UID=$this->session->userdata('UID') group by id");
			return $query->result();
		}
	}
    function getProjectName($projectId) {
		$this->db->select('name');
		$this->db->from('projects');
		$this->db->where('id',$projectId);
		$query=$this->db->get();
		return $query->row()->name;
    }
	
	function getDescription($projectId){
		$this->db->select('description');
		$this->db->from('projects');
		$this->db->where('id',$projectId);
		$query=$this->db->get();
		return $query->row()->description;
	}
	
    function getProjectID($projectName) {
		$this->db->select('id');
		$this->db->from('projects');
		$this->db->where('name',$projectName);
		$query=$this->db->get();
		return $query->row()->id;
	}
	function getAll(){
		$query = $this->db->query("SELECT * FROM projects");
		return $query->result();
	}
	function getID($UName){
		$query = $this->db->query("SELECT id FROM projects WHERE name='$UName'");
		return $query->result();
	}
	
	function ifExists($projectName){
		$query = $this->db->query("SELECT name FROM projects WHERE name='$projectName'");
		return $query->num_rows();
	}
}
