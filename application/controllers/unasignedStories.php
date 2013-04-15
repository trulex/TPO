<!-- avtor: Lovrenc -->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UnasignedStories extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("projects");
	}
	
	public function index()	{	
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			
			$data['rights'] = $session_data['rights'];
			if(strcmp($data['rights'],'user')==0){
					redirect('home','refresh');
			}
			
			$data['active']='menu';
			
			$this->load->view('header', $data);
			$this->load->view('footer');
		}
		else{
			redirect('login', 'refresh');
		}
	}
}
?>