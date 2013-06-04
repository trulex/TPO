<!--avtor:darko-->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class MyTasks extends CI_Controller { 
    function __construct() {
	parent::__construct();
	$this->load->model('projects');
	$this->load->model('tasks');
	$this->load->helper('date');
	$this->load->model('sprints');
	$this->load->model("project_user");
    }
    
    function index() {
		if ( $this->session->userdata('PID')==0) redirect('home', 'refresh');
		if($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id']=$session_data['id'];
			$data['username'] = $session_data['username'];
			$data['name'] = $session_data['name'];
			$data['rights'] = $session_data['rights'];
			$data['active']='mytasks';
			$data['projects']=$this->projects->getProjects($data['rights']);
			$data['currentsprints']=$this->sprints->getProjectSprints($this->session->userdata('PID'));
			$data['currentsprint']=$this->sprints->getCurrentSprint($this->session->userdata('PID'));
			$data['role']=$this->project_user->getRole($this->session->userdata['UID'],$this->session->userdata('PID'));
			$data['isScrumMaster']=$this->project_user->getScrumMaster($this->session->userdata('PID'));
			$data['tasks']=$this->tasks->getMyCurrent($data['id'],$this->session->userdata('SpID')); //Get tasks data
			$data['activeTask']=$this->tasks->getActive($data['id']);
			$data['workHistory']=$this->tasks->getWorkHistory($data['id'],$this->session->userdata('SpID'));
			
			$this->load->view('header', $data);
			$this->load->view('mytasks_view', $data);
			$this->load->view('footer');
		} else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
    }
    function editWork() {
	if( ! empty( $_POST )) {
	    $history=$this->input->post('history');
	    $i=1;
	    $spent=0;
	    $remaining=0;
	    $workID=0;
	    foreach ($history as $day) {
		if($i%3==1) {
		    $spent=$day;
		    $spentA[]=$spent;
		} else if($i%3==2) {
		    $remaining=$day;
		} else {
		    $workID=$day;
//  		    echo $workID.' '.$remaining.' '.$spent.'<br />';
		    $this->tasks->updateHistory($workID, $remaining, $spent);
		}
		$i++;
	    }
	    $sum=array_sum($spentA);
	    $taskID=$this->tasks->getTaskId($workID);
	    $this->tasks->updateSum($sum, $taskID);
	}
	redirect('mytasks');
    }
    function startWork() {
		/* Check if some taks is already being worked on */
		$session_data = $this->session->userdata('logged_in');
		$userId=$session_data['id'];
		if($this->tasks->getActive($userId)!=0) {
			$this->session->set_userdata('taskActive','Stop working on current task to begin with work on another.');
			redirect('mytasks');
		} else {
			$taskId=$this->input->post('taskID');
			/* Update start time in database */
			$newStart=array(
			'start_time'=>date('Y-m-d H:i:s') );
			$this->db->where('id', $taskId);
			$this->db->update('tasks', $newStart);
			/* Mark task as active */
			$newStart=array(
			'active'=>'1' );
			$this->db->where('id', $taskId);
			$this->db->update('tasks', $newStart);
			$this->session->set_userdata('taskActive','');
			
			redirect('mytasks'); //redirect to previous page
		}
    }
    function stopWork() {
		$taskId=$this->input->post('taskID'); 
		/* Update stop time in database */
		$newStop=array(
		'end_time'=>date('Y-m-d H:i:s') );	
		$this->db->where('id', $taskId);
		$this->db->update('tasks', $newStop);
		
		/* Mark task as inactive */
		$newStop=array(
			'active'=>'0' );
		$this->db->where('id', $taskId);
		$this->db->update('tasks', $newStop);
		$this->session->set_userdata('taskActive','');
		
		/* Calculate time spent on task and update it */
		$sql="
		UPDATE `tasks` 
		SET `time_sum` = TIME_TO_SEC( TIMEDIFF(  `end_time` ,  `start_time` ) ) +  `time_sum` 
		WHERE  `id` =  ? ";
		$this->db->query($sql, array($taskId));
		
		$this->db->select('TIME_TO_SEC( TIMEDIFF(  `end_time` ,  `start_time` ) ) as seconds');
		$this->db->from('tasks');
		$this->db->where('id',$taskId);
		$query = $this->db->get();
		$row=$query->row();
		$difference=$row->seconds;
		
		$sql="SELECT time_sum, remaining,date FROM work WHERE date=? AND TID=?";
		$query=$this->db->query($sql, array(date("Y-m-d"), $taskId));
		$result=$query->result_array(); 
		if(!empty($result)) {
		   /* Add time */
		    $sql="
		    UPDATE work 
		    SET time_sum=?+time_sum 
		    WHERE TID=? AND date=? ";
		    $this->db->query($sql, array($difference, $taskId, date("Y-m-d")));
		    /* Subtract from remaining */
		    $sql="
		    UPDATE work 
		    SET remaining=remaining-? 
		    WHERE TID=? AND date=? ";
		    $this->db->query($sql, array($difference, $taskId, date("Y-m-d")));
		    $this->session->set_userdata('razlika',$difference);
		} else {//there is no entry for today
		    $sql="select date,time_sum,remaining,PID from work where TID=? order by date desc";
		    $query=$this->db->query($sql, array($taskId));
		    if ($query->num_rows() > 0) { //there was already work on task
			$row=$query->row();
			$data = array(
			'date' => date("Y-m-d"),
			'TID' => $taskId,
			'time_sum' => $difference,
			'remaining' => $row->remaining - $difference,
			'PID' => $row->PID
			);
			$this->db->insert('work', $data); 
		    } else {
			$sql="select time_estimate from tasks where id=?";
			$query=$this->db->query($sql, array($taskId));
			$row=$query->row();
			$data = array(
			'date' => date("Y-m-d"),
			'TID' => $taskId,
			'time_sum' => $difference,
			'remaining' => $row->time_estimate*3600 - $difference,
			'PID' => $this->session->userdata('PID')
			);
			$this->db->insert('work', $data); 
		    }

		}
		
		redirect('mytasks'); /* redirect to previous page */
    }
}