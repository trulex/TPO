<!--avtor:BOSTJAN-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unfinishedstories extends CI_Controller { 

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
			$data['active']='productbacklog';
			$data['id']=$session_data['id'];
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['id']);
			
			$this->load->model("stories");
			$data['results']= $this->stories->getAll();
			
			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$this->load->view('unfinishedstories_view',$data);
			$this->session->set_flashdata('flashSuccess', 'Stories successfully added to current sprint.');
			$this->load->view('footer');
		} else {
		//If no session, redirect to login page
		redirect('login', 'refresh');
		}
    }
}
?>