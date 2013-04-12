<!--avtor:Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SprintBacklog extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model("projects");
		$this->load->model("users");
		$this->load->model("stories");
		$this->load->model("tasks");
	}

	public function index()	{
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['id']=$session_data['id'];
			$data['project']=$this->session->userdata('project');
			$data['active']='sprintBacklog';	
			$this->load->view('header',$data);
			$data['PID']= $this->projects->getProjectID($data['project']);	
			$data['projects']=$this->projects->getProjects($data['id']);

			$data['stories']= $this->stories->getCurrent($data['PID']);	
			
// 			foreach ($data['stories'] as $story){
// 				$data['tasks'][$story->name]=$this->tasks->getCurrent($story->id);
// 			}
			$data['tasks']= $this->tasks->getAll();
			$this->load->helper(array('form'));
			$this->load->view('sprintBacklog',$data);
			$this->load->view('selProject', $data);
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
		redirect('sprintBacklog');
	}
	function releaseTask(){
		$TID=$this->input->post('TID');
		$this->tasks->setUID($TID,0);	
		redirect('sprintBacklog');
	}
}