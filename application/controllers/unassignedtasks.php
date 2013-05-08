<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Unassignedtasks extends CI_Controller {

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
			$data['activesubmenu3']='unassignedtasks';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['projectUsers']=$this->project_user->getAllFromProject($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata('UID'),$this->session->userdata('PID'));				
			$data['UID']=$this->session->userdata('UID');
			$data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			$data['stories']= $this->stories->getCurrent($this->session->userdata('SpID'));
			
			$this->load->helper(array('form'));
			$this->load->view('header',$data);
			$this->load->view('sprintBacklog',$data);
			$this->load->view('submenu3');
			$this->load->view('unassignedtasks_view',$data);
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
	
	function asignTask(){
		$TID=$this->input->post('TID');
		$UID=$this->input->post('UID');
		$this->tasks->setUID($TID,$UID);
		redirect($this->input->post('redirect'));	
	}
	function endStory(){
		$StID=$this->input->post('StID');
		$this->stories->endStory($StID);
		redirect($this->input->post('redirect'));
	}
	function rejectStory(){
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			
			$this->load->helper('form');
			$data['active']='productbacklog';
			$data['return']=$this->input->post('return');
			$data['StID']=$this->input->post('StID');
			$data['story']=$this->stories->getStory($data['StID']);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('return', 'Return path', 'trim');
			$this->load->view('header', $data);
// 			$this->load->view('editNote', $data);
			$this->load->view('footer');
			if ($this->form_validation->run() == FALSE) {
				
			}
			else {
				$note=$this->input->post('text');
				$this->stories->reopenStory($data['StID']);
				$this->stories->editNote($data['StID'],$note);
// 				redirect($data['return']);
			}
		}
		
		else{
			redirect('login', 'refresh');
		}
	}
}