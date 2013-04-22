<!-- Created by lovrenc -->
<!-- table "tasks": [id|task_name|StID|text|time_estimate|UID|accepted|start_time|end_time|time_sum|active|completed] -->

<?php
class Tasks extends CI_Model{
	
	function getAll(){
		$query = $this->db->query("SELECT id, task_name, text, StID, UID, time_estimate, accepted, completed FROM tasks");
		return $query->result();
	}
	
	function getTasks($userId, $sprintId){
		if($sprintId != 0) {
		    $query = $this->db->query("SELECT id, task_name, text, StID, UID, time_estimate, accepted, completed FROM tasks where UID=$userId ");
		    return $query->result();
		 } else {
		    return array();
		 }
	}
	
	function getCurrent($StID){
		$query=$this->db->query("SELECT id, task_name, text, StID, UID , time_estimate, accepted, completed FROM tasks where StID=$StID");
		return $query->result();
	}
	
	function insert($row){
		$this->db->insert('tasks',$row);
	}
	
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
    
    function getStory($taskName,$userId) { /* Returns story id of task $taskId */
	$this -> db -> select('StID');
	$this -> db -> from('tasks');
	$this -> db -> where('task_name', $taskName);
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
	$this -> db -> where('task_name', $taskName);
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	return $query->row()->completed;
    }
    
    function getTime($taskName,$userId) { /* Returns hours spent on task $taskName */
	$this -> db -> select('time_sum');
	$this -> db -> from('tasks');
	$this -> db -> where('task_name', $taskName);
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	$time=$query->row()->time_sum;
	$time/=3600; // Convert seconds to hours
	$time=round($time,2);
	return $time;
    }
    
    function getTaskName($taskId) {
	$this->db->select('task_name');
	$this->db->from('tasks');
	$this->db->where('id',$taskId);
	$query=$this->db->get();
	$name=$query->row()->task_name;
	
	return $name;
    }
    
}

?>