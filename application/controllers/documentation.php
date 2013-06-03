<!-- controllers/documentation.php -->
<!-- avtor: Lovrenc -->
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model("sprints");
		$this->load->model("stories");
		$this->load->model("tasks");
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
			$data['isScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			$data['active']='wall';
			$data['active2']='documentation';
			$this->load->helper(array('form'));
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
		//if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		
		if($this->session->userdata('logged_in')) {
		
			$session_data = $this->session->userdata('logged_in');
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['active']='wall';
			$data['active2']='documentation';
			$this->load->helper(array('form'));
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
	function saveDocumentation(){
		$this->projects->saveDocumentation($this->input->post('documentation'));
		redirect('documentation', 'refresh');
	}
	
	function importStoryData(){
		$doc="";
		$doc=$doc.'<!DOCTYPE html>\n<html xml:lang="sl" lang="sl" dir="ltr">\n\n<head>\n<title>Documentation</title>\n</head>\n<body>\n';

		$stories=$this->stories->getFromProject($this->session->userdata('PID'));
		foreach($stories as $story){
			$doc=$doc."<h1>".$story->name."</h1>\n";
			if($this->input->post("storiesDescriptions")){
				$doc=$doc.'<p>"'.$story->text.'"</p>\n';
			}
			if($this->input->post("storiesTests")){
				$doc=$doc."<p>TESTS:<br>";
				foreach(explode("\n", $story->tests) as $test) {
					$doc=$doc."-".$test."<br>\n";
				}
				$doc=$doc."</p>\n";
			}
			if($this->input->post("storiesNotes")){
				$doc=$doc."<p>NOTES:<br>";
				foreach(explode("\n", $story->note) as $note) {
					$doc=$doc."-".$note."<br>\n";
				}
				$doc=$doc."</p>\n";
			}
			$tasks=$this->tasks->getCurrent($story->id);
			if(($this->input->post("taskNames") || $this->input->post("taskDescriptions")) && $tasks){
				$tasks=$this->tasks->getCurrent($story->id);
				$doc=$doc.'<h2>Tasks: </h2>\n<div style="margin-left:20px;">\n';
				foreach($tasks as $task){
					$doc=$doc."<h3>".$task->name."</h3>\n";
					if($this->input->post("taskDescriptions")){
						$doc=$doc.'<p>"'.$task->text.'"</p>\n';
					}
				}
				$doc=$doc."</div>\n";
			}
		}
		$doc=$doc."</body>\n</html>\n";
		$this->projects->saveDocumentation($doc);
		redirect('documentation', 'refresh');
	}
	function downloadDocumentation(){
		$session_data = $this->session->userdata('logged_in');
		$data['name'] = $session_data['name'];
		$data['rights'] = $session_data['rights'];
		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
		$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
		$data['active']='wall';
		$data['active2']='documentation';
		$this->load->helper(array('form'));
		$pData=$this->projects->getCurrent();
		$file=fopen("tmp/documentation.html","w+");
		fwrite($file,$pData->documentation);
		fclose($file);
		$this->load->view('header', $data);
		$this->load->view('homeSubmenu', $data);
		$this->load->view('downloadDocumentation', $data);
		$this->load->view('footer');
	}
	function uploadDocumentation(){
		$session_data = $this->session->userdata('logged_in');
		$data['name'] = $session_data['name'];
		$data['rights'] = $session_data['rights'];
		$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
		$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);
		$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
		$data['active']='wall';
		$data['active2']='documentation';
		$data['pData']=$this->projects->getCurrent();
		$this->load->helper(array('form'));
		$config['upload_path'] = 'tmp/';
		$config['allowed_types'] = 'htm|html|php|txt';
		$config['max_size']	= '30';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$data['error'] = array('error' => $this->upload->display_errors());
			$this->load->view('header', $data);
			$this->load->view('homeSubmenu', $data);
			$this->load->view('editDocumentation', $data);
			$this->load->view('footer');
		}
		else
		{
			$doc="";
			$file=fopen("tmp/".$this->upload->data()['file_name'],"r");
			while(!feof($file))
				{
					$doc=$doc.fgets($file);
				}
				fclose($file);
			$this->projects->saveDocumentation($doc);
			redirect('documentation', 'refresh');
		}
	}
}
?>