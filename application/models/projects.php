<!--avtor:darko-->
<!-- table "projects":[id|name|description|documentation] -->
<?php
Class Projects extends CI_Model {
    function getProjects($rights) {
		if($rights) {
			$query=$this->db->query("SELECT id, name FROM projects");
			return $query->result();
		}
		else {
			//returns ids of projects of user with id $userid
			$UID=$this->session->userdata('UID');
			$query=$this->db->query("select id, name, max(role) as role from projects left JOIN project_user on(project_user.PID=projects.id) where project_user.UID=$UID group by id");
			return $query->result();
		}
	}
	
// 	Get all data of current project_name
	function getCurrent(){
		$PID=$this->session->userdata('PID');
		$query = $this->db->query("SELECT * FROM projects WHERE id=$PID");
		return $query->row();
	}
	
    function getProjectName($PID) {
		if($PID){
			$this->db->select('name');
			$this->db->from('projects');
			$this->db->where('id',$PID);
			$query=$this->db->get();
			return $query->row()->name;
		}
		else{
			return "";
		}
    }
    
    function getDocumentation($PID){
		$query=$this->db->query("SELECT documentation FROM projects WHERE id=$PID");
		return $query->result();
    }
    
    function saveDocumentation($doc){
		$PID=$this->session->userdata('PID');
		$query=$this->db->query("UPDATE projects SET documentation='$doc' WHERE id=$PID");
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
