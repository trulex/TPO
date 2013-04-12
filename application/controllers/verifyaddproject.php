<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddProject extends CI_Controller { 
    function __construct(){
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
    }
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='administration';

	    $data['id']=$session_data['id'];
	    $data['projects']=$this->projects->getProjects($data['id']);

		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
	    
	    $data['results']= $this->projects->getAll();
		
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
		
	    $this->form_validation->set_rules('projectname', 'Project name', 'required|callback_projectname_check');
	    $this->form_validation->set_rules('description', 'Project description');
	    
	    if ($this->form_validation->run() == FALSE) {
			$this->load->view('addproject_view',$data);
	    } else {
		$projectname=$this->input->post('projectname');
		$description=$this->input->post('description');
		
		$userdata=array(
		    'project_name'=>$projectname,
		    'description'=>$description
			);
		
		$this->db->insert('projects', $userdata);
		$this->session->set_flashdata('flashSuccess', 'Project successfully added.');
		redirect('addproject');
	    }
	    $this->load->view('footer');
	}    else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    public function projectname_check($str) {
	$this->db->select('project_name');
	$this->db->from('projects');
	$this->db->where('project_name', $str);
	$query=$this->db->get();
	if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('projectname_check', 'A project with the same name already exists.');
	    return FALSE;
	} else {
	    return TRUE;
	}
    }
}