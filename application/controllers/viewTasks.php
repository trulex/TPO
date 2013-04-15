<!--avtor:Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ViewTasks extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("tasks");
		$this->load->model('projects');
		}

	public function index()	{
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			if(strcmp($data['rights'],'user')==0){
					redirect('home','refresh');
			}
			$data['active']='productbacklog';
// 			$data['stories']= $this->stories->getAll($data['id']);	
// 			$data['tasks']= $this->tasks->getAll();
			$data['projects']=$this->projects->getProjects($data['id']);
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			
			$stories=$this->stories->getFromProject($this->session->userdata('PID'));
			$storyTuple=array();
			foreach ($stories as $story){
				$tasks=$this->tasks->getCurrent($story->id);
// 				echo "story name:".$story->name."<br>";
// 				foreach ($tasks as $task){
// 					echo "task: ".$task->task_name."<br>";
// 				}
				$storyTuple=array_push($storyTuple,array($story,$tasks);
			}
			$data['storyTuple']=$storyTuple;
			$this->load->view('header', $data);
// 			$this->load->view('viewTasks',$data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}

	}
	

}