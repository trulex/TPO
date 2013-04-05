<!--avtor:darko-->
<?php
Class Project extends CI_Model {
    function getProjects() {
	$this->db->select('project_name');
	$this->db->from('projects');
	$query=$this->db->get();
	/*if (!$query->num_rows() > 0) {
	    die("There are no projects yet.");
	}*/
	$projects = array();
	foreach ($query->result() as $row) {
	    $projects[] = $row->project_name;
	}
	return $projects;
    }
}
