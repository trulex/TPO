<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EditUsers extends CI_Controller {
    function __construct() {
	parent::__construct();
	$this->load->model('projects');
	$this->load->model('sprints');
	$this->load->model('users');
	$this->load->model("project_user");
    }
    function index() {
    	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['id']=$session_data['id'];
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['project']=$session_data['project'];
	    $data['message']='';
	    if(strcmp($data['rights'],'user')==0) {
		redirect('home','refresh');
	    }
	    $data['active']='administration';
	    $data['projects']=$this->projects->getProjects($data['id']);
	    $data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
	    $data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
	    $data['users']=$this->users->getActiveUsers($data['username']); //get usernames,names and surnames of all users
	    $data['deactivatedUsers']=$this->users->getInactiveUsers();
	    
	    $this->load->helper('form');
	    
	    $this->load->view('header', $data);
	    $this->load->view('editUsers_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
    /* _Deactivate_ a user, maybe I'll rename it in the future */
    function deleteUser() {
	$username=$this->input->post('deleteUser');
	$userdata=array( 'deactivated'=>1 );
	$this->db->where('username', $username);
	$this->db->update('users', $userdata);
	
	$session_data = $this->session->userdata('logged_in');
	$data['id']=$session_data['id'];
	$data['username'] = $session_data['username'];
	$data['name'] = $session_data['name'];
	$data['rights'] = $session_data['rights'];
	$data['project']=$session_data['project'];
	$data['active']='administration';
	$data['projects']=$this->projects->getProjects($data['id']);
	$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
	$data['users']=$this->users->getActiveUsers($data['username']); //get usernames,names and surnames of all users
	$data['deactivatedUsers']=$this->users->getInactiveUsers();
	$data['message']='User successfully deactivated.';
	$this->load->helper('form');
	
	$this->load->view('header', $data);
	$this->load->view('editUsers_view', $data);
	$this->load->view('footer');
    }
    /* Activatea user, maybe I'll rename it in the future */
    function activateUser() {
	$username=$this->input->post('activateUser');
	$userdata=array( 'deactivated'=>0 );
	$this->db->where('username', $username);
	$this->db->update('users', $userdata);
	
	$session_data = $this->session->userdata('logged_in');
	$data['id']=$session_data['id'];
	$data['username'] = $session_data['username'];
	$data['name'] = $session_data['name'];
	$data['rights'] = $session_data['rights'];
	$data['project']=$session_data['project'];
	$data['active']='administration';
	$data['projects']=$this->projects->getProjects($data['id']);
	$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
	$data['users']=$this->users->getActiveUsers($data['username']); //get usernames,names and surnames of all users
	$data['deactivatedUsers']=$this->users->getInactiveUsers();
	$data['message']='User successfully activated.';
	$this->load->helper('form');
	
	$this->load->view('header', $data);
	$this->load->view('editUsers_view', $data);
	$this->load->view('footer');
    }    
}