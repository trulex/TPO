<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class MyTasks extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('project');
	$this->load->model('task');
	$this->load->helper('date');
    }
    
    function index() {
	if($this->session->userdata('logged_in')) {
	    $session_data = $this->session->userdata('logged_in');
	    $data['id']=$session_data['id'];
	    $data['username'] = $session_data['username'];
	    $data['name'] = $session_data['name'];
	    $data['rights'] = $session_data['rights'];
	    $data['active']='mytasks';
	    $data['projects']=$this->project->getProjects($data['id']);
	    $data['tasks']=$this->task->getTasks($data['id']);
	    
	    $this->load->view('header', $data);
	    $this->load->view('mytasks_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
    function startWork() {
	$session_data = $this->session->userdata('logged_in');
	$data['id']=$session_data['id'];
	$this->db->select('id');
	$this->db->from('tasks');
	$this->db->where('task_name', $this->input->post('task'));
	$this->db->where('UID', $data['id']);
	$query=$this->db->get();
	foreach ($query->result() as $row)
	{
	    $taskId=$row->id;
	}
	
	$newStart=array(
	    'start_time'=>date('Y-m-d H:i:s') );
	$this->db->where('task_name', $this->input->post('task'));
	$this->db->where('UID', $data['id']);
	$this->db->where('id', $taskId);
	$this->db->update('tasks', $newStart);
	redirect($this->input->post('redirect')); //redirect to previous page
    }
}