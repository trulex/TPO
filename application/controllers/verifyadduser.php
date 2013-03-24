<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddUser extends CI_Controller { 
    function __construct(){
	parent::__construct();
	$this->load->model('user','',TRUE);
    }
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    
	    $this->load->view('header',$data);
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('username', 'Username', 'trim|required');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
	    $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha');
	    $this->form_validation->set_rules('surname', 'Surname', 'trim|required|alpha');
	    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	    $this->form_validation->set_rules('rights', 'Rights');
	    
	    if ($this->form_validation->run() == FALSE) {
		$this->load->view('adduser_view',$data);
	    } else {
		$username=$this->input->post('username');
		$password=$this->input->post('password');
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
		redirect('adduser',$data);
	    }
	    $this->load->view('footer');
	}    else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
}