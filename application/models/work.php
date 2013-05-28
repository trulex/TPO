	
<?php
class Work extends CI_Model{

	function getAll(){
		$query=$this->db->query("SELECT * FROM work ORDER BY date");	
		return $query->result();
	}

	function getTime($PID){
		$query=$this->db->query("SELECT date,SUM(time_sum) AS timeSum FROM work WHERE PID=$PID GROUP BY date ORDER BY date");	
		return $query->result();
	}
	
	function getTimeSum($PID){
		$query = $this->db->query("SELECT SUM(work.time_sum) AS timeSum FROM work LEFT JOIN tasks ON(work.TID=tasks.id) LEFT JOIN stories ON(tasks.StID=stories.id) WHERE stories.PID=$PID");
		return $query->row()->timeSum;
	}
}
?>