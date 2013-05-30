	
<?php
class Stories_day extends CI_Model{

	function getDays($PID){
		$query=$this->db->query("SELECT date, ocene_sum FROM stories_day WHERE PID=$PID ORDER BY date");	
		return $query->result();
	}
}
?>