<!-- controllers/allTasks.php -->

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AllTasks extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model("projects");
		$this->load->model("users");
		$this->load->model("stories");
		$this->load->model("tasks");
		$this->load->model("sprints");
		$this->load->model("project_user");
	}

	public function index()	{
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			$data['project']=$this->session->userdata('project');
			$data['active']='sprintBacklog';
			$data['activesubmenu3']='alltasks';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['projectUsers']=$this->project_user->getAllFromProject($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata('UID'),$this->session->userdata('PID'));
			$data['mode']=2;
			$data['tuples']=$this->tasks->getAllTupled();
			$this->load->helper(array('form'));
			$this->load->view('header',$data);
			$this->load->view('sprintBacklog',$data);
			$this->load->view('submenu3');
			$this->load->view('sprintBacklogList',$data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
}