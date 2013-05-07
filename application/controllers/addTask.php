<!--avtor:Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddTask extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('tasks');
		$this->load->model("sprints");
		$this->load->model("project_user");
	}

	public function index($StID)	{
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='meni';
			$data['StID']=$StID;
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['UID']=$this->session->userdata('UID');
			$data['ScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			if($data['rights']){
					redirect('home','refresh');
			}
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('task_name', 'Task name', 'trim|required|callback_taskName_check[$StID]');
			$this->form_validation->set_rules('text', 'Text', 'trim|required');
			$this->form_validation->set_rules('time_estimate', 'Time estimate', 'trim|numeric|max_length[3]');
			$this->load->view('addTask',$data);
			$this->load->view('footer');
		} 
		else{
			redirect('login', 'refresh');
		}

	}
	public function taskName_check($str) {
    	$this->db->select('task_name');
		$this->db->from('tasks');
		$this->db->where('task_name', $str);
		$this->db->where('StID', $StID);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('taskName_check', 'Task with such name allready exists.');
		return FALSE;
		} else {
			return TRUE;
		}
    }
		
	

}?>