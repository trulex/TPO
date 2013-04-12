<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddStory extends CI_Controller { 
    function __construct(){
	parent::__construct();
	$this->load->model('projects');
    } 

    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='productbacklog';
	    $data['id']=$session_data['id'];
	    $data['project']=$session_data['project'];
	    $data['projects']=$this->projects->getProjects($data['id']);
	    $data['noproject']='';
	    
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_storyname_check');
	    $this->form_validation->set_rules('text', 'Text', 'trim|required');
	    $this->form_validation->set_rules('tests', 'Tests', 'trim|required');
	    $this->form_validation->set_rules('business_value', 'Business value', 'trim|required|is_natural_no_zero');
	    
	    if ($this->form_validation->run() == FALSE || strcmp($this->session->userdata('project'),'')==0 || !$this->hasRights()) {
		$data['message']='';
		if (strcmp($this->session->userdata('project'),'')==0) {
		    $data['noproject']='Please select a project.';
		} 
		if (!$this->hasRights()) {
		    $data['noproject']='Error: You do not have sufficient rights for adding new stories to this project.';
		}
		$this->load->view('addstory_view',$data);
	    } else {
		$name=$this->input->post('name');
		$text=$this->input->post('text');
		$tests=$this->input->post('tests');
		$priority=$this->input->post('priority');
		$business_value=$this->input->post('business_value');
		$project=$this->session->userdata('project');
		$userdata=array(
		    'name'=>$name,
		    'text'=>$text,
		    'tests'=>$tests,
		    'priority'=>$priority,
		    'busvalue'=>$business_value,
		    'project_name' => $project );
		$this->db->insert('stories', $userdata);
		$data['message']='Story successfully added.';
		$data['noproject']='';
		$this->load->view('addstory_view',$data);
	    }
	    $this->load->view('footer');
	} else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    function hasRights() {
	$session_data = $this->session->userdata('logged_in');
	$userId=$session_data['id'];
	$rights=$session_data['rights'];
	if(strcmp($rights,'admin')==0) {
	    return true;
	}
	$this->db->select('id');
	$this->db->from('projects');
	$this->db->where('project_name', $this->session->userdata('project'));
	$query=$this->db->get();
	$projectId=$query->row()->id;
	
	$this->db->select('role');
	$this->db->from('project_user');
	$this->db->where('project_id', $projectId);
	$this->db->where('user_id', $userId);
	$query=$this->db->get();
	$role=$query->row()->role;
	
	if($role == 0) {
	    return false;
	} else {
	    return true;
	}
    }
    public function storyname_check($str) {
    	$this->db->select('name');
	$this->db->from('stories');
	$this->db->where('name', $str);
	$query=$this->db->get();
	if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('storyname_check', 'The story already exists.');
	return FALSE;
	} else {
	    return TRUE;
	}
    }
}