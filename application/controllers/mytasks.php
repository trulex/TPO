<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class MyTasks extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('project');
    }
    
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['id']=$session_data['id'];
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    /*Pridobimo seznam nalog za uporabnika
	    */
	    $data['active']='mytasks';
	    $data['projects']=$this->project->getProjects($data['id']);
	    $this->load->view('header', $data);
	    $this->load->view('mytasks_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }  
}