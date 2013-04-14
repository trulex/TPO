<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editproject extends CI_Controller { 
    function __construct(){
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
    }

    function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
		$data['id']=$session_data['id'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='administration';
		$data['projects']=$this->projects->getProjects($data['id']);
		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
		
		//$this->load->model("get_projects");
		//$data['results']= $this->get_projects->getAll();
		
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
		
	    $this->form_validation->set_rules('projectname', 'Project name', 'required|callback_projectname_check');
	    $this->form_validation->set_rules('description', 'Project description');
		$this->form_validation->set_rules('scrummaster', 'Scrum master');
	    $this->form_validation->set_rules('productowner', 'Product owner');
	    
	    if ($this->form_validation->run() == FALSE) {
			$this->load->view('editproject_view',$data);
	    } else {
		$projectname=$this->input->post('projectname');
		$description=$this->input->post('description');
		$scrummaster=$this->input->post('scrummaster');
		$productowner=$this->input->post('productowner');
		$teammembers=$this->input->post('listofmembers');
		
		$userdata=array(
		    'project_name'=>$projectname,
		    'description'=>$description
			);
		
		$this->db->update('projects', $userdata);
		
		$this->db->select('id, project_name');
		$this->db->from('projects');
		$this->db->where('project_name', $projectname);
		$query=$this->db->get();
		$id=$query->result('id');
		
		//if ($query->num_rows() > 0)
		
		$userdata=array(
		    'project_id'=>$id,
		    'user_id'=>$scrummaster,
			'role'=> 1
			);
		$this->db->update('product_user', $userdata);
		
		$userdata=array(
		    'project_id'=>$id,
		    'user_id'=>$productowner,
			'role'=> 2
			);
		$this->db->update('product_user', $userdata);
		
		foreach($teammembers as $member){
			$userdata=array(
				'project_id'=>$id,
				'user_id'=>$member,
				'role'=> 0
			);
			$this->db->update('product_user', $userdata);
		}
		
		$this->session->set_flashdata('flashSuccess', 'Project successfully edited.');
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
