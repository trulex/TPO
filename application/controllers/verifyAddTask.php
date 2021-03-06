<!-- controllers/verifyAddTask.php -->
<!--avtor: Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddTask extends CI_Controller { 
    function __construct(){
		parent::__construct();
		$this->load->model('tasks');
		$this->load->model("sprints");
		$this->load->model("projects");
		$this->load->model("project_user");
		
    } 

    function index() {
		//if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='sprintBacklog';
			$data['activesubmenu3']='unassignedtasks';
			$data['id']=$session_data['id'];
			$data['message']="";
			$data['task_name']='';
			$data['text']='';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['isScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			
			$this->load->view('header', $data);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('StID', 'StID', 'trim|numeric');
			if ($this->form_validation->run()==false) {
				$data['message']="nekej ne štima"; // popraviti to
				echo $this->input->post('task');
			}
			else{
				$StID=$this->input->post('task');
				$data['StID']=$StID;
				$this->load->view('submenu3');
				$this->load->view('sprintBacklog',$data);
				$this->load->view('addTask', $data);
				$this->load->view('footer');
			}
		}
		else {
			redirect('login', 'refresh');
		}
	}
    public function taskName_check($str, $StID) {
		$this->db->select('name');
		$this->db->from('tasks');
		$this->db->where('name', $str);
		$this->db->where('StID', $StID);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('taskName_check', 'Story with such name already exists.');
		return FALSE;
		} else {
			return TRUE;
		}
    }
    public function taskCreator(){
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['name'] = $session_data['name'];
		$data['rights'] = $session_data['rights'];
		$data['active']='sprintBacklog';
		$data['activesubmenu3']='unassignedtasks';
		$data['id']=$session_data['id'];
		$data['message']="";
		$data['task_name'] = $this->input->post('task_name');
		$data['text'] = $this->input->post('text');
		$name=$this->input->post('task_name');
		$data['StID']=$this->input->post('StID');
		$data['projects']=$this->projects->getProjects($data['rights']);
		$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
		$data['currentsprint']=$this->sprints->getCurrentSprint($data['currentproject']);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('task_name', 'Task name', 'trim|required|callback_taskName_check[$name, $data["StID"]]');
		$this->form_validation->set_rules('text', 'Text', 'trim|required');
		$this->form_validation->set_rules('time_estimate', 'Time estimate', 'trim|greater_than[0]');
		$this->form_validation->set_message('greater_than', 'Time estimate must be positive!');
		$this->form_validation->set_message('taskName_check', 'Task Name must be unique! <br>');
		$this->form_validation->set_message('required', 'Fields marked with <span style="color:red;vertical-align:top">*</span> are required! <br>');
		$this->load->view('header', $data);
		if ($this->form_validation->run() == FALSE) {
			$data['message']=validation_errors();
			
			$this->load->view('sprintBacklog',$data);
			$this->load->view('submenu3');
			$this->load->view('addTask', $data);
		}
		else {
			$name=$this->input->post('task_name');
			$text=$this->input->post('text');
			$time_estimate=$this->input->post('time_estimate');
			$StID=$this->input->post('StID');
			$taskData=array(
				'name'=>$name,
				'text'=>$text,
				'StID'=>$StID,
				'time_estimate'=>$time_estimate	);
			$this->db->insert('tasks',$taskData);
			redirect('allTasks');
		}
		$this->load->view('footer');
	}
}
?>