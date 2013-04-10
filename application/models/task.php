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

    function getTasks($userId) {
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
}
 
