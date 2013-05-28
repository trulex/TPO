<!-- documentation -->
<!-- avtor: Lovrenc -->
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
		$this->load->model("project_user");
	}
	
	public function index()	{	
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['active']='wall';
			$data['active2']='documentation';
			if(!$data['rights']) {
					redirect('home','refresh');
			}
			
			$data['pData']=$this->projects->getCurrent();
			
			$this->load->view('header', $data);
			$this->load->view('homeSubmenu', $data);
			$this->load->view('documentation', $data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
	
	public function editDocumentation()	{	
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['active']='wall';
			$data['active2']='documentation';
			if(!$data['rights']) {
					redirect('home','refresh');
			}
			
			$data['pData']=$this->projects->getCurrent();
			
			$this->load->view('header', $data);
			$this->load->view('homeSubmenu', $data);
			$this->load->view('editDocumentation', $data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
}
?>