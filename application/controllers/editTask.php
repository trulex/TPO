<!-- avtor: Lovrenc -->

<?php
// First things first, zavrne dostop če se dostopa nepravilno
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EditTask extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
		$this->load->model("tasks");
		$this->load->model("project_user");
		$this->load->model("users");
	}
	
	

	public function index()	{	
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['TID']=$this->input->post('TID');
			$data['message']='';
			$TData=$this->tasks->getTask($data['TID']);
			$data['TName']=$TData->name;
			$data['TText']=$TData->text;
			$data['TTimeEstimate']=$TData->time_estimate;
			$data['TUID']=$TData->UID;
			$data['TAccepted']=$TData->accepted;
			$data['TTimeSum']=$TData->time_sum;
			$data['TCompleted']=$TData->completed;
			$data['projectUsers']=$this->project_user->getAllFromProject($this->session->userdata('PID'));
			if(!$data['rights']) {
					redirect('home','refresh');
			}
			
			$data['active']='productbacklog';
			$this->load->view('header', $data);
			$this->load->view('editTask',$data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
	function taskModifier(){
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['name'] = $session_data['name'];
		$data['rights'] = $session_data['rights'];
		$data['active']='verifyAddTask';
		$data['id']=$session_data['id'];
		$data['message']='';
		$data['task_name'] = $this->input->post('task_name');
		$data['text'] = $this->input->post('text');
		$name=$this->input->post('task_name');
		$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
		$data['currentsprint']=$this->sprints->getCurrentSprint($this->session->userdata('PID'));
		$this->load->library('form_validation');
		$data['project_users']=$this->project_user->getAllFromProject($this->session->userdata('PID'));
		$this->form_validation->set_rules('task_name', 'Task name', 'trim|required|callback_taskName_check[$name, $data["StID"]]');
		$this->form_validation->set_rules('text', 'Text', 'trim|required');
		$this->form_validation->set_rules('time_estimate', 'Time estimate', 'trim|numeric|greater_than[-1]');
		$this->form_validation->set_rules('time_sum', 'Work done', 'trim|numeric|greater_than[-1]');
		$this->form_validation->set_message('greater_than', 'Time estimate must be positive!<br>');
		$this->form_validation->set_message('taskName_check', 'Task Name must be unique! <br>');
		$this->form_validation->set_message('', 'Task Name must be unique! <br>');
		$this->form_validation->set_message('required', 'Fields marked with <span style="color:red;vertical-align:top">*</span> are required! <br>');
		$this->load->view('header', $data);
		$data['TID']=$this->input->post('TID');
		$data['TName']=$this->input->post('task_name');
		$data['TText']=$this->input->post('text');
		$data['TTimeEstimate']=$this->input->post('time_estimate');
		$data['TUID']=$this->input->post('UID');
		$data['TAccepted']=$this->input->post('accepted');
		$data['TTimeSum']=$this->input->post('time_sum');
		$data['TCompleted']=$this->input->post('completed');
		if ($this->form_validation->run() == FALSE) {
			$data['message']=validation_errors();
			$this->load->view('editTask', $data);
		}
		else {
			$this->tasks->editTask($data['TID'],$data['TName'],$data['TText'],$data['TTimeEstimate'],$data['TUID'],$data['TAccepted'],$data['TTimeSum'],$data['TCompleted']);
			redirect('sprintBacklog');
		}
		$this->load->view('footer');
	}
	public function taskName_check($str, $StID) {
		$this->db->select('task_name');
		$this->db->from('tasks');
		$this->db->where('task_name', $str);
		$this->db->where('StID', $StID);
		$query=$this->db->get();
		if ($query->num_rows() > 1) {
			$this->form_validation->set_message('taskName_check', 'Story with such name already exists.');
		return FALSE;
		} else {
			return TRUE;
		}
    }
}
?>