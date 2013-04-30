<!--avtor:darko-->
<?php

Class Profile extends CI_Controller {
	public function __construct()	{
		parent::__construct();
		$this->load->model('projects');
		$this->load->model('sprints');
		$this->load->model('users');
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
		$surnameEmail=$this->users->getSurnameEmail($data['id']);
		$data['surname']=$surnameEmail->surname;
		$data['email']=$surnameEmail->email;
		
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
	    $data['projects']=$this->projects->getProjects($data['rights']);
	    $data['project']=$this->session->userdata('project');
	    $data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
	    $data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
	    $surnameEmail=$this->users->getSurnameEmail($data['id']);
	    $data['surname']=$surnameEmail->surname;
	    $data['email']=$surnameEmail->email;
	    
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
		$password=md5($this->input->post('password'));
		$name=$this->input->post('name');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$userdata=array(
		    'username'=>$username,
		    'password'=>$password,
		    'name'=>$name,
		    'surname'=>$surname,
		    'email'=>$email );
		$this->db->where('id',$data['id']);
		$this->db->update('users', $userdata);
		$data['message']='Profile successfully updated. The changes will be seen at next login.';
		
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
	if ($row->username == $username) { // The usernames are the same
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
?>