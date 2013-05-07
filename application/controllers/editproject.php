<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editproject extends CI_Controller { 
    function __construct(){
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
		$this->load->model("project_user");
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
		$data['PID']=$this->session->userdata('PID');
		$data['projects']=$this->projects->getProjects($data['rights']);
		$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
		$data['UID']=$this->session->userdata('UID');
		$data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
				
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
		
	    $this->form_validation->set_rules('projectname', 'Project name', 'required|callback_projectname_check');
		$this->form_validation->set_rules('checkbox_name', 'listofmembers', 'trim');
	    
	    if ($this->form_validation->run() == FALSE) {
			$data['projectname']=$this->projects->getProjectName($data['PID']);
			$data['description']=$this->projects->getDescription($data['PID']);
			$data['scrummaster']=$this->project_user->getScrumMaster($data['PID']);
			$data['mastername']=$this->project_user->getName($data['scrummaster']);
			$data['productowner']=$this->project_user->getProductOwner($data['PID']);
			$data['ownername']=$this->project_user->getName($data['productowner']);
			$this->load->view('editproject_view',$data);
	    } else {
		$projectname=$this->input->post('projectname');
		$description=$this->input->post('description');
		$scrummaster=$this->input->post('scrummaster');
		$productowner=$this->input->post('productowner');
		$teammembers=$this->input->post('listofmembers');
		$this->session->set_userdata('project', $projectname);
		
		$userdata=array(
		    'name'=>$projectname,
		    'description'=>$description
			);
			
		$this->db->where('id', $data['PID']);
		$this->db->update('projects', $userdata);
		
		$userdata=array(
		    'PID'=>$data['PID'],
			'UID'=>$scrummaster,
			'role'=>1
			);
		
		if($scrummaster != 0){
			if($this->project_user->getScrumMaster($data['PID']) != 0){
				$userdata=array(
					'UID'=>$scrummaster,
				);
				$this->db->where('PID', $data['PID']);
				$this->db->where('role', 1);
				$this->db->update('project_user', $userdata);
			}else{
				$this->db->insert('project_user', $userdata);
			}
		}
		
		if($scrummaster == 0 && $this->project_user->getScrumMaster($data['PID']) != 0){
			$this->db->where('PID', $data['PID']);
			$this->db->where('role', 1);
			$this->db->delete('project_user'); 
		}
		
		$userdata=array(
		    'PID'=>$data['PID'],
			'UID'=>$productowner,
			'role'=>2
			);
		
		if($productowner != 0){
			if($this->project_user->getProductOwner($data['PID']) != 0){
				$userdata=array(
					'UID'=>$productowner,
				);
				$this->db->where('PID', $data['PID']);
				$this->db->where('role', 2);
				$this->db->update('project_user', $userdata);
			}else{
				$this->db->insert('project_user', $userdata);
			}
		}
		
		if($productowner == 0 && $this->project_user->getProductOwner($data['PID']) != 0){
			$this->db->where('PID', $data['PID']);
			$this->db->where('role', 2);
			$this->db->delete('project_user'); 
		}

		if($this->project_user->getTeamMembersID($data['PID'] == 0)){
			foreach($teammembers as $member){
				$userdata=array(
					'PID'=>$data['PID'],
					'UID'=>$member,
					'role'=> 0
				);
				$this->db->insert('project_user', $userdata);
			}
		}else{
			$this->db->where('PID', $data['PID']);
			$this->db->where('role', 0);
			$this->db->delete('project_user');
			
			foreach($teammembers as $member){
				$userdata=array(
					'PID'=>$data['PID'],
					'UID'=>$member,
					'role'=> 0
				);
				$this->db->insert('project_user', $userdata);
			}
		}
		
		$this->session->set_flashdata('flashSuccess', 'Project successfully edited.');
		redirect('editproject');
	    }
	    $this->load->view('footer');
	}    else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
	
    public function projectname_check($str) {
	$this->db->select('id, name');
	$this->db->from('projects');
	$this->db->where('name', $str);
	$query=$this->db->get();
	if ($query->num_rows() > 0 && $query->row()->id != $this->session->userdata('PID')) {
	    $this->form_validation->set_message('projectname_check', 'A project with the same name already exists.');
	    return FALSE;
	} else {
	    return TRUE;
	}
    }
}
