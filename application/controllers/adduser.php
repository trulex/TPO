<!-- controllers/adduser.php -->

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Adduser extends CI_Controller { 
    function __construct() {
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
		$this->load->model("project_user");
    }
    
    function index() {
		//if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			if(!$data['rights']) {
				redirect('home','refresh');
			}
			$data['active']='administration';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$data['message']='';
			$this->load->view('adduser_view', $data);
			$this->load->view('footer');
		} else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
    }
    
}