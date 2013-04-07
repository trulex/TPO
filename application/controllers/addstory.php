<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addstory extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('project');
    }
    
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
		hdfs
		bg
		dfsg
		df
		gtrs
		dfvs
		dtrb
		vdsy
		ersbg
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    if(strcmp($data['rights'],'user')==0) {
		redirect('home','refresh');
	    }
	    $data['active']='productbacklog';
	    $this->load->view('header', $data);
	    $this->load->helper(array('form'));
	    $data['message']='';

	    $data['projects']=$this->project->getProjects();
	    
	    $this->load->view('addstory_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
    
}