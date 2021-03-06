<!-- models/tasks.php -->
<!-- Created by lovrenc -->
<!-- table "tasks": [id|name|StID|text|time_estimate|UID|accepted|start_time|end_time|time_sum|active|completed] -->

<?php
class Tasks extends CI_Model{
	
// 	Get all asks
	function getAll(){
		$query = $this->db->query("SELECT id, name, text, StID, UID, time_estimate, accepted, completed FROM tasks");
		return $query->result();
	}
	
// 	Get tasks from user(if any)
	function getTasks($userId, $sprintId){
		if($sprintId != 0) {
		    $query = $this->db->query("SELECT id, name, text, StID, UID, time_estimate, accepted, completed FROM tasks where UID=$userId ");
		    return $query->result();
		 } else {
		    return array();
		 }
	}
	
// 	get all stories from current project
	function getFromProject(){
	$PID=$this->session->userdata('PID');
		$query = $this->db->query("SELECT name, text FROM tasks WHERE PID=$PID");
		return $query->result();
	}
// 	Get unasigned tasks of current story
	function getCurrentUnasigned($StID){
		$query=$this->db->query("SELECT id, name, text, StID, UID , time_estimate, accepted, completed, active FROM tasks where StID=$StID AND UID=0");
		return $query->result();
	}
// 	Get asigned tasks of curent story
	function getCurrentAsigned($StID){
		$query=$this->db->query("SELECT id, name, text, StID, UID , time_estimate, accepted, completed, active FROM tasks where StID=$StID AND UID!=0");
		return $query->result();
	}

	// 	Get tasks from current story
	function getCurrent($StID){
		$query=$this->db->query("SELECT id, name, text, StID, UID , time_estimate, accepted, completed, active FROM tasks where StID=$StID");
		if($query->num_rows>0){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	
	function getTimeSum($PID){
		$query = $this->db->query("SELECT sum(tasks.time_sum) AS timeSum FROM tasks LEFT JOIN stories ON(tasks.StID=stories.id) WHERE stories.PID=$PID");
		return $query->row()->timeSum;
	}
	
// 	Returns an array of tuples where the first element is a story and the second is an array of unassigned tasks.
	function getUnassignedTupled(){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text, tests, difficulty, note FROM stories WHERE EXISTS( SELECT * FROM tasks WHERE StID=stories.id AND UID=0 ) AND EXISTS (SELECT * FROM sprint_story WHERE StID=stories.id AND SpID=$SpID)");
		$result=array();
		$stories=$query->result();
		foreach($stories as $story){
			$StID=$story->id;
			$tasks=$this->db->query("SELECT * FROM tasks WHERE StID=$StID AND UID=0");
			array_push($result, array($story, $tasks->result()));
		}
		return $result;
	}
	
	// 	Returns an array of tuples where the first element is a story and the second is an array of assigned tasks.
	function getAssignedTupled(){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text, tests, difficulty, note FROM stories WHERE EXISTS( SELECT * FROM tasks WHERE StID=stories.id AND UID!=0 ) AND EXISTS (SELECT * FROM sprint_story WHERE StID=stories.id AND SpID=$SpID)");
		$result=array();
		$stories=$query->result();
		foreach($stories as $story){
			$StID=$story->id;
			$tasks=$this->db->query("SELECT * FROM tasks WHERE StID=$StID AND UID!=0");
			array_push($result,array($story, $tasks->result()));
		}
		return $result;
	}
	
	function getAllTupled(){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text, tests, difficulty, note FROM stories WHERE EXISTS (SELECT * FROM sprint_story WHERE StID=stories.id AND SpID=$SpID)");
		$result=array();
		$stories=$query->result();
		foreach($stories as $story){
			$StID=$story->id;
			$tasks=$this->db->query("SELECT * FROM tasks WHERE StID=$StID ");
			array_push($result,array($story, $tasks->result()));
		}
		return $result;
	}
	
	function getActiveTupled(){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text, tests, difficulty, note FROM stories WHERE EXISTS( SELECT * FROM tasks WHERE StID=stories.id AND active=1 ) AND EXISTS (SELECT * FROM sprint_story WHERE StID=stories.id AND SpID=$SpID)");
		$result=array();
		$stories=$query->result();
		foreach($stories as $story){
			$StID=$story->id;
			$tasks=$this->db->query("SELECT * FROM tasks WHERE StID=$StID AND active=1");
			array_push($result,array($story, $tasks->result()));
		}
		return $result;
	}
	
	function getFinishedTupled(){
		$SpID=$this->session->userdata('SpID');
		$query=$this->db->query("SELECT id, name, text, tests, difficulty, note FROM stories WHERE EXISTS( SELECT * FROM tasks WHERE StID=stories.id AND completed=1 ) AND EXISTS (SELECT * FROM sprint_story WHERE StID=stories.id AND SpID=$SpID)");
		$result=array();
		$stories=$query->result();
		foreach($stories as $story){
			$StID=$story->id;
			$tasks=$this->db->query("SELECT * FROM tasks WHERE StID=$StID AND completed=1");
			array_push($result,array($story, $tasks->result()));
		}
		return $result;
	}
	
	function getCurrentFinished($StID){
		$query=$this->db->query("SELECT id, name, text, StID, UID , time_estimate, accepted, completed, active FROM tasks where StID=$StID AND completed=1");
		if($query->num_rows>0){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	
	function getCurrentUnfinished($StID){
		$query=$this->db->query("SELECT id, name, text, StID, UID , time_estimate, accepted, completed, active FROM tasks where StID=$StID AND completed=0");
		if($query->num_rows>0){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	function getTaskId($workID) {
	    $query=$this->db->query("SELECT TID FROM work where id=$workID");
	    $row=$query->row();
	    return $row->TID;
	}
	function updateSum($sum, $taskID) {
	    $data=array(
		'time_sum'=>round($sum*3600,2) );
	    $this->db->where('id', $taskID);
	    $this->db->update('tasks', $data);
	}
	/* Update work history */
	function updateHistory($workID, $remaining, $spent) {
	    $data = array(
               'time_sum' => round($spent*3600,2),
               'remaining' => round($remaining*3600,2)
            );
//             $this->db->where('date', $date);
            $this->db->where('id', $workID);
	    $this->db->update('work', $data); 
	    return true;
	}
// 	Get all my tasks from current sprint
	function getMyCurrent($UID, $SpID){
		$query=$this->db->query("SELECT tasks.name, tasks.text, tasks.id, tasks.accepted FROM tasks LEFT JOIN stories ON (tasks.StID=stories.id) WHERE (SELECT SpID from sprint_story WHERE StID=stories.id)=$SpID AND tasks.UID=$UID");
		if($query->num_rows() > 0){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* Get work history for current sprint */
	function getWorkHistory($UID, $SpID){
// 		$query=$this->db->query("SELECT tasks.id,work.time_sum,work.remaining,work.date,work.TID FROM tasks LEFT JOIN stories ON (tasks.StID=stories.id) LEFT JOIN work ON (tasks.id=work.TID) WHERE (SELECT SpID from sprint_story WHERE StID=stories.id)=$SpID AND tasks.UID=$UID GROUP BY work.date DESC");
		$query=$this->db->query("SELECT id,date,TID,time_sum,remaining FROM work ORDER BY date DESC");
		if($query->num_rows() > 0){
			return $query->result();
		}
		else{
			return 0;
		}
	}
	function getTask($TID){
		$query=$this->db->query("SELECT * FROM tasks WHERE id=$TID");
		if($query->num_rows==1){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	
// 	Insert new task
	function insert($row){
		$this->db->insert('tasks',$row);
	}
	
// 	Delete task
	function deleteTask($TID){
		$this->db->query("DELETE FROM tasks WHERE id=$TID");
	}
	
//	set all the stuff:
	function editTask($TID,$name, $text, $time_estimate, $UID, $accepted, $time_sum, $completed){
		$this->db->query("UPDATE tasks SET name='$name', text='$text', time_estimate=$time_estimate, UID=$UID, accepted=$accepted, time_sum=$time_sum, completed=$completed WHERE id=$TID");
	}
// 	Set loads of stuff one by one:
//--------------------------------------------------------------------------------------
	function setUID($id,$UID){
		$this->db->query("UPDATE tasks SET UID=$UID WHERE id=$id");
	}
	
	function setTimeEstimate($TID,$TimeEstimate){
		$this->db->query("UPDATE tasks SET time_estimate=$TimeEstimate WHERE id=$TID");
	}
	
	function accept($TID){
		$this->db->query("UPDATE tasks SET accepted=1 WHERE id=$TID");
	}
	
	function decline($TID){
		$this->db->query("UPDATE tasks SET accepted=0 WHERE id=$TID");
	}
	function finish($TID){
		$this->db->query("UPDATE tasks SET completed=1 WHERE id=$TID");
	}
//---------------------------------------------------------------------------------------
	
	function getActive($userId) {
		/* Checks if there is a task that is being worked on, return id of it, or empty string if none is active. */
		$activeTask=0;
		
		$this -> db -> select('active,id');
		$this -> db -> from('tasks');
		$this -> db -> where('UID', $userId);
		$query=$this->db->get();
		foreach ($query->result() as $row) {
			if($row->active==1) {
				$activeTask=$row->id;
				return $activeTask;
			}
		}
		return $activeTask;
    }
	
	function getStoryActive($StID){
		$this->db->select('id');
		$this->db->from('tasks');
		$this->db->where('StID', $StID);
		$this->db->where('active', 1);
		$query=$this->db->get();
		
		if($query->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}
    
    function getStory($taskName,$userId) { /* Returns story id of task $taskId */
		$this -> db -> select('StID');
		$this -> db -> from('tasks');
		$this -> db -> where('name', $taskName);
		$this -> db -> where('UID', $userId);
		$query=$this->db->get();
		$storyId=$query->row()->StID; // get story id
		
		$this -> db -> select('name,text,tests');
		$this -> db -> from('stories');
		$this -> db -> where('id', $storyId);
		$query=$this->db->get();
		$storyData=array(
			'name'=>$query->row()->name,
			'text'=>$query->row()->text,
			'tests'=>$query->row()->tests
		);
		return $storyData;
    }
    
    function isCompleted($taskName,$userId) { /* Return 1 if task is completed */
	$this -> db -> select('completed');
	$this -> db -> from('tasks');
	$this -> db -> where('name', $taskName);
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	return $query->row()->completed;
    }
    
    function getTime($taskName,$userId) { /* Returns hours spent on task $taskName */
	$this -> db -> select('time_sum');
	$this -> db -> from('tasks');
	$this -> db -> where('name', $taskName);
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	$time=$query->row()->time_sum;
	$time/=3600; // Convert seconds to hours
	$time=round($time,2);
	return $time;
    }
    
    function getTaskName($taskId) {
	$this->db->select('name');
	$this->db->from('tasks');
	$this->db->where('id',$taskId);
	$query=$this->db->get();
	$name=$query->row()->name;
	
	return $name;
    }
    
}

?>