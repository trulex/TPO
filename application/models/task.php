<?php
Class Task extends CI_Model {
    function getTasks($userId) {
	$this -> db -> select('task_name');
	$this -> db -> from('tasks');
	$this -> db -> where('UID', $userId);
	
	$query=$this->db->get();
	
	if($query -> num_rows() < 0 ) {
	    return false;
	} else {
	    $tasks=array();
	    foreach ($query->result() as $row) {
		$tasks[]=$row->task_name;
	    }
	    return $tasks;
	}
    }
}
 
