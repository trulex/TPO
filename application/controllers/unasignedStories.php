<!-- avtor: Lovrenc -->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UnasignedStories extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
		$this->load->model("tasks");
	}
	
	public function index()	{	
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);	
			$data['rights'] = $session_data['rights'];
			$data['projects']=$this->projects->getProjects($session_data['id']);
			if(strcmp($data['rights'],'user')==0){
					redirect('home','refresh');
			}
			
			$data['active']='menu';
			$stories=$this->stories->getUnasigned($this->session->userdata('PID'));
			$storyTuple=array();
			foreach ($stories as $story){
				$tasks=$this->tasks->getCurrent($story->id);
				$all=0;
				$done=0;
				foreach ($tasks as $task){
					$all++;
					if($task->completed){
						$done++;
					}
				}
				array_push($storyTuple,array($story,array($all, $done)));
			}
			$data['storyTuple']=$storyTuple;
			$this->load->view('header', $data);
			$this->load->view('unasignedStories', $data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
	
	function changeDifficulty(){
		$difficulty=$this->input->post('difficulty');
		if (is_numeric($difficulty)){
			if ( $difficulty>0){
				$this->stories->setDifficulty($this->input->post('StID'), $difficulty);
			}
		}
		redirect($this->input->post('redirect'));
		
	}
	
}
?>