<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddProject extends CI_Controller { 
    function __construct(){
		parent::__construct();
    }
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='administration';
		
		$this->load->model("get_projects");
		$data['results']= $this->get_projects->getAll();
		
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
		
	    $this->form_validation->set_rules('projectname', 'Project name', 'required|callback_projectname_check');
	    $this->form_validation->set_rules('description', 'Project description');
		$this->form_validation->set_rules('scrummaster', 'Scrum master');
	    $this->form_validation->set_rules('productowner', 'Product owner');
	    
	    if ($this->form_validation->run() == FALSE) {
			$this->load->view('addproject_view',$data);
	    } else {
		$projectname=$this->input->post('projectname');
		$description=$this->input->post('description');
		$scrummaster=$this->input->post('scrummaster');
		$productowner=$this->input->post('productowner');
		
		$userdata=array(
		    'project_name'=>$projectname,
		    'description'=>$description,
			'scrum_master'=>$scrummaster,
			'product_owner'=>$productowner
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