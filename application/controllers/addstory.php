<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addstory extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('projects');
    }
    
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
		$data['id']=$session_data['id'];
	    $data['project']=$session_data['project'];
	    $data['projects']=$this->projects->getProjects($data['id']);
	    $data['active']='productbacklog';
	    $this->load->view('header', $data);
	    $this->load->helper(array('form'));
	    $data['message']='';
	    $data['noproject']='';
	    
	    $this->load->view('addstory_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
    
}