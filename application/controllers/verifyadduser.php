<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class VerifyAddUser extends CI_Controller { 
    function __construct(){
	parent::__construct();
	$this->load->model('user','',TRUE);
	$this->load->model('project');
    }
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='administration';
	    $data['id']=$session_data['id'];
	    $data['projects']=$this->project->getProjects($data['id']);
	    $data['project']=$this->session->userdata('project');
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha|callback_username_check');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
	    $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|callback_password_confirmation');
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|alphasi');
	    $this->form_validation->set_rules('surname', 'Surname', 'trim|required|alphasi');
	    $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
	    $this->form_validation->set_rules('rights', 'Rights');
	    
	    if ($this->form_validation->run() == FALSE) {
		$data['message']='';
		$this->load->view('adduser_view',$data);
	    } else {
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$name=$this->input->post('name');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$rights=$this->input->post('rights');
		$userdata=array(
		    'username'=>$username,
		    'password'=>$password,
		    'name'=>$name,
		    'surname'=>$surname,
		    'email'=>$email,
		    'rights'=>$rights );
		$this->db->insert('users', $userdata);
		$data['message']='User successfully added.';
		$this->load->view('adduser_view',$data);
	    }
	    $this->load->view('footer');
	}    else {
	    //If no session, redirect to login page
	    redirect('login', 'refresh');
	}
    }
    public function username_check($str) {
	$this->db->select('username');
	$this->db->from('users');
	$this->db->where('username', $str);
	$query=$this->db->get();
	if ($query->num_rows() > 0) {
	    $this->form_validation->set_message('username_check', 'The user already exists.');
	    return FALSE;
	} else {
	    return TRUE;
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