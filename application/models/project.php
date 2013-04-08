<!--avtor:darko-->
<?php
Class Project extends CI_Model {
    function getProjects($userid) {
    //returns ids of projects of user with id $userid
	$this->db->select('project_id');
	$this->db->from('project_user');
	$this->db->where('user_id',$userid);
	$query=$this->db->get();
	
	/*if (!$query->num_rows() > 0) {
	    die("There are no projects yet.");
	}*/
	$projects = array();
	foreach ($query->result() as $row) {
	    $projects[] = $row->project_id;
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
}
