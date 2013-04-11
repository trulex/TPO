<!--avtor:darko-->
<?php
Class Project extends CI_Model {
    function getProjects($userid) {
	/* Check if admin */
	$this->db->select('rights');
	$this->db->from('users');
	$this->db->where('id',$userid);
	$query=$this->db->get();
	$rights=$query->row()->rights;
	if(strcmp($rights,'admin')==0) {
	    $this->db->select('id');
	    $this->db->from('projects');
	    $query=$this->db->get();
	    $projects = array();
	    foreach ($query->result() as $row) {
		$projects[] = $row->id;
	    }
	} else {
	    //returns ids of projects of user with id $userid
	    $this->db->select('project_id');
	    $this->db->from('project_user');
	    $this->db->where('user_id',$userid);
	    $query=$this->db->get();
	    $projects = array();
	    foreach ($query->result() as $row) {
		$projects[] = $row->project_id;
	    }
	}
	return $projects;
    }
    function getProjectName($projectId) {
		$this->db->select('project_name');
		$this->db->from('projects');
		$this->db->where('id',$projectId);
		$query=$this->db->get();
		return $query->row()->project_name;
    }
    function getProjectID($projectName) {
		$this->db->select('id');
		$this->db->from('projects');
		$this->db->where('project_name',$projectName);
		$query=$this->db->get();
		return $query->row()->id;
	}
}
