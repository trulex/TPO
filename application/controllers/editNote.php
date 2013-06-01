<!-- avtor: Lovrenc -->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EditNote extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
		$this->load->model("project_user");
	}
	
	

	public function index()	{	
		//if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['isScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			
			$this->load->helper('form');	
			$data['active']='productBacklog';
			$data['return']=$this->input->post('redirect');
			$data['StID']=$this->input->post('StID');
			$data['story']=$this->stories->getStory($data['StID']);
			$this->load->view('header', $data);
			$this->load->view('productBacklog', $data);
			$this->load->view('editNote');
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
	function edit(){
	if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			
			$this->load->helper('form');	
			$data['active']='productBacklog';
			$data['return']=$this->input->post('return');
			$data['StID']=$this->input->post('StID');
			$data['story']=$this->stories->getStory($data['StID']);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('return', 'Return path', 'trim');
			$this->load->view('header', $data);
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('editNote', $data);
			}
			else {
				$StID=$this->input->post('StID');
				$note=$this->input->post('text');
				$return=$this->input->post('return');
				$this->stories->editNote($StID,$note);
				redirect($return);
			}
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
		
	}
}
?>