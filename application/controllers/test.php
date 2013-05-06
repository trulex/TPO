<!--avtor:Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Test extends CI_Controller {

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
			$data['activesubmenu3']='test';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['projectUsers']=$this->project_user->getAllFromProject($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata('UID'),$this->session->userdata('PID')); 
			$stories=$this->stories->getCurrent($this->session->userdata('SpID'));
			$storyTuple=array();
			foreach ($stories as $story){
				$tasks=$this->tasks->getCurrent($story->id);
				array_push($storyTuple,array($story,$tasks));
			}
			$data['storyTuple']=$storyTuple;
			$this->load->helper(array('form'));
			$this->load->view('header',$data);
			$this->load->view('sprintBacklog');
			$this->load->view('submenu3');
			$this->load->view('test',$data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
	function takeTask(){
		$TID=$this->input->post('TID');
		$UID=$this->input->post('UID');
		$this->tasks->setUID($TID,$UID);
		$this->tasks->accept($TID);
		redirect($this->input->post('redirect'));
	}
	
	function acceptTask(){
		$TID=$this->input->post('TID');
		$this->tasks->accept($TID);
		redirect($this->input->post('redirect'));
	}
	
	function asignTask(){
		$TID=$this->input->post('TID');
		$UID=$this->input->post('UID');
		$this->tasks->setUID($TID,$UID);
		redirect($this->input->post('redirect'));
		
	}
	function releaseTask(){
		$TID=$this->input->post('TID');
		$this->tasks->setUID($TID,0);
		$this->tasks->decline($TID);
		redirect($this->input->post('redirect'));
	}
	
	function changeTime(){
		$timeEstimate=$this->input->post('timeEstimate');
		if (is_numeric($timeEstimate)){
			if ( $timeEstimate>0){
				$this->tasks->setTimeEstimate($this->input->post('TID'), $timeEstimate);
			}
		}
		redirect($this->input->post('redirect'));
	}
	function finishTask(){
		$this->tasks->finish($this->input->post('TID'));
		redirect($this->input->post('redirect'));
	}
}