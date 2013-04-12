<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class MyTasks extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('projects');
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
	    $data['projects']=$this->projects->getProjects($data['id']);
	    $data['tasks']=$this->task->getTasks($data['id']); //Gets key-value array of tasks and accepted indices
	    $data['activeTask']=$this->task->getActive($data['id']);
	    
	    $this->load->view('header', $data);
	    $this->load->view('mytasks_view', $data);
	    $this->load->view('footer');
	} else {
	//If no session, redirect to login page
	redirect('login', 'refresh');
	}
    }
    function startWork() {
	/* Check if some taks is already being worked on */
	$session_data = $this->session->userdata('logged_in');
	$userId=$session_data['id'];
	if(strcmp($this->task->getActive($userId),'')!=0) {
	    $this->session->set_userdata('taskActive','Stop working on current task to begin with work on another.');
	    redirect('mytasks');
	} else {
	    $this->db->select('id');
	    $this->db->from('tasks');
	    $this->db->where('task_name', $this->input->post('task'));
	    $this->db->where('UID', $userId);
	    $query=$this->db->get();
	    foreach ($query->result() as $row)
	    {
		$taskId=$row->id;
	    }
	    
	    /* Update start time in database */
	    $newStart=array(
		'start_time'=>date('Y-m-d H:i:s') );
	    $this->db->where('task_name', $this->input->post('task'));
	    $this->db->where('UID', $userId);
	    $this->db->where('id', $taskId);
	    $this->db->update('tasks', $newStart);
	    /* Mark task as active */
	    $newStart=array(
		'active'=>'1' );
	    $this->db->where('task_name', $this->input->post('task'));
	    $this->db->where('UID', $userId);
	    $this->db->where('id', $taskId);
	    $this->db->update('tasks', $newStart);
	    $this->session->set_userdata('taskActive','');
	    redirect('mytasks'); //redirect to previous page
	}
    }
    function stopWork() {
	$session_data = $this->session->userdata('logged_in');
	$userId=$session_data['id'];
	$activeTask=$this->tasks->getActive($userId);
	
	$this->db->select('id');
	$this->db->from('tasks');
	$this->db->where('task_name', $activeTask);
	$this->db->where('UID', $userId);
	$query=$this->db->get();
	foreach ($query->result() as $row) {
	    $taskId=$row->id;
	}
	    
	/* Update stop time in database */
	$newStop=array(
	'end_time'=>date('Y-m-d H:i:s') );	
	$this->db->where('task_name', $activeTask);
	$this->db->where('UID', $userId);
	$this->db->where('id', $taskId);
	$this->db->update('tasks', $newStop);
	
	/* Mark task as inactive */
	$newStop=array(
	    'active'=>'0' );
	$this->db->where('task_name', $activeTask);
	$this->db->where('UID', $userId);
	$this->db->where('id', $taskId);
	$this->db->update('tasks', $newStop);
	$this->session->set_userdata('taskActive','');
	
	/* Calculate time spent on task and update it */
	$sql="
	UPDATE `tasks` 
	SET `time_sum` = TIME_TO_SEC( TIMEDIFF(  `end_time` ,  `start_time` ) ) +  `time_sum` 
	WHERE  `UID` =  ? AND `task_name` = ? ";
	$this->db->query($sql, array($userId, $activeTask));
	redirect('mytasks'); /* redirect to previous page */
    }
}