<!--avtor: Lovrenc-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyAddTask extends CI_Controller { 
    function __construct(){
		parent::__construct();
		$this->load->model('tasks');
    } 

    function index($StID) {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='verifyAddTask';
			$data['id']=$session_data['id'];
			if(strcmp($data['rights'],'user')==0){
					redirect('home','refresh');
			}
			$this->load->view('header',$data);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('task_name', 'Task name', 'trim|required|callback_taskName_check[$StID]');
			$this->form_validation->set_rules('text', 'Text', 'trim|required');
			$this->form_validation->set_rules('time_estimate', 'Time estimate', 'trim|numeric|max_length[3]');
			
			if ($this->form_validation->run() == FALSE) {
				$data['message']='';
				$this->load->view('verifyAddTask',$data);
			} 
			else {
				$name=$this->input->post('task_name');
				$text=$this->input->post('text');
				$tests=$this->input->post('time_estimate');
				$userdata=row(
					'task_name'=>$task_name,
					'text'=>$text,
					'StID'=>$StID,
					'time_estimate'=>$time_estimate);
				$this->db->insert('tasks', $row);
				$data['message']='Story successfully added.';
				$this->load->view('veryfyAddTask',$data);
			}
			$this->load->view('footer');
		}
		else {
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
			$this->form_validation->set_message('taskName_check', 'Story with such name allready exists.');
		return FALSE;
		} else {
			return TRUE;
		}
    }
}
?>