<!-- controllers/allStories.php -->
<!--avtor:BOSTJAN-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AllStories extends CI_Controller { 

    function __construct() {
		parent::__construct();
		$this->load->model('projects');
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model('project_user');
		$this->load->model("tasks");
    }
	
	function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='productBacklog';
			$data['activesubmenu1']='allStories';
			$data['id']=$session_data['id'];
			$data['PID']=$this->session->userdata('PID');
			$data['project']=$session_data['project'];
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$data['PID']);
			$data['results']= $this->stories->getFromProject($this->session->userdata('PID'));
			$data['mode']=2;
			$this->load->view('header', $data);
			$this->load->helper(array('form'));
			$this->load->view('productBacklog',$data);
			$this->load->view('submenu1');
			$this->load->view('productBacklogList',$data);
			$this->load->view('footer');
		} else {
		//If no session, redirect to login page
		redirect('login', 'refresh');
		}
    }
}
?>