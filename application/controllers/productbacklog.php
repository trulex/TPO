<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Productbacklog extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('projects');
	$this->load->model("sprints");
    }
	
	function index() {
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['id']=$session_data['id'];
			$data['rights'] = $session_data['rights'];
			$data['active']='productbacklog';
			$data['projects']=$this->projects->getProjects($data['id']);

			$data['currentproject']=$this->projects->getProjectID($this->session->userdata('project'));
			$data['currentsprints']=$this->sprints->getProjectSprints($data['currentproject']);

			$this->load->view('header', $data);
			$this->load->view('productbacklog');
			$this->load->view('footer');
		}
	}
}