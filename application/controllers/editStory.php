<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class EditStory extends CI_Controller {

    function __construct() {
	    parent::__construct();
	    $this->load->model('sprints');
	    $this->load->model('projects');
	    $this->load->model('stories');
	    $this->load->model('project_user');
    }

    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='productbacklog';
	    $data['activesubmenu1']='unfinishedstories';
	    $data['activesubmenu2']='unassignedstories';
	    $data['id']=$session_data['id'];
	    $data['PID']=$this->session->userdata('PID');
	    $data['project']=$session_data['project'];
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
	    $data['role']=$this->project_user->getRole($this->session->userdata['UID'],$data['PID']);
	    $data['UID']=$this->session->userdata('UID');
	    $data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
	    $data['ProductOwner']=$this->project_user->getProductOwner($this->session->userdata('PID'));
	    $data['storyData']=$this->stories->getData($this->input->post('StID'));
	    $this->session->set_userdata('StoryID',$this->input->post('StID'));
	    $data['message']='';
	    $this->session->set_userdata('storyname1',$data['storyData']->name);
	    
	    
	    $this->load->helper(array('form'));
	    
	    $this->load->view('header', $data);
	    $this->load->view('productbacklog',$data);
	    $this->load->view('submenu1');
	    $this->load->view('submenu2');	    
	    $this->load->view('editStory_view', $data);
	    $this->load->view('footer');
	}
	else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    function verifyEdit() {
	if($this->session->userdata('logged_in')) {
	
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='productbacklog';
	    $data['activesubmenu1']='unfinishedstories';
	    $data['activesubmenu2']='unassignedstories';
	    $data['id']=$session_data['id'];
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['project']=$this->session->userdata('project');
	    $data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
	    $data['storyData']=$this->stories->getData($this->session->userdata['StoryID']);
	    
	    $this->load->library('form_validation');
	    
	    $this->load->view('header', $data);
	    $this->load->view('productbacklog',$data);
	    
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_storyname_check');
	    $this->form_validation->set_rules('text', 'Text', 'trim|required');
	    $this->form_validation->set_rules('tests', 'Tests', 'trim|required');
	    $this->form_validation->set_rules('business_value', 'Business value', 'trim|required|is_natural_no_zero');	    
	    
	    if ($this->form_validation->run() == FALSE) {
		$data['message']='';
		$this->load->view('editStory_view',$data);
	    } else {
		$name=$this->input->post('name');
		$text=$this->input->post('text');
		$tests=$this->input->post('tests');
		$business_value=$this->input->post('business_value');
		$priority=$this->input->post('priority');
		$userdata=array(
		    'name'=>$name,
		    'text'=>$text,
		    'tests'=>$tests,
		    'priority'=>$priority,
		    'busvalue'=>$business_value );
		$this->db->where('id',$this->session->userdata('StoryID'));
		$this->db->update('stories', $userdata);
		$data['storyData']=$this->stories->getData($this->session->userdata['StoryID']);
		$data['message']='Story successfully edited';
		$this->load->view('editStory_view',$data);
	    }
	    
	    $this->load->view('footer');
	    
	}
	else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}    
    }
    /* Check if story in this project with this name already exists */
    function storyname_check($str) {
    	$this->db->select('name');
	$this->db->from('stories');
	$this->db->where('name', $str);
	$this->db->where('PID',$this->session->userdata('PID'));
	$query=$this->db->get();
	$row=$query->row();
	if(!is_null($row)) {
	    if ($row->name == $this->session->userdata('storyname1')) {
		return true;
	    }
	}
	if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('storyname_check', 'A story with name "'.$str.'" already exists.');
	    return FALSE;
	} else {
	    return TRUE;
	}
    }
}
?>