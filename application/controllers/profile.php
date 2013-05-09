<!--avtor:darko-->
<?php

Class Profile extends CI_Controller {
	public function __construct()	{
		parent::__construct();
		$this->load->model('projects');
		$this->load->model('sprints');
		$this->load->model('users');
		$this->load->model("project_user");
	}
	
    function index() {
	if($this->session->userdata('logged_in')) {
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['name'] = $session_data['name'];
		$data['rights'] = $session_data['rights'];
		$data['id']=$session_data['id'];
		$data['active']='';
		$data['message']='';
		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
		$data['UID']=$this->session->userdata('UID');
		$data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));

		$data['userData']=$this->users->getData($data['id']);
		
		$this->load->view('header', $data);
		$this->load->helper(array('form'));
		$this->load->view('profile_view',$data);
		$this->load->view('footer',$data);
	} else {
	    redirect('login', 'refresh');
	}
    }
    function verifyEdit() {
	if($this->session->userdata('logged_in')) {
	
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='';
	    $data['id']=$session_data['id'];
	    $data['PID']=$this->session->userdata('PID');
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['project']=$this->session->userdata('project');
	    $data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
	    $data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
	    $data['role']=$this->project_user->getRole($this->session->userdata['UID'],$data['PID']);
	    $data['UID']=$this->session->userdata('UID');
	    $data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
	    $data['ProductOwner']=$this->project_user->getProductOwner($this->session->userdata('PID'));	    
	    $data['userData']=$this->users->getData($data['id']);
	    
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
		$this->load->view('profile_view',$data);
	    } else {
		$username=$this->input->post('username');
		$name=$this->input->post('name');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		if(strcmp($this->input->post('password'),'')!=0){
		    $password=md5($this->input->post('password'));
		    $userdata=array(
			'username'=>$username,
			'password'=>$password,
			'name'=>$name,
			'surname'=>$surname,
			'email'=>$email );
		} else {
		    $userdata=array(
			'username'=>$username,
			'name'=>$name,
			'surname'=>$surname,
			'email'=>$email );
		}
		$data['username']=$username;
		$this->db->where('id',$data['id']);
		$this->db->update('users', $userdata);
		$data['message']='Profile successfully updated.';
		
		$this->load->view('profile_view',$data);
	    }
	    $this->load->view('footer');
	}    else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    /* Check if new username is the same ai the user's, or if someone else has it. */
    public function username_check($str) {
	$this->db->select('username');
	$this->db->from('users');
	$this->db->where('username', $str);
	$query=$this->db->get();
	$row=$query->row();
	$session_data = $this->session->userdata('logged_in');
	$username = $session_data['username'];
	if ($query->num_rows() == 0) {
	    return true;
	}
	if(!is_null($row->username)) {
	    if ($row->username == $username) { // The usernames are the same
		return true;
	    } else if ($query->num_rows() > 0) {
		$this->form_validation->set_message('username_check', 'This username is already taken.');
		return false;
	    } else {
		return true;
	    }
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
?>