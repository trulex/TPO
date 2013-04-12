<!--avtor:darko-->
<?php
Class Task extends CI_Model {
    function getActive($userId) {
    /* Checks if there is a task that is being worked on, return name of it, or empty string if none is active. */
	$activeTask='';
	
	$this -> db -> select('active,task_name');
	$this -> db -> from('tasks');
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	foreach ($query->result() as $row) {
	    if($row->active==1) {
		$activeTask=$row->task_name;
		return $activeTask;
	    }
	}
	return $activeTask;
    }
    function getStory($taskName,$userId) { /* Returns story id of task with id $taskId */
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
    function getTasks($userId) { /* Returns all tasks assigned to user with id $userId */
	$this -> db -> select('task_name,accepted');
	$this -> db -> from('tasks');
	$this -> db -> where('UID', $userId);
	$query=$this->db->get();
	
	if($query -> num_rows() < 0 ) {
	    return false;
	} else {
	    $tasks=array(); //Array of tasks
	    $accepted=array(); //Array of indices for every task if accepted
	    foreach ($query->result() as $row) {
		$tasks[]=$row->task_name;
		$accepted[]=$row->accepted;
	    }
	    $combined=array_combine($tasks,$accepted); /*Key-value array of tasks and accepted indices */
	    return $combined;
	}
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
}
 
