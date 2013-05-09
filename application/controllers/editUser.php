<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EditUser extends CI_Controller {
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
	    $data['UID']=$this->session->userdata('UID');
	    $data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
	    
	    $username=$this->input->post('editUser');
	    $username=str_replace('"',"",$username);
	    $userId=$this->users->getID($username); //ID of selected user
	    $this->session->set_userdata('userId',$userId);
	    $data['userData']=$this->users->getAllData($userId);
	    $this->session->set_userdata('username1',$username);
	    $this->load->helper('form');
	    $this->load->helper(array('form'));
	    
	    $this->load->view('header', $data);
	    $this->load->view('editUser_view', $data);
	    $this->load->view('footer');
	} else {
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
	    $data['active']='administration';
	    $data['id']=$session_data['id'];
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['project']=$this->session->userdata('project');
	    $data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
	    $data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);  
	    
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha|callback_username_check');
	    $this->form_validation->set_rules('password', 'Password', 'trim|alpha_numeric');
	    $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|callback_password_confirmation');
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|alphasi');
	    $this->form_validation->set_rules('surname', 'Surname', 'trim|required|alphasi');
	    $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
	   
	    $this->load->view('header',$data);
	    
	    if ($this->form_validation->run() == FALSE) {
		$data['message']='';
		$data['userData']=$this->users->getAllData($this->session->userdata('userId'));
		$this->load->view('editUser_view',$data);
	    } else {
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$name=$this->input->post('name');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$rights=$this->input->post('rights');
		if(strcmp($this->input->post('password'),'')!=0){
		    $password=md5($this->input->post('password'));
		    $userdata=array(
			'username'=>$username,
			'password'=>$password,
			'name'=>$name,
			'surname'=>$surname,
			'rights'=>$rights,
			'email'=>$email );
		} else {
		    $userdata=array(
			'username'=>$username,
			'name'=>$name,
			'surname'=>$surname,
			'rights'=>$rights,
			'email'=>$email );
		}
		$this->db->where('username',$this->session->userdata('username1'));
		$this->db->update('users', $userdata);
		$data['message']='Profile successfully updated.';
		
		$username=str_replace('"',"",$username);
		$data['userData']=$this->users->getAllData($this->session->userdata('userId'));
		$data['username1']=$username;		
		
		$this->load->view('editUser_view',$data);
	    }
	    $this->load->view('footer');
	}    else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}	   
    }
    /* Check if new username is the same as the previous, or if someone else has it. */
    public function username_check($str) {
	$this->db->select('username');
	$this->db->from('users');
	$this->db->where('username', $str);
	$query=$this->db->get();
	$row=$query->row();
	if ($query->num_rows <= 0) {//no user with this username
	    return true;
	}
	else if ($row->username == $this->session->userdata('username1')) { // The usernames are the same
	    return true;
	} else if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('username_check', 'This username is already taken.');
	    return false;
	} else {
	    return true;
	}
    }    
    public function password_confirmation($str) {
	if (strcmp($this->input->post('password'),$str)!=0) {
	    $this->form_validation->set_message('password_confirmation', 'Please make sure that passwords match.');
	    return FALSE;
	} else {
	    return TRUE;
	}
    }    
}
